# MySQL PDO Extension Kurulum Rehberi

## Windows + PHP 8.x için

### Adım 1: php.ini Dosyasını Bul

Terminalde şu komutu çalıştır:
```cmd
php --ini
```

Loaded Configuration File satırındaki yolu kopyala (örnek: `C:\php\php.ini`)

### Adım 2: php.ini'yi Düzenle

1. php.ini dosyasını Not Defteri veya VS Code ile aç
2. Ctrl+F ile "pdo_mysql" ara
3. Şu satırı bul:

```ini
;extension=pdo_mysql
```

4. Başındaki `;` işaretini kaldır:

```ini
extension=pdo_mysql
```

5. Ayrıca bunları da kontrol et:

```ini
extension=mysqli
extension=openssl
```

### Adım 3: PHP'yi Yeniden Başlat

**XAMPP kullanıyorsan:**
- XAMPP Control Panel'i aç
- Apache'yi Stop → Start yap

**Built-in server kullanıyorsan:**
- Terminalde `Ctrl + C` ile server'ı durdur
- Tekrar başlat:
```cmd
cd c:\Users\Dest-\OneDrive\Masaüstü\CMS TeknoRay
php -S localhost:8080 -t public
```

### Adım 4: Test Et

Tarayıcıda şu adresi aç:
```
http://localhost:8080/test-db.php
```

### Sorun Devam Ederse

PHP'nin extension_dir'ini kontrol et. php.ini'de:

```ini
extension_dir = "C:/php/ext"  # Bu yolu kendi PHP dizinine göre ayarla
```

## cPanel için (Production)

cPanel'de PHP extension'ları varsayılan olarak aktiftir. Sadece:

1. cPanel → MySQL Databases
2. Veritabanı oluştur
3. Kullanıcı oluştur ve yetkiler ver
4. `config/config.php`'de bilgileri güncelle
