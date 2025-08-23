@extends('layouts.app')
@section('title', 'Home | ConstructKaro')

@section('content')
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

        <!-- 1. Basic Information -->
        <div class="section-divider">
          <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
            <span class="bg-custom-blue text-white rounded-full w-8 h-8 flex items-center justify-center text-sm mr-3">1</span>
            Basic Information
          </h2>

          <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="relative">
              <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
              <input type="text" id="full_name" name="full_name" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all" placeholder="Enter your full name">
            </div>

            <div class="relative">
              <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
              <div class="flex items-stretch rounded-lg border border-gray-300 focus-within:ring-2 focus-within:ring-custom-blue focus-within:border-custom-blue overflow-hidden">
                <input 
                  type="tel" 
                  id="phone_number" 
                  name="phone_number" 
                  placeholder="Enter your phone number"
                  required
                  class="flex-1 px-3 py-2 outline-none border-0 text-gray-900 placeholder-gray-400" />
              </div>
              <small id="phone_error" class="text-red-600 text-xs"></small>
            </div>

            <div class="relative">
              <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
              <div class="flex items-stretch rounded-lg border border-gray-300 overflow-hidden">
                <input id="email" name="email" type="email" placeholder="Enter your email address"
                  class="flex-1 px-3 py-2 outline-none border-0 text-gray-900 placeholder-gray-400" />
              </div>
              <div id="suggestions" class="absolute left-0 right-0 mt-1 bg-white border border-gray-300 rounded-md shadow hidden z-50 max-h-60 overflow-y-auto"></div>
            </div>

            <div class="relative">
              <label class="block text-sm font-medium text-gray-700 mb-2">Password *</label>
              <div class="relative">
                <input type="password" name="password" id="passwordInput" required
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all"
                  placeholder="Create a password">
                <button type="button" id="passwordToggleBtn"
                  class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none"
                  aria-label="Toggle password visibility">
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

            <div class="relative">
              <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password *</label>
              <div class="relative">
                <input type="password" name="password_confirmation" id="confirmPasswordInput" required
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all"
                  placeholder="Confirm your password">
                <button type="button" id="confirmPasswordToggleBtn"
                  class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none"
                  aria-label="Toggle confirm password visibility">
                  <svg id="eyeIconConfirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
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
          </div>
        </div>

        <!-- 2. Project Details -->
        <div class="section-divider">
          <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
            <span class="bg-custom-blue text-white rounded-full w-8 h-8 flex items-center justify-center text-sm mr-3">2</span>
            Project Details
          </h2>

          <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="relative">
              <label class="block text-sm font-medium text-gray-700 mb-2">Type of Vendor Needed *</label>
              <select id="construction_type" name="construction_type_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all">
                <option value="">Select Construction Type</option>
                @foreach($construction_types as $type)
                  <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
              </select>
            </div>

            <div class="relative">
              <label class="block text-sm font-medium text-gray-700 mb-2">Project Type *</label>
              <select id="project_type" name="project_type_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all">
                <option value="">Select Project Type</option>
              </select>
            </div>
          </div>

          <div id="other_project_type_wrapper" class="mt-4 hidden relative">
            <label class="block text-sm font-medium text-gray-700 mb-2">Other Project Type</label>
            <input type="text" name="project_type_other" id="project_type_other" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all" placeholder="Type your project type">
          </div>

          <div id="sub_categories_container" class="mt-6 hidden">
            <label class="block text-sm font-medium text-gray-700 mb-2">
              <span id="sub_category_title">Select Sub-Categories</span>
            </label>
            <div id="sub_categories" class="grid grid-cols-1 md:grid-cols-2 gap-3"></div>
          </div>
        </div>

        <!-- 3. Site Information -->
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
                <label class="block text-sm font-medium text-gray-700 mb-2">Land Location *</label>
                <input type="text" id="land_location" name="land_location" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all" placeholder="Enter the land location">
              </div>
              <div class="relative">
                <label class="block text-sm font-medium text-gray-700 mb-2">Survey Number (Optional)</label>
                <input type="text" id="survey_number" name="survey_number" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all" placeholder="Enter survey number if available">
              </div>
              <div class="relative">
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
              <div class="relative">
                <label class="block text-sm font-medium text-gray-700 mb-2">Area *</label>
                <div class="flex gap-2">
                  <input type="number" id="land_area" name="land_area" class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all" placeholder="Enter area">
                  <select id="land_unit" name="land_unit" class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all">
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
            </div>
          </div>
        </div>
        </div>

        <!-- 4. Documentation -->
        <div class="section-divider">
          <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
            <span class="bg-custom-blue text-white rounded-full w-8 h-8 flex items-center justify-center text-sm mr-3">4</span>
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

                <input
                  id="archFiles"
                  name="arch_files[]"
                  type="file"
                  accept="application/pdf,.pdf"
                  multiple
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white cursor-pointer"
                />

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

  <input
    id="structFiles"
    name="struct_files[]"
    type="file"
    accept="application/pdf,.pdf"
    multiple
    class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white cursor-pointer"
  />

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
            <span class="bg-custom-blue text-white rounded-full w-8 h-8 flex items-center justify-center text-sm mr-3">5</span>
            Timeline & Budget
          </h2>

          <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- <div class="relative">
              <label class="block text-sm font-medium text-gray-700 mb-2">Expected Start Date</label>
              <input type="date" id="expected_start" name="expected_start" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all">
            </div> -->
            <div class="relative">
              <label class="block text-sm font-medium text-gray-700 mb-2">Expected Start Date</label>
              <input type="date" id="expected_start" name="expected_start"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all">
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
          </div>
        </div>

        <div class="text-center pt-8 border-t border-gray-200">
          <button type="submit" class="gradient-bg hover:shadow-2xl text-white px-6 py-2 rounded-md font-semibold text-base transition-all transform hover:scale-105 shadow-md border border-custom-blue">
            Next →
          </button>
          
           <p class="text-sm text-gray-500 mt-4">
            We'll connect you with verified
            <span id="selectedVendor" class="text-custom-orange font-medium">verified contractors</span>
            within 24 hours
          </p>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
  const constructionSelect = document.getElementById('construction_type');
  const vendorSpan = document.getElementById('selectedVendor');

  constructionSelect.addEventListener('change', function () {
    const selectedText = this.options[this.selectedIndex].text;
    vendorSpan.textContent = selectedText !== "Select Construction Type"
      ? selectedText
      : "verified contractors";
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
  const domains = ["gmail.com","yahoo.com","outlook.com","hotmail.com","icloud.com","protonmail.com","rediffmail.com","mail.com","zoho.com","aol.com"];
  let selectedIndex = -1;

  function renderSuggestions(usernameWithAt, filter = "") {
    suggestionsBox.innerHTML = "";
    selectedIndex = -1;
    const list = domains.filter(d => d.startsWith(filter.toLowerCase())).map(d => usernameWithAt + d);
    if (list.length === 0) return suggestionsBox.classList.add("hidden");
    list.forEach((full, idx) => {
      const div = document.createElement("div");
      div.textContent = full;
      div.className = "px-4 py-2 cursor-pointer text-sm text-gray-700 hover:bg-blue-50";
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
    if (atIndex === -1) return suggestionsBox.classList.add("hidden");
    const usernameWithAt = value.slice(0, atIndex + 1);
    const typedDomainPart = value.slice(atIndex + 1);
    if (typedDomainPart === "" || !typedDomainPart.includes(".") || typedDomainPart.length < 64) {
      renderSuggestions(usernameWithAt, typedDomainPart);
    } else { suggestionsBox.classList.add("hidden"); }
  });

  emailInput.addEventListener("keydown", function (e) {
    const items = suggestionsBox.querySelectorAll("div");
    if (suggestionsBox.classList.contains("hidden") || items.length === 0) return;
    if (e.key === "ArrowDown") { e.preventDefault(); selectedIndex = (selectedIndex + 1) % items.length; updateHighlight(items); }
    else if (e.key === "ArrowUp") { e.preventDefault(); selectedIndex = (selectedIndex - 1 + items.length) % items.length; updateHighlight(items); }
    else if (e.key === "Enter") { e.preventDefault(); if (selectedIndex >= 0 && items[selectedIndex]) { emailInput.value = items[selectedIndex].textContent; suggestionsBox.classList.add("hidden"); } }
    else if (e.key === "Escape") suggestionsBox.classList.add("hidden");
  });

  document.addEventListener("click", function (e) {
    if (!emailInput.contains(e.target) && !suggestionsBox.contains(e.target)) suggestionsBox.classList.add("hidden");
  });

  function updateHighlight(items) {
    items.forEach(i => i.classList.remove("bg-blue-50"));
    if (items[selectedIndex]) { items[selectedIndex].classList.add("bg-blue-50"); items[selectedIndex].scrollIntoView({ block: "nearest" }); }
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

/* Land details & BOQ toggles */
document.getElementById('siteReady').addEventListener('change', function(){
  const d = document.getElementById('landDetails');
  this.checked ? d.classList.add('show') : d.classList.remove('show');
});
$('#boqCheckbox').on('change', function(){
  $(this).is(':checked') ? $('#boq-upload-wrapper').slideDown() : $('#boq-upload-wrapper').slideUp();
});

/* Dependent dropdowns */
$(document).ready(function () {
  $('#construction_type').on('change', function () {
    const typeId = $(this).val();
    $('#project_type').html('<option value="">Loading...</option>');
    $('#sub_categories_container').hide();
    $('#other_project_type_wrapper').hide();

    if (!typeId) {
      $('#project_type').html('<option value="">Select Project Type</option>');
      return;
    }

    $.ajax({
      url: '/get-project-types',
      type: 'GET',
      data: { construction_type_id: typeId },
      success: function (data) {
        $('#project_type').empty().append('<option value="">Select Project Type</option>');
        $.each(data, function (index, item) {
          $('#project_type').append('<option value="' + item.id + '">' + item.name + '</option>');
        });
      }
    });
  });

  $('#project_type').on('change', function () {
    const projectTypeId = $(this).val();
    const constructionTypeId = $('#construction_type').val();

    if (projectTypeId === 'other') $('#other_project_type_wrapper').slideDown();
    else $('#other_project_type_wrapper').slideUp();

    $('#sub_categories').empty();
    $('#sub_categories_container').hide();

    if (projectTypeId && constructionTypeId) {
      $.ajax({
        url: '/get-sub-categories',
        type: 'GET',
        data: { construction_type_id: constructionTypeId, project_type_id: projectTypeId },
        success: function (data) {
          if (data.length > 0) {
            $('#sub_category_title').text('Select Sub-Categories');
            $('#sub_categories_container').show();
            data.forEach(subcat => {
              const html = `
                <label class="inline-flex items-center gap-2 p-2 border rounded">
                  <input type="checkbox" class="form-checkbox" name="sub_categories[]" value="${subcat.const_sub_cat_id}">
                  <span class="text-sm">${subcat.sub_category_name}</span>
                </label>`;
              $('#sub_categories').append(html);
            });
          }
        }
      });
    }
  });
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

  const ctype = form.querySelector('#construction_type');
  if(!ctype.value){ setError(ctype, 'Select construction type.'); ok = false; }

  const ptype = form.querySelector('#project_type');
  if(!ptype.value){ setError(ptype, 'Select project type.'); ok = false; }

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

/* Submit via AJAX only if valid */
document.getElementById('projectForm').addEventListener('submit', function(e){
  e.preventDefault();
  const form = this;
  if(!validateForm(form)) return;

  const formData = new FormData(form);
  $.ajax({
    url: form.action,
    method: 'POST',
    data: formData, processData: false, contentType: false,
    success: function(res){
      if(res.success && res.redirect){ window.location.href = res.redirect; }
      else { alert('Something went wrong!'); }
    },
    error: function(xhr){
      try{
        const data = JSON.parse(xhr.responseText);
        if(data?.errors){
          Object.entries(data.errors).forEach(([key,msgs])=>{
            const el = form.querySelector(`[name="${key}"]`) || form.querySelector(`#${key}`);
            el && setError(el, msgs[0]);
          });
          const first = form.querySelector('.has-error'); first?.scrollIntoView({behavior:'smooth', block:'center'});
          return;
        }
      }catch(_){}
      alert('Submission failed!'); console.error(xhr.responseText);
    }
  });
});
</script>
@endsection
