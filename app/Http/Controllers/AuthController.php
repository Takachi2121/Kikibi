<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login(Request $request){
        $email = $request->input('emailUser');
        $password = $request->input('passwordUser');

        $user = User::where('email', $email)->first();

        if(!$user) {
            return redirect()->back()->withInput()->with('error', 'User Tidak Ditemukan');
        }

        if($user && Hash::check($password, $user->password) && $user->role == 'user'){
            Auth::login($user);
            return redirect()->route('home');
        }else if($user && Hash::check($password, $user->password) && $user->role == 'admin'){
            Auth::login($user);
            return redirect()->route('admin-dashboard');
        }else{
            return redirect()->back()->withInput()->with('error', 'Email atau Password Salah');
        }
    }

    public function register(RegisterRequest $request){
        $otp = rand(100000, 999999);

        $sessionData = [
            'nama_lengkap' => $request->namaUser,
            'email' => $request->emailUser,
            'telp' => $request->telpUser,
            'password' => $request->passwordUser,
            'otp' => $otp,
            'created_at' => Carbon::now()
        ];

        Session::put('registerKikibi', $sessionData);

        Mail::send('email.verify-email', [
            'user_name' => $sessionData['nama_lengkap'],
            'otp' => $otp
        ], function($msg) use ($request) {
            $msg->to($request->emailUser)->subject('Verifikasi Akun Kikibi');
        });

        return response()->json([
            'success' => true,
            'message' => 'OTP Telah Dikirimkan, Silahkan Cek Email Anda'
        ]);
    }

    public function verify(Request $request){
        $otp = $request->otp;
        $sessionData = Session::get('registerKikibi');

        if(!$sessionData) {
            return response()->json([
                'success' => false,
                'message' => 'OTP sudah kadaluarsa. Silakan daftar ulang!'
            ]);
        }

        if (now()->diffInMinutes($sessionData['created_at']) > 10) {
            Session::forget('pending_user');
            Session::forget('pending_mitra');
            return response()->json([
                'success' => false,
                'message' => 'OTP sudah kadaluarsa. Silakan daftar ulang!'
            ]);
        }

        // cek OTP
        if ($request->otp != $sessionData['otp']) {
            return response()->json([
                'success' => false,
                'message' => 'OTP salah!'
            ]);
        }

        $wa = $sessionData['telp'];

        // buang spasi, strip, dll
        $wa = preg_replace('/[^0-9+]/', '', $wa);

        // kalau diawali +62 → buang +
        if (str_starts_with($wa, '+62')) {
            $wa = substr($wa, 1);
        }

        // kalau diawali 08 → ganti jadi 628
        if (str_starts_with($wa, '08')) {
            $wa = '628' . substr($wa, 2);
        }

        $user = User::create([
            'nama_lengkap'      => $sessionData['nama_lengkap'],
            'email'     => $sessionData['email'],
            'password'  => Hash::make($sessionData['password']),
            'role'      => 'user',
            'no_telp'   => $wa
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Registrasi Berhasil',
            'redirect' => route('login')
        ]);
    }

    public function logout(){
        Auth::guard('web')->logout();
        Session::flush();
        return redirect()->route('home');
    }

    public function updateProfile(Request $request){
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'no_telp' => 'required|string',
            'password' => 'required|string|min:6',
        ],[
            'nama_lengkap.required' => 'Nama lengkap harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'no_telp.required' => 'Nomor telepon harus diisi',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        $user = Auth::user();

        if(!Hash::check($request->password, $user->password)){
            return response()->json([
                'success' => false,
                'errors' => ['password' => ['Password tidak sesuai']]
            ], 422);
        }

        $user->nama_lengkap = $request->nama_lengkap;
        $user->email = $request->email;
        if (substr($request->no_telp, 0, 2) == '0') {
            $user->no_telp = '62' . substr($request->no_telp, 2);
        } elseif (substr($request->no_telp, 0, 2) == '62') {
            $user->no_telp = $request->no_telp;
        } else {
            $user->no_telp = '62' . substr($request->no_telp, 2);
        }

        $user->update();

        return response()->json([
            'success' => true,
            'message' => 'Profile berhasil diperbarui'
        ]);
    }

    public function updatePass(Request $request){
        $request->validate([
            'current_password' => 'required|string|min:6',
            'password_new' => 'required|string|min:6|confirmed',
        ],[
            'current_password.required' => 'Password lama harus diisi',
            'current_password.min' => 'Password lama minimal 6 karakter',
            'password_new.required' => 'Password baru harus diisi',
            'password_new.min' => 'Password baru minimal 6 karakter',
            'password_new.confirmed' => 'Password baru harus sama dengan konfirmasi password',
        ]);

        $user = Auth::user();

        if(!Hash::check($request->current_password, $user->password)){
            return response()->json([
                'success' => false,
                'errors' => ['current_password' => ['Password lama tidak sesuai']]
            ], 422);
        }

        $user->password = Hash::make($request->password_new);
        $user->update();

        Auth::logout();
        Session::flush();

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diperbarui',
            'redirect' => route('login')
        ]);
    }
}
