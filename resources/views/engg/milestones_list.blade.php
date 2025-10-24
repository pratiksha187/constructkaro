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
        @php $first = $milestones->first(); @endphp
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
              data-id="{{ $first->project_id }}">
              View All
            </button>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="5" class="text-center text-muted">No milestones found</td>
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

{{-- jQuery --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {

  // 🟩 View button click: fetch milestones via AJAX
  $(".viewBtn").click(function() {
    const projectId = $(this).data("id");
    const projectName = $(this).data("project");

    $("#modalBody").html(`<p>Loading milestones for <strong>${projectName}</strong>...</p>`);
    $("#viewModal").modal("show");

    $.get("/engineer/milestones/" + projectId, function(data) {
      if (!data || data.length === 0) {
        $("#modalBody").html("<p class='text-danger'>No milestones found for this project.</p>");
        return;
      }

      let html = `
        <h5 class="mb-3">Project: ${projectName}</h5>
        <table class="table table-bordered align-middle text-center">
          <thead class="table-dark">
            <tr>
              <th>Type of Work</th>
              <th>Work To Be Done</th>
              <th>Milestone</th>
              <th>Description</th>
              <th>Days</th>
              <th>Payment %</th>
              <th>Verification</th>
              <th>Completed</th>
            </tr>
          </thead>
          <tbody>`;

      data.forEach(m => {
        const checked = m.is_completed == 1 ? "checked" : "";
        const bgColor = m.is_completed == 1 ? "style='background-color:#d4edda;'" : "";
        html += `
          <tr data-id="${m.id}" ${bgColor}>
            <td>${m.type_of_work}</td>
            <td>${m.work_to_be_done}</td>
            <td>${m.milestone_title}</td>
            <td>${m.milestone_description ?? '-'}</td>
            <td>${m.timeframe_days}</td>
            <td>${m.payment_percentage}%</td>
            <td>${m.verification_point ?? '-'}</td>
            <td>
              <div class="form-check d-flex justify-content-center align-items-center">
                <input type="checkbox" class="form-check-input complete-checkbox me-2" ${checked}>
                <div class="spinner-border spinner-border-sm text-success d-none" role="status"></div>
              </div>
            </td>
          </tr>`;
      });

      html += "</tbody></table>";
      $("#modalBody").html(html);
    });
  });

  // ✅ Handle checkbox change (update milestone completion)
  $(document).on("change", ".complete-checkbox", function() {
    const checkbox = $(this);
    const row = checkbox.closest("tr");
    const spinner = row.find(".spinner-border");
    const milestoneId = row.data("id");
    const isCompleted = checkbox.is(":checked") ? 1 : 0;

    if (!milestoneId) {
      alert("❌ Milestone ID missing.");
      return;
    }

    spinner.removeClass("d-none");

    $.ajax({
      url: "{{ route('engineer.milestones.updateStatus') }}",
      type: "POST",
      data: {
        _token: "{{ csrf_token() }}",
        id: milestoneId,
        is_completed: isCompleted
      },
      success: function(res) {
        spinner.addClass("d-none");
        if (res.success) {
          if (isCompleted) {
            row.css("background-color", "#d4edda");
          } else {
            row.css("background-color", "");
          }
        } else {
          alert("⚠️ Failed to update milestone.");
          checkbox.prop("checked", !isCompleted);
        }
      },
      error: function(xhr) {
        spinner.addClass("d-none");
        console.error(xhr.responseText);
        alert("⚠️ AJAX error while updating milestone.");
        checkbox.prop("checked", !isCompleted);
      }
    });
  });
});
</script>
@endsection
