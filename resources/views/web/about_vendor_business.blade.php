@extends('layouts.app') @section('title', 'Join as Service Provider | ConstructKaro') @section('content')
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
                        <option value="">Select years of experience</option>
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
                <div class="col-md-6">
                    <label for="state" class="form-label">Operating In*</label>
                    <select name="state" id="state" class="form-control">
                        <option value="">-- Select State --</option>
                        @foreach ($states as $state)
                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="region" class="form-label">Covering Key Region *</label>
                    <select name="region[]" id="region" class="form-control" multiple>
                        <option value="">-- Select Region --</option>
                    </select>
                </div>

                <!-- <div class="col-md-6">
               <label for="city" class="form-label">Select City *</label>
               <select name="city[]" id="city" class="form-control" multiple>
                  <option value="">-- Select City --</option>
               </select>
            </div> -->
                <div class="col-md-6">
                    <label class="form-label">Accepting projects of minimum value (₹) *</label>
                    <input type="number" id="min_project_value" name="min_project_value" class="form-control" placeholder="₹ Minimum project value">
                    <div id="valueInWords" class="mt-2 text-muted"></div>
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
                <div class="col-md-6 mt-3" id="cin_section" style="display: none;">
                    <label class="form-label">CIN No</label>
                    <input type="text" name="cin_no" id="cin_no" class="form-control" placeholder="Enter CIN number" maxlength="21" style="text-transform: uppercase;">
                    <div id="cin_error" style="color: red; display: none;">Please enter a valid 21-character CIN number.</div>
                </div>
                <div class="col-md-6 mt-3" id="llpin" style="display: none;">
                    <label class="form-label">LLPIN No</label>
                    <input type="text" name="llpin_no" id="llpin_no" class="form-control" placeholder="Enter LLPIN number">
                </div>
                <div class="col-md-6 mt-3" id="partnershipdeed" style="display: none;">
                    <label class="form-label">Partnership deed</label>
                    <input type="text" name="partnershipdeed_no" id="partnershipdeed_no" class="form-control" placeholder="Enter Partnership deed number">
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
                <div class="col-md-6">
                    <label class="form-label">GST Number </label>
                    <input type="text" id="gst_number" name="gst_number" class="form-control" style="text-transform: uppercase;" maxlength="15">
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
                    <label class="form-label">TAN Number</label>
                    <input type="text" id="tan_number" name="tan_number" class="form-control" maxlength="10" style="text-transform: uppercase;">
                    <div id="tan_error" style="color: red; display: none;">Please enter a valid TAN number (format: AAAA99999A).</div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">ESIC Number </label>
                    <input type="text" id="esic_number" name="esic_number" class="form-control" maxlength="17" style="text-transform: uppercase;">
                    <div id="esic_error" style="color: red; display: none;">Please enter a valid 17-digit ESIC number.</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">PF No</label>
                    <input type="text" id="pf_code" name="pf_code" class="form-control" style="text-transform: uppercase;">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">MSME/Udyam Registered *</label>
                    <br>
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
                <!-- <div class="col-md-6" id="aadhar_pan_link_section" style="display: none;">
                    <label class="form-label">PAN-Aadhar Seeded? *</label>
                    <br>
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
                </div> -->
            </div>
        </div>
        <hr>
        <!-- Bank Details -->
        <div class="form-section">
            <h5>Bank Details</h5>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Bank Name </label>
                    <input type="text" id="bank_name" name="bank_name" class="form-control" style="text-transform: uppercase;">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Account Number </label>
                    <input type="text" id="account_number" name="account_number" class="form-control">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">IFSC Code </label>
                    <input type="text" id="ifsc_code" name="ifsc_code" class="form-control" style="text-transform: uppercase;">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Type of Account </label>
                    <select class="form-select" id="account_type" name="account_type" required>
                        <option value="">Select account type</option>
                        <option value="1">Savings</option>
                        <option value="2">Current</option>
                        <option value="3">Client Referance</option>
                        <option value="4">Fixed Deposit</option>
                        <option value="5">Recurring Deposit</option>
                        <option value="6">NRO (Non-Resident Ordinary)</option>
                        <option value="7">NRE (Non-Resident External)</option>
                        <option value="8">Overdraft</option>
                        <option value="9">Cash Credit</option>

                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Upload Cancelled Cheque or Bank Passbook Copy <small class="text-muted">(PDF, max 20 MB)</small></label>
                <input type="file" id="cancelled_cheque_file" name="cancelled_cheque_file" class="form-control" accept="application/pdf">
            </div>
        </div>

        <div class="form-section">
            <h5>Required Documents</h5>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label required">PAN Card<small class="text-muted">(PDF, max 20 MB)</small></label>
                    <input accept="application/pdf" type="file" id="pan_card_file" name="pan_card_file" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label required">GST Certificate<small class="text-muted">(PDF, max 20 MB)</small></label>
                    <input accept="application/pdf" type="file" id="gst_certificate_file" name="gst_certificate_file" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label required">Aadhaar Card (Authorised Person)<small class="text-muted">(PDF, max 20 MB)</small></label>
                    <input accept="application/pdf" type="file" id="aadhaar_card_file" name="aadhaar_card_file" class="form-control">
                </div>

                <div class="col-md-6">
                    <label id="certificate_label" class="form-label required">
                        Certificate of Incorporation / LLPIN / SHOP ACT (For Proprietor)<small class="text-muted">(PDF, max 20 MB)</small>
                    </label>
                    <input accept="application/pdf" type="file" id="certificate_of_incorporation_file" name="certificate_of_incorporation_file" class="form-control" multiple>
                    <ul id="file_list" class="file-list"></ul>
                </div>

                <div class="col-md-12" id="itr_section" style="display:none; margin-top:15px;">
                    <label class="form-label required">Upload ITR PDFs<small class="text-muted">(PDF, max 20 MB)</small></label>

                    <div class="mb-2">
                        <label>FY 24–25 *</label>
                        <input accept="application/pdf" type="file" name="itr_24_25" class="form-control itr_file">
                    </div>
                    <div class="mb-2">
                        <label>FY 23–24 *</label>
                        <input accept="application/pdf" type="file" name="itr_23_24" class="form-control itr_file">
                    </div>
                    <div class="mb-2">
                        <label>FY 22–23 *</label>
                        <input accept="application/pdf" type="file" name="itr_22_23" class="form-control itr_file">
                    </div>
                </div>

                <!-- <div class="col-md-6">
                    <label class="form-label required">Turnover Certificate (CA Certified)</label>
                    <input accept="application/pdf" type="file" id="turnover_certificate_file" name="turnover_certificate_file" class="form-control">
                </div> -->
                <!-- <div class="col-md-6"></div> -->

                <!-- <div class="col-md-4">
                    <label class="form-label required">Work Completion Certificate(Add 3 Documents)<small class="text-muted">(PDF,20 MB)</small></label>
                    <input accept="application/pdf" type="file" id="work_completion_certificates_file1" name="work_completion_certificates_file1" class="form-control">
                    <ul id="work_completion_certificates_list1" class="file-list"></ul>
                </div>

                <div class="col-md-4">
                    <label class="form-label required"></label>
                    <input accept="application/pdf" type="file" id="work_completion_certificates_file2" name="work_completion_certificates_file2" class="form-control">
                    <ul id="work_completion_certificates_list2" class="file-list"></ul>
                </div>

                <div class="col-md-4">
                    <label class="form-label required"></label>
                    <input accept="application/pdf" type="file" id="work_completion_certificates_file3" name="work_completion_certificates_file3" class="form-control">
                    <ul id="work_completion_certificates_list3" class="file-list"></ul>
                </div> -->
                <div class="row">
                    <div class="col-12">
                        <label class="form-label fw-semibold">
                            Work Completion Certificate <span class="text-danger">(Add 3 Documents)</span>
                            <small class="text-muted">(PDF only, max 20 MB each)</small>
                        </label>
                    </div>

                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-light fw-semibold">File 1</span>
                            <input type="file" id="work_completion_certificates_file1"
                                name="work_completion_certificates_file1"
                                class="form-control" accept="application/pdf">
                        </div>
                        <div id="file-error1" class="text-danger small mt-1" style="display:none;"></div>
                    </div>

                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-light fw-semibold">File 2</span>
                            <input type="file" id="work_completion_certificates_file2"
                                name="work_completion_certificates_file2"
                                class="form-control" accept="application/pdf">
                        </div>
                        <div id="file-error2" class="text-danger small mt-1" style="display:none;"></div>
                    </div>

                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-light fw-semibold">File 3</span>
                            <input type="file" id="work_completion_certificates_file3"
                                name="work_completion_certificates_file3"
                                class="form-control" accept="application/pdf">
                        </div>
                        <div id="file-error3" class="text-danger small mt-1" style="display:none;"></div>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">PF Registration Documents<small class="text-muted">(PDF, max 20 MB)</small></label>
                    <input accept="application/pdf" type="file" id="pf_documents_file" name="pf_documents_file" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">ESIC Registration Documents<small class="text-muted">(PDF, max 20 MB)</small></label>
                    <input accept="application/pdf" type="file" id="esic_documents_file" name="esic_documents_file" class="form-control">
                </div>
            </div>
        </div>
        <hr>
        <!-- Portfolio & Work Samples -->
        <div class="form-section">
            <h5>Portfolio & Work Samples</h5>
            <div class="mb-3">
                <label class="form-label">Upload Portfolio / Company Profile(PDFs) * <small class="text-muted">(PDF, max 20 MB)</small></label>
                <input type="file" id="portfolio_file" name="portfolio_file" class="form-control" accept="application/pdf">
            </div>
            <div class="mb-3">
                <label class="form-label">License/Certification Upload (PWD,ZP,CIDCO,MJP,CERTIFICATE,ETC)<small class="text-muted">(PDF, max 20 MB)</small></label>
                <input type="file" id="license_certificate_file" name="license_certificate_file" class="form-control" accept="application/pdf">
            </div>
        </div>
        <div class="form-section">
            <h6 class="fw-bold mb-3">
            Client References 
            <span class="text-muted">(Add minimum 3)</span>
            </h6>
            <div id="reference-container">

                <div class="reference-row row g-3 mb-3">
                    <div class="col-md-3">
                        <input type="text" name="client_name[]" class="form-control" placeholder="Client Name *" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="organization[]" class="form-control" placeholder="Organization *" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="phone[]" class="form-control" placeholder="Phone *" required>
                    </div>
                    <div class="col-md-3">
                        <input type="email" name="email[]" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="year_of_completion[]" class="form-control" placeholder="Year of Completion *" min="1900" max="2099" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small">Upload Past Work Photos *</label>

                        <input type="file" name="past_work_photos[]" multiple onchange="if(this.files.length > 50){ alert('Max 50 files allowed!'); this.value=''; }">

                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger remove-row">Remove</button>
                    </div>
                </div>
            </div>
            <button type="button" id="add-reference" class="btn btn-sm btn-success mt-2">
                + Add Reference
            </button>
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
<!-- Step 5 Modal -->
<div class="modal fade" id="step5Modal" tabindex="-1" aria-labelledby="step5ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-3 shadow-lg">

            <div class="modal-body">

                <!-- Terms Summary -->
                <div class="p-3 mb-3 rounded" style="background-color:#e9f3fb;">
                    <h6 class="fw-bold">ConstructKaro Terms Summary</h6>
                    <ul class="mb-0 small">
                        <li>Platform acts as facilitator/mediator between vendors and customers</li>
                        <li>Non-circumvention: No direct bypass of ConstructKaro for 12 months from first introduction</li>
                        <li>Commission structure varies by vendor type (detailed in full agreement)</li>
                        <li>Quality standards and delivery timelines must be maintained</li>
                        <li>Dispute resolution through ConstructKaro mediation process</li>
                    </ul>
                </div>


                <div id="commission_box" class="p-3 mb-3 rounded" style="background-color:#fff3e0; display:none;">
                    <h6 class="fw-bold">Commission Structure (Indicative)</h6>
                    <div class="row small">
                        <div class="col-md-12">
                            <p id="commission_text" class="mb-1"></p>
                        </div>
                    </div>
                    <small class="text-muted">*Exact percentages will be specified in the vendor contract</small>
                </div>

                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="terms_policy" required>
                    <label class="form-check-label small" for="terms_policy">
                        I agree to the
                        <a href="{{route('vendor.agreement')}}" target="_blank" class="text-decoration-none fw-bold text-primary">
                  Vendor Terms & Conditions and Non-Circumvention Policy
               </a>. I understand that I cannot bypass ConstructKaro for direct dealings with introduced customers for 12 months.
                    </label>
                </div>


                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="privacy_policy">
                    <label class="form-check-label small" for="privacy_policy">
                        I agree to the
                        <a href="{{route('privacy.policy')}}" target="_blank" class="text-decoration-none fw-bold text-primary">
                 Privacy Policy and Data Processing terms
               </a>. I consent to ConstructKaro processing my business and project data for platform operations.
                    </label>
                </div>




            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
                <button type="button" id="completeBtn" class="btn btn-warning text-white fw-bold">
                    Complete Registration
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('#region').select2({
          placeholder: "-- Select region --",
          allowClear: true,
          width: '100%'   // ensures it fits Bootstrap form-control
        });
      });
