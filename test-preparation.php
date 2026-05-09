<?php 
require_once 'functions.php';
include 'includes/header.php'; 
include('includes/navbar.php'); 

// Saare slugs ka array taaki loop chal sake
$allSlugs = ['sat', 'ssat', 'psat', 'shsat', 'isee', 'ela', 'scat', 'amc', 'kangaroo', 'act', 'cogat', 'sbac', 'accuplacer', 'stb'];
?>

<!-- AOS for premium animations -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
    .master-wrapper { background-color: #F0F8FF; overflow-x: hidden; }
    /* Har section ki min-height 100vh taaki full screen feel aaye */
    section { 
        padding: 100px 0; 
        border-bottom: 1px solid rgba(0,0,0,0.05); 
        min-height: 80vh;
        scroll-margin-top: 70px; /* Sticky header ke liye offset */
    }
    html { scroll-behavior: smooth; }
    
    /* Global Styles for Section Files */
    .btn-react-blue { background-color: #2563eb; color: white; font-weight: 600; padding: 12px 30px; border-radius: 8px; border: none; text-decoration: none; display: inline-block; transition: 0.3s; }
    .btn-react-blue:hover { background-color: #1d4ed8; transform: scale(1.05); color: white; }
    .card-3d-effect { transition: 0.5s; border-radius: 20px; border: 1px solid #e2e8f0; background: #fff; }
    .card-3d-effect:hover { transform: translateY(-10px); box-shadow: 0px 25px 50px rgba(37, 99, 235, 0.2) !important; }
</style>

<div class="master-wrapper">
    <?php 
    foreach($allSlugs as $slug) {
        // Step 1: Database se us specific slug ka data uthana
        // Variable name humne $sectionData rakha hai conflict se bachne ke liye
        $sectionData = getTestPrepData($slug);
        
        if($sectionData) {
            // Step 2: Section ID slug ke naam par (sat, ssat etc)
            echo "<section id='{$slug}'>";
            
            // Step 3: Specific Section File Include karna
            $filePath = "includes/test-prep-sections/{$slug}-section.php";
            if(file_exists($filePath)) {
                // $sectionData is file ke andar automatically available rahega
                include($filePath); 
            } else {
                echo "<div class='container text-center py-5'>
                        <h2 class='text-muted'>Section file for ".strtoupper($slug)." not found.</h2>
                        <p class='small'>Create: $filePath</p>
                      </div>";
            }
            
            echo "</section>";
        }
    }
    ?>
</div>

<!-- Smooth Scroll Logic for URL Hash -->
<script>
window.addEventListener('load', () => {
    if (window.location.hash) {
        const target = document.querySelector(window.location.hash);
        if (target) {
            setTimeout(() => {
                window.scrollTo({
                    top: target.offsetTop - 80, 
                    behavior: 'smooth'
                });
            }, 100);
        }
    }
});
</script>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init({ duration: 1000, once: true });</script>

<?php include 'includes/footer.php'; ?>