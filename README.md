# 📚 Eğitim API - Laravel Education Management System

Modern ve kapsamlı bir eğitim yönetim sistemi API'si. Laravel framework ve modüler JavaScript mimarisi kullanılarak geliştirilmiştir.

## 🚀 Özellikler

- ✅ **Eğitim Yönetimi**: Video, makale ve kurs türlerinde eğitim içerikleri
- ✅ **Kategori Sistemi**: Eğitimleri kategorilere ayırma
- ✅ **Tag Sistemi**: Etiketleme ve filtreleme
- ✅ **RESTful API**: Modern API standartları
- ✅ **Sayfalama**: Performanslı veri listeme
- ✅ **Veri Doğrulama**: Kapsamlı validation
- ✅ **İlişkisel Veri**: Many-to-many relationships
- ✅ **Modern Frontend**: Bootstrap 5 ile responsive tasarım
- ✅ **Modüler JavaScript**: Performans odaklı JavaScript mimarisi
- ✅ **Merkezi Error Handling**: Standardize hata yönetimi
- ✅ **AJAX SPA Experience**: Sayfa yenilenmesi olmadan dinamik içerik

## 🛠️ Teknolojiler

- **Backend**: Laravel 11
- **Veritabanı**: MySQL
- **Frontend**: HTML5, CSS3, JavaScript ES6+, Bootstrap 5
- **API**: RESTful Architecture
- **ORM**: Eloquent
- **JavaScript**: Modüler mimari, ES6+ features
- **AJAX**: jQuery ile API entegrasyonu

## 🏗️ JavaScript Mimarisi

### Modüler Yapı (22KB Total)
```
public/js/
├── app.js           # Ortak fonksiyonlar (2.6KB)
├── dashboard.js     # Dashboard özellikleri (4.2KB)
├── educations.js    # Eğitim CRUD işlemleri (8.7KB)
├── categories.js    # Kategori yönetimi (4.8KB)
└── tags.js          # Etiket yönetimi (4.4KB)
```

### Temel Özellikler
- **Merkezi AJAX Setup**: CSRF token, error handling
- **Performance**: Paralel API çağrıları, event delegation
- **Code Reuse**: Ortak fonksiyonlar tek yerde
- **Error Management**: Kullanıcı dostu hata mesajları
- **Browser Caching**: Modüler dosyalar ayrı cache'lenir

## 📋 Kurulum

### Gereksinimler
- PHP 8.1 veya üzeri
- Composer
- MySQL 5.7 veya üzeri
- Node.js (opsiyonel)

### Adım Adım Kurulum

1. **Projeyi klonlayın**
```bash
git clone https://github.com/hakanilyas/egitim-api.git
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
- `GET /api/educations` - Tüm eğitimleri listele (pagination destekli)
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
- `/educations` - Eğitim yönetimi (CRUD, arama, filtreleme)
- `/categories` - Kategori yönetimi
- `/tags` - Etiket yönetimi

### Frontend Özellikleri
- **SPA Experience**: AJAX ile sayfa yenilenmesi olmadan işlemler
- **Real-time Updates**: İşlem sonrası otomatik liste yenileme
- **Progressive Enhancement**: JavaScript olmadan da temel işlevsellik
- **Responsive Design**: Tüm cihazlarda uyumlu görünüm
- **User Feedback**: Toast notifikasyonları ve loading states

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

### Eğitimleri Filtreleme ve Sayfalama
```javascript
GET /api/educations?page=1&per_page=10
```

### API Response Formatı
```json
{
    "data": [
        {
            "id": 1,
            "title": "Laravel ile API Geliştirme",
            "description": "Kapsamlı Laravel API kursu",
            "content_type": "video",
            "start_date": "2024-01-15",
            "category": {
                "id": 1,
                "name": "Programming",
                "description": "Programming related courses"
            },
            "tags": [
                {"id": 1, "name": "PHP"},
                {"id": 2, "name": "Laravel"}
            ],
            "created_at": "2024-01-15 10:30:00",
            "updated_at": "2024-01-15 10:30:00"
        }
    ],
    "meta": {
        "current_page": 1,
        "last_page": 5,
        "per_page": 10,
        "total": 50
    }
}
```

## 🗄️ Veritabanı Yapısı

### Tablolar
- `categories` - Eğitim kategorileri (8 kategori)
- `tags` - Etiketler (30 etiket)
- `educations` - Eğitim içerikleri
- `education_tag` - Eğitim-etiket ilişki tablosu (Many-to-Many)

### İlişkiler
- Education `belongsTo` Category (Çoktan-bire)
- Education `belongsToMany` Tag (Çoktan-çoğa)
- Category `hasMany` Education (Birden-çoğa)
- Tag `belongsToMany` Education (Çoktan-çoğa)

## 🧪 Test Verisi

Proje ile birlikte test verileri gelir:
- **8 kategori**: Programming, Design, Marketing, Business, Language, Art, Music, Health
- **30 etiket**: PHP, Laravel, JavaScript, Python, React, Vue.js, Node.js, MySQL, vs.
- **10 örnek eğitim**: Farklı kategoriler ve etiketler ile ilişkilendirilmiş

Test verilerini yüklemek için:
```bash
php artisan db:seed
```

## 🔧 Geliştirme

### Yeni Migration Oluşturma
```bash
php artisan make:migration create_new_table
```

### Yeni Model Oluşturma (Controller ve Resource ile)
```bash
php artisan make:model ModelName -mcr
```

### Yeni Seeder Oluşturma
```bash
php artisan make:seeder TableSeeder
```

### JavaScript Dosyası Ekleme
```javascript
// 1. public/js/ dizininde yeni dosya oluştur
// 2. app.js'deki ortak fonksiyonları kullan
// 3. Blade template'de include et:

