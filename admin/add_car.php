<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Please log in as admin.'];
    header('Location: login.php');
    exit();
}

require_once '../config/db-connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $make = trim($_POST['make'] ?? '');
    $model = trim($_POST['model'] ?? '');
    $year = (int)($_POST['year'] ?? 0);
    $daily_rate = (float)($_POST['daily_rate'] ?? 0);
    $image = $_FILES['image'] ?? null;

    // Validate inputs
    if (empty($make) || empty($model) || $year < 1900 || $year > date('Y') || $daily_rate <= 0) {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Invalid input data.'];
        header('Location: manage-cars.php');
        exit();
    }

    // Validate image
    if (!$image || $image['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Image upload failed.'];
        header('Location: manage-cars.php');
        exit();
    }

    $allowed_types = ['image/jpeg', 'image/png'];
    $max_size = 2 * 1024 * 1024; // 2MB
    if (!in_array($image['type'], $allowed_types) || $image['size'] > $max_size) {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Invalid image type or size (JPEG/PNG, max 2MB).'];
        header('Location: manage-cars.php');
        exit();
    }

    // Generate unique filename
    $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
    $filename = uniqid('car_') . '.' . $ext;
    $target = '../carimages/' . $filename;

    // Upload image
    if (!move_uploaded_file($image['tmp_name'], $target)) {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Failed to save image.'];
        header('Location: manage-cars.php');
        exit();
    }

    try {
        // Insert car
        $query = "INSERT INTO cars (make, model, year, daily_rate, status, image) VALUES (:make, :model, :year, :daily_rate, 'available', :image)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'make' => $make,
            'model' => $model,
            'year' => $year,
            'daily_rate' => $daily_rate,
            'image' => $filename
        ]);

        $_SESSION['alert'] = ['type' => 'success', 'message' => 'Car added successfully.'];
        header('Location: manage-cars.php');
        exit();
    } catch (PDOException $e) {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Database error: Unable to add car.'];
        header('Location: manage-cars.php');
        exit();
    }
}
?>