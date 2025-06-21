<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('siswa.profile', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        // First validate the basic fields
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'confirmed'],
        ]);

        // Check if current password is valid (sama seperti di loginController)
        if (strlen($user->password) < 60 || !str_starts_with($user->password, '$2y$')) {
            return back()->withErrors([
                'current_password' => 'Password tidak valid. Silakan reset password Anda.',
            ]);
        }

        // Verify current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Password saat ini tidak valid.',
            ]);
        }

        // Validate new password strength
        $request->validate([
            'new_password' => [
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
        ]);

        // Update the password - langsung bcrypt sebelum disimpan
        $user->password = bcrypt($request->new_password);
        $user->save();

        return back()->with('success', 'Password berhasil diperbarui!');
    }
}