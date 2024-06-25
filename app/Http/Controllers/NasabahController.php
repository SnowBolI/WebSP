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
        return view('dashboard');
    }

    // Store a newly created resource in storage
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

        // Create new Nasabah
        Nasabah::create($request->all());

        return redirect()->route('dashboard')->with('success', 'Data nasabah berhasil ditambahkan.');
    }

    // Display the specified resource
    public function show(Nasabah $nasabah)
    {
        return view('dashboard', compact('nasabah'));
    }

    // Show the form for editing the specified resource
    public function edit(Nasabah $nasabah)
    {
        return view('dashboard', compact('nasabah'));
    }

    // Update the specified resource in storage
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

        // Update Nasabah
        $nasabah->update($request->all());

        return redirect()->route('dashboard')->with('success', 'Data nasabah berhasil diperbarui.');
    }

    // Remove the specified resource from storage
    public function destroy(Nasabah $nasabah)
    {
        $nasabah->delete();

        return redirect()->route('dashboard')->with('success', 'Data nasabah berhasil dihapus.');
    }
}

