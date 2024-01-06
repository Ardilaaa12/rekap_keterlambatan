<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rombel extends Model
{
    use HasFactory;

    // apa aja yang bisa diisi user
    protected $fillable = [
        'rombel',
    ];

    public function student() {
        return $this->hasMany(Student::class,  'id', 'rombel_id');
    }
}
