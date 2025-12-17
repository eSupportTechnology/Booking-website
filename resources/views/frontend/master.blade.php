<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'My Laravel App')</title>
  <script src="https://cdn.tailwindcss.com"></script>


  {{-- Google Fonts: Lato --}}
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">

  {{-- Tailwind CSS via Vite --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class=" text-gray-900" style="font-family: 'Poppins', sans-serif;">
  <!-- Include Header -->
  @include('frontend.header')

  <!-- Content Section -->
  <div id="content">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
      @if(session('success'))
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Success!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
      </div>
      @endif

      @if(session('error'))
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Error!</strong>
        <span class="block sm:inline">{{ session('error') }}</span>
      </div>
      @endif

      @if($errors->any())
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Whoops!</strong>
        <ul class="list-disc list-inside">
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif
    </div>
    @yield('content')
  </div>




  

  <!-- Footers -->
    @auth('customer')
        @include('customer.footer')   {{-- Logged-in customer FIRST --}}
    @else
        @include('frontend.footer')   {{-- Guest --}}
    @endauth



</body>

</html>
