<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Direksi;
use App\Models\PegawaiKepalaCabang;
use App\Models\PegawaiAdminKas;
use App\Models\PegawaiSupervisor;
use App\Models\PegawaiAccountOffice;
use App\Models\Jabatan;
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
    public function index(Request $request)
    {
        return $request->user();
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'jabatan_id' => 'required|integer|between:1,5',
            'cabang' => 'required_if:jabatan_id,2,3,4,5|string|max:128',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'jabatan_id' => $request->jabatan_id,
            'cabang' => $request->cabang,
        ]);

        event(new Registered($user));
        Auth::login($user);
        return redirect(RouteServiceProvider::HOME);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = md5(time() . '.' . md5($request->email));
            $user->forceFill(['api_token' => $token])->save();
            return response()->json(['token' => $token]);
        }

        return response()->json(['message' => 'The provided credentials do not match our records.'], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->forceFill(['api_token' => null])->save();
        return response()->json(['message' => 'success']);
    }

    public function jabatan()
    {
        $jabatan = Jabatan::all();
        return response()->json($jabatan);
    }

    public function create()
    {
        $users = User::select('cabang')->distinct()->get();
        return view('auth.register', compact('users'));
    }

    public function store(Request $request): RedirectResponse
{
    \Log::info('Request Data:', $request->all());

    $rules = [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'jabatan_id' => ['required', 'integer', 'between:1,5'],
        'cabang' => ['required_if:jabatan_id,2,3,4,5', 'nullable', 'string'],
    ];

    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    try {
        // Set cabang to null if jabatan_id is 1 (Direksi)
        $cabang = $request->jabatan_id == 1 ? null : $request->cabang;

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'jabatan_id' => $request->jabatan_id,
            'cabang' => $cabang,
        ]);

        // Create specific role entry
        switch ($request->jabatan_id) {
            case 1: // Direksi
                Direksi::create([
                    'id_user' => $user->id,
                    'nama' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'cabang' => null, // Explicitly set cabang to null
                ]);
                break;
            case 2: // Pegawai Kepala Cabang
                PegawaiKepalaCabang::create([
                    'id_user' => $user->id,
                    'nama_kepala_cabang' => $request->name,
                    'id_jabatan' => $request->jabatan_id,
                    'cabang' => $request->cabang,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                break;
            case 3: // Pegawai Supervisor
                PegawaiSupervisor::create([
                    'id_user' => $user->id,
                    'nama_supervisor' => $request->name,
                    'id_jabatan' => $request->jabatan_id,
                    'cabang' => $request->cabang,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                break;
            case 4: // Pegawai Admin Kas
                PegawaiAdminKas::create([
                    'id_user' => $user->id,
                    'nama_admin_kas' => $request->name,
                    'id_jabatan' => $request->jabatan_id,
                    'cabang' => $request->cabang,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                break;
            case 5: // Pegawai Account Office
                PegawaiAccountOffice::create([
                    'id_user' => $user->id,
                    'nama_account_officer' => $request->name,
                    'id_jabatan' => $request->jabatan_id,
                    'cabang' => $request->cabang,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                break;
            default:
                break;
        }

        event(new Registered($user));
        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    } catch (\Exception $e) {
        \Log::error('Error creating user: ' . $e->getMessage(), ['exception' => $e]);
        return redirect()->back()->withErrors(['error' => 'Failed to create user: ' . $e->getMessage()])->withInput();
    }
}
}