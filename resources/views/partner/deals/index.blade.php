@extends('partner.master')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">My Deals</h1>
        <a href="{{ route('partner.deals.create') }}" class="bg-[#1F8FB2] text-white px-4 py-2 rounded-lg hover:bg-[#3CC0E9] transition">
            <i class="fas fa-plus mr-2"></i>Create Deal
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Deal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Property</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Discount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Period</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($deals as $deal)
                <tr>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">{{ $deal->title }}</div>
                        <div class="text-sm text-gray-500">{{ Str::limit($deal->description, 50) }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $deal->property->title }}</td>
                    <td class="px-6 py-4">
                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-sm font-medium">
                            {{ $deal->discount_percentage }}% OFF
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm line-through text-gray-500">${{ number_format($deal->original_price, 2) }}</div>
                        <div class="font-medium text-green-600">${{ number_format($deal->discounted_price, 2) }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        {{ $deal->start_date->format('M d') }} - {{ $deal->end_date->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $deal->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($deal->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <div class="flex space-x-2">
                            <a href="{{ route('partner.deals.edit', $deal) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                            <form action="{{ route('partner.deals.toggle-status', $deal) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-yellow-600 hover:text-yellow-900">
                                    {{ $deal->status === 'active' ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                            <form action="{{ route('partner.deals.destroy', $deal) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                        No deals found. <a href="{{ route('partner.deals.create') }}" class="text-blue-600">Create your first deal</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $deals->links() }}
</div>
@endsection