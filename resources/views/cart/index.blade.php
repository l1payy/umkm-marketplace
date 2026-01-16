<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-900 leading-tight">Keranjang</h2>
            <a href="{{ route('products.index') }}" class="px-4 py-2 rounded-lg bg-white border text-gray-700 shadow-sm">Belanja lagi</a>
        </div>
    </x-slot>
    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white rounded-xl shadow ring-1 ring-gray-100 p-6">
                @forelse($items as $item)
                    <div class="flex items-center justify-between border-b py-4">
                        <div>
                            <div class="font-medium">
                                @if($item->product)
                                    {{ $item->product->name }}
                                @elseif($item->offer)
                                    Penawaran untuk: {{ $item->offer->need->title }}
                                @endif
                            </div>
                            <div class="text-sm text-gray-600">Qty: {{ $item->quantity }}</div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="font-semibold">Rp {{ number_format($item->price * $item->quantity) }}</div>
                            <form action="{{ route('cart.item.remove', $item) }}" method="POST">
                                @csrf @method('DELETE')
                                <button class="px-3 py-2 rounded-lg bg-white border text-gray-700 shadow-sm">Hapus</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">Keranjang kosong.</p>
                @endforelse
            </div>
            <div class="bg-white rounded-xl shadow ring-1 ring-gray-100 p-6">
                <div class="text-sm text-gray-600">Total</div>
                <div class="text-2xl font-bold">Rp {{ number_format($total) }}</div>
                <form class="mt-4" action="{{ route('checkout.store') }}" method="POST">
                    @csrf
                    <button
  class="relative z-10 w-full px-4 py-2 rounded-lg bg-emerald-600 !text-white shadow 
         not-italic normal-case bg-clip-border text-opacity-100">
  Checkout
</button>


                </form>
            </div>
        </div>
    </div>
</x-app-layout>
