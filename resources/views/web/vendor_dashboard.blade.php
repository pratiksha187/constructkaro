@extends('layouts.vendor_dash.app')

@section('title', 'Join as Service Provider | ConstructKaro')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
  :root {
    --blue-600: #2563eb;
    --green-100: #dcfce7;
    --green-600: #16a34a;
    --gray-100: #f1f5f9;
    --gray-700: #334155;
    --gray-900: #0f172a;
    --red-600: #dc2626;
  }

  .nav-tabs { border-bottom: 1px solid #e5e7eb; }
  .nav-link { font-weight: 500; color: #6b7280; }
  .nav-link.active { color: #2563eb !important; border-bottom: 3px solid #2563eb !important; }

  /* Banner */
  .banner {
    background: linear-gradient(90deg, #2563eb, #9333ea);
    color: white;
    padding: 20px;
    border-radius: 12px;
    margin: 20px 0;
    text-align: center;
  }

  /* Tender cards */
  .bid-card {
    background: #fff;
    border-radius: 12px;
    padding: 1.5rem;
    width: 100%;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    border: 1px solid #e2e8f0;
  }
  .status-badge {
    background-color: var(--green-100);
    color: var(--green-600);
    font-weight: 600;
    font-size: 0.85rem;
    padding: 4px 10px;
    border-radius: 9999px;
  }
  .project-id { font-size: 0.85rem; color: #64748b; }
  .project-title { font-size: 1.2rem; font-weight: bold; margin-bottom: 0.75rem; color: var(--gray-900); }
  .detail-item { display: flex; align-items: center; margin-bottom: 0.5rem; color: var(--gray-700); font-size: 0.95rem; }
  .detail-item span { margin-left: 0.5rem; }
  .deadline { color: var(--red-600); font-weight: 500; }
  .place-bid-btn {
    background-color: var(--blue-600);
    color: white;
    padding: 0.75rem 1rem;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    width: 100%;
    margin-top: 1rem;
    cursor: pointer;
    transition: background 0.2s ease;
  }
  .place-bid-btn:hover { background-color: #1d4ed8; }
  .emoji { font-size: 1.1rem; }

  /* Table */
  table {
    width: 100%;
    border-collapse: collapse;
    background-color: #fff;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    border-radius: 8px;
    overflow: hidden;
  }
  thead { background-color: #f1f5f9; }
  th, td { padding: 1rem; text-align: left; font-size: 0.95rem; }
  tbody tr:nth-child(even) { background-color: #f9fafb; }
  tbody tr:hover { background-color: #f0f9ff; }
  .status-selected { background-color: #dcfce7; color: #15803d; }
  .status-pending { background-color: #fef9c3; color: #92400e; }
  .status-rejected { background-color: #fee2e2; color: #b91c1c; }
</style>

<div class="container">


<!-- <input type="text" name="data" value="{ session('data') }}">
<input type="text" name="vendor_id" value="{{ session('vendor_id') }}"> -->

  <!-- Tabs -->
  <ul class="nav nav-tabs" id="dashboardTabs" role="tablist">
    <li class="nav-item"><a class="nav-link active" id="tenders-tab" data-bs-toggle="tab" href="#tenders" role="tab">Available Tenders</a></li>
    <li class="nav-item"><a class="nav-link" id="bids-tab" data-bs-toggle="tab" href="#bids" role="tab">My Bids</a></li>
    <li class="nav-item"><a class="nav-link" id="projects-tab" data-bs-toggle="tab" href="#projects" role="tab">Active Projects</a></li>
    <li class="nav-item"><a class="nav-link" id="payments-tab" data-bs-toggle="tab" href="#payments" role="tab">Payments</a></li>
  </ul>

  <!-- Banner -->
  <div class="banner">
    <h5>Get steady projects without chasing clients</h5>
    <p class="mb-0">ConstructKaro brings tenders to you. You execute, we handle billing, payments, and client management.</p>
  </div>

  <!-- Tab Contents -->
  <div class="tab-content mt-4">

    <!-- Available Tenders -->
    <div class="tab-pane fade show active" id="tenders" role="tabpanel">
      <h5>Available Tenders</h5>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="bid-card">
            <div class="card-header d-flex justify-content-between">
              <div class="status-badge">Open for Bids</div>
              <div class="project-id">ID: T-2024-001</div>
            </div>
            <div class="project-title">2,500 sq.ft. Bungalow Construction</div>
            <div class="detail-item"><span class="emoji">📍</span><span>Raigad, Maharashtra</span></div>
            <div class="detail-item"><span class="emoji">💰</span><span>₹1.2 Cr – ₹1.5 Cr</span></div>
            <div class="detail-item"><span class="emoji">⏱️</span><span>12 months timeline</span></div>
            <div class="detail-item"><span class="emoji">📅</span><span class="deadline">Deadline: 25th Sept 2025</span></div>
            <button class="place-bid-btn">Place Bid</button>
          </div>
        </div>
        <div class="col-md-4">
          <div class="bid-card">
            <div class="card-header d-flex justify-content-between">
              <div class="status-badge">Open for Bids</div>
              <div class="project-id">ID: T-2024-002</div>
            </div>
            <div class="project-title">Commercial Complex - Phase 1</div>
            <div class="detail-item"><span class="emoji">📍</span><span>Navi Mumbai</span></div>
            <div class="detail-item"><span class="emoji">💰</span><span>₹2.8 Cr – ₹3.2 Cr</span></div>
            <div class="detail-item"><span class="emoji">⏱️</span><span>18 months timeline</span></div>
            <div class="detail-item"><span class="emoji">📅</span><span class="deadline">Deadline: 30th Sept 2025</span></div>
            <button class="place-bid-btn">Place Bid</button>
          </div>
        </div>
        <div class="col-md-4">
          <div class="bid-card">
            <div class="card-header d-flex justify-content-between">
              <div class="badge bg-warning text-dark">Closing Soon</div>
              <div class="project-id">ID: T-2024-003</div>
            </div>
            <div class="project-title">Residential Apartment Block</div>
            <div class="detail-item"><span class="emoji">📍</span><span>Pune, Maharashtra</span></div>
            <div class="detail-item"><span class="emoji">💰</span><span>₹4.5 Cr – ₹5.0 Cr</span></div>
            <div class="detail-item"><span class="emoji">⏱️</span><span>24 months timeline</span></div>
            <div class="detail-item"><span class="emoji">📅</span><span class="deadline">Deadline: 20th Sept 2025</span></div>
            <button class="place-bid-btn btn btn-warning">Place Bid (Urgent)</button>
          </div>
        </div>
      </div>
    </div>

    <!-- My Bids -->
    <div class="tab-pane fade" id="bids" role="tabpanel">
      <h5>My Bids Status</h5>
      <table class="table align-middle">
        <thead>
          <tr>
            <th>Project</th><th>Bid Amount</th><th>Timeline</th><th>Status</th><th>Submitted</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Villa Construction<br><small class="text-muted">ID: T-2024-005</small></td>
            <td>₹1.35 Cr</td><td>11 months</td>
            <td><span class="badge status-selected">Selected ✓</span></td>
            <td>15 Sept 2025</td>
          </tr>
          <tr>
            <td>Office Building<br><small class="text-muted">ID: T-2024-004</small></td>
            <td>₹2.95 Cr</td><td>16 months</td>
            <td><span class="badge status-pending">Under Evaluation</span></td>
            <td>12 Sept 2025</td>
          </tr>
          <tr>
            <td>Warehouse Complex<br><small class="text-muted">ID: T-2024-003</small></td>
            <td>₹1.85 Cr</td><td>14 months</td>
            <td><span class="badge status-rejected">Not Selected</span></td>
            <td>10 Sept 2025</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Active Projects -->
    <div class="tab-pane fade" id="projects" role="tabpanel">
      <h5 class="mb-4">🚧 Active Projects</h5>
      <div class="card shadow-sm project-card mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between">
          <h6 class="mb-0">🏗️ Villa Construction Project</h6>
          <small>Project ID: <b>C102</b> | Contract: <b>₹1.35 Cr</b></small>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <h6 class="text-secondary">👤 Customer Details</h6>
              <ul class="list-unstyled mb-3">
                <li><b>Name:</b> Rajesh Kumar</li>
                <li><b>Contact:</b> +91 98765 43210</li>
                <li><b>Address:</b> Plot 45, Green Valley, Raigad</li>
              </ul>
              <button class="btn btn-outline-primary btn-sm me-2">💬 Message</button>
              <button class="btn btn-outline-success btn-sm">📄 Upload Invoice</button>
            </div>
            <div class="col-md-6">
              <h6 class="text-secondary">📈 Project Progress</h6>
              <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between">
                  Foundation <span class="badge bg-success">✓ Completed</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                  Structure <span class="badge bg-warning text-dark">In Progress</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                  Finishing <span class="badge bg-secondary">Pending</span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Payments -->
    <div class="tab-pane fade" id="payments" role="tabpanel">
      <h5 class="mb-4">💳 Billing & Payments</h5>
      <div class="row g-4 mb-4">
        <div class="col-md-4">
          <div class="card text-white bg-success h-100 shadow-sm">
            <div class="card-body text-center">
              <h4 class="card-title">₹85.2 L</h4>
              <p class="card-text mb-0">Total Earnings</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-white bg-warning h-100 shadow-sm">
            <div class="card-body text-center">
              <h4 class="card-title">₹12.5 L</h4>
              <p class="card-text mb-0">Pending Payments</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-white bg-info h-100 shadow-sm">
            <div class="card-body text-center">
              <h4 class="card-title">6%</h4>
              <p class="card-text mb-0">ConstructKaro Fee</p>
            </div>
          </div>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered align-middle shadow-sm">
          <thead class="table-light">
            <tr><th>Invoice</th><th>Project</th><th>Amount</th><th>Status</th><th>Date</th></tr>
          </thead>
          <tbody>
            <tr>
              <td><strong>INV-001</strong></td>
              <td>Villa Construction - Milestone 2</td>
              <td>₹25.0 L</td>
              <td><span class="badge bg-success">✓ Payment Released</span></td>
              <td>18 Sept 2025</td>
            </tr>
            <tr>
              <td><strong>INV-002</strong></td>
              <td>Villa Construction - Milestone 3</td>
              <td>₹30.0 L</td>
              <td><span class="badge bg-warning text-dark">⏳ Pending Verification</span></td>
              <td>20 Sept 2025</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@endsection
