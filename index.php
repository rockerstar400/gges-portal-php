

<?php 

// 1. Logic Layer sabse upar
require_once 'functions.php'; 

// 2. Database se Fresh Data Fetch karein (Jaise Node.js mein Controller karta hai)
$bannerData   = getBanner(); 
$why_choose   = getAll('why_choose');
// $subjects     = getAll('subjects');
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
$how_it_works_steps = [
    ["id" => 1, "img" => "assets/images/subject.png", "text" => "Choose a subject"],
    ["id" => 2, "img" => "assets/images/right-tutorial.png", "text" => "Match with the right tutor"],
    ["id" => 3, "img" => "assets/images/session.png", "text" => "Learn through interactive online sessions"],
    ["id" => 4, "img" => "assets/images/progress.png", "text" => "Track progress"]
];

$offers       = getAll('offers');
// Database se data fetch karein
$offers = getLatest('offers', 3);
// Note: functions.php mein humne 'success_stories' table ke liye function banaya tha
$successData = getLatest('success_stories', 3); 
$stories      = getAll('testimonials');
$trust_list   = getAll('trust_stats');
// Agar database khali hai, toh hum functions.php mein default arrays daal sakte hain.

// 3. UI Parts (Sirf ek baar)
include('includes/header.php'); 
include('includes/navbar.php'); 
?>


<!-- --- HERO SECTION --- -->
<?php if($bannerData): ?>
<section class="hero-banner-container">
    <img src="<?php echo $bannerData['image']; ?>" class="hero-banner-img" alt="Banner">
    <div class="hero-text-overlay animate-up text-center">
        <div class="container">
            <h1 class="display-3 fw-bold text-white"><?php echo $bannerData['title']; ?></h1>
            <p class="lead text-white fs-4"><?php echo $bannerData['description']; ?></p>
            <div class="mt-4">
                <a href="contact.php" class="btn btn-primary btn-lg px-5 py-3 rounded-3 shadow-lg fw-bold">
                    Start Free Trial <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- --- MARQUEE --- -->
<div class="bg-primary text-white py-2">
    <marquee behavior="scroll" direction="left" class="fw-bold">
        <?php echo $bannerData ? $bannerData['title'] : "Welcome to GGES Portal!"; ?>
    </marquee>
</div>


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
<?php 
$why_choose_list = getAll('why_choose'); 
?>

<!-- <section class="why-choose-section py-5">
    <div class="container">
        <div class="row g-4">
            <?php foreach($why_choose_list as $item): ?>
            <div class="col-md-4">
                <div class="card p-4 border-0 shadow-sm rounded-4">
                    <img src="<?php echo $item['image']; ?>" class="mb-3" style="width: 50px;">
                    <h5 class="fw-bold"><?php echo $item['title']; ?></h5>
                    <p class="text-muted"><?php echo $item['description']; ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section> -->


