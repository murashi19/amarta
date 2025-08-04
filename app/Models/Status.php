<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = ['name', 'description'];

    // Relasi: satu status dimiliki banyak user
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
