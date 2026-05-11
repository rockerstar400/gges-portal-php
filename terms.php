<?php 
require_once 'functions.php';

// 1. Database se data fetch karna
$termsList = $conn->query("SELECT * FROM terms_services ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);

// 2. Email Linking Logic (React code ka logic PHP mein)
function renderTextWithLinks($text) {
    if (!$text) return "";
    $pattern = '/([a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z0-9._-]+)/i';
    $replacement = '<a href="mailto:$1" class="text-blue-600 text-decoration-underline" style="color: #2563eb;">$1</a>';
    return preg_replace($pattern, $replacement, $text);
}

include 'includes/header.php'; 
include 'includes/navbar.php';
?>

<style>
    /* --- React CSS Replicas --- */
    .page-bg {
        background-color: #f9fafb; /* bg-gray-50 */
        min-height: 100vh;
        padding-top: 3rem; /* py-12 */
        padding-bottom: 3rem;
        font-family: 'Inter', sans-serif;
    }

    /* main card: max-w-5xl mx-auto bg-white p-10 rounded-3xl shadow-xl */
    .terms-main-card {
        max-width: 1024px; /* max-w-5xl */
        margin-left: auto;
        margin-right: auto;
        background-color: #ffffff;
        padding: 2.5rem; /* p-10 */
        border-radius: 1.5rem; /* rounded-3xl */
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); /* shadow-xl */
    }

    .terms-heading {
        color: #2563eb; /* text-blue-600 */
        font-weight: 700;
        font-size: 2.25rem; /* text-3xl to 4xl */
        margin-bottom: 1.5rem;
    }

    .section-block {
        border-bottom: 1px solid #f3f4f6; /* border-gray-100 */
        padding-bottom: 1.5rem;
        margin-bottom: 2rem;
    }
    .section-block:last-child { border-bottom: none; }

    .main-description {
        color: #4b5563; /* text-gray-600 */
        line-height: 1.625;
        white-space: pre-line;
        font-size: 1.125rem;
    }

    .point-subtitle {
        font-size: 1.125rem; /* text-lg */
        font-weight: 600;
        color: #1f2937; /* text-gray-800 */
        margin-bottom: 0.5rem;
        display: block;
    }

    .point-desc {
        color: #374151; /* text-gray-700 */
        line-height: 1.625;
        white-space: pre-line;
        font-size: 1.05rem;
        margin-bottom: 1.25rem;
    }

    /* Standard HTML logic for lists if Admin uses them */
    .point-desc ul { list-style-type: disc; padding-left: 1.5rem; margin-top: 0.5rem; }
    
    @media (max-width: 768px) {
        .terms-main-card { padding: 1.5rem; border-radius: 1rem; margin: 10px; }
        .terms-heading { font-size: 1.8rem; }
    }
</style>

<div class="page-bg px-3">
    <div class="terms-main-card">
        
        <!-- HEADER -->
        <header class="text-center mb-5">
            <h1 class="terms-heading">Terms & Conditions</h1>
        </header>

        <!-- CONTENT -->
        <section class="space-y-8">
            <?php if(empty($termsList)): ?>
                <p class="text-center text-muted">No terms available.</p>
            <?php endif; ?>

            <?php foreach($termsList as $term): 
                $points = json_decode($term['points_json'], true) ?: [];
            ?>
            <div class="section-block">
                
                <!-- MAIN SECTION TITLE -->
                <?php if(!empty($term['title'])): ?>
                    <h3 class="text-uppercase mb-3" style="font-size: 1.25rem; font-weight: 600; color: #111827;">
                        <?= htmlspecialchars($term['title']) ?>
                    </h3>
                <?php endif; ?>

                <!-- MAIN SECTION DESCRIPTION -->
                <?php if(!empty($term['description'])): ?>
                    <div class="main-description mb-4">
                        <?= renderTextWithLinks(htmlspecialchars($term['description'])) ?>
                    </div>
                <?php endif; ?>

                <!-- POINTS LOOP -->
                <?php if(!empty($points)): ?>
                    <div class="mt-4">
                        <?php foreach($points as $p): ?>
                            <div class="mb-4">
                                <!-- Subtitle -->
                                <?php if(!empty($p['subtitle'])): ?>
                                    <span class="point-subtitle"><?= htmlspecialchars($p['subtitle']) ?></span>
                                <?php endif; ?>

                                <!-- Description (HTML Render for Quill Support) -->
                                <div class="point-desc">
                                    <?= renderTextWithLinks($p['desc']) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            </div>
            <?php endforeach; ?>
        </section>

    </div>
</div>

<script>
    // Smooth scroll to top on load (React equivalent)
    window.scrollTo({ top: 0, behavior: 'smooth' });
</script>

<?php include 'includes/footer.php'; ?>