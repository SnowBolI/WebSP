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
        return view('nasabah.create'); // Create a new view for creating Nasabah
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'pokok' => 'required|numeric',
            'bunga' => 'required|numeric',
            'denda' => 'required|numeric',
            'total' => 'required|numeric',
            'account_officer' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
            'ttd' => 'nullable|string|max:255',
            'kembali' => 'nullable|string|max:255',
            'id_cabang' => 'required|numeric',
            'bukti' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'id_wilayah' => 'required|numeric',
            'id_admin_kas' => 'required|numeric',
        ]);

        $nasabah = new Nasabah($request->except('bukti'));

        if ($request->hasFile('bukti')) {
            $file = $request->file('bukti');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $nasabah->bukti = $filename;
        }

        $nasabah->save();

        return redirect()->route('dashboard')->with('success', 'Data nasabah berhasil ditambahkan.');
    }

    public function show(Nasabah $nasabah)
    {
        return view('nasabah.show', compact('nasabah')); // Create a new view for showing a single Nasabah
    }

    public function edit(Nasabah $nasabah)
    {
        return view('nasabah.edit', compact('nasabah')); // Create a new view for editing Nasabah
    }

    public function update(Request $request, Nasabah $nasabah)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'pokok' => 'required|numeric',
            'bunga' => 'required|numeric',
            'denda' => 'required|numeric',
            'total' => 'required|numeric',
            'account_officer' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
            'ttd' => 'nullable|string|max:255',
            'kembali' => 'nullable|string|max:255',
            'id_cabang' => 'required|numeric',
            'bukti' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'id_wilayah' => 'required|numeric',
            'id_admin_kas' => 'required|numeric',
        ]);

        $nasabah->fill($request->except('bukti'));

        if ($request->hasFile('bukti')) {
            $file = $request->file('bukti');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $nasabah->bukti = $filename;
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
