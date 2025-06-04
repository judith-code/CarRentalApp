<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Please log in as admin.'];
    header('Location: login.php');
    exit();
}

require_once '../config/db-connect.php';

try {
    // Fetch total earnings
    $query = "SELECT SUM(total_cost) as total_earnings FROM rentals";
    $stmt = $pdo->query($query);
    $total_earnings = $stmt->fetch(PDO::FETCH_ASSOC)['total_earnings'] ?? 0;

    // Fetch rentals
    $query = "SELECT rentals.*, customers.first_name, customers.email, cars.make, cars.model FROM rentals JOIN cars ON rentals.car_id = cars.id JOIN customers ON rentals.customer_id = customers.id";
    $stmt = $pdo->query($query);
    $rentals = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Database error: Unable to fetch rentals.'];
    $total_earnings = 0;
    $rentals = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Rentals - Car Rental</title>
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
        <h1 class="mb-4"><i class="fas fa-list"></i> Manage Rentals</h1>
        <h3 class="mb-4">Total Earnings: $<?= number_format($total_earnings, 2) ?></h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Car</th>
                    <th>Rental Date</th>
                    <th>Return Date</th>
                    <th>Total Cost</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rentals as $rental): ?>
                    <?php
                    $status = $rental['rental_status'];
                    if ($rental['rental_status'] === 'active' && strtotime($rental['return_date']) <= time()) {
                        $status = 'due for return';
                    }
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($rental['first_name']) ?></td>
                        <td><?= htmlspecialchars($rental['email']) ?></td>
                        <td><?= htmlspecialchars($rental['make'] . ' ' . $rental['model']) ?></td>
                        <td><?= htmlspecialchars($rental['rental_date']) ?></td>
                        <td><?= htmlspecialchars($rental['return_date']) ?></td>
                        <td>$<?= htmlspecialchars(number_format($rental['total_cost'], 2)) ?></td>
                        <td><?= htmlspecialchars($status) ?></td>
                        <td>
                            <?php if ($rental['rental_status'] === 'active'): ?>
                                <a href="mark_returned.php?rental_id=<?= htmlspecialchars($rental['id']) ?>&car_id=<?= htmlspecialchars($rental['car_id']) ?>" 
                                   class="btn btn-primary">
                                   Mark as Returned
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php require '../component/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>