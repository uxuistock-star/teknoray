<!-- SEO Settings - Blue/Red Theme -->
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Flash Messages -->
    <?php if ($success = \App\Core\Session::getFlash('success')): ?>
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-lg">
            <p><?= htmlspecialchars($success) ?></p>
        </div>
    <?php endif; ?>

    <?php if ($error = \App\Core\Session::getFlash('error')): ?>
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-lg">
            <p><?= htmlspecialchars($error) ?></p>
        </div>
    <?php endif; ?>

    <?php $seo = $settings['seo'] ?? []; ?>

    <div>
        <h2 class="text-2xl font-bold text-gray-900">SEO Ayarları</h2>
        <p class="text-gray-500 text-sm">Site geneli SEO ve meta etiketlerini yönetin</p>
    </div>

    <form action="/yonetim/seo/kaydet" method="POST" class="space-y-6">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars((string) ($csrf_token ?? '')) ?>">
        <!-- Global SEO -->
        <div class="bg-white rounded-xl border border-gray-100 p-6 space-y-6">
            <h3 class="font-bold text-gray-900 text-lg">Genel SEO</h3>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Site Başlığı (Title)</label>
                <input type="text" name="seo_title" value="<?= htmlspecialchars($seo['seo_title'] ?? 'TeknoRay Yapı Enerji | Geleceği İnşa Eden Güç') ?>"
                    class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue outline-none">
                <p class="text-xs text-gray-400 mt-1">Tarayıcı sekmesinde görün en başlık (50-60 karakter önerilir)</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Meta Açıklama (Description)</label>
                <textarea rows="3" name="seo_description"
                    class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue outline-none resize-none"><?= htmlspecialchars($seo['seo_description'] ?? "1941'den beri endüstriyel yapı ve enerji sektöründe güven, inovasyon ve sürdürülebilirlik odaklı çözümler üretiyoruz.") ?></textarea>
                <p class="text-xs text-gray-400 mt-1">Arama sonuçlarında görünen açıklama (150-160 karakter önerilir)
                </p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Anahtar Kelimeler (Keywords)</label>
                <input type="text" name="seo_keywords" value="<?= htmlspecialchars($seo['seo_keywords'] ?? 'endüstriyel yapı, yenilenebilir enerji, teknoray, inşaat, sürdürülebilirlik') ?>"
                    class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue outline-none">
                <p class="text-xs text-gray-400 mt-1">Virgülle ayırarak yazın</p>
            </div>
        </div>

        <!-- Open Graph (Social Media) -->
        <div class="bg-white rounded-xl border border-gray-100 p-6 space-y-6">
            <h3 class="font-bold text-gray-900 text-lg">Sosyal Medya (Open Graph)</h3>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">OG Başlık</label>
                <input type="text" name="og_title" value="<?= htmlspecialchars($seo['og_title'] ?? 'TeknoRay Yapı Enerji') ?>"
                    class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">OG Açıklama</label>
                <textarea rows="2" name="og_description"
                    class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue outline-none resize-none"><?= htmlspecialchars($seo['og_description'] ?? 'Endüstriyel yapı ve yenilenebilir enerji alanında 80+ yıllık deneyim.') ?></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">OG Görsel URL</label>
                <input type="url" name="og_image" value="<?= htmlspecialchars($seo['og_image'] ?? '') ?>" placeholder="https://example.com/og-image.jpg"
                    class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue outline-none">
                <p class="text-xs text-gray-400 mt-1">Sosyal medyada paylaşılınca görünecek görsel (1200x630px önerilir)
                </p>
            </div>
        </div>

        <!-- Technical SEO -->
        <div class="bg-white rounded-xl border border-gray-100 p-6 space-y-6">
            <h3 class="font-bold text-gray-900 text-lg">Teknik SEO</h3>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Google Analytics ID</label>
                <input type="text" name="google_analytics" value="<?= htmlspecialchars($seo['google_analytics'] ?? '') ?>" placeholder="G-XXXXXXXXXX"
                    class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Google Search Console Doğrulama Kodu</label>
                <input type="text" name="google_site_verification" value="<?= htmlspecialchars($seo['google_site_verification'] ?? '') ?>" placeholder="google-site-verification..."
                    class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Robots.txt İçeriği</label>
                <textarea rows="4" name="robots_txt"
                    class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue outline-none resize-none font-mono text-sm"><?= htmlspecialchars($seo['robots_txt'] ?? "User-agent: *\nAllow: /\nSitemap: https://teknoray.com.tr/sitemap.xml") ?></textarea>
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" checked class="rounded border-gray-300">
                <label class="text-sm text-gray-700">Arama motorlarına site haritası (sitemap.xml) gönder</label>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-4">
            <button type="button"
                class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition-colors">İptal</button>
            <button type="submit"
                class="px-6 py-3 bg-brand-blue text-white rounded-lg font-medium hover:bg-blue-700 transition-colors">SEO
                Ayarlarını Kaydet</button>
        </div>
    </form>
</div>