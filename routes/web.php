<?php

use App\Http\Controllers\DataController;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

// Login Routes
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Register Routes
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/', function () {
    return view('welcome');
});

// Redirect /dashboard to the NasabahController's index method
Route::get('/dashboard', [NasabahController::class, 'index'])->name('dashboard');

// Resource routes for NasabahController
Route::resource('nasabahs', NasabahController::class);

// Route for inserting data
Route::post('/insert-data', [DataController::class, 'insertData'])->name('insert.data');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
