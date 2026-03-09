<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return redirect()->route('hotspot.packages');
});

// Hotspot Web User Flow (Using layout.hotspot.blade.php)
Route::middleware('web')->group(function () {
    Volt::route('/hotspot/packages', 'hotspot.package-list')
        ->name('hotspot.packages');

    Volt::route('/hotspot/pay/{package_id}', 'hotspot.mpesa-payment-form')
        ->name('hotspot.payment');

    Volt::route('/hotspot/success/{code}', 'hotspot.voucher-success')
        ->name('hotspot.success');

    Volt::route('/hotspot/status', 'hotspot.user-status')
        ->name('hotspot.status');
});

// Mpesa Callbacks (Daraja legacy, if any)
Route::post('/api/mpesa/callback', [App\Services\MpesaService::class, 'callback'])->name('api.mpesa.callback');

// Snippe Webhook Callback
Route::post('/webhook/snippe', [\App\Http\Controllers\SnippeWebhookController::class, 'handle'])->name('webhook.snippe');

// Admin Routes protected by Breeze Auth
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', \App\Livewire\Admin\Dashboard::class)->name('dashboard');
    Route::get('/packages', \App\Livewire\Admin\PackagesIndex::class)->name('packages');
    Route::get('/vouchers', \App\Livewire\Admin\VouchersIndex::class)->name('vouchers');
    Route::get('/payments', \App\Livewire\Admin\PaymentsIndex::class)->name('payments');
    Route::get('/routers', \App\Livewire\Admin\RoutersIndex::class)->name('routers');
    Route::get('/live-users', \App\Livewire\Admin\LiveUsers::class)->name('live-users');
    Route::get('/reports', \App\Livewire\Admin\ReportsIndex::class)->name('reports');
    Route::get('/settings', \App\Livewire\Admin\SettingsForm::class)->name('settings');
    Route::get('/logs', \App\Livewire\Admin\LogsIndex::class)->name('logs');
});

// Let Breeze take over /login and other auth endpoints.
require __DIR__.'/auth.php';
