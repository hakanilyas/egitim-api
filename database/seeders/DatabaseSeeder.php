<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Sadece eğitim sistemine ait verileri ekle
        $this->call([
            CategorySeeder::class,
            TagSeeder::class,
            EducationSeeder::class,
        ]);
    }
} 