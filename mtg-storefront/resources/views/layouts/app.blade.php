<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MTG Storefront</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 min-h-screen">

    <nav class="bg-gray-900 fixed w-full z-20 top-0 inset-x-0 border-b border-gray-700">
        <div class="max-w-7xl flex flex-wrap items-center justify-between mx-auto p-4">

            <a href="/products" class="flex items-center space-x-3">
                <span class="self-center text-xl text-white font-semibold whitespace-nowrap">MTG Storefront</span>
            </a>

            <!-- Mobile toggle -->
            <button data-collapse-toggle="navbar-default" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-400 rounded-md md:hidden hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-gray-500"
                aria-controls="navbar-default" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14"/>
                </svg>
            </button>

            <div class="hidden w-full md:flex md:items-center md:w-auto md:gap-6" id="navbar-default">
                <ul class="font-medium flex flex-col md:flex-row md:items-center gap-2 md:gap-6 p-4 md:p-0 mt-4 md:mt-0 border border-gray-700 rounded-md bg-gray-800 md:border-0 md:bg-transparent">
                    <li>
                        <a href="/products" class="block py-2 px-3 text-white hover:text-blue-400 transition md:p-0">
                            Dashboard
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </nav>

    <div class="container mx-auto px-4 pt-24 pb-8">
        @yield('content')
    </div>

    <footer class="bg-gray-900 text-gray-400 text-sm text-center py-4 mt-8">
        &copy; Maria Tedeman &amp; Elsa Girardo 2026
    </footer>

</body>
</html>