<style>
  .navbar-brand img {
    height: 60px;
    width: auto;
    object-fit: contain;
  }
  .navbar-brand {
    height: 70px;
    display: flex;
    align-items: center;
  }

  .collapse {
    visibility: visible;
  }
  @media (min-width: 576px) {
    .modal-dialog.modal-md { max-width: 738px; } 
  }
</style>

<header class="navbar navbar-expand-lg navbar-light bg-white shadow-sm custom-header">
  <div class="container-fluid">
    <!-- Brand -->
    <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
      <img src="{{ asset('logo/bg.png') }}" alt="ConstructKaro Logo">
    </a>

    <!-- Mobile Toggle Button -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Collapsible Menu -->
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
        <li class="nav-item"><a href="{{ route('about_us') }}" class="nav-link">About Us</a></li>
        <li class="nav-item"><a href="{{ url('contactus') }}" class="nav-link">Contact Us</a></li>
        <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Login</a></li>
        <li class="nav-item">
          <a href="{{ route('customer_basic_info') }}" class="btn btn-primary ms-lg-3 mt-2 mt-lg-0">
            Post Project
          </a>
        </li>
      </ul>
    </div>
  </div>
</header>
