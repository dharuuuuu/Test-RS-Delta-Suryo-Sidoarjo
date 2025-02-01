<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            List Pemeriksaan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <div class="mb-5 mt-4">
                    <div class="flex flex-wrap justify-between">
                        <div class="md:w-1/2">
                            <form>
                                <div class="flex items-center w-full">
                                    <x-inputs.text
                                        name="search"
                                        value="{{ $search ?? '' }}"
                                        placeholder="Search invoice number.."
                                        autocomplete="off"
                                    ></x-inputs.text>

                                    <div class="ml-1">
                                        <button type="submit" class="button button-primary">
                                            <i class="icon ion-md-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="md:w-1/2 text-right">
                            @can('create', App\Models\Inspection::class)
                            <a href="{{ route('inspections.create') }}" class="button button-primary">
                                <i class="mr-1 icon ion-md-add"></i>
                                @lang('crud.common.create')
                            </a>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="block w-full overflow-auto scrolling-touch">
                    <table class="w-full max-w-full mb-4 bg-transparent">
                        <thead class="text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left">No</th>
                                <th class="px-4 py-3 text-left">Invoice Number</th>
                                <th class="px-4 py-3 text-left">Nama Pasien</th>
                                <th class="px-4 py-3 text-left">Tanggal Pemeriksaan</th>
                                <th class="px-4 py-3 text-left">Hasil Pemeriksaan</th>
                                <th class="px-4 py-3 text-left">Status</th>
                                <th class="px-4 py-3 text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse($inspections as $index => $inspection)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-left">
                                    {{ $inspections->firstItem() + $loop->index }}
                                </td>
                                <td class="px-4 py-3 text-left">{{ $inspection->inv_number ?? '-' }}</td>
                                <td class="px-4 py-3 text-left">{{ $inspection->nama_pasien ?? '-' }}</td>
                                <td class="px-4 py-3 text-left">{{ $inspection->tanggal_pemeriksaan ?? '-' }}</td>
                                <td class="px-4 py-3 text-left">{{ $inspection->hasil_pemeriksaan ?? '-' }}</td>
                                <td class="px-4 py-3 text-left" style="max-width: 400px">
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
                                            {{ $inspection->status ?? '-' }}
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
                                            {{ $inspection->status ?? '-' }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                        @if ($inspection->status != 'Terbayar')
                                            @can('update', $inspection)
                                            <a href="{{ route('inspections.edit', $inspection) }}" class="mr-1">
                                                <button type="button" class="button">
                                                    <i class="icon ion-md-create"></i>
                                                </button>
                                            </a>
                                            @endcan 
                                        @endif
                                        
                                        @can('view', $inspection)
                                        <a href="{{ route('inspections.show', $inspection) }}" class="mr-1">
                                            <button type="button" class="button">
                                                <i class="icon ion-md-eye"></i>
                                            </button>
                                        </a>
                                        @endcan 

                                        @if ($inspection->status != 'Terbayar')
                                            @can('delete', $inspection)
                                                <form id="deleteForm" action="{{ route('inspections.destroy', $inspection->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div role="group" aria-label="Row Actions" class=" relative inline-flex align-middle">
                                                        <button type="button" class="button" onclick="confirmDelete('{{ $inspection->id }}')">
                                                            <i class="icon ion-md-trash text-red-500"></i>
                                                        </button>
                                                    </div>
                                                </form>
                                            @endcan
                                        @endif

                                        @if ($inspection->status != 'Terbayar')
                                            @can('payment', $inspection)
                                            <a href="{{ route('inspections.payment', $inspection) }}" class="mr-1">
                                                <button type="button" class="button" style="margin: 0 4px;">
                                                    <i class="ion ion-ios-cash" style="padding: 2px 0;"></i>
                                                </button>
                                            </a>
                                            @endcan 
                                        @endif

                                        @if ($inspection->status == 'Terbayar')
                                            @can('payment', $inspection)
                                            <a href="{{ route('invoices.export_pdf', $inspection->id) }}" class="mr-1">
                                                <button type="button" class="button" style="margin: 0 4px;">
                                                    <i class="ion ion-md-cloud-download" style="padding: 2px 0;"></i>
                                                </button>
                                            </a>
                                            @endcan 
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    @lang('crud.common.no_items_found')
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7">
                                    <div class="mt-10 px-4">
                                        {!! $inspections->render() !!}
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </x-partials.card>
        </div>
    </div>

    <!-- Tambahkan SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(inspectionId) {
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: 'Konfirmasi hapus pemeriksaan',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yakin',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika konfirmasi, submit formulir secara manual
                    document.getElementById('deleteForm').action = '{{ route('inspections.destroy', '') }}/' + inspectionId;
                    document.getElementById('deleteForm').submit();
                }
            });
        }
    </script>
</x-app-layout>