<?php include('includes/header.php'); ?>
<?php include('includes/navbar.php'); ?>

<?php
// PHP Data Array (React ke members state ki tarah)
$management_team = [
    [
        "id" => 1,
        "name" => "John Doe",
        "role" => "Founder & CEO",
        "image" => "assets/images/member1.png",
        "description" => "John has over 15 years of experience in the education sector. He envisions a world where quality education is accessible to every student regardless of their location.",
        "linkedin" => "#"
    ],
    [
        "id" => 2,
        "name" => "Jane Smith",
        "role" => "Academic Director",
        "image" => "assets/images/member2.png",
        "description" => "Jane leads our curriculum development team. Her expertise in pedagogy ensures that our teaching methods are always ahead of the curve and highly effective.",
        "linkedin" => "#"
    ]
];
?>

<div class="management-page-wrapper py-5 bg-gray-50 overflow-hidden" style="min-height: 90vh;">
    <div class="container py-5 mt-4">
        
        <!-- Animated Header -->
        <div class="text-center mb-5 pb-5 animate-up">
            <h6 class="text-primary fw-bold text-uppercase tracking-wider small">Our Leadership</h6>
            <h1 class="fw-extrabold text-dark display-4 mt-2">Meet the Management Team</h1>
            <p class="text-muted fs-5 mt-3 mx-auto" style="max-width: 700px;">
                Visionaries guiding our path to excellence.
            </p>
        </div>

        <!-- Management Grid -->
        <div class="row g-5 mt-5 justify-content-center">
            <?php foreach($management_team as $index => $member): ?>
            <div class="col-lg-5 col-md-6 mb-5 animate-up" style="animation-delay: <?php echo ($index * 0.2); ?>s;">
                <div class="management-card bg-white p-4 p-md-5 pt-5 rounded-4 shadow-lg border-0 text-center position-relative transition-card">
                    
                    <!-- --- IMAGE SECTION (Avatar Style) --- -->
                    <div class="member-avatar-container">
                        <div class="member-avatar-circle shadow-md">
                            <img src="<?php echo $member['image']; ?>" 
                                 alt="<?php echo $member['name']; ?>" 
                                 class="img-fluid"
                                 onerror="this.src='https://via.placeholder.com/150'">
                        </div>
                        
                        <!-- Social Icon (LinkedIn) -->
                        <a href="<?php echo $member['linkedin']; ?>" class="linkedin-badge shadow-sm">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>

                    <!-- --- TEXT CONTENT --- -->
                    <div class="mt-4 pt-2">
                        <h3 class="fw-bold text-dark h3 mb-1 member-name"><?php echo $member['name']; ?></h3>
                        <p class="text-primary fw-bold small text-uppercase tracking-widest mb-4"><?php echo $member['role']; ?></p>
                        
                        <p class="text-secondary leading-relaxed text-justify px-2">
                            <?php echo $member['description']; ?>
                        </p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

    </div>
</div>

<?php include('includes/footer.php'); ?>