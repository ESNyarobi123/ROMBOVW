<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Router extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'ip',
        'username',
        'password',
        'port',
        'is_active',
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Automatically encrypt the router password before database insertion
     * and decrypt it automatically when we fetch it.
     */
    protected function password(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value ? decrypt($value) : null,
            set: fn (string $value) => encrypt($value),
        );
    }
}
