@extends('layouts.cust_dash.app')

@section('title', 'Project Details | ConstructKaro')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
    :root {
        --primary: #f25c05;
        --dark: #1c2c3e;
        --bg: #f8fafc;
        --radius: 14px;
        --shadow: 0 8px 24px rgba(0,0,0,0.08);
    }

    body { background: var(--bg); }

    .page-header {
        background: linear-gradient(135deg, var(--dark), var(--primary));
        color: white;
        border-radius: var(--radius);
        padding: 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: "";
        position: absolute;
        top: -40px;
        right: -40px;
        width: 150px;
        height: 150px;
        background: rgba(255,255,255,0.08);
        border-radius: 50%;
    }

    .section-card {
        background: white;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .progress {
        height: 10px;
        border-radius: 5px;
    }

    .progress-bar {
        background: var(--primary);
    }

    .milestone {
        padding: 1rem;
        border-left: 4px solid #f25c05;
        background: #fff8f2;
        border-radius: var(--radius);
        margin-bottom: 1rem;
        transition: 0.3s;
    }

    .milestone.completed {
        border-left-color: #16a34a;
        background: #f0fdf4;
    }

    .milestone:hover {
        transform: translateY(-3px);
    }

    .payment-item {
        display: flex;
        justify-content: space-between;
        border-bottom: 1px solid #e5e7eb;
        padding: 0.75rem 0;
    }

    .payment-item:last-child { border-bottom: none; }

    .vendor-card {
        background: #fff;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        padding: 1.25rem;
    }

    .vendor-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: #fff3e6;
        color: var(--primary);
        font-size: 1.8rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
    }

    .back-btn {
        color: white;
        text-decoration: none;
    }

    .back-btn:hover {
        text-decoration: underline;
    }
</style>

<div class="container py-5">
    <!-- ✅ Page Header -->
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h2 class="mb-1">Residential Villa Construction</h2>
            <p class="mb-0">Project ID: <strong>PRJ-1024</strong> | Location: Pune</p>
        </div>
        <a href="{{ route('customer.dashboard') }}" class="back-btn">
            <i class="bi bi-arrow-left-circle me-2"></i>Back to Dashboard
        </a>
    </div>

    <!-- ✅ Project Overview -->
    <div class="section-card">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Project Overview</h5>
            <span class="badge bg-warning text-dark">In Progress</span>
        </div>
        <p class="text-muted mb-2"><strong>Stage:</strong> Foundation Work</p>
        <div class="progress mb-3">
            <div class="progress-bar" style="width: 35%;">35%</div>
        </div>
        <p class="mb-1"><strong>Start Date:</strong> 5th Sept 2025</p>
        <p class="mb-0"><strong>Estimated Completion:</strong> 15th Dec 2025</p>
    </div>

    <!-- ✅ Milestones -->
    <div class="section-card">
        <h5 class="mb-3">Project Milestones</h5>

        <div class="milestone completed">
            <h6 class="mb-1"><i class="bi bi-check-circle-fill text-success me-2"></i>Project Initiation</h6>
            <small class="text-muted">Completed on 10 Sept 2025</small>
        </div>

        <div class="milestone">
            <h6 class="mb-1"><i class="bi bi-hourglass-split text-warning me-2"></i>Foundation Work</h6>
            <small class="text-muted">Expected by 15 Oct 2025</small>
        </div>

        <div class="milestone">
            <h6 class="mb-1"><i class="bi bi-clock-history text-secondary me-2"></i>Structure Completion</h6>
            <small class="text-muted">Upcoming Milestone</small>
        </div>
    </div>

    <!-- ✅ Payments -->
    <div class="section-card">
        <h5 class="mb-3">Payment Schedule</h5>

        <div class="payment-item">
            <span><i class="bi bi-cash-coin me-2 text-success"></i>Project Initiation</span>
            <span class="text-success fw-semibold">₹50,000 Paid</span>
        </div>

        <div class="payment-item">
            <span><i class="bi bi-cash-stack me-2 text-warning"></i>Foundation Work</span>
            <span class="text-warning fw-semibold">₹1,50,000 Pending</span>
        </div>

        <div class="payment-item">
            <span><i class="bi bi-currency-rupee me-2 text-muted"></i>Structure Completion</span>
            <span class="text-muted">₹2,00,000 Pending</span>
        </div>

        <hr>
        <div class="d-flex justify-content-between fw-semibold">
            <span>Total Project Value:</span>
            <span>₹25,00,000</span>
        </div>
    </div>

    <!-- ✅ Vendor Info -->
    <div class="section-card">
        <h5 class="mb-3">Assigned Vendor</h5>
        <div class="d-flex align-items-center">
            <div class="vendor-avatar"><i class="bi bi-person-fill"></i></div>
            <div>
                <h6 class="mb-1">Suresh Construction</h6>
                <small class="text-muted d-block">Civil Contractor</small>
                <small><i class="bi bi-telephone text-success me-2"></i>+91 98765 11111</small>
            </div>
        </div>
    </div>

    <!-- ✅ Documents -->
    <div class="section-card">
        <h5 class="mb-3">Documents</h5>
        <ul class="list-unstyled mb-0">
            <li><i class="bi bi-file-earmark-text me-2 text-primary"></i>Architectural Drawings.pdf</li>
            <li><i class="bi bi-file-earmark-spreadsheet me-2 text-success"></i>BOQ_Details.xlsx</li>
            <li><i class="bi bi-file-earmark-richtext me-2 text-warning"></i>Project_Contract.docx</li>
        </ul>
    </div>
</div>
@endsection
