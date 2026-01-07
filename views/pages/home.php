<!-- 1. Hero Slider Section -->
<?php
$slidesForJs = [];
foreach (($slides ?? []) as $s) {
    $slidesForJs[] = [
        'type' => ($s['media_type'] ?? 'image') === 'video' ? 'video' : 'image',
        'src' => $s['media_url'] ?? '',
        'title' => $s['title'] ?? '',
        'description' => $s['description'] ?? '',
        'button1_text' => $s['button1_text'] ?? '',
        'button1_link' => $s['button1_link'] ?? '',
        'button2_text' => $s['button2_text'] ?? '',
        'button2_link' => $s['button2_link'] ?? '',
    ];
}
if (empty($slidesForJs)) {
    $slidesForJs = [
        [
            'type' => 'video',
            'src' => 'https://assets.mixkit.co/videos/preview/mixkit-factory-conveyor-belt-industry-1563-large.mp4',
            'title' => 'GELECEĞİ İNŞA ET',
            'description' => 'Sürdürülebilir endüstriyel çözümler ve ileri teknoloji enerji sistemleri.',
            'button1_text' => 'Projelerimiz',
            'button1_link' => '/projeler',
            'button2_text' => 'İletişim',
            'button2_link' => '/iletisim',
        ],
    ];
}
?>

<section class="relative bg-gray-900 overflow-hidden h-screen" x-data="{
        currentSlide: 0,
        slides: <?= htmlspecialchars(json_encode($slidesForJs, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), ENT_QUOTES, 'UTF-8') ?>,
        next() { this.currentSlide = (this.currentSlide + 1) % this.slides.length },
        prev() { this.currentSlide = (this.currentSlide === 0) ? this.slides.length - 1 : this.currentSlide - 1 },
        init() { setInterval(() => this.next(), 8000) }
    }">

    <!-- Slides -->
    <template x-for="(slide, index) in slides" :key="index">
        <div x-show="currentSlide === index" x-transition:enter="transition ease-out duration-1000"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-1000" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="absolute inset-0 w-full h-full">

            <template x-if="slide.type === 'video'">
                <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover">
                    <source :src="slide.src" type="video/mp4">
                </video>
            </template>
            <template x-if="slide.type === 'image'">
                <img :src="slide.src" class="absolute inset-0 w-full h-full object-cover">
            </template>

            <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-transparent"></div>
        </div>
    </template>

    <!-- Content -->
    <div class="absolute inset-0 z-20 flex items-center">
        <div class="container mx-auto px-6">
            <template x-for="(slide, index) in slides" :key="index">
                <div x-show="currentSlide === index" x-transition:enter="transition ease-out duration-700 delay-300"
                    x-transition:enter-start="opacity-0 translate-y-6" x-transition:enter-end="opacity-100 translate-y-0"
                    class="max-w-3xl">
                    <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-heading font-bold mb-6 tracking-tight text-white leading-tight"
                        x-text="slide.title"></h1>
                    <p class="text-lg md:text-xl font-light text-gray-200 mb-8 max-w-xl leading-relaxed"
                        x-text="slide.description"></p>

                    <div class="flex flex-col sm:flex-row gap-4" x-show="slide.button1_text || slide.button2_text">
                        <a x-show="slide.button1_text" :href="slide.button1_link || '#'"
                            class="px-8 py-3 bg-brand-red text-white font-bold uppercase tracking-widest text-sm hover:bg-red-700 transition-colors rounded shadow-lg"
                            x-text="slide.button1_text"></a>
                        <a x-show="slide.button2_text" :href="slide.button2_link || '#'"
                            class="px-8 py-3 border border-white text-white font-bold uppercase tracking-widest text-sm hover:bg-white hover:text-brand-blue transition-colors rounded"
                            x-text="slide.button2_text"></a>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Slider Controls -->
    <button @click="prev()"
        class="absolute left-4 top-1/2 transform -translate-y-1/2 z-30 p-3 rounded-full border border-white/30 text-white hover:bg-white hover:text-brand-blue transition-all">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
    </button>
    <button @click="next()"
        class="absolute right-4 top-1/2 transform -translate-y-1/2 z-30 p-3 rounded-full border border-white/30 text-white hover:bg-white hover:text-brand-blue transition-all">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
    </button>

    <!-- Dots -->
    <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 z-30 flex space-x-3">
        <template x-for="(slide, index) in slides" :key="index">
            <button @click="currentSlide = index" class="w-3 h-3 rounded-full transition-all duration-300"
                :class="currentSlide === index ? 'bg-brand-red w-8' : 'bg-white/50 hover:bg-white'">
            </button>
        </template>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 right-8 z-30 animate-bounce text-white/40 hidden md:block">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
        </svg>
    </div>
