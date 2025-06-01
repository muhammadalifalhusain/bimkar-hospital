<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Obat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __("Update Obat $obat->nama_obat") }}
                            </p>
                        </header>

                        <form method="post" action="{{ route('obat.update', ['id' => $obat->id]) }}" class="mt-6 space-y-6">
                            @csrf
                            @method('patch')

                            <div>
                                <x-input-label for="nama_obat" :value="__('Nama_obat')" />
                                <x-text-input id="nama_obat" name="namaObat" type="text" class="mt-1 block w-full" :value="old('namaObat', $obat->nama_obat)" required autofocus autocomplete="namaObat" />
                                <x-input-error class="mt-2" :messages="$errors->get('nama_obat')" />
                            </div>

                            <div>
                                <x-input-label for="kemasan" :value="__('Kemasan')" />
                                <x-text-input id="kemasan" name="kemasan" type="text" class="mt-1 block w-full" :value="old('kemasan', $obat->kemasan)" required autocomplete="kemasan" />
                                <x-input-error class="mt-2" :messages="$errors->get('kemasan')" />
                            </div>

                            <div>
                                <x-input-label for="harga" :value="__('Harga')" />
                                <x-text-input id="harga" name="harga" type="number" class="mt-1 block w-full" :value="old('harga', $obat->harga)" required autocomplete="harga" />
                                <x-input-error class="mt-2" :messages="$errors->get('harga')" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>

                                @if (session('status') === 'obat-updated')
                                    <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600 dark:text-gray-400"
                                    >{{ __('Saved.') }}</p>
                                @endif
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
