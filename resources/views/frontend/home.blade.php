@extends('frontend.master')

@section('title', 'Home')

@section('content')

<!-- Hero Section -->
<div class="relative bg-cover bg-center" style="background-image: url('{{ asset('images/home.jpg') }}'); height: 700px;">
    <!-- Overlay with 43% black -->
    <div class="absolute inset-0" style="background-color: rgba(0, 72, 105, 0.43);"></div>
    <!-- Content -->
    <div class="relative z-10 flex flex-col items-center justify-center h-full text-white text-center">
    <!-- Title Section -->

    <h1 class="text-3xl md:text-4xl font-bold leading-snug" style="font-family: 'Lato', sans-serif; font-size:82px;margin-top:-200px;">
    Find Your Perfect Stay <br>
    <div class="mt-8 text-white">
    <img src="{{ asset('images/1.png') }}" alt="Image" class="inline-block  mr-2" style="height:75px;width:75px;">Quick 
        & <img src="{{ asset('images/2.png') }}" alt="Image" class="inline-block  ml-2" style="height:75px;width:75px;"> Easy!
    </div>
</h1>



    <!-- Search Box Section -->
    <div class="mt-4 grid grid-cols-1 md:grid-cols-5 gap-2 bg-white p-4 rounded text-black shadow-lg w-95% md:w-4/5">
        <input type="text" placeholder="Where are you going?" class="p-2 border rounded col-span-1 md:col-span-2">
        <input type="text" placeholder="Check-in date — Check-out date" class="p-2 border rounded col-span-1 md:col-span-1">
        <input type="text" placeholder="2 Adults . 0 Children . 1 Room" class="p-2 border rounded col-span-1 md:col-span-1">
        <button class="bg-cyan-600 text-white px-4 py-2 rounded col-span-1">Search</button>
    </div>
</div>


   
</div>



</div>

<!-- Offers Section-->
<section class="p-6 max-w-6xl mx-auto">
    <h2 class="text-xl font-semibold mb-4">Offers</h2>
    <div class="bg-blue-50 p-4 rounded flex items-center justify-between">
        <div>
            <p class="font-medium">Quick escape, quality time</p>
            <p class="text-sm text-gray-600">Save up to 20% with a Gateway Deal!</p>
        </div>
        <button class="bg-cyan-600 text-white px-4 py-2 rounded">Save on stays</button>
    </div>
</section>

<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Trending destinations</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            <!-- Large Destination Card -->
            <div class="sm:col-span-2 row-span-2 relative rounded overflow-hidden">
                <img src="/images/nuwara-eliya.jpg" alt="Nuwara Eliya" class="w-full h-full object-cover">
                <div class="absolute bottom-0 left-0 p-4 text-white bg-gradient-to-t from-black/60 to-transparent">
                    <h3 class="text-lg font-semibold">Nuwara Eliya</h3>
                    <p class="text-sm">Sri Lanka</p>
                </div>
            </div>

            <!-- Other Destination Cards -->
            <div class="relative rounded overflow-hidden">
                <img src="/images/colombo.jpg" alt="Colombo" class="w-full h-full object-cover">
                <div class="absolute bottom-0 left-0 p-4 text-white bg-gradient-to-t from-black/60 to-transparent">
                    <h3 class="text-base font-semibold">Colombo</h3>
                    <p class="text-sm">Sri Lanka</p>
                </div>
            </div>
            <div class="relative rounded overflow-hidden">
                <img src="/images/sigiriya.jpg" alt="Sigiriya" class="w-full h-full object-cover">
                <div class="absolute bottom-0 left-0 p-4 text-white bg-gradient-to-t from-black/60 to-transparent">
                    <h3 class="text-base font-semibold">Sigiriya</h3>
                    <p class="text-sm">Sri Lanka</p>
                </div>
            </div>
            <div class="relative rounded overflow-hidden">
                <img src="/images/ella.jpg" alt="Ella" class="w-full h-full object-cover">
                <div class="absolute bottom-0 left-0 p-4 text-white bg-gradient-to-t from-black/60 to-transparent">
                    <h3 class="text-base font-semibold">Ella</h3>
                    <p class="text-sm">Sri Lanka</p>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection
