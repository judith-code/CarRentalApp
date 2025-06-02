<?php 
require_once 'config/db-connect.php';

// Get cars with enhanced query
$sql = "SELECT * FROM cars ORDER BY make, model";
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
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #64748b;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --light-bg: #f8fafc;
            --dark-text: #1e293b;
            --border-color: #e2e8f0;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: var(--dark-text);
        }

        .main-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .header-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2.5rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-lg);
            text-align: center;
        }

        .header-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark-text);
            margin-bottom: 0.5rem;
        }

        .header-subtitle {
            font-size: 1.1rem;
            color: var(--secondary-color);
            margin-bottom: 2rem;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: var(--shadow-md);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .stat-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: var(--secondary-color);
            font-weight: 500;
        }

        .available { color: var(--success-color); }
        .rented { color: var(--danger-color); }
        .total { color: var(--primary-color); }

        .table-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--shadow-lg);
            overflow: hidden;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .table-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--dark-text);
        }

        .filter-controls {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .filter-select, .search-input {
            border: 2px solid var(--border-color);
            border-radius: 10px;
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            transition: border-color 0.3s ease;
        }

        .filter-select:focus, .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        .custom-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .custom-table thead th {
            background: linear-gradient(135deg, var(--primary-color), #3b82f6);
            color: white;
            padding: 1.2rem 1rem;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
        }

        .custom-table tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid var(--border-color);
        }

        .custom-table tbody tr:hover {
            background: var(--light-bg);
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        .custom-table tbody tr:last-child {
            border-bottom: none;
        }

        .custom-table td {
            padding: 1.2rem 1rem;
            font-size: 0.95rem;
            vertical-align: middle;
        }

        .car-make {
            font-weight: 600;
            color: var(--dark-text);
        }

        .car-model {
            color: var(--secondary-color);
            font-size: 0.9rem;
        }

        .year-badge {
            background: var(--light-bg);
            color: var(--secondary-color);
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .price-display {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--success-color);
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }

        .status-available {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
        }

        .status-rented {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger-color);
        }

        .action-btn {
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: none;
        }

        .btn-view {
            background: var(--primary-color);
            color: white;
        }

        .btn-view:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
            color: white;
        }

        .btn-unavailable {
            background: var(--border-color);
            color: var(--secondary-color);
            cursor: not-allowed;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: var(--secondary-color);
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        @media (max-width: 768px) {
            .main-container {
                padding: 1rem;
            }

            .header-title {
                font-size: 2rem;
            }

            .table-container {
                padding: 1rem;
                border-radius: 15px;
            }

            .custom-table {
                font-size: 0.85rem;
            }

            .custom-table td, .custom-table th {
                padding: 0.8rem 0.5rem;
            }

            .filter-controls {
                flex-direction: column;
                width: 100%;
            }

            .filter-select, .search-input {
                width: 100%;
            }
        }

        /* Loading animation */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid var(--border-color);
            border-top: 5px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner"></div>
    </div>

    <?php require 'component/navbar.php'; ?>
    
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

        <div class="table-container">
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
                                        <span class="fw-bold">#<?= htmlspecialchars($car['id']) ?></span>
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