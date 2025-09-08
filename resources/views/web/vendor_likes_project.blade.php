@extends('layouts.vendor_dash.app')

@section('title', 'List of Project | ConstructKaro')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

<style>
  body { font-family: 'Inter', sans-serif; background:#f9fafb; color:#0B2240; }
  .table td, .table th { vertical-align: middle; }
  h3.text-primary { color:#FF6600 !important; }
  .btn-primary { background:#FF6600; border-color:#FF6600; color:#fff; }
  .btn-primary:hover { background:#e65c00; border-color:#e65c00; }
  .btn-outline-secondary { color:#0B2240; border-color:#0B2240; }
  .btn-outline-secondary:hover { background:#0B2240; color:#fff; }
  .modal-header.bg-primary { background:#FF6600 !important; }
  .modal-header .btn-close { filter: brightness(0) invert(1); }
  .badge.bg-success { background:#0B2240; }
  .badge.bg-warning { background:#FF6600; }
  label.form-label { color:#0B2240; font-weight:600; }
  .py-5 {
    padding-top: 6rem !important;
    padding-bottom: 3rem !important;
}


</style>

<div class="container py-5">
  <div class="card shadow-sm">
    <div class="col-md-11 text-end mt-3">
      <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Back
      </a>
    </div>

    <div class="card-body">
      <h3 class="mb-4 text-primary">🔍 Explore Like Projects</h3>

      <div class="table-responsive">
        <table id="projectsTable" class="table table-hover table-bordered align-middle w-100">
          <thead class="table-light">
            <tr>
              <th>📌 Project Name</th>
              <th>💰 Budget</th>
              <th>⏱️ Timeline</th>
              <th>👁️ View</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Project Details + Upload Modal -->
<div class="modal fade" id="projectModal" tabindex="-1" aria-labelledby="projectModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="projectModalLabel">Project Details</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><strong>Project Name:</strong> <span id="modalProjectName"></span></p>
        <p><strong>Customer Budget:</strong> <span id="modalBudget" class="badge bg-success text-white"></span></p>
        <p><strong>Timeline:</strong> <span id="modalTimeline" class="badge bg-warning text-white"></span></p>
        <hr>
        <h6>Upload Tender Documents</h6>

        <!-- SINGLE FORM (only here) -->
        <form id="documentUploadForm" enctype="multipart/form-data">
          @csrf
          <input type="hidden" id="project_id" name="project_id">

          <!-- Per-file progress list -->
          <ul id="fileProgressList" class="list-group mb-3" style="display:none;"></ul>

          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">EMD Receipt (.pdf)</label>
              <input type="file" id="emd_receipt" name="emd_receipt" class="form-control" accept=".pdf" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Company Profile (.pdf)</label>
              <input type="file" id="company_profile" name="company_profile" class="form-control" accept=".pdf">
            </div>

            <div class="col-md-6">
              <label class="form-label">Address Proof (.pdf)</label>
              <input type="file" id="address_proof" name="address_proof" class="form-control" accept=".pdf">
            </div>
            <div class="col-md-6">
              <label class="form-label">GST Certificate (.pdf)</label>
              <input type="file" id="gst_certificate" name="gst_certificate" class="form-control" accept=".pdf">
            </div>

            <div class="col-md-6">
              <label class="form-label">Work Experience (.pdf)</label>
              <input type="file" id="work_experience" name="work_experience" class="form-control" accept=".pdf">
            </div>
            <div class="col-md-6">
              <label class="form-label">Financial Capacity (.pdf)</label>
              <input type="file" id="financial_capacity" name="financial_capacity" class="form-control" accept=".pdf">
            </div>

            <div class="col-md-6">
              <label class="form-label">Declaration (.pdf)</label>
              <input type="file" id="declaration" name="declaration" class="form-control" accept=".pdf">
            </div>
            <div class="col-md-6">
              <label class="form-label">BOQ File (.xls/.xlsx)</label>
              <input type="file" id="boq_file" name="boq_file" class="form-control" accept=".xls,.xlsx">
            </div>

            <div class="col-md-6">
              <label class="form-label">Vendor Cost</label>
              <input type="number" id="vendor_cost" name="vendor_cost" class="form-control" placeholder="Enter Vendor Cost" required>
            </div>
          </div>

          <button type="submit" class="btn btn-success mt-4" style="background-color:#0B2240; border-color:#0B2240;">
            Upload All Files
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

<script>
  $(function () {
    $.ajaxSetup({
      headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
    });

    const table = $('#projectsTable').DataTable({
      processing: true,
      serverSide: true,
      ajax: { url: "{{ url('/vender/like-projects-data') }}" },
      columns: [
        { data: 'project_name', name: 'project_name' },
        { data: 'budget_range', name: 'budget_range' },
        { data: 'expected_timeline', name: 'expected_timeline' },
        {
          data: null, orderable:false, searchable:false,
          render: function (data, type, row) {
            const pid = row.id ?? row.project_id ?? row.projectId;   // <- robust id getter
            return `<button class="btn btn-outline-primary btn-sm view-btn"
                      data-id="${pid}" style="color:#FF6600; border-color:#FF6600;">
                      👁️ View
                    </button>`;
          }
        }
      ]
    });

    // View → set hidden project_id and show modal
    $('#projectsTable').on('click', '.view-btn', function () {
      const projectId = $(this).data('id');
      if (!projectId) { alert('Missing project id in table row.'); return; }

      $.get(`/project-details-vendor/${projectId}`)
        .done(function (data) {
          $('#project_id').val(projectId); // <- critical
          $('#modalProjectName').text(data.project_name ?? '');
          $('#modalBudget').text(data.budget_range ?? '');
          $('#modalTimeline').text(data.expected_timeline ?? '');
          new bootstrap.Modal(document.getElementById('projectModal')).show();
        })
        .fail(function () { alert('Failed to load project details.'); });
    });
  });
</script>

<script>
  // === Sequential upload with progress ===
  const tenderFields = [
    'emd_receipt','company_profile','address_proof','gst_certificate',
    'work_experience','financial_capacity','declaration','boq_file'
  ];

  function addProgressItem(name, label) {
    const list = document.getElementById('fileProgressList');
    list.style.display = 'block';
    const li = document.createElement('li');
    li.className = 'list-group-item d-flex justify-content-between align-items-center';
    li.id = `prog-${name}`;
    li.innerHTML = `<span>${label}</span><span class="badge bg-secondary" id="pct-${name}">0%</span>`;
    list.appendChild(li);
  }
  function setProgress(name, pct, done) {
    const badge = document.getElementById(`pct-${name}`);
    if (!badge) return;
    badge.textContent = done ? 'Done' : `${pct}%`;
    badge.className = 'badge ' + (done ? 'bg-success' : 'bg-info');
  }
  function collectSelectedFiles(formEl) {
    const files = {};
    tenderFields.forEach(f => {
      const el = formEl.querySelector('#'+f);
      if (el && el.files && el.files[0]) files[f] = el.files[0];
    });
    return files;
  }
  function isAllowed(field, fileName) {
    const lower = fileName.toLowerCase();
    if (field === 'boq_file') return lower.endsWith('.xls') || lower.endsWith('.xlsx');
    return lower.endsWith('.pdf');
  }
  function uploadOne(field, file, csrf) {
    return new Promise((resolve, reject) => {
      const fd = new FormData();
      fd.append('field', field);
      fd.append('file', file);

      const xhr = new XMLHttpRequest();
      xhr.open('POST', "{{ route('engineer.tender.upload') }}"); // define this route
      xhr.setRequestHeader('X-CSRF-TOKEN', csrf);
      xhr.withCredentials = true;

      xhr.upload.onprogress = (e) => {
        if (e.lengthComputable) {
          setProgress(field, Math.round((e.loaded/e.total)*100), false);
        }
      };
      xhr.onload = () => {
        if (xhr.status >= 200 && xhr.status < 300) {
          try {
            const json = JSON.parse(xhr.responseText);
            setProgress(field, 100, true);
            resolve(json.path);
          } catch { reject('Invalid server response'); }
        } else { reject(xhr.responseText || 'Upload failed'); }
      };
      xhr.onerror = () => reject('Network error');
      xhr.send(fd);
    });
  }

  document.getElementById('documentUploadForm').addEventListener('submit', async function (e) {
    e.preventDefault();
    const form = e.target;

    const projectId = document.getElementById('project_id').value; // <- source of truth
    if (!projectId) { alert('No project selected. Click "View" on a project first.'); return; }

    const selected = collectSelectedFiles(form);
    if (!selected['emd_receipt']) { alert('EMD receipt is required.'); return; }

    // quick client validation
    for (const [field, file] of Object.entries(selected)) {
      if (!isAllowed(field, file.name)) { alert(`${field} has an invalid file type.`); return; }
    }

    // progress UI
    document.getElementById('fileProgressList').innerHTML = '';
    for (const [field, file] of Object.entries(selected)) addProgressItem(field, file.name);

    const csrf = document.querySelector('meta[name="csrf-token"]').content;

    // upload sequentially
    const storedPaths = {};
    try {
      for (const field of tenderFields) {
        const file = selected[field];
        if (!file) continue;
        storedPaths[field] = await uploadOne(field, file, csrf);
      }
    } catch (err) { console.error(err); alert(`Upload failed: ${err}`); return; }

    // final fast save
    const payload = new FormData();
    payload.append('project_id', projectId);
    payload.append('vendor_cost', document.getElementById('vendor_cost').value || '0');
    payload.append('uploaded_paths', JSON.stringify(storedPaths));

    fetch("{{ route('engineer.tender.store') }}", {
      method: 'POST',
      body: payload,
      credentials: 'same-origin',
      headers: { 'X-CSRF-TOKEN': csrf }
    })
    .then(async res => {
      const data = await res.json().catch(() => ({}));
      if (!res.ok) throw new Error(data.message || 'Save failed');
      alert(data.message || 'Submitted!');
      form.reset();
      document.getElementById('fileProgressList').style.display = 'none';
      bootstrap.Modal.getInstance(document.getElementById('projectModal')).hide();
    })
    .catch(err => { console.error(err); alert(err.message || 'Save failed'); });
  });
</script>
@endsection
