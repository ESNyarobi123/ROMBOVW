<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MpesaService
{
    protected string $consumerKey;
    protected string $consumerSecret;
    protected string $shortcode;
    protected string $passkey;
    protected string $env;

    public function __construct()
    {
        $this->consumerKey = config('services.mpesa.consumer_key', env('MPESA_CONSUMER_KEY', ''));
        $this->consumerSecret = config('services.mpesa.consumer_secret', env('MPESA_CONSUMER_SECRET', ''));
        $this->shortcode = config('services.mpesa.shortcode', env('MPESA_SHORTCODE', ''));
        $this->passkey = config('services.mpesa.passkey', env('MPESA_PASSKEY', ''));
        $this->env = config('services.mpesa.env', env('MPESA_ENV', 'sandbox'));
    }

    /**
     * Determine the base URL depending on the environment
     */
    protected function getBaseUrl(): string
    {
        return $this->env === 'sandbox'
            ? 'https://sandbox.safaricom.co.ke'
            : 'https://api.safaricom.co.ke';
    }

    /**
     * Get OAuth token for API consumption
     */
    public function getAccessToken(): ?string
    {
        try {
            $url = $this->getBaseUrl() . '/oauth/v1/generate?grant_type=client_credentials';

            $response = Http::withBasicAuth($this->consumerKey, $this->consumerSecret)
                ->get($url);

            if ($response->successful()) {
                return $response->json('access_token');
            }

            Log::error('M-Pesa Token Error: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('M-Pesa Token Exception: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Initiate STK Push
     */
    public function stkPush(string $phoneNumber, float $amount, string $reference, string $description): array
    {
        $token = $this->getAccessToken();
        if (!$token) {
            return ['status' => false, 'message' => 'Hatuwezi kuunganishwa na M-Pesa kwa sasa.'];
        }

        // Must be in 254... or 255... format depending on integration, usually Safaricom is 254
        // Let's assume passed phone number is correctly formatted before reaching here.
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
        
        $url = $this->getBaseUrl() . '/mpesa/stkpush/v1/processrequest';
        $timestamp = date('YmdHis');
        $password = base64_encode($this->shortcode . $this->passkey . $timestamp);

        try {
            $response = Http::withToken($token)
                ->post($url, [
                    'BusinessShortCode' => $this->shortcode,
                    'Password' => $password,
                    'Timestamp' => $timestamp,
                    'TransactionType' => 'CustomerPayBillOnline',
                    'Amount' => round($amount),
                    'PartyA' => $phoneNumber,
                    'PartyB' => $this->shortcode,
                    'PhoneNumber' => $phoneNumber,
                    'CallBackURL' => route('api.mpesa.callback'),
                    'AccountReference' => $reference,
                    'TransactionDesc' => substr($description, 0, 13) // max 13 chars
                ]);

            if ($response->successful()) {
                return [
                    'status' => true,
                    'data' => $response->json(),
                    'message' => 'Tafadhali weka namba yako ya siri kwenye simu yako kulipa.'
                ];
            }

            Log::error('M-Pesa STK Push Error: ' . $response->body());
            return ['status' => false, 'message' => 'Kuna tatizo wakati wa kutuma ombi kwa M-Pesa.'];
        } catch (\Exception $e) {
            Log::error('M-Pesa STK Push Exception: ' . $e->getMessage());
            return ['status' => false, 'message' => 'Hitilafu kwenye mfumo wa malipo.'];
        }
    }
}
