<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Article Categories
        $articleCats = [
            [
                "id" => "Kabar & Kegiatan Desa",
                "en" => "Village News & Activities",
            ],
            ["id" => "Kunjungan Kerjasama", "en" => "Collaboration Visit"],
        ];

        foreach ($articleCats as $cat) {
            DB::table("article_categories")->insert([
                "name" => json_encode($cat),
                "slug" => Str::slug($cat["id"]),
                "created_at" => now(),
                "updated_at" => now(),
            ]);
        }

        // UMKM Categories
        $umkmCats = [
            ["id" => "Makanan", "en" => "Culinary"],
            ["id" => "Produk", "en" => "Handicraft"],
            ["id" => "Jasa", "en" => "Service"],
        ];

        foreach ($umkmCats as $cat) {
            DB::table("umkm_categories")->insert([
                "name" => json_encode($cat),
                "slug" => Str::slug($cat["id"]),
                "created_at" => now(),
                "updated_at" => now(),
            ]);
        }

        // Tour Categories
        $tourCats = [
            ["id" => "Destinasi", "en" => "Destination"],
            ["id" => "Atraksi", "en" => "Attraction"],
            ["id" => "Aktivitas", "en" => "Activity"],
        ];

        foreach ($tourCats as $cat) {
            DB::table("tour_categories")->insert([
                "name" => json_encode($cat),
                "slug" => Str::slug($cat["id"]),
                "created_at" => now(),
                "updated_at" => now(),
            ]);
        }
    }
}
