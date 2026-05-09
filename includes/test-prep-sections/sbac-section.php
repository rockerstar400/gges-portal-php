<?php 
/**
 * SECTION: SBAC FRONTEND (EXACT REACT 3D REPLICA)
 * Logic: Custom 3D CSS + AOS for Framer Motion feel.
 */

// Data Mapping
$heroTitle       = $sectionData['sbac_hero_title'] ?? "SBAC TEST PREP";
$heroDescription = $sectionData['sbac_hero_desc_html'] ?? ""; // Rich HTML from Admin

$aboutHeading     = $sectionData['sbac_about_heading'] ?? "";
$aboutDescription = $sectionData['sbac_about_desc'] ?? "";

$assessHeading    = $sectionData['sbac_assess_heading'] ?? "";
$assessDescription = $sectionData['sbac_assess_desc'] ?? "";
$assessPoints     = $sectionData['sbac_assess_points'] ?? []; // JSON Array
?>

<style>
    /* --- 1. React Perspective Wrapper --- */
    .sbac-master-container {
        font-family: 'Inter', sans-serif;
        color: #1f2937;
        perspective: 1200px; /* React style 3D Depth */
        overflow-x: hidden;
    }

    /* --- 2. fadeInUp3D Animation Logic --- */
    [data-aos="fade-up-3d"] {
        opacity: 0;
        transform: translateY(60px) rotateX(-20px) scale(0.95);
        transition-property: transform, opacity;
    }
    [data-aos="fade-up-3d"].aos-animate {
        opacity: 1;
        transform: translateY(0) rotateX(0) scale(1);
    }

    /* --- 3. cardHover3D Style --- */
    .sbac-card-3d {
        background: #ffffff;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1); /* Spring-like feel */
        transform-style: preserve-3d;
        border: 1px solid transparent;
        margin-bottom: 24px;
    }
    .sbac-card-3d:hover {
        transform: translateY(-5px) rotateY(2deg) scale(1.02);
        box-shadow: 0px 20px 40px rgba(0,0,0,0.15);
        border-color: #dbeafe;
    }

    /* --- 4. button3D Style --- */
    .btn-3d-react {
        background-color: #2563eb;
        color: white !important;
        font-weight: 600;
        padding: 12px 32px;
        border-radius: 8px;
        border: none;
        display: inline-block;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .btn-3d-react:hover {
        transform: scale(1.1) rotateX(5deg);
        box-shadow: 0px 15px 30px rgba(37, 99, 235, 0.4);
        background-color: #1d4ed8;
    }

    .max-w-7xl { max-width: 1280px; margin-left: auto; margin-right: auto; }
</style>

<div class="sbac-master-container py-5">
    
    <!-- ================= 1. HERO SECTION ================= -->
    <section class="pt-5 pb-5 px-4">
        <div class="max-w-7xl">
            <!-- Title -->
            <?php if($heroTitle): ?>
                <h1 class="display-3 fw-bold text-center mb-4" data-aos="fade-up-3d" data-aos-duration="1000">
                    <?= $heroTitle ?>
                </h1>
            <?php endif; ?>

            <!-- Description (HTML Supported) -->
            <?php if($heroDescription): ?>
                <div class="fs-4 text-secondary mx-auto mb-5 text-center lh-base" style="max-width: 900px;" data-aos="fade-up-3d" data-aos-delay="200">
                    <?= $heroDescription ?>
                </div>
            <?php endif; ?>

            <!-- Top CTA -->
            <div class="text-center" data-aos="fade-up-3d" data-aos-delay="400">
                <h3 class="h5 font-semibold mb-4">So why not take a Free Trial Class for SBAC tutoring with us, To avail.</h3>
                <a href="contact.php" class="btn-3d-react">CLICK HERE</a>
            </div>
        </div>
    </section>

    <!-- ================= 2. ABOUT DESCRIPTION ================= -->
    <?php if($aboutHeading || $aboutDescription): ?>
    <section class="py-5 px-4">
        <div class="max-w-7xl" data-aos="fade-up-3d" data-aos-offset="200">
            <?php if($aboutHeading): ?>
                <h2 class="display-6 fw-bold mb-3"><?= $aboutHeading ?></h2>
            <?php endif; ?>
            <div class="fs-5 text-secondary lh-lg" style="white-space: pre-wrap;">
                <?= $aboutDescription ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ================= 3. ASSESSMENT DETAILS (Light Blue Bg) ================= -->
    <?php if(!empty($assessPoints)): ?>
    <section class="bg-[#F0F8FF]" style="background-color: #F0F8FF; padding: 60px 20px;">
        <div class="max-w-7xl">
            
            <!-- Assess Intro -->
            <div class="text-center mb-5" data-aos="fade-up-3d">
                <?php if($assessHeading): ?>
                    <h2 class="display-5 fw-bold mb-4"><?= $assessHeading ?></h2>
                <?php endif; ?>
                <p class="fs-5 text-secondary whitespace-pre-wrap"><?= $assessDescription ?></p>
            </div>

            <!-- Assessment Cards (3D Hover) -->
            <div class="row g-4 justify-content-center">
                <?php foreach($assessPoints as $idx => $point): ?>
                    <div class="col-12" data-aos="fade-up-3d" data-aos-delay="<?= $idx * 150 ?>">
                        <div class="sbac-card-3d">
                            <h2 class="h4 fw-bold text-primary mb-3" style="color: #1e3a8a !important;"><?= $point['title'] ?></h2>
                            <div class="fs-5 text-secondary lh-lg" style="white-space: pre-wrap;">
                                <?= $point['description'] ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ================= 4. FOOTER CTA SECTION ================= -->
    <section class="py-5 px-4 text-center">
        <div class="max-w-4xl" data-aos="fade-up" data-aos-offset="50">
            <h3 class="h4 font-semibold mb-4">So why not take a Free Trial Class for SBAC tutoring with us,</h3>
            <a href="contact.php" class="btn-3d-react">CLICK HERE</a>
        </div>
    </section>

</div>