<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassProgram extends Model
{
   protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
    ];

    // Relasi: banyak siswa mengikuti satu class_program (many-to-many)
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_classes')
                    ->withTimestamps()
                    ->withPivot('enrolled_at');
    }
}
