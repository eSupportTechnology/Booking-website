@extends('frontend.admin.master')

@section('title', 'Admin Dashboard')

@section('content')
<section class="min-h-screen p-4 sm:p-6 bg-gray-50">
    <div class="space-y-6 sm:space-y-8">

        <!-- Page Heading -->
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2 sm:mb-4">Admin Accounts</h1>

        <!-- Admin Accounts Table -->
        <div class="bg-white rounded-lg shadow p-3 sm:p-6 overflow-x-auto">
            @php
                $adminAccounts = [
                    (object)['id'=>1, 'username'=>'John Doe', 'email'=>'john@example.com', 'active'=>true],
                    (object)['id'=>2, 'username'=>'Emma Smith', 'email'=>'emma@example.com', 'active'=>false],
                    (object)['id'=>3, 'username'=>'Michael Brown', 'email'=>'michael@example.com', 'active'=>true],
                    (object)['id'=>4, 'username'=>'Sophia Johnson', 'email'=>'sophia@example.com', 'active'=>false],
                ];
            @endphp

            <table class="min-w-full border border-gray-200 rounded-lg">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-3 py-2 sm:px-6 sm:py-3 text-left text-gray-700 font-semibold border-b text-sm sm:text-base">ID</th>
                        <th class="px-3 py-2 sm:px-6 sm:py-3 text-left text-gray-700 font-semibold border-b text-sm sm:text-base">UserName</th>
                        <th class="px-3 py-2 sm:px-6 sm:py-3 text-left text-gray-700 font-semibold border-b text-sm sm:text-base">Email</th>
                        <th class="px-3 py-2 sm:px-6 sm:py-3 text-left text-gray-700 font-semibold border-b text-sm sm:text-base">Status</th>
                        <th class="px-3 py-2 sm:px-6 sm:py-3 text-center text-gray-700 font-semibold border-b text-sm sm:text-base">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($adminAccounts as $account)
                        <tr class="hover:bg-gray-50 border-b">
                            <td class="px-3 py-2 sm:px-6 sm:py-3 text-sm sm:text-base">{{ $account->id }}</td>
                            <td class="px-3 py-2 sm:px-6 sm:py-3 text-sm sm:text-base">{{ $account->username }}</td>
                            <td class="px-3 py-2 sm:px-6 sm:py-3 text-sm sm:text-base">{{ $account->email }}</td>
                            <td class="px-3 py-2 sm:px-6 sm:py-3 text-sm sm:text-base">
                                <span class="px-2 py-1 sm:px-3 sm:py-1 rounded-full text-xs sm:text-sm font-semibold {{ $account->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $account->active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-3 py-2 sm:px-6 sm:py-3 text-center whitespace-nowrap">
                                <button class="px-3 py-1 sm:px-4 sm:py-2 rounded-lg shadow text-white text-xs sm:text-sm {{ $account->active ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }}">
                                    {{ $account->active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</section>
@endsection
