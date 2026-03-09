<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'mpesa_receipt',
        'amount',
        'phone',
        'mac_address',
        'voucher_id',
        'package_id',
        'status',
        'callback_data',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'callback_data' => 'array',
        ];
    }

    /**
     * Payment belongs to a voucher.
     */
    public function voucher(): BelongsTo
    {
        return $this->belongsTo(Voucher::class);
    }
}
