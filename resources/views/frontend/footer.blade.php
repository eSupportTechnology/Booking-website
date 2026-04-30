<!-- Guest Footer -->
<footer class="bg-gray-100 text-gray-600 py-10 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Footer Links -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 text-center md:text-left">

            <!-- Column 1: Support -->
            <div>
                <h3 class="text-lg font-bold mb-3 text-gray-900">Support</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('help.center') }}" class="text-gray-500 hover:text-[#1F8FB2] transition-colors">Manage your Trips</a></li>
                    <li><a href="{{ route('help.center') }}" class="text-gray-500 hover:text-[#1F8FB2] transition-colors">Contact Customer Service</a></li>
                    <li><a href="{{ route('safety.resource.center') }}" class="text-gray-500 hover:text-[#1F8FB2] transition-colors">Safety Resource Center</a></li>
                </ul>
            </div>

            <!-- Column 2: Discover -->
            <div>
                <h3 class="text-lg font-bold mb-3 text-gray-900">Discover</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-500 hover:text-[#1F8FB2] transition-colors">Genius Loyalty Program</a></li>
                    <li><a href="#" class="text-gray-500 hover:text-[#1F8FB2] transition-colors">Seasonal & Holiday Deals</a></li>
                    <li><a href="#" class="text-gray-500 hover:text-[#1F8FB2] transition-colors">Travel Articles</a></li>
                    <li><a href="#" class="text-gray-500 hover:text-[#1F8FB2] transition-colors">{{ config('domains.app_name') }} for Business</a></li>
                    <li><a href="#" class="text-gray-500 hover:text-[#1F8FB2] transition-colors">{{ config('domains.app_name') }} for Travel Agents</a></li>
                </ul>
            </div>

            <!-- Column 3: Terms and settings -->
            <div>
                <h3 class="text-lg font-bold mb-3 text-gray-900">Terms & Settings</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-500 hover:text-[#1F8FB2] transition-colors">Privacy & Cookies</a></li>
                    <li><a href="#" class="text-gray-500 hover:text-[#1F8FB2] transition-colors">Terms & Conditions</a></li>
                    <li><a href="#" class="text-gray-500 hover:text-[#1F8FB2] transition-colors">Partner Dispute</a></li>
                    <li><a href="#" class="text-gray-500 hover:text-[#1F8FB2] transition-colors">Human Rights Statement</a></li>
                </ul>
            </div>

            <!-- Column 4: About -->
            <div>
                <h3 class="text-lg font-bold mb-3 text-gray-900">About</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('about.booking') }}" class="text-gray-500 hover:text-[#1F8FB2] transition-colors">About {{ config('domains.app_name') }}</a></li>
                    <li><a href="{{ route('how.we.work') }}" class="text-gray-500 hover:text-[#1F8FB2] transition-colors">How We Work</a></li>
                    <li><a href="{{ route('sustainability') }}" class="text-gray-500 hover:text-[#1F8FB2] transition-colors">Sustainability</a></li>
                    <li><a href="#" class="text-gray-500 hover:text-[#1F8FB2] transition-colors">Careers</a></li>
                    <li><a href="#" class="text-gray-500 hover:text-[#1F8FB2] transition-colors">Investor Relations</a></li>
                    <li><a href="#" class="text-gray-500 hover:text-[#1F8FB2] transition-colors">Corporate Contact</a></li>
                </ul>
            </div>
        </div>

        <!-- Footer Separator -->
        <hr class="my-8 border-gray-300">

        <!-- Copyright and Branding -->
        <div class="text-center space-y-3">
            @php
                $host = config('domains.app_name');
            @endphp

            @if ($host == 'BookinTour')
                <p class="text-sm text-gray-600">
                    BookinTour.com is a part of JSG Ceylon (Pvt) Ltd, a growing leader and trusted partner in online travel and related services.
                </p>
            @elseif ($host == 'Inselor')
                <p class="text-sm text-gray-600">
                    Inselor.de is part of Inselor GmbH, providing trusted online travel and accommodation services.
                </p>
            @endif

            <p class="text-xs text-gray-500">
                Copyright &copy; {{ date('Y') }}. All rights reserved.
            </p>

            <a href="{{ url('/') }}" class="text-[#1F8FB2] font-semibold hover:underline">
                {{ config('domains.domain') }}
            </a>
        </div>
    </div>
</footer>
