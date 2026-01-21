<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-900 leading-tight">Keranjang</h2>
            <a href="{{ route('products.index') }}" class="px-4 py-2 rounded-lg bg-white border text-gray-700 shadow-sm">Belanja lagi</a>
        </div>
    </x-slot>
    <div class="py-6" x-data="{ selected: [], amounts: { @foreach($items as $i)'{{$i->id}}': {{$i->price * $i->quantity}},@endforeach } }">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white rounded-xl shadow ring-1 ring-gray-100 p-6">
                <div class="flex items-center justify-between mb-2">
                    <label class="flex items-center gap-2 text-sm text-gray-700">
                        <input type="checkbox" class="rounded border-gray-300" @change="selected = $event.target.checked ? Object.keys(amounts).map(Number) : []">
                        <span>Pilih semua</span>
                    </label>
                    <div class="text-xs text-gray-500" x-text="selected.length + ' dipilih'"></div>
                </div>
                @forelse($items as $item)
                    <div class="flex items-center gap-4 border-b py-4">
                        <div class="w-20 h-20 rounded-lg overflow-hidden bg-gray-100 ring-1 ring-gray-200 flex items-center justify-center">
                            @if($item->product && $item->product->image_path)
                                <img class="w-full h-full object-cover" src="{{ asset('storage/'.$item->product->image_path) }}" alt="{{ $item->product->name }}">
                            @elseif($item->offer && $item->offer->need && $item->offer->need->reference_image_path)
                                <img class="w-full h-full object-cover" src="{{ asset('storage/'.$item->offer->need->reference_image_path) }}" alt="Referensi">
                            @else
                                <i class="bx bx-package text-2xl text-gray-400"></i>
                            @endif
                        </div>
                        <div>
                            <input type="checkbox" class="rounded border-gray-300" :value="{{ $item->id }}" x-model="selected">
                        </div>
                        <div class="flex-1">
                            @if($item->product)
                                <div class="font-semibold text-gray-900">{{ $item->product->name }}</div>
                                @if($item->product->description)
                                    <div class="text-sm text-gray-600 line-clamp-2">{{ $item->product->description }}</div>
                                @endif
                                <div class="mt-1 text-xs text-gray-500">by {{ $item->product->user->name }}</div>
                            @elseif($item->offer)
                                <div class="font-semibold text-gray-900">{{ $item->offer->need->title }}</div>
                                <div class="text-sm text-gray-600 line-clamp-2">{{ $item->offer->description }}</div>
                                <div class="mt-1 text-xs text-gray-500">by {{ $item->offer->user->name }}</div>
                            @endif
                            <div class="mt-2 text-xs text-gray-500">Jumlah: {{ $item->quantity }}</div>
                        </div>
                        <div class="text-right">
                            <div class="font-semibold">Rp {{ number_format($item->price * $item->quantity) }}</div>
                            <form class="mt-2" action="{{ route('cart.item.remove', $item) }}" method="POST">
                                @csrf @method('DELETE')
                                <button class="px-3 py-2 rounded-lg bg-white border text-gray-700 shadow-sm hover:bg-gray-50">Hapus</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">Keranjang kosong.</p>
                @endforelse
            </div>
            <div class="bg-white rounded-xl shadow ring-1 ring-gray-100 p-6">
                <div class="text-sm text-gray-600">Total</div>
                <div class="text-2xl font-bold">Rp <span x-text="selected.reduce((s,id)=>s + (amounts[id] ?? 0), 0).toLocaleString('id-ID')"></span></div>
                <form class="mt-4" action="{{ route('checkout.store') }}" method="POST">
                    @csrf
                    <template x-for="id in selected">
                        <input type="hidden" name="selected[]" :value="id">
                    </template>
                    <button class="w-full px-4 py-2 rounded-lg bg-emerald-600 !text-white shadow hover:bg-emerald-500" :disabled="selected.length === 0" :class="selected.length === 0 ? 'opacity-60 cursor-not-allowed' : ''">Checkout</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
