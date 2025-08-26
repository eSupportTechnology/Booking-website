@extends('frontend.admin.master')
@section('title', 'Taxi Details')
@section('content')

<section class="min-h-screen p-4 bg-white rounded-lg shadow-lg">
    <div class="space-y-6 p-4">

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
                        <a href="{{ url('/admin/taxi-management') }}" class="text-gray-700 hover:text-blue-600">Taxi</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <span class="text-gray-500">Taxi Details</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Taxi Details Card -->
        <div class="bg-white shadow-lg rounded-lg p-6 border border-gray-200">
            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-800 mb-5">Taxi Details</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-gray-700"><span class="font-semibold">Taxi ID:</span> #T101</p>
                    <p class="text-gray-700"><span class="font-semibold">Driver Name:</span> John Doe</p>
                    <p class="text-gray-700"><span class="font-semibold">Vehicle:</span> Toyota Prius</p>
                </div>
                <div>
                    <p class="text-gray-700"><span class="font-semibold">Status:</span>
                        <span class="px-3 py-1 rounded-full text-white bg-green-500">Active</span>
                    </p>
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ url('/admin/rental/taxi') }}"
                   class="bg-[#1F8FB2] hover:bg-[#157799] text-white px-4 py-2 rounded shadow">
                    ← Back to Taxi List
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
