<?php
session_start();
require_once '../config/db-connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_name = trim($_POST['user_name'] ?? '');
    $email = trim($_POST['email'] ?? '');

    // Validate email format before database query
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Invalid email format.'];
        header('Location: login.php');
        exit();
    }

    try {
        // Prepare and execute query
        $query = "SELECT `id`, `user_name`, `email` FROM `admin` WHERE user_name = ? AND email = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$user_name, $email]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if admin exists
        if ($admin) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['alert'] = ['type' => 'success', 'message' => 'Login successful.'];
            header("Location: dashboard.php");
            exit();
        } else {
            $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Username or email not found.'];
            header('Location: login.php');
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Database error: Unable to process login.'];
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
    <title>Admin Login - Car Rental</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">

</head>
<body>
    
    <div class="container py-5">
                <a href="../index.php" class="btn btn-outline-primary">Back to site</a>

        <h1 class="text-center mb-4"><i class="fas fa-user-shield"></i> Admin Login</h1>
    <div>
        <?php if (isset($_SESSION['alert'])): ?>
    <div class="alert alert-<?= htmlspecialchars($_SESSION['alert']['type']) ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($_SESSION['alert']['message']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['alert']); ?>
<?php endif; ?>

        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="login.php" method="POST">
                    <div class="mb-3">
                        <label for="user_name" class="form-label">Username</label>
                        <input type="text" class="form-control" id="user_name" name="user_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>