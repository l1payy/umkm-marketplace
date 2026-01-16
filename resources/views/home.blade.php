<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-900 leading-tight">Kebutuhan Terbaru</h2>
                <p class="text-sm text-gray-600">Temukan proyek UMKM dan kirim penawaran terbaikmu</p>
            </div>
            <div class="flex gap-2">
<a
  href="{{ route('needs.create') }}"
  class="relative z-10 isolate px-4 py-2 rounded-lg bg-indigo-600 !text-white shadow hover:bg-indigo-500 font-semibold">
  Post Kebutuhan
</a>
                <a href="{{ route('products.index') }}" class="px-4 py-2 rounded-lg bg-white border text-gray-900 shadow hover:bg-gray-50 font-semibold">Lihat Produk</a>
            </div>
        </div>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($needs as $need)
                    <a href="{{ route('needs.show', $need) }}" class="group block rounded-xl bg-white shadow ring-1 ring-gray-100 hover:shadow-md transition overflow-hidden">
                        <div class="h-28 bg-gradient-to-br from-indigo-50 via-white to-purple-50"></div>
                        <div class="p-5">
                            <div class="flex items-start justify-between">
                                <h3 class="text-lg font-semibold text-gray-900 group-hover:text-indigo-700">{{ $need->title }}</h3>
                                <span class="text-xs px-2 py-1 rounded-full bg-emerald-50 text-emerald-700">Open</span>
                            </div>
                            <p class="mt-2 text-sm text-gray-600 line-clamp-3">{{ \Illuminate\Support\Str::limit($need->description, 140) }}</p>
                            <div class="mt-4 flex items-center justify-between">
                                <div class="text-sm text-gray-700">
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
            <div class="mt-6">
                {{ $needs->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
