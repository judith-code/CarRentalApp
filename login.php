<?php
session_start();
require_once 'config/db-connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Invalid email format.'];
        header('Location: login.php');
        exit();
    }

    // Check credentials
    $stmt = $pdo->prepare("SELECT * FROM customers WHERE first_name = ? AND last_name = ? AND email = ?");
    $stmt->execute([$first_name, $last_name, $email]);
    $customer = $stmt->fetch();

    if ($customer) {
        $_SESSION['customer_id'] = $customer['id'];
        $_SESSION['last_activity'] = time(); // For session timeout
        header('Location: myrental.php');
        exit();
    } else {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Invalid credentials.'];
        header('Location: login.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Login</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
</head>
<body>
    <?php require 'component/navbar.php'; ?>
<div class="container py-5">
    <h2 class="text-center mb-4">Customer Login</h2>
    <?php if (isset($_SESSION['alert'])): ?>
        <div class="alert alert-<?= htmlspecialchars($_SESSION['alert']['type']) ?> alert-dismissible fade show">
            <?= htmlspecialchars($_SESSION['alert']['message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['alert']); ?>
    <?php endif; ?>
    <form action="login.php" method="POST" class="col-md-6 offset-md-3">
        <div class="mb-3">
            <label for="lastname" class="form-label">First Name</label>
            <input type="text" class="form-control" name="first_name" required>
        </div>
        <div class="mb-3">
            <label for="lastname" class="form-label">Last Name</label>
            <input type="text" class="form-control" name="last_name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
</div>
    <?php require 'component/footer.php'; ?>
<script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
