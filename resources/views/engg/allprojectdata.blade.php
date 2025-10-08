@extends('layouts.engineer.app')

@section('title', 'Projects List')

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
  .ck-wrap{ max-width: 1200px; margin: 0 auto; padding: 2rem 1.25rem; }

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
      <h2 class="ck-title">Projects List</h2>
      <div class="d-flex gap-2">
        <a href="javascript:void(0)" class="btn btn-outline-primary btn-sm">Export</a>
        <a href="javascript:void(0)" class="btn btn-primary btn-sm">New Project</a>
      </div>
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
            <th>Project Name</th>
            <th>Address</th>
            <th>Description</th>
            <th class="text-center">Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($projects as $index => $project)
            <tr>
              <td>{{ $projects->firstItem() + $index }}</td>
              <td class="fw-semibold">{{ $project->project_name }}</td>
              <td class="text-muted">{{ $project->project_location }}</td>
              <td class="text-muted">{{ $project->project_description }}</td>
              <td class="text-center">
                <button
                  @click="activeProject = {{ json_encode($project) }}"
                  class="icon-btn"
                  title="View Details">
                  <span class="material-icons" style="font-size:18px;">visibility</span>
                </button>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center text-muted py-4">No Project found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="px-3 pb-3">
      {{ $projects->links() }}
    </div>
  </div>

<div x-show="activeProject" x-cloak class="ck-backdrop" x-transition>
  <div class="ck-modal" x-data="{ showTextarea:false }">
    <!-- header -->
    <div class="ck-mhdr">
      <div class="ck-mtitle">
        <span class="material-icons">assignment</span>
        <span x-text="activeProject.project_name"></span>
      </div>
      <button class="ck-close" @click="activeProject = null" title="Close">
        <span class="material-icons">close</span>
      </button>
    </div>

    <!-- body -->
    <div class="ck-mbody">
      <div class="mb-4">
        <div class="ck-section-title">Project Information</div>
        <div class="row g-3 ck-meta">
          <div class="col-md-6"><p>📍 Location</p><p x-text="activeProject.project_location"></p></div>
          <div class="col-md-6"><p>📝 Description</p><p x-text="activeProject.project_description"></p></div>
          <div class="col-md-6"><p>💰 Budget</p><p><span class="ck-chip" x-text="activeProject.budget_range"></span></p></div>
          <div class="col-md-6"><p>⏱ Timeline</p><p><span class="ck-chip" x-text="activeProject.expected_timeline"></span></p></div>
        </div>
      </div>

      <div class="mb-4">
        <div class="ck-section-title">Submission Info</div>

        <div class="ck-meta mb-2">
          <p>🧾 Submission ID</p>
          <p x-text="activeProject.submission_id"></p>
        </div>

        <div class="ck-meta mb-2">
          <p>📁 Project Files</p>
          <template x-if="activeProject.file_path">
            <ul class="list-unstyled mb-0">
              <template x-for="file in JSON.parse(activeProject.file_path)">
                <li class="ck-file mb-1">
                  <a :href="`/${file}`" target="_blank" class="link-primary">
                    <span class="material-icons align-text-bottom me-1" style="font-size:18px;">attach_file</span>
                    <span x-text="file.split('/').pop()"></span>
                  </a>
                </li>
              </template>
            </ul>
          </template>
        </div>

        <div class="ck-meta">
          <p>📁 BOQ File</p>
          <template x-if="activeProject.boqFile">
            <a :href="`/storage/boq_files/${activeProject.boqFile.split('/').pop()}`" download target="_blank" class="btn btn-soft btn-sm">
              <span class="material-icons align-text-bottom me-1" style="font-size:18px;">download</span>
              Download BOQ File
            </a>
          </template>
        </div>
      </div>

      <div>
        <div class="ck-section-title">Contact Information</div>
        <div class="row g-3 ck-meta">
          <div class="col-md-4"><p>👤 Full Name</p><p x-text="activeProject.full_name"></p></div>
          <div class="col-md-4"><p>📧 Email</p><p x-text="activeProject.email"></p></div>
          <div class="col-md-4"><p>📱 Phone</p><p x-text="activeProject.phone_number"></p></div>
        </div>
      </div>

      <!-- inline description area (kept your logic) -->
      <div class="mt-3" x-show="showTextarea" x-transition x-cloak>
        <label class="form-label small">Enter Remarks</label>
        <textarea rows="4" x-ref="remarks" class="form-control" placeholder="Write something here..."></textarea>
        <button @click="submitRemarks(activeProject.id, $refs.remarks.value)" class="btn btn-outline-primary mt-3">Submit</button>
      </div>
    </div>

    <!-- footer actions -->
    <div class="ck-mfooter">
      <a href="#" @click.prevent="showCallModal = true" class="btn btn-success">
        <span class="material-icons me-1" style="font-size:18px;">call</span> Call
      </a>
      <button @click="showTextarea = !showTextarea" class="btn btn-primary">
        <span class="material-icons me-1" style="font-size:18px;">description</span> Description
      </button>
    </div>
  </div>
</div>

  <!-- Call Response Modal -->
  <div x-show="showCallModal" x-cloak class="ck-backdrop" x-transition>
    <div class="ck-modal animate-fade-in" style="width:100%; max-width:520px; position:relative;">
      <button @click="showCallModal = false" class="btn btn-link ck-close p-0">
        <span class="material-icons">close</span>
      </button>

      <div class="p-4 p-md-5" x-data="{ callStatus:'', callRemarks:'' }">
        <h2 class="h5 fw-bold text-dark mb-3">Call Status</h2>

        <div class="mb-3">
          <label class="form-label">Select Call Response</label>
          <select x-model="callStatus" class="form-select">
            <option value="">-- Select Response --</option>
            <option value="1">Received</option>
            <option value="2">Not Reachable</option>
            <option value="3">Call Rejected</option>
            <option value="4">Switched Off</option>
            <option value="5">Wrong Number</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Remarks</label>
          <textarea x-model="callRemarks" rows="3" class="form-control" placeholder="Enter call remarks..."></textarea>
        </div>

        <button
          @click="submitCallResponse(activeProject.id, callStatus, callRemarks)"
          class="btn btn-primary">
          Submit Response
        </button>
      </div>
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
