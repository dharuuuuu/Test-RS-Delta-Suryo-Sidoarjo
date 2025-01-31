<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.permissions.index_title')
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
                                        placeholder="Search Nama.."
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
                            @can('create', App\Models\Permission::class)
                            <a href="{{ route('permissions.create') }}" class="button button-primary">
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
                                <th class="px-4 py-3 text-left">@lang('crud.permissions.inputs.name')</th>
                                <th class="px-4 py-3 text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse($permissions as $index => $permission)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-left">
                                    {{ $permissions->firstItem() + $loop->index }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $permission->name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-center" style="width: 134px;">
                                    <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                        @can('update', $permission)
                                        <a href="{{ route('permissions.edit', $permission) }}" class="mr-1">
                                            <button type="button" class="button">
                                                <i class="icon ion-md-create"></i>
                                            </button>
                                        </a>
                                        @endcan 

                                        @can('view', $permission)
                                        <a href="{{ route('permissions.show', $permission) }}" class="mr-1">
                                            <button type="button" class="button">
                                                <i class="icon ion-md-eye"></i>
                                            </button>
                                        </a>
                                        @endcan 

                                        @can('delete', $permission)
                                            <form id="deleteForm" action="{{ route('permissions.destroy', $permission->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div role="group" aria-label="Row Actions" class=" relative inline-flex align-middle">
                                                    <button type="button" class="button" onclick="confirmDelete('{{ $permission->id }}')">
                                                        <i class="icon ion-md-trash text-red-500"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-4">
                                    @lang('crud.common.no_items_found')
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3">
                                    <div class="mt-10 px-4">
                                        {!! $permissions->render() !!}
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
        function confirmDelete(permissionId) {
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: 'Konfirmasi hapus permission',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yakin',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika konfirmasi, submit formulir secara manual
                    document.getElementById('deleteForm').action = '{{ route('permissions.destroy', '') }}/' + permissionId;
                    document.getElementById('deleteForm').submit();
                }
            });
        }
    </script>
</x-app-layout>
