@extends('layouts.engineer.app')
@section('title', 'Bill Verification Dashboard')

@section('content')
<style>
  :root {
    --navy: #1c2c3e;
    --orange: #f25c05;
    --light-gray: #f8fafc;
  }

  /* Page Wrapper */
  body {
    background-color: var(--light-gray);
  }

  /* Header */
  .page-header h2 {
    color: var(--navy);
    font-weight: 700;
  }
  .page-header p {
    color: #6b7280;
  }

  /* Table Container */
  .bill-table {
    background: #fff;
    border-left: 4px solid var(--orange);
    border-radius: 1rem;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
    overflow: hidden;
  }

  /* Table */
  .table thead {
    background-color: var(--navy);
    color: #fff;
  }

  .table tbody tr:hover {
    background-color: #fff8f4;
  }

  .table th,
  .table td {
    vertical-align: middle !important;
  }

  /* Status Badges */
  .status-badge {
    border-radius: 9999px;
    padding: 0.35rem 0.75rem;
    font-size: 0.75rem;
    font-weight: 600;
  }

  .status-approved {
    background-color: #dcfce7;
    color: #065f46;
  }

  .status-revised {
    background-color: #fef9c3;
    color: #92400e;
  }

  .status-rejected {
    background-color: #fee2e2;
    color: #991b1b;
  }

  .status-pending {
    background-color: #f3f4f6;
    color: #4b5563;
  }

  /* Buttons */
  .btn-view {
    background-color: var(--navy);
    color: #fff;
    border: none;
    padding: 0.4rem 1rem;
    border-radius: 8px;
    font-size: 0.85rem;
    transition: all 0.3s ease;
  }

  .btn-view:hover {
    background-color: var(--orange);
    color: #fff;
    transform: translateY(-1px);
  }

  /* Empty State */
  .empty-row {
    text-align: center;
    color: #6b7280;
    font-size: 0.9rem;
    padding: 1rem;
  }
</style>

<div class="container-fluid py-6 px-4">

  <!-- Header -->
  <div class="page-header mb-6">
    <h2 class="text-2xl flex items-center gap-2">
      <i class="bi bi-file-earmark-text text-orange text-2xl"></i>
      Bill Verification Dashboard
    </h2>
    <p class="text-gray-500 text-sm">Review and approve customer monthly running bills</p>
  </div>

  <!-- Table Container -->
  <div class="bill-table p-3">
    <table class="table table-striped align-middle mb-0">
      <thead>
        <tr>
          <th>Project Name</th>
          <th>Customer</th>
          <th>Month</th>
          <th>Amount (₹)</th>
          <th>Status</th>
          <th class="text-center">Action</th>
        </tr>
      </thead>

      <tbody>
        @forelse($bills as $bill)
          <tr>
          
            <td>
              <strong>{{ $bill->project_name ?? 'N/A' }}</strong><br>
              <small class="text-muted">{{ $bill->project_description ?? '-' }}</small>
            </td>

           
            <td>
              <strong class="text-navy">{{ $bill->full_name ?? '-' }}</strong><br>
              <small class="text-muted">{{ $bill->phone_number ?? '' }}</small>
            </td>

           
            <td>
              @if($bill->bill_month)
                {{ \Carbon\Carbon::parse($bill->bill_month)->format('F Y') }}
              @else
                <span class="text-muted">Not Submitted</span>
              @endif
            </td>

           
            <td>
              @if($bill->amount)
                ₹{{ number_format($bill->amount, 2) }}
              @else
                <span class="text-muted">-</span>
              @endif
            </td>

           
            <td>
              @php
                $badgeClass = match($bill->status) {
                    'Approved' => 'status-badge status-approved',
                    'Revised'  => 'status-badge status-revised',
                    'Rejected' => 'status-badge status-rejected',
                    default    => 'status-badge status-pending',
                };
              @endphp
              <span class="{{ $badgeClass }}">{{ $bill->status ?? 'Pending' }}</span>
            </td>

            <td class="text-center">
              @if($bill->id)
                <button 
                  class="btn-view" 
                  data-id="{{ $bill->id }}" 
                  data-bs-toggle="modal" 
                  data-bs-target="#billModal">
                  View Details
                </button>
              @else
                <span class="text-muted">No Bill Yet</span>
              @endif
            </td>

          </tr>
        @empty
          <tr>
            <td colspan="6" class="empty-row">No bills found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-6">
    {{ $bills->links('pagination::bootstrap-5') }}
  </div>

</div>

<!-- ================= BILL DETAILS MODAL ================= -->
<div class="modal fade" id="billModal" tabindex="-1" aria-labelledby="billModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content rounded-3 shadow-lg border-0">
      <div class="modal-header bg-gray-100 border-0">
        <h5 class="modal-title fw-semibold text-navy" id="billModalLabel">Bill Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body p-4" id="billModalBody">
        <div class="text-center text-muted py-5">
          <div class="spinner-border text-orange" role="status"></div>
          <p class="mt-3">Loading bill details...</p>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    // When user clicks "View Details"
    $('.btn-view').on('click', function () {
        let billId = $(this).data('id');
        let modalBody = $('#billModalBody');
        modalBody.html(`
          <div class="text-center text-muted py-5">
            <div class="spinner-border text-orange" role="status"></div>
            <p class="mt-3">Loading bill details...</p>
          </div>
        `);

        // AJAX request to fetch bill data
        $.ajax({
            url: "{{ route('engineer.bill.show', '') }}/" + billId,
            type: "GET",
            success: function (response) {
                modalBody.html(response);
            },
            error: function () {
                modalBody.html(`
                    <div class="text-center text-danger py-5">
                        <i class="bi bi-exclamation-triangle fs-1"></i>
                        <p class="mt-2">Failed to load bill details. Please try again.</p>
                    </div>
                `);
            }
        });
    });
});
</script>

@endsection
