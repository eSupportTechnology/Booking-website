@extends('frontend.user-master')

@section('content')
{{-- Navigation Bar --}}
<section class="text-white py-8 bg-[#1F8FB2] relative z-0">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
   
  </div>
</section>
<!-- Search Box: Overlapping both sections -->
<div class="relative z-10 -mt-8 px-4">
  <!-- Alpine.js CDN (Required for Dropdowns) -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<form method="GET" class="bg-white rounded-xl px-2 py-1 shadow-lg flex flex-col md:flex-row items-center gap-1 md:gap-0 border-4 border-yellow-400 max-w-6xl mx-auto overflow-visible text-sm">

    <!-- Destination Selector (Styled Like Guests) -->
    <div x-data="{ open: false, destination: '' }" class="relative px-2 py-1 flex-1 border-r md:border-r border-gray-500">
        <button @click="open = !open" type="button" class="flex items-center gap-2 w-full text-left text-sm">
           <img src="{{ asset('assets/stay.svg') }}" alt="Stay" class="w-6 h-6" style="filter: brightness(0) saturate(100%);" />

                <path d="M10 2a6 6 0 00-6 6c0 4.25 6 10 6 10s6-5.75 6-10a6 6 0 00-6-6zm0 8a2 2 0 110-4 2 2 0 010 4z" />
            </svg>
            <span x-text="destination || 'Where are you going?'" style="font-family: 'Noto Sans', sans-serif;" class="text-gray-800 truncate text-base"></span>
        </button>

        <!-- Dropdown Box -->
        <div x-show="open" @click.away="open = false" class="absolute z-20 bg-white shadow-xl rounded-xl p-4 mt-2 w-72 right-0 text-gray-800 space-y-2 text-sm">
            <template x-for="city in ['New York', 'Los Angeles', 'London', 'Paris', 'Tokyo']" :key="city">
                <button type="button" @click="destination = city; open = false" class="block w-full text-left px-3 py-2 hover:bg-gray-100 rounded">
                    <span x-text="city"></span>
                </button>
            </template>
        </div>

        <!-- Hidden field to submit the selected destination -->
        <input type="hidden" name="destination" :value="destination">
    </div>

   <!-- Dates Selector -->
<!-- Include Alpine.js if not already -->
<!-- Include Alpine.js -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<!-- Dropdown with two sections: Check-in/out & Flexible -->
<div x-data="{ open: false, activeTab: 'check', checkIn: '', checkOut: '', flexibleOption: '' }" class="relative flex-1 border-t md:border-t-0 md:border-r border-gray-500 px-2 py-1">
  
  <!-- Dropdown Trigger Button -->
  <button @click="open = !open" type="button" class="flex items-center gap-2 w-full text-left text-sm">
    <img src="{{ asset('assets/calender.svg') }}" alt="Calendar" class="w-5 h-5" />
    <span class="text-gray-800 truncate">
      <template x-if="activeTab === 'check'">
        <span><span x-text="checkIn ? checkIn : 'Check-in'" style="font-family: 'Noto Sans', sans-serif;" class="text-base"></span> — <span x-text="checkOut ? checkOut : 'Check-out'" style="font-family: 'Noto Sans', sans-serif;" class="text-base"></span></span>
      </template>
      <template x-if="activeTab === 'flexible'">
        <span x-text="flexibleOption ? flexibleOption : 'Flexible dates'"></span>
      </template>
    </span>
  </button>

  <!-- Dropdown Content -->
  <div
    x-show="open"
    @click.away="open = false"
    class="absolute z-30 bg-white shadow-xl rounded-xl p-4 mt-2 w-96 right-0 text-gray-800 text-sm"
    x-transition
  >
    <!-- Tabs -->
    <nav class="flex border-b border-gray-200 mb-4">
      <button
        @click.prevent="activeTab = 'check'"
        :class="activeTab === 'check' ? 'border-blue-600 text-blue-600' : 'text-gray-500'"
        class="px-4 py-2 border-b-2 font-semibold focus:outline-none"
      >
        Check-in / Check-out
      </button>
      <button
        @click.prevent="activeTab = 'flexible'"
        :class="activeTab === 'flexible' ? 'border-blue-600 text-blue-600' : 'text-gray-500'"
        class="px-4 py-2 border-b-2 font-semibold focus:outline-none"
      >
        Flexible dates
      </button>
    </nav>

    <!-- Check-in / Check-out Section -->
    <div x-show="activeTab === 'check'" x-transition>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-xs text-gray-500 font-semibold mb-1">Check-in Date</label>
          <input
            type="date"
            x-model="checkIn"
            class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none"
            placeholder="Check-in"
          />
        </div>
        <div>
          <label class="block text-xs text-gray-500 font-semibold mb-1">Check-out Date</label>
          <input
            type="date"
            x-model="checkOut"
            class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none"
            placeholder="Check-out"
          />
        </div>
      </div>
    </div>

    <!-- Flexible Dates Section -->
    <div x-show="activeTab === 'flexible'" x-transition>
      <label class="block text-xs text-gray-500 font-semibold mb-1">Select Flexible Dates</label>
      <select
        x-model="flexibleOption"
        class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none"
      >
        <option value="" disabled>Select option</option>
        <option value="Weekend Getaway">Weekend Getaway</option>
        <option value="Next Month">Next Month</option>
        <option value="Anytime">Anytime</option>
        <option value="Custom Range">Custom Range</option>
      </select>
    </div>

    <!-- Done Button -->
    <div class="mt-4 text-right">
      <button
        @click="open = false"
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm"
      >
        Done
      </button>
    </div>
  </div>
