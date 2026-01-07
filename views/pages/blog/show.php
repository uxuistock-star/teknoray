<!-- Progress Bar -->
<div x-data="{ width: '0%' }"
    x-init="window.addEventListener('scroll', () => { width = (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100 + '%' })"
    class="fixed top-0 left-0 h-1 bg-brand-red z-[60]" :style="{ width: width }"></div>

<article class="bg-primary min-h-screen">
    <!-- Article Header -->
    <header class="relative h-[60vh] flex items-end pb-20 overflow-hidden">
        <?php
        $thumb = $post['thumbnail'] ?? '';
        $thumb = is_string($thumb) ? trim($thumb) : '';
        if (!empty($thumb) && !preg_match('/^(https?:\/\/|\/)/', $thumb)) {
            $thumb = '/' . ltrim($thumb, '/');
        }
        ?>
        <img src="<?= htmlspecialchars($thumb) ?>" alt="<?= htmlspecialchars($post['title']) ?>"
            class="absolute inset-0 w-full h-full object-cover opacity-60">
        <div class="absolute inset-0 bg-gradient-to-t from-primary via-primary/50 to-transparent"></div>

        <div class="container mx-auto px-6 relative z-10">
            <a href="/blog"
                class="inline-flex items-center text-brand-blue hover:text-brand-red mb-6 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Blog'a Dön
            </a>
            <h1 class="text-4xl md:text-6xl font-heading font-bold text-white mb-4 leading-tight">
                <?= htmlspecialchars($post['title']) ?>
            </h1>
            <?php
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            ?>
            <?php if (!empty($_SESSION['admin_logged_in'])): ?>
                <div class="mb-6">
                    <a href="/yonetim/blog/duzenle/<?= (int) $post['id'] ?>" target="_blank"
                        class="inline-flex items-center px-4 py-2 bg-white/10 text-white rounded-lg font-medium hover:bg-white/20 transition-colors">
                        Yönetimde Düzenle
                    </a>
                </div>
            <?php endif; ?>
            <div class="flex flex-wrap items-center gap-6 text-sm text-muted">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2 text-brand-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <?= date('d F Y', strtotime($post['created_at'])) ?>
                </div>
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2 text-brand-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    4 Dk Okuma Süresi
                </div>
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2 text-brand-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                        </path>
                    </svg>
                    <?= $post['views'] ?> Okunma
                </div>
            </div>
        </div>
    </header>

    <!-- Article Content -->
    <div class="container mx-auto px-6 py-12 flex flex-col lg:flex-row gap-16">
        <div class="w-full lg:w-2/3">
            <div class="prose prose-invert prose-lg max-w-none hover:prose-a:text-brand-red">
                <?= $post['content'] ?>
            </div>

            <!-- Share -->
            <div class="mt-12 pt-8 border-t border-white/10">
                <h4 class="text-white font-bold mb-4">Bu yazıyı paylaş:</h4>
                <div class="flex gap-4">
                    <button
                        class="px-4 py-2 bg-[#0077b5] text-white rounded font-medium text-sm hover:opacity-90">LinkedIn</button>
                    <button
                        class="px-4 py-2 bg-[#1DA1F2] text-white rounded font-medium text-sm hover:opacity-90">Twitter</button>
                    <button
                        class="px-4 py-2 bg-[#25D366] text-white rounded font-medium text-sm hover:opacity-90">WhatsApp</button>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="w-full lg:w-1/3">
            <div class="sticky top-24 bg-secondary p-8 rounded-2xl border border-white/5">
                <h3 class="font-heading font-bold text-white mb-6 text-xl">Benzer Yazılar</h3>
                <div class="space-y-6">
                    <a href="#" class="block group">
                        <span class="text-xs text-brand-blue mb-1 block">YENİLENEBİLİR ENERJİ</span>
                        <h4 class="text-white font-bold group-hover:text-brand-red transition-colors">Rüzgar Enerjisinde
                            Verimlilik Artışı</h4>
                    </a>
                    <a href="#" class="block group">
                        <span class="text-xs text-brand-blue mb-1 block">TEKNOLOJİ</span>
                        <h4 class="text-white font-bold group-hover:text-brand-red transition-colors">IoT Tabanlı Sayaç
                            Sistemleri</h4>
                    </a>
                    <a href="#" class="block group">
                        <span class="text-xs text-brand-blue mb-1 block">HABERLER</span>
                        <h4 class="text-white font-bold group-hover:text-brand-red transition-colors">ISO 50001
                            Sertifikamızı Yeniledik</h4>
                    </a>
                </div>
            </div>
        </div>
    </div>
</article>