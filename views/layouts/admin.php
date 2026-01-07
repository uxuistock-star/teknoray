<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $title ?? 'Admin' ?> | TeknoRay
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: { blue: '#1C5B8B', red: '#EC1B13' }
                    },
                    fontFamily: { sans: ['Poppins', 'sans-serif'], heading: ['Audiowide', 'sans-serif'] }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Audiowide&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans antialiased">

    <div class="flex h-screen" x-data="{ sidebarOpen: true, activeMenu: '<?= $activeMenu ?? 'dashboard' ?>' }">

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'w-64' : 'w-20'"
            class="bg-white border-r border-gray-200 flex flex-col transition-all duration-300 hidden md:flex">
            <div class="p-6 border-b border-gray-100 flex items-center"
                :class="sidebarOpen ? 'justify-between' : 'justify-center'">
                <a href="/yonetim" class="font-heading font-bold tracking-wider text-brand-blue"
                    :class="sidebarOpen ? 'text-xl' : 'text-sm'">
                    <span x-show="sidebarOpen">TEKNO<span class="text-brand-red">RAY</span></span>
                    <span x-show="!sidebarOpen" class="text-brand-red">TR</span>
                </a>

                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-400 hover:text-brand-blue"
                    x-show="sidebarOpen">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                    </svg>
                </button>
            </div>

            <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                <a href="/yonetim" class="flex items-center px-4 py-3 rounded-lg font-medium transition-colors"
                    :class="activeMenu === 'dashboard' ? 'bg-brand-blue text-white' : 'text-gray-600 hover:bg-gray-50'">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>
                    </svg>
                    <span class="ml-3" x-show="sidebarOpen">Yönetim Paneli</span>
                </a>
                <a href="/yonetim/projeler" class="flex items-center px-4 py-3 rounded-lg font-medium transition-colors"
                    :class="activeMenu === 'projects' ? 'bg-brand-blue text-white' : 'text-gray-600 hover:bg-gray-50'">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                    <span class="ml-3" x-show="sidebarOpen">Projeler</span>
                </a>
                <a href="/yonetim/blog" class="flex items-center px-4 py-3 rounded-lg font-medium transition-colors"
                    :class="activeMenu === 'blog' ? 'bg-brand-blue text-white' : 'text-gray-600 hover:bg-gray-50'">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                        </path>
                    </svg>
                    <span class="ml-3" x-show="sidebarOpen">Blog Yazıları</span>
                </a>
                <a href="/yonetim/hizmetler" class="flex items-center px-4 py-3 rounded-lg font-medium transition-colors"
                    :class="activeMenu === 'services' ? 'bg-brand-blue text-white' : 'text-gray-600 hover:bg-gray-50'">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span class="ml-3" x-show="sidebarOpen">Hizmetler</span>
                </a>

                <div class="border-t border-gray-100 my-2" x-show="sidebarOpen"></div>

                <a href="/yonetim/slider" class="flex items-center px-4 py-3 rounded-lg font-medium transition-colors"
                    :class="activeMenu === 'slider' ? 'bg-brand-blue text-white' : 'text-gray-600 hover:bg-gray-50'">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span class="ml-3" x-show="sidebarOpen">Slider</span>
                </a>
                <a href="/yonetim/logolar" class="flex items-center px-4 py-3 rounded-lg font-medium transition-colors"
                    :class="activeMenu === 'logos' ? 'bg-brand-blue text-white' : 'text-gray-600 hover:bg-gray-50'">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                    <span class="ml-3" x-show="sidebarOpen">Logolar</span>
                </a>
                <a href="/yonetim/seo" class="flex items-center px-4 py-3 rounded-lg font-medium transition-colors"
                    :class="activeMenu === 'seo' ? 'bg-brand-blue text-white' : 'text-gray-600 hover:bg-gray-50'">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span class="ml-3" x-show="sidebarOpen">SEO Ayarları</span>
                </a>

                <div class="border-t border-gray-100 my-2" x-show="sidebarOpen"></div>

                <a href="/yonetim/ayarlar" class="flex items-center px-4 py-3 rounded-lg font-medium transition-colors"
                    :class="activeMenu === 'settings' ? 'bg-brand-blue text-white' : 'text-gray-600 hover:bg-gray-50'">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="ml-3" x-show="sidebarOpen">Ayarlar</span>
                </a>
            </nav>

            <div class="p-4 border-t border-gray-100">
                <a href="/yonetim/cikis"
                    class="flex items-center px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg font-medium transition-colors">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                    <span class="ml-3" x-show="sidebarOpen">Çıkış Yap</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <h1 class="text-xl font-bold text-gray-800">
                        <?= $pageTitle ?? 'Yönetim Paneli' ?>
                    </h1>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="/" target="_blank"
                        class="text-sm text-gray-500 hover:text-brand-blue flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                        Siteyi Görüntüle
                    </a>
                    <div
                        class="w-10 h-10 bg-brand-blue rounded-full flex items-center justify-center text-white font-bold">
                        A</div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="flex-1 overflow-y-auto p-6">
                <?= $content ?? '' ?>
            </div>
        </main>
    </div>

</body>

</html>