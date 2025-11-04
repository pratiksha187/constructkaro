{{-- resources/views/layouts/engineer/app.blade.php --}}
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Engineer • ConstructKaro')</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Alpine.js -->
  <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

  <style>
    :root {
      --ck-orange: #FF6600;
      --ck-navy: #0B1E39;
      --ck-bg: #F5F7FB;
    }

    html, body {
      height: 100%;
    }

    body {
      background: radial-gradient(1200px 800px at 10% -10%, #eef3ff 0%, rgba(238,243,255,0) 60%),
                  radial-gradient(1200px 800px at 110% 10%, #fef3e9 0%, rgba(254,243,233,0) 60%),
                  var(--ck-bg);
      color: #0B2240;
      font-family: system-ui, -apple-system, "Segoe UI", Inter, Roboto, Helvetica, Arial, sans-serif;
    }

    .layout {
      display: grid;
      grid-template-columns: 260px 1fr;
      min-height: 100vh;
    }

    @media (max-width: 992px) {
      .layout { grid-template-columns: 1fr; }
    }

    /* ===================== Sidebar ===================== */
    .sidebar {
      background: #0B1E39;
      color: #cfd8e3;
      position: sticky;
      top: 0;
      height: 100vh;
      padding-bottom: 1rem;
      box-shadow: inset -1px 0 0 rgba(255,255,255,0.05);
    }

    .brand {
      height: 80px;
      padding: 0 1.25rem;
      display: flex;
      align-items: center;
      border-bottom: 1px solid rgba(255,255,255,.08);
    }

    .brand-logo {
      width: 180px;
      max-height: 150px;
      object-fit: contain;
    }

    .nav-section {
      padding: 1rem .75rem;
    }

    .nav-section .title {
      font-size: .75rem;
      letter-spacing: .08em;
      color: #8ea3c7;
      text-transform: uppercase;
      padding: .5rem .75rem;
    }

    /* Sidebar links */
    .side-link {
      color: #cfd8e3 !important;
      border-radius: 0.6rem;
      padding: 0.65rem 0.9rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      text-decoration: none;
      background: transparent;
      width: 100%;
      border: none;
      font-size: 0.95rem;
      transition: all 0.2s ease-in-out;
    }

    .side-link:hover {
      background: rgba(255,255,255,0.08);
      color: #fff !important;
    }

    .side-link.active {
      background: rgba(255,102,0,0.15);
      color: #fff !important;
      border-left: 3px solid var(--ck-orange);
    }

    /* Submenu links */
    .sidebar .collapse a.side-link {
      font-size: 0.9rem;
      padding-left: 2.3rem;
      display: flex;
      align-items: center;
      justify-content: flex-start;
      gap: 0.6rem;
    }

    .sidebar .collapse a.side-link.active {
      background: rgba(255,102,0,0.15);
      border-left: 3px solid var(--ck-orange);
      color: #fff;
    }

    /* Collapse arrow animation */
    .side-link[aria-expanded="true"] .bi-chevron-down {
      transform: rotate(180deg);
      transition: transform 0.3s ease;
    }

    .side-link[aria-expanded="false"] .bi-chevron-down {
      transition: transform 0.3s ease;
    }

    /* ===================== Topbar ===================== */
    .topbar {
      padding: 1rem 1.25rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 1rem;
    }

    .search {
      display: flex;
      align-items: center;
      gap: .5rem;
      background: #fff;
      border: 1px solid #e7ecf7;
      border-radius: .75rem;
      padding: .5rem .75rem;
      flex: 1;
      max-width: 560px;
    }

    .search input {
      border: none;
      outline: none;
      width: 100%;
      font-size: .95rem;
    }

    .btn-primary {
      --bs-btn-bg: var(--ck-orange);
      --bs-btn-border-color: var(--ck-orange);
      --bs-btn-hover-bg: #e65c00;
      --bs-btn-hover-border-color: #e65c00;
    }

    .btn-outline-primary {
      --bs-btn-color: var(--ck-orange);
      --bs-btn-border-color: var(--ck-orange);
      --bs-btn-hover-bg: var(--ck-orange);
      --bs-btn-hover-border-color: var(--ck-orange);
      --bs-btn-hover-color: #fff;
    }

    .collapse.show {
      visibility: visible !important;
      display: block !important;
    }
  </style>

  @stack('styles')
</head>
<body>
  <div class="layout">
    {{-- ===================== Sidebar ===================== --}}
    <aside class="sidebar d-none d-lg-block">
      <a class="brand" href="{{ url('/') }}" aria-label="ConstructKaro Home">
        <img class="brand-logo" src="{{ asset('logo/bg.png') }}" alt="ConstructKaro Logo">
      </a>

      {{-- Dashboard --}}
      <div class="nav-section">
        <div class="title">Dashboard</div>
        <a class="side-link {{ request()->routeIs('engineer_dashboard') ? 'active' : '' }}" href="{{route('engineer_dashboard')}}">
          <i class="bi bi-speedometer2"></i> Dashboard
        </a>
      </div>

      {{-- Project --}}
      <div class="nav-section">
        <div class="title">Project</div>

        <div class="side-link w-100 text-start d-flex align-items-center justify-content-between"
             data-bs-toggle="collapse"
             data-bs-target="#projectMenu"
             aria-expanded="{{ request()->routeIs('NewProject') || request()->routeIs('NewProjectBoq') ? 'true' : 'false' }}"
             role="button">
          <span><i class="bi bi-diagram-3"></i> Project</span>
          <i class="bi bi-chevron-down small"></i>
        </div>

        <div class="collapse {{ request()->routeIs('NewProject') || request()->routeIs('NewProjectBoq') ? 'show' : '' }}" id="projectMenu">
          <a class="side-link {{ request()->routeIs('NewProject') ? 'active' : '' }}" href="{{ route('NewProject') }}">
            <i class="bi bi-folder2-open"></i> Projects
          </a>
          <a class="side-link {{ request()->routeIs('NewProjectBoq') ? 'active' : '' }}" href="{{ route('NewProjectBoq') }}">
            <i class="bi bi-list-check"></i> BOQ List
          </a>
         <a class="side-link {{ request()->routeIs('billverification') ? 'active' : '' }}" 
            href="{{ route('billverification') }}">
            <i class="bi bi-list-check"></i> Bill Verification
          </a>  

        </div>
      </div>

      {{-- Vendors --}}
      <div class="nav-section">
        <div class="title">Vendors</div>

        <div class="side-link w-100 text-start d-flex align-items-center justify-content-between"
             data-bs-toggle="collapse"
             data-bs-target="#vendorMenu"
             aria-expanded="{{ request()->routeIs('get_all_vender_list') ? 'true' : 'false' }}"
             role="button">
          <span><i class="bi bi-person-badge"></i> Vendors</span>
          <i class="bi bi-chevron-down small"></i>
        </div>

        <div class="collapse {{ request()->routeIs('get_all_vender_list') ? 'show' : '' }}" id="vendorMenu">
          <a class="side-link {{ request()->routeIs('get_all_vender_list') ? 'active' : '' }}" href="{{ route('get_all_vender_list') }}">
            <i class="bi bi-list-ul"></i> Vendor List
          </a>
        </div>
      </div>

      {{-- Milestone --}}
      <div class="nav-section">
        <div class="title">Milestone</div>

        <div class="side-link w-100 text-start d-flex align-items-center justify-content-between"
             data-bs-toggle="collapse"
             data-bs-target="#MilestoneMenu"
             aria-expanded="{{ request()->routeIs('addmillstone') || request()->routeIs('engineer.milestones.list') ? 'true' : 'false' }}"
             role="button">
          <span><i class="bi bi-flag"></i> Milestone</span>
          <i class="bi bi-chevron-down small"></i>
        </div>

        <div class="collapse {{ request()->routeIs('addmillstone') || request()->routeIs('engineer.milestones.list') ? 'show' : '' }}" id="MilestoneMenu">
          <a class="side-link {{ request()->routeIs('addmillstone') ? 'active' : '' }}" href="{{ route('addmillstone') }}">
            <i class="bi bi-plus-circle"></i> Add Milestone
          </a>
          <a class="side-link {{ request()->routeIs('engineer.milestones.list') ? 'active' : '' }}" href="{{ route('engineer.milestones.list') }}">
            <i class="bi bi-list-ul"></i> Milestone List
          </a>
        </div>
      </div>
    </aside>

    {{-- ===================== Main Content ===================== --}}
    <main class="bg-transparent">
      {{-- Topbar --}}
      <div class="topbar container-fluid">
        <button class="btn btn-outline-primary d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#mobileNav">Menu</button>

        <div class="search">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="11" cy="11" r="7" stroke="#8ea3c7" stroke-width="1.6"/>
            <path d="M20 20l-3.2-3.2" stroke="#8ea3c7" stroke-width="1.6" stroke-linecap="round"/>
          </svg>
          <input placeholder="Search projects, vendors…">
        </div>

        <div class="dropdown">
          <button class="btn btn-light d-flex align-items-center gap-2" data-bs-toggle="dropdown" aria-expanded="false">
            <!-- <img src="https://i.pravatar.cc/40?img=64" class="rounded-circle border" width="36" height="36" alt="avatar"> -->
            <span class="small text-muted">Engineer</span>
          </button>
          <ul class="dropdown-menu dropdown-menu-end shadow">
            <li class="dropdown-item-text text-muted small px-3">Signed in as <strong>Engineer</strong></li>
            <li><hr class="dropdown-divider"></li>
            <li class="px-3">
              <form method="POST" action="{{ route('logout') }}">@csrf
                <button type="submit" class="btn btn-danger w-100">Log out</button>
              </form>
            </li>
          </ul>
        </div>
      </div>

      {{-- Page Content --}}
      @yield('content')

      {{-- Mobile Sidebar --}}
      <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileNav">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title">Menu</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column">
          <div class="list-group mb-3">
            <a class="list-group-item list-group-item-action" href="#">Dashboard</a>
            <a class="list-group-item list-group-item-action {{ request()->routeIs('NewProject') ? 'active' : '' }}" href="{{ route('NewProject') }}">Projects</a>
            <a class="list-group-item list-group-item-action" href="{{ route('get_all_vender_list') }}">Vendors</a>
            <a class="list-group-item list-group-item-action" href="{{ route('engineer.milestones.list') }}">Milestones</a>
          </div>
          <form method="POST" action="{{ route('logout') }}" class="mt-auto">@csrf
            <button type="submit" class="btn btn-danger w-100">Log out</button>
          </form>
        </div>
      </div>
    </main>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  @stack('scripts')
</body>
</html>
