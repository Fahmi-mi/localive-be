<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\LemahAsriSeeder;
use Database\Seeders\TourPackageSeeder;
use Database\Seeders\UmkmSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CategorySeeder::class);
        $this->call(TourPackageSeeder::class);
        $this->call(UmkmSeeder::class);
        $this->call(LemahAsriSeeder::class);

        User::factory()->create([
            "name" => "Super Admin",
            "email" => "admin@localive.id",
            "role" => "super_admin",
        ]);
    }
}
