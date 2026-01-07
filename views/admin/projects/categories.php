<!-- Project Categories Management -->
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

    <div class="flex items-center justify-between">
        <div>
            <a href="/yonetim/projeler" class="text-brand-blue hover:underline text-sm flex items-center gap-1 mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Projelere Dön
            </a>
            <h2 class="text-2xl font-bold text-gray-900">Proje Kategorileri</h2>
            <p class="text-gray-500 text-sm">Proje kategori listesini yönetin</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 p-6">
        <form action="/yonetim/projeler/kategoriler/kaydet" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars((string) ($csrf_token ?? '')) ?>">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori Adı *</label>
                <input type="text" name="name" required
                    class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-brand-blue outline-none"
                    placeholder="Örn: Endüstriyel Yapı">
            </div>
            <div>
                <button type="submit"
                    class="w-full px-4 py-3 bg-brand-blue text-white rounded-lg font-medium hover:bg-blue-700 transition-colors">Ekle</button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                <tr>
                    <th class="px-6 py-4 text-left">Kategori</th>
                    <th class="px-6 py-4 text-left">Slug</th>
                    <th class="px-6 py-4 text-right">İşlem</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php foreach (($categories ?? []) as $cat): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900"><?= htmlspecialchars($cat['name']) ?></td>
                        <td class="px-6 py-4 text-gray-500"><?= htmlspecialchars($cat['slug'] ?? '') ?></td>
                        <td class="px-6 py-4 text-right">
                            <form action="/yonetim/projeler/kategoriler/sil/<?= (int) $cat['id'] ?>" method="POST" onsubmit="return confirm('Bu kategoriyi silmek istediğinizden emin misiniz?')" class="inline">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars((string) ($csrf_token ?? '')) ?>">
                                <button type="submit" class="text-brand-red font-medium hover:underline">Sil</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
