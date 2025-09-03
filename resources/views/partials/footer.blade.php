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
                <h5 class="footer-heading">Education</h5>
                <div class="footer-links">
                    <a href="#" class="footer-link">Education for Customer</a>
                    <a href="#" class="footer-link">Education for Vendor</a>
                </div>
            </div>
            <div class="col-md-2">
                <h5 class="footer-heading">Company</h5>
                <div class="footer-links">
                    <a href="{{ route('about_us') }}" class="footer-link">About Us</a>
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
                        <span>+91 98765 43210</span>
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
                        <!-- Privacy Policy Trigger -->
                        <a href="#" class="footer-link" data-bs-toggle="modal" data-bs-target="#privacyModal">
                            Privacy Policy
                        </a>
                        <a href="#" class="footer-link">Terms of Service</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Privacy Policy Modal -->
<div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">

      <!-- Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="privacyModalLabel">Privacy Policy</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Body with PDF -->
      <div class="modal-body" style="height: 80vh;">
       
<iframe id="privacyFrame" src="{{ asset('logo/pdfs/Privacy.pdf') }}" 
          style="width: 100%; height: 100%;" 
          frameborder="0"></iframe>
        <!-- Fallback Message -->
        <div id="pdfFallback" style="display: none; text-align: center; padding: 40px;">
            <p class="text-danger fw-bold">⚠️ Unable to display PDF. Please download it below.</p>
        </div>
      </div>

    
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
