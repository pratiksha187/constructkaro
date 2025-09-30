<style>
  /* tweak these two values only */
  :root{
    --brand-logo-w: 200px; /* logo box width  */
    --brand-logo-h: 56px;  /* logo box height */
  }

  /* optional: keep a consistent header row for the logo */
  .brand {
    height: calc(var(--brand-logo-h) + 24px);
    padding: 12px 20px;
    display: flex;
    align-items: center;
    border-bottom: 1px solid rgba(255,255,255,.08);
  }

  /* the actual image sizing */
  .brand-logo{
    width:  var(--brand-logo-w);
    height: var(--brand-logo-h);
    display: block;
    object-fit: contain;   /* keeps aspect ratio inside the box */
  }

  /* active link style left as-is */
  .side-link.active{
    background: linear-gradient(90deg, rgba(255,102,0,.18), rgba(41,73,233,.18));
    color: #fff;
    border-left: 3px solid #FF6600;
  }
</style>

<aside class="sidebar d-none d-lg-block">
  <!-- Logo row (clickable). If you don't want it clickable, replace <a> with <div class="brand"> -->
  <a class="brand" href="{{ url('/') }}" aria-label="ConstructKaro Home">
    <img
      class="brand-logo"
      src="{{ asset('logo/bg.png') }}"
      alt="ConstructKaro Logo"
      width="200" height="56"  {{-- matches the CSS vars; helps layout stability --}}
    >
  </a>

  <div class="nav-section">
    <div class="title">Dashboard</div>
    <a class="side-link {{ request()->routeIs('admin_dashboard') ? 'active' : '' }}"
       href="{{ route('admin_dashboard') }}">
      <svg class="side-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" width="18" height="18">
        <path d="M3 12l9-9 9 9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
        <path d="M9 21V9h6v12" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
      </svg>
      Overview
    </a>
  </div>

  <div class="nav-section">
    <div class="title">Vendor</div>
    <a class="side-link {{ request()->routeIs('vender_approve_form') ? 'active' : '' }}"
       href="{{ route('vender_approve_form') }}">Register</a>
    <a class="side-link {{ request()->routeIs('vender_approve_data') ? 'active' : '' }}"
       href="{{ route('vender_approve_data') }}">Approve Vendor</a>
    <a class="side-link {{ request()->routeIs('vender_reject_data') ? 'active' : '' }}"
       href="{{ route('vender_reject_data') }}">Reject Vendor</a>


    <div class="title">Add </div>
    <a class="side-link {{ request()->routeIs('worktype') ? 'active' : '' }}"
       href="{{ route('worktype') }}">Work Type</a>
    
  </div>
</aside>
