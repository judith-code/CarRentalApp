<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Please log in as admin.'];
    header('Location: login.php');
    exit();
}

require_once '../config/db-connect.php';

try {
    // Fetching total earnings 
    $query = "SELECT SUM(total_cost) as total_earnings FROM rentals";
    $stmt = $pdo->query($query);
    $total_earnings = $stmt->fetch(PDO::FETCH_ASSOC)['total_earnings'] ?? 0;

    // Fetching rental statistics
    $query = "SELECT 
                COUNT(*) as total_rentals,
                SUM(CASE WHEN rental_status = 'active' THEN 1 ELSE 0 END) as active_rentals,
                SUM(CASE WHEN rental_status = 'completed' THEN 1 ELSE 0 END) as completed_rentals,
                SUM(CASE WHEN rental_status = 'active' AND return_date < CURDATE() THEN 1 ELSE 0 END) as overdue_rentals
              FROM rentals";
    $stmt = $pdo->query($query);
    $stats = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetching all rentals from database
    $query = "SELECT rentals.*, customers.first_name, customers.last_name, customers.email, customers.phone, 
                     cars.make, cars.model, cars.year 
              FROM rentals 
              JOIN cars ON rentals.car_id = cars.id 
              JOIN customers ON rentals.customer_id = customers.id 
              ORDER BY rentals.rental_date DESC";
    $stmt = $pdo->query($query);
    $rentals = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Calculate earnings for current month
    $query = "SELECT SUM(total_cost) as monthly_earnings 
              FROM rentals 
              WHERE MONTH(rental_date) = MONTH(CURDATE()) AND YEAR(rental_date) = YEAR(CURDATE())";
    $stmt = $pdo->query($query);
    $monthly_earnings = $stmt->fetch(PDO::FETCH_ASSOC)['monthly_earnings'] ?? 0;

} catch (PDOException $e) {
    $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Database error: Unable to fetch rentals.'];
    $total_earnings = 0;
    $monthly_earnings = 0;
    $rentals = [];
    $stats = ['total_rentals' => 0, 'active_rentals' => 0, 'completed_rentals' => 0, 'overdue_rentals' => 0];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Management - Car Rental Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/bootstrap/css/manage-rentals.css">    
</head>
<body>
    <?php require '../component/admin-navbar.php'; ?>
    
    <!-- header section -->
    <div class="page-header">
        <div class="container">
            <h1>
                <i class="fas fa-chart-line"></i>
                Rental Management
            </h1>
            <p class="subtitle">Monitor your rental operations and track business performance</p>
        </div>
    </div>

    <div class="container pb-5">
        <!-- Alert Messages -->
        <?php if (isset($_SESSION['alert'])): ?>
            <div class="alert alert-<?= htmlspecialchars($_SESSION['alert']['type']) ?> alert-dismissible fade show" role="alert">
                <i class="fas fa-<?= $_SESSION['alert']['type'] === 'success' ? 'check-circle' : 'exclamation-triangle' ?> me-2"></i>
                <?= htmlspecialchars($_SESSION['alert']['message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['alert']); ?>
        <?php endif; ?>

        <!-- Analytics Cards -->
        <div class="analytics-grid">
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="metric-card earnings">
                        <div class="metric-icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <h3 class="metric-value">$<?= number_format($total_earnings, 0) ?></h3>
                        <p class="metric-label">Total Revenue</p>
                        <div class="metric-change">
                            <i class="fas fa-calendar-month"></i>
                            <span>$<?= number_format($monthly_earnings, 0) ?> this month</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="metric-card active">
                        <div class="metric-icon">
                            <i class="fas fa-key"></i>
                        </div>
                        <h3 class="metric-value"><?= $stats['active_rentals'] ?></h3>
                        <p class="metric-label">Active Rentals</p>
                        <div class="metric-change">
                            <i class="fas fa-car"></i>
                            <span>Currently on road</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="metric-card completed">
                        <div class="metric-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h3 class="metric-value"><?= $stats['completed_rentals'] ?></h3>
                        <p class="metric-label">Completed</p>
                        <div class="metric-change">
                            <i class="fas fa-handshake"></i>
                            <span>Successfully returned</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="metric-card overdue">
                        <div class="metric-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <h3 class="metric-value"><?= $stats['overdue_rentals'] ?></h3>
                        <p class="metric-label">Overdue</p>
                        <div class="metric-change">
                            <i class="fas fa-clock"></i>
                            <span>Require attention</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- showing rentals in a table -->
        <div class="rentals-section">
            <div class="section-header">
                <h2>
                    <i class="fas fa-list-alt"></i>
                    Rental Transactions
                </h2>
                <p class="subtitle">Manage all rental bookings and track their status</p>
            </div>
            
            <?php if (empty($rentals)): ?>
                <div class="empty-state">
                    <i class="fas fa-calendar-times"></i>
                    <h3>No Rentals Found</h3>
                    <p>There are currently no rental transactions in the system.</p>
                </div>
            <?php else: ?>
                <div class="table-container">
                    <table class="table rentals-table">
                        <thead>
                            <tr>
                                <th><i class="fas fa-user me-1"></i>Customer</th>
                                <th><i class="fas fa-car me-1"></i>Vehicle</th>
                                <th><i class="fas fa-calendar-plus me-1"></i>Rental Date</th>
                                <th><i class="fas fa-calendar-check me-1"></i>Return Date</th>
                                <th><i class="fas fa-dollar-sign me-1"></i>Total Cost</th>
                                <th><i class="fas fa-info-circle me-1"></i>Status</th>
                                <th><i class="fas fa-cog me-1"></i>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rentals as $rental): ?>
                                <?php
                                $status = $rental['rental_status'];
                                $is_overdue = false;
                                if ($rental['rental_status'] === 'active' && strtotime($rental['return_date']) <= time()) {
                                    $status = 'overdue';
                                    $is_overdue = true;
                                }
                                ?>
                                <tr>
                                    <td>
                                        <div class="customer-info">
                                            <div class="customer-name">
                                                <?= htmlspecialchars($rental['first_name'] . ' ' . $rental['last_name']) ?>
                                            </div>
                                            <div class="customer-email">
                                                <i class="fas fa-envelope me-1"></i>
                                                <?= htmlspecialchars($rental['email']) ?>
                                            </div>
                                            <?php if (!empty($rental['phone'])): ?>
                                                <div class="customer-email">
                                                    <i class="fas fa-phone me-1"></i>
                                                    <?= htmlspecialchars($rental['phone']) ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="car-info">
                                            <div class="car-name">
                                                <?= htmlspecialchars($rental['make'] . ' ' . $rental['model']) ?>
                                            </div>
                                            <div class="car-year">
                                                <i class="fas fa-calendar me-1"></i>
                                                <?= htmlspecialchars($rental['year']) ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="date-display">
                                            <?= date('M j, Y', strtotime($rental['rental_date'])) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="date-display">
                                            <?= date('M j, Y', strtotime($rental['return_date'])) ?>
                                            <?php if ($is_overdue): ?>
                                                <div class="text-danger small mt-1">
                                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                                    <?= ceil((time() - strtotime($rental['return_date'])) / 86400) ?> days overdue
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="cost-display">
                                            $<?= number_format($rental['total_cost'], 2) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge status-<?= $status ?>">
                                            <?php if ($status === 'active'): ?>
                                                <i class="fas fa-circle"></i>
                                                Active
                                            <?php elseif ($status === 'completed'): ?>
                                                <i class="fas fa-check"></i>
                                                Completed
                                            <?php elseif ($status === 'overdue'): ?>
                                                <i class="fas fa-exclamation-triangle"></i>
                                                Overdue
                                            <?php endif; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($rental['rental_status'] === 'active'): ?>
                                            <button class="btn btn-return btn-sm" 
                                                    onclick="confirmReturn(<?= $rental['id'] ?>, <?= $rental['car_id'] ?>, '<?= htmlspecialchars($rental['first_name']) ?>', '<?= htmlspecialchars($rental['make'] . ' ' . $rental['model']) ?>')">
                                                <i class="fas fa-undo"></i>
                                                Mark Returned
                                            </button>
                                        <?php else: ?>
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i>
                                                Returned
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php require '../component/footer.php'; ?>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmReturn(rentalId, carId, customerName, carName) {
            const message = `Mark rental as returned?\n\nCustomer: ${customerName}\nVehicle: ${carName}\n\nThis will make the vehicle available for new rentals.`;
            
            if (confirm(message)) {
                window.location.href = `mark-return.php?rental_id=${rentalId}&car_id=${carId}`;
            }
        }

        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });

            // Add animation to overdue items
            const overdueItems = document.querySelectorAll('.status-overdue');
            overdueItems.forEach(item => {
                const row = item.closest('tr');
                if (row) {
                    row.style.borderLeft = '4px solid #ef4444';
                }
            });
        });

        // Add some interactivity to metric cards
        document.querySelectorAll('.metric-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-4px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
    </script>
</body>
</html>