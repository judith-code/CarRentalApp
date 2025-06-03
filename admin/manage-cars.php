<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Please log in as admin.'];
    header('Location: login.php');
    exit();
}

require_once '../config/db-connect.php';

try {
    $query = "SELECT * FROM cars";
    $stmt = $pdo->query($query);
    $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Database error: Unable to fetch cars.'];
    $cars = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Cars - Car Rental</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>
<body>
    <?php require '../component/admin-navbar.php'; ?>
    <div class="container py-5">
        <?php if (isset($_SESSION['alert'])): ?>
            <div class="alert alert-<?= htmlspecialchars($_SESSION['alert']['type']) ?> alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['alert']['message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['alert']); ?>
        <?php endif; ?>
        <h1 class="mb-4"><i class="fas fa-car"></i> Manage Cars</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Make</th>
                    <th>Model</th>
                    <th>Year</th>
                    <th>Daily Rate</th>
                    <th>Status</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cars as $car): ?>
                    <tr>
                        <td><?= htmlspecialchars($car['make']) ?></td>
                        <td><?= htmlspecialchars($car['model']) ?></td>
                        <td><?= htmlspecialchars($car['year']) ?></td>
                        <td>$<?= htmlspecialchars(number_format($car['daily_rate'], 2)) ?></td>
                        <td><?= htmlspecialchars($car['status']) ?></td>
                        <td>
                            <img src="../carimages/<?= htmlspecialchars($car['image'] ?? 'default.jpg') ?>" 
                                 alt="<?= htmlspecialchars($car['make'] . ' ' . $car['model']) ?>" 
                                 style="max-width: 100px;">
                        </td>
                        <td>
                            <?php if ($car['status'] !== 'rented'): ?>
                                <a href="delete_car.php?id=<?= htmlspecialchars($car['id']) ?>" 
                                   class="btn btn-danger" 
                                   onclick="return confirm('Are you sure you want to delete this car?')">
                                   Delete
                                </a>
                            <?php else: ?>
                                <button class="btn btn-danger" disabled>Rented</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h2 class="mt-5">Add New Car</h2>
        <form action="add_car.php" method="POST" enctype="multipart/form-data" class="col-md-6">
            <div class="mb-3">
                <label for="make" class="form-label">Make</label>
                <input type="text" class="form-control" id="make" name="make" required>
            </div>
            <div class="mb-3">
                <label for="model" class="form-label">Model</label>
                <input type="text" class="form-control" id="model" name="model" required>
            </div>
            <div class="mb-3">
                <label for="year" class="form-label">Year</label>
                <input type="number" class="form-control" id="year" name="year" min="1900" max="<?= date('Y') ?>" required>
            </div>
            <div class="mb-3">
                <label for="daily_rate" class="form-label">Daily Rate</label>
                <input type="number" class="form-control" id="daily_rate" name="daily_rate" step="0.01" min="0" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Car Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/jpeg,image/png" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Car</button>
        </form>
    </div>
    <?php require '../components/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>