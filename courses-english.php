<?php 
require_once 'functions.php';
include 'includes/header.php'; 
include 'includes/navbar.php';

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
<?php
require_once 'functions.php';

// FIX: Aapka header 'includes' folder ke andar hai
if(file_exists('includes/header.php')){
    include 'includes/header.php';
}

// Data Fetching (Slug database se match kar raha hai: eng-core-ela)
$sectionData = getSectionBySlug('eng-core-ela');
$gridItems = getEnglishGridItems('eng-core-ela');

// Content variables nikalna
$title = $sectionData['title'] ?? 'ABOUT COMMON CORE – ELA';
$content = $sectionData['content'] ?? [];
?>

<main class="overflow-hidden">

    <!-- --- HERO SECTION --- -->
    <section id="common" class="py-5" style="background: #F0F8FF; border-bottom: 1px solid #eee;">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <h2 class="display-5 fw-bold text-dark mb-4">English Online Tutoring</h2>
                    <p class="lead text-secondary mb-4">
                        Master the Common Core English Language Arts (ELA) with our expert tutors. 
                        We cover everything from Reading to Writing.
                    </p>
                    <p class="fw-bold text-primary">So why wait? To avail a Free Trial Class for English Online Tutoring</p>
                    <a href="contact.php" class="btn btn-primary btn-lg px-5 rounded-pill shadow mt-3">Start Free Trial</a>
                </div>
                <div class="col-lg-5 text-center">
                    <!-- Standard image path -->
                    <img src="assets/images/student.png" class="img-fluid rounded-4 shadow-lg" alt="Student" onerror="this.src='https://via.placeholder.com/400x300?text=English+Class'">
                </div>
            </div>
        </div>
    </section>

    <!-- --- DYNAMIC CONTENT SECTION (ELA) --- -->
    <section id="ela" class="py-5 bg-white">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-uppercase"><?php echo $title; ?></h2>
                <div class="mt-4 text-start mx-auto text-secondary" style="max-width: 900px;">
                    <?php 
                    // Database mein 'core_descriptions' key hai (Screenshot check kiya)
                    $paras = $content['core_descriptions'] ?? [];
                    if(!empty($paras)){
                        foreach($paras as $p) echo "<p class='fs-5 mb-3'>$p</p>";
                    } else {
                        echo "<p class='text-center'>Content loading from database...</p>";
                    }
                    ?>
                </div>
            </div>

            <!-- WHAT WE COVER (GRID) -->
            <div class="mt-5 pt-4 border-top">
                <h3 class="fw-bold mb-4">WHAT WE COVER?</h3>
                <div class="row row-cols-2 row-cols-md-4 row-cols-lg-5 g-4">
                    <?php foreach($gridItems as $item): ?>
                    <div class="col">
                        <div class="card h-100 border-0 shadow-sm text-center p-3 rounded-4 bg-light">
                            <div class="bg-primary rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <img src="<?php echo $item['image']; ?>" class="w-50" alt="icon">
                            </div>
                            <p class="fw-bold small mb-0"><?php echo $item['title']; ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
</main>

<?php 
if(file_exists('includes/footer.php')) include 'includes/footer.php'; 
?>
