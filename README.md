# 📚 Eğitim API - Laravel Education Management System

Modern ve kapsamlı bir eğitim yönetim sistemi API'si. Laravel framework kullanılarak geliştirilmiştir.

## 🚀 Özellikler

- ✅ **Eğitim Yönetimi**: Video, makale ve kurs türlerinde eğitim içerikleri
- ✅ **Kategori Sistemi**: Eğitimleri kategorilere ayırma
- ✅ **Tag Sistemi**: Etiketleme ve filtreleme
- ✅ **RESTful API**: Modern API standartları
- ✅ **Sayfalama**: Performanslı veri listeme
- ✅ **Veri Doğrulama**: Kapsamlı validation
- ✅ **İlişkisel Veri**: Many-to-many relationships
- ✅ **Modern Frontend**: Bootstrap 5 ile responsive tasarım

## 🛠️ Teknolojiler

- **Backend**: Laravel 11
- **Veritabanı**: MySQL
- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap 5
- **API**: RESTful Architecture
- **ORM**: Eloquent

## 📋 Kurulum

### Gereksinimler
- PHP 8.1 veya üzeri
- Composer
- MySQL 5.7 veya üzeri
- Node.js (opsiyonel)

### Adım Adım Kurulum

1. **Projeyi klonlayın**
```bash
git clone https://github.com/KullaniciAdiniz/egitim-api.git
cd egitim-api
```

2. **Bağımlılıkları yükleyin**
```bash
composer install
```

3. **Environment dosyasını hazırlayın**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Veritabanı ayarlarını yapın**
`.env` dosyasında veritabanı bilgilerini güncelleyin:
```
DB_DATABASE=egitim_api
DB_USERNAME=root
DB_PASSWORD=your_password
```

5. **Veritabanını oluşturun ve migration'ları çalıştırın**
```bash
php artisan migrate --seed
```

6. **Sunucuyu başlatın**
```bash
php artisan serve
```

Uygulama http://localhost:8000 adresinde çalışacaktır.

## 📱 API Endpoints

### Eğitimler
- `GET /api/educations` - Tüm eğitimleri listele
- `GET /api/educations/{id}` - Belirli eğitimi getir
- `POST /api/educations` - Yeni eğitim oluştur
- `PUT /api/educations/{id}` - Eğitimi güncelle
- `DELETE /api/educations/{id}` - Eğitimi sil

### Kategoriler
- `GET /api/categories` - Tüm kategorileri listele
- `GET /api/categories/{id}` - Belirli kategoriyi getir
- `POST /api/categories` - Yeni kategori oluştur
- `PUT /api/categories/{id}` - Kategoriyi güncelle
- `DELETE /api/categories/{id}` - Kategoriyi sil

### Etiketler
- `GET /api/tags` - Tüm etiketleri listele
- `GET /api/tags/{id}` - Belirli etiketi getir
- `POST /api/tags` - Yeni etiket oluştur
- `PUT /api/tags/{id}` - Etiketi güncelle
- `DELETE /api/tags/{id}` - Etiketi sil

## 🎨 Frontend Sayfaları

- `/` - Dashboard (istatistikler ve genel bakış)
- `/educations` - Eğitim yönetimi
- `/categories` - Kategori yönetimi
- `/tags` - Etiket yönetimi

## 📝 API Kullanım Örnekleri

### Yeni Eğitim Oluşturma
```javascript
POST /api/educations
Content-Type: application/json

{
    "title": "Laravel ile API Geliştirme",
    "description": "Kapsamlı Laravel API kursu",
    "content_type": "video",
    "start_date": "2024-01-15",
    "category_id": 1,
    "tag_ids": [1, 2, 3]
}
```

### Eğitimleri Filtreleme
```javascript
GET /api/educations?page=1&per_page=10
```

## 🗄️ Veritabanı Yapısı

### Tablolar
- `categories` - Eğitim kategorileri
- `tags` - Etiketler
- `educations` - Eğitim içerikleri
- `education_tag` - Eğitim-etiket ilişki tablosu

### İlişkiler
- Education `belongsTo` Category (Çoktan-bire)
- Education `belongsToMany` Tag (Çoktan-çoğa)
- Category `hasMany` Education (Birden-çoğa)
- Tag `belongsToMany` Education (Çoktan-çoğa)

## 🧪 Test Verisi

Proje ile birlikte test verileri gelir:
- 8 kategori (Programming, Design, Marketing, vb.)
- 31 etiket (PHP, Laravel, JavaScript, vb.)
- 10 örnek eğitim içeriği

Test verilerini yüklemek için:
```bash
php artisan db:seed
```

## 🔧 Geliştirme

### Yeni Migration Oluşturma
```bash
php artisan make:migration create_new_table
```

### Yeni Model Oluşturma
```bash
php artisan make:model ModelName -mcr
```

### Yeni Seeder Oluşturma
```bash
php artisan make:seeder TableSeeder
```

## 📊 Özellikler Detayı

### API Resources
- Standardize JSON çıktılar
- İlişkili verilerin kontrollü yüklenmesi
- Tarih formatlarının düzenlenmesi

### Validation
- Kapsamlı form doğrulama
- Özel hata mesajları
- Veritabanı constraint kontrolü

### Pagination
- Otomatik sayfalama
- Meta bilgiler (toplam sayfa, mevcut sayfa)
- Performance optimizasyonu

## 🤝 Katkıda Bulunma

1. Fork yapın
2. Feature branch oluşturun (`git checkout -b feature/amazing-feature`)
3. Commit yapın (`git commit -m 'Add amazing feature'`)
4. Branch'i push edin (`git push origin feature/amazing-feature`)
5. Pull Request açın

## 📄 Lisans

Bu proje MIT lisansı altında lisanslanmıştır.

## 👨‍💻 Geliştirici

- **Adınız Soyadınız** - *Full Stack Developer*

## 📞 İletişim

- Email: email@example.com
- LinkedIn: [linkedin.com/in/profiliniz](https://linkedin.com/in/profiliniz)
- GitHub: [github.com/kullaniciadi](https://github.com/kullaniciadi)

---

⭐ Bu projeyi beğendiyseniz star vermeyi unutmayın!
