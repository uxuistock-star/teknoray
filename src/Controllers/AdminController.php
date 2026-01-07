<?php

namespace App\Controllers;

use App\Core\View;

class AdminController
{
    public function __construct()
    {
        // Start session if not started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    private function requirePost(string $redirectUrl): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            \App\Core\Session::setFlash('error', 'Geçersiz istek yöntemi.');
            \App\Core\Helper::redirect($redirectUrl);
        }
    }

    private function requireValidCsrfToken(string $redirectUrl): void
    {
        $security = new \App\Security\SecurityManager();
        $token = $_POST['csrf_token'] ?? null;
        if (!$security->validateCsrfToken(is_string($token) ? $token : null)) {
            \App\Core\Session::setFlash('error', 'Güvenlik doğrulaması başarısız (CSRF).');
            \App\Core\Helper::redirect($redirectUrl);
        }
    }

    private function getServicesImageColumn(): string
    {
        try {
            $row = \App\Core\Database::fetch(
                "SELECT COUNT(*) AS c FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'services' AND column_name = 'image_url'"
            );
            if (!empty($row) && (int) ($row['c'] ?? 0) > 0) {
                return 'image_url';
            }
        } catch (\Throwable $e) {
            // ignore
        }

        return 'image';
    }

    private function checkAuth()
    {
        if (!isset($_SESSION['admin_logged_in'])) {
            header('Location: /yonetim/giris');
            exit;
        }
    }

    private function renderAdmin(string $view, array $data = [])
    {
        $data['layout'] = 'admin';
        return View::render($view, $data);
    }

    // =====================
    // DASHBOARD
    // =====================
    public function dashboard()
    {
        $this->checkAuth();

        $stats = [
            'projects' => count(\App\Models\Project::all()),
            'services' => count(\App\Models\Service::all()),
            'blogs' => count(\App\Models\BlogPost::all())
        ];

        return $this->renderAdmin('admin/dashboard', [
            'title' => 'Yönetim Paneli',
            'pageTitle' => 'Yönetim Paneli',
            'activeMenu' => 'dashboard',
            'stats' => $stats
        ]);
    }

    // =====================
    // AUTH
    // =====================
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            if ($username === 'admin' && $password === 'teknoray2026') {
                $_SESSION['admin_logged_in'] = true;
                header('Location: /yonetim');
                exit;
            } else {
                $error = 'Hatalı kullanıcı adı veya şifre!';
            }
        }

        // Render login page directly without layout
        ob_start();
        $error = $error ?? null;
        require __DIR__ . '/../../views/admin/login.php';
        return ob_get_clean();
    }

    public function logout()
    {
        unset($_SESSION['admin_logged_in']);
        header('Location: /yonetim/giris');
        exit;
    }

    // =====================
    // PROJECTS CRUD
    // =====================
    public function projectsIndex()
    {
        $this->checkAuth();

        return $this->renderAdmin('admin/projects/index', [
            'title' => 'Projeler',
            'pageTitle' => 'Projeler',
            'activeMenu' => 'projects',
            'projects' => \App\Models\Project::all()
        ]);
    }

    public function projectsCreate()
    {
        $this->checkAuth();

        return $this->renderAdmin('admin/projects/form', [
            'title' => 'Yeni Proje',
            'pageTitle' => 'Yeni Proje Oluştur',
            'activeMenu' => 'projects',
            'categories' => \App\Models\ProjectCategory::all()
        ]);
    }

    public function projectsEdit(int $id)
    {
        $this->checkAuth();

        $project = \App\Models\Project::find($id);
        if (!$project) {
            return "Proje bulunamadı";
        }

        return $this->renderAdmin('admin/projects/form', [
            'title' => 'Proje Düzenle',
            'pageTitle' => 'Proje Düzenle',
            'activeMenu' => 'projects',
            'project' => $project,
            'categories' => \App\Models\ProjectCategory::all()
        ]);
    }

    public function projectCategories()
    {
        $this->checkAuth();

        return $this->renderAdmin('admin/projects/categories', [
            'title' => 'Proje Kategorileri',
            'pageTitle' => 'Proje Kategorileri',
            'activeMenu' => 'projects',
            'categories' => \App\Models\ProjectCategory::all()
        ]);
    }

    public function projectCategoriesStore()
    {
        $this->checkAuth();

        $this->requirePost('/yonetim/projeler/kategoriler');
        $this->requireValidCsrfToken('/yonetim/projeler/kategoriler');

        $name = trim($_POST['name'] ?? '');
        if ($name === '') {
            \App\Core\Session::setFlash('error', 'Kategori adı zorunludur!');
            \App\Core\Helper::redirect('/yonetim/projeler/kategoriler');
        }

        $slug = \App\Core\Helper::generateSlug($name);

        try {
            \App\Models\ProjectCategory::createCategory(['name' => $name, 'slug' => $slug]);
            \App\Core\Session::setFlash('success', 'Kategori eklendi!');
        } catch (\Throwable $e) {
            \App\Core\Session::setFlash('error', 'Hata: ' . $e->getMessage());
        }

        \App\Core\Helper::redirect('/yonetim/projeler/kategoriler');
    }

    public function projectCategoriesDelete(int $id)
    {
        $this->checkAuth();

        $this->requirePost('/yonetim/projeler/kategoriler');
        $this->requireValidCsrfToken('/yonetim/projeler/kategoriler');

        try {
            \App\Models\ProjectCategory::deleteCategory($id);
            \App\Core\Session::setFlash('success', 'Kategori silindi!');
        } catch (\Throwable $e) {
            \App\Core\Session::setFlash('error', 'Hata: ' . $e->getMessage());
        }

        \App\Core\Helper::redirect('/yonetim/projeler/kategoriler');
    }

    public function projectsStore()
    {
        $this->checkAuth();

        $this->requirePost('/yonetim/projeler/ekle');
        $this->requireValidCsrfToken('/yonetim/projeler/ekle');

        // Validation
        if (empty($_POST['title']) || empty($_POST['category']) || empty($_POST['description'])) {
            \App\Core\Session::setFlash('error', 'Lütfen tüm gerekli alanları doldurun!');
            \App\Core\Helper::redirect('/yonetim/projeler/ekle');
        }

        // Generate slug if empty
        $slug = !empty($_POST['slug']) ? $_POST['slug'] : \App\Core\Helper::generateSlug($_POST['title']);

        // Process cover image - prioritize file upload over URL
        $coverImage = '';
        try {
            if (!empty($_FILES['cover_image']) && isset($_FILES['cover_image']['tmp_name']) && $_FILES['cover_image']['tmp_name'] !== '') {
                $coverImage = \App\Core\Upload::save(
                    $_FILES['cover_image'],
                    ['gif', 'png', 'jpg', 'jpeg', 'svg'],
                    10 * 1024 * 1024,
                    'projects'
                );
            } elseif (!empty($_POST['image'])) {
                $coverImage = trim($_POST['image']);
            } else {
                \App\Core\Session::setFlash('error', 'Lütfen kapak fotoğrafı yükleyin veya URL girin!');
                \App\Core\Helper::redirect('/yonetim/projeler/ekle');
            }
        } catch (\Exception $e) {
            \App\Core\Session::setFlash('error', 'Kapak fotoğrafı yükleme hatası: ' . $e->getMessage());
            \App\Core\Helper::redirect('/yonetim/projeler/ekle');
        }

        // Process gallery - combine file uploads and URLs
        $gallery = [];
        
        // Add uploaded gallery files
        if (!empty($_FILES['gallery_files']) && is_array($_FILES['gallery_files']['name'])) {
            $fileCount = count($_FILES['gallery_files']['name']);
            for ($i = 0; $i < $fileCount; $i++) {
                if ($_FILES['gallery_files']['error'][$i] === UPLOAD_ERR_OK) {
                    try {
                        $file = [
                            'name' => $_FILES['gallery_files']['name'][$i],
                            'type' => $_FILES['gallery_files']['type'][$i],
                            'tmp_name' => $_FILES['gallery_files']['tmp_name'][$i],
                            'error' => $_FILES['gallery_files']['error'][$i],
                            'size' => $_FILES['gallery_files']['size'][$i]
                        ];
                        $gallery[] = \App\Core\Upload::save(
                            $file,
                            ['gif', 'png', 'jpg', 'jpeg', 'svg'],
                            10 * 1024 * 1024,
                            'projects/gallery'
                        );
                    } catch (\Exception $e) {
                        // Skip failed uploads, continue with others
                    }
                }
            }
        }
        
        // Add URLs from textarea
        if (!empty($_POST['gallery'])) {
            $urls = array_filter(array_map('trim', explode("\n", $_POST['gallery'])));
            $gallery = array_merge($gallery, $urls);
        }

        $data = [
            'title' => $_POST['title'],
            'slug' => $slug,
            'category' => $_POST['category'],
            'description' => $_POST['description'],
            'image' => $coverImage,
            'client' => $_POST['client'] ?? null,
            'year' => $_POST['year'] ?? null,
            'gallery' => json_encode($gallery)
        ];

        try {
            \App\Models\Project::create($data);
            \App\Core\Session::setFlash('success', 'Proje başarıyla oluşturuldu!');
        } catch (\Exception $e) {
            \App\Core\Session::setFlash('error', 'Hata: ' . $e->getMessage());
        }

        \App\Core\Helper::redirect('/yonetim/projeler');
    }

    public function projectsUpdate(int $id)
    {
        $this->checkAuth();

        $this->requirePost('/yonetim/projeler/duzenle/' . $id);
        $this->requireValidCsrfToken('/yonetim/projeler/duzenle/' . $id);

        $project = \App\Models\Project::find($id);
        if (!$project) {
            \App\Core\Session::setFlash('error', 'Proje bulunamadı!');
            \App\Core\Helper::redirect('/yonetim/projeler');
        }

        // Validation
        if (empty($_POST['title']) || empty($_POST['category']) || empty($_POST['description'])) {
            \App\Core\Session::setFlash('error', 'Lütfen tüm gerekli alanları doldurun!');
            \App\Core\Helper::redirect('/yonetim/projeler/duzenle/' . $id);
        }

        // Generate slug if empty
        $slug = !empty($_POST['slug']) ? $_POST['slug'] : \App\Core\Helper::generateSlug($_POST['title']);

        // Process cover image - prioritize file upload over URL, preserve existing if neither provided
        $coverImage = $project['image'] ?? '';
        try {
            if (!empty($_FILES['cover_image']) && isset($_FILES['cover_image']['tmp_name']) && $_FILES['cover_image']['tmp_name'] !== '') {
                $coverImage = \App\Core\Upload::save(
                    $_FILES['cover_image'],
                    ['gif', 'png', 'jpg', 'jpeg', 'svg'],
                    10 * 1024 * 1024,
                    'projects'
                );
            } elseif (!empty($_POST['image'])) {
                $coverImage = trim($_POST['image']);
            }
        } catch (\Exception $e) {
            \App\Core\Session::setFlash('error', 'Kapak fotoğrafı yükleme hatası: ' . $e->getMessage());
            \App\Core\Helper::redirect('/yonetim/projeler/duzenle/' . $id);
        }

        // Process gallery - start with existing gallery, then add new files/URLs
        $gallery = [];
        if (!empty($project['gallery'])) {
            if (is_string($project['gallery'])) {
                $gallery = json_decode($project['gallery'], true) ?: [];
            } elseif (is_array($project['gallery'])) {
                $gallery = $project['gallery'];
            }
        }
        
        // Add uploaded gallery files
        if (!empty($_FILES['gallery_files']) && is_array($_FILES['gallery_files']['name'])) {
            $fileCount = count($_FILES['gallery_files']['name']);
            for ($i = 0; $i < $fileCount; $i++) {
                if ($_FILES['gallery_files']['error'][$i] === UPLOAD_ERR_OK) {
                    try {
                        $file = [
                            'name' => $_FILES['gallery_files']['name'][$i],
                            'type' => $_FILES['gallery_files']['type'][$i],
                            'tmp_name' => $_FILES['gallery_files']['tmp_name'][$i],
                            'error' => $_FILES['gallery_files']['error'][$i],
                            'size' => $_FILES['gallery_files']['size'][$i]
                        ];
                        $gallery[] = \App\Core\Upload::save(
                            $file,
                            ['gif', 'png', 'jpg', 'jpeg', 'svg'],
                            10 * 1024 * 1024,
                            'projects/gallery'
                        );
                    } catch (\Exception $e) {
                        // Skip failed uploads, continue with others
                    }
                }
            }
        }
        
        // Add URLs from textarea to gallery
        // If URLs are provided, they are added to existing gallery + new uploads
        // User can manage full gallery via textarea if needed
        if (!empty($_POST['gallery'])) {
            $urls = array_filter(array_map('trim', explode("\n", $_POST['gallery'])));
            $gallery = array_merge($gallery, $urls);
        }

        $data = [
            'title' => $_POST['title'],
            'slug' => $slug,
            'category' => $_POST['category'],
            'description' => $_POST['description'],
            'image' => $coverImage,
            'client' => $_POST['client'] ?? null,
            'year' => $_POST['year'] ?? null,
            'gallery' => json_encode($gallery)
        ];

        try {
            \App\Models\Project::update($id, $data);
            \App\Core\Session::setFlash('success', 'Proje başarıyla güncellendi!');
        } catch (\Exception $e) {
            \App\Core\Session::setFlash('error', 'Hata: ' . $e->getMessage());
        }

        \App\Core\Helper::redirect('/yonetim/projeler');
    }

    public function projectsDelete(int $id)
    {
        $this->checkAuth();

        $this->requirePost('/yonetim/projeler');
        $this->requireValidCsrfToken('/yonetim/projeler');

        try {
            \App\Models\Project::delete($id);
            \App\Core\Session::setFlash('success', 'Proje başarıyla silindi!');
        } catch (\Exception $e) {
            \App\Core\Session::setFlash('error', 'Hata: ' . $e->getMessage());
        }

        \App\Core\Helper::redirect('/yonetim/projeler');
    }

    // =====================
    // BLOG CRUD
    // =====================
    public function blogIndex()
    {
        $this->checkAuth();

        $categories = \App\Models\BlogCategory::all();
        $categoriesById = [];
        foreach ($categories as $cat) {
            if (isset($cat['id'])) {
                $categoriesById[(int) $cat['id']] = $cat;
            }
        }

        return $this->renderAdmin('admin/blog/index', [
            'title' => 'Blog Yazıları',
            'pageTitle' => 'Blog Yazıları',
            'activeMenu' => 'blog',
            'posts' => \App\Models\BlogPost::all(),
            'categoriesById' => $categoriesById
        ]);
    }

    public function blogCreate()
    {
        $this->checkAuth();

        return $this->renderAdmin('admin/blog/form', [
            'title' => 'Yeni Yazı',
            'pageTitle' => 'Yeni Blog Yazısı',
            'activeMenu' => 'blog',
            'categories' => \App\Models\BlogCategory::all()
        ]);
    }

    public function blogEdit(int $id)
    {
        $this->checkAuth();

        $post = \App\Models\BlogPost::find($id);
        if (!$post) {
            return "Yazı bulunamadı";
        }

        return $this->renderAdmin('admin/blog/form', [
            'title' => 'Yazı Düzenle',
            'pageTitle' => 'Blog Yazısı Düzenle',
            'activeMenu' => 'blog',
            'post' => $post,
            'categories' => \App\Models\BlogCategory::all()
        ]);
    }

    public function blogCategories()
    {
        $this->checkAuth();

        return $this->renderAdmin('admin/blog/categories', [
            'title' => 'Blog Kategorileri',
            'pageTitle' => 'Blog Kategorileri',
            'activeMenu' => 'blog',
            'categories' => \App\Models\BlogCategory::all()
        ]);
    }

    public function blogCategoriesStore()
    {
        $this->checkAuth();

        $this->requirePost('/yonetim/blog/kategoriler');
        $this->requireValidCsrfToken('/yonetim/blog/kategoriler');

        $name = trim($_POST['name'] ?? '');
        if ($name === '') {
            \App\Core\Session::setFlash('error', 'Kategori adı zorunludur!');
            \App\Core\Helper::redirect('/yonetim/blog/kategoriler');
        }

        $slug = \App\Core\Helper::generateSlug($name);

        try {
            \App\Models\BlogCategory::createCategory(['name' => $name, 'slug' => $slug]);
            \App\Core\Session::setFlash('success', 'Kategori eklendi!');
        } catch (\Throwable $e) {
            \App\Core\Session::setFlash('error', 'Hata: ' . $e->getMessage());
        }

        \App\Core\Helper::redirect('/yonetim/blog/kategoriler');
    }

    public function blogCategoriesDelete(int $id)
    {
        $this->checkAuth();

        $this->requirePost('/yonetim/blog/kategoriler');
        $this->requireValidCsrfToken('/yonetim/blog/kategoriler');

        try {
            \App\Models\BlogCategory::deleteCategory($id);
            \App\Core\Session::setFlash('success', 'Kategori silindi!');
        } catch (\Throwable $e) {
            \App\Core\Session::setFlash('error', 'Hata: ' . $e->getMessage());
        }

        \App\Core\Helper::redirect('/yonetim/blog/kategoriler');
    }

    public function blogStore()
    {
        $this->checkAuth();

        $this->requirePost('/yonetim/blog/ekle');
        $this->requireValidCsrfToken('/yonetim/blog/ekle');

        // Validation
        if (empty($_POST['title']) || empty($_POST['summary']) || empty($_POST['content'])) {
            \App\Core\Session::setFlash('error', 'Lütfen tüm gerekli alanları doldurun!');
            \App\Core\Helper::redirect('/yonetim/blog/ekle');
        }

        $finalThumbnail = trim($_POST['thumbnail'] ?? '');
        try {
            if (!empty($_FILES['thumbnail_file']) && isset($_FILES['thumbnail_file']['tmp_name']) && $_FILES['thumbnail_file']['tmp_name'] !== '') {
                $finalThumbnail = \App\Core\Upload::save(
                    $_FILES['thumbnail_file'],
                    ['gif', 'png', 'jpg', 'jpeg', 'svg'],
                    10 * 1024 * 1024,
                    'blog'
                );
            }
        } catch (\Exception $e) {
            \App\Core\Session::setFlash('error', 'Görsel yükleme hatası: ' . $e->getMessage());
            \App\Core\Helper::redirect('/yonetim/blog/ekle');
        }

        if ($finalThumbnail === '') {
            \App\Core\Session::setFlash('error', 'Lütfen kapak görseli için dosya yükleyin veya URL girin!');
            \App\Core\Helper::redirect('/yonetim/blog/ekle');
        }

        // Generate slug if empty
        $slug = !empty($_POST['slug']) ? $_POST['slug'] : \App\Core\Helper::generateSlug($_POST['title']);

        $data = [
            'title' => $_POST['title'],
            'slug' => $slug,
            'category_id' => $_POST['category_id'] ?? null,
            'summary' => $_POST['summary'],
            'content' => $_POST['content'],
            'thumbnail' => $finalThumbnail,
            'meta_title' => $_POST['meta_title'] ?? null,
            'meta_description' => $_POST['meta_description'] ?? null
        ];

        try {
            \App\Models\BlogPost::create($data);
            \App\Core\Session::setFlash('success', 'Blog yazısı başarıyla oluşturuldu!');
        } catch (\Exception $e) {
            \App\Core\Session::setFlash('error', 'Hata: ' . $e->getMessage());
        }

        \App\Core\Helper::redirect('/yonetim/blog');
    }

    public function blogUpdate(int $id)
    {
        $this->checkAuth();

        $this->requirePost('/yonetim/blog/duzenle/' . $id);
        $this->requireValidCsrfToken('/yonetim/blog/duzenle/' . $id);

        $post = \App\Models\BlogPost::find($id);
        if (!$post) {
            \App\Core\Session::setFlash('error', 'Yazı bulunamadı!');
            \App\Core\Helper::redirect('/yonetim/blog');
        }

        // Validation
        if (empty($_POST['title']) || empty($_POST['summary']) || empty($_POST['content'])) {
            \App\Core\Session::setFlash('error', 'Lütfen tüm gerekli alanları doldurun!');
            \App\Core\Helper::redirect('/yonetim/blog/duzenle/' . $id);
        }

        $finalThumbnail = trim($_POST['thumbnail'] ?? '');
        try {
            if (!empty($_FILES['thumbnail_file']) && isset($_FILES['thumbnail_file']['tmp_name']) && $_FILES['thumbnail_file']['tmp_name'] !== '') {
                $finalThumbnail = \App\Core\Upload::save(
                    $_FILES['thumbnail_file'],
                    ['gif', 'png', 'jpg', 'jpeg', 'svg'],
                    10 * 1024 * 1024,
                    'blog'
                );
            }
        } catch (\Exception $e) {
            \App\Core\Session::setFlash('error', 'Görsel yükleme hatası: ' . $e->getMessage());
            \App\Core\Helper::redirect('/yonetim/blog/duzenle/' . $id);
        }

        if ($finalThumbnail === '') {
            $finalThumbnail = (string) ($post['thumbnail'] ?? '');
        }

        // Generate slug if empty
        $slug = !empty($_POST['slug']) ? $_POST['slug'] : \App\Core\Helper::generateSlug($_POST['title']);

        $data = [
            'title' => $_POST['title'],
            'slug' => $slug,
            'category_id' => $_POST['category_id'] ?? null,
            'summary' => $_POST['summary'],
            'content' => $_POST['content'],
            'thumbnail' => $finalThumbnail,
            'meta_title' => $_POST['meta_title'] ?? null,
            'meta_description' => $_POST['meta_description'] ?? null
        ];

        try {
            \App\Models\BlogPost::update($id, $data);
            \App\Core\Session::setFlash('success', 'Blog yazısı başarıyla güncellendi!');
        } catch (\Exception $e) {
            \App\Core\Session::setFlash('error', 'Hata: ' . $e->getMessage());
        }

        \App\Core\Helper::redirect('/yonetim/blog');
    }

    public function blogDelete(int $id)
    {
        $this->checkAuth();

        $this->requirePost('/yonetim/blog');
        $this->requireValidCsrfToken('/yonetim/blog');

        try {
            \App\Models\BlogPost::delete($id);
            \App\Core\Session::setFlash('success', 'Blog yazısı başarıyla silindi!');
        } catch (\Exception $e) {
            \App\Core\Session::setFlash('error', 'Hata: ' . $e->getMessage());
        }

        \App\Core\Helper::redirect('/yonetim/blog');
    }

    // =====================
    // SERVICES
    // =====================
    public function servicesIndex()
    {
        $this->checkAuth();

        return $this->renderAdmin('admin/services/index', [
            'title' => 'Hizmetler',
            'pageTitle' => 'Hizmetler',
            'activeMenu' => 'services',
            'services' => \App\Models\Service::all()
        ]);
    }

    public function servicesCreate()
    {
        $this->checkAuth();

        return $this->renderAdmin('admin/services/form', [
            'title' => 'Yeni Hizmet',
            'pageTitle' => 'Yeni Hizmet Ekle',
            'activeMenu' => 'services'
        ]);
    }

    public function servicesEdit(int $id)
    {
        $this->checkAuth();

        $service = \App\Models\Service::find($id);
        if (!$service) {
            \App\Core\Session::setFlash('error', 'Hizmet bulunamadı!');
            \App\Core\Helper::redirect('/yonetim/hizmetler');
        }

        return $this->renderAdmin('admin/services/form', [
            'title' => 'Hizmet Düzenle',
            'pageTitle' => 'Hizmet Düzenle',
            'activeMenu' => 'services',
            'service' => $service
        ]);
    }

    public function servicesStore()
    {
        $this->checkAuth();

        $this->requirePost('/yonetim/hizmetler/ekle');
        $this->requireValidCsrfToken('/yonetim/hizmetler/ekle');

        if (empty($_POST['title']) || empty($_POST['summary'])) {
            \App\Core\Session::setFlash('error', 'Lütfen tüm gerekli alanları doldurun!');
            \App\Core\Helper::redirect('/yonetim/hizmetler/ekle');
        }

        $data = [
            'title' => $_POST['title'],
            'summary' => $_POST['summary'],
            'description' => $_POST['description'] ?? null,
            'icon' => $_POST['icon'] ?? null,
            'display_order' => isset($_POST['display_order']) ? (int) $_POST['display_order'] : 0,
        ];

        try {
            if (!empty($_FILES['image']) && isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name'] !== '') {
                $imageColumn = $this->getServicesImageColumn();
                $data[$imageColumn] = \App\Core\Upload::save(
                    $_FILES['image'],
                    ['gif', 'png', 'jpg', 'jpeg', 'mp4', 'svg'],
                    10 * 1024 * 1024,
                    'services'
                );
            }
        } catch (\Exception $e) {
            \App\Core\Session::setFlash('error', 'Görsel yükleme hatası: ' . $e->getMessage());
            \App\Core\Helper::redirect('/yonetim/hizmetler/ekle');
        }

        try {
            \App\Models\Service::create($data);
            \App\Core\Session::setFlash('success', 'Hizmet başarıyla oluşturuldu!');
        } catch (\Exception $e) {
            \App\Core\Session::setFlash('error', 'Hata: ' . $e->getMessage());
        }

        \App\Core\Helper::redirect('/yonetim/hizmetler');
    }

    public function servicesUpdate(int $id)
    {
        $this->checkAuth();

        $this->requirePost('/yonetim/hizmetler/duzenle/' . $id);
        $this->requireValidCsrfToken('/yonetim/hizmetler/duzenle/' . $id);

        $service = \App\Models\Service::find($id);
        if (!$service) {
            \App\Core\Session::setFlash('error', 'Hizmet bulunamadı!');
            \App\Core\Helper::redirect('/yonetim/hizmetler');
        }

        if (empty($_POST['title']) || empty($_POST['summary'])) {
            \App\Core\Session::setFlash('error', 'Lütfen tüm gerekli alanları doldurun!');
            \App\Core\Helper::redirect('/yonetim/hizmetler/duzenle/' . $id);
        }

        $data = [
            'title' => $_POST['title'],
            'summary' => $_POST['summary'],
            'description' => $_POST['description'] ?? null,
            'icon' => $_POST['icon'] ?? null,
            'display_order' => isset($_POST['display_order']) ? (int) $_POST['display_order'] : 0,
        ];

        $imageColumn = $this->getServicesImageColumn();

        // Preserve existing image if no new file is uploaded
        $hasNewImage = !empty($_FILES['image']) && isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name'] !== '';
        
        if (!$hasNewImage) {
            if (!empty($service[$imageColumn])) {
                $data[$imageColumn] = $service[$imageColumn];
            }
        }

        try {
            if ($hasNewImage) {
                $data[$imageColumn] = \App\Core\Upload::save(
                    $_FILES['image'],
                    ['gif', 'png', 'jpg', 'jpeg', 'mp4', 'svg'],
                    10 * 1024 * 1024,
                    'services'
                );
            }
        } catch (\Exception $e) {
            \App\Core\Session::setFlash('error', 'Görsel yükleme hatası: ' . $e->getMessage());
            \App\Core\Helper::redirect('/yonetim/hizmetler/duzenle/' . $id);
        }

        try {
            \App\Models\Service::update($id, $data);
            \App\Core\Session::setFlash('success', 'Hizmet başarıyla güncellendi!');
        } catch (\Exception $e) {
            \App\Core\Session::setFlash('error', 'Hata: ' . $e->getMessage());
        }

        \App\Core\Helper::redirect('/yonetim/hizmetler');
    }

    public function servicesDelete(int $id)
    {
        $this->checkAuth();

        $this->requirePost('/yonetim/hizmetler');
        $this->requireValidCsrfToken('/yonetim/hizmetler');

        try {
            \App\Models\Service::delete($id);
            \App\Core\Session::setFlash('success', 'Hizmet başarıyla silindi!');
        } catch (\Exception $e) {
            \App\Core\Session::setFlash('error', 'Hata: ' . $e->getMessage());
        }

        \App\Core\Helper::redirect('/yonetim/hizmetler');
    }

    // =====================
    // SETTINGS
    // =====================
    public function settings()
    {
        $this->checkAuth();

        $settings = \App\Models\Setting::getAllGrouped();

        return $this->renderAdmin('admin/settings', [
            'title' => 'Ayarlar',
            'pageTitle' => 'Site Ayarları',
            'activeMenu' => 'settings',
            'settings' => $settings
        ]);
    }

    public function settingsSave()
    {
        $this->checkAuth();

        $this->requirePost('/yonetim/ayarlar');
        $this->requireValidCsrfToken('/yonetim/ayarlar');

        try {
            // General Settings
            if (isset($_POST['site_name'])) {
                \App\Models\Setting::bulkSet([
                    'site_name' => $_POST['site_name'],
                    'site_tagline' => $_POST['site_tagline'] ?? '',
                    'site_description' => $_POST['site_description'] ?? ''
                ], 'general');
            }

            // Contact Settings
            if (isset($_POST['contact_phone'])) {
                \App\Models\Setting::bulkSet([
                    'contact_phone' => $_POST['contact_phone'],
                    'contact_email' => $_POST['contact_email'] ?? '',
                    'contact_address' => $_POST['contact_address'] ?? ''
                ], 'contact');
            }

            // Social Media
            if (isset($_POST['social_linkedin'])) {
                \App\Models\Setting::bulkSet([
                    'social_linkedin' => $_POST['social_linkedin'] ?? '',
                    'social_instagram' => $_POST['social_instagram'] ?? '',
                    'social_youtube' => $_POST['social_youtube'] ?? '',
                    'social_twitter' => $_POST['social_twitter'] ?? ''
                ], 'social');
            }

            // Header Settings
            if (isset($_POST['header_phone']) || isset($_POST['header_email'])) {
                \App\Models\Setting::bulkSet([
                    'header_phone' => $_POST['header_phone'] ?? '',
                    'header_email' => $_POST['header_email'] ?? '',
                ], 'header');
            }

            // Footer Settings
            if (isset($_POST['footer_description']) || isset($_POST['footer_phone']) || isset($_POST['footer_email']) || isset($_POST['footer_address'])) {
                \App\Models\Setting::bulkSet([
                    'footer_description' => $_POST['footer_description'] ?? '',
                    'footer_phone' => $_POST['footer_phone'] ?? '',
                    'footer_email' => $_POST['footer_email'] ?? '',
                    'footer_address' => $_POST['footer_address'] ?? '',
                ], 'footer');
            }

            \App\Core\Session::setFlash('success', 'Ayarlar başarıyla kaydedildi!');
        } catch (\Exception $e) {
            \App\Core\Session::setFlash('error', 'Hata: ' . $e->getMessage());
        }

        \App\Core\Helper::redirect('/yonetim/ayarlar');
    }

    // =====================
    // SLIDER
    // =====================
    public function slider()
    {
        $this->checkAuth();

        return $this->renderAdmin('admin/slider', [
            'title' => 'Slider',
            'pageTitle' => 'Hero Slider Yönetimi',
            'activeMenu' => 'slider',
            'slides' => \App\Models\Slider::all()
        ]);
    }

    public function sliderCreate()
    {
        $this->checkAuth();

        return $this->renderAdmin('admin/slider', [
            'title' => 'Yeni Slide',
            'pageTitle' => 'Yeni Slide Ekle',
            'activeMenu' => 'slider',
            'mode' => 'create',
            'slides' => \App\Models\Slider::all()
        ]);
    }

    public function sliderEdit(int $id)
    {
        $this->checkAuth();

        $slide = \App\Models\Slider::find($id);
        if (!$slide) {
            \App\Core\Session::setFlash('error', 'Slide bulunamadı!');
            \App\Core\Helper::redirect('/yonetim/slider');
        }

        return $this->renderAdmin('admin/slider', [
            'title' => 'Slide Düzenle',
            'pageTitle' => 'Slide Düzenle',
            'activeMenu' => 'slider',
            'mode' => 'edit',
            'slide' => $slide,
            'slides' => \App\Models\Slider::all()
        ]);
    }

    public function sliderStore()
    {
        $this->checkAuth();

        $this->requirePost('/yonetim/slider');
        $this->requireValidCsrfToken('/yonetim/slider');

        if (empty($_POST['title'])) {
            \App\Core\Session::setFlash('error', 'Başlık alanı zorunludur!');
            \App\Core\Helper::redirect('/yonetim/slider/ekle');
        }

        $data = [
            'title' => $_POST['title'],
            'description' => $_POST['description'] ?? null,
            'button1_text' => $_POST['button1_text'] ?? null,
            'button1_link' => $_POST['button1_link'] ?? null,
            'button2_text' => $_POST['button2_text'] ?? null,
            'button2_link' => $_POST['button2_link'] ?? null,
            'display_order' => isset($_POST['display_order']) ? (int) $_POST['display_order'] : 0,
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
            'media_url' => '',
            'media_type' => 'image'
        ];

        try {
            if (empty($_FILES['media']) || !isset($_FILES['media']['tmp_name']) || $_FILES['media']['tmp_name'] === '') {
                \App\Core\Session::setFlash('error', 'Lütfen bir medya dosyası yükleyin (GIF/PNG/JPG/JPEG/MP4/SVG).');
                \App\Core\Helper::redirect('/yonetim/slider/ekle');
            }

            $data['media_url'] = \App\Core\Upload::save(
                $_FILES['media'],
                ['gif', 'png', 'jpg', 'jpeg', 'mp4', 'svg'],
                100 * 1024 * 1024,
                'slider'
            );

            $ext = strtolower(pathinfo($data['media_url'], PATHINFO_EXTENSION));
            $data['media_type'] = (in_array($ext, ['mp4'], true)) ? 'video' : 'image';
        } catch (\Exception $e) {
            \App\Core\Session::setFlash('error', 'Medya yükleme hatası: ' . $e->getMessage());
            \App\Core\Helper::redirect('/yonetim/slider/ekle');
        }

        try {
            \App\Models\Slider::create($data);
            \App\Core\Session::setFlash('success', 'Slide başarıyla oluşturuldu!');
        } catch (\Exception $e) {
            \App\Core\Session::setFlash('error', 'Hata: ' . $e->getMessage());
        }

        \App\Core\Helper::redirect('/yonetim/slider');
    }

    public function sliderUpdate(int $id)
    {
        $this->checkAuth();

        $this->requirePost('/yonetim/slider');
        $this->requireValidCsrfToken('/yonetim/slider');

        $slide = \App\Models\Slider::find($id);
        if (!$slide) {
            \App\Core\Session::setFlash('error', 'Slide bulunamadı!');
            \App\Core\Helper::redirect('/yonetim/slider');
        }

        if (empty($_POST['title'])) {
            \App\Core\Session::setFlash('error', 'Başlık alanı zorunludur!');
            \App\Core\Helper::redirect('/yonetim/slider/duzenle/' . $id);
        }

        $data = [
            'title' => $_POST['title'],
            'description' => $_POST['description'] ?? null,
            'button1_text' => $_POST['button1_text'] ?? null,
            'button1_link' => $_POST['button1_link'] ?? null,
            'button2_text' => $_POST['button2_text'] ?? null,
            'button2_link' => $_POST['button2_link'] ?? null,
            'display_order' => isset($_POST['display_order']) ? (int) $_POST['display_order'] : 0,
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ];

        try {
            if (!empty($_FILES['media']) && isset($_FILES['media']['tmp_name']) && $_FILES['media']['tmp_name'] !== '') {
                $data['media_url'] = \App\Core\Upload::save(
                    $_FILES['media'],
                    ['gif', 'png', 'jpg', 'jpeg', 'mp4', 'svg'],
                    100 * 1024 * 1024,
                    'slider'
                );

                $ext = strtolower(pathinfo($data['media_url'], PATHINFO_EXTENSION));
                $data['media_type'] = (in_array($ext, ['mp4'], true)) ? 'video' : 'image';
            }
        } catch (\Exception $e) {
            \App\Core\Session::setFlash('error', 'Medya yükleme hatası: ' . $e->getMessage());
            \App\Core\Helper::redirect('/yonetim/slider/duzenle/' . $id);
        }

        try {
            \App\Models\Slider::update($id, $data);
            \App\Core\Session::setFlash('success', 'Slide başarıyla güncellendi!');
        } catch (\Exception $e) {
            \App\Core\Session::setFlash('error', 'Hata: ' . $e->getMessage());
        }

        \App\Core\Helper::redirect('/yonetim/slider');
    }

    public function sliderDelete(int $id)
    {
        $this->checkAuth();

        $this->requirePost('/yonetim/slider');
        $this->requireValidCsrfToken('/yonetim/slider');

        try {
            \App\Models\Slider::delete($id);
            \App\Core\Session::setFlash('success', 'Slide başarıyla silindi!');
        } catch (\Exception $e) {
            \App\Core\Session::setFlash('error', 'Hata: ' . $e->getMessage());
        }

        \App\Core\Helper::redirect('/yonetim/slider');
    }

    // =====================
    // REFERENCE LOGOS
    // =====================
    public function logos()
    {
        $this->checkAuth();

        $logos = [];
        try {
            $logos = \App\Models\ReferenceLogo::all();
        } catch (\Throwable $e) {
            $logos = [];
        }

        return $this->renderAdmin('admin/logos', [
            'title' => 'Referans Logoları',
            'pageTitle' => 'Referans Şirket Logoları',
            'activeMenu' => 'logos',
            'logos' => $logos
        ]);
    }

    public function logosStore()
    {
        $this->checkAuth();

        $this->requirePost('/yonetim/logolar');
        $this->requireValidCsrfToken('/yonetim/logolar');

        $companyName = trim($_POST['company_name'] ?? '');
        $logoUrl = trim($_POST['logo_url'] ?? '');
        $displayOrder = isset($_POST['display_order']) ? (int) $_POST['display_order'] : 0;

        if ($companyName === '') {
            \App\Core\Session::setFlash('error', 'Lütfen şirket adı alanını doldurun!');
            \App\Core\Helper::redirect('/yonetim/logolar');
        }

        // Dosya yükleme kontrolü
        $finalLogoUrl = $logoUrl;

        try {
            if (!empty($_FILES['logo_file']) && isset($_FILES['logo_file']['tmp_name']) && $_FILES['logo_file']['tmp_name'] !== '') {
                // Dosya yüklendi, dosyayı kaydet
                $finalLogoUrl = \App\Core\Upload::save(
                    $_FILES['logo_file'],
                    ['gif', 'png', 'jpg', 'jpeg', 'svg'],
                    5 * 1024 * 1024, // 5MB limit
                    'logos'
                );
            } elseif ($logoUrl === '') {
                // Ne dosya ne de URL var
                \App\Core\Session::setFlash('error', 'Lütfen logo dosyası yükleyin veya logo URL girin!');
                \App\Core\Helper::redirect('/yonetim/logolar');
            }
        } catch (\Exception $e) {
            \App\Core\Session::setFlash('error', 'Logo yükleme hatası: ' . $e->getMessage());
            \App\Core\Helper::redirect('/yonetim/logolar');
        }

        try {
            \App\Models\ReferenceLogo::create([
                'company_name' => $companyName,
                'logo_url' => $finalLogoUrl,
                'display_order' => $displayOrder,
            ]);
            \App\Core\Session::setFlash('success', 'Logo başarıyla eklendi!');
        } catch (\Exception $e) {
            \App\Core\Session::setFlash('error', 'Hata: ' . $e->getMessage());
        }

        \App\Core\Helper::redirect('/yonetim/logolar');
    }

    public function logosDelete(int $id)
    {
        $this->checkAuth();

        $this->requirePost('/yonetim/logolar');
        $this->requireValidCsrfToken('/yonetim/logolar');

        try {
            \App\Models\ReferenceLogo::delete($id);
            \App\Core\Session::setFlash('success', 'Logo başarıyla silindi!');
        } catch (\Exception $e) {
            \App\Core\Session::setFlash('error', 'Hata: ' . $e->getMessage());
        }

        \App\Core\Helper::redirect('/yonetim/logolar');
    }

    // =====================
    // SEO
    // =====================
    public function seo()
    {
        $this->checkAuth();

        return $this->renderAdmin('admin/seo', [
            'title' => 'SEO Ayarları',
            'pageTitle' => 'SEO ve Meta Etiketleri',
            'activeMenu' => 'seo'
        ]);
    }

    public function seoSave()
    {
        $this->checkAuth();

        $this->requirePost('/yonetim/seo');
        $this->requireValidCsrfToken('/yonetim/seo');

        try {
            \App\Models\Setting::bulkSet([
                'seo_title' => $_POST['seo_title'] ?? '',
                'seo_description' => $_POST['seo_description'] ?? '',
                'seo_keywords' => $_POST['seo_keywords'] ?? '',
                'og_title' => $_POST['og_title'] ?? '',
                'og_description' => $_POST['og_description'] ?? '',
                'og_image' => $_POST['og_image'] ?? '',
                'google_analytics' => $_POST['google_analytics'] ?? '',
                'google_site_verification' => $_POST['google_site_verification'] ?? '',
                'robots_txt' => $_POST['robots_txt'] ?? '',
            ], 'seo');

            \App\Core\Session::setFlash('success', 'SEO ayarları başarıyla kaydedildi!');
        } catch (\Exception $e) {
            \App\Core\Session::setFlash('error', 'Hata: ' . $e->getMessage());
        }

        \App\Core\Helper::redirect('/yonetim/seo');
    }

    // =====================
    // HEADER/FOOTER
    // =====================
    public function headerFooter()
    {
        $this->checkAuth();

        \App\Core\Helper::redirect('/yonetim/ayarlar');
    }

    public function headerFooterSave()
    {
        $this->checkAuth();

        \App\Core\Helper::redirect('/yonetim/ayarlar');
    }
}
