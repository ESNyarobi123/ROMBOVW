<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'package_id',
        'mac_address',
        'ip_address',
        'expires_at',
        'status',
        'phone',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
        ];
    }

    // Auto-generate code if not provided
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($voucher) {
            if (empty($voucher->code)) {
                $voucher->code = strtoupper(Str::random(6)); // Example: XA9K2L
            }
        });
    }

    /**
     * Voucher belongs to a specific ISP package.
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    /**
     * Voucher has one payment associated.
     */
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Check if the voucher time has exceeded
     */
    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }
}
