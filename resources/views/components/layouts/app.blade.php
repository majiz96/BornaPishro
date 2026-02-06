    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Security-Policy" content="script-src * 'unsafe-inline' 'unsafe-eval' data:;">
        <title>{{ $title ?? 'Page Title' }}</title>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nouislider@15.7.0/dist/nouislider.min.css">

        <script>
            (function() {
                const savedTheme = localStorage.getItem('theme');
                if (savedTheme) {
                    document.documentElement.setAttribute('data-bs-theme', savedTheme);
                }
            })();
        </script>

        @vite(['resources/js/app.js', 'resources/css/styles.css','resources/css/app.css'])
        @livewireStyles
    </head>

    <body>

    <livewire:parts.navbar />

    <main class="py-4">
        {{ $slot }}
    </main>

    @livewireScripts

    <script src="https://cdn.jsdelivr.net/npm/nouislider@15.7.0/dist/nouislider.min.js"></script>

    <script>
        function applyTheme(theme) {
            document.documentElement.setAttribute('data-bs-theme', theme);
            localStorage.setItem('theme', theme);
        }

        // بارگذاری اولیه
        document.addEventListener('DOMContentLoaded', () => {
            applyTheme(localStorage.getItem('theme') || 'dark');
        });

        // تغییر توسط کاربر
        window.addEventListener('themeChanged', e => applyTheme(e.detail.theme));

        // بعد از navigate
        document.addEventListener('livewire:navigated', () => {
            applyTheme(localStorage.getItem('theme') || 'dark');
        });
    </script>
    </body>
    </html>
