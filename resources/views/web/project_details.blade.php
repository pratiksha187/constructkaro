@extends('layouts.app')
@section('title', 'Project Questionnaire | ConstructKaro')
@section('content')
<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
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
   .bg-orb-1 {
   position: absolute;
   top: -12rem;
   right: -12rem;
   width: 37.5rem;
   height: 37.5rem;
   background: linear-gradient(135deg, rgba(251, 146, 60, 0.08), rgba(239, 68, 68, 0.08));
   border-radius: 50%;
   filter: blur(60px);
   animation: pulse-slow 4s ease-in-out infinite;
   }
   .bg-orb-2 {
   position: absolute;
   bottom: -12rem;
   left: -12rem;
   width: 43.75rem;
   height: 43.75rem;
   background: linear-gradient(135deg, rgba(59, 130, 246, 0.08), rgba(99, 102, 241, 0.08), rgba(139, 92, 246, 0.08));
   border-radius: 50%;
   filter: blur(60px);
   animation: pulse-slow 4s ease-in-out infinite 1s;
   }
   .bg-orb-3 {
   position: absolute;
   top: 25%;
   right: 33%;
   width: 16rem;
   height: 16rem;
   background: linear-gradient(135deg, rgba(34, 197, 94, 0.06), rgba(16, 185, 129, 0.06));
   border-radius: 50%;
   filter: blur(40px);
   animation: pulse-slow 4s ease-in-out infinite 0.5s;
   }
   .bg-orb-4 {
   position: absolute;
   bottom: 25%;
   left: 33%;
   width: 20rem;
   height: 20rem;
   background: linear-gradient(135deg, rgba(139, 92, 246, 0.06), rgba(236, 72, 153, 0.06));
   border-radius: 50%;
   filter: blur(40px);
   animation: pulse-slow 4s ease-in-out infinite 1.5s;
   }
   .particle-1 {
   top: 5rem;
   left: 5rem;
   width: 0.75rem;
   height: 0.75rem;
   background: linear-gradient(45deg, var(--orange-400), var(--pink-500));
   opacity: 0.6;
   animation-delay: 0.3s;
   }
   .particle-2 {
   top: 10rem;
   right: 8rem;
   width: 1rem;
   height: 1rem;
   background: linear-gradient(45deg, var(--blue-400), var(--indigo-400));
   opacity: 0.5;
   animation-delay: 0.7s;
   }
   .particle-3 {
   bottom: 8rem;
   left: 10rem;
   width: 0.5rem;
   height: 0.5rem;
   background: linear-gradient(45deg, var(--green-400), var(--emerald-400));
   opacity: 0.7;
   animation-delay: 1s;
   }
   .particle-4 {
   bottom: 10rem;
   right: 5rem;
   width: 1.25rem;
   height: 1.25rem;
   background: linear-gradient(45deg, var(--purple-400), var(--pink-400));
   opacity: 0.4;
   animation-delay: 1.5s;
   }
   .particle-5 {
   top: 50%;
   left: 25%;
   width: 0.25rem;
   height: 0.25rem;
   background: linear-gradient(45deg, var(--yellow-400), var(--orange-400));
   opacity: 0.8;
   animation-delay: 2s;
   }
   /* Grid overlay */
   .grid-overlay {
   position: absolute;
   inset: 0;
   background-image: 
   linear-gradient(rgba(99, 102, 241, 0.015) 1px, transparent 1px),
   linear-gradient(90deg, rgba(99, 102, 241, 0.015) 1px, transparent 1px);
   background-size: 80px 80px;
   }
   /* Premium Header */
   .premium-header {
   position: relative;
   z-index: 10;
   background: rgba(255, 255, 255, 0.6);
   backdrop-filter: blur(40px);
   border-bottom: 1px solid rgba(255, 255, 255, 0.4);
   box-shadow: 0 10px 30px rgba(148, 163, 184, 0.2);
   }
   /* Hero Section */
   .hero-badge {
   display: inline-flex;
   align-items: center;
   gap: 0.75rem;
   background: linear-gradient(45deg, rgba(251, 146, 60, 0.1), rgba(236, 72, 153, 0.1), rgba(239, 68, 68, 0.1));
   color: var(--orange-700);
   padding: 0.75rem 1.5rem;
   border-radius: 9999px;
   font-size: 0.875rem;
   font-weight: 600;
   box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
   backdrop-filter: blur(10px);
   border: 1px solid rgba(251, 146, 60, 0.2);
   }
   .hero-title {
   font-size: 4rem;
   font-weight: 700;
   line-height: 1.1;
   margin-bottom: 1.5rem;
   }
   .hero-title-part-1 {
   background: linear-gradient(135deg, var(--slate-900), var(--slate-800), var(--slate-700));
   -webkit-background-clip: text;
   -webkit-text-fill-color: transparent;
   background-clip: text;
   }
   .hero-title-part-2 {
   background: linear-gradient(135deg, var(--orange-500), var(--red-500), var(--pink-500));
   -webkit-background-clip: text;
   -webkit-text-fill-color: transparent;
   background-clip: text;
   }
   .hero-title-part-3 {
   background: linear-gradient(135deg, var(--slate-900), var(--slate-800), var(--slate-700));
   -webkit-background-clip: text;
   -webkit-text-fill-color: transparent;
   background-clip: text;
   }
   .hero-subtitle {
   font-size: 1.5rem;
   color: var(--slate-600);
   line-height: 1.6;
   margin-bottom: 2rem;
   }
   /* Trust Indicators */
   .trust-indicator {
   display: flex;
   align-items: center;
   gap: 0.75rem;
   }
   .trust-icon {
   width: 3rem;
   height: 3rem;
   border-radius: 0.75rem;
   display: flex;
   align-items: center;
   justify-content: center;
   box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
   }
   .trust-icon-secure {
   background: linear-gradient(135deg, var(--green-500), var(--emerald-500));
   }
   .trust-icon-clients {
   background: linear-gradient(135deg, var(--blue-500), var(--indigo-500));
   }
   .trust-icon-rating {
   background: linear-gradient(135deg, var(--purple-500), var(--pink-500));
   }
   .trust-value {
   font-size: 1.125rem;
   font-weight: 700;
   color: var(--slate-900);
   }
   .trust-label {
   font-size: 0.875rem;
   color: var(--slate-500);
   }
   /* Enhanced Form Card */
   .form-card {
   background: rgba(255, 255, 255, 0.7);
   backdrop-filter: blur(40px);
   border: 1px solid rgba(255, 255, 255, 0.4);
   box-shadow: 0 25px 50px rgba(148, 163, 184, 0.2);
   border-radius: 1.5rem;
   overflow: hidden;
   position: relative;
   transition: all 0.5s ease;
   }
   .form-card:hover {
   background: rgba(255, 255, 255, 0.8);
   }
   .form-header-icon {
   position: relative;
   width: 4rem;
   height: 4rem;
   background: linear-gradient(135deg, var(--blue-500), var(--indigo-500), var(--purple-500));
   border-radius: 1rem;
   display: flex;
   align-items: center;
   justify-content: center;
   box-shadow: 0 20px 40px rgba(59, 130, 246, 0.25);
   }
   .form-header-icon-sparkle {
   position: absolute;
   top: -0.5rem;
   right: -0.5rem;
   width: 1.5rem;
   height: 1.5rem;
   background: linear-gradient(45deg, var(--green-400), var(--emerald-400));
   border-radius: 50%;
   display: flex;
   align-items: center;
   justify-content: center;
   box-shadow: 0 10px 20px rgba(34, 197, 94, 0.3);
   }
   .form-header-title {
   font-size: 2.5rem;
   font-weight: 700;
   color: var(--slate-900);
   }
   .form-header-subtitle {
   font-size: 1.125rem;
   color: var(--slate-600);
   }
   /* Enhanced Form Fields */
   .form-label {
   display: flex;
   align-items: center;
   gap: 0.75rem;
   color: var(--slate-700);
   font-weight: 700;
   font-size: 1.125rem;
   margin-bottom: 1rem;
   }
   .form-label-icon {
   width: 2rem;
   height: 2rem;
   border-radius: 0.5rem;
   display: flex;
   align-items: center;
   justify-content: center;
   box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
   }
   .icon-orange {
   background: linear-gradient(135deg, var(--orange-500), var(--red-500));
   }
   .icon-blue {
   background: linear-gradient(135deg, var(--blue-500), var(--indigo-500));
   }
   .icon-green {
   background: linear-gradient(135deg, var(--green-500), var(--emerald-500));
   }
   .icon-purple {
   background: linear-gradient(135deg, var(--purple-500), var(--pink-500));
   }
   .icon-indigo {
   background: linear-gradient(135deg, var(--indigo-500), var(--purple-500));
   }
   .form-input {
   height: 4rem;
   background: linear-gradient(135deg, var(--slate-50), white);
   border: 2px solid var(--slate-200);
   border-radius: 1rem;
   padding: 0 1.5rem;
   color: var(--slate-900);
   font-size: 1rem;
   box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
   backdrop-filter: blur(10px);
   transition: all 0.3s ease;
   width: 100%;
   }
   .form-input::placeholder {
   color: var(--slate-400);
   }
   .form-input:focus {
   outline: none;
   box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
   transform: scale(1.02);
   }
   .form-input.focus-orange:focus {
   border-color: var(--orange-400);
   box-shadow: 0 0 0 4px rgba(251, 146, 60, 0.1), 0 20px 40px rgba(249, 115, 22, 0.2);
   }
   .form-input.focus-blue:focus {
   border-color: var(--blue-400);
   box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1), 0 20px 40px rgba(59, 130, 246, 0.2);
   }
   .form-input.focus-green:focus {
   border-color: var(--green-400);
   box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.1), 0 20px 40px rgba(34, 197, 94, 0.2);
   }
   .form-input.focus-purple:focus {
   border-color: var(--purple-400);
   box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.1), 0 20px 40px rgba(139, 92, 246, 0.2);
   }
   .form-textarea {
   min-height: 8.75rem;
   background: linear-gradient(135deg, var(--slate-50), white);
   border: 2px solid var(--slate-200);
   border-radius: 1rem;
   padding: 1rem 1.5rem;
   color: var(--slate-900);
   font-size: 1rem;
   box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
   backdrop-filter: blur(10px);
   transition: all 0.3s ease;
   resize: none;
   width: 100%;
   }
   .form-textarea:focus {
   outline: none;
   border-color: var(--indigo-400);
   box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1), 0 20px 40px rgba(99, 102, 241, 0.2);
   transform: scale(1.01);
   }
   .form-select {
   height: 4rem;
   background: linear-gradient(135deg, var(--slate-50), white);
   border: 2px solid var(--slate-200);
   border-radius: 1rem;
   padding: 0 1.5rem;
   color: var(--slate-900);
   font-size: 1rem;
   box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
   backdrop-filter: blur(10px);
   transition: all 0.3s ease;
   width: 100%;
   }
   .form-select:focus {
   outline: none;
   border-color: var(--purple-400);
   box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.1), 0 20px 40px rgba(139, 92, 246, 0.2);
   transform: scale(1.02);
   }
   .input-check-icon {
   position: absolute;
   right: 1rem;
   top: 50%;
   transform: translateY(-50%);
   color: var(--green-500);
   opacity: 0;
   transition: opacity 0.3s ease;
   }
   .input-check-icon.show {
   opacity: 1;
   }
   /* Separator */
   .separator {
   position: relative;
   text-align: center;
   }
   .separator::before {
   content: '';
   position: absolute;
   top: 50%;
   left: 0;
   right: 0;
   height: 1px;
   background: linear-gradient(90deg, transparent, var(--slate-300), transparent);
   }
   .separator-badge {
   position: relative;
   display: inline-flex;
   align-items: center;
   gap: 0.75rem;
   background: linear-gradient(45deg, rgba(251, 146, 60, 0.1), rgba(236, 72, 153, 0.1), rgba(239, 68, 68, 0.1));
   color: var(--orange-700);
   padding: 1rem 2rem;
   border-radius: 9999px;
   font-size: 1.125rem;
   font-weight: 700;
   box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
   backdrop-filter: blur(10px);
   border: 1px solid rgba(251, 146, 60, 0.2);
   }
   /* Option Cards */
   .option-card {
   position: relative;
   background: rgba(255, 255, 255, 0.9);
   backdrop-filter: blur(20px);
   border: 3px solid transparent;
   box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
   border-radius: 1.5rem;
   overflow: hidden;
   cursor: pointer;
   transition: all 0.7s ease;
   }
   .option-card:hover {
   transform: scale(1.02);
   box-shadow: 0 35px 70px rgba(0, 0, 0, 0.15);
   }
   .option-card.selected {
   background: white;
   box-shadow: 0 35px 70px rgba(0, 0, 0, 0.15);
   }
   .option-card-orange {
   border-color: rgba(251, 146, 60, 0.2);
   }
   .option-card-orange:hover,
   .option-card-orange.selected {
   border-color: var(--orange-400);
   box-shadow: 0 0 0 4px rgba(251, 146, 60, 0.1), 0 35px 70px rgba(249, 115, 22, 0.25);
   }
   .option-card-blue {
   border-color: rgba(59, 130, 246, 0.2);
   }
   .option-card-blue:hover,
   .option-card-blue.selected {
   border-color: var(--blue-400);
   box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1), 0 35px 70px rgba(59, 130, 246, 0.25);
   }
   .option-card-selection-indicator {
   position: absolute;
   top: 1.5rem;
   right: 1.5rem;
   width: 2rem;
   height: 2rem;
   background: linear-gradient(135deg, var(--green-500), var(--emerald-500));
   border-radius: 50%;
   display: flex;
   align-items: center;
   justify-content: center;
   box-shadow: 0 10px 30px rgba(34, 197, 94, 0.3);
   opacity: 0;
   transform: scale(0);
   transition: all 0.3s ease;
   }
   .option-card.selected .option-card-selection-indicator {
   opacity: 1;
   transform: scale(1);
   }
   .option-card-badge {
   position: absolute;
   top: 1.5rem;
   left: 1.5rem;
   color: white;
   border: none;
   padding: 0.5rem 1rem;
   font-size: 0.875rem;
   font-weight: 700;
   border-radius: 0.5rem;
   box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
   }
   .badge-orange {
   background: linear-gradient(135deg, var(--orange-500), var(--red-500));
   }
   .badge-blue {
   background: linear-gradient(135deg, var(--blue-500), var(--purple-500));
   }
   .option-card-content {
   padding: 2.5rem;
   position: relative;
   }
   .option-card-icon-main {
   width: 7rem;
   height: 7rem;
   border-radius: 1.5rem;
   display: flex;
   align-items: center;
   justify-content: center;
   box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
   transition: all 0.5s ease;
   margin: 0 auto 1.5rem;
   }
   .option-card:hover .option-card-icon-main {
   transform: scale(1.1) rotate(6deg);
   }
   .icon-orange-gradient {
   background: linear-gradient(135deg, var(--yellow-500), var(--orange-500), var(--red-500));
   }
   .icon-blue-gradient {
   background: linear-gradient(135deg, var(--blue-500), var(--indigo-500), var(--purple-500));
   }
   .option-card-title {
   font-size: 1.875rem;
   font-weight: 700;
   color: var(--slate-900);
   margin-bottom: 0.75rem;
   transition: all 0.3s ease;
   text-align: center;
   }
   .option-card:hover .option-card-title {
   background: linear-gradient(135deg, var(--orange-600), var(--pink-600));
   -webkit-background-clip: text;
   -webkit-text-fill-color: transparent;
   background-clip: text;
   }
   .option-card-subtitle {
   font-size: 1.125rem;
   font-weight: 600;
   color: var(--slate-600);
   margin-bottom: 0.75rem;
   text-align: center;
   }
   .option-card-description {
   color: var(--slate-600);
   line-height: 1.6;
   font-size: 1.125rem;
   margin-bottom: 2rem;
   text-align: center;
   }
   .option-card-features {
   margin-bottom: 2rem;
   }
   .option-card-feature {
   display: flex;
   align-items: center;
   gap: 1rem;
   padding: 0.75rem;
   border-radius: 1rem;
   transition: all 0.3s ease;
   margin-bottom: 1rem;
   }
   .option-card-feature.highlight {
   background: linear-gradient(45deg, rgba(255, 251, 235, 0.8), rgba(254, 243, 199, 0.8));
   border: 1px solid rgba(251, 146, 60, 0.2);
   }
   .option-card-feature:hover {
   background: var(--slate-50);
   }
   .option-card-feature-icon {
   width: 2.5rem;
   height: 2.5rem;
   border-radius: 0.75rem;
   display: flex;
   align-items: center;
   justify-content: center;
   flex-shrink: 0;
   box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
   transition: transform 0.3s ease;
   }
   .option-card:hover .option-card-feature-icon {
   transform: scale(1.1);
   }
   .option-card-feature-text {
   font-size: 1.125rem;
   font-weight: 600;
   color: var(--slate-700);
   }
   .option-card-feature.highlight .option-card-feature-text {
   color: var(--orange-700);
   }
   .option-card-feature-star {
   margin-left: auto;
   color: var(--orange-500);
   }
   .option-card-status {
   padding-top: 1.5rem;
   border-top: 1px solid var(--slate-200);
   }
   .option-card-status-badge {
   width: 100%;
   text-align: center;
   padding: 1rem;
   font-size: 1.125rem;
   font-weight: 700;
   border: none;
   border-radius: 1rem;
   transition: all 0.3s ease;
   }
   .status-badge-default {
   background: var(--slate-100);
   color: var(--slate-700);
   }
   .option-card:hover .status-badge-default {
   transform: scale(1.05);
   }
   .status-badge-selected {
   background: linear-gradient(135deg, var(--green-500), var(--emerald-500));
   color: white;
   box-shadow: 0 10px 20px rgba(34, 197, 94, 0.3);
   }
   /* Action Buttons */
   .btn-back {
   display: flex;
   align-items: center;
   gap: 0.75rem;
   border: 2px solid var(--slate-300);
   background: transparent;
   color: var(--slate-700);
   padding: 1rem 2.5rem;
   border-radius: 1rem;
   font-size: 1.125rem;
   font-weight: 600;
   transition: all 0.3s ease;
   box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
   }
   .btn-back:hover {
   border-color: var(--orange-400);
   background: linear-gradient(45deg, rgba(249, 115, 22, 0.05), rgba(236, 72, 153, 0.05));
   transform: scale(1.05);
   box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
   }
   .btn-submit {
   height: 4rem;
   background: linear-gradient(135deg, var(--blue-600), var(--indigo-600), var(--purple-600));
   border: none;
   color: white;
   padding: 0 3rem;
   border-radius: 1rem;
   font-size: 1.25rem;
   font-weight: 700;
   box-shadow: 0 25px 50px rgba(59, 130, 246, 0.25);
   transition: all 0.3s ease;
   position: relative;
   overflow: hidden;
   }
   .btn-submit:hover {
   background: linear-gradient(135deg, var(--blue-700), var(--indigo-700), var(--purple-700));
   transform: scale(1.05);
   box-shadow: 0 30px 60px rgba(59, 130, 246, 0.3);
   }
   .btn-submit:disabled {
   opacity: 0.5;
   cursor: not-allowed;
   transform: none;
   }
   /* Help Section */
   .help-card {
   background: linear-gradient(135deg, var(--slate-50), rgba(239, 246, 255, 0.5), rgba(238, 242, 255, 0.3));
   border: 2px solid rgba(148, 163, 184, 0.2);
   border-radius: 1.5rem;
   overflow: hidden;
   box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
   position: relative;
   transition: all 0.5s ease;
   }
   .help-card:hover {
   background: linear-gradient(135deg, var(--slate-50), rgba(239, 246, 255, 0.7), rgba(238, 242, 255, 0.5));
   }
   .help-icon-main {
   width: 5rem;
   height: 5rem;
   background: linear-gradient(135deg, var(--indigo-500), var(--purple-500), var(--pink-500));
   border-radius: 1.5rem;
   display: flex;
   align-items: center;
   justify-content: center;
   box-shadow: 0 20px 40px rgba(99, 102, 241, 0.25);
   transition: all 0.3s ease;
   margin: 0 auto 2rem;
   }
   .help-card:hover .help-icon-main {
   transform: scale(1.1) rotate(3deg);
   }
   .help-title {
   font-size: 1.875rem;
   font-weight: 700;
   color: var(--slate-900);
   margin-bottom: 1rem;
   }
   .help-description {
   font-size: 1.25rem;
   color: var(--slate-600);
   line-height: 1.6;
   margin-bottom: 2rem;
   }
   .btn-help-primary {
   background: linear-gradient(135deg, var(--green-500), var(--emerald-500));
   border: none;
   color: white;
   padding: 1rem 2rem;
   border-radius: 1rem;
   font-weight: 600;
   box-shadow: 0 20px 40px rgba(34, 197, 94, 0.25);
   transition: all 0.3s ease;
   }
   .btn-help-primary:hover {
   background: linear-gradient(135deg, var(--green-600), var(--emerald-600));
   transform: scale(1.05);
   }
   .btn-help-secondary {
   border: 2px solid var(--indigo-300);
   background: transparent;
   color: var(--slate-700);
   padding: 1rem 2rem;
   border-radius: 1rem;
   font-weight: 600;
   transition: all 0.3s ease;
   }
   .btn-help-secondary:hover {
   border-color: var(--indigo-400);
   background: linear-gradient(45deg, rgba(99, 102, 241, 0.05), rgba(139, 92, 246, 0.05));
   transform: scale(1.05);
   }
   /* Animations */
   @keyframes pulse-slow {
   0%, 100% { opacity: 0.3; transform: scale(1); }
   50% { opacity: 0.5; transform: scale(1.05); }
   }
   @keyframes bounce-float {
   0%, 100% { transform: translateY(0); }
   50% { transform: translateY(-20px); }
   }
   @keyframes pulse-glow {
   0%, 100% { opacity: 0.8; transform: scale(1); }
   50% { opacity: 1; transform: scale(1.1); }
   }
   /* Responsive Design */
   @media (max-width: 1200px) {
   .hero-title {
   font-size: 3.5rem;
   }
   }
   @media (max-width: 992px) {
   .hero-title {
   font-size: 3rem;
   }
   .trust-indicator {
   flex-direction: column;
   text-align: center;
   }
   }
   @media (max-width: 768px) {
   .hero-title {
   font-size: 2.5rem;
   }
   .hero-subtitle {
   font-size: 1.25rem;
   }
   .form-header-title {
   font-size: 2rem;
   }
   .option-card-title {
   font-size: 1.5rem;
   }
   .option-card-content {
   padding: 1.5rem;
   }
   }
   @media (max-width: 576px) {
   .hero-title {
   font-size: 2rem;
   }
   /* .brand-text {
   font-size: 1.5rem;
   } */
   .form-label {
   font-size: 1rem;
   }
   }
   /* Utility Classes */
   .animate-pulse {
   animation: pulse-glow 1.5s ease-in-out infinite;
   }
   .animate-bounce {
   animation: bounce-float 2s ease-in-out infinite;
   }
   .position-relative {
   position: relative;
   }
   .z-index-10 {
   z-index: 10;
   }
   /* Custom Badge */
   .badge-optional {
   background-color: rgba(59, 130, 246, 0.1);
   color: var(--blue-700);
   margin-left: 0.5rem;
   padding: 0.25rem 0.75rem;
   border-radius: 0.5rem;
   font-size: 0.75rem;
   font-weight: 600;
   }
   .btn-gradient {
   background: linear-gradient(to right, #ff6600, #ff8533);
   color: white;
   border: none;
   transition: all 0.3s ease;
   font-weight: 500;
   }
   .btn-gradient:hover {
   background: linear-gradient(to right, #e65c00, #ff751a);
   color: #fff;
   }
   .package-card {
   background-color: #ffffff;
   transition: transform 0.3s ease, box-shadow 0.3s ease;
   position: relative;
   }
   .package-card:hover {
   transform: translateY(-5px);
   box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
   }
   .package-card ul li {
   margin-bottom: 0.5rem;
   font-size: 0.95rem;
   }
   .modal-content {
   background-color: #fff;
   border-radius: 1rem;
   padding: 1rem 1.5rem;
   }
   .btn-primary {
   background: linear-gradient(to right, #5b48ff, #6c63ff);
   border: none;
   }
   .btn-primary:hover {
   background: linear-gradient(to right, #473fff, #5d54ff);
   }
   .confirmation-container {
   padding: 2rem;
   font-family: 'Inter', sans-serif;
   color: #1f2937;
   max-width: 700px;
   margin: auto;
   background: #fff;
   border-radius: 16px;
   box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
   }
   .planner-heading {
   display: flex;
   align-items: center;
   font-size: 1.75rem;
   font-weight: 700;
   color: #111827;
   }
   .planner-logo {
   width: 40px;
   margin-right: 10px;
   }
   .planner-subheading {
   font-size: 1rem;
   color: #6b7280;
   margin-bottom: 1.5rem;
   }
   .summary-card {
   background-color: #e7f1ff;
   border-radius: 12px;
   padding: 1.5rem;
   margin-bottom: 1.5rem;
   }
   .summary-title {
   font-size: 1.125rem;
   font-weight: 600;
   color: #2563eb;
   margin-bottom: 1rem;
   }
   .summary-grid {
   display: grid;
   grid-template-columns: 1fr 1fr;
   gap: 1rem 2rem;
   }
   .summary-grid strong {
   color: #111827;
   }
   .success-banner {
   display: flex;
   gap: 1rem;
   align-items: flex-start;
   background-color: #d1fae5;
   padding: 1rem 1.25rem;
   border-radius: 10px;
   color: #065f46;
   margin-bottom: 1.5rem;
   font-size: 0.95rem;
   }
   .success-banner i {
   font-size: 1.5rem;
   color: #10b981;
   }
   .submit-wrapper {
   text-align: right;
   }
   .btn-primary {
   background: linear-gradient(to right, #6366f1, #8b5cf6);
   border: none;
   font-weight: 600;
   padding: 0.6rem 1.5rem;
   border-radius: 8px;
   color: #fff;
   transition: background 0.3s ease;
   }
   .btn-primary:hover {
   background: linear-gradient(to right, #4f46e5, #7c3aed);
   }
   .is-invalid {
   border: 1px solid #e3342f !important;
   background-color: #fff5f5;
   }
</style>
<div class="min-vh-100 position-relative">
   <!-- Enhanced Background -->
   <div class="enhanced-background"></div>
   <!-- Grid overlay -->
   <div class="grid-overlay"></div>
   <!-- Main Content -->
   <main class="position-relative z-index-10 py-5">
      <div class="container-xl">
         <!-- Enhanced Hero Section -->
         <div class="text-center mb-5" style="padding: 2rem 0;">
            <div class="hero-badge mb-4">
               <i data-lucide="star" style="width: 1.25rem; height: 1.25rem;" class="animate-pulse"></i>
               <span>Premium Project Planning Experience</span>
            </div>
            <div class="mb-4">
               <h2 class="hero-title">
                  <span class="hero-title-part-1">Share Your</span><br>
                  <span class="hero-title-part-2">Vision</span>
                  <span class="hero-title-part-3"> With Us</span>
               </h2>
               <p class="hero-subtitle mx-auto" style="max-width: 56rem;">
                  Tell us about your construction project and let our experts guide you through 
                  the perfect solution tailored to your needs and budget.
               </p>
            </div>
            <!-- Trust indicators -->
            <div class="d-flex justify-content-center align-items-center flex-wrap" style="gap: 3rem; padding-top: 2rem;">
               <div class="trust-indicator">
               </div>
            </div>
         </div>
         <!-- Enhanced Project Details Form -->
         <div class="form-card mb-5" style="margin: 4rem 0;">
            <div class="p-5">
               <div class="text-center mb-5">
                  <div class="d-inline-flex align-items-center mb-4" style="gap: 1rem;">
                     <div class="form-header-icon">
                        <i data-lucide="file-text" class="text-white" style="width: 2rem; height: 2rem;"></i>
                        <div class="form-header-icon-sparkle">
                           <i data-lucide="sparkles" class="text-white" style="width: 0.75rem; height: 0.75rem;"></i>
                        </div>
                     </div>
                     <div class="text-start">
                        <h3 class="form-header-title">Project Information</h3>
                        <p class="form-header-subtitle mb-0">Let's understand your project requirements</p>
                     </div>
                  </div>
               </div>
               <form id="projectForm">
                  <div class="row g-4 mb-4">
                     <div class="col-lg-6">
                        <div class="form-field-group">
                           <label class="form-label">
                              <div class="form-label-icon icon-orange">
                                 <i data-lucide="building-2" class="text-white" style="width: 1rem; height: 1rem;"></i>
                              </div>
                              <span>Project Name</span>
                           </label>
                           <div class="position-relative">
                              <input 
                                 type="text" 
                                 name="project_name" id="project_name"
                                 class="form-input focus-orange" 
                                 placeholder="e.g., Modern Family Villa, Office Complex..."
                                 require>
                              <div class="input-check-icon" id="projectNameCheck">
                                 <i data-lucide="check-circle" style="width: 1.5rem; height: 1.5rem;"></i>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <!-- File Selector -->
                        <label class="form-label mt-2">
                           <div class="form-label-icon icon-green">
                              <i data-lucide="paperclip" class="text-white" style="width: 1rem; height: 1rem;"></i>
                           </div>
                           <span>Attach Project Files (optional)</span>
                        </label>
                        <input 
                           type="file" 
                           id="file_path" 
                           name="file_path[]" 
                           class="form-control" 
                           multiple 
                           accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                           >
                        <small class="form-text text-muted">You can attach multiple files (PDF, DOC, JPG, PNG). Max 10MB each.</small>
                     </div>
                  </div>
                  <div class="row g-4 mb-4">
                     <div class="col-lg-12">
                        <label class="form-label">
                           <div class="form-label-icon icon-indigo">
                              <i data-lucide="file-text" class="text-white" style="width: 1rem; height: 1rem;"></i>
                           </div>
                           <span>Project Description</span>
                        </label>
                        <textarea 
                           id="project_description" name="project_description"
                           class="form-textarea mb-3" 
                           placeholder="Tell us more about your project vision, specific requirements, architectural preferences, or any special features you have in mind..."
                           ></textarea>
                     </div>
                     <div class="space-y-4">
                      
                         <div>
                           <h3 class="font-medium text-gray-900 mb-2">
                              Agreement & Terms <span class="text-red-500">*</span>
                           </h3>

                           <div class="space-y-3">
                              <!-- ✅ Checkbox 1: Terms & Conditions -->
                              <div class="flex items-start space-x-3">
                                 <input 
                                    type="checkbox" 
                                    name="terms_conditions" 
                                    class="mt-1 w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                 >
                                 <label class="text-gray-700 leading-6">
                                    I accept the 
                                    <a href="{{route('customer.agreement')}}" class="text-indigo-600 font-medium hover:underline">Customer Terms &amp; Conditions</a>.
                                 </label>
                              </div>

                              <!-- ✅ Checkbox 2: Privacy Policy -->
                              <div class="flex items-start space-x-3">
                                 <input 
                                    type="checkbox" 
                                    name="privacy_policy" 
                                    class="mt-1 w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                 >
                                 <label class="text-gray-700 leading-6">
                                    I accept the 
                                    <a href="#" class="text-indigo-600 font-medium hover:underline">Privacy Policy</a>.
                                 </label>
                              </div>

                              <!-- ✅ Checkbox 3: No Bypass -->
                              <div class="flex items-start space-x-3">
                                 <input 
                                    type="checkbox" 
                                    name="no_bypass" 
                                    class="mt-1 w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                 >
                                 <label class="text-gray-700 leading-6">
                                    I agree not to bypass ConstructKaro with vendors introduced via this platform.
                                 </label>
                              </div>
                           </div>
                        </div>

                     @if($showFullAddons)
                     <!-- ✅ Show all 3 Add-ons -->
                     <div class="border rounded-lg p-4 bg-gray-50">
                        <h4 class="font-medium text-gray-900 mb-3">Optional Add-ons (Custom Plan)</h4>
                        <p class="text-sm text-gray-500 mb-3">
                           <i class="bi bi-info-circle me-1 text-indigo-500"></i>
                           Complimentary add-on available for your <span class="font-medium text-indigo-600">first project</span> only.
                        </p>

                        <div class="space-y-3">
                           <label class="flex items-start space-x-2">
                              <input type="checkbox" name="addons[]" value="architect_boq"
                                 class="mt-1 w-4 h-4 text-indigo-600 border-gray-300 rounded">
                              <span>
                                 <span class="font-medium text-gray-900">Get Architect &amp; BOQ package</span><br>
                                 <span class="text-gray-600 text-sm">Design 2D & 3D + Drawings + BOQ </span>
                              </span>
                           </label>

                           <label class="flex items-start space-x-2">
                              <input type="checkbox" name="addons[]" value="quality_safety"
                                 class="mt-1 w-4 h-4 text-indigo-600 border-gray-300 rounded">
                              <span>
                                 <span class="font-medium text-gray-900">Site Quality &amp; Safety checks</span><br>
                                 <span class="text-gray-600 text-sm">Periodic inspections during construction</span>
                              </span>
                           </label>

                           <label class="flex items-start space-x-2">
                              <input type="checkbox" name="addons[]" value="monitoring_dashboard"
                                 class="mt-1 w-4 h-4 text-indigo-600 border-gray-300 rounded">
                              <span>
                                 <span class="font-medium text-gray-900">Project Monitoring Dashboard</span><br>
                                 <span class="text-gray-600 text-sm">Progress tracking, photos, milestones</span>
                              </span>
                           </label>
                        </div>
                     </div>

                     @else
                     <!-- ⚪ Show only 2 Add-ons -->
                     <div class="border rounded-lg p-4 bg-gray-50">
                        <h4 class="font-medium text-gray-900 mb-3">Optional Add-ons (Custom Plan)</h4>
                      <p class="text-sm text-gray-500 mb-3">
   <i class="bi bi-info-circle me-1 text-indigo-500"></i>
   Complimentary add-on available for your <span class="font-medium text-indigo-600">first project</span> only.
</p>

                        <div class="space-y-3">
                           <label class="flex items-start space-x-2">
                              <input type="checkbox" name="addons[]" value="quality_safety"
                                 class="mt-1 w-4 h-4 text-indigo-600 border-gray-300 rounded">
                              <span>
                                 <span class="font-medium text-gray-900">Site Quality &amp; Safety checks</span><br>
                                 <span class="text-gray-600 text-sm">Periodic inspections during construction</span>
                              </span>
                           </label>

                           <label class="flex items-start space-x-2">
                              <input type="checkbox" name="addons[]" value="monitoring_dashboard"
                                 class="mt-1 w-4 h-4 text-indigo-600 border-gray-300 rounded">
                              <span>
                                 <span class="font-medium text-gray-900">Project Monitoring Dashboard</span><br>
                                 <span class="text-gray-600 text-sm">Progress tracking, photos, milestones</span>
                              </span>
                           </label>
                        </div>
                     </div>
                     @endif

                       

                     </div>
                  </div>
                  <div class="d-flex justify-content-between">
                     <button type="button" class="btn btn-outline-secondary" onclick="window.history.back();">
                     Back
                     </button>
                     <button type="submit" class="btn btn-primary">
                     Submit Project
                     </button>
                  </div>
               </form>
            </div>
         </div>
         <!-- Enhanced Separator -->
         <div class="separator mb-5">
            <div class="separator-badge">
               <i data-lucide="target" style="width: 1.5rem; height: 1.5rem;" class="animate-pulse"></i>
               <span>Choose Your Perfect Approach</span>
               <i data-lucide="sparkles" style="width: 1.5rem; height: 1.5rem;" class="animate-bounce"></i>
            </div>
         </div>
         <!-- Enhanced Options Grid -->
         <div class="row g-4 mb-5">
            <div class="col-lg-6">
               <div class="option-card option-card-orange" id="optionCard1" data-option="options">
                  <div class="option-card-selection-indicator">
                     <i data-lucide="check-circle" class="text-white" style="width: 1.25rem; height: 1.25rem;"></i>
                  </div>
                  <div class="option-card-badge badge-orange">
                     Most Popular
                  </div>
                  <div class="option-card-content">
                     <!-- Icon and Title -->
                     <div class="text-center mb-4 position-relative" style="z-index: 10;">
                        <div class="option-card-icon-main icon-orange-gradient">
                           <i data-lucide="folder-open" class="text-white" style="width: 3.5rem; height: 3.5rem;"></i>
                        </div>
                        <div>
                           <h3 class="option-card-title">Browse Ready-Made Packages</h3>
                           <p class="option-card-subtitle">Perfect for clients with flexible requirements</p>
                           <p class="option-card-description">Explore our curated collection of pre-designed construction packages with transparent pricing and detailed specifications.</p>
                        </div>
                     </div>
                     <!-- Trigger element -->
                     <div class="option-card-status position-relative" style="z-index: 10;">
                        <div 
                           class="option-card-status-badge status-badge-default" 
                           id="statusBadge1"
                           data-bs-toggle="modal" 
                           data-bs-target="#selectPackageModal"
                           style="cursor: pointer;"
                           >
                           Click to Select
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-lg-6">
               <div class="option-card option-card-blue" id="optionCard2" data-option="guidance">
                  <div class="option-card-selection-indicator">
                     <i data-lucide="check-circle" class="text-white" style="width: 1.25rem; height: 1.25rem;"></i>
                  </div>
                  <div class="option-card-badge badge-blue">
                     Premium
                  </div>
                  <div class="option-card-content">
                     <!-- Icon and Title -->
                     <div class="text-center mb-4 position-relative" style="z-index: 10;">
                        <div class="option-card-icon-main icon-blue-gradient">
                           <i data-lucide="user-check" class="text-white" style="width: 3.5rem; height: 3.5rem;"></i>
                        </div>
                        <div>
                           <h3 class="option-card-title">Get Expert Consultation</h3>
                           <p class="option-card-subtitle">Ideal for complex or unique projects</p>
                           <p class="option-card-description">Work directly with our construction experts to design a completely customized solution tailored to your specific needs.</p>
                        </div>
                     </div>
                     <div class="option-card-status position-relative" style="z-index: 10;">
                        <div class="option-card-status-badge status-badge-default"
                           id="statusBadge2"
                           data-bs-toggle="modal"
                           data-bs-target="#projectFormModal"
                           style="cursor: pointer;">
                           Click to Select
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </main>
</div>
<div class="modal fade" id="selectPackageModal" tabindex="-1" aria-labelledby="selectPackageModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content rounded-4 border-0 shadow-lg">
         <div class="modal-header bg-light border-0 px-4 pt-4">
            <h4 class="modal-title fw-semibold" id="selectPackageModalLabel">Select Package</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body px-4 pb-0">
            <div class="text-center mb-4">
               <p class="text-muted small">Please select the option that best describes your current situation:</p>
               <h2 class="fw-bold">Our Ready-Made Packages</h2>
               <p class="text-muted">Select a package that best fits your project needs. All packages can be customized further.</p>
            </div>
            <div class="row g-4">
               <!-- Essential -->
               <div class="col-md-4">
                  <div class="package-card shadow-sm p-4 rounded-4 h-100">
                     <h5 class="fw-bold text-primary">Essential</h5>
                     <p class="text-muted small">For smaller projects</p>
                     <h4 class="fw-bold mt-2">$10,000 <span class="text-muted fs-6">starting at</span></h4>
                     <ul class="list-unstyled mt-3 mb-4">
                        <li>✔ Basic design consultation</li>
                        <li>✔ Standard materials</li>
                        <li>✔ 3-month timeline</li>
                        <li>✔ 1-year warranty</li>
                     </ul>
                     <button class="btn btn-gradient w-100">Select Package</button>
                  </div>
               </div>
               <!-- Premium -->
               <div class="col-md-4">
                  <div class="package-card shadow-sm p-4 rounded-4 h-100 border border-warning">
                     <div class="badge bg-warning text-dark position-absolute top-0 end-0 mt-3 me-3">POPULAR</div>
                     <h5 class="fw-bold text-primary">Premium</h5>
                     <p class="text-muted small">For medium-sized projects</p>
                     <h4 class="fw-bold mt-2">$25,000 <span class="text-muted fs-6">starting at</span></h4>
                     <ul class="list-unstyled mt-3 mb-4">
                        <li>✔ Advanced design consultation</li>
                        <li>✔ Premium materials</li>
                        <li>✔ 6-month timeline</li>
                        <li>✔ 3-year warranty</li>
                        <li>✔ Project management included</li>
                     </ul>
                     <button class="btn btn-gradient w-100">Select Package</button>
                  </div>
               </div>
               <!-- Luxury -->
               <div class="col-md-4">
                  <div class="package-card shadow-sm p-4 rounded-4 h-100">
                     <h5 class="fw-bold text-primary">Luxury</h5>
                     <p class="text-muted small">For high-end projects</p>
                     <h4 class="fw-bold mt-2">$50,000+ <span class="text-muted fs-6">starting at</span></h4>
                     <ul class="list-unstyled mt-3 mb-4">
                        <li>✔ Full architectural services</li>
                        <li>✔ Luxury materials</li>
                        <li>✔ Custom timeline</li>
                        <li>✔ 5-year warranty</li>
                        <li>✔ Dedicated project manager</li>
                        <li>✔ Interior design services</li>
                     </ul>
                     <button class="btn btn-gradient w-100">Select Package</button>
                  </div>
               </div>
            </div>
            <div class="text-center mt-4">
               <p class="text-muted">Don’t see what you’re looking for? We can create a custom package for your specific needs.</p>
               <button class="btn btn-outline-primary">Request Custom Package</button>
            </div>
         </div>
         <div class="modal-footer border-0 px-4 pb-4">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-gradient">Confirm Selection</button>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="projectFormModal" tabindex="-1" aria-labelledby="projectFormModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content border-0 rounded-4 shadow-lg">
         <div class="modal-header border-0 pb-0">
            <h4 class="modal-title fw-bold" id="projectFormModalLabel">Tell Us About Your Project</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body pt-2">
            <p class="text-muted">Don’t worry if you don’t have all the details. Our team will call you to discuss your project and help finalize the details.</p>
            <form id="projectForm">
               <div class="row g-3">
                  <div class="col-md-6">
                     <label class="form-label">Your Name</label>
                     <input type="text" class="form-control form-control-lg" placeholder="Enter your full name">
                  </div>
                  <div class="col-md-6">
                     <label class="form-label">Phone Number</label>
                     <input type="text" class="form-control form-control-lg" placeholder="Enter your phone number">
                  </div>
                  <div class="col-md-12">
                     <label class="form-label">Email Address</label>
                     <input type="email" class="form-control form-control-lg" placeholder="Enter your email address">
                  </div>
                  <div class="col-md-12">
                     <label class="form-label">Project Type</label>
                     <select class="form-select form-select-lg">
                        <option selected disabled>Select project type</option>
                        <option>Residential</option>
                        <option>Commercial</option>
                        <option>Renovation</option>
                     </select>
                  </div>
                  <div class="col-md-12">
                     <label class="form-label">Project Brief</label>
                     <textarea class="form-control form-control-lg" rows="4" placeholder="Tell us what you have in mind, even if it's just a general idea"></textarea>
                  </div>
                  <div class="col-md-6">
                     <label class="form-label">Best Day to Call</label>
                     <select class="form-select form-select-lg">
                        <option selected disabled>Select day</option>
                        <option>Monday</option>
                        <option>Tuesday</option>
                        <option>Wednesday</option>
                     </select>
                  </div>
                  <div class="col-md-6">
                     <label class="form-label">Best Time to Call</label>
                     <select class="form-select form-select-lg">
                        <option selected disabled>Select time</option>
                        <option>Morning (9am - 12pm)</option>
                        <option>Afternoon (12pm - 3pm)</option>
                        <option>Evening (3pm - 6pm)</option>
                     </select>
                  </div>
               </div>
               <div class="d-flex justify-content-between mt-4">
                  <button type="button" class="btn btn-outline-secondary btn-lg" data-bs-dismiss="modal">Back</button>
                  <button type="submit" class="btn btn-primary btn-lg px-4">Submit Request</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="projectConfirmModal" tabindex="-1" aria-labelledby="projectConfirmModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="confirmation-container">
            <h2 class="planner-heading">
               <!-- <img src="your-logo.png" alt="Logo" class="planner-logo"> -->
               Construction Project Planner
            </h2>
            <p class="planner-subheading">Review your project details and submit your request</p>
            <div class="summary-card">
               <h4 class="summary-title"><i class="bi bi-file-earmark-text"></i> Project Summary</h4>
               <div class="summary-grid">
                  <div>
                     <strong>Project Name</strong><br>
                     <span id="modalProjectName">-</span>
                  </div>
                  <div style="grid-column: span 2;">
                     <strong>Description</strong><br>
                     <span id="modalDescription">-</span>
                  </div>
               </div>
            </div>
            <div class="success-banner">
               <i class="bi bi-check-circle-fill"></i> 
               <div>
                  <strong>Ready to proceed!</strong><br>
                  Your project details are set. Click submit to send your request. Our team will contact you soon.
               </div>
            </div>
            <div class="submit-wrapper">
               <button type="button" class="btn btn-outline-secondary me-3" data-bs-dismiss="modal">Edit</button>
               <button type="button" class="btn btn-primary" id="confirmSubmitBtn">
               <i class="bi bi-rocket-fill me-2"></i> Submit Request
               </button>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Thank You Modal -->
<div class="modal fade" id="thankYouModal" tabindex="-1" aria-labelledby="thankYouModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content p-4">
         <div class="modal-body text-center" id="thankYouSection">
            <h4>Project Submitted Successfully!</h4>
            <h3 class="fw-bold">Thank you! Your request has been submitted.</h3>
            <p>Your project has been received and is now under review by the <strong>Constructkaro</strong> team.</p>
            <h4>Your request has been submitted with ID: <span id="submissionIdTop"></span></h4>
            <h6>Expect up to 3 quotes from verified vendors within 24-48 hours.</h6>
            <div class="border rounded p-3 text-start mb-4" style="background-color: #f6f9fc;">
               <p><strong>⏱ Expected Response:</strong> Within 24 working hours</p>
               <p><strong>📞 Next Step:</strong> Our executive will reach out to you if needed</p>
               <p><strong>🗂 Submission ID:</strong> <span id="submissionIdBox"></span></p>
            </div>
            <div class="p-4 bg-light rounded mt-4 text-start mx-auto" style="max-width: 600px;">
               <h6 class="fw-semibold text-dark mb-3">What happens next?</h6>
               <ul class="mb-0 text-muted">
                  <li>We’ll match your requirements with verified vendors</li>
                  <li>Vendors will review your project and submit quotes</li>
                  <li>You’ll receive notifications via email and SMS</li>
                  <li>Compare quotes and choose the best vendor for your project</li>
               </ul>
            </div>
            <br>
            <button id="goToDashboardBtn" class="btn btn-warning">Go to My Dashboard</button>
            <p class="mt-3 text-muted small">
               Have questions? Contact our support team at<br>
               <a href="mailto:support@constructkaro.com">support@constructkaro.com</a>
            </p>
         </div>
      </div>
   </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- <script>
   $(document).ready(function () {
      // Ensure CSRF token is always attached
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
   
     $('#projectForm').on('submit', function (e) {
        e.preventDefault();
   
        let isValid = true;
   
        // ✅ Check normal required fields
        $('#projectForm [required]').each(function () {
           if (!$(this).val().trim()) {
                 $(this).focus();
                 isValid = false;
                 return false; // break loop
           }
        });
   
        if (!isValid) return;
   
        // ✅ Check if Agreement checkboxes are ticked
        if (!$('input[name="terms"]').is(':checked') || !$('input[name="no_bypass"]').is(':checked')) {
           alert("You must accept the Agreement & Terms before continuing.");
           return;
        }
   
        // ✅ If all good, set modal data
        $('#modalProjectName').text($('#project_name').val());
        $('#modalProjectLocation').text($('#project_location').val());
        $('#modalBudget').text($('#budget_range').val());
        $('#modalTimeline').text($('#expectedTimeline').val());
        $('#modalDescription').text($('#project_description').val());
   
        // ✅ Show modal
        $('#projectConfirmModal').modal('show');
     });
   
    // AJAX Submit after confirmation
    $('#confirmSubmitBtn').on('click', function () {
      let formData = new FormData($('#projectForm')[0]);
   
      $.ajax({
        url: '/project_details_save', // your backend route
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          $('#projectConfirmModal').modal('hide');
          $('#thankYouModal').modal('show');
   
          // Optional: Set dynamic submission ID
          $('#submissionId').text(response.submission_id || 'BX-2025-011');
        },
        error: function (xhr) {
          alert('Error submitting form. Please check console.');
          console.error(xhr.responseText);
        }
      });
    });
   
    // Redirect to Dashboard
    $('#goToDashboardBtn').on('click', function () {
     //  window.location.href = "{{route('Partner_Bids')}}";
              window.location.href = "{{ route('customer.dashboard') }}";
   
    });
   
   });
   
</script> -->
<script>
$(document).ready(function () {
    // ✅ Ensure CSRF token is always attached
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // ✅ Handle Project Form Submission
    $('#projectForm').on('submit', function (e) {
        e.preventDefault();

        let isValid = true;

        // 🔍 Check required fields
        $('#projectForm [required]').each(function () {
            if (!$(this).val().trim()) {
                $(this).focus();
                isValid = false;
                return false; // stop loop
            }
        });

        if (!isValid) return;

        // ✅ Check if all agreement checkboxes are ticked
        if (
            !$('input[name="terms_conditions"]').is(':checked') ||
            !$('input[name="privacy_policy"]').is(':checked') ||
            !$('input[name="no_bypass"]').is(':checked')
        ) {
            alert("You must accept all Agreement & Terms before continuing.");
            return;
        }

        // ✅ Populate confirmation modal
        $('#modalProjectName').text($('#project_name').val());
        $('#modalProjectLocation').text($('#project_location').val());
        $('#modalBudget').text($('#budget_range').val());
        $('#modalTimeline').text($('#expectedTimeline').val());
        $('#modalDescription').text($('#project_description').val());

        // ✅ Show confirmation modal
        $('#projectConfirmModal').modal('show');
    });

    // ✅ Confirm & Submit via AJAX
    $('#confirmSubmitBtn').on('click', function () {
        let formData = new FormData($('#projectForm')[0]);

        $.ajax({
            url: '/project_details_save', // backend route
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#projectConfirmModal').modal('hide');
                $('#thankYouModal').modal('show');

                // Display submission ID dynamically
               //  $('#submissionId').text(response.submission_id || 'BX-2025-011');
               $('#submissionIdTop').text(response.submission_id);
               $('#submissionIdBox').text(response.submission_id);
            },
            error: function (xhr) {
                alert('Error submitting form. Please check console.');
                console.error(xhr.responseText);
            }
        });
    });

    // ✅ Redirect to dashboard after success
    $('#goToDashboardBtn').on('click', function () {
        window.location.href = "{{ route('customer.dashboard') }}";
    });
});
</script>

@endsection