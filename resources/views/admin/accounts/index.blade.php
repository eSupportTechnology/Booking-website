@extends('admin.master')
@section('content')
    <h1>Admin Accounts</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>UserName</th>
                <th>Email</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($viewModel->adminAccounts as $account)
                <tr>
                    <td>{{ $account->id }}</td>
                    <td>{{ $account->username }}</td>
                    <td>{{ $account->email }}</td>
                    <td>{{ $account->status ? 'Active' : 'Inactive' }}</td>
                    <td>
                        <form action="{{ route('admin.accounts.toggle', $account->id) }}" method="POST">
                            @csrf
                            <button type="submit">{{ $account->status ? 'Deactivate' : 'Activate' }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
