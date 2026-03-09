<?php

namespace App\Console\Commands;

use App\Models\Voucher;
use App\Services\MikrotikService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CleanupVouchers extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'vouchers:cleanup';

    /**
     * The console command description.
     */
    protected $description = 'Check for expired vouchers and disconnect users from MikroTik';

    /**
     * Execute the console command.
     */
    public function handle(MikrotikService $mikrotik)
    {
        $this->info('Starting Voucher Cleanup Process...');

        // 1. Find vouchers that have expired but are still marked as active
        $expiredVouchers = Voucher::where('status', 'active')
            ->where('expires_at', '<=', Carbon::now())
            ->get();

        if ($expiredVouchers->isEmpty()) {
            $this->info('Hakuna Vouchers zilizoisha muda wake kwa sasa.');
            return;
        }

        foreach ($expiredVouchers as $voucher) {
            $this->warn("Broadcasting expiry for: {$voucher->code}");
            
            try {
                // Disconnect from MikroTik active sessions
                $mikrotik->forceDisconnect($voucher->code);
                
                // Remove the user from MikroTik entirely
                $mikrotik->disconnectUser($voucher->code);
                
                // Update status in local database
                $voucher->update(['status' => 'expired']);
                
                $this->info("Kukamilisha Expiry ya: {$voucher->code}");
            } catch (\Exception $e) {
                $this->error("Hitilafu kwa Voucher {$voucher->code}: " . $e->getMessage());
                Log::error("Voucher Cleanup Error: " . $e->getMessage());
            }
        }

        $this->info('Zoezi la kusafisha Vouchers limekamilika.');
    }
}
