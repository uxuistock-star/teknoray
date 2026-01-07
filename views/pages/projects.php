<section class="py-20 bg-gradient-to-b from-gray-50 to-white min-h-screen">
    <div class="container mx-auto px-6">
        <!-- Header -->
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-6xl font-sans font-bold mb-6 uppercase tracking-widest text-gray-900">
                Projeler
            </h1>
            <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                1941'den bu yana gerçekleştirdiğimiz endüstriyel yapı ve enerji projelerimiz.
            </p>
        </div>

        <!-- Category Filter -->
        <?php $categories = \App\Models\Project::getCategories(); ?>
        <div x-data="{ activeCategory: 'Tümü' }" class="mb-16">
            <div class="flex justify-center flex-wrap gap-3 mb-12">
                <button @click="activeCategory = 'Tümü'"
                    :class="activeCategory === 'Tümü' ? 'bg-brand-red text-white shadow-lg scale-105' : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-200'"
                    class="px-6 py-3 font-semibold rounded-full text-sm uppercase tracking-wider transition-all duration-300">
                    Tümü
                </button>
                <?php foreach ($categories as $category): ?>
                    <button @click="activeCategory = '<?= htmlspecialchars($category) ?>'"
                        :class="activeCategory === '<?= htmlspecialchars($category) ?>' ? 'bg-brand-blue text-white shadow-lg scale-105' : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-200'"
                        class="px-6 py-3 font-semibold rounded-full text-sm uppercase tracking-wider transition-all duration-300">
                        <?= htmlspecialchars($category) ?>
                    </button>
                <?php endforeach; ?>
            </div>

            <!-- Projects Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($projects as $project): ?>
                    <div x-show="activeCategory === 'Tümü' || activeCategory === '<?= htmlspecialchars($project['category']) ?>'"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        class="group relative overflow-hidden rounded-2xl bg-white shadow-md hover:shadow-2xl transition-all duration-500 border border-gray-100 flex flex-col h-full">
                        
                        <!-- Image -->
                        <div class="relative aspect-[4/3] overflow-hidden bg-gray-100 flex-shrink-0">
                            <img src="<?= htmlspecialchars($project['image']) ?>"
                                alt="<?= htmlspecialchars($project['title']) ?>"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            
                            <!-- Category Badge -->
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1.5 bg-brand-red text-white text-xs font-bold uppercase tracking-wider rounded-full">
                                    <?= htmlspecialchars($project['category']) ?>
                                </span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-brand-blue transition-colors line-clamp-2 min-h-[3.5rem]">
                                <?= htmlspecialchars($project['title']) ?>
                            </h3>
                            <p class="text-gray-600 text-sm leading-relaxed mb-4 line-clamp-3 flex-grow">
                                <?= htmlspecialchars($project['description']) ?>
                            </p>
                            
                            <!-- Meta Info -->
                            <div class="flex items-center justify-between text-xs text-gray-500 mb-4 pb-4 border-b border-gray-100 flex-shrink-0">
                                <?php if (!empty($project['client'])): ?>
                                    <span class="flex items-center gap-1 truncate">
                                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        <span class="truncate"><?= htmlspecialchars($project['client']) ?></span>
                                    </span>
                                <?php endif; ?>
                                <?php if (!empty($project['year'])): ?>
                                    <span class="font-semibold flex-shrink-0"><?= htmlspecialchars($project['year']) ?></span>
                                <?php endif; ?>
                            </div>

                            <!-- CTA Button -->
                            <a href="/projeler/<?= htmlspecialchars($project['slug']) ?>"
                                class="inline-flex items-center justify-center w-full px-4 py-2.5 bg-brand-blue text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors group/btn flex-shrink-0">
                                Detayları İncele
                                <svg class="w-4 h-4 ml-2 transform group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
