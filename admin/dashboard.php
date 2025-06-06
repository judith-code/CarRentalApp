<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Please log in as admin.'];
    header('Location: login.php');
    exit();
}

require_once '../config/db-connect.php';

try {
    // Fetch counts
    $total_customers = $pdo->query("SELECT COUNT(*) as count FROM customers")->fetch(PDO::FETCH_ASSOC)['count'];
    $total_cars = $pdo->query("SELECT COUNT(*) as count FROM cars")->fetch(PDO::FETCH_ASSOC)['count'];
    $total_rentals = $pdo->query("SELECT COUNT(*) as count FROM rentals")->fetch(PDO::FETCH_ASSOC)['count'];
    $total_rented = $pdo->query("SELECT COUNT(*) as count FROM cars WHERE status = 'rented'")->fetch(PDO::FETCH_ASSOC)['count'];
    $total_available = $pdo->query("SELECT COUNT(*) as count FROM cars WHERE status = 'available'")->fetch(PDO::FETCH_ASSOC)['count'];

    // Fetch recent rentals
    $query = "SELECT customers.first_name, rentals.*, cars.make, cars.model, cars.daily_rate
              FROM rentals 
              JOIN cars ON rentals.car_id = cars.id
              JOIN customers  ON rentals.customer_id = customers.id
              ORDER BY rentals.rental_date DESC LIMIT 5";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $recent_rentals = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Database error: Unable to fetch rentals.'];
    $recent_rentals = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Car Rental</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/bootstrap/css/footer.css">
    <link rel="stylesheet" href="../assets/bootstrap/css/admin-dash.css">
</head>
<body>
    <!-- admin navbar-->
    <?php require '../component/admin-navbar.php'; ?>

    <div class="container py-4">
        <!-- Dashboard Header -->
        <div class="dashboard-header text-center">
            <h1 class="mb-2 fw-bold"><i class="fas fa-tachometer-alt me-3"></i>Admin Dashboard</h1>
            <p class="mb-0 opacity-75">Manage your car rental business efficiently</p>
        </div>

        <!-- error & success message -->
        <?php if (isset($_SESSION['alert'])): ?>
            <div class="alert alert-<?= htmlspecialchars($_SESSION['alert']['type']) ?> alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['alert']['message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php unset($_SESSION['alert']); ?>
        <?php endif; ?>

        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <?php
            $stats = [
                ['title' => 'Total Customers', 'value' => $total_customers, 'icon' => 'fa-users', 'gradient' => 'gradient-primary'],
                ['title' => 'Total Cars', 'value' => $total_cars, 'icon' => 'fa-car', 'gradient' => 'gradient-success'],
                ['title' => 'Total Rentals', 'value' => $total_rentals, 'icon' => 'fa-file-alt', 'gradient' => 'gradient-warning'],
                ['title' => 'Cars Rented', 'value' => $total_rented, 'icon' => 'fa-key', 'gradient' => 'gradient-danger'],
                ['title' => 'Cars Available', 'value' => $total_available, 'icon' => 'fa-check-circle', 'gradient' => 'gradient-info']
            ];
            ?>

            <?php foreach ($stats as $stat): ?>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="card stat-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="stat-icon <?= $stat['gradient'] ?> mx-auto mb-3">
                                <i class="fas <?= $stat['icon'] ?> text-white"></i>
                            </div>
                            <h3 class="fw-bold text-dark mb-1"><?= htmlspecialchars($stat['value']) ?></h3>
                            <p class="text-muted mb-0 small"><?= $stat['title'] ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Recent Rentals Section -->
        <div class="rentals-section">
            <div class="d-flex align-items-center mb-4">
                <i class="fas fa-clock text-primary me-2"></i>
                <h2 class="mb-0 text-dark fw-bold">Recent Rentals</h2>
            </div>
            
            <div class="table-responsive">
                <table class="table table-modern table-hover">
                    <thead>
                        <tr>
                            <th><i class="fas fa-user me-2"></i>Customer</th>
                            <th><i class="fas fa-car me-2"></i>Vehicle</th>
                            <th><i class="fas fa-dollar-sign me-2"></i>Daily Rate</th>
                            <th><i class="fas fa-calendar-alt me-2"></i>Rental Date</th>
                            <th><i class="fas fa-calendar-check me-2"></i>Return Date</th>
                            <th><i class="fas fa-receipt me-2"></i>Total Cost</th>
                            <th><i class="fas fa-info-circle me-2"></i>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_rentals as $rental): ?>
                            <?php
                            $status = $rental['rental_status'];
                            $badgeClass = 'secondary';
                            if ($rental['rental_status'] === 'active') {
                                if (strtotime($rental['return_date']) <= time()) {
                                    $status = 'due for return';
                                    $badgeClass = 'warning';
                                } else {
                                    $badgeClass = 'primary';
                                }
                            } elseif ($rental['rental_status'] === 'completed') {
                                $badgeClass = 'success';
                            }
                            ?>
                            <tr>
                                <td class="fw-semibold"><?= htmlspecialchars($rental['first_name']) ?></td>
                                <td><?= htmlspecialchars($rental['make'] . ' ' . $rental['model']) ?></td>
                                <td class="fw-bold text-success">$<?= number_format($rental['daily_rate'], 2) ?></td>
                                <td><?= htmlspecialchars($rental['rental_date']) ?></td>
                                <td><?= htmlspecialchars($rental['return_date']) ?></td>
                                <td class="fw-bold text-primary">$<?= number_format($rental['total_cost'], 2) ?></td>
                                <td><span class="badge bg-<?= $badgeClass ?>"><?= htmlspecialchars($status) ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-4 d-flex gap-3 justify-content-center">
            <a href="manage-cars.php" class="btn btn-primary btn-modern">
                <i class="fas fa-car me-2"></i>Manage Cars
            </a>
            <a href="manage-rentals.php" class="btn btn-primary btn-modern">
                <i class="fas fa-file-alt me-2"></i>Manage Rentals
            </a>
            <a href="login.php" class="btn btn-danger btn-modern">
                <i class="fas fa-sign-out-alt me-2"></i>Logout
            </a>
        </div>
    </div>

    <?php require '../component/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>