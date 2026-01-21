<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductDetailsSeeder extends Seeder
{
    public function run(): void
    {
        $map = [
            'Handphone' => [
                'material' => 'Plastik & Metal',
                'care' => 'Gunakan case, hindari air; bersihkan dengan kain microfiber.',
                'specs' => [
                    'Layar' => 'AMOLED 6.5" FHD+ 120Hz',
                    'Prosesor' => 'Octa-core',
                    'Kamera' => '50MP + 8MP + 2MP',
                    'Baterai' => '5000 mAh fast charge',
                    'Memori' => '8GB/128GB',
                ],
                'desc' => "Smartphone dengan performa stabil, kamera jernih, dan baterai tahan lama. Cocok untuk komunikasi, hiburan, dan produktivitas harian.",
            ],
            'Laptop' => [
                'material' => 'Aluminium & Plastik',
                'care' => 'Jaga ventilasi, bersihkan keyboard; hindari cairan.',
                'specs' => [
                    'Layar' => 'IPS 14\" FHD',
                    'CPU' => 'Intel Core / AMD Ryzen',
                    'GPU' => 'Integrated / Discrete',
                    'RAM' => '8–16GB',
                    'Storage' => 'SSD 256–512GB',
                ],
                'desc' => "Laptop handal untuk kerja dan kuliah dengan prosesor cepat, RAM lega, dan SSD responsif.",
            ],
            'Elektronik' => [
                'material' => 'Beragam',
                'care' => 'Ikuti petunjuk pabrik, bersihkan rutin.',
                'specs' => [
                    'Garansi' => 'Resmi 1 tahun',
                    'Konsumsi Daya' => 'Hemat energi',
                ],
                'desc' => "Produk elektronik untuk kenyamanan dan hiburan di rumah.",
            ],
            'Aksesoris' => [
                'material' => 'Beragam',
                'care' => 'Hindari suhu ekstrem dan cairan.',
                'specs' => [
                    'Kompatibilitas' => 'Universal / model tertentu',
                    'Warna' => 'Pilihan variatif',
                ],
                'desc' => "Aksesoris pelengkap fungsional untuk perangkat Anda.",
            ],
            'Baju' => [
                'material' => 'Katun',
                'care' => 'Cuci menggunakan deterjen lembut.',
                'specs' => [
                    'Bahan' => 'Katun Combed 24s - Extra Soft',
                    'Sablon' => 'Plastisol awet',
                    'Kenyamanan' => 'Sejuk dan nyaman dipakai',
                ],
                'desc' => "Pakaian berkualitas dengan bahan nyaman dan potongan rapi untuk gaya sehari-hari.",
            ],
            'Celana' => [
                'material' => 'Katun / Denim',
                'care' => 'Cuci terbalik, hindari pemutih.',
                'specs' => [
                    'Potongan' => 'Slim / Regular',
                    'Bahan' => 'Denim stretch / Chino',
                ],
                'desc' => "Celana nyaman dan tahan lama dengan desain modis.",
            ],
            'Sepatu' => [
                'material' => 'Kanvas / Kulit',
                'care' => 'Bersihkan kering, simpan di tempat sejuk.',
                'specs' => [
                    'Sol' => 'Anti-slip',
                    'Kenyamanan' => 'Insole empuk',
                ],
                'desc' => "Sepatu berkualitas dengan dukungan kaki yang baik.",
            ],
            'Makanan' => [
                'material' => null,
                'care' => 'Simpan sesuai petunjuk kemasan.',
                'specs' => [
                    'BPOM/NA' => 'Jika berlaku',
                    'Tanggal Kedaluwarsa' => 'Tertera di kemasan',
                ],
                'desc' => "Produk makanan lezat dan higienis.",
            ],
            'Minuman' => [
                'material' => null,
                'care' => 'Simpan dingin untuk kesegaran.',
                'specs' => [
                    'Komposisi' => 'Bahan pilihan',
                ],
                'desc' => "Minuman berkualitas untuk menyegarkan hari Anda.",
            ],
            'Jasa' => [
                'material' => null,
                'care' => null,
                'specs' => [
                    'Jenis Layanan' => 'Profesional',
                    'Durasi' => 'Bervariasi',
                ],
                'desc' => "Layanan profesional dikerjakan oleh tim berpengalaman.",
            ],
            'Otomotif' => [
                'material' => 'Beragam',
                'care' => 'Ikuti rekomendasi pabrikan.',
                'specs' => [
                    'Compat' => 'Tipe kendaraan tertentu',
                ],
                'desc' => "Produk otomotif untuk perawatan dan peningkatan performa.",
            ],
            'Alat Musik' => [
                'material' => 'Kayu / Metal',
                'care' => 'Simpan di suhu stabil, gunakan case.',
                'specs' => [
                    'Nada' => 'Stabil',
                ],
                'desc' => "Alat musik dengan kualitas suara yang baik.",
            ],
            'Jam Tangan' => [
                'material' => 'Stainless / Kulit',
                'care' => 'Hindari air jika bukan waterproof.',
                'specs' => [
                    'Mesin' => 'Quartz / Automatic',
                ],
                'desc' => "Jam tangan akurat dengan tampilan elegan.",
            ],
        ];

        Product::with('user')->chunk(100, function ($products) use ($map) {
            foreach ($products as $p) {
                $shop = $p->user?->name;
                $cfg = $map[$shop] ?? [
                    'material' => null,
                    'care' => null,
                    'specs' => [],
                    'desc' => $p->description ?? 'Produk berkualitas.',
                ];
                ProductDetail::updateOrCreate(
                    ['product_id' => $p->id],
                    [
                        'sku' => 'SKU-'.Str::upper(Str::random(8)),
                        'material' => $cfg['material'],
                        'care_label' => $cfg['care'],
                        'specs' => $cfg['specs'],
                        'long_description' => $cfg['desc']."\n\nReseller dan dropshipper dipersilakan. Dapatkan diskon spesial dari pabrik langsung.",
                    ]
                );
            }
        });
    }
}

