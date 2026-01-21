<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function show(Order $order)
    {
        abort_unless($order->user_id === Auth::id(), 403);
        return view('payments.pay', compact('order'));
    }

    public function start(Order $order, Request $request)
    {
        abort_unless($order->user_id === Auth::id(), 403);
        $validated = $request->validate([
            'method' => ['required','in:bank_transfer,e_wallet,qris'],
            'provider' => ['required','string'],
        ]);

        $payment = Payment::create([
            'order_id' => $order->id,
            'method' => $validated['method'],
            'provider' => $validated['provider'],
            'amount' => $order->total,
            'status' => 'pending',
            'va_number' => $validated['method'] === 'bank_transfer' ? $this->generateVa($validated['provider'], $order->id) : null,
            'qris_payload' => $validated['method'] === 'qris' ? $this->generateQrisPayload($order) : null,
            'reference' => 'INV-'.$order->id.'-'.now()->format('YmdHis'),
        ]);

        return redirect()->route('payments.confirm', [$order, $payment]);
    }

    public function confirm(Order $order, Payment $payment)
    {
        abort_unless($order->user_id === Auth::id(), 403);
        abort_unless($payment->order_id === $order->id, 404);
        return view('payments.confirm', compact('order','payment'));
    }

    public function complete(Order $order, Payment $payment)
    {
        abort_unless($order->user_id === Auth::id(), 403);
        abort_unless($payment->order_id === $order->id, 404);

        $payment->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);
        $order->update(['status' => 'completed']);

        return redirect()->route('orders.receipt', $order)->with('status', 'Pembayaran berhasil');
    }

    public function receipt(Order $order)
    {
        abort_unless($order->user_id === Auth::id(), 403);
        $payment = Payment::where('order_id', $order->id)->latest()->first();
        return view('orders.receipt', compact('order','payment'));
    }

    private function generateVa(string $provider, int $orderId): string
    {
        $prefix = match ($provider) {
            'BCA' => '686',
            'Mandiri' => '896',
            'BNI' => '988',
            'BRI' => '888',
            default => '999',
        };
        return $prefix.str_pad((string)$orderId, 10, '0', STR_PAD_LEFT);
    }

    private function generateQrisPayload(Order $order): string
    {
        return 'QRIS|ORDER#'.$order->id.'|AMOUNT='.$order->total;
    }
}
