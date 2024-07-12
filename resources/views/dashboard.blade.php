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
                        <button onclick="toggleModal('add')" class="bg-blue-500 text-white px-4 py-2 rounded">
                            Tambah Data
                        </button>
                    </div>
                    
                    <!-- Modal -->
                    <div id="modal" class="fixed z-10 inset-0 overflow-y-auto hidden">
                        <div class="flex items-center justify-center min-h-screen">
                            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-2xl">
                                <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-gray-100">Tambah Data Nasabah</h2>
                                <form method="POST" action="" enctype="multipart/form-data" id="nasabah-form">
                                    @csrf
                                    <input type="hidden" name="_method" id="method">
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
                                            <input type="date" name="kembali" id="kembali" class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-200">
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
                                    <th class="w-32 px-2 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">ID Wilayah</th>
                                    <th class="w-24 px-2 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200">
                                @foreach ($nasabahs as $nasabah)
                                <tr>
                                    <td class="px-2 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $loop->iteration }}</td>
                                    <td class="px-2 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $nasabah->nama }}</td>
                                    <td class="px-2 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $nasabah->pokok }}</td>
                                    <td class="px-2 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $nasabah->bunga }}</td>
                                    <td class="px-2 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $nasabah->denda }}</td>
                                    <td class="px-2 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $nasabah->total }}</td>
                                    <td class="px-2 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $nasabah->account_officer }}</td>
                                    <td class="px-2 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $nasabah->keterangan }}</td>
                                    <td class="px-2 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $nasabah->ttd }}</td>
                                    <td class="px-2 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $nasabah->kembali }}</td>
                                    <td class="px-2 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $nasabah->id_cabang }}</td>
                                    <td class="px-2 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200"><img src="{{ $nasabah->bukti }}" alt="Bukti" class="h-10 w-10"></td>
                                    <td class="px-2 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $nasabah->id_wilayah }}</td>
                                    <td class="px-2 py-4 whitespace-nowrap text-sm font-medium">
                                        <button onclick="editNasabah({{ json_encode($nasabah) }})" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-100">Edit</button>
                                        <form method="POST" action="{{ route('nasabahs.destroy', $nasabah->no) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Are you sure?')" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-100">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $nasabahs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleModal(action = '') {
            const modal = document.getElementById('modal');
            const form = document.getElementById('nasabah-form');
            const methodInput = document.getElementById('method');

            if (action === 'add') {
                form.action = "{{ route('nasabahs.store') }}";
                methodInput.value = 'POST';
                form.reset(); // Clear form data
            }

            modal.classList.toggle('hidden');
        }

        function editNasabah(nasabah) {
            const modal = document.getElementById('modal');
            const form = document.getElementById('nasabah-form');
            const methodInput = document.getElementById('method');

            form.action = "/nasabahs/" + nasabah.no;
            methodInput.value = 'PUT';

            document.getElementById('nama').value = nasabah.nama;
            document.getElementById('pokok').value = nasabah.pokok;
            document.getElementById('bunga').value = nasabah.bunga;
            document.getElementById('denda').value = nasabah.denda;
            document.getElementById('total').value = nasabah.total;
            document.getElementById('account_officer').value = nasabah.account_officer;
            document.getElementById('keterangan').value = nasabah.keterangan;
            document.getElementById('ttd').value = nasabah.ttd;
            document.getElementById('kembali').value = nasabah.kembali;
            document.getElementById('id_cabang').value = nasabah.id_cabang;
            document.getElementById('id_wilayah').value = nasabah.id_wilayah;
            // bukti field is not filled as it's a file input

            modal.classList.toggle('hidden');
        }
    </script>
</x-app-layout>