</script>
<script>
    $('#entity_type').on('change', function () {
        const selectedOption = $(this).find("option:selected");
        const text = selectedOption.text();
        const value = selectedOption.val();
    
       
        if (text === "Proprietorship") {
               $("#certificate_label").text("PAN Of Proprietorship*");
           } else if (text === "Private Limited") {
               $("#certificate_label").text("Certificate Of Incopration*");
           } else  if (text === "Partnership") {
               $("#certificate_label").text("Partnership Deed*");
           } else if (text === "LLP") {  
               $("#certificate_label").text("LLP Agreement*");
           } else if (text === "Public Limited") {  
               $("#certificate_label").text("Certificate Of Incopration*");
           } else if (text === "OPC") {      
               $("#certificate_label").text("Certificate Of Incopration*");
           } else if (text === "HUF") {      
               $("#certificate_label").text("HUF PAN Card*");
           } else{
               $("#certificate_label").text("Relevant Document *");
           }
    
        // --- Show/hide sections ---
           if (value === '1') { 
            $('#aadhar_pan_link_section').hide();
            $('#aadhar_section').hide();
            $('#partnershipdeed').hide();
    
            $('#cin_section').show();
            $('#llpin').hide();
        } else if (value === '2') { // Proprietor / Partnership / LLP
            $('#aadhar_pan_link_section').hide();
            $('#aadhar_section').hide();
            $('#partnershipdeed').show();
    
            $('#cin_section').hide();
            $('#llpin').hide();
        } else if (value === '3') { // LLPIN
            $('#aadhar_pan_link_section').show();
            $('#aadhar_section').show();
            $('#partnershipdeed').hide();
    
            $('#cin_section').hide();
            $('#llpin').hide();
        } else if (value === '6') { // Private Limited / Public Ltd
            $('#aadhar_pan_link_section').hide();
            $('#cin_section').hide();
            $('#partnershipdeed').hide();
            $('#aadhar_section').hide();
            $('#llpin').show();
        } else if (value === '7') { // Private Limited / Public Ltd
            $('#aadhar_pan_link_section').hide();
            $('#cin_section').show();
            $('#partnershipdeed').hide();
    
            $('#aadhar_section').hide();
            $('#llpin').hide();
        } else if (value === '8') { // Private Limited / Public Ltd
            $('#aadhar_pan_link_section').hide();
            $('#cin_section').show();
            $('#partnershipdeed').hide();
    
            $('#aadhar_section').hide();
            $('#llpin').hide();
        } else if (value === '9') { // Private Limited / Public Ltd
            $('#aadhar_pan_link_section').hide();
            $('#cin_section').show();
            $('#partnershipdeed').hide();
    
            $('#aadhar_section').hide();
            $('#llpin').hide();
        } else { // Nothing selected
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
    
    
        $('#itr_file').on('change', function () {
               let fileList = $(this)[0].files;
               let output = "";
       
               if (fileList.length > 0) {
                   for (let i = 0; i < fileList.length; i++) {
                       output += "<li>" + fileList[i].name + "</li>";
                   }
               } else {
                   output = "<li>No file selected</li>";
               }
       
               $('#itr_file_list').html(output);
           });
    
        
      // Certificate of Incorporation (multiple)
      $('#certificate_of_incorporation_file').on('change', function () {
        let fileList = this.files;
        let output = '';
        if (fileList.length > 0) {
          for (let i = 0; i < fileList.length; i++) {
            output += `<li>📄 ${fileList[i].name}</li>`;
          }
        } else {
          output = '<li>No file selected</li>';
        }
        $('#file_list').html(output);
      });
    
      // Work Completion Certificates
      $('#work_completion_certificates_file1').on('change', function () {
        let f = this.files;
        $('#work_completion_certificates_list1').html(f.length ? `<li>📄 ${f[0].name}</li>` : '<li>No file selected</li>');
      });
    
      $('#work_completion_certificates_file2').on('change', function () {
        let f = this.files;
        $('#work_completion_certificates_list2').html(f.length ? `<li>📄 ${f[0].name}</li>` : '<li>No file selected</li>');
      });
    
      $('#work_completion_certificates_file3').on('change', function () {
        let f = this.files;
        $('#work_completion_certificates_list3').html(f.length ? `<li>📄 ${f[0].name}</li>` : '<li>No file selected</li>');
      });
</script>
<script>
    // $(document).ready(function() {
    //     $('#businessForm').on('submit', function(e) {
    //         e.preventDefault(); // Prevent default form submission
    
    //         // Validate declaration checkbox (optional)
    //         if (!$('#agreed_declaration').is(':checked')) {
    //             alert('Please agree to the declaration.');
    //             return;
    //         }
    
    //         var form = this;
    //         var formData = new FormData(form); // Collect all form data including files
    //         $('.past_work_photos').each(function(index, input) {
    //               if (input.files.length > 0) {
    //                   for (let i = 0; i < input.files.length; i++) {
    //                       formData.append('past_work_photos[]', input.files[i]);
    //                   }
    //               }
    //           });
    
    //         $.ajax({ 
    //             url: '{{ route("business.store") }}', // Replace with your actual route
    //             type: 'POST',
    //             data: formData,
    //             processData: false, // Important for file uploads
    //             contentType: false, // Important for file uploads
    //             beforeSend: function() {
    //                 // Optional: show a loader
    //                 $('button[type="submit"]').prop('disabled', true).text('Submitting...');
    //             },
    //             success: function(response) {
    //                 // Handle success response
    //                 alert(response.message || 'Form submitted successfully!');
    //                 // form.reset(); // Reset form
    //                   $('#step5Modal').modal('show');
    //                 //  window.location.href = '{{ route("vendor_confiermetion") }}';
    //                 $('#certificate_label').text('Certificate of Incorpration/ LLPIN/ SHOP ACT (FOR Proprietor) *'); // Reset label
    //             },
    //             error: function(xhr) {
    //                 // Handle error response
    //                 if(xhr.responseJSON && xhr.responseJSON.errors){
    //                     var errors = xhr.responseJSON.errors;
    //                     var errorMessage = '';
    //                     $.each(errors, function(key, value) {
    //                         errorMessage += value + "\n";
    //                     });
    //                     alert(errorMessage);
    //                 } else {
    //                     alert('Something went wrong. Please try again.');
    //                 }
    //             },
    //             complete: function() {
    //                 $('button[type="submit"]').prop('disabled', false).text('Submit for Verification');
    //             }
    //         });
    //     });
    // });

$(document).ready(function() {

    $('#businessForm').on('submit', function(e) {
        e.preventDefault();

        // 🔹 Step 1: Declaration checkbox validation
        if (!$('#agreed_declaration').is(':checked')) {
            showAlert('Please agree to the declaration before submitting.', 'warning');
            return;
        }

        // 🔹 Step 2: Check total file size before sending
        let totalSize = 0;
        $('input[type="file"]').each(function() {
            $.each(this.files, function(_, file) {
                totalSize += file.size;
            });
        });

        const MAX_SIZE = 200 * 1024 * 1024; // 200 MB limit
        if (totalSize > MAX_SIZE) {
            showAlert('Total upload size exceeds 200MB. Please reduce file size.', 'danger');
            return;
        }

        // 🔹 Step 3: Prepare FormData
        var form = this;
        var formData = new FormData(form);
        $('.past_work_photos').each(function(index, input) {
            if (input.files.length > 0) {
                for (let i = 0; i < input.files.length; i++) {
                    formData.append('past_work_photos[]', input.files[i]);
                }
            }
        });

        // 🔹 Step 4: AJAX submit
        $.ajax({
            url: '{{ route("business.store") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('button[type="submit"]').prop('disabled', true).text('Submitting...');
                showAlert('Uploading... Please wait.', 'info');
            },
            success: function(response) {
                if (response.status) {
                    showAlert(response.message || 'Form submitted successfully!', 'success');
                    // $('#businessForm')[0].reset();
                    $('#step5Modal').modal('show');
                } else {
                    showAlert(response.message || 'Something went wrong. Please try again.', 'danger');
                }
            },
            error: function(xhr) {
                let message = 'Something went wrong. Please try again.';

                // 🔹 Laravel 413: PostTooLargeException
                if (xhr.status === 413) {
                    message = 'Uploaded files are too large. Please upload smaller files.';
                }

                // 🔹 Laravel 422: Validation errors
                else if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    message = '<strong>Validation failed:</strong><br>';
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        message += `• ${value}<br>`;
                    });
                }

                // 🔹 Laravel 500 or other server errors
                else if (xhr.status === 500) {
                    message = 'Server error. Please try again later.';
                }

                showAlert(message, 'danger');
            },
            complete: function() {
                $('button[type="submit"]').prop('disabled', false).text('Submit for Verification');
            }
        });
    });

    // 🔹 Step 5: Helper — Show Bootstrap Alert dynamically
    function showAlert(message, type = 'info') {
        $('.ajax-alert').remove(); // remove old alerts if any
        const alertHtml = `
            <div class="alert alert-${type} ajax-alert alert-dismissible fade show mt-3" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`;
        $('#businessForm').prepend(alertHtml);
        $('html, body').animate({ scrollTop: $("#businessForm").offset().top - 100 }, 400);
    }

});


    
      document.getElementById('completeBtn').addEventListener('click', function () {
          let terms = document.getElementById('terms_policy').checked;
          let privacy = document.getElementById('privacy_policy').checked;
    
          if (!terms || !privacy) {
              alert("Please agree to the Terms & Conditions and Privacy Policy before proceeding.");
              return;
          }
    
          // If both checkboxes are ticked, redirect
          window.location.href = "{{ route('vendor_confiermetion') }}";
      });
