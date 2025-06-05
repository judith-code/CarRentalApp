<?php 
require_once '../config/db-connect.php';

// Initialize variables
$id = $_GET['id'] ?? null;
$car = null;
$message = '';
$messageType = '';

// Fetch existing car data for pre-population
if ($id) {
    try {
        $query = "SELECT * FROM `cars` WHERE `id` = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id]);
        $car = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$car) {
            $message = "Car not found!";
            $messageType = "danger";
        }
    } catch (PDOException $e) {
        $message = "Database error: " . $e->getMessage();
        $messageType = "danger";
    }
} else {
    $message = "No car ID provided!";
    $messageType = "danger";
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $car) {
    $make = trim($_POST['make'] ?? '');
    $model = trim($_POST['model'] ?? '');
    $year = $_POST['year'] ?? null;
    $daily_rate = $_POST['daily_rate'] ?? null;
    $status = $_POST['status'] ?? '';
    $currentImage = $car['image']; // Keep current image as default
    
    // Validate required fields
    if ($make && $model && $year && $daily_rate && $status) {
        try {
            // Handle file upload if new image is provided
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = '../carimages/';
                
                // Create directory if it doesn't exist
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                $fileExtension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
                
                if (in_array($fileExtension, $allowedExtensions)) {
                    $fileName = uniqid('car_') . '.' . $fileExtension;
                    $filePath = $uploadDir . $fileName;
                    
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
                        // Delete old image if it exists and is different
                        if ($currentImage && file_exists('../carimages/' . $currentImage)) {
                            unlink('../carimages/' . $currentImage);
                        }
                        $currentImage = $fileName;
                    } else {
                        throw new Exception("Failed to upload image");
                    }
                } else {
                    throw new Exception("Invalid file type. Only JPG, PNG, and WebP are allowed.");
                }
            }
            
            // Update database
            $query = "UPDATE `cars` SET `make` = ?, `model` = ?, `year` = ?, `daily_rate` = ?, `status` = ?, `image` = ? WHERE `id` = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$make, $model, $year, $daily_rate, $status, $currentImage, $id]);
            
            $message = "Car updated successfully!";
            $messageType = "success";
            
            // Refresh car data
            $stmt = $pdo->prepare("SELECT * FROM `cars` WHERE `id` = ?");
            $stmt->execute([$id]);
            $car = $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (Exception $e) {
            $message = "Error: " . $e->getMessage();
            $messageType = "danger";
        }
    } else {
        $message = "Please fill in all required fields!";
        $messageType = "warning";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Car - Car Rental System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/bootstrap/css/editcars.css">
</head>
<body>
    <?php require '../component/admin-navbar.php'; ?>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card fade-in">
                    <div class="card-header">
                        <h2 class="mb-0">
                            <i class="fas fa-car me-2"></i>
                            Update Car Information
                        </h2>
                        <?php if ($car): ?>
                            <p class="mb-0 mt-2 opacity-75">
                                Editing: <?php echo htmlspecialchars($car['make'] . ' ' . $car['model']); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                    
                    <div class="card-body p-4">
                        <?php if ($message): ?>
                            <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                                <i class="fas fa-<?php echo $messageType === 'success' ? 'check-circle' : ($messageType === 'danger' ? 'exclamation-triangle' : 'info-circle'); ?> me-2"></i>
                                <?php echo htmlspecialchars($message); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($car): ?>
                            <form action="" method="POST" enctype="multipart/form-data" id="updateCarForm">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($car['id']); ?>">
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="make" class="form-label">
                                            <i class="fas fa-industry me-1"></i>Make *
                                        </label>
                                        <input type="text" name="make" id="make" class="form-control" 
                                               value="<?php echo htmlspecialchars($car['make']); ?>" required>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="model" class="form-label">
                                            <i class="fas fa-car me-1"></i>Model *
                                        </label>
                                        <input type="text" name="model" id="model" class="form-control"
                                               value="<?php echo htmlspecialchars($car['model']); ?>" required>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="year" class="form-label">
                                            <i class="fas fa-calendar me-1"></i>Year *
                                        </label>
                                        <input type="number" name="year" id="year" class="form-control" 
                                               min="1900" max="<?php echo date('Y') + 1; ?>" 
                                               value="<?php echo htmlspecialchars($car['year']); ?>" required>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="daily_rate" class="form-label">
                                            <i class="fas fa-dollar-sign me-1"></i>Daily Rate *
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" name="daily_rate" id="daily_rate" class="form-control" 
                                                   min="0" step="0.01" 
                                                   value="<?php echo htmlspecialchars($car['daily_rate']); ?>" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="status" class="form-label">
                                        <i class="fas fa-info-circle me-1"></i>Status *
                                    </label>
                                    <select name="status" id="status" class="form-select" required>
                                        <option value="">Select Status</option>
                                        <option value="available" <?php echo $car['status'] === 'available' ? 'selected' : ''; ?>>
                                            Available
                                        </option>
                                        <option value="rented" <?php echo $car['status'] === 'rented' ? 'selected' : ''; ?>>
                                            Rented
                                        </option>
                                        <option value="maintenance" <?php echo $car['status'] === 'maintenance' ? 'selected' : ''; ?>>
                                            Under Maintenance
                                        </option>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="image" class="form-label">
                                        <i class="fas fa-image me-1"></i>Car Image
                                    </label>
                                    <input type="file" class="form-control" id="image" name="image" 
                                           accept="image/jpeg,image/png,image/webp" onchange="previewImage()">
                                    <div class="form-text">Leave empty to keep current image. Accepts: JPG, PNG, WebP</div>
                                    
                                    <?php if ($car['image']): ?>
                                        <div class="mt-3">
                                            <label class="form-label">Current Image:</label><br>
                                            <img src="../carimages/<?php echo htmlspecialchars($car['image']); ?>" 
                                                 alt="Current car image" class="image-preview" id="currentImage">
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div id="imagePreview" class="mt-3" style="display: none;">
                                        <label class="form-label">New Image Preview:</label><br>
                                        <img id="preview" class="image-preview" alt="Image preview">
                                    </div>
                                </div>
                                
                                <div class="d-flex gap-3 justify-content-end">
                                    <a href="manage-cars.php" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-1"></i>Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary" id="submitBtn">
                                        <span class="normal-text">
                                            <i class="fas fa-save me-1"></i>Update Car
                                        </span>
                                        <span class="loading">
                                            <i class="fas fa-spinner fa-spin me-1"></i>Updating...
                                        </span>
                                    </button>
                                </div>
                            </form>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                                <h4>Unable to load car data</h4>
                                <p class="text-muted">Please check the car ID and try again.</p>
                                <a href="manage-cars.php" class="btn btn-primary">
                                    <i class="fas fa-arrow-left me-1"></i>Back to Cars
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>index
        </div>
    </div>

    <?php require '../component/admin-navbar.php'; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        function previewImage() {
            const file = document.getElementById('image').files[0];
            const preview = document.getElementById('preview');
            const previewDiv = document.getElementById('imagePreview');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewDiv.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                previewDiv.style.display = 'none';
            }
        }
        
        document.getElementById('updateCarForm').addEventListener('submit', function() {
            const submitBtn = document.getElementById('submitBtn');
            const normalText = submitBtn.querySelector('.normal-text');
            const loadingText = submitBtn.querySelector('.loading');
            
            normalText.style.display = 'none';
            loadingText.style.display = 'inline';
            submitBtn.disabled = true;
        });
        
        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
</body>
</html>