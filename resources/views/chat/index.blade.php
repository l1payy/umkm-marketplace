<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-900 leading-tight">Chat</h2>
            <a href="{{ route('home') }}" class="px-3 py-2 rounded-lg bg-white border text-gray-700 shadow-sm">Beranda</a>
        </div>
    </x-slot>
    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow ring-1 ring-gray-100 p-4">
                <div class="text-sm text-gray-600 mb-2">Percakapan</div>
                <div class="space-y-2">
                    @forelse($conversations as $c)
                        @php
                            $isMeFirst = auth()->id() === $c->user_id;
                            $other = $isMeFirst ? $c->partner : $c->user;
                        @endphp
                        <a class="block px-3 py-2 rounded-lg hover:bg-gray-50 border" href="{{ route('chat.index', ['conversation' => $c->id]) }}">
                            <div class="text-sm font-medium">{{ $other->name }}</div>
                            <div class="text-xs text-gray-500">#{{ $c->id }}</div>
                        </a>
                    @empty
                        <p class="text-sm text-gray-500">Belum ada percakapan.</p>
                    @endforelse
                </div>
            </div>
            <div class="lg:col-span-2 bg-white rounded-xl shadow ring-1 ring-gray-100 p-4">
                @if($active)
                    <div class="h-[48vh] overflow-y-auto space-y-3">
                        @foreach($messages as $msg)
                            <div class="flex {{ $msg->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                                <div class="max-w-[75%] px-3 py-2 rounded-lg {{ $msg->sender_id === auth()->id() ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-800' }}">
                                    <div class="text-sm">{{ $msg->body }}</div>
                                    <div class="mt-1 text-[11px] opacity-80">{{ $msg->created_at->format('d/m H:i') }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <form class="mt-4 flex gap-2" action="{{ route('chat.send') }}" method="POST">
                        @csrf
                        <input type="hidden" name="conversation_id" value="{{ $active->id }}">
                        <input type="text" name="body" class="flex-1 rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600" placeholder="Tulis pesan..." required>
                        <button class="bg-indigo-600 !text-white px-4 py-2 rounded-lg shadow">
  Kirim
</button>

                    </form>
                @else
                    <p class="text-sm text-gray-500">Pilih percakapan di kiri atau mulai chat dari halaman Produk/Kebutuhan.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
