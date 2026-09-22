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

<body class="overflow-x-hidden">

<livewire:parts.navbar />
<livewire:parts.search />



<div class="container-fluid">
    <div class="row">

        <!--        sidebar         -->
        <livewire:dashboard.sidebar />

        {{--        show page contents         --}}
        <div class="showbox col-xxl-9 col-xl-10 col-12 mx-auto rounded-4">
            {{ $slot }}
        </div>


    </div>
</div>


@livewireScripts
<script>
    function applyTheme(theme) {
        document.documentElement.setAttribute('data-bs-theme', theme);

        // اگر آیکن تغییر تم داری
        const icon = document.getElementById('themeToggleIcon');
        if (icon) {
            if (theme === 'dark') {
                icon.classList.remove('bi-sun');
                icon.classList.add('bi-moon');
            } else {
                icon.classList.remove('bi-moon');
                icon.classList.add('bi-sun');
            }
        }
    }

    // ذخیره تم و آیکن هنگام تغییر
    window.addEventListener('themeChanged', e => {
        applyTheme(e.detail.theme);
        localStorage.setItem('theme', e.detail.theme);
    });

    // بازیابی تم و آیکن هنگام لود صفحه
    document.addEventListener('DOMContentLoaded', () => {
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) applyTheme(savedTheme);
    });

    // بازیابی تم و آیکن بعد از navigate
    document.addEventListener('navigated', () => {
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) applyTheme(savedTheme);
    });

    document.addEventListener('livewire:navigated', () => {
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) applyTheme(savedTheme);
    });
</script>
</body>
</html>
