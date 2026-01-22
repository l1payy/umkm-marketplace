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
                <div class="bg-white rounded-2xl shadow ring-1 ring-gray-100 p-6">
                    <div class="flex items-center gap-2">
                        <div class="h-8 w-8 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center">
                            <i class='bx bx-offer'></i>
                        </div>
                        <h3 class="text-lg font-semibold">Kirim Penawaran</h3>
                    </div>
                    @if(auth()->id() === $need->user_id)
                        <div class="mt-4 bg-gray-50 border border-gray-200 rounded-xl p-4 text-sm text-gray-600">
                            Kamu adalah pemilik kebutuhan ini, tidak dapat mengirim penawaran.
                        </div>
                    @else
                        <div class="mt-4 bg-indigo-50 border-l-4 border-indigo-500 rounded-r-xl p-4">
                            <div class="flex items-start gap-2">
                                <i class='bx bx-info-circle text-indigo-600 text-xl'></i>
                                <p class="text-sm text-indigo-800">Tulis deskripsi singkat, harga, dan estimasi pengerjaan agar pemilik kebutuhan mudah membandingkan penawaran.</p>
                            </div>
                        </div>
                        <form class="mt-4 space-y-4" action="{{ route('offers.store', $need) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                <div class="relative mt-1">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class='bx bx-detail text-gray-400'></i>
                                    </div>
                                    <textarea name="description" class="pl-10 block w-full rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600" rows="3" required></textarea>
                                </div>
                                @error('description') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Harga</label>
                                    <div class="relative mt-1">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-400 text-sm">Rp</span>
                                        </div>
                                        <input type="number" step="0.01" name="price" class="pl-10 block w-full rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600" required>
                                    </div>
                                    @error('price') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Estimasi (hari)</label>
                                    <div class="relative mt-1">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class='bx bx-time text-gray-400'></i>
                                        </div>
                                        <input type="number" name="eta_days" class="pl-10 block w-full rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600" required>
                                    </div>
                                    @error('eta_days') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Gambar Penawaran (opsional)</label>
                                <div class="mt-1">
                                    <input type="file" name="image" accept="image/*" class="block w-full rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600">
                                </div>
                                @error('image') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="flex items-center gap-3">
                                <button class="px-5 py-2.5 rounded-lg bg-indigo-600 !text-white shadow hover:bg-indigo-500">Kirim Penawaran</button>
                                <a href="{{ route('needs.latest') }}" class="px-5 py-2.5 rounded-lg bg-white border text-gray-900 shadow-sm">Lihat Kebutuhan Lain</a>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
