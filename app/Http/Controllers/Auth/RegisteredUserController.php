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
                    'id_direksi' => $user->id,
                    // tambahkan data spesifik untuk jabatan direksi jika diperlukan
                ]);
                break;
            case 2: // Pegawai Kepala Cabang
                PegawaiKepalaCabang::create([
                    'id_kepala_cabang' => $user->id,
                    // tambahkan data spesifik untuk jabatan kepala cabang jika diperlukan
                ]);
                break;
            case 3: // Pegawai Admin Kas
                PegawaiAdminKas::create([
                    'id_admin_kas' => $user->id,
                    // tambahkan data spesifik untuk jabatan admin kas jika diperlukan
                ]);
                break;
            case 4: // Pegawai Supervisor
                PegawaiSupervisor::create([
                    'id_supervisor' => $user->id,
                    // tambahkan data spesifik untuk jabatan supervisor jika diperlukan
                ]);
                break;
            case 5: // Pegawai Account Office
                PegawaiAccountOffice::create([
                    'id_account_officer' => $user->id,
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
