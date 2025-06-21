<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        // Rate limiting untuk mencegah brute force
        $this->ensureIsNotRateLimited($request);

        // Validasi input
        $credentials = $request->validate([
            'ni' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Cari user berdasarkan nomor induk
        $user = User::where('ni', $credentials['ni'])->first();

        // Jika user tidak ditemukan atau password salah
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            RateLimiter::hit($this->throttleKey($request));
            
            Log::warning('Login attempt failed', [
                'ni' => $credentials['ni'],
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            throw ValidationException::withMessages([
                'ni' => __('auth.failed'),
            ]);
        }

        // Jika akun dinonaktifkan
        if ($user->status === 'inactive') {
            Log::warning('Login attempt to inactive account', [
                'user_id' => $user->id,
                'ip' => $request->ip()
            ]);
            
            throw ValidationException::withMessages([
                'ni' => __('auth.inactive'),
            ]);
        }

        // Login sukses
        Auth::login($user, $request->remember);
        $request->session()->regenerate();
        
        RateLimiter::clear($this->throttleKey($request));

        Log::info('User logged in', [
            'user_id' => $user->id,
            'ip' => $request->ip()
        ]);

        // Redirect berdasarkan role
        return $this->authenticated($request, $user);
    }

    protected function authenticated(Request $request, $user)
    {
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'instructor':
                return redirect()->route('instructor.dashboard');
            case 'student':
                return redirect()->route('siswa.dashboard');
            default:
                return redirect()->intended('/');
        }
    }

    protected function ensureIsNotRateLimited(Request $request)
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey($request));

        throw ValidationException::withMessages([
            'ni' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    protected function throttleKey(Request $request)
    {
        return Str::transliterate(Str::lower($request->ni).'|'.$request->ip());
    }
}