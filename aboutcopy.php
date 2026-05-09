<?php include('includes/header.php'); ?>
<?php include('includes/navbar.php'); ?>

<?php
// Mock Data (Baad mein Database se aayega)
$aboutData = [
    "image" => "assets/images/about-hero.png",
    "description" => [
        "Grace Global Education Services (GGES) is dedicated to providing high-quality, personalized online tutoring.",
        "Our mission is to empower students through innovative learning techniques and expert guidance.",
        "With years of experience, we have helped thousands of students achieve their dream grades and build confidence."
    ],
    "whyUs" => "We focus on individual growth, ensuring that every student gets the attention they deserve.",
    "howDifferent" => [
        "1-on-1 focus on every student.",
        "Tutors from top-tier universities.",
        "Customized learning paths.",
        "Interactive digital whiteboards."
    ],
    "safety" => [
        "All our tutors undergo strict background checks.",
        "Sessions are recorded for quality and safety monitoring."
    ],
    "tutorDescription" => "Our tutors are not just teachers; they are mentors who inspire students to think beyond textbooks."
];

$members = [
    [
        "name" => "John Doe",
        "role" => "Founder & CEO",
        "image" => "assets/images/member1.png",
        "description" => "John has over 15 years of experience in the education sector and is passionate about digital learning."
    ],
    [
        "name" => "Jane Smith",
        "role" => "Academic Director",
        "image" => "assets/images/member2.png",
        "description" => "Jane oversees the curriculum development and ensures the highest academic standards."
    ]
];
?>

<!-- --- ABOUT HERO SECTION --- -->
<div class="about-hero py-5 px-4" style="background-image: url('assets/images/price-bg.png'); background-size: cover;">
    <div class="container py-5">
        <h1 class="text-center fw-bold display-4 mb-5 animate-up">About Us</h1>
        
        <div class="row align-items-center g-5">
            <div class="col-lg-6 text-center">
                <img src="<?php echo $aboutData['image']; ?>" class="img-fluid rounded-4 shadow-lg float-anim" alt="About GGES">
            </div>
            <div class="col-lg-6">
                <div class="about-text-content">
                    <?php foreach(array_slice($aboutData['description'], 0, 2) as $para): ?>
                        <p class="fs-5 text-secondary mb-4 animate-up"><?php echo $para; ?></p>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        
        <div class="mt-5 animate-up">
            <?php foreach(array_slice($aboutData['description'], 2) as $para): ?>
                <p class="fs-5 text-secondary mb-3"><?php echo $para; ?></p>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- --- LEADERSHIP SECTION --- -->
<section class="management-section py-5 bg-light border-top">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h6 class="text-primary fw-bold text-uppercase tracking-wider">Our Leadership</h6>
            <h2 class="fw-bold display-5">Meet the Management Team</h2>
        </div>

        <div class="row g-5 mt-4">
            <?php foreach($members as $member): ?>
            <div class="col-md-6">
                <div class="member-card bg-white p-5 pt-5 rounded-4 shadow-sm text-center position-relative transition-card">
                    <div class="member-img-wrapper shadow-md">
                        <img src="<?php echo $member['image']; ?>" alt="<?php echo $member['name']; ?>" class="rounded-circle img-fluid">
                    </div>
                    <div class="mt-5">
                        <h3 class="fw-bold h4 mb-1"><?php echo $member['name']; ?></h3>
                        <p class="text-primary fw-bold small text-uppercase mb-3"><?php echo $member['role']; ?></p>
                        <p class="text-muted leading-relaxed"><?php echo $member['description']; ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- --- WHY US & OTHERS --- -->
<section class="py-5 bg-white">
    <div class="container py-5">
        <div id="whyus" class="mb-5">
            <h2 class="fw-bold h1 mb-4 d-flex align-items-center justify-content-center gap-3">
                <i class="fas fa-shield-alt text-primary"></i> Why Us?
            </h2>
            <p class="fs-5 text-center text-secondary mx-auto" style="max-width: 800px;">
                <?php echo $aboutData['whyUs']; ?>
            </p>
        </div>

        <div class="row g-4 mt-5">
            <div class="col-md-6">
                <div class="p-4 bg-light rounded-4 h-100 shadow-sm border-start border-primary border-4">
                    <h4 class="fw-bold mb-4"><i class="fas fa-star text-warning me-2"></i> How Are We Different?</h4>
                    <ul class="list-unstyled">
                        <?php foreach($aboutData['howDifferent'] as $diff): ?>
                            <li class="mb-2 fs-6"><i class="fas fa-check-circle text-success me-2"></i> <?php echo $diff; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-4 bg-light rounded-4 h-100 shadow-sm border-start border-info border-4">
                    <h4 class="fw-bold mb-4"><i class="fas fa-user-shield text-info me-2"></i> Safety First</h4>
                    <?php foreach($aboutData['safety'] as $safe): ?>
                        <p class="mb-3">• <?php echo $safe; ?></p>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="mt-5 p-5 bg-primary text-white rounded-4 text-center shadow-lg">
            <h3 class="fw-bold mb-3"><i class="fas fa-chalkboard-teacher me-2"></i> Our Tutors</h3>
            <p class="fs-5 mb-0"><?php echo $aboutData['tutorDescription']; ?></p>
        </div>
    </div>
</section>

<?php include('includes/footer.php'); ?>