<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Page Title' }}</title>

    @vite(['resources/js/app.js', 'resources/css/styles.css','resources/css/app.css'])
    @livewireStyles
</head>

<body>

<livewire:parts.dash-navbar />



<div class="container-fluid">
    <div class="row">

        <!--        sidebar         -->
        <livewire:dashboard.sidebar />

        {{--        show page contents         --}}
        <div class="showbox col-10 border border-secondary mx-auto rounded-4">
            {{ $slot }}
        </div>


    </div>
</div>


@livewireScripts

<script>
    // ذخیره تم هنگام تغییر
    window.addEventListener('DashthemeChanged', e => {
        document.documentElement.setAttribute('data-bs-theme', e.detail.dashtheme);
        localStorage.setItem('dashtheme', e.detail.dashtheme);
    });

    // بازیابی تم هنگام لود صفحه
    document.addEventListener('DOMContentLoaded', () => {
        const savedTheme = localStorage.getItem('dashtheme');
        if (savedTheme) {
            document.documentElement.setAttribute('data-bs-theme', savedTheme);
        }
    });

    // بازیابی تم هنگام تغییر route با wire:navigate
    document.addEventListener("livewire:navigated", () => {
        const savedTheme = localStorage.getItem('dashtheme');
        if (savedTheme) {
            document.documentElement.setAttribute('data-bs-theme', savedTheme);
        }
    });
</script>
</body>
</html>
