<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MTG Storefront</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<header>
    <nav>
        <a href="/">Home</a>
    </nav>
<body>
    <div class="container mx-auto px-4 py-8">
        @yield('content')
    </div>
</body>
<footer>
    <div>
        &copy; Maria Tedeman & Elsa Girardo 2026
    </div>
</footer>
</html>