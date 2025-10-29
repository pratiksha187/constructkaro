@extends('layouts.vender.app')
@section('title', 'Vendor Dashboard | ConstructKaro')
@section('content')

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ConstructKaro - Vendor Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
  .card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    background-color: #fff;
    padding: 24px;
    margin-bottom: 24px;
  }

  .section-title {
    font-weight: 600;
    font-size: 1.1rem;
    color: #1c2c3e;
    margin-bottom: 20px;
  }

  .form-label {
    font-weight: 500;
    color: #1c2c3e;
  }

  .form-control, .form-select {
    border-radius: 8px;
    padding: 10px 12px;
  }

  textarea.form-control {
    resize: none;
    height: 90px;
  }

  .verified-badge {
    display: inline-flex;
    align-items: center;
    background-color: #e8f9ee;
    color: #16a34a;
    font-weight: 500;
    border-radius: 8px;
    padding: 6px 12px;
  }

  .verified-badge i {
    margin-right: 6px;
  }

  .btn-primary {
    background-color: #1c64f2;
    border: none;
    border-radius: 8px;
    padding: 10px 20px;
    font-weight: 500;
  }

  .btn-secondary {
    background-color: #f3f4f6;
    color: #111827;
    border-radius: 8px;
    padding: 10px 20px;
    font-weight: 500;
  }

  .btn-primary:hover {
    background-color: #1a56db;
  }

  .btn-secondary:hover {
    background-color: #e5e7eb;
  }

  .action-buttons {
    display: flex;
    gap: 12px;
    justify-content: flex-end;
  }

  .file-link a {
    color: #1c64f2;
    text-decoration: none;
  }
</style>

<div class="container my-5">

  <!-- Company Details -->
  <div class="card">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5 class="section-title">Company Details</h5>
    </div>

    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Company Name</label>
        <input type="text" class="form-control" value="{{ $vendor->business_name ?? '' }}" readonly>
      </div>

      <div class="col-md-6">
        <label class="form-label">Contact Number</label>
        <input type="text" class="form-control" value="{{ $vendor->mobile ?? '' }}" readonly>
      </div>

      <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="text" class="form-control" value="{{ trim($vendor->email, '[]\"') }}" readonly>
      </div>

      <div class="col-md-6">
        <label class="form-label">GST Number</label>
        <input type="text" class="form-control" value="{{ $vendor->gst_number ?? '' }}" readonly>
      </div>

      <div class="col-md-6">
        <label class="form-label">Entity Type</label>
        <input type="text" class="form-control" value="{{ $vendor->entity_type ?? '' }}" readonly>
      </div>

      <div class="col-12">
        <label class="form-label">Registered Address</label>
        <textarea class="form-control" readonly>{{ $vendor->registered_address ?? '' }}</textarea>
      </div>
    </div>
  </div>

  <!-- Banking & Tax Info -->
  <div class="card">
    <h5 class="section-title">Banking & Tax Details</h5>
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">PAN Number</label>
        <input type="text" class="form-control" value="{{ $vendor->pan_number ?? '' }}" readonly>
      </div>
      <div class="col-md-6">
        <label class="form-label">TAN Number</label>
        <input type="text" class="form-control" value="{{ $vendor->tan_number ?? '' }}" readonly>
      </div>
      <div class="col-md-4">
        <label class="form-label">Bank Name</label>
        <input type="text" class="form-control" value="{{ $vendor->bank_name ?? '' }}" readonly>
      </div>
      <div class="col-md-4">
        <label class="form-label">Account Number</label>
        <input type="text" class="form-control" value="{{ $vendor->account_number ?? '' }}" readonly>
      </div>
      <div class="col-md-4">
        <label class="form-label">IFSC Code</label>
        <input type="text" class="form-control" value="{{ $vendor->ifsc_code ?? '' }}" readonly>
      </div>
    </div>
  </div>

  <!-- Documents Section -->
  <div class="card">
    <h5 class="section-title">Uploaded Documents</h5>
    <div class="row g-3 file-link">
      @foreach([
        'cancelled_cheque_file' => 'Cancelled Cheque',
        'pan_card_file' => 'PAN Card',
        'aadhaar_card_file' => 'Aadhaar Card',
        'certificate_of_incorporation_file' => 'Certificate of Incorporation',
        'pf_documents_file' => 'PF Document',
        'esic_documents_file' => 'ESIC Document',
        'portfolio_file' => 'Portfolio',
        'license_certificate_file' => 'License Certificate',
        'work_completion_certificates_file1' => 'Work Completion Certificate 1',
        'work_completion_certificates_file2' => 'Work Completion Certificate 2',
        'work_completion_certificates_file3' => 'Work Completion Certificate 3'
      ] as $field => $label)
        @if(!empty($vendor->$field))
        <div class="col-md-6">
          <label class="form-label">{{ $label }}</label>
          <p><a href="{{ asset($vendor->$field) }}" target="_blank"><i class="bi bi-file-earmark-pdf"></i> View Document</a></p>
        </div>
        @endif
      @endforeach
    </div>
  </div>

  <!-- Verification Status -->
  <div class="card">
    <h5 class="section-title mb-3">Verification Status</h5>
    @if($vendor->approved)
      <span class="verified-badge">
        <i class="bi bi-check-circle-fill"></i> Verified Vendor
      </span>
    @else
      <span class="verified-badge" style="background:#fcebea;color:#b91c1c;">
        <i class="bi bi-exclamation-circle-fill"></i> Pending Verification
      </span>
    @endif
  </div>

  <!-- Save / Cancel Buttons -->
  <div class="action-buttons mt-4">
    <button class="btn btn-primary">Save Changes</button>
    <button class="btn btn-secondary">Cancel</button>
  </div>
</div>

@endsection
