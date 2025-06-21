<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'ni',
        'password',
        'jurusan',
        'dudi',
        'pembimbing',
        'role',
        'status',
        'last_login_at',
        'last_login_ip'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'last_login_at' => 'datetime'
    ];

    // Relasi dengan assessments
    public function assessments()
    {
        return $this->hasMany(Assessment::class, 'student_id');
    }


    // Scope untuk DUDI
    public function scopeDudi($query, $dudiName)
    {
        return $query->where('dudi', $dudiName);
    }

    // Cek apakah user adalah pembimbing
    public function isPembimbing()
    {
        return $this->role === 'instructor' || $this->role === 'admin';
    }
}