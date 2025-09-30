@extends('layouts.vendor_dash.app')

@section('title', 'Join as Service Provider | ConstructKaro')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
  body {
    background: #f8fafc;
    font-family: 'Segoe UI', sans-serif;
    color: #1c2c3e;
  }

  .main-card {
    background: #fff;
    border-radius: 18px;
    padding: 50px 40px;
    max-width: 1200px;
    margin: 90px auto 50px;
    box-shadow: 0 8px 28px rgba(28, 44, 62, 0.12);
    border: 1px solid #e5e7eb;
  }

  .gradient-text {
    font-size: 30px;
    font-weight: 700;
    background: linear-gradient(90deg, #f25c05, #1c2c3e);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }

  .welcome-desc {
    font-size: 16px;
    color: #475569;
    margin-top: 12px;
    line-height: 1.7;
    max-width: 800px;
    margin-left: auto;
    margin-right: auto;
  }

  .card-option {
    background: #ffffff;
    border-radius: 16px;
    padding: 30px 25px;
    text-align: center;
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
    height: 100%;
    cursor: pointer;
  }

  .card-option:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(28, 44, 62, 0.15);
    border-color: #f25c05;
  }

  .card-option .icon {
    background: #1c2c3e;
    color: #ffffff;
    font-size: 26px;
    width: 65px;
    height: 65px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 15px;
    box-shadow: 0 4px 10px rgba(28, 44, 62, 0.25);
  }

  .card-option h5 {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 8px;
    color: #1c2c3e;
  }

  .card-option p {
    font-size: 14px;
    color: #6b7280;
    min-height: 42px;
  }

  .btn-primary {
    background-color: #f25c05;
    border-color: #f25c05;
    font-weight: 500;
    padding: 8px 18px;
    border-radius: 10px;
    transition: all 0.3s ease;
  }

  .btn-primary:hover {
    background-color: #d44c00;
    border-color: #d44c00;
    transform: scale(1.05);
  }

  .social-buttons a {
    min-width: 110px;
  }

  .progress {
    height: 10px;
    border-radius: 6px;
    overflow: hidden;
    background: #e5e7eb;
  }
  .progress-bar {
    background: linear-gradient(90deg, #f25c05, #ff8746);
  }
</style>

<div class="container main-card">
  <div class="mb-4 text-center">
    <h2 class="gradient-text">Welcome to ConstructKaro Vendor Network!</h2>
    <p class="welcome-desc">
      Your profile is under review. Once verified, you’ll be visible to project owners and get full access to new opportunities.
    </p>
  </div>

  <div class="row justify-content-center">
    <div class="col-md-12 col-lg-8">
      <div class="card-option text-center p-4 shadow-lg rounded-4">

        <!-- Vendor Info -->
        <p class="fw-bold">Vendor ID: {{ $vendor->id }} | Name: {{ $vendor->name }}</p>

        <div class="icon mb-3">
          <i class="bi bi-person-lines-fill fs-1 text-primary"></i>
        </div>

        <h5 class="fw-bold">Profile Completion</h5>

        <p class="text-muted small fst-italic">
          "Stay connected, grow with us, and unlock more opportunities."
        </p>

        <div class="progress my-3" style="height: 20px;">
          <div id="progressBar" class="progress-bar" style="width:90%">90%</div>
        </div>

        <p id="profileMsg">
          Follow our official pages to reach <strong>100%</strong> completion.  
          Get exclusive updates, tips, and project leads faster!
        </p>

        <!-- Social Buttons -->
        <div id="socialLinks" class="social-buttons d-flex justify-content-center gap-2 mb-3">
          <a href="https://www.facebook.com/share/16n2rF5yTV/?mibextid=wwXIfr" target="_blank" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-facebook"></i> Facebook
          </a>
          <a href="https://www.instagram.com/constructkaro?igsh=MTZmb3Jxajd3N3lhNg==" target="_blank" class="btn btn-sm btn-outline-danger">
            <i class="bi bi-instagram"></i> Instagram
          </a>
          <a href="#" target="_blank" class="btn btn-sm btn-outline-info">
            <i class="bi bi-linkedin"></i> LinkedIn
          </a>
        </div>

        <!-- Follow Confirm Button -->
        <button id="followConfirm" class="btn btn-success fw-bold" data-vendor-id="{{ $vendor->id }}">
          ✅ I Have Followed
        </button>

        <!-- Dashboard Access after follow -->
        <div id="dashboardAccess" class="d-none mt-3">
          <div class="progress my-3" style="height: 20px;">
            <div class="progress-bar bg-success" style="width:100%">100%</div>
          </div>
          <p class="text-success small fw-bold">
            🎉 Thank you for joining our community! Your profile is now 100% complete.  
            Stay tuned for project opportunities and success tips.
          </p>
          <a href="{{ route('vendor_dashboard') }}" class="btn btn-primary mt-2">Go to Dashboard</a>
        </div>

        <hr>
        <a href="{{ route('vendor_dashboard') }}" class="btn btn-outline-secondary mt-2">
          Skip & Go to Dashboard
        </a>

      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#followConfirm').click(function() {
        let vendorId = $(this).data('vendor-id');
        let token = $('meta[name="csrf-token"]').attr('content');
        let button = $(this);

        $.ajax({
            url: '{{ route("vendor.follow.update") }}', 
            type: 'POST',
            data: {
                _token: token,
                vendor_id: vendorId
            },
            success: function(response) {
                if(response.status === 'success') {
                    // Hide social buttons and follow button
                    $('#socialLinks').addClass('d-none');
                    button.addClass('d-none');

                    // Update progress bar
                    $('#progressBar').addClass('bg-success').css('width', '100%').text('100%');

                    // Update message
                    $('#profileMsg').html("Great job! 🎉 You’re now part of the ConstructKaro success community.");

                    // Show dashboard access
                    $('#dashboardAccess').removeClass('d-none');
                } else {
                    alert('Something went wrong. Please try again.');
                }
            },
            error: function() {
                alert('Error updating follow status.');
            }
        });
    });
});
</script>

@endsection
