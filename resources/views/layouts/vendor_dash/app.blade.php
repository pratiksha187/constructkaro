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

        /* Global Styles */
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            overflow-x: hidden;
            font-size: 14px;
            background: linear-gradient(135deg, var(--slate-50) 0%, rgba(239, 246, 255, 0.3) 50%, rgba(238, 242, 255, 0.2) 100%);
        }

        /* Enhanced Background */
        .dashboard-background {
            position: fixed;
            inset: 0;
            z-index: -2;
        }
           /* Footer */
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

        /* Enhanced Header */
        .enhanced-header {
            position: relative;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(40px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 10px 30px rgba(148, 163, 184, 0.15);
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

        .nav-tabs .nav-link.active {
            background: linear-gradient(135deg, var(--orange-500), var(--pink-500));
            color: white;
            box-shadow: 0 10px 25px rgba(249, 115, 22, 0.3);
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

        @media (max-width: 768px) {
            .search-container {
                display: none !important;
            }
            
            .user-profile .user-info {
                display: none !important;
            }
            
            .notifications-dropdown {
                width: 20rem;
                right: -2rem;
            }
        }

        @media (max-width: 576px) {
            .brand-text {
                font-size: 1.25rem;
            }
            
            .notifications-dropdown {
                width: 18rem;
                right: -1rem;
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--slate-100);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--slate-300);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--slate-400);
        }

        /* Tab Content */
        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
            animation: fadeIn 0.3s ease-in-out;
        }

        /* Achievement Badges */
        .achievement-badge {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            border-radius: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .achievement-gold {
            background: rgba(251, 191, 36, 0.1);
            border: 1px solid rgba(251, 191, 36, 0.2);
        }

        .achievement-blue {
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        .achievement-green {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.2);
        }

        /* Star Rating */
        .star-rating {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .star-filled {
            color: #fbbf24;
        }

        /* Upload Zone */
        .upload-zone {
            border: 2px dashed var(--slate-300);
            border-radius: 1rem;
            padding: 2rem;
            text-align: center;
            background: rgba(248, 250, 252, 0.5);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .upload-zone:hover {
            border-color: var(--orange-400);
            background: rgba(251, 146, 60, 0.05);
        }

        .upload-zone.dragover {
            border-color: var(--orange-500);
            background: rgba(251, 146, 60, 0.1);
            transform: scale(1.02);
        }
    </style>
</head>
<body>
    <!-- Background Elements -->
    <div class="dashboard-background"></div>
    <div class="background-elements">
        <div class="bg-orb-1"></div>
        <div class="bg-orb-2"></div>
    </div>
      @include('partials.vendor_header')
    <div class="grid-overlay"></div>

    <!-- Enhanced Header -->
  

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

      <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        // Initialize Lucide icons
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
            initializeApp();
        });

        // Application state
        let showNotifications = false;
        let activeTab = 'overview';

        // Mock vendor data
        const vendorData = {
            companyName: "XYZ Construction Pvt. Ltd.",
            email: "info@xyzconstruction.com",
            phone: "+91 99887 76543",
            location: "Mumbai, Maharashtra",
            established: "2018",
            employeeCount: "50-100",
            specialization: ["Residential", "Commercial", "Renovation"],
            verificationStatus: "Verification Pending",
            profileCompletion: 65,
            rating: 4.7,
            totalProjects: 47,
            activeProjects: 12,
            completedProjects: 35,
            totalEarnings: "₹2.8 Cr",
            avatar: "https://images.unsplash.com/photo-1560250097-0b93528c311a?w=150&h=150&fit=crop"
        };

        // Missing documents
        const missingDocuments = [
            { name: "Turnover Certificate", required: true, uploadedAt: null },
            { name: "Work Reference 2", required: true, uploadedAt: null },
            { name: "GST Registration", required: false, uploadedAt: "2024-01-15" },
            { name: "Insurance Certificate", required: true, uploadedAt: "2024-01-10" }
        ];

        // Verification steps
        const verificationSteps = [
            {
                step: 1,
                title: "Profile Created",
                description: "10 June 2025, 09:15 AM",
                status: "completed"
            },
            {
                step: 2,
                title: "Basic Information Submitted",
                description: "10 June 2025, 09:30 AM",
                status: "completed"
            },
            {
                step: 3,
                title: "Document Verification",
                description: "Awaiting missing documents",
                status: "current"
            },
            {
                step: 4,
                title: "Background Check",
                description: "Pending",
                status: "pending"
            },
            {
                step: 5,
                title: "Verification Complete",
                description: "Pending",
                status: "pending"
            }
        ];

        // Available projects for bidding
        const availableProjects = [
            {
                id: "BID001",
                title: "Luxury Villa Construction",
                location: "Juhu, Mumbai",
                budget: "₹3.2 Cr - ₹3.8 Cr",
                timeline: "14 months",
                postedDate: "2024-01-22",
                deadline: "2024-01-30",
                clientRating: 4.9,
                bidsSubmitted: 8,
                description: "Modern 4BHK villa with contemporary design and premium finishes",
                requirements: ["Residential Experience", "₹1Cr+ Turnover", "Mumbai Location"],
                bidStatus: "pending",
                image: "https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=400&h=250&fit=crop"
            },
            {
                id: "BID002",
                title: "Office Complex Renovation",
                location: "BKC, Mumbai",
                budget: "₹1.2 Cr - ₹1.5 Cr",
                timeline: "8 months",
                postedDate: "2024-01-20",
                deadline: "2024-01-28",
                clientRating: 4.6,
                bidsSubmitted: 12,
                description: "Complete renovation of 3-floor office space with modern amenities",
                requirements: ["Commercial Experience", "Interior Design", "Quick Turnaround"],
                bidStatus: "submitted",
                image: "https://images.unsplash.com/photo-1541888946425-d81bb19240f5?w=400&h=250&fit=crop"
            },
            {
                id: "BID003",
                title: "Residential Tower Construction",
                location: "Thane, Mumbai",
                budget: "₹25 Cr - ₹30 Cr",
                timeline: "30 months",
                postedDate: "2024-01-18",
                deadline: "2024-01-25",
                clientRating: 4.8,
                bidsSubmitted: 15,
                description: "22-floor residential tower with 2BHK and 3BHK apartments",
                requirements: ["High-rise Experience", "₹10Cr+ Turnover", "RERA Compliance"],
                bidStatus: "not_submitted",
                image: "https://images.unsplash.com/photo-1565402170291-8491f14678db?w=400&h=250&fit=crop"
            }
        ];

        // Active projects
        const activeProjects = [
            {
                id: "PRJ001",
                title: "Residential Complex - Phase 1",
                client: "Sharma Developers",
                location: "Andheri West, Mumbai",
                value: "₹4.2 Cr",
                startDate: "2023-08-15",
                expectedCompletion: "2024-12-15",
                actualProgress: 78,
                status: "On Track",
                nextMilestone: "Electrical Installation",
                milestoneDate: "2024-02-01",
                clientRating: 4.8,
                image: "https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=400&h=250&fit=crop"
            },
            {
                id: "PRJ002",
                title: "Corporate Office Interior",
                client: "TechCorp Solutions",
                location: "Lower Parel, Mumbai",
                value: "₹85 Lakh",
                startDate: "2024-01-10",
                expectedCompletion: "2024-06-10",
                actualProgress: 35,
                status: "On Track",
                nextMilestone: "Flooring Installation",
                milestoneDate: "2024-02-15",
                clientRating: 4.6,
                image: "https://images.unsplash.com/photo-1541888946425-d81bb19240f5?w=400&h=250&fit=crop"
            }
        ];

        // Financial data
        const financialData = {
            totalEarnings: "₹2.8 Cr",
            pendingPayments: "₹45 Lakh",
            thisMonthEarnings: "₹22 Lakh",
            averageProjectValue: "₹1.2 Cr",
            paymentHistory: [
                { date: "2024-01-20", amount: "₹15 Lakh", project: "Villa Construction - Phase 2", status: "received" },
                { date: "2024-01-15", amount: "₹25 Lakh", project: "Office Interior - Final", status: "received" },
                { date: "2024-01-10", amount: "₹8 Lakh", project: "Apartment Renovation", status: "pending" }
            ]
        };

        // Notifications
        const notifications = [
            {
                id: 1,
                type: "urgent",
                title: "Document Verification Required",
                message: "Please upload missing Turnover Certificate to complete verification.",
                time: "2 hours ago",
                read: false,
                actionRequired: true
            },
            {
                id: 2,
                type: "success",
                title: "Payment Received",
                message: "₹25 Lakh payment received for Office Interior project.",
                time: "5 hours ago",
                read: false,
                actionRequired: false
            },
            {
                id: 3,
                type: "info",
                title: "New Project Available",
                message: "Luxury Villa project posted - matches your specialization.",
                time: "1 day ago",
                read: true,
                actionRequired: false
            }
        ];

        // Recent activity
        const recentActivity = [
            {
                type: "success",
                title: "Project milestone completed",
                description: "Electrical work finished for Residential Complex",
                time: "2 hours ago"
            },
            {
                type: "info",
                title: "Payment received",
                description: "₹25 Lakh payment for Office Interior project",
                time: "5 hours ago"
            },
            {
                type: "warning",
                title: "New bid opportunity",
                description: "Luxury Villa project matches your expertise",
                time: "1 day ago"
            }
        ];

        // Achievements
        const achievements = [
            {
                type: "gold",
                icon: "award",
                title: "Top Performer",
                description: "Q4 2023"
            },
            {
                type: "blue",
                icon: "shield",
                title: "Quality Assured",
                description: "100% Projects"
            },
            {
                type: "green",
                icon: "heart",
                title: "Client Favorite",
                description: "95% Satisfaction"
            }
        ];

        // Main app initialization
        function initializeApp() {
            populateNotifications();
            populateRecentActivity();
            populateMissingDocuments();
            populateVerificationSteps();
            populateActiveProjects();
            populateAvailableProjects();
            populatePaymentHistory();
            populateAchievements();
            initializeEventListeners();
            updateNotificationBadge();
        }

        // Tab switching
        function switchTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });
            
            // Remove active class from all nav links
            document.querySelectorAll('.nav-link').forEach(link => {
                link.classList.remove('active');
            });
            
            // Show selected tab content
            document.getElementById(`content-${tabName}`).classList.add('active');
            document.getElementById(`tab-${tabName}`).classList.add('active');
            
            activeTab = tabName;
        }

        // Populate functions
        function populateNotifications() {
            const notificationsList = document.getElementById('notificationsList');
            notificationsList.innerHTML = '';

            notifications.forEach(notification => {
                const div = document.createElement('div');
                div.className = `notification-item ${!notification.read ? 'unread' : ''}`;
                
                div.innerHTML = `
                    <div class="d-flex align-items-start" style="gap: 0.75rem;">
                        <div class="notification-dot notification-dot-${notification.type}"></div>
                        <div style="flex: 1;">
                            <p style="font-weight: 600; color: var(--slate-900); font-size: 0.875rem; margin-bottom: 0.25rem;">${notification.title}</p>
                            <p style="color: var(--slate-600); font-size: 0.875rem; margin-bottom: 0.5rem;">${notification.message}</p>
                            <p style="color: var(--slate-500); font-size: 0.75rem; margin: 0;">${notification.time}</p>
                        </div>
                        ${notification.actionRequired ? '<span class="badge bg-danger text-white" style="font-size: 0.75rem;">Action Required</span>' : ''}
                    </div>
                `;
                
                notificationsList.appendChild(div);
            });
        }

        function populateRecentActivity() {
            const activityList = document.getElementById('recentActivityList');
            activityList.innerHTML = '';

            recentActivity.forEach(activity => {
                const div = document.createElement('div');
                div.className = 'activity-item';
                
                div.innerHTML = `
                    <div class="activity-icon activity-icon-${activity.type}">
                        <i data-lucide="${getActivityIcon(activity.type)}" style="width: 1.25rem; height: 1.25rem;"></i>
                    </div>
                    <div style="flex: 1;">
                        <p style="font-weight: 600; color: var(--slate-900); margin-bottom: 0.25rem;">${activity.title}</p>
                        <p style="color: var(--slate-600); font-size: 0.875rem; margin-bottom: 0.25rem;">${activity.description}</p>
                        <p style="color: var(--slate-500); font-size: 0.75rem; margin: 0;">${activity.time}</p>
                    </div>
                `;
                
                activityList.appendChild(div);
            });
        }

        function populateMissingDocuments() {
            const documentsList = document.getElementById('missingDocumentsList');
            documentsList.innerHTML = '';

            missingDocuments.filter(doc => !doc.uploadedAt && doc.required).forEach(doc => {
                const div = document.createElement('div');
                div.className = 'document-item document-missing';
                
                div.innerHTML = `
                    <div class="d-flex align-items-center justify-content-between w-100">
                        <div class="d-flex align-items-center" style="gap: 0.75rem;">
                            <i data-lucide="x" style="width: 1.25rem; height: 1.25rem; color: var(--red-500);"></i>
                            <span style="font-weight: 600; color: var(--slate-900);">${doc.name}</span>
                        </div>
                        <button class="btn btn-primary-gradient btn-sm">
                            <i data-lucide="upload" style="width: 1rem; height: 1rem;" class="me-1"></i>
                            Upload
                        </button>
                    </div>
                `;
                
                documentsList.appendChild(div);
            });
        }

        function populateVerificationSteps() {
            const stepsList = document.getElementById('verificationSteps');
            stepsList.innerHTML = '';

            verificationSteps.forEach(step => {
                const div = document.createElement('div');
                div.className = 'verification-step';
                
                div.innerHTML = `
                    <div class="step-icon step-${step.status}">
                        ${step.status === 'completed' ? '<i data-lucide="check-circle" style="width: 1.25rem; height: 1.25rem;"></i>' :
                          step.status === 'current' ? '<i data-lucide="clock" style="width: 1.25rem; height: 1.25rem;"></i>' :
                          step.step}
                    </div>
                    <div style="flex: 1;">
                        <h6 style="font-weight: 600; color: ${step.status === 'current' ? 'var(--orange-700)' : 'var(--slate-900)'}; margin-bottom: 0.25rem;">
                            ${step.title}
                        </h6>
                        <p style="color: var(--slate-600); font-size: 0.875rem; margin: 0;">${step.description}</p>
                    </div>
                `;
                
                stepsList.appendChild(div);
            });
        }

        function populateActiveProjects() {
            const projectsList = document.getElementById('activeProjectsList');
            projectsList.innerHTML = '';

            activeProjects.forEach(project => {
                const col = document.createElement('div');
                col.className = 'col-lg-6 mb-4';
                
                col.innerHTML = `
                    <div class="project-card">
                        <div class="project-image">
                            <img src="${project.image}" alt="${project.title}">
                            <div class="project-status-badge status-${project.status.toLowerCase().replace(' ', '-')}">${project.status}</div>
                            <div class="position-absolute bottom-0 start-0 end-0 p-3">
                                <div style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(20px); border-radius: 0.75rem; padding: 0.75rem;">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-white" style="font-weight: 600;">Progress</span>
                                        <span class="text-white" style="font-weight: 700;">${project.actualProgress}%</span>
                                    </div>
                                    <div class="progress-bar-custom">
                                        <div class="progress-fill progress-fill-green" style="width: ${project.actualProgress}%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-4">
                            <h4 style="color: var(--slate-900); font-weight: 700; font-size: 1.25rem; margin-bottom: 1rem;">${project.title}</h4>
                            
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-2" style="gap: 0.5rem;">
                                    <i data-lucide="user" style="width: 1rem; height: 1rem; color: var(--blue-500);"></i>
                                    <span style="color: var(--slate-600); font-size: 0.875rem;">${project.client}</span>
                                </div>
                                <div class="d-flex align-items-center mb-2" style="gap: 0.5rem;">
                                    <i data-lucide="map-pin" style="width: 1rem; height: 1rem; color: var(--orange-500);"></i>
                                    <span style="color: var(--slate-600); font-size: 0.875rem;">${project.location}</span>
                                </div>
                                <div class="d-flex align-items-center mb-2" style="gap: 0.5rem;">
                                    <i data-lucide="dollar-sign" style="width: 1rem; height: 1rem; color: var(--green-500);"></i>
                                    <span style="color: var(--slate-600); font-size: 0.875rem; font-weight: 600;">${project.value}</span>
                                </div>
                            </div>

                            <div class="border-top pt-3 mb-3" style="border-color: var(--slate-200) !important;">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span style="font-size: 0.875rem; color: var(--slate-600);">Next Milestone</span>
                                    <span style="font-size: 0.875rem; font-weight: 600; color: var(--slate-900);">${project.nextMilestone}</span>
                                </div>
                                <div class="d-flex align-items-center" style="gap: 0.5rem;">
                                    <i data-lucide="calendar" style="width: 1rem; height: 1rem; color: var(--slate-400);"></i>
                                    <span style="font-size: 0.875rem; color: var(--slate-600);">Due: ${new Date(project.milestoneDate).toLocaleDateString()}</span>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center pt-3 border-top" style="border-color: var(--slate-200) !important;">
                                <div class="star-rating">
                                    <i data-lucide="star" class="star-filled" style="width: 1rem; height: 1rem;"></i>
                                    <span style="font-size: 0.875rem; font-weight: 600;">${project.clientRating}</span>
                                </div>
                                <button class="btn btn-primary-gradient btn-sm">
                                    <i data-lucide="eye" style="width: 1rem; height: 1rem;" class="me-1"></i>
                                    View Details
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                
                projectsList.appendChild(col);
            });
        }

        function populateAvailableProjects() {
            const projectsList = document.getElementById('availableProjectsList');
            projectsList.innerHTML = '';

            availableProjects.forEach(project => {
                const col = document.createElement('div');
                col.className = 'col-lg-4 col-md-6 mb-4';
                
                col.innerHTML = `
                    <div class="project-card">
                        <div style="height: 10rem; overflow: hidden; position: relative;">
                            <img src="${project.image}" alt="${project.title}" style="width: 100%; height: 100%; object-fit: cover;">
                            <div class="project-status-badge bid-status-${project.bidStatus.replace('_', '-')}">${getBidStatusText(project.bidStatus)}</div>
                            <div class="position-absolute bottom-0 start-0 end-0 p-2">
                                <p class="text-white" style="font-weight: 600; font-size: 0.875rem; margin: 0;">${project.title}</p>
                            </div>
                        </div>
                        
                        <div class="p-3">
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-1" style="gap: 0.5rem;">
                                    <i data-lucide="map-pin" style="width: 0.875rem; height: 0.875rem; color: var(--orange-500);"></i>
                                    <span style="color: var(--slate-600); font-size: 0.75rem;">${project.location}</span>
                                </div>
                                <div class="d-flex align-items-center mb-1" style="gap: 0.5rem;">
                                    <i data-lucide="dollar-sign" style="width: 0.875rem; height: 0.875rem; color: var(--green-500);"></i>
                                    <span style="color: var(--slate-600); font-size: 0.75rem; font-weight: 600;">${project.budget}</span>
                                </div>
                                <div class="d-flex align-items-center mb-1" style="gap: 0.5rem;">
                                    <i data-lucide="clock" style="width: 0.875rem; height: 0.875rem; color: var(--blue-500);"></i>
                                    <span style="color: var(--slate-600); font-size: 0.75rem;">${project.timeline}</span>
                                </div>
                            </div>

                            <p style="color: var(--slate-600); font-size: 0.75rem; line-height: 1.4; margin-bottom: 1rem;">${project.description}</p>

                            <div class="mb-3">
                                <p style="font-size: 0.75rem; font-weight: 600; color: var(--slate-700); margin-bottom: 0.5rem;">Requirements:</p>
                                <div class="d-flex flex-wrap gap-1">
                                    ${project.requirements.slice(0, 2).map(req => `<span class="badge bg-secondary" style="font-size: 0.75rem;">${req}</span>`).join('')}
                                    ${project.requirements.length > 2 ? `<span class="badge bg-secondary" style="font-size: 0.75rem;">+${project.requirements.length - 2} more</span>` : ''}
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center pt-2 border-top mb-3" style="border-color: var(--slate-200) !important; font-size: 0.75rem;">
                                <div class="d-flex align-items-center" style="gap: 1rem;">
                                    <div class="d-flex align-items-center" style="gap: 0.25rem;">
                                        <i data-lucide="users" style="width: 0.875rem; height: 0.875rem;"></i>
                                        <span>${project.bidsSubmitted} bids</span>
                                    </div>
                                    <div class="star-rating">
                                        <i data-lucide="star" class="star-filled" style="width: 0.875rem; height: 0.875rem;"></i>
                                        <span>${project.clientRating}</span>
                                    </div>
                                </div>
                                <span style="color: var(--slate-500);">Due: ${new Date(project.deadline).toLocaleDateString()}</span>
                            </div>

                            <button class="btn ${project.bidStatus === 'submitted' ? 'btn-secondary' : 'btn-primary-gradient'} btn-sm w-100" ${project.bidStatus === 'submitted' ? 'disabled' : ''}>
                                <i data-lucide="${project.bidStatus === 'submitted' ? 'check-circle' : 'send'}" style="width: 0.875rem; height: 0.875rem;" class="me-1"></i>
                                ${project.bidStatus === 'submitted' ? 'Bid Submitted' : 'Submit Bid'}
                            </button>
                        </div>
                    </div>
                `;
                
                projectsList.appendChild(col);
            });
        }

        function populatePaymentHistory() {
            const paymentList = document.getElementById('paymentHistoryList');
            paymentList.innerHTML = '';

            financialData.paymentHistory.forEach(payment => {
                const div = document.createElement('div');
                div.className = 'payment-item';
                
                div.innerHTML = `
                    <div class="d-flex align-items-start w-100" style="gap: 0.75rem;">
                        <div style="width: 2rem; height: 2rem; border-radius: 50%; background: ${payment.status === 'received' ? 'rgba(34, 197, 94, 0.1)' : 'rgba(251, 146, 60, 0.1)'}; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i data-lucide="${payment.status === 'received' ? 'check-circle' : 'clock'}" style="width: 1rem; height: 1rem; color: ${payment.status === 'received' ? 'var(--green-600)' : 'var(--orange-600)'};"></i>
                        </div>
                        <div style="flex: 1;">
                            <p style="font-weight: 600; color: var(--slate-900); font-size: 0.875rem; margin-bottom: 0.25rem;">${payment.amount}</p>
                            <p style="color: var(--slate-600); font-size: 0.875rem; margin-bottom: 0.25rem;">${payment.project}</p>
                            <p style="color: var(--slate-500); font-size: 0.75rem; margin: 0;">${payment.date}</p>
                        </div>
                        <span class="badge ${payment.status === 'received' ? 'bg-success' : 'bg-warning'}" style="font-size: 0.75rem;">
                            ${payment.status === 'received' ? 'Received' : 'Pending'}
                        </span>
                    </div>
                `;
                
                paymentList.appendChild(div);
            });
        }

        function populateAchievements() {
            const achievementsList = document.getElementById('achievementsList');
            achievementsList.innerHTML = '';

            achievements.forEach(achievement => {
                const div = document.createElement('div');
                div.className = `achievement-badge achievement-${achievement.type}`;
                
                div.innerHTML = `
                    <i data-lucide="${achievement.icon}" style="width: 1.5rem; height: 1.5rem; color: ${getAchievementColor(achievement.type)};"></i>
                    <div>
                        <p style="font-weight: 600; font-size: 0.875rem; margin-bottom: 0.125rem;">${achievement.title}</p>
                        <p style="color: var(--slate-600); font-size: 0.75rem; margin: 0;">${achievement.description}</p>
                    </div>
                `;
                
                achievementsList.appendChild(div);
            });
        }

        // Event listeners
        function initializeEventListeners() {
            // Notification button
            document.getElementById('notificationBtn').addEventListener('click', function() {
                toggleNotifications();
            });

            // Close notifications when clicking outside
            document.addEventListener('click', function(e) {
                const notificationBtn = document.getElementById('notificationBtn');
                const notificationsDropdown = document.getElementById('notificationsDropdown');
                
                if (!notificationBtn.contains(e.target) && !notificationsDropdown.contains(e.target)) {
                    hideNotifications();
                }
            });

            // Search functionality
            document.getElementById('searchInput').addEventListener('input', function(e) {
                handleSearch(e.target.value);
            });

            // Re-initialize Lucide icons after content updates
            lucide.createIcons();
        }

        // Utility functions
        function getBidStatusText(status) {
            switch (status) {
                case 'submitted': return 'Bid Submitted';
                case 'pending': return 'Review Pending';
                case 'not_submitted': return 'Not Submitted';
                default: return 'Unknown';
            }
        }

        function getActivityIcon(type) {
            switch (type) {
                case 'success': return 'check-circle';
                case 'info': return 'activity';
                case 'warning': return 'alert-circle';
                default: return 'info';
            }
        }

        function getAchievementColor(type) {
            switch (type) {
                case 'gold': return '#f59e0b';
                case 'blue': return '#3b82f6';
                case 'green': return '#22c55e';
                default: return '#6b7280';
            }
        }

        function updateNotificationBadge() {
            const unreadCount = notifications.filter(n => !n.read).length;
            const badge = document.getElementById('notificationBadge');
            
            if (unreadCount > 0) {
                badge.textContent = unreadCount;
                badge.style.display = 'flex';
            } else {
                badge.style.display = 'none';
            }
        }

        function toggleNotifications() {
            const dropdown = document.getElementById('notificationsDropdown');
            showNotifications = !showNotifications;
            
            if (showNotifications) {
                dropdown.classList.add('show');
            } else {
                dropdown.classList.remove('show');
            }
        }

        function hideNotifications() {
            const dropdown = document.getElementById('notificationsDropdown');
            dropdown.classList.remove('show');
            showNotifications = false;
        }

        function handleLogout() {
            showToast('Logging out...', 'info');
            setTimeout(() => {
                window.location.href = '/login';
            }, 1500);
        }

        function handleSearch(query) {
            if (query.length > 0) {
                showToast(`Searching for: ${query}`, 'info');
            }
        }

        // Toast notification system
        function showToast(message, type = 'info') {
            const toastContainer = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = 'alert alert-dismissible fade show';
            toast.setAttribute('role', 'alert');
            
            const typeClass = {
                'success': 'alert-success',
                'info': 'alert-info',
                'warning': 'alert-warning',
                'error': 'alert-danger'
            };
            
            toast.classList.add(typeClass[type] || typeClass.info);
            
            toast.innerHTML = `
                <div class="d-flex align-items-center">
                    <i data-lucide="${type === 'success' ? 'check-circle' : type === 'warning' ? 'alert-circle' : 'info'}" style="width: 1.25rem; height: 1.25rem;" class="me-2"></i>
                    <span>${message}</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            
            toastContainer.appendChild(toast);
            
            // Initialize Lucide icons in the toast
            lucide.createIcons();
            
            // Auto-remove toast after 4 seconds
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.remove();
                }
            }, 4000);
        }

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth <= 768 && showNotifications) {
                hideNotifications();
            }
        });

        // Error handling
        window.addEventListener('error', function(e) {
            console.error('JavaScript error:', e.error);
            showToast('An error occurred. Please refresh the page.', 'error');
        });
    </script>
</body>
</html>