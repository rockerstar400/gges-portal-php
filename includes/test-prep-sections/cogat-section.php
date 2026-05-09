<?php 
/**
 * SECTION: CogAT FRONTEND (MATCHING REACT 3D DESIGN)
 * Path: includes/test-prep-sections/cogat-section.php
 * Note: $sectionData is provided by the master loop in test-preparation.php
 */

// Mapping Variables based on getTestPrepData Master Function
$heroMain        = $sectionData['hero'] ?? [];
$heroExtra       = $sectionData['cogat_hero'] ?? []; // JSON: sub_desc, bullets[]
$structData      = $sectionData['cogat_struct'] ?? []; // JSON: heading, desc, table[]
$measureData     = $sectionData['cogat_measure'] ?? []; // JSON: heading, content
$administerData  = $sectionData['cogat_administer'] ?? []; // JSON: heading, content (Quill)
$levelsData      = $sectionData['cogat_levels'] ?? []; // JSON: heading, desc, table[], q_heading, q_desc
$batteryData     = $sectionData['cogat_battery'] ?? []; // JSON: verbal[], nv[], q[]
$scoreLocData    = $sectionData['cogat_score_loc'] ?? []; // JSON: s_h, s_d, l_h, l_d

$heroTitle       = $heroMain['title'] ?? "COGAT TEST PREP";
$heroDescription = $heroMain['description'] ?? "";
?>

