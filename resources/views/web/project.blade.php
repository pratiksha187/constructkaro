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
               Tell us about your <span class="text-custom-blue">project</span>
            </h1>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    We gather key details to understand your construction needs and connect you with the right
                    <span class="text-custom-orange font-medium">vendors and professionals</span>.
                </p>
            </div>
            {{-- IMPORTANT: novalidate so our JS shows custom messages --}}
            <form id="projectForm" class="space-y-10" action="{{ route('project.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                
                <div class="section-divider">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                  <span class="bg-custom-blue text-white rounded-full w-8 h-8 flex items-center justify-center text-sm mr-3">1</span>
                  Project Details
               </h2>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                        <!-- Work Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Select Type of Contractor/Professional*<small class="text-muted">(Civil,Interior,Electrical,Architect,etc..)</small></label>
                            <select id="work_type" name="work_type" class="form-control select2">
                                <option value="">Select Construction Type</option>
                                @foreach($workTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->work_type }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Work Subtype -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">What Kind Of Work Do You Want To Start? *<small class="text-muted">(Bungalow,Road Work,Factory,Interior,Plot Development,Renovation,etc..)</small></label>
                            <select id="work_subtype" name="work_subtype" class="form-control select2">
                                <option value="">Select Work Subtype</option>
                            </select>
                        </div>

                        <!-- Vendor Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">How Do You Want The Work To Be Done? *<small class="text-muted">(Labour Only,Labour + Material,Turnkey,Consultancy,Supervision,etc..)</small></label>
                            <select id="vendor_type" name="vendor_type" class="form-control select2">
                                <option value="">Select Vendor</option>
                            </select>
                        </div>

                        <!-- Sub Vendor Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Select Your Work Category? *<small class="text-muted">(civil Work,Plumbing,Elecrtical,Painting,etc..)</small></label>

                            <select id="sub_vendor_type_dropdown" name="sub_vendor_types" class="form-control select2">
                                <option value="">Select Sub Vendor Type</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- 3. Site Information -->
                <div class="section-divider">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                  <span class="bg-custom-blue text-white rounded-full w-8 h-8 flex items-center justify-center text-sm mr-3">2</span>
                  Site Information
               </h2>
                    <div class="mb-6">
                        <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Is your plot or site ready?</label>
                                <p class="text-sm text-gray-500">Toggle to "Yes" if your site is prepared for construction</p>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" id="siteReady" name="site_ready">
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                    <div id="landDetails" class="land-details">
                        <div class="bg-blue-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-custom-blue mb-4">Land Details</h3>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <div class="relative">
                                    <label for="land_location" class="block text-sm font-medium text-gray-700 mb-2">Land Location *</label>
                                    <input type="text" id="land_location" name="land_location" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all" placeholder="Enter the land location" required>
                                </div>
                                <div class="relative">
                                    <label for="survey_number" class="block text-sm font-medium text-gray-700 mb-2">Survey Number (Optional)</label>
                                    <input type="text" id="survey_number" name="survey_number" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all" placeholder="Enter survey number if available">
                                </div>
                                <div class="relative">
                                    <label for="land_type" class="block text-sm font-medium text-gray-700 mb-2">Land Type *</label>
                                    <select id="land_type" name="land_type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all" required>
                                        <option value="">Select land type</option>
                                        <option value="residential">Residential</option>
                                        <option value="commercial">Commercial</option>
                                        <option value="industrial">Industrial</option>
                                        <option value="agricultural">Agricultural</option>
                                        <option value="mixed-use">Mixed Use</option>
                                    </select>
                                </div>
                                <div class="relative">
                                    <label for="land_area" class="block text-sm font-medium text-gray-700 mb-2">Plot Size / Built-up Area *</label>
                                    <div class="flex gap-2">
                                        <input type="number" id="land_area" name="land_area" class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all" placeholder="Enter area" required>
                                        <select id="land_unit" name="land_unit" class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all" required>
                                            <option value="">Select Unit</option>
                                            <option value="sqft">Sq.Ft</option>
                                            <option value="sqm">Sq.Mtr</option>
                                            <option value="acres">Acres</option>
                                            <option value="guntha">Guntha</option>
                                            <option value="hectare">Hectare</option>
                                            <option value="square_yards">Square Yards</option>
                                            <option value="cents">Cents</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="site_status" class="block text-sm font-medium text-gray-700 mb-2">Site Status </label>
                                    <select name="site_status" id="site_status" class="form-select @error('site_status') is-invalid @enderror" required>
                                        <option value="">Select site status</option>
                                        <option value="Owned" {{ old( 'site_status')=='Owned' ? 'selected' : '' }}>Owned</option>
                                        <option value="In process" {{ old( 'site_status')=='In process' ? 'selected' : '' }}>In process</option>
                                        <option value="Rented" {{ old( 'site_status')=='Rented' ? 'selected' : '' }}>Rented</option>
                                        <option value="Society approval pending" {{ old( 'site_status')=='Society approval pending' ? 'selected' : '' }}>Society approval pending</option>
                                    </select>
                                    @error('site_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="site_status" class="block text-sm font-medium text-gray-700 mb-2">Utilities on Site </label>
                                    <div class="flex flex-col gap-2">
                                        <div class="flex items-center">
                                            <input type="checkbox" id="water" name="water">
                                            <label for="water" class="ml-2">Water Connection</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="electricity" name="electricity">
                                            <label for="electricity" class="ml-2">Electricity Connection</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="drainage" name="drainage">
                                            <label for="drainage" class="ml-2">Drainage System</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 4. Documentation -->
                <div class="section-divider">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                  <span class="bg-custom-blue text-white rounded-full w-8 h-8 flex items-center justify-center text-sm mr-3">3</span>
                  Documentation
               </h2>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <div class="flex items-center justify-between mb-1">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Architectural Drawings</label>
                                    <p class="text-sm text-gray-500">Do you have architectural plans ready?</p>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" id="archDrawings" name="arch_drawings">
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <!-- Shown only when #archDrawings is checked -->
                            <div id="archUploadWrap" class="mt-3 hidden">
                                <label for="archFiles" class="block text-sm font-medium text-gray-700 mb-1">
                                    Upload Architectural Drawings (PDFs)
                                </label>
                                <input id="archFiles" name="arch_files[]" type="file" multiple accept="application/pdf" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white cursor-pointer" />
                                <small class="text-gray-500">You can select multiple PDF files.</small>
                                <!-- Selected files preview -->
                                <ul id="archFileList" class="mt-2 text-sm text-gray-700 space-y-1"></ul>
                                <!-- Error placeholder -->
                                <p id="archFilesError" class="error-text"></p>
                            </div>
                        </div>
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <div class="flex items-center justify-between mb-1">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Structural Drawings</label>
                                    <p class="text-sm text-gray-500">Do you have structural engineering plans?</p>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" id="structDrawings" name="struct_drawings">
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <!-- Shown only when #structDrawings is checked -->
                            <div id="structUploadWrap" class="mt-3 hidden">
                                <label for="structFiles" class="block text-sm font-medium text-gray-700 mb-1">
                                    Upload Structural Drawings (PDFs)
                                </label>
                                <input id="structFiles" name="struct_files[]" type="file" multiple accept="application/pdf" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white cursor-pointer" />
                                <small class="text-gray-500">You can select multiple PDF files.</small>
                                <!-- Selected files preview -->
                                <ul id="structFileList" class="mt-2 text-sm text-gray-700 space-y-1"></ul>
                                <!-- Error placeholder -->
                                <p id="structFilesError" class="error-text"></p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 bg-orange-50 p-6 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <input type="checkbox" id="boqCheckbox" name="has_boq" class="w-5 h-5 text-custom-blue bg-gray-100 border-gray-300 rounded focus:ring-custom-blue focus:ring-2">
                            <label for="boqCheckbox" class="text-sm font-medium text-gray-700">I have a BOQ (Bill of Quantities) ready for the project</label>
                        </div>
                        <p class="text-sm text-gray-500 mt-2 ml-8">A Bill of Quantities helps contractors provide more accurate estimates</p>
                    </div>
                    <div id="boq-upload-wrapper" class="mt-3">
                        <label for="boqFile" class="block text-sm font-medium text-gray-700 mb-1">Upload BOQ File</label>
                        <input class="w-full px-4 py-2 border border-gray-300 rounded-lg" type="file" id="boqFile" name="boq_file" accept=".xls,.xlsx,.csv,.pdf">
                    </div>
                </div>
                <!-- 5. Timeline & Budget -->
                <div class="section-divider">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                  <span class="bg-custom-blue text-white rounded-full w-8 h-8 flex items-center justify-center text-sm mr-3">4</span>
                  Timeline & Budget
               </h2>
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Expected Start Date</label>
                            <input type="date" id="expected_start" name="expected_start" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all">
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Project Duration</label>
                            <select id="project_duration" name="project_duration" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all">
                                <option value="">Select Project Duration</option>
                                @foreach($expected_timeline as $expected)
                                <option value="{{ $expected->id }}">{{ $expected->timeline }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Budget Range</label>
                            <select id="budget_range" name="budget_range" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all">
                                <option value="">Select budget range</option>
                                @foreach($budgets as $budget)
                                <option value="{{ $budget->id }}">{{ $budget->budget_range }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="payment-preference">
                            <label for="payment_preference" class="block text-sm font-medium text-gray-700 mb-2">Payment Preference </label>
                            <select id="payment_preference" name="payment_preference" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all" required>
                                <option value="">Select payment preference</option>
                                <option value="milestone">Milestone/slab-wise payments</option>
                                <option value="one_time">One-time payment</option>
                                <option value="monthly_bills">Monthly running bills</option>
                            </select>
                        </div>
                        <div class="quality-preference">
                            <label for="quality_preference" class="block text-sm font-medium text-gray-700 mb-2">Quality/Brand Preference </label>
                            <select id="quality_preference" name="quality_preference" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all" required>
                                <option value="">Select quality preference</option>
                                <option value="economy">Economy (Cost-effective options)</option>
                                <option value="standard">Standard (Good quality, reasonable price)</option>
                                <option value="premium">Premium (High-end materials and finishes)</option>
                            </select>
                        </div>
                        <div class="vendor-preference">
                            <label for="vendor_preference" class="block text-sm font-medium text-gray-700 mb-2">Vendor Preference </label>
                            <select id="vendor_preference" name="vendor_preference" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all" required>
                                <option value="">Select vendor preference</option>
                                <option value="local">Local vendors only</option>
                                <option value="nearby">Open to nearby cities</option>
                            </select>
                        </div>
                        <div class="best-time">
                            <label for="best_time" class="block text-sm font-medium text-gray-700 mb-2">Best Time to Call </label>
                            <select id="best_time" name="best_time" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all" required>
                                <option value="">Select best time</option>
                                <option value="morning">Morning (9 AM - 12 PM)</option>
                                <option value="afternoon">Afternoon (12 PM - 5 PM)</option>
                                <option value="evening">Evening (5 PM - 8 PM)</option>
                                <option value="anytime">Anytime</option>
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
    $(document).ready(function () {
        // Initialize all select2
        $('.select2').select2({
            placeholder: "Select an option",
            allowClear: true,
            width: '100%'
        });
    
        // Work Type → Subtypes
        $('#work_type').on('change', function () {
            let workTypeId = $(this).val();
    
            $('#work_subtype').html('<option value="">Loading...</option>').trigger('change');
            $('#vendor_type').html('<option value="">Select Vendor</option>').trigger('change');
            $('#sub_vendor_type_dropdown').html('<option value="">Select Sub Vendor Type</option>').trigger('change');
    
            if (workTypeId) {
                $.ajax({
                    url: '/get-subtypes/' + workTypeId,
                    type: 'GET',
                    success: function (res) {
                        let html = '<option value="">Select Work Subtype</option>';
                        res.forEach(function (item) {
                            html += `<option value="${item.id}">${item.work_subtype}</option>`;
                        });
                        $('#work_subtype').html(html).trigger('change');
                    }
                });
            }
        });
    
        // Subtype → Vendors
        $('#work_subtype').on('change', function () {
            let subtypeId = $(this).val();
    
            $('#vendor_type').html('<option value="">Loading...</option>').trigger('change');
            $('#sub_vendor_type_dropdown').html('<option value="">Select Sub Vendor Type</option>').trigger('change');
    
            if (subtypeId) {
                $.ajax({
                    url: '/get-vendors-id/' + subtypeId,
                    type: 'GET',
                    success: function (res) {
                        let html = '<option value="">Select Vendor</option>';
                        res.forEach(function (item) {
                            html += `<option value="${item.id}">${item.vendor_type}</option>`;
                        });
                        $('#vendor_type').html(html).trigger('change');
                    }
                });
            }
        });
    
        // Vendor → Sub Vendor Types
        $('#vendor_type').on('change', function () {
            let vendorId = $(this).val();
    
            $('#sub_vendor_type_dropdown').html('<option value="">Loading...</option>').trigger('change');
    
            if (vendorId) {
                $.ajax({
                    url: '/get-sub-vendors/' + vendorId,
                    type: 'GET',
                    success: function (res) {
                        let html = '<option value="">Select Sub Vendor Type</option>';
                        if (res.length > 0) {
                            res.forEach(function (item) {
                                html += `<option value="${item.id}">${item.vendor_subcategory}</option>`;
                            });
                        } else {
                            html = '<option value="">No Sub Vendor Types Found</option>';
                        }
                        $('#sub_vendor_type_dropdown').html(html).trigger('change');
                    }
                });
            }
        });
    });
</script>
<script>
    // Get today's date and add 1 day
       const dateInput = document.getElementById('expected_start');
       const today = new Date();
       today.setDate(today.getDate() + 1); // tomorrow
       const tomorrow = today.toISOString().split('T')[0];
       
       // Set min date to tomorrow
       dateInput.min = tomorrow;
</script>
<script>
    // Toggle the upload section
       const archToggle   = document.getElementById('archDrawings');
       const archWrap     = document.getElementById('archUploadWrap');
       const archInput    = document.getElementById('archFiles');
       const archFileList = document.getElementById('archFileList');
       const archErr      = document.getElementById('archFilesError');
       
       archToggle.addEventListener('change', () => {
         archErr.textContent = '';
         if (archToggle.checked) {
           archWrap.classList.remove('hidden');
         } else {
           archWrap.classList.add('hidden');
           archInput.value = '';
           archFileList.innerHTML = '';
         }
       });
       
       // Render selected files
       archInput.addEventListener('change', () => {
         archErr.textContent = '';
         archFileList.innerHTML = '';
       
         [...archInput.files].forEach(file => {
           const li = document.createElement('li');
           li.textContent = `${file.name} (${(file.size/1024/1024).toFixed(2)} MB)`;
           archFileList.appendChild(li);
         });
       });
</script>
<script>
    // Toggle the Structural upload section
       const structToggle   = document.getElementById('structDrawings');
       const structWrap     = document.getElementById('structUploadWrap');
       const structInput    = document.getElementById('structFiles');
       const structFileList = document.getElementById('structFileList');
       const structErr      = document.getElementById('structFilesError');
       
       structToggle.addEventListener('change', () => {
         structErr.textContent = '';
         if (structToggle.checked) {
           structWrap.classList.remove('hidden');
         } else {
           structWrap.classList.add('hidden');
           structInput.value = '';
           structFileList.innerHTML = '';
         }
       });
       
       // Render selected files
       structInput.addEventListener('change', () => {
         structErr.textContent = '';
         structFileList.innerHTML = '';
       
         [...structInput.files].forEach(file => {
           const li = document.createElement('li');
           li.textContent = `${file.name} (${(file.size/1024/1024).toFixed(2)} MB)`;
           structFileList.appendChild(li);
         });
       });
</script>

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
         
       /* Land details & BOQ toggles */
       document.getElementById('siteReady').addEventListener('change', function(){
         const d = document.getElementById('landDetails');
         this.checked ? d.classList.add('show') : d.classList.remove('show');
       });
       $('#boqCheckbox').on('change', function(){
         $(this).is(':checked') ? $('#boq-upload-wrapper').slideDown() : $('#boq-upload-wrapper').slideUp();
       });
       
       
       
       /* ---------------- Form Validation + Submit ---------------- */
       function validateForm(form){
         clearAllErrors(form);
         let ok = true;
       
        
         const siteReady = form.querySelector('#siteReady')?.checked;
         if(siteReady){
           const landLoc = form.querySelector('#land_location');
           const landType = form.querySelector('#land_type');
           const landArea = form.querySelector('#land_area');
           if(!landLoc.value.trim()){ setError(landLoc, 'Enter land location.'); ok = false; }
           if(!landType.value){ setError(landType, 'Select land type.'); ok = false; }
           if(!landArea.value || Number(landArea.value) <= 0){ setError(landArea, 'Enter a valid area.'); ok = false; }
         }
       
         const hasBoq = form.querySelector('#boqCheckbox')?.checked;
         if(hasBoq){
           const fileInput = form.querySelector('#boqFile');
           const f = fileInput.files[0];
           if(!f){ setError(fileInput, 'Please upload your BOQ file.'); ok = false; }
           else if(!/\.(xls|xlsx|csv|pdf)$/i.test(f.name)){ setError(fileInput, 'Allowed: .xls, .xlsx, .csv, .pdf'); ok = false; }
         }
       
         // Architectural Drawings required when toggled ON
         const archOn = form.querySelector('#archDrawings')?.checked;
         if (archOn) {
           const archInput = form.querySelector('#archFiles');
           const files = archInput?.files || [];
           const maxMB = 10;
       
           if (!files.length) {
             setError(archInput, 'Please upload at least one PDF.');
             ok = false;
           } else {
             for (const f of files) {
               const isPdf = f.type === 'application/pdf' || /\.pdf$/i.test(f.name);
               if (!isPdf) {
                 setError(archInput, 'Only PDF files are allowed.');
                 ok = false; break;
               }
               if (f.size > maxMB * 1024 * 1024) {
                 setError(archInput, `Each file must be ≤ ${maxMB} MB.`);
                 ok = false; break;
               }
             }
           }
         }
       // Structural Drawings required when toggled ON
       const structOn = form.querySelector('#structDrawings')?.checked;
       if (structOn) {
         const structInput = form.querySelector('#structFiles');
         const files = structInput?.files || [];
         const maxMB = 10;
       
         if (!files.length) {
           setError(structInput, 'Please upload at least one PDF.');
           ok = false;
         } else {
           for (const f of files) {
             const isPdf = f.type === 'application/pdf' || /\.pdf$/i.test(f.name);
             if (!isPdf) {
               setError(structInput, 'Only PDF files are allowed.');
               ok = false; break;
             }
             if (f.size > maxMB * 1024 * 1024) {
               setError(structInput, `Each file must be ≤ ${maxMB} MB.`);
               ok = false; break;
             }
           }
         }
       }
       
       
         if(!ok){
           const first = form.querySelector('.has-error');
           first?.scrollIntoView({behavior:'smooth', block:'center'});
         }
       
       
         return ok;
       }
</script>
<script>
       
       document.getElementById('projectForm').addEventListener('submit', function(e) {
           e.preventDefault();
           const form = this;
       
        
       
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

@endsection