<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? ($settings['general']['site_name'] ?? 'TeknoRay Yapı Enerji') ?> | <?= $settings['general']['site_tagline'] ?? 'Geleceği İnşa Eden Güç' ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Audiowide&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            blue: '#1C5B8B',
                            red: '#EC1B13'
                        },
                        muted: '#6B7280'
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                        heading: ['Audiowide', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style type="text/tailwindcss">
        @layer utilities {
            .text-glow { text-shadow: 0 0 10px rgba(236, 27, 19, 0.5); }
            .glass-header {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(12px);
                border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            }
        }
        /* Marquee Animation */
        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .animate-marquee {
            animation: marquee 30s linear infinite;
        }
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #fff; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #1C5B8B; }
        /* Hide Scrollbar on horizontal scroll containers */
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>

<body class="bg-white text-gray-900 font-sans antialiased">
    <?php
    $isHomePage = ($_SERVER['REQUEST_URI'] === '/' || $_SERVER['REQUEST_URI'] === '');
    $contactPhone = $settings['header']['header_phone'] ?? ($settings['contact']['contact_phone'] ?? '+90 (212) 000 00 00');
    $contactEmail = $settings['header']['header_email'] ?? ($settings['contact']['contact_email'] ?? 'info@teknoray.com.tr');
    $socialLinkedin = $settings['social']['social_linkedin'] ?? '';
    $socialInstagram = $settings['social']['social_instagram'] ?? '';
    $socialYoutube = $settings['social']['social_youtube'] ?? '';
    $socialTwitter = $settings['social']['social_twitter'] ?? '';
    $footerDescription = $settings['footer']['footer_description'] ?? "1941'den beri endüstriyel yapı ve enerji sektöründe güven, inovasyon ve sürdürülebilirlik odaklı çözümler üretiyoruz.";
    $footerAddress = $settings['footer']['footer_address'] ?? ($settings['contact']['contact_address'] ?? 'Maslak Mah. Büyükdere Cad. No:123\nSarıyer / İstanbul');
    $footerEmail = $settings['footer']['footer_email'] ?? $contactEmail;
    $footerPhone = $settings['footer']['footer_phone'] ?? $contactPhone;
    ?>

    <!-- Top Bar -->
    <?php if ($isHomePage): ?>
        <div class="fixed top-0 w-full z-50 bg-brand-red text-white text-[10px] md:text-xs py-2 shadow-sm">
    <?php else: ?>
        <div x-data="{ show: true }" @scroll.window="show = (window.pageYOffset < 20)"
            class="fixed top-0 w-full z-50 bg-brand-blue text-white text-[10px] md:text-xs py-2 transition-transform duration-300 shadow-sm"
            :class="show ? 'translate-y-0' : '-translate-y-full'">
    <?php endif; ?>
        <div class="container mx-auto px-6 flex justify-between items-center">
            <div class="flex items-center space-x-4 md:space-x-6">
                <a href="tel:<?= preg_replace('/\s+/', '', $contactPhone) ?>" class="hover:text-white/80 flex items-center gap-1 font-medium"><?= htmlspecialchars($contactPhone) ?></a>
                <a href="mailto:<?= htmlspecialchars($contactEmail) ?>"
                    class="hidden md:flex items-center gap-1 hover:text-white/80 font-medium"><?= htmlspecialchars($contactEmail) ?></a>
            </div>

            <div class="flex space-x-3">
                <?php if (!empty($socialLinkedin)): ?>
                    <a href="<?= htmlspecialchars($socialLinkedin) ?>" target="_blank" rel="noopener" aria-label="LinkedIn"
                        class="hover:text-white/80 inline-flex items-center justify-center w-7 h-7 rounded hover:bg-white/10 transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.446-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.604 0 4.267 2.372 4.267 5.456v6.285zM5.337 7.433a2.063 2.063 0 01-2.063-2.065 2.064 2.064 0 114.127 0 2.064 2.064 0 01-2.064 2.065zM6.814 20.452H3.86V9h2.954v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.727v20.545C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.273V1.727C24 .774 23.2 0 22.222 0z"/>
                        </svg>
                    </a>
                <?php endif; ?>
                <?php if (!empty($socialInstagram)): ?>
                    <a href="<?= htmlspecialchars($socialInstagram) ?>" target="_blank" rel="noopener" aria-label="Instagram"
                        class="hover:text-white/80 inline-flex items-center justify-center w-7 h-7 rounded hover:bg-white/10 transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M7.75 2h8.5A5.75 5.75 0 0122 7.75v8.5A5.75 5.75 0 0116.25 22h-8.5A5.75 5.75 0 012 16.25v-8.5A5.75 5.75 0 017.75 2zm0 1.5A4.25 4.25 0 003.5 7.75v8.5A4.25 4.25 0 007.75 20.5h8.5a4.25 4.25 0 004.25-4.25v-8.5A4.25 4.25 0 0016.25 3.5h-8.5zM12 7a5 5 0 110 10 5 5 0 010-10zm0 1.5a3.5 3.5 0 100 7 3.5 3.5 0 000-7zm5.75-1.9a1.15 1.15 0 110 2.3 1.15 1.15 0 010-2.3z"/>
                        </svg>
                    </a>
                <?php endif; ?>
                <?php if (!empty($socialYoutube)): ?>
                    <a href="<?= htmlspecialchars($socialYoutube) ?>" target="_blank" rel="noopener" aria-label="YouTube"
                        class="hover:text-white/80 inline-flex items-center justify-center w-7 h-7 rounded hover:bg-white/10 transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M23.498 6.186a3.02 3.02 0 00-2.127-2.14C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.371.5A3.02 3.02 0 00.502 6.186 31.1 31.1 0 000 12a31.1 31.1 0 00.502 5.814 3.02 3.02 0 002.127 2.14c1.866.5 9.371.5 9.371.5s7.505 0 9.371-.5a3.02 3.02 0 002.127-2.14A31.1 31.1 0 0024 12a31.1 31.1 0 00-.502-5.814zM9.75 15.5v-7l6.25 3.5-6.25 3.5z"/>
                        </svg>
                    </a>
                <?php endif; ?>
                <?php if (!empty($socialTwitter)): ?>
                    <a href="<?= htmlspecialchars($socialTwitter) ?>" target="_blank" rel="noopener" aria-label="X"
                        class="hover:text-white/80 inline-flex items-center justify-center w-7 h-7 rounded hover:bg-white/10 transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.244 2H21l-6.52 7.457L22.5 22h-6.81l-5.33-7.01L4.2 22H1.44l6.98-7.98L1.5 2h6.98l4.82 6.35L18.244 2zm-1.19 18h1.54L7.64 3.91H5.99L17.054 20z"/>
                        </svg>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Header -->
    <header x-data="{ mobileMenu: false, scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 50)"
        class="fixed w-full z-40 transition-all duration-500 top-0 pt-12"
        :class="scrolled ? 'glass-header py-5' : 'bg-transparent py-8'">
        <div class="container mx-auto px-6 flex justify-between items-center transition-all duration-300"
            :class="scrolled ? 'h-[71px]' : 'h-[95px]'">

            <a href="/"
                class="text-2xl md:text-3xl font-heading font-bold tracking-wider relative group text-brand-blue">
                TEKNO<span class="text-brand-red">RAY</span>
            </a>

            <nav class="hidden md:flex space-x-8 text-sm font-bold tracking-wide uppercase">
                <?php if ($isHomePage): ?>
                    <a href="/" class="hover:text-brand-red transition-colors" :class="scrolled ? 'text-gray-800' : 'text-white'">Ana Sayfa</a>
                    <a href="/projeler" class="hover:text-brand-red transition-colors" :class="scrolled ? 'text-gray-800' : 'text-white'">Projeler</a>
                    <a href="/hizmetler" class="hover:text-brand-red transition-colors" :class="scrolled ? 'text-gray-800' : 'text-white'">Hizmetler</a>
                    <a href="/referanslar" class="hover:text-brand-red transition-colors" :class="scrolled ? 'text-gray-800' : 'text-white'">Referanslar</a>
                    <a href="/blog" class="hover:text-brand-red transition-colors" :class="scrolled ? 'text-gray-800' : 'text-white'">Blog</a>
                <?php else: ?>
                    <a href="/" class="text-gray-800 hover:text-brand-red transition-colors">Ana Sayfa</a>
                    <a href="/projeler" class="text-gray-800 hover:text-brand-red transition-colors">Projeler</a>
                    <a href="/hizmetler" class="text-gray-800 hover:text-brand-red transition-colors">Hizmetler</a>
                    <a href="/referanslar" class="text-gray-800 hover:text-brand-red transition-colors">Referanslar</a>
                    <a href="/blog" class="text-gray-800 hover:text-brand-red transition-colors">Blog</a>
                <?php endif; ?>
            </nav>

            <div class="hidden md:flex items-center">
                <a href="/iletisim"
                    class="px-6 py-2.5 bg-brand-red text-white rounded hover:bg-red-700 transition-all font-bold text-sm">Teklif
                    Al</a>
            </div>

            <button @click="mobileMenu = !mobileMenu" class="md:hidden focus:outline-none" :class="(<?= $isHomePage ? 'true' : 'false' ?> && !scrolled) ? 'text-white' : 'text-brand-blue'">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenu" x-cloak x-transition
            class="md:hidden bg-white border-b border-gray-100 p-6 absolute w-full top-full left-0 shadow-xl">
            <a href="/"
                class="block py-3 border-b border-gray-100 text-gray-800 font-bold hover:text-brand-red">Ana
                Sayfa</a>
            <a href="/projeler"
                class="block py-3 border-b border-gray-100 text-gray-800 font-bold hover:text-brand-red">Projeler</a>
            <a href="/hizmetler"
                class="block py-3 border-b border-gray-100 text-gray-800 font-bold hover:text-brand-red">Hizmetler</a>
            <a href="/referanslar"
                class="block py-3 border-b border-gray-100 text-gray-800 font-bold hover:text-brand-red">Referanslar</a>
            <a href="/blog"
                class="block py-3 border-b border-gray-100 text-gray-800 font-bold hover:text-brand-red">Blog</a>
            <a href="/iletisim" class="block py-3 text-brand-red font-bold">İletişim</a>
        </div>
    </header>

    <!-- Content -->
    <main class="<?= $isHomePage ? '' : 'pt-36' ?>">
        <?= $content ?? '' ?>
    </main>

    <!-- Reference Logos Marquee -->
    <section class="py-12 bg-white border-t border-gray-100 overflow-hidden">
        <div class="text-center mb-8">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Güvenilir İş Ortaklarımız</span>
        </div>
        <?php
        $referenceLogos = [];
        try {
            $referenceLogos = \App\Models\ReferenceLogo::all();
        } catch (\Throwable $e) {
            $referenceLogos = [];
        }
        ?>
        <div class="relative">
            <div class="flex animate-marquee whitespace-nowrap">
                <?php if (!empty($referenceLogos)): ?>
                    <?php for ($i = 0; $i < 2; $i++): ?>
                        <div class="flex items-center space-x-16 mx-8">
                            <?php foreach ($referenceLogos as $logo): ?>
                                <img src="<?= htmlspecialchars($logo['logo_url']) ?>" alt="<?= htmlspecialchars($logo['company_name']) ?>"
                                    class="h-8 grayscale hover:grayscale-0 transition-all opacity-60 hover:opacity-100">
                            <?php endforeach; ?>
                        </div>
                    <?php endfor; ?>
                <?php else: ?>
                    <div class="flex items-center space-x-16 mx-8">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ab/Siemens-logo.svg/200px-Siemens-logo.svg.png"
                            alt="Siemens"
                            class="h-8 grayscale hover:grayscale-0 transition-all opacity-60 hover:opacity-100">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/ca/Bosch-logotype.svg/200px-Bosch-logotype.svg.png"
                            alt="Bosch" class="h-8 grayscale hover:grayscale-0 transition-all opacity-60 hover:opacity-100">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/15/Aselsan_logo.svg/200px-Aselsan_logo.svg.png"
                            alt="Aselsan"
                            class="h-8 grayscale hover:grayscale-0 transition-all opacity-60 hover:opacity-100">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3e/Koç_Holding_logo.svg/200px-Koç_Holding_logo.svg.png"
                            alt="Koç Holding"
                            class="h-8 grayscale hover:grayscale-0 transition-all opacity-60 hover:opacity-100">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/8b/Sabancı_Holding_logo.svg/200px-Sabancı_Holding_logo.svg.png"
                            alt="Sabancı"
                            class="h-8 grayscale hover:grayscale-0 transition-all opacity-60 hover:opacity-100">
                    </div>
                    <div class="flex items-center space-x-16 mx-8">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ab/Siemens-logo.svg/200px-Siemens-logo.svg.png"
                            alt="Siemens"
                            class="h-8 grayscale hover:grayscale-0 transition-all opacity-60 hover:opacity-100">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/ca/Bosch-logotype.svg/200px-Bosch-logotype.svg.png"
                            alt="Bosch" class="h-8 grayscale hover:grayscale-0 transition-all opacity-60 hover:opacity-100">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/15/Aselsan_logo.svg/200px-Aselsan_logo.svg.png"
                            alt="Aselsan"
                            class="h-8 grayscale hover:grayscale-0 transition-all opacity-60 hover:opacity-100">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3e/Koç_Holding_logo.svg/200px-Koç_Holding_logo.svg.png"
                            alt="Koç Holding"
                            class="h-8 grayscale hover:grayscale-0 transition-all opacity-60 hover:opacity-100">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/8b/Sabancı_Holding_logo.svg/200px-Sabancı_Holding_logo.svg.png"
                            alt="Sabancı"
                            class="h-8 grayscale hover:grayscale-0 transition-all opacity-60 hover:opacity-100">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Global Footer -->
    <footer class="bg-gray-50 border-t border-gray-200 pt-16 pb-8 text-sm text-gray-700">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                <!-- Brand -->
                <div>
                    <h3 class="text-2xl font-heading font-bold tracking-wider mb-6 text-brand-blue">TEKNO<span
                            class="text-brand-red">RAY</span></h3>
                    <p class="text-muted leading-relaxed mb-6">
                        <?= htmlspecialchars($footerDescription) ?>
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="font-bold text-gray-900 mb-6 uppercase tracking-widest text-xs">Kurumsal</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-muted hover:text-brand-red transition-colors">Hakkımızda</a></li>
                        <li><a href="#" class="text-muted hover:text-brand-red transition-colors">Kariyer</a></li>
                        <li><a href="#" class="text-muted hover:text-brand-red transition-colors">KVKK & Gizlilik</a>
                        </li>
                    </ul>
                </div>

                <!-- Services -->
                <div>
                    <h4 class="font-bold text-gray-900 mb-6 uppercase tracking-widest text-xs">Hizmet Alanları</h4>
                    <ul class="space-y-4">
                        <li><a href="/hizmetler" class="text-muted hover:text-brand-red transition-colors">Endüstriyel
                                Yapılar</a></li>
                        <li><a href="/hizmetler" class="text-muted hover:text-brand-red transition-colors">Yenilenebilir
                                Enerji</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="font-bold text-gray-900 mb-6 uppercase tracking-widest text-xs">İletişim</h4>
                    <p class="text-muted mb-4"><?= nl2br(htmlspecialchars($footerAddress)) ?></p>
                    <a href="mailto:<?= htmlspecialchars($footerEmail) ?>"
                        class="text-brand-blue font-bold hover:text-brand-red transition-colors block mb-2"><?= htmlspecialchars($footerEmail) ?></a>
                    <a href="tel:<?= preg_replace('/\s+/', '', $footerPhone) ?>"
                        class="text-brand-blue font-bold hover:text-brand-red transition-colors block"><?= htmlspecialchars($footerPhone) ?></a>
                </div>
            </div>

            <div
                class="border-t border-gray-200 pt-8 flex flex-col md:flex-row justify-between items-center text-xs text-muted">
                <div>&copy; <?= date('Y') ?> TeknoRay Yapı Enerji A.Ş.</div>
            </div>
        </div>
    </footer>

</body>

</html>