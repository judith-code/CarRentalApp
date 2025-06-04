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
</head>
<body>
    <?php require '../component/admin-navbar.php'; ?>
    <div class="container py-5">
        <?php if (isset($_SESSION['alert'])): ?>
            <div class="alert alert-<?= htmlspecialchars($_SESSION['alert']['type']) ?> alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['alert']['message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['alert']); ?>
        <?php endif; ?>
        <h1 class="mb-4"><i class="fas fa-tachometer-alt"></i> Admin Dashboard</h1>
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Customers</h5>
                        <p class="card-text"><?= htmlspecialchars($total_customers) ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Cars</h5>
                        <p class="card-text"><?= htmlspecialchars($total_cars) ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Rentals</h5>
                        <p class="card-text"><?= htmlspecialchars($total_rentals) ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Cars Rented</h5>
                        <p class="card-text"><?= htmlspecialchars($total_rented) ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Cars Available</h5>
                        <p class="card-text"><?= htmlspecialchars($total_available) ?></p>
                    </div>
                </div>
            </div>
        </div>
        <h2 class="mt-5">Recent Rentals</h2>
        <table class="table table-bordered">
            <thead>
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
                    if ($rental['rental_status'] === 'active' && strtotime($rental['return_date']) <= time()) {
                        $status = 'due for return';
                    }
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($rental['first_name']) ?></td>
                        <td><?= htmlspecialchars($rental['make'] . ' ' . $rental['model']) ?></td>
                        <td>$<?= htmlspecialchars(number_format($rental['daily_rate'], 2)) ?></td>
                        <td><?= htmlspecialchars($rental['rental_date']) ?></td>
                        <td><?= htmlspecialchars($rental['return_date']) ?></td>
                        <td>$<?= htmlspecialchars(number_format($rental['total_cost'], 2)) ?></td>
                        <td><?= htmlspecialchars($status) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="mt-3">
            <a href="manage-cars.php" class="btn btn-primary">Manage Cars</a>
            <a href="manage-rentals.php" class="btn btn-primary">Manage Rentals</a>
            <a href="login.php" class="btn btn-secondary">Logout</a>
        </div>
    </div>
    <?php require '../component/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>