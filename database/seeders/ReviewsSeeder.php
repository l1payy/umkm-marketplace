<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewsSeeder extends Seeder
{
    public function run(): void
    {
        $orders = Order::where('status', 'completed')->get();
        foreach ($orders as $order) {
            $items = OrderItem::where('order_id', $order->id)
                ->whereNotNull('product_id')
                ->get();
            foreach ($items as $item) {
                if (!$item->product_id) {
                    continue;
                }
                $exists = Review::where('product_id', $item->product_id)
                    ->where('user_id', $order->user_id)
                    ->exists();
                if ($exists) {
                    continue;
                }
                $rating = random_int(4, 5);
                $comments = [
                    'Produk sesuai deskripsi dan kualitas bagus.',
                    'Pengiriman cepat, packing rapi. Recommended!',
                    'Harga oke, performa sesuai harapan.',
                    'Pelayanan toko ramah dan responsif.',
                    'Puas dengan produk ini, akan beli lagi.',
                ];
                Review::create([
                    'product_id' => $item->product_id,
                    'user_id' => $order->user_id,
                    'rating' => $rating,
                    'comment' => $comments[array_rand($comments)],
                ]);
            }
        }
    }
}
