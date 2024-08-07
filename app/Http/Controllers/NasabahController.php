<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\Cabang;
use App\Models\Wilayah;
use Illuminate\Http\Request;

class NasabahController extends Controller
{
    public function index(Request $request)
{
    $query = Nasabah::with(['cabang', 'wilayah']);

    // Filtering by date
    if ($request->has('date_filter')) {
        switch ($request->input('date_filter')) {
            case 'last_7_days':
                $query->where('created_at', '>=', now()->subDays(7));
                break;
            case 'last_30_days':
                $query->where('created_at', '>=', now()->subDays(30));
                break;
            case 'last_month':
                $query->where('created_at', '>=', now()->subMonth());
                break;
            case 'last_year':
                $query->where('created_at', '>=', now()->subYear());
                break;
        }
    }

    // Search by nama, nama_cabang, and nama_wilayah
    if ($request->has('search')) {
        $search = $request->input('search');
        $query->where('nama', 'like', "%{$search}%")
              ->orWhereHas('cabang', function ($q) use ($search) {
                  $q->where('nama_cabang', 'like', "%{$search}%");
              })
              ->orWhereHas('wilayah', function ($q) use ($search) {
                  $q->where('nama_wilayah', 'like', "%{$search}%");
              });
    }

    $nasabahs = $query->paginate(10);
    $cabangs = Cabang::all();
    $wilayahs = Wilayah::all();

    return view('dashboard', compact('nasabahs', 'cabangs', 'wilayahs'));
}

    public function search(Request $request)
    {
        $query = $request->input('query');
        $nasabahs = Nasabah::where('nama', 'LIKE', "%{$query}%")
                            ->orWhere('id_cabang', 'LIKE', "%{$query}%")
                            ->orWhere('id_wilayah', 'LIKE', "%{$query}%")
                            ->get();

        return view('nasabahs.partials.table', compact('nasabahs'));
    }
    public function create()
{
    $cabangs = Cabang::all();
    $wilayahs = Wilayah::all();
    dd($cabangs, $wilayahs); // Debug statement to check dataP
    return view('nasabah.create', compact('cabangs', 'wilayahs'));
}

    public function store(Request $request)
    {
        $request->validate([
            'no' => 'required|numeric',
            'nama' => 'required',
            'pokok' => 'required|integer',
            'bunga' => 'required|integer',
            'denda' => 'required|integer',
            'total' => 'required|numeric',
            'account_officer' => 'required',
            'keterangan' => 'required',
            'ttd' => 'required',
            'kembali' => 'required',
            'id_cabang' => 'required|numeric',
            'bukti' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'id_wilayah' => 'required|numeric',
            'id_admin_kas' => 'nullable|numeric',
        ]);

        $nasabah = new Nasabah([
            'no' => $request->get('no'),
            'nama' => $request->get('nama'),
            'pokok' => $request->get('pokok'),
            'bunga' => $request->get('bunga'),
            'denda' => $request->get('denda'),
            'total' => $request->get('total'),
            'account_officer' => $request->get('account_officer'),
            'keterangan' => $request->get('keterangan'),
            'ttd' => $request->get('ttd'),
            'kembali' => $request->get('kembali'),
            'id_cabang' => $request->get('id_cabang'),
            'id_wilayah' => $request->get('id_wilayah'),
            'id_admin_kas' => $request->get('id_admin_kas')
        ]);

        // if ($request->hasFile('bukti')) {
        //     $file = $request->file('bukti');
        //     $filename = time() . '_' . $file->getClientOriginalName(); // Menambahkan timestamp untuk mencegah bentrok nama file
        //     $filePath = $file->storeAs('public/storage/bukti_sp', $filename); // Menyimpan file ke dalam storage/bukti_sp
        //     $nasabah->bukti = $filePath; // Menyimpan path file relatif ke database
        // } else {
        //     dd('File not received');
        // }
        $nasabah->save();
        return redirect()->route('dashboard')->with('success', 'Data nasabah berhasil ditambahkan');
    }

    public function show(Nasabah $nasabah)
    {
        return view('nasabah.show', compact('nasabah'));
    }

    public function edit(Nasabah $nasabah)
{
    $cabangs = Cabang::all();
    $wilayahs = Wilayah::all();
    dd($cabangs, $wilayahs, $nasabah); // Debug statement to check data
    return view('nasabah.edit', compact('nasabah', 'cabangs', 'wilayahs'));
}

    public function update(Request $request, Nasabah $nasabah)
    {
        $validatedData = $request->validate([
            'no' => 'required|numeric',
            'nama' => 'required|string|max:255',
            'pokok' => 'required|numeric',
            'bunga' => 'required|numeric',
            'denda' => 'required|numeric',
            'total' => 'required|numeric',
            'account_officer' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
            'ttd' => 'nullable|string|max:255',
            'kembali' => 'nullable|date',
            'id_cabang' => 'required|numeric',
            'bukti' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'id_wilayah' => 'required|numeric',
            'id_admin_kas' => 'nullable|numeric',
        ]);

        $nasabah->fill($validatedData);
        // if ($request->hasFile('bukti')) {
        //     $file = $request->file('bukti');
        //     $fileName = time() . '_' . $file->getClientOriginalName();
        //     $filePath = $file->storeAs('uploads', $fileName, 'public');
        //     $nasabah->bukti = '/storage/' . $filePath;
        // }

        $nasabah->save();
        return redirect()->route('dashboard')->with('success', 'Data nasabah berhasil diperbarui.');
    }

    public function destroy(Nasabah $nasabah)
    {
        $nasabah->delete();

        return redirect()->route('nasabahs.index')->with('success', 'Data nasabah berhasil dihapus.');
    }
}
