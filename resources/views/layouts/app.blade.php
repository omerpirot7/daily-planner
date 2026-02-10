<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Daily Planner' }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/images/favicon.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon.png">
    <link rel="shortcut icon" href="/images/favicon.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8FAFC; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen">
    
    <main class="py-12">
        {{ $slot }}
    </main>
    
</body>
</html>
