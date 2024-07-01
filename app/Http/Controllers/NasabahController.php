<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use Illuminate\Http\Request;

class NasabahController extends Controller
{
    public function index()
    {
        $nasabahs = Nasabah::all();
        return view('dashboard', ['nasabahs' => $nasabahs]);
    }

    public function create()
    {
        return view('nasabah.create');
    }

    public function store(Request $request)
    {
        \Log::info('Store Method Called');

        // Validasi input
        $validatedData = $request->validate([
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
            'id_admin_kas' => 'required|numeric',
        ]);

        \Log::info('Validated Data: ', $validatedData);

        // Handle file upload for 'bukti'
        if ($request->hasFile('bukti')) {
            $file = $request->file('bukti');
            $fileName = time().'_'.$file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $fileName, 'public');
            $validatedData['bukti'] = '/storage/' . $filePath;
        }

        // Buat instance baru dari model Nasabah
        $nasabah = Nasabah::create($validatedData);
        \Log::info('Nasabah Created: ', $nasabah->toArray());

        // Redirect atau response yang sesuai setelah penyimpanan berhasil
        return redirect()->route('dashboard')->with('success', 'Nasabah berhasil ditambahkan');
    }

    public function show(Nasabah $nasabah)
    {
        return view('nasabah.show', compact('nasabah'));
    }

    public function edit(Nasabah $nasabah)
    {
        return view('nasabah.edit', compact('nasabah'));
    }

    public function update(Request $request, Nasabah $nasabah)
    {
        $validatedData = $request->validate([
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
            'id_admin_kas' => 'required|numeric',
        ]);

        $nasabah->fill($validatedData);

        if ($request->hasFile('bukti')) {
            $file = $request->file('bukti');
            $fileName = time().'_'.$file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $fileName, 'public');
            $nasabah->bukti = '/storage/' . $filePath;
        }

        $nasabah->save();
        return redirect()->route('dashboard')->with('success', 'Data nasabah berhasil diperbarui.');
    }

    public function destroy(Nasabah $nasabah)
    {
        $nasabah->delete();

        return redirect()->route('dashboard')->with('success', 'Data nasabah berhasil dihapus.');
    }
}
