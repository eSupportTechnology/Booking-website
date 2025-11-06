@extends('admin.master')

@section('content')
<div class="space-y-6 px-3 sm:px-6">
    <h1 class="text-2xl font-semibold text-gray-800">Commission Aging Report</h1>

    <!-- Filters -->
    <div class="bg-white p-6 rounded-lg shadow">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Date From</label>
                <input type="date" name="date_from" value="{{ $dateFrom }}" class="mt-1 block w-full rounded-md border-gray-300">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Date To</label>
                <input type="date" name="date_to" value="{{ $dateTo }}" class="mt-1 block w-full rounded-md border-gray-300">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Partner</label>
                <select name="partner_id" class="mt-1 block w-full rounded-md border-gray-300">
                    <option value="">All Partners</option>
                    @foreach($partners as $partner)
                        <option value="{{ $partner['id'] }}" {{ $partnerId == $partner['id'] ? 'selected' : '' }}>
                            {{ $partner['first_name'] }} {{ $partner['last_name'] }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-3">
                <button type="submit" class="text-white px-4 py-2 rounded hover:opacity-90" style="background-color:#1F8FB2;">
                    Apply Filters
                </button>
            </div>
        </form>
    </div>

    <!-- Commission Aging Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-medium">Commission Aging ({{ number_format($commissionRate * 100, 1) }}% Commission Rate) - USD</h3>
            <p class="text-sm text-gray-600">Commissions become invoiceable 15 days after booking date</p>
            <p class="text-xs text-gray-500">All amounts converted to USD for consistency</p>
            <p class="text-xs text-gray-500 mt-1">
                <i class="fas fa-info-circle"></i> 
                To change the commission rate, go to 
                <a href="{{ route('admin.settings') }}" class="text-[#1F8FB2] hover:underline">Admin Settings</a>
            </p>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-gray-700">Partner Name</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-700">Invoice Number</th>
                        <th class="px-4 py-3 text-right font-medium text-gray-700">Total Amount (USD)</th>
                        <th class="px-4 py-3 text-right font-medium text-gray-700">0-15 Days (USD)</th>
                        <th class="px-4 py-3 text-right font-medium text-gray-700">16-30 Days (USD)</th>
                        <th class="px-4 py-3 text-right font-medium text-gray-700">31-45 Days (USD)</th>
                        <th class="px-4 py-3 text-right font-medium text-gray-700">46-60 Days (USD)</th>
                        <th class="px-4 py-3 text-right font-medium text-gray-700">61-75 Days (USD)</th>
                        <th class="px-4 py-3 text-right font-medium text-gray-700">75+ Days (USD)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($commissionData as $data)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <div>
                                    <div class="font-medium text-gray-900">{{ $data['partner_name'] }}</div>
                                    <div class="text-sm text-gray-500">{{ $data['partner_email'] }}</div>
                                </div>
                            </td>
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $data['invoice_number'] }}</td>
                            <td class="px-4 py-3 text-right font-semibold text-gray-900">${{ number_format($data['total_amount'], 2) }}</td>
                            <td class="px-4 py-3 text-right">${{ number_format($data['buckets']['0-15'], 2) }}</td>
                            <td class="px-4 py-3 text-right">${{ number_format($data['buckets']['16-30'], 2) }}</td>
                            <td class="px-4 py-3 text-right">${{ number_format($data['buckets']['31-45'], 2) }}</td>
                            <td class="px-4 py-3 text-right">${{ number_format($data['buckets']['46-60'], 2) }}</td>
                            <td class="px-4 py-3 text-right">${{ number_format($data['buckets']['61-75'], 2) }}</td>
                            <td class="px-4 py-3 text-right">${{ number_format($data['buckets']['75+'], 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-8 text-center text-gray-500">No commission data found for the selected period.</td>
                        </tr>
                    @endforelse
                    
                    @if(count($commissionData) > 0)
                        <tr class="bg-gray-50 font-semibold">
                            <td class="px-4 py-3" colspan="2">TOTAL</td>
                            <td class="px-4 py-3 text-right">${{ number_format($totals['total_amount'], 2) }}</td>
                            <td class="px-4 py-3 text-right">${{ number_format($totals['buckets']['0-15'], 2) }}</td>
                            <td class="px-4 py-3 text-right">${{ number_format($totals['buckets']['16-30'], 2) }}</td>
                            <td class="px-4 py-3 text-right">${{ number_format($totals['buckets']['31-45'], 2) }}</td>
                            <td class="px-4 py-3 text-right">${{ number_format($totals['buckets']['46-60'], 2) }}</td>
                            <td class="px-4 py-3 text-right">${{ number_format($totals['buckets']['61-75'], 2) }}</td>
                            <td class="px-4 py-3 text-right">${{ number_format($totals['buckets']['75+'], 2) }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
        <div class="bg-white p-4 rounded-lg shadow border-l-4 border-green-500">
            <h3 class="text-xs text-gray-500">0-15 Days (USD)</h3>
            <p class="text-lg font-bold text-gray-800">${{ number_format($totals['buckets']['0-15'], 2) }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow border-l-4 border-yellow-500">
            <h3 class="text-xs text-gray-500">16-30 Days (USD)</h3>
            <p class="text-lg font-bold text-gray-800">${{ number_format($totals['buckets']['16-30'], 2) }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow border-l-4 border-orange-500">
            <h3 class="text-xs text-gray-500">31-45 Days (USD)</h3>
            <p class="text-lg font-bold text-gray-800">${{ number_format($totals['buckets']['31-45'], 2) }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow border-l-4 border-red-500">
            <h3 class="text-xs text-gray-500">46-60 Days (USD)</h3>
            <p class="text-lg font-bold text-gray-800">${{ number_format($totals['buckets']['46-60'], 2) }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow border-l-4 border-purple-500">
            <h3 class="text-xs text-gray-500">61-75 Days (USD)</h3>
            <p class="text-lg font-bold text-gray-800">${{ number_format($totals['buckets']['61-75'], 2) }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow border-l-4 border-gray-500">
            <h3 class="text-xs text-gray-500">75+ Days (USD)</h3>
            <p class="text-lg font-bold text-gray-800">${{ number_format($totals['buckets']['75+'], 2) }}</p>
        </div>
    </div>
</div>
@endsection