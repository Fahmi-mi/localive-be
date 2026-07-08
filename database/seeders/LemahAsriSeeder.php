<?php

namespace Database\Seeders;

use App\Models\OrganizationMember;
use App\Models\Profile;
use App\Models\TrackRecord;
use App\Models\VillageInfo;
use Illuminate\Database\Seeder;

class LemahAsriSeeder extends Seeder
{
    public function run(): void
    {
        Profile::create([
            'business_name' => [
                'id' => 'LEMAH ASRI (Lembaga Usaha Tamanan Sadar Wisata)',
                'en' => 'LEMAH ASRI (Tamanan Tourism Awareness Business Institute)',
            ],
            'owner' => [
                'id' => 'Atas Nama Anggota Lemah Asri',
                'en' => 'On Behalf of Lemah Asri Members',
            ],
            'founded_date' => '2021-09-09',
            'location' => [
                'id' => 'Tamanan, Tamanmartani, Kalasan, Sleman, Daerah Istimewa Yogyakarta',
                'en' => 'Tamanan, Tamanmartani, Kalasan, Sleman, Special Region of Yogyakarta',
            ],
            'phone' => '0882005012212',
            'email' => 'tamanan.media@gmail.com',
            'ig_url' => 'https://instagram.com/Tamanan.Media',
            'yt_url' => 'https://youtube.com/@TamananTV',
            'status' => 'published',
            'published_at' => now(),
        ]);

        VillageInfo::create([
            'vision' => [
                'id' => 'Menjadikan Tamanan sebagai Pedukuhan Tamanan berbasis wisata untuk meningkatkan perekonomian masyarakat.',
                'en' => 'To make Tamanan a tourism-based hamlet to improve the community economy.',
            ],
            'mission' => [
                'id' => "• Mensupport Pedukuhan Tamanan menjadi dusun wisata\n• Membantu mengembangkan pemberdayaan, budaya, ekonomi, dan sumber daya manusia serta sumber daya alam",
                'en' => "• Support Tamanan Hamlet to become a tourism village\n• Help develop empowerment, culture, economy, human resources, and natural resources",
            ],
            'status' => 'published',
            'published_at' => now(),
        ]);

        $trackRecords = [
            'Tuan Tuangga Agung',
            'PKG Lowokwaru Malang',
            'Orderlies Training',
            'Live In BEM KM Universitas Gadjah Mada',
            'Outing Class Omah Tahfidz Habibie',
            'Partnership RS Bethesda Yogyakarta',
            'Partnership Bengkel Sapi Kalijeruk',
            'Partnership GENBI',
            'Partnership DEM UGM',
            'Partnership BEM FEB UGM',
            'Studi Banding UMKM dan BUMDes Balerejo Kaliangkrik',
            'Studi Tiru Desa Tegalgondo Klaten',
            'Outing Class SMK Muhammadiyah Delanggu Klaten',
            'Studi Tiru Dusun Karangmojo Sleman',
        ];

        foreach ($trackRecords as $item) {
            TrackRecord::create([
                'content' => ['id' => $item, 'en' => $item],
                'status' => 'published',
                'published_at' => now(),
            ]);
        }

        $orgMembers = [
            'Chief Executive Officer - Yusuf Budiono',
            'Chief Operating Officer - Rinto Hakim Pamungkas',
            'Finance Administration Officer - Muhammad Andika Ronaldo',
            'Marketing Officer - Habib Diki Setiawan',
            'Product Officer - Murni Ageng Saputra',
            'General Officer - Nurcahyono',
        ];

        foreach ($orgMembers as $item) {
            OrganizationMember::create([
                'name' => ['id' => $item, 'en' => $item],
                'status' => 'published',
                'published_at' => now(),
            ]);
        }
    }
}
