@extends('layouts.vender.app')
@section('title', 'Vendor Dashboard | ConstructKaro')
@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
  .card { border-radius: 12px; border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
  .table th { color: #475569; font-weight: 600; background: #f9fafb; }
  .badge-status { font-size: 0.85rem; padding: 6px 12px; border-radius: 50px; }
  .badge-open { background-color: #d1fae5; color: #047857; }
  .badge-submitted { background-color: #fef3c7; color: #92400e; }
  .badge-won { background-color: #e0e7ff; color: #3730a3; }
  .modal-content { border-radius: 16px; border: none; box-shadow: 0 8px 30px rgba(0,0,0,0.15); }
  .modal-header { border-bottom: none; background-color: #f8fafc; }
  .modal-body h6 { font-weight: 600; color: #1e293b; }
  .modal-body p { color: #475569; }
  .form-control, .btn { border-radius: 8px; }
  .btn-primary { background-color: #2563eb; border: none; }
  .btn-primary:hover { background-color: #1d4ed8; }
  .btn-light { background-color: #f1f5f9; color: #334155; }
  .boq-section { background: #f8fafc; border-radius: 8px; padding: 15px; border: 1px solid #e5e7eb; }
  .boq-section a { text-decoration: none; color: #2563eb; font-weight: 500; }
  .boq-section a:hover { text-decoration: underline; }
</style>

<div class="container-fluid my-5">
  <div class="card p-4">
    <h4 class="mb-3 fw-bold">Available Leads & My Bids</h4>

    <table class="table align-middle">
      <thead>
        <tr>
          <th>PROJECT ID</th>
          <th>CUSTOMER TYPE</th>
          <th>LOCATION</th>
          <!-- <th>BUDGET RANGE</th> -->
          <th>STATUS</th>
          <th>ACTION</th>
        </tr>
      </thead>
      <tbody>
        @forelse($project_details as $project)
          <tr>
            <td><strong>#{{ $project->submission_id ?? 'N/A' }}</strong></td>
            <td>{{ ucfirst($project->land_type ?? 'N/A') }}</td>
            <td>{{ $project->land_location ?? 'N/A' }}</td>
           
            <td>
              @if($project->tender_status == 1)
                <span class="badge-status badge-open">Open</span>
              @elseif($project->tender_status == 2)
                <span class="badge-status badge-submitted">Submitted</span>
              @elseif($project->tender_status == 3)
                <span class="badge-status badge-won">Won</span>
              @else
                <span class="badge-status bg-secondary text-white">Pending</span>
              @endif
            </td>
            <td>
              @if($project->already_bid)
                <button class="btn btn-sm btn-secondary" disabled>✅ Already Bid</button>
              @else
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#bidModal{{ $project->project_id }}">
                  📤 Submit Bid
                </button>
              @endif
            </td>
          </tr>

          <!-- Submit Bid Modal -->
          @if(!$project->already_bid)
          <div class="modal fade" id="bidModal{{ $project->project_id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
              <div class="modal-content p-3">
                <div class="modal-header">
                  <h5 class="modal-title fw-bold">
                    Submit Bid - {{ $project->project_name ?? 'Project' }}
                  </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('vendor.upload.boq') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <input type="hidden" name="project_id" value="{{ $project->project_id }}">

                 <div class="modal-body px-4">

    <!-- Project Info Section -->
    <div class="border rounded p-3 mb-4 bg-light">
        <h6 class="text-primary mb-3">Project Information</h6>

        <div class="row">
            <div class="col-md-6 mb-2">
                <p><strong>Project Name:</strong> {{ $project->project_name }}</p>
            </div>

            <div class="col-md-6 mb-2">
                <p><strong>Project Description:</strong> {{ $project->project_description ?? 'N/A' }}</p>
            </div>

            <div class="col-md-6 mb-2">
                <p><strong>State:</strong> {{ $project->statesname }}</p>
            </div>

            <div class="col-md-6 mb-2">
                <p><strong>Region:</strong> {{ $project->regionsname }}</p>
            </div>

            <div class="col-md-6 mb-2">
                <p><strong>City:</strong> {{ $project->citiesname }}</p>
            </div>

            <div class="col-md-6 mb-2">
                <p><strong>Land Location:</strong> {{ $project->land_location }}</p>
            </div>

            <div class="col-md-6 mb-2">
                <p><strong>Land Type:</strong> {{ ucfirst($project->land_type) }}</p>
            </div>

            <div class="col-md-6 mb-2">
                <p><strong>Timeline:</strong> {{ $project->timeline ?? 'N/A' }}</p>
            </div>

            <div class="col-md-6 mb-2">
                <p><strong>Construction Vendor:</strong> {{ $project->work_types ?? 'N/A' }}</p>
            </div>

            <div class="col-md-6 mb-2">
                <p><strong>Project Type:</strong> {{ $project->work_subtype_name ?? 'N/A' }}</p>
            </div>

            <div class="col-md-6 mb-2">
                <p><strong>Work/Service Model:</strong> {{ $project->suggested_vendor_types ?? 'N/A' }}</p>
            </div>

            <div class="col-md-6 mb-2">
                <p><strong>Work/Service Category:</strong> {{ $project->vendor_subcategories ?? 'N/A' }}</p>
            </div>

            <div class="col-md-6 mb-2">
                <p><strong>Payment Preference:</strong> {{ ucfirst($project->payment_preference) }}</p>
            </div>

            <div class="col-md-6 mb-2">
                <p><strong>Quality Preference:</strong> {{ ucfirst($project->quality_preference) }}</p>
            </div>

            <div class="col-md-6 mb-2">
                <p><strong>Vendor Preference:</strong> {{ ucfirst($project->vendor_preference) }}</p>
            </div>
        </div>
    </div>


    <!-- Customer Info -->
    <div class="border rounded p-3 mb-4 bg-white">
        <h6 class="text-primary mb-3">Customer Information</h6>
        <p><strong>Name:</strong> {{ $project->full_name }}</p>
        <p><strong>Email:</strong> {{ $project->email }}</p>
        <p><strong>Phone:</strong> {{ $project->phone_number }}</p>
        <p><strong>Customer Role:</strong> {{ $project->role_name }}</p>
        <p><strong>Registered On:</strong> {{ $project->customer_created_at }}</p>
    </div>


    <!-- Tender Info -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <h6 class="text-primary mb-2">Tender Details</h6>

            @if($project->contract_type)
                <div class="border rounded p-3 bg-light">
                    <p><strong>Contract Type:</strong> {{ $project->contract_type }}</p>
                    <p><strong>Tender Value:</strong> ₹{{ $project->tender_value }}</p>
                    <p><strong>Location:</strong> {{ $project->tender_location ?? $project->land_location }}</p>
                    <p><strong>Published:</strong>
                        {{ $project->published_date ? \Carbon\Carbon::parse($project->published_date)->format('d M Y') : 'N/A' }}
                    </p>
                    <p><strong>Bid Submission End:</strong>
                        {{ $project->bid_submission_end ? \Carbon\Carbon::parse($project->bid_submission_end)->format('d M Y') : 'N/A' }}
                    </p>
                </div>
            @else
                <p class="text-muted">No tender details available.</p>
            @endif

            <div class="mt-3">
                <label class="form-label">Your Bid Amount (₹)</label>
                <input type="number" name="bid_amount" class="form-control" required>
            </div>

            <div class="mt-3">
                <label class="form-label">Remarks (Optional)</label>
                <textarea name="remarks" class="form-control" rows="3"></textarea>
            </div>

        </div>

        <!-- BOQ -->
        <div class="col-md-6">
            <h6 class="text-primary mb-2">BOQ Information</h6>
            <div class="boq-section">
                @if($project->boq_file)
                    <p><i class="bi bi-file-earmark-text me-2"></i>
                        <strong>Client BOQ:</strong>
                        <a href="{{ asset('storage/' . $project->boq_file) }}" target="_blank">View / Download</a>
                    </p>
                @else
                    <p class="text-muted">No BOQ uploaded by client.</p>
                @endif

                <div class="mb-3">
                    <label class="form-label">Upload Your BOQ File</label>
                    <input type="file" name="boq_file" class="form-control"
                           accept=".pdf,.xlsx,.xls,.doc,.docx" required>
                </div>
            </div>
        </div>
    </div>

</div>


                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">💼 Submit Bid with BOQ</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          @endif
        @empty
          <tr>
            <td colspan="6" class="text-center text-muted py-4">
              <i class="bi bi-clipboard-x fs-4 d-block mb-2"></i>
              <strong>No bids available right now.</strong>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
