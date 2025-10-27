@extends('layouts.engineer.app')
@section('title', 'Projects List')
@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<style>
  :root {
    --ck-orange: #FF6600;
    --ck-navy: #0B2240;
    --ck-blue: #2949E9;
    --ck-border: #e9eef7;
  }
  [x-cloak] { display: none !important; }
  .ck-wrap { max-width: 1200px; margin: 0 auto; padding: 2rem 1.25rem; }
  .ck-card {
    background: #fff;
    border: 1px solid var(--ck-border);
    border-radius: 16px;
    box-shadow: 0 10px 28px rgba(12, 33, 72, .06);
  }
  .ck-card-header {
    padding: 1rem 1.25rem;
    background: linear-gradient(180deg, rgba(255,102,0,.06), rgba(41,73,233,.06));
    border-bottom: 1px solid var(--ck-border);
    display: flex; justify-content: space-between;
  }
  .ck-title { font-weight: 700; color: var(--ck-navy); }
  .icon-btn {
    display: inline-flex; align-items: center; justify-content: center;
    width: 36px; height: 36px; border-radius: 10px;
    border: 1px solid var(--ck-border); color: var(--ck-blue); background: #fff;
  }
  .ck-backdrop {
    position: fixed; inset: 0; background: rgba(0,0,0,.6);
    display: flex; align-items: center; justify-content: center;
    z-index: 1050; padding: 1rem;
  }
  .ck-modal {
    background: #fff; border-radius: 16px;
    width: 100%; max-width: 960px; overflow: hidden;
  }
  .ck-mhdr {
    background: linear-gradient(90deg, rgba(255,102,0,.08), rgba(41,73,233,.08));
    padding: 14px 18px; display: flex; justify-content: space-between; align-items: center;
  }
  .ck-mbody {
    padding: 22px; max-height: calc(90vh - 130px);
    overflow: auto;
  }
</style>

