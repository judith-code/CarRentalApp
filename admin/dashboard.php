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

</head>
<body>
    <!-- admin navbar-->
    <?php require '../component/admin-navbar.php'; ?>

    <div class="container py-5">
    <!-- error & success message -->
        <?php if (isset($_SESSION['alert'])): ?>
            <div class="alert alert-<?= htmlspecialchars($_SESSION['alert']['type']) ?> alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['alert']['message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php unset($_SESSION['alert']); ?>
    <?php endif; ?>

    <h1 class="mb-4 text-primary fw-bold"><i class="fas fa-tachometer-alt me-2"></i>Admin Dashboard</h1>

    <!-- calculations on cars customers and rentals-->
    <div class="row g-4">
        <?php
        $stats = [
            ['title' => 'Total Customers', 'value' => $total_customers, 'icon' => 'fa-users', 'bg' => 'bg-primary'],
            ['title' => 'Total Cars', 'value' => $total_cars, 'icon' => 'fa-car', 'bg' => 'bg-success'],
            ['title' => 'Total Rentals', 'value' => $total_rentals, 'icon' => 'fa-file-alt', 'bg' => 'bg-warning'],
            ['title' => 'Cars Rented', 'value' => $total_rented, 'icon' => 'fa-key', 'bg' => 'bg-danger'],
            ['title' => 'Cars Available', 'value' => $total_available, 'icon' => 'fa-check-circle', 'bg' => 'bg-info']
        ];
        ?>

        <?php foreach ($stats as $stat): ?>
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3">
                            <span class="fs-2 text-white <?= $stat['bg'] ?> p-3 rounded-circle d-inline-block">
                                <i class="fas <?= $stat['icon'] ?>"></i>
                            </span>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1"><?= $stat['title'] ?></h6>
                            <h4 class="fw-semibold"><?= htmlspecialchars($stat['value']) ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- displaying recent rentals -->
    <h2 class="mt-5 mb-3 text-secondary">Recent Rentals</h2>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Customer</th>
                    <th>Car</th>
                    <th>Daily Rate</th>
                    <th>Rental Date</th>
                    <th>Return Date</th>
                    <th>Total Cost</th>
                    <th>Status</th>
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
                        <td><?= htmlspecialchars($rental['first_name']) ?></td>
                        <td><?= htmlspecialchars($rental['make'] . ' ' . $rental['model']) ?></td>
                        <td>$<?= number_format($rental['daily_rate'], 2) ?></td>
                        <td><?= htmlspecialchars($rental['rental_date']) ?></td>
                        <td><?= htmlspecialchars($rental['return_date']) ?></td>
                        <td>$<?= number_format($rental['total_cost'], 2) ?></td>
                        <td><span class="badge bg-<?= $badgeClass ?>"><?= htmlspecialchars($status) ?></span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- other actions -->
    <div class="mt-4 d-flex gap-3">
        <a href="manage-cars.php" class="btn btn-primary"><i class="fas fa-car me-1"></i> Manage Cars</a>
        <a href="manage-rentals.php" class="btn btn-primary"><i class="fas fa-file-alt me-1"></i> Manage Rentals</a>
        <a href="login.php" class="btn btn-danger"><i class="fas fa-sign-out-alt me-1"></i> Logout</a>
    </div>
</div>

    <?php require '../component/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>