<?php 
require_once 'functions.php';
include 'includes/header.php'; 

// URL se slug uthana (Default: sat)
$slug = $_GET['type'] ?? 'sat'; 

// Database se content lana
$data = getTestPrepData($slug);

// Agar data nahi mila toh error handle karein
if(!$data) {
    echo "<div class='text-center py-5'><h1>Course Not Found</h1><a href='index.php'>Go Back Home</a></div>";
    include 'includes/footer.php';
    exit;
}
?>

<!-- Animation Library (React ke Framer Motion jaisa look dene ke liye) -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
    .test-prep-main { background-image: url('assets/images/math-bg.png'); background-size: contain; background-position: center; background-color: #F0F8FF; background-blend-mode: overlay; min-height: 100vh; }
    .card-3d:hover { transform: translateY(-10px); transition: 0.4s; box-shadow: 0px 25px 50px -12px rgba(37, 99, 235, 0.25) !important; }
    .border-purple { border-left-color: #A855F7 !important; }
</style>

<div class="test-prep-main py-5 px-3">
    <div class="container py-4">

        <!-- ==========================================================================
             SECTION 1: SAT / PSAT LAYOUT
             (Inka design almost same hota hai)
        =========================================================================== -->
        <?php if ($slug == 'sat' || $slug == 'psat'): 
            $hero = $data['hero'] ?? [];
            $about = $data['about'] ?? [];
            $table = $data['table_data'] ?? [];
        ?>
            <!-- Hero -->
            <div class="text-center mb-5" data-aos="fade-up">
                <h1 class="display-4 fw-bold text-dark"><?= $hero['title'] ?? 'TEST PREP' ?></h1>
                <p class="lead text-secondary mt-3"><?= $hero['subtitle'] ?? '' ?></p>
            </div>

            <div class="text-center mb-5" data-aos="fade-in">
                <p class="fs-5 text-dark lh-lg mx-auto" style="max-width: 1000px; white-space: pre-line;"><?= $hero['description'] ?? '' ?></p>
                <a href="contact.php" class="btn btn-primary btn-lg px-5 py-3 rounded-pill shadow-lg mt-3">Click here for Free Trial Class</a>
            </div>

            <!-- About & Table Card -->
            <div class="card card-3d border-0 shadow-lg p-4 p-md-5 rounded-4 bg-white mt-5" data-aos="zoom-in">
                <h2 class="text-center fw-bold text-dark mb-4 text-uppercase"><?= $about['heading'] ?? 'About Test' ?></h2>
                <p class="text-secondary fs-5 text-center mb-5"><?= $about['description'] ?? '' ?></p>

                <div class="table-responsive rounded-3">
                    <table class="table table-hover align-middle border">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="p-3">Component</th>
                                <th class="p-3 text-center">Time Allowed(minutes)</th>
                                <th class="p-3 text-center">Number of Question/Tasks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($table as $row): ?>
                            <tr>
                                <td class="p-3 fw-bold"><?= $row['name'] ?></td>
                                <td class="p-3 text-center"><?= $row['time'] ?></td>
                                <td class="p-3 text-center"><?= $row['modules'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- PSAT Special Section: Exam Period (Agar PSAT ho toh dikhega) -->
                <?php if($slug == 'psat' && !empty($data['exam_period_json'])): 
                    $examPeriod = json_decode($data['exam_period_json'], true); ?>
                    <h3 class="fw-bold mt-5 mb-4 text-danger">Exam Period</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered bg-light">
                            <thead class="bg-dark text-white">
                                <tr><th>Section Name</th><th>Time</th><th>Modules</th></tr>
                            </thead>
                            <tbody>
                                <?php foreach($examPeriod as $ex): ?>
                                    <tr><td><?= $ex['name'] ?></td><td><?= $ex['time'] ?></td><td><?= $ex['modules'] ?></td></tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <div class="text-center mt-5">
                    <a href="contact.php" class="btn btn-primary btn-lg px-5 py-3 rounded-3 fw-bold shadow">Click here for Free Trial Class</a>
                </div>
            </div>

        <!-- ==========================================================================
             SECTION 2: SSAT LAYOUT (Levels, Cards, Dual Tables)
        =========================================================================== -->
        <?php elseif ($slug == 'ssat'): 
            $hero = $data['hero'] ?? [];
            $levels = $data['levels'] ?? [];
            $about = $data['about'] ?? [];
            $scoring = $data['scoring'] ?? [];
            $struct = $data['structure'] ?? [];
        ?>
            <!-- Hero -->
            <div class="text-center py-4" data-aos="fade-down">
                <h1 class="display-3 fw-bold text-primary mb-4"><?= $hero['title'] ?? 'SSAT PREP' ?></h1>
                <div class="bg-white p-4 rounded-4 shadow-sm mx-auto border-top border-4 border-primary" style="max-width: 900px;">
                    <p class="fs-5 text-secondary"><?= $hero['intro'] ?? '' ?></p>
                </div>
            </div>

            <!-- About & Levels -->
            <div class="row g-4 my-5">
                <div class="col-md-6" data-aos="fade-right">
                    <div class="bg-white p-4 p-md-5 rounded-4 shadow-lg border-start border-primary border-5 h-100">
                        <h2 class="fw-bold mb-4"><?= $about['heading'] ?? 'ABOUT SSAT' ?></h2>
                        <div class="text-secondary fs-5" style="white-space: pre-wrap;"><?= $about['content'] ?? '' ?></div>
                    </div>
                </div>
                <div class="col-md-6" data-aos="fade-left">
                    <div class="bg-white p-4 p-md-5 rounded-4 shadow-lg border-start border-purple border-5 h-100">
                        <h2 class="fw-bold mb-4">DIFFERENT LEVELS</h2>
                        <?php foreach($levels as $lv): ?>
                            <div class="mb-3 border-bottom pb-2">
                                <h5 class="text-primary fw-bold mb-1"><?= $lv['title'] ?></h5>
                                <p class="text-muted small mb-0"><?= $lv['desc'] ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Scoring Cards -->
            <div class="bg-white p-5 rounded-4 shadow-sm border my-5" data-aos="fade-up">
                <h2 class="text-center fw-bold mb-5"><?= $scoring['heading'] ?? 'Scoring Info' ?></h2>
                <div class="row g-4">
                    <?php foreach($scoring['cards'] ?? [] as $card): ?>
                    <div class="col-md-4">
                        <div class="p-4 rounded-4 h-100 shadow-sm border-top border-3 border-primary bg-light card-3d">
                            <h5 class="fw-bold text-primary text-uppercase"><?= $card['title'] ?></h5>
                            <p class="small text-secondary"><?= $card['content'] ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <p class="text-center mt-4 text-muted fst-italic"><?= $scoring['footer'] ?? '' ?></p>
            </div>

            <!-- Dual Tables -->
            <div class="bg-white p-4 p-md-5 rounded-4 shadow-lg mb-5" data-aos="fade-up">
                <h2 class="text-center fw-bold mb-5"><?= $struct['title'] ?? 'TEST STRUCTURE' ?></h2>
                <div class="row g-5">
                    <div class="col-xl-6">
                        <h4 class="fw-bold text-primary mb-3">Middle Level (5th-7th Grade)</h4>
                        <div class="table-responsive border rounded-3">
                            <table class="table table-striped mb-0">
                                <thead class="bg-primary text-white"><tr><th>Section</th><th>Time</th><th>Q's</th></tr></thead>
                                <tbody>
                                    <?php foreach($struct['middle'] ?? [] as $row): ?>
                                    <tr><td><?= $row['sec'] ?></td><td><?= $row['time'] ?></td><td><?= $row['qs'] ?></td></tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <h4 class="fw-bold text-success mb-3">Upper Level (8th-11th Grade)</h4>
                        <div class="table-responsive border rounded-3">
                            <table class="table table-striped mb-0">
                                <thead class="bg-success text-white"><tr><th>Section</th><th>Time</th><th>Q's</th></tr></thead>
                                <tbody>
                                    <?php foreach($struct['upper'] ?? [] as $row): ?>
                                    <tr><td><?= $row['sec'] ?></td><td><?= $row['time'] ?></td><td><?= $row['qs'] ?></td></tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        <!-- ==========================================================================
             SECTION 3: NEXT PAGE PLACEHOLDER
             (ISEE / SHSAT etc. yahan aayenge)
        =========================================================================== -->
        <?php elseif ($slug == 'shsat'): ?>
             <!-- SHSAT Ka Layout Yahan Add Karenge Jab Aap React Code Doge -->
             <div class="text-center py-5"><h2>SHSAT Section is Loading...</h2></div>

        <?php endif; ?>

    </div>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init({ duration: 800, once: true });</script>

<?php include 'includes/footer.php'; ?>