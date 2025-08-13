@extends('layouts.admin')

@section('title', 'Vendor Approve')

@push('styles')
<style>
  :root { --ck-orange:#FF6600; --ck-navy:#0B2240; --ck-blue:#2949E9; }
  .card{border:1px solid #e9eef7;border-radius:1rem;box-shadow:0 8px 24px rgba(12,33,72,.06)}
  .card-header{background:linear-gradient(180deg,rgba(255,102,0,.06),rgba(41,73,233,.06));border-bottom:1px solid #e9eef7}
  .table thead th{background:#fff;border-bottom:1px solid #e9eef7;font-weight:600;color:#0B2240}
  .table tbody tr:hover{background:#fafcff}
  .search-wrap{display:flex;gap:.5rem;align-items:center;background:#fff;border:1px solid #e7ecf7;border-radius:.75rem;padding:.5rem .75rem}
  .search-wrap input{border:none;outline:none;width:260px;max-width:100%}
  .tag{background:rgba(11,34,64,.08);color:var(--ck-navy);font-size:.75rem;padding:.25rem .5rem;border-radius:.5rem}
</style>
@endpush

@section('content')
<div class="container-fluid px-0 px-md-2">
  <div class="card mt-3">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
      <div>
        <h5 class="mb-0">Approved Vendors</h5>
        <small class="text-muted">Showing {{ count($vendors) }} result(s)</small>
      </div>

      <div class="d-flex align-items-center gap-2">
        <div class="search-wrap">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
            <circle cx="11" cy="11" r="7" stroke="#8ea3c7" stroke-width="1.6"/>
            <path d="M20 20l-3.2-3.2" stroke="#8ea3c7" stroke-width="1.6" stroke-linecap="round"/>
          </svg>
          <input id="vendorSearch" type="text" placeholder="Search company, address…" />
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
             
            </tr>
          </thead>
          <tbody>
            @forelse($vendors as $index => $vendor)
              <tr data-row>
                <td>{{ $index + 1 }}</td>
                <td class="fw-semibold">{{ $vendor->company_name }}</td>
                <td class="text-muted small">{{ $vendor->registered_address }}</td>
                <td>{{ $vendor->experience_years }}</td>
                <td><span class="tag">Approved</span></td>
               
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
@endsection

@push('scripts')
<script>
  // Quick client-side search filter
  document.getElementById('vendorSearch').addEventListener('input', function () {
    const q = this.value.toLowerCase().trim();
    document.querySelectorAll('#vendorsTable tbody tr[data-row]').forEach(tr => {
      tr.style.display = tr.innerText.toLowerCase().includes(q) ? '' : 'none';
    });
  });

  // Simple CSV export of visible rows
  document.getElementById('exportCsv').addEventListener('click', function () {
    const rows = [['#','Company Name','Address','Experience','Status']];
    document.querySelectorAll('#vendorsTable tbody tr[data-row]').forEach(tr => {
      if (tr.style.display === 'none') return;
      const tds = tr.querySelectorAll('td');
      rows.push([
        tds[0]?.innerText.trim(),
        tds[1]?.innerText.trim(),
        tds[2]?.innerText.replace(/\s+/g,' ').trim(),
        tds[3]?.innerText.trim(),
        'Approved'
      ]);
    });
    const csv = rows.map(r => r.map(v => `"${(v||'').replace(/"/g,'""')}"`).join(',')).join('\n');
    const blob = new Blob([csv], {type: 'text/csv;charset=utf-8;'});
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url; a.download = 'approved_vendors.csv';
    document.body.appendChild(a); a.click(); document.body.removeChild(a);
    URL.revokeObjectURL(url);
  });
</script>
@endpush
