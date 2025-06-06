<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Please log in as admin.'];
    header('Location: login.php');
    exit();
}

require_once '../config/db-connect.php';

//query to fetch cars
try {
    $query = "SELECT * FROM cars ORDER BY make, model";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
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
    <title>Car Fleet Management - Car Rental Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/bootstrap/css/manage-cars.css">
    <link rel="stylesheet" href="../assets/bootstrap/css/footer.css">
</head>
<body>
    <?php require '../component/admin-navbar.php'; ?>
    
    <!-- header section -->
    <div class="page-header">
        <div class="container">
            <h1>
                <i class="fas fa-car-side"></i>
                Car Fleet Management
            </h1>
            <p class="subtitle">Manage your rental car inventory and track vehicle status</p>
        </div>
    </div>

    <div class="container pb-5">
        <!-- Alert Messages -->
        <?php if (isset($_SESSION['alert'])): ?>
            <div class="alert alert-<?= htmlspecialchars($_SESSION['alert']['type']) ?> alert-dismissible fade show" role="alert">
                <i class="fas fa-<?= $_SESSION['alert']['type'] === 'success' ? 'check-circle' : 'exclamation-triangle' ?> me-2"></i>
                <?= htmlspecialchars($_SESSION['alert']['message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['alert']); ?>
        <?php endif; ?>

        <!-- showing calculations for numbers of info -->
        <div class="stats-cards">
            <div class="row g-4">
                <?php
                $available_count = count(array_filter($cars, fn($car) => $car['status'] === 'available'));
                $rented_count = count(array_filter($cars, fn($car) => $car['status'] === 'rented'));
                $maintenance_count = count(array_filter($cars, fn($car) => $car['status'] === 'maintenance'));
                ?>
                <div class="col-md-3">
                    <div class="stat-card available">
                        <div class="icon">
                            <i class="fas fa-car"></i>
                        </div>
                        <h3 class="number"><?= $available_count ?></h3>
                        <p class="label">Available Cars</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card rented">
                        <div class="icon">
                            <i class="fas fa-key"></i>
                        </div>
                        <h3 class="number"><?= $rented_count ?></h3>
                        <p class="label">Currently Rented</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card maintenance">
                        <div class="icon">
                            <i class="fas fa-tools"></i>
                        </div>
                        <h3 class="number"><?= $maintenance_count ?></h3>
                        <p class="label">In Maintenance</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="icon" style="background-color: rgba(37, 99, 235, 0.1); color: var(--primary-color);">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3 class="number"><?= count($cars) ?></h3>
                        <p class="label">Total Fleet</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- displaying cars in a table -->
        <div class="main-content">
            <div class="content-header">
                <h2><i class="fas fa-list me-2"></i>Vehicle Inventory</h2>
            </div>
            
            <?php if (empty($cars)): ?>
                <div class="empty-state">
                    <i class="fas fa-car"></i>
                    <h4>No vehicles in your fleet</h4>
                    <p>Start by adding your first car to the inventory below.</p>
                </div>
            <?php else: ?>
                <div class="table-container">
                    <table class="table cars-table">
                        <thead>
                            <tr>
                                <th>Vehicle</th>
                                <th>Year</th>
                                <th>Daily Rate</th>
                                <th>Status</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cars as $car): ?>
                                <tr>
                                    <td>
                                        <div>
                                            <strong><?= htmlspecialchars($car['make']) ?></strong>
                                            <div class="text-muted small"><?= htmlspecialchars($car['model']) ?></div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark"><?= htmlspecialchars($car['year']) ?></span>
                                    </td>
                                    <td>
                                        <strong class="text-success">$<?= htmlspecialchars(number_format($car['daily_rate'], 2)) ?></strong>
                                        <div class="text-muted small">per day</div>
                                    </td>
                                    <td>
                                        <span class="status-badge status-<?= htmlspecialchars($car['status']) ?>">
                                            <?= htmlspecialchars(ucfirst($car['status'])) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <img src="../carimages/<?= htmlspecialchars($car['image'] ?? 'default.jpg') ?>" 
                                             alt="<?= htmlspecialchars($car['make'] . ' ' . $car['model']) ?>" 
                                             class="car-image">
                                    </td>
                                    <td>
                                        <?php if ($car['status'] !== 'rented'): ?>
                                            <button class="btn btn-delete btn-sm" 
                                                    onclick="confirmDelete(<?= htmlspecialchars($car['id']) ?>, '<?= htmlspecialchars($car['make'] . ' ' . $car['model']) ?>')">
                                                <i class="fas fa-trash-alt me-1"></i>Delete
                                            </button>
                                            <a href="edit-cars.php?id=<?= htmlspecialchars($car['id']); ?> " class="btn btn-primary btn-sm">Edit</a>
                                        <?php else: ?>
                                            <button class="btn btn-secondary btn-sm" disabled>
                                                <i class="fas fa-lock me-1"></i>Rented
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <!-- section for adding new car to the cars list -->
        <div class="add-car-section">
            <div class="content-header">
                <h2><i class="fas fa-plus-circle me-2"></i>Add New Vehicle</h2>
            </div>
            <div class="form-section">
                <form action="add_car.php" method="POST" enctype="multipart/form-data">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="make" class="form-label">
                                <i class="fas fa-industry me-1"></i>Make
                            </label>
                            <input type="text" class="form-control" id="make" name="make" 
                                   placeholder="e.g., Toyota, Honda, BMW" required>
                        </div>
                        <div class="col-md-6">
                            <label for="model" class="form-label">
                                <i class="fas fa-car me-1"></i>Model
                            </label>
                            <input type="text" class="form-control" id="model" name="model" 
                                   placeholder="e.g., Camry, Civic, X5" required>
                        </div>
                        <div class="col-md-4">
                            <label for="year" class="form-label">
                                <i class="fas fa-calendar me-1"></i>Year
                            </label>
                            <input type="number" class="form-control" id="year" name="year" 
                                   min="1900" max="<?= date('Y') ?>" placeholder="<?= date('Y') ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label for="daily_rate" class="form-label">
                                <i class="fas fa-dollar-sign me-1"></i>Daily Rate
                            </label>
                            <input type="number" class="form-control" id="daily_rate" name="daily_rate" 
                                   step="0.01" min="0" placeholder="0.00" required>
                        </div>
                        <div class="col-md-4">
                            <label for="image" class="form-label">
                                <i class="fas fa-image me-1"></i>Car Image
                            </label>
                            <input type="file" class="form-control" id="image" name="image" 
                                   accept="image/jpeg,image/png,image/webp" required>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Add Vehicle to Fleet
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php require '../component/footer.php'; ?>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmDelete(carId, carName) {
            if (confirm(`Are you sure you want to delete the ${carName}?\n\nThis action cannot be undone.`)) {
                window.location.href = `delete_car.php?id=${carId}`;
            }
        }

        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>
</body>
</html>