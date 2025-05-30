<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            // Programlama etiketleri
            ['name' => 'PHP', 'description' => 'PHP programlama dili'],
            ['name' => 'Laravel', 'description' => 'Laravel framework'],
            ['name' => 'JavaScript', 'description' => 'JavaScript programlama dili'],
            ['name' => 'Vue.js', 'description' => 'Vue.js framework'],
            ['name' => 'React', 'description' => 'React kütüphanesi'],
            ['name' => 'Node.js', 'description' => 'Node.js runtime'],
            ['name' => 'Python', 'description' => 'Python programlama dili'],
            ['name' => 'MySQL', 'description' => 'MySQL veritabanı'],
            ['name' => 'API', 'description' => 'API geliştirme'],
            
            // Tasarım etiketleri
            ['name' => 'UI/UX', 'description' => 'Kullanıcı arayüzü ve deneyimi'],
            ['name' => 'Figma', 'description' => 'Figma tasarım aracı'],
            ['name' => 'Adobe', 'description' => 'Adobe ürünleri'],
            ['name' => 'Photoshop', 'description' => 'Adobe Photoshop'],
            ['name' => 'İllustrator', 'description' => 'Adobe Illustrator'],
            
            // Pazarlama etiketleri
            ['name' => 'SEO', 'description' => 'Arama motoru optimizasyonu'],
            ['name' => 'Google Ads', 'description' => 'Google reklamları'],
            ['name' => 'Facebook Ads', 'description' => 'Facebook reklamları'],
            ['name' => 'E-ticaret', 'description' => 'Elektronik ticaret'],
            ['name' => 'Content Marketing', 'description' => 'İçerik pazarlama'],
            
            // Genel etiketler
            ['name' => 'Başlangıç', 'description' => 'Yeni başlayanlar için'],
            ['name' => 'Orta Seviye', 'description' => 'Orta seviye bilgi gerekli'],
            ['name' => 'İleri Seviye', 'description' => 'Uzman seviyesi'],
            ['name' => 'Pratik', 'description' => 'Uygulamalı öğrenme'],
            ['name' => 'Teori', 'description' => 'Teorik bilgiler'],
            ['name' => 'Canlı Ders', 'description' => 'Canlı eğitim'],
            ['name' => 'Video', 'description' => 'Video içerik'],
            ['name' => 'Döküman', 'description' => 'Yazılı materyal'],
            ['name' => 'Sertifikalı', 'description' => 'Sertifika veren eğitim'],
            ['name' => 'Ücretsiz', 'description' => 'Ücretsiz içerik'],
            ['name' => 'Premium', 'description' => 'Premium içerik']
        ];

        foreach ($tags as $tag) {
            Tag::create($tag);
        }
    }
} 