<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', config('app.name', 'My Laravel App'))</title>
  <script src="https://cdn.tailwindcss.com"></script>

  {{-- Google Fonts --}}
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

  {{-- Tailwind CSS via Vite --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  {{-- Stack for additional styles --}}
  @stack('styles')
</head>

<body class=" text-gray-900" style="font-family: 'Poppins', sans-serif;">
  <!-- Include Header -->
  @include('frontend.header')

  <!-- Content Section -->
  <div id="content">
    @yield('content')
  </div>




  

  <!-- Footers -->
  @auth('customer')
      @include('Customer.footer')   {{-- Logged-in customer --}}
  @else
      @include('frontend.footer')   {{-- Guest --}}
  @endauth

  {{-- Stack for additional scripts --}}
  @stack('scripts')
</body>

</html>
