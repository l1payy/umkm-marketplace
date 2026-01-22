<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\PaymentGatewayService;

class PaymentController extends Controller
{
    private ?int $selectedSellerPayoutId = null;
    public function show(Order $order)
    {
        abort_unless($order->user_id === Auth::id(), 403);
        return view('payments.pay', compact('order'));
    }

    public function start(Order $order, Request $request, PaymentGatewayService $gateway)
    {
        abort_unless($order->user_id === Auth::id(), 403);
        $validated = $request->validate([
            'method' => ['required','in:bank_transfer,e_wallet,qris'],
            'provider' => ['required','string'],
        ]);

        $sellerId = $this->resolveSellerId($order);
        abort_unless($sellerId !== null, 422, 'Pesanan harus berasal dari satu penjual');
        $seller = \App\Models\User::find($sellerId);
        [$method, $provider] = $this->enforceSellerPayment($seller, $validated['method'], $validated['provider']);
        $tx = $gateway->createTransaction($order, $method, $provider);
        $payment = Payment::create([
            'order_id' => $order->id,
            'seller_payout_id' => $this->selectedSellerPayoutId ?? null,
            'method' => $method,
            'provider' => $provider,
            'amount' => $order->total,
            'status' => 'pending',
            'va_number' => $tx['va_number'] ?? null,
            'qris_payload' => $tx['qris_payload'] ?? null,
            'reference' => $tx['reference'] ?? ('INV-'.$order->id.'-'.now()->format('YmdHis')),
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

    private function generateQrisPayload(Order $order): string { return ''; }

    private function resolveSellerId(Order $order): ?int
    {
        $sellerIds = [];
        foreach ($order->items as $item) {
            if ($item->product_id) {
                $sellerIds[] = optional(\App\Models\Product::find($item->product_id))->user_id;
            } elseif ($item->offer_id) {
                $sellerIds[] = optional(\App\Models\Offer::find($item->offer_id))->user_id;
            }
        }
        $sellerIds = collect($sellerIds)->filter()->unique();
        return $sellerIds->count() === 1 ? $sellerIds->first() : null;
    }

    private function enforceSellerPayment($seller, string $method, string $provider): array
    {
        $typeMap = [
            'bank_transfer' => 'bank',
            'e_wallet' => 'ewallet',
            'qris' => 'qris',
        ];
        $type = $typeMap[$method] ?? null;
        abort_unless($type !== null, 422, 'Metode tidak didukung');
        $payouts = $seller ? $seller->payouts()->where('type', $type)->get() : collect();
        abort_unless($payouts->isNotEmpty(), 422, 'Penjual tidak menerima metode ini');
        if (!$provider) {
            $provider = optional($payouts->first())->provider;
        }
        abort_unless($payouts->contains(fn($p) => strcasecmp($p->provider, $provider) === 0), 422, 'Provider tidak tersedia untuk penjual');
        $selected = $payouts->first(fn($p) => strcasecmp($p->provider, $provider) === 0);
        $this->selectedSellerPayoutId = optional($selected)->id;
        return [$method, $provider];
    }
}
