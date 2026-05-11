<?php 
require_once 'functions.php';
include 'includes/header.php'; 
include 'includes/navbar.php';

// Data fetching based on Admin Slugs
$mathHome = getTestPrepData('math-common-core');
$algebraData = getTestPrepData('math-algebra');
$geometryData = getTestPrepData('math-geometry');
$amcData = getTestPrepData('math-amc');
$kangarooData = getTestPrepData('math-kangaroo');
$scienceData = getTestPrepData('math-science');
?>

<!-- AOS Library for Motion Effects -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
    .math-master { background-color: #F0F8FF; overflow-x: hidden; font-family: 'Inter', sans-serif; }
    section { scroll-margin-top: 85px; }
    .btn-react-blue { background: #2563eb; color: #fff !important; padding: 14px 40px; border-radius: 8px; font-weight: 600; transition: 0.3s; border: none; display: inline-block; text-decoration: none; }
    .btn-react-blue:hover { background: #1d4ed8; transform: scale(1.05); box-shadow: 0 10px 20px rgba(37, 99, 235, 0.2); }
</style>

<div class="math-master">
    <!-- 1. COMMON CORE MATH -->
    <section id="math">
        <?php include 'includes/math-sections/math-home.php'; ?>
    </section>

    <!-- 2. MATH ALGEBRA -->
    <section id="algebra">
        <?php include 'includes/math-sections/algebra.php'; ?>
    </section>

    <!-- 3. GEOMETRY -->
    <section id="geometry">
        <?php include 'includes/math-sections/geometry.php'; ?>
    </section>

    <!-- Placeholders for others (Next pages code) -->
    <section id="mathamc"><?php include 'includes/math-sections/amc.php'; ?></section>
    <section id="kangaroo"><?php include 'includes/math-sections/kangaroo.php'; ?></section>
    <section id="science"><?php include 'includes/math-sections/science.php'; ?></section>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init({ duration: 1000, once: true });</script>

<?php include 'includes/footer.php'; ?>