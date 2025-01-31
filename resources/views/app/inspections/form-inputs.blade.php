@php $editing = isset($inspection) @endphp

<div class="flex flex-wrap -mx-4">
    <div class="w-full md:w-full px-4">
        <x-inputs.group class="w-full">
            <x-inputs.text
                name="nama_pasien"
                label="Nama Pasien"
                :value="old('nama_pasien', ($editing ? $inspection->nama_pasien : ''))"
                maxlength="255"
                placeholder="Nama Pasien"
                required
            ></x-inputs.text>
        </x-inputs.group>
    </div>

    <div class="w-full md:w-1/2 px-4">
        <x-inputs.group class="w-full">
            <x-inputs.basic
                type="date"
                name="tanggal_pemeriksaan"
                label="Tanggal Pemeriksaan"
                :value="old('tanggal_pemeriksaan', ($editing ? $inspection->tanggal_pemeriksaan : ''))"
                required
            ></x-inputs.text>
        </x-inputs.group>
    </div>

    <div class="w-full md:w-1/2 px-4">
        <x-inputs.group class="w-full">
            <x-inputs.number
                name="tinggi_badan"
                label="Tinggi Badan (cm)"
                :value="old('tinggi_badan', ($editing ? $inspection->tinggi_badan : ''))"
                step="0.01"
                placeholder="Tinggi Badan"
                required
            ></x-inputs.number>
        </x-inputs.group>
    </div>

    <div class="w-full md:w-1/2 px-4">
        <x-inputs.group class="w-full">
            <x-inputs.number
                name="berat_badan"
                label="Berat Badan (kg)"
                :value="old('berat_badan', ($editing ? $inspection->berat_badan : ''))"
                step="0.01"
                placeholder="Berat Badan"
                required
            ></x-inputs.number>
        </x-inputs.group>
    </div>

    <div class="w-full md:w-1/2 px-4">
        <x-inputs.group class="w-full">
            <x-inputs.text
                name="systole"
                label="Tekanan Systolic"
                :value="old('systole', ($editing ? $inspection->systole : ''))"
                maxlength="10"
                placeholder="Tekanan Systolic"
                required
            ></x-inputs.text>
        </x-inputs.group>
    </div>

    <div class="w-full md:w-1/2 px-4">
        <x-inputs.group class="w-full">
            <x-inputs.text
                name="diastole"
                label="Tekanan Diastolic"
                :value="old('diastole', ($editing ? $inspection->diastole : ''))"
                maxlength="10"
                placeholder="Tekanan Diastolic"
                required
            ></x-inputs.text>
        </x-inputs.group>
    </div>

    <div class="w-full md:w-1/2 px-4">
        <x-inputs.group class="w-full">
            <x-inputs.text
                name="heart_rate"
                label="Heart Rate (BPM)"
                :value="old('heart_rate', ($editing ? $inspection->heart_rate : ''))"
                maxlength="10"
                placeholder="Heart Rate"
                required
            ></x-inputs.text>
        </x-inputs.group>
    </div>

    <div class="w-full md:w-1/2 px-4">
        <x-inputs.group class="w-full">
            <x-inputs.text
                name="respiration_rate"
                label="Respiration Rate"
                :value="old('respiration_rate', ($editing ? $inspection->respiration_rate : ''))"
                maxlength="10"
                placeholder="Respiration Rate"
                required
            ></x-inputs.text>
        </x-inputs.group>
    </div>

    <div class="w-full md:w-1/2 px-4">
        <x-inputs.group class="w-full">
            <x-inputs.number
                name="suhu_tubuh"
                label="Suhu Tubuh (°C)"
                :value="old('suhu_tubuh', ($editing ? $inspection->suhu_tubuh : ''))"
                step="0.01"
                placeholder="Suhu Tubuh"
                required
            ></x-inputs.number>
        </x-inputs.group>
    </div>

    <div class="w-full px-4">
        <x-inputs.group class="w-full">
            <x-inputs.textarea
                name="hasil_pemeriksaan"
                label="Hasil Pemeriksaan"
                placeholder="Hasil Pemeriksaan"
                required
            >{{ old('hasil_pemeriksaan', ($editing ? $inspection->hasil_pemeriksaan : ''))}}</x-inputs.textarea>
        </x-inputs.group>
    </div>

    <input type="hidden" name="status" value="Draft">

</div>
