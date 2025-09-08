<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" sizes="128x128"  content="width=device-width, initial-scale=1.0">
     <link rel="icon" type="image/png" href="{{ asset('logo/bg.png') }}">
    <title>CONSTRUCTKARO - Customer Dashboard</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    
    <style>
        /* Custom CSS Variables */
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
        /* body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            overflow-x: hidden;
            font-size: 14px;
        } */

        /* Enhanced Background */
            /* .dashboard-background {
                position: fixed;
                inset: 0;
                background: linear-gradient(135deg, var(--slate-50) 0%, rgba(239, 246, 255, 0.3) 50%, rgba(238, 242, 255, 0.2) 100%);
                z-index: -2;
            } */

        /* Animated Background Elements */
        /* .background-elements {
            position: fixed;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
            z-index: -1;
        } */

        /* .bg-orb-1 {
            position: absolute;
            top: -12rem;
            right: -12rem;
            width: 37.5rem;
            height: 37.5rem;
            background: linear-gradient(135deg, rgba(251, 146, 60, 0.06), rgba(236, 72, 153, 0.06), rgba(239, 68, 68, 0.06));
            border-radius: 50%;
            filter: blur(60px);
            animation: pulse-slow 6s ease-in-out infinite;
        } */

        /* .bg-orb-2 {
            position: absolute;
            bottom: -12rem;
            left: -12rem;
            width: 43.75rem;
            height: 43.75rem;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.06), rgba(99, 102, 241, 0.06), rgba(139, 92, 246, 0.06));
            border-radius: 50%;
            filter: blur(60px);
            animation: pulse-slow 6s ease-in-out infinite 1s;
        } */

        /* Floating particles */
        /* .floating-particle {
            position: absolute;
            border-radius: 50%;
            animation: bounce-float 4s ease-in-out infinite;
        } */

        /* .particle-1 {
            top: 5rem;
            left: 5rem;
            width: 0.75rem;
            height: 0.75rem;
            background: linear-gradient(45deg, var(--orange-400), var(--pink-500));
            opacity: 0.4;
            animation-delay: 0.3s;
        } */
