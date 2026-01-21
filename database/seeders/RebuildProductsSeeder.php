<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RebuildProductsSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus produk lama dan bersihkan folder storage/products
        Product::query()->delete();
        if (Storage::disk('public')->exists('products')) {
            Storage::disk('public')->deleteDirectory('products');
        }
        Storage::disk('public')->makeDirectory('products');

        $categories = [
            'handphone' => [
                'shop' => 'Handphone',
                'price' => [1500000, 20000000],
                'names' => [
                    'Smartphone Android layar luas',
                    'iPhone seri performa tinggi',
                    'Handphone kamera jernih untuk konten',
                    'HP baterai besar tahan lama',
                ],
                'desc' => 'Handphone berkualitas dengan performa stabil, cocok untuk komunikasi, hiburan, dan produktivitas harian.',
            ],
            'laptop' => [
                'shop' => 'Laptop',
                'price' => [3000000, 35000000],
                'names' => [
                    'Laptop tipis untuk kerja dan kuliah',
                    'Laptop gaming grafis mantap',
                    'Ultrabook profesional ringan',
                    'Laptop bisnis dengan keamanan tinggi',
                ],
                'desc' => 'Laptop handal untuk berbagai kebutuhan, dilengkapi prosesor cepat dan penyimpanan luas.',
            ],
            'elektronik' => [
                'shop' => 'Elektronik',
                'price' => [100000, 15000000],
                'names' => [
                    'Smart TV resolusi tinggi',
                    'Speaker Bluetooth bass mantap',
                    'Kamera digital hasil tajam',
                    'Perangkat rumah pintar',
                ],
                'desc' => 'Produk elektronik untuk meningkatkan kenyamanan dan hiburan di rumah.',
            ],
            'aksesoris' => [
                'shop' => 'Aksesoris',
                'price' => [20000, 2000000],
                'names' => [
                    'Casing handphone premium',
                    'Headset ergonomis noise-cancelling',
                    'Charger cepat resmi',
                    'Strap smartwatch nyaman',
                ],
                'desc' => 'Aksesoris pelengkap yang fungsional dan stylish untuk perangkat Anda.',
            ],
            'baju' => [
                'shop' => 'Baju',
                'price' => [30000, 800000],
                'names' => [
                    'Kaos katun adem',
                    'Kemeja formal slim fit',
                    'Hoodie fleece hangat',
                    'Blouse wanita elegan',
                ],
                'desc' => 'Pakaian berkualitas dengan bahan nyaman dan potongan rapi untuk gaya sehari-hari.',
            ],
            'celana' => [
                'shop' => 'Celana',
                'price' => [40000, 900000],
                'names' => [
                    'Celana jeans stretch',
                    'Chino kasual rapi',
                    'Jogger sporty ringan',
                    'Celana formal kantor',
                ],
                'desc' => 'Celana nyaman dan tahan lama dengan desain modis untuk berbagai kesempatan.',
            ],
            'sepatu' => [
                'shop' => 'Sepatu',
                'price' => [80000, 2500000],
                'names' => [
                    'Sneakers harian empuk',
                    'Sepatu lari breathable',
                    'Boots kulit klasik',
                    'Flat shoes elegan',
                ],
                'desc' => 'Sepatu berkualitas dengan dukungan kaki yang baik dan tampilan menawan.',
            ],
            'makanan' => [
                'shop' => 'Makanan',
                'price' => [10000, 500000],
                'names' => [
                    'Snack gurih renyah',
                    'Kue premium lembut',
                    'Masakan rumahan beku',
                    'Camilan sehat rendah gula',
                ],
                'desc' => 'Produk makanan lezat yang diolah higienis, cocok untuk teman bekerja dan bersantai.',
            ],
            'minuman' => [
                'shop' => 'Minuman',
                'price' => [10000, 400000],
                'names' => [
                    'Kopi arabika premium',
                    'Teh wangi menyegarkan',
                    'Minuman herbal sehat',
                    'Jus buah asli tanpa pengawet',
                ],
                'desc' => 'Minuman berkualitas untuk menyegarkan hari Anda, dibuat dari bahan pilihan.',
            ],
            'jasa' => [
                'shop' => 'Jasa',
                'price' => [50000, 10000000],
                'names' => [
                    'Jasa servis perangkat elektronik',
                    'Jasa desain grafis profesional',
                    'Jasa foto dan video',
                    'Jasa perbaikan rumah ringan',
                ],
                'desc' => 'Layanan profesional dengan hasil memuaskan, dikerjakan oleh tim berpengalaman.',
            ],
            'otomotif' => [
                'shop' => 'Otomotif',
                'price' => [50000, 15000000],
                'names' => [
                    'Aksesoris motor lengkap',
                    'Sparepart mobil original',
                    'Helm standar SNI',
                    'Oli mesin performa tinggi',
                ],
                'desc' => 'Produk otomotif berkualitas untuk perawatan dan peningkatan performa kendaraan.',
            ],
            'alat musik' => [
                'shop' => 'Alat Musik',
                'price' => [100000, 20000000],
                'names' => [
                    'Gitar akustik resonansi hangat',
                    'Keyboard elektrik fitur lengkap',
                    'Biola pemula suara jernih',
                    'Drum set kompak',
                ],
                'desc' => 'Alat musik untuk pemula hingga profesional dengan kualitas suara yang baik.',
            ],
            'jam tangan' => [
                'shop' => 'Jam Tangan',
                'price' => [50000, 10000000],
                'names' => [
                    'Jam tangan analog klasik',
                    'Smartwatch fitur kesehatan',
                    'Chronograph elegan',
                    'Jam kasual strap kulit',
                ],
                'desc' => 'Jam tangan dengan desain menawan dan akurasi waktu, cocok untuk berbagai gaya.',
            ],
        ];

        foreach ($categories as $folder => $cfg) {
            $shopUser = User::where('name', $cfg['shop'])->first();
            if (!$shopUser) {
                // Skip jika user toko tidak ada
                continue;
            }

            $dir = public_path('images'.DIRECTORY_SEPARATOR.$folder);
            if (!File::exists($dir)) {
                continue;
            }
            $files = collect(File::files($dir))->filter(fn($f) => in_array(strtolower($f->getExtension()), ['jpg','jpeg','png','webp']));

            $index = 0;
            foreach ($files as $file) {
                $index++;
                $name = $cfg['names'][$index % count($cfg['names'])];
                $price = random_int($cfg['price'][0], $cfg['price'][1]);

                $targetName = $folder.'-'.Str::random(8).'.'.$file->getExtension();
                Storage::disk('public')->put('products/'.$targetName, File::get($file->getPathname()));

                Product::create([
                    'user_id' => $shopUser->id,
                    'name' => $name,
                    'description' => $cfg['desc'],
                    'price' => $price,
                    'image_path' => 'products/'.$targetName,
                ]);
            }
        }
    }
}

