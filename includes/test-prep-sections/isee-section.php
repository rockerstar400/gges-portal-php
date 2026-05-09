<?php 
/**
 * SECTION: ISEE FRONTEND (MATCHING REACT DESIGN)
 * Variables: $sectionData (Coming from Master Fetch in test-preparation.php)
 */

// Mapping Variables based on getTestPrepData Master Function
$heroTitle    = $sectionData['isee_hero_title'] ?? "ISEE TEST PREP";
$heroDesc     = $sectionData['isee_hero_desc'] ?? "";

$aboutHeading = $sectionData['isee_about_heading'] ?? "ALL ABOUT ISEE TEST";
$aboutDesc    = $sectionData['isee_about_desc'] ?? "";

$purposeTitle = $sectionData['isee_purpose_heading'] ?? "Purpose of the ISEE";
$purposeList  = $sectionData['isee_purpose'] ?? []; // JSON decoded array

$structTitle  = $sectionData['isee_structure_heading'] ?? "Test structure and levels";
$structList   = $sectionData['isee_structure'] ?? []; // JSON decoded array (title/description)

$regHeading   = $sectionData['isee_registration_heading'] ?? "Registration";
$regDesc      = $sectionData['isee_registration_desc'] ?? "";
?>

<style>
    .isee-wrapper { background-color: #F0F8FF; min-height: 100vh; font-family: 'Inter', sans-serif; }
    
    /* 3D Hover Effect for Purpose Cards */
    .isee-purpose-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0px 10px 15px -3px rgba(0, 0, 0, 0.1);
        transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid #e2e8f0;
        height: 100%;
        transform-style: preserve-3d;
    }
    .isee-purpose-card:hover {
        transform: translateY(-10px) scale(1.03);
        box-shadow: 0px 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    /* Structure Cards with Blue Shadow */
    .isee-struct-card {
        background: white;
        border-radius: 20px;
        padding: 1.5rem;
        border: 1px solid #dbeafe;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transition: all 0.4s ease;
        height: 100%;
    }
    .isee-struct-card:hover {
        transform: translateY(-10px);
        box-shadow: 0px 15px 30px rgba(37, 99, 235, 0.2) !important;
    }

    .isee-number {
        font-size: 1.75rem;
        font-weight: 800;
        color: #1e3a8a;
        margin-bottom: 1rem;
        display: block;
    }
    .text-blue-react { color: #2563eb !important; }
</style>

<div class="isee-wrapper py-5 px-3">
    <div class="container max-w-7xl mx-auto py-4">

        <!-- ================= 1. HEADER SECTION ================= -->
        <div class="text-center mb-5" data-aos="fade-up">
            <h1 class="display-4 fw-bold text-dark mb-4"><?= $heroTitle ?></h1>
            <?php if($heroDesc): ?>
                <div class="fs-5 text-secondary mx-auto mb-4 lh-lg" style="max-width: 900px; white-space: pre-wrap;">
                    <?= $heroDesc ?>
                </div>
            <?php endif; ?>

            <!-- CTA Link -->
            <div class="mt-4">
                <p class="fs-5 fw-medium">
                    So why wait? To avail a Free Trial Class for ISEE Test Prep Online Tutoring, &nbsp;
                    <a href="contact.php" class="text-blue-react text-decoration-underline fw-bold d-inline-block hover-scale">
                        CLICK HERE
                    </a>
                </p>
            </div>
        </div>

        <!-- ================= 2. ALL ABOUT SECTION ================= -->
        <div class="text-center my-5 py-5" data-aos="fade-up">
            <h2 class="display-6 fw-bold text-gray-900 mb-4"><?= $aboutHeading ?></h2>
            <?php if($aboutDesc): ?>
                <div class="fs-5 text-secondary mx-auto lh-lg" style="max-width: 1000px; white-space: pre-wrap;">
                    <?= $aboutDesc ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- ================= 3. PURPOSE OF ISEE (Numbered Grid) ================= -->
        <section class="my-5 pt-4">
            <h2 class="h2 fw-bold text-dark mb-5" data-aos="fade-right"><?= $purposeTitle ?></h2>
            
            <div class="row g-4">
                <?php if(!empty($purposeList)): foreach($purposeList as $idx => $item): if(!$item) continue; ?>
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="<?= $idx * 100 ?>">
                        <div class="isee-purpose-card">
                            <span class="isee-number"><?= $idx + 1 ?></span>
                            <p class="fs-5 text-secondary lh-relaxed"><?= $item ?></p>
                        </div>
                    </div>
                <?php endforeach; else: ?>
                    <div class="col-12 text-center text-muted">No purpose data added.</div>
                <?php endif; ?>
            </div>
        </section>

        <!-- ================= 4. TEST STRUCTURE & LEVELS (4-Col Grid) ================= -->
        <section class="my-5 pt-5 pb-5">
            <h2 class="h2 fw-bold text-dark mb-5 text-uppercase" data-aos="fade-right"><?= $structTitle ?></h2>
            
            <div class="row g-4">
                <?php if(!empty($structList)): foreach($structList as $idx => $s): if(!$s['title']) continue; ?>
                    <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="<?= $idx * 50 ?>">
                        <div class="isee-struct-card">
                            <h3 class="h4 fw-bold text-dark mb-3"><?= $s['title'] ?>:</h3>
                            <p class="fs-6 text-secondary mb-0"><?= $s['description'] ?></p>
                        </div>
                    </div>
                <?php endforeach; else: ?>
                    <div class="col-12 text-center text-muted">No structure data added.</div>
                <?php endif; ?>
            </div>
        </section>

        <!-- ================= 5. REGISTRATION SECTION ================= -->
        <?php if($regHeading || $regDesc): ?>
        <div class="card border-0 shadow-lg rounded-4 p-4 p-md-5 bg-white border-start border-primary border-5 mt-5" data-aos="fade-up">
            <h2 class="h3 fw-bold text-dark mb-3"><?= $regHeading ?></h2>
            <div class="fs-5 text-secondary lh-lg" style="white-space: pre-wrap;">
                <?= $regDesc ?>
            </div>
        </div>
        <?php endif; ?>

    </div>
</div>