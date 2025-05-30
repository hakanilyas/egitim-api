<?php

namespace Database\Seeders;

use App\Models\Education;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class EducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $educations = [
            [
                'title' => 'Laravel 12 ile Modern Web Geliştirme',
                'description' => 'Sıfırdan Laravel öğrenerek modern web uygulamaları geliştirmeyi öğrenin.',
                'content_type' => 'video',
                'start_date' => '2025-06-01',
                'category' => 'Programlama',
                'tags' => ['Laravel', 'PHP', 'API', 'Başlangıç']
            ],
            [
                'title' => 'React ile Frontend Geliştirme',
                'description' => 'React kullanarak modern ve responsive kullanıcı arayüzleri oluşturun.',
                'content_type' => 'video',
                'start_date' => '2025-06-15',
                'category' => 'Programlama',
                'tags' => ['React', 'JavaScript', 'UI/UX', 'Orta Seviye']
            ],
            [
                'title' => 'UI/UX Tasarım Temelleri',
                'description' => 'Kullanıcı deneyimi ve arayüz tasarımının temel prensiplerini öğrenin.',
                'content_type' => 'document',
                'start_date' => '2025-06-10',
                'category' => 'Tasarım',
                'tags' => ['UI/UX', 'Figma', 'Başlangıç', 'Teori']
            ],
            [
                'title' => 'Adobe Photoshop ile Grafik Tasarım',
                'description' => 'Photoshop kullanarak profesyonel grafik tasarımlar oluşturun.',
                'content_type' => 'video',
                'start_date' => '2025-06-20',
                'category' => 'Tasarım',
                'tags' => ['Photoshop', 'Adobe', 'Pratik', 'Orta Seviye']
            ],
            [
                'title' => 'SEO Optimizasyonu Rehberi',
                'description' => 'Web sitenizi arama motorlarında üst sıralara çıkarmayı öğrenin.',
                'content_type' => 'document',
                'start_date' => '2025-06-05',
                'category' => 'Pazarlama',
                'tags' => ['SEO', 'Content Marketing', 'Başlangıç', 'Döküman']
            ],
            [
                'title' => 'Google Ads ile Etkili Reklam Kampanyaları',
                'description' => 'Google Ads platformunda başarılı reklam kampanyaları oluşturun.',
                'content_type' => 'video',
                'start_date' => '2025-06-25',
                'category' => 'Pazarlama',
                'tags' => ['Google Ads', 'E-ticaret', 'İleri Seviye', 'Premium']
            ],
            [
                'title' => 'Python ile Veri Analizi',
                'description' => 'Python programlama dili ile veri analizi yapmayı öğrenin.',
                'content_type' => 'video',
                'start_date' => '2025-07-01',
                'category' => 'Programlama',
                'tags' => ['Python', 'API', 'İleri Seviye', 'Sertifikalı']
            ],
            [
                'title' => 'Girişimcilik ve İş Kurma',
                'description' => 'Kendi işinizi kurmak için gerekli adımları ve stratejileri öğrenin.',
                'content_type' => 'document',
                'start_date' => '2025-06-12',
                'category' => 'İş Geliştirme',
                'tags' => ['Başlangıç', 'Teori', 'Ücretsiz']
            ],
            [
                'title' => 'Blockchain ve Kripto Para',
                'description' => 'Blockchain teknolojisi ve kripto para dünyasını keşfedin.',
                'content_type' => 'image',
                'start_date' => '2025-07-10',
                'category' => 'Teknoloji',
                'tags' => ['Orta Seviye', 'Teori', 'Premium']
            ],
            [
                'title' => 'Etkili İletişim Teknikleri',
                'description' => 'İş hayatında ve günlük yaşamda etkili iletişim kurma yöntemlerini öğrenin.',
                'content_type' => 'video',
                'start_date' => '2025-06-18',
                'category' => 'Kişisel Gelişim',
                'tags' => ['Başlangıç', 'Canlı Ders', 'Video']
            ]
        ];

        foreach ($educations as $educationData) {
            // Kategoriyi bul
            $category = Category::where('name', $educationData['category'])->first();
            
            if (!$category) {
                continue; // Kategori bulunamazsa bu eğitimi atla
            }

            // Eğitimi oluştur
            $education = Education::create([
                'title' => $educationData['title'],
                'description' => $educationData['description'],
                'content_type' => $educationData['content_type'],
                'start_date' => $educationData['start_date'],
                'category_id' => $category->id
            ]);

            // Etiketleri ekle
            $tagIds = [];
            foreach ($educationData['tags'] as $tagName) {
                $tag = Tag::where('name', $tagName)->first();
                if ($tag) {
                    $tagIds[] = $tag->id;
                }
            }
            
            if (!empty($tagIds)) {
                $education->tags()->sync($tagIds);
            }
        }
    }
} 