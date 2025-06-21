<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SiswaUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Budi Santoso',
            'ni' => '1234567890', // 10 digit angka
            'password' => Hash::make('pkl2025'),
            'role' => 'student',
            'status' => 'active',
            'jurusan' => 'Teknik Komputer dan Jaringan',
            'dudi' => 'PT. Digital Nusantara',
            'pembimbing' => 'Ibu Siti Aminah'
        ]);

        $this->command->info('Akun siswa berhasil dibuat!');
        $this->command->info('Nomor Induk: 1234567890');
        $this->command->info('Password: pkl2025');
    }
}