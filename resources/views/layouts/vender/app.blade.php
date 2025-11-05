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
      --ck-orange: #f25c05;
      --ck-navy: #1c2c3e;
      --ck-bg: #f5f7fb;
    }

    body {
      background: radial-gradient(1200px 800px at 10% -10%, #eef3ff 0%, rgba(238,243,255,0) 60%),
                  radial-gradient(1200px 800px at 110% 10%, #fef3e9 0%, rgba(254,243,233,0) 60%),
                  var(--ck-bg);
      color: #0b2240;
      font-family: system-ui, -apple-system, "Segoe UI", Inter, Roboto, Helvetica, Arial, sans-serif;
      min-height: 100vh;
    }

    .layout {
      display: grid;
      grid-template-columns: 260px 1fr;
      min-height: 100vh;
    }

    @media (max-width: 992px) {
      .layout {
        grid-template-columns: 1fr;
      }
    }

    /* Sidebar */
    .sidebar {
      background: var(--ck-navy);
      color: #cfd8e3;
      position: sticky;
      top: 0;
      height: 100vh;
      padding-bottom: 1rem;
    }

    .brand {
      height: 80px;
      padding: 0 1.25rem;
      display: flex;
      align-items: center;
      border-bottom: 1px solid rgba(255,255,255,0.08);
    }

    .brand-logo {
      width: 180px;
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

    .side-link {
      color: #cfd8e3 !important;
      border-radius: .6rem;
      padding: .65rem .9rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      text-decoration: none;
      background: transparent;
      width: 100%;
      border: none;
      font-size: .95rem;
      transition: all .2s ease-in-out;
    }

    .side-link:hover {
      background: rgba(255,255,255,0.08);
      color: #fff !important;
    }

    .side-link.active {
      background: rgba(242,92,5,0.15);
      color: #fff !important;
      border-left: 3px solid var(--ck-orange);
    }

    .sidebar .collapse a.side-link {
      font-size: .9rem;
      padding-left: 2.3rem;
      display: flex;
      align-items: center;
      justify-content: flex-start;
      gap: .6rem;
    }

    .sidebar .collapse a.side-link.active {
      background: rgba(242,92,5,0.15);
      border-left: 3px solid var(--ck-orange);
      color: #fff;
    }

    .side-link[aria-expanded="true"] .bi-chevron-down {
      transform: rotate(180deg);
      transition: transform .3s ease;
    }

    .side-link[aria-expanded="false"] .bi-chevron-down {
      transition: transform .3s ease;
    }

    /* Topbar */
    .topbar {
      padding: 1rem 1.25rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 1rem;
      background: transparent;
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

    .sidebar .nav-section {
  margin-bottom: 0.75rem;
}

.sidebar .title {
  margin: 0;
  padding: 0;
  font-size: 0.75rem;
  letter-spacing: 0.05em;
  color: #9da9b9;
}

.sidebar .side-link {
  display: flex;
  align-items: center;
  gap: 8px;
  color: #d1d5db;
  text-decoration: none;
  padding: 6px 10px;
  border-radius: 6px;
  transition: 0.2s ease;
}

.sidebar .side-link:hover {
  background-color: rgba(255, 255, 255, 0.05);
  color: #fff;
}

.sidebar .side-link.active {
  background-color: #f25c05;
  color: #fff;
}

  </style>

  @stack('styles')
</head>
<body>
  <div class="layout">
    {{-- ===================== Sidebar ===================== --}}
    <aside class="sidebar d-none d-lg-block">
      <a class="brand" href="{{ route('vendor_dashboard') }}">
        <img class="brand-logo" src="{{ asset('logo/bg.png') }}" alt="ConstructKaro Logo">
      </a>

      {{-- Dashboard --}}
     
      <div class="nav-section">
        <div class="title mb-1 text-uppercase small text-light opacity-50">Dashboard</div>
        <a class="side-link d-flex align-items-center {{ request()->routeIs('vendor_dashboard') ? 'active' : '' }}" href="{{route('vendor_dashboard')}}">
          <i class="bi bi-speedometer2 me-2"></i> Dashboard
        </a>
      </div>


      {{-- My Profile --}}
      <div class="nav-section">
        <div class="side-link w-100 text-start d-flex align-items-center justify-content-between"
             data-bs-toggle="collapse" data-bs-target="#profileMenu"
             aria-expanded="{{ request()->routeIs('venderdetails') ? 'true' : 'false' }}" role="button">
          <span><i class="bi bi-person-circle"></i> My Profile</span>
          <i class="bi bi-chevron-down small"></i>
        </div>

        <div class="collapse {{ request()->routeIs('venderdetails') ? 'show' : '' }}" id="profileMenu">
          <a class="side-link {{ request()->routeIs('venderdetails') ? 'active' : '' }}" href="{{route('venderdetails')}}">
            <i class="bi bi-pencil-square"></i> Edit Profile
          </a>
        </div>
      </div>

      {{-- My Leads / Bids --}}
      <div class="nav-section">
        <div class="side-link w-100 text-start d-flex align-items-center justify-content-between"
             data-bs-toggle="collapse" data-bs-target="#leadsMenu"
             aria-expanded="{{ request()->routeIs('vender_leads_bids') ? 'true' : 'false' }}" role="button">
          <span><i class="bi bi-file-earmark-text"></i> My Leads / Bids</span>
          <i class="bi bi-chevron-down small"></i>
        </div>

        <div class="collapse {{ request()->routeIs('vender_leads_bids') ? 'show' : '' }}" id="leadsMenu">
          <a class="side-link {{ request()->routeIs('vender_leads_bids') ? 'active' : '' }}" href="{{route('vender_leads_bids')}}">
            <i class="bi bi-list-ul"></i> List
          </a>
        </div>
      </div>

      {{-- My Projects --}}
      <div class="nav-section">
        <div class="side-link w-100 text-start d-flex align-items-center justify-content-between"
             data-bs-toggle="collapse" data-bs-target="#projectMenu"
             aria-expanded="{{ request()->routeIs('vender_myproject') ? 'true' : 'false' }}" role="button">
          <span><i class="bi bi-diagram-3"></i> My Projects</span>
          <i class="bi bi-chevron-down small"></i>
        </div>

        <div class="collapse {{ request()->routeIs('vender_myproject') ? 'show' : '' }}" id="projectMenu">
          <a class="side-link {{ request()->routeIs('vender_myproject') ? 'active' : '' }}" href="{{route('vender_myproject')}}">
            <i class="bi bi-folder2-open"></i> Project List
          </a>
        </div>
      </div>

      {{-- Payments --}}
      <div class="nav-section">
        <div class="side-link w-100 text-start d-flex align-items-center justify-content-between"
             data-bs-toggle="collapse" data-bs-target="#paymentMenu"
             aria-expanded="{{ request()->routeIs('venderpaynment') ? 'true' : 'false' }}" role="button">
          <span><i class="bi bi-wallet2"></i> Payments</span>
          <i class="bi bi-chevron-down small"></i>
        </div>

        <div class="collapse {{ request()->routeIs('venderpaynment') ? 'show' : '' }}" id="paymentMenu">
          <a class="side-link {{ request()->routeIs('venderpaynment') ? 'active' : '' }}" href="{{route('venderpaynment')}}">
            <i class="bi bi-credit-card"></i> Payment List
          </a>
        </div>
      </div>

      {{-- Agreements --}}
      <div class="nav-section">
        <div class="side-link w-100 text-start d-flex align-items-center justify-content-between"
            data-bs-toggle="collapse"
            data-bs-target="#agreementMenu"
            aria-expanded="false"
            role="button">
          <span><i class="bi bi-file-earmark-text"></i> Agreements</span>
          <i class="bi bi-chevron-down small"></i>
        </div>

        <div class="collapse" id="agreementMenu">
          <a class="side-link" href="{{route('venderdigitalagreement')}}">
            <i class="bi bi-journal-text"></i> Active Agreements
          </a>
         
        </div>
      </div>


      {{-- Logout --}}
      <div class="nav-section">
        <a class="side-link text-danger" href="{{ route('logout') }}">
          <i class="bi bi-box-arrow-right"></i> Logout
        </a>
      </div>
    </aside>

    {{-- ===================== Main Content ===================== --}}
    <main class="bg-transparent">
      {{-- Topbar --}}
      <div class="topbar container-fluid">
        <button class="btn btn-outline-primary d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#mobileNav">Menu</button>

        <div class="search">
          <i class="bi bi-search"></i>
          <input placeholder="Search projects, vendors…" />
        </div>

        <div class="dropdown">
          <button class="btn btn-light d-flex align-items-center gap-2" data-bs-toggle="dropdown">
            <!-- <img src="https://i.pravatar.cc/40?img=64" class="rounded-circle border" width="36" height="36" alt="avatar"> -->
            <div class="d-none d-md-block text-start">
              <p class="mb-0 fw-semibold text-dark" style="font-size: 0.875rem;">{{ $vendor->name ?? 'Engineer' }}</p>
              <p class="mb-0 text-muted" style="font-size: 0.75rem;">{{ $vendor->mobile ?? '' }}</p>
            </div>
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
      <div class="p-4">
        @yield('content')
      </div>

      {{-- Mobile Sidebar --}}
      <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileNav">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title">Menu</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column">
          <div class="list-group mb-3">
            <a class="list-group-item list-group-item-action" href="">Dashboard</a>
            <a class="list-group-item list-group-item-action" href="">My Profile</a>
            <a class="list-group-item list-group-item-action" href="">Leads / Bids</a>
            <a class="list-group-item list-group-item-action" href="">Projects</a>
            <a class="list-group-item list-group-item-action" href="">Payments</a>
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
