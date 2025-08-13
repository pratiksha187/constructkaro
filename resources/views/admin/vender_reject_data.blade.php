@extends('layouts.admin')

@section('title', 'Vendor Approve')

@push('styles')
<style>
  :root{ --ck-orange:#FF6600; --ck-navy:#0B2240; --ck-blue:#2949E9; }
  .card{border:1px solid #e9eef7;border-radius:1rem;box-shadow:0 8px 24px rgba(12,33,72,.06)}
  .card-header{background:linear-gradient(180deg,rgba(255,102,0,.06),rgba(41,73,233,.06));border-bottom:1px solid #e9eef7}
  .table thead th{background:#fff;border-bottom:1px solid #e9eef7;font-weight:600;color:#0B2240}
  .table tbody tr:hover{background:#fafcff}
  .tag{background:rgba(220,53,69,.12);color:#dc3545;font-size:.75rem;padding:.25rem .5rem;border-radius:.5rem}
  .search-wrap{display:flex;gap:.5rem;align-items:center;background:#fff;border:1px solid #e7ecf7;border-radius:.75rem;padding:.5rem .75rem}
  .search-wrap input{border:none;outline:none;width:260px;max-width:100%}
  .btn-outline-primary{--bs-btn-color:var(--ck-orange);--bs-btn-border-color:var(--ck-orange)}
</style>
@endpush

@section('content')
<div class="container-fluid px-0 px-md-2">
  <div class="card mt-3">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
      <div>
        <h5 class="mb-0">Rejected Vendors</h5>
        <small class="text-muted">Showing {{ count($vendors) }} result(s)</small>
      </div>
      <div class="d-flex align-items-center gap-2">
        <div class="search-wrap">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
            <circle cx="11" cy="11" r="7" stroke="#8ea3c7" stroke-width="1.6"/>
            <path d="M20 20l-3.2-3.2" stroke="#8ea3c7" stroke-width="1.6" stroke-linecap="round"/>
          </svg>
          <input id="vendorSearch" type="text" placeholder="Search company, address…"/>
        </div>
        <button id="exportCsv" class="btn btn-outline-primary btn-sm">Export CSV</button>
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
              <th style="width:120px">Status</th>
              <th>Reason</th>
              <th class="text-end" style="width:200px">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($vendors as $index => $vendor)
              <tr data-row>
                <td>{{ $index + 1 }}</td>
                <td class="fw-semibold">{{ $vendor->company_name }}</td>
                <td class="text-muted small">{{ $vendor->registered_address }}</td>
                <td>{{ $vendor->experience_years }}</td>
                <td><span class="tag">Rejected</span></td>
                <td class="text-muted small">{{ $vendor->rejection_reason ?? $vendor->remark ?? '—' }}</td>
                <td class="text-end">
                  <div class="btn-group btn-group-sm" role="group" aria-label="Actions">
                    <button class="btn btn-outline-secondary"
                            onclick="updateStatus('{{ $vendor->id }}', 0)">Re-open</button>
                    <button class="btn btn-primary"
                            onclick="updateStatus('{{ $vendor->id }}', 1)">Approve</button>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center text-muted py-4">No vendors found.</td>
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
  // client-side search
  document.getElementById('vendorSearch').addEventListener('input', function () {
    const q = this.value.toLowerCase().trim();
    document.querySelectorAll('#vendorsTable tbody tr[data-row]').forEach(tr => {
      tr.style.display = tr.innerText.toLowerCase().includes(q) ? '' : 'none';
    });
  });

  // CSV export of visible rows
  document.getElementById('exportCsv').addEventListener('click', function () {
    const rows = [['#','Company Name','Address','Experience','Status','Reason']];
    document.querySelectorAll('#vendorsTable tbody tr[data-row]').forEach(tr => {
      if (tr.style.display === 'none') return;
      const tds = tr.querySelectorAll('td');
      rows.push([
        tds[0]?.innerText.trim(),
        tds[1]?.innerText.trim(),
        tds[2]?.innerText.replace(/\s+/g,' ').trim(),
        tds[3]?.innerText.trim(),
        'Rejected',
        tds[5]?.innerText.replace(/\s+/g,' ').trim()
      ]);
    });
    const csv = rows.map(r => r.map(v => `"${(v||'').replace(/"/g,'""')}"`).join(',')).join('\n');
    const blob = new Blob([csv], {type: 'text/csv;charset=utf-8;'});
    const url = URL.createObjectURL(blob);
    const a = Object.assign(document.createElement('a'), { href:url, download:'rejected_vendors.csv' });
    document.body.appendChild(a); a.click(); document.body.removeChild(a);
    URL.revokeObjectURL(url);
  });

  // update status via your existing endpoint
  function updateStatus(vendorId, status) {
    if (!confirm(`Are you sure you want to ${status==1?'APPROVE':'RE-OPEN'} this vendor?`)) return;

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
      showToast(data.message || 'Status updated.');
      setTimeout(() => location.reload(), 800);
    })
    .catch(() => showToast('Something went wrong.', true));
  }

  function showToast(msg, isError=false) {
    const el = document.getElementById('saveToast');
    el.querySelector('.toast-body').textContent = msg;
    el.classList.remove('text-bg-success','text-bg-danger');
    el.classList.add(isError ? 'text-bg-danger' : 'text-bg-success');
    new bootstrap.Toast(el, { delay: 2200 }).show();
  }
</script>
@endpush
