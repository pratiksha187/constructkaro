@extends('layouts.engineer.app')

@section('title', 'Vendor List')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
  :root{
    --ck-orange:#FF6600;
    --ck-navy:#0B2240;
    --ck-blue:#2949E9;
    --ck-bg:#F5F7FB;
    --ck-muted:#6B7A90;
    --ck-card:#ffffff;
    --ck-border:#e9eef7;
  }

  /* utilities */
  [x-cloak]{ display:none !important; }
  .animate-fade-in{ animation:fadeIn .25s ease-out; }
  @keyframes fadeIn{ from{opacity:0; transform:scale(.98)} to{opacity:1; transform:scale(1)} }

  /* page wrapper */
  .ck-wrap{ max-width: 1280px; margin: 0 auto; padding: 2rem 1.25rem; }

  /* card */
  .ck-card{ background:var(--ck-card); border:1px solid var(--ck-border); border-radius:16px; box-shadow:0 10px 28px rgba(12,33,72,.06); overflow:hidden; }
  .ck-card-header{
    padding: 1rem 1.25rem;
    background: linear-gradient(180deg, rgba(255,102,0,.06), rgba(41,73,233,.06));
    border-bottom: 1px solid var(--ck-border);
    display:flex; align-items:center; justify-content:space-between; gap:.75rem;
  }
  .ck-title{ margin:0; font-weight:700; color:var(--ck-navy); }

  /* table */
  .ck-table{ width:100%; }
  .ck-table thead th{
    font-weight:700; color:var(--ck-navy); background:#f8fafc;
    border-bottom:1px solid var(--ck-border); font-size:.95rem;
  }
  .ck-table td, .ck-table th{ padding:.85rem .9rem; vertical-align:middle; }
  .ck-table tbody tr{ transition:background .15s ease; }
  .ck-table tbody tr:hover{ background:#f7faff; }

  /* pills & buttons */
  .btn-primary{
    --bs-btn-bg:var(--ck-orange); --bs-btn-border-color:var(--ck-orange);
    --bs-btn-hover-bg:#e65c00; --bs-btn-hover-border-color:#e65c00;
  }
  .btn-outline-primary{
    --bs-btn-color:var(--ck-orange); --bs-btn-border-color:var(--ck-orange);
    --bs-btn-hover-bg:var(--ck-orange); --bs-btn-hover-border-color:var(--ck-orange);
    --bs-btn-hover-color:#fff;
  }
  .btn-soft{
    color:var(--ck-blue); background:rgba(41,73,233,.12); border:1px solid rgba(41,73,233,.18);
  }
  .btn-soft:hover{ background:rgba(41,73,233,.18); }

  /* “View details” icon button */
  .icon-btn{
    display:inline-flex; align-items:center; justify-content:center;
    width:36px; height:36px; border-radius:10px; border:1px solid var(--ck-border);
    color:var(--ck-blue); background:#fff; transition:.15s ease;
  }
  .icon-btn:hover{ background:rgba(41,73,233,.08); }

  /* alpine modal styling (kept your structure) */
  .ck-backdrop{ position:fixed; inset:0; background:rgba(0,0,0,.6); display:flex; align-items:center; justify-content:center; z-index:1050; padding:1rem; }
  .ck-modal{ background:#fff; border-radius:16px; box-shadow:0 20px 40px rgba(0,0,0,.18); border:1px solid var(--ck-border); }
  .ck-modal .section-title{ font-weight:700; color:var(--ck-navy); border-bottom:1px solid var(--ck-border); padding-bottom:.5rem; margin-bottom:.75rem; }
  .ck-meta p{ margin:0; }
  .ck-meta p:first-child{ color:var(--ck-muted); font-weight:600; margin-bottom:.1rem; }
  .ck-close{ position:absolute; right:14px; top:14px; color:#8a94a7; }
  .ck-close:hover{ color:#000; }

  .pagination{ margin: 1rem 0 0; }

  /* ----- nicer modals ----- */
  .ck-backdrop{
    position:fixed; inset:0; display:flex; align-items:center; justify-content:center;
    padding:1rem; z-index:1050;
    background: radial-gradient(1000px 600px at 10% 0, rgba(41,73,233,.25), transparent 60%),
                radial-gradient(1000px 600px at 90% 100%, rgba(255,102,0,.22), transparent 60%),
                rgba(11,34,64,.60);
    backdrop-filter: blur(6px);
  }
  .ck-modal{
    width:100%; max-width:960px; background:#fff; border-radius:18px; overflow:hidden;
    border:1px solid var(--ck-border); box-shadow:0 28px 60px rgba(12,33,72,.28);
    transform: translateY(4px); animation: pop .18s ease-out forwards;
  }
  @keyframes pop{ to { transform: translateY(0);} }

  .ck-mhdr{
    display:flex; align-items:center; justify-content:space-between; gap:.75rem;
    padding:14px 18px;
    background:linear-gradient(90deg, rgba(255,102,0,.08), rgba(41,73,233,.08));
    border-bottom:1px solid var(--ck-border); position:sticky; top:0; z-index:2;
  }
  .ck-mtitle{ display:flex; align-items:center; gap:.6rem; font-weight:700; color:var(--ck-navy); }
  .ck-mtitle .material-icons{ color: var(--ck-orange); }

  .ck-mbody{ padding:22px; max-height: calc(90vh - 130px); overflow:auto; }
  .ck-mfooter{
    padding:12px 18px; display:flex; gap:.5rem; justify-content:flex-end;
    background:#fafcff; border-top:1px solid var(--ck-border); position:sticky; bottom:0; z-index:2;
  }

  .ck-close{ border-radius:10px; border:1px solid var(--ck-border); background:#fff; padding:.35rem .55rem; }
  .ck-close .material-icons{ font-size:20px; color:#8a94a7; }
  .ck-close:hover .material-icons{ color:#000; }

  /* small visual helpers inside modal */
  .ck-section-title{ font-weight:700; color:var(--ck-navy); margin-bottom:.75rem; }
  .ck-meta p{ margin:0; }
  .ck-meta p:first-child{ color:var(--ck-muted); font-weight:600; margin-bottom:.15rem; font-size:.92rem; }
  .ck-chip{ display:inline-block; font-size:.75rem; font-weight:600; padding:.25rem .6rem;
            color:var(--ck-navy); background:rgba(11,34,64,.06); border-radius:999px; }
  .ck-file a{ text-decoration:none; }
  .ck-file a:hover{ text-decoration:underline; }

  /* keep your existing button palette */
  .btn-primary{ --bs-btn-bg:var(--ck-orange); --bs-btn-border-color:var(--ck-orange);
                --bs-btn-hover-bg:#e65c00; --bs-btn-hover-border-color:#e65c00;}
  .btn-soft{ color:var(--ck-blue); background:rgba(41,73,233,.12); border:1px solid rgba(41,73,233,.18); }
  .btn-soft:hover{ background:rgba(41,73,233,.18); }


</style>

<div class="ck-wrap" x-data="{ activeProject: null, showCallModal: false }">
  <div class="ck-card animate-fade-in">
    <div class="ck-card-header">
      <h2 class="ck-title">Vendor List</h2>
     
    </div>

    {{-- flash --}}
    @if(session('success'))
      <div class="alert alert-success m-3 mb-0">{{ session('success') }}</div>
    @endif

    <div class="table-responsive p-3 pt-2">
      <table class="table table-hover align-middle ck-table">
        <thead class="table-light">
          <tr>
            <th>Id</th>
            <th>Vender Name</th>
            <th>Mobile</th>
            <th>Email</th>

            <th>Company Name</th>
            <th>view</th>
          
          </tr>
        </thead>
       <tbody>
  @forelse($allvendor as $index => $vendor)
    <tr>
      <td>{{ $allvendor->firstItem() + $index }}</td>
      <td class="fw-semibold">{{ $vendor->name }}</td>
      <td class="text-muted">{{ $vendor->mobile }}</td>
      <td class="text-muted">{{ $vendor->email }}</td>
      <td class="text-muted">{{ $vendor->business_name }}</td>
      
      <td>
        <button class="btn btn-outline-primary btn-sm" 
                data-bs-toggle="modal" 
                data-bs-target="#viewVendorModal{{ $vendor->id }}">
          <i class="bi bi-eye"></i> View
        </button>
      </td>
    </tr>

    {{-- View Modal --}}
    <div class="modal fade" id="viewVendorModal{{ $vendor->id }}" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-4">
          <div class="modal-header bg-light">
            <h5 class="modal-title fw-semibold text-dark">
              <i class="bi bi-person-badge text-primary me-1"></i> Vendor Details For {{$vendor->vendor_code}}
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          
          <div class="modal-body p-4">
          
<h6 class="fw-bold border-bottom pb-2 mt-3">Basic Info</h6>
<div class="row mb-3">
  <div class="col-md-4">
    <p class="fw-semibold text-muted mb-1">Vendor Name</p>
    <p class="fw-bold">{{ $vendor->name ?? 'No added data' }}</p>
  </div>
  <div class="col-md-4">
    <p class="fw-semibold text-muted mb-1">Email</p>
    <p class="fw-bold">{{ $vendor->email ?? 'No added data' }}</p>
  </div>
  <div class="col-md-4">
    <p class="fw-semibold text-muted mb-1">Phone</p>
    <p class="fw-bold">{{ $vendor->mobile ?? 'No added data' }}</p>
  </div>
  <div class="col-md-4">
    <p class="fw-semibold text-muted mb-1">Business Name</p>
    <p class="fw-bold">{{ $vendor->business_name ?? 'No added data' }}</p>
  </div>
  <div class="col-md-4">
    <p class="fw-semibold text-muted mb-1">GST Number</p>
    <p class="fw-bold">{{ $vendor->gst_number ?? 'No added data' }}</p>
  </div>
</div>

{{-- Company Info --}}
<h6 class="fw-bold border-bottom pb-2 mt-3">Company Information</h6>
<div class="row mt-2">
  <div class="col-md-6">
    <p class="fw-semibold text-muted mb-1">Company Name</p>
    <p>{{ $vendor->company_name ?? 'No added data' }}</p>
  </div>
  <div class="col-md-6">
    <p class="fw-semibold text-muted mb-1">Type of Entity</p>
    <p>{{ $vendor->entity_type ?? 'No added data' }}</p>
  </div>
  <div class="col-md-12">
    <p class="fw-semibold text-muted mb-1">Registered Address</p>
    <p>{{ $vendor->registered_address ?? 'No added data' }}</p>
  </div>
</div>

{{-- Registration & Bank --}}
<h6 class="fw-bold border-bottom pb-2 mt-4">Registration & Bank Details</h6>
<div class="row mt-2">
  <div class="col-md-4">
    <p class="fw-semibold text-muted mb-1">PAN Number</p>
    <p>{{ $vendor->pan_number ?? 'No added data' }}</p>
  </div>
  <div class="col-md-4">
    <p class="fw-semibold text-muted mb-1">Bank Name</p>
    <p>{{ $vendor->bank_name ?? 'No added data' }}</p>
  </div>
  <div class="col-md-4">
    <p class="fw-semibold text-muted mb-1">Account Number</p>
    <p>{{ $vendor->account_number ?? 'No added data' }}</p>
  </div>
  <div class="col-md-4">
    <p class="fw-semibold text-muted mb-1">IFSC Code</p>
    <p>{{ $vendor->ifsc_code ?? 'No added data' }}</p>
  </div>
  <div class="col-md-4">
    <p class="fw-semibold text-muted mb-1">Account Type</p>
    <p>{{ $vendor->account_type ?? 'No added data' }}</p>
  </div>
</div>

{{-- Agency Service Details --}}
<h6 class="fw-bold border-bottom pb-2 mt-4">Agency Service Details</h6>
<div class="row mt-2">
  <div class="col-md-4">
    <p class="fw-semibold text-muted mb-1">Experience Years</p>
    <p>{{ $vendor->experience_years ?? 'No added data' }}</p>
  </div>
  <div class="col-md-4">
    <p class="fw-semibold text-muted mb-1">Team Size</p>
    <p>{{ $vendor->team_size ?? 'No added data' }}</p>
  </div>
  <div class="col-md-4">
    <p class="fw-semibold text-muted mb-1">Minimum Project Value</p>
    <p>{{ $vendor->min_project_value ?? 'No added data' }}</p>
  </div>
  <div class="col-md-12">
    <p class="fw-semibold text-muted mb-1">Service Coverage Area</p>
    <p>{{ $vendor->service_coverage_area ?? 'No added data' }}</p>
  </div>
</div>



          </div>

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

{{-- libs (keeping your stack; if Alpine isn’t in the layout, add it there) --}}
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

<script>
  // unchanged logic – using your original functions
  function submitRemarks(projectId, engg_decription) {
    if (!engg_decription.trim()) { alert("Please enter some remarks."); return; }
    $.ajax({
      url: '/engineer/project/update-remarks',
      type: 'POST',
      data: { _token: '{{ csrf_token() }}', id: projectId, engg_decription: engg_decription },
      success: function () { alert('Remarks updated successfully!'); location.reload(); },
      error: function () { alert('Error occurred while updating remarks.'); }
    });
  }

  function submitCallResponse(projectId, callStatus, callRemarks) {
    if (!callStatus) { alert("Please select a call status."); return; }
    $.ajax({
      url: '/engineer/project/update-call-response',
      type: 'POST',
      data: { _token: '{{ csrf_token() }}', id: projectId, call_status: callStatus, call_remarks: callRemarks },
      success: function () { alert('Call response updated successfully!'); location.reload(); },
      error: function () { alert('Error occurred while updating call response.'); }
    });
  }
</script>
@endsection