</section>

<!-- 2. Services Section -->
<section id="services" class="py-24 bg-white relative">
    <div class="absolute top-0 right-0 w-1/3 h-full bg-brand-blue/5 skew-x-12 transform origin-top-right"></div>

    <div class="container mx-auto px-6 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
            <div class="hidden md:block">
                <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&q=80"
                    class="w-full h-[500px] object-cover rounded-2xl shadow-2xl" alt="Hizmetler">
            </div>
            <div>
                <h2 class="text-4xl md:text-5xl font-heading font-bold mb-10 text-brand-blue">HİZMETLER</h2>
                <div class="space-y-8">
                    <?php foreach ($services as $service): ?>
                        <div class="group cursor-pointer">
                            <h3
                                class="text-xl font-bold flex items-center text-gray-800 group-hover:text-brand-red transition-colors">
                                <span
                                    class="w-2 h-2 bg-brand-red rounded-full mr-4 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                                <?= htmlspecialchars($service['title']) ?>
                            </h3>
                            <p
                                class="text-gray-600 mt-2 pl-6 border-l border-gray-200 group-hover:border-brand-red transition-colors">
                                <?= htmlspecialchars($service['summary']) ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="mt-10">
                    <a href="/hizmetler"
                        class="inline-flex items-center text-brand-red font-bold uppercase tracking-widest text-sm hover:text-brand-blue transition-colors">
                        TÜM HİZMETLERİ GÖR
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 3. Projects Section -->
<section id="projects" class="py-24 bg-white">
    <div class="container mx-auto px-6 mb-10 flex justify-between items-end">
        <h2 class="text-4xl md:text-5xl font-heading font-bold text-gray-900"><span class="text-brand-blue">SON</span>
            PROJELER</h2>
        <div class="flex gap-2">
            <button
                class="p-2 border border-gray-300 rounded-full hover:bg-brand-blue hover:text-white hover:border-brand-blue transition-colors text-gray-600">&lt;</button>
            <button
                class="p-2 border border-gray-300 rounded-full hover:bg-brand-blue hover:text-white hover:border-brand-blue transition-colors text-gray-600">&gt;</button>
        </div>
    </div>

    <!-- Horizontal Scroll -->
    <div class="flex overflow-x-auto space-x-6 px-6 pb-8 scrollbar-hide">
        <?php foreach ($projects as $project): ?>
            <div
                class="flex-shrink-0 w-[85vw] md:w-[45vw] lg:w-[30vw] relative group rounded-xl overflow-hidden aspect-[4/5] shadow-xl hover:shadow-2xl transition-shadow">
                <img src="<?= $project['image'] ?>"
                    class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 grayscale group-hover:grayscale-0">
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-transparent to-transparent"></div>

                <div class="absolute bottom-0 left-0 p-8">
                    <span
                        class="text-brand-red text-xs font-bold uppercase tracking-widest mb-2 block"><?= $project['category'] ?></span>
                    <h3 class="text-2xl font-bold mb-2 text-white"><?= $project['title'] ?></h3>
                    <a href="/projeler"
                        class="inline-block mt-4 text-sm font-semibold border-b border-white pb-0.5 hover:text-brand-red hover:border-brand-red transition-colors text-white">İncele</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- 4. Stats Section -->
<section class="py-24 bg-brand-blue/5">
    <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
        <div
            class="p-10 bg-white rounded-2xl shadow-lg border border-gray-100 hover:-translate-y-2 transition-transform duration-300">
            <div class="text-5xl font-bold text-brand-red mb-4">1941</div>
            <div class="text-gray-500 text-sm tracking-widest uppercase font-bold">Köklü Geçmiş</div>
        </div>
        <div
            class="p-10 bg-white rounded-2xl shadow-lg border border-gray-100 hover:-translate-y-2 transition-transform duration-300">
            <div class="text-5xl font-bold text-brand-blue mb-4">85+</div>
            <div class="text-gray-500 text-sm tracking-widest uppercase font-bold">Global Proje</div>
        </div>
        <div
            class="p-10 bg-white rounded-2xl shadow-lg border border-gray-100 hover:-translate-y-2 transition-transform duration-300">
            <div class="text-5xl font-bold text-gray-800 mb-4">4K+</div>
            <div class="text-gray-500 text-sm tracking-widest uppercase font-bold">Çalışan</div>
        </div>
    </div>
</section>