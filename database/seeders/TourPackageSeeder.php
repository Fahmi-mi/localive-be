<?php

namespace Database\Seeders;

use App\Models\TourCategory;
use App\Models\TourPackage;
use Illuminate\Database\Seeder;

class TourPackageSeeder extends Seeder
{
    public function run(): void
    {
        $destinasi = TourCategory::where('slug', 'destinasi')->first();
        $atraksi = TourCategory::where('slug', 'atraksi')->first();
        $aktivitas = TourCategory::where('slug', 'aktivitas')->first();

        $items = [
            // Destinasi
            [
                'category_id' => $destinasi->id,
                'title' => ['id' => 'Cagar Budaya Ndokteran', 'en' => 'Ndokteran Cultural Heritage'],
                'description' => [
                    'id' => 'Kawasan cagar budaya bersejarah di Kampung Prenggan yang menyimpan jejak arsitektur dan tata ruang khas Kotagede.',
                    'en' => 'A historical cultural heritage area in Prenggan Village preserving the distinctive architecture and spatial layout of Kotagede.',
                ],
            ],
            [
                'category_id' => $destinasi->id,
                'title' => ['id' => 'Kandang Kelompok', 'en' => 'Communal Livestock Pen'],
                'description' => [
                    'id' => 'Area peternakan komunal warga yang dikelola secara gotong royong, tempat wisatawan belajar kehidupan agraris desa.',
                    'en' => 'A communal livestock area managed collaboratively, where visitors can learn about village agrarian life.',
                ],
            ],
            [
                'category_id' => $destinasi->id,
                'title' => ['id' => 'Sanggar Budaya', 'en' => 'Cultural Studio'],
                'description' => [
                    'id' => 'Pusat kegiatan seni dan budaya warga, tempat latihan tari, karawitan, dan kesenian tradisional yang terus dilestarikan lintas generasi.',
                    'en' => 'A center for arts and cultural activities, hosting traditional dance, gamelan, and art practices passed down through generations.',
                ],
            ],

            // Atraksi
            [
                'category_id' => $atraksi->id,
                'title' => ['id' => 'Macapat Triwiji', 'en' => 'Macapat Triwiji'],
                'description' => [
                    'id' => 'Pertunjukan tembang macapat yang dilantunkan dengan penuh penghayatan, mengangkat nilai-nilai filosofi Jawa melalui syair dan lagu tradisional.',
                    'en' => 'A macapat performance sung with deep expression, showcasing Javanese philosophical values through traditional poetry and song.',
                ],
            ],
            [
                'category_id' => $atraksi->id,
                'title' => ['id' => 'Gejok Lesung', 'en' => 'Gejok Lesung'],
                'description' => [
                    'id' => 'Kesenian musik tradisional yang dimainkan dengan menumbuk alu pada lesung secara berirama, menghasilkan alunan musik khas pedesaan Jawa.',
                    'en' => 'A traditional musical art performed by rhythmically pounding pestles on a mortar, producing distinctive Javanese village music.',
                ],
            ],
            [
                'category_id' => $atraksi->id,
                'title' => ['id' => 'Hadroh', 'en' => 'Hadroh'],
                'description' => [
                    'id' => 'Kesenian musik bernuansa islami yang dimainkan dengan rebana dan syair pujian, bagian dari tradisi keagamaan dan kebudayaan warga.',
                    'en' => 'An Islamic-influenced musical art performed with tambourines and praise poetry, part of the local religious and cultural tradition.',
                ],
            ],
            [
                'category_id' => $atraksi->id,
                'title' => ['id' => 'Karawitan', 'en' => 'Karawitan'],
                'description' => [
                    'id' => 'Pertunjukan musik gamelan Jawa yang dimainkan secara ansambel, menghadirkan harmoni instrumen tradisional yang sarat makna budaya.',
                    'en' => 'A Javanese gamelan ensemble performance, presenting the harmony of traditional instruments rich in cultural meaning.',
                ],
            ],

            // Aktivitas
            [
                'category_id' => $aktivitas->id,
                'title' => ['id' => 'Bertani', 'en' => 'Farming'],
                'description' => [
                    'id' => 'Rasakan pengalaman langsung turun ke sawah bersama petani lokal, mulai dari menanam hingga memanen hasil bumi khas pedesaan.',
                    'en' => 'Experience going directly to the rice fields with local farmers, from planting to harvesting typical village produce.',
                ],
            ],
            [
                'category_id' => $aktivitas->id,
                'title' => ['id' => 'Beternak', 'en' => 'Animal Husbandry'],
                'description' => [
                    'id' => 'Ikut serta dalam kegiatan memberi pakan dan merawat hewan ternak bersama warga, mengenal lebih dekat kehidupan agraris masyarakat.',
                    'en' => 'Participate in feeding and caring for livestock with residents, getting to know the agrarian life of the community up close.',
                ],
            ],
            [
                'category_id' => $aktivitas->id,
                'title' => ['id' => 'Gamelan', 'en' => 'Gamelan'],
                'description' => [
                    'id' => 'Belajar memainkan alat musik gamelan bersama para seniman lokal, mengenal notasi dan filosofi di balik setiap instrumen.',
                    'en' => 'Learn to play gamelan instruments with local artists, discovering the notation and philosophy behind each instrument.',
                ],
            ],
            [
                'category_id' => $aktivitas->id,
                'title' => ['id' => 'Dolanan Anak', 'en' => 'Traditional Children Games'],
                'description' => [
                    'id' => 'Bermain permainan tradisional khas Jawa bersama anak-anak setempat, menghidupkan kembali kegembiraan dolanan masa lalu.',
                    'en' => 'Play traditional Javanese games with local children, reviving the joy of traditional childhood pastimes.',
                ],
            ],
            [
                'category_id' => $aktivitas->id,
                'title' => ['id' => 'Outbond', 'en' => 'Outbound'],
                'description' => [
                    'id' => 'Kegiatan permainan kelompok di ruang terbuka yang memacu kerja sama tim dan keseruan, cocok untuk rombongan keluarga maupun instansi.',
                    'en' => 'Outdoor group activities that encourage teamwork and fun, suitable for family groups or corporate outings.',
                ],
            ],
            [
                'category_id' => $aktivitas->id,
                'title' => ['id' => 'Jelajah Desa Sepeda', 'en' => 'Village Bicycle Tour'],
                'description' => [
                    'id' => 'Berkeliling menyusuri gang-gang dan sudut kampung menggunakan sepeda, menikmati suasana asri sambil mengenal kehidupan sehari-hari warga.',
                    'en' => 'Cycle through village alleys and corners, enjoying the lush atmosphere while getting to know residents\' daily lives.',
                ],
            ],
            [
                'category_id' => $aktivitas->id,
                'title' => ['id' => 'Jelajah Desa Gerobak Sapi', 'en' => 'Oxcart Village Tour'],
                'description' => [
                    'id' => 'Pengalaman unik berkeliling desa menaiki gerobak sapi tradisional, menghadirkan nostalgia transportasi khas pedesaan Jawa tempo dulu.',
                    'en' => 'A unique experience touring the village on a traditional oxcart, bringing back the nostalgia of classic Javanese rural transport.',
                ],
            ],
            [
                'category_id' => $aktivitas->id,
                'title' => ['id' => 'Membuat Olahan Pangan Lokal', 'en' => 'Local Food Processing'],
                'description' => [
                    'id' => 'Praktik langsung mengolah bahan pangan khas daerah bersama warga, dari bahan mentah hingga menjadi sajian kuliner tradisional.',
                    'en' => 'Hands-on practice processing local ingredients with residents, from raw materials to traditional culinary dishes.',
                ],
            ],
        ];

        foreach ($items as $item) {
            TourPackage::create(array_merge($item, [
                'status' => 'published',
                'published_at' => now(),
            ]));
        }
    }
}
