<?php 
/**
 * SECTION: ABOUT INFO (ELA)
 * Logic: Auto-Slider + React Design Replica
 */

$aboutData = getTestPrepData('eng-about-ela');

$description = $aboutData['about_ela_main_desc'] ?? '';
$heading     = $aboutData['about_ela_heading'] ?? '';
$whoTake     = $aboutData['about_ela_whotake_html'] ?? '';
$qTypes      = json_decode($aboutData['about_ela_question_json'] ?? '[]', true) ?: [];
?>

<style>
    .about-ela-wrapper {
        background-color: #F0F8FF;
        background-image: url('assets/images/math-bg.png'); /* Pattern matching screenshot */
        background-size: contain;
        background-position: center;
        background-repeat: repeat;
        background-blend-mode: overlay;
        min-height: 100vh;
        color: #1f2937;
    }

    /* Centered Text Logic */
    .ela-title-main { font-weight: 900; letter-spacing: 1px; color: #111827; margin-bottom: 2rem; }
    .ela-sub-text { font-size: 1.15rem; line-height: 1.8; color: #4b5563; text-align: center; max-width: 1000px; margin: 0 auto; }

    /* 3D Animated Slider Card */
    .slider-card-3d {
        background: rgba(240, 248, 255, 0.7); /* Matching bg but slightly highlighted */
        border-radius: 24px;
        padding: 4rem 2rem;
        border: 1px solid #dbeafe; /* blue-100 */
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        min-height: 350px;
        max-width: 1000px;
        margin: 0 auto;
    }

    .slider-card-3d:hover {
        transform: translateY(-10px);
        box-shadow: 0px 25px 50px -12px rgba(37, 99, 235, 0.2) !important;
        background: #ffffff;
    }

    /* Slide Content Logic */
    .slide-item {
        display: none;
        animation: fadeInSlide 0.8s ease-out forwards;
    }
    .slide-item.active { display: block; }

    @keyframes fadeInSlide {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* React Spring Dots */
    .dot-box { display: flex; justify-content: center; gap: 10px; margin-top: 30px; }
    .dot {
        height: 10px; width: 10px;
        background-color: #93c5fd; /* blue-300 */
        border-radius: 99px;
        cursor: pointer;
        transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .dot.active {
        background-color: #2563eb; /* blue-600 */
        width: 35px; /* Pill shape */
    }

    .section-label { font-weight: 800; color: #1e3a8a; margin-top: 40px; margin-bottom: 20px; }
</style>

<div class="about-ela-wrapper py-5 px-3">
    
    <!-- 1. HERO TITLE -->
    <div class="container py-4 text-center" data-aos="fade-down">
        <h1 class="display-6 fw-bold ela-title-main text-uppercase">ALL YOU NEED TO KNOW ABOUT ELA</h1>
    </div>

    <main class="container py-4">
        
        <!-- 2. MAIN DESCRIPTION -->
        <div class="mb-5" data-aos="fade-up">
            <p class="ela-sub-text"><?= $description ?></p>
        </div>

        <!-- 3. SECONDARY HEADING -->
        <div class="text-center mb-5" data-aos="fade-up" data-aos-delay="100">
            <h2 class="h3 fw-bold text-dark">( <?= $heading ?> )</h2>
        </div>

        <!-- 4. WHO TAKES THIS TEST -->
        <section class="text-center mb-5" data-aos="fade-up" data-aos-delay="200">
            <h3 class="h4 fw-bold mb-4">Who takes this test?</h3>
            <div class="ela-sub-text">
                <?= $whoTake ?>
            </div>
        </section>

        <!-- 5. WHAT IS ON THE TEST SLIDER -->
        <section class="py-5">
            <div class="text-center mb-5" data-aos="fade-up">
                <h3 class="h4 fw-bold text-dark">What is on the test?</h3>
                <p class="fw-bold text-dark mt-4 h5">Core components and formats</p>
            </div>

            <!-- 🔥 3D Animated Slider Card -->
            <div class="slider-card-3d shadow-sm" data-aos="zoom-in">
                
                <div id="reactStyleSlider">
                    <?php if(!empty($qTypes)): foreach($qTypes as $idx => $q): ?>
                        <div class="slide-item <?= $idx === 0 ? 'active' : '' ?>" data-index="<?= $idx ?>">
                            <h3 class="display-6 fw-bold text-center mb-4" style="color: #4b5563;"><?= $q['title'] ?></h3>
                            <div class="text-center px-md-5">
                                <p class="fs-5 text-secondary lh-lg mx-auto" style="max-width: 800px; font-weight: 500;">
                                    <?= $q['description'] ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; endif; ?>
                </div>

                <!-- React Pill Dots -->
                <div class="dot-box">
                    <?php foreach($qTypes as $idx => $q): ?>
                        <div class="dot <?= $idx === 0 ? 'active' : '' ?>" 
                             onclick="manualSlide(<?= $idx ?>)" 
                             data-index="<?= $idx ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </main>
</div>

<script>
    let slideIndex = 0;
    const allSlides = document.querySelectorAll('.slide-item');
    const allDots = document.querySelectorAll('.dot');

    function changeSlide(n) {
        if(allSlides.length === 0) return;
        
        allSlides.forEach(s => s.classList.remove('active'));
        allDots.forEach(d => d.classList.remove('active'));

        allSlides[n].classList.add('active');
        allDots[n].classList.add('active');
        slideIndex = n;
    }

    function manualSlide(n) {
        changeSlide(n);
        stopTimer();
        startTimer();
    }

    function autoNext() {
        let n = (slideIndex + 1) % allSlides.length;
        changeSlide(n);
    }

    let timer = setInterval(autoNext, 4000);

    function startTimer() { timer = setInterval(autoNext, 4000); }
    function stopTimer() { clearInterval(timer); }
</script>