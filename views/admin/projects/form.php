<!-- Project Create/Edit Form -->
<div class="max-w-5xl mx-auto space-y-6">
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
            <a href="/yonetim/projeler" class="text-brand-blue hover:underline text-sm flex items-center gap-1 mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Projelere Dön
            </a>
            <h2 class="text-2xl font-bold text-gray-900">
                <?= isset($project) ? 'Proje Düzenle' : 'Yeni Proje Oluştur' ?>
            </h2>
        </div>
    </div>

    <?php
    // Decode gallery if it exists
    $galleryArray = [];
    if (isset($project['gallery'])) {
        if (is_string($project['gallery'])) {
            $galleryArray = json_decode($project['gallery'], true) ?: [];
        } elseif (is_array($project['gallery'])) {
            $galleryArray = $project['gallery'];
        }
    }
    ?>

    <form action="<?= isset($project) ? '/yonetim/projeler/guncelle/' . $project['id'] : '/yonetim/projeler/kaydet' ?>"
        method="POST" enctype="multipart/form-data" class="space-y-6">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars((string) ($csrf_token ?? '')) ?>">
        <!-- Main Info -->
        <div class="bg-white rounded-xl border border-gray-100 p-6 space-y-6">
            <h3 class="font-bold text-gray-900 text-lg">Temel Bilgiler</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Proje Adı *</label>
                    <input type="text" name="title" required value="<?= $project['title'] ?? '' ?>"
                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 outline-none"
                        placeholder="Örn: Giga Factory İstanbul">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">URL Slug</label>
                    <input type="text" name="slug" value="<?= $project['slug'] ?? '' ?>"
                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 outline-none"
                        placeholder="giga-factory-istanbul">
                    <p class="text-xs text-gray-400 mt-1">Boş bırakırsanız otomatik oluşturulur</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori *</label>
                    <select name="category" required
                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 outline-none bg-white">
                        <option value="">Kategori Seçin</option>
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $cat): ?>
                                <?php $catName = (string) ($cat['name'] ?? ''); ?>
                                <?php if ($catName !== ''): ?>
                                    <option value="<?= htmlspecialchars($catName) ?>" <?= ($project['category'] ?? '') === $catName ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($catName) ?>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="<?= htmlspecialchars($project['category'] ?? '') ?>" <?= !empty($project['category']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($project['category'] ?? '') ?>
                            </option>
                        <?php endif; ?>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Açıklama *</label>
                <textarea name="description" rows="5" required
                    class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 outline-none resize-none"
                    placeholder="Proje hakkında detaylı açıklama..."><?= $project['description'] ?? '' ?></textarea>
            </div>
        </div>

        <!-- Client Info -->
        <div class="bg-white rounded-xl border border-gray-100 p-6 space-y-6">
            <h3 class="font-bold text-gray-900 text-lg">Müşteri Bilgileri</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Müşteri / Firma</label>
                    <input type="text" name="client" value="<?= $project['client'] ?? '' ?>"
                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 outline-none"
                        placeholder="Örn: TeknoRay Enerji A.Ş.">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Proje Yılı</label>
                    <input type="text" name="year" value="<?= $project['year'] ?? date('Y') ?>"
                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 outline-none"
                        placeholder="2024">
                </div>
            </div>
        </div>

        <!-- Media -->
        <div class="bg-white rounded-xl border border-gray-100 p-6 space-y-6">
            <h3 class="font-bold text-gray-900 text-lg">Görseller</h3>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kapak Fotoğrafı *</label>
                <?php
                $coverPreview = $project['image'] ?? '';
                $coverPreview = is_string($coverPreview) ? trim($coverPreview) : '';
                if (!empty($coverPreview) && !preg_match('/^(https?:\/\/|\/)/', $coverPreview)) {
                    $coverPreview = '/' . ltrim($coverPreview, '/');
                }
                ?>
                <?php if (!empty($coverPreview)): ?>
                    <div class="mb-3">
                        <img src="<?= htmlspecialchars($coverPreview) ?>" alt="Mevcut kapak fotoğrafı"
                            class="h-32 w-auto rounded-lg border border-gray-200 bg-gray-50">
                    </div>
                <?php endif; ?>
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Dosya Yükle</label>
                        <input type="file" name="cover_image" accept=".gif,.png,.jpg,.jpeg,.svg"
                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 outline-none bg-white">
                    </div>
                    <div class="text-center text-gray-400 text-sm">veya</div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">URL ile Ekle</label>
                        <input type="url" name="image" value="<?= $project['image'] ?? '' ?>"
                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 outline-none"
                            placeholder="https://example.com/image.jpg">
                    </div>
                </div>
                <p class="text-xs text-gray-400 mt-2">Dosya yüklerseniz URL alanı göz ardı edilir. Boş bırakırsanız mevcut görsel korunur.</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Galeri Görselleri</label>
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Çoklu Dosya Yükle</label>
                        <input type="file" name="gallery_files[]" multiple accept=".gif,.png,.jpg,.jpeg,.svg"
                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 outline-none bg-white">
                        <p class="text-xs text-gray-400 mt-1">Birden fazla dosya seçebilirsiniz (Ctrl/Cmd tuşu ile)</p>
                    </div>
                    <div class="text-center text-gray-400 text-sm">veya</div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">URL ile Ekle (Her satıra bir URL)</label>
                        <textarea name="gallery" rows="6"
                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 outline-none resize-none font-mono text-sm bg-gray-50"
                            placeholder="https://example.com/gallery1.jpg&#10;https://example.com/gallery2.jpg&#10;https://example.com/gallery3.jpg"><?= !empty($galleryArray) ? implode("\n", $galleryArray) : '' ?></textarea>
                    </div>
                </div>
                <?php
                $galleryPreview = [];
                foreach (($galleryArray ?? []) as $galleryImg) {
                    if (!is_string($galleryImg)) {
                        continue;
                    }
                    $img = trim($galleryImg);
                    if ($img === '') {
                        continue;
                    }
                    if (!preg_match('/^(https?:\/\/|\/)/', $img)) {
                        $img = '/' . ltrim($img, '/');
                    }
                    $galleryPreview[] = $img;
                }
                ?>
                <?php if (!empty($galleryPreview)): ?>
                    <div class="mt-3">
                        <p class="text-xs font-medium text-gray-700 mb-2">Mevcut Galeri Görselleri:</p>
                        <div class="grid grid-cols-4 gap-2">
                            <?php foreach ($galleryPreview as $galleryImg): ?>
                                <img src="<?= htmlspecialchars($galleryImg) ?>" alt="Galeri görseli"
                                    class="h-20 w-full object-cover rounded border border-gray-200">
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <p class="text-xs text-gray-400 mt-2">Dosya yüklerseniz URL alanı göz ardı edilir. Yeni dosyalar mevcut galeriye eklenir.</p>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-4">
            <a href="/yonetim/projeler"
                class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition-colors">İptal</a>
            <button type="submit"
                class="px-6 py-3 bg-brand-blue text-white rounded-lg font-medium hover:bg-blue-700 transition-colors">
                <?= isset($project) ? 'Değişiklikleri Kaydet' : 'Projeyi Oluştur' ?>
            </button>
        </div>
    </form>
</div>