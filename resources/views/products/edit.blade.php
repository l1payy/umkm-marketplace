<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-900 leading-tight">Edit Produk</h2>
                <p class="text-sm text-gray-600">Perbarui informasi produk kamu</p>
            </div>
        </div>
    </x-slot>

    @php
        $existingSpecs = [];
        if($product->detail && $product->detail->specs) {
            foreach($product->detail->specs as $k => $v) {
                $existingSpecs[] = ['key' => $k, 'value' => $v];
            }
        }
        if(empty($existingSpecs)) {
            $existingSpecs[] = ['key' => '', 'value' => ''];
        }
        // Pastikan json valid dan aman dimasukkan ke JS
        $specsJson = json_encode($existingSpecs);
    @endphp

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow ring-1 ring-gray-100 p-6" 
                 x-data="{ specs: {{ $specsJson }}, files: [], isDragging: false, onPick(){ $refs.fileInput.click() } }">
                
                <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Left Column: Image -->
                        <div class="lg:col-span-1">
                            <div class="rounded-lg border border-gray-200 p-4">
                                <div class="text-sm font-medium text-gray-700">Foto Produk</div>
                                <p class="text-xs text-gray-500 mt-1">Unggah foto baru untuk mengganti yang lama.</p>
                                
                                <!-- Current Image Preview -->
                                @if($product->image_path)
                                    <div class="mt-3 mb-3">
                                        <p class="text-xs text-gray-500 mb-1">Foto Saat Ini:</p>
                                        <img src="{{ asset('storage/'.$product->image_path) }}" alt="Current Product Image" class="w-full rounded-lg object-cover aspect-square border border-gray-200">
                                    </div>
                                @endif

                                <input x-ref="fileInput" type="file" name="image" accept="image/*" class="sr-only" @change="files = [...$event.target.files]">
                                
                                <div class="mt-3 flex items-center gap-3">
                                    <button type="button" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow hover:from-indigo-500 hover:to-purple-500" @click="onPick()">
                                        <i class='bx bx-image-alt text-xl'></i>
                                        <span>Ganti Foto</span>
                                    </button>
                                    <span class="text-xs px-2 py-1 rounded-full bg-indigo-50 text-indigo-700" x-show="files.length" x-text="files.length + ' file baru'"></span>
                                </div>
                                
                                <div class="mt-3 rounded-xl border-2 border-dashed p-5 text-center text-sm cursor-pointer transition"
                                     :class="isDragging ? 'border-indigo-500 bg-indigo-50 text-indigo-700' : 'border-gray-300 text-gray-600 hover:border-indigo-400 hover:text-indigo-700'"
                                     @click="onPick()"
                                     @dragover.prevent="isDragging=true"
                                     @dragleave="isDragging=false"
                                     @drop.prevent="isDragging=false; files = [...files, ...$event.dataTransfer.files]">
                                    Tarik & letakkan gambar baru di sini
                                </div>
                                @error('image') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                                
                                <!-- New File Preview -->
                                <div class="mt-3" x-show="files.length">
                                    <p class="text-xs text-gray-500 mb-1">Preview Foto Baru:</p>
                                    <template x-for="(f,idx) in files" :key="idx">
                                        <div class="relative aspect-square rounded-lg overflow-hidden border bg-white">
                                            <img :src="URL.createObjectURL(f)" class="w-full h-full object-cover">
                                            <button type="button" class="absolute top-1 right-1 bg-white/90 border border-gray-200 text-gray-700 rounded-full w-7 h-7 flex items-center justify-center shadow hover:bg-white" @click="files.splice(idx,1)">
                                                <i class='bx bx-x text-lg'></i>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Form Fields -->
                        <div class="lg:col-span-2">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Kategori Produk</label>
                                    <select name="category" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600">
                                        <option value="">Pilih kategori</option>
                                        @foreach(['Handphone','Laptop','Elektronik','Aksesoris','Baju','Celana','Sepatu','Makanan','Minuman','Jasa','Otomotif','Alat Musik','Jam Tangan'] as $cat)
                                            <option value="{{ $cat }}" {{ old('category', $product->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nama</label>
                                    <input type="text" name="name" value="{{ old('name', $product->name) }}" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600" required>
                                    @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Harga</label>
                                    <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600" required>
                                    @error('price') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700">Deskripsi Singkat</label>
                                <textarea name="description" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600" rows="3">{{ old('description', $product->description) }}</textarea>
                                @error('description') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="mt-6 border-t pt-6">
                                <h3 class="text-md font-medium text-gray-900 mb-4">Detail & Spesifikasi</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Merk</label>
                                        <input type="text" name="care_label" value="{{ old('care_label', $product->detail->care_label ?? '') }}" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Bahan Produk</label>
                                        <input type="text" name="sku" value="{{ old('sku', $product->detail->sku ?? '') }}" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Berat Produk</label>
                                        <input type="text" name="material" value="{{ old('material', $product->detail->material ?? '') }}" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600">
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <div class="flex items-center justify-between mb-2">
                                        <label class="block text-sm font-medium text-gray-700">Spesifikasi Tambahan</label>
                                        <button type="button" class="px-3 py-1 rounded-lg bg-white border text-gray-900 shadow-sm text-sm hover:bg-gray-50" @click="specs.push({key:'',value:''})">
                                            + Tambah Baris
                                        </button>
                                    </div>
                                    <div class="space-y-2">
                                        <template x-for="(row, i) in specs" :key="i">
                                            <div class="grid grid-cols-1 sm:grid-cols-12 gap-2">
                                                <input class="sm:col-span-5 rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600" type="text" :name="'specs_keys['+i+']'" x-model="row.key" placeholder="Nama (misal: Warna)">
                                                <input class="sm:col-span-6 rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600" type="text" :name="'specs_values['+i+']'" x-model="row.value" placeholder="Nilai (misal: Merah)">
                                                <button type="button" class="sm:col-span-1 rounded-lg border border-red-200 text-red-600 hover:bg-red-50 flex items-center justify-center" @click="specs.splice(i,1)" title="Hapus Baris">
                                                    <i class='bx bx-trash'></i>
                                                </button>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <label class="block text-sm font-medium text-gray-700">Deskripsi Panjang</label>
                                    <textarea name="long_description" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600" rows="6">{{ old('long_description', $product->detail->long_description ?? '') }}</textarea>
                                </div>
                            </div>

                            <div class="mt-6 flex items-center justify-between pt-6 border-t">
                                <a href="{{ route('products.show', $product) }}" class="text-sm text-gray-600 hover:text-gray-900">Batal</a>
                                <button type="submit" class="bg-indigo-600 !text-white px-6 py-2.5 rounded-lg shadow hover:bg-indigo-700 transition">Simpan Perubahan</button>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="mt-8 pt-6 border-t border-gray-100">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Ingin menghapus produk ini?</span>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini? Tindakan ini tidak dapat dibatalkan.')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 text-sm hover:text-red-800 font-medium">Hapus Produk</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
