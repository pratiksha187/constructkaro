<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            overflow-x: hidden;
            font-size: 14px;
        }

        /* Enhanced Background */
        .dashboard-background {
            position: fixed;
            inset: 0;
            background: linear-gradient(135deg, var(--slate-50) 0%, rgba(239, 246, 255, 0.3) 50%, rgba(238, 242, 255, 0.2) 100%);
            z-index: -2;
        }

        /* Animated Background Elements */
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

        /* Floating particles */
        .floating-particle {
            position: absolute;
            border-radius: 50%;
            animation: bounce-float 4s ease-in-out infinite;
        }

        .particle-1 {
            top: 5rem;
            left: 5rem;
            width: 0.75rem;
            height: 0.75rem;
            background: linear-gradient(45deg, var(--orange-400), var(--pink-500));
            opacity: 0.4;
            animation-delay: 0.3s;
        }

        .particle-2 {
            top: 10rem;
            right: 8rem;
            width: 1rem;
            height: 1rem;
            background: linear-gradient(45deg, var(--blue-400), var(--indigo-400));
            opacity: 0.3;
            animation-delay: 0.7s;
        }

        .particle-3 {
            bottom: 8rem;
            left: 10rem;
            width: 0.5rem;
            height: 0.5rem;
            background: linear-gradient(45deg, var(--green-400), var(--emerald-400));
            opacity: 0.5;
            animation-delay: 1s;
        }

        /* Grid overlay */
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

        /* Welcome Card */
        .welcome-card {
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
        }

        .welcome-avatar-fallback {
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
        }

        /* Stats Cards */
        .stat-icon {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
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

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--slate-900);
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--slate-600);
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
        }

        .priority-high {
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
        }

        .status-completed {
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
        }

        /* Progress Overlay */
        .progress-overlay {
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
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--orange-400), var(--pink-400));
            border-radius: 0.25rem;
            transition: width 0.7s ease;
        }

        /* Project Details */
        .project-detail {
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
        }

        /* Vendor Information */
        .vendor-section {
            border-top: 1px solid var(--slate-200);
            padding-top: 1rem;
        }

        .vendor-avatar {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            object-fit: cover;
        }

        .vendor-avatar-fallback {
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
        }

        .vendor-action-btn:hover {
            transform: scale(1.1);
        }

        .vendor-action-btn.phone:hover {
            background: rgba(34, 197, 94, 0.1);
            color: var(--green-600);
        }

        .vendor-action-btn.message:hover {
            background: rgba(59, 130, 246, 0.1);
            color: var(--blue-600);
        }

        /* Milestones */
        .milestones-section {
            border-top: 1px solid var(--slate-200);
            padding-top: 1rem;
        }

        .milestone-item {
            text-align: center;
        }

        .milestone-icon {
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
        }

        .milestone-in-progress {
            background: var(--orange-500);
            color: white;
        }

        .milestone-pending {
            background: var(--slate-200);
            color: var(--slate-500);
        }

        .milestone-label {
            font-size: 0.75rem;
            color: var(--slate-600);
        }

        /* Action Buttons */
        .btn-view-details {
            background: linear-gradient(135deg, var(--orange-500), var(--pink-500));
            border: none;
            color: white;
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-view-details:hover {
            background: linear-gradient(135deg, var(--orange-600), var(--pink-600));
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(249, 115, 22, 0.3);
        }

        /* Filter and Export Buttons */
        .action-btn {
            background: transparent;
            border: 1px solid var(--slate-300);
            border-radius: 0.75rem;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--slate-700);
            transition: all 0.2s ease;
        }

        .action-btn:hover {
            background: rgba(249, 115, 22, 0.05);
            border-color: var(--orange-300);
            color: var(--orange-600);
        }

        /* Recent Activity */
        .activity-item {
            display: flex;
            align-items: start;
            gap: 1rem;
            padding: 1rem;
            background: rgba(248, 250, 252, 0.5);
            border-radius: 1rem;
            transition: all 0.2s ease;
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

        /* Animations */
        @keyframes pulse-slow {
            0%, 100% { opacity: 0.6; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.05); }
        }

        @keyframes bounce-float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
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
            
            .welcome-card .row {
                text-align: center;
            }
            
            .welcome-card .welcome-avatar {
                margin: 0 auto 1rem;
            }
            
            .contact-chip {
                justify-content: center;
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

        /* Utility Classes */
        .text-gradient-orange {
            background: linear-gradient(135deg, var(--orange-500), var(--red-500), var(--pink-500));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .animate-pulse {
            animation: pulse-glow 2s ease-in-out infinite;
        }

        .animate-bounce {
            animation: bounce-float 3s ease-in-out infinite;
        }

        /* Custom Star Rating */
        .star-rating {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .star-filled {
            color: #fbbf24;
        }

        /* Section Headers */
        .section-header {
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
        }

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
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
        }

        .toast-item {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 0.75rem;
            padding: 1rem 1.5rem;
            margin-bottom: 0.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            transform: translateX(100%);
            transition: transform 0.3s ease;
        }

        .toast-item.show {
            transform: translateX(0);
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
         
         .custom-header {
            position: fixed !important;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1050;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

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
    
    <!-- Custom JavaScript -->
    <script>
        // Initialize Lucide icons
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
            initializeApp();
        });

        // Application state
        let showNotifications = false;
        let customerData = {
            name: "Rajesh Kumar",
            email: "rajesh.kumar@email.com",
            phone: "+91 98765 43210",
            location: "Mumbai, Maharashtra",
            memberSince: "Jan 2024",
            totalProjects: 3,
            activeProjects: 2,
            completedProjects: 1,
            avatar: "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&h=150&fit=crop&crop=face"
        };

        let projects = [
            {
                id: "PRJ001",
                title: "Modern Villa Construction",
                description: "3BHK luxury villa with modern amenities",
                location: "Bandra West, Mumbai",
                budget: "₹2.5 Cr",
                startDate: "2024-01-15",
                expectedCompletion: "2024-12-15",
                actualProgress: 65,
                status: "In Progress",
                priority: "High",
                vendor: {
                    id: "VND001",
                    name: "Elite Builders & Contractors",
                    rating: 4.8,
                    phone: "+91 99887 76543",
                    email: "contact@elitebuilders.com",
                    avatar: "https://images.unsplash.com/photo-1560250097-0b93528c311a?w=150&h=150&fit=crop"
                },
                milestones: [
                    { name: "Foundation", status: "completed", progress: 100 },
                    { name: "Structure", status: "in-progress", progress: 80 },
                    { name: "Electrical", status: "pending", progress: 0 },
                    { name: "Finishing", status: "pending", progress: 0 }
                ],
                recentActivity: [
                    { date: "2024-01-20", activity: "Foundation work completed", type: "success" },
                    { date: "2024-01-18", activity: "Structural work 80% complete", type: "info" }
                ],
                image: "https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=400&h=250&fit=crop"
            },
            {
                id: "PRJ002",
                title: "Office Interior Design",
                description: "Complete office interior renovation",
                location: "Andheri East, Mumbai",
                budget: "₹75 Lakh",
                startDate: "2024-02-01",
                expectedCompletion: "2024-05-01",
                actualProgress: 30,
                status: "In Progress",
                priority: "Medium",
                vendor: {
                    id: "VND002",
                    name: "Creative Interiors",
                    rating: 4.6,
                    phone: "+91 98776 65432",
                    email: "info@creativeinteriors.com",
                    avatar: "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&h=150&fit=crop&crop=face"
                },
                milestones: [
                    { name: "Design Planning", status: "completed", progress: 100 },
                    { name: "Demolition", status: "in-progress", progress: 60 },
                    { name: "Installation", status: "pending", progress: 0 },
                    { name: "Finishing", status: "pending", progress: 0 }
                ],
                recentActivity: [
                    { date: "2024-02-10", activity: "Demolition work in progress", type: "info" }
                ],
                image: "https://images.unsplash.com/photo-1541888946425-d81bb19240f5?w=400&h=250&fit=crop"
            },
            {
                id: "PRJ003",
                title: "Residential Apartment Renovation",
                description: "2BHK apartment complete renovation",
                location: "Powai, Mumbai",
                budget: "₹45 Lakh",
                startDate: "2023-08-01",
                expectedCompletion: "2023-12-01",
                actualProgress: 100,
                status: "Completed",
                priority: "Low",
                vendor: {
                    id: "VND003",
                    name: "Home Renovators",
                    rating: 4.9,
                    phone: "+91 97665 54321",
                    email: "support@homerenovators.com",
                    avatar: "https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150&h=150&fit=crop&crop=face"
                },
                milestones: [
                    { name: "Planning", status: "completed", progress: 100 },
                    { name: "Execution", status: "completed", progress: 100 },
                    { name: "Finishing", status: "completed", progress: 100 },
                    { name: "Handover", status: "completed", progress: 100 }
                ],
                recentActivity: [
                    { date: "2023-12-01", activity: "Project completed successfully", type: "success" }
                ],
                image: "https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=400&h=250&fit=crop"
            }
        ];

        let notifications = [
            {
                id: 1,
                type: "success",
                title: "Project Milestone Completed",
                message: "Foundation work for Modern Villa Construction has been completed.",
                time: "2 hours ago",
                read: false,
                projectId: "PRJ001"
            },
            {
                id: 2,
                type: "info",
                title: "Vendor Update",
                message: "Elite Builders has updated the project timeline.",
                time: "5 hours ago",
                read: false,
                projectId: "PRJ001"
            },
            {
                id: 3,
                type: "warning",
                title: "Payment Due",
                message: "Next installment payment is due in 3 days.",
                time: "1 day ago",
                read: true,
                projectId: "PRJ002"
            },
            {
                id: 4,
                type: "info",
                title: "New Message",
                message: "Creative Interiors sent you a project update.",
                time: "2 days ago",
                read: true,
                projectId: "PRJ002"
            }
        ];

        // Main app initialization
        function initializeApp() {
            populateCustomerData();
            populateProjects();
            populateNotifications();
            populateRecentActivity();
            initializeEventListeners();
            updateNotificationBadge();
        }

        // Populate customer data
        function populateCustomerData() {
            document.getElementById('userName').textContent = customerData.name;
            document.getElementById('welcomeName').textContent = customerData.name;
            document.getElementById('userEmail').textContent = customerData.email;
            document.getElementById('userPhone').textContent = customerData.phone;
            document.getElementById('userLocation').textContent = customerData.location;
            document.getElementById('memberSince').textContent = customerData.memberSince;
            document.getElementById('totalProjects').textContent = customerData.totalProjects;
            document.getElementById('activeProjects').textContent = customerData.activeProjects;
            document.getElementById('completedProjects').textContent = customerData.completedProjects;
            
            // Set avatar images
            document.getElementById('userAvatar').src = customerData.avatar;
            document.getElementById('welcomeAvatar').src = customerData.avatar;
        }

        // Populate projects
        function populateProjects() {
            const projectsGrid = document.getElementById('projectsGrid');
            projectsGrid.innerHTML = '';

            projects.forEach((project, index) => {
                const projectCard = createProjectCard(project, index);
                projectsGrid.appendChild(projectCard);
            });

            // Re-initialize Lucide icons
            lucide.createIcons();
        }

        function createProjectCard(project, index) {
            const col = document.createElement('div');
            col.className = 'col-lg-4 col-md-6 mb-4';
            
            const statusClass = getStatusClass(project.status);
            const priorityClass = getPriorityClass(project.priority);
            
            col.innerHTML = `
                <div class="project-card" data-project-id="${project.id}" style="animation-delay: ${index * 0.1}s;">
                    <div class="project-image">
                        <img src="${project.image}" alt="${project.title}" loading="lazy">
                        <div class="project-status-badge ${statusClass}">${project.status}</div>
                        <div class="project-priority-badge ${priorityClass}">${project.priority} Priority</div>
                        <div class="progress-overlay">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-white" style="font-weight: 600; font-size: 0.875rem;">Progress</span>
                                <span class="text-white" style="font-weight: 700;">${project.actualProgress}%</span>
                            </div>
                            <div class="progress-bar-container">
                                <div class="progress-bar" style="width: ${project.actualProgress}%"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h4 style="color: var(--slate-900); font-weight: 700; font-size: 1.25rem;">${project.title}</h4>
                            <button class="btn btn-link p-1" style="color: var(--slate-400);">
                                <i data-lucide="more-vertical" style="width: 1rem; height: 1rem;"></i>
                            </button>
                        </div>
                        <p style="color: var(--slate-600); font-size: 0.875rem; margin-bottom: 1rem;">${project.description}</p>

                        <!-- Project Details -->
                        <div style="margin-bottom: 1rem;">
                            <div class="project-detail">
                                <i data-lucide="map-pin" class="project-detail-icon" style="color: var(--orange-500);"></i>
                                <span>${project.location}</span>
                            </div>
                            <div class="project-detail">
                                <i data-lucide="dollar-sign" class="project-detail-icon" style="color: var(--green-500);"></i>
                                <span style="font-weight: 600;">${project.budget}</span>
                            </div>
                            <div class="project-detail">
                                <i data-lucide="calendar" class="project-detail-icon" style="color: var(--blue-500);"></i>
                                <span>Due: ${new Date(project.expectedCompletion).toLocaleDateString()}</span>
                            </div>
                        </div>

                        <!-- Vendor Information -->
                        <div class="vendor-section">
                            <p style="font-size: 0.75rem; font-weight: 600; color: var(--slate-500); margin-bottom: 0.5rem;">ASSIGNED VENDOR</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center" style="gap: 0.75rem; flex: 1; min-width: 0;">
                                    <img src="${project.vendor.avatar}" alt="${project.vendor.name}" class="vendor-avatar">
                                    <div style="min-width: 0; flex: 1;">
                                        <p style="font-weight: 600; color: var(--slate-900); font-size: 0.875rem; margin-bottom: 0.25rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${project.vendor.name}</p>
                                        <div class="d-flex align-items-center" style="gap: 0.5rem;">
                                            <div class="star-rating">
                                                <i data-lucide="star" class="star-filled" style="width: 0.75rem; height: 0.75rem;"></i>
                                                <span style="font-size: 0.75rem; color: var(--slate-600);">${project.vendor.rating}</span>
                                            </div>
                                            <span style="font-size: 0.75rem; color: var(--slate-400);">ID: ${project.vendor.id}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex" style="gap: 0.25rem;">
                                    <button class="vendor-action-btn phone" title="Call vendor">
                                        <i data-lucide="phone" style="width: 0.75rem; height: 0.75rem;"></i>
                                    </button>
                                    <button class="vendor-action-btn message" title="Message vendor">
                                        <i data-lucide="message-square" style="width: 0.75rem; height: 0.75rem;"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Milestones Preview -->
                        <div class="milestones-section">
                            <p style="font-size: 0.75rem; font-weight: 600; color: var(--slate-500); margin-bottom: 0.75rem;">PROJECT MILESTONES</p>
                            <div class="row">
                                ${project.milestones.map(milestone => `
                                    <div class="col-3">
                                        <div class="milestone-item">
                                            <div class="milestone-icon ${getMilestoneClass(milestone.status)}">
                                                ${getMilestoneIcon(milestone.status)}
                                            </div>
                                            <p class="milestone-label">${milestone.name}</p>
                                        </div>
                                    </div>
                                `).join('')}
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="pt-3">
                            <button class="btn-view-details" onclick="viewProjectDetails('${project.id}')">
                                <i data-lucide="eye" style="width: 1rem; height: 1rem;" class="me-2"></i>
                                View Details
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            return col;
        }

        // Populate notifications
        function populateNotifications() {
            const notificationsList = document.getElementById('notificationsList');
            notificationsList.innerHTML = '';

            notifications.forEach(notification => {
                const notificationItem = createNotificationItem(notification);
                notificationsList.appendChild(notificationItem);
            });
        }

        function createNotificationItem(notification) {
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
                    ${!notification.read ? '<div class="notification-dot" style="background: var(--orange-500); margin-top: 0.5rem;"></div>' : ''}
                </div>
            `;
            
            return div;
        }

        // Populate recent activity
        function populateRecentActivity() {
            const recentActivityList = document.getElementById('recentActivityList');
            recentActivityList.innerHTML = '';

            const allActivity = projects.flatMap(project => 
                project.recentActivity.map(activity => ({
                    ...activity,
                    projectTitle: project.title,
                    projectId: project.id
                }))
            ).slice(0, 6);

            allActivity.forEach((activity, index) => {
                const activityItem = createActivityItem(activity, index);
                recentActivityList.appendChild(activityItem);
            });
        }

        function createActivityItem(activity, index) {
            const div = document.createElement('div');
            div.className = 'activity-item';
            div.style.animationDelay = `${index * 0.1}s`;
            
            div.innerHTML = `
                <div class="activity-icon activity-icon-${activity.type}">
                    ${getActivityIcon(activity.type)}
                </div>
                <div style="flex: 1;">
                    <p style="font-weight: 600; color: var(--slate-900); margin-bottom: 0.25rem;">${activity.activity}</p>
                    <p style="color: var(--slate-600); font-size: 0.875rem; margin-bottom: 0.25rem;">Project: ${activity.projectTitle}</p>
                    <p style="color: var(--slate-500); font-size: 0.75rem; margin: 0;">${activity.date}</p>
                </div>
            `;
            
            return div;
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
        }

        // Notification functions
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

        // Utility functions
        function getStatusClass(status) {
            switch (status) {
                case 'Completed': return 'status-completed';
                case 'In Progress': return 'status-in-progress';
                case 'On Hold': return 'status-on-hold';
                case 'Delayed': return 'status-delayed';
                default: return 'status-in-progress';
            }
        }

        function getPriorityClass(priority) {
            switch (priority) {
                case 'High': return 'priority-high';
                case 'Medium': return 'priority-medium';
                case 'Low': return 'priority-low';
                default: return 'priority-medium';
            }
        }

        function getMilestoneClass(status) {
            switch (status) {
                case 'completed': return 'milestone-completed';
                case 'in-progress': return 'milestone-in-progress';
                case 'pending': return 'milestone-pending';
                default: return 'milestone-pending';
            }
        }

        function getMilestoneIcon(status) {
            switch (status) {
                case 'completed': 
                    return '<i data-lucide="check-circle" style="width: 1rem; height: 1rem;"></i>';
                case 'in-progress': 
                    return '<i data-lucide="clock" style="width: 1rem; height: 1rem;"></i>';
                case 'pending': 
                default:
                    return '<div style="width: 0.5rem; height: 0.5rem; background: currentColor; border-radius: 50%;"></div>';
            }
        }

        function getActivityIcon(type) {
            switch (type) {
                case 'success':
                    return '<i data-lucide="check-circle" style="width: 1.25rem; height: 1.25rem;"></i>';
                case 'info':
                    return '<i data-lucide="activity" style="width: 1.25rem; height: 1.25rem;"></i>';
                case 'warning':
                    return '<i data-lucide="alert-circle" style="width: 1.25rem; height: 1.25rem;"></i>';
                default:
                    return '<i data-lucide="info" style="width: 1.25rem; height: 1.25rem;"></i>';
            }
        }

        // Action handlers
        function viewProjectDetails(projectId) {
            showToast(`Opening details for project ${projectId}`, 'info');
            // Here you would typically navigate to a detailed project view
        }

        function handleLogout() {
            showToast('Logging out...', 'info');
            // Here you would typically handle the logout process
            setTimeout(() => {
                // Redirect to login page
                window.location.href = '/login';
            }, 1500);
        }

        function handleSearch(query) {
            if (query.length > 0) {
                showToast(`Searching for: ${query}`, 'info');
                // Here you would implement search functionality
            }
        }

        // Toast notification system
        function showToast(message, type = 'info') {
            const toastContainer = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = 'toast-item';
            
            const colors = {
                'success': 'linear-gradient(135deg, var(--green-500), var(--emerald-500))',
                'info': 'linear-gradient(135deg, var(--blue-500), var(--indigo-500))',
                'warning': 'linear-gradient(135deg, var(--orange-500), var(--yellow-500))',
                'error': 'linear-gradient(135deg, var(--red-500), var(--pink-500))'
            };
            
            toast.style.background = colors[type] || colors.info;
            toast.style.color = 'white';
            toast.innerHTML = `
                <div class="d-flex align-items-center" style="gap: 0.75rem;">
                    <i data-lucide="${type === 'success' ? 'check-circle' : type === 'warning' ? 'alert-circle' : 'info'}" style="width: 1.25rem; height: 1.25rem;"></i>
                    <span style="font-weight: 600;">${message}</span>
                </div>
            `;
            
            toastContainer.appendChild(toast);
            
            // Initialize Lucide icons in the toast
            lucide.createIcons();
            
            // Show toast
            setTimeout(() => {
                toast.classList.add('show');
            }, 100);
            
            // Hide and remove toast after 4 seconds
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.remove();
                    }
                }, 300);
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