<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class SettingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('admin.setting', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'confirmed', Password::min(8)
                ->mixedCase()
                ->numbers()
                ->symbols()],
        ]);

        if (strlen($user->password) < 60 || !str_starts_with($user->password, '$2y$')) {
            return back()->withErrors([
                'current_password' => 'Password tidak valid. Silakan reset password Anda.',
            ]);
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Password saat ini tidak valid.',
            ]);
        }

        $user->password = bcrypt($request->new_password);
        $user->save();

        return back()->with('success', 'Password berhasil diperbarui!');
    }
}