<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Admin Panel</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">
                @can('view_dashboard')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                @endcan

                @canany(['view_customers', 'view_partners', 'view_rental_providers'])
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Users</a>
                    <ul class="dropdown-menu">
                        @can('view_customers')
                        <li><a class="dropdown-item" href="{{ route('admin.customers') }}">Customers</a></li>
                        @endcan
                        @can('view_partners')
                        <li><a class="dropdown-item" href="{{ route('admin.partners') }}">Partners</a></li>
                        @endcan
                        @can('view_rental_providers')
                        <li><a class="dropdown-item" href="{{ route('admin.rental-providers') }}">Rental Service Providers</a></li>
                        @endcan
                    </ul>
                </li>
                @endcanany

                @canany(['view_apartments', 'view_homes', 'view_hotels', 'view_alternative_places'])
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Property</a>
                    <ul class="dropdown-menu">
                        @can('view_apartments')
                        <li><a class="dropdown-item" href="{{ route('admin.apartments') }}">Apartments</a></li>
                        @endcan
                        @can('view_homes')
                        <li><a class="dropdown-item" href="{{ route('admin.homes') }}">Homes</a></li>
                        @endcan
                        @can('view_hotels')
                        <li><a class="dropdown-item" href="{{ route('admin.hotels') }}">Hotels</a></li>
                        @endcan
                        @can('view_alternative_places')
                        <li><a class="dropdown-item" href="{{ route('admin.alternative.places') }}">Alternative Places</a></li>
                        @endcan
                    </ul>
                </li>
                @endcanany

                @canany(['view_taxi', 'view_airport'])
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Rental</a>
                    <ul class="dropdown-menu">
                        @can('view_taxi')
                        <li><a class="dropdown-item" href="{{ route('admin.rental.taxi') }}">Taxi</a></li>
                        @endcan
                        @can('view_airport')
                        <li><a class="dropdown-item" href="{{ route('admin.rental.airport') }}">Airport</a></li>
                        @endcan
                    </ul>
                </li>
                @endcanany

                @canany(['view_pending_admins', 'view_admin_accounts', 'manage_admin_permissions'])
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Admin Management</a>
                    <ul class="dropdown-menu">
                        @can('view_pending_admins')
                        <li><a class="dropdown-item" href="{{ route('admin.approvals.index') }}">Pending Admins</a></li>
                        @endcan
                        @can('view_admin_accounts')
                        <li><a class="dropdown-item" href="{{ route('admin.accounts.index') }}">Admin Accounts</a></li>
                        @endcan
                        @can('manage_admin_permissions')
                        <li><a class="dropdown-item" href="{{ route('admin.accounts.index') }}">Manage Permissions</a></li>
                        @endcan
                    </ul>
                </li>
                @endcanany
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
