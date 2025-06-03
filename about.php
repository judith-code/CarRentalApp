<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Car Rental</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        .hero {
            background-color: #007bff;
            color: white;
            padding: 60px 0;
            text-align: center;
        }
        .section-title {
            font-size: 2rem;
            margin-bottom: 30px;
            color: #333;
        }
        .team-card {
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border: none;
            transition: transform 0.3s;
        }
        .team-card:hover {
            transform: translateY(-5px);
        }
        .team-card img {
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
            height: 300px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <?php require 'component/navbar.php'; ?>

    <div class="hero">
        <div class="container">
            <h1>About Us</h1>
            <p>Providing top-tier car rental services for comfort and convenience.</p>
        </div>
    </div>

    <div class="container my-5">
        <h2 class="section-title text-center">Our Mission</h2>
        <p class="text-center">Our mission is to provide reliable and affordable car rental services tailored to meet the needs of every customer, ensuring comfort, safety, and satisfaction in every journey.</p>
    </div>

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
