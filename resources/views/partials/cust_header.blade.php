<style>
  .custom-header {
    height: 70px;
    background-color: #fff;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    position: sticky;
    top: 0;
    z-index: 1000;
  }

#notificationsDropdown {
    position: absolute;
    right: 0;
    top: 2.5rem;
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 0.5rem;
    z-index: 999;
}
    .navbar-brand img {
    height: 156px !important;
    width: 214px;
    object-fit: contain;
}

  .navbar-brand {
    display: flex;
    align-items: center;
  }

  .search-container .search-input {
    padding-left: 2.5rem;
    height: 38px;
    font-size: 0.95rem;
  }

  .search-icon {
    position: absolute;
    top: 50%;
    left: 0.75rem;
    transform: translateY(-50%);
    color: #6c757d;
    pointer-events: none;
  }

  .navbar-right {
    display: flex;
    align-items: center;
    gap: 1rem;
  }

  .navbar-right img {
    object-fit: cover;
  }

  .dropdown-toggle::after {
    display: none;
  }

  @media (max-width: 991.98px) {
    .search-container {
      display: none !important;
    }
  }


</style>
<header class="navbar fixed-top navbar-expand-lg custom-header">
  <div class="container-fluid justify-content-between">

    <!-- Logo -->
    <div class="navbar-brand">
      <a href="#">
        <img src="{{ asset('logo/bg.png') }}" alt="ConstructKaro Logo">
      </a>
    </div>

    <!-- Search Bar -->
    <div class="search-container d-none d-md-flex flex-grow-1 mx-4">
      <div class="position-relative w-100">
        <i data-lucide="search" class="search-icon"></i>
        <input type="text" class="form-control search-input" placeholder="Search for services, professionals, or projects..." id="searchInput">
      </div>
    </div>

    <!-- Right Side: Notifications + Profile -->
    <div class="navbar-right d-none d-lg-flex">
      
      <!-- Notification Bell -->
      <div class="position-relative">
        <button class="btn btn-light position-relative" id="notificationBtn">
          <i data-lucide="bell" style="width: 1.25rem; height: 1.25rem;"></i>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notificationBadge">2</span>
        </button>

        <!-- Dropdown (Hidden by default) -->
        <div class="dropdown-menu dropdown-menu-end shadow-sm p-3 mt-2" id="notificationsDropdown" style="min-width: 300px; display: none;">
          <div class="notification-header mb-2">
            <h6 class="mb-1 fw-semibold">Notifications</h6>
            <p class="mb-0 text-muted small">3 unread notifications</p>
          </div>
          <div class="notifications-list" id="notificationsList">
            <!-- JS will populate this -->
          </div>
          <div class="pt-2 border-top">
            <button class="btn btn-link w-100 text-decoration-none text-orange-600 p-0" style="font-size: 0.875rem;">
              View All Notifications
            </button>
          </div>
        </div>
      </div>

      <!-- Profile Dropdown -->
      <div class="dropdown">
        <a class="d-flex align-items-center text-decoration-none" href="#" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&h=150&fit=crop&crop=face"
               alt="Rajesh Kumar" class="rounded-circle me-2" width="40" height="40">
          <div class="d-none d-md-block">
            <p class="mb-0 fw-semibold text-dark" style="font-size: 0.875rem;"></p>
            <p class="mb-0 text-muted" style="font-size: 0.75rem;">Customer</p>
          </div>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
          <li><a class="dropdown-item" href="#">Profile</a></li>
          <li><a class="dropdown-item" href="#">Settings</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item text-danger" href="#" onclick="handleLogout()">
            <i data-lucide="log-out" class="me-1"></i> Logout</a></li>
        </ul>
      </div>
    </div>

    <!-- Mobile Toggle -->
    <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

  </div>
</header>

<script>
  document.getElementById('notificationBtn')?.addEventListener('click', function () {
    const dropdown = document.getElementById('notificationsDropdown');
    dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
  });

  function handleLogout() {
    // Your logout logic here
    console.log("User logged out");
  }
</script>
