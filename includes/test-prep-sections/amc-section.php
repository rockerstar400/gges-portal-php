<?php 
/**
 * SECTION: AMC FRONTEND (MATCHING REACT DESIGN)
 * Path: includes/test-prep-sections/amc-section.php
 * Note: $sectionData is provided by the loop in test-preparation.php
 */

// Mapping Variables based on getTestPrepData Master Function
$heroTitle       = $sectionData['amc_hero_title'] ?? "AMC TEST PREP";
$heroDesc        = $sectionData['amc_hero_desc'] ?? "";

$aboutHeading    = $sectionData['amc_about_heading'] ?? "About AMC Test";
$aboutDesc       = $sectionData['amc_about_desc'] ?? "";

$partHeading     = $sectionData['amc_participate_heading'] ?? "Who Can Participate?";
$partPoints      = $sectionData['amc_participate'] ?? []; // JSON decoded array

$compHeading     = $sectionData['amc_comp_heading'] ?? "Different AMC Competitions";
$compCards       = $sectionData['amc_comp'] ?? []; // JSON decoded array of objects

$whyHeading      = $sectionData['amc_why_heading'] ?? "Why Take AMC?";
$whyDesc         = $sectionData['amc_why_desc'] ?? "";
?>

<style>
    .amc-main-wrapper {
        background-image: url('assets/images/Elaback.png');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        min-height: 100vh;
        color: #1f2937;
        font-family: 'Inter', sans-serif;
    }

    /* Competition Card Design */
    .amc-card-3d {
        background-color: #F0F8FF;
        border-radius: 1.25rem;
        padding: 2rem;
        border: 1px solid #e0f2fe;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        height: 100%;
    }
    .amc-card-3d:hover {
        transform: translateY(-8px) scale(1.01);
        box-shadow: 0px 15px 30px rgba(0, 0, 0, 0.1);
    }

    .text-blue-amc { color: #1e40af; }
    .btn-react-blue { background-color: #2563eb; color: white !important; font-weight: 600; padding: 12px 35px; border-radius: 10px; transition: 0.3s; border: none; text-decoration: none; display: inline-block; }
    .btn-react-blue:hover { background-color: #1d4ed8; transform: scale(1.05); }
</style>

<div class="amc-main-wrapper py-5">
    <div class="container max-w-7xl mx-auto py-4">

        <!-- ================= 1. HERO SECTION ================= -->
        <section class="text-center mb-5 px-3" data-aos="fade-up">
            <?php if($heroTitle): ?>
                <h1 class="display-4 fw-bold mb-4"><?= $heroTitle ?></h1>
            <?php endif; ?>

            <?php if($heroDesc): ?>
                <p class="fs-5 text-secondary lh-lg mb-4 mx-auto" style="max-width: 1000px; white-space: pre-wrap;">
                    <?= $heroDesc ?>
                </p>
            <?php endif; ?>

            <div class="bg-white bg-opacity-50 p-4 rounded-4 shadow-sm d-inline-block">
                <h3 class="h4 fw-bold mb-3 text-dark">So why wait? To avail a Free Trial Class for AMC Test Prep</h3>
                <a href="contact.php" class="btn-react-blue shadow-lg">CLICK HERE</a>
            </div>
        </section>

        <!-- ================= 2. ABOUT AMC ================= -->
        <?php if($aboutHeading || $aboutDesc): ?>
        <section class="my-5 px-3" data-aos="fade-up">
            <div class="max-w-7xl mx-auto">
                <h2 class="display-6 fw-bold mb-3"><?= $aboutHeading ?></h2>
                <p class="fs-5 text-secondary lh-relaxed" style="white-space: pre-wrap;"><?= $aboutDesc ?></p>
            </div>
        </section>
        <?php endif; ?>

        <!-- ================= 3. WHO CAN PARTICIPATE (Staggered List) ================= -->
        <?php if($partHeading || !empty($partPoints)): ?>
        <section class="bg-light py-5 px-3 my-5 rounded-4 shadow-sm" data-aos="fade-in">
            <div class="max-w-7xl mx-auto">
                <h2 class="h2 fw-bold mb-4"><?= $partHeading ?></h2>
                <p class="fs-5 mb-4">The MAA AMC proudly engages with a dedicated group of participants, each crucial to the success of our mathematical community:</p>
                
                <ul class="list-unstyled space-y-3">
                    <?php foreach($partPoints as $idx => $point): if(!$point) continue; ?>
                        <li class="fs-5 d-flex align-items-start" data-aos="fade-left" data-aos-delay="<?= $idx * 100 ?>">
                            <i class="fas fa-check-circle text-primary mt-1 me-3"></i>
                            <?= $point ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>
        <?php endif; ?>

        <!-- ================= 4. AMC COMPETITIONS (3D Cards) ================= -->
        <?php if($compHeading || !empty($compCards)): ?>
        <section class="py-5 px-3">
            <div class="max-w-7xl mx-auto">
                <h2 class="display-6 fw-bold mb-5" data-aos="fade-right"><?= $compHeading ?></h2>

                <div class="row g-4">
                    <?php foreach($compCards as $idx => $card): ?>
                        <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="<?= $idx * 150 ?>">
                            <div class="amc-card-3d">
                                <h3 class="h3 fw-bold text-blue-amc mb-4"><?= $card['title'] ?? '' ?></h3>
                                
                                <div class="fs-6 mb-3 text-secondary">
                                    <?= $card['amcDescription'] ?? '' ?> <!-- Quill HTML Content -->
                                </div>

                                <div class="space-y-2 border-top pt-3">
                                    <p class="mb-1"><strong>Description:</strong> <?= $card['description'] ?? '' ?></p>
                                    <p class="mb-1"><strong>When:</strong> <?= $card['whenText'] ?? '' ?></p>
                                    <p class="mb-0"><strong>For:</strong> <?= $card['whoText'] ?? '' ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- ================= 5. WHY TAKE AMC ================= -->
        <?php if($whyHeading || $whyDesc): ?>
        <section class="bg-blue-50 py-5 px-3 my-5 rounded-4 border border-blue-100" data-aos="fade-up">
            <div class="max-w-7xl mx-auto">
                <h2 class="h2 fw-bold mb-4 text-navy-react"><?= $whyHeading ?></h2>
                <div class="fs-5 text-secondary lh-lg" style="white-space: pre-wrap;">
                    <?= $whyDesc ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- ================= 6. FINAL CTA ================= -->
        <div class="text-center my-5 py-5" data-aos="zoom-in">
            <h3 class="h4 fw-bold mb-4">So why wait? To avail a Free Trial Class for AMC Test Prep</h3>
            <a href="contact.php" class="btn-react-blue shadow-lg">CLICK HERE</a>
        </div>

    </div>
</div>