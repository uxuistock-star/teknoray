<section class="py-24 bg-primary min-h-screen">
    <div class="container mx-auto px-6">
        <h1 class="text-4xl md:text-6xl font-sans font-bold mb-20 text-center uppercase tracking-widest">Referanslar</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8 mb-24">
            <?php if (!empty($logos ?? [])): ?>
                <?php foreach (($logos ?? []) as $logo): ?>
                    <div class="bg-secondary/90 rounded-2xl p-8 border border-white/10 hover:border-brand-blue/60 hover:bg-secondary transition-all duration-300 group shadow-sm">
                        <div class="aspect-[3/2] flex items-center justify-center bg-white/5 rounded-xl border border-white/10 overflow-hidden">
                            <img src="<?= htmlspecialchars($logo['logo_url']) ?>" alt="<?= htmlspecialchars($logo['company_name']) ?>"
                                class="max-h-14 w-auto object-contain grayscale group-hover:grayscale-0 transition-all duration-300">
                        </div>
                        <div class="mt-5 text-center">
                            <div class="text-sm font-bold uppercase tracking-wider text-white/80 group-hover:text-white transition-colors">
                                <?= htmlspecialchars($logo['company_name']) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-full text-center text-white/70">
                    Henüz referans logosu eklenmedi.
                </div>
            <?php endif; ?>
        </div>

        <!-- Testimonials -->
        <h2 class="text-3xl font-sans font-bold mb-12 text-center uppercase tracking-widest">Müşteri Yorumları</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            <div class="bg-secondary p-8 rounded-2xl border border-white/5 relative">
                <div class="text-brand-red text-6xl absolute top-4 left-6 opacity-20">"</div>
                <p class="text-lg text-gray-300 italic mb-6 relative z-10">TeknoRay ile çalışmak fabrikamızın enerji
                    verimliliğini %40 artırdı. Profesyonel ve vizyoner bir ekip.</p>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gray-600 rounded-full mr-4"></div>
                    <div>
                        <div class="font-bold text-white">Ahmet Yılmaz</div>
                        <div class="text-xs text-muted">CEO, Yılmaz Endüstri A.Ş.</div>
                    </div>
                </div>
            </div>
            <div class="bg-secondary p-8 rounded-2xl border border-white/5 relative">
                <div class="text-brand-red text-6xl absolute top-4 left-6 opacity-20">"</div>
                <p class="text-lg text-gray-300 italic mb-6 relative z-10">Zamanında teslimat ve sıfır hata prensibi ile
                    çalışmaları etkileyici.</p>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gray-600 rounded-full mr-4"></div>
                    <div>
                        <div class="font-bold text-white">Mehmet Demir</div>
                        <div class="text-xs text-muted">Operasyon Müdürü, Global Lojistik</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>