<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use Illuminate\Http\Request;

class DataController extends Controller
{

    public function landingPage()
    {
        $nasabahs = Nasabah::all(); // Ambil semua data barang dari database
        return view('dashboard', compact('nasabahs'));
    }

    

    // public function produk()
    // {
    //     $barangs = Barang::all(); // Ambil semua data barang dari database
    //     return view('product', compact('barangs'));
    // }

    // public function about()
    // {
    //     $abouts = About::all();
    //     return view('about', compact('abouts'));
    // }

    // public function blog()
    // {
    //     $barangs = Barang::all(); // Ambil semua data barang dari database
    //     return view('blog');
    // }

    // public function contact()
    // {
    //     $barangs = Barang::all(); // Ambil semua data barang dari database
    //     return view('contact');
    // }

    // public function services()
    // {
    //     $barangs = Barang::all(); // Ambil semua data barang dari database
    //     return view('services', compact('barangs'));
    // }

    // public function databarang(){
    //     return view('databarang', ['barangs' => Barang::all()]);
    // }

    // public function dataabout(){
    //     return view('dataabout', ['abouts' => About::all()]);
    // }

    // public function tambahdata(){
    //     return view('index');
    // }

    // public function tambahabout(){
    //     return view('index');
    // }

    public function insertdata(Request $request){
        $data = Nasabah::create($request->all());
    
        
        $folderPath = public_path('gambaraja');
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0755, true);
        }
    
        
        if($request->hasFile('gambar')){
            $request->file('gambar')->move('gambaraja', $request->file('gambar')->getClientOriginalName());
            $data->gambar = $request->file('gambar')->getClientOriginalName();
            $data->save();
        }
        
        return redirect('/dashboard')->with('success', 'Data Berhasil Di Tambahkan');
    }

//     public function insertabout(Request $request)
// {
//     // Create new About instance with request data
//     $data = About::create($request->all());

//     // Redirect to index page with success message
//     return redirect('/index')->with('success', 'Data About Berhasil Ditambahkan');
// }
    // public function tampilkandata($id_barang){
    //     $data = Barang::find($id_barang);
    //     return view('tampildata', compact('data'));
    // }
    // public function tampilkanabout($id_barang){
    //     $data = About::find($id_barang);
    //     return view('tampilabout', compact('data'));
    // }

    public function updatedata(Request $request, $id) {
    $data = Nasabah::find($id);
    
    // Update data except for the image
    $data->update($request->except('gambar'));

    // Check if an image file is uploaded
    if ($request->hasFile('gambar')) {
        // Delete the old image if it exists
        if (!empty($data->gambar)) {
            $oldImagePath = public_path('gambaraja/' . $data->gambar);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        // Move the uploaded image file to the 'gambaraja' folder
        $newImageName = $request->file('gambar')->getClientOriginalName();
        $request->file('gambar')->move(public_path('gambaraja'), $newImageName);

        // Save the new image file name to the model
        $data->gambar = $newImageName;
        $data->save();
    }

    return redirect()->route('dashboard')->with('success', 'Data Berhasil Di Update');
}

//     public function updateabout(Request $request, $id)
// {
//     $data = About::find($id);

//     // Update data
//     $data->update($request->all());

//     return redirect()->route('index')->with('success', 'Data Berhasil Di Update');
// }


    public function delete($id){
        $data = Barang::find($id);
    
        // Hapus gambar jika ada
        if (!empty($data->gambar)) {
            $gambarPath = public_path('gambaraja/' . $data->gambar);
            
            // Pastikan file gambar ada dan dapat diakses
            if (file_exists($gambarPath)) {
                // Hapus file gambar
                if (unlink($gambarPath)) {
                    // Hapus record dari database
                    $data->delete();
                    return redirect('/index')->with('success', 'Data Berhasil Di Hapus');
                } else {
                    // Jika gagal menghapus file
                    return redirect('/index')->with('error', 'Gagal menghapus file gambar');
                }
            } else {
                // Jika file gambar tidak ditemukan
                return redirect('/index')->with('error', 'File gambar tidak ditemukan');
            }
        } else {
            // Jika tidak ada gambar yang terkait
            $data->delete();
            return redirect('/index')->with('success', 'Data Berhasil Di Hapus');
        }
    }
    
}
