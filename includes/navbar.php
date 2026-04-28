<!-- <?php

$sections = [
    "Math" => [
        "link" => "courses-maths.php",
        "courses" => [
            ["name" => "MATH COMMON CORE", "link" => "courses-maths.php#math"],
            ["name" => "MATH ALGEBRA 1 & 2", "link" => "courses-maths.php#algebra"],
            ["name" => "MATH GEOMETRY", "link" => "courses-maths.php#geometry"]
        ]
    ],
    "English" => [
        "link" => "courses-english.php",
        "courses" => [
            ["name" => "COMMON CORE ENGLISH", "link" => "courses-english.php#common"],
            ["name" => "ELA", "link" => "courses-english.php#englishela"]
        ]
    ]
  
];
?>


<div class="top-bar bg-primary text-white py-2 d-none d-md-block">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="contact-info small">
            <a href="tel:+918860296060" class="text-white text-decoration-none me-3">
                <i class="fas fa-phone-alt me-2"></i> +91-886-029-6060
            </a>
            <a href="mailto:info@mygges.com" class="text-white text-decoration-none">
                <i class="fas fa-envelope me-2"></i> info@mygges.com
            </a>
        </div>
        <div class="social-links">
            <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
            <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="text-white me-3"><i class="fab fa-whatsapp"></i></a>
            <a href="#" class="text-white"><i class="fab fa-youtube"></i></a>
        </div>
    </div>
</div>


<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm py-3">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="assets/images/logo.png" alt="GGES Logo" height="40">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-content="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link fw-bold" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link fw-bold" href="about.php">About Us</a></li>
                
              
                <li class="nav-item dropdown mega-dropdown">
                    <a class="nav-link dropdown-toggle fw-bold" href="#" data-bs-toggle="dropdown">Courses</a>
                    <div class="dropdown-menu shadow border-0 p-3">
                        <div class="row" style="min-width: 600px;">
                            <?php foreach($sections as $title => $data): ?>
                            <div class="col-md-4">
                                <h6 class="text-primary fw-bold"><?php echo $title; ?></h6>
                                <ul class="list-unstyled">
                                    <?php foreach($data['courses'] as $course): ?>
                                    <li><a class="dropdown-item small px-0" href="<?php echo $course['link']; ?>"><?php echo $course['name']; ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </li>

                <li class="nav-item"><a class="nav-link fw-bold" href="pricing.php">Pricing</a></li>
                <li class="nav-item"><a class="nav-link fw-bold" href="contact.php" class="btn btn-primary text-white ms-lg-3 px-4 rounded-pill">Contact Us</a></li>
            </ul>
        </div>
    </div>
</nav> -->

<?php
// React ke 'sections' array ke hisaab se updated data
$sections = [
    "Math" => [
        "link" => "courses-maths.php",
        "courses" => [
            ["name" => "MATH COMMON CORE", "link" => "courses-maths.php#math"],
            ["name" => "MATH ALGEBRA 1 & 2", "link" => "courses-maths.php#algebra"],
            ["name" => "MATH GEOMETRY", "link" => "courses-maths.php#geometry"],
            ["name" => "MATH KANGAROO", "link" => "courses-maths.php#kangaroo"],
            ["name" => "Math AMC", "link" => "courses-maths.php#mathamc"]
        ]
    ],
    "English" => [
        "link" => "courses-english.php",
        "courses" => [
            ["name" => "COMMON CORE ENGLISH", "link" => "courses-english.php#common"],
            ["name" => "ELA", "link" => "courses-english.php#englishela"],
            ["name" => "ISEE", "link" => "courses-english.php#englishisee"]
        ]
    ],
    "Test Prep" => [
        "link" => "courses-test.php",
        "courses" => [
            ["name" => "SAT", "link" => "courses-test.php#sat"],
            ["name" => "PSAT", "link" => "courses-test.php#psat"],
            ["name" => "ACT", "link" => "courses-test.php#act"],
            ["name" => "ISEE", "link" => "courses-test.php#isee"]
        ]
    ],
    "K-12" => [
        "link" => "courses-k-12.php",
        "courses" => [
            ["name" => "Methodology", "link" => "courses-k-12.php#methodology"],
            ["name" => "Subject Expertise", "link" => "courses-k-12.php#expertise"]
        ]
    ]
];
?>

<!-- Top Bar -->
<div class="top-bar bg-primary text-white py-2 d-none d-md-block">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="contact-info small">
            <a href="tel:+918860296060" class="text-white text-decoration-none me-3">
                <i class="fas fa-phone-alt me-2"></i> +91-886-029-6060
            </a>
            <a href="mailto:info@mygges.com" class="text-white text-decoration-none">
                <i class="fas fa-envelope me-2"></i> info@mygges.com
            </a>
        </div>
        <div class="social-links">
            <a href="#" class="text-white ms-3 hover-scale-sm"><i class="fab fa-instagram"></i></a>
            <a href="#" class="text-white ms-3 hover-scale-sm"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="text-white ms-3 hover-scale-sm"><i class="fab fa-whatsapp"></i></a>
            <a href="#" class="text-white ms-3 hover-scale-sm"><i class="fab fa-youtube"></i></a>
        </div>
    </div>
</div>

<!-- Main Navbar -->
<nav class="navbar navbar-expand-xl navbar-light bg-white sticky-top shadow-sm py-3">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="assets/images/logo.png" alt="GGES Logo" height="40">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link fw-bold px-3" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link fw-bold px-3" href="about.php">About Us</a></li>
                
                <!-- Courses Dropdown (Mega Menu Style) -->
                <li class="nav-item dropdown mega-dropdown">
                    <a class="nav-link dropdown-toggle fw-bold px-3" href="#" data-bs-toggle="dropdown">Courses</a>
                    <div class="dropdown-menu shadow-lg border-0 p-4">
                        <div class="row" style="min-width: 800px;">
                            <?php foreach($sections as $title => $data): ?>
                            <div class="col-md-3">
                                <h6 class="text-primary fw-bold mb-3 border-bottom pb-2"><?php echo $title; ?></h6>
                                <ul class="list-unstyled">
                                    <?php foreach($data['courses'] as $course): ?>
                                    <li class="mb-2">
                                        <a class="dropdown-item small p-0 text-wrap" href="<?php echo $course['link']; ?>">
                                            <i class="fas fa-chevron-right me-1 text-primary" style="font-size: 10px;"></i>
                                            <?php echo $course['name']; ?>
                                        </a>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </li>

                <li class="nav-item"><a class="nav-link fw-bold px-3" href="pricing.php">Pricing</a></li>
                
                <!-- Naye Links Jo React mein the -->
                <li class="nav-item"><a class="nav-link fw-bold px-3" href="management.php">Our Management</a></li>
                <li class="nav-item"><a class="nav-link fw-bold px-3" href="testimonial.php">Testimonial</a></li>
                <li class="nav-item"><a class="nav-link fw-bold px-3" href="blog.php">Blog</a></li>

                <li class="nav-item ms-lg-3">
                    <a href="contact.php" class="btn btn-primary text-white px-4 py-2 rounded-pill fw-bold shadow-sm">Contact us</a>
                </li>
            </ul>
        </div>
    </div>
</nav>