<!-- AOS Library for Motion Effects (If not in header) -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<style>
    .why-choose-wrapper {
        background-color: #F0F8FF;
        background-image: url('assets/images/work-bg.png'); /* React: backgroundImage */
        background-size: cover;
        background-position: center;
        position: relative;
        overflow: hidden;
        padding: 100px 0;
    }

    /* Floating 3D Image Animation */
    .floating-edit-img {
        position: absolute;
        top: 10%;
        left: 10%;
        width: 120px;
        opacity: 0.8;
        animation: float 4s ease-in-out infinite;
        z-index: 1;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }

    /* Heading Styles */
    .section-title-react {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 40px;
        color: #1A202C;
        margin-bottom: 10px;
    }

    .title-underline {
        width: 100px;
        height: 4px;
        background-color: #3B82F6;
        margin: 0 auto 25px;
        border-radius: 50px;
    }

    /* 3D Card Styling */
    .react-card-3d {
        background: #ffffff;
        padding: 35px 30px;
        border-radius: 24px; /* rounded-2xl */
        border: 1px solid #f3f4f6;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        display: flex;
        align-items: flex-start;
        height: 100%;
        cursor: pointer;
        transform-style: preserve-3d;
    }

    .react-card-3d:hover {
        transform: translateY(-12px) rotateX(2deg) scale(1.02);
        box-shadow: 0px 20px 40px rgba(0, 0, 0, 0.15);
    }

    /* Icon Circle */
    .icon-circle-react {
        width: 64px;
        height: 64px;
        background-color: #EFF6FF; /* blue-50 */
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 20px;
        flex-shrink: 0;
        transition: 0.4s;
    }

    .react-card-3d:hover .icon-circle-react {
        transform: rotate(15deg) scale(1.1);
    }

    .card-title-react {
        font-weight: 700;
        font-size: 20px;
        color: #1f2937;
        margin-bottom: 8px;
    }

    .card-desc-react {
        color: #4b5563;
        line-height: 1.6;
        font-size: 16px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .section-title-react { font-size: 32px; }
        .floating-edit-img { display: none; }
    }
</style>

<section class="why-choose-wrapper">
    <!-- Floating Decoration -->
    <img src="assets/images/editImg.png" class="floating-edit-img shadow-sm" alt="deco">

    <div class="container position-relative" style="z-index: 2;">
        <!-- Heading Section -->
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="section-title-react">Why Choose Us?</h2>
            <div class="title-underline"></div>
            <p class="text-secondary fs-5 mx-auto" style="max-width: 700px;">
                We provide a learning experience that is effective, convenient, and tailored to you.
            </p>
        </div>

        <!-- Cards Grid -->
        <div class="row g-4 justify-content-center">
            <?php foreach($why_choose_list as $idx => $item): ?>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo $idx * 150; ?>">
                <div class="react-card-3d">
                    <div class="icon-circle-react">
                        <img src="<?php echo $item['image']; ?>" alt="icon" style="width: 32px; height: 32px; object-fit: contain;">
                    </div>
                    <div>
                        <h3 class="card-title-react"><?php echo $item['title']; ?></h3>
                        <p class="card-desc-react"><?php echo $item['description']; ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- AOS Script (Ensure this is in footer or here) -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init({
    duration: 800,
    once: true,
  });
</script>


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

<!-- offers -->
<!-- <div class="row g-4">
    <?php foreach($offers as $offer): ?>
    <div class="col-md-4">
        <div class="offer-card p-4 bg-white shadow-sm rounded-4 border-top border-primary border-4 h-100">
            <div class="d-flex justify-content-between mb-3">
                <span class="badge bg-soft-blue text-primary"><?php echo $offer['type']; ?></span>
                <small class="text-muted"><?php echo $offer['expireDate'] ? date('d M, Y', strtotime($offer['expireDate'])) : ''; ?></small>
            </div>
            <h4 class="fw-bold"><?php echo $offer['title']; ?></h4>
            <p class="text-muted"><?php echo getShortText($offer['description'], 80); ?></p>
            <a href="offer-detail.php?id=<?php echo $offer['id']; ?>" class="btn btn-light-soft w-100 mt-auto">Learn More</a>
        </div>
    </div>
    <?php endforeach; ?>
