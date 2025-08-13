{{-- resources/views/engineer/dashboard.blade.php --}}
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
  }
  body{ background: radial-gradient(1200px 800px at 10% -10%, #eef3ff 0%, rgba(238,243,255,0) 60%),
                    radial-gradient(1200px 800px at 110% 10%, #fef3e9 0%, rgba(254,243,233,0) 60%),
                    var(--ck-bg); }

  .card{ border:1px solid #e9eef7; border-radius:1rem; box-shadow:0 8px 24px rgba(12,33,72,.06); }
  .card-header{ background:linear-gradient(180deg,rgba(255,102,0,.06),rgba(41,73,233,.06)); border-bottom:1px solid #e9eef7; }
  .kpi{ position:relative; overflow:hidden; background:var(--ck-card); }
  .kpi::before{ content:""; position:absolute; inset:-60% -60% auto; height:150%;
    background:conic-gradient(from 180deg at 50% 0%, rgba(255,102,0,.15), rgba(41,73,233,.15), rgba(255,102,0,.15));
    filter:blur(40px); opacity:.35; }
  .kpi .value{ font-size:2rem; font-weight:800; color:var(--ck-navy); line-height:1; }
  .kpi .label{ color:#6B7A90; font-weight:600; }
  .kpi .chip{ font-size:.8rem; font-weight:600; color:var(--ck-blue); }

  .btn-primary{ --bs-btn-bg:var(--ck-orange); --bs-btn-border-color:var(--ck-orange);
                --bs-btn-hover-bg:#e65c00; --bs-btn-hover-border-color:#e65c00; }
  .btn-outline-primary{ --bs-btn-color:var(--ck-orange); --bs-btn-border-color:var(--ck-orange); }

  .table > :not(caption) > * > * { padding:.9rem .75rem; }
  .badge-soft { background:rgba(41,73,233,.12); color:var(--ck-blue); }
  .badge-dim  { background:rgba(11,34,64,.08); color:var(--ck-navy); }
  .progress{ height:8px; border-radius:10px; background:#eef2f8; }
  .progress-bar{ background:var(--ck-blue); }
  .quick-action .bi{ font-size:1.1rem; }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 pb-5">

  {{-- Heading + actions --}}
  <div class="d-flex flex-wrap justify-content-between align-items-center mt-3 mb-3 gap-2">
    <h3 class="mb-0">Engineer Dashboard</h3>
    <div class="d-flex gap-2">
      <a href="" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> New Project
      </a>
      <a href="" class="btn btn-outline-primary">
        <i class="bi bi-table me-1"></i> BOQ
      </a>
    </div>
  </div>

  {{-- KPIs --}}
  <div class="row g-4">
    <div class="col-12 col-sm-6 col-xl-3">
      <div class="card kpi p-3">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="value">{{ $stats['assigned_projects'] ?? 6 }}</div>
            <div class="label mt-1">Assigned Projects</div>
          </div>
          <span class="chip"><i class="bi bi-clipboard-check me-1"></i>{{ $stats['assigned_delta'] ?? '+2' }}</span>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
      <div class="card kpi p-3">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="value">{{ $stats['active_tenders'] ?? 3 }}</div>
            <div class="label mt-1">Active Tenders</div>
          </div>
          <span class="chip"><i class="bi bi-activity me-1"></i>{{ $stats['tenders_delta'] ?? '⚡' }}</span>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
      <div class="card kpi p-3">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="value">{{ $stats['pending_boqs'] ?? 4 }}</div>
            <div class="label mt-1">BOQs Pending</div>
          </div>
          <span class="chip"><i class="bi bi-hourglass-split me-1"></i>Due</span>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
      <div class="card kpi p-3">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="value">{{ $stats['deadlines_this_week'] ?? 2 }}</div>
            <div class="label mt-1">Deadlines this week</div>
          </div>
          <span class="chip"><i class="bi bi-calendar-week me-1"></i>Focus</span>
        </div>
      </div>
    </div>
  </div>

  {{-- Main grid --}}
  <div class="row g-4 mt-1">
    {{-- Recent projects --}}
    <div class="col-12 col-xl-8">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Recent Projects</h5>
          <div class="d-flex gap-2">
            <a class="btn btn-outline-primary btn-sm" href="">
              <i class="bi bi-grid-3x3-gap me-1"></i>All Projects
            </a>
            <a class="btn btn-primary btn-sm" href="">
              <i class="bi bi-upload me-1"></i>Upload Tender
            </a>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th>Project</th>
                  <th>Client</th>
                  <th>Budget</th>
                  <th>Timeline</th>
                  <th>Status</th>
                  <th class="text-end">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse(($projects ?? []) as $p)
                  <tr>
                    <td class="fw-semibold">{{ $p->name }}</td>
                    <td class="text-muted small">{{ $p->client ?? '—' }}</td>
                    <td>₹ {{ number_format($p->budget ?? 0) }}</td>
                    <td>{{ $p->timeline ?? '—' }}</td>
                    <td>
                      @php $status = strtolower($p->status ?? 'queued'); @endphp
                      @if($status === 'in progress')
                        <span class="badge bg-success-subtle text-success border border-success-subtle">In Progress</span>
                      @elseif($status === 'bidding')
                        <span class="badge badge-soft rounded-pill">Bidding</span>
                      @else
                        <span class="badge badge-dim rounded-pill">Queued</span>
                      @endif
                    </td>
                    <td class="text-end">
                      <a href="" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-eye"></i>
                      </a>
                      <a href="" class="btn btn-sm btn-primary">
                        <i class="bi bi-pencil-square"></i>
                      </a>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6" class="text-center text-muted py-4">No recent projects.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    {{-- Right column: tasks & quick actions --}}
    <div class="col-12 col-xl-4">
      <div class="card mb-4">
        <div class="card-header">
          <h6 class="mb-0">My Tasks</h6>
        </div>
        <div class="card-body">
          @php
            $tasks = $tasks ?? [
              ['title'=>'Prepare BOQ – Retail Fit-Out','pct'=>70,'due'=>'Thu'],
              ['title'=>'Upload EMD receipt – Smart Security','pct'=>35,'due'=>'Today'],
              ['title'=>'Finalize vendor cost – Tower A','pct'=>55,'due'=>'Mon'],
            ];
          @endphp
          @foreach($tasks as $t)
            <div class="mb-3">
              <div class="d-flex justify-content-between">
                <div class="fw-semibold">{{ $t['title'] }}</div>
                <span class="text-muted small">Due: {{ $t['due'] }}</span>
              </div>
              <div class="progress mt-2">
                <div class="progress-bar" role="progressbar" style="width: {{ $t['pct'] }}%" aria-valuenow="{{ $t['pct'] }}" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
          @endforeach
          <a href="" class="small">View all tasks</a>
        </div>
      </div>

      <div class="card">
        <div class="card-header">
          <h6 class="mb-0">Quick Actions</h6>
        </div>
        <div class="card-body">
          <div class="d-grid gap-2">
            <a href="" class="btn btn-outline-primary quick-action">
              <i class="bi bi-file-earmark-arrow-up me-1"></i> Upload Tender Docs
            </a>
            <a href="" class="btn btn-outline-primary quick-action">
              <i class="bi bi-plus-square-dotted me-1"></i> Create BOQ
            </a>
            <a href="" class="btn btn-outline-primary quick-action">
              <i class="bi bi-folder2-open me-1"></i> My Documents
            </a>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection
