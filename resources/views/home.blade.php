<x-app-layout>
    <div class="py-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @php($heroPath = public_path('images/bg.jpg'))
            @php($heroUrl = asset('images/bg.jpg'))
            @php($hasHero = file_exists($heroPath))
            <section
    id="hero"
    class="relative overflow-hidden mt-0 text-white
           min-h-[35vh] sm:min-h-[45vh] md:min-h-[50vh]
           flex items-center justify-center text-center
           {{ $hasHero ? '' : 'bg-gradient-to-br from-purple-700 via-purple-600 to-indigo-600' }}"
    style="{{ $hasHero ? "background-image:url('$heroUrl'); background-size:cover; background-position:center; background-repeat:no-repeat;" : '' }}"
>

                <div class="absolute inset-0 {{ $hasHero ? 'bg-black/35' : 'bg-black/20' }}"></div>
                <div class="relative z-10 max-w-3xl mx-auto px-6">
                    <h1 class="text-4xl md:text-6xl font-bold drop-shadow-lg">UMKM Marketplace</h1>
                    <p class="mt-4 text-base md:text-xl text-white/95">Temukan produk & jasa UMKM, atau posting kebutuhanmu agar penjual menawarkan solusi terbaik.</p>
                    <div class="mt-10 flex justify-center gap-5">
                        <a href="{{ route('needs.latest') }}" class="px-7 py-3 rounded-lg bg-white text-gray-900 font-semibold shadow">Post Kebutuhan</a>
                        <a href="#produk" class="px-7 py-3 rounded-lg bg-purple-600 text-white font-semibold shadow ring-2 ring-white/60">Lihat Produk</a>
                    </div>
                </div>
            </section>

            <section class="mt-8 rounded-xl bg-white shadow ring-1 ring-gray-100 p-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">Post kebutuhan kamu agar penjual dapat menawarkan produk/jasa</h2>
                    <a href="{{ route('needs.latest') }}" class="px-4 py-2 rounded-lg bg-indigo-600 text-white shadow">Post Kebutuhan</a>
                </div>
            </section>

            <section class="mt-8" x-data>
                <h3 class="text-xl font-bold text-gray-900 mb-6 text-center">Kategori Pilihan</h3>
                <div class="relative group">
                    <button
                        class="absolute left-1 top-1/2 -translate-y-1/2 z-10 w-8 h-8 flex items-center justify-center bg-white/90 border border-gray-200 shadow rounded-full text-gray-600 hover:text-indigo-700 hover:border-indigo-600 transition opacity-0 group-hover:opacity-100 pointer-events-none group-hover:pointer-events-auto hidden sm:flex"
                        @click="$refs.catScroll.scrollBy({ left: -320, behavior: 'smooth' })">
                        <i class='bx bx-chevron-left text-lg'></i>
                    </button>
                    <div
                        x-ref="catScroll"
                        class="flex gap-4 overflow-x-auto scroll-smooth snap-x snap-mandatory px-1 no-scrollbar"
                        style="scrollbar-width: none;">
                        @foreach($categoryList as $cat)
                        <a href="{{ route('products.index', ['category' => $cat['name']]) }}"
                           class="flex flex-col items-center justify-center group w-20 flex-shrink-0 snap-start">
                            <div class="h-12 w-12 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-gray-500 group-hover:border-indigo-600 group-hover:text-indigo-600 transition duration-300 shadow-sm">
                                <i class='bx {{ $cat['icon'] }} text-2xl'></i>
                            </div>
                            <div class="mt-2 text-[10px] sm:text-xs font-medium text-gray-600 text-center leading-tight group-hover:text-indigo-700 transition">{{ $cat['name'] }}</div>
                        </a>
                        @endforeach
                    </div>
                    <button
                        class="absolute right-1 top-1/2 -translate-y-1/2 z-10 w-8 h-8 flex items-center justify-center bg-white/90 border border-gray-200 shadow rounded-full text-gray-600 hover:text-indigo-700 hover:border-indigo-600 transition opacity-0 group-hover:opacity-100 pointer-events-none group-hover:pointer-events-auto hidden sm:flex"
                        @click="$refs.catScroll.scrollBy({ left: 320, behavior: 'smooth' })">
                        <i class='bx bx-chevron-right text-lg'></i>
                    </button>
                </div>
            </section>

            <section id="produk" class="mt-10">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Produk Terbaru</h3>
                    <a href="{{ route('products.index') }}" class="text-sm text-indigo-700 hover:text-indigo-800">Lihat semua</a>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-6">
                    @foreach($products as $product)
                        <div class="rounded-xl bg-white shadow ring-1 ring-gray-100 overflow-hidden hover:shadow-md transition group flex flex-col h-full">
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
                <div class="mt-8 flex justify-center">
                    <a
                      href="{{ route('products.index') }}"
                      class="px-6 py-3 rounded-full bg-purple-600 text-white font-semibold shadow ring-2 ring-purple-300 hover:bg-purple-500 transition">
                      Muat Lebih Banyak
                    </a>
                </div>
            </section>

            <section class="mt-12">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Kebutuhan Terbaru</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($needs as $need)
                        <a href="{{ route('needs.show', $need) }}" class="group block rounded-xl bg-white shadow ring-1 ring-gray-100 hover:shadow-md transition overflow-hidden">
                            <div class="h-32 w-full bg-white flex items-center justify-center">
                                @if($need->reference_image_path)
                                    <img class="max-h-full max-w-full object-contain" src="{{ asset('storage/'.$need->reference_image_path) }}" alt="Referensi">
                                @else
                                    <div class="h-full w-full bg-gradient-to-br from-indigo-50 via-white to-purple-50"></div>
                                @endif
                            </div>
                            <div class="p-5">
                                <div class="flex items-start justify-between">
                                    <h3 class="text-sm font-semibold text-gray-900 group-hover:text-indigo-700">{{ $need->title }}</h3>
                                    <span class="text-xs px-2 py-1 rounded-full bg-emerald-50 text-emerald-700">Open</span>
                                </div>
                                <p class="mt-2 text-xs text-gray-600 line-clamp-3">{{ \Illuminate\Support\Str::limit($need->description, 140) }}</p>
                                <div class="mt-3 flex items-center justify-between">
                                    <div class="text-xs text-gray-700">
                                        Budget:
                                        @if($need->budget_min || $need->budget_max)
                                            <span class="font-medium">Rp {{ number_format($need->budget_min ?? 0) }} - Rp {{ number_format($need->budget_max ?? 0) }}</span>
                                        @else
                                            <span class="font-medium">Tidak ditentukan</span>
                                        @endif
                                    </div>
                                    <div class="text-xs text-gray-500">by {{ $need->user->name }}</div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="mt-8 flex justify-center">
                    <a
                      href="{{ route('needs.latest') }}"
                      class="px-6 py-3 rounded-full bg-purple-600 text-white font-semibold shadow ring-2 ring-purple-300 hover:bg-purple-500 transition">
                      Muat Lebih Banyak
                    </a>
                </div>
            </section>

            <footer class="mt-12 rounded-xl bg-white shadow ring-1 ring-gray-100 p-6 text-sm text-gray-600">
                © {{ date('Y') }} UMKM Marketplace
            </footer>
        </div>
    </div>
</x-app-layout>
