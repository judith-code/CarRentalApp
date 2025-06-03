<?php
session_start();
require_once 'config/db-connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['last_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Invalid email format.'];
        header('Location: login.php');
        exit();
    }

    // Check credentials
    $query = "SELECT * FROM customers WHERE first_name = ? last_name = ? AND email = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$first_name, $last_name, $email]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result->num_rows > 0) {
        $customer = $result->fetch_assoc();
        $_SESSION['customer_id'] = $customer['id'];
        header('Location: myrentals.php');
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
</head>
<body>
    <?php require 'component/navbar.php'; ?>
    <div class='container mt-5 mb-5 '>
        <h1 class='text-center'><i class="fas fa-sign-in-alt"></i> Users Log In</h1>
        <div>
        <form action="login.php" method="POST">
    <div class="mb-3">
        <label for="firstname">First Name</label>
        <input type="text" class="form-control" name="first_name" required>
    </div>
    <div class="mb-3">
        <label for="lastname">Last Name</label>
        <input type="text" class="form-control" name="last_name" required>
    </div>
    <div class="mb-3">
        <label for="email">Email</label>
        <input type="email" class="form-control" name="email" required>
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
    </div>
    
    <?php require 'component/footer.php'; ?>
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>