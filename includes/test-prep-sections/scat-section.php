<?php 
/**
 * SECTION: SCAT FRONTEND (MATCHING REACT DESIGN)
 * Variables: $sectionData (Coming from Master Fetch in test-preparation.php)
 */

// Mapping Variables based on updated Master Fetch and Admin Logic
$heroTitle       = $sectionData['scat_hero_title'] ?? "SCAT TEST PREP";
$heroDesc        = $sectionData['scat_hero_desc'] ?? "";

$aboutHeading    = $sectionData['scat_about_heading'] ?? "";
$aboutDesc       = $sectionData['scat_about_desc'] ?? "";
$versionsHeading = $sectionData['scat_versions_heading'] ?? "Versions";
$versionsList    = $sectionData['scat_versions'] ?? []; // Array of strings

$formatHeading   = $sectionData['scat_format_heading'] ?? "Format Section";
$formatDesc      = $sectionData['scat_format_desc'] ?? "";
$formatSections  = $sectionData['scat_format_sections'] ?? []; // Array of {title, description}

$scoringHeading  = $sectionData['scat_scoring_heading_html'] ?? "";
$scoringLevels   = $sectionData['scat_scoring_levels'] ?? []; // Array of {title, details}

$tipsHeading     = $sectionData['scat_tips_heading'] ?? "Tips Section";
$tipsList        = $sectionData['scat_tips'] ?? []; // Array of strings

$registerHeading = $sectionData['scat_register_heading'] ?? "Registration";
$registerSub     = $sectionData['scat_register_subheading'] ?? "";
$registerContact = $sectionData['scat_register_contact_html'] ?? "";
$authHeading     = $sectionData['scat_auth_heading'] ?? "Authorization";
$authDesc        = $sectionData['scat_auth_desc_html'] ?? "";
?>

