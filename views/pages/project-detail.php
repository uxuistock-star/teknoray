<?php
// Ensure gallery is decoded - prepareForView already does this, but double-check
if (isset($project['gallery'])) {
    if (is_string($project['gallery'])) {
        $galleryDecoded = json_decode($project['gallery'], true);
        $project['gallery'] = is_array($galleryDecoded) ? $galleryDecoded : [];
    } elseif (!is_array($project['gallery'])) {
        $project['gallery'] = [];
    }
} else {
    $project['gallery'] = [];
}

// Separate main image and gallery images
$mainImage = !empty($project['image']) ? $project['image'] : '';
$mainImage = is_string($mainImage) ? trim($mainImage) : '';
if (!empty($mainImage) && !preg_match('/^(https?:\/\/|\/)/', $mainImage)) {
    $mainImage = '/' . ltrim($mainImage, '/');
}

$galleryImages = !empty($project['gallery']) && is_array($project['gallery']) ? array_filter($project['gallery']) : [];
$galleryImages = array_values(array_filter(array_map(function ($img) {
    if (!is_string($img)) {
        return '';
    }
    $img = trim($img);
    if ($img === '') {
        return '';
    }
    if (!preg_match('/^(https?:\/\/|\/)/', $img)) {
        $img = '/' . ltrim($img, '/');
    }
    return $img;
}, $galleryImages)));

// Combine all images for the slide (main image + gallery images)
$allImages = [];
if (!empty($mainImage)) {
    $allImages[] = $mainImage;
}
if (!empty($galleryImages)) {
    $allImages = array_merge($allImages, $galleryImages);
}
?>

