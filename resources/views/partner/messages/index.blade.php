@extends('partner.master')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-2xl p-8 text-white">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-4xl font-bold mb-2">Messages</h1>
                <p class="text-purple-100 text-lg">Communicate with your guests efficiently</p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="bg-white/20 px-4 py-2 rounded-xl">
                    <span class="text-sm font-medium">{{ $unreadCount }} Unread</span>
                </div>
                <button class="bg-white text-purple-600 px-4 py-2 rounded-xl font-semibold hover:bg-purple-50 transition-colors duration-200">
                    <i class="fas fa-search mr-2"></i>Search
                </button>
            </div>
        </div>
    </div>

    <!-- Messages Interface -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 h-[600px]">
        <!-- Conversations List -->
        <div class="lg:col-span-1 bg-white rounded-2xl shadow-lg border border-gray-100 flex flex-col">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-800">Conversations</h2>
                <p class="text-sm text-gray-600 mt-1">Recent messages</p>
            </div>
            <div class="flex-1 overflow-y-auto p-4 space-y-3">
                @forelse($conversations as $conversation)
                <div class="p-4 border {{ $loop->first ? 'border-purple-200 bg-purple-50' : 'border-gray-200' }} rounded-xl cursor-pointer hover:bg-gray-50 transition-colors duration-200">
                    <div class="flex items-start space-x-3">
                        <div class="h-10 w-10 bg-{{ $loop->first ? 'purple' : 'blue' }}-500 rounded-full flex items-center justify-center">
                            <span class="text-white font-semibold text-sm">{{ substr($conversation['guest_name'], 0, 2) }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start">
                                <h3 class="font-semibold text-gray-900 truncate">{{ $conversation['guest_name'] }}</h3>
                                <span class="text-xs text-gray-500">{{ $conversation['time_ago'] }}</span>
                            </div>
                            <p class="text-sm text-gray-600 truncate">{{ $conversation['property_name'] }}</p>
                            <p class="text-xs text-gray-500 mt-1 truncate">{{ $conversation['last_message'] }}</p>
                        </div>
                        @if($conversation['unread'] > 0)
                        <div class="bg-red-500 h-2 w-2 rounded-full"></div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <i class="fas fa-comments text-gray-300 text-4xl mb-4"></i>
                    <p class="text-gray-500">No conversations yet</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Chat Area -->
        <div class="lg:col-span-3 bg-white rounded-2xl shadow-lg border border-gray-100 flex flex-col">
            <!-- Chat Header -->
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="h-12 w-12 bg-purple-500 rounded-full flex items-center justify-center">
                            <span class="text-white font-bold">SJ</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Sarah Johnson</h3>
                            <p class="text-sm text-gray-600">Ocean View Apartment - Booking #BK10234</p>
                            <p class="text-xs text-green-600 flex items-center mt-1">
                                <div class="h-2 w-2 bg-green-500 rounded-full mr-2"></div>
                                Online now
                            </p>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <button class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                            <i class="fas fa-phone"></i>
                        </button>
                        <button class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                            <i class="fas fa-video"></i>
                        </button>
                        <button class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Messages -->
            <div class="flex-1 overflow-y-auto p-6 space-y-4 bg-gray-50">
                <div class="flex items-start space-x-3">
                    <div class="h-8 w-8 bg-purple-500 rounded-full flex items-center justify-center">
                        <span class="text-white font-semibold text-xs">SJ</span>
                    </div>
                    <div class="bg-white p-4 rounded-2xl rounded-tl-lg shadow-sm max-w-xs">
                        <p class="text-sm text-gray-800">Hi! What time is check-in for tomorrow?</p>
                        <span class="text-xs text-gray-500 mt-2 block">2h ago</span>
                    </div>
                </div>

                <div class="flex justify-end">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white p-4 rounded-2xl rounded-tr-lg shadow-sm max-w-xs">
                        <p class="text-sm">Check-in is from 3:00 PM onwards. I'll be available to meet you at the property.</p>
                        <span class="text-xs text-purple-200 mt-2 block">1h ago</span>
                    </div>
                </div>

                <div class="flex items-start space-x-3">
                    <div class="h-8 w-8 bg-purple-500 rounded-full flex items-center justify-center">
                        <span class="text-white font-semibold text-xs">SJ</span>
                    </div>
                    <div class="bg-white p-4 rounded-2xl rounded-tl-lg shadow-sm max-w-xs">
                        <p class="text-sm text-gray-800">Perfect! Should I call you when I arrive?</p>
                        <span class="text-xs text-gray-500 mt-2 block">30m ago</span>
                    </div>
                </div>

                <div class="flex justify-end">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white p-4 rounded-2xl rounded-tr-lg shadow-sm max-w-xs">
                        <p class="text-sm">Yes, please call me at +1 234 567 8900. Looking forward to hosting you!</p>
                        <span class="text-xs text-purple-200 mt-2 block">Just now</span>
                    </div>
                </div>
            </div>

            <!-- Message Input -->
            <div class="p-6 border-t border-gray-100">
                <div class="flex items-center space-x-4">
                    <button class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                        <i class="fas fa-paperclip"></i>
                    </button>
                    <div class="flex-1 relative">
                        <input type="text" placeholder="Type your message..." class="w-full border border-gray-300 rounded-xl px-4 py-3 pr-12 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <button class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-smile"></i>
                        </button>
                    </div>
                    <button class="bg-gradient-to-r from-purple-500 to-purple-600 text-white p-3 rounded-xl hover:from-purple-600 hover:to-purple-700 transition-all duration-200 shadow-lg">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
