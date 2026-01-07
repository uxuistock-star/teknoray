<!-- Services List - Blue/Red Theme -->
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
            <h2 class="text-2xl font-bold text-gray-900">Hizmetler</h2>
            <p class="text-gray-500 text-sm">Hizmet alanlarını yönetin</p>
        </div>
        <a href="/yonetim/hizmetler/ekle"
            class="inline-flex items-center px-4 py-2 bg-brand-blue text-white rounded-lg font-medium hover:bg-blue-700 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Yeni Hizmet Ekle
        </a>
    </div>

    <!-- Services Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($services as $service): ?>
            <div class="bg-white rounded-xl border border-gray-100 p-6 hover:shadow-lg transition-shadow">
                <?php
                $serviceImage = $service['image_url'] ?? ($service['image'] ?? '');
                $serviceImage = is_string($serviceImage) ? trim($serviceImage) : '';
                if (!empty($serviceImage) && !preg_match('/^(https?:\/\/|\/)/', $serviceImage)) {
                    $serviceImage = '/' . ltrim($serviceImage, '/');
                }
                ?>
                <?php if (!empty($serviceImage)): ?>
                    <div class="mb-4">
                        <img src="<?= htmlspecialchars($serviceImage) ?>" alt=""
                            class="w-full h-36 object-cover rounded-lg border border-gray-100 bg-gray-50">
                    </div>
                <?php endif; ?>
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 bg-brand-blue/10 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-brand-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <div class="flex space-x-1">
                        <a href="/yonetim/hizmetler/duzenle/<?= (int) $service['id'] ?>"
                            class="p-1.5 text-gray-400 hover:text-brand-blue hover:bg-gray-100 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </a>
                        <form action="/yonetim/hizmetler/sil/<?= (int) $service['id'] ?>" method="POST" onsubmit="return confirm('Bu hizmeti silmek istediğinizden emin misiniz?')">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars((string) ($csrf_token ?? '')) ?>">
                            <button type="submit" class="p-1.5 text-gray-400 hover:text-brand-red hover:bg-gray-100 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
                <h3 class="font-bold text-gray-900 text-lg mb-2"><?= htmlspecialchars($service['title']) ?></h3>
                <p class="text-gray-500 text-sm line-clamp-2"><?= htmlspecialchars($service['summary']) ?></p>
            </div>
        <?php endforeach; ?>

        <!-- Add New Card -->
        <a href="/yonetim/hizmetler/ekle"
            class="bg-gray-50 rounded-xl border-2 border-dashed border-gray-200 p-6 flex flex-col items-center justify-center text-center hover:bg-gray-100 transition-colors cursor-pointer min-h-[200px]">
            <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
            </div>
            <span class="text-gray-500 font-medium">Yeni Hizmet Ekle</span>
        </a>
    </div>
</div>