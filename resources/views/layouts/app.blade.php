<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- Boxicons -->
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen relative bg-gradient-to-br from-purple-50 via-white to-purple-100">
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute -top-24 -left-24 w-72 h-72 bg-purple-200 rounded-full blur-3xl opacity-50"></div>
                <div class="absolute top-1/3 -right-24 w-72 h-72 bg-purple-300 rounded-full blur-3xl opacity-40"></div>
                <div class="absolute bottom-0 left-1/3 w-64 h-64 bg-purple-200 rounded-full blur-3xl opacity-40"></div>
            </div>
            <div class="relative z-10">
                @include('layouts.navigation')

                @if (isset($header))
                    <header class="bg-gradient-to-r from-white via-gray-50 to-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <main class="pb-10">
                    @include('components.flash')
                    @unless (request()->routeIs('home'))
                        @include('components.back-button')
                    @endunless
                    {{ $slot }}
                </main>
                <footer class="bg-white border-t border-gray-200">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                            <div>
                                <div class="flex items-center gap-2">
                                    <img src="{{ asset('images/logo.png') }}" alt="UMKM Marketplace" class="h-8 w-auto">
                                    <span class="text-lg font-semibold text-gray-900">UMKM Marketplace</span>
                                </div>
                                <p class="mt-3 text-sm text-gray-600">Temukan produk & jasa UMKM, atau post kebutuhanmu agar pelaku usaha menawarkan solusi terbaik.</p>
                                <div class="mt-4 flex items-center gap-3 text-gray-600">
                                    <a href="{{ route('products.index') }}" class="text-sm hover:text-indigo-600">Produk & Jasa</a>
                                    <a href="{{ route('needs.latest') }}" class="text-sm hover:text-indigo-600">Kebutuhan</a>
                                    <a href="{{ route('profile.edit') }}" class="text-sm hover:text-indigo-600">Profil</a>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-900">Beli</h4>
                                <ul class="mt-3 space-y-2">
                                    <li><a href="{{ route('products.index') }}" class="text-sm text-gray-600 hover:text-indigo-600">Jelajahi Produk</a></li>
                                    <li><a href="{{ route('cart.index') }}" class="text-sm text-gray-600 hover:text-indigo-600">Keranjang</a></li>
                                    <li><a href="{{ route('orders.index') }}" class="text-sm text-gray-600 hover:text-indigo-600">Pesanan</a></li>
                                </ul>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-900">Jual</h4>
                                <ul class="mt-3 space-y-2">
                                    <li><a href="{{ route('products.create') }}" class="text-sm text-gray-600 hover:text-indigo-600">Tambah Produk</a></li>
                                    <li><a href="{{ route('needs.latest') }}" class="text-sm text-gray-600 hover:text-indigo-600">Tawarkan ke Kebutuhan</a></li>
                                    <li><a href="{{ route('products.mine') }}" class="text-sm text-gray-600 hover:text-indigo-600">Produk Saya</a></li>
                                </ul>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-900">Ikuti Kami</h4>
                                <div class="mt-3 flex items中心 gap-3">
                                    <a href="#" class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:text-indigo-600"><i class='bx bxl-facebook'></i></a>
                                    <a href="#" class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:text-indigo-600"><i class='bx bxl-twitter'></i></a>
                                    <a href="#" class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:text-indigo-600"><i class='bx bxl-instagram'></i></a>
                                    <a href="#" class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:text-indigo-600"><i class='bx bxl-pinterest'></i></a>
                                </div>
                                <h4 class="mt-6 text-sm font-semibold text-gray-900">Dapatkan Aplikasi</h4>
                                <div class="mt-3 grid grid-cols-2 gap-3">
                                    <a href="#" class="px-3 py-2 rounded-lg border text-gray-700 hover:border-indigo-600 hover:text-indigo-700 text-sm flex items-center justify-center gap-2"><i class='bx bxl-play-store'></i> <span>Google Play</span></a>
                                    <a href="#" class="px-3 py-2 rounded-lg border text-gray-700 hover:border-indigo-600 hover:text-indigo-700 text-sm flex items-center justify-center gap-2"><i class='bx bxl-apple'></i> <span>App Store</span></a>
                                </div>
                            </div>
                        </div>
                        <div class="mt-10 flex flex-col sm:flex-row items-center justify-between border-t border-gray-100 pt-6 text-sm text-gray-600">
                            <div>© {{ date('Y') }} UMKM Marketplace</div>
                            <div class="flex items-center gap-4">
                                <a href="#" class="hover:text-indigo-600">Kebijakan Privasi</a>
                                <a href="#" class="hover:text-indigo-600">Syarat & Ketentuan</a>
                                <a href="#" class="hover:text-indigo-600">Bantuan</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </body>
</html>
