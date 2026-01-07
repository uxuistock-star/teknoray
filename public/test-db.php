<?php
// Test database connection
try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=teknoray_cms;charset=utf8mb4',
        'root',
        ''
    );
    echo "✅ MySQL Bağlantısı Başarılı!<br>";
    echo "PDO Driver: " . $pdo->getAttribute(PDO::ATTR_DRIVER_NAME) . "<br>";
    echo "Server Version: " . $pdo->getAttribute(PDO::ATTR_SERVER_VERSION) . "<br>";
} catch (PDOException $e) {
    echo "❌ Bağlantı Hatası: " . $e->getMessage() . "<br>";
    echo "<br>Çözüm:<br>";
    echo "1. php.ini'de 'extension=pdo_mysql' satırını aktif et<br>";
    echo "2. MySQL server'ın çalıştığından emin ol<br>";
    echo "3. Veritabanı adı ve kullanıcı bilgilerini kontrol et<br>";
}
