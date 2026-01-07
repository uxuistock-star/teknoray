-- TeknoRay CMS Database Schema
-- For MySQL 5.7+ / MariaDB

-- Create Database
CREATE DATABASE IF NOT EXISTS teknoray_cms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE teknoray_cms;

-- =============================================
-- PROJECTS TABLE
-- =============================================
CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    category VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    image VARCHAR(500) NOT NULL,
    client VARCHAR(255) DEFAULT NULL,
    year VARCHAR(4) DEFAULT NULL,
    gallery TEXT DEFAULT NULL COMMENT 'JSON array of image URLs',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_category (category),
    INDEX idx_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- BLOG CATEGORIES TABLE
-- =============================================
CREATE TABLE blog_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    slug VARCHAR(180) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- BLOG POSTS TABLE
-- =============================================
CREATE TABLE blog_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    category_id INT DEFAULT NULL,
    summary TEXT NOT NULL,
    content LONGTEXT NOT NULL,
    thumbnail VARCHAR(500) NOT NULL,
    views INT DEFAULT 0,
    meta_title VARCHAR(255) DEFAULT NULL,
    meta_description TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_slug (slug),
    INDEX idx_category (category_id),
    CONSTRAINT fk_blog_posts_category FOREIGN KEY (category_id) REFERENCES blog_categories(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- PROJECT CATEGORIES TABLE
-- =============================================
CREATE TABLE project_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    slug VARCHAR(180) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- SERVICES TABLE
-- =============================================
CREATE TABLE services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    summary TEXT NOT NULL,
    description TEXT DEFAULT NULL,
    image_url VARCHAR(500) DEFAULT NULL,
    icon VARCHAR(100) DEFAULT NULL,
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_order (display_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- SLIDER TABLE
-- =============================================
CREATE TABLE slider (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT DEFAULT NULL,
    media_url VARCHAR(500) NOT NULL,
    media_type ENUM('image', 'video') DEFAULT 'image',
    button1_text VARCHAR(100) DEFAULT NULL,
    button1_link VARCHAR(255) DEFAULT NULL,
    button2_text VARCHAR(100) DEFAULT NULL,
    button2_link VARCHAR(255) DEFAULT NULL,
    display_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_order (display_order),
    INDEX idx_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- REFERENCE LOGOS TABLE
-- =============================================
CREATE TABLE reference_logos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_name VARCHAR(255) NOT NULL,
    logo_url VARCHAR(500) NOT NULL,
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_order (display_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- SETTINGS TABLE (Key-Value Store)
-- =============================================
CREATE TABLE settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT DEFAULT NULL,
    setting_group VARCHAR(50) DEFAULT 'general' COMMENT 'general, seo, contact, social, header, footer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_group (setting_group)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- USERS TABLE (Admin)
-- =============================================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL COMMENT 'bcrypt hashed',
    email VARCHAR(255) DEFAULT NULL,
    role ENUM('admin', 'editor') DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- SEED DATA
-- =============================================

-- Default Admin User (password: teknoray2026)
INSERT INTO users (username, password, email, role) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@teknoray.com.tr', 'admin');

-- Sample Projects
INSERT INTO projects (title, slug, category, description, image, client, year, gallery) VALUES
('Giga Factory İstanbul', 'giga-factory-istanbul', 'Endüstriyel Yapı', 'Tesla Giga Factory için 50.000 m² endüstriyel zemin kaplama, yüksek voltaj elektrik altyapısı ve otomasyon sistemleri.', 'https://images.unsplash.com/photo-1581092160562-40aa08e78837?auto=format&fit=crop&q=80', 'Tesla Motors', '2024', '["https://images.unsplash.com/photo-1581092160562-40aa08e78837?auto=format&fit=crop&q=80","https://images.unsplash.com/photo-1587293852726-70cdb56c2866?auto=format&fit=crop&q=80"]'),
('Enerji Santrali Modernizasyonu', 'enerji-santrali-modernizasyonu', 'Enerji', 'Doğalgaz kombine çevrim santrali için tesisat ve mekanik altyapı yenileme projesi.', 'https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?auto=format&fit=crop&q=80', 'EÜAŞ', '2023', '[]');
-- Blog Categories
INSERT INTO blog_categories (name, slug) VALUES
('Teknoloji', 'teknoloji'),
('Sürdürülebilirlik', 'surdurulebilirlik'),
('Proje Haberleri', 'proje-haberleri');

-- Sample Blog Posts
INSERT INTO blog_posts (title, slug, category_id, summary, content, thumbnail, views) VALUES
('Endüstri 4.0 ve Üretim Sistemleri', 'endustri-4-0-ve-uretim-sistemleri', 1, 'Endüstri 4.0 transformasyonu ve akıllı fabrika konseptleri hakkında kapsamlı rehber.', '<p>Endüstri 4.0, otomasyon ve veri alışverişini içeren üretim teknolojilerindeki son trendleri ifade eder.</p>', 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&q=80', 1250);

-- Project Categories
INSERT INTO project_categories (name, slug) VALUES
('Endüstriyel Yapı', 'endustriyel-yapi'),
('Enerji', 'enerji'),
('Lojistik', 'lojistik'),
('Ar-Ge', 'ar-ge'),
('Ticari Kompleks', 'ticari-kompleks');

-- Sample Services
INSERT INTO services (title, summary, display_order) VALUES
('Endüstriyel Yapı İnşaatı', 'Fabrika, depo ve lojistik merkezleri için anahtar teslim çözümler', 1),
('Yenilenebilir Enerji', 'Solar, rüzgar ve hidroelektrik enerji sistemleri kurulumu', 2),
('Tesisat ve Mekanik', 'Endüstriyel HVAC, boru hattı ve mekanik sistemler', 3);

-- Sample Slider
INSERT INTO slider (title, description, media_url, media_type, button1_text, button1_link, display_order, is_active) VALUES
('GELECEĞİ İNŞA ET', 'Sürdürülebilir endüstriyel çözümler ve ileri teknoloji enerji sistemleri ile yarını bugünden tasarlıyoruz.', 'https://assets.mixkit.co/videos/preview/mixkit-factory-conveyor-belt-industry-1563-large.mp4', 'video', 'Projelerimiz', '/projects', 1, 1),
('Raylı Sistemler ve Kamu Projelerinde Güçlü Portföy', 'TÜRASAŞ, TÜVASAŞ, YHT ve restorasyon projelerinde epoksi zemin, tesisat ve iklimlendirme', 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&q=80', 'image', 'Detaylar', '/projects', 2, 1);

-- Sample Reference Logos
INSERT INTO reference_logos (company_name, logo_url, display_order) VALUES
('Siemens', 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ab/Siemens-logo.svg/200px-Siemens-logo.svg.png', 1),
('Bosch', 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/ca/Bosch-logotype.svg/200px-Bosch-logotype.svg.png', 2),
('Aselsan', 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/15/Aselsan_logo.svg/200px-Aselsan_logo.svg.png', 3);

-- Sample Settings
INSERT INTO settings (setting_key, setting_value, setting_group) VALUES
-- General
('site_name', 'TeknoRay Yapı Enerji', 'general'),
('site_tagline', 'Geleceği İnşa Eden Güç', 'general'),
('site_description', '1941''den beri endüstriyel yapı ve enerji sektöründe güven, inovasyon ve sürdürülebilirlik odaklı çözümler üretiyoruz.', 'general'),

-- SEO
('seo_title', 'TeknoRay Yapı Enerji | Geleceği İnşa Eden Güç', 'seo'),
('seo_description', '1941''den beri endüstriyel yapı ve enerji sektöründe güven, inovasyon ve sürdürülebilirlik odaklı çözümler.', 'seo'),
('seo_keywords', 'endüstriyel yapı, yenilenebilir enerji, teknoray, inşaat, sürdürülebilirlik', 'seo'),
('og_title', 'TeknoRay Yapı Enerji', 'seo'),
('og_description', 'Endüstriyel yapı ve yenilenebilir enerji alanında 80+ yıllık deneyim.', 'seo'),
('google_analytics', '', 'seo'),

-- Contact
('contact_phone', '+90 (212) 000 00 00', 'contact'),
('contact_email', 'info@teknoray.com.tr', 'contact'),
('contact_address', 'Maslak Mah. Büyükdere Cad. No:123, Sarıyer / İstanbul', 'contact'),

-- Social
('social_linkedin', '', 'social'),
('social_instagram', '', 'social'),
('social_youtube', '', 'social'),
('social_twitter', '', 'social'),

-- Header
('header_phone', '+90 (212) 000 00 00', 'header'),
('header_email', 'info@teknoray.com.tr', 'header'),

-- Footer
('footer_description', '1941''den beri endüstriyel yapı ve enerji sektöründe güven, inovasyon ve sürdürülebilirlik odaklı çözümler üretiyoruz.', 'footer');
