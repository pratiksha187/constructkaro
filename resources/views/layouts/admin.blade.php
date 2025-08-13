<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>@yield('title','ConstructKaro • Admin')</title>

  {{-- Fonts + Bootstrap --}}
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>

  {{-- Brand theme (from your homepage colors) --}}
  <style>
    :root{
      --ck-orange:#FF6600;
      --ck-navy:#0B2240;
      --ck-blue:#2949E9;
      --ck-bg:#F5F7FB;
      --ck-card:#FFFFFF;
      --ck-text:#0B2240;
      --ck-muted:#6B7A90;
      --bs-primary:var(--ck-orange);
      --bs-secondary:var(--ck-navy);
    }
    html,body{height:100%}
    body{
      font-family:'Inter',system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial,sans-serif;
      background:
        radial-gradient(1200px 800px at 10% -10%,#eef3ff 0%,rgba(238,243,255,0) 60%),
        radial-gradient(1200px 800px at 110% 10%,#fef3e9 0%,rgba(254,243,233,0) 60%),
        var(--ck-bg);
      color:var(--ck-text);
    }
    .layout{display:grid;grid-template-columns:260px 1fr;min-height:100%}
    @media (max-width:992px){.layout{grid-template-columns:1fr}}

    /* Sidebar */
    .sidebar{background:var(--ck-navy);color:#c9d5ea;position:sticky;top:0;height:100dvh;padding-bottom:1rem}
    .brand{display:flex;align-items:center;gap:.6rem;padding:1rem 1.25rem;color:#fff;text-decoration:none;border-bottom:1px solid rgba(255,255,255,.08)}
    .brand .dot{width:34px;height:34px;border-radius:10px;background:linear-gradient(135deg,var(--ck-orange),var(--ck-blue));display:grid;place-items:center;color:#fff;font-weight:700}
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

    /* Cards + table */
    .kpi-card{background:var(--ck-card);border:1px solid #e9eef7;border-radius:1rem;padding:1.25rem;position:relative;overflow:hidden}
    .kpi-card::before{content:\"\";position:absolute;inset:0;top:-60%;height:140%;background:conic-gradient(from 180deg at 50% 0%,rgba(255,102,0,.15),rgba(41,73,233,.15),rgba(255,102,0,.15));filter:blur(40px);opacity:.35}
    .kpi-title{color:var(--ck-muted);font-size:.9rem}
    .kpi-value{font-size:2rem;font-weight:700;color:var(--ck-text)}
    .kpi-trend{font-size:.9rem;font-weight:600;color:var(--ck-blue)}
    .card{border:1px solid #e9eef7;border-radius:1rem;overflow:hidden;box-shadow:0 8px 24px rgba(12,33,72,.06)}
    .card-header{background:linear-gradient(180deg,rgba(255,102,0,.06),rgba(41,73,233,.06));border-bottom:1px solid #e9eef7}
    .table>:not(caption)>*>*{padding:.9rem .75rem}
    .badge-soft{background:rgba(41,73,233,.12);color:var(--ck-blue)}
    .badge-dim{background:rgba(11,34,64,.08);color:var(--ck-navy)}
    .footer{color:var(--ck-muted);font-size:.85rem}
    .btn-primary{--bs-btn-bg:var(--ck-orange);--bs-btn-border-color:var(--ck-orange);--bs-btn-hover-bg:#e65c00;--bs-btn-hover-border-color:#e65c00}
    .btn-outline-primary{--bs-btn-color:var(--ck-orange);--bs-btn-border-color:var(--ck-orange);--bs-btn-hover-bg:var(--ck-orange);--bs-btn-hover-border-color:var(--ck-orange)}
  </style>

  @stack('styles')
</head>
<body>
  <div class="layout">
 
    @include('partials.adminsidebar')


    <main class="bg-transparent">
     
      @include('partials.adminheader')

      {{-- Page content --}}
      <div class="container-fluid px-4 pb-5">
        @yield('content')
        {{-- Footer --}}
        @include('partials.adminfooter')
      </div>
    </main>
  </div>

  {{-- Scripts --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  @stack('scripts')
</body>
</html>
