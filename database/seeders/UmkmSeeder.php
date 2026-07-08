<?php

namespace Database\Seeders;

use App\Models\Umkm;
use App\Models\UmkmCategory;
use Illuminate\Database\Seeder;

class UmkmSeeder extends Seeder
{
    public function run(): void
    {
        $makanan = UmkmCategory::where('slug', 'makanan')->first();
        $produk = UmkmCategory::where('slug', 'produk')->first();
        $jasa = UmkmCategory::where('slug', 'jasa')->first();

        $items = [
            // Makanan
            [
                'category_id' => $makanan->id,
                'title' => ['id' => 'Joglo Belimo', 'en' => 'Joglo Belimo'],
                'description' => [
                    'id' => 'Menjual aneka donat dan bakery buatan rumahan. Kontak Ibu Fika.',
                    'en' => 'Sells various homemade donuts and bakery. Contact Ibu Fika.',
                ],
                'phone' => '081210839779',
            ],
            [
                'category_id' => $makanan->id,
                'title' => ['id' => 'Lepet Jagung Menuk', 'en' => 'Lepet Jagung Menuk'],
                'description' => [
                    'id' => 'Menyediakan lepet jagung khas buatan Ibu Rohanti.',
                    'en' => 'Provides traditional lepet jagung made by Ibu Rohanti.',
                ],
                'phone' => '081575274207',
            ],
            [
                'category_id' => $makanan->id,
                'title' => ['id' => 'Warung Mama Hana', 'en' => 'Warung Mama Hana'],
                'description' => [
                    'id' => 'Menyajikan tahu penyet, mie ayam, dan tempura. Kontak Ibu Ruri.',
                    'en' => 'Serves tahu penyet, chicken noodles, and tempura. Contact Ibu Ruri.',
                ],
                'phone' => '083841659957',
            ],
            [
                'category_id' => $makanan->id,
                'title' => ['id' => 'Es Teler Bunda Hilya', 'en' => 'Es Teler Bunda Hilya'],
                'description' => [
                    'id' => 'Menjual es teler segar buatan Ibu Badriyah.',
                    'en' => 'Sells fresh es teler made by Ibu Badriyah.',
                ],
                'phone' => '085747811055',
            ],
            [
                'category_id' => $makanan->id,
                'title' => ['id' => 'Pempek Kajoku', 'en' => 'Pempek Kajoku'],
                'description' => [
                    'id' => 'Menjual pempek khas buatan Ibu Tasning Rumawati.',
                    'en' => 'Sells authentic pempek made by Ibu Tasning Rumawati.',
                ],
                'phone' => '088983011454',
            ],
            [
                'category_id' => $makanan->id,
                'title' => ['id' => 'Warung Bu Pairah', 'en' => 'Warung Bu Pairah'],
                'description' => [
                    'id' => 'Menyediakan sego wiwit, bubur sayur, gorengan, dan mie kuning.',
                    'en' => 'Provides sego wiwit, vegetable porridge, fried snacks, and yellow noodles.',
                ],
                'phone' => null,
            ],
            [
                'category_id' => $makanan->id,
                'title' => ['id' => 'Cilok Jaya', 'en' => 'Cilok Jaya'],
                'description' => [
                    'id' => 'Menjual cilok kacang khas buatan Arin.',
                    'en' => 'Sells authentic peanut cilok made by Arin.',
                ],
                'phone' => '085848700037',
            ],
            [
                'category_id' => $makanan->id,
                'title' => ['id' => 'Tamanan Snack', 'en' => 'Tamanan Snack'],
                'description' => [
                    'id' => 'Menyediakan aneka jajanan tradisional: coromawar, semar mendem, apem (Bang Udin), serta tahu bakso, risoles, arem-arem, dadar gulung, dan mendhut (Bu Sani). Kontak Bu Nurul.',
                    'en' => 'Provides various traditional snacks: coromawar, semar mendem, apem (Bang Udin), and tofu meatballs, risoles, arem-arem, dadar gulung, mendhut (Bu Sani). Contact Bu Nurul.',
                ],
                'phone' => '087738770075',
            ],
            [
                'category_id' => $makanan->id,
                'title' => ['id' => 'Kedai Kekinian', 'en' => 'Kedai Kekinian'],
                'description' => [
                    'id' => 'Menjual seblak ndeso khas buatan Ilham.',
                    'en' => 'Sells authentic seblak ndeso made by Ilham.',
                ],
                'phone' => '083872033524',
            ],

            // Produk
            [
                'category_id' => $produk->id,
                'title' => ['id' => 'Loena', 'en' => 'Loena'],
                'description' => [
                    'id' => 'Menjual keripik lidah buaya buatan Bu Hani.',
                    'en' => 'Sells aloe vera chips made by Bu Hani.',
                ],
                'phone' => '081991402883',
            ],
            [
                'category_id' => $produk->id,
                'title' => ['id' => 'Browconis', 'en' => 'Browconis'],
                'description' => [
                    'id' => 'Menjual brownies buatan Bu Nopiyanti.',
                    'en' => 'Sells brownies made by Bu Nopiyanti.',
                ],
                'phone' => '082134345104',
            ],
            [
                'category_id' => $produk->id,
                'title' => ['id' => 'Talazza', 'en' => 'Talazza'],
                'description' => [
                    'id' => 'Menjual keripik talas buatan Bu Pinarti.',
                    'en' => 'Sells taro chips made by Bu Pinarti.',
                ],
                'phone' => '082328140944',
            ],
            [
                'category_id' => $produk->id,
                'title' => ['id' => 'Peyek Ibu Dwi', 'en' => 'Peyek Ibu Dwi'],
                'description' => [
                    'id' => 'Menjual peyek buatan rumahan khas Ibu Dwi.',
                    'en' => 'Sells homemade peyek by Ibu Dwi.',
                ],
                'phone' => null,
            ],
            [
                'category_id' => $produk->id,
                'title' => ['id' => 'Stick Lidah Buaya Vilova', 'en' => 'Vilova Aloe Vera Sticks'],
                'description' => [
                    'id' => 'Menjual stick lidah buaya buatan Bu Titi Yulianti.',
                    'en' => 'Sells aloe vera sticks made by Bu Titi Yulianti.',
                ],
                'phone' => '081328171515',
            ],
            [
                'category_id' => $produk->id,
                'title' => ['id' => 'Pupuk Limbah Tamanan', 'en' => 'Tamanan Organic Fertilizer'],
                'description' => [
                    'id' => 'Menjual pupuk hasil olahan limbah warga Tamanan.',
                    'en' => 'Sells fertilizer made from processed Tamanan community waste.',
                ],
                'phone' => '085878347481',
            ],

            // Jasa
            [
                'category_id' => $jasa->id,
                'title' => ['id' => 'Karnaminik', 'en' => 'Karnaminik'],
                'description' => [
                    'id' => 'Kerajinan kulit berupa tas kulit dan dompet kulit.',
                    'en' => 'Leather crafts including leather bags and wallets.',
                ],
                'phone' => '085601266849',
            ],
            [
                'category_id' => $jasa->id,
                'title' => ['id' => 'House of Amora', 'en' => 'House of Amora'],
                'description' => [
                    'id' => 'Kerajinan kulit berupa tas kulit, dompet kulit, ikat pinggang kulit, dan aksesoris.',
                    'en' => 'Leather crafts including bags, wallets, belts, and accessories.',
                ],
                'phone' => '082227042929',
            ],
            [
                'category_id' => $jasa->id,
                'title' => ['id' => 'Bekti Ratna MUA', 'en' => 'Bekti Ratna MUA'],
                'description' => [
                    'id' => 'Jasa make up untuk berbagai acara.',
                    'en' => 'Makeup services for various events.',
                ],
                'phone' => '08126640207',
            ],
            [
                'category_id' => $jasa->id,
                'title' => ['id' => 'Laundry Bu Siti', 'en' => 'Laundry Bu Siti'],
                'description' => [
                    'id' => 'Jasa laundry Rp8.000/kg, setrika Rp5.000/kg, dan seprei satuan Rp10.000–20.000.',
                    'en' => 'Laundry service Rp8,000/kg, ironing Rp5,000/kg, and bed sheets Rp10,000–20,000 each.',
                ],
                'phone' => '083841553519',
            ],
            [
                'category_id' => $jasa->id,
                'title' => ['id' => 'Laundry Bu Asih', 'en' => 'Laundry Bu Asih'],
                'description' => [
                    'id' => 'Jasa laundry Rp8.000/kg, setrika Rp5.000/kg, dan seprei satuan Rp10.000–20.000.',
                    'en' => 'Laundry service Rp8,000/kg, ironing Rp5,000/kg, and bed sheets Rp10,000–20,000 each.',
                ],
                'phone' => '083181231264',
            ],
            [
                'category_id' => $jasa->id,
                'title' => ['id' => 'Salon Nadia Totok Aura', 'en' => 'Salon Nadia Totok Aura'],
                'description' => [
                    'id' => 'Jasa totok mata/hidung/payudara/perut mulai Rp50.000–85.000 per sesi, make up Rp100.000–125.000, serta paket dekor & make up pengantin dan lamaran sesuai budget.',
                    'en' => 'Facial acupressure from Rp50,000–85,000 per session, makeup Rp100,000–125,000, and wedding/engagement decoration & makeup packages according to budget.',
                ],
                'phone' => '081904064255',
            ],
            [
                'category_id' => $jasa->id,
                'title' => ['id' => 'Griya Busana Nurul KH', 'en' => 'Griya Busana Nurul KH'],
                'description' => [
                    'id' => 'Jasa menjahit busana.',
                    'en' => 'Dressmaking and tailoring services.',
                ],
                'phone' => '087738770075',
            ],
            [
                'category_id' => $jasa->id,
                'title' => ['id' => 'Bimbel Triwiji', 'en' => 'Triwiji Tutoring'],
                'description' => [
                    'id' => 'Bimbingan belajar bahasa Jawa untuk anak-anak dan pelajar.',
                    'en' => 'Javanese language tutoring for children and students.',
                ],
                'phone' => null,
            ],
            [
                'category_id' => $jasa->id,
                'title' => ['id' => 'Les Baca Tulis', 'en' => 'Reading & Writing Tutoring'],
                'description' => [
                    'id' => 'Bimbingan belajar membaca dan menulis untuk anak-anak.',
                    'en' => 'Reading and writing tutoring for children.',
                ],
                'phone' => null,
            ],
            [
                'category_id' => $jasa->id,
                'title' => ['id' => 'Bimbel Calistung', 'en' => 'Calistung Tutoring'],
                'description' => [
                    'id' => 'Bimbingan belajar membaca, menulis, dan berhitung untuk anak-anak.',
                    'en' => 'Reading, writing, and arithmetic tutoring for children.',
                ],
                'phone' => null,
            ],
        ];

        foreach ($items as $item) {
            Umkm::create(array_merge($item, [
                'status' => 'published',
                'published_at' => now(),
            ]));
        }
    }
}
