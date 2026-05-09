<?php 
/**
 * SECTION: ABOUT ELA (About Info Page)
 * Path: includes/english-sections/about-info-section.php
 * Note: $prepData is fetched in the main courses-english.php file using slug 'eng-about-ela'
 */

$aboutData = getTestPrepData('eng-about-ela');

// Mapping variables based on Admin Save Logic
$description = $aboutData['about_ela_main_desc'] ?? '';
$heading     = $aboutData['about_ela_heading'] ?? '';
$whoTake     = $aboutData['about_ela_whotake_html'] ?? '';
$qTypes      = json_decode($aboutData['about_ela_question_json'] ?? '[]', true) ?: [];
?>

<style>
    .about-ela-wrapper {
        background-color: #F0F8FF;
        background-image: url('assets/images/about-bg.png');
        background-size: contain;
        background-position: center;
        min-height: 100vh;
        position: relative;
        overflow: hidden;
    }

    /* 3D Slider Card Logic */
    .slider-card-3d {
        background: #F0F8FF;
        border-radius: 24px;
        padding: 3rem;
        border: 1px solid rgba(191, 219, 254, 0.5); /* blue-100/50 */
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        position: relative;
        z-index: 10;
        min-height: 350px;
    }

    .slider-card-3d:hover {
        transform: translateY(-10px);
        box-shadow: 0px 20px 40px rgba(59, 130, 246, 0.15);
    }

    /* Slider Content Animations */
    .slide-content {
        display: none;
        animation: slideIn 0.6s ease-out forwards;
    }

    .slide-content.active {
        display: block;
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateX(20px); }
        to { opacity: 1; transform: translateX(0); }
    }

    /* Pagination Dots (Spring Animation) */
    .dot-container {
        display: flex;
        justify-content: center;
        gap: 12px;
        margin-top: 40px;
    }

    .dot {
        height: 12px;
        border-radius: 99px;
        background-color: #bfdbfe; /* blue-300 */
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        width: 12px;
    }

    .dot.active {
        background-color: #2563eb; /* blue-600 */
        width: 32px;
    }

    .text-gray-600 { color: #4b5563; }
</style>

<div class="about-ela-wrapper py-5 px-3">
    
    <!-- Title Section -->
    <div class="container py-4 text-center" data-aos="fade-down">
        <h1 class="display-5 fw-extrabold text-dark mb-0">ALL YOU NEED TO KNOW ABOUT ELA</h1>
    </div>

    <main class="container py-4" style="max-width: 1100px;">
        
        <!-- Description Paragraph -->
        <div class="mb-5" data-aos="fade-up">
            <p class="fs-5 text-gray-600 lh-lg"><?= $description ?></p>
        </div>

        <!-- Heading -->
        <div class="mb-4" data-aos="fade-up" data-aos-delay="100">
            <h2 class="display-6 fw-bold text-gray-600 text-start"><?= $heading ?></h2>
        </div>

        <!-- Who Takes This Test Section -->
        <section class="py-5" data-aos="fade-up" data-aos-delay="200">
            <h3 class="h2 fw-bold mb-4 text-center text-dark">Who takes this test?</h3>
            <div class="fs-5 text-gray-600 lh-relaxed">
                <?= $whoTake ?> <!-- Quill HTML Output -->
            </div>
        </section>

        <!-- What is on the test Slider -->
        <section class="py-5">
            <div class="text-center mb-5" data-aos="fade-up">
                <h3 class="h2 fw-bold text-dark mb-3">What is on the test?</h3>
                <h4 class="h5 fw-semibold text-secondary">Core components and formats</h4>
            </div>

            <!-- 🔥 3D Animated Slider Card -->
            <div class="slider-card-3d mx-auto max-width-900" data-aos="zoom-in">
                
                <div id="qTypeSlider">
                    <?php if(!empty($qTypes)): foreach($qTypes as $idx => $q): ?>
                        <div class="slide-content <?= $idx === 0 ? 'active' : '' ?>" data-index="<?= $idx ?>">
                            <h3 class="display-6 fw-bold text-center text-gray-600 mb-5"><?= $q['title'] ?></h3>
                            <div class="text-center">
                                <p class="fs-4 text-dark fw-medium lh-base mx-auto" style="max-width: 800px;">
                                    <?= $q['description'] ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; endif; ?>
                </div>

                <!-- Pagination Dots -->
                <div class="dot-container">
                    <?php foreach($qTypes as $idx => $q): ?>
                        <div class="dot <?= $idx === 0 ? 'active' : '' ?>" 
                             onclick="goToSlide(<?= $idx ?>)" 
                             data-index="<?= $idx ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </main>
</div>

<script>
    let currentSlide = 0;
    const slides = document.querySelectorAll('.slide-content');
    const dots = document.querySelectorAll('.dot');
    const totalSlides = slides.length;

    function showSlide(index) {
        slides.forEach(s => s.classList.remove('active'));
        dots.forEach(d => d.classList.remove('active'));

        slides[index].classList.add('active');
        dots[index].classList.add('active');
        currentSlide = index;
    }

    function goToSlide(index) {
        showSlide(index);
        resetTimer();
    }

    function nextSlide() {
        let next = (currentSlide + 1) % totalSlides;
        showSlide(next);
    }

    let slideTimer = setInterval(nextSlide, 4000);

    function resetTimer() {
        clearInterval(slideTimer);
        slideTimer = setInterval(nextSlide, 4000);
    }
</script>