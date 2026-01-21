<x-app-layout>

    <div class="py-6" x-data="{ qty: 1, price: {{ (int) $product->price }} }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="rounded-xl bg-white shadow ring-1 ring-gray-100 p-6" x-data="{ idx: 0 }">
                @php($images = $product->images ?? collect())
                <div class="w-full bg-white">
                    <div class="relative aspect-video rounded-lg bg-white flex items-center justify-center overflow-hidden">
                        @if(($images->count() ?? 0) > 0)
                            <img :src="'{{ asset('storage') }}/' + '{{ $images->first()->path }}'" x-show="idx===0" class="w-full h-full object-contain">
                            @foreach($images as $i => $img)
                                <img src="{{ asset('storage/'.$img->path) }}" x-show="idx==={{ $i }}" class="w-full h-full object-contain">
                            @endforeach
                        @elseif($product->image_path)
                            <img class="w-full h-full object-contain" src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-indigo-50 via-white to-purple-50"></div>
                        @endif
                        <button type="button" class="absolute left-2 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white/80 border flex items-center justify-center" @click="idx = Math.max(0, idx-1)"><i class="bx bx-chevron-left text-xl"></i></button>
                        <button type="button" class="absolute right-2 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white/80 border flex items-center justify-center" @click="idx = Math.min({{ max(0, ($images->count() ?? 0) - 1) }}, idx+1)"><i class="bx bx-chevron-right text-xl"></i></button>
                    </div>
                    @if(($images->count() ?? 0) > 0)
                        <div class="mt-3 grid grid-cols-5 gap-2">
                            @foreach($images as $i => $img)
                                <button type="button" class="aspect-square rounded-lg overflow-hidden border" @click="idx={{ $i }}">
                                    <img src="{{ asset('storage/'.$img->path) }}" class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            <div class="rounded-xl bg-white shadow ring-1 ring-gray-100 p-6">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $product->name }}</h3>
                        <div class="mt-2 text-3xl font-extrabold text-gray-900">Rp {{ number_format($product->price) }}</div>
                    </div>
                </div>
                <div class="mt-4 text-sm text-gray-600">
                    <div class="flex items-center gap-1">
                        <i class="bx bxs-star text-yellow-400"></i>
                        <span>{{ number_format($product->reviews_avg_rating ?? 0, 1) }} · {{ $product->reviews_count ?? 0 }} ulasan</span>
                    </div>
                </div>
                <p class="mt-4 text-gray-700">{{ $product->description }}</p>
                <div class="mt-4 text-xs text-gray-500">by {{ $product->user->name }}</div>

                <div class="mt-4">
                    <div class="flex items-center justify-between rounded-xl border border-gray-200 p-4 bg-white">
                        <div class="flex items-center gap-3">
                            @if($product->user->profile_photo_path)
                                <img src="{{ asset('storage/'.$product->user->profile_photo_path) }}" alt="{{ $product->user->name }}" class="h-10 w-10 rounded-full object-cover">
                            @else
                                <div class="h-10 w-10 rounded-full bg-gray-200"></div>
                            @endif
                            <div>
                                <div class="flex items-center gap-1">
                                    <span class="text-sm font-semibold text-gray-900">{{ $product->user->name }}</span>
                                    <i class='bx bxs-badge-check text-purple-600'></i>
                                </div>
                                <div class="flex items-center gap-3 text-xs text-gray-600">
                                    <span class="flex items-center gap-1">
                                        <i class='bx bxs-star text-yellow-400'></i>
                                        {{ number_format(($sellerAvgRating ?? $product->reviews_avg_rating ?? 0), 1) }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <i class='bx bx-box text-gray-500'></i>
                                        {{ $sellerProductsCount ?? ($product->user->products->count() ?? 0) }} total barang
                                    </span>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="px-3 py-1 rounded-lg border border-emerald-600 text-emerald-600 hover:bg-emerald-50 text-sm">Follow</button>
                    </div>
                </div>
            </div>
            <div class="rounded-xl bg-white shadow ring-1 ring-gray-100 p-6">
                <div class="text-sm text-gray-600">Atur jumlah</div>
                <div class="mt-3 flex items-center gap-3">
                    <button class="w-8 h-8 rounded-lg border flex items-center justify-center" @click="qty = Math.max(1, qty-1)">-</button>
                    <input type="number" min="1" x-model.number="qty" class="w-16 text-center rounded-lg border">
                    <button class="w-8 h-8 rounded-lg border flex items-center justify-center" @click="qty = qty+1">+</button>
                </div>
                <div class="mt-3 text-sm text-gray-600">Subtotal</div>
                <div class="text-xl font-bold">Rp <span x-text="(qty*price).toLocaleString('id-ID')"></span></div>
                <div class="mt-4 flex flex-col gap-3">
                    <form action="{{ route('cart.add.product', $product) }}" method="POST">
                        @csrf
                        <input type="hidden" name="quantity" :value="qty">
                        <button class="w-full px-4 py-2 rounded-lg bg-indigo-600 text-white shadow">+ Keranjang</button>
                    </form>
                    <form action="{{ route('checkout.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_direct" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" :value="qty">
                        <button class="w-full px-4 py-2 rounded-lg bg-emerald-600 text-white shadow">Beli Langsung</button>
                    </form>
                    <div class="flex items-center justify-between mt-2">
                        <a href="{{ route('chat.index', ['user' => $product->user_id]) }}" class="px-3 py-2 rounded-lg bg-white border text-gray-700 shadow-sm flex items-center gap-2"><i class="bx bx-chat"></i><span>Chat</span></a>
                        <button type="button" class="px-3 py-2 rounded-lg bg-white border text-gray-700 shadow-sm flex items-center gap-2"
                            @click="navigator.clipboard.writeText('{{ url()->current() }}')">
                            <i class="bx bx-share-alt"></i><span>Share</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
            <div class="bg-white rounded-xl shadow ring-1 ring-gray-100 p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-1">
                    <h3 class="text-lg font-semibold">Spesifikasi</h3>
                    <dl class="mt-3 space-y-2 text-sm">
                        <div class="flex items-start justify-between">
                            <dt class="text-gray-600">Material</dt>
                            <dd class="text-gray-900">{{ optional($product->detail)->material ?? '—' }}</dd>
                        </div>
                        <div class="flex items-start justify-between">
                            <dt class="text-gray-600">Care Label</dt>
                            <dd class="text-gray-900">{{ optional($product->detail)->care_label ?? '—' }}</dd>
                        </div>
                        <div class="flex items-start justify-between">
                            <dt class="text-gray-600">Kode SKU</dt>
                            <dd class="text-gray-900">{{ optional($product->detail)->sku ?? '—' }}</dd>
                        </div>
                        @if(optional($product->detail)->specs)
                            @foreach($product->detail->specs as $k => $v)
                                <div class="flex items-start justify-between">
                                    <dt class="text-gray-600">{{ $k }}</dt>
                                    <dd class="text-gray-900">{{ $v }}</dd>
                                </div>
                            @endforeach
                        @endif
                    </dl>
                </div>
                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold">Deskripsi</h3>
                    <div class="mt-3 text-sm text-gray-700 whitespace-pre-line">
                        {{ optional($product->detail)->long_description ?? $product->description }}
                    </div>

                </div>
                <div class="md:col-span-2">
                    <h3 class="mt-6 text-lg font-semibold">Ulasan Pengguna</h3>
                    @if(($product->reviews_count ?? 0) > 0)
                        <div class="mt-4 space-y-4">
                            @foreach($product->reviews as $review)
                                <div class="rounded-lg border p-4 bg-white">
                                    <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-2">
                                                <div class="text-sm font-semibold text-gray-900">{{ $review->user->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $review->created_at->format('d M Y') }}</div>
                                            </div>
                                            <div class="flex items-center text-yellow-400">
                                                <i class="bx bxs-star"></i>
                                                <span class="text-sm font-semibold ml-1">{{ $review->rating }}</span>
                                            </div>
                                        </div>
                                    @if($review->comment)
                                        <div class="mt-2 text-sm text-gray-700">{{ $review->comment }}</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="mt-3 text-sm text-gray-600">Belum ada ulasan. Jadilah yang pertama setelah checkout.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
