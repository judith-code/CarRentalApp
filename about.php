<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Car Rental</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/bootstrap/css/about.css">
</head>
<body>
    <?php require 'component/navbar.php'; ?>
<!-- header section -->
    <div class="hero">
        <div class="container">
            <h1>About Us</h1>
            <p>Providing top-tier car rental services for comfort and convenience.</p>
        </div>
    </div>

<!-- mission statement -->
    <div class="container my-5">
        <h2 class="section-title text-center">Our Mission</h2>
        <p class="text-center">Our mission is to provide reliable and affordable car rental services tailored to meet the needs of every customer, ensuring comfort, safety, and satisfaction in every journey.</p>
    </div>
    
<!-- the team -->
    <div class="container my-5">
        <h2 class="section-title text-center">Meet the Team</h2>
        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="card team-card">
                    <img src="assets/images/lady.avif" class="card-img-top" alt="Anselem Judith">
                    <div class="card-body text-center">
                        <h5 class="card-title">Anselem Judith</h5>
                        <p class="card-text">Co-Founder & Operations Lead</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card team-card">
                    <img src="assets/images/moses.avif" class="card-img-top" alt="Onyilo Moses">
                    <div class="card-body text-center">
                        <h5 class="card-title">Onyilo Moses</h5>
                        <p class="card-text">Co-Founder & Technical Lead</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require 'component/footer.php'; ?>
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
