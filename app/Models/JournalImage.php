<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalImage extends Model
{
    use HasFactory;

    protected $fillable = ['journal_id', 'image_path'];

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image_path);
    }
}