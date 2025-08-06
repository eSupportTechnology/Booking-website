<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Auth')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        inter: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: '#0F5A83',
                        hoverPrimary: '#4EB6D2',
                        darkText: '#2F2937',
                        lightText: '#F0F9FF',
                        darkBlueStart: '#2F2937',
                        darkBlueMid: '#1F8FB2',
                    }
                }
            }
        }
    </script>
</head>
<body class="font-inter bg-gradient-to-br from-darkBlueStart via-darkBlueMid to-darkBlueStart min-h-screen flex text-darkText">
    <nav class="text-white fixed w-full z-50 shadow-xl">
        <div class="max-w-full mx-auto px-4">
            <div class="flex justify-between h-16 items-center">

                <!-- Left: Logo + Hamburger -->
                <div class="flex items-center space-x-4">
                <!-- Hamburger -->
                <button id="menuToggle" class="text-white focus:outline-none block md:hidden">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <a href="#" class="text-xl font-bold">Admin</a>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <button class="text-white">
                        <i class="fas fa-bell"></i>
                        </button>
                        <span class="absolute -top-1 -right-2 bg-red-500 text-xs px-1.5 rounded-full">3</span>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <main class="flex items-center justify-center w-full px-4">
        @yield('content')
    </main>

</body>
</html>
