<?php
session_start();

// Validate and fetch car ID
$selectedCarId = $_GET['id'] ?? null;
if (!isset($selectedCarId) || !is_numeric($selectedCarId) || $selectedCarId > 1000) {
    header("Location: cars.php");
    exit();
}

require_once 'config/db-connect.php';
$sql = "SELECT * FROM cars WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$selectedCarId]);
$selectedCar = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$selectedCar) {
    header("Location: cars.php");
    exit();
}

// Show success/error messages
$successMessage = $_SESSION['hire_success'] ?? null;
$errorMessage = $_SESSION['hire_error'] ?? null;
unset($_SESSION['hire_success'], $_SESSION['hire_error']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($selectedCar['make'] . ' ' . $selectedCar['model']) ?> - Car Details</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/bootstrap/css/car.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --danger-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            --shadow-soft: 0 10px 30px rgba(0,0,0,0.1);
            --shadow-hover: 0 15px 40px rgba(0,0,0,0.15);
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .hero-section {
            background: var(--primary-gradient);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="white" opacity="0.1"><polygon points="0,0 1000,100 1000,0"/></svg>');
            background-size: cover;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .enhanced-card {
            background: white;
            border-radius: 20px;
            box-shadow: var(--shadow-soft);
            border: none;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .enhanced-card:hover {
            box-shadow: var(--shadow-hover);
            transform: translateY(-5px);
        }

        .car-image-container {
            position: relative;
            overflow: hidden;
            border-radius: 15px;
            height: 300px;
        }

        .car-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .car-image:hover {
            transform: scale(1.05);
        }

        .car-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--success-gradient);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .car-badge.unavailable {
            background: var(--danger-gradient);
        }

        .detail-item {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 0.5rem;
            border-left: 4px solid var(--primary-gradient);
            transition: all 0.3s ease;
        }

        .detail-item:hover {
            background: #e9ecef;
            transform: translateX(5px);
        }

        .detail-icon {
            width: 24px;
            margin-right: 10px;
            color: #667eea;
        }

        .price-highlight {
            background: var(--success-gradient);
            color: white;
            padding: 1rem;
            border-radius: 10px;
            text-align: center;
            margin: 1rem 0;
        }

        .price-highlight .price {
            font-size: 2rem;
            font-weight: bold;
        }

        .hire-form {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 2rem;
            border-radius: 20px;
            color: white;
        }

        .form-control {
            border-radius: 10px;
            border: 2px solid transparent;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .btn-hire {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            border: none;
            padding: 1rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }

        .btn-hire:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(79, 172, 254, 0.4);
        }

        .alert-enhanced {
            border-radius: 15px;
            border: none;
            padding: 1.5rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .alert-success-enhanced {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .alert-danger-enhanced {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            color: white;
        }

        .alert-enhanced::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: rgba(255,255,255,0.5);
        }

        .alert-icon {
            font-size: 1.5rem;
            margin-right: 1rem;
        }

        .back-btn {
            background: rgba(255,255,255,0.1);
            border: 2px solid rgba(255,255,255,0.3);
            color: white;
            border-radius: 50px;
            padding: 0.5rem 1.5rem;
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            background: rgba(255,255,255,0.2);
            border-color: rgba(255,255,255,0.5);
            color: white;
            transform: translateY(-2px);
        }

        .section-title {
            position: relative;
            margin-bottom: 2rem;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 50px;
            height: 3px;
            background: var(--primary-gradient);
            border-radius: 2px;
        }

        @media (max-width: 768px) {
            .hero-section {
                padding: 1rem 0;
            }
            
            .car-image-container {
                height: 250px;
                margin-bottom: 2rem;
            }
            
            .hire-form {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <?php require 'component/navbar.php'; ?>

    <section class="hero-section">
        <div class="container hero-content">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="display-4 fw-bold mb-2">
                        <?= htmlspecialchars($selectedCar['make'] . ' ' . $selectedCar['model']) ?>
                    </h1>
                    <p class="lead mb-0">
                        <i class="fas fa-calendar-alt me-2"></i><?= htmlspecialchars($selectedCar['year']) ?>
                    </p>
                </div>
                <a href="cars.php" class="btn back-btn">
                    <i class="fas fa-arrow-left me-2"></i>Back to Cars
                </a>
            </div>
        </div>
    </section>

    <div class="container pb-5">
        <!-- Success/Error Messages -->
        <?php if ($successMessage): ?>
            <div class="alert alert-enhanced alert-success-enhanced d-flex align-items-center" role="alert">
                <i class="fas fa-check-circle alert-icon"></i>
                <div>
                    <h5 class="mb-1">Success!</h5>
                    <p class="mb-0"><?= htmlspecialchars($successMessage) ?></p>
                </div>
                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if ($errorMessage): ?>
            <div class="alert alert-enhanced alert-danger-enhanced d-flex align-items-center" role="alert">
                <i class="fas fa-exclamation-triangle alert-icon"></i>
                <div>
                    <h5 class="mb-1">Error!</h5>
                    <p class="mb-0"><?= htmlspecialchars($errorMessage) ?></p>
                </div>
                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Car Details Card -->
        <div class="enhanced-card p-4 mb-4">
            <h2 class="section-title">Vehicle Details</h2>
            <div class="row">
                <div class="col-lg-6">
                    <div class="car-image-container">
                        <img src="carimages/<?= htmlspecialchars($selectedCar['image']); ?>" 
                             class="car-image" 
                             alt="<?= htmlspecialchars($selectedCar['make'] . ' ' . $selectedCar['model']) ?>">
                        <div class="car-badge <?= $selectedCar['status'] !== 'available' ? 'unavailable' : '' ?>">
                            <?= ucfirst(htmlspecialchars($selectedCar['status'])) ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="detail-item">
                        <i class="fas fa-car detail-icon"></i>
                        <strong>Brand:</strong> <?= htmlspecialchars($selectedCar['make']) ?>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-cogs detail-icon"></i>
                        <strong>Model:</strong> <?= htmlspecialchars($selectedCar['model']) ?>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-calendar-alt detail-icon"></i>
                        <strong>Year:</strong> <?= htmlspecialchars($selectedCar['year']) ?>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-info-circle detail-icon"></i>
                        <strong>Status:</strong> <?= ucfirst(htmlspecialchars($selectedCar['status'])) ?>
                    </div>
                    
                    <div class="price-highlight">
                        <div class="price">$<?= htmlspecialchars($selectedCar['daily_rate']) ?></div>
                        <div>per day</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hire Form -->
        <?php if ($selectedCar['status'] === 'available'): ?>
        <div class="enhanced-card">
            <div class="hire-form">
                <h3 class="text-center mb-4">
                    <i class="fas fa-key me-2"></i>Reserve This Vehicle
                </h3>
                <form action="processes/hire-process.php" method="post" id="hireForm">
                    <input type="hidden" name="car_id" value="<?= $selectedCarId ?>">
                    <input type="hidden" name="daily_rate" value="<?= htmlspecialchars($selectedCar['daily_rate']) ?>">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="first_name" class="form-label">
                                <i class="fas fa-user me-2"></i>First Name
                            </label>
                            <input type="text" name="first_name" id="first_name" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="last_name" class="form-label">
                                <i class="fas fa-user me-2"></i>Last Name
                            </label>
                            <input type="text" name="last_name" id="last_name" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope me-2"></i>Email Address
                            </label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">
                                <i class="fas fa-phone me-2"></i>Phone Number
                            </label>
                            <input type="tel" name="phone" id="phone" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="return_date" class="form-label">
                            <i class="fas fa-calendar-check me-2"></i>Return Date
                        </label>
                        <input type="date" name="return_date" id="return_date" class="form-control" required 
                               min="<?= date('Y-m-d', strtotime('+1 day')); ?>" 
                               max="<?= date('Y-m-d', strtotime('+7 days')) ?>">
                        <div class="form-text text-light mt-2">
                            <i class="fas fa-info-circle me-1"></i>
                            Select a return date between tomorrow and 6 days from now
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-hire btn-lg">
                            <i class="fas fa-credit-card me-2"></i>Confirm Reservation
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <?php else: ?>
        <div class="enhanced-card p-4 text-center">
            <div class="mb-4">
                <i class="fas fa-exclamation-triangle text-warning" style="font-size: 4rem;"></i>
            </div>
            <h3 class="text-muted mb-3">Vehicle Unavailable</h3>
            <p class="lead text-muted mb-4">
                This vehicle is currently not available for hire. Please check back later or browse our other available vehicles.
            </p>
            <a href="cars.php" class="btn btn-primary">
                <i class="fas fa-search me-2"></i>Browse Available Cars
            </a>
        </div>
        <?php endif; ?>
    </div>

    <?php require 'component/footer.php'; ?>
    
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                if (alert.querySelector('.btn-close')) {
                    alert.querySelector('.btn-close').click();
                }
            });
        }, 5000);

        // Form validation enhancement
        document.getElementById('hireForm')?.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
            submitBtn.disabled = true;
        });

        // Return date validation
        const returnDateInput = document.getElementById('return_date');
        if (returnDateInput) {
            returnDateInput.addEventListener('change', function() {
                const selectedDate = new Date(this.value);
                const today = new Date();
                const maxDate = new Date();
                maxDate.setDate(today.getDate() + 30);
                
                if (selectedDate <= today) {
                    this.setCustomValidity('Return date must be at least tomorrow');
                } else if (selectedDate > maxDate) {
                    this.setCustomValidity('Return date cannot be more than 30 days from today');
                } else {
                    this.setCustomValidity('');
                }
            });
        }
    </script>
</body>
</html>