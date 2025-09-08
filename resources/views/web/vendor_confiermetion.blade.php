@extends('layouts.app')

@section('title', 'Join as Service Provider | ConstructKaro')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
  body {
    background: #f9fafb;
    font-family: 'Segoe UI', sans-serif;
    color: #1c2c3e;
  }

  .main-card {
    background: #fff;
    border-radius: 18px;
    padding: 50px 40px;
    max-width: 1200px;
    margin: 90px auto 50px;
    box-shadow: 0 10px 35px rgba(28, 44, 62, 0.12);
    border: 1px solid #e5e7eb;
  }

  .gradient-text {
    font-size: 32px;
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
    background: #fdfdfd;
    border-radius: 16px;
    padding: 35px 25px;
    text-align: center;
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
    height: 100%;
    cursor: pointer;
  }

  .card-option:hover {
    transform: translateY(-6px);
    box-shadow: 0 10px 22px rgba(28, 44, 62, 0.15);
    border-color: #f25c05;
  }

  .card-option .icon {
    background: #1c2c3e;
    color: #ffffff;
    font-size: 28px;
    width: 65px;
    height: 65px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 18px;
    box-shadow: 0 4px 10px rgba(28, 44, 62, 0.25);
  }

  .card-option h5 {
    font-size: 18px;
    font-weight: 600;
    color: #1c2c3e;
    margin-bottom: 10px;
  }

  .card-option p {
    font-size: 14px;
    color: #6b7280;
    min-height: 45px;
  }

  .btn-primary {
    background-color: #f25c05;
    border-color: #f25c05;
    font-weight: 500;
    padding: 10px 20px;
    border-radius: 10px;
    transition: all 0.3s ease;
  }

  .btn-primary:hover {
    background-color: #d44c00;
    border-color: #d44c00;
    transform: scale(1.05);
  }

  .btn-outline-success {
    color: #1c2c3e;
    border-color: #1c2c3e;
    font-weight: 500;
    border-radius: 10px;
    padding: 10px 20px;
  }

  .btn-outline-success:hover {
    background-color: #1c2c3e;
    color: #fff;
    border-color: #1c2c3e;
  }

  .info-message {
    background: #fff7ed;
    color: #b45309;
    padding: 16px 22px;
    border-radius: 12px;
    text-align: center;
    margin-top: 50px;
    font-size: 15px;
    border: 1px solid #fed7aa;
    max-width: 800px;
    margin-left: auto;
    margin-right: auto;
  }

  .logout-btn {
    position: absolute;
    top: 20px;
    right: 30px;
  }

  .logout-btn button {
    border-color: #1c2c3e;
    color: #1c2c3e;
    border-radius: 6px;
    font-weight: 500;
  }

  .logout-btn button:hover {
    background-color: #1c2c3e;
    color: #fff;
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
    <h2 class="gradient-text">Welcome to ConstructKaro Vendor Network!</h2>
    <p class="welcome-desc">
      We're excited to have you onboard. Your profile is currently under review. 
      Once verified, you’ll be visible to project owners and gain full access to exciting opportunities across the platform.
    </p>
    <a href="{{ route('vendor_likes_project') }}" class="btn btn-outline-success mt-3">
      <i class="bi bi-heart-fill me-1"></i> Like Projects
    </a>
  </div>

  <div class="text-center mb-5">
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
