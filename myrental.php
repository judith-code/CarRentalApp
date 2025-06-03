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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
</head>
<body>
        <?php require 'component/navbar.php'; ?>
    <h2>My Rentals</h2>
<table class="table">
    <thead>
        <tr>
            <th>Car Name</th>
            <th>Daily Rate</th>
            <th>Rental Date</th>
            <th>Return Date</th>
            <th>Total Cost</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result): ?>
            <?php foreach ($result as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['make'] . ' ' . $row['model']) ?></td>
                    <td><?= htmlspecialchars($row['daily_rate']) ?></td>
                    <td><?php echo htmlspecialchars($row['rental_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['return_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['total_cost']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="9">No rentals found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<a href="logout.php" class="btn btn-secondary">Logout</a>


    <?php require 'component/footer.php'; ?>
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>