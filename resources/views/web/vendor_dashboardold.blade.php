@extends('layouts.vendor_dash.app')

@section('title', 'Vendor Dashboard | ConstructKaro')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
  body {
    background: #f5f7fa;
    font-family: 'Segoe UI', sans-serif;
    color: #1c2c3e;
  }

  .main-card {
    margin: 80px auto 50px;
    max-width: 1500px;
    padding: 40px 30px;
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 10px 35px rgba(28, 44, 62, 0.12);
  }

  .dashboard-header {
    text-align: center;
    margin-bottom: 40px;
  }

  .dashboard-header h2 {
    font-size: 32px;
    font-weight: 700;
    background: linear-gradient(90deg, #f25c05, #1c2c3e);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }

  .dashboard-header p {
    color: #6b7280;
    font-size: 16px;
    margin-top: 8px;
  }

  /* Summary Cards */
  .summary-card {
    border-radius: 12px;
    padding: 25px 20px;
    box-shadow: 0 4px 15px rgba(28, 44, 62, 0.1);
    transition: transform 0.2s;
  }

  .summary-card:hover {
    transform: translateY(-5px);
  }

  .summary-card .icon {
    font-size: 28px;
    margin-bottom: 15px;
  }

  .summary-card h4 {
    font-size: 22px;
    font-weight: 600;
  }

  .summary-card p {
    font-size: 14px;
    color: #475569;
  }

  /* Tenders / Bids Cards */
  .bid-card, .project-card, .payment-card {
    border-radius: 12px;
    padding: 20px;
    background: #fff;
    box-shadow: 0 6px 20px rgba(28, 44, 62, 0.08);
    margin-bottom: 25px;
    transition: transform 0.2s;
  }

  .bid-card:hover, .project-card:hover, .payment-card:hover {
    transform: translateY(-5px);
  }

  .bid-card .status-badge {
    font-size: 0.85rem;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 9999px;
  }

  .project-title {
    font-size: 1.2rem;
    font-weight: 600;
    margin: 12px 0 10px;
  }

  .detail-item {
    display: flex;
    align-items: center;
    font-size: 0.95rem;
    color: #475569;
    margin-bottom: 5px;
  }

  .detail-item span:first-child {
    margin-right: 8px;
  }

  .place-bid-btn {
    width: 100%;
    padding: 10px 0;
    border-radius: 8px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: 0.2s;
  }

  .place-bid-btn:hover {
    transform: scale(1.03);
  }

  /* Tabs */
  .nav-tabs {
    border-bottom: 2px solid #e5e7eb;
    margin-bottom: 30px;
  }

  .nav-link {
    font-weight: 500;
    color: #6b7280;
    font-size: 0.95rem;
  }

  .nav-link.active {
    color: #f25c05 !important;
    border-bottom: 3px solid #f25c05 !important;
  }

  /* Tables */
  table {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(28,44,62,0.05);
  }

  thead {
    background-color: #f3f4f6;
  }

  th, td {
    padding: 12px 15px;
    font-size: 0.95rem;
  }

  tbody tr:hover {
    background-color: #f0f9ff;
  }

  .badge-status {
    padding: 4px 10px;
    border-radius: 9999px;
    font-size: 0.8rem;
    font-weight: 600;
  }

  .badge-success { background-color: #dcfce7; color: #16a34a; }
  .badge-warning { background-color: #fef3c7; color: #b45309; }
  .badge-danger { background-color: #fee2e2; color: #b91c1c; }

  .banner {
    background: linear-gradient(90deg,#f25c05,#1c2c3e);
    padding: 20px;
    border-radius: 12px;
    color: #fff;
    text-align: center;
    margin-bottom: 30px;
  }

  .banner h5 {
    font-weight: 600;
    font-size: 1.2rem;
  }

  .banner p {
    font-size: 0.95rem;
    margin: 5px 0 0;
  }
</style>

<div class="container main-card">

  <!-- Dashboard Header -->
  <div class="dashboard-header">
    <h2>Welcome, {{ $vendor->name }}</h2>
    <p>Here’s a summary of your tenders, bids, projects, and payments.</p>
  </div>

  <!-- Summary Cards -->
  <div class="row g-4 mb-4">
    <div class="col-md-3">
      <div class="summary-card text-center bg-light">
        <div class="icon text-primary"><i class="bi bi-file-earmark-text"></i></div>
        <h4>0</h4>
        <p>Available Tenders</p>
      </div>
    </div>
    <div class="col-md-3">
      <div class="summary-card text-center bg-light">
        <div class="icon text-success"><i class="bi bi-check-circle"></i></div>
        <h4>0</h4>
        <p>Bids Submitted</p>
      </div>
    </div>
    <div class="col-md-3">
      <div class="summary-card text-center bg-light">
        <div class="icon text-warning"><i class="bi bi-building"></i></div>
        <h4>0</h4>
        <p>Active Projects</p>
      </div>
    </div>
    <div class="col-md-3">
      <div class="summary-card text-center bg-light">
        <div class="icon text-danger"><i class="bi bi-currency-rupee"></i></div>
        <h4>₹0</h4>
        <p>Total Earnings</p>
      </div>
    </div>
  </div>

  <!-- Banner -->
  <div class="banner">
    <h5>Get steady projects without chasing clients</h5>
    <p>ConstructKaro brings tenders to you. Execute projects, and we handle billing, payments, and client management.</p>
  </div>

  <!-- Tabs -->
  <ul class="nav nav-tabs" id="dashboardTabs" role="tablist">
    <li class="nav-item"><a class="nav-link active" id="tenders-tab" data-bs-toggle="tab" href="#tenders" role="tab">Available Tenders</a></li>
    <li class="nav-item"><a class="nav-link" id="bids-tab" data-bs-toggle="tab" href="#bids" role="tab">My Bids</a></li>
    <li class="nav-item"><a class="nav-link" id="projects-tab" data-bs-toggle="tab" href="#projects" role="tab">Active Projects</a></li>
    <li class="nav-item"><a class="nav-link" id="payments-tab" data-bs-toggle="tab" href="#payments" role="tab">Payments</a></li>
  </ul>

  <div class="tab-content mt-4">

    <!-- Available Tenders -->
    <div class="tab-pane fade show active" id="tenders" role="tabpanel">
      <div class="row g-4">
        @for ($i = 1; $i <= 3; $i++)
        <div class="col-md-4">
          <div class="bid-card">
            <div class="d-flex justify-content-between mb-2">
              <span class="badge bg-success">Open</span>
              <span class="text-muted">ID: T-2024-00{{ $i }}</span>
            </div>
            <div class="project-title">Project {{ $i }} Construction</div>
            <div class="detail-item"><span>📍</span>Location City</div>
            <div class="detail-item"><span>💰</span>₹1.2 Cr – ₹1.5 Cr</div>
            <div class="detail-item"><span>⏱️</span>12 months</div>
            <div class="detail-item"><span>📅</span>Deadline: 25th Sept 2025</div>
            <button class="place-bid-btn bg-primary text-white">Place Bid</button>
          </div>
        </div>
        @endfor
      </div>
    </div>

    <!-- My Bids -->
    <div class="tab-pane fade" id="bids" role="tabpanel">
      <table class="table table-bordered align-middle">
        <thead class="table-light">
          <tr>
            <th>Project</th><th>Bid Amount</th><th>Timeline</th><th>Status</th><th>Submitted</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Villa Construction</td><td>₹1.35 Cr</td><td>11 months</td>
            <td><span class="badge badge-status badge-success">Selected</span></td>
            <td>15 Sept 2025</td>
          </tr>
          <tr>
            <td>Office Building</td><td>₹2.95 Cr</td><td>16 months</td>
            <td><span class="badge badge-status badge-warning">Under Evaluation</span></td>
            <td>12 Sept 2025</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Active Projects -->
    <div class="tab-pane fade" id="projects" role="tabpanel">
      <div class="project-card p-3">
        <div class="d-flex justify-content-between mb-2">
          <h6>Villa Construction Project</h6>
          <small>Project ID: C102 | ₹1.35 Cr</small>
        </div>
        <div class="row mt-2">
          <div class="col-md-6">
            <p>👤 Customer: Rajesh Kumar</p>
            <p>📞 +91 98765 43210</p>
            <p>🏠 Green Valley, Raigad</p>
            <button class="btn btn-outline-primary btn-sm me-2">💬 Message</button>
            <button class="btn btn-outline-success btn-sm">📄 Upload Invoice</button>
          </div>
          <div class="col-md-6">
            <h6>📈 Project Progress</h6>
            <ul class="list-group">
              <li class="list-group-item d-flex justify-content-between">Foundation <span class="badge bg-success">✓ Completed</span></li>
              <li class="list-group-item d-flex justify-content-between">Structure <span class="badge bg-warning text-dark">In Progress</span></li>
              <li class="list-group-item d-flex justify-content-between">Finishing <span class="badge bg-secondary">Pending</span></li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Payments -->
    <div class="tab-pane fade" id="payments" role="tabpanel">
      <div class="row g-4 mb-4">
        <div class="col-md-4">
          <div class="payment-card text-center bg-success text-white">
            <h4>₹0</h4>
            <p>Total Earnings</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="payment-card text-center bg-warning text-dark">
            <h4>₹0</h4>
            <p>Pending Payments</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="payment-card text-center bg-info text-white">
            <h4>0%</h4>
            <p>ConstructKaro Fee</p>
          </div>
        </div>
      </div>
      <table class="table table-bordered align-middle">
        <thead class="table-light">
          <tr><th>Invoice</th><th>Project</th><th>Amount</th><th>Status</th><th>Date</th></tr>
        </thead>
        <tbody>
          <tr>
            <td>INV-001</td>
            <td>Villa Construction - Milestone 2</td>
            <td>₹25.0 L</td>
            <td><span class="badge badge-status badge-success">Payment Released</span></td>
            <td>18 Sept 2025</td>
          </tr>
          <tr>
            <td>INV-002</td>
            <td>Villa Construction - Milestone 3</td>
            <td>₹30.0 L</td>
            <td><span class="badge badge-status badge-warning">Pending Verification</span></td>
            <td>20 Sept 2025</td>
          </tr>
        </tbody>
      </table>
    </div>

  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
