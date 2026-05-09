<?php 
require_once 'functions.php'; 

$mathAbout = getCourseData('math-common-core');
$algebra   = getCourseData('math-algebra');
$geometry  = getCourseData('math-geometry');
$amc       = getCourseData('math-amc');
$kangaroo  = getCourseData('math-kangaroo');
$science   = getCourseData('math-science'); // 👈 PRE-CALCULUS DATA

$kangarooCards = getKangarooDetails();
$scienceCards  = getScienceDetails();

$mathDesc    = json_decode($mathAbout['content_json'] ?? '{"descriptions":[]}', true);
$algContent  = json_decode($algebra['content_json'] ?? '{"chapters":[]}', true);
$geoContent  = json_decode($geometry['content_json'] ?? '{"chapter_names":[]}', true);
$amcContent  = json_decode($amc['content_json'] ?? '{"competitions":[]}', true);
$kanContent  = json_decode($kangaroo['content_json'] ?? '{"structures":[]}', true);
$sciContent  = json_decode($science['content_json'] ?? '{}', true);

include('includes/header.php'); 
include('includes/navbar.php'); 
?>

<div class="math-master-wrapper" style="background-color: #F0F8FF;">

<!-- 1. MATH -->
<section id="math" class="py-5 px-4">
    <div class="container py-5">
        <h1><?php echo $mathAbout['title'] ?? 'Math Common Core'; ?></h1>

        <?php foreach(($mathDesc['descriptions'] ?? []) as $p): ?>
            <p><?php echo $p ?? ''; ?></p>
        <?php endforeach; ?>
    </div>
</section>

<!-- 2. ALGEBRA -->

<section id="algebra" class="py-5 bg-white-50">
    <div class="container">
        <!-- 1. Main Title -->
        <h2 class="mb-4"><?php echo $algebra['title'] ?? ''; ?></h2>

        <?php 
        $algContent = json_decode($algebra['content_json'] ?? '{}', true);
        
        if (!empty($algContent['main_desc'])): 
            // Hum saare new lines (\r\n) ko space se replace kar denge 
            // taaki text break na ho aur poora container width le
            $cleanDesc = str_replace(["\r", "\n"], ' ', trim($algContent['main_desc']));
        ?>
            <div class="main-description mb-5">
                <!-- Bina nl2br ke print karenge taaki line khud adjust ho -->
                <p style="text-align: justify; width: 100%; line-height: 1.6;">
                    <?php echo $cleanDesc; ?>
                </p>
            </div>
        <?php endif; ?>

        <!-- Chapters Section -->
        <?php 
        $counter = 0;
        $chapters = $algContent['chapters'] ?? [];

        foreach($chapters as $c): 
            $name = trim($c['name'] ?? '');
            $desc = trim($c['desc'] ?? '');

            if (!empty($name) || !empty($desc)): 
                $bg = ($counter++ % 2 == 0) ? '#AEA4DE' : '#F0B6C2';
        ?>
            <div style="background:<?php echo $bg; ?>; padding:20px; margin-bottom:15px; border-radius: 8px;">
                <?php if(!empty($name)): ?>
                    <h4 style="font-weight: bold;"><?php echo $name; ?></h4>
                <?php endif; ?>

                <?php if(!empty($desc)): ?>
                    <p style="margin-bottom: 0;"><?php echo nl2br($desc); ?></p>
                <?php endif; ?>
            </div>
        <?php 
            endif; 
        endforeach; 
        ?>
    </div>
</section>

<!-- 3. GEOMETRY -->
 <!-- <?php 
 
 echo print_r($geometry);
 ?> -->
<section id="geometry" class="py-5">
    <div class="container">
        <!-- 1. Title -->
        <h2><?php echo $geometry['title'] ?? ''; ?></h2>

        <?php 
        // 2. JSON decode karna zaroori hai
        $geoData = json_decode($geometry['content_json'] ?? '{}', true);
        
        // 3. Main Description (Poore container ki width lega)
        if (!empty($geoData['main_description'])): 
            // New lines hata rahe hain taaki width poori le aur beech mein break na ho
            $cleanMainDesc = str_replace(["\r", "\n"], ' ', trim($geoData['main_description']));
        ?>
            <div class="description-section mb-4">
                <p style="text-align: justify; line-height: 1.6;">
                    <?php echo $cleanMainDesc; ?>
                </p>
                
                <?php 
                // Agar subject_description bhi dikhani hai toh:
                if (!empty($geoData['subject_description'])): 
                    $cleanSubDesc = str_replace(["\r", "\n"], ' ', trim($geoData['subject_description']));
                ?>
                    <p style="text-align: justify; line-height: 1.6;">
                        <?php echo $cleanSubDesc; ?>
                    </p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- 4. Chapters List -->
        <div class="chapters-list mt-4">
            <?php 
            $chapters = $geoData['chapter_names'] ?? [];
            foreach($chapters as $i => $name): 
                if(!empty(trim($name))): // Khali chapter name skip karne ke liye
            ?>
                <p><strong>Chapter <?php echo $i+1; ?></strong> - <?php echo $name; ?></p>
            <?php 
                endif;
            endforeach; 
            ?>
        </div>
    </div>
</section>

<!-- 4. AMC (ERROR FIXED) -->

