@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="mt-8">
        <!-- Button to Open Tambah Barang Modal -->
        <button type="button" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mb-4" data-bs-toggle="modal" data-bs-target="#tambahModal">
            Tambah Barang
        </button>

        @if ($message = Session::get('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert" id="success-alert">
            <strong class="font-bold">{{ $message }}</strong>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
            </span>
        </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-2 px-4 border-b">No</th>
                        <th class="py-2 px-4 border-b">Nama</th>
                        <th class="py-2 px-4 border-b">Pokok</th>
                        <th class="py-2 px-4 border-b">Bunga</th>
                        <th class="py-2 px-4 border-b">Denda</th>
                        <th class="py-2 px-4 border-b">Total</th>
                        <th class="py-2 px-4 border-b">Account Officer</th>
                        <th class="py-2 px-4 border-b">Keterangan</th>
                        <th class="py-2 px-4 border-b">TTD</th>
                        <th class="py-2 px-4 border-b">Kembali</th>
                        <th class="py-2 px-4 border-b">Cabang</th>
                        <th class="py-2 px-4 border-b">ID Account Officer</th>
                        <th class="py-2 px-4 border-b">ID Kepala Cabang</th>
                        <th class="py-2 px-4 border-b">ID Admin Kas</th>
                        <th class="py-2 px-4 border-b">Created At</th>
                        <th class="py-2 px-4 border-b">Updated At</th>
                        <th class="py-2 px-4 border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($nasabahs as $nasabah)
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $nasabah->no }}</td>
                        <td class="py-2 px-4 border-b">{{ $nasabah->nama }}</td>
                        <td class="py-2 px-4 border-b">{{ $nasabah->pokok }}</td>
                        <td class="py-2 px-4 border-b">{{ $nasabah->bunga }}</td>
                        <td class="py-2 px-4 border-b">{{ $nasabah->denda }}</td>
                        <td class="py-2 px-4 border-b">{{ $nasabah->total }}</td>
                        <td class="py-2 px-4 border-b">{{ $nasabah->account_officer }}</td>
                        <td class="py-2 px-4 border-b">{{ $nasabah->keterangan }}</td>
                        <td class="py-2 px-4 border-b">{{ $nasabah->ttd }}</td>
                        <td class="py-2 px-4 border-b">{{ $nasabah->kembali }}</td>
                        <td class="py-2 px-4 border-b">{{ $nasabah->cabang }}</td>
                        <td class="py-2 px-4 border-b">{{ $nasabah->id_account_officer }}</td>
                        <td class="py-2 px-4 border-b">{{ $nasabah->id_kepala_cabang }}</td>
                        <td class="py-2 px-4 border-b">{{ $nasabah->id_admin_kas }}</td>
                        <td class="py-2 px-4 border-b">{{ $nasabah->created_at->format('Y-m-d | H:i:s') }}</td>
                        <td class="py-2 px-4 border-b">{{ $nasabah->updated_at->format('Y-m-d | H:i:s') }}</td>
                        <td class="py-2 px-4 border-b">
                            <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded text-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $nasabah->id }}">Edit</button>
                            <button type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $nasabah->id }}">Hapus</button>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal{{ $nasabah->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $nasabah->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header bg-gray-100">
                                    <h5 class="modal-title" id="editModalLabel{{ $nasabah->id }}">Edit Barang</h5>
                                    <button type="button" class="bg-transparent border-0 text-black float-right" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body bg-white">
                                    <form action="{{ route('update.barang', $nasabah->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('POST')
                                        <div class="mb-4">
                                            <label for="gambar" class="block text-gray-700 text-sm font-bold mb-2">Gambar</label>
                                            <input type="file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="gambar" name="gambar">
                                        </div>
                                        <div class="mb-4">
                                            <label for="nama" class="block text-gray-700 text-sm font-bold mb-2">Nama</label>
                                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nama" name="nama" value="{{ $nasabah->nama }}">
                                        </div>
                                        <div class="mb-4">
                                            <label for="deskripsi" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
                                            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="deskripsi" name="deskripsi" rows="3">{{ $nasabah->deskripsi }}</textarea>
                                        </div>
                                        <div class="mb-4">
                                            <label for="harga" class="block text-gray-700 text-sm font-bold mb-2">Harga</label>
                                            <input type="number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="harga" name="harga" value="{{ $nasabah->harga }}">
                                        </div>
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Simpan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Confirmation Modal -->
                    <div class="modal fade" id="deleteModal{{ $nasabah->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $nasabah->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-gray-100">
                                    <h5 class="modal-title" id="deleteModalLabel{{ $nasabah->id }}">Konfirmasi Hapus</h5>
                                    <button type="button" class="bg-transparent border-0 text-black float-right" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body bg-white">
                                    <p>Apakah Anda yakin ingin menghapus barang <strong>{{ $nasabah->nama }}</strong>?</p>
                                </div>
                                <div class="modal-footer bg-gray-100">
                                    <button type="button" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded" data-bs-dismiss="modal">Batal</button>
                                    <a href="{{ route('delete.barang', $nasabah->id) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Hapus</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Tambah Modal -->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gray-100">
                <h5 class="modal-title" id="tambahModalLabel">Tambah Barang</h5>
                <button type="button" class="bg-transparent border-0 text-black float-right" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-white">
                <form action="{{ route('insert.data') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="gambar" class="block text-gray-700 text-sm font-bold mb-2">Gambar</label>
                        <input type="file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="gambar" name="gambar">
                    </div>
                    <div class="mb-4">
                        <label for="nama" class="block text-gray-700 text-sm font-bold mb-2">Nama</label>
                        <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nama" name="nama">
                    </div>
                    <div class="mb-4">
                        <label for="deskripsi" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
                        <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="deskripsi" name="deskripsi" rows="3"></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="harga" class="block text-gray-700 text-sm font-bold mb-2">Harga</label>
                        <input type="number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="harga" name="harga">
                    </div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

