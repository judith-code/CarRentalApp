<!-- component/admin-navbar.php -->
<div class="navbar-wrapper" id="adminNavbarWrapper">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container-fluid">
            <!-- Brand with enhanced styling -->
            <a class="navbar-brand fw-bold d-flex align-items-center" href="../index.php">
                <div class="brand-icon-wrapper me-2">
                    <i class="fas fa-car text-primary"></i>
                </div>
                <span class="brand-text">
                    <span class="text-primary">Car</span>Rental
                    <small class="text-muted ms-2 d-none d-md-inline">Admin Portal</small>
                </span>
            </a>

            <!-- Mobile toggle button -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbarNav" 
                    aria-controls="adminNavbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="adminNavbarNav">
                <!-- Navigation items -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link px-3 py-2 rounded-pill mx-1 <?= basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'active bg-primary text-white' : '' ?>" 
                           href="dashboard.php">
                            <i class="fas fa-tachometer-alt me-2"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 py-2 rounded-pill mx-1 <?= basename($_SERVER['PHP_SELF']) === 'manage-cars.php' ? 'active bg-primary text-white' : '' ?>" 
                           href="manage-cars.php">
                            <i class="fas fa-car me-2"></i>
                            <span>Manage Cars</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 py-2 rounded-pill mx-1 <?= basename($_SERVER['PHP_SELF']) === 'manage-rentals.php' ? 'active bg-primary text-white' : '' ?>" 
                           href="manage-rentals.php">
                            <i class="fas fa-list me-2"></i>
                            <span>Manage Rentals</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 py-2 rounded-pill mx-1 <?= basename($_SERVER['PHP_SELF']) === 'manage-users.php' ? 'active bg-primary text-white' : '' ?>" 
                           href="manage-users.php">
                            <i class="fas fa-users me-2"></i>
                            <span>Users</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 py-2 rounded-pill mx-1 <?= basename($_SERVER['PHP_SELF']) === 'reports.php' ? 'active bg-primary text-white' : '' ?>" 
                           href="reports.php">
                            <i class="fas fa-chart-bar me-2"></i>
                            <span>Reports</span>
                        </a>
                    </li>
                </ul>

                <!-- Right side items -->
                <div class="navbar-nav ms-auto d-flex align-items-center">
                    <!-- Notifications dropdown -->
                    <div class="nav-item dropdown me-3">
                        <a class="nav-link position-relative" href="#" id="notificationDropdown" role="button" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-bell text-light"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                3
                                <span class="visually-hidden">unread notifications</span>
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="notificationDropdown">
                            <li><h6 class="dropdown-header">Notifications</h6></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-info-circle text-info me-2"></i>New rental request</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-exclamation-triangle text-warning me-2"></i>Car maintenance due</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-check-circle text-success me-2"></i>Rental completed</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-center" href="#">View all notifications</a></li>
                        </ul>
                    </div>

                    <!-- User profile dropdown -->
                    <div class="nav-item dropdown me-3">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" 
                           role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-avatar me-2">
                                <i class="fas fa-user-circle fs-5 text-light"></i>
                            </div>
                            <span class="d-none d-md-inline text-light">Admin</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                            <li><h6 class="dropdown-header">Account</h6></li>
                            <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="settings.php"><i class="fas fa-cog me-2"></i>Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                        </ul>
                    </div>

                    <!-- Quick logout button (alternative) -->
                    <a href="logout.php" class="btn btn-outline-light btn-sm d-flex align-items-center">
                        <i class="fas fa-sign-out-alt me-2"></i>
                        <span class="d-none d-md-inline">Logout</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>
</div>

<!-- Custom CSS for enhanced styling -->
<style>
.navbar-wrapper {
    position: sticky;
    top: 0;
    z-index: 1020;
}

.navbar-brand {
    font-size: 1.5rem;
    transition: all 0.3s ease;
}

.navbar-brand:hover {
    transform: translateY(-2px);
}

.brand-icon-wrapper {
    width: 40px;
    height: 40px;
    background: rgba(13, 110, 253, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.navbar-brand:hover .brand-icon-wrapper {
    background: rgba(13, 110, 253, 0.2);
    transform: rotate(360deg);
}

.nav-link {
    transition: all 0.3s ease;
    position: relative;
    font-weight: 500;
}

.nav-link:not(.active):hover {
    background-color: rgba(255, 255, 255, 0.1) !important;
    transform: translateY(-2px);
    color: #fff !important;
}

.nav-link.active {
    font-weight: 600;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.dropdown-menu {
    border: none;
    border-radius: 0.5rem;
    margin-top: 0.5rem;
    min-width: 220px;
}

.dropdown-item {
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
}

.dropdown-item:hover {
    background-color: rgba(13, 110, 253, 0.1);
    transform: translateX(5px);
}

.user-avatar {
    width: 35px;
    height: 35px;
    background: linear-gradient(45deg, #007bff, #0056b3);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-outline-light {
    border-radius: 25px;
    padding: 0.5rem 1rem;
    transition: all 0.3s ease;
}

.btn-outline-light:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

/* Mobile responsiveness */
@media (max-width: 991.98px) {
    .navbar-nav .nav-link {
        margin: 0.25rem 0;
        border-radius: 0.5rem;
    }
    
    .navbar-nav .nav-link.active {
        margin: 0.25rem 0;
    }
    
    .dropdown-menu {
        margin-top: 0;
        border-radius: 0.5rem;
    }
}

/* Animation for mobile toggle */
.navbar-toggler {
    transition: all 0.3s ease;
}

.navbar-toggler:focus {
    box-shadow: none;
    border-color: transparent;
}

.navbar-toggler:hover {
    background-color: rgba(255, 255, 255, 0.1);
}

/* Notification badge animation */
.badge {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        transform: translate(-50%, -50%) scale(1);
    }
    50% {
        transform: translate(-50%, -50%) scale(1.1);
    }
    100% {
        transform: translate(-50%, -50%) scale(1);
    }
}

/* Smooth scrolling for sticky navbar */
html {
    scroll-padding-top: 80px;
}
</style>