<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserClass extends Pivot
{
    protected $table = 'user_classes';

    protected $fillable = [
        'user_id',
        'class_program_id',
        'enrolled_at',
    ];
}

