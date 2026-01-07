<!-- Blog Hero -->
<section class="relative py-16 md:py-20 bg-white border-b border-gray-100">
    <div class="container mx-auto px-6">
        <div class="flex flex-col items-center text-center">
            <div class="text-xs font-semibold uppercase tracking-widest text-gray-500 mb-3">
                Anasayfa / Blog
            </div>
            <h1 class="text-4xl md:text-6xl font-sans font-bold mb-4 text-gray-900 uppercase tracking-widest">Blog & <span
                    class="text-brand-red">Haberler</span></h1>
            <p class="text-gray-600 max-w-2xl mx-auto text-base md:text-lg leading-relaxed">
                Sektörel gelişmeler, teknoloji trendleri ve TeknoRay'den son haberler.
            </p>
        </div>
    </div>
</section>

<!-- Content -->
<section class="py-16 md:py-20 bg-white">
    <div class="container mx-auto px-6 flex flex-col lg:flex-row gap-12">

        <!-- Main Area -->
        <div class="w-full lg:w-3/4">
            <!-- Featured Post -->
            <?php if (!empty($posts)):
                $featured = $posts[0]; ?>
                <article class="mb-12 rounded-2xl overflow-hidden border border-gray-100 bg-white shadow-sm hover:shadow-lg transition-all group">
                    <a href="/blog/<?= $featured['slug'] ?>" class="block relative h-80 overflow-hidden">
                        <img src="<?= $featured['thumbnail'] ?>" alt="<?= htmlspecialchars($featured['title']) ?>"
                            class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 p-8">
                            <span
                                class="bg-brand-red text-white text-xs font-bold uppercase tracking-widest px-3 py-1 rounded mb-4 inline-block">Öne
                                Çıkan</span>
                            <h2 class="text-2xl md:text-3xl font-bold text-white mb-2">
                                <?= htmlspecialchars($featured['title']) ?></h2>
                            <p class="text-gray-200 text-sm"><?= date('d M Y', strtotime($featured['created_at'])) ?></p>
                        </div>
                    </a>
                </article>
            <?php endif; ?>

            <!-- Post Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <?php foreach (array_slice($posts, 1) as $post): ?>
                    <article
                        class="bg-white rounded-2xl overflow-hidden group hover:shadow-lg transition-all border border-gray-100">
                        <a href="/blog/<?= $post['slug'] ?>" class="block relative h-48 overflow-hidden">
                            <img src="<?= $post['thumbnail'] ?>" alt="<?= htmlspecialchars($post['title']) ?>"
                                class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-110">
                        </a>
                        <div class="p-6">
                            <div
                                class="flex items-center text-xs text-brand-blue mb-3 font-semibold uppercase tracking-wider">
                                <span><?= date('d M Y', strtotime($post['created_at'])) ?></span>
                                <span class="mx-2">•</span>
                                <span><?= $post['views'] ?> Görüntülenme</span>
                            </div>
                            <h2 class="text-lg font-bold mb-3 text-gray-900 group-hover:text-brand-red transition-colors">
                                <a href="/blog/<?= $post['slug'] ?>"><?= htmlspecialchars($post['title']) ?></a>
                            </h2>
                            <p class="text-gray-500 text-sm mb-4 line-clamp-2"><?= htmlspecialchars($post['summary']) ?></p>
                            <a href="/blog/<?= $post['slug'] ?>"
                                class="inline-flex items-center text-brand-red font-semibold text-sm hover:underline">
                                Devamını Oku
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                    </path>
                                </svg>
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <div class="mt-12 flex justify-center space-x-2">
                <a href="#" class="px-4 py-2 bg-brand-blue text-white rounded font-bold">1</a>
                <a href="#" class="px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 font-bold">2</a>
                <span class="px-4 py-2 text-gray-400">...</span>
                <a href="#" class="px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 font-bold">Sonraki</a>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="w-full lg:w-1/4 space-y-8">
            <!-- Search -->
            <div class="bg-gray-50 p-6 rounded-xl border border-gray-100">
                <h3 class="font-bold text-gray-900 mb-4 text-lg">Ara</h3>
                <form onsubmit="return false;" class="relative">
                    <input type="text" placeholder="Kelime ara..."
                        class="w-full bg-white border border-gray-200 rounded-lg py-3 px-4 text-gray-900 focus:outline-none focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20">
                    <button class="absolute right-3 top-3 text-gray-400 hover:text-brand-blue">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Categories -->
            <div class="bg-gray-50 p-6 rounded-xl border border-gray-100">
                <h3 class="font-bold text-gray-900 mb-4 text-lg">Kategoriler</h3>
                <ul class="space-y-3">
                    <?php foreach ($categories as $cat): ?>
                        <li>
                            <a href="#"
                                class="flex justify-between items-center text-gray-600 hover:text-brand-red transition-colors group">
                                <span><?= htmlspecialchars($cat['name']) ?></span>
                                <span
                                    class="bg-gray-200 px-2 py-0.5 rounded text-xs text-gray-500 group-hover:bg-brand-red group-hover:text-white transition-colors">12</span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Newsletter -->
            <div class="bg-gradient-to-br from-brand-blue to-blue-800 p-6 rounded-xl text-center">
                <h3 class="font-bold text-white mb-2">Bültene Abone Ol</h3>
                <p class="text-xs text-blue-200 mb-4">Sektörel gelişmelerden haberdar olun.</p>
                <input type="email" placeholder="E-posta adresiniz"
                    class="w-full bg-white/10 border border-white/20 rounded py-2 px-3 text-white placeholder-blue-200 text-sm mb-3 focus:outline-none focus:bg-white/20">
                <button
                    class="w-full bg-white text-brand-blue font-bold py-2 rounded text-sm hover:bg-gray-100 transition-colors">Kayıt
                    Ol</button>
            </div>
        </div>
    </div>
</section>