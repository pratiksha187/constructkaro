@extends('layouts.vender.app')
@section('title', 'Vendor Dashboard | ConstructKaro')
@section('content')

<div class="card shadow-sm border-0 mt-4">
  <div class="card-body">
    <h5 class="fw-bold mb-3">Uploaded Documents</h5>

    <div class="row g-3">
      @forelse ($documents as $doc)
        <div class="col-md-4">
          <div class="border rounded p-3 h-100">
            <div class="d-flex align-items-center mb-2">
              @if ($doc->verified)
                <i class="bi bi-check-circle-fill text-success me-2"></i>
              @else
                <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>
              @endif
              <h6 class="fw-semibold mb-0">{{ $doc->document_type }}</h6>
            </div>

            @if ($doc->verified)
              <small class="text-muted">Verified on {{ \Carbon\Carbon::parse($doc->verified_date)->format('M d, Y') }}</small>
              <br>
              <a href="{{ asset($doc->file_path) }}" target="_blank" class="text-decoration-none text-primary fw-semibold">
                <i class="bi bi-file-earmark-text me-1"></i> View Document
              </a>
            @else
              <small class="text-muted d-block mb-2">Pending verification</small>
              <a href="#" class="text-decoration-none text-primary fw-semibold">
                <i class="bi bi-folder-fill text-warning me-1"></i> Upload Document
              </a>
            @endif
          </div>
        </div>
      @empty
        <div class="text-center text-muted py-5">
          <i class="bi bi-folder-x fs-3 d-block mb-2"></i>
          <p class="fw-semibold mb-0">No documents uploaded yet.</p>
        </div>
      @endforelse
    </div>
  </div>
</div>

@endsection
