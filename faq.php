<?php 
require_once 'functions.php';

// 1. Data Fetching
$bannerData = getBanner(); // Admin se marquee title ke liye
$faqs = $conn->query("SELECT * FROM faqs ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);

include 'includes/header.php'; 
include 'includes/navbar.php';
?>

<!-- AOS for premium motion effects -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<style>
    /* --- 1. Hero & Marquee Styles --- */
    .animate-up {
        opacity: 0;
        transform: translateY(30px);
        animation: fadeInUp 0.8s ease forwards;
    }
    @keyframes fadeInUp {
        to { opacity: 1; transform: translateY(0); }
    }

    .hero-area {
        background-color: #F8FBFF;
        border-bottom: 1px solid #e2e8f0;
    }

    /* --- 2. FAQ Accordion Styles --- */
    .faq-wrapper {
        background-color: #F8FBFF;
        min-height: 50vh;
        font-family: 'Inter', sans-serif;
    }

    .faq-item {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
        border: 1px solid transparent;
        transition: all 0.3s ease;
    }

    .faq-item[open] {
        border-color: #dbeafe;
        box-shadow: 0 10px 25px rgba(5, 114, 230, 0.1);
    }

    summary {
        list-style: none;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 24px;
        font-size: 1.25rem;
        font-weight: 600;
        color: #0572E6;
        cursor: pointer;
        outline: none;
    }

    summary::-webkit-details-marker { display: none; }

    .arrow-icon { transition: transform 0.3s ease; font-size: 1rem; }
    .faq-item[open] .arrow-icon { transform: rotate(180deg); }

    .faq-content {
        padding: 0 24px 24px 24px;
        font-size: 1.125rem;
        color: #4b5563;
        line-height: 1.7;
    }

    .text-navy-react { color: #0E1D3E; }
    .btn-react-blue { background-color: #2563eb; color: white !important; }
</style>

<!-- ==========================================
     SECTION 1: DYNAMIC MARQUEE (Admin Title)
=========================================== -->
<div class="bg-primary text-white py-2">
    <marquee behavior="scroll" direction="left" class="fw-bold">
        <?php echo $bannerData ? $bannerData['title'] : "Welcome to GGES Portal!"; ?>
    </marquee>
</div>

<!-- ==========================================
     SECTION 2: HERO CONTENT AREA
=========================================== -->
<div class="hero-area py-5">
    <div class="container text-center py-5">
        <div class="animate-up" style="animation-delay: 0.3s;">
            <h1 class="display-3 fw-bold">Personalized <span class="text-primary">Online</span></h1>
        </div>
        <div class="animate-up" style="animation-delay: 0.6s;">
            <h1 class="display-3 fw-bold">Tutoring</h1>
            <h2 class="text-primary display-4 fw-bold mb-4">From Our Experienced Tutors</h2>
        </div>
        
        <p class="lead text-muted mx-auto mb-5 animate-up" style="max-width: 700px; animation-delay: 0.9s;">
            We provide the best educational support to help you achieve your goals with ease.
        </p>

        <div class="animate-up" style="animation-delay: 1.2s;">
            <a href="contact.php" class="btn btn-primary btn-lg px-5 py-3 rounded-3 shadow-lg fw-bold">
                Start Free Trial <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</div>

<!-- ==========================================
     SECTION 3: FAQ ACCORDION
=========================================== -->
<div class="faq-wrapper py-5 px-3">
    <div class="container py-5" style="max-width: 1000px;">
        
        <!-- Title -->
        <div class="text-center mb-5" data-aos="fade-down">
            <h1 class="display-5 fw-bold text-navy-react mb-3">Frequently Asked Questions</h1>
            <div class="mx-auto bg-primary rounded" style="width: 60px; height: 4px;"></div>
        </div>

        <!-- FAQ Items -->
        <div class="mt-5">
            <?php if(!empty($faqs)): foreach($faqs as $idx => $faq): 
                $points = json_decode($faq['points_json'], true) ?: [];
            ?>
                <details class="faq-item" data-aos="fade-up" data-aos-delay="<?= $idx * 100 ?>">
                    <summary>
                        <?= htmlspecialchars($faq['title']) ?>
                        <span class="arrow-icon">▼</span>
                    </summary>

                    <div class="faq-content">
                        <!-- Description (Quill HTML) -->
                        <div class="mb-3">
                            <?= $faq['description'] ?> 
                        </div>

                        <!-- Points List -->
                        <?php if(!empty($points)): ?>
                            <ul class="list-disc ms-4 space-y-2">
                                <?php foreach($points as $p): ?>
                                    <li><?= htmlspecialchars($p) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </details>
            <?php endforeach; else: ?>
                <p class="text-center text-muted py-5 fs-5">No FAQs found.</p>
            <?php endif; ?>
        </div>

        <!-- More Queries Section -->
        <div class="text-center mt-5 pt-4" data-aos="zoom-in">
            <p class="fs-5 text-secondary">
                For more queries 
                <a href="contact.php" class="text-primary fw-bold text-decoration-underline">click here</a>.
            </p>
        </div>

    </div>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ duration: 800, once: true });
</script>

<?php include 'includes/footer.php'; ?>