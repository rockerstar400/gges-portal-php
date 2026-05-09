<?php 
/**
 * SECTION: PSAT FRONTEND (MATCHING REACT DESIGN)
 * Path: includes/test-prep-sections/psat-section.php
 * Note: $sectionData is provided by the loop in test-preparation.php
 */

// Mapping Variables based on getTestPrepData Master Function
$hero            = $sectionData['hero'] ?? [];
$about           = $sectionData['about'] ?? [];
$structureTable  = $sectionData['table'] ?? [];       // table_data_json -> table
$examPeriodTable = $sectionData['exam_period'] ?? [];  // exam_period_json -> exam_period

$heroTitle       = $hero['title'] ?? "PSAT TEST PREP";
$heroSubtitle    = $hero['subtitle'] ?? "";
$heroDescription = $hero['description'] ?? "";

$aboutHeading     = $about['heading'] ?? "ALL ABOUT PSAT";
$aboutDescription = $about['description'] ?? "";
?>

<style>
    /* React Style Theme for PSAT */
    .psat-wrapper { 
        background-color: #F0F8FF; 
        background-image: url('assets/images/math-bg.png'); 
        background-size: contain; 
        background-position: center; 
        background-repeat: repeat;
        min-height: 100vh;
        font-family: 'Inter', sans-serif;
    }

    /* Blue Theme Colors */
    .text-blue-react { color: #2563eb !important; }
    .bg-blue-react { background-color: #2563eb !important; border: none; color: white !important; }
    .bg-blue-react:hover { background-color: #1d4ed8 !important; transform: scale(1.05); transition: 0.3s; }

    /* 3D Hover Card (Replicating React shadow-inner & 3D Lift) */
    .card-3d-psat {
        background: #F0F8FF;
        border-radius: 20px;
        padding: 2.5rem;
        border: 1px solid #dbeafe;
        box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.05);
        transition: all 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .card-3d-psat:hover {
        transform: translateY(-5px);
        box-shadow: 0px 20px 40px -10px rgba(37, 99, 235, 0.2) !important;
    }

    /* Table Design matching React */
    .psat-table thead { background-color: #2563eb; color: white; }
    .psat-table th, .psat-table td { border: 1px solid #dee2e6; padding: 12px; }
    .bg-white-row { background-color: #ffffff; }
    .bg-gray-row { background-color: #f9fafb; }
    .hover-row:hover { background-color: #eff6ff; transition: 0.2s; }
</style>

<div class="psat-wrapper py-5 px-3">
    <div class="container max-w-7xl mx-auto py-4">

        <!-- ================= 1. HEADER SECTION ================= -->
        <?php if($heroTitle || $heroSubtitle): ?>
        <div class="text-center mb-5" data-aos="fade-up">
            <?php if($heroTitle): ?>
                <h1 class="display-4 fw-bold text-dark mb-4"><?= $heroTitle ?></h1>
            <?php endif; ?>
            
            <?php if($heroSubtitle): ?>
                <p class="fs-5 text-secondary mx-auto mb-4" style="max-width: 850px;">
                    <?= $heroSubtitle ?>
                </p>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- ================= 2. FREE TRIAL TEXT ================= -->
        <div class="text-center mb-5" data-aos="fade-up" data-aos-delay="150">
            <p class="fs-5 fw-semibold text-dark">
                So why wait? To avail a Free Trial Class for PSAT Test Prep Online Tutoring, &nbsp;
                <a href="contact.php" class="text-blue-react text-decoration-underline fw-bold d-inline-block shadow-hover">
                    CLICK HERE
                </a>
            </p>
        </div>

        <!-- ================= 3. MAIN CONTENT (All About PSAT) ================= -->
        <div class="mb-5" data-aos="fade-up">
            <h2 class="display-6 fw-bold text-dark mb-4">ALL ABOUT PSAT</h2>
            <?php if($heroDescription): ?>
                <div class="fs-5 text-secondary lh-lg" style="white-space: pre-wrap; text-align: justify;">
                    <?= $heroDescription ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- ================= 4. 3D HOVER CARD SECTION ================= -->
        <?php if($aboutHeading || $aboutDescription || !empty($structureTable)): ?>
        <div class="card-3d-psat mt-5" data-aos="zoom-in">
            
            <?php if($aboutHeading): ?>
                <h2 class="text-center fw-bold text-dark mb-4 text-uppercase"><?= $aboutHeading ?></h2>
            <?php endif; ?>

            <?php if($aboutDescription): ?>
                <p class="text-secondary fs-5 text-center mb-5 mx-auto" style="max-width: 1000px; white-space: pre-wrap;">
                    <?= $aboutDescription ?>
                </p>
            <?php endif; ?>

            <!-- Table 1: PSAT TEST STRUCTURE -->
            <h3 class="fw-bold text-dark mb-4 mt-2">PSAT TEST STRUCTURE</h3>
            <div class="table-responsive rounded-3 overflow-hidden shadow-sm border border-gray-300 mb-5">
                <table class="table psat-table align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width: 33.33%;">Section</th>
                            <th style="width: 33.33%;" class="text-center">Length (minutes)</th>
                            <th style="width: 33.33%;" class="text-center">Number of Questions / Tasks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($structureTable)): foreach($structureTable as $idx => $row): ?>
                        <tr class="<?= $idx % 2 == 0 ? 'bg-white-row' : 'bg-gray-row' ?> hover-row">
                            <td class="fw-bold"><?= $row['name'] ?></td>
                            <td class="text-center"><?= $row['time'] ?></td>
                            <td class="text-center"><?= $row['modules'] ?></td>
                        </tr>
                        <?php endforeach; else: ?>
                            <tr><td colspan="3" class="text-center py-3">No Structure Data Found</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Table 2: EXAM PERIOD -->
            <h3 class="fw-bold text-dark mb-4">EXAM PERIOD</h3>
            <div class="table-responsive rounded-3 overflow-hidden shadow-sm border border-gray-300">
                <table class="table psat-table align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width: 33.33%;">Grade Level</th>
                            <th style="width: 33.33%;" class="text-center">Season</th>
                            <th style="width: 33.33%;" class="text-center">Exam</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($examPeriodTable)): foreach($examPeriodTable as $idx => $row): ?>
                        <tr class="<?= $idx % 2 == 0 ? 'bg-white-row' : 'bg-gray-row' ?> hover-row">
                            <td class="fw-bold"><?= $row['name'] ?></td>
                            <td class="text-center"><?= $row['time'] ?></td>
                            <td class="text-center"><?= $row['modules'] ?></td>
                        </tr>
                        <?php endforeach; else: ?>
                            <tr><td colspan="3" class="text-center py-3">No Exam Period Data Found</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Bottom CTA -->
            <div class="text-center mt-5 pt-4">
                <a href="contact.php" class="btn bg-blue-react px-5 py-3 shadow-lg fw-bold rounded-lg text-white">
                    Click here for Free Trial Class
                </a>
            </div>
        </div>
        <?php endif; ?>

    </div>
</div>