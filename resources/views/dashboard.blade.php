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

                    <!-- Filter and Search Form -->
                    <div class="flex justify-between mb-4">
                        <div>
                            <form method="GET" action="{{ route('nasabahs.index') }}">
                                <select name="date_filter" onchange="this.form.submit()" class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-4 py-2 rounded">
                                    <option value="">Last 30 days</option>
                                    <option value="last_7_days" {{ request('date_filter') == 'last_7_days' ? 'selected' : '' }}>Last 7 days</option>
                                    <option value="last_30_days" {{ request('date_filter') == 'last_30_days' ? 'selected' : '' }}>Last 30 days</option>
                                    <option value="last_month" {{ request('date_filter') == 'last_month' ? 'selected' : '' }}>Last month</option>
                                    <option value="last_year" {{ request('date_filter') == 'last_year' ? 'selected' : '' }}>Last year</option>
                                </select>
                            </form>
                        </div>
                        <div>
                            <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Search by name, branch, region" class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-4 py-2 rounded">
                        </div>
                    </div>

                    <!-- Modal -->
                    <div id="modal" class="fixed z-10 inset-0 overflow-y-auto hidden">
                        <div class="flex items-center justify-center min-h-screen">
                            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-2xl">
                                <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-gray-100" id="modal-title">Tambah Data Nasabah</h2>
                                <form method="POST" action="{{ route('nasabahs.store') }}" enctype="multipart/form-data" id="nasabah-form">
                                    @csrf
                                    <input type="hidden" name="_method" value="POST">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="no" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nomor</label>
                                            <input type="text" name="no" id="no" class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-200">
                                        </div>
                                        <div>
                                            <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nama</label>
                                            <input type="text" name="nama" id="nama" class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-200">
                                        </div>
                                        <div>
                                            <label for="pokok" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Pokok</label>
                                            <input type="number" name="pokok" id="pokok" class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-200" oninput="calculateTotal()">
                                        </div>
                                        <div>
                                            <label for="bunga" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Bunga</label>
                                            <input type="number" name="bunga" id="bunga" class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-200" oninput="calculateTotal()">
                                        </div>
                                        <div>
                                            <label for="denda" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Denda</label>
                                            <input type="number" name="denda" id="denda" class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-200" oninput="calculateTotal()">
                                        </div>
                                        <div>
                                            <label for="total" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Total</label>
                                            <input type="number" name="total" id="total" class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-200" readonly>
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
                                            <input type="date" name="ttd" id="ttd" class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-200">
                                        </div>
                                        <div>
                                            <label for="kembali" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Kembali</label>
                                            <input type="date" name="kembali" id="kembali" class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-200">
                                        </div>
                                        <div>
                                            <label for="id_cabang" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Cabang</label>
                                            <select name="id_cabang" id="id_cabang" class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-200">
                                                @foreach ($cabangs as $cabang)
                                                    <option value="{{ $cabang->id_cabang }}">{{ $cabang->nama_cabang }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label for="bukti" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Bukti (Gambar)</label>
                                            <input type="file" name="bukti" id="bukti" class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-200">
                                        </div>
                                        <div>
                                            <label for="id_wilayah" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Wilayah</label>
                                            <select name="id_wilayah" id="id_wilayah" class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-200">
                                                @foreach ($wilayahs as $wilayah)
                                                    <option value="{{ $wilayah->id_wilayah }}">{{ $wilayah->nama_wilayah }}</option>
                                                @endforeach
                                            </select>
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
                        <table class="min-w-full table-fixed divide-y divide-gray-200" id="nasabah-table">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="w-8 px-2 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">No</th>
                                    <th class="w-32 px-2 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Nama</th>
                                    <th class="w-16 px-2 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Pokok</th>
                                    <th class="w-16 px-2 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Bunga</th>
                                    <th class="w-16 px-2 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Denda</th>
                                    <th class="w-16 px-2 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Total</th>
                                    <th class="w-32 px-2 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Account Officer</th>
                                    <th class="w-64 px-2 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Keterangan</th>
                                    <th class="w-32 px-2 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Cabang</th>
                                    <th class="w-32 px-2 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Wilayah</th>
                                    <th class="w-32 px-2 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200">
                                @foreach ($nasabahs as $nasabah)
                                    <tr>
                                        <td class="px-2 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">{{ $nasabah->no }}</td>
                                        <td class="px-2 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-200">{{ $nasabah->nama }}</td>
                                        <td class="px-2 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-200">{{ $nasabah->pokok }}</td>
                                        <td class="px-2 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-200">{{ $nasabah->bunga }}</td>
                                        <td class="px-2 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-200">{{ $nasabah->denda }}</td>
                                        <td class="px-2 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-200">{{ $nasabah->total }}</td>
                                        <td class="px-2 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-200">{{ $nasabah->account_officer }}</td>
                                        <td class="px-2 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-200">{{ $nasabah->keterangan }}</td>
                                        <td class="px-2 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-200">{{ $nasabah->cabang->nama_cabang }}</td>
                                        <td class="px-2 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-200">{{ $nasabah->wilayah->nama_wilayah }}</td>
                                        <td class="px-2 py-4 whitespace-nowrap text-sm font-medium">
                                        <button onclick="toggleModal('edit', JSON.parse('{{ json_encode($nasabah) }}'))" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                        @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-600" onclick="return confirm('Are you sure you want to delete this item?');">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4">
                            {{ $nasabahs->links() }}
                        </div>
                    </div>

                    <!-- Custom JS for Modal and Search -->
                    <script>
                        function toggleModal(action, nasabah = null) {
        const modal = document.getElementById('modal');
        const form = document.getElementById('nasabah-form');
        const modalTitle = document.getElementById('modal-title');

        if (action === 'add') {
            form.action = "{{ route('nasabahs.store') }}";
            form.querySelector('[name="_method"]').value = 'POST';
            modalTitle.innerText = 'Tambah Data Nasabah';
            form.reset();
        } else if (action === 'edit' && nasabah) {
            form.action = `{{ url('nasabahs') }}/${nasabah.no}`;
            form.querySelector('[name="_method"]').value = 'PUT';
            modalTitle.innerText = 'Edit Data Nasabah';

            form.querySelector('[name="no"]').value = nasabah.no || '';
            form.querySelector('[name="nama"]').value = nasabah.nama || '';
            form.querySelector('[name="pokok"]').value = nasabah.pokok || '';
            form.querySelector('[name="bunga"]').value = nasabah.bunga || '';
            form.querySelector('[name="denda"]').value = nasabah.denda || '';
            form.querySelector('[name="total"]').value = nasabah.total || '';
            form.querySelector('[name="account_officer"]').value = nasabah.account_officer || '';
            form.querySelector('[name="keterangan"]').value = nasabah.keterangan || '';
            form.querySelector('[name="ttd"]').value = nasabah.ttd || '';
            form.querySelector('[name="kembali"]').value = nasabah.kembali || '';
            form.querySelector('[name="id_cabang"]').value = nasabah.id_cabang || '';
            form.querySelector('[name="id_wilayah"]').value = nasabah.id_wilayah || '';
        }

        modal.classList.toggle('hidden');
    }

    function calculateTotal() {
        const pokok = parseFloat(document.getElementById('pokok').value) || 0;
        const bunga = parseFloat(document.getElementById('bunga').value) || 0;
        const denda = parseFloat(document.getElementById('denda').value) || 0;
        const total = pokok + bunga + denda;
        document.getElementById('total').value = total;
    }

                        document.getElementById('search').addEventListener('keyup', function (event) {
                            const query = event.target.value;
                            const table = document.getElementById('nasabah-table');
                            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

                            for (let i = 0; i < rows.length; i++) {
                                const cells = rows[i].getElementsByTagName('td');
                                let match = false;

                                for (let j = 0; j < cells.length; j++) {
                                    if (cells[j].innerText.toLowerCase().includes(query.toLowerCase())) {
                                        match = true;
                                        break;
                                    }
                                }

                                if (match) {
                                    rows[i].style.display = '';
                                } else {
                                    rows[i].style.display = 'none';
                                }
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
