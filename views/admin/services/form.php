<!-- Service Create/Edit Form -->
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

    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <a href="/yonetim/hizmetler" class="text-brand-blue hover:underline text-sm flex items-center gap-1 mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Hizmetlere Dön
            </a>
            <h2 class="text-2xl font-bold text-gray-900">
                <?= isset($service) ? 'Hizmet Düzenle' : 'Yeni Hizmet Ekle' ?>
            </h2>
        </div>
    </div>

    <form action="<?= isset($service) ? '/yonetim/hizmetler/guncelle/' . $service['id'] : '/yonetim/hizmetler/kaydet' ?>"
        method="POST" enctype="multipart/form-data" class="space-y-6">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars((string) ($csrf_token ?? '')) ?>">
        <!-- Main Info -->
        <div class="bg-white rounded-xl border border-gray-100 p-6 space-y-6">
            <h3 class="font-bold text-gray-900 text-lg">Temel Bilgiler</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hizmet Başlığı *</label>
                    <input type="text" name="title" required value="<?= $service['title'] ?? '' ?>"
                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 outline-none"
                        placeholder="Örn: Endüstriyel Yapı İnşaatı">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kısa Özet *</label>
                    <textarea name="summary" rows="3" required
                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 outline-none resize-none"
                        placeholder="Liste ve ana sayfada görünecek kısa özet..."><?= $service['summary'] ?? '' ?></textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Detay Açıklama</label>
                    <textarea name="description" rows="6"
                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 outline-none resize-none"
                        placeholder="Hizmet detay açıklaması..."><?= $service['description'] ?? '' ?></textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hizmet Görseli (GIF/PNG/JPG/JPEG/MP4/SVG)</label>
                    <?php
                    $serviceImage = $service['image_url'] ?? ($service['image'] ?? '');
                    $serviceImage = is_string($serviceImage) ? trim($serviceImage) : '';
                    if (!empty($serviceImage) && !preg_match('/^(https?:\/\/|\/)/', $serviceImage)) {
                        $serviceImage = '/' . ltrim($serviceImage, '/');
                    }
                    ?>
                    <?php if (!empty($serviceImage)): ?>
                        <div class="mb-3">
                            <img src="<?= htmlspecialchars($serviceImage) ?>" alt="Mevcut görsel"
                                class="h-28 w-auto rounded-lg border border-gray-200 bg-gray-50">
                        </div>
                    <?php endif; ?>
                    <input type="file" name="image" accept=".gif,.png,.jpg,.jpeg,.mp4,.svg"
                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 outline-none bg-white">
                    <p class="text-xs text-gray-400 mt-1">Boş bırakırsanız mevcut görsel korunur.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">İkon (opsiyonel)</label>
                    <input type="text" name="icon" value="<?= $service['icon'] ?? '' ?>"
                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 outline-none"
                        placeholder="Örn: briefcase">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sıra</label>
                    <input type="number" name="display_order" value="<?= isset($service['display_order']) ? (int)$service['display_order'] : 0 ?>"
                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 outline-none"
                        placeholder="0">
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-4">
            <a href="/yonetim/hizmetler"
                class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition-colors">İptal</a>
            <button type="submit"
                class="px-6 py-3 bg-brand-blue text-white rounded-lg font-medium hover:bg-blue-700 transition-colors">
                <?= isset($service) ? 'Değişiklikleri Kaydet' : 'Hizmeti Oluştur' ?>
            </button>
        </div>
    </form>
</div>
