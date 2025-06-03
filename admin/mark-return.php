<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Please log in as admin.'];
    header('Location: login.php');
    exit();
}

require_once '../config/db-connect.php';

$rental_id = (int)($_GET['rental_id'] ?? 0);
$car_id = (int)($_GET['car_id'] ?? 0);

if ($rental_id <= 0 || $car_id <= 0) {
    $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Invalid rental or car ID.'];
    header('Location: manage-rentals.php');
    exit();
}

try {
    $pdo->beginTransaction();

    // Update rental status
    $query = "UPDATE rentals SET rental_status = 'returned' WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $rental_id]);

    // Update car status
    $query = "UPDATE cars SET status = 'available' WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $car_id]);

    $pdo->commit();

    $_SESSION['alert'] = ['type' => 'success', 'message' => 'Rental marked as returned.'];
    header('Location: manage-rentals.php');
    exit();
} catch (PDOException $e) {
    $pdo->rollBack();
    $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Database error: Unable to mark rental as returned.'];
    header('Location: manage-rentals.php');
    exit();
}
?>