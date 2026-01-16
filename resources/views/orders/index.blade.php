<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-900 leading-tight">Pesanan</h2>
            <a href="{{ route('home') }}" class="px-4 py-2 rounded-lg bg-white border text-gray-700 shadow-sm">Kembali ke Beranda</a>
        </div>
    </x-slot>
    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow ring-1 ring-gray-100 p-6">
                @forelse($orders as $order)
                    <div class="border-b py-4">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-600">#{{ $order->id }} — {{ ucfirst($order->status) }}</div>
                            <div class="font-semibold bg-emerald-50 text-emerald-700 px-2 py-1 rounded">Rp {{ number_format($order->total) }}</div>
                        </div>
                        <div class="mt-2 text-sm text-gray-700">Item: {{ $order->items->count() }}</div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">Belum ada pesanan.</p>
                @endforelse
                <div class="mt-4">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
