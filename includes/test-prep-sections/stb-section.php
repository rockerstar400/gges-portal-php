<?php 
/**
 * SECTION: STB FRONTEND (EXACT REACT 3D REPLICA)
 * Path: includes/test-prep-sections/stb-section.php
 * Logic: Custom 3D CSS + AOS for Framer Motion "Spring" Feel.
 */

// Mapping Variables based on getTestPrepData Master Function
$hero            = $sectionData['hero'] ?? [];
$heroTitle       = $hero['title'] ?? "STB TEST PREP";
$heroDescription = $hero['description'] ?? "";

$aboutHeading     = $sectionData['stb_about_h'] ?? "";
$aboutDescription = $sectionData['stb_about_desc'] ?? ""; // Rich HTML from Admin

$stbUsedDesc      = $sectionData['stb_used_desc'] ?? "";
$stbSubsetPoints  = $sectionData['stb_subset_points'] ?? []; // Array
$stbSubsetDesc    = $sectionData['stb_subset_desc'] ?? "";

$subtestHeading   = $sectionData['stb_subtest_heading'] ?? "";
$subtestsList     = $sectionData['stb_subtests'] ?? []; // Array of cards

$infoHeading      = $sectionData['stb_info_h'] ?? "";
$infoDescription  = $sectionData['stb_info_desc'] ?? "";
$timeTable        = $sectionData['stb_timing'] ?? []; // Table Array
?>

