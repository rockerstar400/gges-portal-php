<?php 
require_once 'functions.php'; 

// 1. Data Fetching (React ke Promise.all jaisa)
$aboutData = getAbout(); 
$members = getMembers(); 

// 2. JSON Decoding (MongoDB Arrays to PHP Arrays)
$description = json_decode($aboutData['description'] ?? '[]', true);
$whyUs = json_decode($aboutData['why_us'] ?? '[]', true);
$howDiff = json_decode($aboutData['how_different'] ?? '[]', true);
$safety = json_decode($aboutData['safety'] ?? '[]', true);

include('includes/header.php'); 
include('includes/navbar.php'); 
?>

<div class="about-page-wrapper overflow-hidden" style="background-color: #F0F8FF;">

    <!-- --- HERO SECTION --- -->
    <div class="relative py-20 px-4" style="background-image: url('assets/images/price-bg.png'); background-size: cover; background-position: center;">
        <div class="container max-w-7xl mx-auto">
            <p class="text-3xl md:text-4xl font-bold text-center mb-16 animate-up">About Us</p>

            <div class="row align-items-center g-5">
                <!-- Hero Image -->
                <div class="col-lg-6 text-center animate-side-left">
                    <?php if(!empty($aboutData['image'])): ?>
                        <img src="<?php echo $aboutData['image']; ?>" alt="About" class="rounded-4 shadow-lg img-fluid float-anim" style="max-width: 550px;">
                    <?php endif; ?>
                </div>

                <!-- Main Description (React logic: First 2 paragraphs) -->
                <div class="col-lg-6 animate-side-right">
                    <div class="space-y-4">
                        <?php foreach(array_slice($description, 0, 2) as $index => $para): ?>
                            <p class="text-secondary fs-5 leading-relaxed mb-4 animate-up" style="animation-delay: <?php echo $index * 0.2; ?>s;">
                                <?php echo $para; ?>
                            </p>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Remaining Description -->
            <div class="mt-5 animate-up" style="animation-delay: 0.5s;">
                <?php foreach(array_slice($description, 2) as $para): ?>
                    <p class="text-secondary fs-5 leading-relaxed mb-3"><?php echo $para; ?></p>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- --- LEADERSHIP SECTION --- -->
    <?php if(!empty($members)): ?>
    <section class="bg-light py-16 border-top border-bottom">
        <div class="container max-w-7xl mx-auto">
            <div class="text-center mb-5 pb-4">
                <h6 class="text-primary fw-bold tracking-widest text-uppercase small">Our Leadership</h6>
                <h2 class="fw-extrabold display-5 mt-2">Meet the Management Team</h2>
            </div>

            <div class="row g-5 justify-content-center mt-5">
                <?php foreach($members as $index => $m): ?>
                <div class="col-lg-5 col-md-6 mb-5 animate-up" style="animation-delay: <?php echo $index * 0.2; ?>s;">
                    <div class="management-card bg-white p-4 p-md-5 pt-5 rounded-4 shadow-lg text-center position-relative transition-card border-0">
                        <!-- Avatar Section -->
                        <div class="member-avatar-container">
                            <div class="member-avatar-circle shadow-md">
                                <img src="<?php echo $m['image']; ?>" alt="<?php echo $m['name']; ?>" class="img-fluid" onerror="this.src='https://via.placeholder.com/150'">
                            </div>
                        </div>
                        <!-- Bio Section -->
                        <div class="mt-4 pt-2">
                            <h3 class="fw-bold h4 mb-1"><?php echo $m['name']; ?></h3>
                            <p class="text-primary fw-bold small text-uppercase mb-4"><?php echo $m['role']; ?></p>
                            <p class="text-muted small leading-relaxed text-justify"><?php echo $m['description']; ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- --- WHY US SECTION --- -->
    <section id="whyus" class="py-16 bg-white">
        <div class="container max-w-7xl mx-auto">
            <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 d-flex align-items-center justify-content-center gap-3">
                <i class="fas fa-shield-alt text-indigo"></i> Why Us?
            </h2>
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <?php foreach($whyUs as $index => $point): ?>
                        <p class="text-secondary fs-5 mb-4 leading-relaxed animate-up" style="animation-delay: <?php echo $index * 0.1; ?>s;">
                            <i class="fas fa-check-circle text-success me-2"></i> <?php echo $point; ?>
                        </p>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- --- HOW DIFFERENT & SAFETY --- -->
    <section class="py-16" style="background-color: #F0F8FF;">
        <div class="container max-w-6xl mx-auto">
            <!-- How Different -->
            <h2 class="text-2xl md:text-4xl font-bold text-center mb-10">
                <i class="fas fa-sparkles text-warning me-2"></i> <?php echo $aboutData['how_diff_header'] ?: 'How Are We Different?'; ?>
            </h2>
            <div class="row g-4 mb-5">
                <?php foreach($howDiff as $point): ?>
                    <div class="col-md-6">
                        <div class="p-4 bg-white shadow-sm rounded-4 h-100 border-start border-4 border-primary">
                            <p class="m-0 fw-medium text-dark">• <?php echo $point; ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Safety -->
            <div class="mt-20">
                <h3 class="text-2xl md:text-4xl font-bold text-center mb-10"><i class="fas fa-user-shield text-primary me-2"></i> Safety</h3>
                <div class="row g-4">
                    <?php foreach($safety as $point): ?>
                        <div class="col-md-6">
                            <div class="p-4 bg-white shadow-sm rounded-4 h-100 text-secondary">
                                <?php echo $point; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Tutors Section -->
            <div class="mt-20 p-5 bg-white shadow-lg rounded-5 text-center animate-up">
                <h3 class="fw-bold mb-4"><i class="fas fa-chalkboard-teacher text-primary me-2"></i> Our Tutors</h3>
                <p class="fs-5 text-secondary m-0"><?php echo $aboutData['tutor_desc']; ?></p>
            </div>
        </div>
    </section>

</div>

<?php include('includes/footer.php'); ?>