<div class="ck-wrap" 
     x-data="{
        activeProject: null,
        submitProjectUpdate() {
          const projectId = this.$refs.projectId.value;
          const engg_description = this.$refs.remarks.value;
          const callStatus = this.$refs.callStatus.value;
          const callRemarks = this.$refs.callRemarks.value;

          if (!engg_description.trim() && !callStatus) {
            alert('⚠️ Please enter remarks or select a call response.');
            return;
          }

          $.ajax({
            url: '/engineer/project/update-details',
            type: 'POST',
            data: {
              _token: '{{ csrf_token() }}',
              id: projectId,
              engg_decription: engg_description,
              call_status: callStatus,
              call_remarks: callRemarks
            },
            success: () => {
              alert('✅ Details updated successfully!');
              this.activeProject = null; // close modal
            },
            error: () => {
              alert('❌ Error occurred while updating details.');
            }
          });
        }
     }">

  <div class="ck-card">
    <div class="ck-card-header">
      <h2 class="ck-title">Projects List</h2>
    </div>

    @if(session('success'))
      <div class="alert alert-success m-3 mb-0">{{ session('success') }}</div>
    @endif

    <div class="table-responsive p-3">
      <table class="table table-striped table-bordered align-middle">
        <thead class="table-dark">
          <tr>
            <th>Project ID</th>
            <th>Customer Name</th>
            <th>Project Name</th>
            <th>Budget</th>
            <th>Engineer Remarks</th>
            <th>Call Status</th>
            <th>Created At</th>
            <th class="text-center">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($projects as $p)
            <tr>
              <td>{{ $p->submission_id }}</td>
              <td>{{ $p->full_name }}</td>
              <td>{{ $p->project_name }}</td>
              <td>{{ $p->budget_range ?? $p->detail_budget_range }}</td>
              <td>{{ $p->engg_decription ?? '-' }}</td>
              <td>
                @if($p->call_status == 1) ✅ Received
                @elseif($p->call_status == 2) 📞 Not Reachable
                @elseif($p->call_status == 3) ❌ Call Rejected
                @elseif($p->call_status == 4) ⚡ Switched Off
                @elseif($p->call_status == 5) 🚫 Wrong Number
                @else -
                @endif
              </td>
              <td>{{ $p->project_created_at ? \Carbon\Carbon::parse($p->project_created_at)->format('d M Y, h:i A') : '-' }}</td>
              <td class="text-center">
                <button @click="activeProject = {{ json_encode($p) }}" class="icon-btn" title="View Details">
                  <span class="material-icons" style="font-size:18px;">visibility</span>
                </button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>

      <div class="mt-3">
        {{ $projects->links() }}
      </div>
    </div>
  </div>

  {{-- 🔹 Modal --}}
  <div x-show="activeProject" x-cloak class="ck-backdrop" x-transition>
    <div class="ck-modal shadow-lg border-0 rounded-4 overflow-hidden">

      <!-- Header -->
      <div class="ck-mhdr">
        <div class="d-flex align-items-center gap-2">
          <span class="material-icons text-warning fs-4">assignment</span>
          <h5 class="mb-0 fw-bold text-dark" x-text="activeProject.project_name"></h5>
        </div>
        <button class="btn btn-light btn-sm rounded-circle shadow-sm" @click="activeProject=null" title="Close">
          <span class="material-icons">close</span>
        </button>
      </div>

      <!-- Body -->
      <div class="ck-mbody p-4" style="background:#fafbfd;">
        <div class="mb-4">
          <h6 class="fw-bold text-dark mb-3 border-start border-3 ps-2" style="border-color:#FF6600;">Project Information</h6>
          <div class="row g-3">
            <div class="col-md-6">
              <p class="fw-semibold small mb-1">📍 Location</p>
              <p x-text="activeProject.project_location ?? activeProject.land_location"></p>
            </div>
            <div class="col-md-6">
              <p class="fw-semibold small mb-1">📝 Description</p>
              <p x-text="activeProject.project_description"></p>
            </div>
            <div class="col-md-6">
              <p class="fw-semibold small mb-1">💰 Budget</p>
              <span class="badge text-bg-light border" x-text="activeProject.budget_range ?? activeProject.detail_budget_range"></span>
            </div>
            <div class="col-md-6">
              <p class="fw-semibold small mb-1">⏱ Timeline</p>
              <span class="badge text-bg-light border" x-text="activeProject.project_duration ?? activeProject.expected_timeline"></span>
            </div>
          </div>
        </div>

        <!-- Contact Info -->
        <div class="mb-4">
          <h6 class="fw-bold text-dark mb-3 border-start border-3 ps-2" style="border-color:#0B2240;">Contact Information</h6>
          <div class="row g-3">
            <div class="col-md-4"><p class="fw-semibold small mb-1">👤 Full Name</p><p x-text="activeProject.full_name"></p></div>
            <div class="col-md-4"><p class="fw-semibold small mb-1">📧 Email</p><p x-text="activeProject.email"></p></div>
            <div class="col-md-4"><p class="fw-semibold small mb-1">📱 Phone</p><p x-text="activeProject.phone_number"></p></div>
          </div>
        </div>

        <!-- Engineer Action -->
        <div class="border-top pt-4 mt-4">
          <h6 class="fw-bold mb-3 text-dark">🧰 Engineer Action</h6>

          <!-- Hidden project_id -->
          <input type="hidden" x-ref="projectId" :value="activeProject.project_id">

          <p class="text-muted small mb-3">
            <strong>Project ID:</strong> <span x-text="activeProject.project_id"></span>
          </p>

          <div class="mb-3">
            <label class="form-label small fw-semibold">Engineer Remarks</label>
            <textarea rows="4" x-ref="remarks" class="form-control shadow-sm border-1"
                      placeholder="Write engineer remarks..."></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label small fw-semibold">Select Call Response</label>
            <select x-ref="callStatus" class="form-select shadow-sm">
              <option value="">-- Select Response --</option>
              <option value="1">Received</option>
              <option value="2">Not Reachable</option>
              <option value="3">Call Rejected</option>
              <option value="4">Switched Off</option>
              <option value="5">Wrong Number</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label small fw-semibold">Call Remarks</label>
            <textarea x-ref="callRemarks" rows="3" class="form-control shadow-sm"
                      placeholder="Enter call remarks..."></textarea>
          </div>

          <button @click="submitProjectUpdate()" class="btn btn-primary px-4">
            Submit
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Scripts --}}
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@endsection