/* 
        .particle-2 {
            top: 10rem;
            right: 8rem;
            width: 1rem;
            height: 1rem;
            background: linear-gradient(45deg, var(--blue-400), var(--indigo-400));
            opacity: 0.3;
            animation-delay: 0.7s;
        } */

        /* .particle-3 {
            bottom: 8rem;
            left: 10rem;
            width: 0.5rem;
            height: 0.5rem;
            background: linear-gradient(45deg, var(--green-400), var(--emerald-400));
            opacity: 0.5;
            animation-delay: 1s;
        } */

        /* Grid overlay */
        /* .grid-overlay {
            position: fixed;
            inset: 0;
            background-image: 
                linear-gradient(rgba(99, 102, 241, 0.01) 1px, transparent 1px),
                linear-gradient(90deg, rgba(99, 102, 241, 0.01) 1px, transparent 1px);
            background-size: 60px 60px;
            z-index: -1;
        } */

        /* Enhanced Header */
        /* .enhanced-header {
            position: relative;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(40px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 10px 30px rgba(148, 163, 184, 0.15);
        } */

        /* .brand-icon {
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
        } */

        /* .brand-pulse {
            position: absolute;
            top: -0.25rem;
            right: -0.25rem;
            width: 0.75rem;
            height: 0.75rem;
            background: linear-gradient(45deg, var(--green-400), var(--emerald-400));
            border-radius: 50%;
            animation: pulse-glow 2s ease-in-out infinite;
        } */

        /* .brand-text {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--slate-900), var(--slate-800), var(--slate-700));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        } */

        /* .brand-text-accent {
            background: linear-gradient(135deg, var(--orange-500), var(--red-500), var(--pink-500));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        } */

        /* .brand-subtitle {
            font-size: 0.875rem;
            color: var(--slate-500);
            font-weight: 500;
        } */

        /* Search Input */
        /* .search-container {
            position: relative;
            flex: 1;
            max-width: 32rem;
        } */

        /* .search-input {
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
        } */

        /* .search-input:focus {
            outline: none;
            border-color: var(--orange-400);
            box-shadow: 0 0 0 3px rgba(251, 146, 60, 0.1), 0 10px 25px rgba(0, 0, 0, 0.1);
            background: rgba(255, 255, 255, 0.8);
        } */

        /* .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--slate-400);
            width: 1.25rem;
            height: 1.25rem;
        } */

        /* Notification Button */
        /* .notification-btn {
            position: relative;
            padding: 0.75rem;
            background: transparent;
            border: none;
            border-radius: 1rem;
            transition: all 0.2s ease;
        }

        .notification-btn:hover {
            background: rgba(251, 146, 60, 0.1);
        } */

        /* .notification-badge {
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
        } */

        /* User Profile */
        /* .user-profile {
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
        } */

        /* .user-avatar-fallback {
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
        } */

        /* .logout-btn {
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
        } */

        /* Notifications Dropdown */
       
        /* .notifications-dropdown {
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
        } */

        /* .notifications-dropdown.show {
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
        } */

        /* .notification-dot {
            width: 0.5rem;
            height: 0.5rem;
            border-radius: 50%;
            flex-shrink: 0;
            margin-top: 0.5rem;
        }

        .notification-dot-success {
            background: var(--green-500);
        }

        .notification-dot-info {
            background: var(--blue-500);
        }

        .notification-dot-warning {
            background: var(--orange-500);
        }

        .notification-dot-error {
            background: var(--red-500);
        } */

        /* Dashboard Cards */
        /* .dashboard-card {
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
        } */

        /* Welcome Card */
        /* .welcome-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0.6));
            backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
            border-radius: 1.5rem;
        }

        .welcome-avatar {
            width: 5rem;
            height: 5rem;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            object-fit: cover;
        } */

        /* .welcome-avatar-fallback {
            width: 5rem;
            height: 5rem;
            background: linear-gradient(135deg, var(--orange-500), var(--pink-500));
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.5rem;
        }

        .contact-chip {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--slate-100);
            border-radius: 0.5rem;
            padding: 0.25rem 0.75rem;
            font-size: 0.875rem;
        } */

        /* Stats Cards */
        /* .stat-icon {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        } */

        /* .stat-icon-blue {
            background: linear-gradient(135deg, var(--blue-500), var(--indigo-500));
        }

        .stat-icon-orange {
            background: linear-gradient(135deg, var(--orange-500), var(--red-500));
        }

        .stat-icon-green {
            background: linear-gradient(135deg, var(--green-500), var(--emerald-500));
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--slate-900);
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--slate-600);
        } */

        /* Project Cards */
        /* .project-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            border-radius: 1.5rem;
            transition: all 0.5s ease;
            cursor: pointer;
            overflow: hidden;
            height: 100%;
        } */

        /* .project-card:hover {
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
        } */

        /* .project-status-badge {
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

        .project-priority-badge {
            position: absolute;
            top: 1rem;
            left: 1rem;
            padding: 0.5rem 1rem;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            font-weight: 600;
            border: 1px solid;
            backdrop-filter: blur(10px);
        } */

        /* .priority-high {
            color: var(--red-600);
            background: rgba(254, 242, 242, 0.9);
            border-color: rgba(239, 68, 68, 0.2);
        }

        .priority-medium {
            color: var(--orange-600);
            background: rgba(255, 247, 237, 0.9);
            border-color: rgba(251, 146, 60, 0.2);
        }

        .priority-low {
            color: var(--green-600);
            background: rgba(240, 253, 244, 0.9);
            border-color: rgba(34, 197, 94, 0.2);
        } */

        /* .status-completed {
            background: var(--green-500);
            color: white;
        }

        .status-in-progress {
            background: var(--blue-500);
            color: white;
        }

        .status-on-hold {
            background: var(--orange-500);
            color: white;
        }

        .status-delayed {
            background: var(--red-500);
            color: white;
        } */

        /* Progress Overlay */
        /* .progress-overlay {
            position: absolute;
            bottom: 1rem;
            left: 1rem;
            right: 1rem;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(20px);
            border-radius: 0.75rem;
            padding: 0.75rem;
        }

        .progress-bar-container {
            width: 100%;
            height: 0.5rem;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 0.25rem;
            overflow: hidden;
        } */

        /* .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--orange-400), var(--pink-400));
            border-radius: 0.25rem;
            transition: width 0.7s ease;
        } */

        /* Project Details */
        /* .project-detail {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: var(--slate-600);
            margin-bottom: 0.5rem;
        }

        .project-detail-icon {
            width: 1rem;
            height: 1rem;
            flex-shrink: 0;
        } */

        /* Vendor Information */
        /* .vendor-section {
            border-top: 1px solid var(--slate-200);
            padding-top: 1rem;
        }

        .vendor-avatar {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            object-fit: cover;
        } */

        /* .vendor-avatar-fallback {
            width: 2.5rem;
            height: 2.5rem;
            background: linear-gradient(135deg, var(--blue-500), var(--indigo-500));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .vendor-action-btn {
            padding: 0.25rem;
            background: transparent;
            border: none;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
        } */

        /* .vendor-action-btn:hover {
            transform: scale(1.1);
        }

        .vendor-action-btn.phone:hover {
            background: rgba(34, 197, 94, 0.1);
            color: var(--green-600);
        }

        .vendor-action-btn.message:hover {
            background: rgba(59, 130, 246, 0.1);
            color: var(--blue-600);
        } */

        /* Milestones */
        /* .milestones-section {
            border-top: 1px solid var(--slate-200);
            padding-top: 1rem;
        }

        .milestone-item {
            text-align: center;
        } */

        /* .milestone-icon {
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.5rem;
            font-size: 0.75rem;
        }

        .milestone-completed {
            background: var(--green-500);
            color: white;
        } */

        /* .milestone-in-progress {
            background: var(--orange-500);
            color: white;
        }

        .milestone-pending {
            background: var(--slate-200);
            color: var(--slate-500);
        } */

        /* .milestone-label {
            font-size: 0.75rem;
            color: var(--slate-600);
        } */

        /* Action Buttons */
        /* .btn-view-details {
            background: linear-gradient(135deg, var(--orange-500), var(--pink-500));
            border: none;
            color: white;
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
        } */

        /* .btn-view-details:hover {
            background: linear-gradient(135deg, var(--orange-600), var(--pink-600));
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(249, 115, 22, 0.3);
        } */

        /* Filter and Export Buttons */
        /* .action-btn {
            background: transparent;
            border: 1px solid var(--slate-300);
            border-radius: 0.75rem;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--slate-700);
            transition: all 0.2s ease;
        } */

        /* .action-btn:hover {
            background: rgba(249, 115, 22, 0.05);
            border-color: var(--orange-300);
            color: var(--orange-600);
        } */

        /* Recent Activity */
        /* .activity-item {
            display: flex;
            align-items: start;
            gap: 1rem;
            padding: 1rem;
            background: rgba(248, 250, 252, 0.5);
            border-radius: 1rem;
            transition: all 0.2s ease;
        } */

        /* .activity-item:hover {
            background: rgba(241, 245, 249, 0.5);
            transform: translateY(-1px);
        } */

        /* .activity-icon {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        } */

        /* .activity-icon-success {
            background: rgba(34, 197, 94, 0.1);
            color: var(--green-600);
        } */

        /* .activity-icon-info {
            background: rgba(59, 130, 246, 0.1);
            color: var(--blue-600);
        } */

        /* .activity-icon-warning {
            background: rgba(251, 146, 60, 0.1);
            color: var(--orange-600);
        } */

        /* Animations */
        /* @keyframes pulse-slow {
            0%, 100% { opacity: 0.6; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.05); }
        } */

        /* @keyframes bounce-float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        @keyframes pulse-glow {
            0%, 100% { opacity: 0.8; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.1); }
        } */

        /* @keyframes slideInFromTop {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        } */

        /* @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        } */

        /* Responsive Design */
        @media (max-width: 1200px) {
            .search-container {
                max-width: 24rem;
            }
        }

        /* @media (max-width: 768px) {
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
            
            .welcome-card .row {
                text-align: center;
            }
            
            .welcome-card .welcome-avatar {
                margin: 0 auto 1rem;
            }
            
            .contact-chip {
                justify-content: center;
            }
        } */

        /* @media (max-width: 576px) {
            .brand-text {
                font-size: 1.25rem;
            }
            
            .notifications-dropdown {
                width: 18rem;
                right: -1rem;
            }
        } */

        /* Utility Classes */
        .text-gradient-orange {
            background: linear-gradient(135deg, var(--orange-500), var(--red-500), var(--pink-500));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* .animate-pulse {
            animation: pulse-glow 2s ease-in-out infinite;
        }

        .animate-bounce {
            animation: bounce-float 3s ease-in-out infinite;
        } */

        /* Custom Star Rating */
        /* .star-rating {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .star-filled {
            color: #fbbf24;
        } */

        /* Section Headers */
        /* .section-header {
            margin-bottom: 1.5rem;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--slate-900);
            margin-bottom: 0.5rem;
        }

        .section-subtitle {
            color: var(--slate-600);
        } */

        /* Loading States */
        .loading-skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* Toast Notifications */
        /* .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
        } */

        /* .toast-item {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 0.75rem;
            padding: 1rem 1.5rem;
            margin-bottom: 0.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            transform: translateX(100%);
            transition: transform 0.3s ease;
        } */

        /* .toast-item.show {
            transform: translateX(0);
        } */

        /* Custom Scrollbar */
        /* ::-webkit-scrollbar {
            width: 6px;
        } */

        /* ::-webkit-scrollbar-track {
            background: var(--slate-100);
            border-radius: 3px;
        } */

        /* ::-webkit-scrollbar-thumb {
            background: var(--slate-300);
            border-radius: 3px;
        } */

        /* ::-webkit-scrollbar-thumb:hover {
            background: var(--slate-400);
        } */
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
         /* .footer-brand-icon {
         width: 2.5rem;
         height: 2.5rem;
         background: linear-gradient(135deg, var(--orange-500), var(--orange-600));
         border-radius: 0.5rem;
         display: flex;
         align-items: center;
         justify-content: center;
         margin-right: 0.75rem;
         } */
         /* .footer-brand-icon i {
         color: white;
         width: 1.5rem;
         height: 1.5rem;
         } */
         /* .footer-brand-text {
         font-size: 1.25rem;
         font-weight: 700;
         } */
         /* .footer-description {
         color: rgba(255, 255, 255, 0.7);
         line-height: 1.6;
         } */
         /* .footer-heading {
         font-size: 1rem;
         font-weight: 600;
         margin-bottom: 1rem;
         } */
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
         /* .footer-link:hover {
         color: var(--orange-400);
         } */
         /* .footer-contacts {
         display: flex;
         flex-direction: column;
         gap: 0.75rem;
         } */
       
         /* .footer-bottom {
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
         } */
         /* @media (max-width: 768px) {
         .footer-legal {
         justify-content: center;
         margin-top: 1rem;
         }
         } */
         
         /* .custom-header {
            position: fixed !important;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1050;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        } */

    </style>
</head>
<body>
    <!-- Background Elements -->
    <div class="dashboard-background"></div>
    <div class="background-elements">
        <div class="bg-orb-1"></div>
        <div class="bg-orb-2"></div>
        <div class="floating-particle particle-1"></div>
        <div class="floating-particle particle-2"></div>
        <div class="floating-particle particle-3"></div>
    </div>
    <div class="grid-overlay"></div>

      @include('partials.cust_header')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

      <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
 
</body>
</html>