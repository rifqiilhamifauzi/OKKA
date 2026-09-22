<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Send a WhatsApp message using Fonnte API.
     *
     * @param string $phone
     * @param string $message
     * @return bool
     */
    public static function sendMessage($phone, $message)
    {
        $url = env('WA_GATEWAY_URL', 'https://api-wa.uinsgd.net/api/send-message');
        $apiKey = env('WA_GATEWAY_API_KEY');
        $senderId = env('WA_GATEWAY_SENDER_ID', 'OKKA');

        if (empty($apiKey)) {
            Log::warning('WA Gateway API Key is not set. WhatsApp message not sent.');
            return false;
        }

        // Format phone number to Indonesian format if it starts with 0
        $formattedPhone = self::formatPhoneNumber($phone);

        try {
            $response = Http::withHeaders([
                'X-API-Key' => $apiKey,
                'Content-Type' => 'application/json'
            ])->post($url, [
                'sender_id' => $senderId,
                'number' => $formattedPhone,
                'message' => $message,
            ]);

            if ($response->successful()) {
                $responseBody = json_decode($response->body());
                // The gateway typically returns status true or similar on success
                if (isset($responseBody->status) && $responseBody->status === true) {
                    return true;
                }
                // Even if we don't know the exact success format, a 200 OK is a good sign
                return true;
            }

            Log::error('WA Gateway API Error: ' . $response->body());
            return false;

        } catch (\Exception $e) {
            Log::error('WA Gateway Connection Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Format phone number to start with 62 or +62 (Fonnte expects 628...)
     * 
     * @param string $phone
     * @return string
     */
    private static function formatPhoneNumber($phone)
    {
        // Remove non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Replace leading 0 with 62
        if (substr($phone, 0, 1) == '0') {
            $phone = '62' . substr($phone, 1);
        }

        return $phone;
    }
}
