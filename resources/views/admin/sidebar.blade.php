<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Admin Panel</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.customers') }}">Customers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.apartments') }}">Apartments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.hotels') }}">Hotels</a>
                </li>
                @if(Auth::guard('admin')->user()->hasRole('superAdmin'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.approvals.index') }}">Pending Admins</a>
                </li>
                @endif
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        {{ Auth::guard('admin')->user()->name }}
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
