<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return redirect()->route('hotspot.packages');
});

// Hotspot Web User Flow
Route::middleware('web')->group(function () {
    // 1 & 2. Package Selection (Welcome)
    Volt::route('/hotspot/packages', 'hotspot.⚡package-list')->name('hotspot.packages');

    // 3. Payment Page
    Volt::route('/hotspot/pay/{package_id}', 'hotspot.⚡mpesa-payment-form')->name('hotspot.payment');

    // 4. Success / Voucher Display
    Volt::route('/hotspot/success/{code}', 'hotspot.⚡voucher-success')->name('hotspot.success');

    // 5. User Connected Status
    Volt::route('/hotspot/status', 'hotspot.⚡user-status')->name('hotspot.status');
});

// Mpesa Callbacks
Route::post('/api/mpesa/callback', [App\Services\MpesaService::class, 'callback'])->name('api.mpesa.callback');
