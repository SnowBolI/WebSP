<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Data Nasabah') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between mb-4">
                        <h2 class="text-2xl font-bold">List Data Nasabah</h2>
                        <button onclick="toggleModal()" class="bg-blue-500 text-white px-4 py-2 rounded">
                            Tambah Data
                        </button>
                    </div>
                    
                    <!-- Modal -->
                    <div id="modal" class="fixed z-10 inset-0 overflow-y-auto hidden">
                        <div class="flex items-center justify-center min-h-screen">
                            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-2xl">
                                <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-gray-100">Tambah Data Nasabah</h2>
                                <form method="POST" action="{{ route('nasabahs.store') }}">
                                    @csrf
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nama</label>
                                            <input type="text" name="nama" id="nama" class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-200">
                                        </div>
                                        <div>
                                            <label for="pokok" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Pokok</label>
                                            <input type="number" name="pokok" id="pokok" class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-200">
                                        </div>
                                        <div>
                                            <label for="bunga" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Bunga</label>
                                            <input type="number" name="bunga" id="bunga" class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-200">
                                        </div>
                                        <div>
                                            <label for="denda" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Denda</label>
                                            <input type="number" name="denda" id="denda" class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-200">
                                        </div>
                                        <div>
                                            <label for="total" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Total</label>
                                            <input type="number" name="total" id="total" class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-200">
                                        </div>
                                        <div>
                                            <label for="account_officer" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Account Officer</label>
                                            <input type="text" name="account_officer" id="account_officer" class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-200">
                                        </div>
                                        <div>
                                            <label for="keterangan" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Keterangan</label>
                                            <input type="text" name="keterangan" id="keterangan" class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-200">
                                        </div>
                                        <div>
                                            <label for="ttd" class="block text-sm font-medium text-gray-700 dark:text-gray-200">TTD</label>
                                            <input type="text" name="ttd" id="ttd" class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-200">
                                        </div>
                                        <div>
                                            <label for="kembali" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Kembali</label>
                                            <input type="text" name="kembali" id="kembali" class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-200">
                                        </div>
                                        <div>
                                            <label for="id_cabang" class="block text-sm font-medium text-gray-700 dark:text-gray-200">ID Cabang</label>
                                            <input type="number" name="id_cabang" id="id_cabang" class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-200">
                                        </div>
                                        <div>
                                            <label for="bukti" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Bukti (Gambar)</label>
                                            <input type="file" name="bukti" id="bukti" class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-200">
                                        </div>
                                        <div>
                                            <label for="id_wilayah" class="block text-sm font-medium text-gray-700 dark:text-gray-200">ID Wilayah</label>
                                            <input type="number" name="id_wilayah" id="id_wilayah" class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-200">
                                        </div>
                                        <div>
                                            <label for="id_admin_kas" class="block text-sm font-medium text-gray-700 dark:text-gray-200">ID Admin Kas</label>
                                            <input type="number" name="id_admin_kas" id="id_admin_kas" class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-200">
                                        </div>
                                    </div>
                                    <div class="mt-4 flex justify-end">
                                        <button type="button" onclick="toggleModal()" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">
                                            Batal
                                        </button>
                                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                                            Simpan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Responsive table wrapper -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-fixed divide-y divide-gray-200">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="w-8 px-2 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">No</th>
                                    <th class="w-32 px-2 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Nama</th>
                                    <th class="w-24 px-2 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Pokok</th>
                                    <th class="w-24 px-2 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Bunga</th>
                                    <th class="w-24 px-2 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Denda</th>
                                    <th class="w-24 px-2 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Total</th>
                                    <th class="w-40 px-2 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Account Officer</th>
                                    <th class="w-32 px-2 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Keterangan</th>
                                    <th class="w-24 px-2 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">TTD</th>
                                    <th class="w-24 px-2 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Kembali</th>
                                    <th class="w-24 px-2 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">ID Cabang</th>
                                    <th class="w-32 px-2 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Bukti (Gambar)</th>
                                    <th class="w-24 px-2                                 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">ID Admin Kas</th>
                                <th class="w-32 px-2 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Created At</th>
                                <th class="w-32 px-2 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Updated At</th>
                                <th class="w-16 px-2 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200">
                                @foreach ($nasabahs as $nasabah)
                                <tr>
                                    <td class="px-2 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                                    <td class="px-2 py-4 whitespace-nowrap">{{ $nasabah->nama }}</td>
                                    <td class="px-2 py-4 whitespace-nowrap">{{ $nasabah->pokok }}</td>
                                    <td class="px-2 py-4 whitespace-nowrap">{{ $nasabah->bunga }}</td>
                                    <td class="px-2 py-4 whitespace-nowrap">{{ $nasabah->denda }}</td>
                                    <td class="px-2 py-4 whitespace-nowrap">{{ $nasabah->total }}</td>
                                    <td class="px-2 py-4 whitespace-nowrap">{{ $nasabah->account_officer }}</td>
                                    <td class="px-2 py-4 whitespace-nowrap">{{ $nasabah->keterangan }}</td>
                                    <td class="px-2 py-4 whitespace-nowrap">{{ $nasabah->ttd }}</td>
                                    <td class="px-2 py-4 whitespace-nowrap">{{ $nasabah->kembali }}</td>
                                    <td class="px-2 py-4 whitespace-nowrap">{{ $nasabah->id_cabang }}</td>
                                    <td class="px-2 py-4 whitespace-nowrap">
                                        @if ($nasabah->bukti)
                                        <img src="{{ asset('storage/' . $nasabah->bukti) }}" alt="Bukti" class="w-16 h-16">
                                        @endif
                                    </td>
                                    <td class="px-2 py-4 whitespace-nowrap">{{ $nasabah->id_admin_kas }}</td>
                                    <td class="px-2 py-4 whitespace-nowrap">{{ $nasabah->created_at }}</td>
                                    <td class="px-2 py-4 whitespace-nowrap">{{ $nasabah->updated_at }}</td>
                                    <td class="px-2 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('nasabahs.edit', $nasabah->id) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                        <form action="{{ route('nasabahs.destroy', $nasabah->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 ml-2">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleModal() {
            const modal = document.getElementById('modal');
            modal.classList.toggle('hidden');
        }
    </script>

</x-app-layout>

