@php
    $editing = isset($inspection);
    $lastInvoice = App\Models\Inspection::latest('id')->first(); // Ambil data invoice terakhir
    $nextInvoiceNumber = $lastInvoice ? 'INV-' . str_pad((int) substr($lastInvoice->inv_number, 4) + 1, 5, '0', STR_PAD_LEFT) : 'INV-00001'; // Generate nomor invoice berikutnya

    $currentMedicines = $editing ? $inspection->medicines : []; // Jika sedang mengedit, ambil data obat, jika tidak, set kosong
@endphp

<style>
    .obat-group-header {
        align-items: center;
        background-color: #6366f1;
        color: white;
        border-radius: 5px;
        margin-bottom: 10px;
        font-weight: bold;
    }
</style>

<div class="flex flex-wrap -mx-4">
    <div class="w-full md:w-1/2 px-4">
        <x-inputs.group class="w-full">
            <x-inputs.label-with-asterisk label="Invoice Number"/>
            <x-inputs.text
                name="inv_number"
                :value="old('inv_number', ($editing ? $inspection->inv_number : $nextInvoiceNumber))"
                maxlength="10"
                placeholder="Invoice Number"
                readonly
            ></x-inputs.text>
        </x-inputs.group>
    </div>

    <div class="w-full md:w-1/2 px-4">
        <x-inputs.group class="w-full">
            <x-inputs.label-with-asterisk label="Nama Pasien"/>
            <x-inputs.text
                name="nama_pasien"
                :value="old('nama_pasien', ($editing ? $inspection->nama_pasien : ''))"
                maxlength="255"
                placeholder="Nama Pasien"
                required
            ></x-inputs.text>
        </x-inputs.group>
    </div>

    <div class="w-full md:w-1/2 px-4">
        <x-inputs.group class="w-full">
            <x-inputs.label-with-asterisk label="Tanggal Pemeriksaan"/>
            <x-inputs.basic
                type="date"
                name="tanggal_pemeriksaan"
                :value="old('tanggal_pemeriksaan', ($editing ? $inspection->tanggal_pemeriksaan : ''))"
                required
            ></x-inputs.text>
        </x-inputs.group>
    </div>

    <div class="w-full md:w-1/2 px-4">
        <x-inputs.group class="w-full">
            <x-inputs.label-with-asterisk label="Tinggi Badan (cm)"/>
            <x-inputs.number
                name="tinggi_badan"
                :value="old('tinggi_badan', ($editing ? $inspection->tinggi_badan : ''))"
                step="0.01"
                placeholder="Tinggi Badan"
                required
            ></x-inputs.number>
        </x-inputs.group>
    </div>

    <div class="w-full md:w-1/2 px-4">
        <x-inputs.group class="w-full">
            <x-inputs.label-with-asterisk label="Berat Badan (kg)"/>
            <x-inputs.number
                name="berat_badan"
                :value="old('berat_badan', ($editing ? $inspection->berat_badan : ''))"
                step="0.01"
                placeholder="Berat Badan"
                required
            ></x-inputs.number>
        </x-inputs.group>
    </div>

    <div class="w-full md:w-1/2 px-4">
        <x-inputs.group class="w-full">
            <x-inputs.label-with-asterisk label="Tekanan Systolic"/>
            <x-inputs.text
                name="systole"
                :value="old('systole', ($editing ? $inspection->systole : ''))"
                maxlength="10"
                placeholder="Tekanan Systolic"
                required
            ></x-inputs.text>
        </x-inputs.group>
    </div>

    <div class="w-full md:w-1/2 px-4">
        <x-inputs.group class="w-full">
            <x-inputs.label-with-asterisk label="Tekanan Diastolic"/>
            <x-inputs.text
                name="diastole"
                :value="old('diastole', ($editing ? $inspection->diastole : ''))"
                maxlength="10"
                placeholder="Tekanan Diastolic"
                required
            ></x-inputs.text>
        </x-inputs.group>
    </div>

    <div class="w-full md:w-1/2 px-4">
        <x-inputs.group class="w-full">
            <x-inputs.label-with-asterisk label="Heart Rate (BPM)"/>
            <x-inputs.text
                name="heart_rate"
                :value="old('heart_rate', ($editing ? $inspection->heart_rate : ''))"
                maxlength="10"
                placeholder="Heart Rate"
                required
            ></x-inputs.text>
        </x-inputs.group>
    </div>

    <div class="w-full md:w-1/2 px-4">
        <x-inputs.group class="w-full">
            <x-inputs.label-with-asterisk label="Respiration Rate"/>
            <x-inputs.text
                name="respiration_rate"
                :value="old('respiration_rate', ($editing ? $inspection->respiration_rate : ''))"
                maxlength="10"
                placeholder="Respiration Rate"
                required
            ></x-inputs.text>
        </x-inputs.group>
    </div>

    <div class="w-full md:w-1/2 px-4">
        <x-inputs.group class="w-full">
            <x-inputs.label-with-asterisk label="Suhu Tubuh (°C)"/>
            <x-inputs.number
                name="suhu_tubuh"
                :value="old('suhu_tubuh', ($editing ? $inspection->suhu_tubuh : ''))"
                step="0.01"
                placeholder="Suhu Tubuh"
                required
            ></x-inputs.number>
        </x-inputs.group>
    </div>

    <div class="w-full px-4">
        <x-inputs.group class="w-full">
            <x-inputs.label-with-asterisk label="Hasil Pemeriksaan"/>
            <x-inputs.textarea
                name="hasil_pemeriksaan"
                placeholder="Hasil Pemeriksaan"
                required
            >{{ old('hasil_pemeriksaan', ($editing ? $inspection->hasil_pemeriksaan : ''))}}</x-inputs.textarea>
        </x-inputs.group>
    </div>

    <div class="w-full px-4" style="margin-bottom: 50px;">
        <x-inputs.group class="w-full">
            <x-inputs.label-without-asterisk label="Upload File"/>
    
            <!-- Display current file if it exists -->
            @if($editing && $inspection->file_url)
                <div class="mb-2">
                    <strong>Current file:</strong>
                    <a href="{{ Storage::url($inspection->file_url) }}" target="_blank" class="text-blue-600">
                        View File
                    </a>
                </div>
            @endif
    
            <!-- File input for upload -->
            <input 
                type="file" 
                name="file_url"  
                accept="application/pdf, image/*" 
                class="form-input w-full"
            >
        </x-inputs.group>
    </div>
    
    <input type="hidden" name="status" value="Draft">

    <div class="w-full px-4">
        <!-- Header Row -->
        <div class="obat-group-header" style="display: flex; flex-wrap: wrap; padding: 10px 0;">
            <div style="width: 50px; padding: 5px 10px !important;">
                <span>#</span>
            </div>
            <div style="width: 790px; padding: 0 10px !important;">
                <span>Pilih Obat</span>
            </div>
            <div style="width: 250px; padding: 0 10px !important;">
                <span>Jumlah Obat</span>
            </div>
            <div style="width: 219px; padding: 0 10px !important;">
                <span></span>
            </div>
        </div>

        <div id="obat-container">
            @if($currentMedicines && count($currentMedicines) > 0) <!-- Menyaring hanya jika $currentMedicines ada dan lebih dari 0 -->
                @foreach($currentMedicines as $index => $medicine)
                    <div class="obat-group" style="display: flex; flex-wrap: wrap;">
                        <x-inputs.group style="width: 50px; padding: 5px 10px !important;">
                            <div>
                                <span class="obat-number">{{ $index + 1 }}</span>
                            </div>
                        </x-inputs.group>
        
                        <x-inputs.group style="width: 790px; padding: 0 10px !important;">
                            <x-inputs.select name="id[]" required>
                                <option disabled selected value="">Pilih Obat</option>
                                @foreach($medicines as $medicineOption)
                                    <option value="{{ $medicineOption['id'] }}"
                                        @if($medicine->id_obat == $medicineOption['id']) selected @endif>
                                        {{ $medicineOption['name'] }}
                                    </option>
                                @endforeach
                            </x-inputs.select>
                        </x-inputs.group>
        
                        <x-inputs.group style="width: 250px; padding: 0 10px !important;">
                            <x-inputs.number name="jumlah[]" min="1" required placeholder="Jumlah Obat"
                                value="{{ old('jumlah', $medicine->jumlah) }}"/>
                        </x-inputs.group>
        
                        <x-inputs.group>
                            <button type="button" class="delete-obat" style="padding: 7px 15px; background-color:rgb(221, 221, 221); border-radius: 5px;">
                                <i class="icon ion-md-trash text-red-600"></i>
                            </button>
                        </x-inputs.group>
                    </div>
                @endforeach
            @else
                <!-- Jika tidak ada obat yang sebelumnya dipilih, tampilkan form kosong -->
                <div class="obat-group" style="display: flex; flex-wrap: wrap;">
                    <x-inputs.group style="width: 50px; padding: 5px 10px !important;">
                        <div>
                            <span class="obat-number">1</span>
                        </div>
                    </x-inputs.group>
        
                    <x-inputs.group style="width: 790px; padding: 0 10px !important;">
                        <x-inputs.select name="id[]" required>
                            <option disabled selected>Pilih Obat</option>
                            @foreach($medicines as $medicine)
                                <option value="{{ $medicine['id'] }}">{{ $medicine['name'] }}</option>
                            @endforeach
                        </x-inputs.select>
                    </x-inputs.group>
        
                    <x-inputs.group style="width: 250px; padding: 0 10px !important;">
                        <x-inputs.number name="jumlah[]" min="1" required placeholder="Jumlah Obat" />
                    </x-inputs.group>
        
                    <x-inputs.group>
                        <button type="button" class="delete-obat" style="padding: 7px 15px; background-color:rgb(221, 221, 221); border-radius: 5px;">
                            <i class="icon ion-md-trash text-red-600"></i>
                        </button>
                    </x-inputs.group>
                </div>
            @endif
        </div>
        

        <div style="width: 100%; padding: 10px; margin-top: 20px; display: flex; align-items: center; justify-content: space-between;">
            <button
                type="button"
                class="tambah-obat-button"
                style="padding: 10px; color: white; background-color: #6366f1; border-radius: 5px;"
            >
                + Tambah Obat
            </button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tambahObatButton = document.querySelector('.tambah-obat-button');
        const obatContainer = document.getElementById('obat-container');

        // Menangani penambahan obat
        tambahObatButton.addEventListener('click', function() {
            const index = obatContainer.children.length + 1; // Menentukan nomor urut obat
            const obatGroup = document.createElement('div');
            obatGroup.classList.add('obat-group');
            obatGroup.style.display = 'flex';
            obatGroup.style.flexWrap = 'wrap';

            // Membuat grup input untuk obat
            obatGroup.innerHTML = `
                <x-inputs.group style="width: 50px; padding: 5px 10px !important;">
                    <div>
                        <span class="obat-number">${index}</span>
                    </div>
                </x-inputs.group>

                <x-inputs.group style="width: 790px; padding: 0 10px !important;">
                    <x-inputs.select name="id[]" required>
                        <option disabled selected>Pilih Obat</option>
                        @foreach($medicines as $medicine)
                            <option value="{{ $medicine['id'] }}">{{ $medicine['name'] }}</option>
                        @endforeach
                    </x-inputs.select>
                </x-inputs.group>

                <x-inputs.group style="width: 250px; padding: 0 10px !important;">
                    <x-inputs.basic 
                        type="number" 
                        name="jumlah[]" 
                        :min="1" 
                        placeholder="Jumlah Obat"
                    ></x-inputs.basic>
                </x-inputs.group>

                <x-inputs.group>
                    <button type="button" class="delete-obat" style="padding: 7px 15px; background-color:rgb(221, 221, 221); border-radius: 5px;">
                        <i class="icon ion-md-trash text-red-600"></i>
                    </button>
                </x-inputs.group>
            `;

            // Menambahkan grup obat ke container
            obatContainer.appendChild(obatGroup);

            // Menambahkan event listener untuk menghapus obat
            const deleteButton = obatGroup.querySelector('.delete-obat');
            deleteButton.addEventListener('click', function() {
                if (obatContainer.children.length > 1) {
                    obatContainer.removeChild(obatGroup);
                    updateObatNumbers(); // Update nomor urut obat setelah penghapusan
                }
            });

            updateObatNumbers(); // Update nomor urut obat setelah penambahan
        });

        // Fungsi untuk memperbarui nomor urut obat
        function updateObatNumbers() {
            const obatGroups = obatContainer.querySelectorAll('.obat-group');
            obatGroups.forEach((group, index) => {
                const obatNumber = group.querySelector('.obat-number');
                if (obatNumber) {
                    obatNumber.textContent = index + 1; // Update nomor urut
                }
            });
        }

        // Inisialisasi tombol hapus untuk item yang ada saat halaman dimuat
        const deleteButtons = document.querySelectorAll('.delete-obat');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                if (obatContainer.children.length > 1) {
                    const obatGroup = button.closest('.obat-group');
                    if (obatGroup) {
                        obatContainer.removeChild(obatGroup);
                        updateObatNumbers(); // Update nomor urut obat setelah penghapusan
                    }
                }
            });
        });
    });
</script>
