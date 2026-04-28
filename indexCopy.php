<?php
$why_choose_data = [
    [
        "title" => "Certified & Experienced Tutors",
        "description" => "Our tutors are experts in their fields with proven teaching experience.",
        "image" => "assets/images/icon-container.png"
    ],
    [
        "title" => "1-on-1 Personalized Sessions",
        "description" => "Lessons are tailored to your unique pace and learning style.",
        "image" => "assets/images/icon-container-2.png"
    ],
    [
        "title" => "Flexible Scheduling",
        "description" => "Book sessions that fit perfectly into your busy schedule.",
        "image" => "assets/images/icon-container-3.png"
    ],
    [
        "title" => "Affordable Plans",
        "description" => "High-quality tutoring at prices that won't break bank.",
        "image" => "assets/images/icon-container-4.png"
    ],
    [
        "title" => "Progress Reports for Parents",
        "description" => "Stay informed with detailed updates on your child's progress.",
        "image" => "assets/images/icon-container-5.png"
    ]
];
?>
<?php
$subjects = [
    [
        "title" => "Math",
        "gradient" => "linear-gradient(135deg, #3b82f6, #1d4ed8)",
        "bgImg" => "assets/images/math.png",
        "icon" => "assets/images/math-icon.png",
        "url" => "courses-maths.php#math"
    ],
    [
        "title" => "English",
        "gradient" => "linear-gradient(135deg, #a855f7, #ec4899)",
        "bgImg" => "assets/images/english.png",
        "icon" => "assets/images/eng-icon.png",
        "url" => "courses-english.php#common"
    ],
    [
        "title" => "K-12",
        "gradient" => "linear-gradient(135deg, #6366f1, #1d4ed8)",
        "bgImg" => "assets/images/lp.png",
        "icon" => "assets/images/k-12.png",
        "url" => "courses-k-12#methodology"
    ],
    [
        "title" => "Test Prep",
        "gradient" => "linear-gradient(135deg, #ef4444, #f97316)",
        "bgImg" => "assets/images/child.png",
        "icon" => "assets/images/lp-icon.png",
        "url" => "courses-test#sat"
    ]
];
?>
<?php

function getShortText($text, $limit = 80) {
    if (strlen($text) > $limit) {
        return substr(strip_tags($text), 0, $limit) . "...";
    }
    return strip_tags($text);
}


$offers = [
    ["id" => 1, "type" => "PROMOTION", "expireDate" => "2024-05-20", "title" => "Summer Math Camp", "description" => "Get 20% off on our advanced math camp this summer."],
    ["id" => 2, "type" => "NEW COURSE", "expireDate" => "2024-06-15", "title" => "Advanced SAT Prep", "description" => "Join our newly launched intensive SAT preparation module."],
    ["id" => 3, "type" => "ANNOUNCEMENT", "expireDate" => "2024-07-01", "title" => "New Online Portal", "description" => "We are migrating to a faster, more interactive learning portal."]
];


$stories = [
    ["name" => "Sarah Johnson", "designation" => "Parent", "rating" => 5, "description" => "My daughter's math scores improved significantly in just 3 months!", "image" => "assets/images/sarah.png"],
    ["name" => "Michael Chen", "designation" => "Student", "rating" => 5, "description" => "The tutors are very patient and explain complex concepts very clearly.", "image" => "assets/images/michel.png"],
    ["name" => "David Smith", "designation" => "Parent", "rating" => 4, "description" => "Excellent scheduling flexibility. Highly recommended for busy families.", "image" => "assets/images/david.png"]
];
?>
<?php
$trust_stats = [
    [
        "title" => "500+", 
        "description" => "Active Students", 
        "image" => "assets/images/trust-1.png"
    ],
    [
        "title" => "100+", 
        "description" => "Expert Tutors", 
        "image" => "assets/images/trust-2.png"
    ],
    [
        "title" => "50,000+", 
        "description" => "Sessions Completed", 
        "image" => "assets/images/trust-3.png"
    ],
    [
        "title" => "99%", 
        "description" => "Satisfaction Rate", 
        "image" => "assets/images/trust-4.png"
    ]
];

