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


class InspectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Inspection::class);

        $search = $request->get('search', '');

        $inspections = Inspection::query()
            ->when($search, function ($query, $search) {
                return $query->where('nama_pasien', 'like', "%{$search}%");
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

        return view('app.inspections.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InspectionStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Inspection::class);

        $validated = $request->validated();

        // Handle file upload only if the file exists
        $filePath = null;
        if ($request->hasFile('file_url')) {
            // Store the file and get its path
            $filePath = $request->file('file_url')->store('uploads/inspections', 'public');
        }

        // Add the file_path to the validated data
        $validated['file_url'] = $filePath;

        $inspection = Inspection::create($validated);

        return redirect()
            ->route('inspections.index')
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Inspection $inspection): View
    {
        $this->authorize('view', $inspection);

        return view('app.inspections.show', compact('inspection'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Inspection $inspection): View
    {
        $this->authorize('update', $inspection);

        return view('app.inspections.edit', compact('inspection'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InspectionUpdateRequest $request, Inspection $inspection): RedirectResponse
{
    $this->authorize('update', $inspection);

    // Get validated data from the form request
    $validated = $request->validated();

    // Check if a new file is uploaded
    if ($request->hasFile('file_url')) {
        // Delete the old file if it exists
        if ($inspection->file_url && Storage::exists($inspection->file_url)) {
            Storage::delete($inspection->file_url);
        }

        // Store the new file and get its path
        $filePath = $request->file('file_url')->store('uploads/inspections', 'public');
        
        // Update the validated data with the new file path
        $validated['file_url'] = $filePath;
    }

    // Update the inspection record with the validated data, including the file_url if uploaded
    $inspection->update($validated);

    return redirect()
        ->route('inspections.edit', $inspection)
        ->withSuccess(__('crud.common.saved'));
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
