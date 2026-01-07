<!-- Blog Create/Edit Form - Blue/Red Theme -->
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <a href="/yonetim/blog" class="text-brand-blue hover:underline text-sm flex items-center gap-1 mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Blog Yazılarına Dön
            </a>
            <h2 class="text-2xl font-bold text-gray-900"><?= isset($post) ? 'Yazıyı Düzenle' : 'Yeni Blog Yazısı' ?>
            </h2>
        </div>
    </div>

    <form action="<?= isset($post) ? '/yonetim/blog/guncelle/' . $post['id'] : '/yonetim/blog/kaydet' ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars((string) ($csrf_token ?? '')) ?>">
        <!-- Main Content -->
        <div class="bg-white rounded-xl border border-gray-100 p-6 space-y-6">
            <h3 class="font-bold text-gray-900 text-lg">İçerik</h3>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Başlık *</label>
                <input type="text" name="title" required value="<?= $post['title'] ?? '' ?>"
                    class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 outline-none"
                    placeholder="Yazı başlığı...">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">URL Slug</label>
                    <input type="text" name="slug" value="<?= $post['slug'] ?? '' ?>"
                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue outline-none"
                        placeholder="yazi-basligi">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                    <select name="category_id"
                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue outline-none">
                        <option value="">Kategori Seçin</option>
                        <?php foreach (($categories ?? []) as $cat): ?>
                            <option value="<?= (int) $cat['id'] ?>" <?= (string) ((int) ($post['category_id'] ?? 0)) === (string) ((int) $cat['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Özet *</label>
                <textarea name="summary" rows="3" required
                    class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 outline-none resize-none"
                    placeholder="Kısa özet (liste görünümünde görünecek)..."><?= $post['summary'] ?? '' ?></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">İçerik *</label>
                <textarea name="content" rows="12" required
                    class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 outline-none resize-none"
                    placeholder="Yazı içeriği (HTML desteklenir)..."><?= $post['content'] ?? '' ?></textarea>
                <p class="text-xs text-gray-400 mt-1">HTML etiketleri kullanabilirsiniz</p>
            </div>
        </div>

        <!-- Media -->
        <div class="bg-white rounded-xl border border-gray-100 p-6 space-y-6">
            <h3 class="font-bold text-gray-900 text-lg">Görsel</h3>

            <div>
                <?php
                $thumbPreview = $post['thumbnail'] ?? '';
                $thumbPreview = is_string($thumbPreview) ? trim($thumbPreview) : '';
                if (!empty($thumbPreview) && !preg_match('/^(https?:\/\/|\/)/', $thumbPreview)) {
                    $thumbPreview = '/' . ltrim($thumbPreview, '/');
                }
                ?>

                <?php if (!empty($thumbPreview)): ?>
                    <div class="mb-3">
                        <img src="<?= htmlspecialchars($thumbPreview) ?>" alt="Mevcut kapak görseli"
                            class="h-32 w-auto rounded-lg border border-gray-200 bg-gray-50">
                    </div>
                <?php endif; ?>

                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Dosya Yükle</label>
                        <input type="file" name="thumbnail_file" accept=".gif,.png,.jpg,.jpeg,.svg"
                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 outline-none bg-white">
                    </div>
                    <div class="text-center text-gray-400 text-sm">veya</div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">URL ile Ekle</label>
                        <input type="url" name="thumbnail" value="<?= $post['thumbnail'] ?? '' ?>"
                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue outline-none"
                            placeholder="https://example.com/image.jpg">
                    </div>
                </div>

                <p class="text-xs text-gray-400 mt-2">Dosya yüklerseniz URL alanı göz ardı edilir. Boş bırakılırsa mevcut görsel korunur.</p>
            </div>
        </div>

        <!-- SEO -->
        <div class="bg-white rounded-xl border border-gray-100 p-6 space-y-6">
            <h3 class="font-bold text-gray-900 text-lg">SEO Ayarları</h3>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Meta Başlık</label>
                <input type="text" name="meta_title" value=""
                    class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue outline-none"
                    placeholder="Boş bırakılırsa yazı başlığı kullanılır">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Meta Açıklama</label>
                <textarea name="meta_description" rows="2"
                    class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue outline-none resize-none"
                    placeholder="Arama motorları için açıklama..."></textarea>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-4">
            <a href="/yonetim/blog"
                class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition-colors">İptal</a>
            <button type="submit"
                class="px-6 py-3 bg-brand-blue text-white rounded-lg font-medium hover:bg-blue-700 transition-colors">
                <?= isset($post) ? 'Değişiklikleri Kaydet' : 'Yazıyı Yayınla' ?>
            </button>
        </div>
    </form>
</div>