</div> -->
<section class="py-5" style="background-color: #F0F8FF;">
    <div class="container py-5 text-center">
        <!-- Animated Badge (React Style) -->
        <div class="d-inline-flex align-items-center bg-white px-4 py-1 rounded-pill shadow-sm border mb-4 badge-float">
            <img src="assets/images/latest.png" class="me-2" style="width: 16px;">
            <span class="small fw-bold text-muted">Latest Updates</span>
        </div>

        <h2 class="fw-bold display-5 mb-2 text-dark">Offers & News</h2>
        <p class="text-muted fs-5 mx-auto mb-5" style="max-width: 700px;">
            Stay updated with our latest promotions, new courses, and exciting announcements
        </p>

        <div class="row g-4">
            <?php if($offers): foreach($offers as $offer): ?>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-md rounded-5 p-4 text-start transition-card bg-white">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="badge rounded-pill px-3 py-2 text-uppercase" style="background: #EBF8FF; color: #305CDE; font-size: 10px; font-weight: 700; letter-spacing: 1px;">
                            <?php echo $offer['type']; ?>
                        </span>
                        <small class="text-muted fw-bold" style="font-size: 12px;">
                            <?php echo date('d/m/Y', strtotime($offer['created_at'])); ?>
                        </small>
                    </div>
                    <h4 class="fw-bold text-dark mb-3"><?php echo $offer['title']; ?></h4>
                    <p class="text-muted mb-4 flex-grow-1">
                        <?php echo getShortText($offer['description'], 100); ?>
                    </p>
                    <a href="offer-detail.php?id=<?php echo $offer['id']; ?>" class="btn w-100 py-3 fw-bold rounded-4" style="background: #F8FAFC; color: #305CDE; font-size: 14px;">
                        Learn More →
                    </a>
                </div>
            </div>
            <?php endforeach; endif; ?>
        </div>

        <div class="mt-5 pt-3">
            <a href="offer-list.php" class="btn btn-primary px-5 py-3 rounded-pill fw-bold shadow-blue">
                View All Updates →
            </a>
        </div>
    </div>
</section>

<section class="py-5 bg-white">
        <div class="container py-5 text-center">
            <h2 class="fw-bold display-5 mb-2">Success Stories</h2>
            <p class="text-muted fs-5 mb-5">Hear what parents and students have to say about their experience with us.</p>

            <div class="row g-4">
                <?php if($successData): foreach($successData as $index => $story): ?>
                <div class="col-md-4 animate-up" style="animation-delay: <?php echo $index * 0.2; ?>s;">
                    <div class="card h-100 p-4 p-lg-5 border-0 rounded-5 transition-card text-start" style="background-color: #F0F8FF; border: 1px solid #EBF8FF !important;">
                        <!-- Rating Stars -->
                        <div class="text-warning mb-4 fs-5">
                            <?php 
                                $rating = (int)$story['rating'];
                                for($i=1; $i<=5; $i++) {
                                    echo ($i <= $rating) ? '★' : '<span class="text-muted opacity-25">★</span>';
                                }
                            ?>
                        </div>
                        
                        <!-- Description -->
                        <p class="text-dark fst-italic fs-5 mb-5 leading-relaxed">
                            “<?php echo $story['description']; ?>”
                        </p>

                        <!-- User Info -->
                        <div class="d-flex align-items-center mt-auto">
                            <div class="rounded-circle shadow-sm border border-4 border-white overflow-hidden me-3" style="width: 55px; height: 55px;">
                                <img src="<?php echo $story['image']; ?>" class="w-100 h-100 object-fit-cover" onerror="this.src='https://via.placeholder.com/55'">
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0 text-dark"><?php echo $story['name']; ?></h6>
                                <small class="text-primary fw-bold"><?php echo $story['designation']; ?></small>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; endif; ?>
            </div>
        </div>
    </section>
<!-- Trust & Credibility Section -->
  

<section class="trust-section py-5" style="background-color: #F0F8FF;">
    <div class="container text-center">
        <div class="mb-5 animate-up">
            <h2 class="fw-bold display-6 mb-2">Trust & Credibility</h2>
            <p class="text-muted fs-5">Join Our Growing Community of Successful Learners</p>
        </div>

        <div class="row g-4 justify-content-center">
            <?php if(!empty($trust_list)): ?>
                <?php foreach($trust_list as $stat): ?>
                <div class="col-6 col-md-3">
                    <div class="stat-item d-flex flex-column align-items-center">
                        <div class="stat-icon-box mb-3 shadow-lg bg-white rounded-4 border border-light" style="width: 85px; height: 85px; display: flex; align-items: center; justify-content: center;">
                            <!-- Image path fix -->
                            <img src="<?php echo $stat['image']; ?>" alt="icon" class="img-fluid p-2" style="width: 50px;">
                        </div>
                        <h3 class="fw-bold text-dark mb-1 h2"><?php echo $stat['title']; ?></h3>
                        <p class="text-muted small fw-bold text-uppercase tracking-wider"><?php echo $stat['description']; ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Database khali hone par ye dikhega -->
                <p class="text-muted">No stats added yet.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Transparent Pricing Section -->
