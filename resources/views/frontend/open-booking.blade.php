<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookingtour</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite('resources/css/app.css') {{-- if using Laravel Vite --}}
</head>
<body class="bg-[#1595b2] flex items-center justify-center min-h-screen">

     @php
                            $host = config('domains.app_name');

                        @endphp

                       

    <div class="text-center px-4 sm:px-6 lg:px-8">
        @if ($host == 'BookinTour')  <h1 class="text-white text-2xl sm:text-3xl font-semibold mb-6">Bookintour.com</h1>@elseif ($host == 'Inselor')
                                <img src="{{ asset('images/inselor-logo.png') }}" alt="Inselor"
                                    class="h-12 w-auto align-middle" />
                            @endif
        
        <!-- Bed icon -->
        <div class="flex justify-center mb-6">
            <img src="{{ asset('assets/Vector (43).svg') }}" alt="Bed Icon" class="w-12 h-12">
        </div>

        <h2 class="text-white text-lg sm:text-xl font-medium mb-2">You're really there</h2>
        <p class="text-white text-sm opacity-80">Setting up your calendar</p>
    </div>

</body>
</html>
