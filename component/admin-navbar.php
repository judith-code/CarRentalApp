<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin-nav</title>
    <link rel="stylesheet" href="assets/bootstrap/css/adminnav.css">
</head>
<body>
    <div>
        <!-- component/admin-navbar.php -->
<div class="navbar-wrapper" id="adminNavbarWrapper">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="../index.php">
                <div class="brand-icon-wrapper me-2">
                    <i class="fas fa-car text-primary"></i>
                </div>
                <span class="brand-text">
                    <span class="text-primary">Car</span>Rental
                    <small class="text-muted ms-2 d-none d-md-inline">Admin Portal</small>
                </span>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbarNav" 
                    aria-controls="adminNavbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="adminNavbarNav">
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
                </ul>

                <div class="navbar-nav ms-auto d-flex align-items-center">
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

                    <a href="logout.php" class="btn btn-outline-light btn-sm d-flex align-items-center">
                        <i class="fas fa-sign-out-alt me-2"></i>
                        <span class="d-none d-md-inline">Logout</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>
</div>
    </div>
</body>
</html>