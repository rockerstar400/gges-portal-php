<?php 
$gTitle = $geometryData['geometry_title'] ?? '';
$gDesc = $geometryData['geometry_desc'] ?? '';
$gChapters = $geometryData['geometry_chapters'] ?? [];
$gSubDesc = $geometryData['geometry_subject_desc'] ?? '';
?>
<div class="py-5" style="background-image: url('assets/images/math-bg.png'); background-size: contain; background-position: center; background-repeat: no-repeat;">
    <div class="container py-5 text-center">
        <div data-aos="fade-up">
            <h2 class="display-4 fw-bold text-dark mb-4"><?= $gTitle ?></h2>
            <p class="fs-5 text-secondary mx-auto mb-5" style="max-width: 900px;"><?= $gDesc ?></p>
            <a href="contact.php" class="btn btn-react-blue px-5">Get Started</a>
        </div>

        <!-- Chapters Grid (React Slider Replica) -->
        <div class="bg-white p-4 p-md-5 rounded-4 shadow-lg text-start mt-5" data-aos="fade-up">
            <h4 class="fw-bold mb-5 border-bottom pb-3">Geometry Chapters Included:</h4>
            <div class="row g-4">
                <?php foreach($gChapters as $idx => $chapter): ?>
                <div class="col-lg-4 col-md-6" data-aos="fade-left" data-aos-delay="<?= $idx * 50 ?>">
                    <div class="d-flex align-items-center gap-3 p-3 border rounded-3 bg-light hover-shadow transition">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="min-width: 40px; height: 40px;">
                            <?= $idx + 1 ?>
                        </div>
                        <div class="small fw-bold text-dark"><?= $chapter ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="mt-5 text-center">
                <p class="fs-5 text-secondary fst-italic"><?= $gSubDesc ?></p>
                <a href="contact.php" class="btn btn-react-blue mt-3">Start Free Trial</a>
            </div>
        </div>
    </div>
</div>
<style>.hover-shadow:hover { background: #fff !important; transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }</style>