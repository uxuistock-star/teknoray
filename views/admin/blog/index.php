<!-- Blog Posts List - Blue/Red Theme -->
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Blog Yazıları</h2>
            <p class="text-gray-500 text-sm">Blog içeriklerini yönetin</p>
        </div>
        <div class="flex gap-2">
            <a href="/yonetim/blog/kategoriler"
                class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition-colors">
                Kategoriler
            </a>
            <a href="/yonetim/blog/ekle"
                class="inline-flex items-center px-4 py-2 bg-brand-blue text-white rounded-lg font-medium hover:bg-blue-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Yeni Yazı Ekle
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-6 py-4 text-left"><input type="checkbox" class="rounded border-gray-300"></th>
                        <th class="px-6 py-4 text-left">Yazı</th>
                        <th class="px-6 py-4 text-left">Kategori</th>
                        <th class="px-6 py-4 text-left">Görüntülenme</th>
                        <th class="px-6 py-4 text-left">Tarih</th>
                        <th class="px-6 py-4 text-left">İşlemler</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php foreach ($posts as $post): ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4"><input type="checkbox" class="rounded border-gray-300"></td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-4">
                                    <img src="<?= $post['thumbnail'] ?>" class="w-16 h-12 rounded-lg object-cover" alt="">
                                    <div>
                                        <div class="font-medium text-gray-900 line-clamp-1">
                                            <?= htmlspecialchars($post['title']) ?></div>
                                        <div class="text-sm text-gray-500">/blog/<?= $post['slug'] ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <?php
                                $catName = 'Genel';
                                $catId = isset($post['category_id']) ? (int) $post['category_id'] : 0;
                                if ($catId > 0 && !empty($categoriesById[$catId]['name'])) {
                                    $catName = (string) $categoriesById[$catId]['name'];
                                }
                                ?>
                                <span class="px-3 py-1 bg-brand-blue/10 text-brand-blue rounded-full text-sm font-medium"><?= htmlspecialchars($catName) ?></span>
                            </td>
                            <td class="px-6 py-4 text-gray-600"><?= number_format($post['views']) ?></td>
                            <td class="px-6 py-4 text-gray-600"><?= date('d.m.Y', strtotime($post['created_at'])) ?></td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <a href="/blog/<?= $post['slug'] ?>" target="_blank"
                                        class="p-2 text-gray-400 hover:text-brand-blue hover:bg-gray-100 rounded-lg transition-colors"
                                        title="Görüntüle">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </a>
                                    <a href="/yonetim/blog/duzenle/<?php echo $post['id']; ?>"
                                        class="p-2 text-gray-400 hover:text-brand-blue hover:bg-gray-100 rounded-lg transition-colors"
                                        title="Düzenle">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </a>
                                    <form action="/yonetim/blog/sil/<?php echo (int) $post['id']; ?>" method="POST" onsubmit="return confirm('Bu yazıyı silmek istediğinizden emin misiniz?')">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars((string) ($csrf_token ?? '')) ?>">
                                        <button
                                            type="submit"
                                            class="p-2 text-gray-400 hover:text-brand-red hover:bg-gray-100 rounded-lg transition-colors"
                                            title="Sil">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>