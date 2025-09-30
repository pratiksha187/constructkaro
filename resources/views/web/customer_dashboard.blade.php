@extends('layouts.cust_dash.app')

@section('title', 'Customer Dashboard | ConstructKaro')

@section('content')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard | ConstructKaro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --gradient-primary: linear-gradient(135deg, #1e293b, #f97316);
            --card-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
            --border-radius: 12px;
            --transition: all 0.3s ease;
        }
/* 
        body {
            background-color: #f8f9fa;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        } */

        .container-custom {
            max-width: 1398px;
            margin: 0 auto;
            padding: 1.5rem;
        }

        .dashboard-header {
            background: var(--gradient-primary);
            color: white;
            padding: 2rem;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            position: relative;
            overflow: hidden;
            margin-bottom: 1.5rem;
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

        .dashboard-header-content {
            position: relative;
            z-index: 10;
        }

        .welcome-title {
            font-size: 1.875rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .contact-info {
            color: rgba(255,255,255,0.8);
            font-size: 0.875rem;
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
            margin-bottom: 2rem;
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
            text-decoration: none;
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
            margin-bottom: 1.5rem;
            opacity: 0;
            transform: translateY(20px);
        }

        .modern-card.show {
            opacity: 1;
            transform: translateY(0);
        }

        .card-header-modern {
            background: transparent;
            border-bottom: 1px solid #e2e8f0;
            padding: 1.25rem 1.25rem 1rem;
        }

        .card-title-modern {
            font-size: 1.125rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .progress-modern {
            height: 1.25rem;
            background-color: #e2e8f0;
            border-radius: 0.625rem;
            overflow: hidden;
            margin-bottom: 1rem;
        }

        .progress-bar-modern {
            height: 100%;
            background: linear-gradient(90deg, #22c55e, #16a34a);
            border-radius: 0.625rem;
            transition: width 0.5s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .payment-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .payment-item:last-child {
            border-bottom: none;
        }

        .communication-item {
            background: #f1f5f9;
            border-radius: 8px;
            padding: 1rem;
            border-left: 4px solid #3b82f6;
            margin-bottom: 1rem;
        }

        .communication-item:nth-child(2n) {
            border-left-color: #8b5cf6;
            background: #faf5ff;
        }

        .chat-btn {
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: var(--transition);
            color: white;
            width: 100%;
        }

        .chat-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
        }

        .guarantee-card {
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            border: 1px solid #22c55e;
            border-left: 4px solid #22c55e;
        }

        .guarantee-content {
            color: #15803d;
        }

        .vendor-card {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 1rem;
            background: #fff;
            box-shadow: var(--card-shadow);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            margin-bottom: 1rem;
        }

        .vendor-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
        }

        .vendor-avatar {
            font-size: 2rem;
            color: #f97316;
            background: #fff7ed;
            border-radius: 50%;
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .tab-content-area {
            display: none;
        }

        .tab-content-area.active {
            display: block;
        }

        .badge-warning {
            background-color: #fef3c7;
            color: #d97706;
            padding: 0.375rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
            border-radius: 0.5rem;
            padding: 0.75rem;
            margin: 0;
        }

        @media (max-width: 768px) {
            .dashboard-header { 
                padding: 1.5rem; 
            }
            .custom-nav-tabs { 
                grid-template-columns: 1fr; 
            }
            .container-custom {
                padding: 1rem;
            }
        }
    </style>

    <div class="min-vh-100">
        <div class="container-custom">
            
            <!-- Dashboard Header -->
            <div class="dashboard-header">
                <div class="dashboard-header-content">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-person-circle me-3" style="font-size:2rem;"></i>
                                <h1 class="welcome-title" id="customerName">Welcome, Rajesh Kumar</h1>
                            </div>
                            <p class="contact-info mb-3">Track your project progress, payments & connect with your vendor</p>
                            <div class="d-flex flex-column gap-2">
                                <div class="d-flex align-items-center contact-info">
                                    <i class="bi bi-envelope me-2"></i>
                                    <small id="customerEmail">rajesh.kumar@email.com</small>
                                </div>
                                <div class="d-flex align-items-center contact-info">
                                    <i class="bi bi-telephone me-2"></i>
                                    <small id="customerPhone">+91 98765 43210</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Project Tabs -->
            <div class="custom-nav-tabs" id="projectTabs">
                <!-- Tabs will be generated by JavaScript -->
            </div>

            <!-- Tab Content -->
            <div id="tabContent">
                <!-- Content will be generated by JavaScript -->
            </div>

            <!-- Vendors List -->
            <div class="col-12 mt-4">
                <div class="modern-card show">
                    <div class="card-header-modern d-flex justify-content-between align-items-center">
                        <h6 class="card-title-modern">👷 Vendors List</h6>
                        <span class="badge-warning">
                            Available after project confirmation
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row g-3" id="vendorsList">
                            <!-- Vendors will be generated by JavaScript -->
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mock Data
        const mockCustomer = {
            full_name: 'Rajesh Kumar',
            email: 'rajesh.kumar@email.com',
            phone_number: '+91 98765 43210'
        };

        const mockProjects = [
            {
                id: '1',
                project_name: 'Residential Villa Construction',
                progress: 35,
                current_stage: 'Foundation & Structure',
                total_value: 2500000,
                payments: [
                    { id: '1', milestone: 'Project Initiation', amount: 50000, status: 'paid' },
                    { id: '2', milestone: 'Foundation Work', amount: 150000, status: 'pending' },
                    { id: '3', milestone: 'Structure Completion', amount: 200000, status: 'pending' },
                    { id: '4', milestone: 'Final Handover', amount: 100000, status: 'pending' }
                ],
                messages: [
                    { id: '1', sender: 'Construction Manager', content: 'Foundation work has started as per schedule. Expected completion by next week.' },
                    { id: '2', sender: 'Project Coordinator', content: 'Please review and approve the revised timeline for the electrical work.' },
                    { id: '3', sender: 'Quality Inspector', content: 'Quality check completed for the foundation. All parameters are within specifications.' }
                ]
            },
            {
                id: '2',
                project_name: 'Commercial Office Building',
                progress: 15,
                current_stage: 'Site Preparation',
                total_value: 5000000,
                payments: [
                    { id: '5', milestone: 'Site Survey', amount: 25000, status: 'paid' },
                    { id: '6', milestone: 'Excavation', amount: 200000, status: 'pending' }
                ],
                messages: [
                    { id: '4', sender: 'Site Engineer', content: 'Site survey completed. Excavation work will begin next Monday.' }
                ]
            },
            {
                id: '3',
                project_name: 'Home Renovation',
                progress: 80,
                current_stage: 'Finishing Work',
                total_value: 800000,
                payments: [
                    { id: '7', milestone: 'Demolition', amount: 50000, status: 'paid' },
                    { id: '8', milestone: 'Renovation Work', amount: 400000, status: 'paid' },
                    { id: '9', milestone: 'Final Touches', amount: 100000, status: 'pending' }
                ],
                messages: [
                    { id: '5', sender: 'Interior Designer', content: 'Paint work is 90% complete. Final inspection scheduled for this Friday.' }
                ]
            }
        ];

        const mockVendors = [
            { id: '1', name: 'Suresh Construction', specialization: 'Civil Contractor', email: 'suresh@constructco.in', phone: '+91 98765 11111' },
            { id: '2', name: 'Modern Electricals', specialization: 'Electrical Contractor', email: 'info@modernelectric.in', phone: '+91 98765 22222' },
            { id: '3', name: 'Prime Plumbing Services', specialization: 'Plumbing Contractor', email: 'prime@plumbing.in', phone: '+91 98765 33333' },
            { id: '4', name: 'Elite Interiors', specialization: 'Interior Designer', email: 'contact@eliteinteriors.in', phone: '+91 98765 44444' }
        ];

        let activeTab = mockProjects[0]?.id || '1';

        // Initialize the application
        function initializeApp() {
            renderTabs();
            renderTabContent();
            renderVendors();
            showTab(activeTab);
        }

        // Render project tabs
        function renderTabs() {
            const tabsContainer = document.getElementById('projectTabs');
            tabsContainer.innerHTML = mockProjects.map(project => `
                <a href="#" class="nav-link ${project.id === activeTab ? 'active' : ''}" 
                   onclick="showTab('${project.id}')" data-tab="${project.id}">
                    ${project.project_name}
                </a>
            `).join('');
        }

        // Render tab content
        function renderTabContent() {
            const contentContainer = document.getElementById('tabContent');
            contentContainer.innerHTML = mockProjects.map(project => `
                <div class="tab-content-area ${project.id === activeTab ? 'active' : ''}" id="tab-${project.id}">
                    <div class="row g-4">
                        <!-- Project Progress Card -->
                        <div class="col-lg-6">
                            <div class="modern-card">
                                <div class="card-header-modern">
                                    <h6 class="card-title-modern">📊 Project Progress</h6>
                                </div>
                                <div class="card-body">
                                    <div class="progress-modern">
                                        <div class="progress-bar-modern" style="width: ${project.progress}%;">
                                            ${project.progress}%
                                        </div>
                                    </div>
                                    <small class="text-muted">Current stage: ${project.current_stage}</small>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Card -->
                        <div class="col-lg-6">
                            <div class="modern-card">
                                <div class="card-header-modern">
                                    <h6 class="card-title-modern">💰 Payment Schedule</h6>
                                </div>
                                <div class="card-body">
                                    ${project.payments.map(payment => `
                                        <div class="payment-item">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-currency-rupee me-2"></i>
                                                <span class="fw-medium">${payment.milestone}</span>
                                            </div>
                                            <span class="fw-semibold">₹${payment.amount.toLocaleString('en-IN')}</span>
                                        </div>
                                    `).join('')}
                                    <hr>
                                    <div class="d-flex justify-content-between fw-semibold">
                                        <span>Total Project Value</span>
                                        <span>₹${project.total_value.toLocaleString('en-IN')}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Communication Card -->
                        <div class="col-lg-6">
                            <div class="modern-card">
                                <div class="card-header-modern">
                                    <h6 class="card-title-modern">💬 Communication</h6>
                                </div>
                                <div class="card-body">
                                    ${project.messages.map((message, index) => `
                                        <div class="communication-item">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="bi bi-person-circle me-2"></i>
                                                <span class="fw-medium">${message.sender}</span>
                                            </div>
                                            <p class="small text-muted mb-0">${message.content}</p>
                                        </div>
                                    `).join('')}
                                    <button class="chat-btn" onclick="handleChatClick()">
                                        <i class="bi bi-chat-dots me-2"></i> Open Chat
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Guarantee Card -->
                        <div class="col-lg-6">
                            <div class="modern-card guarantee-card">
                                <div class="card-header-modern bg-transparent">
                                    <h6 class="card-title-modern guarantee-content">
                                        <i class="bi bi-shield-check me-2"></i> ConstructKaro Guarantee
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3 guarantee-content">
                                        <div class="fw-medium">Safe & Secure Payments</div>
                                        <small>Your payments are protected with escrow until work is completed.</small>
                                    </div>
                                    <div class="alert-success">
                                        <small>Guaranteed vendor quality & timely delivery.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        // Render vendors
        function renderVendors() {
            const vendorsContainer = document.getElementById('vendorsList');
            vendorsContainer.innerHTML = mockVendors.map(vendor => `
                <div class="col-md-6 col-lg-4">
                    <div class="vendor-card">
                        <div class="d-flex align-items-center mb-3">
                            <div class="vendor-avatar me-3">
                                <i class="bi bi-person-circle"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-semibold">${vendor.name}</h6>
                                <small class="text-muted">${vendor.specialization}</small>
                            </div>
                        </div>
                        <div class="mb-2">
                            <i class="bi bi-envelope text-primary me-2"></i>
                            <small>${vendor.email}</small>
                        </div>
                        <div>
                            <i class="bi bi-telephone text-success me-2"></i>
                            <small>${vendor.phone}</small>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        // Show specific tab
        function showTab(tabId) {
            // Update active tab
            activeTab = tabId;
            
            // Update tab buttons
            document.querySelectorAll('.nav-link').forEach(tab => {
                tab.classList.remove('active');
            });
            document.querySelector(`[data-tab="${tabId}"]`).classList.add('active');
            
            // Update tab content
            document.querySelectorAll('.tab-content-area').forEach(content => {
                content.classList.remove('active');
            });
            document.getElementById(`tab-${tabId}`).classList.add('active');
            
            // Animate cards
            setTimeout(() => {
                const cards = document.querySelectorAll(`#tab-${tabId} .modern-card`);
                cards.forEach((card, index) => {
                    setTimeout(() => card.classList.add('show'), index * 100);
                });
            }, 50);
        }

        // Handle chat button click
        function handleChatClick() {
            alert('Chat feature will be available soon!');
        }

        // Initialize app when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            initializeApp();
            
            // Initial animation for first tab
            setTimeout(() => {
                const initialCards = document.querySelectorAll('.tab-content-area.active .modern-card');
                initialCards.forEach((card, index) => {
                    setTimeout(() => card.classList.add('show'), index * 100);
                });
            }, 100);
        });
    </script>
@endsection