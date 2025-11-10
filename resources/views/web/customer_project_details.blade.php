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

    /* ---------- Header ---------- */
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

    /* ---------- Section Cards ---------- */
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

    /* ---------- Progress ---------- */
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

    /* ---------- Milestones ---------- */
    .milestone-card {
        border-left: 4px solid var(--primary);
        transition: all 0.3s ease;
        padding: 1.25rem;
        border-radius: 14px;
    }

    .milestone-card.completed {
        background-color: #f4fcf4;
        border-left-color: #28a745;
    }

    .milestone-card.pending {
        background-color: #fff7f5;
        border-left-color: #f25c05;
    }

    .milestone-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    /* ---------- Payment Section ---------- */
    .payment-item {
        display: flex;
        justify-content: space-between;
        padding: 0.85rem 0;
        border-bottom: 1px solid #eee;
    }

    .payment-item:last-child { border-bottom: none; }

    /* ---------- Vendor & Documents ---------- */
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

    /* Buttons */
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

    <!-- 🔹 Page Header -->
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
    
    <!-- 🔹 Project Overview -->
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

    
        <div class="progress mb-3" style="height: 16px;">
            <div 
                class="progress-bar progress-bar-striped progress-bar-animated text-center" 
                role="progressbar"
                style="width: {{ $totalPercentage }}%;"
                aria-valuenow="{{ $totalPercentage }}" 
                aria-valuemin="0" 
                aria-valuemax="100">
                {{ $totalPercentage }}%
            </div>
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

    <!-- 🔹 Project Milestones -->
    <div class="section-card shadow-sm p-4 rounded-4 bg-white">
        <div class="section-header d-flex align-items-center mb-3">
            <i class="bi bi-flag-fill me-2 text-orange fs-5"></i>
            <h5 class="m-0 fw-semibold text-dark">Project Milestones</h5>
        </div>

        @foreach($milestones as $milestone)
            <div class="milestone-card {{ $milestone->is_completed ? 'completed' : 'pending' }} p-3 rounded-3 mb-3">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="mb-0 fw-semibold d-flex align-items-center">
                        @if($milestone->is_completed)
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                        @else
                            <i class="bi bi-hourglass-split text-warning me-2"></i>
                        @endif
                        {{ $milestone->milestone_title }}
                    </h6>
                    <small class="text-muted d-block mb-2">
                        @if($milestone->is_completed)
                            Completed on {{ \Carbon\Carbon::parse($milestone->updated_at)->format('d M Y') }}
                        @else
                            Expected by {{ \Carbon\Carbon::parse($milestone->created_at)->addDays($milestone->timeframe_days)->format('d M Y') }}
                        @endif

                        <span class="badge bg-primary">{{ $milestone->payment_percentage }}% Payment</span>
                    </small>
                
                </div>

                <div class="mb-2">
                    <span class="badge bg-light text-dark border me-2">{{ ucfirst($milestone->type_of_work) }}</span>
                    <span class="badge bg-light text-dark border me-2">{{ ucfirst($milestone->work_to_be_done) }}</span>
                    
                </div>

                <p class="text-muted small mb-0">{{ $milestone->milestone_description }}</p>
            </div>
        @endforeach
    </div>

    <!-- 🔹 Payment Schedule -->
    <div class="section-card">
        <div class="section-header">
            <i class="bi bi-cash-stack text-orange"></i> Payment Schedule
        </div>
        <div class="divider"></div>

        <hr>
        <div class="d-flex justify-content-between fw-semibold">
            <span>Total Project Value:</span>
            <span>₹0</span>
        </div>
    </div>

    <!-- 🔹 Vendor + Documents -->
    <div class="section-card">
        <div class="section-header">
            <i class="bi bi-people-fill text-orange"></i> Assigned Vendor & Documents
        </div>
        <div class="divider"></div>

    </div>

</div>
@endsection
