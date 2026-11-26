<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Admin default (Abi Prasetio - Founder PT Anugerah Pratama)
        $adminData = [
            'name'     => 'Abi Prasetio',
            'username' => 'abi_admin',
            'password' => Hash::make('prasetio'),
        ];
        $admin = User::where('username', 'abi_admin')
            ->orWhere('email', 'abi_admin@giftora.com')
            ->orWhere('email', 'admin@giftora.com')
            ->first();

        if ($admin) {
            $admin->update($adminData);
        } else {
            User::create(array_merge($adminData, ['email' => 'abi_admin@giftora.com']));
        }

        $categories = [
            [
                'name' => 'Hampers Lebaran',
                'slug' => 'hampers-lebaran',
                'description' => 'Koleksi parsel anyaman bambu dan kue kering artisan untuk silaturahmi Idulfitri.',
            ],
            [
                'name' => 'Corporate Gift Box',
                'slug' => 'corporate-gift-box',
                'description' => 'Gift box eksklusif untuk klien, mitra bisnis, dan apresiasi karyawan.',
            ],
            [
                'name' => 'Wellness & Spa',
                'slug' => 'wellness-spa',
                'description' => 'Paket relaksasi botani berisi lilin kedelai, minyak esensial, dan perawatan alami.',
            ],
            [
                'name' => 'Tea & Artisan',
                'slug' => 'tea-artisan',
                'description' => 'Kurasi teh pilihan, madu hutan murni, dan perangkat seduh keramik lokal.',
            ],
            [
                'name' => 'Newborn & Baby',
                'slug' => 'newborn-baby',
                'description' => 'Bingkisan kelahiran berbahan katun organik dan kayu alami.',
            ],
            [
                'name' => 'Signature Celebration',
                'slug' => 'signature-celebration',
                'description' => 'Seri unggulan Giftora untuk ulang tahun dan perayaan personal.',
            ],
        ];

        $catModels = [];
        foreach ($categories as $cat) {
            $catModels[$cat['slug']] = Category::create($cat);
        }

        $products = [
            [
                'category_id' => $catModels['hampers-lebaran']->id,
                'name' => 'Raya Serenity Bamboo Hamper',
                'slug' => 'raya-serenity-bamboo-hamper',
                'sku' => 'GFT-RYA-001',
                'price' => 685000,
                'stock' => 18,
                'weight_grams' => 2200,
                'contents_summary' => 'Nastar Wijsman, Kaastengels Keju Tua, Putri Salju, Lidah Kucing, Kurma Medjool, Infuser Teh',
                'description' => 'Dikemas dalam keranjang anyaman bambu berlapis linen cream dengan pita satin sage.',
                'image_path' => 'images/hamper_raya.jpg',
                'is_featured' => true,
            ],
            [
                'category_id' => $catModels['corporate-gift-box']->id,
                'name' => 'Executive Brew & Leather Box',
                'slug' => 'executive-brew-leather-box',
                'sku' => 'GFT-CRP-002',
                'price' => 890000,
                'stock' => 25,
                'weight_grams' => 1850,
                'contents_summary' => 'Kopi Arabika Single-Origin 200g, Dripper Keramik Matte, Jurnal Kulit, Pulpen Kuningan',
                'description' => 'Hantaran korporat berkarakter modern dalam hardbox matte charcoal bermagnet.',
                'image_path' => 'images/hamper_corporate.jpg',
                'is_featured' => true,
            ],
            [
                'category_id' => $catModels['wellness-spa']->id,
                'name' => 'Botanical Calm Wellness Set',
                'slug' => 'botanical-calm-wellness-set',
                'sku' => 'GFT-WLN-003',
                'price' => 475000,
                'stock' => 30,
                'weight_grams' => 1400,
                'contents_summary' => 'Lilin Kedelai Botani 220g, Minyak Esensial Lavender, Sabun Oat & Madu, Handuk Linen',
                'description' => 'Rangkaian relaksasi rumahan yang diracik oleh perajin aromaterapi lokal.',
                'image_path' => 'images/hamper_wellness.jpg',
                'is_featured' => true,
            ],
            [
                'category_id' => $catModels['tea-artisan']->id,
                'name' => 'Artisan Tea Atelier Basket',
                'slug' => 'artisan-tea-atelier-basket',
                'sku' => 'GFT-TEA-004',
                'price' => 595000,
                'stock' => 14,
                'weight_grams' => 2050,
                'contents_summary' => 'Teko Keramik Speckled, Kaleng Teh Earl Grey & Mint, Madu Hutan 290g, Shortbread',
                'description' => 'Set minum teh sore bergaya studio keramik lengkap dengan teko glasir buatan tangan.',
                'image_path' => 'images/hamper_tea.jpg',
                'is_featured' => true,
            ],
            [
                'category_id' => $catModels['newborn-baby']->id,
                'name' => 'Heirloom Newborn Welcome Box',
                'slug' => 'heirloom-newborn-welcome-box',
                'sku' => 'GFT-BBY-005',
                'price' => 740000,
                'stock' => 12,
                'weight_grams' => 1500,
                'contents_summary' => 'Selimut Rajut Katun Organik, Rattle Kayu Beech, Minyak Bayi Chamomile, Kartu Linen',
                'description' => 'Kado penyambutan bayi baru lahir yang lembut, aman, dan penuh makna.',
                'image_path' => 'images/hamper_newborn.jpg',
                'is_featured' => false,
            ],
            [
                'category_id' => $catModels['signature-celebration']->id,
                'name' => 'Giftora Signature Wildflower Box',
                'slug' => 'giftora-signature-wildflower-box',
                'sku' => 'GFT-SGN-006',
                'price' => 540000,
                'stock' => 22,
                'weight_grams' => 1650,
                'contents_summary' => 'Madu Wildflower 250g, Mug Stoneware, Lilin Wild Sage & Oak, Eukaliptus Kering',
                'description' => 'Edisi ikonik Giftora dari PT Anugerah Pratama dalam rigid box linen gading.',
                'image_path' => 'images/hamper_signature.jpg',
                'is_featured' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
