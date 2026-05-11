<?php 
$hero = $mathHome['hero'] ?? [];
$descs = $mathHome['about'] ?? []; // Array of descriptions
?>
<div class="py-5" style="background-image: url('assets/images/math-bg.png'); background-size: contain; background-position: center; background-repeat: no-repeat;">
    <div class="container py-5">
        <div data-aos="fade-right">
            <h1 class="display-3 fw-bold text-dark mb-4"><?= $hero['title'] ?? 'Math Course' ?></h1>
            <div class="space-y-4 text-secondary fs-5 lh-lg">
                <?php foreach($descs as $p): ?>
                    <p class="mb-4"><?= $p ?></p>
                <?php endforeach; ?>
            </div>
            <div class="mt-5 text-center">
                <p class="h5 fw-bold mb-4">Click here to schedule a Free Trial Class for any subject</p>
                <a href="contact.php" class="btn-react-blue shadow-lg">Start Free Trial <i class="fas fa-arrow-right ms-2"></i></a>
            </div>
        </div>
    </div>
</div>