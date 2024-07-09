<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Cabang;
use App\Models\Direksi;
use App\Models\PegawaiKepalaCabang;
use App\Models\PegawaiAdminKas;
use App\Models\PegawaiSupervisor;
use App\Models\PegawaiAccountOffice;
use App\Models\CabangWilayah; // Tambahkan model CabangWilayah
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
    public function create()
    {
        $cabangs = Cabang::all();
        return view('auth.register', compact('cabangs'));
    }

    public function store(Request $request): RedirectResponse
    {
        \Log::info('Request Data:', $request->all());

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'id_jabatan' => ['required', 'integer', 'between:1,5'],
        ];

        switch ($request->id_jabatan) {
            case 2:
            case 3:
            case 4:
            case 5:
                $rules['id_cabang'] = ['required', 'integer'];
                break;
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'id_jabatan' => $request->id_jabatan,
        ]);

        if (!$user) {
            throw ValidationException::withMessages(['error' => 'Failed to create user']);
        }

        switch ($request->id_jabatan) {
            case 1:
                Direksi::create([
                    'id_user' => $user->id_user,
                    'nama' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                break;
            case 2:
                $direksi = Direksi::first();
                PegawaiKepalaCabang::create([
                    'id_user' => $user->id_user,
                    'nama_kepala_cabang' => $request->name,
                    'id_jabatan' => $request->id_jabatan,
                    'id_cabang' => $request->id_cabang,
                    'id_direksi' => $direksi->id,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                break;
            case 3:
                $kepalacabang = PegawaiKepalaCabang::first();
                $cabangWilayah = CabangWilayah::where('id_cabang', $request->id_cabang)->first();
                $id_wilayah = $cabangWilayah ? $cabangWilayah->id_wilayah : null;
                PegawaiSupervisor::create([
                    'id_user' => $user->id_user,
                    'nama_supervisor' => $request->name,
                    'id_jabatan' => $request->id_jabatan,
                    'id_cabang' => $request->id_cabang,
                    'id_wilayah' => $id_wilayah,
                    'id_kepala_cabang' => $kepalacabang->id_kepala_cabang,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                break;
            case 4:
                $kepalacabang = PegawaiKepalaCabang::first();
                PegawaiAdminKas::create([
                    'id_user' => $user->id_user,
                    'nama_admin_kas' => $request->name,
                    'id_jabatan' => $request->id_jabatan,
                    'id_cabang' => $request->id_cabang,
                    'id_kepala_cabang' => $kepalacabang->id_kepala_cabang,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                break;
            case 5:
                $kepalacabang = PegawaiKepalaCabang::first();
                PegawaiAccountOffice::create([
                    'id_user' => $user->id,
                    'nama_account_officer' => $request->name,
                    'id_jabatan' => $request->id_jabatan,
                    'id_cabang' => $request->id_cabang,
                    'id_kepala_cabang' => $kepalacabang->id_kepala_cabang,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                break;
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
