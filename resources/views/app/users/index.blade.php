<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.users.index_title')
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
                                        placeholder="Seach Nama.."
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
                            @can('create', App\Models\User::class)
                            <a href="{{ route('users.create') }}" class="button button-primary">
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
                                <th class="px-4 py-3 text-left">@lang('crud.users.inputs.name')</th>
                                <th class="px-4 py-3 text-left">@lang('crud.users.inputs.email')</th>
                                <th class="px-4 py-3 text-left">@lang('crud.users.inputs.gender')</th>
                                <th class="px-4 py-3 text-left">@lang('crud.users.inputs.date_of_birth')</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse($users as $index => $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-left">
                                    {{ $users->firstItem() + $loop->index }}
                                </td>
                                <td class="px-4 py-3 text-left">{{ $user->name ?? '-' }}</td>
                                <td class="px-4 py-3 text-left">{{ $user->email ?? '-' }}</td>
                                <td class="px-4 py-3 text-left">{{ $user->gender ?? '-' }}</td>
                                <td class="px-4 py-3 text-left">{{ $user->date_of_birth ?? '-' }}</td>
                                <td class="px-4 py-3 text-center" style="width: 134px;">
                                    <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                        @can('update', $user)
                                        <a href="{{ route('users.edit', $user) }}" class="mr-1">
                                            <button type="button" class="button">
                                                <i class="icon ion-md-create"></i>
                                            </button>
                                        </a>
                                        @endcan 
                                        
                                        @can('view', $user)
                                        <a href="{{ route('users.show', $user) }}" class="mr-1">
                                            <button type="button" class="button">
                                                <i class="icon ion-md-eye"></i>
                                            </button>
                                        </a>
                                        @endcan 

                                        @can('delete', $user)
                                        <button 
                                            type="button" 
                                            class="button delete-user" 
                                            data-id="{{ $user->id }}"
                                            data-name="{{ $user->name }}"
                                        >
                                            <i class="icon ion-md-trash text-red-600"></i>
                                        </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    @lang('crud.common.no_items_found')
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6">
                                    <div class="mt-10 px-4">
                                        {!! $users->render() !!}
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
            document.querySelectorAll('.delete-user').forEach(button => {
                button.addEventListener('click', function () {
                    let userId = this.getAttribute('data-id');
                    let userName = this.getAttribute('data-name');
                    
                    Swal.fire({
                        title: `Are you sure?`,
                        text: `You are about to delete ${userName}. This action cannot be undone!`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/users/${userId}`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({ _method: 'DELETE' })
                            }).then(response => {
                                if (response.ok) {
                                    Swal.fire({
                                        title: "Deleted!",
                                        text: `${userName} has been deleted.`,
                                        icon: "success",
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#3085d6", // Ubah warna tombol OK agar lebih terlihat
                                        customClass: {
                                            confirmButton: 'swal-custom-button' // Tambahkan class untuk styling tambahan
                                        }
                                    }).then(() => {
                                        window.location.reload(); // Reload halaman setelah klik OK
                                    });
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
