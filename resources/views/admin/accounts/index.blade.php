@extends('admin.master')
@section('title', 'Admin Accounts')
@section('content')
    <section class="min-h-screen p-4 sm:p-6 bg-gray-50">
    <div class="space-y-6 sm:space-y-8">

        <!-- Page Heading -->
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2 sm:mb-4">Admin Accounts</h1>

        <!-- Admin Accounts Table -->
        <div class="bg-white rounded-lg shadow p-3 sm:p-6 overflow-x-auto">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <table class="min-w-full border border-gray-200 rounded-lg">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Username</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($viewModel->adminAccounts as $account)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm">{{ $account->id }}</td>
                            <td class="px-6 py-4 text-sm">{{ $account->username }}</td>
                            <td class="px-6 py-4 text-sm">{{ $account->email }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full
                                    {{ $account->status === 'approved' ? 'bg-green-100 text-green-800' :
                                       ($account->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($account->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    @if($account->status === 'approved' && (Auth::guard('admin')->user()->isSuperAdmin() || Auth::guard('admin')->user()->can('manage_admin_permissions')))
                                        <a href="{{ route('admin.permissions.manage', $account->id) }}"
                                           class="px-3 py-1 text-xs font-semibold rounded-lg bg-blue-500 hover:bg-blue-600 text-white">
                                            Manage Permissions
                                        </a>
                                    @endif
                                    
                                    @if(Auth::guard('admin')->user()->isSuperAdmin() || Auth::guard('admin')->user()->can('edit_admin_accounts'))
                                    <form action="{{ route('admin.accounts.updateStatus', $account->id) }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="status" value="{{ $account->status === 'approved' ? 'rejected' : 'approved' }}">
                                        <button type="submit"
                                            class="px-3 py-1 text-xs font-semibold rounded-lg text-white
                                            {{ $account->status === 'approved' ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }}">
                                            {{ $account->status === 'approved' ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
