@extends('layouts.app')

@section('title', 'Home | ConstructKaro')

@section('content')
<style>
  @keyframes fadeInUp {
    0% {
      transform: translateY(20px) scale(0.9);
      opacity: 0;
    }
    100% {
      transform: translateY(0) scale(1);
      opacity: 1;
    }
  }
  .animate-fadeInUp {
    animation: fadeInUp 0.6s ease-out forwards;
  }
  .stat-label {
    font-size: 0.900rem;
    color: #ea580c;
    margin-bottom: 0.5rem;
}
</style>
      <section class="min-h-screen flex items-center justify-center px-6 py-16">
         <div class="max-w-7xl w-full grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <!-- Left: Text Content -->
            <div>
               <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-6">
                  Build Smart. 
                  <span class="text-blue-600">Hire Verified</span> 
                  <span class="text-orange-500">Construction Vendors</span> Instantly.
               </h1>
               <p class="text-gray-600 text-lg mb-8">
                  Connect with trusted professionals for your construction projects.
                  Get quotes, compare contractors, and start building today.
               </p>
               <div class="flex gap-4 mb-10 flex-wrap">
                  <a href="{{ route('customer_basic_info') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow font-semibold">
                  Post a Project
                  </a>
                  <a href="{{route('vendor')}}" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg shadow font-semibold">
                  Join as Vendor
                  </a>
               </div>
              
            </div>
           
            <div class="relative">
               <div class="bg-gradient-to-br from-blue-50 to-orange-50 rounded-3xl p-6 shadow-xl relative h-[350px]"> 
                  
                  <video controls autoplay muted loop 
                        class="w-full h-full object-cover rounded-2xl">
                     <source src="logo/intro.mp4" type="video/mp4">
                     Your browser does not support the video tag.
                  </video>
               </div>

               <!-- Badge: Verified -->
               <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2">
                  <span class="bg-blue-600 text-white text-sm px-3 py-1 rounded-full shadow-md">
                     Verified ✓
                  </span>
               </div>

               <!-- Badge: Instant Match -->
               <div class="absolute bottom-0 left-0 translate-y-1/2 -translate-x-1/2">
                  <span class="bg-orange-500 text-white text-sm px-3 py-1 rounded-full shadow-md">
                     Instant Match
                  </span>
               </div>
            </div>

         </div>
      </section>
      <section class="hero-section py-5">
         <div class="container-xl">
            <div class="text-center">
             
               <div class="hero-content">
                    <h2 class="hero-title">
                        Build Smart. Build <span class="text-gradient">Right.</span>
                    </h2>
                    <p class="hero-subtitle">
                        Connect with verified construction professionals, manage your projects seamlessly, 
                        and turn your vision into reality — all on India's most trusted construction platform.
                    </p>
               </div>

               <!-- Stats Cards -->
               <div class="row g-4 mt-5" id="statsCards">
                  <!-- Verified Vendors -->
                  <div class="col-6 col-lg-3">
                     <div class="card stats-card">
                        <div class="card-body text-center">
                           <div class="stat-icon stat-icon-blue">
                              <i data-lucide="users"></i>
                           </div>
                           <div class="stat-content">
                              <p class="stat-value">50+</p>
                              <p class="stat-label">Verified Vendors</p>
                              <small class="text-muted d-block">
                                 Contractors, Architects, Interior Designers, Surveyors & more
                              </small>
                           </div>
                        </div>
                     </div>
                  </div>

                  <!-- Transparent Bidding -->
                  <div class="col-6 col-lg-3">
                     <div class="card stats-card">
                        <div class="card-body text-center">
                           <div class="stat-icon stat-icon-green">
                              <i data-lucide="check-circle"></i>
                           </div>
                           <div class="stat-content">
                              <p class="stat-value">100%</p>
                              <p class="stat-label">Transparent Bidding</p>
                              <small class="text-muted d-block">
                                 No fake leads. </small>
                                 <small class="text-muted d-block">
                                 Pay only when you win work .
                              </small>
                           </div>
                        </div>
                     </div>
                  </div>

                  <!-- Zero Registration Fees -->
                  <div class="col-6 col-lg-3">
                     <div class="card stats-card">
                        <div class="card-body text-center">
                           <div class="stat-icon stat-icon-orange">
                              <i data-lucide="badge-check"></i>
                           </div>
                           <div class="stat-content">
                              <p class="stat-value">Zero</p>
                              <p class="stat-label">Registration Fees</p>
                              <small class="text-muted d-block">
                                 Vendors join for free. Customers post projects free.
                              </small>
                           </div>
                        </div>
                     </div>
                  </div>

                  <!-- Active Regions -->
                  <div class="col-6 col-lg-3">
                     <div class="card stats-card">
                        <div class="card-body text-center">
                           <div class="stat-icon stat-icon-purple">
                              <i data-lucide="map-pin"></i>
                           </div>
                           <div class="stat-content">
                              <p class="stat-value">8+ Regions</p>
                              <p class="stat-label">Active Locations</p>
                              <small class="text-muted d-block">
                                 Mumbai • Raigad • Pune • Mumbai Suburban • Palghar • Thane • Navi Mumbai  expanding soon
                              </small>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

            </div>
         </div>
      </section>
      <section class="content-section py-5">
         <div class="container-xl">
            <!-- Custom Tab Navigation -->
            <div class="text-center mb-5">
               <div class="custom-tabs">
                  <button class="tab-btn active" data-tab="services">Services</button>
                  <button class="tab-btn" data-tab="projects">Featured Projects</button>
               </div>
            </div>
            <!-- Services Tab Content -->
            <div id="services-content" class="tab-content active">
               <div class="text-center mb-5">
                  <h3 class="section-title">Our Services</h3>
                  <p class="section-subtitle">
                     Comprehensive construction services with verified professionals across all specializations
                  </p>
               </div>
               <div class="row g-4" id="servicesGrid">
                  <!-- Services will be populated by JavaScript -->
               </div>
            </div>
            <!-- Projects Tab Content -->
            <div id="projects-content" class="tab-content">
               <div class="text-center mb-5">
                  <h3 class="section-title">Featured Projects</h3>
                  <p class="section-subtitle">
                     Explore successful projects completed through our platform
                  </p>
               </div>
               <div class="row g-4" id="projectsGrid">
                  <!-- Projects will be populated by JavaScript -->
               </div>
            </div>
         </div>
      </section>
      <section class="cta-section py-5">
         <div class="container-xl">
            <div class="row justify-content-center">
               <div class="col-lg-8">
                  <div class="card cta-card">
                     <div class="card-body text-center text-white position-relative">
                        <!-- Background Pattern -->
                        <div class="cta-pattern"></div>
                        <div class="position-relative">
                           <h3 class="cta-title">Ready to Start Your Project?</h3>
                           <p class="cta-subtitle">
                              Join thousands of satisfied customers who have built their dreams with CONSTRUCTKARO
                           </p>
                           <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center align-items-center">
                             
                              <button type="button" class="btn btn-primary btn-lg cta-btn-primary"
                                    onclick="window.location='{{ route('project') }}'">
                                 Start Building Now
                              </button>

                              <button class="btn btn-outline-light btn-lg cta-btn-secondary">
                              Learn More
                              </button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- ✅ Login Modal -->
      <div id="loginModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
      <div class="bg-white rounded-3xl shadow-2xl p-8 w-full max-w-md transition-all duration-500 ease-out animate-fadeInUp relative">
         
         <!-- Animated Logo -->
         <div class="flex justify-center mb-6">
            <img src="logo/bg.png" alt="Logo" class="w-20 h-20 animate-bounce" />
         </div>

         <!-- Heading -->
         <h2 class="text-2xl font-bold text-center text-gray-800 mb-4">Welcome to ConstructKaro</h2>
         <p class="text-center text-gray-500 mb-6">Login as:</p>

         <!-- Buttons -->
         <div class="flex flex-col space-y-4">
            <a href="{{route('login')}}" class="bg-blue-600 hover:bg-blue-700 text-white text-center py-3 rounded-lg font-semibold transition">
            Vendor/Customer
            </a>
         
         </div>

         <!-- Close Button -->
         <button onclick="closeLoginModal()" class="absolute top-2 right-3 text-gray-400 hover:text-gray-600 text-xl">&times;</button>
      </div>
      </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
  window.addEventListener('DOMContentLoaded', () => {
    // Delay for 3000 milliseconds (3 seconds)
    setTimeout(() => {
      const modal = document.getElementById('loginModal');
      modal.classList.remove('hidden');
    }, 7000);
  });

  function closeLoginModal() {
    document.getElementById('loginModal').classList.add('hidden');
  }
  


   const emailInput = document.getElementById('email');
   const suggestionsBox = document.getElementById('suggestions');
   
   const domains = [
     'gmail.com', 'yahoo.com', 'rediffmail.com', 'outlook.com', 'hotmail.com',
     'live.com', 'aol.com', 'icloud.com', 'protonmail.com', 'mail.com',
     'zoho.com', 'gmx.com', 'yandex.com', 'msn.com', 'inbox.com', 'me.com'
   ];
   
   emailInput.addEventListener('input', function () {
     const value = this.value;
     const atIndex = value.indexOf('@');
   
     if (atIndex !== -1 && !value.includes('.', atIndex)) {
       const username = value.slice(0, atIndex + 1); // include @
       suggestionsBox.innerHTML = '';
       domains.forEach(domain => {
         const item = document.createElement('a');
         item.className = 'dropdown-item';
         item.textContent = username + domain;
         item.onclick = () => {
           emailInput.value = item.textContent;
           suggestionsBox.style.display = 'none';
         };
         suggestionsBox.appendChild(item);
       });
       suggestionsBox.style.display = 'block';
     } else {
       suggestionsBox.style.display = 'none';
     }
   });
   
   document.addEventListener('click', (e) => {
     if (!suggestionsBox.contains(e.target) && e.target !== emailInput) {
       suggestionsBox.style.display = 'none';
     }
   });
</script>

@endsection