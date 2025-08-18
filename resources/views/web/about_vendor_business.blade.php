@extends('layouts.app')

@section('title', 'Join as Service Provider | ConstructKaro')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Business Registration Form</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">

<style>
/* Tweak Select2 single select to match .form-select height */
.select2-container .select2-selection--single {
  height: calc(2.5rem + 2px);
  border: 1px solid #ced4da;
  border-radius: .375rem;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
  line-height: 2.4rem;
  padding-left: .75rem;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
  height: calc(2.5rem + 2px);
  right: .5rem;
}
</style>

<style>
   #valueInWords {
      margin-top: 5px;
      color: black;
      font-style: italic;
    }
  .form-wrapper {
    background-color: #fff;
    padding: 2.5rem;
    border-radius: 16px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
    margin-top: 2rem;
    margin-bottom: 3rem;
  }
  body { background-color: #f8f9fb; font-family: 'Segoe UI', sans-serif; }
  h4, h5 { font-weight: 700; background: linear-gradient(90deg, #2949e9ff, #1c2c3e); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
  .form-label { font-weight: 600; color: #1b2a3d; }
  .form-control, .form-select { border-radius: 8px; border: 1px solid #ced4da; transition: border-color 0.2s ease, box-shadow 0.2s ease; }
  .form-control:focus, .form-select:focus { border-color: #f47c1c; box-shadow: 0 0 0 0.2rem rgba(244,124,28,0.25); }
  .form-section { background:#fff; border:1px solid #e3e6ea; border-left:5px solid #f47c1c; padding:1.5rem; margin-bottom:2rem; border-radius:12px; }
  .btn-primary { background-color:#f47c1c; border:none; font-weight:600; padding:12px 24px; border-radius:8px; transition:.3s; }
  .btn-primary:hover { background-color:#e86e12; }
  .progress { height: 10px; }
  .progress + .progress { margin-top: .5rem; }
  input[type="file"] { padding: 6px; border-radius: 6px; }
</style>

<div class="form-wrapper">
  <h5>Tell us more about your business</h5>
  <h4>Complete your profile to start receiving project requests</h4>

  <!-- Per-file progress list -->
  <ul id="fileProgressList" class="list-group my-3" style="display:none;"></ul>

  <!-- Whole-form upload progress (fallback/success indicator) -->
  <div id="uploadProgressWrap" class="mt-3" style="display:none;">
    <div class="d-flex justify-content-between">
      <small>Uploading…</small>
      <small><span id="uploadPercent">0</span>%</small>
    </div>
    <div class="progress">
      <div id="uploadBar" class="progress-bar" role="progressbar" style="width:0%"></div>
    </div>
  </div>

  <form id="businessForm" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-section">
      <h5>Basic Business Information</h5>
      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label">Years of Experience *</label>
          <select class="form-select" id="experience_years" name="experience_years">
            <option>Select years of experience</option>
            <option value="1">0-2 Years</option>
            <option value="2">3-5 Years</option>
            <option value="3">6-10 Years</option>
            <option value="4">11-15 Years</option>
            <option value="5">16-20 Years</option>
            <option value="6">20+ Years</option>
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Team Size *</label>
          <select class="form-select" id="team_size" name="team_size">
            <option>Select team size</option>
            <option value="1">Just Me</option>
            <option value="2">2-5 people</option>
            <option value="3">6-10 people</option>
            <option value="4">11-20 people</option>
            <option value="5">21-50 people</option>
            <option value="6">50+ people</option>
          </select>
        </div>
      </div>
      <div class="row mb-3">
        <!-- <div class="col-md-6">
          <label class="form-label">Service Coverage Area *</label>
          <input type="text" id="service_coverage_area" name="service_coverage_area" class="form-control" placeholder="City/State (e.g., Mumbai, Maharashtra)">
        </div> -->
        <div class="col-md-6">
          <label class="form-label">Service Coverage Area *</label>
          <select id="service_coverage_area" name="service_coverage_area[]" class="form-select" multiple required>

            <option value="">-- Select Service Coverage Area --</option>

        
          </select>
        </div>

        <!-- <div class="col-md-6">
          <label class="form-label">Accepting projects of minimum value (₹) *</label>
          <input type="number" id="min_project_value" name="min_project_value" class="form-control" placeholder="₹ Minimum project value">
        </div> -->
        <div class="col-md-6">
          <label class="form-label">Accepting projects of minimum value (₹) *</label>
          <input type="number" id="min_project_value" name="min_project_value" class="form-control" placeholder="₹ Minimum project value">
          <div id="valueInWords"></div>
        </div>

      </div>
    </div>

    <hr>

    <!-- Company Details -->
    <div class="form-section">
      <h5>Company Details</h5>
      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label">Company Name *</label>
          <input type="text" class="form-control" id="company_name" name="company_name">
        </div>
        <div class="col-md-6">
          <label class="form-label">Type of Entity *</label>
          <select id="entity_type" name="entity_type" class="form-select">
            <option value="">-- Select --</option>
            @foreach ($entity_type as $entity)
              <option value="{{ $entity->id }}">{{ $entity->entity_type }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6 mt-3" id="aadhar_section" style="display: none;">
          <label class="form-label">Aadhar Card No</label>
          <input type="text" name="aadhar_card_no" id="aadhar_card_no" class="form-control" maxlength="12" placeholder="Enter Aadhar number">
          <div id="aadhar_error" style="color: red; display: none;">Please enter a valid 12-digit Aadhar number.</div>
        </div>
        <!-- <div class="col-md-6 mt-3" id="cin_section" style="display: none;">
          <label class="form-label">CIN No</label>
          <input type="text" name="cin_no" id="cin_no" class="form-control" placeholder="Enter CIN number">
        </div> -->
        <div class="col-md-6 mt-3" id="cin_section" style="display: none;">
          <label class="form-label">CIN No</label>
          <input type="text" name="cin_no" id="cin_no" class="form-control" placeholder="Enter CIN number" maxlength="21" style="text-transform: uppercase;">
          <div id="cin_error" style="color: red; display: none;">Please enter a valid 21-character CIN number.</div>
        </div>
        <div class="col-md-6 mt-3" id="llpin" style="display: none;">
          <label class="form-label">LLPIN No</label>
          <input type="text" name="llpin_no" id="llpin_no" class="form-control" placeholder="Enter LLPIN number">
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Registered Office Address *</label>
        <textarea class="form-control" id="registered_address" name="registered_address"></textarea>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label">Contact Person Designation *</label>
          <input type="text" id="contact_person_designation" name="contact_person_designation" class="form-control">
        </div>
        <!-- <div class="col-md-6">
          <label class="form-label">GST Number *</label>
          <input type="text" id="gst_number" name="gst_number" class="form-control">
        </div> -->
        <div class="col-md-6">
          <label class="form-label">GST Number *</label>
          <input type="text" id="gst_number" name="gst_number" class="form-control" maxlength="15">
          <div id="gst_error" style="color: red; display: none;">GST number must be exactly 15 characters.</div>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label">PAN Number *</label>
          <input type="text" id="pan_number" name="pan_number" class="form-control" maxlength="10" style="text-transform: uppercase;">
          <div id="pan_error" style="color: red; display: none;">Please enter a valid PAN number.</div>
        </div>
        <div class="col-md-6">
          <label class="form-label">TAN Number *</label>
          <input type="text" id="tan_number" name="tan_number" class="form-control" maxlength="10" style="text-transform: uppercase;">
          <div id="tan_error" style="color: red; display: none;">Please enter a valid TAN number.</div>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label">ESIC Number </label>
          <input type="text" id="esic_number" name="esic_number" class="form-control" maxlength="17">
          <div id="esic_error" style="color: red; display: none;">Please enter a valid 17-digit ESIC number.</div>
        </div>
        <div class="col-md-6">
          <label class="form-label">PF No</label>
          <input type="text" id="pf_code" name="pf_code" class="form-control">
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label">MSME/Udyam Registered *</label><br>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="msme_registered" value="yes" onclick="toggleMsmeUpload()">
            <label class="form-check-label">Yes</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="msme_registered" value="no" onclick="toggleMsmeUpload()">
            <label class="form-check-label">No</label>
          </div>
          <div id="msmeUploadSection" style="display: none; margin-top: 10px;">
            <label for="msme_file" class="form-label">Upload MSME/Udyam Certificate:</label>
            <input type="file" id="msme_file" name="msme_file" class="form-control" accept="application/pdf">
          </div>
        </div>

        <div class="col-md-6" id="aadhar_pan_link_section" style="display: none;">
          <label class="form-label">PAN-Aadhar Seeded? *</label><br>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="pan_aadhar_seeded" value="yes" onclick="toggleOptions()">
            <label class="form-check-label">Yes</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="pan_aadhar_seeded" value="no" onclick="toggleOptions()">
            <label class="form-check-label">No</label>
          </div>

          <div id="uploadSection" style="display: none; margin-top: 10px;">
            <label for="uploadadharpanFile" class="form-label">Upload link Document:</label>
            <input type="file" id="uploadadharpanFile" name="uploadadharpanFile" class="form-control" accept="application/pdf">
          </div>
          <div id="linkSection" style="display: none; margin-top: 10px;">
            <a href="https://eportal.incometax.gov.in/iec/foservices/#/pre-login/bl-link-aadhaar" target="_blank">
              Click here to link PAN with Aadhar
            </a>
          </div>
        </div>
      </div>
    </div>

    <hr>

    <!-- Bank Details -->
    <div class="form-section">
      <h5>Bank Details</h5>
      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label">Bank Name *</label>
          <input type="text"id="bank_name" name="bank_name" class="form-control">
        </div>
        <div class="col-md-6">
          <label class="form-label">Account Number *</label>
          <input type="text" id="account_number" name="account_number" class="form-control">
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label">IFSC Code *</label>
          <input type="text" id="ifsc_code" name="ifsc_code" class="form-control">
        </div>
        <!-- <div class="col-md-6">
          <label class="form-label">Type of Account *</label>
          <select class="form-select" id="account_type" name="account_type">
            <option>Select account type</option>
            <option value="1">Savings</option>
            <option value="2">Current</option>
          </select>
        </div> -->
        <div class="col-md-6">
          <label class="form-label">Type of Account *</label>
          <select class="form-select" id="account_type" name="account_type" required>
            <option value="">Select account type</option>
            <option value="1">Savings</option>
            <option value="2">Current</option>
            <option value="3">Salary</option>
            <option value="4">Fixed Deposit</option>
            <option value="5">Recurring Deposit</option>
            <option value="6">NRO (Non-Resident Ordinary)</option>
            <option value="7">NRE (Non-Resident External)</option>
          </select>
        </div>

      </div>
      <div class="mb-3">
        <label class="form-label">Upload Cancelled Cheque or Bank Passbook Copy *</label>
        <input type="file" id="cancelled_cheque_file" name="cancelled_cheque_file" class="form-control" accept="application/pdf">
      </div>
    </div>

    <!-- Required Documents -->
    <div class="form-section">
      <h5>Required Documents</h5>
      <div class="row g-3">
        <div class="col-md-6">PAN Card *<input accept="application/pdf" type="file" id="pan_card_file" name="pan_card_file" class="form-control"></div>
        <div class="col-md-6">Aadhaar Card (Authorised Person) *<input accept="application/pdf" type="file" id="aadhaar_card_file" name="aadhaar_card_file" class="form-control"></div>
        <div class="col-md-6">Certificate of Incorporation (If company/LLP) *<input accept="application/pdf" type="file" id="certificate_of_incorporation_file" name="certificate_of_incorporation_file" class="form-control"></div>
        <div class="col-md-6">3 Years ITR PDF (Latest First) *<input accept="application/pdf" type="file" id="itr_file" name="itr_file" class="form-control"></div>
        <div class="col-md-6">Turnover Certificate (CA Certified) *<input accept="application/pdf" type="file" id="turnover_certificate_file" name="turnover_certificate_file" class="form-control"></div>
        <div class="col-md-6">Work Completion Certificates – 3 Similar Projects *<input accept="application/pdf" type="file" id="work_completion_certificates_file" name="work_completion_certificates_file" class="form-control"></div>
        <div class="col-md-6">PF / ESIC Registration Documents *<input accept="application/pdf" type="file" id="pf_esic_documents_file" name="pf_esic_documents_file" class="form-control"></div>
        <div class="col-md-6">Company Profile / Work Brochure (Optional)<input accept="application/pdf" type="file" id="company_profile_file" name="company_profile_file" class="form-control"></div>
      </div>
    </div>

    <hr>

    <!-- Portfolio & Work Samples -->
    <div class="form-section">
      <h5>Portfolio & Work Samples</h5>
      <div class="mb-3">
        <label class="form-label">Upload Portfolio (PDFs) *</label>
        <input type="file" id="portfolio_file" name="portfolio_file" class="form-control" accept="application/pdf">
      </div>
      <div class="mb-3">
        <label class="form-label">Upload Past Work Photos *</label>
        <!-- Even photos are PDF-only per your requirement -->
        <input type="file" id="past_work_photos_file" name="past_work_photos_file" class="form-control" accept="application/pdf">
      </div>
      <div class="mb-3">
        <label class="form-label">License/Certification Upload</label>
        <input type="file" id="license_certificate_file" name="license_certificate_file" class="form-control" accept="application/pdf">
      </div>
    </div>

    <div class="form-check mb-3">
      <input class="form-check-input" type="checkbox" id="agreed_declaration" name="agreed_declaration">
      <label class="form-check-label" for="agreed_declaration">
        I hereby declare that the above information is true and I am authorised to register this company.
      </label>
    </div>

    <button type="submit" class="btn btn-primary">Submit for Verification</button>
  </form>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>

<script>
  // Entity toggles
  $('#entity_type').on('change', function () {
    const value = $(this).val();
    if (value === '3' || value === '4' || value === '5') {
      $('#aadhar_pan_link_section').show();
      $('#aadhar_section').show();
      $('#cin_section').hide();
      $('#llpin').hide();
    } else if (value === '6') {
      $('#aadhar_pan_link_section').hide();
      $('#aadhar_section').hide();
      $('#cin_section').hide();
      $('#llpin').show();
    } else if (value !== '') {
      $('#aadhar_pan_link_section').hide();
      $('#cin_section').show();
      $('#aadhar_section').hide();
      $('#llpin').hide();
    } else {
      $('#llpin, #aadhar_pan_link_section, #aadhar_section, #cin_section').hide();
    }
  });

  function toggleOptions() {
    const selectedValue = document.querySelector('input[name="pan_aadhar_seeded"]:checked').value;
    const uploadSection = document.getElementById('uploadSection');
    const linkSection = document.getElementById('linkSection');
    if (selectedValue === 'yes') {
      uploadSection.style.display = 'block';
      linkSection.style.display = 'none';
    } else if (selectedValue === 'no') {
      uploadSection.style.display = 'block';
      linkSection.style.display = 'block';
    }
  }

  function toggleMsmeUpload() {
    const selectedValue = document.querySelector('input[name="msme_registered"]:checked').value;
    const msmeUploadSection = document.getElementById('msmeUploadSection');
    msmeUploadSection.style.display = (selectedValue === 'yes') ? 'block' : 'none';
  }
</script>

<script>
  // ==== Client validation & sequential uploads ====

  // Force all file inputs to accept PDFs (extra safety)
  $('input[type="file"]').attr('accept', 'application/pdf');

  function isPdfFile(file) {
    if (!file) return true;
    const nameOk = /\.pdf$/i.test(file.name);
    const typeOk = (file.type === 'application/pdf' || file.type === '');
    return nameOk && typeOk;
  }
  function validateOnlyPdf(formEl) {
    const files = formEl.querySelectorAll('input[type="file"]');
    const bad = [];
    files.forEach(inp => {
      const f = inp.files && inp.files[0];
      if (f && !isPdfFile(f)) bad.push(inp.name || inp.id);
    });
    if (bad.length) {
      alert('Only PDF files are allowed. Fix:\n- ' + bad.join('\n- '));
      return false;
    }
    return true;
  }

  // Optional size check (20 MB per file)
  const MAX_MB = 20;
  function checkSizes(formEl) {
    const tooBig = [];
    formEl.querySelectorAll('input[type="file"]').forEach(inp => {
      const f = inp.files && inp.files[0];
      if (f && f.size > MAX_MB * 1024 * 1024) {
        tooBig.push(`${inp.name || inp.id} (${(f.size/1024/1024).toFixed(1)}MB)`);
      }
    });
    if (tooBig.length) {
      alert(`Each file must be ≤ ${MAX_MB} MB:\n- ` + tooBig.join('\n- '));
      return false;
    }
    return true;
  }

  const fileFields = [
    'msme_file','uploadadharpanFile',
    'cancelled_cheque_file',
    'pan_card_file','aadhaar_card_file','certificate_of_incorporation_file',
    'itr_file','turnover_certificate_file','work_completion_certificates_file',
    'pf_esic_documents_file','company_profile_file',
    'portfolio_file','past_work_photos_file','license_certificate_file'
  ];

  function collectFilesMap() {
    const map = {};
    fileFields.forEach(name => {
      const el = document.getElementById(name);
      if (el && el.files && el.files[0]) map[name] = el.files[0];
    });
    return map;
  }

  function addProgressItem(name, label) {
    const list = document.getElementById('fileProgressList');
    list.style.display = 'block';
    const li = document.createElement('li');
    li.className = 'list-group-item d-flex justify-content-between align-items-center';
    li.id = `prog-${name}`;
    li.innerHTML = `<span>${label}</span><span class="badge bg-secondary" id="pct-${name}">0%</span>`;
    list.appendChild(li);
  }
  function setProgress(name, pct, done) {
    const badge = document.getElementById(`pct-${name}`);
    if (!badge) return;
    badge.textContent = done ? 'Done' : `${pct}%`;
    badge.className = 'badge ' + (done ? 'bg-success' : 'bg-info');
  }

  async function uploadOne(fieldName, file) {
    return new Promise((resolve, reject) => {
      const fd = new FormData();
      fd.append('file', file);
      fd.append('field', fieldName);

      const xhr = new XMLHttpRequest();
      xhr.open('POST', "{{ route('business.uploadFile') }}");
      xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));

      xhr.upload.onprogress = (e) => {
        if (e.lengthComputable) {
          const pct = Math.round((e.loaded / e.total) * 100);
          setProgress(fieldName, pct, false);
        }
      };
      xhr.onload = () => {
        if (xhr.status >= 200 && xhr.status < 300) {
          try {
            const json = JSON.parse(xhr.responseText);
            setProgress(fieldName, 100, true);
            resolve(json.path); // stored relative path
          } catch (e) { reject('Invalid server response'); }
        } else {
          reject(xhr.responseText || 'Upload failed');
        }
      };
      xhr.onerror = () => reject('Network error');
      xhr.send(fd);
    });
  }

  $(document).ready(function () {
    let submitting = false;

    $('#businessForm').on('submit', async function (e) {
      e.preventDefault();
      if (submitting) return;

      if (!validateOnlyPdf(this)) return;
      if (!checkSizes(this)) return;

      submitting = true;
      const $btn = $(this).find('button[type="submit"]');
      $btn.prop('disabled', true).text('Submitting…');

      // Show overall progress bar
      $('#uploadProgressWrap').show();
      $('#uploadBar').css('width', '0%');
      $('#uploadPercent').text('0');

      const filesMap = collectFilesMap();
      document.getElementById('fileProgressList').innerHTML = '';
      Object.entries(filesMap).forEach(([name, file]) => addProgressItem(name, file.name));

      // Upload files sequentially
      const storedPaths = {};
      const entries = Object.entries(filesMap);
      for (let i = 0; i < entries.length; i++) {
        const [name, file] = entries[i];
        try {
          storedPaths[name] = await uploadOne(name, file);
          const pctOverall = Math.round(((i+1) / entries.length) * 100);
          $('#uploadBar').css('width', pctOverall + '%');
          $('#uploadPercent').text(pctOverall);
        } catch (err) {
          alert(`Failed to upload ${name}: ${err}`);
          submitting = false;
          $btn.prop('disabled', false).text('Submit for Verification');
          return;
        }
      }

      // Submit rest of form with stored file paths (no big payload now)
      const formData = new FormData(this);
      Object.keys(filesMap).forEach(name => formData.delete(name)); // remove actual files
      formData.append('uploaded_paths', JSON.stringify(storedPaths));

      $.ajax({
        url: "{{ route('business.store') }}",
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        timeout: 300000,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function () {
          alert('Form submitted successfully!');
          window.location.href = '{{ route("vendor_confiermetion") }}';
        },
        error: function (xhr) {
          let msg = 'Something went wrong.';
          if (xhr.responseJSON && xhr.responseJSON.errors) {
            msg = Object.values(xhr.responseJSON.errors).flat().join('\n');
          }
          alert(msg);
        },
        complete: function () {
          submitting = false;
          $btn.prop('disabled', false).text('Submit for Verification');
          $('#uploadProgressWrap').hide();
        }
      });
    });
  });
</script>
<script>
$(function () {
  // If this select was already enhanced, destroy and re-init (prevents "no search" bugs)
  if ($('#service_coverage_area').data('select2')) {
    $('#service_coverage_area').select2('destroy');
  }

  $('#service_coverage_area').select2({
    width: '100%',
    placeholder: '-- Select Service Coverage Area --',
    allowClear: true,
    minimumResultsForSearch: 0,
    dropdownParent: $(document.body),

    // Group-aware matcher: matches option text OR group label.
    matcher: function (params, data) {
      const term = $.trim(params.term || '').toLowerCase();
      if (term === '') return data;  // show all when no search

      // If this is a group (has children)
      if (data.children && data.children.length) {
        const groupLabel = (data.text || '').toLowerCase();

        // 1) If group label matches, return whole group unchanged
        if (groupLabel.includes(term)) {
          return data;
        }

        // 2) Otherwise, filter children by their text
        const filteredChildren = [];
        for (let i = 0; i < data.children.length; i++) {
          const child = data.children[i];
          if ((child.text || '').toLowerCase().includes(term)) {
            // Clone the child so Select2 can render it
            filteredChildren.push($.extend(true, {}, child));
          }
        }

        if (filteredChildren.length) {
          const modifiedData = $.extend(true, {}, data);
          modifiedData.children = filteredChildren;
          return modifiedData;
        }
        // No children matched → hide this group
        return null;
      }

      // Regular option
      if ((data.text || '').toLowerCase().includes(term)) {
        return data;
      }

      // As a fallback, try to match option's parent <optgroup> label
      const el = data.element;
      const groupLabel = el && el.parentElement && el.parentElement.label
        ? el.parentElement.label.toLowerCase()
        : '';
      if (groupLabel.includes(term)) {
        return data;
      }

      return null;
    }
  });
});
</script>

<script>
fetch('/get-service-areas')
  .then(res => res.json())
  .then(data => {
    const select = document.getElementById('service_coverage_area');
    select.innerHTML = '';

    const defaultOption = document.createElement('option');
    defaultOption.textContent = '-- Select Service Coverage Area --';
    defaultOption.value = '';
    select.appendChild(defaultOption);

    data.forEach(group => {
      const optgroup = document.createElement('optgroup');
      optgroup.label = group.region;

      group.areas.forEach(area => {
        const option = document.createElement('option');
        option.value = area;
        option.textContent = area;
        optgroup.appendChild(option);
      });

      select.appendChild(optgroup);
    });
  });
</script>
<script>
  document.getElementById("min_project_value").addEventListener("input", function() {
    const num = parseInt(this.value);
    const valueInWords = document.getElementById("valueInWords");

    if (!num || isNaN(num)) {
      valueInWords.innerText = "";
      return;
    }

    valueInWords.innerText = "In words: " + numberToWords(num);
  });

  function numberToWords(num) {
    const a = [
      '', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine',
      'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen',
      'seventeen', 'eighteen', 'nineteen'
    ];
    const b = [
      '', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy',
      'eighty', 'ninety'
    ];

    if (num === 0) return 'zero';
    if (num > 999999) return 'Number too large';

    function inWords(n) {
      if (n < 20) return a[n];
      if (n < 100) return b[Math.floor(n / 10)] + (n % 10 ? " " + a[n % 10] : "");
      if (n < 1000) return a[Math.floor(n / 100)] + " hundred" + (n % 100 ? " " + inWords(n % 100) : "");
      if (n < 100000) return inWords(Math.floor(n / 1000)) + " thousand" + (n % 1000 ? " " + inWords(n % 1000) : "");
      return inWords(Math.floor(n / 100000)) + " lakh" + (n % 100000 ? " " + inWords(n % 100000) : "");
    }

    let words = inWords(num);
    return words.charAt(0).toUpperCase() + words.slice(1);
  }
</script>

<script>
  const gstInput = document.getElementById('gst_number');
  const gstError = document.getElementById('gst_error');

  gstInput.addEventListener('blur', () => {
    const gstValue = gstInput.value.trim();
    if (gstValue.length !== 15) {
      gstError.style.display = 'block';
      gstInput.classList.add('is-invalid');
    } else {
      gstError.style.display = 'none';
      gstInput.classList.remove('is-invalid');
    }
  });
</script>

<script>
  const panInput = document.getElementById('pan_number');
  const panError = document.getElementById('pan_error');

  function isValidPAN(pan) {
    const panRegex = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;
    return panRegex.test(pan.toUpperCase());
  }

  panInput.addEventListener('blur', () => {
    const panValue = panInput.value.trim().toUpperCase();
    panInput.value = panValue; // convert to uppercase
    if (!isValidPAN(panValue)) {
      panError.style.display = 'block';
      panInput.classList.add('is-invalid');
    } else {
      panError.style.display = 'none';
      panInput.classList.remove('is-invalid');
    }
  });
</script>
<script>
  const tanInput = document.getElementById('tan_number');
  const tanError = document.getElementById('tan_error');

  function isValidTAN(tan) {
    const tanRegex = /^[A-Z]{4}[0-9]{5}[A-Z]{1}$/;
    return tanRegex.test(tan.toUpperCase());
  }

  tanInput.addEventListener('blur', () => {
    const tanValue = tanInput.value.trim().toUpperCase();
    tanInput.value = tanValue; // convert to uppercase
    if (!isValidTAN(tanValue)) {
      tanError.style.display = 'block';
      tanInput.classList.add('is-invalid');
    } else {
      tanError.style.display = 'none';
      tanInput.classList.remove('is-invalid');
    }
  });
</script>
<script>
  const esicInput = document.getElementById('esic_number');
  const esicError = document.getElementById('esic_error');

  function isValidESIC(esic) {
    const esicRegex = /^\d{17}$/;
    return esicRegex.test(esic);
  }

  esicInput.addEventListener('blur', () => {
    const esicValue = esicInput.value.trim();
    if (esicValue !== "" && !isValidESIC(esicValue)) {
      esicError.style.display = 'block';
      esicInput.classList.add('is-invalid');
    } else {
      esicError.style.display = 'none';
      esicInput.classList.remove('is-invalid');
    }
  });
</script>
<script>
  const cinInput = document.getElementById('cin_no');
  const cinError = document.getElementById('cin_error');

 

  function isValidCIN(cin) {
  const cinRegex = /^[LU]{1}[0-9]{5}[A-Z]{2}[0-9]{4}[A-Z]{3}[0-9]{6}$/;
  return cinRegex.test(cin.toUpperCase());
}


  cinInput.addEventListener('blur', () => {
    const cinValue = cinInput.value.trim().toUpperCase();
    cinInput.value = cinValue; // auto uppercase
    if (cinValue !== "" && !isValidCIN(cinValue)) {
      cinError.style.display = 'block';
      cinInput.classList.add('is-invalid');
    } else {
      cinError.style.display = 'none';
      cinInput.classList.remove('is-invalid');
    }
  });
</script>
<script>
  const aadharInput = document.getElementById('aadhar_card_no');
  const aadharError = document.getElementById('aadhar_error');

  function isValidAadhar(aadhar) {
    const aadharRegex = /^\d{12}$/;
    return aadharRegex.test(aadhar);
  }

  aadharInput.addEventListener('blur', () => {
    const aadharValue = aadharInput.value.trim();
    if (aadharValue !== "" && !isValidAadhar(aadharValue)) {
      aadharError.style.display = 'block';
      aadharInput.classList.add('is-invalid');
    } else {
      aadharError.style.display = 'none';
      aadharInput.classList.remove('is-invalid');
    }
  });
</script>
@endsection