?>
<?php
$pricing_plans = [
    [
        "planName" => "Starter",
        "className" => "Class 1-5",
        "fees" => [
            ["label" => "4 Sessions", "price" => "$29"],
            ["label" => "30 Mins/Session", "price" => "Included"]
        ],
        "feesPerHour" => "$15",
        "off" => "5% Off"
    ],
    [
        "planName" => "Professional",
        "className" => "Class 6-10",
        "fees" => [
            ["label" => "12 Sessions", "price" => "$79"],
            ["label" => "60 Mins/Session", "price" => "Included"]
        ],
        "feesPerHour" => "$12",
        "off" => "15% Off"
    ],
    [
        "planName" => "Premium",
        "className" => "Class 11-12",
        "fees" => [
            ["label" => "Unlimited", "price" => "$149"],
            ["label" => "60 Mins/Session", "price" => "Included"]
        ],
        "feesPerHour" => "$10",
        "off" => "25% Off"
    ]
];
?>
<?php
$how_it_works_steps = [
    ["id" => 1, "img" => "assets/images/subject.png", "text" => "Choose a subject"],
    ["id" => 2, "img" => "assets/images/right-tutorial.png", "text" => "Match with the right tutor"],
    ["id" => 3, "img" => "assets/images/session.png", "text" => "Learn through interactive online sessions"],
    ["id" => 4, "img" => "assets/images/progress.png", "text" => "Track progress"]
];
?>
<?php include('includes/header.php'); ?>
<?php include('includes/navbar.php'); ?>

<!-- Hero Section -->
<!-- <section class="hero-banner-container">
    <img src="assets/images/home-2.jpg" class="hero-banner-img" alt="Hero Banner">
    
    
    <img src="assets/images/money.png" class="floating-money d-none d-md-block" alt="Money">
</section> -->

<!-- Marquee -->
<!-- <div class="bg-primary text-white py-2">
    <marquee behavior="scroll" direction="left" class="fw-bold">
        Welcome to GGES - Discover amazing personalized online tutoring services!
    </marquee>
</div> -->


<!-- Hero Content Area -->
<div class="container text-center py-5">
    <div class="animate-up" style="animation-delay: 0.3s;">
        <h1 class="display-3 fw-bold">Personalized <span class="text-primary">Online</span></h1>
    </div>
    <div class="animate-up" style="animation-delay: 0.6s;">
        <h1 class="display-3 fw-bold">Tutoring</h1>
        <h2 class="text-primary display-4 fw-bold mb-4">From Our Experienced Tutors</h2>
    </div>
    
    <p class="lead text-muted mx-auto mb-5" style="max-width: 700px; animation-delay: 0.9s;">
        We provide the best educational support to help you achieve your goals with ease.
    </p>

    <div class="animate-up" style="animation-delay: 1.2s;">
        <a href="contact.php" class="btn btn-primary btn-lg px-5 py-3 rounded-3 shadow-lg fw-bold">
            Start Free Trial <i class="fas fa-arrow-right ms-2"></i>
        </a>
    </div>
