<?php
session_start();
require_once 'config/db-connect.php';

if (!isset($_SESSION['customer_id'])) {
    $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Please log in to view your rentals.'];
    header('Location: login.php');
    exit();
}
$customer_id = $_SESSION['customer_id'];
$query = "SELECT customers.first_name, customers.last_name, customers.email, customers.phone, rentals.*,cars.make, cars.model, cars.daily_rate, cars.status FROM rentals JOIN cars ON rentals.car_id = cars.id JOIN customers ON rentals.customer_id = customers.id WHERE rentals.customer_id = :customer_id";

$stmt = $pdo->prepare($query);
$stmt->execute(['customer_id' => $customer_id]);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get customer info for welcome message
$customer_query = "SELECT first_name, last_name FROM customers WHERE id = :customer_id";
$customer_stmt = $pdo->prepare($customer_query);
$customer_stmt->execute(['customer_id' => $customer_id]);
$customer_info = $customer_stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Rentals - Car Rental Dashboard</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/bootstrap/css/myrental.css">
</head>
<body>
    <?php require 'component/navbar.php'; ?>
    
    <div class="container-fluid">
        <div class="dashboard-container">
            <!-- header section on customers dashboard-->
            <div class="dashboard-header">
                <div class="welcome-section">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1 class="welcome-title">
                                <i class="fas fa-car me-2"></i>
                                Welcome back, <?= htmlspecialchars($customer_info['first_name'] ?? 'Valued Customer') ?>!
                            </h1>
                            <p class="welcome-subtitle">Manage your car rentals and track your booking history</p>
                        </div>
                        <div class="col-md-4">
                            <div class="stats-card">
                                <span class="stats-number"><?= count($result) ?></span>
                                <span class="stats-label">Total Rentals</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- displaying content on customers rentsls  -->
            <div class="content-section">
                <h2 class="section-title">
                    <i class="fas fa-history"></i>
                    My Rental History
                </h2>

                <?php if ($result): ?>
                    <div class="rentals-table">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th><i class="fas fa-car me-2"></i>Vehicle</th>
                                        <th><i class="fas fa-dollar-sign me-2"></i>Daily Rate</th>
                                        <th><i class="fas fa-calendar-alt me-2"></i>Rental Date</th>
                                        <th><i class="fas fa-calendar-check me-2"></i>Return Date</th>
                                        <th><i class="fas fa-calculator me-2"></i>Total Cost</th>
                                        <th><i class="fas fa-info-circle me-2"></i>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($result as $row): ?>
                                        <tr>
                                            <td>
                                                <div class="car-info">
                                                    <div class="car-icon">
                                                        <i class="fas fa-car"></i>
                                                    </div>
                                                    <div>
                                                        <strong><?= htmlspecialchars($row['make'] . ' ' . $row['model']) ?></strong>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="price-tag">$<?= htmlspecialchars(number_format($row['daily_rate'], 2)) ?></span>
                                            </td>
                                            <td><?= htmlspecialchars(date('M d, Y', strtotime($row['rental_date']))) ?></td>
                                            <td><?= htmlspecialchars(date('M d, Y', strtotime($row['return_date']))) ?></td>
                                            <td>
                                                <strong class="price-tag">$<?= htmlspecialchars(number_format($row['total_cost'], 2)) ?></strong>
                                            </td>
                                            <td>
                                                <?php
                                                $status = strtolower($row['status']);
                                                $statusClass = 'status-completed';
                                                if ($status === 'active' || $status === 'ongoing') {
                                                    $statusClass = 'status-active';
                                                } elseif ($status === 'cancelled') {
                                                    $statusClass = 'status-cancelled';
                                                }
                                                ?>
                                                <span class="status-badge <?= $statusClass ?>">
                                                    <?= htmlspecialchars(ucfirst($row['status'])) ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="rentals-table">
                        <div class="empty-state">
                            <i class="fas fa-car"></i>
                            <h3>No Rentals Yet</h3>
                            <p>You haven't made any car rentals yet. Start exploring our available vehicles!</p>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Buttons for other actions-->
                <div class="action-buttons">
                    <a href="cars.php" class="btn-custom btn-primary-custom">
                        <i class="fas fa-plus"></i>
                        Book New Rental
                    </a>
                    <a href="login.php" class="btn-custom btn-secondary-custom">
                        <i class="fas fa-sign-out-alt"></i>
                        Log Out
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php require 'component/footer.php'; ?>
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>