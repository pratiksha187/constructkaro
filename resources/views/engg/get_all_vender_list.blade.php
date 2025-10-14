@extends('layouts.engineer.app')

@section('title', 'Vendor List')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
  :root {
    --ck-orange: #FF6600;
    --ck-navy: #0B2240;
    --ck-blue: #2949E9;
    --ck-border: #e9eef7;
  }
  .btn-primary {
    --bs-btn-bg: var(--ck-orange);
    --bs-btn-border-color: var(--ck-orange);
    --bs-btn-hover-bg: #e65c00;
    --bs-btn-hover-border-color: #e65c00;
  }
</style>

<div class="ck-wrap" x-data="{ activeVendor: null }">
  <div class="ck-card animate-fade-in">
    <div class="ck-card-header">
      <h2 class="ck-title">Vendor List</h2>
    </div>

    @if(session('success'))
      <div class="alert alert-success m-3 mb-0">{{ session('success') }}</div>
    @endif

    <div class="table-responsive p-3 pt-2">
      <table class="table table-hover align-middle ck-table">
        <thead class="table-light">
          <tr>
            <th>ID</th>
            <th>Vendor Name</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Company Name</th>
            <th>View</th>
          </tr>
        </thead>
        <tbody>
          @forelse($allvendor as $index => $vendor)
            <tr>
              <td>{{ $allvendor->firstItem() + $index }}</td>
              <td class="fw-semibold">{{ $vendor->vendor_name }}</td>
              <td>{{ $vendor->vendor_mobile }}</td>
              <td>{{ $vendor->vendor_email }}</td>
              <td>{{ $vendor->vendor_business_name }}</td>
              <td>
                <button class="btn btn-outline-primary btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#viewVendorModal{{ $vendor->vendor_id }}">
                  <i class="bi bi-eye"></i> View
                </button>
              </td>
            </tr>

            {{-- View Modal --}}
            <div class="modal fade" id="viewVendorModal{{ $vendor->vendor_id }}" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content border-0 shadow-lg rounded-4">
                  <div class="modal-header bg-light">
                    <h5 class="modal-title fw-semibold text-dark">
                      <i class="bi bi-person-badge text-primary me-1"></i> Vendor Details - {{ $vendor->vendor_code }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>

                  <div class="modal-body p-4">

                    {{-- Basic Info --}}
                    <h6 class="fw-bold border-bottom pb-2 mt-3">Basic Info</h6>
                    <div class="row mb-3">
                      <div class="col-md-4">
                        <p class="fw-semibold text-muted mb-1">Vendor Name</p>
                        <p class="fw-bold">{{ $vendor->vendor_name ?? 'No data' }}</p>
                      </div>
                      <div class="col-md-4">
                        <p class="fw-semibold text-muted mb-1">Email</p>
                        <p class="fw-bold">{{ $vendor->vendor_email ?? 'No data' }}</p>
                      </div>
                      <div class="col-md-4">
                        <p class="fw-semibold text-muted mb-1">Phone</p>
                        <p class="fw-bold">{{ $vendor->vendor_mobile ?? 'No data' }}</p>
                      </div>
                    </div>

                    {{-- Company Info --}}
                    <h6 class="fw-bold border-bottom pb-2 mt-3">Company Information</h6>
                    <div class="row">
                      <div class="col-md-6">
                        <p class="fw-semibold text-muted mb-1">Company Name</p>
                        <p>{{ $vendor->br_company_name ?? 'No data' }}</p>
                      </div>
                      <div class="col-md-6">
                        <p class="fw-semibold text-muted mb-1">Entity Type</p>
                        <p>{{ $vendor->br_entity_type ?? 'No data' }}</p>
                      </div>
                    </div>

                    {{-- Bank Info --}}
                    <h6 class="fw-bold border-bottom pb-2 mt-4">Bank Details</h6>
                    <div class="row">
                      <div class="col-md-4">
                        <p class="fw-semibold text-muted mb-1">Bank Name</p>
                        <p>{{ $vendor->br_bank_name ?? 'No data' }}</p>
                      </div>
                      <div class="col-md-4">
                        <p class="fw-semibold text-muted mb-1">Account Number</p>
                        <p>{{ $vendor->br_account_number ?? 'No data' }}</p>
                      </div>
                      <div class="col-md-4">
                        <p class="fw-semibold text-muted mb-1">IFSC Code</p>
                        <p>{{ $vendor->br_ifsc_code ?? 'No data' }}</p>
                      </div>
                    </div>

                    {{-- ✅ NEW SECTION: Call Status + Remarks --}}
                    <h6 class="fw-bold border-bottom pb-2 mt-4">Call Status & Remarks</h6>
                  {{-- ✅ NEW SECTION: Call Status + Remarks --}}
{{-- ✅ NEW SECTION: Call Status + Remarks --}}
<h6 class="fw-bold border-bottom pb-2 mt-4">Call Status & Remarks</h6>
<form id="callForm{{ $vendor->vendor_id }}">
  <div class="row mt-2">
    <div class="col-md-4">
      <label for="call_status{{ $vendor->vendor_id }}" class="fw-semibold text-muted mb-1">Call Status</label>
      <select id="call_status{{ $vendor->vendor_id }}" name="call_status" class="form-select">
        <option value="">-- Select Status --</option>
        <option value="Connected" {{ $vendor->call_status == 'Connected' ? 'selected' : '' }}>Connected</option>
        <option value="Not Connected" {{ $vendor->call_status == 'Not Connected' ? 'selected' : '' }}>Not Connected</option>
        <option value="Follow-up" {{ $vendor->call_status == 'Follow-up' ? 'selected' : '' }}>Follow-up</option>
        <option value="Interested" {{ $vendor->call_status == 'Interested' ? 'selected' : '' }}>Interested</option>
        <option value="Not Interested" {{ $vendor->call_status == 'Not Interested' ? 'selected' : '' }}>Not Interested</option>
      </select>
    </div>

    <div class="col-md-8">
      <label for="call_remarks{{ $vendor->vendor_id }}" class="fw-semibold text-muted mb-1">Remarks</label>
      <textarea id="call_remarks{{ $vendor->vendor_id }}" 
                name="call_remarks" 
                rows="2" 
                class="form-control" 
                placeholder="Enter remarks...">{{ $vendor->call_remarks ?? '' }}</textarea>
    </div>
  </div>

  <div class="text-end mt-3">
    <button type="button"
            class="btn btn-primary btn-sm"
            onclick="submitVendorCall({{ $vendor->vendor_id }})">
      <i class="bi bi-telephone-forward me-1"></i> Save Call Response
    </button>
  </div>
</form>



                  </div> {{-- modal-body --}}

                  <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
          @empty
            <tr>
              <td colspan="6" class="text-center text-muted py-4">No Vendor found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="px-3 pb-3">
      {{ $allvendor->links() }}
    </div>
  </div>
</div>

{{-- Scripts --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
function submitVendorCall(vendorId) {
  let callStatus = $('#call_status' + vendorId).val();
  let callRemarks = $('#call_remarks' + vendorId).val();

  if (!callStatus) {
    alert("Please select a call status.");
    return;
  }

  $.ajax({
    url: "{{ route('engineer.vendor.updateCallStatus') }}",
    type: "POST",
    data: {
      _token: "{{ csrf_token() }}",
      vendor_id: vendorId,
      call_status: callStatus,
      call_remarks: callRemarks
    },
    success: function (response) {
      alert("Call status updated successfully!");
      $('#viewVendorModal' + vendorId).modal('hide');
    },
    error: function () {
      alert("Error updating call status.");
    }
  });
}

</script>
@endsection
