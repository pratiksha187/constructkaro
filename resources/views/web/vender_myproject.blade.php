@extends('layouts.vender.app')
@section('title', 'Vendor Dashboard | ConstructKaro')
@section('content')

<div class="container py-4">

  <!-- Tabs -->
  <ul class="nav nav-tabs mb-4" id="projectTabs" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="active-tab" data-bs-toggle="tab" data-bs-target="#active" type="button" role="tab">
        Active Projects (0)
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed" type="button" role="tab">
        Completed Projects (0)
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="review-tab" data-bs-toggle="tab" data-bs-target="#review" type="button" role="tab">
        Under Review (0)
      </button>
    </li>
  </ul>

  <div class="tab-content" id="projectTabsContent">
    
    <!-- Active Projects -->
    <div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="active-tab">
      <div class="card border-0 shadow-sm rounded-3 p-4">
        <h5 class="fw-semibold mb-3">Active Projects</h5>

        {{-- If no projects --}}
        <div class="text-center text-muted py-5">
          <i class="bi bi-clipboard-x fs-3 d-block mb-2"></i>
          <p class="fw-semibold mb-0">No active projects at the moment.</p>
        </div>
      </div>
    </div>

    <!-- Completed Projects -->
    <div class="tab-pane fade" id="completed" role="tabpanel" aria-labelledby="completed-tab">
      <div class="card border-0 shadow-sm rounded-3 p-4">
        <h5 class="fw-semibold mb-3">Completed Projects</h5>

        {{-- If no completed projects --}}
        <div class="text-center text-muted py-5">
          <i class="bi bi-clipboard-check fs-3 d-block mb-2"></i>
          <p class="fw-semibold mb-0">No completed projects yet.</p>
        </div>
      </div>
    </div>

    <!-- Under Review Projects -->
    <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
      <div class="card border-0 shadow-sm rounded-3 p-4">
        <h5 class="fw-semibold mb-3">Projects Under Review</h5>

        {{-- If no review projects --}}
        <div class="text-center text-muted py-5">
          <i class="bi bi-hourglass-split fs-3 d-block mb-2"></i>
          <p class="fw-semibold mb-0">No projects are currently under review.</p>
        </div>
      </div>
    </div>

  </div>
</div>

@endsection
