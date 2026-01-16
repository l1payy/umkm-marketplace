<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Produk/Jasa</h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow p-6">
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900" required>
                        @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="description" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900" rows="4">{{ old('description') }}</textarea>
                        @error('description') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Harga</label>
                        <input type="number" step="0.01" name="price" value="{{ old('price') }}" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900" required>
                        @error('price') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Foto</label>
                        <input type="file" name="image" accept="image/*" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900">
                        @error('image') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="pt-2">
                        <button class="bg-gray-900 !text-white px-4 py-2 rounded-lg shadow">
  Simpan
</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
