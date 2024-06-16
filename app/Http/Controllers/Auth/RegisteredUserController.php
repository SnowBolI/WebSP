<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
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
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $cabangs = \App\Models\Cabang::all(); // Mengambil semua cabang dari model Cabang

        return view('auth.register', compact('cabangs'));
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
        // Debug: Log request data
        \Log::info('Request Data:', $request->all());

        // Common validation rules
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'jabatan_id' => ['required', 'integer', 'between:1,5'], // Validasi jabatan_id antara 1 hingga 5
        ];

        // Add specific validation rules based on jabatan_id
        switch ($request->jabatan_id) {
            case 2:
            case 3:
            case 4:
            case 5:
                $rules['id_cabang'] = ['required', 'integer'];
                break;
        }

        // Validate input data
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        // Create new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'jabatan_id' => $request->jabatan_id,
        ]);

        if (!$user) {
            throw ValidationException::withMessages(['error' => 'Failed to create user']);
        }

        // Save specific data based on jabatan_id
        switch ($request->jabatan_id) {
            case 1: // Direksi
                Direksi::create([
                    'nama' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                break;
            case 2: // Pegawai Kepala Cabang
                // Get id_direksi from the Direksi table
                $direksi = Direksi::first(); // Adjust this to your specific requirements
                PegawaiKepalaCabang::create([
                    'nama_kepala_cabang' => $request->name,
                    'id_jabatan' => $request->jabatan_id,
                    'id_cabang' => $request->id_cabang,
                    'id_direksi' => $direksi ? $direksi->id_direksi : null,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                break;
            case 3: // Pegawai Admin Kas
                PegawaiAdminKas::create([
                    'nama_admin_kas' => $request->name,
                    'id_supervisor' => $request->id_supervisor,
                    'id_jabatan' => $request->jabatan_id,
                    'id_cabang' => $request->id_cabang,
                    'id_wilayah' => $request->id_wilayah,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                break;
            case 4: // Pegawai Supervisor
                $kepalacabang = PegawaiKepalaCabang::first();
                $cabangWilayah = CabangWilayah::where('id_cabang', $request->id_cabang)->first();
                $id_wilayah = $cabangWilayah ? $cabangWilayah->id_wilayah : null;
                PegawaiSupervisor::create([
                    'nama_supervisor' => $request->name,
                    'id_kepala_cabang' => $kepalacabang ? $kepalacabang->id_kepala_cabang : null,
                    'id_jabatan' => $request->jabatan_id,
                    'id_cabang' => $request->id_cabang,
                    'id_wilayah' => $id_wilayah,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                break;
            case 5: // Pegawai Account Office
                PegawaiAccountOffice::create([
                    'nama_account_officer' => $request->name,
                    'id_admin_kas' => $request->id_admin_kas,
                    'id_jabatan' => $request->jabatan_id,
                    'id_cabang' => $request->id_cabang,
                    'id_wilayah' => $request->id_wilayah,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                break;
            default:
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
