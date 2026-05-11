<?php 
/**
 * SECTION: MATH KANGAROO FRONTEND (EXACT REACT REPLICA)
 * Path: includes/math-sections/kangaroo.php
 */

// 1. Data Mapping for Main Kangaroo Info
$heroTitle   = $kangarooData['hero']['title'] ?? "MATH KANGAROO TEST PREP";
$heroDesc    = $kangarooData['hero']['description'] ?? "";
// Admin saved 'kan_struct_json', master function made it 'kan_struct'
$structDescs = $kangarooData['kan_struct'] ?? []; 

// 2. Fetch Detail Kangaroo Items (Images & List)
$detailItems = $conn->query("SELECT * FROM kangaroo_details ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<style>
    .kangaroo-wrapper {
        background-color: #F0F8FF;
        background-image: url('assets/images/test-bg.png'); /* React: testBgImg */
        background-size: contain;
        background-position: center;
        background-repeat: no-repeat;
        min-height: 100vh;
        overflow-x: hidden;
    }

    /* Floating Image Animation */
    .float-anim {
        animation: kangarooFloat 5s ease-in-out infinite;
    }
    @keyframes kangarooFloat {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-15px) rotate(1deg); }
    }

    .card-hover-react:hover {
        transform: scale(1.02);
        transition: 0.3s ease-in-out;
    }

    .btn-react-blue {
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
    .btn-react-blue:hover {
        background-color: #1d4ed8;
        transform: scale(1.05);
        box-shadow: 0 10px 20px rgba(37, 99, 235, 0.4);
    }
</style>

<div class="kangaroo-wrapper py-5 px-3">
    <div class="container py-4">

        <!-- ================= 1. TOP / HERO SECTION ================= -->
        <section class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-bold text-gray-800 mb-3"><?= $heroTitle ?></h2>
            <div class="fs-5 text-secondary mx-auto mb-4 lh-lg" style="max-width: 1000px;">
                <?= $heroDesc ?>
            </div>
            <p class="h4 fw-bold text-dark mb-4">So why wait? To avail a Free Trial Class for Math Kangaroo Test Prep Online Tutoring</p>
            <a href="contact.php" class="btn-react-blue shadow-lg">Start Free Trial</a>
        </section>

        <!-- ================= 2. TEST STRUCTURE SECTION ================= -->
        <section class="py-5" data-aos="fade-up">
            <h1 class="display-6 fw-bold text-center mb-4">TEST STRUCTURE</h1>
            <div class="mx-auto" style="max-width: 900px;">
                <?php foreach($structDescs as $p): ?>
                    <p class="fs-5 text-secondary mb-3"><?= $p ?></p>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- ================= 3. MAIN CONTENT LOOP (Alternating) ================= -->
        <main class="py-5">
            <?php foreach($detailItems as $idx => $item): 
                $isEven = ($idx % 2 != 0); // Check for alternating layout
                $itemDescs = json_decode($item['description'], true) ?: [];
            ?>
            <div class="row align-items-center g-5 mb-5 pb-5">
                
                <!-- TEXT COLUMN -->
                <div class="col-lg-6 <?= $isEven ? 'order-lg-2' : 'order-lg-1' ?>" 
                     data-aos="<?= $isEven ? 'fade-left' : 'fade-right' ?>">
                    <h2 class="display-6 fw-bold text-dark mb-4"><?= $item['title'] ?></h2>
                    <ul class="list-unstyled space-y-3">
                        <?php foreach($itemDescs as $pIdx => $desc): ?>
                        <li class="fs-5 text-secondary d-flex align-items-start">
                            <span class="fw-bold text-dark me-2"><?= $pIdx + 1 ?>.</span>
                            <span style="white-space: pre-line;"><?= $desc ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- IMAGE COLUMN (Floating) -->
                <div class="col-lg-6 <?= $isEven ? 'order-lg-1' : 'order-lg-2' ?>" 
                     data-aos="<?= $isEven ? 'fade-right' : 'fade-left' ?>">
                    <div class="float-anim">
                        <img src="<?= $item['image'] ?>" 
                             alt="Kangaroo Detail" 
                             class="img-fluid rounded-4 shadow-2xl card-hover-react border border-white border-4">
                    </div>
                </div>

            </div>
            <?php endforeach; ?>
        </main>

        <!-- ================= 4. FOOTER CTA SECTION ================= -->
        <div class="text-center py-5" data-aos="zoom-in">
            <p class="fs-5 fw-bold text-dark mb-4">
                We have the best content and specialized tutors available for Math Kangaroo.
            </p>
            <h3 class="h4 fw-bold text-gray-800 mb-4">
                So why wait? To avail a Free Trial Class for AMC Test Prep Online Tutoring
            </h3>
            <a href="contact.php" class="btn-react-blue shadow-xl px-5">Start Free Trial</a>
        </div>

    </div>
</div>