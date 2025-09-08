@extends('layouts.cust_dash.app')

@section('title', 'Customer Dashboard | ConstructKaro')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
    .py-4 {
    padding-top: 5.5rem !important;
    padding-bottom: 1.5rem !important;
}
:root {
    --gradient-primary: linear-gradient(135deg, #1e293b, #f97316);
    --card-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
    --border-radius: 12px;
    --transition: all 0.3s ease;
}

.dashboard-header {
    background: var(--gradient-primary);
    color: white;
    padding: 2rem;
    border-radius: var(--border-radius);
    box-shadow: var(--card-shadow);
    position: relative;
    overflow: hidden;
}

.dashboard-header::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 200px;
    height: 200px;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
    transform: translate(50px, -50px);
}

.custom-nav-tabs {
    border: none;
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--card-shadow);
    padding: 0.5rem;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 0.25rem;
}

.custom-nav-tabs .nav-link {
    border: none;
    border-radius: 8px;
    padding: 0.75rem 1rem;
    color: #64748b;
    font-weight: 500;
    transition: var(--transition);
    text-align: center;
    background: transparent;
}

.custom-nav-tabs .nav-link.active {
    background: #fed7aa;
    color: #ea580c;
    box-shadow: 0 2px 4px rgba(249,115,22,0.1);
}

.modern-card {
    border: none;
    border-radius: var(--border-radius);
    box-shadow: var(--card-shadow);
    transition: var(--transition);
    background: white;
    opacity: 0;
    transform: translateY(20px);
}

.modern-card.show {
    opacity: 1;
    transform: translateY(0);
}

.card-header { background: transparent; border-bottom: 1px solid #e2e8f0; }

.payment-item { display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e2e8f0; }
.payment-item:last-child { border-bottom: none; }

.communication-item { background: #f1f5f9; border-radius: 8px; padding: 1rem; border-left: 4px solid #3b82f6; }
.communication-item:nth-child(2) { border-left-color: #8b5cf6; background: #faf5ff; }

.chat-btn {
    background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    transition: var(--transition);
}

.guarantee-card { background: linear-gradient(135deg, #f0fdf4, #dcfce7); border: 1px solid #22c55e; border-left: 4px solid #22c55e; }

@media (max-width: 768px) {
    .dashboard-header { padding: 1.5rem; }
    .custom-nav-tabs { grid-template-columns: 1fr; }
}
</style>

<div class="min-vh-100" style="background-color: #f8f9fa;">
    <div class="container py-4" style="max-width: 1398px;">
        <!-- Dashboard Header -->
        <div class="dashboard-header mb-4">
            <div class="d-flex align-items-start justify-content-between">
                <div>
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-person-circle me-3" style="font-size:2rem;"></i>
                        <h1 class="h3 mb-0 fw-semibold">Welcome, {{ $cust_details->full_name }}</h1>
                    </div>
                    <p class="text-white-50 mb-3">Track your project progress, payments & connect with your vendor</p>
                    <div class="d-flex flex-column gap-2">
                        <div class="d-flex align-items-center"><i class="bi bi-envelope me-2"></i><small>{{ $cust_details->email }}</small></div>
                        <div class="d-flex align-items-center"><i class="bi bi-telephone me-2"></i><small>{{ $cust_details->phone_number }}</small></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Project Tabs -->
        <ul class="nav nav-tabs custom-nav-tabs mb-4" id="projectTabs" role="tablist">
            @foreach($projects as $index => $project)
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $index==0?'active':'' }}" 
                        id="project-{{ $project->id }}-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#project-{{ $project->id }}"
                        type="button">
                    {{ $project->project_name ?? 'Project '.$project->id }}
                </button>
            </li>
            @endforeach
        </ul>

        <div class="tab-content">
            @foreach($projects as $index => $project)
            <div class="tab-pane fade {{ $index==0?'show active':'' }}" id="project-{{ $project->id }}" role="tabpanel">
                <div class="row g-4">
                    <!-- Project Progress Card -->
                    <div class="col-lg-6">
                        <div class="card modern-card h-100">
                            <div class="card-header">
                                <h6 class="mb-0 fw-semibold">📊 Project Progress</h6>
                            </div>
                            <div class="card-body">
                              
                                <div class="progress-step ">
                                    <div class="step-icon"><i class="bi "></i></div>
                                    <div class="flex-grow-1">
                                        <div class="fw-medium"></div>
                                        <small class=""></small>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <!-- Payment Card -->
                    <div class="col-lg-6">
                        <div class="card modern-card h-100">
                            <div class="card-header"><h6 class="mb-0 fw-semibold">💰 Payment Schedule</h6></div>
                            <div class="card-body">
                               
                                <div class="payment-item">
                                    <div class="d-flex align-items-center">
                                        <i class="bi  me-2"></i>
                                        <span class="fw-medium"></span>
                                    </div>
                                    <span class="fw-semibold"></span>
                                </div>
                               
                                <hr>
                                <div class="d-flex justify-content-between fw-semibold">
                                    <span>Total Project Value</span>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Communication Card -->
                    <div class="col-lg-6">
                        <div class="card modern-card h-100">
                            <div class="card-header"><h6 class="mb-0 fw-semibold">💬 Communication</h6></div>
                            <div class="card-body">
                               
                                <div class="communication-item mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi  me-2"></i>
                                        <span class="fw-medium"></span>
                                    </div>
                                    <p class="small text-muted mb-0"></p>
                                </div>
                               
                                <button class="btn btn-primary w-100 chat-btn">
                                    <i class="bi bi-chat-dots me-2"></i> Open Chat
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Guarantee Card -->
                    <div class="col-lg-6">
                        <div class="card guarantee-card h-100">
                            <div class="card-header bg-transparent">
                                <h6 class="mb-0 fw-semibold text-success"><i class="bi bi-shield-check me-2"></i> ConstructKaro Guarantee</h6>
                            </div>
                            <div class="card-body">
                              
                                <div class="guarantee-item mb-3">
                                    <div class="d-flex align-items-start">
                                        <i class="bi  text-success me-2 mt-1"></i>
                                        <div>
                                            <div class="fw-medium text-success"></div>
                                            <small class="text-success"></small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="alert alert-success mb-0">
                                    <small></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab animation
    const tabButtons = document.querySelectorAll('[data-bs-toggle="tab"]');
    tabButtons.forEach(button => {
        button.addEventListener('shown.bs.tab', e => {
            const targetTab = document.querySelector(e.target.getAttribute('data-bs-target'));
            const cards = targetTab.querySelectorAll('.modern-card');
            cards.forEach((card, index) => {
                setTimeout(() => card.classList.add('show'), index*100);
            });
        });
    });

    // Initial animation
    const initialCards = document.querySelectorAll('.tab-pane.active .modern-card');
    initialCards.forEach((card, index) => setTimeout(()=>card.classList.add('show'), index*100));

    // Chat button
    document.querySelectorAll('.chat-btn').forEach(btn => {
        btn.addEventListener('click', () => alert('Chat feature will be available soon!'));
    });
});
</script>
@endsection