<section id="amc" class="py-5 bg-white">
    <div class="container">
        <h2>AMC Test Prep</h2>

        <div class="row">
            <?php foreach(($amcContent['competitions'] ?? []) as $card): ?>
            <div class="col-md-4 mb-4">
                <div class="p-4 shadow">

                    <h4><?php echo $card['name'] ?? 'No Title'; ?></h4>

                    <p><?php echo $card['desc_rich'] ?? 'No Description'; ?></p>

                    <p>
                        <b>For:</b> <?php echo $card['for'] ?? '-'; ?><br>
                        <b>When:</b> <?php echo $card['when'] ?? '-'; ?>
                    </p>

                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- 5. KANGAROO -->
 <?php 
 $kanData = json_decode($kangaroo['content_json'] ?? '{}', true);

 ?>
<section id="kangaroo" class="py-5">
    <div class="container">
        <!-- 1. Title (Database se jo 'title' key hai) -->
        <h2 class="mb-4"><?php echo $kangaroo['title'] ?? 'Math Kangaroo'; ?></h2>

        <?php 
        // 2. JSON data ko decode kiya
        
        
        // 3. Test Prep Description (Full width aur clean text)
        if (!empty($kanData['test_prep_desc'])): 
            $cleanTestDesc = str_replace(["\r", "\n"], ' ', trim($kanData['test_prep_desc']));
        ?>
            <div class="test-prep-section mb-5">
                <p style="text-align: justify; line-height: 1.6;">
                    <?php echo $cleanTestDesc; ?>
                </p>
            </div>
        <?php endif; ?>

        <!-- 4. Structures ya Cards wala data -->
        <div class="kangaroo-details">
                    <h2 class="mb-4">TEST STRUCTURE</h2>

            <?php 
            $structures = $kanData['structures'] ?? [];
            if(is_array($structures)):
                foreach($structures as $s): 
                    if(!empty(trim($s))):
            ?>
                <div class="p-3 mb-3">
                    <p style="margin-bottom: 0;"> <?php echo trim($s); ?></p>
                </div>
            <?php 
                    endif;
                endforeach; 
            endif;
            ?>
        </div>
    </div>
</section>
<section id="kangaroo-features" class="py-5 bg-light">
    <div class="container">
        <?php foreach ($kangarooCards as $index => $kc): 
            // Description ko decode kar rahe hain
            $points = json_decode($kc['description'] ?? '[]', true);
            
            // Har second item par image ki position badalne ke liye logic
            // Agar index even (0, 2, 4) hai toh text left, image right
            // Agar index odd (1, 3, 5) hai toh image left, text right
            $isEven = ($index % 2 == 0);
        ?>
            <div class="row align-items-center mb-5 <?php echo !$isEven ? 'flex-row-reverse' : ''; ?>">
                
                <!-- Text Column -->
                <div class="col-md-7">
                    <div class="pe-md-4">
                        <h2 class="fw-bold mb-4" style="color: #1a237e;">
                            <?php echo $kc['title'] ?? ''; ?>
                        </h2>
                        
                        <?php if(is_array($points)): ?>
                            <ul class="list-unstyled">
                                <?php foreach($points as $i => $pt): ?>
                                    <li class="mb-3 d-flex align-items-start">
                                        <span class="me-2 fw-bold"><?php echo $i + 1; ?>.</span>
                                        <span style="line-height: 1.6; color: #555;">
                                            <?php echo nl2br(trim($pt)); ?>
                                        </span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Image Column -->
                <div class="col-md-5">
                    <div class="image-wrapper p-2 shadow-sm bg-white" style="border-radius: 15px;">
                        <img src="<?php echo $kc['image'] ?? 'image_874dd2.jpg'; ?>" 
                             class="img-fluid w-100" 
                             alt="<?php echo $kc['title'] ?? 'Feature'; ?>" 
                             style="border-radius: 10px; min-height: 300px; object-fit: cover;">
                    </div>
                </div>

            </div>
            
            <!-- Agar last item nahi hai toh separator dikhayein -->
            <?php if($index < count($kangarooCards) - 1): ?>
                <hr class="my-5" style="opacity: 0.1;">
            <?php endif; ?>

        <?php endforeach; ?>
    </div>
</section>

<style>
    /* Chote screens par image hamesha upar rahegi */
    @media (max-width: 767px) {
        .flex-row-reverse {
            flex-direction: column-reverse !important;
        }
        .main-description {
            text-align: left !important;
        }
    }
</style>
<!-- 🔥 6. PRE-CALCULUS (SCIENCE) -->
<section id="science" class="py-5 bg-light">
    <div class="container text-center">

        <h2 class="fw-bold">
            <?php echo $science['title'] ?? 'Math Pre-Calculus'; ?>
        </h2>

        <p class="mt-3">
            <?php echo $sciContent['science_desc'] ?? 'Content coming soon...'; ?>
        </p>

        <!-- Optional cards -->
        <div class="row mt-4">
            <?php foreach($scienceCards as $card): ?>
            <div class="col-md-4 mb-3">
                <div class="p-3 shadow rounded">
                    <h5><?php echo $card['title'] ?? ''; ?></h5>
                    <p><?php echo $card['description'] ?? ''; ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>

</div>

<!-- ✅ SCROLL FIX -->
<style>
html {
    scroll-behavior: smooth;
}

/* Sticky navbar fix */
section {
    scroll-margin-top: 100px;
}
</style>

<?php include('includes/footer.php'); ?>