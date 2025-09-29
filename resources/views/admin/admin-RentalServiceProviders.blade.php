@extends('admin.master')
@section('title', 'Rental Service Providers Management')
@section('content')

<section class="min-h-screen p-4 bg-white rounded-lg shadow-lg">
    <div class="space-y-6 p-2 sm:p-4">

        <!-- Breadcrumb -->
        <nav class="flex flex-wrap mb-3 sm:mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center flex-wrap space-x-1 md:space-x-3 text-xs sm:text-sm">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600">
                        <i class="fas fa-home mr-1"></i> Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs sm:text-sm"></i>
                        <span class="text-gray-500">Rental Service Providers</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Title -->
        <h1 class="text-lg sm:text-2xl md:text-3xl font-bold text-gray-800 mb-3 sm:mb-6 leading-tight">
            Rental Service Providers Management
        </h1>

        <!-- Search & Filter Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <div class="w-full sm:w-2/3 flex flex-col sm:flex-row gap-2 sm:gap-3">
                <form method="GET" class="w-full flex flex-col sm:flex-row gap-2 sm:gap-3">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search by name, email, or phone"
                        class="w-full sm:flex-1 px-3 py-2 text-xs sm:text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#1F8FB2]"
                    >
                    <select name="account_type"
                        class="px-3 py-2 text-xs sm:text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#1F8FB2] bg-white w-full sm:w-auto"
                        onchange="this.form.submit()">
                        <option value="">All Types</option>
                        <option value="company" @selected(request('account_type') === 'company')>Company</option>
                        <option value="individual" @selected(request('account_type') === 'individual')>Individual</option>
                    </select>
                    <button type="submit" class="px-3 py-2 bg-[#1F8FB2] text-white rounded-md text-xs sm:text-sm hover:bg-[#157799]">
                        Search
                    </button>
                </form>
            </div>
        </div>

        <!-- Table Wrapper -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full text-xs sm:text-sm text-left text-gray-700">
                    <thead class="bg-gray-50 font-bold uppercase text-gray-500">
                        <tr>
                            <th class="px-2 sm:px-4 py-2 sm:py-3">ID</th>
                            <th class="px-2 sm:px-4 py-2 sm:py-3">Name/Company</th>
                            <th class="px-2 sm:px-4 py-2 sm:py-3">Email</th>
                            <th class="px-2 sm:px-4 py-2 sm:py-3">Type</th>
                            <th class="px-2 sm:px-4 py-2 sm:py-3">Cars</th>
                            <th class="px-2 sm:px-4 py-2 sm:py-3">Taxis</th>
                            <th class="px-2 sm:px-4 py-2 sm:py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($providers as $provider)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-2 sm:px-4 py-3 font-medium text-gray-900">#{{ $provider->id }}</td>
                            <td class="px-2 sm:px-4 py-3">
                                @if($provider->isCompany())
                                    <div class="font-medium">{{ $provider->company_name }}</div>
                                    <div class="text-xs text-gray-500">{{ $provider->full_name }}</div>
                                @else
                                    {{ $provider->full_name }}
                                @endif
                            </td>
                            <td class="px-2 sm:px-4 py-3">{{ $provider->email }}</td>
                            <td class="px-2 sm:px-4 py-3">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold 
                                    @if($provider->isCompany()) bg-blue-100 text-blue-800 @else bg-green-100 text-green-800 @endif">
                                    {{ ucfirst($provider->account_type) }}
                                </span>
                            </td>
                            <td class="px-2 sm:px-4 py-3">
                                <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs">
                                    {{ $provider->cars_count }}
                                </span>
                            </td>
                            <td class="px-2 sm:px-4 py-3">
                                <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs">
                                    {{ $provider->taxis_count }}
                                </span>
                            </td>
                            <td class="px-2 sm:px-4 py-3">
                                <div class="flex flex-wrap gap-2 sm:gap-3">
                                    <a href="{{ route('admin.rental-providers.view', $provider->id) }}"
                                        class="text-[#1F8FB2] hover:text-[#157799] text-xs sm:text-sm font-medium inline-flex items-center">
                                        <i class="fas fa-eye mr-1"></i> View
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                No rental service providers found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-3 sm:px-4 py-3 flex flex-col sm:flex-row items-center justify-between gap-3 border-t border-gray-200">
                <p class="text-xs text-gray-700">
                    Showing {{ $providers->firstItem() ?? 0 }} to {{ $providers->lastItem() ?? 0 }} of {{ $providers->total() }} results
                </p>
                <div class="space-x-1">
                    {{ $providers->links('pagination::simple-bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</section>

@endsection