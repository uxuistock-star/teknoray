<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yönetici Girişi | TeknoRay</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: { blue: '#1C5B8B', red: '#EC1B13' }
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                        heading: ['Audiowide', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Audiowide&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 min-h-screen flex items-center justify-center">

    <!-- Login Card - Perfectly Centered -->
    <div class="w-full max-w-md px-6">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">

            <!-- Logo Header -->
            <div class="bg-brand-blue py-8 text-center">
                <h1 class="font-heading text-3xl font-bold text-white tracking-wider">
                    TEKNO<span class="text-brand-red">RAY</span>
                </h1>
                <p class="text-blue-200 text-sm mt-2 tracking-widest uppercase">Yönetim Paneli</p>
            </div>

            <!-- Form -->
            <div class="p-8">
                <?php if (isset($error) && $error): ?>
                    <div class="bg-red-50 border-l-4 border-brand-red text-red-700 px-4 py-3 rounded-lg mb-6 text-sm">
                        <?= $error ?>
                    </div>
                <?php endif; ?>

                <form action="/yonetim/giris" method="POST" class="space-y-5">
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">Kullanıcı Adı</label>
                        <input type="text" name="username" required autofocus
                            class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 outline-none transition-all"
                            placeholder="admin">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">Şifre</label>
                        <input type="password" name="password" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 outline-none transition-all"
                            placeholder="••••••••">
                    </div>

                    <button type="submit"
                        class="w-full bg-brand-blue text-white font-bold py-3.5 rounded-lg hover:bg-blue-700 transition-colors">
                        Giriş Yap
                    </button>
                </form>

                <!-- Links -->
                <div class="mt-6 pt-6 border-t border-gray-100 flex flex-col items-center gap-3">
                    <a href="#" class="text-gray-500 hover:text-brand-blue text-sm transition-colors">
                        Şifremi Unuttum
                    </a>
                    <a href="/"
                        class="text-brand-blue hover:text-brand-red text-sm font-medium transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Ana Sayfaya Dön
                    </a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>