</div>
<!-- Why Choose Us Section -->
<section class="why-choose-section py-5 position-relative" style="background-image: url('assets/images/work-bg.png'); background-size: cover; background-color: #F0F8FF;">
    
    <!-- Floating 3D Image (React's editImg) -->
    <img src="assets/images/editImg.png" class="floating-img d-none d-lg-block" alt="Decoration">

    <div class="container py-5 mt-4">
        <!-- Section Heading -->
        <div class="text-center mb-5">
            <h2 class="fw-bold display-5 mb-2" style="color: #1A202C;">Why Choose Us?</h2>
            <div class="heading-line mx-auto mb-4"></div>
            <p class="text-muted fs-5 mx-auto" style="max-width: 700px;">
                We provide a learning experience that is effective, convenient, and tailored to you.
            </p>
        </div>

        <!-- Cards Grid -->
        <div class="row g-4 justify-content-center">
            <?php foreach($why_choose_data as $item): ?>
            <div class="col-md-6 col-lg-4">
                <div class="feature-card h-100 p-4 bg-white border-0 shadow-sm d-flex align-items-start">
                    <div class="icon-box me-3">
                        <img src="<?php echo $item['image']; ?>" alt="icon" class="img-fluid" style="width: 40px;">
                    </div>
                    <div>
                        <h5 class="fw-bold mb-2 text-dark"><?php echo $item['title']; ?></h5>
                        <p class="text-muted mb-0" style="font-size: 0.95rem;">
                            <?php echo $item['description']; ?>
                        </p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<section class="subjects-section py-5 position-relative overflow-hidden" style="background-color: #F0F8FF;">
    
    <!-- Floating Planes (Decorations) -->
    <img src="assets/images/plane3.png" class="floating-plane plane-right d-none d-md-block" alt="plane">
    <img src="assets/images/leftplane3.png" class="floating-plane plane-left d-none d-md-block" alt="plane">

    <div class="container py-5">
        <h2 class="text-center fw-bold display-6 mb-5 animate-up">Subjects & Courses</h2>

        <div class="row g-4 justify-content-center">
            <?php foreach($subjects as $sub): ?>
            <div class="col-sm-6 col-md-3">
                <a href="<?php echo $sub['url']; ?>" class="text-decoration-none">
                    <div class="subject-card shadow-lg" style="background: <?php echo $sub['gradient']; ?>;">
                        
                        <!-- Background Image with Zoom -->
                        <div class="subject-bg-overlay" style="background-image: url('<?php echo $sub['bgImg']; ?>');"></div>
                        
                        <div class="subject-content text-center py-5">
                            <div class="icon-wrapper mb-3">
                                <img src="<?php echo $sub['icon']; ?>" alt="icon" class="subject-icon">
                            </div>
                            <h3 class="text-white fw-bold h4 m-0"><?php echo $sub['title']; ?></h3>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<div class="bg-light-blue py-5">
    <!-- 1. Offers Section -->
    <section class="container py-5">
        <div class="text-center mb-5">
            <!-- Floating Badge -->
            <div class="badge-float d-inline-flex align-items-center bg-white px-3 py-1 rounded-pill shadow-sm border border-light mb-3">
                <img src="assets/images/latest.png" class="me-2" alt="latest">
                <span class="small fw-bold text-muted">Latest Updates</span>
            </div>
            
            <h2 class="fw-bold display-6 mb-3 animate-up">Offers & News</h2>
            <p class="text-muted fs-5 mx-auto animate-up" style="max-width: 700px;">
                Stay updated with our latest promotions, new courses, and exciting announcements
            </p>
        </div>

        <div class="row g-4">
            <?php foreach($offers as $offer): ?>
            <div class="col-md-4 animate-up">
                <div class="offer-card h-100 p-4 bg-white shadow-sm border-0 rounded-4 transition-card">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="badge bg-soft-blue text-blue px-3 py-1 rounded-pill small"><?php echo $offer['type']; ?></span>
                        <span class="text-muted small fw-bold"><?php echo date("d/m/Y", strtotime($offer['expireDate'])); ?></span>
                    </div>
                    <h4 class="fw-bold mb-3"><?php echo $offer['title']; ?></h4>
                    <p class="text-muted flex-grow-1"><?php echo getShortText($offer['description']); ?></p>
                    <a href="offer-detail.php?id=<?php echo $offer['id']; ?>" class="btn btn-light-soft text-blue w-100 fw-bold rounded-3 mt-3">
                        Learn More <i class="fas fa-arrow-right ms-1 small"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-5">
            <a href="offer-list.php" class="btn btn-primary btn-lg px-5 py-3 rounded-pill shadow-blue fw-bold">
                View All Updates <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </section>

    <!-- 2. Success Stories Section -->
    <section class="bg-white py-5 mt-5">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold display-6 mb-3">Success Stories</h2>
                <p class="text-muted fs-5 mx-auto" style="max-width: 700px;">
                    Hear what parents and students have to say about their experience with us.
                </p>
            </div>

            <div class="row g-4">
                <?php foreach($stories as $story): ?>
                <div class="col-md-4">
                    <div class="review-card h-100 p-4 bg-light-blue rounded-4 border-0 shadow-sm text-start transition-card">
                        <div class="text-warning mb-3">
                            <?php for($i=0; $i<$story['rating']; $i++) echo "★"; ?>
                        </div>
                        <p class="text-dark fst-italic mb-4 fs-5 leading-relaxed">
                            “<?php echo $story['description']; ?>”
                        </p>
                        <div class="d-flex align-items-center mt-auto">
                            <img src="<?php echo $story['image']; ?>" class="rounded-circle border border-white shadow-sm me-3" style="width: 50px; height: 50px; object-fit: cover;">
                            <div>
                                <h6 class="fw-bold mb-0 text-dark"><?php echo $story['name']; ?></h6>
                                <p class="text-blue small mb-0 fw-bold"><?php echo $story['designation']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</div>
<!-- Trust & Credibility Section -->
<section class="trust-section py-5 position-relative" style="background-image: url('assets/images/work-bg.png'); background-size: contain; background-position: center; background-color: #F0F8FF;">
    <div class="container py-5 text-center position-relative" style="z-index: 10;">
        
        <!-- Heading -->
        <div class="mb-5 animate-up">
            <h2 class="fw-bold display-6 mb-2">Trust & Credibility</h2>
            <p class="text-muted fs-5">Join Our Growing Community of Successful Learners</p>
        </div>

        <!-- Stats Grid -->
        <div class="row g-4 justify-content-center">
            <?php foreach($trust_stats as $stat): ?>
            <div class="col-6 col-md-3">
                <div class="stat-item d-flex flex-col flex-column align-items-center">
                    
                    <!-- 3D Spinning Icon Box -->
                    <div class="stat-icon-box mb-3 shadow-lg bg-white rounded-4 border border-light">
                        <img src="<?php echo $stat['image']; ?>" alt="<?php echo $stat['title']; ?>" class="img-fluid p-2" style="width: 80px;">
                    </div>
                    
                    <h3 class="fw-bold text-dark mb-1 h2"><?php echo $stat['title']; ?></h3>
                    <p class="text-muted small fw-bold text-uppercase tracking-wider"><?php echo $stat['description']; ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<!-- Transparent Pricing Section -->
<section class="pricing-section py-5" style="background-color: #F0F8FF;">
    <div class="container py-5">
        
        <!-- Heading -->
        <div class="text-center mb-5 animate-up">
            <h2 class="fw-bold display-6 mb-3 text-dark">Transparent Pricing</h2>
            <p class="text-muted fs-5 mx-auto" style="max-width: 700px;">
                Choose a plan that works for you. No hidden fees, ever. Get started with a free trial.
            </p>
        </div>

        <!-- Pricing Grid -->
        <div class="row g-4 justify-content-center">
            <?php foreach($pricing_plans as $plan): ?>
            <div class="col-lg-4 col-md-6 animate-up">
                <div class="pricing-card h-100 bg-white rounded-4 shadow-sm border-0 d-flex flex-column overflow-hidden transition-card">
                    
                    <!-- Card Header -->
                    <div class="p-4 border-bottom bg-white">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="text-muted small fw-bold text-uppercase mb-2">Plan Name</h5>
                                <span class="badge-rose px-3 py-1 rounded-3 fw-bold small">
                                    <?php echo $plan['planName']; ?>
                                </span>
                            </div>
                            <div class="text-end">
                                <span class="text-muted small fw-bold d-block">Classes</span>
                                <span class="btn btn-primary btn-sm rounded-2 py-1 px-3 mt-1 pointer-none">
                                    <?php echo $plan['className']; ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Pricing Table Body -->
                    <div class="p-4 flex-grow-1">
                        <table class="table table-borderless mb-0">
                            <tbody>
                                <?php foreach($plan['fees'] as $fee): ?>
                                <tr class="border-bottom-faded">
                                    <td class="ps-0 py-3 fw-medium text-secondary"><?php echo $fee['label']; ?></td>
                                    <td class="pe-0 py-3 text-end fw-bold text-dark"><?php echo $fee['price']; ?></td>
                                </tr>
                                <?php endforeach; ?>
                                
                                <tr class="border-bottom-faded">
                                    <td class="ps-0 py-3 fw-medium text-secondary">Fees Per Hour</td>
                                    <td class="pe-0 py-3 text-end fw-bold text-dark"><?php echo $plan['feesPerHour']; ?></td>
                                </tr>
                                
                                <tr>
                                    <td class="ps-0 py-3 fw-medium text-secondary">Saving In Offers</td>
                                    <td class="pe-0 py-3 text-end fw-bold text-success"><?php echo $plan['off']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Card Footer Button -->
                    <div class="p-4 mt-auto">
                        <a href="pricing.php" class="btn btn-primary w-100 py-3 rounded-3 fw-bold shadow-blue hover-scale">
                            Get Started
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Bottom Actions -->
        <div class="text-center mt-5 animate-up">
            <a href="pricing.php" class="btn btn-primary btn-lg px-5 py-3 rounded-3 fw-bold shadow-blue mb-4">
                View All Plans <i class="fas fa-arrow-right ms-2"></i>
            </a>
            <p class="text-muted">
                All plans include a <span class="fw-bold text-dark">money-back guarantee</span>
            </p>
        </div>
    </div>
</section>
<!-- How It Works Section -->
<section id="howitwork" class="py-5 position-relative overflow-hidden" 
    style="background-image: url('assets/images/work-bg.png'); background-size: contain; background-position: center; background-color: #F0F8FF;">
    
    <div class="container py-5 position-relative" style="z-index: 10;">
        <!-- Heading -->
        <div class="text-center mb-5 animate-up">
            <h2 class="fw-bold display-5 mb-3" style="font-family: 'Poppins', sans-serif;">How It Works</h2>
            <p class="text-muted fs-5 mx-auto" style="max-width: 750px;">
                Getting started with your personalized learning journey is simple. Follow these four easy steps.
            </p>
        </div>

        <!-- Steps Row -->
        <div class="row g-4 justify-content-between align-items-start mt-5">
            <?php foreach($how_it_works_steps as $index => $step): ?>
            <div class="col-md-3 col-sm-6 text-center position-relative step-container animate-fade-in-up" 
                 style="animation-delay: <?php echo ($index * 0.2); ?>s;">
                
                <!-- Step Number Badge -->
                <div class="step-number shadow-sm">
                    <?php echo $step['id']; ?>
                </div>

                <!-- Icon and Arrow Container -->
                <div class="position-relative mb-4 step-icon-wrapper">
                    <img src="<?php echo $step['img']; ?>" alt="step-icon" class="img-fluid step-img">
                    
                    <!-- Arrow (Sirf desktop par aur last item ko chhod kar) -->
                    <?php if($index < count($how_it_works_steps) - 1): ?>
                    <img src="assets/images/work-arrow.png" class="step-arrow d-none d-lg-block" alt="arrow">
                    <?php endif; ?>
                </div>

                <!-- Step Text -->
                <h5 class="fw-bold px-2" style="line-height: 1.4; color: #000;">
                    <?php echo $step['text']; ?>
                </h5>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php include('includes/footer.php'); ?>