<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Car Rental</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/bootstrap/css/contact.css">
</head>
<body>
    <?php require 'component/navbar.php'; ?>

    <div class="container my-5">
        <!-- Alert Messages -->
        <?php if (isset($_SESSION['alert'])): ?>
            <div class="alert alert-<?= htmlspecialchars($_SESSION['alert']['type']) ?> alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['alert']['message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['alert']); ?>
        <?php endif; ?>

        <!-- Contact Form Section -->
        <div class="row justify-content-center">
            <div class="col-md-8 contact-section">
                <h1><i class="fas fa-envelope me-2"></i>Contact Us</h1>
                <form action="https://formspree.io/f/xgvkaopy" method="POST" class="contact-form mt-4">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input
                            type="text"
                            class="form-control"
                            id="name"
                            name="name"
                            placeholder="Your Name"
                            value="<?= isset($_SESSION['form_data']['name']) ? htmlspecialchars($_SESSION['form_data']['name']) : '' ?>"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input
                            type="email"
                            class="form-control"
                            id="email"
                            name="email"
                            placeholder="Your Email"
                            value="<?= isset($_SESSION['form_data']['email']) ? htmlspecialchars($_SESSION['form_data']['email']) : '' ?>"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea
                            class="form-control"
                            id="message"
                            name="message"
                            rows="5"
                            placeholder="Your Message"
                            required
                        ><?= isset($_SESSION['form_data']['message']) ? htmlspecialchars($_SESSION['form_data']['message']) : '' ?></textarea>
                    </div>
                    <input type="text" name="_gotcha" style="display: none;">
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Static Contact Info -->
        <div class="row justify-content-center">
            <div class="col-md-6 contact-info text-center mt-5">
                <h2>Our Contact Details</h2>
                <p><i class="fas fa-envelope"></i>Email: anselemjudith0@gmail.com</p>
                <p><i class="fas fa-phone"></i>Phone: +234 9038 360 889</p>
                <p><i class="fas fa-map-marker-alt"></i>Address: Opposite Agblo Top Hotel</p>
            </div>
        </div>
    </div>

<button class="scroll-to-top btn btn-primary btn-lg align-right" id="scrollToTop" aria-label="Scroll to top"><i class="fas fa-arrow-up"></i></button>
    document.getElementById('scrollToTop').addEventListener('click', function () {
    window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    <?php require 'component/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    document.getElementById('scrollToTop').addEventListener('click', function () {
    window.scrollTo({ top: 0, behavior: 'smooth' });
    });
    </script>
</body>
</html>
