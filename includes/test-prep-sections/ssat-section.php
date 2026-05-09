<?php 
/**
 * SECTION: SSAT FRONTEND (MATCHING REACT DESIGN)
 * Variables are coming from the Master Fetch Function.
 */

$hero         = $sectionData['hero'] ?? [];
$about        = $sectionData['about'] ?? [];
$levels       = $sectionData['levels'] ?? [];
$comp         = $sectionData['comparison'] ?? []; 
$scoring      = $sectionData['scoring'] ?? []; 
$facts        = $sectionData['facts'] ?? [];   
$struct       = $sectionData['structure'] ?? []; 
$footer_score = $sectionData['good_score'] ?? []; 
?>

<style>
    .ssat-wrapper { background-color: #F0F8FF; min-height: 100vh; font-family: 'Inter', sans-serif; overflow-x: hidden; }
    
    /* 1. Glassmorphism Hero Box */
    .hero-glass { 
        background: rgba(255, 255, 255, 0.8); 
        backdrop-filter: blur(12px); 
        border-radius: 24px; 
        border-top: 5px solid #3b82f6; 
        box-shadow: 0 20px 40px rgba(0,0,0,0.05);
    }

    /* 2. 3D Hover Card (Exact React Feel) */
    .card-react-3d {
        background: white;
        border-radius: 20px;
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }
    .card-react-3d:hover {
        transform: translateY(-12px) scale(1.01);
        box-shadow: 0px 25px 50px rgba(37, 99, 235, 0.2) !important;
    }

    /* 3. Themed Accents */
    .border-l-blue { border-left: 8px solid #2563eb !important; }
    .border-l-purple { border-left: 8px solid #9333ea !important; }
    .border-t-orange { border-top: 6px solid #fb923c !important; }
    .border-l-teal { border-left: 8px solid #14b8a6 !important; }
    .border-b-red { border-bottom: 8px solid #ef4444 !important; }
    
    .bg-orange-light { background-color: #fff7ed; border-radius: 12px; }
    .btn-react-blue { background-color: #2563eb; color: white; font-weight: 600; padding: 14px 40px; border-radius: 10px; transition: 0.3s; border: none; text-decoration: none; display: inline-block; }
    .btn-react-blue:hover { background-color: #1d4ed8; transform: scale(1.05); color: white; }

    /* Tables */
    .ssat-table thead { background-color: #2563eb; color: white; }
    .ssat-table-upper thead { background-color: #059669; color: white; }
</style>

<div class="ssat-wrapper py-5 px-3" style="background-image: url('assets/images/math-bg.png'); background-size: contain; background-position: center; background-repeat: repeat; background-blend-mode: overlay;">
    <div class="container py-4">

        <!-- ================= 1. HERO SECTION ================= -->
        <div class="text-center mb-5" data-aos="fade-up">
            <h1 class="display-4 fw-bold text-blue-900 mb-5 text-uppercase tracking-wider">
                <?= $hero['title'] ?? 'SSAT TEST PREP' ?>
            </h1>
            
            <?php if(!empty($hero['description'])): ?>
            <div class="hero-glass p-4 p-md-5 mx-auto shadow-lg" style="max-width: 900px;" data-aos="zoom-in">
                <p class="fs-5 text-dark lh-lg mb-0" style="white-space: pre-wrap;"><?= $hero['description'] ?></p>
            </div>
            <?php endif; ?>

            <div class="mt-5 pt-3">
                <a href="contact.php" class="btn-react-blue shadow-lg">Click here for Free Trial Class</a>
            </div>
        </div>

        <!-- ================= 2. ABOUT & LEVELS (3D Grid) ================= -->
        <div class="row g-4 my-5 pt-5">
            <div class="col-md-6" data-aos="fade-right">
                <div class="card-react-3d p-4 p-md-5 border-l-blue h-100">
                    <h2 class="fw-bold mb-4 text-dark text-uppercase"><?= $about['heading'] ?? 'ABOUT SSAT' ?></h2>
                    <div class="text-secondary fs-5 lh-base" style="white-space: pre-wrap;"><?= $about['description'] ?? '' ?></div>
                </div>
            </div>
            <div class="col-md-6" data-aos="fade-left">
                <div class="card-react-3d p-4 p-md-5 border-l-purple h-100">
                    <h2 class="fw-bold mb-4 text-dark text-uppercase">Different Levels</h2>
                    <div class="space-y-4">
                        <?php if(!empty($levels)): foreach($levels as $lv): ?>
                            <div class="mb-4 border-bottom pb-2">
                                <h5 class="text-primary fw-bold mb-1 fs-4"><?= $lv['title'] ?? '' ?></h5>
                                <p class="text-secondary small mb-0"><?= $lv['desc'] ?? '' ?></p>
                            </div>
                        <?php endforeach; else: ?>
                            <p class="text-muted">No level information added.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= 4. COMPARISON SECTION (Orange Design) ================= -->
        <?php if(!empty($comp['heading']) || !empty($comp['title'])): ?>
        <div class="card-react-3d p-4 p-md-5 border-t-orange my-5 shadow-sm" data-aos="fade-up">
            <h2 class="text-center fw-bold text-dark mb-4"><?= $comp['heading'] ?? ($comp['title'] ?? '') ?></h2>
            <div class="text-secondary fs-5 mb-4 text-center" style="white-space: pre-wrap;"><?= $comp['description'] ?? ($comp['intro'] ?? '') ?></div>
            <div class="bg-orange-light p-4 shadow-inner">
                <ul class="list-unstyled mb-0">
                    <?php if(!empty($comp['points'])): foreach($comp['points'] as $pt): ?>
                        <li class="mb-3 fs-5 d-flex align-items-start" data-aos="fade-right">
                            <i class="fas fa-check-circle text-warning mt-1 me-3"></i> <?= $pt ?>
                        </li>
                    <?php endforeach; endif; ?>
                </ul>
            </div>
        </div>
        <?php endif; ?>

        <!-- ================= 6. SCORING SECTION (Staggered Cards) ================= -->
        <div class="bg-white p-4 p-md-5 rounded-4 shadow-lg my-5" data-aos="fade-up">
            <h2 class="text-center fw-bold text-dark mb-5 display-6"><?= $scoring['heading'] ?? 'How is the SSAT scored?' ?></h2>
            <div class="row g-4">
                <?php if(!empty($scoring['cards'])): foreach($scoring['cards'] as $idx => $sc): ?>
                <div class="col-md-4" data-aos="zoom-in" data-aos-delay="<?= $idx * 100 ?>">
                    <div class="p-4 rounded-4 h-100 card-react-3d border border-light bg-light">
                        <h5 class="fw-bold text-primary border-bottom border-primary border-opacity-25 pb-2 mb-3 text-uppercase"><?= $sc['title'] ?? '' ?></h5>
                        <p class="small text-muted mb-0" style="white-space: pre-wrap;"><?= $sc['content'] ?? '' ?></p>
                    </div>
                </div>
                <?php endforeach; endif; ?>
            </div>
            <p class="text-center mt-5 text-muted fst-italic"><?= $scoring['footer'] ?? '' ?></p>
        </div>

        <!-- ================= 5. FACTS SECTION (Teal Border) ================= -->
        <?php if(!empty($facts['heading']) || !empty($facts['title'])): ?>
        <div class="card-react-3d p-4 p-md-5 border-l-teal my-5 shadow-sm" data-aos="fade-left">
            <h2 class="fw-bold mb-4 text-dark display-6"><?= $facts['heading'] ?? ($facts['title'] ?? 'SSAT Quick Facts') ?></h2>
            <div class="fs-5 text-dark lh-lg fw-medium" style="white-space: pre-wrap;"><?= $facts['content'] ?? '' ?></div>
            <p class="mt-4 small text-muted fst-italic border-top pt-2"><?= $facts['disclaimer'] ?? '' ?></p>
        </div>
        <?php endif; ?>

        <!-- ================= 7. TEST STRUCTURE DUAL TABLES ================= -->
        <div class="bg-white p-4 p-md-5 rounded-4 shadow-lg mb-5" data-aos="fade-up">
            <h2 class="text-center fw-bold mb-5 text-uppercase text-dark"><?= $struct['heading'] ?? ($struct['title'] ?? 'SSAT TEST STRUCTURE') ?></h2>
            <div class="row g-5">
                <div class="col-xl-6">
                    <h4 class="fw-bold text-primary mb-3 bg-light p-3 rounded-3 d-inline-block shadow-sm">Middle Level (5th-7th Grade)</h4>
                    <div class="table-responsive border rounded-4 overflow-hidden">
                        <table class="table ssat-table table-hover align-middle mb-0">
                            <thead><tr><th class="p-3">Section</th><th class="p-3 text-center">Time</th><th class="p-3 text-center">Questions</th><th class="p-3 text-center">Download</th></tr></thead>
                            <tbody>
                                <?php if(!empty($struct['middle'])): foreach($struct['middle'] as $m): ?>
                                <tr>
                                    <td class="p-3 fw-bold text-dark"><?= $m['section'] ?? ($m['sec'] ?? '') ?></td>
                                    <td class="p-3 text-center"><?= $m['time'] ?? '' ?></td>
                                    <td class="p-3 text-center"><?= $m['questions'] ?? '' ?></td>
                                    <td class="p-3 text-center">
                                        <?php if(!empty($m['download'] ?? $m['link'])): ?>
                                            <a href="<?= $m['download'] ?? $m['link'] ?>" target="_blank" class="text-primary fw-bold text-decoration-underline">Download</a>
                                        <?php else: ?> - <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-xl-6">
                    <h4 class="fw-bold text-success mb-3 bg-light p-3 rounded-3 d-inline-block shadow-sm">Upper Level (8th-11th Grade)</h4>
                    <div class="table-responsive border rounded-4 overflow-hidden">
                        <table class="table ssat-table-upper table-hover align-middle mb-0">
                            <thead><tr><th class="p-3">Section</th><th class="p-3 text-center">Time</th><th class="p-3 text-center">Questions</th><th class="p-3 text-center">Download</th></tr></thead>
                            <tbody>
                                <?php if(!empty($struct['upper'])): foreach($struct['upper'] as $u): ?>
                                <tr>
                                    <td class="p-3 fw-bold text-dark"><?= $u['section'] ?? ($u['sec'] ?? '') ?></td>
                                    <td class="p-3 text-center"><?= $u['time'] ?? '' ?></td>
                                    <td class="p-3 text-center"><?= $u['questions'] ?? '' ?></td>
                                    <td class="p-3 text-center">
                                        <?php if(!empty($u['download'] ?? $u['link'])): ?>
                                            <a href="<?= $u['download'] ?? $u['link'] ?>" target="_blank" class="text-success fw-bold text-decoration-underline">Download</a>
                                        <?php else: ?> - <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= 8. GOOD SCORE & FOOTER ================= -->
        <div class="card-react-3d p-4 p-md-5 border-b-red text-center my-5 shadow-lg" data-aos="zoom-in">
            <h2 class="fw-bold text-dark mb-3 display-6"><?= $footer_score['heading'] ?? ($footer_score['score_title'] ?? 'Ready to Start?') ?></h2>
            <p class="text-secondary fs-5 mb-5 mx-auto max-width-800"><?= $footer_score['intro'] ?? '' ?></p>
            
            <div class="row g-4 text-start justify-content-center">
                <div class="col-md-5">
                    <div class="p-4 bg-red-light rounded-4 border border-danger border-opacity-20 h-100">
                        <h4 class="fw-bold text-danger mb-2">Scaled Scores</h4>
                        <p class="mb-0 text-dark small lh-base"><?= $footer_score['scaled'] ?? '' ?></p>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="p-4 bg-red-light rounded-4 border border-danger border-opacity-20 h-100">
                        <h4 class="fw-bold text-danger mb-2">Percentile Ranks</h4>
                        <p class="mb-0 text-dark small lh-base"><?= $footer_score['percentile'] ?? '' ?></p>
                    </div>
                </div>
            </div>
            
            <div class="mt-5 pt-4">
                <h3 class="fw-bold mb-4 text-dark h2">Ready to start your SSAT preparation?</h3>
                <a href="contact.php" class="btn-react-blue btn-lg px-5 shadow">Click here for Free Trial Class</a>
            </div>
        </div>

    </div>
</div>