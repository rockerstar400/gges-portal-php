<?php 
/**
 * SECTION: ELA FRONTEND (MATCHING REACT DESIGN)
 * Path: includes/test-prep-sections/ela-section.php
 * Note: $sectionData variable is provided by test-preparation.php wrapper.
 */

// Mapping Variables based on your Master Fetch Function
$hero            = $sectionData['hero'] ?? [];
$introHeading    = $sectionData['ela_intro_title'] ?? "";
$introContent    = $sectionData['ela_intro_content'] ?? ""; // Rich HTML from Admin
$adminHeading    = $sectionData['ela_admin_title'] ?? "";
$adminPoints     = $sectionData['ela_admin'] ?? []; // Array of {title, description}

$heroTitle       = $hero['title'] ?? "ELA TEST PREP";
$heroDescription = $hero['description'] ?? "";
?>

<style>
    .ela-main-wrapper {
        min-height: 100vh;
        background-image: url('assets/images/Elaback.png');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        background-repeat: no-repeat;
        font-family: 'Inter', sans-serif;
    }

    .text-gray-900 { color: #111827; }
    .text-blue-ela { color: #2563eb; }

    /* React Style: Slide Right on Hover */
    .ela-list-item {
        transition: transform 0.4s ease, background 0.3s ease;
        padding: 15px;
        border-radius: 12px;
    }
    .ela-list-item:hover {
        transform: translateX(15px);
        background: rgba(37, 99, 235, 0.05);
    }

    /* CTA Section (3D Pop Up Style) */
    .ela-cta-box {
        background-color: #f9fafb;
        border: 1px solid #f3f4f6;
        transition: all 0.5s ease;
    }
    .ela-cta-box:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }

    .btn-blue-react {
        background-color: #2563eb;
        color: white !important;
        font-weight: 600;
        padding: 14px 40px;
        border-radius: 10px;
        transition: 0.3s;
        border: none;
        display: inline-block;
        text-decoration: none;
    }
    .btn-blue-react:hover {
        background-color: #1d4ed8;
        transform: scale(1.05);
        box-shadow: 0 10px 20px rgba(37, 99, 235, 0.3);
    }
</style>

<div class="ela-main-wrapper py-5 px-3">
    <div class="container max-w-7xl mx-auto py-5">

        <!-- ================= 1. HERO / HEADER SECTION ================= -->
        <header class="mb-5 text-center" data-aos="fade-up">
            <?php if($heroTitle): ?>
                <h1 class="display-4 fw-bold text-gray-900 mb-4 text-uppercase tracking-tight">
                    <?= $heroTitle ?>
                </h1>
            <?php endif; ?>

            <?php if($heroDescription): ?>
                <div class="fs-5 text-secondary lh-lg mx-auto mb-4" style="max-width: 1000px; white-space: pre-line;">
                    <?= $heroDescription ?>
                </div>
            <?php endif; ?>

            <h2 class="h3 fw-bold text-gray-900 mt-5" data-aos="fade-up" data-aos-delay="100">
                (New York State English Language Arts (ELA) Test)
            </h2>
        </header>

        <!-- ================= 2. INTRO SECTION (HTML Content) ================= -->
        <?php if($introHeading || $introContent): ?>
        <section class="mb-5 py-4" data-aos="fade-right">
            <?php if($introHeading): ?>
                <h2 class="h2 fw-bold text-gray-900 mb-4"><?= $introHeading ?></h2>
            <?php endif; ?>

            <?php if($introContent): ?>
                <div class="fs-5 text-dark lh-relaxed">
                    <?= $introContent ?> <!-- Render HTML from Admin Quill -->
                </div>
            <?php endif; ?>
        </section>
        <?php endif; ?>

        <!-- ================= 3. ADMINISTRATION LIST ================= -->
        <section class="mb-5">
            <div class="mb-4" data-aos="fade-left">
                <?php if($adminHeading): ?>
                    <h2 class="h3 fw-bold text-gray-900 mb-2"><?= $adminHeading ?></h2>
                <?php endif; ?>
                <p class="fs-5 text-dark fw-bold">Core components and formats</p>
            </div>

            <div class="row g-2">
                <?php if(!empty($adminPoints)): foreach($adminPoints as $idx => $pt): ?>
                    <div class="col-12" data-aos="fade-up" data-aos-delay="<?= $idx * 100 ?>">
                        <div class="ela-list-item">
                            <h4 class="h4 fw-bold text-blue-ela mb-1"><?= $pt['title'] ?? '' ?></h4>
                            <p class="fs-5 text-secondary mb-0"><?= $pt['description'] ?? '' ?></p>
                        </div>
                    </div>
                <?php endforeach; else: ?>
                    <div class="col-12 text-center text-muted">No details added yet.</div>
                <?php endif; ?>
            </div>
        </section>

        <!-- ================= 4. CTA SECTION ================= -->
        <div class="ela-cta-box p-5 rounded-4 text-center my-5 shadow-sm" data-aos="zoom-in">
            <h3 class="h4 fw-bold text-gray-900 mb-4">
                So why wait? To avail of a Free Trial Class for ELA Tutoring
            </h3>
            <a href="contact.php" class="btn-blue-react shadow-lg">
                Free Trial Class
            </a>
        </div>

    </div>
</div>