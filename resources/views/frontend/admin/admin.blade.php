@extends('frontend.admin.master')

@section('title', 'Admin Dashboard')

@section('content')
<section class="min-h-screen p-6 bg-gray-50">
    <div class="space-y-8">

        <!-- Breadcrumb -->
        <nav class="flex mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600">Dashboard</a>
                </li>
                <li>
                    <span class="text-gray-400">/</span>
                </li>
                <li class="text-gray-500 font-medium">Admin</li>
            </ol>
        </nav>

        <!-- Page Heading -->
        <h1 class="text-3xl font-bold text-gray-800">Admin Dashboard</h1>

        <!-- Card Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">

            <!-- Users -->
            <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">Manage Users</h2>
                <p class="text-gray-600 mb-4">Add, edit, or delete users from the system.</p>
                <a href="#" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow">
                    Go to Users
                </a>
            </div>

            <!-- Roles -->
            <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">Manage Roles</h2>
                <p class="text-gray-600 mb-4">Define and manage roles and permissions.</p>
                <a href="#" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded shadow">
                    Go to Roles
                </a>
            </div>

            <!-- Settings -->
            <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">System Settings</h2>
                <p class="text-gray-600 mb-4">Update application settings and preferences.</p>
                <a href="#" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded shadow">
                    Go to Settings
                </a>
            </div>

        </div>
    </div>
</section>
@endsection
