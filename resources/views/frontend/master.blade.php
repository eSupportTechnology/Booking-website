<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Laravel App')</title>

    {{-- Google Fonts: Lato --}}
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">

    {{-- Tailwind CSS via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="font-sans bg-gray-100 text-gray-900">
  <!-- Include Header -->
  @include('frontend.Header')

   <!-- Content Section -->
    <div id="content">
        @yield('content')
    </div>

   
   

</body>

</html>
