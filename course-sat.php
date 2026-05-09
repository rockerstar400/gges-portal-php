<?php 
require_once 'functions.php';
include 'includes/header.php'; 

// Database se data uthana (Slug: sat)
$data = getTestPrepData('sat'); 
$hero = $data['hero'] ?? [];
$features = $data['features'] ?? [];
$about = $data['about'] ?? [];
$table = $data['table_data'] ?? [];
?>

<!-- AOS Animation CSS -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<main class="w-full bg-[#F0F8FF] py-5 px-4 md:px-16" style="background-image: url('assets/images/math-bg.png'); background-size: contain; background-position: center;">
    <div class="container py-5">
        
        <!-- HERO SECTION -->
        <div class="text-center mb-5" data-aos="fade-up">
            <h1 class="display-4 fw-bold text-dark mb-3"><?= $hero['title'] ?? 'SAT TEST PREP' ?></h1>
            <p class="lead text-secondary mx-auto" style="max-width: 800px;"><?= $hero['subtitle'] ?? '' ?></p>
        </div>

        <!-- MAIN DESCRIPTION -->
        <div class="row justify-content-center mb-5" data-aos="fade-in">
            <div class="col-lg-10 text-center">
                <p class="fs-5 text-dark lh-lg mb-4" style="white-space: pre-line;"><?= $hero['description'] ?? '' ?></p>
                <a href="contact.php" class="btn btn-primary btn-lg px-5 py-3 rounded-pill shadow">Click here for Free Trial Class</a>
            </div>
        </div>

        <!-- ABOUT & TABLE SECTION (3D Card Effect) -->
        <div class="card border-0 shadow-lg p-4 p-md-5 rounded-4 bg-white" data-aos="zoom-in" style="border: 1px solid #e0eaff !important;">
            <h2 class="text-center fw-bold text-dark mb-4"><?= $about['heading'] ?? 'ALL ABOUT SAT' ?></h2>
            <p class="text-secondary fs-5 text-center mb-5"><?= $about['description'] ?? '' ?></p>

            <div class="table-responsive rounded-3 shadow-sm">
                <table class="table table-hover align-middle border">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="p-3">Component</th>
                            <th class="p-3 text-center">Time Allowed (minutes)</th>
                            <th class="p-3 text-center">Number of Questions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($table)): foreach($table as $row): ?>
                        <tr>
                            <td class="p-3 fw-bold text-dark"><?= $row['name'] ?></td>
                            <td class="p-3 text-center"><?= $row['time'] ?></td>
                            <td class="p-3 text-center"><?= $row['modules'] ?></td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr><td colspan="3" class="text-center py-4">No data available</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="text-center mt-5">
                <a href="contact.php" class="btn btn-primary btn-lg px-5 py-3 rounded-3 fw-bold shadow">Click here for Free Trial Class</a>
            </div>
        </div>
    </div>
</main>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init({ duration: 800, once: true });</script>

<?php include 'includes/footer.php'; ?>