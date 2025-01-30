<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div style="padding: 20px; text-align: center; font-size: 18px;">
                    Berhasil Login Sebagai <strong>{{ Auth::user()->getRoleNames()->implode(', ') }}</strong>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
