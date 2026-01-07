<!-- Header/Footer Editor - Blue/Red Theme -->
<div class="max-w-6xl mx-auto space-y-6">
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

    <?php
    $header = $settings['header'] ?? [];
    $footer = $settings['footer'] ?? [];
    ?>

    <div>
        <h2 class="text-2xl font-bold text-gray-900">Header & Footer Yönetimi</h2>
        <p class="text-gray-500 text-sm">Site üst ve alt kısımlarını düzenleyin</p>
    </div>

    <form action="/yonetim/header-footer/kaydet" method="POST" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Header Settings -->
        <div class="bg-white rounded-xl border border-gray-100 p-6 space-y-6">
            <h3 class="font-bold text-gray-900 text-lg flex items-center gap-2">
                <svg class="w-5 h-5 text-brand-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7">
                    </path>
                </svg>
                Header (Üst Menü)
            </h3>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Üst Bar Telefon</label>
                <input type="tel" name="header_phone" value="<?= htmlspecialchars($header['header_phone'] ?? '') ?>"
                    class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:border-brand-blue outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Üst Bar E-posta</label>
                <input type="email" name="header_email" value="<?= htmlspecialchars($header['header_email'] ?? '') ?>"
                    class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:border-brand-blue outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">Menü Öğeleri</label>
                <div class="space-y-2">
                    <div class="flex items-center gap-2 p-3 bg-gray-50 rounded-lg">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16">
                            </path>
                        </svg>
                        <input type="text" value="Ana Sayfa" class="flex-1 bg-transparent border-none outline-none">
                        <input type="text" value="/"
                            class="w-24 bg-transparent border-none outline-none text-gray-500 text-sm">
                        <button class="text-brand-red hover:bg-red-50 p-1 rounded">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="flex items-center gap-2 p-3 bg-gray-50 rounded-lg">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16">
                            </path>
                        </svg>
                        <input type="text" value="Projeler" class="flex-1 bg-transparent border-none outline-none">
                        <input type="text" value="/projeler"
                            class="w-24 bg-transparent border-none outline-none text-gray-500 text-sm">
                        <button class="text-brand-red hover:bg-red-50 p-1 rounded">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <button
                        class="w-full p-3 border-2 border-dashed border-gray-200 rounded-lg hover:border-brand-blue hover:bg-blue-50 text-brand-blue text-sm font-medium transition-colors">
                        + Menü Öğesi Ekle
                    </button>
                </div>
            </div>

            <div class="pt-4 border-t">
                <button type="submit"
                    class="w-full bg-brand-blue text-white py-2.5 rounded-lg hover:bg-blue-700 transition-colors">Header/Footer
                    Ayarlarını Kaydet</button>
            </div>
        </div>

        <!-- Footer Settings -->
        <div class="bg-white rounded-xl border border-gray-100 p-6 space-y-6">
            <h3 class="font-bold text-gray-900 text-lg flex items-center gap-2">
                <svg class="w-5 h-5 text-brand-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7">
                    </path>
                </svg>
                Footer (Alt Kısım)
            </h3>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Footer Açıklama</label>
                <textarea rows="3" name="footer_description"
                    class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:border-brand-blue outline-none resize-none"><?= htmlspecialchars($footer['footer_description'] ?? '') ?></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Telefon</label>
                <input type="tel" name="footer_phone" value="<?= htmlspecialchars($footer['footer_phone'] ?? '') ?>"
                    class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:border-brand-blue outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">E-posta</label>
                <input type="email" name="footer_email" value="<?= htmlspecialchars($footer['footer_email'] ?? '') ?>"
                    class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:border-brand-blue outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Adres</label>
                <textarea rows="2" name="footer_address"
                    class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:border-brand-blue outline-none resize-none"><?= htmlspecialchars($footer['footer_address'] ?? '') ?></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">Sosyal Medya Linkleri</label>
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-500 w-24">LinkedIn</span>
                        <input type="url" placeholder="https://linkedin.com/company/teknoray"
                            class="flex-1 px-4 py-2 border border-gray-200 rounded-lg focus:border-brand-blue outline-none text-sm">
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-500 w-24">Instagram</span>
                        <input type="url" placeholder="https://instagram.com/teknoray"
                            class="flex-1 px-4 py-2 border border-gray-200 rounded-lg focus:border-brand-blue outline-none text-sm">
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t">
                <button type="submit"
                    class="w-full bg-brand-blue text-white py-2.5 rounded-lg hover:bg-blue-700 transition-colors">Header/Footer
                    Ayarlarını Kaydet</button>
            </div>
        </div>
    </form>
</div>