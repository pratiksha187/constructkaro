@extends('layouts.vender.app')
@section('title', 'Vendor Dashboard | ConstructKaro')
@section('content')
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ConstructKaro - Vendor Dashboard</title>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
     body {
      background-color: #f8f9fb;
      font-family: 'Inter', sans-serif;
    }
   .bg-primary {
    --bs-bg-opacity: 1;
    background-color: rgb(36 100 194) !important;
}
 .card {
      border: none;
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .rating {
      font-size: 2rem;
      color: #ffc107;
    }
    .review-box {
      background-color: #f8f9fa;
      border-radius: 10px;
      padding: 12px 16px;
      margin-top: 12px;
    }
    .notification-box {
      border-radius: 10px;
      padding: 14px 18px;
      margin-bottom: 15px;
    }
    .notification-box.blue {
      background-color: #eef5ff;
    }
    .notification-box.green {
      background-color: #e8f9ee;
    }
    .notification-box.yellow {
      background-color: #fffbe6;
    }
    .notification-title {
      font-weight: 600;
      font-size: 1rem;
    }
    .notification-time {
      color: #6c757d;
      font-size: 0.875rem;
    }
</style>
<div class="container py-4">
  <!-- Welcome Card -->
  <div class="card border-0 shadow-sm mb-4 rounded-3 overflow-hidden">
    <div class="card-body p-4 bg-primary text-white d-flex justify-content-between align-items-center flex-wrap">
      <div>
        <h5 class="fw-semibold mb-1">Welcome, {{$vendor->name}} 👋</h5>
        <span class="badge bg-success">
          <i class="bi bi-check-circle me-1"></i> Verified Vendor
        </span>
      </div>
      <div class="text-end">
        <p class="mb-1 text-light opacity-75 small">Vendor Code</p>
        <h6 class="mb-0 fw-semibold">{{$vendor->vendor_code}}</h6>
      </div>
    </div>
  </div>

  <!-- Quick Overview -->
  <div class="row g-3 mb-4">
    <div class="col-md-4">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-body d-flex align-items-center justify-content-between">
          <div>
            <h6 class="fw-semibold text-dark mb-1">View New Leads</h6>
            <p class="text-muted small mb-0">0 new opportunities</p>
          </div>
          <span class="text-primary fs-3"><i class="bi bi-binoculars"></i></span>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-body d-flex align-items-center justify-content-between">
          <div>
            <h6 class="fw-semibold text-dark mb-1">My Ongoing Projects</h6>
            <p class="text-muted small mb-0">0 active projects</p>
          </div>
          <span class="text-warning fs-3"><i class="bi bi-diagram-3"></i></span>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-body d-flex align-items-center justify-content-between">
          <div>
            <h6 class="fw-semibold text-dark mb-1">Payments Overview</h6>
            <p class="text-muted small mb-0">₹00 pending</p>
          </div>
          <span class="text-success fs-3"><i class="bi bi-wallet2"></i></span>
        </div>
      </div>
    </div>
  </div>

  <!-- Details Section -->
  <div class="row g-3">
    <!-- Active Bids -->
    <div class="col-md-4">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-body">
          <h6 class="fw-semibold mb-2">Active Bids</h6>
          <p class="text-muted small mb-2">This Month</p>
          <h4 class="fw-bold text-primary">0 bids</h4>
          <div class="mt-3 small">
            <div class="d-flex justify-content-between"><span>Won</span><span>5</span></div>
            <div class="progress mb-2" style="height: 5px;">
              <div class="progress-bar bg-success" style="width: 0%;"></div>
            </div>

            <div class="d-flex justify-content-between"><span>Pending</span><span>4</span></div>
            <div class="progress mb-2" style="height: 5px;">
              <div class="progress-bar bg-warning" style="width: 0%;"></div>
            </div>

            <div class="d-flex justify-content-between"><span>Lost</span><span>3</span></div>
            <div class="progress" style="height: 5px;">
              <div class="progress-bar bg-danger" style="width: %;"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Ongoing Projects -->
    <div class="col-md-4">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-body">
          <h6 class="fw-semibold mb-2">Ongoing Projects</h6>

          <div class="mb-3">
            <h6 class="mb-0 text-dark">Residential Villa</h6>
            <small class="text-muted">Navi Mumbai</small>
            <div class="progress mt-2" style="height: 6px;">
              <div class="progress-bar bg-primary" style="width: 0%;"></div>
            </div>
            <small class="text-muted">Progress 0%</small>
          </div>

          <div>
            <h6 class="mb-0 text-dark">Office Complex</h6>
            <small class="text-muted">Pune</small>
            <div class="progress mt-2" style="height: 6px;">
              <div class="progress-bar bg-warning" style="width: 0%;"></div>
            </div>
            <small class="text-muted">Progress 0%</small>
          </div>
        </div>
      </div>
    </div>

    <!-- Earnings Summary -->
    <div class="col-md-4">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-body">
          <h6 class="fw-semibold mb-2">Earnings Summary</h6>
          <h3 class="fw-bold text-success">₹0</h3>
          <p class="text-muted small">This Month</p>

          <div class="d-flex justify-content-between small text-muted mb-2">
            <span>Lifetime</span>
            <span class="fw-semibold text-dark">₹0</span>
          </div>
          <div class="d-flex justify-content-between small text-muted mb-3">
            <span>Upcoming</span>
            <span class="fw-semibold text-dark">₹0</span>
          </div>

          <!-- <div class="alert alert-success py-2 px-3 small mb-0">
            Next payout: <strong>Dec 15, 2025</strong>
          </div> -->
        </div>
      </div>
    </div>
  </div>
</div>
<div class="container my-5">
  <div class="row g-4">
    <!-- Customer Ratings -->
    <div class="col-md-5">
      <div class="card p-4">
        <h5 class="fw-semibold mb-3">Customer Ratings</h5>
        <div class="text-center mb-3">
          <span class="fw-bold rating">0</span>
          <span class=" fs-5">★★★★★</span>
          <p class="text-muted small mb-0">Based on 0 reviews</p>
        </div>
        <!-- <div class="review-box">
          <p class="mb-1 fw-semibold">"Excellent work quality!"</p>
          <p class="text-muted small mb-0">- Priya Sharma</p>
        </div>
        <div class="review-box">
          <p class="mb-1 fw-semibold">"On-time delivery"</p>
          <p class="text-muted small mb-0">- Amit Patel</p>
        </div> -->
      </div>
    </div>

    <!-- Recent Notifications -->
    <div class="col-md-7">
      <div class="card p-4">
        <h5 class="fw-semibold mb-3">Recent Notifications</h5>

        <div class="notification-box blue">
          <div class="notification-title">
            📥 New lead available
          </div>
          <!-- <div class="text-muted small">Residential project in Thane - ₹20L budget</div>
          <div class="notification-time mt-1">2 hours ago</div> -->
        </div>

        <div class="notification-box green">
          <div class="notification-title">
            ✅ Agreement signed
          </div>
          <!-- <div class="text-muted small">Villa project agreement has been digitally signed</div>
          <div class="notification-time mt-1">1 day ago</div> -->
        </div>

        <div class="notification-box yellow">
          <div class="notification-title">
            💰 Payment reminder
          </div>
          <!-- <div class="text-muted small">Milestone payment of ₹3.2L is due for review</div>
          <div class="notification-time mt-1">3 days ago</div> -->
        </div>
      </div>
    </div>
  </div>
</div>
@endsection