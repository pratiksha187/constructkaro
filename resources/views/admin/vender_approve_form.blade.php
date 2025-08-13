@extends('layouts.admin')

@section('title','Vendor Approve')

@push('styles')
<style>
  :root{
    --ck-orange:#FF6600;
    --ck-navy:#0B2240;
    --ck-blue:#2949E9;
  }
  .card{border:1px solid #e9eef7;border-radius:1rem;box-shadow:0 8px 24px rgba(12,33,72,.06)}
  .card-header{background:linear-gradient(180deg,rgba(255,102,0,.06),rgba(41,73,233,.06));border-bottom:1px solid #e9eef7}
  .table thead th{background:#fff;border-bottom:1px solid #e9eef7;font-weight:600;color:#0B2240}
  .table tbody tr:hover{background:#fafcff}
  .badge-soft{background:rgba(41,73,233,.12);color:var(--ck-blue)}
  .badge-queued{background:rgba(11,34,64,.08);color:var(--ck-navy)}
  .btn-outline-primary{--bs-btn-color:var(--ck-orange);--bs-btn-border-color:var(--ck-orange)}
  .form-select.status{min-width: 140px;}
  .search-wrap{display:flex;gap:.5rem;align-items:center;background:#fff;border:1px solid #e7ecf7;border-radius:.75rem;padding:.5rem .75rem}
  .search-wrap input{border:none;outline:none;width:260px;max-width:100%}
</style>
@endpush

@section('content')
<div class="container-fluid px-0 px-md-2">
  <div class="card mt-3">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
      <h5 class="mb-0">Registered Vendors</h5>

      <div class="d-flex align-items-center gap-2">
        <div class="search-wrap">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
            <circle cx="11" cy="11" r="7" stroke="#8ea3c7" stroke-width="1.6"/>
            <path d="M20 20l-3.2-3.2" stroke="#8ea3c7" stroke-width="1.6" stroke-linecap="round"/>
          </svg>
          <input id="vendorSearch" type="text" placeholder="Search company, address…" />
        </div>
      </div>
    </div>

    <div class="card-body">
      @if(session('success'))
        <div class="alert alert-success mb-3">{{ session('success') }}</div>
      @endif

      <div class="table-responsive">
        <table id="vendorsTable" class="table align-middle">
          <thead>
            <tr>
              <th style="width:60px">#</th>
              <th>Company Name</th>
              <th>Address</th>
              <th style="width:160px">Experience</th>
             
              <th style="width:180px" class="text-end">Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($vendors as $index => $vendor)
              @php
                $statusVal = $vendor->approved;
              @endphp
              <tr data-row>
                <td>{{ $index + 1 }}</td>
                <td class="fw-semibold">{{ $vendor->company_name }}</td>
                <td class="text-muted small">{{ $vendor->registered_address }}</td>
                <td>{{ $vendor->experience_years }}</td>
                
                <td class="text-end">
                  <div class="d-inline-flex align-items-center gap-2">
                    <select
                      class="form-select form-select-sm status"
                      data-id="{{ $vendor->id }}"
                      aria-label="Change status"
                    >
                      <option value="">-- Select --</option>
                      <option value="1" @selected($statusVal==1)>Approve</option>
                      <option value="2" @selected($statusVal==2)>Reject</option>
                    </select>
                    <div class="spinner-border spinner-border-sm text-secondary d-none" role="status" aria-hidden="true"></div>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center text-muted py-4">No vendors found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

{{-- Toast --}}
<div class="position-fixed bottom-0 end-0 p-3" style="z-index:1080">
  <div id="saveToast" class="toast align-items-center border-0" role="status" aria-live="polite" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body"></div>
      <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  // quick client-side filter
  document.getElementById('vendorSearch').addEventListener('input', function () {
    const q = this.value.toLowerCase().trim();
    document.querySelectorAll('#vendorsTable tbody tr[data-row]').forEach(tr => {
      const text = tr.innerText.toLowerCase();
      tr.style.display = text.includes(q) ? '' : 'none';
    });
  });

  // status change -> AJAX
  document.querySelectorAll('.form-select.status').forEach(sel => {
    sel.addEventListener('change', function () {
      const row = this.closest('tr');
      const spinner = row.querySelector('.spinner-border');
      const vendorId = this.dataset.id;
      const status = this.value;

      if (!status) return;

      if (!confirm(`Are you sure you want to ${status == '1' ? 'APPROVE' : 'REJECT'} this vendor?`)) {
        this.value = ''; return;
      }

      this.disabled = true;
      spinner.classList.remove('d-none');

      fetch(`/admin/vendors/${vendorId}/update-status`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ status })
      })
      .then(r => r.json())
      .then(data => {
        // update badge
        const badgeCell = row.querySelector('td:nth-child(5)');
        if (status === '1') {
          badgeCell.innerHTML = '<span class="badge text-bg-success">Approved</span>';
        } else if (status === '2') {
          badgeCell.innerHTML = '<span class="badge text-bg-danger">Rejected</span>';
        } else {
          badgeCell.innerHTML = '<span class="badge badge-soft">Pending</span>';
        }
        showToast(data.message || 'Status updated.');
      })
      .catch(() => showToast('Something went wrong.', true))
      .finally(() => {
        this.disabled = false;
        spinner.classList.add('d-none');
      });
    });
  });

  function showToast(msg, isError=false) {
    const el = document.getElementById('saveToast');
    el.querySelector('.toast-body').textContent = msg;
    el.classList.remove('text-bg-success','text-bg-danger');
    el.classList.add(isError ? 'text-bg-danger' : 'text-bg-success');

    const toast = new bootstrap.Toast(el, { delay: 2200 });
    toast.show();
  }
</script>
@endpush
