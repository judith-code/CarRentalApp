<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Please log in as admin.'];
    header('Location: login.php');
    exit();
}

require_once '../config/db-connect.php';

$car_id = (int)($_GET['id'] ?? 0);

if ($car_id <= 0) {
    $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Invalid car ID.'];
    header('Location: manage-cars.php');
    exit();
}

try {
    // Check if car is rented
    $query = "SELECT status FROM cars WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $car_id]);
    $car = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$car) {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Car not found.'];
        header('Location: manage-cars.php');
        exit();
    }

    if ($car['status'] === 'rented') {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Cannot delete a rented car.'];
        header('Location: manage-cars.php');
        exit();
    }

    // Delete car
    $query = "DELETE FROM cars WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $car_id]);

    $_SESSION['alert'] = ['type' => 'success', 'message' => 'Car deleted successfully.'];
    header('Location: manage-cars.php');
    exit();
} catch (PDOException $e) {
    $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Database error: Unable to delete car.'];
    header('Location: manage-cars.php');
    exit();
}
?>