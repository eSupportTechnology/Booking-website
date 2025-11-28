@extends('partner.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Payouts & Earnings</h1>
        <p class="text-gray-600 mt-2">Track your earnings and payout history</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Pending Payouts</p>
                    <p class="text-3xl font-bold mt-1">${{ number_format($stats['pending_amount'], 2) }}</p>
                    <p class="text-xs mt-2 opacity-75">{{ $stats['pending_count'] }} payout(s)</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-blue-400 to-blue-500 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Processing</p>
                    <p class="text-3xl font-bold mt-1">${{ number_format($stats['processing_amount'], 2) }}</p>
                    <p class="text-xs mt-2 opacity-75">Being processed</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-400 to-green-500 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Paid This Month</p>
                    <p class="text-3xl font-bold mt-1">${{ number_format($stats['completed_this_month'], 2) }}</p>
                    <p class="text-xs mt-2 opacity-75">{{ now()->format('F Y') }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-400 to-purple-500 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Total Earned</p>
                    <p class="text-3xl font-bold mt-1">${{ number_format($stats['total_earned'], 2) }}</p>
                    <p class="text-xs mt-2 opacity-75">All time</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Payout History -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Payout History</h2>
            <div class="text-sm text-gray-500">
                All amounts shown are net earnings (after commission)
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Booking</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Property</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Guest</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Method</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ref</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($payouts as $payout)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ $payout->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <span class="text-blue-600 font-medium">#{{ $payout->booking_id }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ $payout->booking->property->title ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $payout->booking->user->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-semibold text-gray-900">
                                ${{ number_format($payout->amount, 2) }}
                            </div>
                            @if($payout->booking)
                            <div class="text-xs text-gray-500">
                                Gross: ${{ number_format($payout->booking->total_price, 2) }}
                            </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($payout->payout_status === 'completed')
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 font-medium">
                                ✓ Paid
                            </span>
                            @elseif($payout->payout_status === 'processing')
                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 font-medium">
                                ⟳ Processing
                            </span>
                            @elseif($payout->payout_status === 'pending')
                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 font-medium">
                                ⏱ Pending
                            </span>
                            @else
                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800 font-medium">
                                ✗ Failed
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ ucfirst($payout->payout_method ?? 'N/A') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $payout->transaction_reference ?? '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <p class="text-lg font-medium">No payouts yet</p>
                                <p class="text-sm mt-1">Payouts will appear here once you receive bookings</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($payouts->hasPages())
        <div class="p-4 border-t border-gray-200">
            {{ $payouts->links() }}
        </div>
        @endif
    </div>

    <!-- Info Box -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div class="text-sm text-blue-800">
                <p class="font-semibold mb-1">About Payouts</p>
                <ul class="list-disc list-inside space-y-1 text-blue-700">
                    <li>Payouts are created automatically when customers book your properties</li>
                    <li>The platform deducts a 10% commission from the booking total</li>
                    <li>You receive 90% of the booking amount as your payout</li>
                    <li>Payouts are processed by admin and paid via your selected method (PayPal/Bank)</li>
                    <li>Status changes: Pending → Processing → Completed</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection