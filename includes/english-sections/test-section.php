<?php 
/**
 * SECTION: ABOUT ISEE TEST (Test Page)
 * Path: includes/english-sections/test-section.php
 * Note: $prepData is fetched in courses-english.php using slug 'eng-about-isee'
 */

$iseeData = getTestPrepData('eng-about-isee');

// Mapping based on Master Function cleaned keys
$titles   = $iseeData['about_isee_title'] ?? [];   // Array of strings
$purposes = $iseeData['about_isee_purpose'] ?? []; // Array of strings
$structs  = $iseeData['about_isee_struct'] ?? [];  // Array of {heading, description}
?>

<style>
    .isee-test-wrapper { background-color: #F0F8FF; font-family: 'Inter', sans-serif; color: #111827; }
    
    /* 3D Card Hover Logic (Exact React cardHover3D) */
    .isee-card-3d {
        background: #ffffff;
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0px 10px 15px -3px rgba(0, 0, 0, 0.1);
        transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        transform-style: preserve-3d;
        height: 100%;
        border: 1px solid #e5e7eb;
    }
    .isee-card-3d:hover {
        transform: translateY(-10px) scale(1.03);
        box-shadow: 0px 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    /* Purpose Circle Number */
    .purpose-number {
        font-size: 1.5rem;
        font-weight: 800;
        color: #1e3a8a;
        margin-bottom: 10px;
        display: block;
    }

    /* Structure Card Custom Shadow */
    .struct-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #dbeafe; /* blue-100 */
        transition: 0.4s ease;
    }
    .struct-card:hover {
        transform: translateY(-10px);
        box-shadow: 0px 15px 30px rgba(37, 99, 235, 0.2) !important;
    }

    .text-blue-react { color: #2563eb !important; }
</style>

<div class="isee-test-wrapper py-5 px-3">
    <div class="container py-4">

        <!-- ================= 1. HEADER SECTION ================= -->
        <div class="text-center mb-5" data-aos="fade-up">
            <h1 class="display-5 fw-bold text-dark mb-3 text-uppercase">ISEE TEST PREP</h1>
            
            <?php if(!empty($titles)): ?>
                <!-- React Title.slice(0, 1) mapping -->
                <p class="fs-5 text-secondary mx-auto mb-4" style="max-width: 900px;">
                    <?= $titles[0] ?>
                </p>
            <?php endif; ?>

            <div class="mt-4 fs-5 fw-medium">
                So why wait? To avail a Free Trial Class for ISEE Test Prep Online Tutoring, &nbsp;
                <a href="contact.php" class="text-blue-react text-decoration-underline fw-bold d-inline-block hover-scale">
                    CLICK HERE
                </a>
            </div>
        </div>

        <!-- ================= 2. ALL ABOUT SECTION ================= -->
        <div class="text-center my-5 py-5" data-aos="fade-up">
            <h2 class="display-6 fw-bold text-gray-900 mb-4">ALL ABOUT ISEE TEST</h2>
            
            <?php if(count($titles) > 1): ?>
                <!-- React Title.slice(1) mapping -->
                <div class="fs-5 text-secondary mx-auto lh-lg" style="max-width: 1000px;">
                    <?php for($i=1; $i<count($titles); $i++): ?>
                        <p class="mb-2"><?= $titles[$i] ?></p>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- ================= 3. PURPOSE OF THE ISEE (3-Col Grid) ================= -->
        <section class="my-5">
            <h2 class="h2 fw-bold text-gray-900 mb-5" data-aos="fade-right">Purpose of the ISEE</h2>
            
            <div class="row g-4">
                <?php foreach($purposes as $idx => $p): if(!$p) continue; ?>
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="<?= $idx * 100 ?>">
                        <div class="isee-card-3d text-center">
                            <span class="purpose-number text-start"><?= $idx + 1 ?></span>
                            <p class="fs-5 text-secondary lh-relaxed mb-0"><?= $p ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- ================= 4. TEST STRUCTURE & LEVELS (4-Col Grid) ================= -->
        <section class="mt-5 pt-5 pb-5">
            <h2 class="h2 fw-bold text-gray-900 mb-5" data-aos="fade-right">Test structure and levels</h2>
            
            <div class="row g-4">
                <?php foreach($structs as $idx => $s): if(!$s['heading']) continue; ?>
                    <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="<?= $idx * 50 ?>">
                        <div class="struct-card p-4 h-100 shadow-sm">
                            <h3 class="h4 fw-bold text-dark mb-3"><?= $s['heading'] ?>:</h3>
                            <p class="fs-6 text-secondary mb-0"><?= $s['description'] ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

    </div>
</div>