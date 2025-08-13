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
    position: sticky;
    top: 0;
    height: 80px; /* ✅ FIXED HEIGHT */
    display: flex;
    align-items: center;
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

.search-container {
    position: relative;
    flex: 1;
    max-width: 420px;
    margin: 0 1.5rem;
}

.search-input {
    width: 100%;
    padding: 0.5rem 2.5rem;
    border-radius: 9999px;
    border: 1px solid #e2e8f0;
    font-size: 0.95rem;
    outline: none;
    background-color: #f9fafb;
}

.search-icon {
    position: absolute;
    left: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--slate-600);
}

.notification-btn {
    background: transparent;
    border: none;
    position: relative;
}

.notification-badge {
    position: absolute;
    top: -6px;
    right: -6px;
    background: #ef4444;
    color: #fff;
    font-size: 0.7rem;
    font-weight: 600;
    border-radius: 50%;
    padding: 0.15rem 0.4rem;
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
</style>

<header class="enhanced-header">
    <div class="container-xl">
        <!-- Left: Logo -->
        <a href="#" class="navbar-brand d-flex align-items-center gap-2">
            <img src="{{ asset('logo/bg.png') }}" alt="ConstructKaro Logo">
        </a>

        <!-- Center: Search -->
        <div class="search-container d-none d-md-flex">
            <i data-lucide="search" class="search-icon"></i>
            <input type="text" class="search-input" placeholder="Search projects, bids, or clients..." id="searchInput">
        </div>

        <!-- Right: Notification + User -->
        <div class="d-flex align-items-center" style="gap: 1rem;">
            <!-- Notifications -->
            <div class="position-relative">
                <button class="notification-btn" id="notificationBtn">
                    <i data-lucide="bell" style="width: 1.25rem; height: 1.25rem;"></i>
                    <span class="notification-badge" id="notificationBadge">2</span>
                </button>
            </div>

            <!-- Profile -->
            <div class="user-profile">
                <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=150&h=150&fit=crop"
                     alt="XYZ Construction" class="user-avatar">
                <div class="user-info d-none d-md-block">
                    <p class="mb-0" style="font-size: 0.875rem; font-weight: 600; color: var(--slate-900);">XYZ Construction</p>
                    <p class="mb-0" style="font-size: 0.75rem; color: var(--slate-600);">Vendor</p>
                </div>
                <button class="logout-btn" title="Logout" onclick="handleLogout()">
                    <i data-lucide="log-out" style="width: 1rem; height: 1rem;"></i>
                </button>
            </div>
        </div>
    </div>
</header>
