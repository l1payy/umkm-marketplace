<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-900 leading-tight">Konfirmasi Pembayaran #{{ $order->id }}</h2>
            <div class="text-sm font-semibold bg-emerald-50 text-emerald-700 px-3 py-1 rounded">Total Rp {{ number_format($order->total) }}</div>
        </div>
    </x-slot>
    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white rounded-xl shadow ring-1 ring-gray-100 p-6">
                <div class="text-sm text-gray-600">Metode: {{ strtoupper($payment->method) }} — {{ $payment->provider }}</div>
                @if($payment->method === 'bank_transfer')
                    <div class="mt-3">
                        <div class="text-sm">Virtual Account</div>
                        <div class="text-2xl font-bold">{{ $payment->va_number }}</div>
                        <p class="mt-2 text-sm text-gray-600">Silakan transfer sesuai total. Setelah pembayaran, klik tombol Konfirmasi.</p>
                    </div>
                @elseif($payment->method === 'qris')
                    <div class="mt-3">
                        <div class="text-sm">QRIS</div>
                        <img class="mt-2 w-40 h-40 object-contain" src="https://api.qrserver.com/v1/create-qr-code/?size=240x240&data={{ urlencode($payment->qris_payload) }}" alt="QRIS">
                        <p class="mt-2 text-sm text-gray-600">Scan QRIS menggunakan aplikasi pembayaran.</p>
                    </div>
                @else
                    <div class="mt-3">
                        <div class="text-sm">E-Wallet</div>
                        <p class="mt-1 text-gray-600 text-sm">Buka {{ $payment->provider }} dan lakukan pembayaran sesuai total. Referensi: {{ $payment->reference }}</p>
                    </div>
                @endif
                <form class="mt-6" action="{{ route('payments.complete', [$order, $payment]) }}" method="POST">
                    @csrf
                    <button class="px-4 py-2 rounded-lg bg-emerald-600 !text-white shadow">Konfirmasi Pembayaran</button>
                </form>
            </div>
            <div class="bg-white rounded-xl shadow ring-1 ring-gray-100 p-6">
                <div class="text-sm text-gray-600">Ringkasan</div>
                <div class="mt-3 space-y-2">
                    @foreach($order->items as $i)
                        <div class="flex items-center justify-between text-sm">
                            <div>Item #{{ $i->id }}</div>
                            <div>Rp {{ number_format($i->price * $i->quantity) }}</div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 border-t pt-3 flex items-center justify-between">
                    <div class="font-medium">Total</div>
                    <div class="font-bold">Rp {{ number_format($order->total) }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

