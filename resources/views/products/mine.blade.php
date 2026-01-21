<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-900 leading-tight">Produk Saya</h2>
                <p class="text-sm text-gray-600">Kelola produk yang kamu unggah</p>
            </div>
            <a href="{{ route('products.create') }}" class="px-4 py-2 rounded-lg bg-indigo-600 !text-white shadow">Tambah Produk</a>
        </div>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($products as $product)
                    <div class="rounded-xl bg-white shadow ring-1 ring-gray-100 overflow-hidden">
                        @if($product->image_path)
                        <img class="w-full h-40 object-contain object-center bg-white" src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}">
                        @endif
                        <div class="p-5">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $product->name }}</h3>
                            <p class="mt-1 text-sm text-gray-600 line-clamp-3">{{ $product->description }}</p>
                            <div class="mt-3 text-sm font-semibold bg-emerald-50 text-emerald-700 px-2 py-1 rounded">Rp {{ number_format($product->price) }}</div>
                            <div class="mt-4 flex gap-2">
                                <a href="{{ route('products.edit', $product) }}" class="px-3 py-2 rounded-lg bg-white border text-gray-900 shadow-sm">Edit</a>
                                <a href="{{ route('products.show', $product) }}" class="px-3 py-2 rounded-lg bg-indigo-600 !text-white shadow">Lihat</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
