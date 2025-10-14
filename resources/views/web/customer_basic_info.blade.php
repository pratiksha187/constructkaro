@extends('layouts.app') @section('title', 'Add Project | ConstructKaro') @section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = { theme: { extend: { colors: { 'custom-blue': '#007bff', 'custom-orange': '#ff6f00' } } } }
</script>
<style>
    #suggestions{background:#fff;border:1px solid #ced4da;border-top:none;border-radius:0 0 .375rem .375rem;max-height:200px;overflow-y:auto;z-index:1000}
       #suggestions div{padding:.5rem 1rem;cursor:pointer}
       #suggestions div:hover,#suggestions .highlight{background:#f0f0f0}
       body{font-family:'Segoe UI',sans-serif}
       .toggle-switch{position:relative;display:inline-block;width:50px;height:24px}
       .toggle-switch input{opacity:0;width:0;height:0}
       .slider{position:absolute;cursor:pointer;inset:0;background:#ccc;transition:.4s;border-radius:24px}
       .slider:before{position:absolute;content:"";height:18px;width:18px;left:3px;bottom:3px;background:#fff;border-radius:50%;transition:.4s}
       input:checked + .slider{background:#007bff}
       input:checked + .slider:before{transform:translateX(26px)}
       .land-details{max-height:0;overflow:hidden;transition:max-height .5s ease,opacity .3s;opacity:0}
       .land-details.show{max-height:1000px;opacity:1}
       .gradient-bg{background:linear-gradient(135deg,#007bff 0%,#0056b3 100%)}
       .section-divider{border-left:4px solid #007bff;padding-left:1rem;margin:2rem 0}
       .form-container{min-height:100vh;background:linear-gradient(135deg,#f8f9fa 0%,#e9ecef 100%)}
       #boq-upload-wrapper{display:none}
       .error-text{font-size:.8rem;color:#dc2626;margin-top:.25rem}
       .has-error{border-color:#dc2626 !important}
       .has-error:focus{box-shadow:0 0 0 3px rgba(220,38,38,.2) !important}
</style>
<div class="form-container">
    <div class="container mx-auto px-6 py-8">
        <div class="bg-white border p-8 lg:p-12 max-w-8xl mx-auto rounded">
            <div class="text-center mb-10">
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
               Tell us your <span class="text-custom-blue">Basic Information</span>
            </h1>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    We gather key details to understand your construction needs and connect you with the right
                    <span class="text-custom-orange font-medium">vendors and professionals</span>.
                </p>
            </div>
            {{-- IMPORTANT: novalidate so our JS shows custom messages --}}
            <form id="projectForm" class="space-y-10" action="{{ route('customer.basicinfo.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                <!-- 1. Basic Information -->
                <div class="section-divider">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                  <!-- <span class="bg-custom-blue text-white rounded-full w-8 h-8 flex items-center justify-center text-sm mr-3"></span> -->
                  Basic Information
                    </h2>
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                            <input type="text" id="full_name" name="full_name" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all" placeholder="Enter your full name">
                        </div>
                        <div class="relative">
                            <label>Mobile Number *</label>
                            <input type="text" name="phone_number" id="phone_number" class="form-control" required maxlength="10" pattern="^(?!0)(?!.*(\d)\1{9})[6-9]\d{9}$" title="Enter a valid 10-digit mobile number (not starting with 0 and not all same digits)">
                            <button type="button" id="sendOtpBtn" class="btn btn-primary mt-2">Send OTP</button>
                        </div>
                        <div class="relative">
                            <label>Enter OTP *</label>
                            <input type="text" id="otp" name="otp" class="form-control" maxlength="6" pattern="\d{6}" title="Enter the 6-digit OTP">
                            <button type="button" id="verifyOtpBtn" class="btn btn-success mt-2">Verify OTP</button>
                            <span id="otpStatus" class="ms-2 fw-bold"></span>
                        </div>

                        <div class="mb-3 position-relative">
                            <label for="email" class="form-label">Email ID *</label>
                            <input type="email" name="email" id="email" class="form-control" required autocomplete="off">

                            <!-- Suggestion dropdown -->
                            <div id="suggestions" class="position-absolute bg-white border rounded w-100 mt-1 shadow-sm hidden" style="z-index: 1000;"></div>

                            <button type="button" id="sendEmailOtpBtn" class="btn btn-primary mt-2">
                                Send Email OTP
                            </button>
                        </div>
                       

                        <div class="relative">
                            <label>Enter Email OTP *</label>
                            <input type="text" id="emailOtp" name="email_otp" class="form-control" maxlength="6">
                            <button type="button" id="verifyEmailOtpBtn" class="btn btn-success mt-2">Verify Email OTP</button>
                        </div>
                         <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Gender *</label>
                            <select name="gender" id="gender" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all">
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Password *</label>
                            <div class="relative">
                                <input type="password" name="password" id="passwordInput" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all" placeholder="Create a password">
                                <button type="button" id="passwordToggleBtn" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none" aria-label="Toggle password visibility">
                                    <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password *</label>
                            <div class="relative">
                                <input type="password" name="password_confirmation" id="confirmPasswordInput" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all" placeholder="Confirm your password">
                                <button type="button" id="confirmPasswordToggleBtn" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none" aria-label="Toggle confirm password visibility">
                                    <svg id="eyeIconConfirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Role *</label>
                            <select required id="role_id" name="role_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all">
                                <option value="">Select your role</option>
                                @foreach($role_types as $role)
                                <option value="{{ $role->id }}">{{ $role->role }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="relative">
                            <label for="state" class="form-label">Select State</label>
                            <select name="state" id="state" class="form-control">
                                <option value="">-- Select State --</option>
                                @foreach ($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="relative">
                            <label for="region" class="form-label">Select Region</label>
                            <select name="region" id="region" class="form-control">
                                <option value="">-- Select Region --</option>
                            </select>
                        </div>
                        <div class="relative">
                            <label for="city" class="form-label">Select City</label>
                            <select name="city" id="city" class="form-control">
                                <option value="">-- Select City --</option>
                            </select>
                        </div>
                    </div>
                </div>
              
                <div class="text-center pt-8 border-t border-gray-200">
                    <button type="submit" class="gradient-bg hover:shadow-2xl text-white px-6 py-2 rounded-md font-semibold text-base transition-all transform hover:scale-105 shadow-md border border-custom-blue">
                        Next →
                    </button>
                    <p class="text-sm text-gray-500 mt-4">
                        We'll connect you with verified
                        <span id="selectedVendor" class="text-custom-orange font-medium">verified contractors</span> within 24 hours
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    /* ---------------- Email Suggestions ---------------- */
      (function () {
        const emailInput = document.getElementById("email");
        const suggestionsBox = document.getElementById("suggestions");
        const domains = [
          "gmail.com","yahoo.com","outlook.com","hotmail.com",
          "icloud.com","protonmail.com","rediffmail.com","mail.com",
          "zoho.com","aol.com"
        ];
        let selectedIndex = -1;
    
        function renderSuggestions(usernameWithAt, filter = "") {
          suggestionsBox.innerHTML = "";
          selectedIndex = -1;
          const list = domains
            .filter(d => d.startsWith(filter.toLowerCase()))
            .map(d => usernameWithAt + d);
    
          if (list.length === 0) {
            suggestionsBox.classList.add("hidden");
            return;
          }
    
          list.forEach((full, idx) => {
            const div = document.createElement("div");
            div.textContent = full;
            div.className = "px-3 py-2 cursor-pointer text-dark bg-white hover-bg-light";
            div.dataset.index = idx;
            div.addEventListener("click", function () {
              emailInput.value = this.textContent;
              suggestionsBox.classList.add("hidden");
              emailInput.focus();
            });
            suggestionsBox.appendChild(div);
          });
          suggestionsBox.classList.remove("hidden");
        }
    
        emailInput.addEventListener("input", function () {
          const value = this.value;
          const atIndex = value.indexOf("@");
          if (atIndex === -1) {
            suggestionsBox.classList.add("hidden");
            return;
          }
    
          const usernameWithAt = value.slice(0, atIndex + 1);
          const typedDomainPart = value.slice(atIndex + 1);
    
          if (typedDomainPart === "" || !typedDomainPart.includes(".") || typedDomainPart.length < 64) {
            renderSuggestions(usernameWithAt, typedDomainPart);
          } else {
            suggestionsBox.classList.add("hidden");
          }
        });
    
        emailInput.addEventListener("keydown", function (e) {
          const items = suggestionsBox.querySelectorAll("div");
          if (suggestionsBox.classList.contains("hidden") || items.length === 0) return;
    
          if (e.key === "ArrowDown") {
            e.preventDefault();
            selectedIndex = (selectedIndex + 1) % items.length;
            updateHighlight(items);
          } else if (e.key === "ArrowUp") {
            e.preventDefault();
            selectedIndex = (selectedIndex - 1 + items.length) % items.length;
            updateHighlight(items);
          } else if (e.key === "Enter") {
            e.preventDefault();
            if (selectedIndex >= 0 && items[selectedIndex]) {
              emailInput.value = items[selectedIndex].textContent;
              suggestionsBox.classList.add("hidden");
            }
          } else if (e.key === "Escape") {
            suggestionsBox.classList.add("hidden");
          }
        });
    
        document.addEventListener("click", function (e) {
          if (!emailInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
            suggestionsBox.classList.add("hidden");
          }
        });
    
        function updateHighlight(items) {
          items.forEach(i => i.classList.remove("bg-light"));
          if (items[selectedIndex]) {
            items[selectedIndex].classList.add("bg-light");
            items[selectedIndex].scrollIntoView({ block: "nearest" });
          }
        }
      })();
</script>
<script>
    /* ---------------- Error helpers (more robust placement) ---------------- */
       function setError(el, msg){
         clearError(el);
         el.classList.add('has-error');
         const p = document.createElement('p');
         p.className = 'error-text';
         p.textContent = msg;
         // Prefer nearest .relative wrapper, else parent, else after element
         const wrap = el.closest('.relative') || el.parentElement;
         if (wrap) wrap.appendChild(p); else el.insertAdjacentElement('afterend', p);
       }
       function clearError(el){
         el.classList.remove('has-error');
         const wrap = el.closest('.relative') || el.parentElement;
         (wrap ? wrap : el).querySelectorAll('.error-text').forEach(n => n.remove());
       }
       function clearAllErrors(form){
         form.querySelectorAll('.has-error').forEach(e => e.classList.remove('has-error'));
         form.querySelectorAll('.error-text').forEach(e => e.remove());
       }
       
       /* ---------------- Validation utils ---------------- */
       function isValidIndianMobile(raw){
         const digits = (raw || '').replace(/\D/g,'');
         if(!/^[6-9]\d{9}$/.test(digits)) return false;    // 10 digits, starts 6-9
         if(/^(.)\1{9}$/.test(digits)) return false;       // all same digits
         if(['0123456789','1234567890','9876543210'].includes(digits)) return false; // obvious sequences
         return true;
       }
       
       /* Clamp phone input: digits only, max 10 */
       const phoneInput = document.getElementById('phone_number');
       const phoneError = document.getElementById('phone_error');
       phoneInput.addEventListener('input', function(){
         this.value = this.value.replace(/\D/g,'').slice(0,10);
         phoneError.textContent = '';
       });
       
       /* Password toggles */
       document.getElementById('passwordToggleBtn').addEventListener('click', () => {
         const input = document.getElementById('passwordInput');
         const icon = document.getElementById('eyeIcon');
         if(input.type === 'password'){
           input.type = 'text';
           icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
             d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.056 10.056 0 012.59-4.263M6.423 6.423A9.956 9.956 0 0112 5c4.477 0 8.267 2.943 9.541 7a10.05 10.05 0 01-4.421 5.681M15 12a3 3 0 11-6 0 3 3 0 016 0zM3 3l18 18" />`;
         }else{
           input.type = 'password';
           icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
         }
       });
       document.getElementById('confirmPasswordToggleBtn').addEventListener('click', () => {
         const input = document.getElementById('confirmPasswordInput');
         const icon = document.getElementById('eyeIconConfirm');
         if (input.type === 'password') {
           input.type = 'text';
           icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
             d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.056 10.056 0 012.59-4.263M6.423 6.423A9.956 9.956 0 0112 5c4.477 0 8.267 2.943 9.541 7a10.05 10.05 0 01-4.421 5.681M15 12a3 3 0 11-6 0 3 3 0 016 0zM3 3l18 18" />`;
         } else {
           input.type = 'password';
           icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
             d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
             d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
         }
       });
       
     
       
       /* ---------------- Form Validation + Submit ---------------- */
       function validateForm(form){
         clearAllErrors(form);
         let ok = true;
       
         const fullName = form.querySelector('#full_name');
         if(!fullName.value.trim() || fullName.value.trim().length < 2){ setError(fullName, 'Enter your full name.'); ok = false; }
       
         const phone = form.querySelector('#phone_number');
         if(!isValidIndianMobile(phone.value)){ setError(phone, 'Enter a valid Indian mobile number (10 digits starting 6–9).'); ok = false; }
       
       
         const email = form.querySelector('#email');
         if(!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim())){ setError(email, 'Enter a valid email address.'); ok = false; }
       
         const pass = form.querySelector('#passwordInput');
         if(!pass.value || pass.value.length < 6){ setError(pass, 'Password must be at least 6 characters.'); ok = false; }
       
         const confirmPass = form.querySelector('#confirmPasswordInput');
         if(!confirmPass.value){ setError(confirmPass, 'Please confirm your password.'); ok = false; }
         else if(confirmPass.value !== pass.value){ setError(confirmPass, 'Passwords do not match.'); ok = false; }
       
         const role = form.querySelector('#role_id');
         if(!role.value){ setError(role, 'Select your role.'); ok = false; }
       
     
       
       
         if(!ok){
           const first = form.querySelector('.has-error');
           first?.scrollIntoView({behavior:'smooth', block:'center'});
         }
       
       
         return ok;
       }
</script>
<script>
    let otpVerified = false; // global flag
       
       // --- SEND OTP ---
       document.getElementById('sendOtpBtn').addEventListener('click', function() {
           let mobile = document.getElementById('phone_number').value.trim();
       
           if (!/^(?!0)(?!.*(\d)\1{9})[6-9]\d{9}$/.test(mobile)) {
               alert("Please enter a valid mobile number.");
               return;
           }
       
           fetch("{{ url('/send-otp') }}", {
               method: 'POST',
               headers: {
                   'Content-Type': 'application/json',
                   'X-CSRF-TOKEN': '{{ csrf_token() }}'
               },
               body: JSON.stringify({ mobile: mobile })
           })
           .then(res => res.json())
           .then(data => {
               if (data.status === 'success') {
                   alert('OTP sent successfully!');
               } else {
                   alert('Error: ' + data.message);
               }
           })
           .catch(error => console.error('Error:', error));
       });
       
       // --- VERIFY OTP ---
       document.getElementById('verifyOtpBtn').addEventListener('click', function() {
        let otp = document.getElementById('otp').value.trim();
        let otpStatus = document.getElementById('otpStatus');
        let verifyBtn = document.getElementById('verifyOtpBtn');
       
        if (!/^\d{6}$/.test(otp)) {
            otpStatus.innerHTML = "<span style='color:red'>❌ Please enter a valid 6-digit OTP.</span>";
            return;
        }
       
        fetch("{{ url('/verify-otp') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ otp: otp })
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                otpVerified = true;
       
                // ✅ Replace button with message
                verifyBtn.style.display = "none";  
                otpStatus.innerHTML = "<span style='color:green'>✅ OTP Verified</span>";
       
                // Optional: disable OTP input after success
                document.getElementById('otp').readOnly = true;
       
            } else {
                otpVerified = false;
                otpStatus.innerHTML = "<span style='color:red'>❌ Invalid OTP</span>";
            }
        })
        .catch(error => console.error('Error:', error));
       });
       
       // --- FORM SUBMIT ---
       document.getElementById('projectForm').addEventListener('submit', function(e) {
           e.preventDefault();
           const form = this;
       
           if (!otpVerified) {
               alert("Please verify your OTP before submitting the form.");
               return;
           }
       
           if (!validateForm(form)) return;
       
           const formData = new FormData(form);
           $.ajax({
               url: form.action,
               method: 'POST',
               data: formData,
               processData: false,
               contentType: false,
               success: function(res) {
                   if (res.success && res.redirect) {
                       window.location.href = res.redirect;
                   } else {
                       alert('Something went wrong!');
                   }
               },
               error: function(xhr) {
                   try {
                       const data = JSON.parse(xhr.responseText);
                       if (data?.errors) {
                           Object.entries(data.errors).forEach(([key, msgs]) => {
                               const el = form.querySelector(`[name="${key}"]`) || form.querySelector(`#${key}`);
                               el && setError(el, msgs[0]);
                           });
                           const first = form.querySelector('.has-error');
                           first?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                           return;
                       }
                   } catch (_) {}
                   alert('Submission failed!');
                   console.error(xhr.responseText);
               }
           });
       });
</script>
<script>
    // State → Region
       $('#state').on('change', function() {
           let state_id = $(this).val();
           $('#region').empty().append('<option value="">-- Select Region --</option>');
           $('#city').empty().append('<option value="">-- Select City --</option>');
       
           if (state_id) {
               $.get('/get-regions/' + state_id, function(data) {
                   $.each(data, function(key, value) {
                       $('#region').append('<option value="'+ key +'">'+ value +'</option>');
                   });
               });
           }
       });
       
       // Region → City
       $('#region').on('change', function() {
           let region_id = $(this).val();
           $('#city').empty().append('<option value="">-- Select City --</option>');
       
           if (region_id) {
               $.get('/get-cities/' + region_id, function(data) {
                   $.each(data, function(key, value) {
                       $('#city').append('<option value="'+ key +'">'+ value +'</option>');
                   });
               });
           }
       });
       
       
       
           // Send Email OTP
       $('#sendEmailOtpBtn').on('click', function() {
        let email = $('#email').val();
       
        fetch('/send-email-otp', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ email: email })
        })
        .then(res => res.json())
       
        .then(data => {
            if (data.status === 'success') {
                alert('Email OTP sent successfully!');
            } else {
                alert('Error: ' + data.message);
            }
        });
        // .then(data => alert(data.message));
       });
       
       // Verify Email OTP
       $('#verifyEmailOtpBtn').on('click', function() {
        let otp = $('#emailOtp').val();
       
        fetch('/verify-email-otp', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ otp: otp })
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                // Change button state
                let btn = document.getElementById('verifyEmailOtpBtn');
                btn.innerText = "Email OTP Verified ✅";
                btn.classList.remove("btn-success");
                btn.classList.add("btn-outline-success");
                btn.disabled = true;
       
                // Show a green success message
                let msgBox = document.createElement("div");
                msgBox.classList.add("text-success", "mt-2");
                // msgBox.innerText = "Email OTP verified successfully!";
                btn.parentNode.appendChild(msgBox);
            } else {
                alert('Invalid Email OTP');
            }
        });
        // .then(data => alert(data.message));
       });
</script>
@endsection