<?php
require_once 'functions.php';
// Database se Footer Banner fetch karein
$fBanner = getFooterBanner();

// Default Data if DB empty
$fTitle = $fBanner['title'] ?? 'Ready to Start Your Learning Journey?';
$fDesc  = $fBanner['description'] ?? 'Join thousands of students already achieving their academic goals with personalized online tutoring.';
$fImg   = $fBanner['image'] ?? 'assets/images/footer.png';

$quick_links = [
    ["name" => "About", "url" => "about.php"],
    ["name" => "Pricing", "url" => "pricing.php"],
    ["name" => "Blog", "url" => "blog.php"],
    ["name" => "FAQ", "url" => "faq.php"]
];

$support_links = [
    ["name" => "Privacy Policy", "url" => "privacy-policy.php"],
    ["name" => "Terms & Conditions", "url" => "terms.php"]
];
?>

<footer class="footer-wrapper overflow-hidden">
    
    <!-- 1. TOP CTA BANNER (Dynamic Background) -->
    <section class="footer-cta-container position-relative py-5 text-center text-white" 
             style="background: url('<?php echo $fImg; ?>') no-repeat center center; background-size: cover;">
        <div class="cta-overlay"></div> <!-- Dark overlay matching screenshot -->
        
        <div class="container position-relative z-index-10 py-5">
            <div class="max-w-800 mx-auto animate-up">
                <h2 class="display-5 fw-bold mb-3"><?php echo $fTitle; ?></h2>
                <p class="fs-5 mb-5 opacity-90"><?php echo $fDesc; ?></p>
                
                <div class="d-flex flex-column flex-md-row justify-content-center gap-3">
                    <a href="contact.php" class="btn btn-white text-primary fw-bold px-4 py-2 rounded-3">
                        Get Started <i class="fas fa-arrow-right ms-2 small"></i>
                    </a>
                    <a href="https://wa.me/+918860296060" target="_blank" class="btn btn-outline-light fw-bold px-4 py-2 rounded-3">
                        Talk to an Advisor
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. MAIN FOOTER (Blue Section) -->
    <section class="main-footer bg-primary-custom text-white py-5">
        <div class="container">
            <div class="row g-5">
                
                <!-- About & Social -->
                <div class="col-lg-3 col-md-6">
                    <img src="assets/images/logo.png" alt="GGES Logo" height="50" class="mb-4 bg-white rounded p-1">
                    <p class="text-blue-light mb-4">Personalized online tutoring to help students achieve their academic goals.</p>
                    <div class="d-flex gap-2">
                        <a href="#" class="social-circle"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-circle"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="social-circle"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-circle"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-3 col-md-6">
                    <h5 class="fw-bold mb-4 border-bottom-faded pb-2">Quick Links</h5>
                    <ul class="list-unstyled footer-link-list">
                        <?php foreach($quick_links as $link): ?>
                        <li><a href="<?php echo $link['url']; ?>"><?php echo $link['name']; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Support -->
                <div class="col-lg-3 col-md-6">
                    <h5 class="fw-bold mb-4 border-bottom-faded pb-2">Support</h5>
                    <ul class="list-unstyled footer-link-list">
                        <?php foreach($support_links as $link): ?>
                        <li><a href="<?php echo $link['url']; ?>"><?php echo $link['name']; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="col-lg-3 col-md-6">
                    <h5 class="fw-bold mb-4 border-bottom-faded pb-2">Contact</h5>
                    <ul class="list-unstyled contact-info-list">
                        <li class="mb-3">
                            <i class="far fa-envelope me-2"></i> info@mygges.com
                        </li>
                        <li class="mb-4">
                            <i class="fas fa-phone-alt me-2"></i> +91-886-029-6060
                        </li>
                        <li>
                            <a href="https://wa.me/+918860296060" class="btn btn-white text-primary rounded-pill px-4 fw-bold shadow-sm">
                                <i class="fab fa-whatsapp text-success me-2 fs-5"></i> Live Chat
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- 3. COPYRIGHT -->
            <div class="mt-5 pt-4 border-top border-white-10 text-center small opacity-75">
                © 2026 <span class="fw-bold">Grace Global Education Services,</span> All rights reserved
            </div>
        </div>
    </section>
</footer>

<!-- 4. FLOATING BUTTONS (Exactly as screenshot) -->
<div class="floating-controls">
    <!-- WhatsApp -->
    <a href="https://wa.me/+918860296060" class="wa-float shadow-lg" target="_blank">
        <i class="fab fa-whatsapp"></i>
    </a>
    <!-- Scroll to Top -->
    <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="top-float shadow-lg">
        <i class="fas fa-arrow-up"></i>
    </button>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>