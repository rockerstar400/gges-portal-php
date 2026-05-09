<?php 
/**
 * SECTION: ACT FRONTEND (MATCHING REACT DESIGN)
 * Path: includes/test-prep-sections/act-section.php
 * Note: $sectionData variable is provided by test-preparation.php wrapper.
 */

// Mapping Variables based on getTestPrepData Master Function
$hero            = $sectionData['hero'] ?? [];
$about           = $sectionData['about'] ?? [];
$aboutList       = json_decode($sectionData['act_about_json'] ?? '[]', true);
$addInfoHead     = $sectionData['act_additional_heading'] ?? "";
$addInfoList     = json_decode($sectionData['act_additional_json'] ?? '[]', true);
$actHeading      = $sectionData['act_test_sections_heading'] ?? "";
$actList         = json_decode($sectionData['act_test_sections_json'] ?? '[]', true);

$heroTitle       = $hero['title'] ?? "ACT TEST PREP";
$heroDescription = $hero['description'] ?? "";
?>

<style>
    .act-wrapper { 
        background-color: #ffffff; 
        min-height: 100vh; 
        font-family: 'Inter', sans-serif; 
        color: #1f2937;
        perspective: 1200px; /* React style 3D depth */
    }

    /* 3D Hero Card */
    .act-hero-card {
        background: white;
        padding: 1.5rem;
        border-radius: 1.25rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        border-top: 4px solid #3b82f6;
        transition: 0.3s;
    }
    .act-hero-card:hover { transform: scale(1.02); }

    /* Blue React Hover Cards */
    .act-card-3d {
        background-color: #F0F8FF;
        border-radius: 1rem;
        padding: 1.5rem;
        border: 1px solid #e2e8f0;
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        height: 100%;
        transform-style: preserve-3d;
    }
    .act-card-3d:hover {
        transform: translateY(-10px) rotateX(4deg) rotateY(2deg);
        box-shadow: 0px 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
        z-index: 10;
    }

    /* White Section Cards */
    .act-sec-card {
        background: white;
        padding: 2rem;
        border-radius: 1.25rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        border-top: 4px solid #6366f1; /* Indigo */
        transition: 0.5s;
    }
    .act-sec-card:hover { transform: translateY(-10px); box-shadow: 0px 15px 30px rgba(0,0,0,0.1); }

    .text-blue-react { color: #2563eb; }
    .bg-blue-react { background-color: #2563eb; color: white !important; border: none; border-radius: 8px; font-weight: 600; padding: 12px 30px; transition: 0.3s; }
    .bg-blue-react:hover { background-color: #1d4ed8; transform: scale(1.1); box-shadow: 0 0 20px rgba(37, 99, 235, 0.6); }
    
    .border-l-blue { border-left: 8px solid #2563eb !important; padding-left: 1.5rem; }
</style>

<div class="act-wrapper">
    
    <!-- ================= 1. HERO SECTION ================= -->
    <section class="pt-5 pb-5 px-4" data-aos="fade-up">
        <div class="container max-w-7xl mx-auto text-center py-5">
            <h1 class="display-3 fw-bold text-blue-900 mb-4 text-uppercase"><?= $heroTitle ?></h1>
            
            <?php if($heroDescription): ?>
                <div class="act-hero-card max-width-900 mx-auto mb-5">
                    <p class="fs-5 text-secondary lh-lg mb-0" style="white-space: pre-wrap;"><?= $heroDescription ?></p>
                </div>
            <?php endif; ?>

            <div class="mt-4">
                <h3 class="h4 fw-bold text-blue-800 mb-4">So why wait? To avail a Free Trial Class for ACT Test Prep Online</h3>
                <a href="contact.php" class="btn bg-blue-react shadow-lg text-uppercase">Click here for Free Trial</a>
            </div>
        </div>
    </section>

    <!-- ================= 2. ABOUT SECTION ================= -->
    <?php if($about['heading'] || $about['description'] || !empty($aboutList)): ?>
    <section class="py-5 px-4">
        <div class="container max-w-7xl mx-auto">
            <?php if($about['heading']): ?>
                <h2 class="display-6 fw-bold mb-4 border-l-blue"><?= $about['heading'] ?></h2>
            <?php endif; ?>

            <?php if($about['description']): ?>
                <div class="fs-5 text-secondary mb-5 lh-relaxed" style="white-space: pre-wrap;"><?= $about['description'] ?></div>
            <?php endif; ?>

            <div class="row g-4">
                <?php foreach($aboutList as $idx => $item): ?>
                    <div class="col-md-6" data-aos="fade-up" data-aos-delay="<?= $idx * 100 ?>">
                        <div class="act-card-3d">
                            <h3 class="h4 fw-bold text-blue-react mb-3 border-bottom pb-2"><?= $item['title'] ?></h3>
                            <p class="fs-5 text-secondary mb-0"><?= $item['description'] ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ================= 3. ADDITIONAL INFO ================= -->
    <?php if($addInfoHead || !empty($addInfoList)): ?>
    <section class="py-5 px-4 bg-white">
        <div class="container max-w-7xl mx-auto">
            <?php if($addInfoHead): ?>
                <h2 class="display-6 fw-bold mb-4 border-l-blue"><?= $addInfoHead ?></h2>
            <?php endif; ?>

            <div class="row g-4">
                <?php foreach($addInfoList as $idx => $item): ?>
                    <div class="col-md-6" data-aos="fade-up" data-aos-delay="<?= $idx * 100 ?>">
                        <div class="act-card-3d">
                            <h3 class="h4 fw-bold text-blue-react mb-3 border-bottom pb-2"><?= $item['title'] ?></h3>
                            <p class="fs-5 text-secondary mb-0"><?= $item['description'] ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ================= 4. IMAGE STRUCTURE SECTION ================= -->
    <section class="py-5 px-4 text-center" data-aos="zoom-in">
        <div class="container max-w-5xl mx-auto">
            <h2 class="display-6 fw-bold mb-5">ACT TEST STRUCTURE</h2>
            <div class="d-flex justify-content-center">
                <!-- assets folder mein P2-ACT.jpg image honi chahiye -->
                <img src="assets/images/P2-ACT.jpg" alt="ACT Format Table" class="img-fluid rounded-4 shadow-lg border border-2 border-light hover-scale" style="max-width: 600px;">
            </div>
        </div>
    </section>

    <!-- ================= 5. ACT SECTIONS LIST ================= -->
    <?php if($actHeading || !empty($actList)): ?>
    <section class="bg-light py-5 px-4 mt-5">
        <div class="container max-w-7xl mx-auto">
            <?php if($actHeading): ?>
                <h2 class="display-6 fw-bold mb-5 text-center"><?= $actHeading ?></h2>
            <?php endif; ?>

            <div class="row g-4">
                <?php foreach($actList as $idx => $item): ?>
                    <div class="col-12" data-aos="<?= $idx % 2 == 0 ? 'fade-right' : 'fade-left' ?>">
                        <div class="act-sec-card">
                            <h3 class="h3 fw-bold text-indigo-900 mb-4"><?= $item['title'] ?></h3>
                            <div class="fs-5 text-secondary lh-lg">
                                <?= $item['description'] ?> <!-- Quill HTML Content -->
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ================= 6. BOTTOM CTA ================= -->
    <section class="py-5 bg-light text-center border-top" data-aos="fade-up">
        <div class="container max-w-4xl mx-auto py-4">
            <h2 class="display-6 fw-bold mb-4">Start Your ACT Prep Today!</h2>
            <p class="fs-4 mb-5 font-semibold">To know more or to take a Free Trial Online tutoring class for ACT or SAT test preparation tutoring,</p>
            <a href="contact.php" class="btn bg-blue-react shadow-xl btn-lg px-5 py-3" style="transform: skewX(-5deg);">
                Click here for Free Trial Class
            </a>
        </div>
    </section>

</div>