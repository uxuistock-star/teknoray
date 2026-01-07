<!-- Site Settings -->
<?php
$general = $settings['general'] ?? [];
$contact = $settings['contact'] ?? [];
$social = $settings['social'] ?? [];
$header = $settings['header'] ?? [];
$footer = $settings['footer'] ?? [];
?>

<!-- Flash Messages -->
<?php if ($success = \App\Core\Session::getFlash('success')): ?>
    <div class="max-w-4xl mx-auto mb-6">
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-lg">
            <p>
                <?= htmlspecialchars($success) ?>
            </p>
        </div>
    </div>
<?php endif; ?>

<?php if ($error = \App\Core\Session::getFlash('error')): ?>
    <div class="max-w-4xl mx-auto mb-6">
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-lg">
            <p>
                <?= htmlspecialchars($error) ?>
            </p>
        </div>
    </div>
<?php endif; ?>

<div class="max-w-4xl mx-auto space-y-6">
    <form action="/yonetim/ayarlar/kaydet" method="POST" class="space-y-6">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars((string) ($csrf_token ?? '')) ?>">
        <!-- General -->
        <div class="bg-white rounded-xl border border-gray-100 p-6 space-y-6">
            <h3 class="font-bold text-gray-900 text-lg flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Genel Ayarlar
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Site Adı</label>
                    <input type="text" name="site_name"
                        value="<?= htmlspecialchars($general['site_name'] ?? 'TeknoRay Yapı Enerji') ?>"
                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Site Sloganı</label>
                    <input type="text" name="site_tagline"
                        value="<?= htmlspecialchars($general['site_tagline'] ?? 'Geleceği İnşa Eden Güç') ?>"
                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue outline-none">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Site Açıklaması (SEO)</label>
                <textarea name="site_description" rows="2"
                    class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue outline-none resize-none"><?= htmlspecialchars($general['site_description'] ?? "1941'den beri endüstriyel yapı ve enerji sektöründe güven, inovasyon ve sürdürülebilirlik odaklı çözümler üretiyoruz.") ?></textarea>
            </div>
        </div>

        <!-- Contact -->
        <div class="bg-white rounded-xl border border-gray-100 p-6 space-y-6">
            <h3 class="font-bold text-gray-900 text-lg flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                    </path>
                </svg>
                İletişim Bilgileri
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Telefon</label>
                    <input type="tel" name="contact_phone"
                        value="<?= htmlspecialchars($contact['contact_phone'] ?? '+90 (212) 000 00 00') ?>"
                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">E-posta</label>
                    <input type="email" name="contact_email"
                        value="<?= htmlspecialchars($contact['contact_email'] ?? 'info@teknoray.com.tr') ?>"
                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue outline-none">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Adres</label>
                <textarea name="contact_address" rows="2"
                    class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue outline-none resize-none"><?= htmlspecialchars($contact['contact_address'] ?? 'Maslak Mah. Büyükdere Cad. No:123, Sarıyer / İstanbul') ?></textarea>
            </div>
        </div>

        <!-- Social Media -->
        <div class="bg-white rounded-xl border border-gray-100 p-6 space-y-6">
            <h3 class="font-bold text-gray-900 text-lg flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                    </path>
                </svg>
                Sosyal Medya
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">LinkedIn</label>
                    <input type="url" name="social_linkedin"
                        value="<?= htmlspecialchars($social['social_linkedin'] ?? '') ?>"
                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue outline-none"
                        placeholder="https://linkedin.com/company/teknoray">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Instagram</label>
                    <input type="url" name="social_instagram"
                        value="<?= htmlspecialchars($social['social_instagram'] ?? '') ?>"
                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue outline-none"
                        placeholder="https://instagram.com/teknoray">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">YouTube</label>
                    <input type="url" name="social_youtube"
                        value="<?= htmlspecialchars($social['social_youtube'] ?? '') ?>"
                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue outline-none"
                        placeholder="https://youtube.com/@teknoray">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Twitter/X</label>
                    <input type="url" name="social_twitter"
                        value="<?= htmlspecialchars($social['social_twitter'] ?? '') ?>"
                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue outline-none"
                        placeholder="https://x.com/teknoray">
                </div>
            </div>
        </div>

        <!-- Header -->
        <div class="bg-white rounded-xl border border-gray-100 p-6 space-y-6">
            <h3 class="font-bold text-gray-900 text-lg flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h7"></path>
                </svg>
                Header Ayarları
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Üst Bar Telefon</label>
                    <input type="tel" name="header_phone"
                        value="<?= htmlspecialchars($header['header_phone'] ?? ($contact['contact_phone'] ?? '+90 (212) 000 00 00')) ?>"
                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Üst Bar E-posta</label>
                    <input type="email" name="header_email"
                        value="<?= htmlspecialchars($header['header_email'] ?? ($contact['contact_email'] ?? 'info@teknoray.com.tr')) ?>"
                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue outline-none">
                </div>
            </div>
            <p class="text-xs text-gray-400">Sosyal medya linkleri üstteki “Sosyal Medya” alanından alınır ve ön yüzde header’da gösterilir.</p>
        </div>

        <!-- Footer -->
        <div class="bg-white rounded-xl border border-gray-100 p-6 space-y-6">
            <h3 class="font-bold text-gray-900 text-lg flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
                Footer Ayarları
            </h3>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Footer Açıklama</label>
                <textarea name="footer_description" rows="3"
                    class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue outline-none resize-none"><?= htmlspecialchars($footer['footer_description'] ?? ($general['site_description'] ?? "1941'den beri endüstriyel yapı ve enerji sektöründe güven, inovasyon ve sürdürülebilirlik odaklı çözümler üretiyoruz.")) ?></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Footer Telefon</label>
                    <input type="tel" name="footer_phone"
                        value="<?= htmlspecialchars($footer['footer_phone'] ?? ($contact['contact_phone'] ?? '+90 (212) 000 00 00')) ?>"
                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Footer E-posta</label>
                    <input type="email" name="footer_email"
                        value="<?= htmlspecialchars($footer['footer_email'] ?? ($contact['contact_email'] ?? 'info@teknoray.com.tr')) ?>"
                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue outline-none">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Footer Adres</label>
                <textarea name="footer_address" rows="2"
                    class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue outline-none resize-none"><?= htmlspecialchars($footer['footer_address'] ?? ($contact['contact_address'] ?? 'Maslak Mah. Büyükdere Cad. No:123, Sarıyer / İstanbul')) ?></textarea>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-4">
            <button type="reset"
                class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition-colors">Sıfırla</button>
            <button type="submit"
                class="px-6 py-3 bg-brand-blue text-white rounded-lg font-medium hover:bg-blue-700 transition-colors">Ayarları
                Kaydet</button>
        </div>
    </form>
</div>