@extends('layouts.engineer.app')

@section('title', 'Saved Milestones')

@section('content')
<div class="container mt-4">
  <h4 class="mb-3">Saved Milestones</h4>

  @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <a href="{{ route('addmillstone') }}" class="btn btn-secondary mb-3">← Add New Milestone</a>

  <table class="table table-bordered table-striped align-middle">
    <thead class="table-dark">
      <tr>
        <th>#</th>
        <th>Project Name</th>
        
        <th>Type</th>
        <th>Milestones (Title - Payment %)</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @php $count = 1; @endphp
      @forelse ($grouped as $projectId => $milestones)
        @php 
          $first = $milestones->first(); 
        @endphp
        <tr>
          <td>{{ $count++ }}</td>
          <td>{{ $first->project_name }}</td>
          
          <td>{{ ucfirst($first->type_of_work ?? '-') }}</td>
          <td>
            <ul class="mb-0">
              @foreach ($milestones as $m)
                <li>
                  <strong>{{ $m->milestone_title }}</strong> 
                  — {{ ucfirst($m->type_of_work) }} 
                  ({{ $m->payment_percentage }}%)
                </li>
              @endforeach
            </ul>
          </td>
          <td>
            <button class="btn btn-sm btn-primary viewBtn"
              data-project="{{ $first->project_name }}"
            
              data-type="{{ $first->type_of_work }}"
              data-id="{{ $first->project_id }}">
              View All
            </button>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="6" class="text-center text-muted">No milestones found</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

{{-- 🔍 Modal for View All Milestones --}}
<div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title">Project Milestones</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modalBody">
        <p>Loading milestones...</p>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
  $(".viewBtn").click(function() {
    let projectId = $(this).data("id");
    let projectName = $(this).data("project");

    $("#modalBody").html("<p>Loading milestones for <strong>" + projectName + "</strong>...</p>");

    $.get("/engineer/milestones/" + projectId, function(data) {
      if (data.length === 0) {
        $("#modalBody").html("<p class='text-danger'>No milestones found for this project.</p>");
        return;
      }

      let html = `
        <h5>Project: ${projectName}</h5>
        <table class="table table-bordered">
          <thead><tr>
            <th>Type of Work</th>
            <th>Work To Be Done</th>
            <th>Milestone</th>
            <th>Description</th>
            <th>Days</th>
            <th>Payment %</th>
            <th>Verification</th>
          </tr></thead><tbody>`;

      data.forEach(m => {
        html += `
          <tr>
            <td>${m.type_of_work}</td>
            <td>${m.work_to_be_done}</td>
            <td>${m.milestone_title}</td>
            <td>${m.milestone_description ?? '-'}</td>
            <td>${m.timeframe_days}</td>
            <td>${m.payment_percentage}%</td>
            <td>${m.verification_point ?? '-'}</td>
          </tr>`;
      });

      html += `</tbody></table>`;
      $("#modalBody").html(html);
    });

    $("#viewModal").modal("show");
  });
});
</script>
@endsection
