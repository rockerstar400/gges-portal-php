<?php 
/**
 * SECTION: TEST STRUCTURE (Registration Page)
 * Path: includes/english-sections/structure-section.php
 * Note: $prepData is fetched in the main courses-english.php file using slug 'eng-registration'
 */

$regData = getTestPrepData('eng-registration');

// Mapping variables
$title       = $regData['eng_reg_title'] ?? "Structure Title";
$description = $regData['eng_reg_desc'] ?? "Description not available.";
?>

<style>
    .structure-wrapper {
        background-color: #F0F8FF;
        background-image: url('assets/images/work-bg.png');
        background-size: contain;
        background-position: center;
        position: relative;
        overflow: hidden;
    }

    /* 🔥 3D Floating Image logic */
    .floating-container {
        position: relative;
        display: inline-block;
        transition: transform 0.3s ease;
    }

    .image-glow-effect {
        position: absolute;
        inset: -10px;
        background: #3b82f6;
        border-radius: 24px;
        filter: blur(25px);
        opacity: 0.15;
        z-index: 0;
    }

    .float-anim {
        animation: floatImage 5s ease-in-out infinite;
        z-index: 10;
        position: relative;
        border: 1px solid rgba(255, 255, 255, 0.5);
    }

    @keyframes floatImage {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }

    /* React Style Buttons */
    .btn-blue-react {
        background-color: #2563eb;
        color: white !important;
        font-weight: 600;
        padding: 12px 35px;
        border-radius: 10px;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        border: none;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        text-decoration: none;
        display: inline-block;
    }

    .btn-blue-react:hover {
        transform: scale(1.05);
        background-color: #1d4ed8;
        box-shadow: 0px 10px 20px rgba(37, 99, 235, 0.4);
    }
</style>

<div class="structure-wrapper py-5 px-3">
    <div class="container py-5 relative z-10">
        
        <!-- Header Animation -->
        <div class="text-center mb-5" data-aos="fade-up">
            <h1 class="text-uppercase fw-bold text-gray-800 mb-5" style="letter-spacing: 2px;">
                Test Structure
            </h1>

            <!-- 🔥 3D Floating Image Card -->
            <div class="floating-container mb-5" data-aos="zoom-in" data-aos-duration="800">
                <div class="image-glow-effect"></div>
                <!-- assets/images/isee.jpg file path ensure karein -->
                <img src="assets/images/isee.jpg" 
                     alt="Test Structure" 
                     class="img-fluid rounded-4 shadow-2xl float-anim max-width-800 mx-auto"
                     style="width: 100%; max-width: 800px;">
            </div>

            <!-- Dynamic Title -->
            <h2 class="display-5 fw-bold text-gray-900 mt-5" data-aos="fade-up">
                <?= $title ?>
            </h2>
        </div>

        <!-- Description Paragraph -->
        <div class="max-width-900 mx-auto text-center mb-5" data-aos="fade-up" data-aos-delay="200">
            <p class="fs-5 text-gray-700 lh-lg px-2">
                <?= $description ?>
            </p>
        </div>

        <!-- CTA Section -->
        <div class="text-center mt-5" data-aos="zoom-in">
            <div class="fw-bold fs-5 mb-4 text-gray-800">
                So why wait? To avail a Free Trial Class for Science Online Tutoring
            </div>

            <div class="flex justify-center">
                <a href="contact.php" class="btn-blue-react">
                    Start Free Trial
                </a>
            </div>
        </div>

    </div>
</div>