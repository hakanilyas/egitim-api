# 🚀 Kurulum ve GitHub'a Push Rehberi

Bu rehber, projenizi GitHub'a nasıl yükleyeceğinizi adım adım anlatır.

## 1. Git Kurulumu (Windows)

### Git İndirme ve Kurma
1. **Git for Windows'u indirin**: https://git-scm.com/download/win
2. İndirilen `.exe` dosyasını çalıştırın
3. Kurulum sihirbazında şu ayarları yapın:
   - ✅ "Git Bash Here" seçeneğini işaretleyin
   - ✅ "Git from the command line and also from 3rd-party software" seçin
   - ✅ "Use Windows' default console window" seçin
4. Kurulumu tamamlayın
5. **Terminal'i yeniden başlatın** (PowerShell'i kapatıp açın)

### Git Kurulumunu Doğrulama
```bash
git --version
```
Bu komut Git versiyonunu gösterirse kurulum başarılıdır.

## 2. Git Yapılandırması

Terminal'de aşağıdaki komutları çalıştırın (kendi bilgilerinizi yazın):

```bash
# Global kullanıcı adı ayarlama
git config --global user.name "Adınız Soyadınız"

# Global email ayarlama (GitHub email adresinizi kullanın)
git config --global user.email "github-email@example.com"

# Ayarları kontrol etme
git config --global --list
```

## 3. GitHub Hesabı ve Repository Oluşturma

### GitHub Hesabı
1. https://github.com adresine gidin
2. Hesabınız yoksa **Sign up** ile hesap oluşturun
3. Email adresinizi doğrulayın

### Yeni Repository Oluşturma
1. GitHub'da **"+"** butonuna tıklayın
2. **"New repository"** seçin
3. Şu bilgileri girin:
   - **Repository name**: `egitim-api`
   - **Description**: `Laravel Education Management API`
   - **Visibility**: Public veya Private seçin
   - ⚠️ **"Initialize this repository with a README"** seçeneğini İŞARETLEMEYİN
   - ⚠️ **.gitignore** ve **license** eklemeyin (zaten var)
4. **"Create repository"** butonuna tıklayın

## 4. Proje Dizininde Git İşlemleri

### Proje Dizinine Gidin
```bash
cd C:\laragon\www\egitim-api
```

### Git Repository Başlatma
```bash
git init
```

### Dosyaları Staging Area'ya Ekleme
```bash
# Tüm dosyaları ekle
git add .

# Hangi dosyaların eklendiğini kontrol et
git status
```

### İlk Commit
```bash
git commit -m "İlk commit: Laravel Eğitim API projesi

- Laravel 11 ile eğitim yönetim sistemi
- CRUD işlemleri (Education, Category, Tag)
- API Resources ile standardize JSON
- Seeders ile test verisi
- Bootstrap 5 ile modern frontend
- RESTful API endpoints
- Migration ve ilişkisel veritabanı yapısı"
```

### GitHub Repository'ye Bağlama
GitHub'da oluşturduğunuz repository'nin URL'ini kullanın:

```bash
# Remote repository ekleme
git remote add origin https://github.com/KULLANICI_ADINIZ/egitim-api.git

# Remote'u kontrol etme
git remote -v
```

### Ana Branch Ayarlama ve Push
```bash
# Ana branch'i main olarak ayarla
git branch -M main

# İlk push (upstream ayarlayarak)
git push -u origin main
```

## 5. Başarı Kontrolü

### Terminal'de Başarı Mesajları
Push işlemi başarılı olursa şuna benzer çıktı göreceksiniz:
```
Enumerating objects: 150, done.
Counting objects: 100% (150/150), done.
Delta compression using up to 8 threads
Compressing objects: 100% (130/130), done.
Writing objects: 100% (150/150), 2.5 MiB | 1.2 MiB/s, done.
Total 150 (delta 15), reused 0 (delta 0), pack-reused 0
To https://github.com/kullaniciadi/egitim-api.git
 * [new branch]      main -> main
Branch 'main' set up to track remote branch 'main' from 'origin'.
```

### GitHub'da Kontrol
1. GitHub'daki repository sayfanıza gidin
2. Dosyalarınızın yüklendiğini göreceksiniz
3. README.md dosyası otomatik olarak görünecek

## 6. Gelecekte Değişiklik Yapma

### Değişiklikleri Push Etme
Proje üzerinde değişiklik yaptığınızda:

```bash
# Değişiklikleri kontrol et
git status

# Değişiklikleri staging area'ya ekle
git add .

# Commit oluştur
git commit -m "Açıklayıcı commit mesajı"

# GitHub'a push et
git push
```

### Branch ile Çalışma (İleri Seviye)
```bash
# Yeni branch oluştur
git checkout -b feature/yeni-ozellik

# Değişiklik yap ve commit et
git add .
git commit -m "Yeni özellik eklendi"

# Branch'i push et
git push origin feature/yeni-ozellik

# GitHub'da Pull Request oluştur
```

## 7. Sorun Giderme

### Git Komutu Tanınmıyor
```
'git' is not recognized as an internal or external command
```
**Çözüm**: Git'i yeniden kurun ve PATH'e eklendiğinden emin olun.

### Authentication Hatası
```
remote: Support for password authentication was removed
```
**Çözüm**: 
1. GitHub'da Personal Access Token oluşturun (Settings > Developer settings > Personal access tokens)
2. Şifre yerine token kullanın

### Remote Repository Zaten Var
```
fatal: remote origin already exists
```
**Çözüm**:
```bash
git remote remove origin
git remote add origin https://github.com/kullaniciadi/egitim-api.git
```

### Large File Warning
```
warning: LF will be replaced by CRLF
```
**Çözüm**: Bu Windows'da normal bir uyarıdır, görmezden gelebilirsiniz.

## 8. Bonus: Faydalı Git Komutları

```bash
# Commit geçmişini görme
git log --oneline

# Değişiklikleri geri alma (henüz commit edilmemişse)
git checkout -- dosya_adi.php

# Son commit'i geri alma
git reset --soft HEAD~1

# Remote repository'den son değişiklikleri çekme
git pull

# Branch listesi
git branch -a

# Git durumunu temizleme
git clean -fd
```

## 9. GitHub Repository Özellikleri

### README.md Güncelleme
Repository'nizde README.md dosyası otomatik görünür. Bu dosyayı:
- Projenizin açıklaması
- Kurulum talimatları  
- API dokümantasyonu
- Özellikler listesi
için kullanabilirsiniz.

### Issues ve Discussions
- **Issues**: Bug raporu, özellik istekleri
- **Discussions**: Toplulukla sohbet

### GitHub Pages (Opsiyonel)
Static site hosting için GitHub Pages kullanabilirsiniz.

---

## ✅ Kontrol Listesi

- [ ] Git kuruldu ve yapılandırıldı
- [ ] GitHub hesabı oluşturuldu
- [ ] Repository oluşturuldu
- [ ] Proje başarıyla push edildi
- [ ] README.md düzenlendi
- [ ] Commit mesajları anlamlı

**Tebrikler! 🎉 Projeniz artık GitHub'da yayında!**

---

## 📞 Yardım

Sorun yaşarsanız:
1. Bu rehberi tekrar okuyun
2. Git dokümantasyonunu kontrol edin: https://git-scm.com/docs
3. GitHub yardım sayfasını ziyaret edin: https://docs.github.com
4. Stack Overflow'da arama yapın 