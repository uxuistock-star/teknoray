<?php

namespace App\Core;

class Upload
{
    public static function save(array $file, array $allowedExtensions, int $maxBytes, string $subDir): string
    {
        if (!isset($file['error']) || is_array($file['error'])) {
            throw new \RuntimeException('Geçersiz dosya yükleme isteği.');
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new \RuntimeException('Dosya yüklenemedi. (Hata kodu: ' . $file['error'] . ')');
        }

        if (!isset($file['size']) || (int) $file['size'] <= 0) {
            throw new \RuntimeException('Boş dosya yüklenemez.');
        }

        if ((int) $file['size'] > $maxBytes) {
            throw new \RuntimeException('Dosya boyutu limitini aşıyor.');
        }

        $originalName = $file['name'] ?? '';
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

        if ($extension === '' || !in_array($extension, $allowedExtensions, true)) {
            throw new \RuntimeException('Geçersiz dosya formatı. İzin verilen: ' . implode(', ', $allowedExtensions));
        }

        $baseDir = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'uploads';
        $targetDir = $baseDir . DIRECTORY_SEPARATOR . trim($subDir, "\\/");

        if (!is_dir($targetDir) && !mkdir($targetDir, 0775, true) && !is_dir($targetDir)) {
            throw new \RuntimeException('Upload klasörü oluşturulamadı.');
        }

        $safeName = bin2hex(random_bytes(16)) . '.' . $extension;
        $targetPath = $targetDir . DIRECTORY_SEPARATOR . $safeName;

        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            throw new \RuntimeException('Dosya kaydedilemedi.');
        }

        $relative = '/uploads/' . trim($subDir, "\\/") . '/' . $safeName;
        return str_replace('\\', '/', $relative);
    }
}
