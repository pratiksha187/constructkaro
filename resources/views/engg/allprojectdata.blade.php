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
  .ck-title { font-weight: 700; color: #1d549b; }
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

  .ck-backdrop {
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.45);
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 30px;
  z-index: 9999;
}

.ck-modal {
  background: #fff;
  width: 90vw;          /* Increase Width */
  max-width: 1200px;    /* Max Width Limit */
  max-height: 90vh;     /* Increase Height */
  overflow-y: auto;     /* Scroll Inside */
  border-radius: 12px;
  animation: scaleIn .25s ease;
}

.ck-mhdr {
  background: #f8f9fc;
  border-bottom: 1px solid #ddd;
  padding: 16px 24px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.ck-mbody {
  padding: 24px;
  overflow-y: auto;
}

/* Smooth Opening Animation */
@keyframes scaleIn {
  0% { transform: scale(0.92); opacity: 0; }
  100% { transform: scale(1); opacity: 1; }
}

</style>
<div class="ck-wrap"
     x-data="{
        activeProject: null,
        search: '',
        
        showExpiryModal: false,
        updateProjectId: '',
        newDate: '',

        // OPEN EXPIRY MODAL
        openExpiryModal(id, oldDate) {
            this.updateProjectId = id;
            this.newDate = oldDate;
            this.showExpiryModal = true;
        },

        // SUBMIT EXPIRY UPDATE
        submitExpiryUpdate() {
            fetch('/update-expiry-date', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    project_id: this.updateProjectId,
                    expiry_date: this.newDate
                })
            })
            .then(() => {
                alert('Expiry Date Updated Successfully!');
                location.reload();
            });
        },

        // ENGINEER PROJECT UPDATE
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
                    alert('Details updated successfully!');
                    this.activeProject = null; 
                },
                error: () => {
                    alert('Error occurred while updating.');
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
<div class="p-3 pb-0">
  <div class="input-group" style="max-width: 350px;">
    <span class="input-group-text bg-white border-end-0">
      <span class="material-icons" style="font-size:18px;">search</span>
    </span>
    <input type="text" class="form-control border-start-0" placeholder="Search projects..."
           x-model="search">
  </div>
</div>

    <div class="table-responsive p-3">
      <table class="table table-striped table-bordered align-middle">
        <thead class="table-dark">
          <tr>
            <th>Project ID</th>
            <th>Customer Name</th>
            <th>Phone Number</th>
            <th>Project Name</th>
            <th>Budget</th>
            <th>Engineer Remarks</th>
            <th>Call Status</th>
            <th>Project Upload Date</th>
            <th>Tender Upload Date</th>
            <th>Tender Expiry Date</th>
            <th>Tender Update</th>
            
            <th class="text-center">Action</th>
          </tr>
        </thead>
      
        <tbody>
          @foreach ($projects as $p)
            <tr x-show="`${{ json_encode($p->submission_id) }} 
                        {{ json_encode($p->full_name) }} 
                        {{json_encode($p->phone_number) }}
                        {{ json_encode($p->project_name) }} 
                        {{ json_encode($p->budget_range_name) }}`.toLowerCase().includes(search.toLowerCase())">
              
              <td>{{ $p->submission_id }}</td>
              <td>{{ $p->full_name }}</td>
              <td>{{ $p->phone_number }}</td>
              
              <td>{{ $p->project_name }}</td>
              <td>{{ $p->budget_range_name }}</td>
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
              <td>{{ $p->project_created_at ? \Carbon\Carbon::parse($p->project_created_at)->format('d M Y') : '-' }}</td>
              <td>{{ $p->bid_submission_start ? \Carbon\Carbon::parse($p->bid_submission_start)->format('d M Y') : '-' }}</td>

               <td>
                    @php
                        $expiry = \Carbon\Carbon::parse($p->expired_project_date);
                        $isExpired = $expiry->isPast();
                    @endphp

                    @if($isExpired)
                        <span class="text-danger fw-bold">{{ $expiry->format('d M Y') }}</span>
                        <br>
                        <button class="btn btn-sm btn-danger mt-1"
                                @click="openExpiryModal({{ $p->project_id }}, '{{ $p->expired_project_date }}')">
                            Expired – Update
                        </button>
                    @else
                        <span class="text-success fw-bold">{{ $expiry->format('d M Y') }}</span>
                    @endif
                </td>


              <td>
                @if($p->tender_upload)
                    <span class="text-green-600 font-bold">Tender Uploaded</span>
                @else
                    <span class="text-red-600 font-bold">Pending</span>
                @endif
              </td>

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
    <div class="ck-modal shadow-lg border-0 rounded-4 overflow-hidden ">

      <!-- Header -->
      <div class="ck-mhdr">
        <div class="d-flex align-items-center gap-2">
          <span class="material-icons text-warning fs-4">assignment</span>
          <h5 class="mb-0 fw-bold text-dark" x-text="activeProject.project_name"></h5>( <h5 class="mb-0 fw-bold text-dark" x-text="activeProject.submission_id"></h5>)
        </div>
        <button class="btn btn-light btn-sm rounded-circle shadow-sm" @click="activeProject=null" title="Close">
          <span class="material-icons">close</span>
        </button>
      </div>

      <!-- Body -->
      <div class="ck-mbody p-4" style="background:#fafbfd;">
          <!-- Contact Info -->
        <div class="mb-4">
          <h6 class="fw-bold text-dark mb-3 border-start border-3 ps-2" style="border-color:#0B2240;">Contact Information</h6>
          <div class="row g-3">
            <div class="col-md-4"><p class="fw-semibold small mb-1">👤 Full Name</p><p x-text="activeProject.full_name"></p></div>
            <div class="col-md-4"><p class="fw-semibold small mb-1">📧 Email</p><p x-text="activeProject.email"></p></div>
            <div class="col-md-4"><p class="fw-semibold small mb-1">📱 Phone</p><p x-text="activeProject.phone_number"></p></div>
            <div class="col-md-4"><p class="fw-semibold small mb-1">👤 Gender</p><p x-text="activeProject.gender"></p></div>
            <div class="col-md-4"><p class="fw-semibold small mb-1">📍 State</p><p x-text="activeProject.statesname"></p></div>
            <div class="col-md-4"><p class="fw-semibold small mb-1">📍 Region</p><p x-text="activeProject.regionsname"></p></div>
            <div class="col-md-4"><p class="fw-semibold small mb-1">📍 City</p><p x-text="activeProject.citiesname"></p></div>
            
            
          </div>
        </div>

        <div class="mb-4">
          <h6 class="fw-bold text-dark mb-3 border-start border-3 ps-2" style="border-color:#FF6600;">Project Information</h6>
          <div class="row g-3">
            <div class="col-md-4">
              <p class="fw-semibold small mb-1">📍 Land Location</p>
              <p x-text="activeProject.project_location ?? activeProject.land_location"></p>
            </div>
             <div class="col-md-4">
              <p class="fw-semibold small mb-1">📍 Survey Number</p>
              <p x-text="activeProject.survey_number ?? activeProject.survey_number"></p>
            </div>
             <div class="col-md-4">
              <p class="fw-semibold small mb-1">📍 Land Type</p>
              <p x-text="activeProject.land_type ?? activeProject.land_type"></p>
            </div>
  

            <div class="col-md-4">
              <p class="fw-semibold small mb-1">📍 Land Area</p>
              <p x-text="`${activeProject.land_area ?? ''} ${activeProject.land_unit ?? ''}`"></p>
            </div>

            <div class="col-md-4">
              <p class="fw-semibold small mb-1">📝 Description</p>
              <p x-text="activeProject.project_description"></p>
            </div>
            <div class="col-md-4">
              <p class="fw-semibold small mb-1">💰 Budget</p>
              <span class="badge text-bg-light border" x-text="activeProject.budget_range_name ?? activeProject.budget_range_name   "></span>
            </div>
            <div class="col-md-4">
              <p class="fw-semibold small mb-1">⏱ Timeline</p>
              <span class="badge text-bg-light border" x-text="activeProject.timeline ?? activeProject.timeline"></span>
            </div>
            <div class="col-md-4">
              <p class="fw-semibold small mb-1">👤 Role</p>
              <span class="badge text-bg-light border" x-text="activeProject.role_name ?? activeProject.role_name"></span>
            </div> 
            <div class="col-md-4">
              <p class="fw-semibold small mb-1">👤 Site Ready</p>
              <span class="badge text-bg-light border" x-text="activeProject.site_ready ?? activeProject.site_ready"></span>
            </div> 
            <div class="col-md-4">
              <p class="fw-semibold small mb-1">👤 Arch Drawings Available</p>
              <span class="badge text-bg-light border"
                    x-text="activeProject.arch_drawings == 1 ? 'Yes' : 'No'"></span>
            </div>

            <div class="col-md-4">
              <p class="fw-semibold small mb-1">👤 Struct Drawings Available</p>
              <span class="badge text-bg-light border" x-text="activeProject.struct_drawings == 1 ? 'Yes' : 'No'"></span>
            </div>

            <div class="col-md-4">
              <p class="fw-semibold small mb-1">👤 BOQ Available</p>
              <span class="badge text-bg-light border" x-text="activeProject.has_boq == 1 ? 'Yes' : 'No'"></span>
            </div>

            <div class="col-md-4">
              <p class="fw-semibold small mb-1">👤 Expected Start</p>
              <span class="badge text-bg-light border" x-text="activeProject.expected_start ?? activeProject.expected_start"></span>
            </div>

            <div class="col-md-4">
              <p class="fw-semibold small mb-1">💧 Water</p>
              <span :class="activeProject.water === 'on' ? 'badge bg-success' : 'badge bg-secondary'"
                    x-text="activeProject.water === 'on' ? 'YES' : 'NO'">
              </span>
            </div>
            <div class="col-md-4">
              <p class="fw-semibold small mb-1">⚡ Electricity</p>
              <span :class="activeProject.electricity === 'on' ? 'badge bg-success' : 'badge bg-secondary'"
                    x-text="activeProject.electricity === 'on' ? 'YES' : 'NO'">
              </span>
            </div>

            <div class="col-md-4">
              <p class="fw-semibold small mb-1">🚰 Drainage</p>
              <span :class="activeProject.drainage === 'on' ? 'badge bg-success' : 'badge bg-secondary'"
                    x-text="activeProject.drainage === 'on' ? 'YES' : 'NO'">
              </span>
            </div>
            <div class="col-md-4">
              <p class="fw-semibold small mb-1">👤 work_type</p>
              <span class="badge text-bg-light border" x-text="activeProject.work_types ?? activeProject.work_types"></span>
            </div>
            <div class="col-md-4">
              <p class="fw-semibold small mb-1">🎯 Work Subtype</p>
              <span class="badge text-bg-light border" x-text="activeProject.work_subtype_name ?? '-'"></span>
            </div>

            <div class="col-md-4">
              <p class="fw-semibold small mb-1">🏭 Vendor Type</p>
              <span class="badge text-bg-light border" x-text="activeProject.suggested_vendor_types ?? '-'"></span>
            </div>

            <div class="col-md-4">
              <p class="fw-semibold small mb-1">👥 Sub Vendor Types</p>
              <span class="badge text-bg-light border" x-text="activeProject.vendor_subcategories ?? '-'"></span>
            </div>

            <div class="col-md-4">
              <p class="fw-semibold small mb-1">💰 Payment Preference</p>
              <span class="badge text-bg-light border" x-text="activeProject.payment_preference ?? '-'"></span>
            </div>

            <div class="col-md-4">
              <p class="fw-semibold small mb-1">⭐ Quality Preference</p>
              <span class="badge text-bg-light border" x-text="activeProject.quality_preference ?? '-'"></span>
            </div>

            <div class="col-md-4">
              <p class="fw-semibold small mb-1">📍 Vendor Preference</p>
              <span class="badge text-bg-light border" x-text="activeProject.vendor_preference ?? '-'"></span>
            </div>

            <div class="col-md-4">
              <p class="fw-semibold small mb-1">⏱ Best Time to Contact</p>
              <span class="badge text-bg-light border" x-text="activeProject.best_time ?? '-'"></span>
            </div>



            
          </div>
        </div>

      
        <!-- Files Available -->
        <div class="mb-4">
          <h6 class="fw-bold text-dark mb-3 border-start border-3 ps-2" style="border-color:#2949E9;">Files Available</h6>
          <div class="row g-3">

            <!-- Architectural File -->
            <template x-if="activeProject.arch_files">
              <div class="col-md-4">
                <p class="fw-semibold small mb-1">🏗 Architectural Drawings</p>
                <template x-for="file in JSON.parse(activeProject.arch_files)">
                  <div class="d-flex align-items-center justify-content-between border rounded p-2 bg-light">
                    <span class="text-truncate small" x-text="file.split('/').pop()"></span>
                    <div class="btn-group btn-group-sm">
                      <a :href="'/storage/' + file" target="_blank" class="btn btn-outline-primary btn-sm">View</a>
                      <a :href="'/storage/' + file" :download="file.split('/').pop()" class="btn btn-outline-success btn-sm">Download</a>
                    </div>
                  </div>
                </template>
              </div>
            </template>

            <!-- Structural File -->
            <template x-if="activeProject.struct_files">
              <div class="col-md-4">
                <p class="fw-semibold small mb-1">🧱 Structural Drawings</p>
                <template x-for="file in JSON.parse(activeProject.struct_files)">
                  <div class="d-flex align-items-center justify-content-between border rounded p-2 bg-light">
                    <span class="text-truncate small" x-text="file.split('/').pop()"></span>
                    <div class="btn-group btn-group-sm">
                      <a :href="'/storage/' + file" target="_blank" class="btn btn-outline-primary btn-sm">View</a>
                      <a :href="'/storage/' + file" :download="file.split('/').pop()" class="btn btn-outline-success btn-sm">Download</a>
                    </div>
                  </div>
                </template>
              </div>
            </template>

            <!-- BOQ File -->
            <template x-if="activeProject.boq_file">
              <div class="col-md-4">
                <p class="fw-semibold small mb-1">📊 BOQ File</p>
                <div class="d-flex align-items-center justify-content-between border rounded p-2 bg-light">
                  <span class="text-truncate small" x-text="activeProject.boq_file.split('/').pop()"></span>
                  <div class="btn-group btn-group-sm">
                    <a :href="'/storage/' + activeProject.boq_file" target="_blank" class="btn btn-outline-primary btn-sm">View</a>
                    <a :href="'/storage/' + activeProject.boq_file" :download="activeProject.boq_file.split('/').pop()" class="btn btn-outline-success btn-sm">Download</a>
                  </div>
                </div>
              </div>
            </template>

            <!-- No Files -->
            <template x-if="!activeProject.arch_files && !activeProject.struct_files && !activeProject.boq_file">
              <div class="col-12">
                <p class="text-muted small">No files uploaded for this project.</p>
              </div>
            </template>

          </div>
        </div>


        <!-- Engineer Action -->
        <div class="border-top pt-4 mt-4">
          <h6 class="fw-bold mb-3 text-dark">🧰 Engineer Action</h6>

          <!-- Hidden project_id -->
          <input type="hidden" x-ref="projectId" :value="activeProject.project_id">

          

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

  <!-- Expiry Update Modal -->
<div x-show="showExpiryModal"
     class="ck-backdrop"
     x-transition>
    <div class="bg-white p-4 rounded shadow" style="width:350px;">
        <h5 class="mb-2">Update Expiry Date</h5>

        <label class="form-label">Select New Date</label>
        <input type="date" class="form-control mb-3" x-model="newDate">

        <div class="text-end">
            <button class="btn btn-secondary btn-sm" 
                    @click="showExpiryModal=false">
                Cancel
            </button>

            <button class="btn btn-primary btn-sm"
                    @click="submitExpiryUpdate">
                Update
            </button>
        </div>
    </div>
</div>

</div>

{{-- Scripts --}}
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function openExpiryModal(id, oldDate) {
        this.updateProjectId = id;
        this.newDate = oldDate;
        this.showExpiryModal = true;
    }

    function submitExpiryUpdate() {
        fetch('/update-expiry-date', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                project_id: this.updateProjectId,
                expiry_date: this.newDate
            })
        })
        .then(() => {
            alert("Expiry date updated!");
            location.reload();
        });
    }
</script>

@endsection
