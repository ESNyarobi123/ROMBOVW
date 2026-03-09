<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Voucher;
use App\Models\Package;
use App\Services\MikrotikService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SnippeWebhookController extends Controller
{
    /**
     * Inapokea (POST) Callback kutoka Snippe baada ya malipo kukamilika/kufeli.
     */
    public function handle(Request $request, \App\Services\MikrotikService $mikrotik)
    {
        Log::info('SNIPPE WEBHOOK RECEIVED: ', $request->all());

        // Hapa utabinafsisha 'keys' za payload inategemeana na API Doc.
        // Haya ni makadirio (standard structure) kama status ipo:
        $payload = $request->all();
        
        $status = $payload['status'] ?? null;
        $reference = $payload['reference'] ?? null; 
        // Let's also check event type, some APIs use "event" = "payment.completed"
        $event = $payload['event'] ?? '';

        if (!$reference) {
            return response()->json(['error' => 'No reference provided'], 400);
        }

        if ($status === 'completed' || $status === 'successful' || $event === 'payment.completed') {
            
            // 1. Pata Rekodi ya Payment database (ambayo ipo 'pending')
            $payment = Payment::where('mpesa_receipt', $reference) // we use mpesa_receipt field to store REF temporarily
                               ->orWhere('id', $reference) // fallback
                               ->first();

            if (!$payment) {
                // Kama hakuna rekodi, labda imechelewa kutengenezwa? Update log
                Log::warning('Payment record not found for webhook reference: ' . $reference);
                return response()->json(['success' => true]); 
            }

            if ($payment->status === 'completed') {
                return response()->json(['success' => true]); // Tushamaliza kale
            }

            // 2. Mark Payment 'COMPLETED'
            $payment->update([
                'status' => 'completed',
                // optionally we can save actual receipt given by Snippe
                // 'mpesa_receipt' => $payload['transaction_id'] ?? $reference,
            ]);

            // 3. Toa Voucher sasa
            $package = Package::find($payment->package_id);
            if ($package) {
                $code = strtoupper(Str::random(6)); // Code fupi na nzuri 
                $macAddress = $payment->mac_address ?? session()->get('mac_address'); // kama ilisave session
                
                $voucher = Voucher::create([
                    'package_id' => $package->id,
                    'code' => $code,
                    'phone' => $payment->phone,
                    'mac_address' => $macAddress,
                    'status' => 'active',
                    // Time computation could also start *after* they login (first use),
                    // but depending on setup, we might start it immediately upon purchase:
                    'expires_at' => Carbon::now()->addMinutes($package->time_limit),
                ]);

                // 4. Mweke Mteja kwenye MikroTik Moja Kwa Moja
                if ($macAddress) {
                    try {
                        // Convert minutes to MikroTik time format (e.g. 60 -> 01:00:00)
                        $uptimeLimit = \App\Services\MikrotikService::formatUptime($package->time_limit);
                        
                        // We use the voucher code as both username and password for simplicity, 
                        // bound to the user's MAC address.
                        $mikrotik->addHotspotUser(
                            $voucher->code, 
                            $macAddress, 
                            $uptimeLimit,
                            null, // bytes
                            'default'
                        );
                        
                        Log::info("MikroTik User Added Successfully: " . $voucher->code);
                    } catch (\Exception $e) {
                        Log::error("Failed to add user to MikroTik after payment: " . $e->getMessage());
                        // Even if router fails, voucher is still in DB for manual fix
                    }
                }

                // Tumia hii kumjuvisha mtu wa Livewire Polling afungue mlango!
                // Kuweka session hakufanyi kazi kwenye webhooks manake zinaingia kama Server
                // Badala yake, Status kwenye Database kuwa "completed" ndo signal ya Livewire
            }
        } 
        elseif ($status === 'failed' || $event === 'payment.failed') {
            // Mark Payment Failed
            Payment::where('mpesa_receipt', $reference)->update(['status' => 'failed']);
        }

        // Must respond HTTP 200 OK so Snippe Knows you received it
        return response()->json(['success' => true]);
    }
}
