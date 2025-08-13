@extends('layouts.admin')
@section('title','Dashboard')

@section('content')
  <div class="row g-4 mb-2">
    <div class="col-12 col-sm-6 col-xl-3">
      <div class="kpi-card">
        <div class="kpi-title">Total Projects</div>
        <div class="d-flex align-items-baseline justify-content-between mt-2">
          <div class="kpi-value">6</div>
          <span class="kpi-trend">+12%</span>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
      <div class="kpi-card">
        <div class="kpi-title">Total Vendors</div>
        <div class="d-flex align-items-baseline justify-content-between mt-2">
          <div class="kpi-value">30</div>
          <span class="kpi-trend text-success">+5</span>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
      <div class="kpi-card">
        <div class="kpi-title">Active Bids</div>
        <div class="d-flex align-items-baseline justify-content-between mt-2">
          <div class="kpi-value">18</div>
          <span class="badge badge-soft rounded-pill">Open</span>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
      <div class="kpi-card">
        <div class="kpi-title">Conversion Rate</div>
        <div class="d-flex align-items-baseline justify-content-between mt-2">
          <div class="kpi-value">98.5%</div>
          <span class="badge badge-dim rounded-pill">YTD</span>
        </div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
      <h5 class="mb-0">Recent Projects</h5>
      <div class="d-flex gap-2">
        <button class="btn btn-outline-primary btn-sm">Export</button>
       
      </div>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th>Project</th><th>Budget</th><th>Timeline</th><th>Status</th><th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <div class="fw-semibold">Residential Tower – Andheri</div>
                <div class="text-muted small">Architecture & Construction</div>
              </td>
              <td>₹ 1.2 Cr</td>
              <td>6 months</td>
              <td><span class="badge badge-soft rounded-pill">Bidding</span></td>
              <td class="text-end">
                <button class="btn btn-sm btn-outline-primary">View</button>
                <button class="btn btn-sm btn-primary">Assign</button>
              </td>
            </tr>
            <!-- more rows... -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
