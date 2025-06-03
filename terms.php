<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms & Conditions - AutoRent Pro</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/bootstrap/css/terms.css">
</head>
<body>
    <?php require 'component/navbar.php'; ?>
    
    <section class="hero-section">
        <div class="container hero-content">
            <h1 class="display-4 fw-bold mb-3">Terms & Conditions</h1>
            <p class="lead">Please read our terms and conditions carefully before using our car rental services</p>
        </div>
    </section>

    <div class="container">
        <div class="main-container">
            <div class="row g-0">
                <!-- Sidebar Navigation -->
                <div class="col-lg-3">
                    <div class="sidebar">
                        <nav class="nav flex-column">
                            <a class="nav-link active" href="#agreement" data-bs-toggle="pill">
                                <i class="fas fa-handshake"></i>Rental Agreement
                            </a>
                            <a class="nav-link" href="#eligibility" data-bs-toggle="pill">
                                <i class="fas fa-user-check"></i>Eligibility
                            </a>
                            <a class="nav-link" href="#vehicle-condition" data-bs-toggle="pill">
                                <i class="fas fa-car"></i>Vehicle Condition
                            </a>
                            <a class="nav-link" href="#payment" data-bs-toggle="pill">
                                <i class="fas fa-credit-card"></i>Payment Terms
                            </a>
                            <a class="nav-link" href="#insurance" data-bs-toggle="pill">
                                <i class="fas fa-shield-alt"></i>Insurance
                            </a>
                            <a class="nav-link" href="#liability" data-bs-toggle="pill">
                                <i class="fas fa-exclamation-triangle"></i>Liability
                            </a>
                            <a class="nav-link" href="#cancellation" data-bs-toggle="pill">
                                <i class="fas fa-times-circle"></i>Cancellation
                            </a>
                            <a class="nav-link" href="#contact" data-bs-toggle="pill">
                                <i class="fas fa-phone"></i>Contact Us
                            </a>
                        </nav>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">
                    <div class="content-section">
                        <div class="last-updated">
                            <i class="fas fa-calendar-alt me-2"></i>
                            Last updated: <?= date('F j, Y') ?>
                        </div>

                        <div class="tab-content">
                            <!-- Rental Agreement -->
                            <div class="tab-pane fade show active" id="agreement">
                                <div class="terms-section">
                                    <h2 class="section-title">Rental Agreement</h2>
                                    <p>By renting a vehicle from AutoRent Pro, you agree to comply with all terms and conditions outlined in this agreement. This agreement constitutes a legally binding contract between you (the renter) and AutoRent Pro.</p>
                                    
                                    <ul class="terms-list">
                                        <li>The rental agreement begins when you take possession of the vehicle and ends when you return it to our designated location.</li>
                                        <li>You must be at least 21 years old with a valid driver's license to rent a vehicle.</li>
                                        <li>A valid credit card in the renter's name is required for all transactions.</li>
                                        <li>All information provided must be accurate and truthful.</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Eligibility Requirements -->
                            <div class="tab-pane fade" id="eligibility">
                                <div class="terms-section">
                                    <h2 class="section-title">Eligibility Requirements</h2>
                                    
                                    <div class="highlight-box">
                                        <h5><strong>Age Requirements</strong></h5>
                                        <p>Minimum age of 21 years. Drivers aged 21-24 may be subject to additional fees and restrictions.</p>
                                    </div>

                                    <ul class="terms-list">
                                        <li>Must possess a valid, unrestricted driver's license for at least 2 years.</li>
                                        <li>Valid major credit card (Visa, MasterCard, American Express) in renter's name.</li>
                                        <li>International renters must present a valid International Driving Permit along with their home country license.</li>
                                        <li>Clean driving record with no major violations in the past 3 years.</li>
                                        <li>No DUI/DWI convictions in the past 5 years.</li>
                                        <li>Must pass identity verification and credit check process.</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Vehicle Condition -->
                            <div class="tab-pane fade" id="vehicle-condition">
                                <div class="terms-section">
                                    <h2 class="section-title">Vehicle Condition & Return Policy</h2>
                                    
                                    <ul class="terms-list">
                                        <li>Pre-rental inspection will be conducted to document existing damage.</li>
                                        <li>Vehicle must be returned in the same condition as received.</li>
                                        <li>Vehicle must be returned with the same fuel level as at pickup.</li>
                                        <li>Interior and exterior must be reasonably clean upon return.</li>
                                        <li>Damage charges will be assessed for any new damage found upon return.</li>
                                        <li>Late return fees apply: $25 per hour for the first 2 hours, then full daily rate.</li>
                                        <li>Smoking in vehicles is strictly prohibited - $200 cleaning fee applies.</li>
                                        <li>Pet policy: Additional $50 cleaning fee for pet hair/odor.</li>
                                    </ul>

                                    <div class="highlight-box">
                                        <h5><strong>Important Note</strong></h5>
                                        <p>Failure to return the vehicle on time may result in additional daily charges and potential reporting to authorities if vehicle is not returned within 24 hours of due time.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Terms -->
                            <div class="tab-pane fade" id="payment">
                                <div class="terms-section">
                                    <h2 class="section-title">Payment Terms & Fees</h2>
                                    
                                    <ul class="terms-list">
                                        <li>Full payment is required at time of rental or reservation.</li>
                                        <li >Security deposit of $200-500 will be held on credit card (varies by vehicle class).</li>
                                        <li>Fuel service charge: $3.50 per gallon if returned with less fuel.</li>
                                        <li>Additional driver fee: $10 per day per additional authorized driver.</li>
                                        <li>GPS navigation system: $5 per day (optional).</li>
                                        <li>Child safety seat: $8 per day (recommended to reserve in advance).</li>
                                        <li>Airport pickup/drop-off fee: $15 per transaction.</li>
                                        <li>Mobile Wi-Fi hotspot: $7 per day (optional).</li>
                                    </ul>

                                    <div class="highlight-box">
                                        <h5><strong>Refund Policy</strong></h5>
                                        <p>Cancellations made 24+ hours in advance: Full refund. Less than 24 hours: 50% refund. No-shows: No refund.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Insurance -->
                            <div class="tab-pane fade" id="insurance">
                                <div class="terms-section">
                                    <h2 class="section-title">Insurance Coverage</h2>
                                    
                                    <ul class="terms-list">
                                        <li>Basic liability insurance is included with all rentals.</li>
                                        <li data-="💥">Collision Damage Waiver (CDW): $15-25 per day (optional but recommended).</li>
                                        <li data-="🔓">Theft Protection: $8 per day (optional).</li>
                                        <li data-="🏥">Personal Accident Insurance: $6 per day (optional).</li>
                                        <li data-="🧳">Personal Effects Coverage: $4 per day (optional).</li>
                                        <li data-="📞">Roadside Assistance: Included 24/7 for all rentals.</li>
                                        <li data-="⚠️">Insurance coverage may be void if terms are violated.</li>
                                    </ul>

                                    <div class="highlight-box">
                                        <h5><strong>Coverage Exclusions</strong></h5>
                                        <p>Coverage does not apply to damage caused by reckless driving, off-road use, racing, or driving under the influence of alcohol or drugs.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Liability -->
                            <div class="tab-pane fade" id="liability">
                                <div class="terms-section">
                                    <h2 class="section-title">Liability & Restrictions</h2>
                                    
                                    <ul class="terms-list">
                                        <li>Renter is liable for all traffic violations, tolls, and parking tickets.</li>
                                        <li>Vehicle cannot be used for commercial purposes or ride-sharing.</li>
                                        <li>Off-road driving is strictly prohibited.</li>
                                        <li>Racing, speed contests, or stunt driving is forbidden.</li>
                                        <li>Driving on beaches or unpaved roads is not permitted.</li>
                                        <li>Towing other vehicles or trailers is prohibited.</li>
                                        <li>Only authorized drivers listed on agreement may operate vehicle.</li>
                                        <li>Vehicle must remain within specified geographic boundaries.</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Cancellation Policy -->
                            <div class="tab-pane fade" id="cancellation">
                                <div class="terms-section">
                                    <h2 class="section-title">Cancellation & Modification Policy</h2>
                                    
                                    <ul class="terms-list">
                                        <li>Free cancellation up to 24 hours before pickup time.</li>
                                        <li>50% cancellation fee for cancellations within 24 hours.</li>
                                        <li>No refund for no-shows or cancellations after pickup time.</li>
                                        <li>Modifications to reservations subject to availability and rate changes.</li>
                                        <li>All cancellations must be made by phone or through our website.</li>
                                        <li >Early returns do not qualify for partial refunds.</li>
                                        <li>Cancellation confirmation will be sent via email.</li>
                                    </ul>

                                    <div class="highlight-box">
                                        <h5><strong>Force Majeure</strong></h5>
                                        <p>In cases of natural disasters, government restrictions, or other events beyond our control, standard cancellation fees may be waived.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Information -->
                            <div class="tab-pane fade" id="contact">
                                <div class="terms-section">
                                    <h2 class="section-title">Contact Information</h2>
                                    <p>If you have any questions about these terms and conditions, please don't hesitate to contact us:</p>
                                    
                                    <div class="contact-card">
                                        <h4><i class="fas fa-headset me-2"></i>Customer Support</h4>
                                        <div class="contact-info">
                                            <div class="contact-item">
                                                <i class="fas fa-phone"></i>
                                                <span>+234 8169 559 351</span>
                                            </div>
                                            <div class="contact-item">
                                                <i class="fas fa-envelope"></i>
                                                <span>onyilomoses4god@gmail.com</span>
                                            </div>
                                            <div class="contact-item">
                                                <i class="fas fa-clock"></i>
                                                <span>24/7 Available</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-center mt-4">
                                        <a href="cars.php" class="btn btn-primary-custom btn-lg">
                                            <i class="fas fa-car me-2"></i>Start Your Rental
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll to Top Button -->
    <button class="scroll-to-top" id="scrollToTop">
        <i class="fas fa-arrow-up"></i>
    </button>

    <?php require 'component/footer.php'; ?>
    
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>