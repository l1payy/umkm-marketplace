<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                @if(request('q'))
                    <h2 class="font-semibold text-xl text-gray-900 leading-tight">Hasil Pencarian</h2>
                    <p class="text-sm text-gray-600">Menampilkan hasil untuk: "{{ request('q') }}"</p>
                @else
                    <h2 class="font-semibold text-xl text-gray-900 leading-tight">Produk & Jasa</h2>
                    <p class="text-sm text-gray-600">Jelajahi produk/jasa UMKM dan dukung lokal</p>
                @endif
            </div>
            <a
              href="{{ route('products.create') }}"
              class="relative z-10 isolate px-4 py-2 rounded-lg bg-indigo-600 !text-white shadow hover:bg-indigo-500">
              Tambah Produk
            </a>
        </div>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($products->count() === 0)
                <div class="rounded-xl bg-white shadow ring-1 ring-gray-100 p-6 text-center text-gray-600">
                    Tidak ada produk yang cocok dengan pencarian.
                </div>
            @endif
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($products as $product)
                    <div class="rounded-xl bg-white shadow ring-1 ring-gray-100 overflow-hidden hover:shadow-md transition flex flex-col h-full">
                        @if($product->image_path)
                        <img class="w-full h-40 object-contain object-center bg-white" src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}">
                        @endif
                        <div class="p-5 flex flex-col flex-1">
                            <div class="flex items-start justify-between mb-2 h-10">
                                <h3 class="text-sm font-semibold text-gray-900 line-clamp-2 group-hover:text-indigo-700" title="{{ $product->name }}">{{ $product->name }}</h3>
                                @if($product->category)
                                    <span class="text-xs px-2 py-1 rounded-full bg-indigo-50 text-indigo-700 ml-2 shrink-0">{{ $product->category }}</span>
                                @endif
                            </div>
                            <div class="mb-3 h-8">
                                <p class="text-xs text-gray-600 line-clamp-2" title="{{ $product->description }}">{{ $product->description }}</p>
                            </div>
                            <div class="mb-3 h-4">
                                <div class="text-xs text-gray-500 whitespace-nowrap overflow-hidden text-ellipsis">by {{ $product->user->name }} @if($product->city) • {{ $product->city }} @endif</div>
                            </div>
                            <div class="flex items-center justify-between whitespace-nowrap mb-4 h-6">
                                <div class="text-sm font-semibold bg-emerald-50 text-emerald-700 px-2 py-1 rounded whitespace-nowrap">Rp {{ number_format($product->price) }}</div>
                                <div class="text-xs text-gray-600 flex items-center">
                                    <i class='bx bxs-star text-yellow-400'></i> {{ number_format($product->reviews_avg_rating ?? 0, 1) }} • {{ $product->reviews_count ?? 0 }}
                                </div>
                            </div>
                            <div class="mt-auto flex gap-2">
                                <a href="{{ route('products.show', $product) }}" class="flex-1 px-3 py-2 rounded-lg bg-white border text-gray-900 shadow-sm text-center text-sm flex items-center justify-center">Detail</a>
                                <form action="{{ route('cart.add.product', $product) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button class="w-full px-3 py-2 rounded-lg bg-indigo-600 text-white shadow text-sm">Keranjang</button>
                                </form>
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
