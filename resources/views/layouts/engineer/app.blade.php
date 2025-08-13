{{-- resources/views/layouts/engineer/app.blade.php --}}
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Engineer • ConstructKaro')</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

  <style>
    :root{ --ck-orange:#FF6600; --ck-navy:#0B2240; --ck-blue:#2949E9; --ck-bg:#F5F7FB; }
    html,body{height:100%}
    body{
      background: radial-gradient(1200px 800px at 10% -10%, #eef3ff 0%, rgba(238,243,255,0) 60%),
                  radial-gradient(1200px 800px at 110% 10%, #fef3e9 0%, rgba(254,243,233,0) 60%),
                  var(--ck-bg);
      color:#0B2240;
      font-family: system-ui,-apple-system,Segoe UI,Inter,Roboto,Helvetica,Arial,sans-serif;
    }
    .layout{display:grid;grid-template-columns:260px 1fr;min-height:100%;}
    @media (max-width:992px){.layout{grid-template-columns:1fr}}

    /* Sidebar */
    .sidebar{background:var(--ck-navy);color:#c9d5ea;position:sticky;top:0;height:100dvh;padding-bottom:1rem}
    .brand{height:72px;padding:0 1.25rem;display:flex;align-items:center;border-bottom:1px solid rgba(255,255,255,.08)}
    .brand-logo{max-height:155px;width:175px;display:block;object-fit:contain}
    .nav-section{padding:1rem .75rem}
    .nav-section .title{font-size:.75rem;letter-spacing:.08em;color:#8ea3c7;text-transform:uppercase;padding:.5rem .75rem}
    .side-link{color:#c9d5ea;border-radius:.75rem;padding:.65rem .75rem;display:flex;align-items:center;gap:.6rem;text-decoration:none}
    .side-link:hover{background:rgba(255,255,255,.06);color:#fff}
    .side-link.active{background:linear-gradient(90deg,rgba(255,102,0,.18),rgba(41,73,233,.18));color:#fff;border-left:3px solid var(--ck-orange)}
    .side-icon{width:18px;height:18px;opacity:.9}

    /* Topbar */
    .topbar{padding:1rem 1.25rem;display:flex;align-items:center;justify-content:space-between;gap:1rem}
    .search{display:flex;align-items:center;gap:.5rem;background:#fff;border:1px solid #e7ecf7;border-radius:.75rem;padding:.5rem .75rem;flex:1;max-width:560px}
    .search input{border:none;outline:none;width:100%;font-size:.95rem}

    .btn-primary{--bs-btn-bg:var(--ck-orange);--bs-btn-border-color:var(--ck-orange);--bs-btn-hover-bg:#e65c00;--bs-btn-hover-border-color:#e65c00}
    .btn-outline-primary{--bs-btn-color:var(--ck-orange);--bs-btn-border-color:var(--ck-orange);--bs-btn-hover-bg:var(--ck-orange);--bs-btn-hover-border-color:var(--ck-orange);--bs-btn-hover-color:#fff}
  </style>

  @stack('styles')
</head>
<body>
  <div class="layout">
    {{-- Sidebar --}}
    <aside class="sidebar d-none d-lg-block">
      <a class="brand" href="{{ url('/') }}" aria-label="ConstructKaro Home">
        <img class="brand-logo" src="{{ asset('logo/bg.png') }}" alt="ConstructKaro Logo">
      </a>

      <div class="nav-section">
        <div class="title">Dashboard</div>
        
      </div>

      <div class="nav-section">
        <div class="title">Project</div>
        <a class="side-link {{ request()->routeIs('engineer.projects.*') ? 'active' : '' }}" href="{{ route('NewProject') }}">Projects</a>
      </div>

      <div class="nav-section">
        <div class="title">BOQ</div>
        <a class="side-link {{ request()->routeIs('engineer.boq.*') ? 'active' : '' }}" href="{{ route('NewProjectBoq') }}">BOQ List</a>
      </div>
    </aside>

    {{-- Main --}}
    <main class="bg-transparent">
      {{-- Topbar --}}
      <div class="topbar container-fluid">
        <button class="btn btn-outline-primary d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#mobileNav">Menu</button>

        <div class="search">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="11" cy="11" r="7" stroke="#8ea3c7" stroke-width="1.6"/><path d="M20 20l-3.2-3.2" stroke="#8ea3c7" stroke-width="1.6" stroke-linecap="round"/>
          </svg>
          <input placeholder="Search projects, vendors…">
        </div>

        <div class="dropdown">
          <button class="btn btn-light d-flex align-items-center gap-2" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://i.pravatar.cc/40?img=64" class="rounded-circle border" width="36" height="36" alt="avatar">
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

      {{-- Page content --}}
      @yield('content')

      {{-- Mobile offcanvas --}}
      <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileNav">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title">Menu</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column">
          <div class="list-group mb-3">
            <a class="list-group-item list-group-item-action {{ request()->routeIs('engineer.dashboard') ? 'active' : '' }}" href="">Dashboard</a>
            <a class="list-group-item list-group-item-action" href="{{ route('NewProject') }}">Projects</a>
            <a class="list-group-item list-group-item-action" href="">BOQ</a>
          </div>
          <form method="POST" action="{{ route('logout') }}" class="mt-auto">@csrf
            <button type="submit" class="list-group-item list-group-item-action btn btn-danger w-100">Log out</button>
          </form>
        </div>
      </div>
    </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  @stack('scripts')
</body>
</html>
