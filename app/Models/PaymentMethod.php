<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_name',
        'account_number',
        'account_name',
        'type',
    ];
    
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get payment methods by type
     */
    public static function getByType($type)
    {
        return self::where('type', $type)->get();
    }

    /**
     * Get bank transfer methods
     */
    public static function getBankMethods()
    {
        return self::where('type', 'bank_transfer')->get();
    }

    /**
     * Get e-wallet methods
     */
    public static function getEwalletMethods()
    {
        return self::where('type', 'ewallet')->get();
    }

    /**
     * Get method by bank name
     */
    public static function getByBankName($bankName)
    {
        return self::where('bank_name', strtoupper($bankName))->first();
    }
}