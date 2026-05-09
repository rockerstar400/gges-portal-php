<?php 
require_once 'functions.php';
include 'includes/header.php'; 

// Data fetching (Admin slugs ke according)
$langData = getTestPrepData('eng-common-lang'); // Common English Language
$coreData = getTestPrepData('eng-core-ela');   // Common Core ELA
$coreDetails = $conn->query("SELECT * FROM core_ela_details ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
// Baki sections ka data bhi yahi fetch kar lena...
?>

<!-- AOS for Animations (React motion ka replacement) -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
    .eng-wrapper { overflow-x: hidden; font-family: 'Inter', sans-serif; }
    section { scroll-margin-top: 80px; } /* Header offset */
</style>

<div class="eng-wrapper">
    <!-- 1. Hero Section -->
    <section id="common">
        <?php include 'includes/english-sections/hero-section.php'; ?>
    </section>

    <!-- 2. Core ELA Section -->
    <section id="englishela">
        <?php include 'includes/english-sections/core-ela-section.php'; ?>
    </section>

    <!-- 3. About Info Section (Placeholder - aap iska file bana lena) -->
    <section id="aboutela">
        <?php include 'includes/english-sections/about-info-section.php'; ?>
    </section>

    <!-- 4. Test Page (ISEE) Section -->
    <section id="englishisee">
        <?php include 'includes/english-sections/test-section.php'; ?>
    </section>

    <!-- 5. Measure & Structure -->
    <?php include 'includes/english-sections/measure-section.php'; ?>
    <?php include 'includes/english-sections/structure-section.php'; ?>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init({ duration: 800, once: true });</script>

<?php include 'includes/footer.php'; ?>