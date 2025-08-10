<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Status extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description'];

    // Relasi: satu status dimiliki banyak user
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
