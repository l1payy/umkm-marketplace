<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-900 leading-tight">Post Kebutuhan</h2>
            <p class="text-sm text-gray-600">Ceritakan kebutuhan UMKM kamu, biar pelaku usaha bantu</p>
        </div>
    </x-slot>
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow ring-1 ring-gray-100 p-6">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center">
                        <i class='bx bx-edit'></i>
                    </div>
                    <div>
                        <div class="text-lg font-semibold text-gray-900">Buat Kebutuhan</div>
                        <div class="text-sm text-gray-600">Isi detail kebutuhan agar pelaku usaha dapat mengirim penawaran terbaik</div>
                    </div>
                </div>
                <div class="mt-4 bg-indigo-50 border-l-4 border-indigo-500 rounded-r-xl p-4">
                    <div class="flex items-start gap-2">
                        <i class='bx bx-info-circle text-indigo-600 text-xl'></i>
                        <p class="text-sm text-indigo-800">Judul singkat, deskripsi jelas, dan kisaran budget membantu penjual memahami kebutuhanmu.</p>
                    </div>
                </div>
                <form action="{{ route('needs.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-6">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Judul</label>
                        <div class="relative mt-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class='bx bx-bulb text-gray-400'></i>
                            </div>
                            <input type="text" name="title" value="{{ old('title') }}" class="pl-10 block w-full rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600" required>
                        </div>
                        @error('title') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <div class="relative mt-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class='bx bx-detail text-gray-400'></i>
                            </div>
                            <textarea name="description" class="pl-10 block w-full rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600" rows="4" required>{{ old('description') }}</textarea>
                        </div>
                        @error('description') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Budget Min</label>
                            <div class="relative mt-1">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-400 text-sm">Rp</span>
                                </div>
                                <input type="number" step="0.01" name="budget_min" value="{{ old('budget_min') }}" class="pl-10 block w-full rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600">
                            </div>
                            @error('budget_min') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Budget Max</label>
                            <div class="relative mt-1">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-400 text-sm">Rp</span>
                                </div>
                                <input type="number" step="0.01" name="budget_max" value="{{ old('budget_max') }}" class="pl-10 block w-full rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600">
                            </div>
                            @error('budget_max') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Upload Foto Referensi</label>
                        <div class="mt-1">
                            <input type="file" name="reference_image" accept="image/*" class="block w-full rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600">
                        </div>
                        @error('reference_image') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="pt-2 flex items-center gap-3">
                        <button class="px-5 py-2.5 rounded-lg bg-indigo-600 !text-white shadow hover:bg-indigo-500">Post Kebutuhan</button>
                        <a href="{{ route('needs.latest') }}" class="px-5 py-2.5 rounded-lg bg-white border text-gray-900 shadow-sm">Kebutuhan Terbaru</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
