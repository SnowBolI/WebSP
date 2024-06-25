<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nasabah extends Model
{
    public function index()
{
    $nasabahs = Nasabah::all(); // Assuming Nasabah is your model name
    return view('dashboard', compact('nasabahs'));
}

}
