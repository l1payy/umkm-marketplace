<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Produk/Jasa</h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow p-6" x-data="{ specs: [{key:'',value:''}], files: [], isDragging: false, onPick(){ $refs.fileInput.click() } }">
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div class="lg:col-span-1">
                            <div class="rounded-lg border border-gray-200 p-4">
                                <div class="text-sm font-medium text-gray-700">Foto Produk</div>
                                <p class="text-xs text-gray-500 mt-1">Unggah beberapa foto. Foto pertama menjadi foto utama.</p>
                                <input x-ref="fileInput" type="file" name="images[]" accept="image/*" multiple class="sr-only" @change="files = [...$event.target.files]">
                                <div class="mt-3 flex items-center gap-3">
                                    <button type="button" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow hover:from-indigo-500 hover:to-purple-500" @click="onPick()">
                                        <i class='bx bx-image-alt text-xl'></i>
                                        <span>Pilih Foto</span>
                                    </button>
                                    <span class="text-xs px-2 py-1 rounded-full bg-indigo-50 text-indigo-700" x-show="files.length" x-text="files.length + ' file'"></span>
                                    <span class="ml-auto text-xs text-gray-500">PNG/JPG maks 4MB</span>
                                </div>
                                <div class="mt-3 rounded-xl border-2 border-dashed p-5 text-center text-sm cursor-pointer transition"
                                     :class="isDragging ? 'border-indigo-500 bg-indigo-50 text-indigo-700' : 'border-gray-300 text-gray-600 hover:border-indigo-400 hover:text-indigo-700'"
                                     @click="onPick()"
                                     @dragover.prevent="isDragging=true"
                                     @dragleave="isDragging=false"
                                     @drop.prevent="isDragging=false; files = [...files, ...$event.dataTransfer.files]">
                                    Tarik & letakkan gambar di sini atau klik tombol di atas
                                </div>
                                @error('images') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                                <div class="mt-3 grid grid-cols-3 gap-2" x-show="files.length">
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
                        <div class="lg:col-span-2">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Kategori Produk</label>
                                    <select name="category" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600">
                                        <option value="">Pilih kategori</option>
                                        <option>Handphone</option>
                                        <option>Laptop</option>
                                        <option>Elektronik</option>
                                        <option>Aksesoris</option>
                                        <option>Baju</option>
                                        <option>Celana</option>
                                        <option>Sepatu</option>
                                        <option>Makanan</option>
                                        <option>Minuman</option>
                                        <option>Jasa</option>
                                        <option>Otomotif</option>
                                        <option>Alat Musik</option>
                                        <option>Jam Tangan</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nama</label>
                                    <input type="text" name="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900" required>
                                    @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Harga</label>
                                    <input type="number" step="0.01" name="price" value="{{ old('price') }}" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900" required>
                                    @error('price') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700">Deskripsi Singkat</label>
                                <textarea name="description" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900" rows="3">{{ old('description') }}</textarea>
                                @error('description') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <label class="text-sm font-medium text-gray-700">Spesifikasi</label>
                            <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
                                                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Merk</label>
                                    <input type="text" name="care_label" value="{{ old('care_label') }}" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Bahan Produk</label>
                                    <input type="text" name="sku" value="{{ old('sku') }}" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Berat Produk</label>
                                    <input type="text" name="material" value="{{ old('material') }}" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900">
                                </div>

                            </div>
                            <div class="mt-6">
                                <div class="flex items-center justify-between">
                                    
                                    <button type="button" class="px-3 py-1 rounded-lg bg-white border text-gray-900 shadow-sm text-sm" @click="specs.push({key:'',value:''})">Tambah Baris Spesifikasi</button>
                                </div>
                                <div class="mt-3 space-y-2">
                                    <template x-for="(row, i) in specs" :key="i">
                                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-2">
                                            <input class="sm:col-span-5 rounded-lg border-gray-300" type="text" :name="'specs_keys['+i+']'" x-model="row.key" placeholder="Nama spesifikasi">
                                            <input class="sm:col-span-6 rounded-lg border-gray-300" type="text" :name="'specs_values['+i+']'" x-model="row.value" placeholder="Nilai spesifikasi">
                                            <button type="button" class="sm:col-span-1 rounded-lg border text-gray-700" @click="specs.splice(i,1)">Hapus</button>
                                        </div>
                                    </template>
                                </div>
                            </div>
                            <div class="mt-6">
                                <label class="block text-sm font-medium text-gray-700">Deskripsi Panjang</label>
                                <textarea name="long_description" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900" rows="6">{{ old('long_description') }}</textarea>
                            </div>
                            <div class="mt-6">
                                <button class="px-5 py-2.5 rounded-lg bg-indigo-600 !text-white shadow hover:bg-indigo-500">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
