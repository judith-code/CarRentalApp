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

    // Checking credentials
    $stmt = $pdo->prepare("SELECT * FROM customers WHERE first_name = ? AND last_name = ? AND email = ?");
    $stmt->execute([$first_name, $last_name, $email]);
    $customer = $stmt->fetch();

    if ($customer) {
        $_SESSION['customer_id'] = $customer['id'];
        $_SESSION['last_activity'] = time(); 
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
    <!-- css links -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-..." crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <style>
        .scroll-to-top {
        position: fixed;
        bottom: 30px;
        right: 30px;
        display: none; /* hidden by default */
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 50px;
        padding: 10px 16px;
        cursor: pointer;
        z-index: 9999;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.scroll-to-top:hover {
    background-color: #0056b3;
}
    </style>
</head>
<body>
    <?php require 'component/navbar.php'; ?>

<div class="container py-5">
    <h2 class="text-center mb-4">Customer Login</h2>
    <!--success and error messages -->
    <?php if (isset($_SESSION['alert'])): ?>
        <div class="alert alert-<?= htmlspecialchars($_SESSION['alert']['type']) ?> alert-dismissible fade show">
            <?= htmlspecialchars($_SESSION['alert']['message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['alert']); ?>
    <?php endif; ?>
    
    <!-- log in form -->
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
     
    <button class="scroll-to-top btn btn-primary btn-lg align-right" id="scrollToTop" aria-label="Scroll to top"><i class="fas fa-arrow-up"></i></button>
   
    <?php require 'component/footer.php'; ?>
<script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>

<script>
    
    document.getElementById('scrollToTop').addEventListener('click', function () {
    window.scrollTo({ top: 0, behavior: 'smooth' });
    });
</script>
</body>
</html>
