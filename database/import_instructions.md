# Veritabanı Kurulum Talimatları

## Adım 1: phpMyAdmin'i Aç

1. XAMPP Control Panel'den **MySQL** servisinin çalıştığından emin olun (yeşil renkte görünmeli)
2. Tarayıcınızda şu adresi açın: [http://localhost/phpmyadmin](http://localhost/phpmyadmin)

## Adım 2: SQL Dosyasını İçe Aktar

1. phpMyAdmin açıldığında üst menüden **"SQL"** sekmesine tıklayın
2. Aşağıdaki kutuda **"Dosya Seç"** butonuna tıklayın
3. Şu dosyayı seçin: `C:\xampp\htdocs\CMSTeknoRay\database\schema.sql`
4. **"Git"** (veya "Go") butonuna tıklayın

## Sonuç

Eğer her şey başarılı olursa:
- ✅ `teknoray_cms` veritabanı oluşturulacak
- ✅ Tüm tablolar (projects, blog_posts, services, slider, vb.) oluşturulacak
- ✅ Örnek veriler otomatik eklenecek
- ✅ Admin kullanıcısı hazır olacak
  - Kullanıcı adı: `admin`
  - Şifre: `teknoray2026`

## Test Etme

Veritabanı kurulduktan sonra şu adresi ziyaret edin:
- **Site**: [http://localhost/CMSTeknoRay/public/](http://localhost/CMSTeknoRay/public/)
- **Admin Panel**: [http://localhost/CMSTeknoRay/public/admin](http://localhost/CMSTeknoRay/public/admin)
