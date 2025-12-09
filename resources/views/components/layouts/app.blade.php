<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Page Title' }}</title>

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
    window.addEventListener('themeChanged', e => {
        document.documentElement.setAttribute('data-bs-theme',e.detail.theme);
    })
</script>
</body>
</html>
