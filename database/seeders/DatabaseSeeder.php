<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Vendor;
use App\Models\Package;
use App\Models\PromoCode;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin ─────────────────────────────────────────────────────────────
        $admin = User::updateOrCreate(
            ['email' => 'admin@indonesialuxe.com'],
            [
                'name' => 'Admin Indonesia Luxe',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // ── Demo User ─────────────────────────────────────────────────────────
        $user = User::updateOrCreate(
            ['email' => 'user@demo.com'],
            [
                'name' => 'Demo User',
                'password' => Hash::make('password'),
                'role' => 'user',
                'phone' => '081234567890',
            ]
        );

        // ── Demo Vendor ───────────────────────────────────────────────────────
        $vendorUser = User::updateOrCreate(
            ['email' => 'vendor@demo.com'],
            [
                'name' => 'Demo Vendor',
                'password' => Hash::make('password'),
                'role' => 'vendor',
                'phone' => '081987654321',
            ]
        );

        $vendor = Vendor::updateOrCreate(
            ['user_id' => $vendorUser->id],
            [
                'business_name' => 'Indonesia Adventure Co.',
                'status' => 'approved',
                'description' => 'Tour operator terbaik di Indonesia',
            ]
        );

        // ── Categories ────────────────────────────────────────────────────────
        $categories = [
            ['name' => 'Open Trip', 'icon' => 'users', 'image' => 'https://images.unsplash.com/photo-1594805938422-b330ad42a7bb?w=400'],
            ['name' => 'Private Tour', 'icon' => 'compass', 'image' => 'https://images.unsplash.com/photo-1728049006343-9ee0187643d5?w=400'],
            ['name' => 'Hiking / Camping', 'icon' => 'tent', 'image' => 'https://images.unsplash.com/photo-1607672390383-aa666b4761ea?w=400'],
            ['name' => 'Rafting', 'icon' => 'waves', 'image' => 'https://images.unsplash.com/photo-1711024069413-d3b1bb99cfaf?w=400'],
            ['name' => 'Snorkeling / Diving', 'icon' => 'ship', 'image' => 'https://images.unsplash.com/photo-1746211516723-c4cd447ec665?w=400'],
            ['name' => 'Jeep Adventure', 'icon' => 'car', 'image' => 'https://images.unsplash.com/photo-1759741753063-a3d126020677?w=400'],
            ['name' => 'Local Experience', 'icon' => 'heart', 'image' => 'https://images.unsplash.com/photo-1769485016794-03c4834c02d9?w=400'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['name' => $cat['name']], $cat);
        }

        // ── Sample Packages ───────────────────────────────────────────────────
        $packages = [
            [
                'title' => 'Open Trip Labuan Bajo & Komodo Island 3D2N',
                'description' => 'Jelajahi keindahan Labuan Bajo dan Pulau Komodo dalam perjalanan 3 hari 2 malam yang tak terlupakan.',
                'duration' => '3 Hari 2 Malam',
                'original_price' => 4000000,
                'discounted_price' => 3500000,
                'rating' => 4.8,
                'review_count' => 124,
                'status' => 'approved',
                'category_name' => 'Open Trip',
                'image' => 'https://images.unsplash.com/photo-1694271486260-1a1859d4c745?w=600',
                'inclusions' => ['Kapal phinisi', 'Meals 3x sehari', 'Snorkeling gear', 'Guide lokal'],
                'itinerary' => ['Day 1: Labuan Bajo - Rinca Island', 'Day 2: Komodo - Pink Beach', 'Day 3: Manta Point - Finish'],
            ],
            [
                'title' => 'Private Tour Bali Cultural Experience 2D1N',
                'description' => 'Nikmati pengalaman budaya Bali yang autentik dengan private tour eksklusif.',
                'duration' => '2 Hari 1 Malam',
                'original_price' => 3200000,
                'discounted_price' => 2800000,
                'rating' => 4.9,
                'review_count' => 89,
                'status' => 'approved',
                'category_name' => 'Private Tour',
                'image' => 'https://images.unsplash.com/photo-1594805938422-b330ad42a7bb?w=600',
                'inclusions' => ['Private car + driver', 'Hotel 4-star', 'Breakfast', 'Entrance ticket'],
                'itinerary' => ['Day 1: Ubud - Tegallalang - Tirta Empul', 'Day 2: Uluwatu Temple - Kecak Dance'],
            ],
            [
                'title' => 'Hiking Mount Bromo Sunrise Adventure',
                'description' => 'Saksikan sunrise spektakuler dari puncak Gunung Bromo.',
                'duration' => '1 Hari',
                'original_price' => 1200000,
                'discounted_price' => 1200000,
                'rating' => 4.7,
                'review_count' => 210,
                'status' => 'approved',
                'category_name' => 'Hiking / Camping',
                'image' => 'https://images.unsplash.com/photo-1559628233-e9287b161a30?w=600',
                'inclusions' => ['Jeep 4x4', 'Guide', 'Masker', 'Breakfast'],
                'itinerary' => ['02:00 Pick up', '04:00 Penanjakan viewpoint', '06:00 Bromo crater', '09:00 Finish'],
            ],
            [
                'title' => 'Rafting Sungai Ayung Bali - Full Day',
                'description' => 'Arung jeram seru di Sungai Ayung Bali sepanjang 12km.',
                'duration' => '1 Hari',
                'original_price' => 950000,
                'discounted_price' => 850000,
                'rating' => 4.6,
                'review_count' => 156,
                'status' => 'approved',
                'category_name' => 'Rafting',
                'image' => 'https://images.unsplash.com/photo-1711024069413-d3b1bb99cfaf?w=600',
                'inclusions' => ['Equipment lengkap', 'Guide profesional', 'Lunch buffet', 'Insurance'],
                'itinerary' => ['08:00 Pick up', '09:30 Start rafting', '12:00 Lunch', '13:00 Finish'],
            ],
            [
                'title' => 'Snorkeling Raja Ampat Premium 4D3N',
                'description' => 'Eksplorasi surga bawah laut Raja Ampat dengan snorkeling dan diving.',
                'duration' => '4 Hari 3 Malam',
                'original_price' => 9000000,
                'discounted_price' => 8500000,
                'rating' => 5.0,
                'review_count' => 45,
                'status' => 'approved',
                'category_name' => 'Snorkeling / Diving',
                'image' => 'https://images.unsplash.com/photo-1696855179868-9c40f02b4706?w=600',
                'inclusions' => ['Speedboat', 'Homestay', '3 meals/day', 'Snorkeling gear', 'Guide'],
                'itinerary' => ['Day 1: Sorong - Waisai', 'Day 2: Pianemo - Wayag', 'Day 3: Cape Kri', 'Day 4: Return'],
            ],
            [
                'title' => 'Jeep Adventure Merapi Lava Tour',
                'description' => 'Jelajahi jalur lava Gunung Merapi dengan jeep 4x4.',
                'duration' => '3 Jam',
                'original_price' => 450000,
                'discounted_price' => 450000,
                'rating' => 4.5,
                'review_count' => 320,
                'status' => 'approved',
                'category_name' => 'Jeep Adventure',
                'image' => 'https://images.unsplash.com/photo-1759741753063-a3d126020677?w=600',
                'inclusions' => ['Jeep 4x4', 'Driver', 'Masker', 'Air mineral'],
                'itinerary' => ['Pick up', 'Bunker Kaliadem', 'Mini Museum', 'Sungai Gendol', 'Finish'],
            ],
            [
                'title' => 'Local Experience: Belajar Batik di Solo',
                'description' => 'Pelajari seni membatik tradisional langsung dari pengrajin batik di Solo.',
                'duration' => '4 Jam',
                'original_price' => 350000,
                'discounted_price' => 350000,
                'rating' => 4.9,
                'review_count' => 67,
                'status' => 'approved',
                'category_name' => 'Local Experience',
                'image' => 'https://images.unsplash.com/photo-1769485016794-03c4834c02d9?w=600',
                'inclusions' => ['Material batik', 'Instruktur', 'Snack & tea', 'Lunch tradisional'],
                'itinerary' => ['09:00 Intro batik', '10:00 Praktik', '12:00 Lunch', '13:00 Finishing'],
            ],
            [
                'title' => 'Camping Glamping Pangalengan 2D1N',
                'description' => 'Glamping mewah di Pangalengan dengan pemandangan perkebunan teh.',
                'duration' => '2 Hari 1 Malam',
                'original_price' => 1800000,
                'discounted_price' => 1500000,
                'rating' => 4.8,
                'review_count' => 98,
                'status' => 'approved',
                'category_name' => 'Hiking / Camping',
                'image' => 'https://images.unsplash.com/photo-1607672390383-aa666b4761ea?w=600',
                'inclusions' => ['Tent fully furnished', 'BBQ dinner', 'Breakfast', 'Bonfire kit'],
                'itinerary' => ['Day 1: Check-in 14:00 - BBQ 19:00', 'Day 2: Breakfast - Checkout 12:00'],
            ],
        ];

        foreach ($packages as $pkg) {
            $category = Category::where('name', $pkg['category_name'])->first();
            Package::updateOrCreate(
                ['title' => $pkg['title']],
                [
                    'slug' => Str::slug($pkg['title']) . '-' . Str::random(6),
                    'vendor_id' => $vendor->id,
                    'category_id' => $category?->id,
                    'description' => $pkg['description'],
                    'duration' => $pkg['duration'],
                    'original_price' => $pkg['original_price'],
                    'discounted_price' => $pkg['discounted_price'],
                    'image' => $pkg['image'],
                    'gallery' => [$pkg['image']],
                    'inclusions' => $pkg['inclusions'],
                    'itinerary' => $pkg['itinerary'],
                    'rating' => $pkg['rating'],
                    'review_count' => $pkg['review_count'],
                    'status' => 'approved',
                ]
            );
        }

        // ── Promo Codes ───────────────────────────────────────────────────────
        $promos = [
            ['code' => 'LUXENEW20', 'discount_type' => 'percent', 'discount_value' => 20, 'min_price' => 500000, 'label' => 'Diskon 20% Semua Tour – Pengguna Baru', 'promo_group' => 'Pengguna Baru', 'period' => '01 Jan – 31 Des 2026'],
            ['code' => 'LUXENEW10', 'discount_type' => 'percent', 'discount_value' => 10, 'min_price' => 250000, 'label' => 'Diskon 10% Open Trip – Pengguna Baru', 'category' => 'Open Trip', 'promo_group' => 'Pengguna Baru', 'period' => '01 Jan – 31 Des 2026'],
            ['code' => 'LUXEFIRST', 'discount_type' => 'flat', 'discount_value' => 150000, 'min_price' => 600000, 'label' => 'Hemat Rp 150.000 Private Tour', 'category' => 'Private Tour', 'promo_group' => 'Pengguna Baru', 'period' => '01 Jan – 31 Des 2026'],
            ['code' => 'LUXEB1G1', 'discount_type' => 'percent', 'discount_value' => 15, 'min_price' => 0, 'label' => 'Buy 1 Get 1 Open Trip – Diskon 15%', 'category' => 'Open Trip', 'promo_group' => 'Pengguna Baru', 'period' => '01 Feb – 28 Feb 2026'],
            ['code' => 'LUXEWEEKEND15', 'discount_type' => 'percent', 'discount_value' => 15, 'min_price' => 400000, 'label' => 'Diskon 15% Semua Aktivitas Weekend', 'promo_group' => 'Weekend Getaway', 'period' => 'Setiap Sabtu–Minggu 2026'],
            ['code' => 'LUXEHIKE10', 'discount_type' => 'percent', 'discount_value' => 10, 'min_price' => 300000, 'label' => 'Diskon 10% Hiking & Camping', 'category' => 'Hiking / Camping', 'promo_group' => 'Weekend Getaway', 'period' => 'Setiap Sabtu–Minggu 2026'],
            ['code' => 'LUXEBIRD20', 'discount_type' => 'percent', 'discount_value' => 20, 'min_price' => 0, 'label' => 'Early Bird H-7: Diskon 20%', 'promo_group' => 'Weekend Getaway', 'period' => 'Setiap Sabtu–Minggu 2026'],
            ['code' => 'LUXEGROUP20', 'discount_type' => 'percent', 'discount_value' => 20, 'min_price' => 0, 'label' => 'Diskon 20% Grup 5–9 Orang', 'promo_group' => 'Group Deals', 'period' => 'Sepanjang Tahun 2026'],
            ['code' => 'LUXEGROUP25', 'discount_type' => 'percent', 'discount_value' => 25, 'min_price' => 0, 'label' => 'Diskon 25% + Free 1 Pax – Grup 10–19 Orang', 'promo_group' => 'Group Deals', 'period' => 'Sepanjang Tahun 2026'],
            ['code' => 'LUXEGROUP30', 'discount_type' => 'percent', 'discount_value' => 30, 'min_price' => 0, 'label' => 'Diskon 30% + Free Guide Privat – Grup 20+ Orang', 'promo_group' => 'Group Deals', 'period' => 'Sepanjang Tahun 2026'],
            ['code' => 'LUXETRANSFER', 'discount_type' => 'flat', 'discount_value' => 100000, 'min_price' => 0, 'label' => 'Gratis Airport Transfer – Semua Grup', 'promo_group' => 'Group Deals', 'period' => 'Sepanjang Tahun 2026'],
        ];

        foreach ($promos as $promo) {
            PromoCode::updateOrCreate(['code' => $promo['code']], array_merge($promo, ['is_active' => true]));
        }
    }
}
