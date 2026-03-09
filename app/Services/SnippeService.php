<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SnippeService
{
    protected string $apiKey;
    protected string $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('SNIPPE_API_KEY');
        $this->baseUrl = env('SNIPPE_API_URL', 'https://api.snippe.sh/v1');
    }

    /**
     * Tuma ombi (Request) ya Push (USSD) kwenda kwa namba ya Mteja
     */
    public function initiateMobileMoneyPush($phone, $amount, $reference, $description = 'Malipo ya WiFi (Kifurushi)')
    {
        // Format namba (Mfano 0754... iwe 255754...)
        $phoneStr = $phone;
        if (str_starts_with($phoneStr, '0')) {
            $phoneStr = '255' . substr($phoneStr, 1);
        }

        try {
            $response = Http::withToken($this->apiKey)
                ->withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])
                ->post($this->baseUrl . '/payments', [
                    // Mfumo kamili wa JSON kulingana na API. Note: Hii array inaweza
                    // kuhitaji kurekebishwa kidogo kuendana na "keys" zao kamili endapo 
                    // haziko exactly hivi (mf. payment_method => 'mobile_money').
                    'amount' => $amount,
                    'currency' => 'TZS',
                    'reference' => $reference,
                    'description' => $description,
                    'method' => 'mobile_money', 
                    'customer' => [
                        'phone' => $phoneStr,
                        'name' => 'Mteja WiFi', // Placeholder
                    ],
                    'webhook_url' => route('webhook.snippe'), 
                ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Snippe API Payment Failed:', [
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            return ['success' => false, 'message' => 'Njia ya malipo (API) inasumbua kwa sasa.'];

        } catch (\Exception $e) {
            Log::error('Snippe API Error: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Hitilafu kwenye kutuma STK Push.'];
        }
    }
}
