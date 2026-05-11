<?php 
// Admin se banner data fetch karna
$bannerData = getBanner(); 

/**
 * Path Logic: 
 * Admin se jo image aati hai wo 'uploads/filename.jpg' hoti hai.
 * Frontend par dikhane ke liye hume check karna hoga ki file exist karti hai ya nahi.
 */
$dynamicImg = (!empty($bannerData['image']) && file_exists($bannerData['image'])) ? $bannerData['image'] : 'assets/images/heroBanner.jpg';
?>

<style>
    /* 1. Main Container: Ye poori screen lega (100vh) */
    .banner-container {
        position: relative;
        width: 100%;
        height: 100vh; 
        display: flex;
        flex-direction: column;
        justify-content: center; /* Vertical Center */
        align-items: center;     /* Horizontal Center */
        text-align: center;
        color: white;
        overflow: hidden;
        margin-top: -85px; /* Navbar ke height ke hisaab se adjust karein agar navbar transparent karni ho */
    }

    /* 2. Background Image (absolute positioning) */
    .banner-bg-image {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover; /* Image khichegi nahi */
        z-index: -1; 
    }

    /* 3. Dark Overlay (React design ko match karne ke liye) */
    .banner-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.4); /* 40% andhera taaki white text dikhe */
        z-index: 0;
    }

    /* 4. Text Content Logic */
    .banner-content {
        position: relative;
        z-index: 1; /* Overlay ke upar */
        padding: 0 20px;
    }

    .text-bold-white {
        font-size: clamp(2rem, 5vw, 4rem); /* Responsive font size */
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 0.5rem;
        text-shadow: 0 4px 15px rgba(0,0,0,0.5); /* Premium Look */
    }

    .sub-text-white {
        font-size: 1.25rem;
        color: #ffffff;
        margin-bottom: 2.5rem;
        max-width: 800px;
        opacity: 0.95;
        line-height: 1.6;
    }

    /* 5. Start Free Trial Button (#305CDE) */
    .btn-free-trial {
        background-color: #ffffff;
        color: #305CDE !important;
        font-weight: 700;
        padding: 18px 50px;
        border-radius: 50px;
        font-size: 1.1rem;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        text-decoration: none;
        display: inline-block;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .btn-free-trial:hover {
        transform: scale(1.1) translateY(-5px);
        background-color: #f8f9ff;
        box-shadow: 0 15px 30px rgba(0,0,0,0.3);
    }
</style>

<div class="banner-container">
    <!-- Background dynamic image -->
    <img src="<?= $dynamicImg ?>" class="banner-bg-image" alt="Hero Banner">
    
    <!-- Dark overlay -->
    <div class="banner-overlay"></div>

    <!-- Text Overlay Content -->
    <div class="banner-content" data-aos="zoom-out">
        <div class="text-bold-white">Personalized Online prateek</div>
        <div class="text-bold-white">Tutoring Anytime</div>
        <div class="display-5 fw-bold mb-4 text-white">Anywhere</div>
        
        <div class="sub-text-white mx-auto">
            Connect with expert tutors for math, science, 
            languages, and more — tailored to your goals.
        </div>

        <a href="contact.php" class="btn-free-trial shadow-lg">
            Start Free Trial
        </a>
    </div>
</div>