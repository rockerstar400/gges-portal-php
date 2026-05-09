<style>
    .ela-card { transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275); border-radius: 20px; border: 1px solid #eee; }
    .ela-card:hover { transform: translateY(-10px) scale(1.05); box-shadow: 0 15px 30px rgba(85, 79, 232, 0.2) !important; }
    .icon-circle { width: 70px; height: 70px; background: #554FE8; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 15px; }
</style>

<div class="bg-white py-5">
    <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-6 fw-bold mb-4">ABOUT COMMON CORE – ELA</h2>
            <?php 
            $elaParas = json_decode($coreData['ela_core_desc_json'] ?? '[]', true);
            foreach($elaParas as $p): ?>
                <p class="fs-5 text-secondary text-justify mb-3 lh-base"><?= $p ?></p>
            <?php endforeach; ?>
        </div>

        <div class="row mt-5">
            <div class="col-lg-4 mb-4" data-aos="fade-right">
                <h3 class="fw-bold display-6 mb-3">WHAT WE COVER?</h3>
                <p class="fs-5 text-muted"><?= $coreData['ela_cover_desc'] ?? '' ?></p>
            </div>

            <!-- Grid Items -->
            <div class="col-lg-8">
                <div class="row row-cols-2 row-cols-md-3 g-4">
                    <?php foreach($coreDetails as $item): ?>
                    <div class="col" data-aos="zoom-in">
                        <div class="ela-card bg-white p-4 h-100 text-center shadow-sm">
                            <div class="icon-circle mx-auto">
                                <img src="<?= $item['image'] ?>" class="w-50" alt="icon">
                            </div>
                            <h6 class="fw-bold mb-0"><?= $item['title'] ?></h6>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- CTA -->
        <div class="text-center mt-5 pt-4">
            <p class="fw-bold fs-5 mb-4">So why wait? To avail a Free Trial Class for Science Online Tutoring</p>
            <a href="contact.php" class="btn btn-primary btn-lg px-5 rounded-pill shadow-lg">Start Free Trial</a>
        </div>
    </div>
</div>