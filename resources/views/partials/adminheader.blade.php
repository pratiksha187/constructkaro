<div class="topbar container-fluid">
  <button class="btn btn-outline-primary d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#mobileNav">
    Menu
  </button>

  <div class="search">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
      <circle cx="11" cy="11" r="7" stroke="#8ea3c7" stroke-width="1.6"/>
      <path d="M20 20l-3.2-3.2" stroke="#8ea3c7" stroke-width="1.6" stroke-linecap="round"/>
    </svg>
    <input placeholder="Search projects, vendors…"/>
  </div>

  <div class="d-flex align-items-center gap-2">
    {{-- User dropdown --}}
    <div class="dropdown">
      <button class="btn btn-light d-flex align-items-center gap-2" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="https://i.pravatar.cc/40?img=64" class="rounded-circle border" width="36" height="36" alt="avatar"/>
        <span class="small text-muted">ADMIN</span>
      </button>
      <ul class="dropdown-menu dropdown-menu-end shadow">
        <li class="dropdown-item-text text-muted small px-3">Signed in as <strong>ADMIN</strong></li>
        <li><hr class="dropdown-divider"></li>
        {{-- <li><a class="dropdown-item" href="{{ route('admin.profile') }}">Profile</a></li> --}}
        <li class="px-3">
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger w-100">Log out</button>
          </form>
        </li>
      </ul>
    </div>
  </div>
</div>

{{-- Mobile offcanvas (sidebar clone) --}}
<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileNav">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title">Menu</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body d-flex flex-column">
    <div class="list-group mb-3">
      <a class="list-group-item list-group-item-action {{ request()->routeIs('admin_dashboard') ? 'active' : '' }}" href="{{ route('admin_dashboard') }}">Dashboard</a>
      <a class="list-group-item list-group-item-action" href="{{ route('vender_approve_form') }}">Register Vendor</a>
      <a class="list-group-item list-group-item-action" href="{{ route('vender_approve_data') }}">Approve Vendor</a>
      <a class="list-group-item list-group-item-action" href="{{ route('vender_reject_data') }}">Reject Vendor</a>
      <a class="list-group-item list-group-item-action" href="#">Masters: Services</a>
      <a class="list-group-item list-group-item-action" href="#">Masters: Locations</a>
      <a class="list-group-item list-group-item-action" href="#">Users: Admins</a>
      <a class="list-group-item list-group-item-action" href="#">Users: Customers</a>
    </div>

    {{-- Logout as list-group button --}}
    <form method="POST" action="{{ route('logout') }}" class="mt-auto">
      @csrf
      <button type="submit" class="list-group-item list-group-item-action btn btn-danger w-100">
        Log out
      </button>
    </form>
  </div>
</div>
