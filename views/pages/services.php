<section class="py-24 bg-white min-h-screen">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-6xl font-sans font-bold mb-6 uppercase tracking-widest text-brand-blue">Hizmetler</h1>
            <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto">Endüstriyel tesislerden yenilenebilir enerji altyapılarına
                kadar geniş kapsamlı mühendislik çözümleri.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($services as $service): ?>
                <div class="group bg-white rounded-xl border border-gray-200 overflow-hidden hover:border-brand-blue/30 hover:shadow-lg transition-all duration-300 flex flex-col h-full">
                    <!-- Image Section -->
                    <div class="relative aspect-[4/3] bg-gradient-to-br from-gray-50 to-gray-100 overflow-hidden flex-shrink-0">
                        <?php 
                        $imageUrl = '';
                        if (!empty($service['image_url'])) {
                            $imageUrl = trim($service['image_url']);
                        } elseif (!empty($service['image'])) {
                            $imageUrl = trim($service['image']);
                        }
                        // Ensure the image URL starts with / if it's a relative path
                        if (!empty($imageUrl) && !preg_match('/^(https?:\/\/|\/)/', $imageUrl)) {
                            $imageUrl = '/' . ltrim($imageUrl, '/');
                        }
                        ?>
                        <?php if (!empty($imageUrl)): ?>
                            <img src="<?= htmlspecialchars($imageUrl) ?>" 
                                alt="<?= htmlspecialchars($service['title']) ?>"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="absolute inset-0 bg-gradient-to-br from-brand-blue/5 to-brand-red/5 hidden items-center justify-center">
                                <div class="w-16 h-16 rounded-full bg-white/80 backdrop-blur-sm flex items-center justify-center shadow-sm">
                                    <svg class="w-8 h-8 text-brand-blue/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="absolute inset-0 bg-gradient-to-br from-brand-blue/5 to-brand-red/5"></div>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-16 h-16 rounded-full bg-white/80 backdrop-blur-sm flex items-center justify-center shadow-sm">
                                    <svg class="w-8 h-8 text-brand-blue/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Content Section -->
                    <div class="p-6 flex flex-col flex-grow">
                        <h2 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-brand-blue transition-colors min-h-[3rem]">
                            <?= htmlspecialchars($service['title']) ?>
                        </h2>
                        <p class="text-gray-600 text-sm leading-relaxed mb-5 line-clamp-3 flex-grow">
                            <?= htmlspecialchars($service['summary']) ?>
                        </p>

                        <!-- Action Button -->
                        <a href="/iletisim" 
                            class="inline-flex items-center justify-center w-full px-4 py-2.5 rounded-lg bg-brand-blue text-white text-sm font-medium hover:bg-blue-700 transition-colors flex-shrink-0">
                            Teklif Al
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>