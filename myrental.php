<?php
session_start();
require_once 'config/db-connect.php';

if (!isset($_SESSION['customer_id'])) {
    $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Please log in to view your rentals.'];
    header('Location: login.php');
    exit();
}

$customer_id = $_SESSION['customer_id'];
$query = "SELECT c.firstname, c.lastname, c.email, c.phone, r.*, cars.make, cars.model, cars.daily_rate
          FROM rentals r
          JOIN cars ON r.car_id = cars.id
          JOIN customers c ON r.customer_id = c.id
          WHERE r.customer_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();
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
        <?php while ($rental = $result->fetch_assoc()): ?>
            <?php
            $status = $rental['rental_status'];
            if ($rental['rental_status'] === 'active' && strtotime($rental['return_date']) <= time()) {
                $status = 'due for return';
            }
            ?>
            <tr>
                <td><?php echo htmlspecialchars($rental['make'] . ' ' . $rental['model']); ?></td>
                <td><?php echo htmlspecialchars($rental['daily_rate']); ?></td>
                <td><?php echo htmlspecialchars($rental['rental_date']); ?></td>
                <td><?php echo htmlspecialchars($rental['return_date']); ?></td>
                <td><?php echo htmlspecialchars($rental['total_cost']); ?></td>
                <td><?php echo htmlspecialchars($status); ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<a href="logout.php" class="btn btn-secondary">Logout</a>


    <?php require 'component/footer.php'; ?>
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