</div>




    <!-- Guests Selector -->
    <div x-data="{ open: false, adults: 2, children: 0, rooms: 1, pets: false }" class="relative px-2 py-1 flex-1 border-t md:border-t-0 md:border-r border-gray-500">
        <button @click="open = !open" type="button" class="flex items-center gap-2 w-full text-left text-sm">
                <img src="{{ asset('assets/user.svg') }}" alt="Calendar" class="w-5 h-5" />
            <span x-text="`${adults} adults · ${children} children · ${rooms} room${rooms > 1 ? 's' : ''}`" class="text-gray-800 text-base truncate" style="font-family: 'Noto Sans', sans-serif;"></span>
        </button>

        <!-- Guest Dropdown -->
        <div x-show="open" @click.away="open = false" class="absolute z-20 bg-white shadow-xl rounded-xl p-4 mt-2 w-72 right-0 text-gray-800 space-y-4 text-sm">
            <!-- Adults -->
            <div class="flex items-center justify-between">
                <span style="font-family: 'Noto Sans', sans-serif;">Adults</span>
                <div class="flex items-center gap-2">
                    <button type="button" @click="if(adults > 1) adults--" class="px-2 py-1 bg-gray-200 rounded" style="font-family: 'Noto Sans', sans-serif;">−</button>
                    <span x-text="adults"></span>
                    <button type="button" @click="adults++" class="px-2 py-1 bg-gray-200 rounded" style="font-family: 'Noto Sans', sans-serif;">+</button>
                </div>
            </div>

            <!-- Children -->
            <div class="flex items-center justify-between">
                <span>Children</span>
                <div class="flex items-center gap-2">
                    <button type="button" @click="if(children > 0) children--" class="px-2 py-1 bg-gray-200 rounded">−</button>
                    <span x-text="children"></span>
                    <button type="button" @click="children++" class="px-2 py-1 bg-gray-200 rounded">+</button>
                </div>
            </div>

            <!-- Rooms -->
            <div class="flex items-center justify-between">
                <span>Rooms</span>
                <div class="flex items-center gap-2">
                    <button type="button" @click="if(rooms > 1) rooms--" class="px-2 py-1 bg-gray-200 rounded">−</button>
                    <span x-text="rooms"></span>
                    <button type="button" @click="rooms++" class="px-2 py-1 bg-gray-200 rounded">+</button>
                </div>
            </div>

            <!-- Pets Toggle -->
            <div class="flex items-center justify-between">
                <span>Travelling with pets?</span>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" x-model="pets" class="sr-only peer">
                    <div class="w-10 h-6 bg-gray-300 rounded-full peer peer-checked:bg-blue-600 relative transition-all">
                        <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-all peer-checked:translate-x-4"></div>
                    </div>
                </label>
            </div>

            <p class="text-xs text-gray-500">
                Assistance animals aren’t considered pets.<br>
                <a href="#" class="text-blue-600 underline">Read more about travelling with assistance animals</a>
            </p>

            <!-- Done Button -->
            <button type="button" @click="open = false" class="block w-full text-center bg-white border border-blue-600 text-blue-600 font-semibold py-2 rounded hover:bg-blue-50">
                Done
            </button>
        </div>
    </div>

    <!-- Search Button -->
    <div class="px-2 py-1">
        <button type="submit" class="w-full md:w-auto h-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg text-sm" style="background-color:#3CC0E9;">
            Search
        </button>
    </div>
</form>


</div>



<!-- AlpineJS -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>


<div class="border-b sticky top-0 bg-white z-50">
    <div class="max-w-6xl mx-auto flex space-x-6 overflow-x-auto text-sm md:text-base whitespace-nowrap px-4 py-2">
        <a href="#overview" class="scroll-link">Overview</a>
        <a href="#info" class="scroll-link">Villa info & price</a>
        <a href="#facilities" class="scroll-link">Facilities</a>
        <a href="#rules" class="scroll-link">House rules</a>
        <a href="#fineprint" class="scroll-link">The fine print</a>
        <a href="#reviews" class="scroll-link">Guest reviews (745)</a>
    </div>
</div>

{{-- Page Sections --}}
<section id="overview" class="min-h-screen p-6 bg-gray-50">
    <h2 class="text-xl font-bold mb-4">Overview</h2>
</section>
<section id="info" class="min-h-screen p-6 bg-white">
    <h2 class="text-xl font-bold mb-4">Villa info & price</h2>
</section>
<section id="facilities" class="min-h-screen p-6 bg-gray-50">
    <h2 class="text-xl font-bold mb-4">Facilities</h2>
</section>
<section id="rules" class="min-h-screen p-6 bg-white">
    <h2 class="text-xl font-bold mb-4">House rules</h2>
</section>
<section id="fineprint" class="min-h-screen p-6 bg-gray-50">
    <h2 class="text-xl font-bold mb-4">The fine print</h2>
</section>
<section id="reviews" class="min-h-screen p-6 bg-white">
    <h2 class="text-xl font-bold mb-4">Guest reviews</h2>
</section>
@endsection
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const links = document.querySelectorAll("a.scroll-link");
        const sections = document.querySelectorAll("section");

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    links.forEach(link => {
                        link.classList.remove("border-b-2", "border-blue-500", "text-blue-600", "font-semibold");
                        if (link.getAttribute("href") === `#${entry.target.id}`) {
                            link.classList.add("border-b-2", "border-blue-500", "text-blue-600", "font-semibold");
                        }
                    });
                }
            });
        }, { threshold: 0.6 });

        sections.forEach(section => observer.observe(section));

        links.forEach(link => {
            link.addEventListener("click", (e) => {
                e.preventDefault();
                const target = document.querySelector(link.getAttribute("href"));
                target.scrollIntoView({ behavior: "smooth" });
            });
        });
    });
</script>
