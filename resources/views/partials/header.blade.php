<style>
  .navbar-brand img {
    height: 183px;
    width: 214px;
    object-fit: contain;
}

  .navbar-brand {
    height: 70px; /* or use default height of your navbar */
    display: flex;
    align-items: center;
  }
   </style>
<header class="navbar navbar-expand-lg custom-header">

   <div class="container-fluid">
      <!-- <div class="navbar-brand d-flex align-items-center">
         <a class="navbar-brand d-flex align-items-center ms-0" href="#" style="height: 100%;">
            <img src="{{ asset('logo/bg.png') }}" alt="ConstructKaro Logo" >
         </a>
      </div> -->
      <div class="navbar-brand">
         <a class="d-flex align-items-center" href="#">
            <img src="{{ asset('logo/bg.png') }}" alt="ConstructKaro Logo">
         </a>
      </div>

      <!-- Search Bar -->
     
   <nav class="navbar-nav d-none d-lg-flex flex-row align-items-center">
      <a href="{{ url('/') }}" class="nav-link">Home</a>
      <a href="" class="nav-link">About Us</a>
      <a href="" class="nav-link">Education for Customers</a>
      <a href="" class="nav-link">Education for Vendors</a>
      <a href="" class="nav-link">Contact Us</a>

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
