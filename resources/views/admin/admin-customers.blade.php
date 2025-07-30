@extends('admin.master')

@section('content')
<div class="p-6 bg-white rounded shadow space-y-6">
    <!-- Breadcrumb -->
    <nav class="flex mb-4" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600">
                    <i class="fas fa-home mr-1"></i> Dashboard
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-gray-500">Customers</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Page Title -->
    <h2 class="text-2xl font-semibold text-[#1F8FB2]">Customers</h2>

    <!-- Search Bar -->
    <div class="flex justify-between items-center gap-4 max-w-xl">
        <input
            type="text"
            placeholder="Search by name or email"
            class="flex-grow border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#1F8FB2]"
        />
        <button class="bg-[#1F8FB2] text-white px-4 py-2 rounded hover:bg-[#157799] transition">
            Search
        </button>
    </div>

    <!-- Customers Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded shadow">
            <thead class="bg-[#E6F7FC] text-[#1F8FB2]">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold">ID</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
                <tr>
                    <td class="px-6 py-4">1</td>
                    <td class="px-6 py-4">John Doe</td>
                    <td class="px-6 py-4">
                        <span class="inline-block px-3 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">Active</span>
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.customer.view') }}" class="px-3 py-1 text-sm text-white bg-[#1F8FB2] hover:bg-[#157799] rounded">View</a>
                        <button class="px-3 py-1 text-sm text-white bg-red-500 hover:bg-red-600 rounded">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td class="px-6 py-4">2</td>
                    <td class="px-6 py-4">Jane Smith</td>
                    <td class="px-6 py-4">
                        <span class="inline-block px-3 py-1 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded-full">Pending</span>
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.customer.view') }}" class="px-3 py-1 text-sm text-white bg-[#1F8FB2] hover:bg-[#157799] rounded">View</a>
                        <button class="px-3 py-1 text-sm text-white bg-red-500 hover:bg-red-600 rounded">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td class="px-6 py-4">3</td>
                    <td class="px-6 py-4">Michael Brown</td>
                    <td class="px-6 py-4">
                        <span class="inline-block px-3 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded-full">Inactive</span>
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.customer.view') }}" class="px-3 py-1 text-sm text-white bg-[#1F8FB2] hover:bg-[#157799] rounded">View</a>
                        <button class="px-3 py-1 text-sm text-white bg-red-500 hover:bg-red-600 rounded">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
