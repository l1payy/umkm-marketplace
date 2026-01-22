<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Services\PaymentGatewayService;

class PaymentWebhookController extends Controller
{
    public function handle(Request $request, PaymentGatewayService $gateway)
    {
        $raw = $request->getContent();
        $sig = $request->header('X-Signature');
        $verified = $gateway->verifyWebhook($raw, $sig);
        abort_unless($verified['valid'], 401);

        $data = $verified['data'];
        $reference = (string)($data['reference'] ?? '');
        $status = (string)($data['status'] ?? '');
        $payment = Payment::where('reference', $reference)->first();
        abort_unless($payment, 404);
        $order = Order::find($payment->order_id);
        abort_unless($order, 404);

        if ($status === 'paid') {
            $payment->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);
            $order->update(['status' => 'completed']);
            $gateway->generateInvoice($order, $payment->reference);
        } elseif (in_array($status, ['failed','expired','canceled'])) {
            $payment->update(['status' => 'failed']);
            $order->update(['status' => 'failed']);
        }

        return response()->json(['ok' => true]);
    }
}
