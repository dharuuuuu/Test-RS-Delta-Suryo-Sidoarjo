<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.users.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('users.index') }}" class="mr-4">
                        <i class="mr-1 icon ion-md-arrow-back"></i>
                    </a>
                </x-slot>

                <div class="mt-4 px-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Kolom Kiri --}}
                        <div>
                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    @lang('crud.users.inputs.name')
                                </h5>
                                <span>{{ $user->name ?? '-' }}</span>
                            </div>
                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    @lang('crud.users.inputs.gender')
                                </h5>
                                <span>{{ $user->gender ?? '-' }}</span>
                            </div>
                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    @lang('crud.roles.name')
                                </h5>
                                <div>
                                    @forelse ($user->roles as $role)
                                        <span class="inline-block px-2 py-1 text-sm rounded bg-blue-500 text-white">
                                            {{ $role->name }}
                                        </span>
                                    @empty
                                        <span>-</span>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        {{-- Kolom Kanan --}}
                        <div>
                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    @lang('crud.users.inputs.email')
                                </h5>
                                <span>{{ $user->email ?? '-' }}</span>
                            </div>
                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700">
                                    @lang('crud.users.inputs.date_of_birth')
                                </h5>
                                <span>{{ $user->date_of_birth ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tombol Navigasi --}}
                <div class="mt-10 flex justify-between">
                    <a href="{{ route('users.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\User::class)
                    <a href="{{ route('users.create') }}" class="button">
                        <i class="mr-1 icon ion-md-add"></i>
                        @lang('crud.common.create')
                    </a>
                    @endcan
                </div>
            </x-partials.card>
        </div>
    </div>
</x-app-layout>
