<?php
$selectedCarId = $_GET['id'] ;

require_once 'config/db-connect.php';
$sql = "SELECT * FROM cars WHERE id= ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$selectedCarId]);
$selectedCar= $stmt->fetch(PDO::FETCH_ASSOC);

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    header("location: cars.php");
    exit();
};

if((!$selectedCar)){
    header("location:cars.php");
    exit();
};

if(($_GET['id']) > 1000){
    header("location:cars.php");
    exit();
};
$success = "Hired successfully!";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Details</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border: none;
            border-radius: 12px;
        }
        .car-image {
            height: 180px;
            width: 100%;
            object-fit: cover;
            border-radius: 8px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
    </style>
</head>
<body>
    <?php  require 'component/navbar.php'; ?>

    <div class="container py-5">
        <div class="mb-3">
            <a href="cars.php" class="btn btn-outline-secondary">&larr; Back to Cars List</a>
        </div>

        <div class="card p-4">
            <h2 class="mb-4">Car Details</h2>
            <div class="row">
                <div class="col-md-6">
                    <img src="uploads/<?php echo $selectedCar['image'] ?? 'default.jpg'; ?>" alt="Car Image" class="car-image">
                </div>
                <div class="col-md-6">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Brand:</strong> <?php echo $selectedCar['make']; ?></li>
                        <li class="list-group-item"><strong>Model:</strong> <?php echo $selectedCar['model']; ?></li>
                        <li class="list-group-item"><strong>Year:</strong> <?php echo $selectedCar['year']; ?></li>
                        <li class="list-group-item"><strong>Daily Rate:</strong> $<?php echo $selectedCar['daily_rate']; ?></li>
                        <li class="list-group-item"><strong>Status:</strong> <?php echo ucfirst($selectedCar['status']); ?></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card mt-5 p-4">
            <h3 class="text-center mb-4">Hire This Car</h3>
            <form action="processes/hire-process.php" method="post">
                <input type="hidden" name="car_id" value="<?php echo $selectedCarId ?>">
                <input type="hidden" name="daily_rate" value="<?php echo $selectedCar['daily_rate'] ?>">

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

    <?php  require 'component/footer.php'; ?>
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>