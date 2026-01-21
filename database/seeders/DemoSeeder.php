<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Need;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            // Seed shop users with same password
            $shops = [
                'Handphone','Laptop','Elektronik','Aksesoris','Baju','Celana','Sepatu',
                'Makanan','Minuman','Jasa','Otomotif','Alat Musik','Jam Tangan',
            ];
            foreach ($shops as $name) {
                $email = Str::slug($name).'@example.com';
                User::updateOrCreate(
                    ['email' => $email],
                    [
                        'name' => $name,
                        'password' => Hash::make('p3p3kl4h'),
                        'email_verified_at' => now(),
                    ]
                );
            }

            $user = User::updateOrCreate(
                ['email' => 'demo@example.com'],
                [
                    'name' => 'Demo User',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            );

            $seller = User::updateOrCreate(
                ['email' => 'seller@example.com'],
                [
                    'name' => 'Seller UMKM',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            );

            Product::factory()->count(6)->create([
                'user_id' => $user->id,
            ]);

            Need::factory()->create([
                'user_id' => $user->id,
            ]);

            Need::factory()->create([
                'user_id' => $user->id,
            ]);

            $c = Conversation::firstOrCreate([
                'user_id' => min($user->id, $seller->id),
                'partner_id' => max($user->id, $seller->id),
            ]);

            Message::create([
                'conversation_id' => $c->id,
                'sender_id' => $seller->id,
                'body' => 'Halo! Ada yang bisa dibantu untuk kebutuhan UMKM kamu?',
            ]);
    }
}
