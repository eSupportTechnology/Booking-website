@extends('admin.master')
@section('title', 'Vehicle Management')
@section('content')

<section class="min-h-screen p-4 bg-white rounded-lg shadow-lg">
    <div class="space-y-6">

        <!-- Breadcrumb -->
        <nav class="flex text-sm mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-3">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600">
                        <i class="fas fa-home mr-1"></i> Dashboard
                    </a>
                </li>
                <li class="text-gray-500">/ Registered Vehicles</li>
            </ol>
        </nav>

        <!-- Title -->
        <h1 class="text-2xl font-bold text-gray-800">Registered Vehicles</h1>

        <!-- Search -->
        <form method="GET" class="flex gap-3">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Search brand, model, owner or plate"
                class="px-3 py-2 border rounded-md w-1/3">

            <select name="status" class="px-3 py-2 border rounded-md" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="Active" @selected(request('status')=='Active')>Active</option>
                <option value="Inactive" @selected(request('status')=='Inactive')>Inactive</option>
                <option value="On Trip" @selected(request('status')=='On Trip')>On Trip</option>
            </select>

            <button class="px-4 py-2 bg-blue-600 text-white rounded">Search</button>
        </form>

        <!-- Table -->
        <div class="bg-white rounded shadow overflow-x-auto">
            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Owner</th>
                        <th class="px-4 py-3">Vehicle</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Approval</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($cars as $car)
                    <tr class="border-b">

                        <!-- ID -->
                        <td class="px-4 py-3 font-semibold">#C{{ $car->id }}</td>

                        <!-- OWNER COLUMN -->
                        <td class="px-4 py-3">
                            @php
                                $owner = $car->renter;
                            @endphp

                            @if($owner)

                                @if($owner->account_type === 'company')
                                    {{-- COMPANY OWNER --}}
                                    <span class="font-semibold text-gray-900">
                                        {{ $owner->company_name }}
                                    </span>
                                    <span class="text-xs text-gray-500">(Company)</span>
                                    <br>
                                    <span class="text-xs text-gray-600">{{ $owner->phone }}</span>

                                @else
                                    {{-- INDIVIDUAL OWNER --}}
                                    <span class="font-semibold text-gray-900">
                                        {{ $owner->full_name }}
                                    </span>
                                    <span class="text-xs text-gray-500">(Individual)</span>
                                    <br>
                                    <span class="text-xs text-gray-600">{{ $owner->phone }}</span>
                                @endif

                            @else
                                <span class="text-gray-500">Unknown</span>
                            @endif
                        </td>

                        <!-- VEHICLE COLUMN -->
                        <td class="px-4 py-3">
                            {{ $car->brand->brand_name ?? '' }}
                            -
                            {{ $car->model->model_name ?? '' }}
                        </td>

                        <!-- STATUS DROPDOWN -->
                        <td class="px-2 sm:px-4 py-3">
                            <div class="relative">
                                <select onchange="handleCarStatusChange(this, '{{ $car->id }}')"
                                    class="appearance-none
                                        @if($car->status === 'Active') bg-green-100 text-green-800
                                        @elseif($car->status === 'Inactive') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800
                                        @endif
                                        font-medium text-xs sm:text-sm rounded-full pl-6 pr-4 py-1
                                        focus:outline-none focus:ring-2 focus:ring-[#1F8FB2] transition">
                                    
                                    <option value="Active" @selected($car->status === 'Active')>Active</option>
                                    <option value="Inactive" @selected($car->status === 'Inactive')>Inactive</option>
                                    <option value="Unavailable" @selected($car->status === 'Unavailable')>Unavailable</option>
                                </select>

                                <span class="absolute top-1/2 left-2 -translate-y-1/2 w-2 h-2 rounded-full
                                        @if($car->status === 'Active') bg-green-800
                                        @elseif($car->status === 'Inactive') bg-yellow-800
                                        @else bg-red-800
                                        @endif
                                        pointer-events-none status-dot">
                                </span>
                            </div>
                        </td>


                        <!-- APPROVAL BADGE -->
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded text-xs font-semibold
                                {{ $car->approval_status=='approved'
                                    ? 'bg-green-100 text-green-800'
                                    : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($car->approval_status) }}
                            </span>
                        </td>

                        <!-- ACTIONS -->
                        <td class="px-4 py-3 flex gap-3">

                            <!-- VIEW BUTTON -->
                            <a href="{{ route('admin.rental.carrentals.details', $car->id) }}"
                                class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-eye"></i> View
                            </a>

                            <!-- DELETE BUTTON -->
                            <form action="{{ route('admin.rental.carrentals.delete', $car->id) }}" method="POST"
                                onsubmit="return confirm('Delete this vehicle?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="p-3 border-t">
                {{ $cars->links('pagination::simple-bootstrap-4') }}
            </div>

        </div>
    </div>
</section>

<script>
function updateCarStatus(sel, id){
    fetch(`/admin/vehicles/${id}/status`, {
        method: "PATCH",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name=csrf-token]').content
        },
        body: JSON.stringify({ status: sel.value })
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
    });
}

function handleCarStatusChange(selectElement, carId) {
    let newStatus = selectElement.value;

    fetch(`/admin/rental/carrentals/${carId}/status`, {
        method: "PATCH",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ status: newStatus })
    })
    .then(response => response.json())
    .then(data => {
        // Change the color dynamically
        selectElement.className =
            `appearance-none font-medium text-xs sm:text-sm rounded-full pl-6 pr-4 py-1 transition ` +
            (newStatus === "Active" ? "bg-green-100 text-green-800" :
            newStatus === "Inactive" ? "bg-yellow-100 text-yellow-800" :
                                       "bg-red-100 text-red-800");

        // Dot color
        selectElement.parentElement.querySelector(".status-dot").className =
            `absolute top-1/2 left-2 -translate-y-1/2 w-2 h-2 rounded-full pointer-events-none status-dot ` +
            (newStatus === "Active" ? "bg-green-800" :
            newStatus === "Inactive" ? "bg-yellow-800" :
                                       "bg-red-800");

        alert("Status updated successfully!");
    })
    .catch(error => {
        alert("Something went wrong!");
        console.error(error);
    });
}

</script>

@endsection
