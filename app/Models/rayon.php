<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rayon extends Model
{
    use HasFactory;

    protected $fillable = [
        'rayon',
        'user_id',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function student() {
        return $this->hasMany(Student::class, 'id', 'rayon_id');
    }
}