</script>
<script>
    const inputEl = document.getElementById("min_project_value");
       const outEl = document.getElementById("valueInWords");
       
       inputEl.addEventListener("input", function () {
         const num = Number(this.value);
         if (!num || isNaN(num) || num < 0) {
           outEl.innerHTML = "";
           return;
         }
       
         const words = numberToIndianWords(num);
       
         outEl.innerHTML = `
           <strong>In words:</strong> ${words}
          
           
         `;
       });
       
       // ---- Number → Words (Indian system up to Shankh) ----
       function numberToIndianWords(num) {
         if (num === 0) return "Zero";
       
         const ONES = ["","one","two","three","four","five","six","seven","eight","nine","ten",
           "eleven","twelve","thirteen","fourteen","fifteen","sixteen","seventeen","eighteen","nineteen"];
         const TENS = ["","","twenty","thirty","forty","fifty","sixty","seventy","eighty","ninety"];
       
         // Largest to smallest Indian units
         const UNITS = [
           { value: 1e17, name: "shankh" },
           { value: 1e15, name: "padma" },
           { value: 1e13, name: "neel" },
           { value: 1e11, name: "kharab" },
           { value: 1e9,  name: "arab" },
           { value: 1e7,  name: "crore" },
           { value: 1e5,  name: "lakh" },
           { value: 1e3,  name: "thousand" }
           // hundreds handled below 1000
         ];
       
         function belowThousand(n) {
           let str = "";
           if (n >= 100) {
             str += ONES[Math.floor(n/100)] + " hundred";
             n = n % 100;
             if (n) str += " ";
           }
           if (n >= 20) {
             str += TENS[Math.floor(n/10)];
             if (n % 10) str += " " + ONES[n % 10];
           } else if (n > 0) {
             str += ONES[n];
           }
           return str;
         }
       
         function convert(n) {
           let parts = [];
           for (const u of UNITS) {
             if (n >= u.value) {
               const q = Math.floor(n / u.value);
               parts.push(convert(q) + " " + u.name);
               n = n % u.value;
             }
           }
           if (n > 0) {
             parts.push(belowThousand(n));
           }
           return parts.join(" ");
         }
       
         const out = convert(num).trim();
         return out.charAt(0).toUpperCase() + out.slice(1);
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
    
      // ✅ Validation pattern: 4 letters + 5 digits + 1 letter
      function isValidTAN(tan) {
        const tanRegex = /^[A-Z]{4}[0-9]{5}[A-Z]{1}$/;
        return tanRegex.test(tan);
      }
    
      // ✅ Auto-uppercase and validate on blur
      tanInput.addEventListener('blur', () => {
        const tanValue = tanInput.value.trim().toUpperCase();
        tanInput.value = tanValue; // force uppercase
    
        if (!isValidTAN(tanValue)) {
          tanError.style.display = 'block';
          tanInput.classList.add('is-invalid');
        } else {
          tanError.style.display = 'none';
          tanInput.classList.remove('is-invalid');
        }
      });
    
      // ✅ Optional: restrict input to only A–Z and 0–9
      tanInput.addEventListener('input', () => {
        tanInput.value = tanInput.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
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
    
          // Region → City (multiple)
          $('#region').on('change', function() {
             let region_ids = $(this).val(); // array of selected region IDs
             $('#city').empty().append('<option value="">-- Select City --</option>');
    
             if (region_ids && region_ids.length > 0) {
                $.ajax({
                      url: '/get-cities-by-regions',
                      type: 'POST',
                      data: {
                         region_ids: region_ids,
                         _token: '{{ csrf_token() }}'
                      },
                      success: function(data) {
                         $.each(data, function(key, value) {
                            $('#city').append('<option value="'+ key +'">'+ value +'</option>');
                         });
                      }
                });
             }
          });
</script>

<script>
    $(document).ready(function () {
         // Minimum required references
         const MIN_REFERENCES = 3;
       
         // Add new row
         $("#add-reference").click(function () {
           let newRow = $(".reference-row:first").clone();
           newRow.find("input").val(""); // clear values
           $("#reference-container").append(newRow);
         });
       
         // Remove row
         $(document).on("click", ".remove-row", function () {
           if ($(".reference-row").length > MIN_REFERENCES) {
             $(this).closest(".reference-row").remove();
           } else {
             alert("At least " + MIN_REFERENCES + " references are required.");
           }
         });
       });
</script>
<script>
    $(document).ready(function() {
        $('#experience_years').change(function() {
            let selected = $(this).val();
            if(selected == "1") {
                // 0-2 Years: hide ITR section and remove 'required'
                $('#itr_section').hide();
                $('.itr_file').prop('required', false);
            } else if(selected != "") {
                // Other options: show ITR section and make files mandatory
                $('#itr_section').show();
                $('.itr_file').prop('required', true);
            } else {
                $('#itr_section').hide();
                $('.itr_file').prop('required', false);
            }
        });
    });
</script>

<script>
    // Define commissions
      const commissions = {
        "Architects": "6–10%",
        "Consultants": "6–10%",
        "Contractors": "7–8%",
        "Interiors": "12–15%",
        "Surveying": "6–8%",
        "Fabrication": "8–10%",
        "Utilities/Specialized": "8–10%"
      };
    
      // On dropdown change
      $('#entity_type').on('change', function () {
        let selected = $(this).val();
       //  alert(selected);
        if (commissions[selected]) {
          $('#commission_text').html(`<strong>${selected}:</strong> ${commissions[selected]}`);
          $('#commission_box').show();
        } else {
          $('#commission_box').hide();
        }
      });
</script>
@endsection