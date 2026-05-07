<?php
// Industry Standard: Navigation Data Array
// In links ko humne hamari banayi hui dynamic files se map kiya hai
$sections = [
    "Math" => [
        "link" => "courses-maths.php",
        "courses" => [
            ["name" => "MATH COMMON CORE", "link" => "courses-maths.php#math"],
            ["name" => "MATH ALGEBRA 1 & 2", "link" => "courses-maths.php#algebra"],
            ["name" => "MATH GEOMETRY", "link" => "courses-maths.php#geometry"],
            ["name" => "MATH KANGAROO", "link" => "courses-maths.php#kangaroo"],
            ["name" => "MATH AMC", "link" => "courses-maths.php#amc"],
            ["name" => "MATH PRE-CALCULUS", "link" => "courses-maths.php#science"]
        ]
    ],
    "English" => [
        "link" => "courses-english.php",
        "courses" => [
            ["name" => "COMMON CORE ENGLISH", "link" => "courses-english.php#common"],
            ["name" => "ELA", "link" => "courses-english.php#ela"],
            ["name" => "ISEE", "link" => "courses-english.php#isee"],
            ["name" => "REGISTRATION", "link" => "courses-english.php#registration"]
        ]
    ],
"Test Prep" => [
        "link" => "#",
        "courses" => [
            ["name" => "SAT", "link" => "course-sat.php"],
            ["name" => "SSAT", "link" => "course-ssat.php"],
            ["name" => "PSAT", "link" => "course-psat.php"],
            ["name" => "SHSAT", "link" => "course-shsat.php"],
            ["name" => "ISEE", "link" => "course-isee.php"],
            ["name" => "ELA", "link" => "course-ela.php"],
            ["name" => "SCAT", "link" => "course-scat.php"],
            ["name" => "AMC", "link" => "course-amc.php"],
            ["name" => "KANGAROO", "link" => "course-kangaroo.php"],
            ["name" => "ACT", "link" => "course-act.php"],
            ["name" => "COGAT", "link" => "course-cogat.php"],
            ["name" => "SBAC", "link" => "course-sbac.php"],
            ["name" => "ACCUPLACER", "link" => "course-accuplacer.php"],
            ["name" => "STB", "link" => "course-stb.php"]
        ]
    ],
    "K-12" => [
        "link" => "courses-k12.php",
        "courses" => [
            ["name" => "Methodology", "link" => "courses-k12.php#methodology"],
            ["name" => "Subject Expertise", "link" => "courses-k12.php#expertise"]
        ]
    ]
];

// Current page name nikalne ke liye logic
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!-- --- TOP BAR --- -->
<div class="top-bar bg-primary text-white py-2 d-none d-md-block">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="contact-info small">
            <a href="tel:+918860296060" class="text-white text-decoration-none me-3">
                <i class="fas fa-phone-alt me-2 text-info"></i> +91-886-029-6060
            </a>
            <a href="mailto:info@mygges.com" class="text-white text-decoration-none">
                <i class="fas fa-envelope me-2 text-info"></i> info@mygges.com
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

<!-- --- MAIN NAVBAR --- -->
<nav class="navbar navbar-expand-xl navbar-light bg-white sticky-top shadow-sm py-3">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="index.php">
            <img src="assets/images/logo.png" alt="GGES Logo" height="40" onerror="this.src='https://via.placeholder.com/120x40?text=GGES+LOGO'">
        </a>
        
        <!-- Mobile Toggle -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-center">
                
                <li class="nav-item">
                    <a class="nav-link fw-bold px-3 <?php echo ($current_page == 'index.php') ? 'text-primary' : ''; ?>" href="index.php">Home</a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link fw-bold px-3 <?php echo ($current_page == 'about.php') ? 'text-primary' : ''; ?>" href="about.php">About Us</a>
                </li>
                
                <!-- Courses Mega Dropdown -->
                <li class="nav-item dropdown mega-dropdown">
                    <a class="nav-link dropdown-toggle fw-bold px-3" href="#" data-bs-toggle="dropdown">Courses</a>
                    <div class="dropdown-menu shadow-lg border-0 p-4 rounded-4">
                        <div class="row" style="min-width: 850px;">
                            <?php foreach($sections as $title => $data): ?>
                            <div class="col-md-3 border-end last-child-no-border">
                                <h6 class="text-primary fw-bold mb-3 pb-2 border-bottom"><?php echo $title; ?></h6>
                                <ul class="list-unstyled p-0 m-0">
                                    <?php foreach($data['courses'] as $course): ?>
                                    <li class="mb-2">
                                        <a class="dropdown-item small p-0 text-wrap d-flex align-items-center" href="<?php echo $course['link']; ?>">
                                            <i class="fas fa-chevron-right me-2 text-primary" style="font-size: 8px;"></i>
                                            <span><?php echo $course['name']; ?></span>
                                        </a>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link fw-bold px-3 <?php echo ($current_page == 'pricing.php') ? 'text-primary' : ''; ?>" href="pricing.php">Pricing</a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link fw-bold px-3 <?php echo ($current_page == 'management.php') ? 'text-primary' : ''; ?>" href="management.php">Management</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link fw-bold px-3 <?php echo ($current_page == 'testimonial.php') ? 'text-primary' : ''; ?>" href="testimonial.php">Testimonials</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link fw-bold px-3 <?php echo ($current_page == 'blog.php') ? 'text-primary' : ''; ?>" href="blog.php">Blog</a>
                </li>

                <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                    <a href="contact.php" class="btn btn-primary text-white px-4 py-2 rounded-pill fw-bold shadow-sm hover-scale">Contact us</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
/* Mega Menu Custom Styling */
.mega-dropdown:hover .dropdown-menu {
    display: block;
    margin-top: 0;
}
.dropdown-item {
    transition: all 0.2s ease;
    color: #4b5563 !important;
}
.dropdown-item:hover {
    background: transparent !important;
    color: #305CDE !important;
    transform: translateX(5px);
}
.last-child-no-border:last-child {
    border-right: none !important;
}
.hover-scale:hover {
    transform: scale(1.05);
    transition: 0.3s;
}
</style>