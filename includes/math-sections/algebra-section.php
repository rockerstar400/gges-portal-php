<?php 
/**
 * SECTION: MATH AMC (100% REACT DESIGN REPLICA)
 * Logic: Auto-Slider + 3D Hover + HTML Content Support
 */

// 1. Master Data Mapping (Functions.php se decoded data)
$hero         = $sectionData['hero'] ?? []; // title, description
$aboutSection = $sectionData['about'] ?? []; // heading, description
$participate  = $sectionData['amc_participate'] ?? []; // condition in React
$whyTake      = $sectionData['amc_why'] ?? []; // whyTake in React
$competitions = $sectionData['amc_comp'] ?? []; // competition in React

// React design variables
$heroTitle = $hero['title'] ?? "Who can participate in the MAA AMC?";
$heroDesc  = $hero['description'] ?? "";
$aboutDesc = $aboutSection['description'] ?? ""; // React CompletionData.description
?>

<style>
    .amc-wrapper { font-family: 'Inter', sans-serif; color: #1f2937; }
    
    /* Hero & About Styles */
    .amc-about-bg {
        background-color: #F0F8FF;
        background-image: url('assets/images/about-bg-2.png');
        background-size: contain;
        background-position: center;
        background-repeat: no-repeat;
    }

    .amc-floating-img {
        animation: amcFloat 4s ease-in-out infinite;
        border-radius: 1rem;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }
    @keyframes amcFloat {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }

    /* 3D Competition Card (React-style) */
    .amc-3d-card {
        background-color: #D7E9FF;
        border-radius: 24px;
        padding: 3rem;
        border: 1px solid #dbeafe;
        transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        min-height: 400px;
        position: relative;
    }
    .amc-3d-card:hover {
        transform: translateY(-8px);
        box-shadow: 0px 15px 30px rgba(59, 130, 246, 0.2) !important;
    }

    /* Slider logic */
    .amc-slide { display: none; animation: amcFadeIn 0.6s ease-out forwards; }
    .amc-slide.active { display: block; }
    @keyframes amcFadeIn { from { opacity: 0; transform: translateX(20px); } to { opacity: 1; transform: translateX(0); } }

    /* React Spring Dots */
    .amc-dot-box { display: flex; justify-content: center; gap: 10px; margin-top: 30px; }
    .amc-dot {
        height: 10px; width: 10px; background-color: #93c5fd; border-radius: 99px;
        cursor: pointer; transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .amc-dot.active { background-color: #2563eb; width: 32px; }

    .btn-circle {
        width: 55px; height: 55px; border-radius: 50%; background: white; border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08); color: #2563eb; transition: 0.3s;
    }
    .btn-circle:hover { transform: scale(1.1); background: #eff6ff; }
</style>

<div class="amc-wrapper">

    <!-- ================= 1. ABOUT AMC TEST (Top) ================= -->
    <section class="amc-about-bg py-5">
        <div class="container py-5">
            <motion-div data-aos="fade-up">
                <h3 class="text-3xl font-bold text-gray-900 mb-6 text-center">ABOUT AMC TEST</h3>
                <p class="fs-5 text-gray-700 text-center mx-auto mb-12" style="max-width: 1100px;"><?= $aboutDesc ?></p>
            </motion-div>

            <div class="row align-items-center g-5 mt-5">
                <!-- Left: Participation Content -->
                <div class="col-lg-6" data-aos="fade-right">
                    <h4 class="text-3xl font-bold text-gray-900 mb-6"><?= $heroTitle ?></h4>
                    <p class="fs-5 text-gray-700 mb-6">The MAA AMC proudly engages students with a dedicated group of participants, each crucial to the success of our mathematical community:</p>
                    
                    <div class="space-y-6">
                        <?php foreach($participate as $idx => $ele): ?>
                        <div class="d-flex align-items-start mb-4" data-aos="fade-left" data-aos-delay="<?= $idx * 150 ?>">
                            <div class="fw-bold fs-4 me-4 text-dark"><?= $idx + 1 ?></div>
                            <p class="fs-5 text-gray-700 mb-0 lh-relaxed"><?= $ele ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Right: Floating Image -->
                <div class="col-lg-6 text-center" data-aos="zoom-in">
                    <img src="assets/images/amc.png" class="img-fluid amc-floating-img" alt="AMC Study">
                </div>
            </div>
        </div>
    </section>

    <!-- ================= 2. COMPETITIONS SLIDER SECTION ================= -->
    <section class="bg-light py-5">
        <div class="container py-5">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="text-3xl sm:text-4xl font-semibold">What are the different MAA AMC competitions?</h2>
            </div>

            <div class="position-relative max-width-1100 mx-auto px-md-5">
                <!-- Navigation -->
                <button class="btn-circle position-absolute start-0 top-50 translate-middle-y d-none d-md-flex z-index-2 shadow" onclick="changeAmcSlide(-1)">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="btn-circle position-absolute end-0 top-50 translate-middle-y d-none d-md-flex z-index-2 shadow" onclick="changeAmcSlide(1)">
                    <i class="fas fa-chevron-right"></i>
                </button>

                <!-- 3D Slider Card -->
                <div class="amc-3d-card mx-auto shadow-sm" data-aos="zoom-in">
                    <div id="amc-carousel-wrapper">
                        <?php if(!empty($competitions)): foreach($competitions as $idx => $c): ?>
                            <div class="amc-slide <?= $idx === 0 ? 'active' : '' ?>" data-index="<?= $idx ?>">
                                <h3 class="display-6 fw-bold text-dark mb-4"><?= $c['title'] ?></h3>
                                
                                <!-- Rich Text Content from Quill -->
                                <div class="fs-5 text-secondary fw-semibold mb-4 lh-lg">
                                    <?= $c['amc'] ?>
                                </div>

                                <div class="fs-5 text-gray-700 space-y-3 pt-4 border-top border-primary border-opacity-10">
                                    <p class="mb-2"><strong>Description:</strong> <?= $c['description'] ?></p>
                                    <p class="mb-2"><strong>For:</strong> <?= $c['for'] ?></p>
                                    <p class="mb-0"><strong>When:</strong> <?= $c['when'] ?></p>
                                </div>
                            </div>
                        <?php endforeach; endif; ?>
                    </div>

                    <!-- React Dots -->
                    <div class="amc-dot-box">
                        <?php foreach($competitions as $idx => $c): ?>
                            <div class="amc-dot <?= $idx === 0 ? 'active' : '' ?>" onclick="setAmcSlide(<?= $idx ?>)"></div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= 3. WHY TO TAKE IT SECTION ================= -->
    <section class="py-5 bg-white">
        <div class="container py-5 text-center" data-aos="fade-up">
            <h1 class="display-5 fw-bold mb-5">WHY TO TAKE IT?</h1>
            <div class="fs-5 text-gray-600 lh-lg mx-auto mb-10" style="max-width: 1000px; text-align: justify;">
                <?php foreach($whyTake as $p): ?>
                    <p class="mb-6"><?= $p ?></p>
                <?php endforeach; ?>
            </div>

            <div class="mt-5">
                <h3 class="h3 fw-bold mb-4 text-dark">So why wait? To avail a Free Trial Class for AMC Test Prep Online Tutoring</h3>
                <a href="contact.php" class="btn btn-primary btn-lg px-5 py-3 rounded-3 shadow fw-bold">Start Free Trial</a>
            </div>
        </div>
    </section>

</div>

<script>
    let currentIdx = 0;
    const slides = document.querySelectorAll('.amc-slide');
    const dots = document.querySelectorAll('.amc-dot');

    function updateAmcSlider(n) {
        if(slides.length === 0) return;
        
        slides.forEach(s => s.classList.remove('active'));
        dots.forEach(d => d.classList.remove('active'));
        
        slides[n].classList.add('active');
        dots[n].classList.add('active');
        currentIdx = n;
    }

    function changeAmcSlide(step) {
        let next = (currentIdx + step + slides.length) % slides.length;
        updateAmcSlider(next);
        resetAmcTimer();
    }

    function setAmcSlide(n) {
        updateAmcSlider(n);
        resetAmcTimer();
    }

    // Auto Advance Logic (4 seconds like React code)
    let amcTimer = setInterval(() => changeAmcSlide(1), 4000);

    function resetAmcTimer() {
        clearInterval(amcTimer);
        amcTimer = setInterval(() => changeAmcSlide(1), 4000);
    }
</script>