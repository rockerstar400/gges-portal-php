<?php 
/**
 * SECTION: WHAT THE SECTIONS MEASURE
 * Path: includes/english-sections/measure-section.php
 * Note: $prepData is fetched in the main courses-english.php file using slug 'eng-registration'
 */

// Mapping variables based on our English Admin Logic
$measure = $prepData['eng_measure'] ?? []; // JSON decoded array (title1, description1, etc.)
?>

<style>
    .measure-wrapper {
        background-color: #F0F8FF;
        font-family: 'Inter', sans-serif;
    }

    /* Premium 3D Card Style */
    .measure-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 30px;
        border: 1px solid #f3f4f6;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        height: 100%;
        cursor: default;
        position: relative;
    }

    .measure-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0px 20px 40px rgba(59, 130, 246, 0.15) !important;
    }

    /* Icon Container with Flip Effect */
    .icon-container {
        background-color: #dbeafe; /* blue-100 */
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        transition: transform 0.6s;
        transform-style: preserve-3d;
    }

    .measure-card:hover .icon-container {
        transform: rotateY(180deg);
    }

    .icon-container img {
        width: 24px;
        height: 24px;
        object-fit: contain;
    }

    /* Special Dot for Reading Comprehension */
    .reading-dot {
        position: absolute;
        top: 24px;
        right: 24px;
        width: 8px;
        height: 8px;
        background-color: #d1d5db; /* gray-300 */
        border-radius: 50%;
    }

    .measure-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 12px;
    }

    .measure-desc {
        font-size: 1.1rem;
        color: #4b5563;
        line-height: 1.6;
    }
</style>

<div class="measure-wrapper py-5 px-3">
    <div class="container py-4">
        
        <!-- Header Section -->
        <div class="mb-5 pb-3" data-aos="fade-right">
            <h1 class="h2 fw-bold text-dark">What the sections measure</h1>
        </div>

        <!-- First Row: 3 Cards (Verbal, Quant, Reading) -->
        <div class="row g-4 mb-4">
            <!-- Card 1: Verbal -->
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="measure-card shadow-sm">
                    <div class="icon-container">
                        <img src="assets/icons/verbal.png" alt="Verbal">
                    </div>
                    <h3 class="measure-title"><?= $measure['title1'] ?? 'Verbal Reasoning' ?></h3>
                    <p class="measure-desc"><?= $measure['description1'] ?? '' ?></p>
                </div>
            </div>

            <!-- Card 2: Quantitative -->
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="measure-card shadow-sm">
                    <div class="icon-container">
                        <img src="assets/icons/quantitative.png" alt="Quantitative">
                    </div>
                    <h3 class="measure-title"><?= $measure['title2'] ?? 'Quantitative Reasoning' ?></h3>
                    <p class="measure-desc"><?= $measure['description2'] ?? '' ?></p>
                </div>
            </div>

            <!-- Card 3: Reading (With Special Dot) -->
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="measure-card shadow-sm">
                    <div class="reading-dot"></div>
                    <div class="icon-container">
                        <img src="assets/icons/reading.png" alt="Reading">
                    </div>
                    <h3 class="measure-title"><?= $measure['title3'] ?? 'Reading Comprehension' ?></h3>
                    <p class="measure-desc"><?= $measure['description3'] ?? '' ?></p>
                </div>
            </div>
        </div>

        <!-- Second Row: 2 Cards Centered (Mathematics, Essay) -->
        <div class="row g-4 justify-content-center">
            <!-- Card 4: Mathematics -->
            <div class="col-md-5" data-aos="fade-up" data-aos-delay="400">
                <div class="measure-card shadow-sm text-center">
                    <div class="icon-container mx-auto">
                        <img src="assets/icons/mathmatics.png" alt="Math">
                    </div>
                    <h3 class="measure-title"><?= $measure['title4'] ?? 'Mathematics Achievement' ?></h3>
                    <p class="measure-desc"><?= $measure['description4'] ?? '' ?></p>
                </div>
            </div>

            <!-- Card 5: Essay -->
            <div class="col-md-5" data-aos="fade-up" data-aos-delay="500">
                <div class="measure-card shadow-sm text-center">
                    <div class="icon-container mx-auto">
                        <img src="assets/icons/essay.png" alt="Essay">
                    </div>
                    <h3 class="measure-title"><?= $measure['title5'] ?? 'Essay' ?></h3>
                    <p class="measure-desc"><?= $measure['description5'] ?? '' ?></p>
                </div>
            </div>
        </div>

    </div>
</div>