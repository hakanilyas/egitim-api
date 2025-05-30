<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Programlama',
                'description' => 'Yazılım geliştirme ve programlama dilleri'
            ],
            [
                'name' => 'Tasarım',
                'description' => 'Grafik tasarım, UI/UX tasarım ve yaratıcı çalışmalar'
            ],
            [
                'name' => 'Pazarlama',
                'description' => 'Dijital pazarlama, sosyal medya ve reklam stratejileri'
            ],
            [
                'name' => 'İş Geliştirme',
                'description' => 'Girişimcilik, proje yönetimi ve iş stratejileri'
            ],
            [
                'name' => 'Dil Öğrenimi',
                'description' => 'Yabancı dil öğrenimi ve dil becerileri'
            ],
            [
                'name' => 'Kişisel Gelişim',
                'description' => 'Liderlik, iletişim ve motivasyon teknikleri'
            ],
            [
                'name' => 'Teknoloji',
                'description' => 'Yapay zeka, blockchain ve emerging teknolojiler'
            ],
            [
                'name' => 'Sağlık ve Fitness',
                'description' => 'Beslenme, egzersiz ve sağlıklı yaşam'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
} 