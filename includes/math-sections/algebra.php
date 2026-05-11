<?php 
$heading = $algebraData['tutoring_heading'] ?? '';
$hDesc = $algebraData['tutoring_description'] ?? '';
$chapters = $algebraData['tutoring_chapters'] ?? [];
?>
<div class="py-5 container">
    <div class="text-center mb-5" data-aos="fade-up">
        <h2 class="display-4 fw-bold text-dark"><?= $heading ?></h2>
        <p class="fs-5 text-secondary mx-auto mt-3" style="max-width: 800px;"><?= $hDesc ?></p>
        <a href="contact.php" class="btn btn-react-blue mt-4">Get Started</a>
    </div>

    <?php foreach($chapters as $idx => $ch): 
        $bgColor = ($idx % 2 == 0) ? '#AEA4DE' : '#F0B6C2';
    ?>
    <div class="card border-0 mb-5 shadow-xl p-4 p-md-5 text-white" 
         style="background-color: <?= $bgColor ?>; border-radius: 25px;" data-aos="zoom-in">
        <h3 class="display-5 fw-bold mb-4"><?= $ch['title'] ?></h3>
        <p class="fs-5 fw-semibold mb-4 opacity-90"><?= $ch['description'] ?></p>
        
        <ul class="row list-unstyled gy-3">
            <?php foreach($ch['names'] as $nIdx => $name): ?>
            <li class="col-md-6 fs-5 fw-bold"><i class="fas fa-check-circle me-3"></i> Chapterssss <?= $nIdx+1 ?>: <?= $name ?></li>
            <?php endforeach; ?>
        </ul>

        <div class="mt-5 pt-4 border-top border-white border-opacity-25">
            <p class="fw-bold fs-5 mb-4">GGES hopes that you will enjoy studying Algebra 1 online with us.</p>
            <a href="contact.php" class="btn btn-light text-primary btn-lg px-5 shadow fw-bold rounded-3">Start Free Trial</a>
        </div>
    </div>
    <?php endforeach; ?>
</div>