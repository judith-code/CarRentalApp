<?php
session_start();
require '../config/db-connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $car_id = $_POST['car_id'] ?? null;
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $daily_rate = $_POST['daily_rate'] ?? null;
    $return_date = $_POST['return_date'] ?? null;
    $rental_date = date('Y-m-d');

    $_SESSION['form_data'] = $_POST; // Save form input in session for reuse on errors

    // Validation
    if (!$car_id || !$return_date || !$first_name || !$last_name || !$email || !$phone) {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => 'All fields are required.'];
        header("Location: ../car.php?id=$car_id");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Invalid email format.'];
        header("Location: ../car.php?id=$car_id");
        exit();
    }

    if (!preg_match('/^\d{10,13}$/', $phone)) {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Phone number must be 10 to 13 digits.'];
        header("Location: ../car.php?id=$car_id");
        exit();
    }

    // Calculate rental duration and cost
    $rental_dateObj = new DateTime($rental_date);
    $return_dateObj = new DateTime($return_date);
    $days = $rental_dateObj->diff($return_dateObj)->days;
    if ($days <= 0) $days = 1;

    $total_cost = $daily_rate * $days;

    try {
        // Check for existing customer
        $stmt = $pdo->prepare("SELECT * FROM customers WHERE email = ?");
        $stmt->execute([$email]);
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$customer) {
            // Insert new customer
            $stmt = $pdo->prepare("INSERT INTO customers (first_name, last_name, phone, email) VALUES (?, ?, ?, ?)");
            $stmt->execute([$first_name, $last_name, $phone, $email]);

            $stmt = $pdo->prepare("SELECT * FROM customers WHERE email = ?");
            $stmt->execute([$email]);
            $customer = $stmt->fetch(PDO::FETCH_ASSOC);
        }

        $customer_id = $customer['id'];

        // Insert rental
        $stmt = $pdo->prepare("INSERT INTO rentals (customer_id, car_id, rental_date, return_date, total_cost) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$customer_id, $car_id, $rental_date, $return_date, $total_cost]);

        // Update car status
        $stmt = $pdo->prepare("UPDATE cars SET status = 'rented' WHERE id = ?");
        $stmt->execute([$car_id]);

        unset($_SESSION['form_data']); // Clear form data
        $_SESSION['alert'] = ['type' => 'success', 'message' => 'Car hired successfully! We\'ll contact you soon.'];
        header('Location: ../cars.php');
        exit();

    } catch (PDOException $e) {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Something went wrong while processing your request.'];
        header("Location: ../car.php?id=$car_id");
        exit();
    }
}
