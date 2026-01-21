<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-900 leading-tight">Resi Pembayaran #{{ $order->id }}</h2>
            <a href="{{ route('orders.index') }}" class="px-4 py-2 rounded-lg bg-white border text-gray-700 shadow-sm">Lihat Pesanan</a>
        </div>
    </x-slot>
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow ring-1 ring-gray-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-600">Tanggal</div>
                        <div class="font-medium">{{ now()->format('d M Y H:i') }}</div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm text-gray-600">Total</div>
                        <div class="text-xl font-bold">Rp {{ number_format($order->total) }}</div>
                    </div>
                </div>
                <div class="mt-4 border-t pt-4 space-y-2">
                    @foreach($order->items as $i)
                        <div class="flex items-center justify-between text-sm">
                            <div>Item #{{ $i->id }} × {{ $i->quantity }}</div>
                            <div>Rp {{ number_format($i->price * $i->quantity) }}</div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6 border-t pt-4">
                    <div class="text-sm text-gray-600">Metode</div>
                    @if($payment)
                        <div class="font-medium">{{ strtoupper($payment->method) }} — {{ $payment->provider }}</div>
                        @if($payment->va_number)
                            <div class="text-sm text-gray-600">VA: {{ $payment->va_number }}</div>
                        @endif
                        <div class="text-sm text-gray-600">Ref: {{ $payment->reference }}</div>
                        <div class="text-sm text-gray-600">Status: {{ ucfirst($payment->status) }}</div>
                    @else
                        <div class="font-medium">Tidak tersedia</div>
                    @endif
                </div>
                <div class="mt-6">
                    <button onclick="window.print()" class="px-4 py-2 rounded-lg bg-indigo-600 !text-white shadow">Cetak Resi</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

