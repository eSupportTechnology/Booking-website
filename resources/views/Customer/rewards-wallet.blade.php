@extends('frontend.master')

@section('content')
<div class="bg-gray-100 min-h-screen">
    <!-- Hero Section -->
    <div class="bg-[#0071C2] text-white py-12">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center gap-2 text-sm text-blue-200 mb-4">
                <a href="{{ route('customer.profile') }}" class="hover:text-white">My Account</a>
                <span>></span>
                <span class="text-white">Rewards & Wallet</span>
            </div>
            <h1 class="text-3xl font-bold mb-2">Rewards & Wallet</h1>
            <p class="text-blue-100">Save money on your next adventure with Bookintour.com</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Wallet Balance Card -->
        <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 -mt-16 relative z-10 mb-8">
            <div class="grid md:grid-cols-2 gap-8">
                <!-- Left: Balance -->
                <div class="flex items-center gap-6">
                    <div class="w-20 h-20 bg-gradient-to-br from-[#0071C2] to-[#003B95] rounded-2xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Wallet Balance</h2>
                        <p class="text-sm text-gray-500 mb-2">Includes all spendable rewards</p>
                        <p class="text-3xl font-bold text-[#0071C2]">
                            {{ $currencyService->formatPrice($walletData['balance'], $currency) }}
                        </p>
                    </div>
                </div>

                <!-- Right: Breakdown -->
                <div class="border-t md:border-t-0 md:border-l border-gray-200 pt-6 md:pt-0 md:pl-8">
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Credits</span>
                            <span class="font-semibold text-gray-900">{{ $currencyService->formatPrice($walletData['credits'], $currency) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Vouchers ({{ $walletData['voucher_count'] }})</span>
                            <span class="font-semibold text-gray-900">{{ $currencyService->formatPrice($walletData['vouchers'], $currency) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Pending Rewards</span>
                            <span class="font-semibold text-yellow-600">{{ $currencyService->formatPrice($walletData['pending_rewards'], $currency) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Coupon Code -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
            <h3 class="font-semibold text-gray-900 mb-4">Got a coupon code?</h3>
            <form action="{{ route('customer.rewards.coupon') }}" method="POST" class="flex gap-3">
                @csrf
                <input type="text"
                       name="coupon_code"
                       placeholder="Enter coupon code"
                       class="flex-1 border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#0071C2] focus:border-transparent">
                <button type="submit"
                        class="px-6 py-3 bg-[#0071C2] text-white rounded-lg font-medium hover:bg-[#005B9E] transition">
                    Apply
                </button>
            </form>
            @if(session('error'))
                <p class="text-red-500 text-sm mt-2">{{ session('error') }}</p>
            @endif
            @if(session('success'))
                <p class="text-green-500 text-sm mt-2">{{ session('success') }}</p>
            @endif
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
            <h3 class="font-semibold text-gray-900 mb-4">Recent Activity</h3>
            @if($recentActivity->count() > 0)
                <div class="space-y-4">
                    @foreach($recentActivity as $activity)
                        <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center
                                    {{ $activity['type'] === 'earned' ? 'bg-green-100' : 'bg-yellow-100' }}">
                                    @if($activity['type'] === 'earned')
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $activity['description'] }}</p>
                                    <p class="text-sm text-gray-500">{{ $activity['date']->format('M d, Y') }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold {{ $activity['type'] === 'earned' ? 'text-green-600' : 'text-yellow-600' }}">
                                    {{ $activity['type'] === 'earned' ? '+' : '' }}{{ $currencyService->formatPrice($activity['amount'], $currency) }}
                                </p>
                                <p class="text-xs text-gray-500">{{ ucfirst($activity['status']) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <p class="text-gray-500">No activity yet</p>
                    <p class="text-sm text-gray-400 mt-1">Complete bookings to earn rewards!</p>
                    <a href="{{ route('home-listing') }}" class="inline-block mt-4 px-4 py-2 bg-[#0071C2] text-white rounded-lg text-sm font-medium hover:bg-[#005B9E] transition">
                        Browse Properties
                    </a>
                </div>
            @endif
        </div>

        <!-- How it Works -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-semibold text-gray-900 mb-6">How Rewards & Wallet Works</h3>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="flex gap-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-[#0071C2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-1">Book and Earn Rewards</h4>
                        <p class="text-sm text-gray-600">Earn 1% cashback on every completed booking. Credits are automatically added to your wallet.</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-1">Track at a Glance</h4>
                        <p class="text-sm text-gray-600">Your Wallet keeps all rewards safe and shows your earnings and spending history.</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-1">Pay with Wallet</h4>
                        <p class="text-sm text-gray-600">Use your credits during checkout to save money on your next booking.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Summary -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-8">
            <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                <p class="text-3xl font-bold text-[#0071C2]">{{ $walletData['completed_bookings'] }}</p>
                <p class="text-sm text-gray-600 mt-1">Completed Bookings</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                <p class="text-3xl font-bold text-green-600">{{ $currencyService->formatPrice($walletData['total_earned'], $currency) }}</p>
                <p class="text-sm text-gray-600 mt-1">Total Earned</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                <p class="text-3xl font-bold text-gray-900">{{ $currencyService->formatPrice($walletData['total_spent'], $currency) }}</p>
                <p class="text-sm text-gray-600 mt-1">Total Spent</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                <p class="text-3xl font-bold text-[#0071C2]">{{ $currencyService->formatPrice($walletData['balance'], $currency) }}</p>
                <p class="text-sm text-gray-600 mt-1">Available Balance</p>
            </div>
        </div>
    </div>
</div>
@endsection
