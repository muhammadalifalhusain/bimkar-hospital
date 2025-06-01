<x-app-layout> 
    <x-slot name="header"> 
        <h2 class="text-xl font-semibold leading-tight text-gray-800"> 
            {{ __('Daftar Obat') }} 
        </h2> 
    </x-slot> 
 
    <div class="py-12"> 
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8"> 
            <div class="p-4 bg-white shadow-sm sm:p-8 sm:rounded-lg">
                <section> 
                    <header class="flex items-center justify-between"> 
                        <h2 class="text-lg font-medium text-gray-900"> 
                            {{ __('Daftar Obat') }} 
                        </h2> 
    
                        <div class="flex-col items-center justify-center text-center"> 
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createObat">Tambah Obat</button> 
    
                            @if (session('status') === 'obat-created') 
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" 
                                    class="text-sm text-gray-600">{{ __('Created.') }}</p> 
                            @endif 
                            @if (session('status') === 'obat-exists') 
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" 
                                    class="text-sm text-gray-600">{{ __('Exists.') }}</p> 
                            @endif 
                        </div> 
    
                        {{-- Modal --}} 
                        <div class="modal fade bd-example-modal-lg" id="createObat" tabindex="-1" role="dialog" aria-labelledby="detailModalTitle" aria-hidden="true"> 
                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document"> 
                                <div class="modal-content"> 
    
                                    <!-- Modal Header --> 
                                    <div class="modal-header"> 
                                        <h5 class="modal-title font-weight-bold" id="riwayatModalLabel"> 
                                            Detail Obat 
                                        </h5> 
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
                                            <span aria-hidden="true">&times;</span> 
                                        </button> 
                                    </div> 
    
                                    <!-- Modal Body --> 
                                    <div class="modal-body"> 
                                        <form id="formObat" action="{{ route('obat.store') }}" method="POST"> 
                                            @csrf

                                            <div class="mb-4">
                                                <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                                                <input type="text" id="nama" name="namaObat" placeholder="Nama Obat" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            </div>

                                            <div class="mb-4">
                                                <label for="kemasan" class="block text-sm font-medium text-gray-700 mb-1">Kemasan</label>
                                                <input type="text" id="kemasan" name="kemasan" placeholder="Plastik" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            </div>

                                            <div class="mb-4">
                                                <label for="harga" class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                                                <div class="flex rounded-md shadow-sm">
                                                    <input type="text" name="harga" id="harga" placeholder="120000000"
                                                        class="flex-1 px-3 py-2 border border-gray-300 rounded-l-md">
                                                    <span class="inline-flex items-center px-3 border border-l-0 border-gray-300 bg-gray-100 text-gray-700 rounded-r-md text-sm">
                                                        Rp
                                                    </span>
                                                </div>
                                            </div>

                                        </form> 
                                    </div> 
    
                                    <!-- Modal Footer --> 
                                    <div class="modal-footer"> 
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> 
                                            Tutup 
                                        </button> 
                                        <button type="button" class="btn btn-primary" onclick="document.getElementById('formObat').submit();" data-dismiss="modal"> 
                                            Simpan 
                                        </button> 
                                    </div> 
                                </div> 
                            </div> 
                        </div> 
                    </header> 
    
                    <table class="table mt-6 overflow-hidden rounded table-hover"> 
                        <thead class="thead-light"> 
                            <tr> 
                                <th scope="col">No</th> 
                                <th scope="col">Nama</th> 
                                <th scope="col">Kemasan</th> 
                                <th scope="col">Harga</th> 
                                <th scope="col">Aksi</th> 
                            </tr> 
                        </thead> 
                        <tbody> 
                            @foreach ($obats as $row) 
                                <tr> 
                                    <th scope="row" class="align-middle text-start">{{ $loop->iteration }}</th> 
                                    <td class="align-middle text-start">{{ $row->nama_obat }}</td> 
                                    <td class="align-middle text-start">{{ $row->kemasan }}</td> 
                                    <td class="align-middle text-start">@rupiah($row->harga)</td> 
                                    <td class="align-middle text-start d-flex  gap-1"> 
                                        <a class="btn btn-sm btn-info" href="{{ route('obat.edit', ['id' => $row->id]) }}">Edit</a>
                                        <form action="{{ route('obat.destroy', ['id' => $row->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>

                                    </td> 
                                </tr> 
                            @endforeach 
                        </tbody> 
                    </table> 
                </section> 
            </div> 
        </div>
    </div>
</x-app-layout> 