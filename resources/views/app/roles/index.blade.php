<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.roles.index_title')
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
                            @can('create', App\Models\Role::class)
                            <a href="{{ route('roles.create') }}" class="button button-primary">
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
                                <th class="px-4 py-3 text-left">@lang('crud.roles.inputs.name')</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse($roles as $index => $role)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-left">
                                    {{ $roles->firstItem() + $loop->index }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $role->name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-center" style="width: 134px;">
                                    <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                        @can('update', $role)
                                        <a href="{{ route('roles.edit', $role) }}" class="mr-1">
                                            <button type="button" class="button">
                                                <i class="icon ion-md-create"></i>
                                            </button>
                                        </a>
                                        @endcan 

                                        @can('view', $role)
                                        <a href="{{ route('roles.show', $role) }}" class="mr-1">
                                            <button type="button" class="button">
                                                <i class="icon ion-md-eye"></i>
                                            </button>
                                        </a>
                                        @endcan 

                                        @can('delete', $role)
                                        <button type="button" class="button delete-role" 
                                            data-id="{{ $role->id }}" data-name="{{ $role->name }}">
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
                                        {!! $roles->render() !!}
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
            document.querySelectorAll('.delete-role').forEach(button => {
                button.addEventListener('click', function () {
                    let roleId = this.getAttribute('data-id');
                    let roleName = this.getAttribute('data-name');
                    
                    Swal.fire({
                        title: "Are you sure?",
                        text: `You are about to delete the role: ${roleName}. This action cannot be undone!`,
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
                            fetch(`/roles/${roleId}`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({ _method: 'DELETE' })
                            }).then(response => {
                                if (response.ok) {
                                    Swal.fire('Deleted!', `${roleName} has been deleted.`, 'success')
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
