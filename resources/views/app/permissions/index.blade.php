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
                                <th></th>
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
                                        <button type="button" class="button delete-permission" 
                                            data-id="{{ $permission->id }}" data-name="{{ $permission->name }}">
                                            <i class="icon ion-md-trash text-red-600"></i>
                                        </button>
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
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.delete-permission').forEach(button => {
                button.addEventListener('click', function () {
                    let permissionId = this.getAttribute('data-id');
                    let permissionName = this.getAttribute('data-name');
                    
                    Swal.fire({
                        title: "Are you sure?",
                        text: `You are about to delete the permission: ${permissionName}. This action cannot be undone!`,
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Yes, delete it!",
                        customClass: {
                            confirmButton: 'swal-confirm-btn'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/permissions/${permissionId}`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({ _method: 'DELETE' })
                            }).then(response => {
                                if (response.ok) {
                                    Swal.fire('Deleted!', `${permissionName} has been deleted.`, 'success')
                                        .then(() => window.location.reload());
                                } else {
                                    Swal.fire('Error!', 'Something went wrong.', 'error');
                                }
                            });
                        }
                    });
                });
            });
        });
    </script>
</x-app-layout>