<style>
    .cogat-wrapper { font-family: 'Inter', sans-serif; color: #1f2937; overflow-x: hidden; }
    
    /* 3D Depth Setup */
    .perspective-1200 { perspective: 1200px; }
    
    /* Hero Section Dark Theme */
    .cogat-hero { background-color: #0f172a; color: #ffffff; padding: 100px 0; }
    
    /* 3D Tilted Table Logic */
    .tilt-table-wrapper {
        transform: rotateX(5deg);
        transition: transform 0.5s ease;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        border-radius: 12px;
        overflow: hidden;
    }
    .tilt-table-wrapper:hover { transform: rotateX(0deg); }

    /* Battery Cards (3D Lift) */
    .battery-card {
        background: #fff;
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid #e2e8f0;
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        height: 100%;
    }
    .battery-card:hover {
        transform: translateY(-10px) scale(1.02) rotateX(2deg);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
    }

    /* Accents */
    .border-b-verbal { border-bottom: 4px solid #2563eb; }
    .border-b-nv { border-bottom: 4px solid #059669; }
    .border-b-quant { border-bottom: 4px solid #ca8a04; }
    
    .bg-verbal { background-color: #eff6ff; }
    .bg-nv { background-color: #f0fdf4; }
    .bg-quant { background-color: #fefce8; }

    .btn-cogat-blue {
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
    .btn-cogat-blue:hover {
        background-color: #1d4ed8;
        transform: scale(1.05);
        box-shadow: 0 0 20px rgba(37, 99, 235, 0.4);
    }
</style>

<div class="cogat-wrapper">

    <!-- ================= 1. HERO SECTION (Dark) ================= -->
    <section class="cogat-hero text-center px-4" data-aos="fade-in">
        <div class="container max-w-7xl mx-auto">
            <h1 class="display-3 fw-bold mb-5 shadow-sm text-uppercase" data-aos="zoom-out" data-aos-delay="200">
                <?= $heroTitle ?>
            </h1>
            
            <?php if($heroDescription): ?>
                <div class="fs-4 fw-light opacity-90 mb-5 mx-auto text-start lh-base" style="max-width: 900px; white-space: pre-wrap;">
                    <?= $heroDescription ?>
                </div>
            <?php endif; ?>

            <div class="mt-4">
                <a href="contact.php" class="btn-cogat-blue shadow-lg">Book Free Trial Class</a>
            </div>
        </div>
    </section>

    <!-- ================= 2. WHY CHOOSE / LIST SECTION ================= -->
    <?php if(!empty($heroExtra['sub_desc']) || !empty($heroExtra['bullets'])): ?>
    <section class="py-5 px-4 bg-white">
        <div class="container max-w-7xl mx-auto py-5">
            <?php if(!empty($heroExtra['sub_desc'])): ?>
                <p class="fs-4 text-dark mb-5 leading-relaxed"><?= $heroExtra['sub_desc'] ?></p>
            <?php endif; ?>

            <?php if(!empty($heroExtra['bullets'])): ?>
                <ul class="list-unstyled row g-4">
                    <?php foreach($heroExtra['bullets'] as $idx => $bullet): ?>
                        <li class="col-md-6 fs-5 d-flex align-items-start" data-aos="fade-right" data-aos-delay="<?= $idx * 100 ?>">
                            <i class="fas fa-check-circle text-primary mt-1 me-3"></i>
                            <div class="text-secondary"><?= $bullet ?></div> <!-- Rendered as HTML for Quill support -->
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>

    <!-- ================= 3. TEST STRUCTURE TABLE (3D Tilt) ================= -->
    <section class="py-5 px-4 bg-light perspective-1200" data-aos="fade-up">
        <div class="container max-w-7xl mx-auto">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3"><?= $structData['heading'] ?? '' ?></h2>
                <p class="fs-5 text-secondary"><?= $structData['desc'] ?? '' ?></p>
            </div>

            <?php if(!empty($structData['table'])): ?>
                <div class="tilt-table-wrapper shadow-2xl">
                    <table class="table table-hover align-middle mb-0 bg-white border">
                        <thead class="bg-primary text-white">
                            <tr class="text-uppercase small tracking-wider">
                                <th class="p-4 border-0">Verbal Battery</th>
                                <th class="p-4 border-0">Quantitative Battery</th>
                                <th class="p-4 border-0">Non-Verbal Battery</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($structData['table'] as $row): ?>
                            <tr>
                                <td class="p-4 border-end"><?= $row['v'] ?></td>
                                <td class="p-4 border-end"><?= $row['q'] ?></td>
                                <td class="p-4"><?= $row['n'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- ================= 4. MEASURE & ADMINISTER ================= -->
    <section class="py-5 px-4 bg-white" data-aos="fade-up">
        <div class="container max-w-7xl mx-auto py-5">
            <div class="row g-5">
                <div class="col-md-6" data-aos="fade-right">
                    <div class="p-5 rounded-4 h-100 shadow-sm border border-light bg-light" style="transform: rotateY(5deg);">
                        <h2 class="h2 fw-bold text-blue-900 mb-4"><?= $measureData['heading'] ?? '' ?></h2>
                        <p class="fs-5 text-secondary lh-lg"><?= $measureData['content'] ?? '' ?></p>
                    </div>
                </div>
                <div class="col-md-6" data-aos="fade-left">
                    <div class="p-5 rounded-4 h-100 shadow-sm border border-light bg-light" style="transform: rotateY(-5deg);">
                        <h2 class="h2 fw-bold text-blue-900 mb-4"><?= $administerData['heading'] ?? '' ?></h2>
                        <div class="fs-5 text-secondary lh-lg">
                            <?= $administerData['content'] ?? '' ?> <!-- Quill HTML -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= 5. LEVELS TABLE ================= -->
    <section class="py-5 px-4 bg-light perspective-1200" data-aos="fade-up">
        <div class="container max-w-7xl mx-auto">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3"><?= $levelsData['heading'] ?? '' ?></h2>
                <p class="fs-5 text-secondary"><?= $levelsData['desc'] ?? '' ?></p>
            </div>

            <?php if(!empty($levelsData['table'])): ?>
                <div class="table-responsive rounded-4 shadow-lg overflow-hidden">
                    <table class="table table-hover align-middle mb-0 bg-white">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="p-3">Grade</th><th class="p-3">Level</th>
                                <th class="p-3">Questions</th><th class="p-3">Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($levelsData['table'] as $idx => $row): ?>
                            <tr data-aos="fade-left" data-aos-delay="<?= $idx * 50 ?>">
                                <td class="p-3 fw-bold"><?= $row['g'] ?></td>
                                <td class="p-3"><?= $row['l'] ?></td>
                                <td class="p-3"><?= $row['q'] ?></td>
                                <td class="p-3"><?= $row['t'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <?php if(!empty($levelsData['q_heading'])): ?>
                <div class="mt-5 text-center p-4 bg-success bg-opacity-10 rounded-4 border border-success border-opacity-20 shadow-sm" data-aos="zoom-in">
                    <h3 class="h3 fw-bold text-success mb-2"><?= $levelsData['q_heading'] ?></h3>
                    <p class="fs-5 mb-0 text-dark"><?= $levelsData['q_desc'] ?></p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- ================= 6. BATTERY DETAILS ================= -->
    <section class="py-5 px-4 bg-white">
        <div class="container max-w-7xl mx-auto py-5 space-y-5">
            
            <!-- Verbal -->
            <?php if(!empty($batteryData['verbal'])): ?>
                <div class="mb-5">
                    <h2 class="h2 fw-bold text-blue-800 border-b-verbal d-inline-block mb-4">VERBAL BATTERY</h2>
                    <div class="row g-4">
                        <?php foreach($batteryData['verbal'] as $idx => $it): ?>
                            <div class="col-md-6" data-aos="fade-up">
                                <div class="battery-card bg-verbal">
                                    <h4 class="fw-bold text-primary mb-3"><?= $it['t'] ?></h4>
                                    <p class="fs-6 text-dark mb-0 lh-relaxed" style="white-space: pre-wrap;"><?= $it['c'] ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Non-Verbal -->
            <?php if(!empty($batteryData['nv'])): ?>
                <div class="mb-5">
                    <h2 class="h2 fw-bold text-success border-b-nv d-inline-block mb-4">NON-VERBAL BATTERY</h2>
                    <div class="row g-4">
                        <?php foreach($batteryData['nv'] as $idx => $it): ?>
                            <div class="col-md-6" data-aos="fade-up">
                                <div class="battery-card bg-nv">
                                    <h4 class="fw-bold text-success mb-3"><?= $it['t'] ?></h4>
                                    <p class="fs-6 text-dark mb-0 lh-relaxed" style="white-space: pre-wrap;"><?= $it['c'] ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Quantitative -->
            <?php if(!empty($batteryData['q'])): ?>
                <div>
                    <h2 class="h2 fw-bold text-warning border-b-quant d-inline-block mb-4">QUANTITATIVE BATTERY</h2>
                    <div class="row g-4">
                        <?php foreach($batteryData['q'] as $idx => $it): ?>
                            <div class="col-md-6" data-aos="fade-up">
                                <div class="battery-card bg-quant">
                                    <h4 class="fw-bold text-warning mb-3" style="color: #ca8a04 !important;"><?= $it['t'] ?></h4>
                                    <p class="fs-6 text-dark mb-0 lh-relaxed" style="white-space: pre-wrap;"><?= $it['c'] ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </section>

    <!-- ================= 7. SCORING & LOCATION ================= -->
    <section class="py-5 px-4 bg-light">
        <div class="container max-w-7xl mx-auto py-5">
            <div class="row g-5">
                <div class="col-md-6" data-aos="fade-right">
                    <h2 class="h3 fw-bold mb-3"><?= $scoreLocData['s_h'] ?? 'Scoring' ?></h2>
                    <div class="p-4 bg-white rounded-4 shadow-sm fs-5 text-secondary border lh-lg" style="white-space: pre-wrap;">
                        <?= $scoreLocData['s_d'] ?? '' ?>
                    </div>
                </div>
                <div class="col-md-6" data-aos="fade-left">
                    <h2 class="h3 fw-bold mb-3"><?= $scoreLocData['l_h'] ?? 'Location' ?></h2>
                    <div class="p-4 bg-white rounded-4 shadow-sm fs-5 text-secondary border lh-lg" style="white-space: pre-wrap;">
                        <?= $scoreLocData['l_d'] ?? '' ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= 8. FOOTER CTA ================= -->
    <section class="bg-dark text-white py-5 text-center shadow-lg" data-aos="fade-up">
        <div class="container max-w-4xl mx-auto py-5">
            <h2 class="display-5 fw-bold mb-4">Start Your CogAT Prep Today!</h2>
            <a href="contact.php" class="btn-cogat-blue shadow-xl">Get Free Trial Class</a>
        </div>
    </section>

</div>