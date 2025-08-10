<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    protected $table = 'fees';

    protected $fillable = [
        'name',
        'type',
        'amount',
        'description',
        'is_installment_available',
        'installment_amount',
        'installment_months',
    ];

    protected $casts = [
        'is_installment_available' => 'boolean',
        'amount' => 'float',
        'installment_amount' => 'float',
    ];

    /**
     * Relasi ke class_programs jika nanti diperlukan
     * Misalnya: satu fee bisa digunakan di banyak class_programs
     */
    public function classPrograms()
    {
        return $this->hasMany(ClassProgram::class, 'fee_id');
    }

    /**
     * Scope pencarian berdasarkan type
     */
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }
}
