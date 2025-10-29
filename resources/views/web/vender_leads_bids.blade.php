@extends('layouts.vender.app')
@section('title', 'Vendor Dashboard | ConstructKaro')
@section('content')

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
  .card {
    border-radius: 12px;
    border: none;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
  }

  .table th {
    color: #475569;
    font-weight: 600;
    background: #f9fafb;
  }

  .table td {
    vertical-align: middle;
  }

  .badge-status {
    font-size: 0.85rem;
    padding: 6px 12px;
    border-radius: 50px;
  }

  .badge-open {
    background-color: #d1fae5;
    color: #047857;
  }

  .badge-submitted {
    background-color: #fef3c7;
    color: #92400e;
  }

  .badge-won {
    background-color: #e0e7ff;
    color: #3730a3;
  }

  .btn-link {
    text-decoration: none;
    font-weight: 500;
  }

  .btn-link:hover {
    text-decoration: underline;
  }

  /* Modal */
  .modal-content {
    border-radius: 12px;
    border: none;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
  }

  .modal-header {
    border-bottom: none;
    background-color: #f8fafc;
  }

  .modal-body h6 {
    font-weight: 600;
    color: #1e293b;
  }

  .modal-body p {
    color: #475569;
    margin-bottom: 10px;
  }

  .modal-footer .btn {
    border-radius: 8px;
    padding: 8px 20px;
  }

  .btn-primary {
    background-color: #2563eb;
    border: none;
  }

  .btn-primary:hover {
    background-color: #1d4ed8;
  }

  .btn-light {
    background-color: #f1f5f9;
    color: #334155;
  }
</style>

<div class="container my-5">
  <div class="card p-4">
    <h4 class="mb-3 fw-bold">Available Leads & My Bids</h4>

    <table class="table align-middle">
      <thead>
        <tr>
          <th>PROJECT ID</th>
          <th>CUSTOMER TYPE</th>
          <th>LOCATION</th>
          <th>BUDGET RANGE</th>
          <th>STATUS</th>
          <th>ACTION</th>
        </tr>
      </thead>
      <tbody>
        <!-- <tr>
          <td><strong>#CST1001</strong></td>
          <td>Residential</td>
          <td>Navi Mumbai</td>
          <td>₹15L–₹25L</td>
          <td><span class="badge-status badge-open">Open</span></td>
          <td>
            <a href="#" class="btn-link text-primary" data-bs-toggle="modal" data-bs-target="#projectModal">
              🔍 View Details
            </a>
            <span class="text-success ms-2">📤 Submit Bid</span>
          </td>
        </tr> -->
        <!-- <tr>
          <td><strong>#CST1002</strong></td>
          <td>Commercial</td>
          <td>Pune</td>
          <td>₹50L–₹75L</td>
          <td><span class="badge-status badge-submitted">Bid Submitted</span></td>
          <td>
            <a href="#" class="btn-link text-primary" data-bs-toggle="modal" data-bs-target="#projectModal">
              🔍 View Details
            </a>
            <span class="text-muted ms-2">Awaiting Response</span>
          </td>
        </tr> -->
        <!-- <tr>
          <td><strong>#CST1003</strong></td>
          <td>Residential</td>
          <td>Thane</td>
          <td>₹30L–₹40L</td>
          <td><span class="badge-status badge-won">Won</span></td>
          <td>
            <a href="#" class="btn-link text-primary" data-bs-toggle="modal" data-bs-target="#projectModal">
              🔍 View Project
            </a>
          </td>
        </tr> -->
        <tr>
      <td colspan="6" class="text-center text-muted py-4">
        <i class="bi bi-clipboard-x fs-4 d-block mb-2"></i>
        <strong>No bids available right now.</strong>
      </td>
    </tr>
      </tbody>
    </table>
  </div>
</div>

<!-- Project Details Modal -->
<div class="modal fade" id="projectModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">Project Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body px-4">
        <h6>Residential Villa Construction</h6>
        <p class="text-muted mb-2">#CST1001 • Navi Mumbai</p>

        <h6>Budget Range</h6>
        <p class="text-success fw-semibold">₹15L–₹25L</p>

        <h6>Description</h6>
        <p>Complete construction of a 3BHK villa with modern amenities including swimming pool, garden, and parking space.</p>

        <h6>Scope of Work</h6>
        <p>Civil work, electrical, plumbing, interior design, landscaping</p>

        <h6>Timeline</h6>
        <p>6–8 months</p>

        <h6>Requirements</h6>
        <p>GST registered contractor with minimum 5 years experience</p>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Ask Query</button>
        <button type="button" class="btn btn-primary">Submit Bid</button>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> -->

@endsection
