<?php 
/**
 * SECTION: ACCUPLACER FRONTEND (EXACT REACT 3D REPLICA)
 * Logic: Custom 3D CSS + AOS for Framer Motion feel + Multiple Dynamic Grids.
 */

// Mapping Variables based on Admin Logic & Database Columns
$hero            = $sectionData['hero'] ?? [];
$heroTitle       = $sectionData['accu_hero_title'] ?? ($hero['title'] ?? "ACCUPLACER TEST PREP");
$heroDescription = $sectionData['accu_hero_desc'] ?? ($hero['description'] ?? "");

$aboutHeading     = $sectionData['accu_about_heading'] ?? "";
$aboutDescription = $sectionData['accu_about_desc'] ?? "";

$whatsHeading     = $sectionData['accu_whats_heading'] ?? "";
$whatsDescription = $sectionData['accu_whats_desc'] ?? "";

// Repeaters
$testList         = $sectionData['accu_test_list'] ?? []; // Inside the Tests
$writeDesc        = $sectionData['accu_write_desc_html'] ?? "";
$writeList        = $sectionData['accu_write_list'] ?? []; // WritePlacer List
$eslDesc          = $sectionData['accu_esl_desc_html'] ?? "";
$eslList          = $sectionData['accu_esl_list'] ?? [];  // ESL List
?>

