@extends('layouts.calling.app')

@section('title', 'Vendor Add')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3">Vendor Details</h3>

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addVendorModal">
        + Add Vendor
    </button>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th> <!-- Added -->
                <th>Name</th>
                <th>Mobile</th>
                <th>Address</th>
                <th>Location</th>
                <th>Remark</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="vendorTable">
            @foreach($vendors as $vendor)
            <tr data-id="{{ $vendor->id }}">
                <td>{{ $vendor->id }}</td> <!-- Added -->
                <td>{{ $vendor->name }}</td>
                <td>{{ $vendor->mobile }}</td>
                <td>{{ $vendor->address }}</td>
                <td>{{ $vendor->location }}</td>
                <td>{{ $vendor->remark ?? '-' }}</td>
                <td>
                    <span class="badge 
                        @if($vendor->status === 'Active') bg-success
                        @elseif($vendor->status === 'Inactive') bg-danger
                        @elseif($vendor->status === 'Pending') bg-secondary
                        @elseif($vendor->status === 'Not Reachable') bg-warning text-dark
                        @elseif($vendor->status === 'Interested') bg-info text-dark
                        @elseif($vendor->status === 'Not Interested') bg-dark
                        @elseif($vendor->status === 'Follow Up') bg-primary
                        @else bg-light text-dark @endif
                    ">
                        {{ $vendor->status ?? 'Pending' }}
                    </span>
                </td>
                <td>
                    <button class="btn btn-sm btn-warning editBtn">Edit</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


<!-- Add Vendor Modal -->
<div class="modal fade" id="addVendorModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="vendorForm">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Add Vendor Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body row g-3">
            <div class="col-md-6"><label class="form-label">Name</label><input type="text" name="name" class="form-control" required></div>
            <div class="col-md-6"><label class="form-label">Mobile</label><input type="text" name="mobile" class="form-control" required></div>
            <div class="col-md-6"><label class="form-label">Address</label><input type="text" name="address" class="form-control"></div>
            <div class="col-md-6"><label class="form-label">Location</label><input type="text" name="location" class="form-control"></div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save Vendor</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Edit Vendor Modal -->
<div class="modal fade" id="editVendorModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="editVendorForm">
        @csrf
        <input type="hidden" id="editVendorId">
        <div class="modal-header">
          <h5 class="modal-title">Edit Vendor</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body row g-3">
            <div class="col-12">
                <label class="form-label">Remark</label>
                <input type="text" name="remark" id="editRemark" class="form-control">
            </div>
            <div class="col-12">
                <label class="form-label">Status</label>
                <select name="status" id="editStatus" class="form-select">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                    <option value="Pending">Pending</option>
                    <option value="Not Reachable">Not Reachable</option>
                    <option value="Interested">Interested</option>
                    <option value="Not Interested">Not Interested</option>
                    <option value="Follow Up">Follow Up</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>


<script>
let currentRow = null;

// Save Vendor
document.getElementById("vendorForm").addEventListener("submit", function(e) {
    e.preventDefault();
    fetch("{{ route('vendors.store') }}", {
        method: "POST",
        headers: {"X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content},
        body: new FormData(this)
    })
    .then(res => res.json())
    .then(data => {
        let statusClass = "bg-secondary"; // default
        switch(data.status) {
            case "Active": statusClass = "bg-success"; break;
            case "Inactive": statusClass = "bg-danger"; break;
            case "Pending": statusClass = "bg-secondary"; break;
            case "Not Reachable": statusClass = "bg-warning text-dark"; break;
            case "Interested": statusClass = "bg-info text-dark"; break;
            case "Not Interested": statusClass = "bg-dark"; break;
            case "Follow Up": statusClass = "bg-primary"; break;
        }

        let row = `
            <tr data-id="${data.id}">
                <td>${data.id}</td> <!-- show ID -->
                <td>${data.name}</td>
                <td>${data.mobile}</td>
                <td>${data.address ?? ''}</td>
                <td>${data.location ?? ''}</td>
                <td>${data.remark}</td>
                <td><span class="badge ${statusClass}">${data.status}</span></td>
                <td><button class="btn btn-sm btn-warning editBtn">Edit</button></td>
            </tr>
        `;
        document.querySelector("#vendorTable").insertAdjacentHTML("beforeend", row);
        this.reset();
        bootstrap.Modal.getInstance(document.getElementById('addVendorModal')).hide();
    });
});

// Edit Button
document.getElementById("vendorTable").addEventListener("click", function(e) {
    if (e.target.classList.contains("editBtn")) {
        currentRow = e.target.closest("tr");
        let id = currentRow.dataset.id;
        let remark = currentRow.children[5].innerText;
        let status = currentRow.children[6].innerText.trim();

        document.getElementById("editVendorId").value = id;
        document.getElementById("editRemark").value = remark === "-" ? "" : remark;
        document.getElementById("editStatus").value = status;

        new bootstrap.Modal(document.getElementById('editVendorModal')).show();
    }
});

// Update Vendor
document.getElementById("editVendorForm").addEventListener("submit", function(e) {
    e.preventDefault();
    let id = document.getElementById("editVendorId").value;
    let formData = new FormData(this);

    fetch(`/vendors/${id}`, {
        method: "POST",
        headers: {"X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content},
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        let statusClass = "bg-secondary";
        switch(data.status) {
            case "Active": statusClass = "bg-success"; break;
            case "Inactive": statusClass = "bg-danger"; break;
            case "Pending": statusClass = "bg-secondary"; break;
            case "Not Reachable": statusClass = "bg-warning text-dark"; break;
            case "Interested": statusClass = "bg-info text-dark"; break;
            case "Not Interested": statusClass = "bg-dark"; break;
            case "Follow Up": statusClass = "bg-primary"; break;
        }

        if (currentRow) {
            currentRow.children[5].innerText = data.remark;
            currentRow.children[6].innerHTML = `<span class="badge ${statusClass}">${data.status}</span>`;
        }
        bootstrap.Modal.getInstance(document.getElementById('editVendorModal')).hide();
    });
});
</script>
@endsection
