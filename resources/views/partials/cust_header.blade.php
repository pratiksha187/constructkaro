<style>
  :root {
    --primary: #f25c05;
    --dark: #1c2c3e;
    --light: #ffffff;
    --muted: #6b7280;
  }

  /* ================= HEADER ================= */
  .custom-header {
    height: 70px;
    background-color: var(--light);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    position: sticky;
    top: 0;
    z-index: 1100;
    border-bottom: 2px solid rgba(242, 92, 5, 0.1);
  }

  .navbar-brand img {
    height: 60px;
    object-fit: contain;
    transition: transform 0.2s ease-in-out;
  }

  .navbar-brand img:hover {
    transform: scale(1.05);
  }

  /* ================= PROFILE ================= */
  .navbar-right {
    display: flex;
    align-items: center;
    gap: 1.5rem;
  }

  .dropdown-toggle::after {
    display: none;
  }

  .profile-box {
    display: flex;
    align-items: center;
    background: #f9fafb;
    border-radius: 10px;
    border: 1px solid #e5e7eb;
    padding: 0.4rem 0.8rem;
    cursor: pointer;
    transition: 0.3s;
  }

  .profile-box:hover {
    background: #fff3e6;
    border-color: var(--primary);
  }

  .profile-info p {
    margin: 0;
    line-height: 1.2;
  }

  .profile-name {
    font-weight: 600;
    color: var(--dark);
    font-size: 0.9rem;
  }

  .profile-phone {
    color: var(--muted);
    font-size: 0.8rem;
  }

  /* ================= DROPDOWN ================= */
  .dropdown-menu {
    border-radius: 10px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.08);
    border: 1px solid #f0f0f0;
    animation: fadeIn 0.2s ease-in-out;
  }

  @keyframes fadeIn {
    from {opacity: 0; transform: translateY(5px);}
    to {opacity: 1; transform: translateY(0);}
  }

  .dropdown-item {
    font-size: 0.9rem;
    border-radius: 8px;
    padding: 0.6rem 0.9rem;
    transition: 0.2s;
  }

  .dropdown-item:hover {
    background-color: #fff3e6;
    color: var(--primary);
  }

  /* ================= ADD PROJECT BUTTON ================= */
  .add-project-btn {
    background-color: var(--primary);
    color: white;
    border: none;
    padding: 0.55rem 1.25rem;
    border-radius: 50px;
    cursor: pointer;
    font-size: 0.95rem;
    font-weight: 500;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .add-project-btn:hover {
    background-color: #d84f03;
    transform: translateY(-1px);
  }

  .add-project-btn i {
    font-size: 1rem;
  }

  /* ================= MOBILE ================= */
  @media (max-width: 991.98px) {
    .add-project-btn {
      display: none;
    }
  }
</style>

<header class="navbar navbar-expand-lg custom-header px-3">
  <div class="container-fluid justify-content-between align-items-center">

    <!-- 🔹 Left: Logo -->
    <a class="navbar-brand d-flex align-items-center" href="{{ route('customer.dashboard') }}">
      <img src="{{ asset('logo/bg.png') }}" alt="ConstructKaro Logo">
    </a>

    <!-- 🔸 Right: Profile + Button -->
    <div class="navbar-right d-none d-lg-flex">

    

      <!-- Add Project Button -->
      <button class="add-project-btn" onclick="window.location.href='{{ route('project') }}'">
        <i class="bi bi-plus-circle"></i> Add New Project
      </button>


        <!-- Profile Dropdown -->
      <div class="dropdown">
        <a class="d-flex align-items-center text-decoration-none dropdown-toggle" href="#" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          <div class="profile-box">
            <div class="profile-info">
              <p class="profile-name">{{ $cust_details->full_name ?? 'User' }}</p>
              <p class="profile-phone">{{ $cust_details->phone_number ?? '' }}</p>
            </div>
          </div>
        </a>

        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
          <li><a class="dropdown-item" href="{{ route('customer.dashboard') }}"><i class="bi bi-house-door me-2 text-orange"></i>Dashboard</a></li>
          <!-- <li><a class="dropdown-item" href="#"><i class="bi bi-person-circle me-2 text-orange"></i>Profile</a></li>
          <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2 text-orange"></i>Settings</a></li> -->
          <li><hr class="dropdown-divider"></li>
          <li class="px-3">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="btn btn-outline-danger w-100"><i class="bi bi-box-arrow-right me-1"></i>Logout</button>
            </form>
          </li>
        </ul>
      </div>
    </div>

    <!-- Mobile Toggle -->
    <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
  </div>
</header>

<!-- ✅ Bootstrap JS (Already in app.blade.php) -->
<script>
  // No manual toggle needed; Bootstrap handles it automatically.
  document.addEventListener('DOMContentLoaded', function () {
    const dropdowns = document.querySelectorAll('[data-bs-toggle="dropdown"]');
    dropdowns.forEach(el => new bootstrap.Dropdown(el));
  });
</script>
