<?php 
/**
 * SECTION: COMMON ENGLISH LANGUAGE HERO
 * Path: includes/english-sections/hero-section.php
 */
?>

<style>
    /* --- React Style Theme --- */
    .hero-main-wrapper {
        background-color: #F0F8FF;
        background-image: url('assets/images/work-bg.png');
        background-size: contain;
        background-position: center;
        background-repeat: no-repeat;
        overflow: hidden;
    }

    /* Floating Image Animation */
    .react-floating-img {
        animation: floatAnim 4s ease-in-out infinite;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    }
    @keyframes floatAnim {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-12px); }
    }

    /* Card Designs exactly like React */
    .react-prop-card {
        padding: 20px;
        border-radius: 1.25rem; /* rounded-xl */
        font-size: 0.95rem;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
        display: flex;
        align-items: center;
        height: 100%;
    }
    .react-prop-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08);
    }

    /* Colors from React Code */
    .bg-sky-react { background-color: #e0f2fe; color: #075985; } /* sky-100 */
    .bg-cyan-react { background-color: #cffafe; color: #164e63; } /* cyan-100 */
    .bg-purple-react { background-color: #f3e8ff; color: #581c87; } /* purple-100 */
    .bg-pink-react { background-color: #fce7f3; color: #831843; } /* pink-100 */
    .bg-green-react { background-color: #dcfce7; color: #064e3b; } /* green-100 */

    .btn-blue-react {
        background-color: #2563eb;
        color: white !important;
        font-weight: 600;
        padding: 14px 40px;
        border-radius: 0.75rem;
        transition: 0.3s;
        border: none;
        box-shadow: 0 10px 15px rgba(37, 99, 235, 0.2);
    }
    .btn-blue-react:hover {
        background-color: #1d4ed8;
        transform: scale(1.05);
    }
</style>

<div class="hero-main-wrapper py-5 px-3">
    <div class="container py-5">
        <div class="row align-items-center g-5">
            
            <!-- LEFT CONTENT -->
            <div class="col-lg-7" data-aos="fade-right">
                <h1 class="display-5 fw-bold text-dark mb-4 lh-sm">
                    <?= $langData['eng_lang_heading'] ?? 'COMMON CORE – ENGLISH LANGUAGE AND ARTS' ?>
                </h1>
                
                <p class="fs-5 text-secondary mb-4 lh-lg" style="max-width: 90%; text-align: justify;">
                    <?= $langData['eng_lang_desc'] ?? '' ?>
                </p>

                <p class="fw-bold text-dark h5 mb-5">
                    So why wait? To avail a Free Trial Class for English Online Tutoring
                </p>

                <div class="mt-4">
                    <a href="contact.php" class="btn-blue-react shadow-lg text-uppercase">
                        Start Free Trial
                    </a>
                </div>
            </div>

            <!-- RIGHT FLOATING GRID (Exact React Layout) -->
            <div class="col-lg-5">
                <div class="row g-3">
                    
                    <!-- Left Column of the Grid -->
                    <div class="col-6 d-flex flex-column gap-3">
                        <div class="react-prop-card bg-sky-react shadow-sm" data-aos="fade-up">
                            <?= $langData['eng_lang_prop1'] ?? '' ?>
                        </div>

                        <div class="bg-white p-3 rounded-4 shadow-sm react-floating-img">
                            <img src="<?= $langData['eng_lang_image'] ?>" class="img-fluid rounded-3" alt="student">
                        </div>

                        <div class="react-prop-card bg-cyan-react shadow-sm" data-aos="fade-up">
                            <?= $langData['eng_lang_prop2'] ?? '' ?>
                        </div>
                    </div>

                    <!-- Right Column of the Grid -->
                    <div class="col-6 d-flex flex-column gap-3 mt-4">
                        <div class="react-prop-card bg-purple-react shadow-sm" data-aos="fade-up" data-aos-delay="100">
                            <?= $langData['eng_lang_prop3'] ?? '' ?>
                        </div>
                        
                        <div class="react-prop-card bg-pink-react shadow-sm" data-aos="fade-up" data-aos-delay="200">
                            <?= $langData['eng_lang_prop4'] ?? '' ?>
                        </div>

                        <div class="react-prop-card bg-green-react shadow-sm" data-aos="fade-up" data-aos-delay="300">
                            <?= $langData['eng_lang_prop5'] ?? '' ?>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>