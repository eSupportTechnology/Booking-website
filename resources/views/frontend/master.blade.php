<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Laravel App')</title>
      <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">

    {{-- Google Fonts: Lato --}}
   <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

   <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">

    {{-- Tailwind CSS via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class=" text-gray-900" style="font-family: 'Poppins', sans-serif;">
  <!-- Include Header -->
  @include('frontend.Header')

   <!-- Content Section -->
    <div id="content">
        @yield('content')
    </div>

   
   
@include('frontend.footer')
</body>

</html>
