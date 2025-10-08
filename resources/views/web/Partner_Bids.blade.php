@extends('layouts.app')
@section('title', 'Project Questionnaire | ConstructKaro')

@section('content')
<style>
  .container { max-width: 900px; margin: 40px auto; padding: 0 20px; } h2 { font-size: 26px; margin-bottom: 10px; font-weight: 600; color: #222; } .subtitle { color: #666; margin-bottom: 30px; font-size: 15px; } .vendor-card { background: #fff; border: 1px solid #e2e8f0; padding: 20px 24px; margin-bottom: 24px; border-radius: 10px; position: relative; box-shadow: 0 4px 12px rgba(0,0,0,0.04); transition: transform 0.2s ease, box-shadow 0.2s ease; cursor: pointer; } .vendor-card:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(0,0,0,0.06); } .vendor-card.highlight { border: 2px solid #f6b947; box-shadow: 0 6px 18px rgba(255, 190, 0, 0.15); } .header { display: flex; align-items: center; justify-content: space-between; } .badge { font-size: 12px; padding: 6px 12px; border-radius: 16px; font-weight: 500; color: #fff; white-space: nowrap; } .gold { background-color: #ffb400; } .silver { background-color: #b0b0b0; } .details { margin-top: 14px; display: flex; flex-wrap: wrap; gap: 16px; font-size: 14px; color: #444; } .rating { color: #f5a623; font-weight: bold; } .price { position: absolute; right: 24px; bottom: 20px; font-size: 20px; font-weight: bold; color: #f2552c; } .note { background-color: #edf4ff; padding: 18px 20px; border-left: 4px solid #3a8dde; font-size: 14px; border-radius: 6px; margin-top: 50px; color: #333; } .note strong { color: #3a8dde; } .proceed-btn { display: none; width: 100%; padding: 14px; font-weight: 600; font-size: 16px; color: #fff; background: linear-gradient(90deg, #f25c05, #f6b947); border: none; border-radius: 8px; cursor: pointer; margin-top: 30px; } .proceed-btn:hover { opacity: 0.9; } @media (max-width: 600px) { .price { position: static; margin-top: 15px; } .header { flex-direction: column; align-items: flex-start; gap: 8px; } }
</style>

<div class="container">
  <h2>Review Verified Partner Bids</h2>
  <p class="subtitle">Your project, your choice — but always backed by ConstructKaro's safety and warranty.</p>

  {{-- Vendor Loop --}}
  @foreach($vendor as $index => $v)
    <div class="vendor-card {{ $loop->first ? 'highlight' : '' }}" 
         data-vendor="{{ $v->service_provider_id }}" 
         data-name="{{ $v->name }}" 
         data-cost="{{ $v->vendor_cost }}">
      <div class="header">
        <h3>{{ $v->name }}</h3>
        <span class="badge {{ $index % 2 == 0 ? 'gold' : 'silver' }}">
          ConstructKaro Verified {{ $index % 2 == 0 ? 'Gold' : 'Silver' }} Partner
        </span>
      </div>
      <div class="details">
        <span class="rating">⭐ {{ rand(40, 49)/10 }} ({{ rand(50,150) }} projects)</span>
        <span class="info">Business: {{ $v->business_name }}</span>
        <span class="info">Location: {{ $v->location }}</span>
        <span class="info">Experience: {{ $v->experience_years ?? 'N/A' }}</span>
      </div>
      <div class="price">₹{{ $v->vendor_cost ?? '0' }}</div>
    </div>
  @endforeach

  {{-- Hidden field + button --}}
  <form id="vendorForm">
    @csrf
    <input type="hidden" name="selected_vendor" id="selected_vendor" value="">
    <button type="submit" class="proceed-btn btn btn-warning" id="proceedBtn">
        Select Vendor & Proceed
    </button>
  </form>

  {{-- Note --}}
  <div class="note">
    <strong>🔒 Note:</strong> Vendors remain ConstructKaro Partners — ensuring no hidden dealings, no risks, only trust. 
  </div>
</div>

{{-- Success Modal --}}
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center p-4">
      <div class="mb-3">
        <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex p-3">
          <i class="bi bi-check-lg text-success" style="font-size:32px;"></i>
        </div>
      </div>
      <h4 class="fw-bold">Thank you <span id="customerName"></span>!</h4>
      <p class="text-muted">
        ConstructKaro will now assign your chosen Verified Partner to your project.
      </p>
      <button type="button" id="proceedToContract" class="btn btn-warning text-white fw-semibold">
        Proceed to Contract
      </button>
    </div>
  </div>
</div>

{{-- Contract Confirmation Modal --}}
<div class="modal fade" id="contractModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content p-4">
      <h5 class="fw-bold mb-3">Contract Confirmation & Partner Details</h5>
      <div class="alert alert-success d-flex align-items-center">
        <i class="bi bi-check-circle-fill me-2 text-success"></i>
        <div>
          <strong>Contract Signed Successfully!</strong><br>
          Your project will be executed by ConstructKaro Partner:
        </div>
      </div>

      <div class="p-3 border rounded d-flex justify-content-between align-items-center">
        <div>
          <h6 id="partnerName" class="fw-bold"></h6>
          <span class="badge bg-warning text-dark">Verified Partner</span>
          <p class="small mt-2 text-muted">
            They are your on-site contact. ConstructKaro will monitor safety, quality, and payments.
          </p>
        </div>
        <div class="text-end">
          <h4 class="text-danger fw-bold" id="contractValue"></h4>
          <small class="text-muted">Contract Value</small>
        </div>
      </div>

      <div class="text-center mt-4">
        <button id="goToDashboard" class="btn btn-warning text-white fw-semibold">
            View Project Dashboard
        </button>

      </div>
    </div>
  </div>
</div>

{{-- Scripts --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    const proceedBtn = $("#proceedBtn");
    const selectedInput = $("#selected_vendor");

    // Auto-select first vendor
    let firstVendor = $(".vendor-card").first();
    if (firstVendor.length) {
        firstVendor.addClass("highlight");
        selectedInput.val(firstVendor.data("vendor")); 
        proceedBtn.show();
    }

    // Vendor selection
    $(".vendor-card").on("click", function() {
        $(".vendor-card").removeClass("highlight");
        $(this).addClass("highlight");

        selectedInput.val($(this).data("vendor"));
        proceedBtn.show();
    });

    // Form submit
    $("#vendorForm").on("submit", function(e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('proceed.vendor') }}",
            method: "POST",
            data: $(this).serialize(),
            success: function(response) {
                $("#customerName").text(response.customer_name ?? "Customer");

                // Save vendor info for contract modal
                $("#partnerName").text($(".vendor-card.highlight").data("name"));
                $("#contractValue").text("₹" + $(".vendor-card.highlight").data("cost"));

                let modal = new bootstrap.Modal(document.getElementById('successModal'));
                modal.show();
            },
            error: function(xhr) {
                alert(xhr.responseJSON?.message ?? "Something went wrong!");
            }
        });
    });

    // Proceed to contract
    $("#proceedToContract").on("click", function() {
        let successModal = bootstrap.Modal.getInstance(document.getElementById('successModal'));
        successModal.hide();

        let contractModal = new bootstrap.Modal(document.getElementById('contractModal'));
        contractModal.show();
    });
});

// Attach event to button
$(document).on("click", "#goToDashboard", function () {
    $.ajax({
        url: "{{ route('customer.dashboard') }}", // use your Laravel route name
        type: "GET",
        success: function (response) {
            // Option 1: Redirect user after successful call
            window.location.href = "{{ route('customer.dashboard') }}";
        },
        error: function () {
            alert("Something went wrong, please try again!");
        }
    });
});

</script>
@endsection
