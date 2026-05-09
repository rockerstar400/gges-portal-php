<?php 
require_once 'functions.php';
include 'includes/header.php'; 

$data = getTestPrepData('ssat');
$hero = $data['hero'] ?? [];
$levels = $data['levels'] ?? [];
$about = $data['about'] ?? [];
$comp = $data['comparison'] ?? [];
$scoring = $data['scoring'] ?? [];
$facts = $data['quick_facts'] ?? [];
$struct = $data['structure'] ?? [];
$footer_score = $data['footer_score'] ?? [];
?>

<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<main class="bg-[#F0F8FF]" style="background-image: url('assets/images/math-bg.png'); background-blend-mode: overlay;">
    <div class="container py-5 space-y-5">
        
        <!-- HERO -->
        <div class="text-center py-5" data-aos="fade-down">
            <h1 class="display-4 fw-bold text-primary mb-4"><?= $hero['title'] ?? 'SSAT PREP' ?></h1>
            <div class="bg-white p-4 rounded-4 shadow-sm mx-auto border-top border-4 border-primary" style="max-width: 900px;">
                <p class="fs-5 text-secondary lh-base"><?= $hero['intro'] ?? '' ?></p>
            </div>
            <a href="contact.php" class="btn btn-primary btn-lg mt-4 px-5 rounded-pill shadow"><?= $hero['cta'] ?? 'Free Trial Class' ?></a>
        </div>

        <!-- ABOUT & LEVELS GRID -->
        <div class="row g-4 mb-5">
            <div class="col-md-6" data-aos="fade-right">
                <div class="bg-white p-5 rounded-4 shadow-lg border-start border-primary border-5 h-100">
                    <h2 class="fw-bold mb-3"><?= $about['heading'] ?? 'ABOUT SSAT' ?></h2>
                    <p class="text-secondary fs-5"><?= $about['content'] ?? '' ?></p>
                </div>
            </div>
            <div class="col-md-6" data-aos="fade-left">
                <div class="bg-white p-5 rounded-4 shadow-lg border-start border-purple border-5 h-100" style="border-left-color: #A855F7 !important;">
                    <h2 class="fw-bold mb-3">DIFFERENT LEVELS</h2>
                    <?php foreach($levels as $lv): ?>
                        <div class="mb-3 border-bottom pb-2">
                            <h5 class="text-primary fw-bold mb-1"><?= $lv['title'] ?></h5>
                            <p class="text-muted small mb-0"><?= $lv['desc'] ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- SCORING CARDS -->
        <div class="bg-white p-5 rounded-4 shadow-sm border mb-5">
            <h2 class="text-center fw-bold mb-5" data-aos="fade-up"><?= $scoring['heading'] ?? 'How is SSAT Scored?' ?></h2>
            <div class="row g-4">
                <?php foreach($scoring['cards'] ?? [] as $card): ?>
                <div class="col-md-4" data-aos="flip-left">
                    <div class="p-4 rounded-4 h-100 shadow-sm border-top border-3 border-primary bg-light">
                        <h5 class="fw-bold text-primary text-uppercase"><?= $card['title'] ?></h5>
                        <p class="small text-secondary"><?= $card['content'] ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- DUAL TABLES: TEST STRUCTURE -->
        <div class="bg-white p-5 rounded-4 shadow-lg mb-5">
            <h2 class="text-center fw-bold mb-5"><?= $struct['title'] ?? 'TEST STRUCTURE' ?></h2>
            <div class="row g-5">
                <!-- Middle Level -->
                <div class="col-xl-6" data-aos="fade-up">
                    <h4 class="fw-bold text-primary mb-3">Middle Level (5th-7th Grade)</h4>
                    <div class="table-responsive border rounded-3">
                        <table class="table table-striped mb-0">
                            <thead class="bg-primary text-white">
                                <tr><th>Section</th><th>Time</th><th>Q's</th><th>Link</th></tr>
                            </thead>
                            <tbody>
                                <?php foreach($struct['middle'] ?? [] as $row): ?>
                                <tr>
                                    <td><?= $row['sec'] ?></td>
                                    <td><?= $row['time'] ?></td>
                                    <td><?= $row['qs'] ?></td>
                                    <td><a href="<?= $row['link'] ?>" class="text-decoration-none fw-bold">Download</a></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Upper Level -->
                <div class="col-xl-6" data-aos="fade-up" data-aos-delay="200">
                    <h4 class="fw-bold text-success mb-3">Upper Level (8th-11th Grade)</h4>
                    <div class="table-responsive border rounded-3">
                        <table class="table table-striped mb-0">
                            <thead class="bg-success text-white">
                                <tr><th>Section</th><th>Time</th><th>Q's</th><th>Link</th></tr>
                            </thead>
                            <tbody>
                                <?php foreach($struct['upper'] ?? [] as $row): ?>
                                <tr>
                                    <td><?= $row['sec'] ?></td>
                                    <td><?= $row['time'] ?></td>
                                    <td><?= $row['qs'] ?></td>
                                    <td><a href="<?= $row['link'] ?>" class="text-decoration-none fw-bold text-success">Download</a></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init({ duration: 800, once: true });</script>

<?php include 'includes/footer.php'; ?>