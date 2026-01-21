<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-900 leading-tight">{{ $need->title }}</h2>
            <span class="text-xs px-3 py-1 rounded-full bg-emerald-50 text-emerald-700">{{ ucfirst($need->status) }}</span>
        </div>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-xl shadow ring-1 ring-gray-100 p-6">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-600">by {{ $need->user->name }}</div>
                        <span class="text-xs px-2 py-1 rounded-full bg-emerald-50 text-emerald-700">{{ ucfirst($need->status) }}</span>
                    </div>
                    <p class="mt-3 text-gray-700">{{ $need->description }}</p>
                    <div class="mt-4 text-sm text-gray-700">
                        Budget:
                        @if($need->budget_min || $need->budget_max)
                            <span class="font-medium">Rp {{ number_format($need->budget_min ?? 0) }} - Rp {{ number_format($need->budget_max ?? 0) }}</span>
                        @else
                            <span class="font-medium">Tidak ditentukan</span>
                        @endif
                    </div>
                    @if($need->reference_image_path)
                        <div class="mt-4 flex justify-center">
                            <img class="rounded-lg mx-auto w-full max-w-xs md:max-w-sm h-auto object-contain" src="{{ asset('storage/'.$need->reference_image_path) }}" alt="Referensi">
                        </div>
                    @endif
                </div>

                <div class="bg-white rounded-xl shadow ring-1 ring-gray-100 p-6">
                    <h3 class="text-lg font-semibold">Penawaran</h3>
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($need->offers as $offer)
                            <div class="rounded-lg p-4 shadow-sm ring-1 ring-gray-100 bg-white">
                                <div class="grid grid-cols-1 sm:grid-cols-5 gap-4">
                                    <div class="sm:col-span-3">
                                        <div class="flex items-center justify-between">
                                            <div class="text-sm text-gray-600">by {{ $offer->user->name }}</div>
                                            <div class="text-sm font-medium">Rp {{ number_format($offer->price) }}</div>
                                        </div>
                                        <p class="mt-2 text-sm text-gray-700">{{ $offer->description }}</p>
                                        <div class="mt-2 text-xs text-gray-500">Estimasi: {{ $offer->eta_days }} hari</div>
                                        <div class="mt-4 flex flex-col sm:flex-row gap-2 sm:gap-3">
                                            <a href="{{ route('chat.index', ['user' => $offer->user_id]) }}" class="sm:flex-1 px-3 py-2 rounded-lg bg-white border text-gray-700 shadow-sm text-center">Chat Penawar</a>
                                            <form action="{{ route('cart.add.offer', $offer) }}" method="POST" class="sm:flex-1">
                                                @csrf
                                                <button type="submit" class="w-full px-3 py-2 rounded-lg bg-white border text-gray-700 shadow-sm">Masukkan Keranjang</button>
                                            </form>
                                            <form action="{{ route('checkout.store') }}" method="POST" class="sm:flex-1">
                                                @csrf
                                                <input type="hidden" name="offer_direct" value="{{ $offer->id }}">
                                                <button type="submit" class="w-full px-3 py-2 rounded-lg bg-indigo-600 text-white shadow">Checkout</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="sm:col-span-2">
                                        @if($offer->image_path)
                                            <div class="w-full h-full rounded-lg overflow-hidden border bg-white">
                                                <img class="w-full h-40 object-contain" src="{{ asset('storage/'.$offer->image_path) }}" alt="Gambar Penawaran">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">Belum ada penawaran.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div>
                <div class="bg-white rounded-xl shadow ring-1 ring-gray-100 p-6">
                    <h3 class="text-lg font-semibold">Kirim Penawaran</h3>
                    @if(auth()->id() === $need->user_id)
                        <p class="mt-2 text-sm text-gray-500">Kamu adalah pemilik kebutuhan ini, tidak dapat mengirim penawaran.</p>
                    @else
                        <form class="mt-4 space-y-3" action="{{ route('offers.store', $need) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                <textarea name="description" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600" rows="3" required></textarea>
                                @error('description') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Harga</label>
                                    <input type="number" step="0.01" name="price" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600" required>
                                    @error('price') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Estimasi (hari)</label>
                                    <input type="number" name="eta_days" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600" required>
                                    @error('eta_days') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Gambar Penawaran (opsional)</label>
                                <input type="file" name="image" accept="image/*" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600">
                                @error('image') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <button class="bg-indigo-600 !text-white px-4 py-2 rounded-lg shadow">Kirim</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