<style>
    /* --- 1. React Perspective Wrapper --- */
    .stb-master-wrapper {
        font-family: 'Inter', sans-serif;
        color: #1f2937;
        perspective: 1200px; /* React style 3D Depth */
        background-image: url('assets/images/Elaback.png');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        min-height: 100vh;
    }

    /* --- 2. fadeInUp3D Animation Logic --- */
    [data-aos="stb-3d-up"] {
        opacity: 0;
        transform: translateY(60px) rotateX(-15deg) scale(0.95);
        transition-property: transform, opacity;
    }
    [data-aos="stb-3d-up"].aos-animate {
        opacity: 1;
        transform: translateY(0) rotateX(0) scale(1);
    }

    /* --- 3. Card 3D Hover (Exact React Feel) --- */
    .stb-card-3d {
        background: #ffffff;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        transform-style: preserve-3d;
        height: 100%;
        border: 1px solid #e5e7eb;
    }
    .stb-card-3d:hover {
        transform: translateY(-8px) rotateX(5deg) rotateY(2deg) scale(1.02);
        box-shadow: 0px 25px 50px -12px rgba(37, 99, 235, 0.25);
        z-index: 10;
    }

    /* --- 4. Tilted Table --- */
    .stb-table-container {
        transform: rotateX(10deg);
        transition: transform 0.8s ease;
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        border-radius: 12px;
        overflow: hidden;
    }
    .stb-table-container:hover { transform: rotateX(0deg); }

    .btn-stb-3d {
        background-color: #2563eb;
        color: white !important;
        font-weight: 600;
        padding: 14px 45px;
        border-radius: 10px;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        border: none;
        display: inline-block;
        text-decoration: none;
    }
    .btn-stb-3d:hover {
        transform: scale(1.1) rotateX(5deg);
        box-shadow: 0px 15px 30px rgba(37, 99, 235, 0.4);
    }

    .bg-stb-light { background-color: #F0F8FF; }
    .max-w-7xl { max-width: 1280px; margin: 0 auto; }
</style>

<div class="stb-master-wrapper py-5 px-3">
    <div class="max-w-7xl">

        <!-- ================= 1. HERO SECTION ================= -->
        <section class="py-10 text-center">
            <?php if($heroTitle): ?>
                <h1 class="display-3 fw-bold mb-4 drop-shadow-lg" data-aos="zoom-in" data-aos-duration="1000">
                    <?= $heroTitle ?>
                </h1>
            <?php endif; ?>

            <?php if($heroDescription): ?>
                <div class="fs-4 text-secondary mx-auto mb-5 lh-base" style="max-width: 1000px;" data-aos="stb-3d-up">
                    <?= $heroDescription ?>
                </div>
            <?php endif; ?>

            <!-- Floating CTA Box -->
            <div class="p-5 rounded-4 bg-white bg-opacity-75 backdrop-blur shadow-xl border d-inline-block" data-aos="stb-3d-up" data-aos-delay="200">
                <h3 class="h4 font-semibold mb-4 text-dark">Why not take a FREE TRIAL CLASS for STB Test online tutoring</h3>
                <a href="contact.php" class="btn-stb-3d shadow-lg">CLICK HERE</a>
            </div>
        </section>

        <!-- ================= 2. ABOUT STB (HTML) ================= -->
        <?php if($aboutHeading || $aboutDescription): ?>
        <section class="py-5" data-aos="stb-3d-up">
            <div class="stb-card-3d bg-white">
                <?php if($aboutHeading): ?>
                    <h2 class="display-6 fw-bold mb-4"><?= $aboutHeading ?></h2>
                <?php endif; ?>
                <div class="fs-5 text-secondary lh-lg">
                    <?= $aboutDescription ?> <!-- Quill Rich Text -->
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- ================= 3. STB USAGE & SUBSETS ================= -->
        <div class="row g-4 mb-5">
            <?php if($stbUsedDesc): ?>
            <div class="col-md-6" data-aos="fade-right">
                <div class="stb-card-3d">
                    <h2 class="h3 fw-bold mb-4">What is the STB Used For?</h2>
                    <p class="fs-5 text-secondary lh-lg"><?= $stbUsedDesc ?></p>
                </div>
            </div>
            <?php endif; ?>

            <?php if(!empty($stbSubsetPoints)): ?>
            <div class="col-md-6" data-aos="fade-left">
                <div class="stb-card-3d">
                    <h2 class="h3 fw-bold mb-4">What are the STB Subtests?</h2>
                    <ul class="list-unstyled space-y-3">
                        <?php foreach($stbSubsetPoints as $idx => $pt): ?>
                            <li class="fs-5 d-flex align-items-center" data-aos="fade-left" data-aos-delay="<?= $idx * 100 ?>">
                                <i class="fas fa-check-circle text-primary me-3"></i> <?= $pt ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php if($stbSubsetDesc): ?>
                        <p class="mt-4 text-muted italic small"><?= $stbSubsetDesc ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- ================= 4. SUBTESTS DETAILS (Staggered Cards) ================= -->
        <section class="bg-stb-light p-4 p-md-5 rounded-4 my-5">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="display-5 fw-bold mb-3">What Material is on the STB Subtests?</h2>
                <p class="fs-5 text-secondary">The following is a description of the four subtests that the student will complete:</p>
            </div>

            <div class="row g-4">
                <?php foreach($subtestsList as $idx => $st): ?>
                    <div class="col-md-6" data-aos="stb-3d-up" data-aos-delay="<?= $idx * 150 ?>">
                        <div class="stb-card-3d">
                            <h3 class="h4 fw-bold text-primary mb-3"><?= $st['title'] ?></h3>
                            <div class="fs-6 text-secondary lh-base" style="white-space: pre-wrap;"><?= $st['content'] ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- ================= 5. TIMING TABLE (3D Tilt) ================= -->
        <?php if(!empty($timeTable)): ?>
        <section class="py-5">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="h2 fw-bold mb-3"><?= $infoHeading ?></h2>
                <p class="fs-5 text-secondary"><?= $infoDescription ?></p>
            </div>

            <div class="stb-table-container shadow-2xl" data-aos="zoom-in">
                <table class="table table-hover align-middle mb-0 bg-white border">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="p-4 border-0">Subtest + Tutorial</th>
                            <th class="p-4 border-0 text-center">5th/6th Graders Time</th>
                            <th class="p-4 border-0 text-center">7th Graders+ Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($timeTable as $idx => $row): ?>
                        <tr class="<?= $idx % 2 != 0 ? 'bg-light' : 'bg-white' ?>">
                            <td class="p-4 fw-bold"><?= $row['activity'] ?></td>
                            <td class="p-4 text-center"><?= $row['time5th6th'] ?></td>
                            <td class="p-4 text-center"><?= $row['time7thPlus'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
        <?php endif; ?>

        <!-- ================= 6. FINAL CTA ================= -->
        <section class="py-5 text-center" data-aos="stb-3d-up">
            <div class="container max-w-4xl py-5">
                <h2 class="h3 font-semibold mb-5">Why not take a FREE TRIAL CLASS for STB Test online tutoring.</h2>
                <a href="contact.php" class="btn-stb-3d shadow-2xl" style="transform: rotate(-1deg);">CLICK HERE</a>
            </div>
        </section>

    </div>
</div>