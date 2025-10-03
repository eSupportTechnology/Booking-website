<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Laravel App')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>


    {{-- Google Fonts: Lato --}}
   <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

   <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">

    {{-- Tailwind CSS via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class=" text-gray-900" style="font-family: 'Poppins', sans-serif;">
  <!-- Include Header -->
  @include('Customer.header')
@stack('styles')
   <!-- Content Section -->
    <div id="content">
        @yield('content')
    </div>


@stack('scripts')
@include('Customer.footer')
</body>

</html>
