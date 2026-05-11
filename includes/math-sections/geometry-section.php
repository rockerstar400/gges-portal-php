<?php 
$gTitle = $geometryData['geometry_title'] ?? '';
$gDesc = $geometryData['geometry_desc'] ?? '';
$gSubjectDesc = $geometryData['geometry_subject_desc'] ?? '';
$gChapters = $geometryData['geometry_chapters'] ?? [];
?>
<div class="py-5" style="background-image: url('assets/images/math-bg.png'); background-size: contain; background-position: center; background-color: #F0F8FF;">
    <div class="container py-5 text-center">
        <div data-aos="fade-up">
            <h2 class="display-4 fw-bold text-dark mb-4"><?= $gTitle ?></h2>
            <p class="fs-5 text-secondary mx-auto mb-4" style="max-width: 900px;"><?= $gDesc ?></p>
            <p class="h5 fw-bold text-dark mb-5">Why not avail a Free Trial Class for online Geometry tutoring. To schedule a Free Trial Class</p>
            <a href="contact.php" class="btn-react-blue mb-5 px-5 shadow-lg">Get Started</a>
        </div>

        <div class="bg-white p-4 p-md-5 rounded-4 shadow-lg text-start mt-5" data-aos="fade-up">
            <h3 class="fw-bold mb-5 border-bottom pb-3">Geometry Chapters Included:</h3>
            <div class="row g-4">
                <?php foreach($gChapters as $idx => $chapter): ?>
                <div class="col-lg-4 col-md-6" data-aos="fade-right" data-aos-delay="<?= $idx * 50 ?>">
                    <div class="d-flex align-items-center gap-3 p-3 hover-lift border rounded-3 bg-light">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="min-width: 45px; height: 45px;">
                            <?= $idx + 1 ?>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0">Chapter <?= $idx + 1 ?></h6>
                            <p class="small text-muted mb-0"><?= $chapter ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="mt-5 pt-4 text-center">
                <p class="fs-5 text-secondary italic"><?= $gSubjectDesc ?></p>
                <a href="contact.php" class="btn-react-blue mt-4">Start Free Trial</a>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-lift { transition: 0.3s; }
    .hover-lift:hover { transform: translateX(10px); background: #fff !important; border-color: #2563eb !important; }
</style>