<!-- Slider Management - Blue/Red Theme -->
<div class="space-y-6">
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
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Hero Slider Yönetimi</h2>
            <p class="text-gray-500 text-sm">Ana sayfa slider içeriklerini düzenleyin</p>
        </div>
        <a href="/yonetim/slider/ekle"
            class="inline-flex items-center px-4 py-2 bg-brand-blue text-white rounded-lg font-medium hover:bg-blue-700 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Yeni Slide Ekle
        </a>
    </div>

    <?php
    $mode = $mode ?? 'list';
    $slide = $slide ?? null;
    ?>

    <?php if ($mode === 'create' || $mode === 'edit'): ?>
        <div class="bg-white rounded-xl border border-gray-100 p-6">
            <h3 class="font-bold text-gray-900 text-lg mb-4"><?= $mode === 'edit' ? 'Slide Düzenle' : 'Yeni Slide Ekle' ?></h3>
            <form action="<?= $mode === 'edit' ? '/yonetim/slider/guncelle/' . (int)$slide['id'] : '/yonetim/slider/kaydet' ?>"
                method="POST" enctype="multipart/form-data" class="space-y-4">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars((string) ($csrf_token ?? '')) ?>">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Başlık *</label>
                    <input type="text" name="title" required value="<?= htmlspecialchars($slide['title'] ?? '') ?>"
                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:border-brand-blue outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Açıklama</label>
                    <textarea name="description" rows="3"
                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:border-brand-blue outline-none resize-none"><?= htmlspecialchars($slide['description'] ?? '') ?></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Buton 1 Metni</label>
                        <input type="text" name="button1_text" value="<?= htmlspecialchars($slide['button1_text'] ?? '') ?>"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:border-brand-blue outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Buton 1 Linki</label>
                        <input type="text" name="button1_link" value="<?= htmlspecialchars($slide['button1_link'] ?? '') ?>"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:border-brand-blue outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Buton 2 Metni</label>
                        <input type="text" name="button2_text" value="<?= htmlspecialchars($slide['button2_text'] ?? '') ?>"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:border-brand-blue outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Buton 2 Linki</label>
                        <input type="text" name="button2_link" value="<?= htmlspecialchars($slide['button2_link'] ?? '') ?>"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:border-brand-blue outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sıra</label>
                        <input type="number" name="display_order" value="<?= isset($slide['display_order']) ? (int)$slide['display_order'] : 0 ?>"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:border-brand-blue outline-none">
                    </div>
                    <div class="flex items-center gap-3 pt-8">
                        <input type="checkbox" name="is_active" value="1" <?= ($mode === 'create' || (int)($slide['is_active'] ?? 1) === 1) ? 'checked' : '' ?> class="rounded border-gray-300">
                        <label class="text-sm text-gray-700">Aktif</label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Medya (GIF/PNG/JPG/JPEG/MP4/SVG) <?= $mode === 'edit' ? '(Opsiyonel)' : '*' ?></label>
                    <?php if (!empty($slide['media_url'])): ?>
                        <div class="mb-3">
                            <?php if (($slide['media_type'] ?? 'image') === 'video'): ?>
                                <video class="w-full max-w-md rounded-lg border border-gray-200" controls>
                                    <source src="<?= htmlspecialchars($slide['media_url']) ?>" type="video/mp4">
                                </video>
                            <?php else: ?>
                                <img src="<?= htmlspecialchars($slide['media_url']) ?>" class="w-full max-w-md rounded-lg border border-gray-200" alt="Medya">
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <input type="file" name="media" accept=".gif,.png,.jpg,.jpeg,.mp4,.svg"
                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:border-brand-blue outline-none bg-white">
                    <p class="text-xs text-gray-400 mt-1">Maksimum 100MB.</p>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <a href="/yonetim/slider" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">İptal</a>
                    <button type="submit" class="px-4 py-2 bg-brand-blue text-white rounded-lg hover:bg-blue-700 transition-colors">Kaydet</button>
                </div>
            </form>
        </div>
    <?php endif; ?>

    <!-- Slides List -->
    <div class="space-y-4">
        <?php foreach (($slides ?? []) as $s): ?>
            <div class="bg-white rounded-xl border border-gray-100 overflow-hidden hover:shadow-lg transition-shadow">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-6">
                    <div class="lg:col-span-1">
                        <div class="relative rounded-lg overflow-hidden aspect-video bg-gray-100">
                            <?php if (($s['media_type'] ?? 'image') === 'video'): ?>
                                <video class="w-full h-full object-cover" muted controls>
                                    <source src="<?= htmlspecialchars($s['media_url']) ?>" type="video/mp4">
                                </video>
                                <div class="absolute top-2 right-2 bg-brand-blue text-white text-xs px-2 py-1 rounded">Video</div>
                            <?php else: ?>
                                <img src="<?= htmlspecialchars($s['media_url']) ?>" class="w-full h-full object-cover" alt="Slide">
                                <div class="absolute top-2 right-2 bg-brand-blue text-white text-xs px-2 py-1 rounded">Görsel</div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="lg:col-span-2 space-y-3">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <div class="text-xs text-gray-400 mb-1">Sıra: <?= (int)($s['display_order'] ?? 0) ?> · <?= (int)($s['is_active'] ?? 0) === 1 ? 'Aktif' : 'Pasif' ?></div>
                                <h3 class="text-lg font-bold text-gray-900"><?= htmlspecialchars($s['title']) ?></h3>
                                <?php if (!empty($s['description'])): ?>
                                    <p class="text-gray-600 text-sm mt-2"><?= htmlspecialchars($s['description']) ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="flex gap-2">
                                <a href="/yonetim/slider/duzenle/<?= (int)$s['id'] ?>"
                                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">Düzenle</a>
                                <form action="/yonetim/slider/sil/<?= (int) $s['id'] ?>" method="POST" onsubmit="return confirm('Bu slide silinsin mi?')">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars((string) ($csrf_token ?? '')) ?>">
                                    <button type="submit" class="px-4 py-2 text-brand-red hover:bg-red-50 rounded-lg transition-colors">Sil</button>
                                </form>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 pt-2 border-t">
                            <div class="text-xs text-gray-500">Buton 1: <?= htmlspecialchars($s['button1_text'] ?? '') ?> <?= !empty($s['button1_link']) ? '(' . htmlspecialchars($s['button1_link']) . ')' : '' ?></div>
                            <div class="text-xs text-gray-500">Buton 2: <?= htmlspecialchars($s['button2_text'] ?? '') ?> <?= !empty($s['button2_link']) ? '(' . htmlspecialchars($s['button2_link']) . ')' : '' ?></div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>