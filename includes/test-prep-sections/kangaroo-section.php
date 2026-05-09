<?php 
/**
 * SECTION: MATH KANGAROO FRONTEND (MATCHING REACT 3D DESIGN)
 * Path: includes/test-prep-sections/kangaroo-section.php
 * Note: $sectionData is provided by test-preparation.php wrapper.
 */

// Mapping Variables based on Master Fetch Function
$hero        = $sectionData['hero'] ?? [];
$heroTitle   = $hero['title'] ?? "MATH KANGAROO TEST PREP";
$heroDesc    = $hero['description'] ?? "";

$structHead  = $sectionData['kan_struct_heading'] ?? "TEST STRUCTURE";
$structDesc  = $sectionData['kan_struct_desc'] ?? "";

$featHead    = $sectionData['kan_feat_heading'] ?? "Features";
$featList    = $sectionData['kan_feat'] ?? []; // JSON Array of strings

$rulesHead   = $sectionData['kan_rules_heading'] ?? "General Rules";
$rulesList   = $sectionData['kan_rules'] ?? []; // JSON Array of {text, subpoints[]}

$scoreHead   = $sectionData['kan_score_heading'] ?? "Scoring";
$scoreDesc   = $sectionData['kan_score_desc'] ?? "";
?>

<style>
    .kan-wrapper { 
        background-image: url('assets/images/Elaback.png'); 
        background-size: cover; background-position: center; background-attachment: fixed;
        min-height: 100vh; font-family: 'Inter', sans-serif; color: #1f2937;
    }

    /* 3D Hover & Glassmorphism like React */
    .kan-3d-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(8px);
        border-radius: 24px;
        padding: 2.5rem;
        border: 1px solid rgba(255, 255, 255, 0.4);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .kan-3d-card:hover {
        transform: translateY(-12px) scale(1.02);
        box-shadow: 0 25px 50px rgba(37, 99, 235, 0.15) !important;
        background: #ffffff;
    }

    /* Floating CTA Section */
    .kan-hero-cta {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        border: 1px solid #e5e7eb;
        border-radius: 1.5rem;
        padding: 2rem;
    }

    .text-blue-900 { color: #1e3a8a; }
    .btn-react-blue { background-color: #2563eb; color: white !important; font-weight: 600; padding: 14px 45px; border-radius: 12px; transition: 0.3s; border: none; text-decoration: none; display: inline-block; }
    .btn-react-blue:hover { background-color: #1d4ed8; transform: scale(1.1); box-shadow: 0 0 20px rgba(37, 99, 235, 0.4); }

    /* Nested List Styles */
    .rules-main-item { transition: 0.3s; padding: 10px; border-radius: 10px; }
    .rules-main-item:hover { transform: translateX(10px); color: #1e3a8a; background: rgba(37, 99, 235, 0.05); }
    .subpoints-circle { list-style-type: circle; margin-left: 2rem; color: #4b5563; }
</style>

<div class="kan-wrapper py-5">
    <div class="container max-w-7xl mx-auto py-4">

        <!-- ================= 1. HERO SECTION ================= -->
        <section class="mb-5 pt-5 text-center" data-aos="fade-up">
            <h1 class="display-3 fw-bold text-dark mb-4 drop-shadow-lg"><?= $heroTitle ?></h1>
            
            <?php if($heroDesc): ?>
                <div class="fs-5 text-secondary lh-lg mb-5 mx-auto" style="max-width: 1000px; white-space: pre-wrap;"><?= $heroDesc ?></div>
            <?php endif; ?>

            <div class="kan-hero-cta d-inline-block shadow-lg mt-2" data-aos="zoom-in" data-aos-delay="200">
                <h3 class="h4 fw-bold mb-4">So why wait? To avail a Free Trial Class for Math Kangaroo Test</h3>
                <a href="contact.php" class="btn-react-blue">CLICK HERE</a>
            </div>
        </section>

        <!-- ================= 2. TEST STRUCTURE (3D Card) ================= -->
        <?php if($structHead || $structDesc): ?>
        <section class="my-5 py-5 px-3" data-aos="fade-up">
            <div class="kan-3d-card max-w-7xl mx-auto shadow-sm">
                <h2 class="display-6 fw-bold text-blue-900 mb-4"><?= $structHead ?></h2>
                <div class="fs-5 text-secondary lh-relaxed" style="white-space: pre-wrap;"><?= $structDesc ?></div>
            </div>
        </section>
        <?php endif; ?>

        <!-- ================= 3. FEATURES (Staggered List) ================= -->
        <?php if($featHead || !empty($featList)): ?>
        <section class="bg-primary bg-opacity-5 py-5 px-3 my-5 rounded-4 border-top border-bottom border-primary border-opacity-10" data-aos="fade-in">
            <div class="max-w-7xl mx-auto">
                <h2 class="display-6 fw-bold text-blue-900 mb-5"><?= $featHead ?></h2>
                <ul class="list-unstyled space-y-4">
                    <?php foreach($featList as $idx => $item): if(!$item) continue; ?>
                        <li class="fs-5 d-flex align-items-start" data-aos="fade-left" data-aos-delay="<?= $idx * 100 ?>">
                            <i class="fas fa-check-circle text-primary mt-1 me-3"></i>
                            <?= $item ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>
        <?php endif; ?>

        <!-- ================= 4. GENERAL RULES (Nested Staggered) ================= -->
        <?php if($rulesHead || !empty($rulesList)): ?>
        <section class="py-5 px-3 my-5" data-aos="fade-up">
            <div class="max-w-7xl mx-auto">
                <h2 class="display-6 fw-bold text-blue-900 mb-5"><?= $rulesHead ?></h2>
                
                <ul class="list-unstyled space-y-5">
                    <?php foreach($rulesList as $idx => $rule): ?>
                        <li class="rules-main-item" data-aos="fade-up" data-aos-delay="<?= $idx * 150 ?>">
                            <div class="fs-4 fw-bold mb-2"><?= $rule['text'] ?? $rule['type'] ?></div>
                            
                            <?php if(!empty($rule['subpoints'])): ?>
                                <ul class="subpoints-circle mt-2">
                                    <?php foreach($rule['subpoints'] as $sub): ?>
                                        <li class="fs-5 mb-1"><?= $sub ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>
        <?php endif; ?>

        <!-- ================= 5. SCORING (Final Card) ================= -->
        <?php if($scoreHead || $scoreDesc): ?>
        <section class="my-5 py-5 px-3" data-aos="zoom-in">
            <div class="kan-3d-card border-start border-primary border-5">
                <h2 class="display-6 fw-bold text-blue-900 mb-4"><?= $scoreHead ?></h2>
                <div class="fs-5 text-secondary lh-lg" style="white-space: pre-wrap;"><?= $scoreDesc ?></div>
            </div>
        </section>
        <?php endif; ?>

        <!-- ================= 6. FINAL FOOTER CTA ================= -->
        <div class="text-center my-5 py-5" data-aos="fade-up">
            <h3 class="h4 fw-bold mb-4">So why wait? To avail a Free Trial Class for Math Kangaroo Test</h3>
            <div class="flex justify-center gap-4">
                <a href="contact.php" class="btn-react-blue shadow-lg" style="transform: rotate(-1deg);">
                    CLICK HERE
                </a>
            </div>
        </div>

    </div>
</div>