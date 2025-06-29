<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    // Password yang di-hardcode
    private $accessPassword = '$2y$12$9gTVXz5.B4GoqLdX7U2P2.DoGyx5Ve9fWlTsxXR6fiwKk1N1vYpYy';

    public function showUploadForm(Request $request)
    {
        return view('admin.management-siswa');
    }

    public function verifyAccess(Request $request)
    {
        $request->validate([
            'access_password' => 'required|string',
        ]);

        if (Hash::check($request->access_password, $this->accessPassword)) {
            session(['authenticated' => true]);
            return redirect()->route('admin.user-upload')->with('success', 'Autentikasi berhasil!');
        }

        return back()->with('error', 'Password akses salah!');
    }

    public function uploadUsersAjax(Request $request)
{
    if (!session('authenticated')) {
        return response()->json([
            'success' => false,
            'message' => 'Silakan verifikasi password akses terlebih dahulu.'
        ], 403);
    }

    $validator = Validator::make($request->all(), [
        'data' => 'required|array',
        'data.*.name' => 'required|string|max:255',
        'data.*.ni' => 'required|string|max:255|unique:users,ni',
        'data.*.password' => 'required|string|min:8',
        'data.*.role' => 'required|in:student,instructor,admin',
        'data.*.jurusan' => 'required|string|max:255', // Diubah menjadi required
        'data.*.dudi' => 'nullable|string|max:255',
        'data.*.pembimbing' => 'nullable|string|max:255', // Tetap sebagai string
        'data.*.status' => 'sometimes|string|in:active,inactive'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Validasi gagal',
            'errors' => $validator->errors()->all()
        ], 422);
    }

    $successCount = 0;
    $errorMessages = [];

    foreach ($request->data as $item) {
        try {
            // Validasi format password bcrypt
            if (!preg_match('/^\$2[abzy]\$\d{1,2}\$[.\/A-Za-z0-9]{53}$/', $item['password'])) {
                $errorMessages[] = "Password untuk {$item['name']} bukan format bcrypt valid";
                continue;
            }

            // Pastikan jurusan tidak null
            if (empty($item['jurusan'])) {
                $errorMessages[] = "Jurusan wajib diisi untuk siswa {$item['name']}";
                continue;
            }

            // Ubah mapping role menjadi:
            $role = match(strtolower($item['role'])) {
                'student' => 'student', // Jangan ubah menjadi 'siswa'
                'instructor' => 'instructor',
                'admin' => 'admin',
                default => strtolower($item['role'])
            };

            User::create([
                'name' => $item['name'],
                'ni' => $item['ni'],
                'password' => $item['password'],
                'jurusan' => $item['jurusan'], // Wajib ada
                'dudi' => $item['dudi'] ?? null,
                'pembimbing' => $item['pembimbing'], // Simpan sebagai string langsung
                'role' => $role,
                'status' => $item['status'] ?? 'active',
            ]);

            $successCount++;
        } catch (\Exception $e) {
            // Di blok catch AdminController.php
            $errorMessages[] = "Error pada user {$item['name']}: " . $e->getMessage() . 
                            " | Data: " . json_encode($item);
            Log::error("Error creating user {$item['name']}: " . $e->getMessage());
        }
    }

    return response()->json([
        'success' => $successCount > 0,
        'inserted' => $successCount,
        'errors' => $errorMessages,
        'message' => $successCount > 0 
            ? "Berhasil menambahkan $successCount user baru" 
            : "Gagal menambahkan user"
    ]);
}
}