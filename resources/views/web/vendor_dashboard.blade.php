@extends('layouts.vendor_dash.app')
@section('title', 'Project Questionnaire | ConstructKaro')
@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONSTRUCTKARO - Advanced Vendor Dashboard</title>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    
    <style>
        /* Import design system variables from globals.css */
        :root {
            --font-size: 14px;
            --background: #ffffff;
            --foreground: oklch(0.145 0 0);
            --card: #ffffff;
            --card-foreground: oklch(0.145 0 0);
            --popover: oklch(1 0 0);
            --popover-foreground: oklch(0.145 0 0);
            --primary: #030213;
            --primary-foreground: oklch(1 0 0);
            --secondary: oklch(0.95 0.0058 264.53);
            --secondary-foreground: #030213;
            --muted: #ececf0;
            --muted-foreground: #717182;
            --accent: #e9ebef;
            --accent-foreground: #030213;
            --destructive: #d4183d;
            --destructive-foreground: #ffffff;
            --border: rgba(0, 0, 0, 0.1);
            --input: transparent;
            --input-background: #f3f3f5;
            --switch-background: #cbced4;
            --font-weight-medium: 500;
            --font-weight-normal: 400;
            --ring: oklch(0.708 0 0);
            --radius: 0.625rem;

            /* Additional color variables for gradients */
            --orange-500: #f97316;
            --orange-600: #ea580c;
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
            --amber-500: #f59e0b;
            --amber-600: #d97706;
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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            font-size: var(--font-size);
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, var(--slate-50) 0%, rgba(239, 246, 255, 0.3) 50%, rgba(238, 242, 255, 0.2) 100%);
            color: var(--foreground);
            line-height: 1.5;
            font-weight: var(--font-weight-normal);
            min-height: 100vh;
        }

        /* Typography */
        h1 {
            font-size: 1.5rem;
            font-weight: var(--font-weight-medium);
            line-height: 1.5;
        }

        h2 {
            font-size: 1.25rem;
            font-weight: var(--font-weight-medium);
            line-height: 1.5;
        }

        h3 {
            font-size: 1.125rem;
            font-weight: var(--font-weight-medium);
            line-height: 1.5;
        }

        h4 {
            font-size: 1rem;
            font-weight: var(--font-weight-medium);
            line-height: 1.5;
        }

        p {
            font-size: 1rem;
            font-weight: var(--font-weight-normal);
            line-height: 1.5;
        }

        label {
            font-size: 1rem;
            font-weight: var(--font-weight-medium);
            line-height: 1.5;
        }

        button {
            font-size: 1rem;
            font-weight: var(--font-weight-medium);
            line-height: 1.5;
        }

        input {
            font-size: 1rem;
            font-weight: var(--font-weight-normal);
            line-height: 1.5;
        }

        /* Enhanced Header */
        .header {
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .header-container {
            max-width: 80rem;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 4rem;
        }

        /* Brand */
        .brand {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .brand-icon {
            position: relative;
            width: 2.5rem;
            height: 2.5rem;
            background: linear-gradient(135deg, var(--orange-500), var(--red-500), var(--pink-500));
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.3);
        }

        .brand-icon::after {
            content: '';
            position: absolute;
            top: -0.125rem;
            right: -0.125rem;
            width: 0.75rem;
            height: 0.75rem;
            background: var(--emerald-500);
            border-radius: 50%;
            border: 2px solid white;
        }

        .brand-text {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--foreground);
        }

        .brand-accent {
            color: var(--orange-500);
        }

        .brand-subtitle {
            font-size: 0.75rem;
            color: var(--muted-foreground);
            font-weight: var(--font-weight-normal);
        }

        /* Search */
        .search-container {
            position: relative;
            flex: 1;
            max-width: 28rem;
            margin: 0 2rem;
        }

        .search-input {
            width: 100%;
            height: 2.5rem;
            padding: 0 1rem 0 2.5rem;
            background: var(--muted);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            color: var(--foreground);
            transition: all 0.2s ease;
        }

        .search-input:focus {
            outline: none;
            background: var(--background);
            border-color: var(--ring);
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted-foreground);
            width: 1rem;
            height: 1rem;
        }

        /* User Actions */
        .user-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .notification-btn {
            position: relative;
            width: 2.25rem;
            height: 2.25rem;
            border: none;
            background: transparent;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .notification-btn:hover {
            background: var(--muted);
        }

        .notification-badge {
            position: absolute;
            top: -0.25rem;
            right: -0.25rem;
            width: 1.25rem;
            height: 1.25rem;
            background: var(--destructive);
            color: white;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: var(--muted);
            border-radius: 0.5rem;
            padding: 0.5rem;
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

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-size: 0.75rem;
            font-weight: var(--font-weight-medium);
            color: var(--foreground);
        }

        .user-role {
            font-size: 0.75rem;
            color: var(--muted-foreground);
        }

        .logout-btn {
            width: 2rem;
            height: 2rem;
            border: none;
            background: transparent;
            border-radius: 0.375rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.1);
            color: var(--destructive);
        }

        /* Notifications Dropdown */
        .notifications-dropdown {
            position: absolute;
            right: 0;
            top: 100%;
            margin-top: 0.5rem;
            width: 20rem;
            background: var(--popover);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            z-index: 50;
            display: none;
        }

        .notifications-dropdown.show {
            display: block;
            animation: slideIn 0.2s ease-out;
        }

        .notification-header {
            padding: 1rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .notification-title {
            font-size: 0.875rem;
            font-weight: var(--font-weight-medium);
            color: var(--foreground);
        }

        .notification-count {
            background: var(--secondary);
            color: var(--secondary-foreground);
            font-size: 0.75rem;
            padding: 0.125rem 0.5rem;
            border-radius: 0.375rem;
        }

        .notification-item {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--border);
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .notification-item:hover {
            background: var(--muted);
        }

        .notification-item.unread {
            background: rgba(59, 130, 246, 0.05);
        }

        .notification-content {
            display: flex;
            align-items: start;
            gap: 0.75rem;
        }

        .notification-dot {
            width: 0.5rem;
            height: 0.5rem;
            border-radius: 50%;
            margin-top: 0.5rem;
            flex-shrink: 0;
        }

        .notification-dot.urgent { background: var(--destructive); }
        .notification-dot.success { background: var(--emerald-500); }
        .notification-dot.info { background: var(--blue-500); }
        .notification-dot.warning { background: var(--amber-500); }

        .notification-text {
            flex: 1;
        }

        .notification-subject {
            font-size: 0.875rem;
            font-weight: var(--font-weight-medium);
            color: var(--foreground);
            margin-bottom: 0.25rem;
        }

        .notification-message {
            font-size: 0.75rem;
            color: var(--muted-foreground);
            margin-bottom: 0.25rem;
        }

        .notification-time {
            font-size: 0.75rem;
            color: var(--muted-foreground);
        }

        .notification-action {
            background: var(--destructive);
            color: var(--destructive-foreground);
            font-size: 0.75rem;
            padding: 0.125rem 0.5rem;
            border-radius: 0.375rem;
        }

        /* Main Content */
        .main-content {
            max-width: 105rem;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        /* Tab Navigation */
        .tab-navigation {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            height: 3rem;
            background: var(--background);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 0.25rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .tab-btn {
            border: none;
            background: transparent;
            color: var(--muted-foreground);
            font-weight: var(--font-weight-medium);
            font-size: 0.875rem;
            border-radius: calc(var(--radius) - 2px);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .tab-btn:hover {
            background: var(--muted);
            color: var(--foreground);
        }

        .tab-btn.active {
            background: linear-gradient(135deg, var(--orange-500), var(--pink-500));
            color: white;
            box-shadow: 0 2px 8px rgba(249, 115, 22, 0.3);
        }

        /* Tab Content */
        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
            animation: fadeIn 0.3s ease-in-out;
        }

        /* Cards */
        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease;
        }

        .card:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border);
        }

        .card-title {
            font-size: 1rem;
            font-weight: var(--font-weight-medium);
            color: var(--card-foreground);
            margin-bottom: 0.25rem;
        }

        .card-description {
            font-size: 0.875rem;
            color: var(--muted-foreground);
        }

        .card-content {
            padding: 1.5rem;
        }

        /* Gradient Cards */
        .gradient-card {
            background: linear-gradient(135deg, var(--blue-600), var(--purple-600), var(--indigo-600));
            color: white;
            border: none;
            box-shadow: 0 8px 32px rgba(59, 130, 246, 0.3);
        }

        .gradient-card-green {
            background: linear-gradient(135deg, var(--emerald-500), var(--green-500), var(--emerald-600));
            box-shadow: 0 8px 32px rgba(16, 185, 129, 0.3);
        }

        /* Metric Cards */
        .metric-card {
            padding: 1.5rem;
            text-align: left;
        }

        .metric-icon {
            width: 3rem;
            height: 3rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .metric-icon.emerald { background: rgba(16, 185, 129, 0.1); color: var(--emerald-600); }
        .metric-icon.blue { background: rgba(59, 130, 246, 0.1); color: var(--blue-600); }
        .metric-icon.purple { background: rgba(139, 92, 246, 0.1); color: var(--purple-600); }
        .metric-icon.amber { background: rgba(245, 158, 11, 0.1); color: var(--amber-600); }

        .metric-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--foreground);
            margin-bottom: 0.25rem;
        }

        .metric-label {
            font-size: 0.875rem;
            color: var(--muted-foreground);
            margin-bottom: 0.25rem;
        }

        .metric-change {
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .metric-change.positive { color: var(--emerald-600); }
        .metric-change.negative { color: var(--destructive); }

        /* Progress Bars */
        .progress-container {
            margin-bottom: 1.5rem;
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .progress-label {
            font-size: 0.875rem;
            color: var(--muted-foreground);
        }

        .progress-value {
            font-size: 0.875rem;
            font-weight: var(--font-weight-medium);
            color: var(--foreground);
        }

        .progress-bar {
            width: 100%;
            height: 0.5rem;
            background: var(--muted);
            border-radius: 0.25rem;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            border-radius: 0.25rem;
            transition: width 0.5s ease;
        }

        .progress-fill.emerald { background: var(--emerald-500); }
        .progress-fill.blue { background: var(--blue-500); }
        .progress-fill.orange { background: var(--orange-500); }
        .progress-fill.purple { background: var(--purple-500); }

        /* Project Cards */
        .project-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .project-card:hover {
            transform: translateY(-4px) scale(1.01);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
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
            transition: transform 0.5s ease;
        }

        .project-card:hover .project-image img {
            transform: scale(1.05);
        }

        .project-badges {
            position: absolute;
            top: 1rem;
            right: 1rem;
            display: flex;
            gap: 0.5rem;
        }

        .project-progress-overlay {
            position: absolute;
            bottom: 1rem;
            left: 1rem;
            right: 1rem;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 0.5rem;
            padding: 0.75rem;
        }

        .project-details {
            padding: 1.5rem;
        }

        .project-meta {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            color: var(--muted-foreground);
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            font-weight: var(--font-weight-medium);
            border-radius: 0.375rem;
            border: 1px solid transparent;
        }

        .badge.primary {
            background: var(--primary);
            color: var(--primary-foreground);
        }

        .badge.secondary {
            background: var(--secondary);
            color: var(--secondary-foreground);
        }

        .badge.success {
            background: var(--emerald-500);
            color: white;
        }

        .badge.info {
            background: var(--blue-500);
            color: white;
        }

        .badge.warning {
            background: var(--amber-500);
            color: white;
        }

        .badge.danger {
            background: var(--destructive);
            color: var(--destructive-foreground);
        }

        .badge.outline {
            background: transparent;
            border-color: var(--border);
            color: var(--foreground);
        }

        /* Status Badges */
        .status-on-track {
            background: var(--emerald-500);
            color: white;
        }

        .status-at-risk {
            background: var(--amber-500);
            color: white;
        }

        .status-delayed {
            background: var(--destructive);
            color: white;
        }

        .priority-high {
            background: rgba(239, 68, 68, 0.1);
            color: var(--destructive);
            border-color: rgba(239, 68, 68, 0.2);
        }

        .priority-medium {
            background: rgba(245, 158, 11, 0.1);
            color: var(--amber-600);
            border-color: rgba(245, 158, 11, 0.2);
        }

        .priority-low {
            background: rgba(34, 197, 94, 0.1);
            color: var(--emerald-600);
            border-color: rgba(34, 197, 94, 0.2);
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: var(--font-weight-medium);
            border-radius: var(--radius);
            border: 1px solid transparent;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--blue-500), var(--purple-600));
            color: white;
            border: none;
        }

        .btn-primary:hover:not(:disabled) {
            background: linear-gradient(135deg, var(--blue-600), var(--purple-700));
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .btn-secondary {
            background: var(--secondary);
            color: var(--secondary-foreground);
        }

        .btn-secondary:hover:not(:disabled) {
            background: var(--accent);
        }

        .btn-outline {
            background: transparent;
            border-color: var(--border);
            color: var(--foreground);
        }

        .btn-outline:hover:not(:disabled) {
            background: var(--muted);
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.75rem;
        }

        .btn-lg {
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: var(--font-weight-medium);
            color: var(--foreground);
        }

        .form-input {
            width: 100%;
            padding: 0.75rem;
            background: var(--input-background);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            color: var(--foreground);
            transition: all 0.2s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--ring);
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1);
        }

        /* Grid Layouts */
        .grid {
            display: grid;
            gap: 1.5rem;
        }

        .grid-cols-1 { grid-template-columns: repeat(1, 1fr); }
        .grid-cols-2 { grid-template-columns: repeat(2, 1fr); }
        .grid-cols-3 { grid-template-columns: repeat(3, 1fr); }
        .grid-cols-4 { grid-template-columns: repeat(4, 1fr); }

        /* Spacing */
        .space-y-4 > * + * { margin-top: 1rem; }
        .space-y-6 > * + * { margin-top: 1.5rem; }
        .space-y-8 > * + * { margin-top: 2rem; }

        .mb-4 { margin-bottom: 1rem; }
        .mb-6 { margin-bottom: 1.5rem; }
        .mb-8 { margin-bottom: 2rem; }

        .p-4 { padding: 1rem; }
        .p-6 { padding: 1.5rem; }
        .p-8 { padding: 2rem; }

        /* Flex Utilities */
        .flex { display: flex; }
        .flex-col { flex-direction: column; }
        .items-center { align-items: center; }
        .items-start { align-items: flex-start; }
        .justify-between { justify-content: space-between; }
        .justify-center { justify-content: center; }
        .gap-2 { gap: 0.5rem; }
        .gap-3 { gap: 0.75rem; }
        .gap-4 { gap: 1rem; }
        .gap-6 { gap: 1.5rem; }

        /* Text Utilities */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-xs { font-size: 0.75rem; }
        .text-sm { font-size: 0.875rem; }
        .text-base { font-size: 1rem; }
        .text-lg { font-size: 1.125rem; }
        .text-xl { font-size: 1.25rem; }
        .text-2xl { font-size: 1.5rem; }
        .text-3xl { font-size: 2rem; }

        .font-medium { font-weight: var(--font-weight-medium); }
        .font-semibold { font-weight: 600; }
        .font-bold { font-weight: 700; }

        /* Color Utilities */
        .text-muted { color: var(--muted-foreground); }
        .text-emerald { color: var(--emerald-600); }
        .text-blue { color: var(--blue-600); }
        .text-amber { color: var(--amber-600); }
        .text-red { color: var(--destructive); }

        /* Background Utilities */
        .bg-muted { background: var(--muted); }
        .bg-emerald { background: rgba(16, 185, 129, 0.1); }
        .bg-blue { background: rgba(59, 130, 246, 0.1); }
        .bg-amber { background: rgba(245, 158, 11, 0.1); }
        .bg-red { background: rgba(239, 68, 68, 0.1); }

        /* Activity Items */
        .activity-item {
            display: flex;
            align-items: start;
            gap: 1rem;
            padding: 0.75rem;
            background: var(--muted);
            border-radius: var(--radius);
            margin-bottom: 0.75rem;
            transition: all 0.2s ease;
        }

        .activity-item:hover {
            background: var(--accent);
            transform: translateY(-1px);
        }

        .activity-icon {
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
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
            border: 2px solid;
            flex-shrink: 0;
        }

        .step-completed {
            background: var(--emerald-500);
            border-color: var(--emerald-500);
            color: white;
        }

        .step-current {
            background: var(--blue-500);
            border-color: var(--blue-500);
            color: white;
        }

        .step-pending {
            background: var(--muted);
            border-color: var(--border);
            color: var(--muted-foreground);
        }

        /* Animations */
        @keyframes slideIn {
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
        @media (max-width: 1024px) {
            .grid-cols-4 { grid-template-columns: repeat(2, 1fr); }
            .search-container { display: none; }
        }

        @media (max-width: 768px) {
            .header-content { flex-wrap: wrap; }
            .user-info { display: none; }
            .tab-navigation { grid-template-columns: repeat(3, 1fr); font-size: 0.75rem; }
            .grid-cols-3 { grid-template-columns: repeat(1, 1fr); }
            .grid-cols-2 { grid-template-columns: repeat(1, 1fr); }
            .main-content { padding: 1rem; }
        }

        @media (max-width: 640px) {
            .tab-navigation { grid-template-columns: repeat(2, 1fr); }
            .project-card { margin-bottom: 1rem; }
        }

        /* Hover Effects */
        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--muted);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--muted-foreground);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--foreground);
        }

        /* Hidden on mobile utilities */
        @media (max-width: 768px) {
            .hidden-mobile { display: none !important; }
        }

        /* Show only on mobile */
        .show-mobile {
            display: none;
        }

        @media (max-width: 768px) {
            .show-mobile { display: block; }
        }
    </style>
