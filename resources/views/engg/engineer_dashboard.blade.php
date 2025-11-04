@extends('layouts.engineer.app')
@section('title','Dashboard')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
  :root{
    --ck-orange:#FF6600;
    --ck-navy:#0B2240;
    --ck-blue:#2949E9;
    --ck-bg:#F5F7FB;
    --ck-card:#FFFFFF;
    --ck-muted:#6B7A90;
    --ck-success:#16a34a;
    --ck-warning:#f59e0b;
  }

  /* Page backdrop */
  body{
    background:
      radial-gradient(1200px 800px at 10% -10%, #eef3ff 0%, rgba(238,243,255,0) 60%),
      radial-gradient(1200px 800px at 110% 10%, #fef3e9 0%, rgba(254,243,233,0) 60%),
      var(--ck-bg);
  }

  /* Cards */
  .card{
    border:1px solid #e9eef7;
    border-radius:1rem;
    box-shadow:0 10px 28px rgba(12,33,72,.06);
    overflow:hidden;
    background:var(--ck-card);
  }
  .card-header{
    background:linear-gradient(180deg,rgba(255,102,0,.05),rgba(41,73,233,.05));
    border-bottom:1px solid #e9eef7;
  }
  .hover-lift{transition:transform .2s ease, box-shadow .2s ease}
  .hover-lift:hover{transform:translateY(-3px); box-shadow:0 14px 34px rgba(12,33,72,.12)}

  /* Buttons */
  .btn-primary{
    --bs-btn-bg:var(--ck-orange);
    --bs-btn-border-color:var(--ck-orange);
    --bs-btn-hover-bg:#e65c00;
    --bs-btn-hover-border-color:#e65c00;
    --bs-btn-active-bg:#cc5200;
    --bs-btn-active-border-color:#cc5200;
  }
  .btn-outline-primary{
    --bs-btn-color:var(--ck-orange);
    --bs-btn-border-color:var(--ck-orange);
    --bs-btn-hover-bg:rgba(255,102,0,.08);
    --bs-btn-hover-color:var(--ck-orange);
    --bs-btn-active-bg:rgba(255,102,0,.14);
  }
  .btn-icon{width:38px;height:38px;display:inline-grid;place-items:center;border-radius:.75rem}

  /* KPI tiles */
  .kpi{position:relative; overflow:hidden; background:var(--ck-card)}
  .kpi::before{
    content:""; position:absolute; inset:-60% -60% auto; height:150%;
    background:conic-gradient(from 180deg at 50% 0%, rgba(255,102,0,.15), rgba(41,73,233,.18), rgba(255,102,0,.15));
    filter:blur(42px); opacity:.35;
  }
  .kpi .value{font-size:2rem;font-weight:800;color:var(--ck-navy);line-height:1}
  .kpi .label{color:var(--ck-muted);font-weight:600}
  .kpi .chip{font-size:.8rem;font-weight:700;color:var(--ck-blue)}
  .kpi-icon{
    width:42px;height:42px;border-radius:12px;display:grid;place-items:center;flex:0 0 auto;
    background:linear-gradient(135deg, rgba(41,73,233,.12), rgba(255,102,0,.12));
    color:var(--ck-blue);
    border:1px solid #e9eef7;
  }

  /* Badges & status dots */
  .badge-soft { background:rgba(41,73,233,.12); color:var(--ck-blue); border:1px solid rgba(41,73,233,.22) }
  .badge-dim  { background:rgba(11,34,64,.08); color:var(--ck-navy); border:1px solid rgba(11,34,64,.18) }
  .status-dot{width:.55rem;height:.55rem;border-radius:999px;display:inline-block;margin-right:.4rem;vertical-align:middle}
  .dot-success{background:var(--ck-success)}
  .dot-warning{background:var(--ck-warning)}
  .dot-muted{background:#9aa7bd}

  /* Progress */
  .progress{height:8px;border-radius:10px;background:#eef2f8}
  .progress-bar{background:var(--ck-blue); animation:progressPulse 2s ease-in-out infinite}
  @keyframes progressPulse{
    0%,100%{filter:brightness(1)}
    50%{filter:brightness(1.15)}
  }

  /* Table */
  .table-modern thead th{
    font-weight:700;color:#3a4861;border-bottom:1px solid #e9eef7;background:#f9fbff;position:sticky;top:0;z-index:1
  }
  .table-modern tbody tr{transition:background .15s ease}
  .table-modern tbody tr:hover{background:rgba(41,73,233,.03)}

  /* Utilities */
  .text-muted-2{color:var(--ck-muted)}
  .soft-divider{height:1px;background:linear-gradient(90deg,transparent,#e9eef7,transparent)}
</style>
@endpush

@section('content')
<div class="container-fluid px-4 pb-5">

  {{-- Heading + actions --}}
  <div class="d-flex flex-wrap justify-content-between align-items-center mt-3 mb-3 gap-2">
    <div>
      <h3 class="mb-1">Engineer Dashboard</h3>
      <div class="text-muted-2 small">Welcome back • {{ now()->format('D, d M Y') }}</div>
    </div>
    <div class="d-flex gap-2">
     
      <a href="{{route('NewProjectBoq')}}" class="btn btn-outline-primary hover-lift">
        <i class="bi bi-table me-1"></i> BOQ
      </a>
    </div>
  </div>

  {{-- KPIs --}}
  <div class="row g-4">
    <div class="col-12 col-sm-6 col-xl-3">
      <div class="card kpi p-3 hover-lift">
        <div class="d-flex justify-content-between align-items-start">
          <div class="d-flex gap-3">
            <div class="kpi-icon"><i class="bi bi-diagram-3"></i></div>
            <div>
              <div class="value">{{ $stats['assigned_projects'] }}</div>
              <div class="label mt-1">Total Projects</div>
            </div>
          </div>
          <span class="chip"><i class="bi bi-clipboard-check me-1"></i>{{ $stats['assigned_delta'] ?? '+2' }}</span>
        </div>
      </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
      <div class="card kpi p-3 hover-lift">
        <div class="d-flex justify-content-between align-items-start">
          <div class="d-flex gap-3">
            <div class="kpi-icon"><i class="bi bi-briefcase"></i></div>
            <div>
              <div class="value">{{ $stats['active_tenders'] ?? 3 }}</div>
              <div class="label mt-1">Active Tenders</div>
            </div>
          </div>
          <span class="chip"><i class="bi bi-activity me-1"></i>{{ $stats['tenders_delta'] ?? '⚡' }}</span>
        </div>
      </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
      <div class="card kpi p-3 hover-lift">
        <div class="d-flex justify-content-between align-items-start">
          <div class="d-flex gap-3">
            <div class="kpi-icon"><i class="bi bi-list-check"></i></div>
            <div>
              <div class="value">{{ $stats['pending_boqs']}}</div>
              <div class="label mt-1">BOQs Pending</div>
            </div>
          </div>
          <span class="chip"><i class="bi bi-hourglass-split me-1"></i>Due</span>
        </div>
      </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
      <div class="card kpi p-3 hover-lift">
        <div class="d-flex justify-content-between align-items-start">
          <div class="d-flex gap-3">
            <div class="kpi-icon"><i class="bi bi-calendar-week"></i></div>
            <div>
              <div class="value">{{ $stats['deadlines_this_week'] }}</div>
              <div class="label mt-1">Deadlines this week</div>
            </div>
          </div>
          <span class="chip"><i class="bi bi-lightning-charge me-1"></i>Focus</span>
        </div>
      </div>
    </div>
  </div>

  {{-- Main grid --}}
  <div class="row g-4 mt-1">
    {{-- Recent projects --}}
    <div class="col-12 col-xl-8">
      <div class="card hover-lift">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Recent Projects</h5>
          <div class="d-flex gap-2">
           
          </div>
        </div>

      
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-modern align-middle mb-0">
              <thead>
                <tr>
                  <th>Project</th>
                  <th>Client</th>
                  <th>Budget</th>
                  <th>Timeline</th>
               
                </tr>
              </thead>
              <tbody>
                @forelse($projects as $p)
                  <tr>
                    <!-- 🔹 Project Name & Location -->
                    <td class="fw-semibold">
                      {{ $p->project_name ?? 'N/A' }}
                      <div class="text-muted small">{{ $p->project_location  }}</div>
                    </td>

                    <!-- 🔹 Client Details -->
                    <td>
                      <div class="fw-semibold">{{ $p->full_name}}</div>
                      <div class="text-muted small">{{ $p->phone_number }}</div>
                    </td>

                    <!-- 🔹 Budget -->
                    <td>
                     {{ $p->budget_range_name }}
                    </td>

                    <!-- 🔹 Timeline -->
                    <td>
                      {{ $p->timeline }}
                    </td>

                   

                  </tr>
                @empty
                  <tr>
                    <td colspan="6" class="text-center text-muted py-5">
                      <div class="mb-2"><i class="bi bi-inboxes"></i></div>
                      No recent projects.
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <!-- Pagination -->
          <div class="mt-3 px-3">
            {{ $projects->links() }}
          </div>
        </div>


      </div>
    </div>

    {{-- Right column --}}
    <div class="col-12 col-xl-4">
      <div class="card mb-4 hover-lift">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h6 class="mb-0">My Tasks</h6>
          <span class="text-muted-2 small"><i class="bi bi-clock-history me-1"></i>Auto-updates</span>
        </div>
        <div class="card-body">
          @php
            $tasks = $tasks ?? [
              ['title'=>'Prepare BOQ – Retail Fit-Out','pct'=>0],
              ['title'=>'Upload EMD receipt – Smart Security','pct'=>0],
              ['title'=>'Finalize vendor cost – Tower A','pct'=>0],
            ];
          @endphp
          @foreach($tasks as $t)
            <div class="mb-3">
              <div class="d-flex justify-content-between">
                <div class="fw-semibold">{{ $t['title'] }}</div>
                
              </div>
              <div class="progress mt-2">
                <div class="progress-bar" role="progressbar" style="width: {{ $t['pct'] }}%" aria-valuenow="{{ $t['pct'] }}" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
          @endforeach
          <div class="soft-divider my-3"></div>
          
        </div>
      </div>


    </div>
  </div>

</div>
@endsection

@push('scripts')
<script>
  // Enable Bootstrap tooltips if available
  window.addEventListener('DOMContentLoaded', () => {
    if (window.bootstrap) {
      const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
      tooltipTriggerList.map(el => new bootstrap.Tooltip(el))
    }
  })
</script>
@endpush
