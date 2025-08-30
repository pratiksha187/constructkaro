<style>
  .navbar-brand img {
    height: 183px;
    width: 214px;
    object-fit: contain;
  }
  .navbar-brand {
    height: 70px; 
    display: flex;
    align-items: center;
  }
   @media (min-width: 576px) {
    .modal-dialog.modal-md { max-width: 738px; } 
  }
</style>

<header class="navbar navbar-expand-lg custom-header">
  <div class="container-fluid">
    <div class="navbar-brand">
      <a class="d-flex align-items-center" href="#">
        <img src="{{ asset('logo/bg.png') }}" alt="ConstructKaro Logo">
      </a>
    </div>

    <nav class="navbar-nav d-none d-lg-flex flex-row align-items-center">
      <a href="{{ url('/') }}" class="nav-link">Home</a>
      <a href="" class="nav-link">About Us</a>

      <!-- These two trigger the modal -->
      <a href="#" class="nav-link soon-link"
         data-title="Education for Customers"
         data-body="We’re preparing step-by-step guides, checklists, and how-tos tailored for customers.">
        Education for Customers
      </a>

      <a href="#" class="nav-link soon-link"
         data-title="Education for Vendors"
         data-body="We’re curating resources, documentation, and best practices to help vendors succeed on ConstructKaro.">
        Education for Vendors
      </a>

      <a href="{{ url('contactus') }}" class="nav-link">Contact Us</a>
      <a href="{{ route('login') }}" class="nav-link">Login</a>
      <button type="button" class="btn btn-primary ms-3" onclick="window.location='{{ route('project') }}'">
        Post Project
      </button>
    </nav>

    <!-- Mobile menu button -->
    <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
  </div>
</header>

<!-- Coming Soon Modal (place once per page) -->
<div class="modal fade" id="comingSoonModal" tabindex="-1" aria-labelledby="comingSoonLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content border-0 rounded-4">
      <div class="modal-header border-0">
        <h5 class="modal-title" id="comingSoonLabel">Coming soon</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="d-flex align-items-start">
          <div class="me-3 fs-1">🚧</div>
          <div>
            <p class="mb-2" id="comingSoonMessage">
              We’re building this page for you. Check back shortly.
            </p>
            <small class="text-muted">
              Want a heads-up when it goes live? <a href="{{ url('contactus') }}">Contact us</a>.
            </small>
          </div>
        </div>
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Script: wire up the links to the modal -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Ensure Bootstrap JS is available
    if (typeof bootstrap === 'undefined' || !bootstrap.Modal) {
      console.warn('Bootstrap Modal not found. Make sure bootstrap.bundle.min.js is included.');
      return;
    }

    const modalEl   = document.getElementById('comingSoonModal');
    const titleEl   = document.getElementById('comingSoonLabel');
    const messageEl = document.getElementById('comingSoonMessage');
    const bsModal   = new bootstrap.Modal(modalEl);

    document.querySelectorAll('.soon-link').forEach(link => {
      link.addEventListener('click', function (e) {
        e.preventDefault();

        const t = this.dataset.title || 'Coming soon';
        const b = this.dataset.body  || 'We’re building this page for you. Check back shortly.';

        titleEl.textContent = t + ' — Coming Soon';
        messageEl.textContent = b;

        bsModal.show();
      });
    });
  });
</script>
