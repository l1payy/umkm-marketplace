<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-900 leading-tight">{{ $product->name }}</h2>
            <div class="text-sm font-semibold bg-emerald-50 text-emerald-700 px-3 py-1 rounded">Rp {{ number_format($product->price) }}</div>
        </div>
    </x-slot>
    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 rounded-xl bg-white shadow ring-1 ring-gray-100 p-6">
                @if($product->image_path)
                <div class="flex justify-center">
                    <img class="rounded-lg mx-auto w-full max-w-xs md:max-w-sm h-auto object-contain" src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}">
                </div>
                @endif
                <p class="mt-4 text-gray-700">{{ $product->description }}</p>
            </div>
            <div class="rounded-xl bg-white shadow ring-1 ring-gray-100 p-6">
                <div class="text-sm text-gray-600">Aksi</div>
                <div class="mt-3 flex flex-col gap-3">
                    <a href="{{ route('chat.index', ['user' => $product->user_id]) }}" class="px-4 py-2 rounded-lg bg-white border text-gray-900 shadow-sm text-center font-semibold">Chat Penjual</a>
                    <form action="{{ route('cart.add.product', $product) }}" method="POST">
                        @csrf
                        <button class="w-full px-4 py-2 rounded-lg bg-indigo-600 text-white shadow font-semibold">Masukkan Keranjang</button>
                    </form>
                    <form action="{{ route('checkout.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_direct" value="{{ $product->id }}">
                        <button class="w-full px-4 py-2 rounded-lg bg-emerald-600 text-white shadow font-semibold">Checkout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
