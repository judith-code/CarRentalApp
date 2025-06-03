<?php 
require_once 'config/db-connect.php';

// Get cars with enhanced query
$sql = "SELECT * FROM cars";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Count available cars
$availableCars = array_filter($cars, function($car) {
    return $car['status'] === 'available';
});
$rentedCars = array_filter($cars, function($car) {
    return $car['status'] === 'rented';
});

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Car Rentals - Fleet Overview</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/bootstrap/css/cars.css">
</head>
<body>
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner"></div>
    </div>

    <?php require 'component/navbar.php'; ?>
   <!--- success message --->
    <?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
        <?= htmlspecialchars($_SESSION['success_message']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
        <?= htmlspecialchars($_SESSION['error_message']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>

    <div class="main-container">
        <div class="header-section">
            <h1 class="header-title">
                <i class="fas fa-car-alt me-3"></i>
                Premium Car Fleet
            </h1>
            <p class="header-subtitle">
                Discover our premium collection of rental vehicles, from economy to luxury
            </p>
            
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-icon available">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-number available"><?= count($availableCars) ?></div>
                    <div class="stat-label">Available Cars</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon rented">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-number rented"><?= count($rentedCars) ?></div>
                    <div class="stat-label">Currently Rented</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon total">
                        <i class="fas fa-cars"></i>
                    </div>
                    <div class="stat-number total"><?= count($cars) ?></div>
                    <div class="stat-label">Total Fleet</div>
                </div>
            </div>
        </div>

        <div class="table-container ">
            <div class="table-header">
                <h2 class="table-title">
                    <i class="fas fa-list-ul me-2"></i>
                    Vehicle Inventory
                </h2>
                
                <div class="filter-controls">
                    <input type="text" class="search-input" id="searchInput" placeholder="Search cars...">
                    <select class="filter-select" id="statusFilter">
                        <option value="all">All Status</option>
                        <option value="available">Available Only</option>
                        <option value="rented">Rented Only</option>
                    </select>
                    <select class="filter-select" id="makeFilter">
                        <option value="all">All Makes</option>
                        <?php 
                        $makes = array_unique(array_column($cars, 'make'));
                        foreach($makes as $make): ?>
                            <option value="<?= htmlspecialchars($make) ?>"><?= htmlspecialchars($make) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <?php if(empty($cars)): ?>
                <div class="empty-state">
                    <i class="fas fa-car-crash"></i>
                    <h3>No vehicles found</h3>
                    <p>There are currently no cars in the fleet.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="custom-table" id="carsTable">
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag me-2"></i>ID</th>
                                <th><i class="fas fa-industry me-2"></i>Make & Model</th>
                                <th><i class="fas fa-calendar me-2"></i>Year</th>
                                <th><i class="fas fa-dollar-sign me-2"></i>Daily Rate</th>
                                <th><i class="fas fa-info-circle me-2"></i>Status</th>
                                <th><i class="fas fa-cogs me-2"></i>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="carsTableBody">
                            <?php foreach($cars as $car): ?>
                                <tr class="car-row" 
                                    data-status="<?= htmlspecialchars($car['status']) ?>" 
                                    data-make="<?= htmlspecialchars($car['make']) ?>"
                                    data-search="<?= htmlspecialchars(strtolower($car['make'] . ' ' . $car['model'])) ?>">
                                    <td>
                                        <span class="fw-bold"><?= htmlspecialchars($car['id']) ?></span>
                                    </td>
                                    <td>
                                        <div class="car-make"><?= htmlspecialchars($car['make']) ?></div>
                                        <div class="car-model"><?= htmlspecialchars($car['model']) ?></div>
                                    </td>
                                    <td>
                                        <span class="year-badge"><?= htmlspecialchars($car['year']) ?></span>
                                    </td>
                                    <td>
                                        <span class="price-display">$<?= number_format($car['daily_rate'], 2) ?></span>
                                        <small class="text-muted d-block">per day</small>
                                    </td>
                                    <td>
                                        <?php if($car['status'] === 'available'): ?>
                                            <span class="status-badge status-available">
                                                <i class="fas fa-check-circle"></i>
                                                Available
                                            </span>
                                        <?php else: ?>
                                            <span class="status-badge status-rented">
                                                <i class="fas fa-clock"></i>
                                                Rented
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($car['status'] === 'available'): ?>
                                            <a href="car.php?id=<?= $car['id'] ?>" class="action-btn btn-view">
                                                <i class="fas fa-eye"></i>
                                                View Details
                                            </a>
                                        <?php else: ?>
                                            <button class="action-btn btn-unavailable" disabled>
                                                <i class="fas fa-ban"></i>
                                                Unavailable
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
    </div>

    <?php require 'component/footer.php'; ?>

    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        // Enhanced filtering and search functionality
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter');
            const makeFilter = document.getElementById('makeFilter');
            const tableBody = document.getElementById('carsTableBody');
            const loadingOverlay = document.getElementById('loadingOverlay');

            function showLoading() {
                loadingOverlay.style.display = 'flex';
            }

            function hideLoading() {
                loadingOverlay.style.display = 'none';
            }

            function filterTable() {
                showLoading();
                
                setTimeout(() => {
                    const searchTerm = searchInput.value.toLowerCase();
                    const statusValue = statusFilter.value;
                    const makeValue = makeFilter.value;
                    const rows = tableBody.querySelectorAll('.car-row');

                    let visibleCount = 0;
                    rows.forEach(row => {
                        const searchData = row.getAttribute('data-search');
                        const status = row.getAttribute('data-status');
                        const make = row.getAttribute('data-make');

                        const matchesSearch = searchTerm === '' || searchData.includes(searchTerm);
                        const matchesStatus = statusValue === 'all' || status === statusValue;
                        const matchesMake = makeValue === 'all' || make === makeValue;

                        if (matchesSearch && matchesStatus && matchesMake) {
                            row.style.display = '';
                            visibleCount++;
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    // Show empty state if no results
                    if (visibleCount === 0 && !document.querySelector('.empty-state')) {
                        const emptyState = document.createElement('tr');
                        emptyState.className = 'empty-results';
                        emptyState.innerHTML = `
                            <td colspan="6" class="text-center py-5">
                                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                <h5>No results found</h5>
                                <p class="text-muted">Try adjusting your search criteria</p>
                            </td>
                        `;
                        tableBody.appendChild(emptyState);
                    } else {
                        const emptyResults = document.querySelector('.empty-results');
                        if (emptyResults) {
                            emptyResults.remove();
                        }
                    }

                    hideLoading();
                }, 300);
            }

            // Event listeners
            searchInput.addEventListener('input', filterTable);
            statusFilter.addEventListener('change', filterTable);
            makeFilter.addEventListener('change', filterTable);

            // Add smooth animations to table rows
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            });

            document.querySelectorAll('.car-row').forEach(row => {
                row.style.opacity = '0';
                row.style.transform = 'translateY(20px)';
                row.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                observer.observe(row);
            });

            // Initialize
            hideLoading();
        });
    </script>
</body>
</html>