<style>
    /* --- 1. Perspective Wrapper for 3D Feel --- */
    .accu-master-wrapper {
        font-family: 'Inter', sans-serif;
        color: #1f2937;
        perspective: 1200px;
        overflow-x: hidden;
    }

    /* --- 2. 3D Animation Definition (AOS Custom) --- */
    [data-aos="accu-3d-up"] {
        opacity: 0;
        transform: translateY(60px) rotateX(-15deg) scale(0.95);
        transition-property: transform, opacity;
    }
    [data-aos="accu-3d-up"].aos-animate {
        opacity: 1;
        transform: translateY(0) rotateX(0) scale(1);
    }

    /* --- 3. Card 3D Hover Logic --- */
    .accu-card-3d {
        background: #ffffff;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        transform-style: preserve-3d;
        border-left: 4px solid #1d4ed8; /* Blue-700 from React */
        height: 100%;
        margin-bottom: 20px;
    }
    .accu-card-3d:hover {
        transform: translateY(-8px) rotateX(5deg) rotateY(2deg) scale(1.02);
        box-shadow: 0px 25px 50px -12px rgba(0, 0, 0, 0.25);
        z-index: 10;
    }

    /* --- 4. Gradient Logic --- */
    .accu-gradient-bg {
        background: linear-gradient(to right, #eff6ff, #ffffff);
        padding: 80px 0;
    }

    .btn-accu-3d {
        background-color: #2563eb;
        color: white !important;
        font-weight: 600;
        padding: 14px 40px;
        border-radius: 10px;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        border: none;
        box-shadow: 0 10px 15px rgba(37, 99, 235, 0.2);
    }
    .btn-accu-3d:hover {
        transform: scale(1.1) rotateX(5deg);
        box-shadow: 0px 15px 30px rgba(37, 99, 235, 0.4);
    }

    .text-blue-react { color: #2563eb; }
    .max-w-7xl { max-width: 1280px; margin: 0 auto; }
</style>

<div class="accu-master-wrapper">

    <!-- ================= 1. HERO SECTION ================= -->
    <section class="pt-20 pb-10 px-4">
        <div class="max-w-7xl">
            <!-- Title with Spring Pop -->
            <?php if($heroTitle): ?>
                <h1 class="display-3 fw-bold text-center mb-5" data-aos="zoom-in" data-aos-duration="1000">
                    <?= $heroTitle ?>
                </h1>
            <?php endif; ?>

            <!-- Hero Description -->
            <?php if($heroDescription): ?>
                <div class="fs-4 text-center text-secondary mx-auto mb-5 lh-base" style="max-width: 1000px;" data-aos="accu-3d-up">
                    <?= $heroDescription ?>
                </div>
            <?php endif; ?>

            <!-- CTA Link (React Style) -->
            <div class="text-center" data-aos="accu-3d-up" data-aos-delay="200">
                <p class="fs-5 fw-semibold">
                    So why wait? To avail a Free Trial Class for Accuplacer Test Prep Online Tutoring, &nbsp;
                    <a href="contact.php" class="text-blue-react text-decoration-underline fw-bold d-inline-block hover-scale">CLICK HERE</a>
                </p>
            </div>
        </div>
    </section>

    <!-- ================= 2. ABOUT SECTIONS ================= -->
    <section class="py-5 px-4">
        <div class="max-w-7xl">
            <!-- About Card 1 -->
            <?php if($aboutHeading || $aboutDescription): ?>
            <div class="mb-5" data-aos="accu-3d-up">
                <h2 class="display-6 fw-bold mb-3 text-dark"><?= $aboutHeading ?></h2>
                <div class="fs-5 text-secondary lh-lg" style="white-space: pre-wrap;"><?= $aboutDescription ?></div>
            </div>
            <?php endif; ?>

            <!-- About Card 2 -->
            <?php if($whatsHeading || $whatsDescription): ?>
            <div class="mb-5" data-aos="accu-3d-up" data-aos-delay="200">
                <h2 class="display-6 fw-bold mb-3 text-dark"><?= $whatsHeading ?></h2>
                <div class="fs-5 text-secondary lh-lg" style="white-space: pre-wrap;"><?= $whatsDescription ?></div>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- ================= 3. INSIDE THE TESTS (Full-Width Cards) ================= -->
    <?php if(!empty($testList)): ?>
    <section class="py-16 px-4 bg-light">
        <div class="max-w-7xl">
            <h2 class="display-5 fw-extrabold text-center mb-5" data-aos="fade-up">Inside the Tests</h2>
            
            <div class="row g-4">
                <?php foreach($testList as $idx => $test): ?>
                    <div class="col-12" data-aos="accu-3d-up" data-aos-delay="<?= $idx * 100 ?>">
                        <div class="accu-card-3d">
                            <h3 class="h3 fw-bold text-primary mb-3"><?= $test['title'] ?></h3>
                            <div class="fs-5 text-secondary lh-lg" style="white-space: pre-wrap;"><?= $test['description'] ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ================= 4. WRITEPLACER ESSAY (2-Col Grid) ================= -->
    <?php if($writeDesc || !empty($writeList)): ?>
    <section class="accu-gradient-bg px-4">
        <div class="max-w-7xl">
            <h2 class="display-5 fw-extrabold text-center mb-5" data-aos="fade-up">WritePlacer Essay</h2>
            
            <div class="fs-4 text-center text-dark mb-5 lh-base mx-auto" style="max-width: 900px;" data-aos="accu-3d-up">
                <?= $writeDesc ?>
            </div>

            <div class="row g-4 mt-2">
                <?php foreach($writeList as $idx => $item): ?>
                    <div class="col-md-6" data-aos="accu-3d-up" data-aos-delay="<?= $idx * 150 ?>">
                        <div class="accu-card-3d" style="border-left-color: #2563eb;">
                            <h3 class="h4 fw-bold text-primary mb-3"><?= $item['title'] ?></h3>
                            <div class="fs-5 text-secondary lh-lg"><?= $item['description'] ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ================= 5. ESL SECTION (2-Col Grid) ================= -->
    <?php if($eslDesc || !empty($eslList)): ?>
    <section class="accu-gradient-bg px-4" style="background: linear-gradient(to left, #eff6ff, #ffffff);">
        <div class="max-w-7xl">
            <h2 class="display-5 fw-extrabold text-center mb-5" data-aos="fade-up">ACCUPLACER for ELL</h2>
            
            <div class="fs-4 text-center text-dark mb-5 lh-base mx-auto" style="max-width: 900px;" data-aos="accu-3d-up">
                <?= $eslDesc ?>
            </div>

            <div class="row g-4 mt-2">
                <?php foreach($eslList as $idx => $item): ?>
                    <div class="col-md-6" data-aos="accu-3d-up" data-aos-delay="<?= $idx * 150 ?>">
                        <div class="accu-card-3d" style="border-left-color: #2563eb;">
                            <h3 class="h4 fw-bold text-primary mb-3"><?= $item['title'] ?></h3>
                            <div class="fs-5 text-secondary lh-lg"><?= $item['description'] ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ================= 6. FINAL CTA ================= -->
    <section class="py-5 bg-white text-center" data-aos="zoom-in">
        <div class="container max-w-4xl mx-auto py-5">
            <h3 class="h3 fw-bold text-dark mb-4">So why wait? To avail a Free Trial Class for Accuplacer Test Prep Online Tutoring</h3>
            <a href="contact.php" class="btn-accu-3d shadow-xl">CLICK HERE</a>
        </div>
    </section>

</div>