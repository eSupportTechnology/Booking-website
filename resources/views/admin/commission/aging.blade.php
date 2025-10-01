@extends('admin.master')

@section('content')
<div class="p-6 bg-white rounded shadow">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-[#1F8FB2]">📊 Commission Aging Report</h2>
        <div class="space-x-2">
            <form action="{{ route('admin.commission.generate') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Generate Invoices
                </button>
            </form>
            <form action="{{ route('admin.commission.deactivate') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700"
                        onclick="return confirm('Deactivate properties for overdue partners?')">
                    Deactivate Overdue
                </button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Partner</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">0-15 Days</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">16-30 Days</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">31-45 Days</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">46+ Days</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($report as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $item['partner_name'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $item['partner_email'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-red-600">
                            ${{ number_format($item['total_amount'], 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            ${{ number_format($item['buckets']['0-15'], 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-yellow-600">
                            ${{ number_format($item['buckets']['16-30'], 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-orange-600">
                            ${{ number_format($item['buckets']['31-45'], 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600 font-semibold">
                            ${{ number_format($item['buckets']['46+'], 2) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            No pending commissions found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection