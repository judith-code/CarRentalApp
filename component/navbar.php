<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enhanced Navbar - Car Rental</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/bootstrap/css/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-..." crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/bootstrap/css/navbar.css">
</head>
<body>
    <!-- component/navbar.php -->
     <!-- component/navbar.php -->
<div class="navbar-wrapper" id="navbarWrapper">
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-car brand-icon"></i> Car Rental
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : '' ?>" href="index.php">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'cars.php' ? 'active' : '' ?>" href="cars.php">
                            <i class="fas fa-car"></i> Rent a Car
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'contact.php' ? 'active' : '' ?>" href="contact.php">
                            <i class="fas fa-envelope"></i> Contact
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'about.php' ? 'active' : '' ?>" href="about.php">
                            <i class="fas fa-info-circle"></i> About
                        </a>
                    </li>
                  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle <?= in_array(basename($_SERVER['PHP_SELF']), ['terms.php', 'login.php', 'admin/login.php']) ? 'active' : '' ?>" 
       href="#" id="moreDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-ellipsis-h"></i> More
    </a>
    <ul class="dropdown-menu" aria-labelledby="moreDropdown">
        <li>
            <a class="dropdown-item <?= basename($_SERVER['PHP_SELF']) === 'terms.php' ? 'active' : '' ?>" href="terms.php">
                <i class="fas fa-file-alt"></i> T&C
            </a>
        </li>
        <li>
            <a class="dropdown-item <?= basename($_SERVER['PHP_SELF']) === 'login.php' ? 'active' : '' ?>" href="login.php">
                <i class="fas fa-sign-in-alt"></i> Login
            </a>
        </li>
        <li>
            <a class="dropdown-item <?= basename($_SERVER['PHP_SELF']) === 'admin/login.php' ? 'active' : '' ?>" href="admin/login.php">
                <i class="fas fa-user-shield"></i> Admin
            </a>
        </li>
    </ul>
</li>

                </ul>
                <a href="cars.php" class="btn nav-cta">
                    <i class="fas fa-calendar-check"></i> Rent Now
                </a>
            </div>
        </div>
    </nav>
</div>


   
</body>
</html>