<!-- Reference Logos Management - Blue/Red Theme -->
<div class="space-y-6" x-data="{ showForm: false }">
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
            <h2 class="text-2xl font-bold text-gray-900">Referans Şirket Logoları</h2>
            <p class="text-gray-500 text-sm">Footer üstünde akan şirket logolarını yönetin</p>
        </div>
        <button @click="showForm = true"
            class="inline-flex items-center px-4 py-2 bg-brand-blue text-white rounded-lg font-medium hover:bg-blue-700 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Yeni Logo Ekle
        </button>
    </div>

    <!-- Logos Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
        <?php foreach (($logos ?? []) as $logo): ?>
            <div class="bg-white rounded-xl border border-gray-100 p-6 hover:shadow-lg transition-shadow group">
                <div class="aspect-square flex items-center justify-center mb-4 bg-gray-50 rounded-lg overflow-hidden">
                    <img src="<?= htmlspecialchars($logo['logo_url']) ?>" alt="<?= htmlspecialchars($logo['company_name']) ?>" class="max-w-full max-h-full object-contain">
                </div>
                <div class="text-center mb-3">
                    <div class="font-medium text-gray-900 text-sm">
                        <?= htmlspecialchars($logo['company_name']) ?>
                    </div>
                </div>
                <div class="flex gap-2">
                    <form action="/yonetim/logolar/sil/<?= (int) $logo['id'] ?>" method="POST" class="flex-1" onsubmit="return confirm('Bu logoyu silmek istediğinizden emin misiniz?')">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars((string) ($csrf_token ?? '')) ?>">
                        <button type="submit" class="w-full p-2 text-brand-red hover:bg-red-50 rounded-lg transition-colors text-sm">
                            <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Add New Card -->
        <div @click="showForm = true"
            class="bg-gray-50 rounded-xl border-2 border-dashed border-gray-200 p-6 flex flex-col items-center justify-center text-center hover:bg-gray-100 transition-colors cursor-pointer min-h-[200px]">
            <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
            </div>
            <span class="text-gray-500 font-medium text-sm">Yeni Logo</span>
        </div>
    </div>

    <!-- Logo Add/Edit Form -->
    <div x-show="showForm" x-cloak
        class="bg-white rounded-xl border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-gray-900">Logo Ekle / Düzenle</h3>
            <button @click="showForm = false" type="button"
                class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form action="/yonetim/logolar/kaydet" method="POST" enctype="multipart/form-data" class="space-y-4" @submit="setTimeout(() => showForm = false, 100)">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars((string) ($csrf_token ?? '')) ?>">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Şirket Adı *</label>
                    <input type="text" name="company_name" required
                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:border-brand-blue outline-none"
                        placeholder="Örn: Siemens">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sıra</label>
                    <input type="number" name="display_order" value="0"
                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:border-brand-blue outline-none">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Logo Dosyası Yükle</label>
                <input type="file" name="logo_file" accept=".gif,.png,.jpg,.jpeg,.svg"
                    class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:border-brand-blue outline-none bg-white">
                <p class="text-xs text-gray-400 mt-1">Desteklenen formatlar: GIF, PNG, JPG, JPEG, SVG (Maksimum 5MB)</p>
            </div>
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">VEYA</span>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Logo URL</label>
                <input type="url" name="logo_url"
                    class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:border-brand-blue outline-none"
                    placeholder="https://example.com/logo.png">
                <p class="text-xs text-gray-400 mt-1">Dosya yüklemediyseniz logo URL'si girebilirsiniz</p>
            </div>
            <div class="flex gap-2">
                <button type="button" @click="showForm = false"
                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">İptal</button>
                <button type="submit"
                    class="px-4 py-2 bg-brand-blue text-white rounded-lg hover:bg-blue-700 transition-colors">Kaydet</button>
            </div>
        </form>
    </div>
</div>