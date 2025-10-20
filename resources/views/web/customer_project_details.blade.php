@extends('layouts.cust_dash.app')

@section('title', 'Project Details | ConstructKaro')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
    :root {
        --primary: #f25c05;
        --dark: #1c2c3e;
        --light: #f9fafb;
        --radius: 16px;
        --shadow: 0 8px 24px rgba(0,0,0,0.08);
    }

    body {
        background: var(--light);
        font-family: "Inter", sans-serif;
    }

    /* ---------------- Header ---------------- */
    .page-header {
        background: linear-gradient(135deg, var(--dark), var(--primary));
        border-radius: var(--radius);
        color: white;
        padding: 2.5rem;
        margin-bottom: 2.5rem;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow);
    }

    .page-header::before {
        content: "";
        position: absolute;
        top: -60px;
        right: -60px;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: rgba(255,255,255,0.1);
    }

    .page-header h2 {
        font-weight: 700;
        letter-spacing: 0.4px;
    }

    .text-orange { color: var(--primary); }
    .text-navy { color: var(--dark); }

    /* ---------------- Card ---------------- */
    .section-card {
        background: #fff;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        padding: 1.75rem;
        margin-bottom: 2rem;
        transition: 0.3s;
    }

    .section-card:hover {
        transform: translateY(-3px);
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 600;
        color: var(--dark);
        border-left: 4px solid var(--primary);
        padding-left: 10px;
        font-size: 1.1rem;
    }

    .divider {
        height: 2px;
        width: 60px;
        background: var(--primary);
        border-radius: 2px;
        margin: 1rem 0;
    }

    /* ---------------- Progress ---------------- */
    .progress {
        height: 12px;
        border-radius: 8px;
        background: #e9ecef;
    }

    .progress-bar {
        background: var(--primary);
        font-size: 0.75rem;
        font-weight: 600;
        animation: grow 2s ease-out;
    }

    @keyframes grow {
        from { width: 0; }
        to { width: 35%; }
    }

    /* ---------------- Milestones ---------------- */
    .milestone {
        padding: 1rem 1.25rem;
        border-left: 5px solid var(--primary);
        background: #fff8f4;
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
        box-shadow: 0 3px 10px rgba(0,0,0,0.05);
    }

    /* ---------------- Payment ---------------- */
    .payment-item {
        display: flex;
        justify-content: space-between;
        padding: 0.85rem 0;
        border-bottom: 1px solid #eee;
    }

    .payment-item:last-child { border-bottom: none; }

    /* ---------------- Vendor + Docs ---------------- */
    .vendor-docs {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }

    @media (max-width: 992px) {
        .vendor-docs {
            grid-template-columns: 1fr;
        }
    }

    .vendor-box, .docs-box {
        background: #fefefe;
        border: 1px solid #eee;
        border-radius: 14px;
        padding: 1.5rem;
        transition: 0.3s;
    }

    .vendor-box:hover, .docs-box:hover {
        border-color: var(--primary);
        box-shadow: 0 4px 16px rgba(242,92,5,0.08);
    }

    .vendor-avatar {
        width: 65px;
        height: 65px;
        border-radius: 50%;
        background: linear-gradient(135deg, #fff3e6, #ffe0cc);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: var(--primary);
        margin-right: 1rem;
    }

    .vendor-details h6 {
        margin-bottom: 0.25rem;
        font-weight: 600;
        color: var(--dark);
    }

    .vendor-details small {
        color: #6b7280;
    }

    .docs-list li {
        background: #f9fafb;
        border-radius: 10px;
        padding: 0.8rem 1rem;
        margin-bottom: 0.6rem;
        transition: 0.2s;
        display: flex;
        align-items: center;
    }

    .docs-list li i {
        font-size: 1.2rem;
    }

    .docs-list li:hover {
        background: #fff3e6;
        transform: translateX(5px);
    }

    /* Optional buttons */
    .action-btn {
        border: none;
        background: var(--primary);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.9rem;
        transition: 0.3s;
    }

    .action-btn:hover {
        background: #d84f03;
    }
</style>

<div class="container py-5">

    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h2>{{ $project->project_name ?? 'Untitled Project' }}</h2>
            <p class="mb-0 opacity-75">
                Submission ID: <strong>{{ $project->submission_id ?? 'N/A' }}</strong> 
                @if(!empty($project->project_location))
                    | Location: {{ $project->project_location }}
                @endif
            </p>
        </div>
        <a href="{{ route('customer.dashboard') }}" class="text-white text-decoration-none fw-medium">
            <i class="bi bi-arrow-left-circle me-2"></i> Back to Dashboard
        </a>
    </div>
    
    <div class="section-card">
        <div class="section-header">
            <i class="bi bi-bar-chart-line-fill text-orange"></i> Project Overview
        </div>
        <div class="divider"></div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="fw-medium text-secondary">Stage: Foundation Work</span>
            <span class="badge bg-warning text-dark px-3 py-2">In Progress</span>
        </div>
        <p class="text-muted mb-3">
            {{ $project->project_description ?? 'No project description provided.' }}
        </p>
        <div class="progress mb-3">
            <div class="progress-bar" style="width: 0%;">0%</div>
        </div>
        <div class="d-flex justify-content-between small text-muted">
            <span><strong>Created On:</strong> {{ \Carbon\Carbon::parse($project->created_at)->format('d M Y') }}</span>
            <span><strong>Status:</strong> 
                @if($project->confirm == 1)
                    <span class="badge bg-success">Confirmed</span>
                @else
                    <span class="badge bg-warning text-dark">Pending</span>
                @endif
            </span>
        </div>
    </div>
    <!-- ✅ Milestones -->
    <div class="section-card">
        <div class="section-header">
            <i class="bi bi-flag-fill text-orange"></i> Project Milestones
        </div>
        <div class="divider"></div>

        <!-- <div class="milestone completed">
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
        </div> -->
    </div>

    <!-- ✅ Payment Schedule -->
    <div class="section-card">
        <div class="section-header">
            <i class="bi bi-cash-stack text-orange"></i> Payment Schedule
        </div>
        <div class="divider"></div>

        <!-- <div class="payment-item">
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
        </div> -->

        <hr>
        <div class="d-flex justify-content-between fw-semibold">
            <span>Total Project Value:</span>
            <span>₹00</span>
        </div>
    </div>

    <!-- ✅ Vendor + Documents -->
    <div class="section-card">
        <div class="section-header">
            <i class="bi bi-people-fill text-orange"></i> Assigned Vendor & Documents
        </div>
        <div class="divider"></div>

        <!-- <div class="vendor-docs">
         
            <div class="vendor-box d-flex align-items-center">
                <div class="vendor-avatar"><i class="bi bi-person-fill"></i></div>
                <div class="vendor-details">
                    <h6>Suresh Construction</h6>
                    <small class="d-block">Civil Contractor</small>
                    <small><i class="bi bi-telephone text-success me-2"></i>+91 98765 11111</small>
                </div>
            </div>

            
            <div class="docs-box">
                <h6 class="fw-semibold text-navy mb-3">
                    <i class="bi bi-folder2-open text-orange me-2"></i>Documents
                </h6>
                <ul class="list-unstyled docs-list mb-3">
                    <li><i class="bi bi-file-earmark-text text-primary me-2"></i>Architectural Drawings.pdf</li>
                    <li><i class="bi bi-file-earmark-spreadsheet text-success me-2"></i>BOQ_Details.xlsx</li>
                    <li><i class="bi bi-file-earmark-richtext text-warning me-2"></i>Project_Contract.docx</li>
                </ul>
                <button class="action-btn"><i class="bi bi-download me-1"></i>Download All</button>
            </div>
        </div> -->
    </div>
</div>
@endsection
