<?php
session_start();

$selectedCarId = $_GET['id'] ?? null;
if (!isset($selectedCarId) || !is_numeric($selectedCarId)) {
    $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Error: Invalid car ID.'];
    header("Location: cars.php");
    exit();
}

//query to get all cars
require_once 'config/db-connect.php';
$stmt = $pdo->prepare("SELECT * FROM cars WHERE id = ?");
$stmt->execute([$selectedCarId]);
$selectedCar = $stmt->fetch();

if (!$selectedCar || strtolower($selectedCar['status']) !== 'available') {
    $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Error: Car is not available.'];
    header("Location: cars.php");
    exit();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Car Details</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/bootstrap/css/car.css">
</head>
<body>
<div class="container  mt-5 mb-5 ">
    <a href="cars.php" class="btn btn-outline-secondary mb-3">← Back to Cars List</a>

    <!-- displaying car details -->
    <div class="card p-4 shadow-sm mb-4">
        <h2 class="mb-4">Car Details</h2>
        <div class="row">
            <div class="col-md-6 text-center">
               <!--<img src="<?= htmlspecialchars($imagePath) ?>" alt="<?= htmlspecialchars($selectedCar['make'] . ' ' . $selectedCar['model']) ?>" class="img-fluid rounded" style="max-width: 300px;"> -->
               <img src="carimages/<?php echo $selectedCar['image'] ?>" >
            </div>
            <div class="col-md-6">
                <ul class="list-group">
                    <li class="list-group-item"><strong>Brand:</strong> <?= htmlspecialchars($selectedCar['make']) ?></li>
                    <li class="list-group-item"><strong>Model:</strong> <?= htmlspecialchars($selectedCar['model']) ?></li>
                    <li class="list-group-item"><strong>Year:</strong> <?= htmlspecialchars($selectedCar['year']) ?></li>
                    <li class="list-group-item"><strong>Daily Rate:</strong> $<?= number_format($selectedCar['daily_rate'], 2) ?></li>
                    <li class="list-group-item"><strong>Status:</strong> <?= ucfirst(htmlspecialchars($selectedCar['status'])) ?></li>
                </ul>
            </div>
            <div class="note-section">
                <p><strong>NOTE: </strong>Please read our <a href="terms.php">T&C</a> carefully before hiring a car.</p>
            </div>
        </div>
    </div>

    <div class="card p-4 shadow-sm">
        <h3 class="text-center mb-4">Hire This Car</h3>
        <form action="processes/hire-process.php" method="post">
            <input type="hidden" name="car_id" value="<?= htmlspecialchars($selectedCarId) ?>">
            <input type="hidden" name="daily_rate" value="<?= htmlspecialchars($selectedCar['daily_rate']) ?>">

            <?php
            $formData = $_SESSION['form_data'] ?? [];
            function field($name) {
                global $formData;
                return isset($formData[$name]) ? htmlspecialchars($formData[$name]) : '';
            }
            ?>

            <!-- hiring form -->
            <div class="mb-3">
                <label for="return_date" class="form-label">Return Date</label>
                <input type="date" name="return_date" id="return_date" class="form-control" required
                       min="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d', strtotime('+7 days')) ?>" value="<?= field('return_date') ?>">
            </div>
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" name="first_name" id="first_name" class="form-control" required value="<?= field('first_name') ?>">
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" name="last_name" id="last_name" class="form-control" required value="<?= field('last_name') ?>">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" name="email" id="email" class="form-control" required value="<?= field('email') ?>">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="tel" name="phone" id="phone" class="form-control" required value="<?= field('phone') ?>">
            </div>

            <button type="submit" class="btn btn-primary w-100">Confirm Hire</button>
        </form>
    </div>
    </div>
</div>
<?php require 'component/navbar.php'; ?>

<?php require 'component/footer.php'; ?>
<script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
