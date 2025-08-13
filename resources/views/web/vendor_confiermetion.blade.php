@extends('layouts.app')

@section('title', 'Join as Service Provider | ConstructKaro')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
  body {
    background: linear-gradient(to bottom right, #f7f7f7, #ffffff);
    font-family: 'Segoe UI', sans-serif;
    color: #111827;
  }

  .main-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 50px;
    max-width: 1358px;
    margin: 80px auto 40px;
    box-shadow: 0 15px 50px rgba(17, 24, 39, 0.08);
  }

  .welcome-title {
    font-size: 28px;
    font-weight: 600;
    color: #0077b6;
  }

  .welcome-desc {
    font-size: 16px;
    color: #374151;
    margin-top: 10px;
  }

  .card-option {
    background: #e0f7fa;
    border-radius: 16px;
    padding: 35px 25px;
    text-align: center;
    border: 1px solid #90e0ef;
    transition: all 0.3s ease;
    height: 100%;
    cursor: pointer;
  }

  .card-option:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 25px rgba(0, 119, 182, 0.15);
  }

  .card-option .icon {
    background: #0077b6;
    color: #ffffff;
    font-size: 30px;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 15px;
  }

  .card-option h5 {
    font-size: 18px;
    font-weight: 600;
    color: #023047;
  }

  .card-option p {
    font-size: 14px;
    color: #4b5563;
  }

  .info-message {
    background: #d1f3f8;
    color: #0077b6;
    padding: 15px 20px;
    border-radius: 8px;
    text-align: center;
    margin-top: 50px;
    font-size: 15px;
  }

  .btn-primary {
    background-color: #0077b6;
    border-color: #0077b6;
    font-weight: 500;
  }

  .btn-primary:hover {
    background-color: #023e8a;
    border-color: #023e8a;
  }

  .btn-outline-success {
    color: #0077b6;
    border-color: #0077b6;
    font-weight: 500;
  }

  .btn-outline-success:hover {
    background-color: #0077b6;
    color: #fff;
    border-color: #0077b6;
  }

  footer {
    text-align: center;
    padding: 30px 0;
    font-size: 14px;
    color: #6b7280;
  }

  footer a {
    color: #0077b6;
    margin: 0 10px;
    text-decoration: none;
  }

  footer a:hover {
    text-decoration: underline;
  }

  .logout-btn {
    position: absolute;
    top: 20px;
    right: 30px;
  }

  .logout-btn button {
    border-color: #0077b6;
    color: #0077b6;
  }

  .logout-btn button:hover {
    background-color: #0077b6;
    color: #fff;
    border-color: #0077b6;
  }

  .gradient-text {
  font-size: 28px;
  font-weight: 700;
  background: linear-gradient(90deg, #e35b0dff, #0077b6);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

</style>

<!-- Logout Button -->
<form method="POST" action="" class="logout-btn">
  @csrf
  <button type="submit" class="btn btn-sm btn-outline-light">
    <i class="bi bi-box-arrow-right me-1"></i> Log out
  </button>
</form>

<!-- Main Content Card -->
<div class="container main-card">
  <div class="mb-4 text-center">
    <h2 class="welcome-title gradient-text">Welcome to ConstructKaro Vendor Network!</h2>

    <!-- <h2 class="welcome-title">Welcome to ConstructKaro Vendor Network!</h2> -->
    <p class="welcome-desc">We're excited to have you onboard. Your profile is currently under review. Once verified, you’ll be visible to project owners and gain full access to exciting opportunities across the platform.</p>
      <a href="{{ route('vendor_likes_project') }}" class="btn btn-outline-success">
      <i class="bi bi-heart-fill me-1"></i> Like Projects
    </a>
  </div>

  <div class="text-center mb-4">
    <h5 class="text-muted">While we verify your profile, you can:</h5>
  </div>

  <div class="row g-4 justify-content-center">
    <!-- Explore Projects Card -->
    <div class="col-md-6 col-lg-5">
      <div class="card-option" onclick="window.location='{{ route('projects.list.page') }}'">
        <div class="icon"><i class="bi bi-search"></i></div>
        <h5>Explore Projects</h5>
        <p>Browse available projects with limited access until your profile is verified.</p>
        <a href="{{ route('projects.list.page') }}" class="btn btn-primary mt-3">Browse Projects</a>
      </div>
    </div>

    <!-- Complete Profile Card -->
    <div class="col-md-6 col-lg-5">
      <div class="card-option" onclick="window.location='{{ route('vendor_dashboard') }}'">
        <div class="icon"><i class="bi bi-person-lines-fill"></i></div>
        <h5>Complete Your Profile</h5>
        <p>Provide more details to strengthen your profile and speed up the approval process.</p>
        <a href="{{ route('vendor_dashboard') }}" class="btn btn-primary mt-3">Edit Profile</a>
      </div>
    </div>
  </div>

  <!-- Info Message -->
  <div class="info-message mt-5">
    <i class="bi bi-info-circle-fill me-2"></i>
    Verification usually takes 1–2 business days. We’ll notify you via email once your account is approved.
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
