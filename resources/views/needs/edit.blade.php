<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-900 leading-tight">Edit Kebutuhan</h2>
                <p class="text-sm text-gray-600">Perbarui kebutuhan kamu</p>
            </div>
        </div>
    </x-slot>
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow ring-1 ring-gray-100 p-6">
                <form action="{{ route('needs.update', $need) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Judul</label>
                        <input type="text" name="title" value="{{ old('title', $need->title) }}" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600" required>
                        @error('title') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="description" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600" rows="4" required>{{ old('description', $need->description) }}</textarea>
                        @error('description') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Budget Min</label>
                            <input type="number" step="0.01" name="budget_min" value="{{ old('budget_min', $need->budget_min) }}" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600">
                            @error('budget_min') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Budget Max</label>
                            <input type="number" step="0.01" name="budget_max" value="{{ old('budget_max', $need->budget_max) }}" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600">
                            @error('budget_max') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Upload Foto Referensi</label>
                        <input type="file" name="reference_image" accept="image/*" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600">
                        @error('reference_image') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        @if($need->reference_image_path)
                            <img class="mt-3 rounded-lg w-40 h-40 object-cover" src="{{ asset('storage/'.$need->reference_image_path) }}" alt="Preview">
                        @endif
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600">
                            <option value="open" @selected(old('status', $need->status) === 'open')>Open</option>
                            <option value="closed" @selected(old('status', $need->status) === 'closed')>Closed</option>
                        </select>
                        @error('status') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="pt-2">
                        <button type="submit" class="bg-indigo-600 !text-white px-4 py-2 rounded-lg shadow">Simpan</button>
                    </div>
                </form>
                <div class="pt-2">
                    <form action="{{ route('needs.destroy', $need) }}" method="POST" onsubmit="return confirm('Hapus kebutuhan ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="bg-red-600 !text-white px-4 py-2 rounded-lg shadow">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
