<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Direksi;
use App\Models\PegawaiKepalaCabang;
use App\Models\PegawaiAdminKas;
use App\Models\PegawaiSupervisor;
use App\Models\PegawaiAccountOffice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Providers\RouteServiceProvider;
use Illuminate\Routing\Controller;

class RegisteredUserController extends Controller
{
    /**
     * Disp lay the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
{
    // Validasi data input
    $validator = Validator::make($request->all(), [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'jabatan_id' => ['required', 'integer', 'between:1,5'], // Validasi jabatan_id antara 1 hingga 5
    ]);

    if ($validator->fails()) {
        return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
    }

    // Membuat pengguna baru
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'jabatan_id' => $request->jabatan_id,
    ]);

    // Memastikan user berhasil dibuat
    if (!$user) {
        throw ValidationException::withMessages(['error' => 'Failed to create user']);
    }

    // Menyimpan data spesifik berdasarkan jabatan
    switch ($request->jabatan_id) {
        case 1: // Direksi
            Direksi::create([
                'nama' => $request->name, // Contoh penggunaan nama untuk Direksi
                'email' => $request->email,
                'password' => Hash::make($request->password),
                // tambahkan data spesifik untuk jabatan direksi jika diperlukan
            ]);
            break;
        case 2: // Pegawai Kepala Cabang
            PegawaiKepalaCabang::create([
                'nama_kepala_cabang' => $request->name, // Contoh penggunaan nama untuk Kepala Cabang
                'id_jabatan' => $request->jabatan_id,
                'id_cabang' => $request->id_cabang,
                'id_direksi' => $request->id_direksi,
                'email' => $request->email,
                'password' => $request->password
                // tambahkan data spesifik untuk jabatan kepala cabang jika diperlukan
            ]);
            break;
        case 3: // Pegawai Admin Kas
            PegawaiAdminKas::create([
                'nama_admin_kas' => $request->name, // Contoh penggunaan nama untuk Admin Kas
                'id_supervisor' =>$request->id_supervisor,
                'id_jabatan' => $request->jabatan_id,
                'id_cabang' => $request->id_cabang,
                'id_wilayah' => $request->id_wilayah,
                'email' => $request->email,
                'password' => $request->password
                // tambahkan data spesifik untuk jabatan admin kas jika diperlukan
            ]);
            break;
        case 4: // Pegawai Supervisor
            PegawaiSupervisor::create([
                'nama_supervisor' => $request->name, // Contoh penggunaan nama untuk Supervisor
                'id_kepala_cabang' => $request->id_kepala_cabang,
                'id_jabatan' => $request->jabatan_id,
                'id_cabang' => $request->id_cabang,
                'id_wilayah' => $request->id_wilayah,
                'email' => $request->email,
                'password' => $request->password
                // tambahkan data spesifik untuk jabatan supervisor jika diperlukan
            ]);
            break;
        case 5: // Pegawai Account Office
            PegawaiAccountOffice::create([
                'nama_account_officer' => $request->name, // Contoh penggunaan nama untuk Account Office
                'id_admin_kas' => $request->id_admin_kas,
                'id_jabatan' => $request->jabatan_id,
                'id_cabang' => $request->id_cabang,
                'id_wilayah' => $request->id_wilayah,
                'email' => $request->email,
                'password' => $request->password
                // tambahkan data spesifik untuk jabatan account office jika diperlukan
            ]);
            break;
        default:
            // do nothing or handle default case
            break;
    }

    // Event registered user
    event(new Registered($user));

    // Autentikasi user
    Auth::login($user);

    // Redirect home
    return redirect(RouteServiceProvider::HOME);
    }
}