<style>
    .scat-wrapper { background-color: #ffffff; min-height: 100vh; font-family: 'Inter', sans-serif; color: #1f2937; }
    
    /* 3D Hover Card Logic */
    .scat-card-3d {
        background: #fff;
        border-radius: 16px;
        padding: 2rem;
        border: 1px solid #e5e7eb;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        height: 100%;
    }
    .scat-card-3d:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .text-blue-react { color: #2563eb !important; }
    .btn-react-blue { background-color: #2563eb; color: white !important; font-weight: 600; padding: 12px 35px; border-radius: 10px; transition: 0.3s; border: none; text-decoration: none; display: inline-block; }
    .btn-react-blue:hover { background-color: #1d4ed8; transform: scale(1.05); }
    
    /* List styles */
    .scat-list { list-style-type: disc; padding-left: 1.5rem; }
    .scat-list li { margin-bottom: 0.75rem; font-size: 1.125rem; }
</style>

<div class="scat-wrapper py-5 px-3">
    <div class="container max-w-7xl mx-auto py-4">

        <!-- ================= 1. HERO SECTION ================= -->
        <section class="text-center mb-5" data-aos="fade-up">
            <?php if($heroTitle): ?>
                <h1 class="display-4 fw-bold mb-4 text-uppercase"><?= $heroTitle ?></h1>
            <?php endif; ?>

            <?php if($heroDesc): ?>
                <p class="fs-5 text-secondary lh-lg mb-5 mx-auto" style="max-width: 1000px; white-space: pre-line;">
                    <?= $heroDesc ?>
                </p>
            <?php endif; ?>

            <div class="font-semibold fs-5">
                So why wait? To avail a Free Trial Class for SCAT Test Prep Online Tutoring, &nbsp;
                <a href="contact.php" class="text-blue-react text-decoration-underline fw-bold d-inline-block hover-scale">
                    CLICK HERE
                </a>
            </div>
        </section>

        <!-- ================= 2. ABOUT SECTION & VERSIONS ================= -->
        <?php if($aboutHeading || !empty($versionsList)): ?>
        <section class="my-5 py-4" data-aos="fade-up">
            <div class="p-4 p-md-5 rounded-4" style="transition: 0.3s;" onmouseover="this.style.boxShadow='0 10px 30px rgba(0,0,0,0.05)'" onmouseout="this.style.boxShadow='none'">
                <?php if($aboutHeading): ?>
                    <h2 class="display-6 fw-bold mb-4"><?= $aboutHeading ?></h2>
                <?php endif; ?>
                <?php if($aboutDesc): ?>
                    <p class="fs-5 text-secondary mb-5" style="white-space: pre-line;"><?= $aboutDesc ?></p>
                <?php endif; ?>

                <?php if($versionsHeading): ?>
                    <h3 class="h2 fw-bold mb-4"><?= $versionsHeading ?></h3>
                <?php endif; ?>
                <?php if(!empty($versionsList)): ?>
                    <ul class="scat-list text-secondary">
                        <?php foreach($versionsList as $v): if(!$v) continue; ?>
                            <li data-aos="fade-left"><?= $v ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </section>
        <?php endif; ?>

        <!-- ================= 3. FORMAT SECTION (Grid) ================= -->
        <?php if($formatHeading || !empty($formatSections)): ?>
        <section class="my-5" data-aos="fade-up">
            <div class="mb-5">
                <h2 class="display-6 fw-bold mb-3"><?= $formatHeading ?></h2>
                <p class="fs-5 text-secondary"><?= $formatDesc ?></p>
            </div>

            <div class="row g-4">
                <?php foreach($formatSections as $idx => $sec): ?>
                    <div class="col-md-6" data-aos="zoom-in" data-aos-delay="<?= $idx * 100 ?>">
                        <div class="scat-card-3d">
                            <h3 class="h4 fw-bold text-dark mb-3"><?= $sec['title'] ?></h3>
                            <p class="fs-5 text-secondary mb-0" style="white-space: pre-line;"><?= $sec['description'] ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>

        <!-- ================= 4. SCORING SECTION ================= -->
        <section class="my-5 pt-5" data-aos="fade-up">
            <h2 class="display-6 fw-bold mb-4">Scoring and Timing</h2>
            <?php if($scoringHeading): ?>
                <div class="fs-5 mb-5 text-secondary"><?= $scoringHeading ?></div>
            <?php endif; ?>

            <div class="row g-4 mb-5">
                <?php foreach($scoringLevels as $idx => $lvl): ?>
                    <div class="col-md-6" data-aos="fade-up" data-aos-delay="<?= $idx * 100 ?>">
                        <div class="scat-card-3d border-start border-primary border-4">
                            <h3 class="h4 fw-bold text-dark mb-3"><?= $lvl['title'] ?></h3>
                            <p class="fs-5 text-secondary mb-0"><?= $lvl['details'] ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <p class="fs-5 text-dark italic">This scaled score is based on the number of questions the student answers correctly out of the 50 scored questions in each section.</p>
        </section>

        <!-- ================= 5. TIPS SECTION ================= -->
        <?php if(!empty($tipsList)): ?>
        <section class="my-5 py-5" data-aos="fade-up">
            <h2 class="display-6 fw-bold mb-4"><?= $tipsHeading ?></h2>
            <p class="fs-5 mb-4 text-dark">However, during our sessions on the SCAT test preparations, we equip our students by giving Tips and Tricks to answer SCAT test questions quickly and accurately. Still here are general tips for taking the SCAT test:</p>
            <ul class="scat-list text-secondary">
                <?php foreach($tipsList as $tip): if(!$tip) continue; ?>
                    <li data-aos="fade-right"><?= $tip ?></li>
                <?php endforeach; ?>
            </ul>
        </section>
        <?php endif; ?>

        <!-- ================= 6. REGISTRATION & AUTH ================= -->
        <section class="my-5 pt-4" data-aos="fade-in">
            <div class="space-y-4">
                <?php if($registerHeading): ?><h2 class="display-6 fw-bold mb-2"><?= $registerHeading ?></h2><?php endif; ?>
                <?php if($registerSub): ?><p class="h3 fw-bold mb-4 text-primary"><?= $registerSub ?></p><?php endif; ?>
                
                <div class="fs-5 text-secondary mb-5">
                    <?= $registerContact ?> <!-- HTML from Admin -->
                </div>

                <?php if($authHeading): ?><h3 class="h2 fw-bold mt-5 mb-3"><?= $authHeading ?></h3><?php endif; ?>
                <div class="fs-5 text-secondary lh-lg">
                    <?= $authDesc ?> <!-- HTML from Admin -->
                </div>
            </div>
        </section>

        <!-- ================= 7. CTA SECTION ================= -->
        <div class="text-center my-5 py-5" data-aos="zoom-in">
            <h3 class="h4 fw-bold mb-4">So why wait? To avail a Free Trial Class for SCAT Test Prep</h3>
            <a href="contact.php" class="btn-react-blue shadow-lg">CLICK HERE</a>
        </div>

    </div>
</div>