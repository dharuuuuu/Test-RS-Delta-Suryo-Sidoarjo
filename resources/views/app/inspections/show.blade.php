<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lihat Pemeriksaan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('inspections.index') }}" class="mr-4">
                        <i class="mr-1 icon ion-md-arrow-back"></i>
                    </a>
                </x-slot>

                <div class="mt-4 px-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Kolom Kiri --}}
                        <div>
                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Nama Pasien
                                </h5>
                                <span>{{ $inspection->nama_pasien ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Tanggal Pemeriksaan
                                </h5>
                                <span>{{ $inspection->tanggal_pemeriksaan ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Tinggi Badan (cm)
                                </h5>
                                <span>{{ $inspection->tinggi_badan ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Berat Badan (kg)
                                </h5>
                                <span>{{ $inspection->berat_badan ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Tekanan Systolic
                                </h5>
                                <span>{{ $inspection->systole ?? '-' }}</span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-1">
                                <div class="mb-4">
                                    <h5 class="font-medium text-gray-700">
                                        Hasil Pemeriksaan
                                    </h5>
                                    <span>{{ $inspection->hasil_pemeriksaan ?? '-' }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Kolom Kanan --}}
                        <div>
                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Tekanan Diastolic
                                </h5>
                                <span>{{ $inspection->diastole ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Heart Rate (BPM)
                                </h5>
                                <span>{{ $inspection->heart_rate ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Respiration Rate
                                </h5>
                                <span>{{ $inspection->respiration_rate ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Suhu Tubuh (°C)
                                </h5>
                                <span>{{ $inspection->suhu_tubuh ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    Status
                                </h5>
                                @if ($inspection->status == 'Draft')
                                    <div
                                        style="min-width: 80px;"
                                        class="
                                            inline-block
                                            py-1
                                            text-center text-sm
                                            rounded
                                            bg-gray-500
                                            text-white
                                        "
                                    >
                                        <span>{{ $inspection->status ?? '-' }}</span>
                                    </div>
                                @elseif ($inspection->status == 'Terbayar')
                                    <div
                                        style="min-width: 80px;"
                                        class=" 
                                            inline-block
                                            py-1
                                            text-center text-sm
                                            rounded
                                            bg-green-600
                                            text-white
                                        "
                                    >
                                        <span>{{ $inspection->status ?? '-' }}</span>
                                    </div>
                                @endif
                            </div>

                            {{-- File Section: Show download button if file exists --}}
                            @if ($inspection->file_url)
                                <div class="mb-4">
                                    <h5 class="font-medium text-gray-700">
                                        File Pemeriksaan
                                    </h5>
                                    <a 
                                        href="{{ Storage::url($inspection->file_url) }}" 
                                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-600 hover:bg-blue-700 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                        download
                                    >
                                        <i class="mr-2 icon ion-md-download"></i> Download File
                                    </a>
                                </div>
                            @else
                                <div class="mb-4">
                                    <h5 class="font-medium text-gray-700">
                                        Tidak ada file yang diunggah
                                    </h5>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Tombol Navigasi --}}
                <div class="mt-10 flex justify-between">
                    <a href="{{ route('inspections.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\Inspection::class)
                    <a href="{{ route('inspections.create') }}" class="button">
                        <i class="mr-1 icon ion-md-add"></i>
                        @lang('crud.common.create')
                    </a>
                    @endcan
                </div>
            </x-partials.card>
        </div>
    </div>
</x-app-layout>
