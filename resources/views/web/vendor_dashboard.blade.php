@extends('layouts.vendor_dash.app')
@section('title', 'Vendor Dashboard | ConstructKaro')
@section('content')
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ConstructKaro - Vendor Dashboard</title>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
   :root {
   --primary-blue: #2563eb;
   --primary-orange: #ea580c;
   --success-green: #16a34a;
   --warning-amber: #d97706;
   --danger-red: #dc2626;
   --slate-50: #f8fafc;
   --slate-100: #f1f5f9;
   --slate-200: #e2e8f0;
   --slate-600: #475569;
   --slate-700: #334155;
   --slate-800: #1e293b;
   }
   .py-4 {
   padding-top: 5.5rem !important;
   padding-bottom: 1.5rem !important;
   }
   /* Header Styles */
   .header-navbar {
   background: rgba(255, 255, 255, 0.9);
   backdrop-filter: blur(10px);
   border-bottom: 1px solid rgba(226, 232, 240, 0.6);
   position: sticky;
   top: 0;
   z-index: 1050;
   }
   .brand-logo {
   background: linear-gradient(135deg, var(--primary-blue), var(--primary-orange));
   color: white;
   width: 40px;
   height: 40px;
   border-radius: 8px;
   display: flex;
   align-items: center;
   justify-content: center;
   }
   /* Stats Cards */
   .stats-card {
   background: rgba(255, 255, 255, 0.9);
   backdrop-filter: blur(10px);
   border: none;
   border-radius: 16px;
   box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
   transition: all 0.3s ease;
   height: 100%;
   }
   .stats-card:hover {
   transform: translateY(-4px) scale(1.02);
   box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
   }
   .stats-icon {
   width: 48px;
   height: 48px;
   border-radius: 12px;
   display: flex;
   align-items: center;
   justify-content: center;
   font-size: 20px;
   }
   .custom-tabs .nav-pills .nav-link {
   background: transparent;
   color: var(--slate-600);
   border-radius: 32px;
   padding: 3px 43px;
   font-weight: 500;
   transition: all 0.2s 
   ease;
   }
   .custom-tabs .nav-pills .nav-link.active {
   background: var(--primary-blue);
   color: white;
   box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
   }
   /* Tender Cards */
   .tender-card {
   background: rgba(255, 255, 255, 0.95);
   backdrop-filter: blur(10px);
   border: none;
   border-radius: 16px;
   box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
   transition: all 0.3s ease;
   height: 100%;
   overflow: hidden;
   }
   .tender-card:hover {
   transform: translateY(-8px) scale(1.02);
   box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
   }
   .tender-card .card-title:hover {
   color: var(--primary-blue);
   }
   /* Badges */
   .status-hot { background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; }
   .status-new { background: #dbeafe; color: #2563eb; border: 1px solid #bfdbfe; }
   .status-closing { background: #fed7aa; color: #ea580c; border: 1px solid #fdba74; }
   /* Progress Bars */
   .progress-modern {
   height: 8px;
   border-radius: 20px;
   background-color: var(--slate-200);
   overflow: hidden;
   }
   .progress-modern .progress-bar {
   border-radius: 20px;
   transition: width 0.6s ease;
   }
   /* Project Cards */
   .project-card {
   background: rgba(255, 255, 255, 0.95);
   backdrop-filter: blur(10px);
   border: none;
   border-radius: 16px;
   box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
   margin-bottom: 24px;
   }
   /* Chart Container */
   .chart-container {
   background: rgba(255, 255, 255, 0.9);
   backdrop-filter: blur(10px);
   border: none;
   border-radius: 16px;
   box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
   padding: 24px;
   }
   .chart-container {
   position: relative;
   height: 300px;   /* fix height */
   width: 100%;     /* full width */
   }
   /* Animations */
   .fade-in {
   animation: fadeIn 0.6s ease forwards;
   }
   @keyframes fadeIn {
   from { opacity: 0; transform: translateY(20px); }
   to { opacity: 1; transform: translateY(0); }
   }
   .slide-in-left {
   animation: slideInLeft 0.6s ease forwards;
   }
   @keyframes slideInLeft {
   from { opacity: 0; transform: translateX(-30px); }
   to { opacity: 1; transform: translateX(0); }
   }
   /* Bid probability bars */
   .probability-bar {
   height: 6px;
   background-color: var(--slate-200);
   border-radius: 10px;
   overflow: hidden;
   }
   .probability-fill {
   height: 100%;
   background: linear-gradient(90deg, var(--success-green), #22c55e);
   border-radius: 10px;
   transition: width 0.8s ease;
   }
   /* Milestone indicators */
   .milestone-dot {
   width: 12px;
   height: 12px;
   border-radius: 50%;
   transition: all 0.3s ease;
   }
   .milestone-completed { background-color: var(--success-green); }
   .milestone-progress { background-color: var(--warning-amber); }
   .milestone-pending { background-color: var(--slate-200); }
   /* Button gradients */
   .btn-gradient {
   background: linear-gradient(135deg, var(--primary-blue), #3b82f6);
   border: none;
   color: white;
   font-weight: 500;
   padding: 10px 20px;
   border-radius: 8px;
   transition: all 0.3s ease;
   }
   .btn-gradient:hover {
   background: linear-gradient(135deg, #1d4ed8, var(--primary-blue));
   transform: translateY(-1px);
   box-shadow: 0 6px 20px rgba(37, 99, 235, 0.3);
   color: white;
   }
   /* Custom scrollbar */
   ::-webkit-scrollbar {
   width: 6px;
   }
   ::-webkit-scrollbar-track {
   background: var(--slate-100);
   }
   ::-webkit-scrollbar-thumb {
   background: var(--slate-600);
   border-radius: 3px;
   }
   /* Responsive adjustments */
   @media (max-width: 768px) {
   .stats-card {
   margin-bottom: 16px;
   }
   .tender-card {
   margin-bottom: 20px;
   }
   }
   /* Content visibility classes */
   .tab-content > .tab-pane {
   display: none;
   }
   .tab-content > .tab-pane.active {
   display: block;
   animation: fadeIn 0.3s ease;
   }
</style>
<div class="container-fluid py-4">
   <!-- Stats Cards -->
   <div class="row g-4 mb-4 fade-in">
      <div class="col-md-6 col-lg-3">
         <div class="card stats-card">
            <div class="card-body p-4">
               <div class="d-flex align-items-center">
                  <div class="stats-icon bg-primary bg-opacity-10 text-primary me-3">
                     <i class="bi bi-file-earmark-text"></i>
                  </div>
                  <div class="flex-grow-1">
                     <h3 class="mb-0 fw-bold">{{$project_details_count}}</h3>
                     <p class="text-muted mb-1 small fw-medium">Active Tenders</p>
                     <small class="text-success">
                     <i class="bi bi-arrow-up-right"></i> +3 this week
                     </small>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-md-6 col-lg-3">
         <div class="card stats-card">
            <div class="card-body p-4">
               <div class="d-flex align-items-center">
                  <div class="stats-icon bg-success bg-opacity-10 text-success me-3">
                     <i class="bi bi-bullseye"></i>
                  </div>
                  <div class="flex-grow-1">
                     <h3 class="mb-0 fw-bold">0%</h3>
                     <p class="text-muted mb-1 small fw-medium">Winning Rate</p>
                     <small class="text-success">
                     <i class="bi bi-arrow-up-right"></i> +12% this month
                     </small>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-md-6 col-lg-3">
         <div class="card stats-card">
            <div class="card-body p-4">
               <div class="d-flex align-items-center">
                  <div class="stats-icon bg-warning bg-opacity-10 text-warning me-3">
                     <i class="bi bi-building"></i>
                  </div>
                  <div class="flex-grow-1">
                     <h3 class="mb-0 fw-bold">8</h3>
                     <p class="text-muted mb-1 small fw-medium">Active Projects</p>
                     <small class="text-info">2 completing soon</small>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-md-6 col-lg-3">
         <div class="card stats-card">
            <div class="card-body p-4">
               <div class="d-flex align-items-center">
                  <div class="stats-icon bg-info bg-opacity-10 text-info me-3">
                     <i class="bi bi-currency-rupee"></i>
                  </div>
                  <div class="flex-grow-1">
                     <h3 class="mb-0 fw-bold">₹0</h3>
                     <p class="text-muted mb-1 small fw-medium">Revenue</p>
                     <small class="text-success">
                     <i class="bi bi-arrow-up-right"></i> +25% vs last quarter
                     </small>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- Main Tabs -->
   <div class="custom-tabs">
      <ul class="nav nav-pills justify-content-center mb-4" id="mainTabs">
         <li class="nav-item">
            <button class="nav-link active" data-bs-target="overview">Overview</button>
         </li>
         <li class="nav-item">
            <button class="nav-link" data-bs-target="tenders">Available Tenders</button>
         </li>
         <li class="nav-item">
            <button class="nav-link" data-bs-target="bids">My Bids</button>
         </li>
         <li class="nav-item">
            <button class="nav-link" data-bs-target="projects">Active Projects</button>
         </li>
         <li class="nav-item">
            <button class="nav-link" data-bs-target="analytics">Analytics</button>
         </li>
      </ul>
      <div class="tab-content">
         <!-- Overview Tab -->
         <div class="tab-pane active" id="overview">
            <div class="row g-4 mb-4">
               <!-- Revenue Chart -->
               <div class="col-lg-8">
                  <div class="chart-container slide-in-left">
                     <h5 class="mb-3 d-flex align-items-center">
                        <i class="bi bi-graph-up text-primary me-2"></i>
                        Revenue Trend
                     </h5>
                     <canvas id="revenueChart" height="100"></canvas>
                  </div>
               </div>
               <!-- Project Distribution -->
               <div class="col-lg-4">
                  <div class="chart-container slide-in-left">
                     <h5 class="mb-3">Project Types</h5>
                     <canvas id="projectChart" class="projectChart" height="200"></canvas>
                     <div class="mt-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                           <span class="d-flex align-items-center">
                           <span class="badge bg-primary rounded-circle me-2" style="width: 12px; height: 12px;"></span>
                           Residential
                           </span>
                           <span class="fw-bold">45%</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                           <span class="d-flex align-items-center">
                           <span class="badge bg-warning rounded-circle me-2" style="width: 12px; height: 12px;"></span>
                           Commercial
                           </span>
                           <span class="fw-bold">30%</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                           <span class="d-flex align-items-center">
                           <span class="badge bg-success rounded-circle me-2" style="width: 12px; height: 12px;"></span>
                           Infrastructure
                           </span>
                           <span class="fw-bold">25%</span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- Recent Bids -->
            <div class="chart-container fade-in">
               <h5 class="mb-4">Recent Bids & Opportunities</h5>
               <div class="row g-3">
                  <div class="col-12">
                     <div class="d-flex align-items-center justify-content-between p-3 rounded-3 bg-light bg-opacity-50 border">
                        <div class="d-flex align-items-center">
                           <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-3 me-3">
                              <i class="bi bi-building"></i>
                           </div>
                           <div>
                              <h6 class="mb-0">Metro Station Complex</h6>
                              <small class="text-muted">Sep 20, 2024</small>
                           </div>
                        </div>
                        <div class="d-flex align-items-center">
                           <div class="text-end me-3">
                              <div class="fw-bold">₹12.5 Cr</div>
                              <div class="d-flex align-items-center">
                                 <div class="probability-bar me-2" style="width: 60px;">
                                    <div class="probability-fill" style="width: 75%;"></div>
                                 </div>
                                 <small class="text-muted">75%</small>
                              </div>
                           </div>
                           <span class="badge bg-primary bg-opacity-10 text-primary">Under Review</span>
                        </div>
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="d-flex align-items-center justify-content-between p-3 rounded-3 bg-light bg-opacity-50 border">
                        <div class="d-flex align-items-center">
                           <div class="bg-success bg-opacity-10 text-success p-2 rounded-3 me-3">
                              <i class="bi bi-building"></i>
                           </div>
                           <div>
                              <h6 class="mb-0">Shopping Mall Renovation</h6>
                              <small class="text-muted">Sep 15, 2024</small>
                           </div>
                        </div>
                        <div class="d-flex align-items-center">
                           <div class="text-end me-3">
                              <div class="fw-bold">₹3.8 Cr</div>
                              <div class="d-flex align-items-center">
                                 <div class="probability-bar me-2" style="width: 60px;">
                                    <div class="probability-fill" style="width: 85%;"></div>
                                 </div>
                                 <small class="text-muted">85%</small>
                              </div>
                           </div>
                           <span class="badge bg-success bg-opacity-10 text-success">Shortlisted</span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- Available Tenders Tab -->
         <div class="tab-pane" id="tenders">
            <div class="row g-4">
               <div class="col-lg-4 col-md-6">
                  <div class="card tender-card">
                     <div class="card-header border-0 bg-transparent">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                           <div class="d-flex align-items-center">
                              <span class="badge status-hot rounded-pill me-2">Hot</span>
                              <i class="bi bi-exclamation-triangle text-danger"></i>
                           </div>
                           <div class="d-flex align-items-center text-muted small">
                              <i class="bi bi-star-fill text-warning me-1"></i>
                              <span>4.8</span>
                           </div>
                        </div>
                        <h5 class="card-title mb-1">Premium Villa Complex</h5>
                        <p class="text-muted small mb-0">Green Valley Developers</p>
                     </div>
                     <div class="card-body pt-0">
                        <div class="row g-2 text-small mb-3">
                           <div class="col-6">
                              <i class="bi bi-geo-alt text-muted me-1"></i>
                              <span class="small">Sector 47, Gurgaon</span>
                           </div>
                           <div class="col-6">
                              <i class="bi bi-building text-muted me-1"></i>
                              <span class="small">12,500 sq ft</span>
                           </div>
                           <div class="col-6">
                              <i class="bi bi-currency-rupee text-muted me-1"></i>
                              <span class="small">₹3.2 - 4.1 Cr</span>
                           </div>
                           <div class="col-6">
                              <i class="bi bi-clock text-muted me-1"></i>
                              <span class="small">18 months</span>
                           </div>
                        </div>
                        <hr class="my-3">
                        <div class="d-flex justify-content-between align-items-center mb-2 small">
                           <span class="text-muted">Deadline:</span>
                           <span class="fw-medium text-danger">Oct 15, 2024</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3 small">
                           <span class="text-muted">Competing Bids:</span>
                           <span class="fw-medium">
                           <i class="bi bi-people text-muted me-1"></i>8
                           </span>
                        </div>
                        <div class="d-flex gap-2">
                           <button class="btn btn-gradient flex-grow-1">
                           <i class="bi bi-file-earmark-text me-1"></i>
                           Place Bid
                           </button>
                           <button class="btn btn-outline-secondary">
                           <i class="bi bi-eye"></i>
                           </button>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-4 col-md-6">
                  <div class="card tender-card">
                     <div class="card-header border-0 bg-transparent">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                           <div class="d-flex align-items-center">
                              <span class="badge status-new rounded-pill me-2">New</span>
                              <i class="bi bi-clock text-warning"></i>
                           </div>
                           <div class="d-flex align-items-center text-muted small">
                              <i class="bi bi-star-fill text-warning me-1"></i>
                              <span>4.6</span>
                           </div>
                        </div>
                        <h5 class="card-title mb-1">Tech Office Campus</h5>
                        <p class="text-muted small mb-0">InnoTech Solutions</p>
                     </div>
                     <div class="card-body pt-0">
                        <div class="row g-2 text-small mb-3">
                           <div class="col-6">
                              <i class="bi bi-geo-alt text-muted me-1"></i>
                              <span class="small">Whitefield, Bangalore</span>
                           </div>
                           <div class="col-6">
                              <i class="bi bi-building text-muted me-1"></i>
                              <span class="small">85,000 sq ft</span>
                           </div>
                           <div class="col-6">
                              <i class="bi bi-currency-rupee text-muted me-1"></i>
                              <span class="small">₹8.5 - 10.2 Cr</span>
                           </div>
                           <div class="col-6">
                              <i class="bi bi-clock text-muted me-1"></i>
                              <span class="small">24 months</span>
                           </div>
                        </div>
                        <hr class="my-3">
                        <div class="d-flex justify-content-between align-items-center mb-2 small">
                           <span class="text-muted">Deadline:</span>
                           <span class="fw-medium text-danger">Oct 22, 2024</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3 small">
                           <span class="text-muted">Competing Bids:</span>
                           <span class="fw-medium">
                           <i class="bi bi-people text-muted me-1"></i>12
                           </span>
                        </div>
                        <div class="d-flex gap-2">
                           <button class="btn btn-gradient flex-grow-1">
                           <i class="bi bi-file-earmark-text me-1"></i>
                           Place Bid
                           </button>
                           <button class="btn btn-outline-secondary">
                           <i class="bi bi-eye"></i>
                           </button>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-4 col-md-6">
                  <div class="card tender-card">
                     <div class="card-header border-0 bg-transparent">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                           <div class="d-flex align-items-center">
                              <span class="badge status-closing rounded-pill me-2">Closing Soon</span>
                              <i class="bi bi-exclamation-triangle text-danger"></i>
                           </div>
                           <div class="d-flex align-items-center text-muted small">
                              <i class="bi bi-star-fill text-warning me-1"></i>
                              <span>4.9</span>
                           </div>
                        </div>
                        <h5 class="card-title mb-1">Highway Bridge Construction</h5>
                        <p class="text-muted small mb-0">State PWD</p>
                     </div>
                     <div class="card-body pt-0">
                        <div class="row g-2 text-small mb-3">
                           <div class="col-6">
                              <i class="bi bi-geo-alt text-muted me-1"></i>
                              <span class="small">NH-48, Maharashtra</span>
                           </div>
                           <div class="col-6">
                              <i class="bi bi-building text-muted me-1"></i>
                              <span class="small">2.5 km span</span>
                           </div>
                           <div class="col-6">
                              <i class="bi bi-currency-rupee text-muted me-1"></i>
                              <span class="small">₹15.2 - 18.0 Cr</span>
                           </div>
                           <div class="col-6">
                              <i class="bi bi-clock text-muted me-1"></i>
                              <span class="small">30 months</span>
                           </div>
                        </div>
                        <hr class="my-3">
                        <div class="d-flex justify-content-between align-items-center mb-2 small">
                           <span class="text-muted">Deadline:</span>
                           <span class="fw-medium text-danger">Nov 5, 2024</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3 small">
                           <span class="text-muted">Competing Bids:</span>
                           <span class="fw-medium">
                           <i class="bi bi-people text-muted me-1"></i>6
                           </span>
                        </div>
                        <div class="d-flex gap-2">
                           <button class="btn btn-gradient flex-grow-1">
                           <i class="bi bi-file-earmark-text me-1"></i>
                           Place Bid
                           </button>
                           <button class="btn btn-outline-secondary">
                           <i class="bi bi-eye"></i>
                           </button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- My Bids Tab -->
         <div class="tab-pane" id="bids">
            <div class="chart-container">
               <h5 class="mb-4">Submitted Bids</h5>
               <p class="text-muted mb-4">Track the status of your submitted proposals</p>
               <div class="row g-3">
                  <div class="col-12">
                     <div class="border rounded-3 p-4 hover-effect" style="transition: all 0.2s ease;">
                        <div class="d-flex align-items-center justify-content-between">
                           <div class="d-flex align-items-center">
                              <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3 me-3">
                                 <i class="bi bi-file-earmark-text"></i>
                              </div>
                              <div>
                                 <h6 class="mb-0">Metro Station Complex</h6>
                                 <small class="text-muted">Submitted: Sep 20, 2024</small>
                              </div>
                           </div>
                           <div class="d-flex align-items-center">
                              <div class="text-end me-4">
                                 <div class="h5 mb-1">₹12.5 Cr</div>
                                 <div class="d-flex align-items-center">
                                    <div class="probability-bar me-2" style="width: 80px;">
                                       <div class="probability-fill" style="width: 75%;"></div>
                                    </div>
                                    <small class="text-muted">75%</small>
                                 </div>
                              </div>
                              <span class="badge bg-primary bg-opacity-10 text-primary">Under Review</span>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="border rounded-3 p-4 hover-effect" style="transition: all 0.2s ease;">
                        <div class="d-flex align-items-center justify-content-between">
                           <div class="d-flex align-items-center">
                              <div class="bg-success bg-opacity-10 text-success p-3 rounded-3 me-3">
                                 <i class="bi bi-file-earmark-text"></i>
                              </div>
                              <div>
                                 <h6 class="mb-0">Shopping Mall Renovation</h6>
                                 <small class="text-muted">Submitted: Sep 15, 2024</small>
                              </div>
                           </div>
                           <div class="d-flex align-items-center">
                              <div class="text-end me-4">
                                 <div class="h5 mb-1">₹3.8 Cr</div>
                                 <div class="d-flex align-items-center">
                                    <div class="probability-bar me-2" style="width: 80px;">
                                       <div class="probability-fill" style="width: 85%;"></div>
                                    </div>
                                    <small class="text-muted">85%</small>
                                 </div>
                              </div>
                              <span class="badge bg-success bg-opacity-10 text-success">Shortlisted</span>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="border rounded-3 p-4 hover-effect" style="transition: all 0.2s ease;">
                        <div class="d-flex align-items-center justify-content-between">
                           <div class="d-flex align-items-center">
                              <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-3 me-3">
                                 <i class="bi bi-file-earmark-text"></i>
                              </div>
                              <div>
                                 <h6 class="mb-0">Industrial Warehouse</h6>
                                 <small class="text-muted">Submitted: Sep 10, 2024</small>
                              </div>
                           </div>
                           <div class="d-flex align-items-center">
                              <div class="text-end me-4">
                                 <div class="h5 mb-1">₹7.2 Cr</div>
                                 <div class="d-flex align-items-center">
                                    <div class="probability-bar me-2" style="width: 80px;">
                                       <div class="probability-fill" style="width: 90%;"></div>
                                    </div>
                                    <small class="text-muted">90%</small>
                                 </div>
                              </div>
                              <span class="badge bg-warning bg-opacity-10 text-warning">Negotiation</span>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- Active Projects Tab -->
         <div class="tab-pane" id="projects">
            <div class="project-card">
               <div class="card-header border-0 bg-transparent">
                  <div class="d-flex justify-content-between align-items-start">
                     <div>
                        <h4 class="mb-1">Marina Bay Residences</h4>
                        <p class="text-muted mb-0">Coastal Developers • Goa</p>
                     </div>
                     <div class="text-end">
                        <div class="h2 text-primary mb-0">75%</div>
                        <span class="badge bg-success bg-opacity-10 text-success">On Track</span>
                     </div>
                  </div>
                  <div class="progress-modern mt-3">
                     <div class="progress-bar bg-primary" style="width: 75%"></div>
                  </div>
               </div>
               <div class="card-body">
                  <div class="row g-4">
                     <!-- Project Details -->
                     <div class="col-lg-4">
                        <h6 class="mb-3 d-flex align-items-center">
                           <i class="bi bi-building me-2"></i>
                           Project Details
                        </h6>
                        <div class="small mb-3">
                           <div class="d-flex justify-content-between mb-2">
                              <span class="text-muted">Budget:</span>
                              <span class="fw-medium">₹4.2 Cr</span>
                           </div>
                           <div class="d-flex justify-content-between mb-2">
                              <span class="text-muted">Timeline:</span>
                              <span class="fw-medium">3 months remaining</span>
                           </div>
                           <div class="d-flex justify-content-between mb-2">
                              <span class="text-muted">Team Size:</span>
                              <span class="fw-medium">24 members</span>
                           </div>
                           <div class="d-flex justify-content-between">
                              <span class="text-muted">Next Milestone:</span>
                              <span class="fw-medium text-warning">Interior Finishing</span>
                           </div>
                        </div>
                        <div class="d-flex gap-2">
                           <button class="btn btn-outline-primary btn-sm">
                           <i class="bi bi-chat-dots me-1"></i>
                           Contact Client
                           </button>
                           <button class="btn btn-outline-success btn-sm">
                           <i class="bi bi-upload me-1"></i>
                           Upload Report
                           </button>
                        </div>
                     </div>
                     <!-- Milestones -->
                     <div class="col-lg-4">
                        <h6 class="mb-3 d-flex align-items-center">
                           <i class="bi bi-flag me-2"></i>
                           Milestones
                        </h6>
                        <div class="space-y-3">
                           <div class="d-flex align-items-center mb-3">
                              <div class="milestone-dot milestone-completed me-3"></div>
                              <div class="flex-grow-1">
                                 <div class="small fw-medium">Foundation</div>
                                 <div class="text-muted" style="font-size: 0.75rem;">Jan 2024</div>
                              </div>
                              <span class="badge bg-success bg-opacity-10 text-success small">Done</span>
                           </div>
                           <div class="d-flex align-items-center mb-3">
                              <div class="milestone-dot milestone-completed me-3"></div>
                              <div class="flex-grow-1">
                                 <div class="small fw-medium">Structure</div>
                                 <div class="text-muted" style="font-size: 0.75rem;">Jun 2024</div>
                              </div>
                              <span class="badge bg-success bg-opacity-10 text-success small">Done</span>
                           </div>
                           <div class="d-flex align-items-center mb-3">
                              <div class="milestone-dot milestone-progress me-3"></div>
                              <div class="flex-grow-1">
                                 <div class="small fw-medium">Roofing</div>
                                 <div class="text-muted" style="font-size: 0.75rem;">Oct 2024</div>
                              </div>
                              <span class="badge bg-warning bg-opacity-10 text-warning small">Active</span>
                           </div>
                           <div class="d-flex align-items-center">
                              <div class="milestone-dot milestone-pending me-3"></div>
                              <div class="flex-grow-1">
                                 <div class="small fw-medium">Finishing</div>
                                 <div class="text-muted" style="font-size: 0.75rem;">Dec 2024</div>
                              </div>
                              <span class="badge bg-secondary bg-opacity-10 text-secondary small">Pending</span>
                           </div>
                        </div>
                     </div>
                     <!-- Recent Activity -->
                     <div class="col-lg-4">
                        <h6 class="mb-3 d-flex align-items-center">
                           <i class="bi bi-clock me-2"></i>
                           Recent Activity
                        </h6>
                        <div class="small">
                           <div class="mb-3">
                              <div class="text-dark">Concrete pouring completed for Block A</div>
                              <div class="text-muted" style="font-size: 0.75rem;">2 days ago</div>
                           </div>
                           <div class="mb-3">
                              <div class="text-dark">Electrical rough-in inspection passed</div>
                              <div class="text-muted" style="font-size: 0.75rem;">5 days ago</div>
                           </div>
                           <div>
                              <div class="text-dark">Plumbing installation started</div>
                              <div class="text-muted" style="font-size: 0.75rem;">1 week ago</div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- Second Project -->
            <div class="project-card">
               <div class="card-header border-0 bg-transparent">
                  <div class="d-flex justify-content-between align-items-start">
                     <div>
                        <h4 class="mb-1">Smart Office Tower</h4>
                        <p class="text-muted mb-0">Urban Spaces Ltd • Pune</p>
                     </div>
                     <div class="text-end">
                        <div class="h2 text-primary mb-0">45%</div>
                        <span class="badge bg-danger bg-opacity-10 text-danger">Behind Schedule</span>
                     </div>
                  </div>
                  <div class="progress-modern mt-3">
                     <div class="progress-bar bg-warning" style="width: 45%"></div>
                  </div>
               </div>
               <div class="card-body">
                  <div class="row g-4">
                     <div class="col-lg-4">
                        <h6 class="mb-3 d-flex align-items-center">
                           <i class="bi bi-building me-2"></i>
                           Project Details
                        </h6>
                        <div class="small mb-3">
                           <div class="d-flex justify-content-between mb-2">
                              <span class="text-muted">Budget:</span>
                              <span class="fw-medium">₹6.8 Cr</span>
                           </div>
                           <div class="d-flex justify-content-between mb-2">
                              <span class="text-muted">Timeline:</span>
                              <span class="fw-medium">8 months remaining</span>
                           </div>
                           <div class="d-flex justify-content-between mb-2">
                              <span class="text-muted">Team Size:</span>
                              <span class="fw-medium">32 members</span>
                           </div>
                           <div class="d-flex justify-content-between">
                              <span class="text-muted">Next Milestone:</span>
                              <span class="fw-medium text-warning">MEP Installation</span>
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-8">
                        <h6 class="mb-3 d-flex align-items-center">
                           <i class="bi bi-clock me-2"></i>
                           Recent Activity
                        </h6>
                        <div class="small">
                           <div class="mb-3">
                              <div class="text-dark">Weather delay for concrete work</div>
                              <div class="text-muted" style="font-size: 0.75rem;">1 day ago</div>
                           </div>
                           <div>
                              <div class="text-dark">Additional steel reinforcement ordered</div>
                              <div class="text-muted" style="font-size: 0.75rem;">3 days ago</div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- Analytics Tab -->
         <div class="tab-pane" id="analytics">
            <div class="row g-4">
               <div class="col-lg-6">
                  <div class="chart-container">
                     <h5 class="mb-3">Monthly Performance</h5>
                     <canvas id="performanceChart" height="150"></canvas>
                  </div>
               </div>
               <div class="col-lg-6">
                  <div class="chart-container">
                     <h5 class="mb-4">Key Metrics</h5>
                     <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                           <span class="small text-muted">Bid Success Rate</span>
                           <span class="fw-bold">68%</span>
                        </div>
                        <div class="progress-modern">
                           <div class="progress-bar bg-primary" style="width: 68%"></div>
                        </div>
                     </div>
                     <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                           <span class="small text-muted">Project Completion Rate</span>
                           <span class="fw-bold">92%</span>
                        </div>
                        <div class="progress-modern">
                           <div class="progress-bar bg-success" style="width: 92%"></div>
                        </div>
                     </div>
                     <div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                           <span class="small text-muted">Client Satisfaction</span>
                           <span class="fw-bold">4.8/5</span>
                        </div>
                        <div class="progress-modern">
                           <div class="progress-bar bg-warning" style="width: 96%"></div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
   document.addEventListener('DOMContentLoaded', function() {
       // -------------------- Tabs --------------------
       const tabButtons = document.querySelectorAll('#mainTabs .nav-link');
       const tabPanes = document.querySelectorAll('.tab-pane');
   
       tabButtons.forEach(button => {
           button.addEventListener('click', function() {
               const targetId = this.getAttribute('data-bs-target');
               tabButtons.forEach(btn => btn.classList.remove('active'));
               tabPanes.forEach(pane => pane.classList.remove('active'));
               this.classList.add('active');
               document.getElementById(targetId).classList.add('active');
           });
       });
   
       // -------------------- Charts --------------------
   
       // Prepare PHP data
       const months = @json(array_keys($projects_by_month->toArray()));
       const totals = @json(array_values($projects_by_month->toArray()));
   
       const monthLabels = months.map(m => 
           ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'][m-1]
       );
   
       // Revenue Chart (Line)
       const revenueCtx = document.getElementById('revenueChart').getContext('2d');
       new Chart(revenueCtx, {
           type: 'line',
           data: {
               labels: monthLabels,
               datasets: [{
                   label: 'Projects',
                   data: totals,
                   borderColor: '#2563eb',
                   backgroundColor: 'rgba(37, 99, 235, 0.1)',
                   borderWidth: 3,
                   fill: true,
                   tension: 0.4,
                   pointBackgroundColor: '#2563eb',
                   pointBorderColor: '#ffffff',
                   pointBorderWidth: 2,
                   pointRadius: 6
               }]
           },
           options: {
               responsive: true,
               maintainAspectRatio: false,
               plugins: { legend: { display: false } },
               scales: {
                   y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
                   x: { grid: { display: false } }
               }
           }
       });
   
       // Project Distribution Chart (Doughnut)
       // Use live data grouped by project_type
       const projectDistribution = @json($project_distribution ?? ['Residential'=>0,'Commercial'=>0,'Infrastructure'=>0]);
       const projectLabels = Object.keys(projectDistribution);
       const projectData = Object.values(projectDistribution);
   
       const projectCtx = document.getElementById('projectChart').getContext('2d');
       new Chart(projectCtx, {
           type: 'doughnut',
           data: {
               labels: projectLabels,
               datasets: [{
                   data: projectData,
                   backgroundColor: ['#3B82F6', '#F59E0B', '#10B981'],
                   borderWidth: 0,
                   cutout: '60%'
               }]
           },
           options: {
               responsive: true,
               maintainAspectRatio: false,
               plugins: { legend: { display: false } }
           }
       });
   
       // Performance Chart (Bar)
       // Example: monthly project count (same as revenue)
       const performanceCtx = document.getElementById('performanceChart').getContext('2d');
       new Chart(performanceCtx, {
           type: 'bar',
           data: {
               labels: monthLabels,
               datasets: [{
                   label: 'Projects',
                   data: totals,
                   backgroundColor: '#3B82F6',
                   borderRadius: 4,
                   borderSkipped: false
               }]
           },
           options: {
               responsive: true,
               maintainAspectRatio: false,
               plugins: { legend: { display: false } },
               scales: {
                   y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
                   x: { grid: { display: false } }
               }
           }
       });
   
       // -------------------- Hover Effects --------------------
       const cards = document.querySelectorAll('.tender-card, .stats-card');
       cards.forEach(card => {
           card.addEventListener('mouseenter', () => card.style.transform = 'translateY(-8px) scale(1.02)');
           card.addEventListener('mouseleave', () => card.style.transform = 'translateY(0) scale(1)');
       });
   
       const bidItems = document.querySelectorAll('.hover-effect');
       bidItems.forEach(item => {
           item.addEventListener('mouseenter', () => {
               item.style.borderColor = '#2563eb';
               item.style.backgroundColor = 'rgba(37, 99, 235, 0.05)';
           });
           item.addEventListener('mouseleave', () => {
               item.style.borderColor = '#e2e8f0';
               item.style.backgroundColor = 'transparent';
           });
       });
   
       // -------------------- Progress Bars --------------------
       const progressBars = document.querySelectorAll('.progress-bar, .probability-fill');
       const observer = new IntersectionObserver(entries => {
           entries.forEach(entry => {
               if (entry.isIntersecting) {
                   const bar = entry.target;
                   const width = bar.style.width;
                   bar.style.width = '0%';
                   setTimeout(() => { bar.style.width = width; }, 100);
               }
           });
       });
       progressBars.forEach(bar => observer.observe(bar));
   
       // -------------------- Notifications --------------------
       function showNotification(message, type='info') {
           const notification = document.createElement('div');
           notification.className = `alert alert-${type} position-fixed`;
           notification.style.cssText = 'top:20px; right:20px; z-index:1060; min-width:300px;';
           notification.innerHTML = `
               <div class="d-flex align-items-center">
                   <i class="bi bi-check-circle me-2"></i>
                   ${message}
                   <button type="button" class="btn-close ms-auto" onclick="this.parentElement.parentElement.remove()"></button>
               </div>`;
           document.body.appendChild(notification);
           setTimeout(() => notification.remove(), 5000);
       }
   
       document.addEventListener('click', e => {
           if (e.target.closest('.btn-gradient')) showNotification('Bid submission form would open here','success');
       });
   
   });
</script>
@endsection