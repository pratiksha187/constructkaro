<div class="p-4">
  <div class="d-flex justify-content-between align-items-start mb-3">
    <div>
      <h4 class="fw-bold text-navy mb-1">
        {{ $bill->project_name ?? 'N/A' }} - {{ \Carbon\Carbon::parse($bill->bill_month)->format('F Y') }}
      </h4>
      <span class="badge bg-light text-navy border">Bill #{{ $bill->id }}</span>
    </div>
    <div class="text-end">
      <h5 class="text-success fw-bold mb-0">₹{{ number_format($bill->amount, 2) }}</h5>
      <small class="text-muted">Amount Claimed</small>
    </div>
  </div>

  <div class="mb-4">
    <h6 class="fw-semibold text-navy">Work Description:</h6>
    <p class="bg-light p-3 rounded">{{ $bill->work_description }}</p>
  </div>

  <div class="mb-4">
    <h6 class="fw-semibold text-navy">Attachments:</h6>
    <ul class="list-unstyled mb-0">
      @if($bill->quantity_sheet)
        <li><i class="bi bi-file-earmark-spreadsheet text-primary"></i>
          <a href="{{ asset('storage/'.$bill->quantity_sheet) }}" target="_blank">Quantity Sheet</a>
        </li>
      @endif
      @if($bill->invoice_path)
        <li><i class="bi bi-file-earmark-text text-success"></i>
          <a href="{{ asset('storage/'.$bill->invoice_path) }}" target="_blank">Invoice</a>
        </li>
      @endif
    </ul>
  </div>

  <div class="mb-4">
    <h6 class="fw-semibold text-navy">Work Photos:</h6>
    <div class="d-flex gap-3 flex-wrap">
      @if($bill->site_photos)
        @foreach(json_decode($bill->site_photos, true) as $photo)
          <img src="{{ asset('storage/'.$photo) }}" alt="Work Photo"
               class="rounded shadow-sm" width="100" height="100">
        @endforeach
      @else
        <p class="text-muted">No photos uploaded.</p>
      @endif
    </div>
  </div>

  <form action="{{ route('billverification.update', $bill->id) }}" method="POST">
  @csrf
  <div class="row align-items-end">
    <!-- Status -->
    <div class="col-md-6 mb-3">
      <label class="form-label fw-semibold">Approval Action *</label>
      <select name="status" class="form-select" required>
        <option value="">Select action</option>
        <option value="Approved" {{ $bill->status == 'Approved' ? 'selected' : '' }}>Approved</option>
        <option value="Revised"  {{ $bill->status == 'Revised' ? 'selected' : '' }}>Revised</option>
        <option value="Rejected" {{ $bill->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
      </select>
    </div>

    <!-- Remarks -->
    <div class="col-md-6 mb-3">
      <label class="form-label fw-semibold">Remarks / Revision Notes</label>
      <textarea name="engineer_remarks" class="form-control" rows="2" placeholder="Enter remarks...">{{ $bill->engineer_remarks }}</textarea>
    </div>
  </div>

  <div class="text-end">
    <button type="submit" class="btn btn-success px-4">Submit Review</button>
  </div>
</form>

</div>
