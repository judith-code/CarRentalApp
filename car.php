<?php
session_start();

// Validate and fetch car ID
$selectedCarId = $_GET['id'] ?? null;
if (!isset($selectedCarId) || !is_numeric($selectedCarId) || $selectedCarId > 1000) {
    header("Location: cars.php");
    exit();
}

require_once 'config/db-connect.php';
$sql = "SELECT * FROM cars WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$selectedCarId]);
$selectedCar = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$selectedCar) {
    header("Location: cars.php");
    exit();
}

// Show success message if redirected after hire
$successMessage = $_SESSION['hire_success'] ?? null;
unset($_SESSION['hire_success']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Details</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/bootstrap/css/car.css">
</head>
<body>
    <?php require 'component/navbar.php'; ?>

    <div class="container py-5">
        <div class="mb-3">
            <a href="cars.php" class="btn btn-outline-secondary">&larr; Back to Cars List</a>
        </div>

        <?php if ($successMessage): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($successMessage) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card p-4 mb-4">
            <h2 class="mb-4">Car Details</h2>
            <div class="row">
                <div class="col-md-6">
                    <img src="carimages/<?= htmlspecialchars($selectedCar['carimages'] ?? 'fusion.avif') ?>" alt="Car Image" class="car-image">
                </div>
                <div class="col-md-6">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Brand:</strong> <?= htmlspecialchars($selectedCar['make']) ?></li>
                        <li class="list-group-item"><strong>Model:</strong> <?= htmlspecialchars($selectedCar['model']) ?></li>
                        <li class="list-group-item"><strong>Year:</strong> <?= htmlspecialchars($selectedCar['year']) ?></li>
                        <li class="list-group-item"><strong>Daily Rate:</strong> $<?= htmlspecialchars($selectedCar['daily_rate']) ?></li>
                        <li class="list-group-item"><strong>Status:</strong> <?= ucfirst(htmlspecialchars($selectedCar['status'])) ?></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card p-4">
            <h3 class="text-center mb-4">Hire This Car</h3>
            <form action="processes/hire-process.php" method="post">
                <input type="hidden" name="car_id" value="<?= $selectedCarId ?>">
                <input type="hidden" name="daily_rate" value="<?= htmlspecialchars($selectedCar['daily_rate']) ?>">

                <div class="mb-3">
                    <label for="return_date" class="form-label">Return Date</label>
                    <input type="date" name="return_date" id="return_date" class="form-control" required min="<?= date('Y-m-d'); ?>" max="<?= date('Y-m-d', strtotime('+7 days')) ?>">
                </div>

                <div class="mb-3">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" name="first_name" id="first_name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" name="last_name" id="last_name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="tel" name="phone" id="phone" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Confirm Hire</button>
            </form>
        </div>
    </div>

    <?php require 'component/footer.php'; ?>
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
