<style>
    .hero-bg { background-color: #F0F8FF; background-image: url('assets/images/work-bg.png'); background-size: contain; background-position: center; }
    .floating-img { animation: float 4s ease-in-out infinite; }
    @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-15px); } }
    .prop-card { background: #e0f2fe; padding: 20px; border-radius: 15px; font-weight: 500; transition: 0.3s; }
    .prop-card:hover { box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
</style>

<div class="hero-bg py-5">
    <div class="container py-5">
        <div class="row align-items-center g-5">
            <!-- Left Content -->
            <div class="col-lg-7" data-aos="fade-right">
                <h2 class="display-5 fw-bold text-dark mb-4"><?= $langData['eng_lang_heading'] ?? '' ?></h2>
                <p class="fs-5 text-secondary mb-4 lh-lg"><?= $langData['eng_lang_desc'] ?? '' ?></p>
                <p class="fw-bold h5 mb-5">So why wait? To avail a Free Trial Class for English Online Tutoring</p>
                <a href="contact.php" class="btn btn-primary btn-lg px-5 py-3 rounded-3 shadow">Start Free Trial</a>
            </div>
            
            <!-- Right Floating Grid -->
            <div class="col-lg-5">
                <div class="row g-3">
                    <div class="col-6 d-flex flex-column gap-3">
                        <div class="prop-card" data-aos="fade-up"><?= $langData['eng_lang_prop1'] ?? '' ?></div>
                        <div class="bg-white p-2 rounded-4 shadow-sm floating-img">
                            <img src="<?= $langData['eng_lang_image'] ?>" class="img-fluid rounded-4" alt="student">
                        </div>
                        <div class="prop-card" style="background:#cffafe;" data-aos="fade-up"><?= $langData['eng_lang_prop2'] ?? '' ?></div>
                    </div>
                    <div class="col-6 d-flex flex-column gap-3 mt-4">
                        <div class="prop-card" style="background:#f3e8ff;" data-aos="fade-up"><?= $langData['eng_lang_prop3'] ?? '' ?></div>
                        <div class="prop-card" style="background:#fce7f3;" data-aos="fade-up"><?= $langData['eng_lang_prop4'] ?? '' ?></div>
                        <div class="prop-card" style="background:#dcfce7;" data-aos="fade-up"><?= $langData['eng_lang_prop5'] ?? '' ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>