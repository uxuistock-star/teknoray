<section class="py-24 bg-white min-h-screen">
    <div class="container mx-auto px-6">
        <?php
        $contactPhone = $settings['contact']['contact_phone'] ?? '+90 (212) 000 00 00';
        $contactEmail = $settings['contact']['contact_email'] ?? 'info@teknoray.com.tr';
        $contactAddress = $settings['contact']['contact_address'] ?? "Maslak Mah. Büyükdere Cad. No:123\nSarıyer / İstanbul";
        ?>

        <!-- Hero -->
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-6xl font-heading font-bold mb-6 text-gray-900">BİZE <span
                    class="text-brand-blue">ULAŞIN</span></h1>
            <p class="text-gray-500 max-w-2xl mx-auto">Projeleriniz için teklif almak veya sorularınız için bizimle
                iletişime geçin.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
            <!-- Contact Form -->
            <div class="bg-gray-50 rounded-2xl p-8 md:p-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-8">İletişim Formu</h2>
                <form action="#" method="POST" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Ad Soyad</label>
                            <input type="text" name="name" required
                                class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 outline-none transition-all"
                                placeholder="Ahmet Yılmaz">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Firma</label>
                            <input type="text" name="company"
                                class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 outline-none transition-all"
                                placeholder="Firma Adı (Opsiyonel)">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">E-posta</label>
                        <input type="email" name="email" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 outline-none transition-all"
                            placeholder="ornek@firma.com">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Telefon</label>
                        <input type="tel" name="phone"
                            class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 outline-none transition-all"
                            placeholder="+90 5XX XXX XX XX">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Konu</label>
                        <select name="subject"
                            class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 outline-none transition-all">
                            <option value="">Konu Seçin</option>
                            <option value="teklif">Teklif Talebi</option>
                            <option value="bilgi">Bilgi Alma</option>
                            <option value="ortaklik">İş Ortaklığı</option>
                            <option value="kariyer">Kariyer</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Mesajınız</label>
                        <textarea name="message" rows="5" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 outline-none transition-all resize-none"
                            placeholder="Projeniz hakkında detayları paylaşın..."></textarea>
                    </div>
                    <button type="submit"
                        class="w-full bg-brand-red text-white font-bold py-4 rounded-lg hover:bg-red-700 transition-colors shadow-lg">
                        Mesaj Gönder
                    </button>
                </form>
            </div>

            <!-- Contact Info -->
            <div class="space-y-8">
                <!-- Map Placeholder -->
                <div class="rounded-2xl overflow-hidden h-64 bg-gray-200 relative">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3008.2599799553!2d29.0244!3d41.1082!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDHCsDA2JzI5LjUiTiAyOcKwMDEnMjcuOCJF!5e0!3m2!1str!2str!4v1640000000000!5m2!1str!2str"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                        class="absolute inset-0"></iframe>
                </div>

                <!-- Info Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-brand-blue text-white p-6 rounded-2xl">
                        <div class="text-3xl mb-4">📍</div>
                        <h3 class="font-bold text-lg mb-2">Merkez Ofis</h3>
                        <p class="text-white/80 text-sm"><?= nl2br(htmlspecialchars($contactAddress)) ?></p>
                    </div>
                    <div class="bg-gray-900 text-white p-6 rounded-2xl">
                        <div class="text-3xl mb-4">📞</div>
                        <h3 class="font-bold text-lg mb-2">Telefon</h3>
                        <p class="text-white/80 text-sm"><?= htmlspecialchars($contactPhone) ?></p>
                    </div>
                    <div class="bg-gray-100 p-6 rounded-2xl">
                        <div class="text-3xl mb-4">✉️</div>
                        <h3 class="font-bold text-lg mb-2 text-gray-900">E-posta</h3>
                        <p class="text-gray-600 text-sm"><?= htmlspecialchars($contactEmail) ?></p>
                    </div>
                    <div class="bg-brand-red text-white p-6 rounded-2xl">
                        <div class="text-3xl mb-4">🕐</div>
                        <h3 class="font-bold text-lg mb-2">Çalışma Saatleri</h3>
                        <p class="text-white/80 text-sm">Hafta içi: 09:00 - 18:00<br>Cumartesi: 09:00 - 14:00</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>