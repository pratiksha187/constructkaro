@extends('layouts.app')

@section('title', 'List of Project | ConstructKaro')

@section('content')
<!-- Fonts & CSS -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
 
.table {
  width: 100% !important;
  font-size: 15px;
}

.table th,
.table td {
  text-align: center;
  padding: 1rem;
}

.card-body {
  padding: 2rem 2rem;
}

.table-wrapper {
  width: 100%;
  overflow-x: auto;
}

@media (min-width: 768px) {
  .card {
    max-width: 100%;
  }
}

  /* .table td, .table th {
    vertical-align: middle;
  } */

  h3.text-primary {
    color: #FF6600 !important;
  }

  .btn-primary {
    background-color: #FF6600;
    border-color: #FF6600;
    color: #fff;
  }
  .btn-primary:hover {
    background-color: #e65c00;
    border-color: #e65c00;
  }

  .btn-outline-secondary {
    color: #0B2240;
    border-color: #0B2240;
  }
  .btn-outline-secondary:hover {
    background-color: #0B2240;
    color: #fff;
  }

  .btn-outline-danger {
    color: #FF6600;
    border-color: #FF6600;
  }
  .btn-outline-danger:hover {
    background-color: #FF6600;
    color: #fff;
  }

  .btn-outline-primary {
    color: #FF6600;
    border-color: #FF6600;
  }
  .btn-outline-primary:hover {
    background-color: #FF6600;
    color: #fff;
  }

  .modal-header.bg-primary {
    background-color: #FF6600 !important;
  }

  .modal-header.bg-primary .btn-close {
    filter: brightness(0) invert(1);
  }

  .badge.bg-success {
    background-color: #0B2240;
    color: #fff;
  }

  .badge.bg-warning {
    background-color: #FF6600;
    color: #fff;
  }

  label.form-label {
    color: #0B2240;
    font-weight: 600;
  }
</style>


<div class="container py-8">
  <div class="card shadow-sm mb-4">
    <div class="card-body">
      <div class="col-md-12 text-end mt-3">
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
          <i class="bi bi-arrow-left"></i> Back
        </a>
      </div>

      <h3 class="mb-4 text-primary">🔍 Explore Projects</h3>

      <form id="filterForm" class="row g-3 mb-4">
        <div class="col-md-4">
          <label class="form-label fw-semibold">Project Type</label>
          <input type="text" name="project_name" class="form-control" placeholder="e.g. Residential">
        </div>
        <div class="col-md-4">
          <label class="form-label fw-semibold">Budget Range</label>
          <input type="text" name="budget_range" class="form-control" placeholder="e.g. 10-20 Lacs">
        </div>
        <div class="col-md-4 d-flex align-items-end">
          <button type="submit" class="btn btn-primary me-2 w-50">🔎 Filter</button>
          <button type="button" id="resetBtn" class="btn btn-outline-secondary w-50">♻️ Reset</button>
        </div>
      </form>

      <div class="table-responsive mt-4" style="padding: 0 0.5rem;">
        <table id="projectsTable" class="table table-hover table-bordered align-middle w-100">
          <thead class="table-light">
            <tr>
              <th>📌 Project Name</th>
              <th>💰 Budget</th>
              <th>⏱️ Timeline</th>
              <th>❤️ Like</th>
              <th>👁️ View</th>
            </tr>
          </thead>
        </table>
      </div>

    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="projectModal" tabindex="-1" aria-labelledby="projectModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="projectModalLabel">Project Details</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><strong>Project Name:</strong> <span id="modalProjectName"></span></p>
        <p><strong>Budget:</strong> <span id="modalBudget" class="badge bg-success text-white"></span></p>
        <p><strong>Timeline:</strong> <span id="modalTimeline" class="badge bg-warning text-white"></span></p>
      </div>
    </div>
  </div>
</div>

<!-- JS Dependencies -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  // Init DataTable
  let table = $('#projectsTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: "{{ url('/vender/projects-data') }}",
      data: function (d) {
        d.project_name = $('input[name=project_name]').val();
        d.budget_range = $('input[name=budget_range]').val();
      }
    },
    columns: [
      { data: 'project_name', name: 'project_name' },
      { data: 'budget_range', name: 'budget_range' },
      { data: 'expected_timeline', name: 'expected_timeline' },
      {
        data: null,
        name: 'like',
        orderable: false,
        searchable: false,
        render: function (data, type, row) {
          return `<button class="btn btn-outline-danger btn-sm like-btn" data-id="${row.id}">❤️ Like</button>`;
        }
      },
      {
        data: null,
        name: 'view',
        orderable: false,
        searchable: false,
        render: function (data, type, row) {
          return `<button class="btn btn-outline-primary btn-sm view-btn" data-id="${row.id}">👁️ View</button>`;
        }
      }
    ]
  });

  // Filter
  $('#filterForm').on('submit', function (e) {
    e.preventDefault();
    table.draw();
  });

  $('#resetBtn').on('click', function () {
    $('#filterForm')[0].reset();
    table.draw();
  });

  // Like
  $('#projectsTable').on('click', '.like-btn', function () {
    const projectId = $(this).data('id');

    $.ajax({
      url: '/project-likes',
      method: 'POST',
      data: { project_id: projectId },
      success: function (response) {
        alert(response.message || 'Project liked successfully!');
      },
      error: function (xhr) {
        if (xhr.status === 409) {
          alert(xhr.responseJSON.message || 'You already liked this project.');
        } else {
          alert('An error occurred while liking the project.');
        }
      }
    });
  });

  // View
  $('#projectsTable').on('click', '.view-btn', function () {
    const projectId = $(this).data('id');

    $.ajax({
      url: `/project-details-vendor/${projectId}`,
      method: 'GET',
      success: function (data) {
        $('#modalProjectName').text(data.project_name);
        $('#modalBudget').text(data.budget_range);
        $('#modalTimeline').text(data.expected_timeline);

        const modal = new bootstrap.Modal(document.getElementById('projectModal'));
        modal.show();
      },
      error: function () {
        alert('Failed to load project details.');
      }
    });
  });
});
</script>
@endsection
