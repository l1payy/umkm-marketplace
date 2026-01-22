<?php

namespace App\Services;

use App\Models\Order;

class PaymentGatewayService
{
    public function createTransaction(Order $order, string $method, string $provider): array
    {
        $reference = 'INV-'.$order->id.'-'.now()->format('YmdHis');
        $va = null;
        $qris = null;
        if ($method === 'bank_transfer') {
            $prefix = match ($provider) {
                'BCA' => '686',
                'Mandiri' => '896',
                'BNI' => '988',
                'BRI' => '888',
                default => '999',
            };
            $va = $prefix.str_pad((string)$order->id, 10, '0', STR_PAD_LEFT);
        } elseif ($method === 'qris') {
            $qris = 'QRIS|ORDER#'.$order->id.'|AMOUNT='.$order->total.'|REF='.$reference;
        }
        return [
            'reference' => $reference,
            'va_number' => $va,
            'qris_payload' => $qris,
            'expires_at' => now()->addMinutes(30),
        ];
    }

    public function verifyWebhook(string $payload, ?string $signature): array
    {
        $secret = env('PAYMENT_WEBHOOK_SECRET', 'secret');
        $expected = hash_hmac('sha256', $payload, $secret);
        $valid = hash_equals($expected, (string) $signature);
        $data = json_decode($payload, true) ?: [];
        return ['valid' => $valid, 'data' => $data];
    }

    public function generateInvoice(Order $order, string $reference): string
    {
        return $reference;
    }
}
