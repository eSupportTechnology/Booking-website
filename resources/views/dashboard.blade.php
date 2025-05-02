<h1>HI</h1>
<div class="d-grid px-2 pt-2 pb-1">
    <form id="logout-form" action="{{ route('traveler.logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-sm btn-danger d-flex">
            <small class="align-middle">Logout</small>
            <i class="ti ti-logout ms-2 ti-14px"></i>
        </button>
    </form>
    <a href="{{ route('traveler.profile') }}" class="btn btn-sm btn-primary d-flex">
        <small class="align-middle">Profile</small>
        <i class="ti ti-user ms-2 ti-14px"></i>
    </a>
</div>