</head>
<body>
    <!-- Enhanced Header -->
    <!--  -->

    <!-- Main Content -->
    <main class="main-content">
        <!-- Tab Navigation -->
        <div class="tab-navigation">
            <button class="tab-btn active" onclick="switchTab('overview')" id="tab-overview">Overview</button>
            <button class="tab-btn" onclick="switchTab('verification')" id="tab-verification">Verification</button>
            <button class="tab-btn" onclick="switchTab('projects')" id="tab-projects">Projects</button>
            <button class="tab-btn" onclick="switchTab('bidding')" id="tab-bidding">Bidding</button>
            <button class="tab-btn" onclick="switchTab('earnings')" id="tab-earnings">Earnings</button>
            <button class="tab-btn" onclick="switchTab('profile')" id="tab-profile">Profile</button>
        </div>

        <!-- Overview Tab -->
        <div id="content-overview" class="tab-content active">
            <!-- Welcome Section -->
            <div class="card gradient-card mb-6">
                <div class="card-content">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div style="width: 3rem; height: 3rem; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); border-radius: 0.75rem; display: flex; align-items: center; justify-content: center;">
                                <i data-lucide="sparkles" style="width: 1.5rem; height: 1.5rem; color: white;"></i>
                            </div>
                            <div>
                                <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem;">Welcome back, Elite Construction Partners!</h2>
                                <p style="color: rgba(255, 255, 255, 0.8);">Building the future, one project at a time</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div style="font-size: 2rem; font-weight: 700; margin-bottom: 0.25rem;">78%</div>
                            <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.875rem; margin-bottom: 0.5rem;">Profile Complete</p>
                            <div style="width: 8rem; background: rgba(255, 255, 255, 0.2); border-radius: 0.5rem; height: 0.5rem;">
                                <div style="background: linear-gradient(90deg, var(--emerald-500), var(--green-500)); height: 0.5rem; border-radius: 0.5rem; width: 78%; transition: width 0.7s ease;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Key Metrics Grid -->
            <div class="grid grid-cols-4 mb-8">
                <div class="card hover-lift">
                    <div class="metric-card">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="metric-label">Total Projects</p>
                                <p class="metric-value">47</p>
                                <div class="metric-change positive">
                                    <i data-lucide="trending-up" style="width: 0.75rem; height: 0.75rem;"></i>
                                    +12% this month
                                </div>
                            </div>
                            <div class="metric-icon emerald">
                                <i data-lucide="bar-chart-3" style="width: 1.5rem; height: 1.5rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card hover-lift">
                    <div class="metric-card">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="metric-label">Active Projects</p>
                                <p class="metric-value">12</p>
                                <div class="metric-change">
                                    <i data-lucide="activity" style="width: 0.75rem; height: 0.75rem;"></i>
                                    3 due this week
                                </div>
                            </div>
                            <div class="metric-icon blue">
                                <i data-lucide="gauge" style="width: 1.5rem; height: 1.5rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card hover-lift">
                    <div class="metric-card">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="metric-label">Total Earnings</p>
                                <p class="metric-value">₹3.2 Cr</p>
                                <div class="metric-change positive">
                                    <i data-lucide="arrow-up-right" style="width: 0.75rem; height: 0.75rem;"></i>
                                    +15.3% growth
                                </div>
                            </div>
                            <div class="metric-icon purple">
                                <i data-lucide="wallet" style="width: 1.5rem; height: 1.5rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card hover-lift">
                    <div class="metric-card">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="metric-label">Client Rating</p>
                                <p class="metric-value">4.8</p>
                                <div class="metric-change">
                                    <i data-lucide="star" style="width: 0.75rem; height: 0.75rem; color: var(--amber-500);"></i>
                                    156 reviews
                                </div>
                            </div>
                            <div class="metric-icon amber">
                                <i data-lucide="trophy" style="width: 1.5rem; height: 1.5rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance Overview -->
            <div class="grid grid-cols-2 gap-6 mb-8">
                <!-- Performance Metrics -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title flex items-center gap-2">
                            <i data-lucide="gauge" style="width: 1.25rem; height: 1.25rem; color: var(--blue-600);"></i>
                            Performance Dashboard
                        </h3>
                        <p class="card-description">Your key performance indicators</p>
                    </div>
                    <div class="card-content space-y-6">
                        <div class="progress-container">
                            <div class="progress-header">
                                <span class="progress-label">Project Success Rate</span>
                                <span class="progress-value">96%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill emerald" style="width: 96%;"></div>
                            </div>
                        </div>

                        <div class="progress-container">
                            <div class="progress-header">
                                <span class="progress-label">On-Time Delivery</span>
                                <span class="progress-value">94%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill blue" style="width: 94%;"></div>
                            </div>
                        </div>

                        <div class="progress-container">
                            <div class="progress-header">
                                <span class="progress-label">Client Satisfaction</span>
                                <span class="progress-value">4.8/5.0</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill orange" style="width: 96%;"></div>
                            </div>
                        </div>

                        <div class="progress-container">
                            <div class="progress-header">
                                <span class="progress-label">Quality Score</span>
                                <span class="progress-value">94%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill purple" style="width: 94%;"></div>
                            </div>
                        </div>

                        <div style="border-top: 1px solid var(--border); padding-top: 1rem;">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-center p-3 bg-muted" style="border-radius: 0.5rem;">
                                    <p style="font-size: 1.25rem; font-weight: 700; color: var(--emerald-600);">72%</p>
                                    <p class="text-xs text-muted">Repeat Clients</p>
                                </div>
                                <div class="text-center p-3 bg-muted" style="border-radius: 0.5rem;">
                                    <p style="font-size: 1.25rem; font-weight: 700; color: var(--blue-600);">+15.3%</p>
                                    <p class="text-xs text-muted">Monthly Growth</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

               
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Quick Actions</h3>
                    <p class="card-description">Frequently used actions and shortcuts</p>
                </div>
                <div class="card-content">
                    <div class="grid grid-cols-4 gap-4">
                        <button class="btn btn-outline flex-col" style="height: 5rem; gap: 0.5rem;">
                            <i data-lucide="plus" style="width: 1.25rem; height: 1.25rem;"></i>
                            <span class="text-xs">New Bid</span>
                        </button>
                        <button class="btn btn-outline flex-col" style="height: 5rem; gap: 0.5rem;">
                            <i data-lucide="upload" style="width: 1.25rem; height: 1.25rem;"></i>
                            <span class="text-xs">Upload Documents</span>
                        </button>
                        <button class="btn btn-outline flex-col" style="height: 5rem; gap: 0.5rem;">
                            <i data-lucide="message-square" style="width: 1.25rem; height: 1.25rem;"></i>
                            <span class="text-xs">Contact Support</span>
                        </button>
                        <button class="btn btn-outline flex-col" style="height: 5rem; gap: 0.5rem;">
                            <i data-lucide="download" style="width: 1.25rem; height: 1.25rem;"></i>
                            <span class="text-xs">Export Reports</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Verification Tab -->
        <div id="content-verification" class="tab-content">
            <!-- Verification Status -->
            <div class="card gradient-card mb-6">
                <div class="card-content">
                    <div class="flex items-center justify-between">
                        <div class="space-y-2">
                            <h2 style="font-size: 1.5rem; font-weight: 700;">Profile Verification</h2>
                            <p style="color: rgba(255, 255, 255, 0.8);">Complete verification to unlock all platform features</p>
                        </div>
                        <div class="text-right">
                            <div style="font-size: 2rem; font-weight: 700;">78%</div>
                            <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.875rem;">Complete</p>
                        </div>
                    </div>
                    <div style="margin-top: 1.5rem;">
                        <div style="width: 100%; background: rgba(255, 255, 255, 0.2); border-radius: 0.5rem; height: 0.75rem;">
                            <div style="background: linear-gradient(90deg, var(--emerald-500), var(--green-500)); height: 0.75rem; border-radius: 0.5rem; width: 78%; transition: width 0.7s ease;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Verification Steps -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title flex items-center gap-2">
                        <i data-lucide="shield" style="width: 1.25rem; height: 1.25rem; color: var(--blue-600);"></i>
                        Verification Progress
                    </h3>
                    <p class="card-description">Track your verification status step by step</p>
                </div>
                <div class="card-content space-y-6">
                    <div id="verificationSteps">
                        <!-- Verification steps will be populated by JavaScript -->
                    </div>

                    <div style="border-top: 1px solid var(--border); padding-top: 1.5rem; margin-top: 1.5rem;">
                        <div class="bg-emerald" style="border: 1px solid rgba(34, 197, 94, 0.2); border-radius: 0.5rem; padding: 1rem;">
                            <div class="flex items-start gap-3">
                                <i data-lucide="zap" style="width: 1.25rem; height: 1.25rem; color: var(--emerald-600); margin-top: 0.125rem;"></i>
                                <div>
                                    <h4 style="color: var(--emerald-600); font-weight: 600; margin-bottom: 0.5rem;">Verification Benefits</h4>
                                    <ul style="color: var(--emerald-600); font-size: 0.875rem; padding-left: 1rem;">
                                        <li>Access to premium project listings</li>
                                        <li>Higher bid success rate with verified badge</li>
                                        <li>Direct client communication</li>
                                        <li>Featured vendor placement</li>
                                        <li>Priority customer support</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-4">
                        <button class="btn btn-outline">Contact Verification Team</button>
                        <button class="btn btn-primary">Complete Verification</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Projects Tab -->
        <div id="content-projects" class="tab-content">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.25rem;">Active Projects</h3>
                    <p class="text-sm text-muted">Monitor and manage your ongoing projects</p>
                </div>
                <div class="flex gap-2">
                    <button class="btn btn-outline btn-sm">
                        <i data-lucide="filter" style="width: 1rem; height: 1rem;" class="mr-2"></i>
                        Filter
                    </button>
                    <button class="btn btn-outline btn-sm">
                        <i data-lucide="download" style="width: 1rem; height: 1rem;" class="mr-2"></i>
                        Export
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6" id="activeProjectsList">
                <!-- Active projects will be populated by JavaScript -->
            </div>
        </div>

        <!-- Bidding Tab -->
        <div id="content-bidding" class="tab-content">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.25rem;">Available Projects</h3>
                    <p class="text-sm text-muted">Browse and bid on new opportunities</p>
                </div>
                <div class="flex gap-2">
                    <button class="btn btn-outline btn-sm">
                        <i data-lucide="filter" style="width: 1rem; height: 1rem;" class="mr-2"></i>
                        Filter
                    </button>
                    <button class="btn btn-primary btn-sm">
                        <i data-lucide="plus" style="width: 1rem; height: 1rem;" class="mr-2"></i>
                        Submit Bid
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-6" id="availableProjectsList">
                <!-- Available projects will be populated by JavaScript -->
            </div>
        </div>

        <!-- Earnings Tab -->
        <div id="content-earnings" class="tab-content">
            <div class="grid grid-cols-3 gap-6">
                <!-- Main Earnings Card -->
                <div style="grid-column: span 2;">
                    <div class="card gradient-card-green mb-6">
                        <div class="card-content">
                            <div class="flex items-center justify-between">
                                <div class="space-y-2">
                                    <h3 style="font-size: 2rem; font-weight: 700;">₹3.2 Cr</h3>
                                    <p style="color: rgba(255, 255, 255, 0.8);">Total Lifetime Earnings</p>
                                    <div class="flex items-center gap-2" style="color: rgba(255, 255, 255, 0.8);">
                                        <i data-lucide="trending-up" style="width: 1rem; height: 1rem;"></i>
                                        <span class="text-sm">+15.3% from last month</span>
                                    </div>
                                </div>
                                <div style="width: 4rem; height: 4rem; background: rgba(255, 255, 255, 0.2); border-radius: 1rem; display: flex; align-items: center; justify-content: center;">
                                    <i data-lucide="wallet" style="width: 2rem; height: 2rem; color: white;"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="metric-icon amber" style="margin: 0 auto 0.75rem;">
                                    <i data-lucide="clock" style="width: 1.5rem; height: 1.5rem;"></i>
                                </div>
                                <p style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.25rem;">₹65 Lakh</p>
                                <p class="text-sm text-muted">Pending Payments</p>
                            </div>
                        </div>

                        <div class="card text-center">
                            <div class="card-content">
                                <div class="metric-icon blue" style="margin: 0 auto 0.75rem;">
                                    <i data-lucide="trending-up" style="width: 1.5rem; height: 1.5rem;"></i>
                                </div>
                                <p style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.25rem;">₹28 Lakh</p>
                                <p class="text-sm text-muted">This Month</p>
                            </div>
                        </div>

                        <div class="card text-center">
                            <div class="card-content">
                                <div class="metric-icon purple" style="margin: 0 auto 0.75rem;">
                                    <i data-lucide="bar-chart-3" style="width: 1.5rem; height: 1.5rem;"></i>
                                </div>
                                <p style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.25rem;">₹1.8 Cr</p>
                                <p class="text-sm text-muted">Avg Project Value</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment History -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title flex items-center gap-2">
                            <i data-lucide="dollar-sign" style="width: 1.25rem; height: 1.25rem; color: var(--emerald-600);"></i>
                            Recent Payments
                        </h3>
                    </div>
                    <div class="card-content">
                        <div id="paymentHistoryList">
                            <!-- Payment history will be populated by JavaScript -->
                        </div>
                        <button class="btn btn-outline btn-sm" style="width: 100%; margin-top: 1rem;">
                            View All Transactions
                        </button>
                    </div>
                </div>
            </div>

            <!-- Financial Insights -->
            <div class="card mt-6">
                <div class="card-header">
                    <h3 class="card-title">Financial Insights</h3>
                    <p class="card-description">Key financial metrics and trends</p>
                </div>
                <div class="card-content">
                    <div class="grid grid-cols-4 gap-6">
                        <div class="text-center p-4 bg-emerald" style="border-radius: 0.5rem;">
                            <p style="font-size: 1.5rem; font-weight: 700; color: var(--emerald-600);">24.5%</p>
                            <p class="text-sm text-muted">Profit Margin</p>
                        </div>
                        <div class="text-center p-4 bg-blue" style="border-radius: 0.5rem;">
                            <p style="font-size: 1.5rem; font-weight: 700; color: var(--blue-600);">₹1.8L</p>
                            <p class="text-sm text-muted">Avg Invoice Value</p>
                        </div>
                        <div class="text-center p-4 bg-muted" style="border-radius: 0.5rem;">
                            <p style="font-size: 1.5rem; font-weight: 700; color: var(--purple-600);">15 days</p>
                            <p class="text-sm text-muted">Avg Payment Time</p>
                        </div>
                        <div class="text-center p-4 bg-amber" style="border-radius: 0.5rem;">
                            <p style="font-size: 1.5rem; font-weight: 700; color: var(--amber-600);">98.5%</p>
                            <p class="text-sm text-muted">Collection Rate</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Tab -->
        <div id="content-profile" class="tab-content">
            <div class="grid grid-cols-3 gap-6">
                <!-- Company Information -->
                <div style="grid-column: span 2;">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title flex items-center gap-2">
                                <i data-lucide="building" style="width: 1.25rem; height: 1.25rem; color: var(--blue-600);"></i>
                                Company Information
                            </h3>
                            <p class="card-description">Manage your company details and profile</p>
                        </div>
                        <div class="card-content space-y-6">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="form-group">
                                    <label class="form-label">Company Name</label>
                                    <input type="text" class="form-input" value="Elite Construction Partners">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Email Address</label>
                                    <input type="email" class="form-input" value="contact@eliteconstruction.com">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Phone Number</label>
                                    <input type="tel" class="form-input" value="+91 98765 43210">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Location</label>
                                    <input type="text" class="form-input" value="Mumbai, Maharashtra">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Established Year</label>
                                    <input type="text" class="form-input" value="2018">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Employee Count</label>
                                    <input type="text" class="form-input" value="50-100">
                                </div>
                            </div>

                            <div>
                                <label class="form-label">Specializations</label>
                                <div class="flex flex-wrap gap-2" style="margin-top: 0.5rem;">
                                    <span class="badge secondary">Residential</span>
                                    <span class="badge secondary">Commercial</span>
                                    <span class="badge secondary">Renovation</span>
                                    <button class="btn btn-outline btn-sm">
                                        <i data-lucide="plus" style="width: 0.75rem; height: 0.75rem; margin-right: 0.25rem;"></i>
                                        Add
                                    </button>
                                </div>
                            </div>

                            <div style="border-top: 1px solid var(--border); padding-top: 1.5rem;">
                                <div class="flex gap-3">
                                    <button class="btn btn-primary">
                                        <i data-lucide="edit" style="width: 1rem; height: 1rem; margin-right: 0.5rem;"></i>
                                        Update Profile
                                    </button>
                                    <button class="btn btn-outline">
                                        <i data-lucide="settings" style="width: 1rem; height: 1rem; margin-right: 0.5rem;"></i>
                                        Settings
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Ratings & Reviews -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title flex items-center gap-2">
                                <i data-lucide="star" style="width: 1.25rem; height: 1.25rem; color: var(--amber-500);"></i>
                                Ratings & Reviews
                            </h3>
                        </div>
                        <div class="card-content text-center space-y-4">
                            <div>
                                <div style="font-size: 2.5rem; font-weight: 700; margin-bottom: 0.5rem;">4.8</div>
                                <div class="flex justify-center gap-1 mb-2">
                                    <i data-lucide="star" style="width: 1.25rem; height: 1.25rem; color: var(--amber-500); fill: var(--amber-500);"></i>
                                    <i data-lucide="star" style="width: 1.25rem; height: 1.25rem; color: var(--amber-500); fill: var(--amber-500);"></i>
                                    <i data-lucide="star" style="width: 1.25rem; height: 1.25rem; color: var(--amber-500); fill: var(--amber-500);"></i>
                                    <i data-lucide="star" style="width: 1.25rem; height: 1.25rem; color: var(--amber-500); fill: var(--amber-500);"></i>
                                    <i data-lucide="star" style="width: 1.25rem; height: 1.25rem; color: var(--muted-foreground);"></i>
                                </div>
                                <p class="text-sm text-muted">156 reviews</p>
                            </div>
                            <button class="btn btn-outline btn-sm" style="width: 100%;">
                                View All Reviews
                            </button>
                        </div>
                    </div>

                    <!-- Achievements -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title flex items-center gap-2">
                                <i data-lucide="trophy" style="width: 1.25rem; height: 1.25rem; color: var(--amber-500);"></i>
                                Achievements
                            </h3>
                        </div>
                        <div class="card-content space-y-3" id="achievementsList">
                            <!-- Achievements will be populated by JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

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
            companyName: "Elite Construction Partners",
            email: "contact@eliteconstruction.com",
            phone: "+91 98765 43210",
            location: "Mumbai, Maharashtra",
            established: "2018",
            employeeCount: "50-100",
            specialization: ["Residential", "Commercial", "Renovation"],
            verificationStatus: "Verification Pending",
            profileCompletion: 78,
            rating: 4.8,
            totalProjects: 47,
            activeProjects: 12,
            completedProjects: 35,
            totalEarnings: "₹3.2 Cr",
            monthlyGrowth: 15.3,
            avatar: "https://images.unsplash.com/photo-1560250097-0b93528c311a?w=150&h=150&fit=crop"
        };

        // Verification steps
        const verificationSteps = [
            {
                step: 1,
                title: "Profile Setup",
                description: "Basic company information submitted",
                status: "completed",
                date: "Jan 10, 2024"
            },
            {
                step: 2,
                title: "Document Upload",
                description: "Required documents uploaded and under review",
                status: "completed",
                date: "Jan 12, 2024"
            },
            {
                step: 3,
                title: "Verification Review",
                description: "Documents being verified by our team",
                status: "current",
                date: "In Progress"
            },
            {
                step: 4,
                title: "Background Check",
                description: "Final verification and background screening",
                status: "pending",
                date: "Pending"
            },
            {
                step: 5,
                title: "Account Approval",
                description: "Full access granted to all platform features",
                status: "pending",
                date: "Pending"
            }
        ];

        // Active projects
        const activeProjects = [
            {
                id: "PRJ001",
                title: "Luxury Residential Complex",
                client: "Premium Developers Pvt Ltd",
                clientLogo: "https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=60&h=60&fit=crop",
                location: "Bandra West, Mumbai",
                value: "₹4.8 Cr",
                startDate: "2023-08-15",
                expectedCompletion: "2024-12-15",
                actualProgress: 68,
                status: "On Track",
                priority: "High",
                nextMilestone: "Interior Finishing Phase",
                milestoneDate: "2024-03-01",
                clientRating: 4.9,
                teamSize: 25,
                image: "https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=400&h=280&fit=crop",
                category: "Residential"
            },
            {
                id: "PRJ002",
                title: "Corporate Office Renovation",
                client: "TechCorp Solutions Ltd",
                clientLogo: "https://images.unsplash.com/photo-1549924231-f129b911e442?w=60&h=60&fit=crop",
                location: "Lower Parel, Mumbai",
                value: "₹1.2 Cr",
                startDate: "2024-01-10",
                expectedCompletion: "2024-07-10",
                actualProgress: 35,
                status: "On Track",
                priority: "Medium",
                nextMilestone: "Electrical Systems",
                milestoneDate: "2024-02-20",
                clientRating: 4.7,
                teamSize: 12,
                image: "https://images.unsplash.com/photo-1541888946425-d81bb19240f5?w=400&h=280&fit=crop",
                category: "Commercial"
            },
            {
                id: "PRJ003",
                title: "Heritage Building Restoration",
                client: "Mumbai Heritage Trust",
                clientLogo: "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=60&h=60&fit=crop",
                location: "Fort, Mumbai",
                value: "₹2.1 Cr",
                startDate: "2023-10-01",
                expectedCompletion: "2024-08-01",
                actualProgress: 45,
                status: "At Risk",
                priority: "High",
                nextMilestone: "Structural Reinforcement",
                milestoneDate: "2024-02-10",
                clientRating: 4.8,
                teamSize: 18,
                image: "https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400&h=280&fit=crop",
                category: "Restoration"
            }
        ];

        // Available projects for bidding
        const availableProjects = [
            {
                id: "BID001",
                title: "Luxury Villa Development",
                client: "Prestige Group",
                location: "Juhu, Mumbai",
                budget: "₹5.2 Cr - ₹6.8 Cr",
                timeline: "18 months",
                postedDate: "2024-01-22",
                deadline: "2024-02-05",
                clientRating: 4.9,
                bidsSubmitted: 12,
                description: "Premium 5BHK villa with modern amenities, pool, and landscaping",
                requirements: ["High-end Residential", "₹2Cr+ Portfolio", "Mumbai Location"],
                bidStatus: "active",
                matchScore: 95,
                category: "Residential",
                urgency: "High",
                image: "https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=400&h=250&fit=crop"
            },
            {
                id: "BID002",
                title: "IT Park Development",
                client: "Godrej Properties",
                location: "Vikhroli, Mumbai",
                budget: "₹15 Cr - ₹18 Cr",
                timeline: "24 months",
                postedDate: "2024-01-20",
                deadline: "2024-02-02",
                clientRating: 4.8,
                bidsSubmitted: 8,
                description: "Modern IT park with sustainable design and smart building features",
                requirements: ["Commercial Experience", "Green Building", "Large Scale"],
                bidStatus: "submitted",
                matchScore: 88,
                category: "Commercial",
                urgency: "Medium",
                image: "https://images.unsplash.com/photo-1541888946425-d81bb19240f5?w=400&h=250&fit=crop"
            },
            {
                id: "BID003",
                title: "Shopping Mall Renovation",
                client: "Phoenix Mills",
                location: "Kurla, Mumbai",
                budget: "₹8.5 Cr - ₹10 Cr",
                timeline: "14 months",
                postedDate: "2024-01-18",
                deadline: "2024-01-28",
                clientRating: 4.7,
                bidsSubmitted: 15,
                description: "Complete renovation of existing shopping complex with modern retail spaces",
                requirements: ["Retail Experience", "Quick Execution", "Operational Renovation"],
                bidStatus: "not_submitted",
                matchScore: 82,
                category: "Retail",
                urgency: "High",
                image: "https://images.unsplash.com/photo-1563013544-824ae1b704d3?w=400&h=250&fit=crop"
            }
        ];

        // Financial data
        const financialData = {
            totalEarnings: "₹3.2 Cr",
            pendingPayments: "₹65 Lakh",
            thisMonthEarnings: "₹28 Lakh",
            averageProjectValue: "₹1.8 Cr",
            profitMargin: 24.5,
            paymentHistory: [
                { date: "2024-01-25", amount: "₹18 Lakh", project: "Luxury Villa - Phase 3", status: "received", client: "Premium Developers" },
                { date: "2024-01-20", amount: "₹32 Lakh", project: "Office Complex - Final", status: "received", client: "TechCorp Solutions" },
                { date: "2024-01-15", amount: "₹12 Lakh", project: "Heritage Restoration", status: "pending", client: "Heritage Trust" },
                { date: "2024-01-10", amount: "₹25 Lakh", project: "Commercial Tower", status: "received", client: "Metro Builders" }
            ]
        };

        // Notifications
        const notifications = [
            {
                id: 1,
                type: "urgent",
                title: "Bid Deadline Approaching",
                message: "Luxury Villa Development bid deadline in 2 days",
                time: "1 hour ago",
                read: false,
                actionRequired: true,
                projectId: "BID001"
            },
            {
                id: 2,
                type: "success",
                title: "Payment Processed",
                message: "₹32 Lakh payment received from TechCorp Solutions",
                time: "3 hours ago",
                read: false,
                actionRequired: false,
                amount: "₹32 Lakh"
            },
            {
                id: 3,
                type: "info",
                title: "New Project Match",
                message: "Shopping Mall Renovation matches your expertise (82% match)",
                time: "5 hours ago",
                read: true,
                actionRequired: false,
                matchScore: 82
            },
            {
                id: 4,
                type: "warning",
                title: "Document Expiring",
                message: "Insurance certificate expires in 30 days",
                time: "1 day ago",
                read: true,
                actionRequired: true,
                expiryDays: 30
            }
        ];

        // Recent activity
        const recentActivity = [
            {
                type: "success",
                title: "Milestone Completed",
                description: "Interior phase finished for Luxury Complex",
                time: "2 hours ago",
                icon: "check-circle-2"
            },
            {
                type: "success",
                title: "Payment Received",
                description: "₹32 Lakh from TechCorp Solutions",
                time: "3 hours ago",
                icon: "dollar-sign"
            },
            {
                type: "warning",
                title: "New Bid Opportunity",
                description: "IT Park Development - 95% match",
                time: "5 hours ago",
                icon: "file-text"
            },
            {
                type: "info",
                title: "Team Update",
                description: "5 new team members added to projects",
                time: "1 day ago",
                icon: "users"
            }
        ];

        // Achievements
        const achievements = [
            {
                type: "amber",
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
                type: "emerald",
                icon: "heart",
                title: "Client Favorite",
                description: "95% Satisfaction"
            }
        ];

        // Main app initialization
        function initializeApp() {
            populateNotifications();
            populateRecentActivity();
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
            document.querySelectorAll('.tab-btn').forEach(link => {
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

            notifications.slice(0, 4).forEach(notification => {
                const div = document.createElement('div');
                div.className = `notification-item ${!notification.read ? 'unread' : ''}`;
                
                div.innerHTML = `
                    <div class="notification-content">
                        <div class="notification-dot ${notification.type}"></div>
                        <div class="notification-text">
                            <div class="notification-subject">${notification.title}</div>
                            <div class="notification-message">${notification.message}</div>
                            <div class="notification-time">${notification.time}</div>
                        </div>
                        ${notification.actionRequired ? '<span class="notification-action">Action</span>' : ''}
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
                
                const activityTypeClass = {
                    'success': 'bg-emerald',
                    'info': 'bg-blue',
                    'warning': 'bg-amber'
                };

                const activityTypeColor = {
                    'success': 'var(--emerald-600)',
                    'info': 'var(--blue-600)',
                    'warning': 'var(--amber-600)'
                };
                
                div.innerHTML = `
                    <div class="activity-icon ${activityTypeClass[activity.type]}">
                        <i data-lucide="${activity.icon}" style="width: 1rem; height: 1rem; color: ${activityTypeColor[activity.type]};"></i>
                    </div>
                    <div style="flex: 1;">
                        <p class="text-sm font-medium" style="margin-bottom: 0.25rem;">${activity.title}</p>
                        <p class="text-xs text-muted" style="margin-bottom: 0.25rem;">${activity.description}</p>
                        <p class="text-xs text-muted">${activity.time}</p>
                    </div>
                `;
                
                activityList.appendChild(div);
            });
        }

        function populateVerificationSteps() {
            const stepsList = document.getElementById('verificationSteps');
            stepsList.innerHTML = '';

            verificationSteps.forEach(step => {
                const div = document.createElement('div');
                div.className = 'verification-step';
                
                const stepIcon = step.status === 'completed' ? 
                    '<i data-lucide="check" style="width: 1.25rem; height: 1.25rem;"></i>' :
                    step.status === 'current' ? 
                    '<i data-lucide="clock" style="width: 1.25rem; height: 1.25rem;"></i>' :
                    step.step.toString();
                
                div.innerHTML = `
                    <div class="step-icon step-${step.status}">
                        ${stepIcon}
                    </div>
                    <div style="flex: 1;">
                        <h4 style="font-weight: 600; color: ${step.status === 'current' ? 'var(--blue-600)' : 'var(--foreground)'}; margin-bottom: 0.25rem;">
                            ${step.title}
                        </h4>
                        <p class="text-sm text-muted" style="margin-bottom: 0.25rem;">${step.description}</p>
                        <p class="text-xs text-muted">${step.date}</p>
                    </div>
                    ${step.status === 'current' ? '<span class="badge info">In Progress</span>' : ''}
                `;
                
                stepsList.appendChild(div);
            });
        }

        function populateActiveProjects() {
            const projectsList = document.getElementById('activeProjectsList');
            projectsList.innerHTML = '';

            activeProjects.forEach(project => {
                const col = document.createElement('div');
                col.className = 'project-card hover-lift';
                
                const statusClass = {
                    'On Track': 'status-on-track',
                    'At Risk': 'status-at-risk',
                    'Delayed': 'status-delayed'
                };

                const priorityClass = {
                    'High': 'priority-high',
                    'Medium': 'priority-medium',
                    'Low': 'priority-low'
                };
                
                col.innerHTML = `
                    <div class="project-image">
                        <img src="${project.image}" alt="${project.title}" loading="lazy">
                        <div class="project-badges">
                            <span class="badge ${statusClass[project.status]}">${project.status}</span>
                            <span class="badge ${priorityClass[project.priority]} outline">${project.priority}</span>
                        </div>
                        <div class="project-progress-overlay">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium">Progress</span>
                                <span class="text-sm font-bold">${project.actualProgress}%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill emerald" style="width: ${project.actualProgress}%;"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="project-details">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h4 style="font-weight: 700; font-size: 1.125rem; margin-bottom: 0.25rem;">${project.title}</h4>
                                <span class="badge outline text-xs">${project.category}</span>
                            </div>
                            <button class="btn btn-outline btn-sm" style="width: 2rem; height: 2rem; padding: 0;">
                                <i data-lucide="more-vertical" style="width: 1rem; height: 1rem;"></i>
                            </button>
                        </div>

                        <div class="space-y-2 mb-4">
                            <div class="project-meta">
                                <img src="${project.clientLogo}" alt="${project.client}" style="width: 1.25rem; height: 1.25rem; border-radius: 50%; object-fit: cover;">
                                <span>${project.client}</span>
                            </div>
                            <div class="project-meta">
                                <i data-lucide="map-pin" style="width: 1rem; height: 1rem; color: var(--orange-500);"></i>
                                <span>${project.location}</span>
                            </div>
                            <div class="project-meta">
                                <i data-lucide="dollar-sign" style="width: 1rem; height: 1rem; color: var(--emerald-500);"></i>
                                <span class="font-medium">${project.value}</span>
                            </div>
                            <div class="project-meta">
                                <i data-lucide="users" style="width: 1rem; height: 1rem; color: var(--blue-500);"></i>
                                <span>${project.teamSize} team members</span>
                            </div>
                        </div>

                        <div style="border-top: 1px solid var(--border); padding-top: 1rem; margin-bottom: 1rem;">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-muted">Next Milestone</span>
                                <span class="text-sm font-medium">${project.nextMilestone}</span>
                            </div>
                            <div class="project-meta">
                                <i data-lucide="calendar" style="width: 1rem; height: 1rem;"></i>
                                <span>Due: ${new Date(project.milestoneDate).toLocaleDateString()}</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-2">
                            <div class="flex items-center gap-2">
                                <i data-lucide="star" style="width: 1rem; height: 1rem; color: var(--amber-500); fill: var(--amber-500);"></i>
                                <span class="text-sm font-medium">${project.clientRating}</span>
                            </div>
                            <button class="btn btn-primary btn-sm">
                                <i data-lucide="eye" style="width: 1rem; height: 1rem; margin-right: 0.5rem;"></i>
                                View Details
                            </button>
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
                col.className = 'project-card hover-lift';
                
                const bidStatusClass = {
                    'submitted': 'success',
                    'active': 'info',
                    'not_submitted': 'secondary'
                };

                const bidStatusText = {
                    'submitted': 'Bid Submitted',
                    'active': 'Open for Bids',
                    'not_submitted': 'Available'
                };

                const matchScoreClass = project.matchScore >= 90 ? 'text-emerald bg-emerald' : 
                                      project.matchScore >= 80 ? 'text-blue bg-blue' : 
                                      'text-amber bg-amber';
                
                col.innerHTML = `
                    <div style="height: 10rem; overflow: hidden; position: relative;">
                        <img src="${project.image}" alt="${project.title}" style="width: 100%; height: 100%; object-fit: cover;">
                        <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.6), transparent);"></div>
                        
                        <div style="position: absolute; top: 0.75rem; right: 0.75rem; display: flex; gap: 0.5rem;">
                            <span class="badge ${bidStatusClass[project.bidStatus]} text-xs">${bidStatusText[project.bidStatus]}</span>
                            ${project.urgency === 'High' ? '<span class="badge danger text-xs">Urgent</span>' : ''}
                        </div>

                        <div style="position: absolute; top: 0.75rem; left: 0.75rem;">
                            <span class="badge ${matchScoreClass} text-xs">${project.matchScore}% Match</span>
                        </div>
                        
                        <div style="position: absolute; bottom: 0.75rem; left: 0.75rem; right: 0.75rem;">
                            <h4 style="color: white; font-weight: 600; font-size: 0.875rem;">${project.title}</h4>
                        </div>
                    </div>
                    
                    <div style="padding: 1rem;">
                        <div class="flex items-center justify-between mb-3">
                            <span class="badge outline text-xs">${project.category}</span>
                            <div class="text-xs text-muted flex items-center gap-1">
                                <i data-lucide="clock" style="width: 0.75rem; height: 0.75rem;"></i>
                                <span>Due: ${new Date(project.deadline).toLocaleDateString()}</span>
                            </div>
                        </div>

                        <div class="space-y-2 mb-3">
                            <div class="project-meta">
                                <i data-lucide="building" style="width: 0.75rem; height: 0.75rem; color: var(--blue-500);"></i>
                                <span class="text-xs">${project.client}</span>
                            </div>
                            <div class="project-meta">
                                <i data-lucide="map-pin" style="width: 0.75rem; height: 0.75rem; color: var(--orange-500);"></i>
                                <span class="text-xs">${project.location}</span>
                            </div>
                            <div class="project-meta">
                                <i data-lucide="dollar-sign" style="width: 0.75rem; height: 0.75rem; color: var(--emerald-500);"></i>
                                <span class="text-xs font-medium">${project.budget}</span>
                            </div>
                            <div class="project-meta">
                                <i data-lucide="timer" style="width: 0.75rem; height: 0.75rem; color: var(--purple-500);"></i>
                                <span class="text-xs">${project.timeline}</span>
                            </div>
                        </div>

                        <p class="text-xs text-muted mb-3" style="line-height: 1.4;">${project.description}</p>

                        <div class="mb-3">
                            <p class="text-xs font-medium mb-2">Requirements:</p>
                            <div class="flex flex-wrap gap-1">
                                ${project.requirements.slice(0, 2).map(req => `<span class="badge secondary text-xs">${req}</span>`).join('')}
                                ${project.requirements.length > 2 ? `<span class="badge secondary text-xs">+${project.requirements.length - 2}</span>` : ''}
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-2 mb-3" style="border-top: 1px solid var(--border); font-size: 0.75rem;">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center gap-1">
                                    <i data-lucide="users" style="width: 0.75rem; height: 0.75rem;"></i>
                                    <span>${project.bidsSubmitted} bids</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <i data-lucide="star" style="width: 0.75rem; height: 0.75rem; color: var(--amber-500); fill: var(--amber-500);"></i>
                                    <span>${project.clientRating}</span>
                                </div>
                            </div>
                        </div>

                        <button class="btn ${project.bidStatus === 'submitted' ? 'btn-secondary' : 'btn-primary'} btn-sm" style="width: 100%;" ${project.bidStatus === 'submitted' ? 'disabled' : ''}>
                            <i data-lucide="${project.bidStatus === 'submitted' ? 'check-circle-2' : 'send'}" style="width: 0.75rem; height: 0.75rem; margin-right: 0.5rem;"></i>
                            ${project.bidStatus === 'submitted' ? 'Bid Submitted' : 'Submit Bid'}
                        </button>
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
                div.className = 'activity-item';
                
                const statusClass = payment.status === 'received' ? 'bg-emerald' : 'bg-amber';
                const statusColor = payment.status === 'received' ? 'var(--emerald-600)' : 'var(--amber-600)';
                const statusIcon = payment.status === 'received' ? 'check-circle-2' : 'clock';
                
                div.innerHTML = `
                    <div class="activity-icon ${statusClass}">
                        <i data-lucide="${statusIcon}" style="width: 1rem; height: 1rem; color: ${statusColor};"></i>
                    </div>
                    <div style="flex: 1; min-width: 0;">
                        <p class="text-sm font-medium" style="margin-bottom: 0.25rem;">${payment.amount}</p>
                        <p class="text-xs text-muted" style="margin-bottom: 0.25rem;">${payment.project}</p>
                        <p class="text-xs text-muted" style="margin-bottom: 0.25rem;">${payment.client}</p>
                        <p class="text-xs text-muted">${payment.date}</p>
                    </div>
                    <span class="badge ${payment.status === 'received' ? 'success' : 'warning'} text-xs">
                        ${payment.status === 'received' ? 'Received' : 'Pending'}
                    </span>
                `;
                
                paymentList.appendChild(div);
            });
        }

        function populateAchievements() {
            const achievementsList = document.getElementById('achievementsList');
            achievementsList.innerHTML = '';

            achievements.forEach(achievement => {
                const div = document.createElement('div');
                div.className = `flex items-center gap-3 p-3 bg-${achievement.type}`;
                div.style.borderRadius = '0.5rem';
                
                const iconColor = {
                    'amber': 'var(--amber-600)',
                    'blue': 'var(--blue-600)',
                    'emerald': 'var(--emerald-600)'
                };
                
                div.innerHTML = `
                    <i data-lucide="${achievement.icon}" style="width: 1.5rem; height: 1.5rem; color: ${iconColor[achievement.type]};"></i>
                    <div>
                        <p class="text-sm font-medium" style="margin-bottom: 0.125rem;">${achievement.title}</p>
                        <p class="text-xs text-muted">${achievement.description}</p>
                    </div>
                `;
                
                achievementsList.appendChild(div);
            });
        }

        // Event listeners
        function initializeEventListeners() {
            // Notification button
            document.getElementById('notificationBtn').addEventListener('click', function(e) {
                e.stopPropagation();
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

        function handleLogout() {
            if (confirm('Are you sure you want to logout?')) {
                // Here you would typically handle the logout process
                alert('Logging out...');
                // Redirect to login page
                // window.location.href = '/login';
            }
        }

        function handleSearch(query) {
            if (query.length > 0) {
                console.log(`Searching for: ${query}`);
                // Here you would implement search functionality
            }
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
        });
    </script>
@endsection