@section('scripts')
<script src="{{ asset('js/your-module.js') }}"></script>
@endsection
```

## 📊 Mimari Özellikleri

### Backend Architecture
- **MVC Pattern**: Model-View-Controller ayrımı
- **API Resources**: Standardize JSON output
- **Eloquent ORM**: Object-relational mapping
- **Form Validation**: Server-side validation
- **Error Handling**: Consistent error responses

### Frontend Architecture
- **Modular JavaScript**: Separation of concerns
- **Component-based**: Reusable UI components
- **Event-driven**: DOM event delegation
- **Progressive Enhancement**: JavaScript as enhancement layer

### Performance Features
- **Lazy Loading**: İlişkili verilerin kontrollü yüklenmesi
- **Pagination**: Büyük veri setleri için performans
- **Browser Caching**: Static asset caching
- **Parallel API Calls**: Multiple requests simultaneously
- **Optimized DOM**: Batch DOM manipulations

## 📂 Proje Dosya Yapısı

```
egitim-api/
├── app/
│   ├── Http/
│   │   ├── Controllers/Api/
│   │   │   ├── EducationController.php     # Eğitim CRUD
│   │   │   ├── CategoryController.php      # Kategori CRUD
│   │   │   └── TagController.php           # Etiket CRUD
│   │   └── Resources/
│   │       ├── EducationResource.php       # JSON formatı
│   │       ├── CategoryResource.php        # JSON formatı
│   │       └── TagResource.php             # JSON formatı
│   └── Models/
│       ├── Education.php                   # Eloquent model
│       ├── Category.php                    # Eloquent model
│       └── Tag.php                         # Eloquent model
├── database/
│   ├── migrations/                         # Veritabanı şeması
│   │   ├── 2024_create_categories_table.php
│   │   ├── 2024_create_tags_table.php
│   │   ├── 2024_create_educations_table.php
│   │   └── 2024_create_education_tag_table.php
│   └── seeders/                           # Test verileri
│       ├── CategorySeeder.php
│       ├── TagSeeder.php
│       ├── EducationSeeder.php
│       └── DatabaseSeeder.php
├── public/js/                             # JavaScript modülleri
│   ├── app.js                            # Ortak fonksiyonlar
│   ├── dashboard.js                      # Dashboard özellikleri
│   ├── educations.js                     # Eğitim yönetimi
│   ├── categories.js                     # Kategori yönetimi
│   └── tags.js                          # Etiket yönetimi
├── resources/
│   └── views/                           # Blade templates
│       ├── layouts/app.blade.php        # Ana layout
│       ├── dashboard.blade.php          # Dashboard sayfası
│       ├── educations.blade.php         # Eğitimler sayfası
│       ├── categories.blade.php         # Kategoriler sayfası
│       └── tags.blade.php              # Etiketler sayfası
├── routes/
│   ├── api.php                         # API rotaları
│   └── web.php                         # Web rotaları
├── .env.example                        # Environment template
├── Egitim-API.postman_collection.json # API test collection
├── INSTALLATION.md                     # Kurulum rehberi
├── dokumantasyon.txt                  # Detaylı döküman (803 satır)
└── README.md                          # Bu dosya
```

## 🚀 Performans Optimizasyonları

### Backend Optimizations
- **Eager Loading**: N+1 query problemini önleme
- **API Resources**: Gereksiz veri transferini önleme
- **Database Indexing**: Primary ve foreign key'ler
- **Query Optimization**: Efficient Eloquent queries

### Frontend Optimizations
- **Code Splitting**: Modüler JavaScript dosyaları
- **Event Delegation**: Memory efficient event handling
- **DOM Batching**: Single DOM update operations
- **Parallel Loading**: Simultaneous API requests
- **Browser Caching**: Static asset caching

### Network Optimizations
- **JSON API**: Lightweight data transfer
- **HTTP Caching**: Proper cache headers
- **Compression**: Gzip compression support
- **CDN Ready**: Asset helper for CDN integration

## 🔗 Faydalı Linkler

- **Repository**: [https://github.com/hakanilyas/egitim-api](https://github.com/hakanilyas/egitim-api)
- **Postman Collection**: [Egitim-API.postman_collection.json](./Egitim-API.postman_collection.json)
- **Installation Guide**: [INSTALLATION.md](./INSTALLATION.md)
- **Detailed Documentation**: [dokumantasyon.txt](./dokumantasyon.txt) (803 satır detaylı rehber)
- **Laravel Documentation**: [Laravel 11 Docs](https://laravel.com/docs/11.x)

## 🧪 Test & Debug

### API Testing
```bash
# Postman Collection'ı import edin
# Veya curl ile test edin:

