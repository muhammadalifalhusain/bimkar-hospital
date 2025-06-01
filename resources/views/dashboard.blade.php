<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (Auth::user()->role == "dokter")
                        {{ __("You're logged in, Dokter!") }}
                    @elseif (Auth::user()->role == "pasien")
                        @if (session('status') === 'user-created') <span x-data="{ show: true }" class="ml-1 inline-block px-3 py-1 text-sm font-semibold text-green-800 bg-green-100 rounded-full" x-show="show" x-transition x-init="setTimeout(() => show = false, 10000)" class="text-sm text-gray-600">{{ __('Welcome New User!') }} @endif </span> {{ __("You're logged in, Pasien!") }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
