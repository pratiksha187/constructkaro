@extends('layouts.app')
@section('title', 'Home | ConstructKaro')
@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<script>
   tailwind.config = {
     theme: {
       extend: {
         colors: {
           'custom-blue': '#007bff',
           'custom-orange': '#ff6f00',
         }
       }
     }
   }
</script>
<style>
   body {
   font-family: 'Segoe UI', sans-serif;
   }
   .toggle-switch {
   position: relative;
   display: inline-block;
   width: 50px;
   height: 24px;
   }
   .toggle-switch input {
   opacity: 0;
   width: 0;
   height: 0;
   }
   .slider {
   position: absolute;
   cursor: pointer;
   top: 0;
   left: 0;
   right: 0;
   bottom: 0;
   background-color: #ccc;
   transition: .4s;
   border-radius: 24px;
   }
   .slider:before {
   position: absolute;
   content: "";
   height: 18px;
   width: 18px;
   left: 3px;
   bottom: 3px;
   background-color: white;
   transition: .4s;
   border-radius: 50%;
   }
   input:checked + .slider {
   background-color: #007bff;
   }
   input:checked + .slider:before {
   transform: translateX(26px);
   }
   .land-details {
   max-height: 0;
   overflow: hidden;
   transition: max-height 0.5s ease-in-out, opacity 0.3s ease;
   opacity: 0;
   }
   .land-details.show {
   max-height: 1000px;
   opacity: 1;
   }
   .gradient-bg {
   background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
   }
   .section-divider {
   border-left: 4px solid #007bff;
   padding-left: 1rem;
   margin: 2rem 0;
   }
   .form-container {
   min-height: 100vh;
   background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
   }
   #boq-upload-wrapper {
   display: none;
   }
   .error-text{ font-size:.8rem; color:#dc2626; margin-top:.25rem }
   .has-error{ border-color:#dc2626 !important; }
   .has-error:focus{ box-shadow:0 0 0 3px rgba(220,38,38,.2) !important; }
</style>
</head>
<body class="bg-white">
   <div class="form-container">
      <div class="container mx-auto px-6 py-8">
         <div class="bg-white  border  p-8 lg:p-12 max-w-8xl mx-auto rounded">
            <div class="text-center mb-10">
               <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                  Tell us about your <span class="text-custom-blue">project</span>
               </h1>
               <p class="text-lg text-gray-600 max-w-4xl mx-auto">We gather key details to understand your construction needs and connect you with the right <span class="text-custom-orange font-medium">vendors and professionals</span>.</p>
            </div>
            <form class="space-y-10" action="" method="POST" enctype="multipart/form-data">
               @csrf
               <div class="section-divider">
                  <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                     <span class="bg-custom-blue text-white rounded-full w-8 h-8 flex items-center justify-center text-sm mr-3">1</span>
                     Basic Information
                  </h2>
                  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                     <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                        <input type="text" id="full_name" name="full_name" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all" placeholder="Enter your full name">
                     </div>
                    
                  <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>

                  <!-- Input group -->
                  <div class="flex items-stretch rounded-lg border border-gray-300 focus-within:ring-2 focus-within:ring-custom-blue focus-within:border-custom-blue overflow-hidden">
                     <input
                        type="tel"
                        id="phone_number"
                        name="phone_number"
                        placeholder="Enter your phone number"
                        class="flex-1 px-3 py-2 outline-none border-0 text-gray-900 placeholder-gray-400"
                     />
                     <!-- <button
                        type="button"
                        id="sendPhoneOtpBtn"
                        class="px-3 sm:px-4 py-1.5 text-xs sm:text-sm font-medium bg-custom-blue hover:bg-blue-600 text-white transition disabled:opacity-50 disabled:cursor-not-allowed"
                        title="Send OTP"
                     >
                        Send OTP
                     </button> -->
                  </div>

                  <!-- OTP entry (shown after send) -->
                  <!-- <div id="phoneOtpWrap" class="mt-2 hidden">
                     <div class="flex items-stretch rounded-md border border-gray-300 overflow-hidden">
                        <input
                        id="phoneOtp"
                        maxlength="6"
                        placeholder="6-digit code"
                        class="w-32 px-3 py-2 outline-none border-0 text-sm"
                        />
                        <button
                        type="button"
                        id="verifyPhoneOtpBtn"
                        class="px-3 sm:px-4 py-1.5 text-xs sm:text-sm font-medium bg-green-600 hover:bg-green-700 text-white transition"
                        >
                        Verify
                        </button>
                        <span id="phoneOtpStatus" class="self-center ml-2 text-xs sm:text-sm"></span>
                     </div>
                  </div> -->
                  </div>

                  <!-- EMAIL -->
                  <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>

                  <!-- Input group -->
                  <div class="flex items-stretch rounded-lg border border-gray-300 focus-within:ring-2 focus-within:ring-custom-blue focus-within:border-custom-blue overflow-hidden">
                     <input
                        id="email"
                        name="email"
                        type="email"
                        placeholder="Enter your email address"
                        autocomplete="off"
                        class="flex-1 px-3 py-2 outline-none border-0 text-gray-900 placeholder-gray-400"
                     />
                     <!-- <button
                        type="button"
                        id="sendEmailOtpBtn"
                        class="px-3 sm:px-4 py-1.5 text-xs sm:text-sm font-medium bg-custom-blue hover:bg-blue-600 text-white transition disabled:opacity-50 disabled:cursor-not-allowed"
                        title="Send OTP"
                     >
                        Send OTP
                     </button> -->
                  </div>

                  <!-- OTP entry (shown after send) -->
                  <!-- <div id="emailOtpWrap" class="mt-2 hidden">
                     <div class="flex items-stretch rounded-md border border-gray-300 overflow-hidden">
                        <input
                        id="emailOtp"
                        maxlength="6"
                        placeholder="6-digit code"
                        class="w-32 px-3 py-2 outline-none border-0 text-sm"
                        />
                        <button
                        type="button"
                        id="verifyEmailOtpBtn"
                        class="px-3 sm:px-4 py-1.5 text-xs sm:text-sm font-medium bg-green-600 hover:bg-green-700 text-white transition"
                        >
                        Verify
                        </button>
                        <span id="emailOtpStatus" class="self-center ml-2 text-xs sm:text-sm"></span>
                     </div>
                  </div> -->

                  <!-- keep your suggestions dropdown if you use it -->
                  <div id="suggestions" class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded shadow-lg hidden max-h-60 overflow-auto"></div>
                  </div>

                     <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password *</label>
                        <div class="relative">
                           <input type="password" name="password" id="passwordInput" required
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all"
                              placeholder="Create a password">
                           <button type="button" onclick="togglePassword()" 
                              class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none">
                              <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                              </svg>
                           </button>
                        </div>
                     </div>
                     <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Role *</label>
                        <select required  id="role_id" name="role_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all">
                           <option value="">Select your role</option>
                           @foreach($role_types as $role)
                           <option value="{{ $role->id }}">{{ $role->role }}</option>
                           @endforeach
                        </select>
                     </div>
                  </div>
               </div>
               <div class="section-divider">
                  <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                     <span class="bg-custom-blue text-white rounded-full w-8 h-8 flex items-center justify-center text-sm mr-3">2</span>
                     Project Details
                  </h2>
                  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                     <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Type of Vendor Needed *</label>
                        <select id="construction_type" name="construction_type_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all">
                           <option value="">Select Construction Type</option>
                           @foreach($construction_types as $type)
                           <option value="{{ $type->id }}">{{ $type->name }}</option>
                           @endforeach
                        </select>
                     </div>
                     <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Project Type *</label>
                        <select id="project_type" name="project_type_id"  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all">
                           <option value="">Select Project Type</option>
                        </select>
                     </div>
                     <div id="sub_categories_container" class="mt-6 hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Select Sub-Categories</label>
                        <div id="sub_categories" name="sub_categories" class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                           <!-- Subcategory checkboxes will be inserted here -->
                        </div>
                     </div>
                  </div>
               </div>
               <div class="section-divider">
                  <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                     <span class="bg-custom-blue text-white rounded-full w-8 h-8 flex items-center justify-center text-sm mr-3">3</span>
                     Site Information
                  </h2>
                  <div class="mb-6">
                     <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg">
                        <div>
                           <label class="block text-sm font-medium text-gray-700 mb-1">Is your plot or site ready?</label>
                           <p class="text-sm text-gray-500">Toggle to "Yes" if your site is prepared for construction</p>
                        </div>
                        <label class="toggle-switch">
                        <input type="checkbox" id="siteReady" name="site_ready" onchange="toggleLandDetails()">
                        <span class="slider"></span>
                        </label>
                     </div>
                  </div>
                  <!-- Land Details -->
                  <div id="landDetails" class="land-details">
                     <div class="bg-blue-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-custom-blue mb-4">Land Details</h3>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                           <div>
                              <label class="block text-sm font-medium text-gray-700 mb-2">Land Location *</label>
                              <input type="text" id="land_location" name="land_location" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all" placeholder="Enter the land location">
                           </div>
                           <div>
                              <label class="block text-sm font-medium text-gray-700 mb-2">Survey Number (Optional)</label>
                              <input type="text" id="survey_number" name="survey_number" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all" placeholder="Enter survey number if available">
                           </div>
                           <div>
                              <label class="block text-sm font-medium text-gray-700 mb-2">Land Type *</label>
                              <select id="land_type" name="land_type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all">
                                 <option value="">Select land type</option>
                                 <option value="residential">Residential</option>
                                 <option value="commercial">Commercial</option>
                                 <option value="industrial">Industrial</option>
                                 <option value="agricultural">Agricultural</option>
                                 <option value="mixed-use">Mixed Use</option>
                              </select>
                           </div>
                           <div>
                              <label class="block text-sm font-medium text-gray-700 mb-2">Area *</label>
                              <div class="flex space-x-2">
                                 <input type="number" id="land_area" name="land_area"  class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all" placeholder="Enter area">
                                 <select id="land_unit" name="land_unit" class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all">
                                    <option value="sqft">Sq Ft</option>
                                    <option value="sqm">Sq M</option>
                                    <option value="acres">Acres</option>
                                    <option value="cents">Cents</option>
                                 </select>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="section-divider">
                  <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                     <span class="bg-custom-blue text-white rounded-full w-8 h-8 flex items-center justify-center text-sm mr-3">4</span>
                     Documentation
                  </h2>
                  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                     <div class="bg-gray-50 p-6 rounded-lg">
                        <div class="flex items-center justify-between mb-4">
                           <div>
                              <label class="block text-sm font-medium text-gray-700 mb-1">Architectural Drawings</label>
                              <p class="text-sm text-gray-500">Do you have architectural plans ready?</p>
                           </div>
                           <label class="toggle-switch">
                           <input type="checkbox" id="archDrawings" name="arch_drawings">
                           <span class="slider"></span>
                           </label>
                        </div>
                     </div>
                     <div class="bg-gray-50 p-6 rounded-lg">
                        <div class="flex items-center justify-between mb-4">
                           <div>
                              <label class="block text-sm font-medium text-gray-700 mb-1">Structural Drawings</label>
                              <p class="text-sm text-gray-500">Do you have structural engineering plans?</p>
                           </div>
                           <label class="toggle-switch">
                           <input type="checkbox" id="structDrawings" name="struct_drawings">
                           <span class="slider"></span>
                           </label>
                        </div>
                     </div>
                  </div>
                  <div class="mt-6 bg-orange-50 p-6 rounded-lg">
                     <div class="flex items-center space-x-3">
                        <input type="checkbox" id="boqCheckbox" name="has_boq" class="w-5 h-5 text-custom-blue bg-gray-100 border-gray-300 rounded focus:ring-custom-blue focus:ring-2">
                        <label for="boq" class="text-sm font-medium text-gray-700">I have a BOQ (Bill of Quantities) ready for the project</label>
                     </div>
                     <p class="text-sm text-gray-500 mt-2 ml-8">A Bill of Quantities helps contractors provide more accurate estimates</p>
                  </div>
                  <div id="boq-upload-wrapper" class="mb-3">
                     <label for="boqFile" class="form-label">Upload BOQ File</label>
                     <input class="form-control" type="file" id="boqFile" name="boq_file" accept=".xls,.xlsx,.csv,.pdf">
                  </div>
               </div>
               <div class="section-divider">
                  <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                     <span class="bg-custom-blue text-white rounded-full w-8 h-8 flex items-center justify-center text-sm mr-3">5</span>
                     Timeline & Budget
                  </h2>
                  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                     <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Expected Start Date</label>
                        <input type="date" id="expected_start" name="expected_start" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all">
                     </div>
                     <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Project Duration</label>
                        <select id="project_duration" name="project_duration" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all">
                           <option value="">Select Project Duration</option>
                           @foreach($expected_timeline as $expected)
                           <option value="{{ $expected->id }}">{{ $expected->timeline }}</option>
                           @endforeach
                        </select>
                     </div>
                     <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Budget Range</label>
                        <select id="budget_range" name="budget_range" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all">
                           <option value="">Select budget range</option>
                           @foreach($budgets as $budget)
                           <option value="{{ $budget->id }}">{{ $budget->budget_range }}</option>
                           @endforeach
                        </select>
                     </div>
                  </div>
               </div>
               <div class="text-center pt-8 border-t border-gray-200">
                  <button type="submit" class="gradient-bg hover:shadow-2xl text-white px-6 py-2 rounded-md font-semibold text-base transition-all transform hover:scale-105 shadow-md border border-custom-blue">
                  Next →
                  </button>
                  <p class="text-sm text-gray-500 mt-4">We'll connect you with <span class="text-custom-orange font-medium">verified contractors</span> within 24 hours</p>
               </div>
            </form>
         </div>
      </div>
   </div>
   <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
   <script>
      // ---- Helpers -------------------------------------------------------------
      function setError(el, msg){
        // clear any previous error next to this field
        clearError(el);
        el.classList.add('has-error');
      
        // create error message just under the field
        const p = document.createElement('p');
        p.className = 'error-text';
        p.textContent = msg;
      
        // Insert after the input/select (or after its wrapper if needed)
        const after = el.parentElement?.querySelector('.error-text') ? el.parentElement : el;
        (el.closest('.relative') || el.parentElement || el).appendChild(p);
      }
      
      function clearError(el){
        el.classList.remove('has-error');
        const wrap = el.closest('.relative') || el.parentElement || el;
        wrap.querySelectorAll('.error-text').forEach(n => n.remove());
      }
      
      function clearAllErrors(form){
        form.querySelectorAll('.has-error').forEach(e => e.classList.remove('has-error'));
        form.querySelectorAll('.error-text').forEach(e => e.remove());
      }
      
      // Phone checks: 10 digits (start 6–9), not all same, not obvious sequences
      function isValidIndianMobile(raw){
        const digits = (raw || '').replace(/\D/g,'');
        if (!/^[6-9]\d{9}$/.test(digits)) return false;
        if (/^(.)\1{9}$/.test(digits)) return false;                 // 9999999999
        if (digits === '0123456789' || digits === '1234567890') return false;
        if (digits === '9876543210') return false;
        return true;
      }
      
      function validateForm(form){
        clearAllErrors(form);
        let ok = true;
      
        const fullName = form.querySelector('#full_name');
        if (!fullName.value.trim() || fullName.value.trim().length < 2){
          setError(fullName, 'Enter your full name.'); ok = false;
        }
      
        const phone = form.querySelector('#phone_number');
        if (!isValidIndianMobile(phone.value)){
          setError(phone, 'Enter a valid Indian mobile number (10 digits starting 6–9, not repeated/sequential).');
          ok = false;
        }
      
        const email = form.querySelector('#email');
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim())){
          setError(email, 'Enter a valid email address.'); ok = false;
        }
      
        const pass = form.querySelector('#passwordInput');
        if (!pass.value || pass.value.length < 6){
          setError(pass, 'Password must be at least 6 characters.'); ok = false;
        }
      
        const role = form.querySelector('#role_id');
        if (!role.value){ setError(role, 'Select your role.'); ok = false; }
      
        const ctype = form.querySelector('#construction_type');
        if (!ctype.value){ setError(ctype, 'Select construction type.'); ok = false; }
      
        const ptype = form.querySelector('#project_type');
        if (!ptype.value){ setError(ptype, 'Select project type.'); ok = false; }
      
        // If "site ready" is ON, require land details
        const siteReady = form.querySelector('#siteReady')?.checked;
        if (siteReady){
          const landLoc = form.querySelector('#land_location');
          const landType = form.querySelector('#land_type');
          const landArea = form.querySelector('#land_area');
      
          if (!landLoc.value.trim()){ setError(landLoc, 'Enter land location.'); ok = false; }
          if (!landType.value){ setError(landType, 'Select land type.'); ok = false; }
          if (!landArea.value || Number(landArea.value) <= 0){
            setError(landArea, 'Enter a valid area.'); ok = false;
          }
        }
      
        // If "I have BOQ" is checked, require file and extension
        const hasBoq = form.querySelector('#boqCheckbox')?.checked;
        if (hasBoq){
          const fileInput = form.querySelector('#boqFile');
          const f = fileInput.files[0];
          if (!f){
            setError(fileInput, 'Please upload your BOQ file.'); ok = false;
          }else if (!/\.(xls|xlsx|csv|pdf)$/i.test(f.name)){
            setError(fileInput, 'Allowed: .xls, .xlsx, .csv, .pdf'); ok = false;
          }
        }
      
        // Scroll to first error if any
        if (!ok){
          const first = form.querySelector('.has-error');
          first?.scrollIntoView({behavior:'smooth', block:'center'});
        }
        return ok;
      }
      
      // ---- Submit (keeps your existing AJAX logic) -----------------------------
      //   $('form').on('submit', function(e) {
      //     e.preventDefault();
      //     const form = this;
      
      //     if (!validateForm(form)) return; // block submit on error
      
      //     let formData = new FormData(form);
      //     $.ajax({
      //       url: "{{ route('project.store') }}",
      //       method: 'POST',
      //       data: formData,
      //       processData: false,
      //       contentType: false,
      //       success: function(response) {
      //         if (response.success && response.redirect) {
      //           window.location.href = response.redirect;
      //         } else {
      //           alert('Something went wrong!');
      //         }
      //       },
      //       error: function(xhr) {
      //         // If server sent Laravel validation errors, show them inline too
      //         try{
      //           const data = JSON.parse(xhr.responseText);
      //           if (data?.errors){
      //             Object.entries(data.errors).forEach(([key, messages])=>{
      //               const el = form.querySelector(`[name="${key}"]`) || form.querySelector(`#${key}`);
      //               if (el) setError(el, messages[0]);
      //             });
      //             const first = form.querySelector('.has-error');
      //             first?.scrollIntoView({behavior:'smooth', block:'center'});
      //             return;
      //           }
      //         }catch(_){}
      //         alert('Submission failed!');
      //         console.error(xhr.responseText);
      //       }
      //     });
      //   });
      
      // ---------- helpers (same as you had) ----------
      function setError(el,msg){ clearError(el); el.classList.add('has-error');
        const p=document.createElement('p'); p.className='error-text'; p.textContent=msg;
        (el.closest('.relative')||el.parentElement||el).appendChild(p); }
      function clearError(el){ el.classList.remove('has-error');
        const wrap=el.closest('.relative')||el.parentElement||el; wrap.querySelectorAll('.error-text').forEach(n=>n.remove()); }
      function clearAllErrors(form){ form.querySelectorAll('.has-error').forEach(e=>e.classList.remove('has-error'));
        form.querySelectorAll('.error-text').forEach(e=>e.remove()); }
      function isValidIndianMobile(raw){
        const d=(raw||'').replace(/\D/g,''); if(!/^[6-9]\d{9}$/.test(d)) return false;
        if(/^(.)\1{9}$/.test(d)) return false;
        if(d==='0123456789'||d==='1234567890'||d==='9876543210') return false; return true;
      }
      function validateForm(form){
        clearAllErrors(form); let ok=true;
        const full=form.querySelector('#full_name'); if(!full.value.trim()||full.value.trim().length<2){ setError(full,'Enter your full name.'); ok=false; }
        const phone=form.querySelector('#phone_number'); if(!isValidIndianMobile(phone.value)){ setError(phone,'Enter a valid Indian mobile number.'); ok=false; }
        const email=form.querySelector('#email'); if(!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim())){ setError(email,'Enter a valid email.'); ok=false; }
        const pass=form.querySelector('#passwordInput'); if(!pass.value||pass.value.length<6){ setError(pass,'Password must be at least 6 characters.'); ok=false; }
        const role=form.querySelector('#role_id'); if(!role.value){ setError(role,'Select your role.'); ok=false; }
        // add your other field checks if needed ...
        return ok;
      }
      
      // ---------- your AJAX submit (unchanged except we gate OTP verified) ----------
      // let phoneVerified=false, emailVerified=false;
      $('form').on('submit', function(e){
        e.preventDefault();
        const form=this;
      //   if(!validateForm(form)) return;
      //   if(!phoneVerified){ setError(document.getElementById('phone_number'),'Please verify your mobile number.'); return; }
      //   if(!emailVerified){ setError(document.getElementById('email'),'Please verify your email.'); return; }
      
        const formData = new FormData(form);
        $.ajax({
          url: "{{ route('project.store') }}",
          method:'POST', data:formData, processData:false, contentType:false,
          success: function(res){
            if(res.success && res.redirect){ window.location.href=res.redirect; }
            else alert('Something went wrong!');
          },
          error: function(xhr){
            try{
              const data=JSON.parse(xhr.responseText);
              if(data?.errors){
                Object.entries(data.errors).forEach(([key,msgs])=>{
                  const el=form.querySelector(`[name="${key}"]`)||form.querySelector(`#${key}`);
                  if(el) setError(el, msgs[0]);
                });
                const first=form.querySelector('.has-error'); first?.scrollIntoView({behavior:'smooth',block:'center'});
                return;
              }
            }catch(_){}
            alert('Submission failed!'); console.error(xhr.responseText);
          }
        });
      });
      
      // ---------- Toggle Land Details ----------
      function toggleLandDetails(){
        const c=document.getElementById('siteReady'); const d=document.getElementById('landDetails');
        if(c && d){ c.checked ? d.classList.add('show') : d.classList.remove('show'); }
      }
      
      // ---------- OTP JS (robust + CSRF safe) ----------
      // document.addEventListener('DOMContentLoaded', function(){
      //   const CSRF = (document.querySelector('meta[name="csrf-token"]')?.content) || '{{ csrf_token() }}';
      //   function toast(el,msg,ok=true){ if(!el) return; el.textContent=msg; el.className='text-sm ml-2 '+(ok?'text-green-700':'text-red-600'); }
      
      //   const btnSendPhone = document.getElementById('sendPhoneOtpBtn');
      //   const btnVerifyPhone = document.getElementById('verifyPhoneOtpBtn');
      //   const btnSendEmail = document.getElementById('sendEmailOtpBtn');
      //   const btnVerifyEmail = document.getElementById('verifyEmailOtpBtn');
      
      //   // send phone otp
      //   btnSendPhone?.addEventListener('click', function(){
      //     const raw=document.getElementById('phone_number').value.trim();
      //     const digits=raw.replace(/\D/g,''); if(!/^[6-9]\d{9}$/.test(digits)){ alert('Enter a valid Indian mobile number.'); return; }
      //     this.disabled=true;
      //     fetch(`{{ route('otp.send') }}`,{
      //       method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF},
      //       body: JSON.stringify({ type:'phone', recipient: digits })
      //     }).then(async r=>({ok:r.ok,j:await r.json().catch(()=>({}))}))
      //       .then(({ok,j})=>{
      //         this.disabled=false;
      //         if(!ok){ alert(j.message||'Failed to send code'); return; }
      //         document.getElementById('phoneOtpWrap')?.classList.remove('hidden');
      //         toast(document.getElementById('phoneOtpStatus'),'Code sent. Check SMS.');
      //       }).catch(()=>{ this.disabled=false; alert('Network error'); });
      //   });
      
      //   // verify phone otp
      //   btnVerifyPhone?.addEventListener('click', function(){
      //     const digits=document.getElementById('phone_number').value.trim().replace(/\D/g,'');
      //     const code=document.getElementById('phoneOtp').value.trim(); if(!/^\d{6}$/.test(code)){ alert('Enter 6-digit code'); return; }
      //     fetch(`{{ route('otp.verify') }}`,{
      //       method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF},
      //       body: JSON.stringify({ type:'phone', recipient: digits, code })
      //     }).then(async r=>({ok:r.ok,j:await r.json().catch(()=>({}))}))
      //       .then(({ok,j})=>{
      //         if(!ok){ toast(document.getElementById('phoneOtpStatus'), j.message||'Invalid code', false); return; }
      //         phoneVerified=true; document.getElementById('phone_number')?.setAttribute('readonly','readonly');
      //         btnSendPhone.disabled=true; toast(document.getElementById('phoneOtpStatus'),'Verified ✓');
      //       }).catch(()=> toast(document.getElementById('phoneOtpStatus'),'Network error',false));
      //   });
      
      //   // send email otp
      //   btnSendEmail?.addEventListener('click', function(){
      //     const email=document.getElementById('email').value.trim();
      //     if(!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)){ alert('Enter a valid email'); return; }
      //     this.disabled=true;
      //     fetch(`{{ route('otp.send') }}`,{
      //       method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF},
      //       body: JSON.stringify({ type:'email', recipient: email })
      //     }).then(async r=>({ok:r.ok,j:await r.json().catch(()=>({}))}))
      //       .then(({ok,j})=>{
      //         this.disabled=false;
      //         if(!ok){ alert(j.message||'Failed to send code'); return; }
      //         document.getElementById('emailOtpWrap')?.classList.remove('hidden');
      //         toast(document.getElementById('emailOtpStatus'),'Code sent. Check your inbox.');
      //       }).catch(()=>{ this.disabled=false; alert('Network error'); });
      //   });
      
      //   // verify email otp
      //   btnVerifyEmail?.addEventListener('click', function(){
      //     const email=document.getElementById('email').value.trim();
      //     const code=document.getElementById('emailOtp').value.trim(); if(!/^\d{6}$/.test(code)){ alert('Enter 6-digit code'); return; }
      //     fetch(`{{ route('otp.verify') }}`,{
      //       method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF},
      //       body: JSON.stringify({ type:'email', recipient: email, code })
      //     }).then(async r=>({ok:r.ok,j:await r.json().catch(()=>({}))}))
      //       .then(({ok,j})=>{
      //         if(!ok){ toast(document.getElementById('emailOtpStatus'), j.message||'Invalid code', false); return; }
      //         emailVerified=true; document.getElementById('email')?.setAttribute('readonly','readonly');
      //         btnSendEmail.disabled=true; toast(document.getElementById('emailOtpStatus'),'Verified ✓');
      //       }).catch(()=> toast(document.getElementById('emailOtpStatus'),'Network error',false));
      //   });
      // });
      
      // password eye toggle
      function togglePassword(){
        const input=document.getElementById('passwordInput'); const icon=document.getElementById('eyeIcon');
        if(input.type==='password'){ input.type='text';
          icon.innerHTML=`<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.056 10.056 0 012.59-4.263M6.423 6.423A9.956 9.956 0 0112 5c4.477 0 8.267 2.943 9.541 7a10.05 10.05 0 01-4.421 5.681M15 12a3 3 0 11-6 0 3 3 0 016 0zM3 3l18 18" />`;
        }else{ input.type='password';
          icon.innerHTML=`<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
        }
      }
      
   </script>
   <script>
      function toggleLandDetails() {
        const checkbox = document.getElementById('siteReady');
        const landDetails = document.getElementById('landDetails');
        
        if (checkbox.checked) {
          landDetails.classList.add('show');
        } else {
          landDetails.classList.remove('show');
        }
      }
      
   </script>
   <script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'967b6b2a120aff70',t:'MTc1Mzk0NzMyMi4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script>
   <script>
      document.addEventListener("DOMContentLoaded", function () {
        const emailInput = document.getElementById("email");
        const suggestionsBox = document.getElementById("suggestions");
      
        const domains = [
          "gmail.com", "yahoo.com", "outlook.com", "hotmail.com", "icloud.com",
          "protonmail.com", "rediffmail.com", "mail.com", "zoho.com", "aol.com"
        ];
      
        let selectedIndex = -1;
      
        emailInput.addEventListener("input", function () {
          const value = this.value;
          const atIndex = value.indexOf("@");
      
          if (atIndex !== -1 && !value.slice(atIndex + 1).includes(".")) {
            const username = value.slice(0, atIndex + 1);
            suggestionsBox.innerHTML = "";
            selectedIndex = -1;
      
            domains.forEach((domain, index) => {
              const suggestion = document.createElement("div");
              suggestion.textContent = username + domain;
              suggestion.className = "px-4 py-2 hover:bg-blue-100 cursor-pointer text-sm text-gray-700";
              suggestion.setAttribute("data-index", index);
      
              suggestion.addEventListener("click", function () {
                emailInput.value = this.textContent;
                suggestionsBox.classList.add("hidden");
              });
      
              suggestionsBox.appendChild(suggestion);
            });
      
            suggestionsBox.classList.remove("hidden");
          } else {
            suggestionsBox.classList.add("hidden");
          }
        });
      
        emailInput.addEventListener("keydown", function (e) {
          const items = suggestionsBox.querySelectorAll("div");
      
          if (suggestionsBox.classList.contains("hidden")) return;
      
          if (e.key === "ArrowDown") {
            e.preventDefault();
            selectedIndex = (selectedIndex + 1) % items.length;
            updateHighlight(items);
          }
      
          if (e.key === "ArrowUp") {
            e.preventDefault();
            selectedIndex = (selectedIndex - 1 + items.length) % items.length;
            updateHighlight(items);
          }
      
          if (e.key === "Enter") {
            if (selectedIndex >= 0 && items[selectedIndex]) {
              e.preventDefault();
              emailInput.value = items[selectedIndex].textContent;
              suggestionsBox.classList.add("hidden");
            }
          }
        });
      
        document.addEventListener("click", function (e) {
          if (!emailInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
            suggestionsBox.classList.add("hidden");
          }
        });
      
        function updateHighlight(items) {
          items.forEach(item => item.classList.remove("bg-blue-100"));
          if (items[selectedIndex]) {
            items[selectedIndex].classList.add("bg-blue-100");
            items[selectedIndex].scrollIntoView({ block: "nearest" });
          }
        }
      });
   </script>
   <script>
      $('#boqCheckbox').on('change', function () {
          if ($(this).is(':checked')) {
              $('#boq-upload-wrapper').slideDown();
          } else {
              $('#boq-upload-wrapper').slideUp();
          }
      });
      
        $(document).ready(function () {
      // Fetch Project Types when Construction Type changes
      $('#construction_type').on('change', function () {
         const typeId = $(this).val();
         $('#project_type').html('<option value="">Loading...</option>');
         $('#sub_categories_container').hide();
          $('#other_project_type_wrapper').hide();
         if (typeId) {
             $.ajax({
                 url: '/get-project-types',
                 type: 'GET',
                 data: { construction_type_id: typeId },
                 success: function (data) {
                     $('#project_type').empty().append('<option value="">Select Project Type</option>');
                     $.each(data, function (index, item) {
                         $('#project_type').append('<option value="' + item.id + '">' + item.name + '</option>');
                     });
      
                      // $('#project_type').append('<option value="other">Other</option>');
                 }
             });
      
             $('#project_type').on('change', function () {
                const selected = $(this).val();
                if (selected === '6') {
                      $('#other_project_type_wrapper').slideDown();
                } else {
                      $('#other_project_type_wrapper').slideUp();
                }
             });
                }
             });
      
      // Fetch Subcategories when Project Type changes
      $('#project_type').on('change', function () {
         const projectTypeId = $(this).val();
         const constructionTypeId = $('#construction_type').val();
      
         $('#sub_categories').empty();
         $('#sub_categories_container').hide();
      
         if (projectTypeId && constructionTypeId) {
             $.ajax({
                 url: '/get-sub-categories',
                 type: 'GET',
                 data: {
                     construction_type_id: constructionTypeId,
                     project_type_id: projectTypeId
                 },
                 success: function (data) {
                     if (data.length > 0) {
                         $('#sub_category_title').text();
                         $('#sub_categories_container').show();
      
                         $.each(data, function (index, subcat) {
                            const checkbox = `
                               <div class="form-check">
                                     <input class="form-check-input" type="checkbox" name="sub_categories[]" value="${subcat.const_sub_cat_id}" id="subcat_${subcat.const_sub_cat_id}">
                                     <label class="form-check-label" for="subcat_${subcat.const_sub_cat_id}">
                                        ${subcat.sub_category_name}
                                     </label>
                               </div>`;
                            $('#sub_categories').append(checkbox);
                         });
      
                     }
                 }
             });
         }
      });
      });
      
      function togglePassword() {
      const passwordInput = document.getElementById('passwordInput');
      const eyeIcon = document.getElementById('eyeIcon');
      
      if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
      // Optional: Change the eye icon to an "eye-off" icon
      eyeIcon.innerHTML = `
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.056 10.056 0 012.59-4.263M6.423 6.423A9.956 9.956 0 0112 5c4.477 0 8.267 2.943 9.541 7a10.05 10.05 0 01-4.421 5.681M15 12a3 3 0 11-6 0 3 3 0 016 0zM3 3l18 18" />
      `;
      } else {
      passwordInput.type = 'password';
      // Restore the original eye icon
      eyeIcon.innerHTML = `
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
      `;
      }
      }
      
   </script>
   @endsection