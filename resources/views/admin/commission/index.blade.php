@extends('admin.master')

@section('content')
<div class="p-6 bg-white rounded shadow">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-[#1F8FB2]">💰 Commission Management</h2>
        <a href="{{ route('admin.settings') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 text-sm">
            ← Back to Settings
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Global Commission Rate Info -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
        <h3 class="text-lg font-semibold text-blue-800 mb-2">🌐 Global Commission Rate</h3>
        <p class="text-blue-700">
            Current global rate: <strong>{{ number_format($globalCommissionRate * 100, 2) }}%</strong>
        </p>
        <p class="text-sm text-blue-600 mt-1">
            This rate applies to all partners unless they have an individual rate set.
        </p>
    </div>

    <!-- Partners Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Partner</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Current Rate</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rate Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($partners as $partner)
                    @php
                        $individualRate = $partner->settings?->commission_rate;
                        $effectiveRate = $partner->getEffectiveCommissionRate();
                        $isIndividual = $individualRate !== null;
                    @endphp
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $partner->first_name }} {{ $partner->last_name }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $partner->user->email }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-semibold {{ $isIndividual ? 'text-blue-600' : 'text-gray-600' }}">
                                {{ number_format($effectiveRate * 100, 2) }}%
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $isIndividual ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $isIndividual ? 'Individual' : 'Global' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button onclick="openCommissionModal({{ $partner->id }}, '{{ $partner->first_name }} {{ $partner->last_name }}', {{ $individualRate ?? 'null' }})" 
                                    class="text-indigo-600 hover:text-indigo-900 mr-3">
                                {{ $isIndividual ? 'Edit' : 'Set Individual' }}
                            </button>
                            @if($isIndividual)
                                <form action="{{ route('admin.commission.remove', $partner) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" 
                                            onclick="return confirm('Remove individual rate and use global rate?')">
                                        Remove
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            No partners found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $partners->links() }}
    </div>
</div>

<!-- Commission Modal -->
<div id="commissionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Set Individual Commission Rate</h3>
                <form id="commissionForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Partner: <span id="partnerName" class="font-semibold"></span>
                        </label>
                        <div class="flex items-center space-x-4">
                            <div class="flex-1">
                                <input type="number" 
                                       name="commission_rate" 
                                       id="commissionRateInput"
                                       step="0.0001" 
                                       min="0" 
                                       max="1" 
                                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1F8FB2]" 
                                       placeholder="0.15">
                                <p class="text-xs text-gray-500 mt-1">Enter as decimal (e.g., 0.15 for 15%)</p>
                            </div>
                            <div class="text-lg font-semibold text-gray-700">
                                <span id="modalCommissionPercentage">0%</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeCommissionModal()" 
                                class="px-4 py-2 text-gray-600 border border-gray-300 rounded hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-[#1F8FB2] text-white rounded hover:bg-[#157799]">
                            Save Rate
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function openCommissionModal(partnerId, partnerName, currentRate) {
    document.getElementById('partnerName').textContent = partnerName;
    document.getElementById('commissionForm').action = `/admin/commission/partner/${partnerId}`;
    
    const input = document.getElementById('commissionRateInput');
    if (currentRate !== null) {
        input.value = currentRate;
        updateModalPercentage(currentRate);
    } else {
        input.value = '';
        updateModalPercentage(0);
    }
    
    document.getElementById('commissionModal').classList.remove('hidden');
}

function closeCommissionModal() {
    document.getElementById('commissionModal').classList.add('hidden');
}

function updateModalPercentage(value) {
    const percentage = (parseFloat(value) * 100).toFixed(2);
    document.getElementById('modalCommissionPercentage').textContent = percentage + '%';
}

document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('commissionRateInput');
    input.addEventListener('input', function() {
        updateModalPercentage(this.value || 0);
    });
});

// Close modal when clicking outside
document.getElementById('commissionModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeCommissionModal();
    }
});
</script>
@endsection