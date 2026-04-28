<?php 
require_once 'functions.php'; // 1. Logic Layer include karein
$testimonials = getTestimonials(); // 2. Real data fetch karein (functions.php se)

include('includes/header.php'); 
include('includes/navbar.php'); 
?>

<div class="testimonial-page-wrapper py-5" style="background-image: url('assets/images/work-bg.png'); background-size: contain; background-position: center; background-color: #F0F8FF; min-height: 90vh;">
    <div class="container py-5">
        
        <!-- Heading -->
        <div class="text-center mb-5 animate-up">
            <h2 class="fw-bold display-5 mb-4">What Our Clients Say</h2>
        </div>

        <!-- Testimonial Grid -->
        <div class="row g-4 justify-content-center perspective-1000">
            <?php if(!empty($testimonials)): foreach($testimonials as $index => $review): ?>
            <div class="col-lg-4 col-md-6 animate-3d-entry" style="animation-delay: <?php echo ($index * 0.15); ?>s;">
                <div class="testimonial-card h-100 p-4 p-md-5 bg-white rounded-4 shadow-lg border-0 d-flex flex-column transition-3d-hover">
                    
                    <!-- Quote Icon -->
                    <div class="quote-mark text-blue-200 display-4 mb-n3 font-serif">“</div>
                    
                    <!-- Dynamic Description -->
                    <p class="text-secondary fs-5 fst-italic mb-4 flex-grow-1 position-relative z-index-10">
                        <?php echo $review['description']; ?>
                    </p>

                    <div class="d-flex align-items-center gap-3 pt-4 border-top">
                        
                        <!-- PREMIUM ROTATING ICON SECTION -->
                        <div class="profile-container">
                            <!-- Rotating Conic Gradient Ring -->
                            <div class="rotating-border-ring"></div>
                            
                            <!-- Profile Image Holder (Dynamic Path) -->
                            <div class="profile-img-holder">
                                <img src="<?php echo $review['image']; ?>" 
                                     alt="<?php echo $review['title']; ?>" 
                                     class="img-fluid rounded-full shadow-sm"
                                     onerror="this.src='https://via.placeholder.com/150'">
                            </div>
                        </div>

                        <div>
                            <!-- Dynamic Name & Address -->
                            <h5 class="fw-bold text-dark mb-0"><?php echo $review['title']; ?></h5>
                            <p class="text-primary small fw-bold mb-0"><?php echo $review['address']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; else: ?>
                <!-- Fallback agar database khali ho -->
                <div class="col-12 text-center py-5">
                    <p class="text-muted">No testimonials found. Check back soon!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>