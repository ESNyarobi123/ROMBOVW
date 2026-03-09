<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'time_limit', // Stored in minutes
        'bytes_limit', // Stored in bytes (nullable for unlimited)
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    /**
     * A package can have multiple vouchers.
     */
    public function vouchers(): HasMany
    {
        return $this->hasMany(Voucher::class);
    }
}
