<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="icon" type="image/png" href="{{ asset('logo/bg.png') }}">

    <title>CONSTRUCTKARO - Vendor Dashboard</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    
    <style>
        /* CSS Variables for consistent theming */
        :root {
            --orange-500: #f97316;
            --orange-600: #ea580c;
            --orange-400: #fb923c;
            --red-500: #ef4444;
            --red-600: #dc2626;
            --pink-500: #ec4899;
            --pink-600: #db2777;
            --blue-500: #3b82f6;
            --blue-600: #2563eb;
            --indigo-500: #6366f1;
            --indigo-600: #4f46e5;
            --purple-500: #8b5cf6;
            --purple-600: #7c3aed;
            --green-500: #22c55e;
            --green-600: #16a34a;
            --emerald-500: #10b981;
            --emerald-600: #059669;
            --yellow-500: #eab308;
            --yellow-600: #ca8a04;
            --slate-50: #f8fafc;
            --slate-100: #f1f5f9;
            --slate-200: #e2e8f0;
            --slate-300: #cbd5e1;
            --slate-400: #94a3b8;
            --slate-500: #64748b;
            --slate-600: #475569;
            --slate-700: #334155;
            --slate-800: #1e293b;
            --slate-900: #0f172a;
        }

         .custom-footer {
         background: rgba(15, 23, 42, 0.95);
         backdrop-filter: blur(20px);
         border-top: 1px solid var(--slate-800);
         color: white;
         position: relative;
         z-index: 10;
         margin-top: 4rem;
         padding: 3rem 0 2rem;
         }
         .footer-brand-icon {
         width: 2.5rem;
         height: 2.5rem;
         background: linear-gradient(135deg, var(--orange-500), var(--orange-600));
         border-radius: 0.5rem;
         display: flex;
         align-items: center;
         justify-content: center;
         margin-right: 0.75rem;
         }
         .footer-brand-icon i {
         color: white;
         width: 1.5rem;
         height: 1.5rem;
         }
         .footer-brand-text {
         font-size: 1.25rem;
         font-weight: 700;
         }
         .footer-description {
         color: rgba(255, 255, 255, 0.7);
         line-height: 1.6;
         }
         .footer-heading {
         font-size: 1rem;
         font-weight: 600;
         margin-bottom: 1rem;
         }
         .footer-links {
         display: flex;
         flex-direction: column;
         gap: 0.5rem;
         }
         .footer-link {
         color: rgba(255, 255, 255, 0.7);
         text-decoration: none;
         transition: color 0.3s ease;
         }
         .footer-link:hover {
         color: var(--orange-400);
         }
         .footer-contacts {
         display: flex;
         flex-direction: column;
         gap: 0.75rem;
         }
         .footer-contact {
         display: flex;
         align-items: center;
         color: rgba(255, 255, 255, 0.7);
         gap: 0.5rem;
         }
         .footer-contact i {
         width: 1rem;
         height: 1rem;
         }
         .footer-bottom {
         border-top: 1px solid var(--slate-800);
         margin-top: 3rem;
         padding-top: 2rem;
         }
         .footer-copyright {
         color: rgba(255, 255, 255, 0.6);
         margin: 0;
         }
         .footer-legal {
         display: flex;
         gap: 1.5rem;
         }
         @media (max-width: 768px) {
         .footer-legal {
         justify-content: center;
         margin-top: 1rem;
         }
         }

        .background-elements {
            position: fixed;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
            z-index: -1;
        }

        .bg-orb-1 {
            position: absolute;
            top: -12rem;
            right: -12rem;
            width: 37.5rem;
            height: 37.5rem;
            background: linear-gradient(135deg, rgba(251, 146, 60, 0.06), rgba(236, 72, 153, 0.06), rgba(239, 68, 68, 0.06));
            border-radius: 50%;
            filter: blur(60px);
            animation: pulse-slow 6s ease-in-out infinite;
        }

        .bg-orb-2 {
            position: absolute;
            bottom: -12rem;
            left: -12rem;
            width: 43.75rem;
            height: 43.75rem;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.06), rgba(99, 102, 241, 0.06), rgba(139, 92, 246, 0.06));
            border-radius: 50%;
            filter: blur(60px);
            animation: pulse-slow 6s ease-in-out infinite 1s;
        }

        .grid-overlay {
            position: fixed;
            inset: 0;
            background-image: 
                linear-gradient(rgba(99, 102, 241, 0.01) 1px, transparent 1px),
                linear-gradient(90deg, rgba(99, 102, 241, 0.01) 1px, transparent 1px);
            background-size: 60px 60px;
            z-index: -1;
        }


        .brand-icon {
            position: relative;
            width: 3rem;
            height: 3rem;
            background: linear-gradient(135deg, var(--orange-500), var(--red-500), var(--pink-500));
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 15px 35px rgba(249, 115, 22, 0.25);
            overflow: hidden;
        }

        .brand-icon::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.15), transparent);
        }

        .brand-pulse {
            position: absolute;
            top: -0.25rem;
            right: -0.25rem;
            width: 0.75rem;
            height: 0.75rem;
            background: linear-gradient(45deg, var(--green-400), var(--emerald-400));
            border-radius: 50%;
            animation: pulse-glow 2s ease-in-out infinite;
        }

        .brand-text {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--slate-900), var(--slate-800), var(--slate-700));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .brand-text-accent {
            background: linear-gradient(135deg, var(--orange-500), var(--red-500), var(--pink-500));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .brand-subtitle {
            font-size: 0.875rem;
            color: var(--slate-500);
            font-weight: 500;
        }

        /* Search Input */
        .search-container {
            position: relative;
            flex: 1;
            max-width: 32rem;
        }

        .search-input {
            width: 100%;
            height: 3rem;
            padding-left: 3rem;
            padding-right: 1rem;
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(148, 163, 184, 0.2);
            border-radius: 1rem;
            color: var(--slate-900);
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--orange-400);
            box-shadow: 0 0 0 3px rgba(251, 146, 60, 0.1), 0 10px 25px rgba(0, 0, 0, 0.1);
            background: rgba(255, 255, 255, 0.8);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--slate-400);
            width: 1.25rem;
            height: 1.25rem;
        }

        /* Notification Button */
        .notification-btn {
            position: relative;
            padding: 0.75rem;
            background: transparent;
            border: none;
            border-radius: 1rem;
            transition: all 0.2s ease;
        }

        .notification-btn:hover {
            background: rgba(251, 146, 60, 0.1);
        }

        .notification-badge {
            position: absolute;
            top: -0.25rem;
            right: -0.25rem;
            width: 1.25rem;
            height: 1.25rem;
            background: linear-gradient(45deg, var(--red-500), var(--pink-500));
            color: white;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: pulse-glow 2s ease-in-out infinite;
        }

        /* User Profile */
        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(10px);
            border-radius: 1rem;
            padding: 0.5rem;
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .user-avatar {
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            object-fit: cover;
        }

        .user-avatar-fallback {
            width: 2rem;
            height: 2rem;
            background: linear-gradient(135deg, var(--orange-500), var(--pink-500));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .logout-btn {
            padding: 0.5rem;
            background: transparent;
            border: none;
            border-radius: 0.75rem;
            color: var(--slate-600);
            transition: all 0.2s ease;
        }

        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.1);
            color: var(--red-600);
        }

        /* Notifications Dropdown */
        .notifications-dropdown {
            position: absolute;
            right: 0;
            top: 100%;
            margin-top: 0.5rem;
            width: 24rem;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 1.5rem;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            display: none;
        }

        .notifications-dropdown.show {
            display: block;
            animation: slideInFromTop 0.3s ease-out;
        }

        .notification-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid rgba(148, 163, 184, 0.2);
        }

        .notification-item {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid rgba(148, 163, 184, 0.1);
            transition: background-color 0.2s ease;
            cursor: pointer;
        }

        .notification-item:hover {
            background: rgba(248, 250, 252, 0.5);
        }

        .notification-item.unread {
            background: rgba(251, 146, 60, 0.05);
        }

        .notification-dot {
            width: 0.5rem;
            height: 0.5rem;
            border-radius: 50%;
            flex-shrink: 0;
            margin-top: 0.5rem;
        }

        .notification-dot-urgent {
            background: var(--red-500);
        }

        .notification-dot-success {
            background: var(--green-500);
        }

        .notification-dot-info {
            background: var(--blue-500);
        }

        /* Dashboard Cards */
        .dashboard-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            border-radius: 1.5rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .dashboard-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.12);
        }

        .dashboard-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .dashboard-card:hover::before {
            opacity: 1;
        }

        /* Gradient Cards */
        .gradient-card {
            background: linear-gradient(135deg, var(--blue-500), var(--indigo-600));
            color: white;
            border: none;
            box-shadow: 0 25px 50px rgba(59, 130, 246, 0.25);
        }

        .gradient-card-green {
            background: linear-gradient(135deg, var(--green-500), var(--emerald-600));
            box-shadow: 0 25px 50px rgba(34, 197, 94, 0.25);
        }

        /* Stats Cards */
        .stat-icon {
            width: 3rem;
            height: 3rem;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .stat-icon-blue {
            background: linear-gradient(135deg, var(--blue-500), var(--indigo-500));
        }

        .stat-icon-orange {
            background: linear-gradient(135deg, var(--orange-500), var(--red-500));
        }

        .stat-icon-green {
            background: linear-gradient(135deg, var(--green-500), var(--emerald-500));
        }

        .stat-icon-purple {
            background: linear-gradient(135deg, var(--purple-500), var(--pink-500));
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--slate-900);
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--slate-600);
        }

        /* Tab Navigation */
        .nav-tabs {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            border-radius: 1rem;
            padding: 0.25rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .nav-tabs .nav-link {
            border: none;
            border-radius: 0.75rem;
            color: var(--slate-600);
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
            background: transparent;
        }

        .nav-tabs .nav-link:hover {
            background: rgba(251, 146, 60, 0.1);
            color: var(--orange-600);
        }

        /* Progress Bars */
        .progress-bar-custom {
            height: 0.5rem;
            background: var(--slate-200);
            border-radius: 0.25rem;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            border-radius: 0.25rem;
            transition: width 0.7s ease;
        }

        .progress-fill-green {
            background: linear-gradient(90deg, var(--green-500), var(--emerald-500));
        }

        .progress-fill-blue {
            background: linear-gradient(90deg, var(--blue-500), var(--indigo-500));
        }

        .progress-fill-orange {
            background: linear-gradient(90deg, var(--orange-500), var(--pink-500));
        }

        .progress-fill-purple {
            background: linear-gradient(90deg, var(--purple-500), var(--pink-500));
        }

        /* Verification Steps */
        .verification-step {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .step-icon {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            flex-shrink: 0;
        }

        .step-completed {
            background: var(--green-500);
            color: white;
        }

        .step-current {
            background: var(--orange-500);
            color: white;
        }

        .step-pending {
            background: var(--slate-200);
            color: var(--slate-500);
        }

        /* Project Cards */
        .project-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            border-radius: 1.5rem;
            transition: all 0.5s ease;
            cursor: pointer;
            overflow: hidden;
            height: 100%;
        }

        .project-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
        }

        .project-image {
            height: 12rem;
            overflow: hidden;
            position: relative;
        }

        .project-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.7s ease;
        }

        .project-card:hover .project-image img {
            transform: scale(1.1);
        }

        .project-status-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            padding: 0.5rem 1rem;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            font-weight: 600;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
        }

        .status-on-track {
            background: var(--green-500);
            color: white;
        }

        .status-delayed {
            background: var(--red-500);
            color: white;
        }

        .status-at-risk {
            background: var(--orange-500);
            color: white;
        }

        .bid-status-submitted {
            background: var(--blue-500);
            color: white;
        }

        .bid-status-pending {
            background: var(--orange-500);
            color: white;
        }

        .bid-status-not-submitted {
            background: var(--slate-500);
            color: white;
        }

        /* Action Buttons */
        .btn-primary-gradient {
            background: linear-gradient(135deg, var(--orange-500), var(--pink-500));
            border: none;
            color: white;
            border-radius: 0.75rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary-gradient:hover {
            background: linear-gradient(135deg, var(--orange-600), var(--pink-600));
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(249, 115, 22, 0.3);
            color: white;
        }

        .btn-outline-custom {
            background: transparent;
            border: 1px solid var(--slate-300);
            border-radius: 0.75rem;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--slate-700);
            transition: all 0.2s ease;
        }

        .btn-outline-custom:hover {
            background: rgba(249, 115, 22, 0.05);
            border-color: var(--orange-300);
            color: var(--orange-600);
        }

        /* Document Management */
        .document-item {
            padding: 1rem;
            border-radius: 0.75rem;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: between;
        }

        .document-missing {
            background: rgba(239, 68, 68, 0.05);
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .document-uploaded {
            background: rgba(34, 197, 94, 0.05);
            border: 1px solid rgba(34, 197, 94, 0.2);
        }

        /* Activity Items */
        .activity-item {
            display: flex;
            align-items: start;
            gap: 1rem;
            padding: 1rem;
            background: rgba(248, 250, 252, 0.5);
            border-radius: 1rem;
            transition: all 0.2s ease;
            margin-bottom: 1rem;
        }

        .activity-item:hover {
            background: rgba(241, 245, 249, 0.5);
            transform: translateY(-1px);
        }

        .activity-icon {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .activity-icon-success {
            background: rgba(34, 197, 94, 0.1);
            color: var(--green-600);
        }

        .activity-icon-info {
            background: rgba(59, 130, 246, 0.1);
            color: var(--blue-600);
        }

        .activity-icon-warning {
            background: rgba(251, 146, 60, 0.1);
            color: var(--orange-600);
        }

        /* Payment Items */
        .payment-item {
            display: flex;
            align-items: center;
            justify-content: between;
            padding: 1rem;
            background: rgba(248, 250, 252, 0.5);
            border-radius: 1rem;
            margin-bottom: 0.75rem;
        }

        /* Animations */
        @keyframes pulse-slow {
            0%, 100% { opacity: 0.6; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.05); }
        }

        @keyframes pulse-glow {
            0%, 100% { opacity: 0.8; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.1); }
        }

        @keyframes slideInFromTop {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .search-container {
                max-width: 24rem;
            }
        }

      
    </style>
</head>
<body>
    @include('partials.vendor_header')
  
    <main>
        @yield('content')
    </main>


    @include('partials.footer')

      <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
  
</body>
</html>