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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen relative bg-gradient-to-br from-purple-50 via-white to-purple-100">
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute -top-24 -left-24 w-72 h-72 bg-purple-200 rounded-full blur-3xl opacity-50"></div>
                <div class="absolute top-1/3 -right-24 w-72 h-72 bg-purple-300 rounded-full blur-3xl opacity-40"></div>
                <div class="absolute bottom-0 left-1/3 w-64 h-64 bg-purple-200 rounded-full blur-3xl opacity-40"></div>
            </div>
            <div class="relative z-10 flex flex-col items-center justify-center min-h-screen px-4">
                <a href="/" class="block">
                    <img src="{{ asset('images/logo.png') }}" alt="UMKM Marketplace" class="h-[200px] w-auto object-contain">
                </a>
                <div class="w-full sm:max-w-md mt-6 rounded-2xl bg-white/95 backdrop-blur-md shadow-xl ring-1 ring-purple-100">
                    <div class="px-6 py-6">
                        {{ $slot }}
                    </div>
                </div>
                <div class="mt-6 text-xs text-gray-500">© {{ date('Y') }} UMKM Marketplace</div>
            </div>
        </div>
    </body>
</html>
