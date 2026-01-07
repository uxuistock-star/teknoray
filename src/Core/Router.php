<?php

namespace App\Core;

class Router
{
    protected array $routes = [];

    public function resolve()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';

        // Remove base path if running in subdirectory
        // For XAMPP: /CMSTeknoRay/... -> /...
        if (str_starts_with($path, '/CMSTeknoRay')) {
            $path = substr($path, strlen('/CMSTeknoRay'));
        }

        // If accessed via public subdirectory directly, handle that too
        $scriptDir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        if ($scriptDir !== '' && $scriptDir !== '/' && str_starts_with($path, $scriptDir)) {
            $path = substr($path, strlen($scriptDir));
        }

        // Remove query string
        $position = strpos($path, '?');
        if ($position !== false) {
            $path = substr($path, 0, $position);
        }

        // Ensure path starts with /
        if (empty($path) || $path[0] !== '/') {
            $path = '/' . $path;
        }

        $redirectMap = [
            '/projects' => '/projeler',
            '/services' => '/hizmetler',
            '/references' => '/referanslar',
            '/contact' => '/iletisim',
            '/admin' => '/yonetim',
            '/admin/login' => '/yonetim/giris',
            '/admin/logout' => '/yonetim/cikis',
            '/admin/projects' => '/yonetim/projeler',
            '/admin/projects/create' => '/yonetim/projeler/ekle',
            '/admin/projects/store' => '/yonetim/projeler/kaydet',
            '/admin/blog' => '/yonetim/blog',
            '/admin/blog/create' => '/yonetim/blog/ekle',
            '/admin/blog/store' => '/yonetim/blog/kaydet',
            '/admin/services' => '/yonetim/hizmetler',
            '/admin/settings' => '/yonetim/ayarlar',
            '/admin/settings/save' => '/yonetim/ayarlar/kaydet',
            '/admin/slider' => '/yonetim/slider',
            '/admin/logos' => '/yonetim/logolar',
            '/admin/seo' => '/yonetim/seo',
            '/admin/header-footer' => '/yonetim/header-footer',
        ];

        if (isset($redirectMap[$path])) {
            header('Location: ' . $redirectMap[$path], true, 301);
            exit;
        }

        $redirectPatterns = [
            '#^/projects/([a-z0-9-]+)$#' => '/projeler/$1',
            '#^/admin/projects/edit/(\d+)$#' => '/yonetim/projeler/duzenle/$1',
            '#^/admin/projects/update/(\d+)$#' => '/yonetim/projeler/guncelle/$1',
            '#^/admin/projects/delete/(\d+)$#' => '/yonetim/projeler/sil/$1',
            '#^/admin/blog/edit/(\d+)$#' => '/yonetim/blog/duzenle/$1',
            '#^/admin/blog/update/(\d+)$#' => '/yonetim/blog/guncelle/$1',
            '#^/admin/blog/delete/(\d+)$#' => '/yonetim/blog/sil/$1',
        ];

        foreach ($redirectPatterns as $pattern => $target) {
            if (preg_match($pattern, $path, $matches)) {
                $location = $target;
                foreach (array_slice($matches, 1) as $i => $value) {
                    $location = str_replace('$' . ($i + 1), $value, $location);
                }
                header('Location: ' . $location, true, 301);
                exit;
            }
        }



