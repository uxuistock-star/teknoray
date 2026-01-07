<!-- Admin Dashboard - Blue/Red Theme Only -->
<div class="space-y-8">

    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-brand-blue to-blue-700 rounded-2xl p-8 text-white relative overflow-hidden">
        <div class="absolute right-0 top-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="relative z-10">
            <h2 class="text-2xl font-bold mb-2">Hoş Geldiniz, Admin! 👋</h2>
            <p class="text-blue-100">TeknoRay Yönetim Paneli - Tüm içerikleri buradan yönetebilirsiniz.</p>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-brand-blue/10 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-brand-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                </div>
                <span class="text-xs font-bold text-brand-blue bg-blue-50 px-2 py-1 rounded">+2 Bu Ay</span>
            </div>
            <div class="text-3xl font-bold text-gray-900 mb-1"><?= $stats['projects'] ?? 0 ?></div>
            <div class="text-sm text-gray-500">Toplam Proje</div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-brand-blue/10 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-brand-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                        </path>
                    </svg>
                </div>
                <span class="text-xs font-bold text-brand-blue bg-blue-50 px-2 py-1 rounded">+5 Bu Ay</span>
            </div>
            <div class="text-3xl font-bold text-gray-900 mb-1"><?= $stats['blogs'] ?? 0 ?></div>
            <div class="text-sm text-gray-500">Blog Yazısı</div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-brand-blue/10 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-brand-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900 mb-1"><?= $stats['services'] ?? 0 ?></div>
            <div class="text-sm text-gray-500">Hizmet Alanı</div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-brand-blue/10 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-brand-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                        </path>
                    </svg>
                </div>
                <span class="text-xs font-bold text-brand-blue bg-blue-50 px-2 py-1 rounded">Bu Hafta</span>
            </div>
            <div class="text-3xl font-bold text-gray-900 mb-1">2,458</div>
            <div class="text-sm text-gray-500">Sayfa Görüntüleme</div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Content Management -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden lg:col-span-2">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h3 class="font-bold text-gray-800">Hızlı İşlemler</h3>
            </div>
            <div class="p-6 grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="/yonetim/projeler/ekle"
                    class="flex flex-col items-center p-4 rounded-xl bg-brand-blue/5 hover:bg-brand-blue/10 transition-colors text-center group">
                    <div
                        class="w-12 h-12 bg-brand-blue rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Yeni Proje</span>
                </a>
                <a href="/yonetim/blog/ekle"
                    class="flex flex-col items-center p-4 rounded-xl bg-brand-blue/5 hover:bg-brand-blue/10 transition-colors text-center group">
                    <div
                        class="w-12 h-12 bg-brand-blue rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Yeni Yazı</span>
                </a>
                <a href="/yonetim/slider"
                    class="flex flex-col items-center p-4 rounded-xl bg-brand-blue/5 hover:bg-brand-blue/10 transition-colors text-center group">
                    <div
                        class="w-12 h-12 bg-brand-blue rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Slider</span>
                </a>
                <a href="/yonetim/seo"
                    class="flex flex-col items-center p-4 rounded-xl bg-brand-blue/5 hover:bg-brand-blue/10 transition-colors text-center group">
                    <div
                        class="w-12 h-12 bg-brand-blue rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-700">SEO</span>
                </a>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h3 class="font-bold text-gray-800">Son Aktiviteler</h3>
            </div>
            <div class="divide-y divide-gray-100 max-h-64 overflow-y-auto">
                <div class="px-6 py-4 flex items-center gap-3">
                    <div class="w-2 h-2 bg-brand-blue rounded-full"></div>
                    <div class="flex-1">
                        <div class="text-sm font-medium text-gray-900">Admin giriş yaptı</div>
                        <div class="text-xs text-gray-500"><?= date('d.m.Y H:i') ?></div>
                    </div>
                </div>
                <div class="px-6 py-4 flex items-center gap-3">
                    <div class="w-2 h-2 bg-brand-blue rounded-full"></div>
                    <div class="flex-1">
                        <div class="text-sm font-medium text-gray-900">Yeni proje eklendi</div>
                        <div class="text-xs text-gray-500">Bugün, 14:30</div>
                    </div>
                </div>
                <div class="px-6 py-4 flex items-center gap-3">
                    <div class="w-2 h-2 bg-brand-blue rounded-full"></div>
                    <div class="flex-1">
                        <div class="text-sm font-medium text-gray-900">Blog yazısı güncellendi</div>
                        <div class="text-xs text-gray-500">Dün, 16:45</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Overview -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Projects -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-gray-800">Son Projeler</h3>
                <a href="/yonetim/projeler" class="text-sm text-brand-blue hover:underline">Tümü →</a>
            </div>
            <div class="divide-y divide-gray-100">
                <?php $recentProjects = array_slice(\App\Models\Project::all(), 0, 4); ?>
                <?php foreach ($recentProjects as $project): ?>
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <div class="flex items-center space-x-4">
                            <img src="<?= $project['image'] ?>" class="w-12 h-12 rounded-lg object-cover" alt="">
                            <div>
                                <div class="font-medium text-gray-900"><?= $project['title'] ?></div>
                                <div class="text-xs text-gray-500"><?= $project['category'] ?></div>
                            </div>
                        </div>
                        <a href="/yonetim/projeler/duzenle/<?= $project['id'] ?>" class="text-gray-400 hover:text-brand-blue">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Recent Blog Posts -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-gray-800">Son Blog Yazıları</h3>
                <a href="/yonetim/blog" class="text-sm text-brand-blue hover:underline">Tümü →</a>
            </div>
            <div class="divide-y divide-gray-100">
                <?php $recentPosts = array_slice(\App\Models\BlogPost::all(), 0, 4); ?>
                <?php foreach ($recentPosts as $post): ?>
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <div class="flex items-center space-x-4">
                            <img src="<?= $post['thumbnail'] ?>" class="w-12 h-12 rounded-lg object-cover" alt="">
                            <div>
                                <div class="font-medium text-gray-900 line-clamp-1"><?= $post['title'] ?></div>
                                <div class="text-xs text-gray-500"><?= date('d M Y', strtotime($post['created_at'])) ?> •
                                    <?= number_format($post['views']) ?> görüntülenme</div>
                            </div>
                        </div>
                        <a href="/yonetim/blog/duzenle/<?= $post['id'] ?>" class="text-gray-400 hover:text-brand-blue">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>