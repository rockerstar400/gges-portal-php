<?php 
/**
 * SECTION: MATH AMC (100% REACT DESIGN REPLICA)
 * Path: includes/test-prep-sections/amc-section.php
 */

// 1. Data Mapping (Master function cleaned keys use kar rahe hain)
$heroTitle   = $sectionData['hero']['title'] ?? "Who can participate in the MAA AMC?";
$heroDesc    = $sectionData['hero']['description'] ?? "";

// Participate List (amc_participate_json -> amc_participate)
$participateList = $sectionData['amc_participate'] ?? []; 

// Why Take List (amc_why_json -> amc_why)
$whyTakeList = $sectionData['amc_why'] ?? []; 

// Competition Cards (amc_comp_json -> amc_comp)
$competitions = $sectionData['amc_comp'] ?? []; 
?>

<style>
    .amc-master { font-family: 'Inter', sans-serif; color: #1f2937; overflow-x: hidden; }
    
    /* Hero & About Design matching Screenshot 1 */
    .amc-top-section {
        background-color: #F0F8FF;
        background-image: url('assets/images/about-bg-2.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        padding: 80px 0;
    }

    .amc-floating-img {
        animation: amcFloat 4s ease-in-out infinite;
        max-width: 450px;
        filter: drop-shadow(0 20px 30px rgba(0,0,0,0.1));
    }
    @keyframes amcFloat {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }

    /* 3D Competition Card matching Screenshot 2 */
    .amc-slider-box {
        background-color: #D7E9FF;
        border-radius: 30px;
        padding: 3.5rem;
        border: 1px solid #c3dafe;
        transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        min-height: 420px;
        position: relative;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    }
    .amc-slider-box:hover {
        transform: translateY(-10px);
        box-shadow: 0px 30px 60px rgba(59, 130, 246, 0.25) !important;
    }

    /* Slider logic */
    .amc-slide { display: none; animation: amcFadeEffect 0.7s ease-out forwards; }
    .amc-slide.active { display: block; }
    @keyframes amcFadeEffect { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }

    /* React Dots & Nav */
    .amc-pills { display: flex; justify-content: center; gap: 10px; margin-top: 30px; }
    .amc-pill {
        height: 10px; width: 10px; background-color: #93c5fd; border-radius: 99px;
        cursor: pointer; transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .amc-pill.active { background-color: #2563eb; width: 35px; }

    .btn-nav-amc {
        width: 50px; height: 50px; border-radius: 50%; background: white; border: none;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1); color: #2563eb; transition: 0.3s; z-index: 10;
    }
    .btn-nav-amc:hover { transform: scale(1.15); background: #eff6ff; }

    /* Why Take Section matching Screenshot 3 */
    .why-take-title { font-weight: 800; color: #111827; margin-bottom: 2rem; }
    .why-take-text { font-size: 1.15rem; line-height: 1.8; color: #4b5563; text-align: justify; }

    .btn-start-trial {
        background-color: #2563eb; color: white !important; font-weight: 700; 
        padding: 15px 45px; border-radius: 12px; transition: 0.3s; text-decoration: none; display: inline-block;
    }
    .btn-start-trial:hover { background-color: #1d4ed8; transform: translateY(-3px); box-shadow: 0 10px 20px rgba(37, 99, 235, 0.3); }
</style>

<div class="amc-master">

    <!-- ================= SECTION 1: ABOUT AMC TEST ================= -->
    <section class="amc-top-section">
        <div class="container py-4">
            <h1 class="display-5 fw-bold text-center mb-5 text-uppercase" data-aos="fade-down">ABOUT AMC TEST</h1>
            
            <!-- Hero Description -->
            <p class="fs-5 text-secondary text-center mx-auto mb-10 lh-lg" style="max-width: 1000px;" data-aos="fade-up">
                <?= $heroDesc ?>
            </p>

            <div class="row align-items-center g-5 mt-5">
                <!-- Left: Numbered List -->
                <div class="col-lg-7" data-aos="fade-right">
                    <h2 class="h2 fw-bold text-dark mb-4"><?= $heroTitle ?></h2>
                    <p class="fs-5 text-secondary mb-5">The MAA AMC proudly engages students with a dedicated group of participants, each crucial to the success of our mathematical community:</p>
                    
                    <div class="space-y-5">
                        <?php foreach($participateList as $idx => $ele): ?>
                        <div class="d-flex align-items-start mb-4" data-aos="fade-left" data-aos-delay="<?= $idx * 150 ?>">
                            <div class="fw-bold fs-4 me-4 text-dark" style="min-width: 25px;"><?= $idx + 1 ?></div>
                            <p class="fs-5 text-dark mb-0 lh-base"><?= $ele ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Right: Floating Girl Image -->
                <div class="col-lg-5 text-center" data-aos="zoom-in">
                    <img src="assets/images/amc.png" class="img-fluid amc-floating-img" alt="AMC">
                </div>
            </div>
        </div>
    </section>

    <!-- ================= SECTION 2: COMPETITIONS SLIDER ================= -->
    <section class="py-5 bg-white border-top">
        <div class="container py-5">
            <h2 class="display-6 fw-bold text-center mb-5" data-aos="fade-up">What are the different MAA AMC competitions?</h2>

            <div class="position-relative px-md-5">
                <!-- Navigation Arrows -->
                <button class="btn-nav-amc position-absolute start-0 top-50 translate-middle-y d-none d-md-flex" onclick="moveAmcSlide(-1)">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="btn-nav-amc position-absolute end-0 top-50 translate-middle-y d-none d-md-flex" onclick="moveAmcSlide(1)">
                    <i class="fas fa-chevron-right"></i>
                </button>

                <!-- 3D Slider Card -->
                <div class="amc-slider-box mx-auto" style="max-width: 1000px;" data-aos="zoom-in">
                    <div id="amc-slides-container">
                        <?php if(!empty($competitions)): foreach($competitions as $idx => $c): ?>
                            <div class="amc-slide <?= $idx === 0 ? 'active' : '' ?>">
                                <h3 class="display-4 fw-bold text-dark mb-4"><?= $c['title'] ?></h3>
                                
                                <!-- Rich Text Content from Quill -->
                                <div class="fs-5 text-primary fw-semibold mb-5 lh-lg">
                                    <?= $c['amc'] ?> 
                                </div>

                                <div class="fs-5 text-dark space-y-3 pt-4 border-top border-primary border-opacity-10">
                                    <p class="mb-3"><strong>Description:</strong> <?= $c['description'] ?></p>
                                    <div class="row">
                                        <div class="col-md-6"><p><strong>For:</strong> <?= $c['for'] ?></p></div>
                                        <div class="col-md-6"><p><strong>When:</strong> <?= $c['when'] ?></p></div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; else: ?>
                            <p class="text-center py-5">No competitions found. Add from Admin.</p>
                        <?php endif; ?>
                    </div>

                    <!-- Pagination Pills -->
                    <div class="amc-pills">
                        <?php foreach($competitions as $idx => $c): ?>
                            <div class="amc-pill <?= $idx === 0 ? 'active' : '' ?>" onclick="goToAmcSlide(<?= $idx ?>)"></div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= SECTION 3: WHY TAKE IT ================= -->
    <section class="py-5" style="background: #F0F8FF;">
        <div class="container py-5">
            <h2 class="display-5 fw-bold text-center mb-5 text-uppercase why-take-title" data-aos="fade-down">WHY TO TAKE IT?</h2>
            
            <div class="why-take-text mx-auto mb-12" style="max-width: 1100px;" data-aos="fade-up">
                <?php foreach($whyTakeList as $p): ?>
                    <p class="mb-5"><?= $p ?></p>
                <?php endforeach; ?>
            </div>

            <div class="text-center mt-5 pt-5" data-aos="zoom-in">
                <h3 class="h3 fw-bold mb-4 text-dark">So why wait? To avail a Free Trial Class for AMC Test Prep Online Tutoring</h3>
                <a href="contact.php" class="btn-start-trial shadow-lg">Start Free Trial</a>
            </div>
        </div>
    </section>

</div>

<script>
    let currentAmcIdx = 0;
    const slidesAmc = document.querySelectorAll('.amc-slide');
    const pillsAmc = document.querySelectorAll('.amc-pill');

    function refreshAmcSlider(n) {
        if(slidesAmc.length === 0) return;
        slidesAmc.forEach(s => s.classList.remove('active'));
        pillsAmc.forEach(p => p.classList.remove('active'));
        
        slidesAmc[n].classList.add('active');
        pillsAmc[n].classList.add('active');
        currentAmcIdx = n;
    }

    function moveAmcSlide(step) {
        let next = (currentAmcIdx + step + slidesAmc.length) % slidesAmc.length;
        refreshAmcSlider(next);
        resetAmcInterval();
    }

    function goToAmcSlide(n) {
        refreshAmcSlider(n);
        resetAmcInterval();
    }

    let amcAutoPlay = setInterval(() => moveAmcSlide(1), 5000);
    function resetAmcInterval() {
        clearInterval(amcAutoPlay);
        amcAutoPlay = setInterval(() => moveAmcSlide(1), 5000);
    }
</script>