curl -X GET http://localhost:8000/api/educations \
  -H "Accept: application/json"

curl -X POST http://localhost:8000/api/educations \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"title":"Test","description":"Test desc","content_type":"video","start_date":"2024-01-15","category_id":1}'
```

### JavaScript Debugging
```javascript
// Browser Console'da debug etmek için:
console.log('Current educations:', allEducations);
console.log('API Base:', API_BASE);

// Error tracking:
window.addEventListener('error', function(e) {
    console.error('JavaScript Error:', e.error);
});
```

## 🤝 Katkıda Bulunma

1. Fork yapın
2. Feature branch oluşturun (`git checkout -b feature/amazing-feature`)
3. JavaScript modules için coding standards'ı takip edin
4. Commit yapın (`git commit -m 'Add amazing feature'`)
5. Branch'i push edin (`git push origin feature/amazing-feature`)
6. Pull Request açın

### Coding Standards
- **JavaScript**: ES6+ features, JSDoc comments
- **PHP**: PSR-12 coding standards
- **CSS**: BEM methodology
- **Commits**: Conventional commits format

## 📈 Proje İstatistikleri

### Backend (Laravel)
- **3 Model**: Education, Category, Tag
- **3 Controller**: RESTful API endpoints
- **3 API Resource**: JSON standardization
- **4 Migration**: Database schema
- **4 Seeder**: Test data (8 categories, 30 tags, 10 educations)

### Frontend (JavaScript)
- **5 Modül**: 22KB total JavaScript
- **800+ satır**: Modüler JavaScript kodu
- **4 Sayfa**: Dashboard, Educations, Categories, Tags
- **SPA Experience**: AJAX-based navigation

### Features
- **CRUD Operations**: Full Create, Read, Update, Delete
- **Real-time Updates**: Dynamic content without page refresh
- **Error Handling**: User-friendly error messages
- **Performance**: Optimized API calls and DOM operations
- **Responsive**: Mobile-first design approach

## 📄 Lisans

Bu proje MIT lisansı altında lisanslanmıştır.

## 👨‍💻 Geliştirici

- **Hakan İlyas** - *Full Stack Developer*
- Modern web development best practices
- Laravel & JavaScript expertise

## 📞 İletişim

- GitHub: [hakanilyas](https://github.com/hakanilyas)
- Repository: [egitim-api](https://github.com/hakanilyas/egitim-api)

---

⭐ Bu projeyi beğendiyseniz star vermeyi unutmayın!

**Laravel + Modüler JavaScript = Modern Web Development**