<?php 
$pricing_data = getPricing(); 
?>

<section class="py-16 px-5 text-center bg-light-blue">
    <div class="container max-w-7xl">
        
        <!-- --- STATIC HEADER --- -->
        <div class="mb-5 animate-up">
            <h2 class="text-3xl md:text-4xl font-bold mb-3 text-dark">Transparent Pricing</h2>
            <p class="text-muted text-lg mb-5">
                Choose a plan that works for you. No hidden fees, ever. Get started with a free trial.
            </p>
        </div>

        <!-- --- DYNAMIC GRID --- -->
        <div class="row g-4 justify-content-center">
            <?php foreach($pricing_data as $index => $ele): 
                // JSON string ko PHP Array mein convert karein
                $feesList = json_decode($ele['fees'], true);
            ?>
            <div class="col-lg-4 col-md-6 animate-up" style="animation-delay: <?php echo $index * 0.1; ?>s;">
                <div class="pricing-card h-100 bg-white rounded-4 shadow-sm border border-light d-flex flex-column transition-card">
                    
                    <div class="table-responsive p-3">
                        <table class="table table-borderless align-middle mb-0">
                            <thead>
                                <tr class="border-bottom">
                                    <th class="text-start py-3">
                                        <span class="small text-muted fw-bold d-block">Plan Name</span>
                                        <span class="badge bg-rose-light text-rose mt-2 px-3 py-1 rounded-3">
                                            <?php echo $ele['planName']; ?>
                                        </span>
                                    </th>
                                    <th class="text-center py-3">
                                        <span class="small text-muted fw-bold d-block">Classes</span>
                                        <button class="btn btn-primary btn-sm mt-2 rounded-2"><?php echo $ele['className']; ?></button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($feesList): foreach($feesList as $fee): ?>
                                <tr class="border-bottom-faded">
                                    <td class="text-start py-3 text-secondary fw-medium"><?php echo $fee['label']; ?></td>
                                    <td class="text-center py-3 text-dark fw-bold"><?php echo $fee['price']; ?></td>
                                </tr>
                                <?php endforeach; endif; ?>

                                <!-- STATIC LABELS WITH DYNAMIC VALUES -->
                                <tr class="border-bottom-faded">
                                    <td class="text-start py-3 text-secondary fw-medium">Fees Per Hour</td>
                                    <td class="text-center py-3 text-dark fw-bold"><?php echo $ele['feesPerHour'] ?: '-'; ?></td>
                                </tr>
                                <tr>
                                    <td class="text-start py-3 text-secondary fw-medium">Saving In Offers</td>
                                    <td class="text-center py-3 text-success fw-bold"><?php echo $ele['off'] ?: '-'; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="p-4 mt-auto">
                        <a href="contact.php" class="btn btn-primary w-100 py-3 rounded-3 fw-bold shadow-blue hover-scale">
                            Get Started
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Static View All Button -->
        <div class="mt-5">
            <a href="pricing.php" class="btn btn-primary btn-lg px-5 py-3 rounded-pill fw-bold shadow-blue">
                View All Plans <i class="fas fa-arrow-right ms-2"></i>
            </a>
            <p class="mt-4 text-muted">All plans include a <span class="fw-bold text-dark">money-back guarantee</span></p>
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