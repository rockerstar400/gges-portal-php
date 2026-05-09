<?php 
/**
 * SECTION: K-12 SERVICE & METHODOLOGY (EXACT REACT REPLICA)
 * Variables $serviceData and $methodologyData are coming from courses-k12.php
 */
?>

<!-- AOS for entry animations -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<style>
    /* --- React Gradient Hero --- */
    .k12-hero-section {
        background: linear-gradient(to right, #1e3a8a, #1d4ed8);
        color: white;
        padding: 100px 0;
        position: relative;
    }

    .text-yellow-react { color: #facc15; }
    .bg-yellow-react { background-color: #facc15; color: #1e3a8a !important; font-weight: 800; border-radius: 50px; padding: 12px 35px; transition: 0.3s; border: none; }
    .bg-yellow-react:hover { background-color: #fde047; transform: scale(1.05); box-shadow: 0px 0px 20px rgba(250, 204, 21, 0.5); }

    /* Hero Floating Image */
    .hero-img-wrap { position: relative; }
    .hero-glow-blob {
        position: absolute; width: 300px; height: 300px; background: #3b82f6;
        filter: blur(80px); opacity: 0.3; border-radius: 50%; z-index: 1; top: 50%; left: 50%; transform: translate(-50%, -50%);
    }
    .floating-animation {
        animation: floatImg 6s ease-in-out infinite;
        z-index: 2;
        position: relative;
        border-radius: 20px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }
    @keyframes floatImg {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }

    /* Methodology Section */
    .math-bg-overlay {
        background-color: #ffffff;
        background-image: url('assets/images/math-bg.png');
        background-size: contain;
        background-position: center;
        background-repeat: no-repeat;
    }

    /* 3D Method Cards */
    .method-card-3d {
        background: #f0f7ff;
        border: 1px solid #dbeafe;
        border-radius: 20px;
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        cursor: pointer;
        padding: 30px 20px;
    }
    .method-card-3d:hover {
        transform: translateY(-12px) scale(1.05);
        box-shadow: 0px 15px 30px rgba(59, 130, 246, 0.2);
        background: #ffffff;
    }

    /* Expertise Cards */
    .expertise-card {
        border-radius: 24px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.06);
        transition: 0.4s ease;
        overflow: hidden;
        height: 100%;
        background: #fff;
    }
    .expertise-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 25px 50px rgba(0,0,0,0.12);
    }
    .exp-icon-box {
        width: 55px; height: 55px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        color: white; font-size: 22px;
    }

    /* CTA Section */
    .bg-navy-cta { background-color: #1e3a8a; color: white; border-radius: 0; }
    .btn-white-cta { background: #fff; color: #1e3a8a !important; border-radius: 50px; padding: 12px 40px; font-weight: 700; transition: 0.3s; }
    .btn-white-cta:hover { background: #f3f4f6; transform: scale(1.05); }
</style>

<div class="k12-wrapper">

    <!-- ================= 1. HERO SECTION ================= -->
    <section class="k12-hero-section px-4">
        <div class="container max-w-7xl mx-auto">
            <div class="row align-items-center g-5">
                <div class="col-lg-7" data-aos="fade-right">
                    <h1 class="display-4 fw-bold mb-4">Our <span class="text-yellow-react">K-12 Services</span></h1>
                    <p class="fs-5 opacity-90 mb-5 lh-lg">
                        <?= $serviceData['description'] ?? 'GGES offers specialized tutoring for all grades K through 12. We understand the unique needs of every student.' ?>
                    </p>
                    <a href="contact.php" class="btn bg-yellow-react shadow-lg d-inline-flex align-items-center gap-2">
                        Book a Session <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="col-lg-5 text-center mt-5 mt-lg-0">
                    <div class="hero-img-wrap">
                        <div class="hero-glow-blob"></div>
                        <?php if(!empty($serviceData['image'])): ?>
                            <img src="<?= $serviceData['image'] ?>" class="img-fluid floating-animation shadow-2xl" alt="K12 Tutoring">
                        <?php else: ?>
                            <img src="https://via.placeholder.com/500x400?text=K-12+Services" class="img-fluid floating-animation shadow-2xl">
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= 2. METHODOLOGY SECTION ================= -->
    <section id="methodology" class="math-bg-overlay py-5">
        <div class="container py-5">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="display-5 fw-bold text-dark">Our Methodology</h2>
                <p class="fs-5 text-secondary">At GGES we work with the following approach:</p>
                <div class="mx-auto bg-primary rounded" style="width: 80px; height: 5px; margin-top: 15px;"></div>
            </div>

            <div class="row g-4 justify-content-center mt-4">
                <?php foreach($methodologyData as $idx => $meth): ?>
                <div class="col-lg-2 col-md-4 col-sm-6" data-aos="fade-up" data-aos-delay="<?= $idx * 100 ?>">
                    <div class="method-card-3d text-center h-100 shadow-sm">
                        <div class="bg-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 60px; height: 60px;">
                            <img src="<?= $meth['image'] ?>" class="w-50" alt="icon" onerror="this.src='https://via.placeholder.com/40'">
                        </div>
                        <h6 class="fw-bold mb-2 text-dark"><?= $meth['title'] ?></h6>
                        <p class="small text-muted mb-0" style="font-size: 13px;"><?= $meth['description'] ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ================= 3. SUBJECT EXPERTISE SECTION ================= -->
    <section id="expertise" class="py-5" style="background-color: #F0F8FF;">
        <div class="container py-5">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="display-5 fw-bold text-dark">Subject Expertise</h2>
                <p class="fs-5 text-secondary">We are the best when it comes to:</p>
            </div>

            <div class="row g-4">
                <!-- MATH Column -->
                <div class="col-lg-4" data-aos="fade-up">
                    <div class="expertise-card border-top border-5 border-primary">
                        <div class="p-4 bg-light d-flex align-items-center gap-3" style="background-color: #f0f7ff !important;">
                            <div class="exp-icon-box bg-primary shadow-lg"><i class="fas fa-calculator"></i></div>
                            <h3 class="h4 fw-bold mb-0"><?= $serviceData['title1'] ?? 'Mathematics' ?></h3>
                        </div>
                        <div class="p-4 p-md-5">
                            <ul class="list-unstyled space-y-3">
                                <?php 
                                $mathPoints = json_decode($serviceData['description1'] ?? '[]', true) ?: [];
                                foreach($mathPoints as $point): ?>
                                    <li class="fs-6 d-flex align-items-start text-secondary">
                                        <i class="fas fa-check-circle text-primary mt-1 me-3"></i>
                                        <span class="fw-medium"><?= $point ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- SCIENCE Column -->
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="expertise-card border-top border-5 border-success">
                        <div class="p-4 bg-light d-flex align-items-center gap-3" style="background-color: #f0fdf4 !important;">
                            <div class="exp-icon-box bg-success shadow-lg"><i class="fas fa-microscope"></i></div>
                            <h3 class="h4 fw-bold mb-0"><?= $serviceData['title2'] ?? 'Science' ?></h3>
                        </div>
                        <div class="p-4 p-md-5">
                            <ul class="list-unstyled space-y-3">
                                <?php 
                                $sciPoints = json_decode($serviceData['description2'] ?? '[]', true) ?: [];
                                foreach($sciPoints as $point): ?>
                                    <li class="fs-6 d-flex align-items-start text-secondary">
                                        <i class="fas fa-check-circle text-success mt-1 me-3"></i>
                                        <span class="fw-medium"><?= $point ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- ENGLISH Column -->
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="expertise-card border-top border-5 border-info">
                        <div class="p-4 bg-light d-flex align-items-center gap-3" style="background-color: #f0f9ff !important;">
                            <div class="exp-icon-box bg-info shadow-lg"><i class="fas fa-book-open"></i></div>
                            <h3 class="h4 fw-bold mb-0"><?= $serviceData['title3'] ?? 'English' ?></h3>
                        </div>
                        <div class="p-4 p-md-5">
                            <ul class="list-unstyled space-y-3">
                                <?php 
                                $engPoints = json_decode($serviceData['description3'] ?? '[]', true) ?: [];
                                foreach($engPoints as $point): ?>
                                    <li class="fs-6 d-flex align-items-start text-secondary">
                                        <i class="fas fa-check-circle text-info mt-1 me-3"></i>
                                        <span class="fw-medium"><?= $point ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= 4. FINAL CTA SECTION ================= -->
    <section class="py-5 bg-navy-cta text-white text-center">
        <div class="container py-5" data-aos="zoom-in">
            <h2 class="display-5 fw-bold mb-4">Start Your Learning Journey with GGES</h2>
            <p class="fs-5 opacity-75 mb-5 mx-auto" style="max-width: 700px;">Contact us today to discuss how we can help achieve your academic goals.</p>
            <a href="contact.php" class="btn btn-white-cta shadow-xl">Contact Us Now</a>
        </div>
    </section>

</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init({ duration: 1000, once: true });</script>