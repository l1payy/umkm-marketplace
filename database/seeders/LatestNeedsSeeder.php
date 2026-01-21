<?php

namespace Database\Seeders;

use App\Models\Need;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class LatestNeedsSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        if ($users->count() < 2) {
            return;
        }

        $imageRoot = public_path('images');
        if (!File::exists($imageRoot)) {
            return;
        }

        $files = collect(File::allFiles($imageRoot))
            ->filter(fn($f) => in_array(strtolower($f->getExtension()), ['jpg','jpeg','png','webp']))
            ->take(40);

        $titles = [
            'Butuh Handphone untuk kerja harian',
            'Laptop untuk desain grafis',
            'Speaker Bluetooth untuk acara',
            'Kaos polos bahan nyaman',
            'Sepatu lari anti selip',
            'Jasa servis AC panggilan',
            'Kamera mirrorless untuk konten',
            'Meja kerja minimalis',
            'Jam tangan kasual pria',
            'Charger cepat resmi',
        ];

        $descs = [
            'Cari produk berkualitas dengan harga terjangkau. Prioritas yang ready stock.',
            'Butuh segera, bisa COD atau kirim cepat. Garansi diutamakan.',
            'Tolong rekomendasikan yang awet dan sesuai kebutuhan.',
            'Fokus pada performa dan kenyamanan penggunaan harian.',
        ];

        $offers = [
            'Produk original bergaransi resmi. Siap kirim hari ini.',
            'Kualitas terjamin, ada bonus aksesoris. Harga boleh nego.',
            'Unit siap pakai, free ongkir area terdekat.',
            'Stok terbatas, bisa pesan warna. Pengiriman kilat.',
        ];

        $created = 0;
        foreach ($files as $file) {
            if ($created >= 20) {
                break;
            }

            $owner = $users->random();
            $others = $users->where('id', '!=', $owner->id);
            if ($others->isEmpty()) {
                continue;
            }
            $offerer = $others->random();

            $refName = 'ref-'.uniqid().'.'.$file->getExtension();
            Storage::disk('public')->put('references/'.$refName, File::get($file->getPathname()));

            $min = random_int(100000, 1000000);
            $max = random_int($min + 100000, $min + 1000000);
            $need = Need::create([
                'user_id' => $owner->id,
                'title' => $titles[array_rand($titles)],
                'description' => $descs[array_rand($descs)],
                'budget_min' => $min,
                'budget_max' => $max,
                'reference_image_path' => 'references/'.$refName,
                'status' => 'open',
            ]);

            $offerImgName = 'offer-'.uniqid().'.'.$file->getExtension();
            Storage::disk('public')->put('offers/'.$offerImgName, File::get($file->getPathname()));
            $price = random_int($min, $max);
            Offer::create([
                'need_id' => $need->id,
                'user_id' => $offerer->id,
                'description' => $offers[array_rand($offers)],
                'price' => $price,
                'eta_days' => random_int(1, 7),
                'image_path' => 'offers/'.$offerImgName,
            ]);

            $created++;
        }
    }
}
