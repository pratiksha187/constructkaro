<style>
    .navbar-brand img {
    height: 183px;
    width: 214px;
    object-fit: contain;
}

@media (min-width: 768px) {
    .col-md-2 {
        flex: 1 0 auto;
        width: 16.66666667%;
    }
}
</style>
<footer class="custom-footer">
         <div class="container-xl">
            <div class="row g-4">
               <div class="col-md-3">
                  <div class="footer-brand">
                     <div class="d-flex align-items-center mb-3">
                        
                        <h4 class="footer-brand-text mb-0">
                           <div class="navbar-brand">
                              <a class="d-flex align-items-center" href="#">
                                 <img src="{{ asset('logo/bg.png') }}" alt="ConstructKaro Logo">
                              </a>
                           </div> 
                        </h4>
                     </div>
                     <p class="footer-description">
                        Building the future of construction through technology and trusted partnerships.
                     </p>
                  </div>
               </div>
               <div class="col-md-2">
                  <!-- <h5 class="footer-heading">Education</h5>
                  <div class="footer-links">
                     <a href="#" class="footer-link">Education for Customer</a>
                     <a href="#" class="footer-link">Education for Vendor</a>
                    
                  </div> -->
               </div>
               <div class="col-md-2">
                  <h5 class="footer-heading">Company</h5>
                  <div class="footer-links">
                     <a href="{{route('about_us')}}" class="footer-link">About Us</a>
                     <a href="#" class="footer-link">Careers</a>
                     <a href="#" class="footer-link">Press</a>
                     <a href="#" class="footer-link">Blog</a>
                  </div>
               </div>
               <div class="col-md-2">
                  <h5 class="footer-heading">Contact</h5>
                  <div class="footer-contacts">
                     <div class="footer-contact">
                        <i data-lucide="phone"></i>
                        <span>+91 8446115797</span>
                     </div>
                     <div class="footer-contact">
                        <i data-lucide="mail"></i>
                        <span>hello@constructkaro.com</span>
                     </div>
                  </div>
               </div>
            </div>
            <div class="footer-bottom">
               <div class="row align-items-center">
                  <div class="col-md-6">
                     <p class="footer-copyright">© 2025 CONSTRUCTKARO. All rights reserved.</p>
                  </div>
                  <div class="col-md-6 text-md-end">
                     <div class="footer-legal">
                        <!-- <a href="#" class="footer-link">Privacy Policy</a> -->
                         <a href="{{ route('privacy.policy') }}" target="_blank" class="footer-link">Privacy Policy</a>
                        <a href="#" class="footer-link">Terms of Service</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </footer>