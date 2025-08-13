<!DOCTYPE html>
<html lang="en">
 <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- <meta name="csrf-token" content="{{ csrf_token() }}"> -->

      <title>CONSTRUCTKARO - Dashboard</title>
      <!-- Bootstrap 5 CSS -->
      <script src="https://cdn.tailwindcss.com"></script>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
      <!-- Lucide Icons -->
      <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
      <!-- Custom CSS -->
      <!-- <link rel="stylesheet" href="styles.css"> -->
       <link href="{{ asset('styles.css') }}" rel="stylesheet">

      <style>
         /* Custom CSS Variables */
         :root {
         --orange-500: #f97316;
         --orange-600: #ea580c;
         --orange-400: #fb923c;
         --slate-50: #f8fafc;
         --slate-100: #f1f5f9;
         --slate-600: #475569;
         --slate-700: #334155;
         --slate-800: #1e293b;
         --slate-900: #0f172a;
         --blue-50: #eff6ff;
         --blue-500: #3b82f6;
         --blue-600: #2563eb;
         --green-500: #22c55e;
         --green-600: #16a34a;
         --purple-500: #8b5cf6;
         --purple-600: #7c3aed;
         --yellow-500: #eab308;
         --yellow-600: #ca8a04;
         --red-500: #ef4444;
         --red-600: #dc2626;
         }
         /* Global Styles */
         body {
         background: linear-gradient(135deg, var(--slate-50) 0%, var(--blue-50) 50%, var(--slate-100) 100%);
         min-height: 100vh;
         padding-top: 80px;
         font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
         position: relative;
         overflow-x: hidden;
         }
         /* Animated Background Elements */
         .background-elements {
         position: fixed;
         top: 0;
         left: 0;
         width: 100%;
         height: 100%;
         pointer-events: none;
         z-index: -1;
         overflow: hidden;
         }
         .bg-element {
         position: absolute;
         border-radius: 50%;
         filter: blur(100px);
         animation: pulse 4s ease-in-out infinite;
         }
         .bg-element-1 {
         top: -10rem;
         right: -10rem;
         width: 20rem;
         height: 20rem;
         background: rgba(249, 115, 22, 0.1);
         animation-delay: 0s;
         }
         .bg-element-2 {
         bottom: -15rem;
         left: -15rem;
         width: 24rem;
         height: 24rem;
         background: rgba(59, 130, 246, 0.1);
         animation-delay: 2s;
         }
         .floating-shape {
         position: absolute;
         border-radius: 50%;
         animation: bounce 3s ease-in-out infinite;
         }
         .floating-shape-1 {
         top: 25%;
         left: 33%;
         width: 1.5rem;
         height: 1.5rem;
         background: rgba(249, 115, 22, 0.2);
         animation-delay: 0.8s;
         }
         .floating-shape-2 {
         bottom: 25%;
         right: 33%;
         width: 1rem;
         height: 1rem;
         background: rgba(59, 130, 246, 0.2);
         transform: rotate(45deg);
         border-radius: 0;
         animation-delay: 1.7s;
         }
         @keyframes pulse {
         0%, 100% { opacity: 0.3; transform: scale(1); }
         50% { opacity: 0.5; transform: scale(1.1); }
         }
         @keyframes bounce {
         0%, 100% { transform: translateY(0); }
         50% { transform: translateY(-20px); }
         }
         /* Header Styles */
         /* .custom-header {
         background: rgba(255, 255, 255, 0.8);
         backdrop-filter: blur(20px);
         border-bottom: 1px solid rgba(255, 255, 255, 0.5);
         box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
         position: relative;
         z-index: 10;
         height: 80px;
         } */

         .custom-header {
            position: fixed !important;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1050;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

         .brand-icon {
         width: 3rem;
         height: 3rem;
         background: linear-gradient(135deg, var(--orange-500), var(--orange-600));
         border-radius: 0.75rem;
         display: flex;
         align-items: center;
         justify-content: center;
         margin-right: 0.75rem;
         box-shadow: 0 10px 20px rgba(249, 115, 22, 0.3);
         }
         .brand-icon i {
         color: white;
         width: 1.75rem;
         height: 1.75rem;
         }
         .brand-text {
         font-size: 1.5rem;
         font-weight: 700;
         color: var(--slate-900);
         }
         .text-orange {
         color: var(--orange-500);
         }
         .search-container {
         max-width: 32rem;
         }
         .search-input {
         height: 3rem;
         padding-left: 3rem;
         background: rgba(255, 255, 255, 0.6);
         backdrop-filter: blur(10px);
         border: 1px solid rgba(148, 163, 184, 0.2);
         border-radius: 0.75rem;
         transition: all 0.3s ease;
         }
         .search-input:focus {
         border-color: var(--orange-400);
         box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
         background: rgba(255, 255, 255, 0.8);
         }
         .search-icon {
         position: absolute;
         left: 1rem;
         top: 50%;
         transform: translateY(-50%);
         color: var(--slate-600);
         width: 1.25rem;
         height: 1.25rem;
         }
         .nav-link {
         color: var(--slate-700) !important;
         font-weight: 500;
         padding: 0.5rem 0.75rem !important;
         margin: 0 0.25rem;
         border-radius: 0.5rem;
         transition: all 0.3s ease;
         }
         .nav-link:hover {
         color: var(--orange-500) !important;
         background: rgba(249, 115, 22, 0.1);
         transform: scale(1.05);
         }
         .btn-primary {
         background: linear-gradient(135deg, var(--orange-500), var(--orange-600));
         border: none;
         border-radius: 0.75rem;
         font-weight: 600;
         padding: 0.75rem 1.5rem;
         box-shadow: 0 10px 20px rgba(249, 115, 22, 0.3);
         transition: all 0.3s ease;
         }
         .btn-primary:hover {
         background: linear-gradient(135deg, var(--orange-600), var(--orange-600));
         transform: translateY(-2px);
         box-shadow: 0 15px 30px rgba(249, 115, 22, 0.4);
         }
         /* Hero Section */
         .hero-section {
         position: relative;
         z-index: 5;
         padding: 4rem 0;
         }
         .hero-title {
         font-size: 3.5rem;
         font-weight: 700;
         color: var(--slate-900);
         line-height: 1.2;
         margin-bottom: 1.5rem;
         }
         .text-gradient {
         background: linear-gradient(135deg, var(--orange-500), var(--orange-600));
         -webkit-background-clip: text;
         -webkit-text-fill-color: transparent;
         background-clip: text;
         }
         .hero-subtitle {
         font-size: 1.25rem;
         color: var(--slate-600);
         max-width: 48rem;
         margin: 0 auto 3rem;
         line-height: 1.6;
         }
         @media (max-width: 768px) {
         .hero-title {
         font-size: 2.5rem;
         }
         .hero-subtitle {
         font-size: 1.1rem;
         }
         }
         /* Stats Cards */
         .stats-card {
         background: rgba(255, 255, 255, 0.7);
         backdrop-filter: blur(20px);
         border: 1px solid rgba(255, 255, 255, 0.5);
         box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
         border-radius: 1rem;
         transition: all 0.3s ease;
         overflow: hidden;
         }
         .stats-card:hover {
         transform: translateY(-10px) scale(1.05);
         box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
         }
         .stat-icon {
         width: 3rem;
         height: 3rem;
         border-radius: 0.75rem;
         display: flex;
         align-items: center;
         justify-content: center;
         margin: 0 auto 1rem;
         }
         .stat-icon-blue {
         background: rgba(59, 130, 246, 0.1);
         }
         .stat-icon-blue i {
         color: var(--blue-600);
         width: 1.5rem;
         height: 1.5rem;
         }
         .stat-icon-green {
         background: rgba(34, 197, 94, 0.1);
         }
         .stat-icon-green i {
         color: var(--green-600);
         width: 1.5rem;
         height: 1.5rem;
         }
         .stat-icon-orange {
         background: rgba(249, 115, 22, 0.1);
         }
         .stat-icon-orange i {
         color: var(--orange-600);
         width: 1.5rem;
         height: 1.5rem;
         }
         .stat-icon-purple {
         background: rgba(139, 92, 246, 0.1);
         }
         .stat-icon-purple i {
         color: var(--purple-600);
         width: 1.5rem;
         height: 1.5rem;
         }
         .stat-value {
         font-size: 1.5rem;
         font-weight: 700;
         color: var(--slate-900);
         margin-bottom: 0.5rem;
         }
         .stat-label {
         font-size: 0.875rem;
         color: var(--slate-600);
         margin-bottom: 0.5rem;
         }
         .badge-success {
         background: rgba(34, 197, 94, 0.1);
         color: var(--green-600);
         border: none;
         }
         /* Content Section */
         .content-section {
         position: relative;
         z-index: 5;
         padding: 4rem 0;
         }
         /* Custom Tabs */
         .custom-tabs {
         display: inline-flex;
         background: rgba(255, 255, 255, 0.7);
         backdrop-filter: blur(20px);
         border: 1px solid rgba(255, 255, 255, 0.5);
         border-radius: 1rem;
         padding: 0.25rem;
         box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
         }
         .tab-btn {
         background: none;
         border: none;
         padding: 0.75rem 1.5rem;
         border-radius: 0.75rem;
         font-weight: 600;
         color: var(--slate-700);
         transition: all 0.3s ease;
         cursor: pointer;
         }
         .tab-btn.active {
         background: linear-gradient(135deg, var(--orange-500), var(--orange-600));
         color: white;
         box-shadow: 0 10px 20px rgba(249, 115, 22, 0.3);
         }
         .tab-btn:hover:not(.active) {
         background: rgba(249, 115, 22, 0.1);
         color: var(--orange-600);
         }
         /* Tab Content */
         .tab-content {
         display: none;
         }
         .tab-content.active {
         display: block;
         animation: fadeInUp 0.5s ease;
         }
         @keyframes fadeInUp {
         from {
         opacity: 0;
         transform: translateY(20px);
         }
         to {
         opacity: 1;
         transform: translateY(0);
         }
         }
         .section-title {
         font-size: 2rem;
         font-weight: 700;
         color: var(--slate-900);
         margin-bottom: 1rem;
         }
         .section-subtitle {
         font-size: 1.125rem;
         color: var(--slate-600);
         max-width: 32rem;
         margin: 0 auto;
         }
         /* Service Cards */
         .service-card {
         background: rgba(255, 255, 255, 0.7);
         backdrop-filter: blur(20px);
         border: 1px solid rgba(255, 255, 255, 0.5);
         box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
         border-radius: 1rem;
         transition: all 0.5s ease;
         cursor: pointer;
         overflow: hidden;
         height: 100%;
         }
         .service-card:hover {
         transform: translateY(-10px) scale(1.05);
         box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
         }
         .service-icon {
         width: 4rem;
         height: 4rem;
         border-radius: 1rem;
         display: flex;
         align-items: center;
         justify-content: center;
         margin-bottom: 1.5rem;
         box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
         transition: transform 0.3s ease;
         }
         .service-card:hover .service-icon {
         transform: scale(1.1);
         }
         .service-icon i {
         color: white;
         width: 2rem;
         height: 2rem;
         }
         .service-title {
         font-size: 1.25rem;
         font-weight: 700;
         color: var(--slate-900);
         margin-bottom: 0.75rem;
         transition: color 0.3s ease;
         }
         .service-card:hover .service-title {
         color: var(--orange-600);
         }
         .service-count {
         color: var(--slate-600);
         margin-bottom: 0.75rem;
         }
         .service-badge {
         border: none;
         margin-bottom: 1.5rem;
         }
         .service-btn {
         background: none;
         border: none;
         color: var(--orange-600);
         font-weight: 600;
         width: 100%;
         display: flex;
         justify-content: space-between;
         align-items: center;
         padding: 0.75rem 0;
         transition: all 0.3s ease;
         }
         .service-btn:hover {
         color: var(--orange-700);
         background: rgba(249, 115, 22, 0.1);
         border-radius: 0.5rem;
         transform: translateX(5px);
         }
         /* Project Cards */
         .project-card {
         background: rgba(255, 255, 255, 0.7);
         backdrop-filter: blur(20px);
         border: 1px solid rgba(255, 255, 255, 0.5);
         box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
         border-radius: 1rem;
         transition: all 0.5s ease;
         overflow: hidden;
         height: 100%;
         }
         .project-card:hover {
         transform: translateY(-10px) scale(1.05);
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
         transition: transform 0.5s ease;
         }
         .project-card:hover .project-image img {
         transform: scale(1.1);
         }
         .project-status {
         position: absolute;
         top: 1rem;
         right: 1rem;
         border: none;
         box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
         }
         .project-title {
         font-size: 1.25rem;
         font-weight: 700;
         color: var(--slate-900);
         margin-bottom: 1rem;
         }
         .project-details {
         margin-bottom: 1rem;
         }
         .project-detail {
         display: flex;
         align-items: center;
         margin-bottom: 0.5rem;
         font-size: 0.875rem;
         color: var(--slate-600);
         }
         .project-detail i {
         width: 1rem;
         height: 1rem;
         margin-right: 0.5rem;
         }
         .progress-container {
         margin-bottom: 1rem;
         }
         .progress-header {
         display: flex;
         justify-content: space-between;
         margin-bottom: 0.5rem;
         font-size: 0.875rem;
         }
         .progress-header span:first-child {
         color: var(--slate-600);
         }
         .progress-header span:last-child {
         font-weight: 600;
         }
         .progress {
         height: 0.5rem;
         background: var(--slate-200);
         border-radius: 0.25rem;
         overflow: hidden;
         }
         .progress-bar {
         background: linear-gradient(135deg, var(--orange-500), var(--orange-600));
         height: 100%;
         transition: width 0.3s ease;
         }
         .project-btn {
         background: none;
         border: none;
         color: var(--orange-600);
         font-weight: 600;
         width: 100%;
         display: flex;
         justify-content: space-between;
         align-items: center;
         padding: 0.75rem 0;
         transition: all 0.3s ease;
         }
         .project-btn:hover {
         color: var(--orange-700);
         background: rgba(249, 115, 22, 0.1);
         border-radius: 0.5rem;
         }
         /* Call to Action Section */
         .cta-section {
         position: relative;
         z-index: 5;
         padding: 4rem 0;
         }
         .cta-card {
         background: linear-gradient(135deg, var(--slate-800), var(--slate-900), var(--slate-800));
         border: none;
         box-shadow: 0 30px 60px rgba(0, 0, 0, 0.2);
         border-radius: 1.5rem;
         overflow: hidden;
         }
         .cta-pattern {
         position: absolute;
         top: 0;
         left: 0;
         right: 0;
         bottom: 0;
         background-image: 
         linear-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px),
         linear-gradient(90deg, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
         background-size: 30px 30px;
         }
         .cta-title {
         font-size: 2.5rem;
         font-weight: 700;
         margin-bottom: 1rem;
         }
         .cta-subtitle {
         font-size: 1.25rem;
         opacity: 0.8;
         max-width: 32rem;
         margin: 0 auto 2rem;
         }
         .cta-btn-primary {
         background: linear-gradient(135deg, var(--orange-500), var(--orange-600));
         border: none;
         padding: 1rem 2rem;
         font-weight: 600;
         border-radius: 0.75rem;
         transition: all 0.3s ease;
         }
         .cta-btn-primary:hover {
         background: linear-gradient(135deg, var(--orange-600), var(--orange-600));
         transform: translateY(-2px) scale(1.05);
         box-shadow: 0 20px 40px rgba(249, 115, 22, 0.3);
         }
         .cta-btn-secondary {
         border: 2px solid rgba(255, 255, 255, 0.3);
         padding: 1rem 2rem;
         font-weight: 600;
         border-radius: 0.75rem;
         transition: all 0.3s ease;
         }
         .cta-btn-secondary:hover {
         background: rgba(255, 255, 255, 0.1);
         border-color: rgba(255, 255, 255, 0.5);
         transform: translateY(-2px) scale(1.05);
         }
         @media (max-width: 576px) {
         .cta-title {
         font-size: 2rem;
         }
         .cta-subtitle {
         font-size: 1.1rem;
         }
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
         /* Responsive Design */
         @media (max-width: 1200px) {
         .hero-title {
         font-size: 3rem;
         }
         }
         @media (max-width: 992px) {
         .hero-title {
         font-size: 2.5rem;
         }
         .search-container {
         display: none !important;
         }
         }
         @media (max-width: 768px) {
         .hero-section, .content-section, .cta-section {
         padding: 2rem 0;
         }
         .custom-header {
         height: auto;
         padding: 1rem 0;
         }
         .brand-text {
         font-size: 1.25rem;
         }
         .service-card, .project-card {
         margin-bottom: 1rem;
         }
         }
         /* Loading and Animation States */
         .fade-in {
         animation: fadeIn 0.6s ease-in-out;
         }
         @keyframes fadeIn {
         from { opacity: 0; }
         to { opacity: 1; }
         }
         .slide-up {
         animation: slideUp 0.6s ease-out;
         }
         @keyframes slideUp {
         from {
         transform: translateY(30px);
         opacity: 0;
         }
         to {
         transform: translateY(0);
         opacity: 1;
         }
         }

         
      </style>
   </head>
 <body>
      <!-- Animated Background Elements -->
        <div class="background-elements">
            <div class="bg-element bg-element-1"></div>
            <div class="bg-element bg-element-2"></div>
            <div class="floating-shape floating-shape-1"></div>
            <div class="floating-shape floating-shape-2"></div>
        </div>

    @include('partials.header')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')
    
   </body>
</html>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
      <!-- Custom JavaScript -->
      <script>
         // Initialize Lucide icons
         document.addEventListener('DOMContentLoaded', function() {
         lucide.createIcons();
         
         // Initialize the application
         initializeApp();
         });
         
         // Main app initialization
         function initializeApp() {
         initializeTabs();
         populateServices();
         populateProjects();
         initializeSearch();
         initializeAnimations();
         initializeInteractions();
         }
         
         // Tab functionality
         function initializeTabs() {
         const tabButtons = document.querySelectorAll('.tab-btn');
         const tabContents = document.querySelectorAll('.tab-content');
         
         tabButtons.forEach(button => {
             button.addEventListener('click', () => {
                 const targetTab = button.getAttribute('data-tab');
                 
                 // Remove active class from all buttons and contents
                 tabButtons.forEach(btn => btn.classList.remove('active'));
                 tabContents.forEach(content => content.classList.remove('active'));
                 
                 // Add active class to clicked button and corresponding content
                 button.classList.add('active');
                 document.getElementById(targetTab + '-content').classList.add('active');
             });
         });
         }
         
         // Services data and population
         function populateServices() {
         const services = [
             {
                 icon: 'building-2',
                 title: 'Architecture & Design',
                 count: '250+ Professionals',
                 color: 'linear-gradient(135deg, #3b82f6, #2563eb)',
                 bgColor: '#eff6ff',
                 textColor: '#2563eb'
             },
             {
                 icon: 'hammer',
                 title: 'Construction',
                 count: '180+ Contractors',
                 color: 'linear-gradient(135deg, #f97316, #ea580c)',
                 bgColor: '#fff7ed',
                 textColor: '#ea580c'
             },
             {
                 icon: 'wrench',
                 title: 'Renovation',
                 count: '320+ Experts',
                 color: 'linear-gradient(135deg, #22c55e, #16a34a)',
                 bgColor: '#f0fdf4',
                 textColor: '#16a34a'
             },
             {
                 icon: 'paint-bucket',
                 title: 'Interior Design',
                 count: '140+ Designers',
                 color: 'linear-gradient(135deg, #8b5cf6, #7c3aed)',
                 bgColor: '#faf5ff',
                 textColor: '#7c3aed'
             },
             {
                 icon: 'zap',
                 title: 'Electrical',
                 count: '90+ Electricians',
                 color: 'linear-gradient(135deg, #eab308, #ca8a04)',
                 bgColor: '#fefce8',
                 textColor: '#ca8a04'
             },
             {
                 icon: 'shield',
                 title: 'Security Systems',
                 count: '60+ Specialists',
                 color: 'linear-gradient(135deg, #ef4444, #dc2626)',
                 bgColor: '#fef2f2',
                 textColor: '#dc2626'
             }
         ];
         
         const servicesGrid = document.getElementById('servicesGrid');
         servicesGrid.innerHTML = '';
         
         services.forEach((service, index) => {
             const serviceCard = createServiceCard(service, index);
             servicesGrid.appendChild(serviceCard);
         });
         
         // Re-initialize Lucide icons for dynamically created content
         lucide.createIcons();
         }
         
         function createServiceCard(service, index) {
         const col = document.createElement('div');
         col.className = 'col-md-6 col-lg-4';
         
         col.innerHTML = `
             <div class="card service-card slide-up" style="animation-delay: ${index * 0.1}s">
                 <div class="card-body p-4">
                     <div class="service-icon" style="background: ${service.color}">
                         <i data-lucide="${service.icon}"></i>
                     </div>
                     <div class="service-content">
                         <h4 class="service-title">${service.title}</h4>
                         <p class="service-count">${service.count}</p>
                         <span class="badge service-badge" style="background-color: ${service.bgColor}; color: ${service.textColor}">
                             Available Now
                         </span>
                         <button class="service-btn">
                             <span>Explore Professionals</span>
                             <i data-lucide="arrow-right"></i>
                         </button>
                     </div>
                 </div>
             </div>
         `;
         
         return col;
         }
         
         // Projects data and population
         function populateProjects() {
         const projects = [
             {
                 title: 'Modern Villa Construction',
                 location: 'Mumbai, Maharashtra',
                 budget: '₹2.5 Cr',
                 timeline: '12 months',
                 image: 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=400&h=250&fit=crop',
                 status: 'In Progress',
                 statusClass: 'bg-primary',
                 completion: 65
             },
             {
                 title: 'Office Complex Renovation',
                 location: 'Delhi, NCR',
                 budget: '₹1.8 Cr',
                 timeline: '8 months',
                 image: 'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?w=400&h=250&fit=crop',
                 status: 'Planning',
                 statusClass: 'bg-warning',
                 completion: 20
             },
             {
                 title: 'Residential Township',
                 location: 'Bangalore, Karnataka',
                 budget: '₹15 Cr',
                 timeline: '24 months',
                 image: 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=400&h=250&fit=crop',
                 status: 'Completed',
                 statusClass: 'bg-success',
                 completion: 100
             }
         ];
         
         const projectsGrid = document.getElementById('projectsGrid');
         projectsGrid.innerHTML = '';
         
         projects.forEach((project, index) => {
             const projectCard = createProjectCard(project, index);
             projectsGrid.appendChild(projectCard);
         });
         
         // Re-initialize Lucide icons for dynamically created content
         lucide.createIcons();
         }
         
         function createProjectCard(project, index) {
         const col = document.createElement('div');
         col.className = 'col-lg-4';
         
         const progressSection = project.status === 'In Progress' ? `
             <div class="progress-container">
                 <div class="progress-header">
                     <span>Progress</span>
                     <span>${project.completion}%</span>
                 </div>
                 <div class="progress">
                     <div class="progress-bar" style="width: ${project.completion}%"></div>
                 </div>
             </div>
         ` : '';
         
         col.innerHTML = `
             <div class="card project-card slide-up" style="animation-delay: ${index * 0.1}s">
                 <div class="project-image">
                     <img src="${project.image}" alt="${project.title}" loading="lazy">
                     <span class="badge project-status ${project.statusClass}">${project.status}</span>
                 </div>
                 <div class="card-body">
                     <h4 class="project-title">${project.title}</h4>
                     <div class="project-details">
                         <div class="project-detail">
                             <i data-lucide="map-pin"></i>
                             <span>${project.location}</span>
                         </div>
                         <div class="project-detail">
                             <i data-lucide="dollar-sign"></i>
                             <span>${project.budget}</span>
                         </div>
                         <div class="project-detail">
                             <i data-lucide="calendar"></i>
                             <span>${project.timeline}</span>
                         </div>
                     </div>
                     ${progressSection}
                     <button class="project-btn">
                         <span>View Details</span>
                         <i data-lucide="arrow-right"></i>
                     </button>
                 </div>
             </div>
         `;
         
         return col;
         }
         
         // Search functionality
         function initializeSearch() {
         const searchInput = document.getElementById('searchInput');
         
         if (searchInput) {
             searchInput.addEventListener('input', function(e) {
                 const searchTerm = e.target.value.toLowerCase();
                 // Add search functionality here if needed
                 console.log('Searching for:', searchTerm);
             });
         }
         }
         
         // Animation utilities
         function initializeAnimations() {
         // Intersection Observer for scroll animations
         const observerOptions = {
             threshold: 0.1,
             rootMargin: '0px 0px -50px 0px'
         };
         
         const observer = new IntersectionObserver((entries) => {
             entries.forEach(entry => {
                 if (entry.isIntersecting) {
                     entry.target.classList.add('fade-in');
                 }
             });
         }, observerOptions);
         
         // Observe all cards and sections
         document.querySelectorAll('.stats-card, .service-card, .project-card').forEach(el => {
             observer.observe(el);
         });
         }
         
         // Interactive elements
         function initializeInteractions() {
         // Add click handlers for service cards
         document.addEventListener('click', function(e) {
             if (e.target.closest('.service-btn')) {
                 e.preventDefault();
                 const serviceCard = e.target.closest('.service-card');
                 const serviceTitle = serviceCard.querySelector('.service-title').textContent;
                 showToast(`Exploring ${serviceTitle} professionals...`);
             }
             
             if (e.target.closest('.project-btn')) {
                 e.preventDefault();
                 const projectCard = e.target.closest('.project-card');
                 const projectTitle = projectCard.querySelector('.project-title').textContent;
                 showToast(`Opening ${projectTitle} details...`);
             }
             
             if (e.target.closest('.cta-btn-primary')) {
                 e.preventDefault();
                 showToast('Redirecting to project creation...');
             }
             
             if (e.target.closest('.cta-btn-secondary')) {
                 e.preventDefault();
                 showToast('Loading more information...');
             }
         });
         
         // Add hover effects to cards
         document.addEventListener('mouseenter', function(e) {
             if (e.target.closest('.stats-card, .service-card, .project-card')) {
                 e.target.closest('.card').style.transform = 'translateY(-10px) scale(1.05)';
             }
         }, true);
         
         document.addEventListener('mouseleave', function(e) {
             if (e.target.closest('.stats-card, .service-card, .project-card')) {
                 e.target.closest('.card').style.transform = '';
             }
         }, true);
         }
         
         // Toast notification system
         function showToast(message) {
         // Remove existing toast
         const existingToast = document.querySelector('.toast-notification');
         if (existingToast) {
             existingToast.remove();
         }
         
         // Create new toast
         const toast = document.createElement('div');
         toast.className = 'toast-notification';
         toast.style.cssText = `
             position: fixed;
             top: 20px;
             right: 20px;
             background: linear-gradient(135deg, #f97316, #ea580c);
             color: white;
             padding: 1rem 1.5rem;
             border-radius: 0.75rem;
             box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
             z-index: 1000;
             animation: slideInRight 0.3s ease-out;
             font-weight: 600;
         `;
         
         toast.textContent = message;
         document.body.appendChild(toast);
         
         // Add slide-in animation
         const style = document.createElement('style');
         style.textContent = `
             @keyframes slideInRight {
                 from {
                     transform: translateX(100%);
                     opacity: 0;
                 }
                 to {
                     transform: translateX(0);
                     opacity: 1;
                 }
             }
         `;
         document.head.appendChild(style);
         
         // Remove toast after 3 seconds
         setTimeout(() => {
             toast.style.animation = 'slideOutRight 0.3s ease-in forwards';
             setTimeout(() => {
                 if (toast.parentNode) {
                     toast.remove();
                 }
                 if (style.parentNode) {
                     style.remove();
                 }
             }, 300);
         }, 3000);
         
         // Add slide-out animation
         setTimeout(() => {
             const slideOutStyle = document.createElement('style');
             slideOutStyle.textContent = `
                 @keyframes slideOutRight {
                     from {
                         transform: translateX(0);
                         opacity: 1;
                     }
                     to {
                         transform: translateX(100%);
                         opacity: 0;
                     }
                 }
             `;
             document.head.appendChild(slideOutStyle);
         }, 2700);
         }
         
         // Utility functions
         function debounce(func, wait) {
         let timeout;
         return function executedFunction(...args) {
             const later = () => {
                 clearTimeout(timeout);
                 func(...args);
             };
             clearTimeout(timeout);
             timeout = setTimeout(later, wait);
         };
         }
         
         // Smooth scrolling for navigation links
         document.addEventListener('click', function(e) {
         if (e.target.matches('a[href^="#"]')) {
             e.preventDefault();
             const target = document.querySelector(e.target.getAttribute('href'));
             if (target) {
                 target.scrollIntoView({
                     behavior: 'smooth',
                     block: 'start'
                 });
             }
         }
         });
         
         // Performance optimization: Lazy loading for images
         function initializeLazyLoading() {
         const images = document.querySelectorAll('img[loading="lazy"]');
         
         if ('IntersectionObserver' in window) {
             const imageObserver = new IntersectionObserver((entries) => {
                 entries.forEach(entry => {
                     if (entry.isIntersecting) {
                         const img = entry.target;
                         img.src = img.dataset.src || img.src;
                         img.classList.remove('lazy');
                         imageObserver.unobserve(img);
                     }
                 });
             });
         
             images.forEach(img => imageObserver.observe(img));
         }
         }
         
         // Initialize lazy loading when DOM is ready
         document.addEventListener('DOMContentLoaded', initializeLazyLoading);
         
         // Handle window resize events
         window.addEventListener('resize', debounce(() => {
         // Reinitialize components that might need resizing
         console.log('Window resized');
         }, 250));
         
         // Error handling
         window.addEventListener('error', function(e) {
         console.error('JavaScript error:', e.error);
         });
         
         // Service Worker registration (if needed for PWA functionality)
         if ('serviceWorker' in navigator) {
         window.addEventListener('load', () => {
             // Uncomment if you have a service worker
             // navigator.serviceWorker.register('/sw.js');
         });
         }
      </script>
</body>
</html>
