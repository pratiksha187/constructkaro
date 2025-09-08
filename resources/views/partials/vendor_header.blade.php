<style>
    
:root {
    --orange-500: #f97316;
    --orange-600: #ea580c;
    --slate-600: #64748b;
    --slate-900: #0f172a;
}


.enhanced-header {
    background: #ffffff;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
    z-index: 1000;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    height: 80px;
    display: flex;
    align-items: center;
}

body {
    padding-top: 80px;
}

.enhanced-header .container-xl {
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 100%;
}

.navbar-brand img {
    /* height: 190px; */
    height: 176px;
    width: 164px;
    object-fit: contain;
}
.navbar-brand img {
    margin-left: -107px  !important
}


.user-profile {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    background: #f1f5f9;
    border-radius: 9999px;
    padding: 0.25rem 0.75rem;
}

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 9999px;
    object-fit: cover;
}

.logout-btn {
    background: transparent;
    border: none;
    color: var(--slate-600);
}

.logout-btn:hover {
    color: var(--orange-600);
}
.right-section {
  display: flex;
  align-items: center;
  gap: 16px;
  text-align: right;
}
.partner-info p {
  margin: 0;
  font-size: 14px;
}
.profile-icon img {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.2);
  padding: 4px;
}
</style>

<header class="enhanced-header">
    <div class="container-xl">
       
        <!-- Left: Logo -->
        <a href="#" class="navbar-brand d-flex align-items-center gap-2">
            <img src="{{ asset('logo/bg.png') }}" alt="ConstructKaro Logo">
        </a>

        <!-- Right: Notification + User -->
        <div class="d-flex align-items-center" style="gap: 1rem;">
        
            <div class="right-section">
                <div class="partner-info">
                    <p><strong> ID:</strong>   {{ $data->vendor_code ?? '-' }}</p>
                    <p> {{ $data->name ?? '-' }}</p>
                </div>
              
                </div>
            </div>
        </div>
</header>
