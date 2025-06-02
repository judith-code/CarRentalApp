
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/home.css">
</head>
<body>
    <!-- Navigation -->
    <?php require 'component/navbar.php'; ?>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-content">
            <h1>Find the Perfect Ride for Every Journey</h1>
            <p>Premium car rental experience with unmatched convenience, reliability, and competitive pricing. Your adventure starts here.</p>
            <div class="hero-buttons">
                <a href="cars.php" class="btn btn-primary">
                    <i class="fas fa-car"></i> Rent a Car
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="section features" id="features">
        <div class="container">
            <h2 class="section-title">Why Choose DriveEasy?</h2>
            <div class="features-grid">
                <div class="feature-card fade-in">
                    <div class="feature-icon">
                        <i class="fas fa-car-side"></i>
                    </div>
                    <h3>Premium Fleet</h3>
                    <p>Choose from our extensive collection of well-maintained vehicles, from economy to luxury cars.</p>
                </div>
                <div class="feature-card fade-in">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>Easy Booking</h3>
                    <p>Book your perfect car in minutes with our streamlined online platform and mobile app.</p>
                </div>
                <div class="feature-card fade-in">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>24/7 Support</h3>
                    <p>Our dedicated customer service team is available round the clock to assist you.</p>
                </div>
                <div class="feature-card fade-in">
                    <div class="feature-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3>Flexible Rentals</h3>
                    <p>Enjoy flexible pickup and drop-off options that fit your schedule and location preferences.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="section how-it-works">
        <div class="container">
            <h2 class="section-title">How It Works</h2>
            <div class="steps">
                <div class="step fade-in">
                    <div class="step-number">1</div>
                    <h3>Search & Compare</h3>
                    <p>Browse our extensive fleet and compare prices to find the perfect car for your needs and budget.</p>
                </div>
                <div class="step fade-in">
                    <div class="step-number">2</div>
                    <h3>Book & Confirm</h3>
                    <p>Complete your reservation in minutes with our secure booking system and instant confirmation.</p>
                </div>
                <div class="step fade-in">
                    <div class="step-number">3</div>
                    <h3>Pick Up & Drive</h3>
                    <p>Collect your car from your chosen location and start your journey with confidence and peace of mind.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Cars -->
    <section class="section popular-cars" id="cars">
        <div class="container">
            <h2 class="section-title">Popular Cars</h2>
            <div class="cars-grid">
                <div class="car-card fade-in">
                    <div class="car-image">
                        <img src="carimages/corolla.avif" alt="Toyota Corolla" style="height: 150px; border-radius: 10px;">
                    </div>
                    <div class="car-info">
                        <div class="car-name">Toyota Corolla</div>
                        <div class="car-price">From $100.00/day</div>
                        <div class="car-features">
                            <span><i class="fas fa-users"></i> 5 Seats</span>
                            <span><i class="fas fa-cog"></i> Auto</span>
                            <span><i class="fas fa-gas-pump"></i> Fuel Efficient</span>
                        </div>
                        <a href="car.php?id=1">View</a>
                    </div>
                </div>
                <div class="car-card fade-in">
                    <div class="car-image">
                        <img src="carimages/civic.avif" alt="Honda Civic" style="height: 150px; border-radius: 10px;">
                    </div>
                    <div class="car-info">
                        <div class="car-name">Honda Civic</div>
                        <div class="car-price">From $180.00/day</div>
                        <div class="car-features">
                            <span><i class="fas fa-users"></i> 5 Seats</span>
                            <span><i class="fas fa-cog"></i> Auto</span>
                            <span><i class="fas fa-star"></i> Popular</span>
                        </div>
                        <a href="car.php?id=6">View</a>
                    </div>
                </div>

                <div class="car-card fade-in">
                    <div class="car-image">
                        <img src="carimages/fusion.avif" alt="Ford Fusion" style="height: 150px; border-radius: 10px;">
                    </div>
                    <div class="car-info">
                        <div class="car-name">Ford Fusion</div>
                        <div class="car-price">From $330.00/day</div>
                        <div class="car-features">
                            <span><i class="fas fa-users"></i> 4 Seats</span>
                            <span><i class="fas fa-tachometer-alt"></i> Sport</span>
                            <span><i class="fas fa-crown"></i> Premium</span>
                        </div>
                        <a href="car.php?id=18">View</a>
                    </div>
                </div>
            </div>
            
            <div class="view-all-cars">
                <a href="cars.php">
                    <i class="fas fa-th-large"></i> View All Cars
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="section testimonials">
        <div class="container">
            <h2 class="section-title">What Our Customers Say</h2>
            <div class="testimonials-grid">
                <div class="testimonial fade-in">
                    <div class="testimonial-text">
                        Fast and smooth booking process. The car was immaculately clean and ready exactly on time. The entire experience exceeded my expectations.
                    </div>
                    <div class="testimonial-author">Sarah M.</div>
                    <div class="testimonial-location">Lagos, Nigeria</div>
                </div>
                <div class="testimonial fade-in">
                    <div class="testimonial-text">
                        I found the perfect car at an unbeatable price. The customer service was exceptional and made the whole process effortless. Highly recommended!
                    </div>
                    <div class="testimonial-author">James O.</div>
                    <div class="testimonial-location">Abuja, Nigeria</div>
                </div>
            </div>
        </div>
    </section>

    <?php require 'component/footer.php'; ?>

    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 100) {
                navbar.style.background = 'rgba(255, 255, 255, 0.98)';
                navbar.style.boxShadow = '0 2px 30px rgba(0, 0, 0, 0.15)';
            } else {
                navbar.style.background = 'rgba(255, 255, 255, 0.95)';
                navbar.style.boxShadow = '0 2px 20px rgba(0, 0, 0, 0.1)';
            }
        });

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe all fade-in elements
        document.querySelectorAll('.fade-in').forEach(el => {
            observer.observe(el);
        });
    </script>
</body>
</html>
