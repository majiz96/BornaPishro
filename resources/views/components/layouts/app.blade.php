<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Page Title' }}</title>

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
<script>
    // ذخیره تم هنگام تغییر
    window.addEventListener('themeChanged', e => {
        document.documentElement.setAttribute('data-bs-theme', e.detail.theme);
        localStorage.setItem('theme', e.detail.theme);
    });

    // بازیابی تم هنگام لود صفحه
    document.addEventListener('DOMContentLoaded', () => {
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            document.documentElement.setAttribute('data-bs-theme', savedTheme);
        }
    });

    // بازیابی تم هنگام تغییر route با wire:navigate
    document.addEventListener("livewire:navigated", () => {
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            document.documentElement.setAttribute('data-bs-theme', savedTheme);
        }
    });
</script>
</body>
</html>
