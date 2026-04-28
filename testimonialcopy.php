<?php include('includes/header.php'); ?>
<?php include('includes/navbar.php'); ?>

<?php

$testimonials = [
    [
        "title" => "Excellent Support",
        "address" => "California, USA",
        "image" => "assets/images/sarah.png",
        "description" => "The personalized attention my son received was beyond our expectations. His grades in Math improved significantly within just two months of joining GGES."
    ],
    [
        "title" => "Great Tutors",
        "address" => "London, UK",
        "image" => "assets/images/michel.png",
        "description" => "The tutors are incredibly patient and knowledgeable. The interactive sessions make learning complex English concepts much easier and fun for the kids."
    ],
    [
        "title" => "Highly Recommended",
        "address" => "Toronto, Canada",
        "image" => "assets/images/david.png",
        "description" => "Flexible scheduling and high-quality teaching. As a working parent, the convenience of online sessions tailored to our time zone is a lifesaver."
    ]
];
?>

<div class="testimonial-page-wrapper py-5" style="background-image: url('assets/images/work-bg.png'); background-size: contain; background-color: #F0F8FF; min-height: 90vh;">
    <div class="container py-5">
        
       
        <div class="text-center mb-5 animate-up">
            <h2 class="fw-bold display-5 mb-4">What Our Clients Say</h2>
        </div>

       
        <div class="row g-4 justify-content-center perspective-1000">
            <?php foreach($testimonials as $index => $review): ?>
            <div class="col-lg-4 col-md-6 animate-3d-entry" style="animation-delay: <?php echo ($index * 0.15); ?>s;">
                <div class="testimonial-card h-100 p-4 p-md-5 bg-white rounded-4 shadow-lg border-0 d-flex flex-column transition-3d-hover">
                    
                   
                    <div class="quote-mark text-blue-200 display-4 mb-n3 font-serif">“</div>
                    
                    <p class="text-secondary fs-5 fst-italic mb-4 flex-grow-1 position-relative z-index-10">
                        <?php echo $review['description']; ?>
                    </p>

                    <div class="d-flex align-items-center gap-3 pt-4 border-top">
                        
                        
                        <div class="profile-container">
                            
                            <div class="rotating-border-ring"></div>
                            
                            <!-- Profile Image Holder -->
                            <div class="profile-img-holder">
                                <img src="<?php echo $review['image']; ?>" 
                                     alt="<?php echo $review['title']; ?>" 
                                     class="img-fluid rounded-full shadow-sm"
                                     onerror="this.src='https://via.placeholder.com/150'">
                            </div>
                        </div>

                        <div>
                            <h5 class="fw-bold text-dark mb-0"><?php echo $review['title']; ?></h5>
                            <p class="text-primary small fw-bold mb-0"><?php echo $review['address']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>