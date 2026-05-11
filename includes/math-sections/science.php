<?php 
/**
 * SECTION: K-12 COMMON CORE SCIENCE (MATCHING REACT DESIGN)
 * Path: includes/math-sections/science.php
 */

// 1. Data Mapping for Main Science Info
$sciHeroDesc  = $scienceData['sci_hero_desc'] ?? "";
$sciTutorDesc = $scienceData['sci_tutor_desc'] ?? "";

// 2. Fetch Individual Science Topics
$scienceTopics = $conn->query("SELECT * FROM science_details ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<style>
    .sci-wrapper { font-family: 'Inter', sans-serif; color: #1f2937; }
    .bg-light-blue { background-color: #F0F8FF; }
    
    /* Tutor Background Section */
    .tutor-bg-wrapper {
        background-image: url('assets/images/tutor-bg.png'); 
        background-size: contain;
        background-position: center;
        background-repeat: no-repeat;
    }

    /* 3D Text Card */
    .sci-text-card {
        background-color: #AEE5FF;
        border-radius: 24px;
        padding: 2.5rem;
        border: 1px solid #bfdbfe;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .sci-text-card:hover {
        transform: translateY(-10px);
        box-shadow: 0px 15px 30px rgba(0,0,0,0.15) !important;
    }

    /* Floating Image Animation */
    .sci-float-img {
        animation: sciFloat 4s ease-in-out infinite;
        filter: drop-shadow(0 10px 15px rgba(0,0,0,0.1));
    }
    @keyframes sciFloat {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }

    /* Read More Logic Styles */
    .desc-truncate {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;  
        overflow: hidden;
    }
    .desc-full { display: block !important; }
    .see-more-btn { color: #2563eb; font-weight: 800; cursor: pointer; border: none; background: none; padding: 0; font-size: 0.9rem; }

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

<div class="sci-wrapper">

    <!-- ================= 1. INTRO SECTION ================= -->
    <section class="bg-light-blue py-5 px-3">
        <div class="container py-4" data-aos="fade-up">
            <h1 class="display-5 fw-bold text-center mb-4 text-dark text-uppercase">ABOUT COMMON CORE – SCIENCE</h1>
            <p class="fs-5 text-secondary text-center mx-auto mb-4" style="max-width: 1000px;"><?= $sciHeroDesc ?></p>
            
            <div class="text-center mt-5">
                <h3 class="h4 font-semibold mb-4">So why wait? To avail a Free Trial Class for AMC Test Prep Online Tutoring</h3>
                <a href="contact.php" class="btn btn-react-blue shadow-lg">Start Free Trial</a>
            </div>
        </div>
    </section>

    <!-- ================= 2. HOW & TOPICS SECTION ================= -->
    <section class="tutor-bg-wrapper bg-light-blue py-5 px-3">
        <div class="container py-5">
            
            <!-- How We Tutor Title -->
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="display-6 fw-bold">HOW WE TUTOR?</h2>
                <p class="fs-5 text-secondary mt-4 lh-lg mx-auto" style="max-width: 1100px;"><?= $sciTutorDesc ?></p>
            </div>

            <!-- Topics Section Title -->
            <div class="text-center my-5 pt-5" data-aos="fade-up">
                <h2 class="display-6 fw-bold">TOPICS WE TUTOR?</h2>
            </div>

            <!-- MAIN LOOP (Alternating) -->
            <?php foreach($scienceTopics as $idx => $item): 
                $isEven = ($idx % 2 != 0);
            ?>
            <section class="row align-items-center g-5 mb-5 pb-5">
                
                <!-- TEXT CARD COLUMN -->
                <div class="col-lg-6 <?= $isEven ? 'order-lg-2' : 'order-lg-1' ?>" data-aos="<?= $isEven ? 'fade-left' : 'fade-right' ?>">
                    <div class="sci-text-card shadow-sm">
                        <h2 class="h3 fw-bold mb-4"><?= $item['title'] ?></h2>
                        
                        <!-- Read More Component Logic -->
                        <div class="sci-description-container">
                            <p class="fs-5 text-dark mb-0 sci-desc-text" id="desc-<?= $idx ?>">
                                <?= $item['description'] ?>
                            </p>
                            <button class="see-more-btn mt-2 d-none" id="btn-<?= $idx ?>" onclick="toggleDesc(<?= $idx ?>)">See More</button>
                        </div>
                    </div>
                </div>

                <!-- IMAGE COLUMN -->
                <div class="col-lg-6 <?= $isEven ? 'order-lg-1' : 'order-lg-2' ?>" data-aos="<?= $isEven ? 'fade-right' : 'fade-left' ?>">
                    <div class="text-center">
                        <h2 class="h3 fw-bold mb-4"><?= $item['heading'] ?></h2>
                        <hr class="w-25 mx-auto mb-4 border-2 border-primary opacity-25">
                        <div class="sci-float-img">
                            <img src="<?= $item['image'] ?>" alt="Science Topic" class="img-fluid max-h-350">
                        </div>
                    </div>
                </div>

            </section>
            <?php endforeach; ?>

            <!-- FINAL INFO SECTION -->
            <section class="text-center py-5" data-aos="zoom-in">
                <div class="max-width-1000 mx-auto">
                    <p class="fs-5 fw-semibold text-secondary lh-lg mb-5">
                        Experience has shown time and time again that students who spend time in our tutoring centers see an overall increase in their science grades. This is because of our customized approach to science tutoring, which recognizes that no two students are exactly the same in terms of their needs and goals.
                    </p>
                    <h3 class="h4 fw-bold text-gray-800 mb-4">So why wait? To avail a Free Trial Class for Science Online Tutoring</h3>
                    <a href="contact.php" class="btn btn-react-blue shadow-xl">Start Free Trial</a>
                </div>
            </section>

        </div>
    </section>
</div>

<script>
    // Logic for "See More" only on mobile (like React code)
    function checkDescriptions() {
        const isMobile = window.innerWidth < 768;
        document.querySelectorAll('.sci-desc-text').forEach((el, index) => {
            const btn = document.getElementById('btn-' + index);
            if (isMobile && el.innerText.split(' ').length > 40) {
                el.classList.add('desc-truncate');
                btn.classList.remove('d-none');
            } else {
                el.classList.remove('desc-truncate');
                btn.classList.add('d-none');
            }
        });
    }

    function toggleDesc(id) {
        const el = document.getElementById('desc-' + id);
        const btn = document.getElementById('btn-' + id);
        if (el.classList.contains('desc-truncate')) {
            el.classList.remove('desc-truncate');
            btn.innerText = 'See Less';
        } else {
            el.classList.add('desc-truncate');
            btn.innerText = 'See More';
        }
    }

    window.addEventListener('resize', checkDescriptions);
    window.addEventListener('DOMContentLoaded', checkDescriptions);
</script>