        // Define Routes
        $routes = [
            // Public Routes
            '/' => [\App\Controllers\HomeController::class, 'index'],
            '/projeler' => [\App\Controllers\HomeController::class, 'projects'],
            '/hizmetler' => [\App\Controllers\HomeController::class, 'services'],
            '/referanslar' => [\App\Controllers\HomeController::class, 'references'],
            '/iletisim' => [\App\Controllers\HomeController::class, 'contact'],
            '/blog' => [\App\Controllers\BlogController::class, 'index'],

            // Admin Routes
            '/yonetim' => [\App\Controllers\AdminController::class, 'dashboard'],
            '/yonetim/giris' => [\App\Controllers\AdminController::class, 'login'],
            '/yonetim/cikis' => [\App\Controllers\AdminController::class, 'logout'],

            // Admin Projects
            '/yonetim/projeler' => [\App\Controllers\AdminController::class, 'projectsIndex'],
            '/yonetim/projeler/ekle' => [\App\Controllers\AdminController::class, 'projectsCreate'],
            '/yonetim/projeler/kaydet' => [\App\Controllers\AdminController::class, 'projectsStore'],
            '/yonetim/projeler/kategoriler' => [\App\Controllers\AdminController::class, 'projectCategories'],
            '/yonetim/projeler/kategoriler/kaydet' => [\App\Controllers\AdminController::class, 'projectCategoriesStore'],

            // Admin Blog
            '/yonetim/blog' => [\App\Controllers\AdminController::class, 'blogIndex'],
            '/yonetim/blog/ekle' => [\App\Controllers\AdminController::class, 'blogCreate'],
            '/yonetim/blog/kaydet' => [\App\Controllers\AdminController::class, 'blogStore'],
            '/yonetim/blog/kategoriler' => [\App\Controllers\AdminController::class, 'blogCategories'],
            '/yonetim/blog/kategoriler/kaydet' => [\App\Controllers\AdminController::class, 'blogCategoriesStore'],

            // Admin Services
            '/yonetim/hizmetler' => [\App\Controllers\AdminController::class, 'servicesIndex'],
            '/yonetim/hizmetler/ekle' => [\App\Controllers\AdminController::class, 'servicesCreate'],
            '/yonetim/hizmetler/kaydet' => [\App\Controllers\AdminController::class, 'servicesStore'],

            // Admin Settings
            '/yonetim/ayarlar' => [\App\Controllers\AdminController::class, 'settings'],
            '/yonetim/ayarlar/kaydet' => [\App\Controllers\AdminController::class, 'settingsSave'],

            // Admin Content Management
            '/yonetim/slider' => [\App\Controllers\AdminController::class, 'slider'],
            '/yonetim/slider/ekle' => [\App\Controllers\AdminController::class, 'sliderCreate'],
            '/yonetim/slider/kaydet' => [\App\Controllers\AdminController::class, 'sliderStore'],
            '/yonetim/logolar' => [\App\Controllers\AdminController::class, 'logos'],
            '/yonetim/logolar/kaydet' => [\App\Controllers\AdminController::class, 'logosStore'],
            '/yonetim/seo' => [\App\Controllers\AdminController::class, 'seo'],
            '/yonetim/seo/kaydet' => [\App\Controllers\AdminController::class, 'seoSave'],
            '/yonetim/header-footer' => [\App\Controllers\AdminController::class, 'headerFooter'],
            '/yonetim/header-footer/kaydet' => [\App\Controllers\AdminController::class, 'headerFooterSave'],

            // Regex routes
            '#^/blog/([a-zA-Z0-9-]+)$#' => [\App\Controllers\BlogController::class, 'show'],
            '#^/projeler/([a-zA-Z0-9-]+)$#' => [\App\Controllers\HomeController::class, 'projectDetail'],
            '#^/yonetim/projeler/duzenle/(\d+)$#' => [\App\Controllers\AdminController::class, 'projectsEdit'],
            '#^/yonetim/projeler/guncelle/(\d+)$#' => [\App\Controllers\AdminController::class, 'projectsUpdate'],
            '#^/yonetim/projeler/sil/(\d+)$#' => [\App\Controllers\AdminController::class, 'projectsDelete'],
            '#^/yonetim/projeler/kategoriler/sil/(\d+)$#' => [\App\Controllers\AdminController::class, 'projectCategoriesDelete'],
            '#^/yonetim/blog/duzenle/(\d+)$#' => [\App\Controllers\AdminController::class, 'blogEdit'],
            '#^/yonetim/blog/guncelle/(\d+)$#' => [\App\Controllers\AdminController::class, 'blogUpdate'],
            '#^/yonetim/blog/sil/(\d+)$#' => [\App\Controllers\AdminController::class, 'blogDelete'],
            '#^/yonetim/blog/kategoriler/sil/(\d+)$#' => [\App\Controllers\AdminController::class, 'blogCategoriesDelete'],
            '#^/yonetim/hizmetler/duzenle/(\d+)$#' => [\App\Controllers\AdminController::class, 'servicesEdit'],
            '#^/yonetim/hizmetler/guncelle/(\d+)$#' => [\App\Controllers\AdminController::class, 'servicesUpdate'],
            '#^/yonetim/hizmetler/sil/(\d+)$#' => [\App\Controllers\AdminController::class, 'servicesDelete'],
            '#^/yonetim/slider/duzenle/(\d+)$#' => [\App\Controllers\AdminController::class, 'sliderEdit'],
            '#^/yonetim/slider/guncelle/(\d+)$#' => [\App\Controllers\AdminController::class, 'sliderUpdate'],
            '#^/yonetim/slider/sil/(\d+)$#' => [\App\Controllers\AdminController::class, 'sliderDelete'],
            '#^/yonetim/logolar/sil/(\d+)$#' => [\App\Controllers\AdminController::class, 'logosDelete']
        ];

        // Match Routes
        foreach ($routes as $pattern => $handler) {
            // Exact match
            if ($pattern === $path) {
                $controller = new $handler[0]();
                return $controller->{$handler[1]}();
            }

            // Regex match
            if (str_starts_with($pattern, '#') && preg_match($pattern, $path, $matches)) {
                array_shift($matches); // Remove full match
                $controller = new $handler[0]();
                return $controller->{$handler[1]}(...$matches);
            }
        }

        return "404 - Sayfa Bulunamadı";
    }
}
