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

        /* Responsive Design */
        @media (max-width: 1200px) {
            .search-container {
                max-width: 24rem;
            }
        }


        /* Utility Classes */
        .text-gradient-orange {
            background: linear-gradient(135deg, var(--orange-500), var(--red-500), var(--pink-500));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
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