<!-- Project Detail Page -->
<div class="bg-white">
    <!-- Hero Section -->
    <section class="relative h-[70vh] min-h-[500px] overflow-hidden">
        <img src="<?= htmlspecialchars($mainImage) ?>" 
            class="absolute inset-0 w-full h-full object-cover"
            alt="<?= htmlspecialchars($project['title']) ?>">
        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-black/30"></div>
        
        <div class="absolute bottom-0 left-0 right-0 p-8 md:p-16">
            <div class="container mx-auto max-w-6xl">
                <div class="mb-4">
                    <span class="inline-block px-4 py-2 bg-brand-red text-white text-sm font-bold uppercase tracking-widest rounded-full">
                        <?= htmlspecialchars($project['category'] ?? '') ?>
                    </span>
                </div>
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-heading font-bold text-white mb-4 leading-tight">
                    <?= htmlspecialchars($project['title']) ?>
                </h1>
                <?php if (!empty($project['client']) || !empty($project['year'])): ?>
                    <div class="flex flex-wrap items-center gap-6 text-white/90 text-sm md:text-base">
                        <?php if (!empty($project['client'])): ?>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <span class="font-semibold"><?= htmlspecialchars($project['client']) ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($project['year'])): ?>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="font-semibold"><?= htmlspecialchars($project['year']) ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="py-16 md:py-24 bg-gray-50">
        <div class="container mx-auto px-6 max-w-7xl">
            <div
                data-images='<?= htmlspecialchars(json_encode($allImages, JSON_UNESCAPED_SLASHES), ENT_QUOTES, "UTF-8") ?>'
                x-data="{
                    currentIndex: 0,
                    images: [],
                    init() {
                        try {
                            this.images = JSON.parse(this.$el.dataset.images || '[]');
                        } catch (e) {
                            this.images = [];
                        }
                    },
                    nextImage() {
                        if (this.images.length > 1) {
                            this.currentIndex = (this.currentIndex + 1) % this.images.length;
                        }
                    },
                    prevImage() {
                        if (this.images.length > 1) {
                            this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
                        }
                    },
                    goToImage(index) {
                        if (index >= 0 && index < this.images.length) {
                            this.currentIndex = index;
                        }
                    }
                }">
                <!-- Main Image Display -->
                <div class="relative w-full aspect-[16/9] rounded-2xl overflow-hidden bg-gray-200 shadow-2xl mb-6">
                    <template x-if="images.length > 0">
                        <div>
                            <img :src="images[currentIndex]" 
                                :alt="'Proje Görseli ' + (currentIndex + 1)"
                                class="w-full h-full object-cover transition-opacity duration-500">
                        </div>
                    </template>
                    <div x-show="images.length === 0" class="absolute inset-0 flex items-center justify-center bg-gray-100">
                        <p class="text-gray-400">Galeri görseli bulunamadı</p>
                    </div>
                    
                    <!-- Navigation Arrows -->
                    <button x-show="images.length > 1" @click="prevImage()" 
                        class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white text-gray-900 p-3 rounded-full shadow-lg transition-all z-10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <button x-show="images.length > 1" @click="nextImage()" 
                        class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white text-gray-900 p-3 rounded-full shadow-lg transition-all z-10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>

                    <!-- Image Counter -->
                    <div x-show="images.length > 1" class="absolute bottom-4 right-4 bg-black/70 text-white px-4 py-2 rounded-full text-sm font-medium">
                        <span x-text="currentIndex + 1"></span> / <span x-text="images.length"></span>
                    </div>
                </div>

                <!-- Thumbnail Navigation (if more than 1 image) -->
                <div x-show="images.length > 1" class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide">
                    <template x-for="(image, index) in images" :key="index">
                        <button @click="goToImage(index)"
                            :class="currentIndex === index ? 'ring-4 ring-brand-blue' : 'opacity-60 hover:opacity-100'"
                            class="flex-shrink-0 w-24 h-24 rounded-lg overflow-hidden bg-gray-200 transition-all">
                            <img :src="image" 
                                :alt="'Thumbnail ' + (index + 1)"
                                class="w-full h-full object-cover">
                        </button>
                    </template>
                </div>
            </div>
        </div>
    </section>

    <!-- Project Information -->
    <section class="py-16 md:py-24">
        <div class="container mx-auto px-6 max-w-4xl">
            <!-- Project Description -->
            <div class="mb-12">
                <h2 class="text-3xl md:text-4xl font-heading font-bold text-brand-blue mb-6">Proje Hakkında</h2>
                <div class="prose prose-lg max-w-none">
                    <p class="text-gray-700 leading-relaxed text-lg">
                        <?= nl2br(htmlspecialchars($project['description'] ?? '')) ?>
                    </p>
                </div>
            </div>

            <!-- Project Details -->
            <div class="bg-gradient-to-br from-gray-50 to-white rounded-2xl p-8 border border-gray-200">
                <h3 class="text-xl font-bold text-gray-900 mb-6 pb-4 border-b border-gray-200">
                    Proje Detayları
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <?php if (!empty($project['client'])): ?>
                        <div>
                            <span class="text-xs text-gray-500 font-semibold uppercase tracking-wider block mb-2">Müşteri</span>
                            <span class="text-lg text-gray-900 font-bold">
                                <?= htmlspecialchars($project['client']) ?>
                            </span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($project['year'])): ?>
                        <div>
                            <span class="text-xs text-gray-500 font-semibold uppercase tracking-wider block mb-2">Yıl</span>
                            <span class="text-lg text-gray-900 font-bold">
                                <?= htmlspecialchars($project['year']) ?>
                            </span>
                        </div>
                    <?php endif; ?>
                    
                    <div>
                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wider block mb-2">Kategori</span>
                        <span class="text-lg text-brand-blue font-bold">
                            <?= htmlspecialchars($project['category'] ?? '-') ?>
                        </span>
                    </div>
                </div>
                
                <a href="/iletisim"
                    class="block mt-8 w-full text-center bg-brand-red text-white font-bold py-4 rounded-xl hover:bg-red-700 transition-colors shadow-lg hover:shadow-xl">
                    Teklif Al
                </a>
            </div>
        </div>
    </section>

    <!-- Back Link -->
    <section class="pb-16 bg-gray-50">
        <div class="container mx-auto px-6 max-w-7xl">
            <a href="/projeler"
                class="inline-flex items-center text-brand-blue font-semibold hover:text-brand-red transition-colors group">
                <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Tüm Projelere Dön
            </a>
        </div>
    </section>
</div>

<style>
.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}
</style>
