@extends('layouts.cust_dash.app')
@section('title', 'Project Questionnaire | ConstructKaro')
@section('content')
<style>
.main-content {
    margin-top: 100px; /* or match your header height */
}
</style>
<main class="container main-content">

    <!-- Main Content -->

<input type="hidden" name="project_id" id="project_id" value="{{ session('project_id') }}">

<!-- 
<pre>
{{ print_r(session()->all(), true) }}


</pre> -->

        <!-- Welcome Section & Customer Stats -->
        <div class="row mb-4" >
            <!-- Welcome Card -->
            <div class="col-lg-8">
                <div class="welcome-card p-4">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&h=150&fit=crop&crop=face" 
                                 alt="Rajesh Kumar" class="welcome-avatar" id="welcomeAvatar">
                        </div>
                        <div class="col">
                           <h2 class="mb-2" style="font-size: 1.875rem; font-weight: 700; color: var(--slate-900);">
                                Welcome back, 
                                
                                <span id="welcomeName">

                                
                                </span>!
                            </h2>

                            <p class="mb-3" style="color: var(--slate-600); font-size: 1.125rem;">
                                Here's an overview of your construction projects
                            </p>
                            <div class="d-flex flex-wrap" style="gap: 1rem;">
                                <div class="contact-chip">
                                    <i data-lucide="mail" style="width: 1rem; height: 1rem; color: var(--slate-600);"></i>
                                    <span style="color: var(--slate-700);" id="userEmail"></span>
                                </div>
                                <div class="contact-chip">
                                    <i data-lucide="phone" style="width: 1rem; height: 1rem; color: var(--slate-600);"></i>
                                    <span style="color: var(--slate-700);" id="userPhone"></span>
                                </div>
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="col-lg-4">
                <div class="dashboard-card p-4 h-100">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="mb-0" style="color: var(--slate-900); font-weight: 600;">Project Overview</h5>
                    </div>
                    <div class="d-flex flex-column" style="gap: 1rem;">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center" style="gap: 0.75rem;">
                                <div class="stat-icon stat-icon-blue">
                                    <i data-lucide="bar-chart-3" class="text-white" style="width: 1.25rem; height: 1.25rem;"></i>
                                </div>
                               
                            <div>
                                <p class="stat-value mb-0" id="totalProjects">
                                    {{ session('totalProjects') }}
                                </p>

                                <p class="stat-label mb-0">Total Projects</p>
                            </div>


                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center" style="gap: 0.75rem;">
                                <div class="stat-icon stat-icon-orange">
                                    <i data-lucide="activity" class="text-white" style="width: 1.25rem; height: 1.25rem;"></i>
                                </div>
                                <div>
                                    <p class="stat-value mb-0" id="activeProjects">{{ session('totalProjects') }}</p>
                                    <p class="stat-label mb-0">Active Projects</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center" style="gap: 0.75rem;">
                                <div class="stat-icon stat-icon-green">
                                    <i data-lucide="check-circle" class="text-white" style="width: 1.25rem; height: 1.25rem;"></i>
                                </div>
                                <div>
                                    <p class="stat-value mb-0" id="completedProjects">{{ session('totalProjects') }}</p>
                                    <p class="stat-label mb-0">Completed</p>
                                </div>
                            </div>
                        </div>

                        <div class="pt-3 border-top" style="border-color: var(--slate-200) !important;">
                            <p class="mb-0" style="font-size: 0.75rem; color: var(--slate-500);">
                                Member since <span id="memberSince">Jan 2024</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Projects Section -->
        <div class="section-header d-flex align-items-center justify-content-between mb-4">
            <div>
                <h3 class="section-title">Your Projects</h3>
                <p class="section-subtitle mb-0">Track progress and manage your construction projects</p>
            </div>
            <div class="d-flex" style="gap: 0.5rem;">
                <button class="action-btn">
                    <i data-lucide="filter" style="width: 1rem; height: 1rem;" class="me-2"></i>
                    Filter
                </button>
                <button class="action-btn">
                    <i data-lucide="download" style="width: 1rem; height: 1rem;" class="me-2"></i>
                    Export
                </button>
            </div>
        </div>

        <!-- Projects Grid -->
        <div class="row mb-5" id="projectsGrid">
            <!-- Projects will be populated by JavaScript -->
        </div>

        <!-- Recent Activity -->
        <div class="dashboard-card">
            <div class="p-4 border-bottom" style="border-color: rgba(148, 163, 184, 0.2) !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="mb-1" style="color: var(--slate-900); font-weight: 600;">Recent Activity</h5>
                        <p class="mb-0" style="color: var(--slate-600); font-size: 0.875rem;">Latest updates from your projects</p>
                    </div>
                    <button class="action-btn">
                        <i data-lucide="arrow-right" style="width: 1rem; height: 1rem;"></i>
                        View All
                    </button>
                </div>
            </div>
            <div class="p-4">
                <div id="recentActivityList">
                    <!-- Recent activity will be populated by JavaScript -->
                </div>
            </div>
        </div>
    </main>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

@endsection