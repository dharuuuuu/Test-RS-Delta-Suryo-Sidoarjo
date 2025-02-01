<?php

namespace App\Http\Controllers;

use App\Models\Inspection;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\InspectionStoreRequest;
use App\Http\Requests\InspectionUpdateRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\MedicalPrescription;

class InspectionController extends Controller
{
    // Fungsi untuk mendapatkan token API
    private function getApiToken()
    {
        // Cek apakah token sudah ada di cache
        $token = Cache::get('api_token');
        if (!$token) {
            // Lakukan request POST ke API untuk mendapatkan token
            $response = Http::post('http://recruitment.rsdeltasurya.com/api/v1/auth', [
                'email' => 'dimasddr7@gmail.com', // Email Anda
                'password' => '085782003596',    // Nomor HP Anda
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $token = $data['access_token'];

                // Simpan token ke cache selama 1 hari
                Cache::put('api_token', $token, 86400);
            } else {
                // Jika gagal mendapatkan token, Anda bisa menambahkan penanganan error
                return null;
            }
        }
        return $token;
    }

    // Fungsi untuk mengambil daftar obat
    private function getMedicines()
    {
        $token = $this->getApiToken();

        if (!$token) {
            return [];
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://recruitment.rsdeltasurya.com/api/v1/medicines');

        if ($response->successful()) {
            return $response->json()['medicines'];
        }

        return [];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Inspection::class);

        $search = $request->get('search', '');

        $inspections = Inspection::query()
            ->when($search, function ($query, $search) {
                return $query->where('inv_number', 'like', "%{$search}%");
            })
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('app.inspections.index', compact('inspections', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Inspection::class);

        $medicines = $this->getMedicines();

        return view('app.inspections.create', compact('medicines'));
    }

    // Fungsi untuk mendapatkan detail obat berdasarkan ID
    private function getMedicinesByIds($obatIds)
    {
        $token = $this->getApiToken();

        if (!$token) {
            return [];
        }

        // Ambil semua obat dengan sekali request, menggunakan query parameter untuk ID
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://recruitment.rsdeltasurya.com/api/v1/medicines', [
            'ids' => implode(',', $obatIds), // Mengirim ID obat sekaligus
        ]);

        if ($response->successful()) {
            return collect($response->json()['medicines'])->keyBy('id');  // Kembalikan hasil dalam bentuk key-value berdasarkan ID
        }

        return [];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InspectionStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();
    
        // Handle file upload
        $filePath = null;
        if ($request->hasFile('file_url')) {
            $filePath = $request->file('file_url')->store('uploads/inspections', 'public');
        }
    
        $validated['file_url'] = $filePath;
    
        // Simpan pemeriksaan
        $inspection = Inspection::create($validated);
    
        // Ambil data obat yang dipilih
        $obatIds = $request->input('id', []);
        $jumlahObat = $request->input('jumlah', []);
    
        // Ambil semua data obat sekaligus
        $medicines = $this->getMedicinesByIds($obatIds);
    
        if ($obatIds) {
            foreach ($obatIds as $index => $obatId) {
                // Ambil nama obat dari data yang sudah ada
                $medicine = $medicines[$obatId] ?? null;
                $namaObat = $medicine ? $medicine['name'] : null;
    
                // Simpan resep obat
                MedicalPrescription::create([
                    'id_inspection' => $inspection->id,
                    'id_obat' => $obatId,
                    'jumlah' => $jumlahObat[$index],
                    'nama_obat' => $namaObat,
                ]);
            }
        }
    
        return redirect()
            ->route('inspections.index')
            ->withSuccess(__('crud.common.created'));
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Inspection $inspection): View
    {
        // Memastikan pemeriksaan memiliki relasi dengan data obat (medicines) yang sudah menyimpan nama obat
        $inspection->load('medicines');

        // Mengizinkan hanya pemeriksaan yang memiliki izin untuk dilihat
        $this->authorize('view', $inspection);

        return view('app.inspections.show', compact('inspection'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Inspection $inspection): View
    {
        $this->authorize('update', $inspection);

        $medicines = $this->getMedicines();

        // Ambil resep obat yang sudah ada terkait pemeriksaan ini
        $currentMedicines = MedicalPrescription::where('id_inspection', $inspection->id)->get();

        // Siapkan array untuk ID obat yang sudah dipilih
        $currentMedicinesIds = $currentMedicines->pluck('id_obat')->toArray();

        // Kirim data ke view
        return view('app.inspections.edit', compact('inspection', 'medicines', 'currentMedicinesIds', 'currentMedicines'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(InspectionUpdateRequest $request, Inspection $inspection): RedirectResponse
    {
        $this->authorize('update', $inspection);

        // Validasi data dari form request
        $validated = $request->validated();

        // Cek apakah ada file baru yang diupload
        if ($request->hasFile('file_url')) {
            // Hapus file lama jika ada
            if ($inspection->file_url && Storage::exists($inspection->file_url)) {
                Storage::delete($inspection->file_url);
            }

            // Simpan file baru dan dapatkan path-nya
            $filePath = $request->file('file_url')->store('uploads/inspections', 'public');
            $validated['file_url'] = $filePath; // Menyimpan path file yang baru
        }

        // Update pemeriksaan dengan data validasi
        $inspection->update($validated);

        // Mengambil data ID obat dan jumlah yang dipilih dari form
        $obatIds = $request->input('id', []); // Daftar ID obat yang dipilih
        $jumlahObat = $request->input('jumlah', []); // Jumlah obat yang dipilih

        // Hapus resep obat lama terkait pemeriksaan ini
        MedicalPrescription::where('id_inspection', $inspection->id)->delete();

        // Ambil data obat berdasarkan ID yang dipilih
        $medicines = $this->getMedicinesByIds($obatIds);

        if ($obatIds) {
            foreach ($obatIds as $index => $obatId) {
                // Ambil nama obat dari data yang sudah ada
                $medicine = $medicines[$obatId] ?? null;
                $namaObat = $medicine ? $medicine['name'] : null;

                // Menyimpan resep obat baru
                MedicalPrescription::create([
                    'id_inspection' => $inspection->id,
                    'id_obat' => $obatId,
                    'jumlah' => $jumlahObat[$index],
                    'nama_obat' => $namaObat,
                ]);
            }
        }

        return redirect()
            ->route('inspections.edit', $inspection)
            ->withSuccess(__('crud.common.saved'));  // Memberikan notifikasi bahwa data berhasil disimpan
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inspection $inspection): RedirectResponse
    {
        $this->authorize('delete', $inspection);

        $inspection->delete();

        return redirect()
            ->route('inspections.index')
            ->withSuccess(__('crud.common.removed'));
    }
}