@extends('partner.master')
@section('title', 'Deals')
@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg p-5 border border-gray-200 shadow-sm">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <div>
                <h1 class="text-xl font-semibold text-gray-800">Deals</h1>
                <p class="text-gray-500 text-sm">Create and manage special offers</p>
            </div>
            <a href="{{ route('partner.deals.create') }}" class="bg-[#1F8FB2] text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-[#1a7a99] transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Create Deal
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
        {{ session('success') }}
    </div>
    @endif

    <!-- Deals Table -->
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left">Deal</th>
                        <th class="px-4 py-3 text-left">Property</th>
                        <th class="px-4 py-3 text-left">Discount</th>
                        <th class="px-4 py-3 text-left">Price</th>
                        <th class="px-4 py-3 text-left hidden md:table-cell">Period</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($deals as $deal)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">
                            <div class="font-medium text-gray-900">{{ $deal->title }}</div>
                            <div class="text-xs text-gray-500">{{ Str::limit($deal->description, 40) }}</div>
                        </td>
                        <td class="px-4 py-3 text-gray-700">{{ $deal->property->title }}</td>
                        <td class="px-4 py-3">
                            <span class="bg-red-100 text-red-700 px-2 py-0.5 rounded text-xs font-medium">
                                {{ $deal->discount_percentage }}% OFF
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-xs text-gray-400 line-through">${{ number_format($deal->original_price, 2) }}</div>
                            <div class="font-medium text-green-600">${{ number_format($deal->discounted_price, 2) }}</div>
                        </td>
                        <td class="px-4 py-3 text-gray-600 hidden md:table-cell text-xs">
                            {{ $deal->start_date->format('M d') }} - {{ $deal->end_date->format('M d, Y') }}
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 rounded text-xs font-medium {{ $deal->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                {{ ucfirst($deal->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2 text-xs">
                                <a href="{{ route('partner.deals.edit', $deal) }}" class="text-[#1F8FB2] hover:underline">Edit</a>
                                <form action="{{ route('partner.deals.toggle-status', $deal) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-yellow-600 hover:underline">
                                        {{ $deal->status === 'active' ? 'Pause' : 'Activate' }}
                                    </button>
                                </form>
                                <form action="{{ route('partner.deals.destroy', $deal) }}" method="POST" class="inline" onsubmit="return confirm('Delete this deal?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-400">
                            No deals yet. <a href="{{ route('partner.deals.create') }}" class="text-[#1F8FB2] hover:underline">Create your first deal</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($deals->hasPages())
    <div class="flex justify-center">
        {{ $deals->links() }}
    </div>
    @endif
</div>
@endsection
