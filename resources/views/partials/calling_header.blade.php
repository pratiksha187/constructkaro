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
<!--  -->
<header class="navbar fixed-top navbar-expand-lg custom-header">
  <div class="container-fluid justify-content-between">

    <!-- Logo -->
    <div class="navbar-brand">
      <a href="#">
        <img src="{{ asset('logo/bg.png') }}" alt="ConstructKaro Logo">
      </a>
    </div>

    <!-- Right Side: Profile Dropdown -->
    <div class="navbar-right d-none d-lg-flex">
      <div class="dropdown">
        <!-- 🔹 Profile image acts as toggle -->
        <a class="d-flex align-items-center text-decoration-none dropdown-toggle" 
           href="#" id="profileDropdown" 
           data-bs-toggle="dropdown" aria-expanded="false">
          <!-- <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&h=150&fit=crop&crop=face"
               alt="" class="rounded-circle me-2" width="40" height="40"> -->
          <div class="d-none d-md-block">
            <p class="mb-0 fw-semibold text-dark" style="font-size: 0.875rem;"></p>
            <p class="mb-0 text-muted" style="font-size: 0.75rem;"></p>
          </div>
        </a>

        <!-- 🔹 Dropdown menu -->
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
          <li><a class="dropdown-item" href="#">Profile</a></li>
         
          <li><hr class="dropdown-divider"></li>
         
           <li class="px-3">
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger w-100">Log out</button>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

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
