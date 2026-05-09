<?php 
require_once 'functions.php'; // 1. Logic Layer include karein
$management_team = getMembers(); // 2. Real data fetch karein (order_val ke hisaab se)

include('includes/header.php'); 
include('includes/navbar.php'); 
?>

<div class="management-page-wrapper py-5 bg-gray-50 overflow-hidden" style="min-height: 90vh;">
    <div class="container py-5 mt-4">
        
        <!-- Animated Header (Static UI as per requirement) -->
        <div class="text-center mb-5 pb-5 animate-up">
            <h6 class="text-primary fw-bold text-uppercase tracking-wider small">Our Leadership</h6>
            <h1 class="fw-extrabold text-dark display-4 mt-2">Meet the Management Team</h1>
            <p class="text-muted fs-5 mt-3 mx-auto" style="max-width: 700px;">
                Visionaries guiding our path to excellence.
            </p>
        </div>

        <!-- Management Grid (Now Dynamic) -->
        <div class="row g-5 mt-5 justify-content-center">
            <?php if(!empty($management_team)): foreach($management_team as $index => $member): ?>
            <div class="col-lg-5 col-md-6 mb-5 animate-up" style="animation-delay: <?php echo ($index * 0.2); ?>s;">
                <div class="management-card bg-white p-4 p-md-5 pt-5 rounded-4 shadow-lg border-0 text-center position-relative transition-card">
                    
                    <!-- --- IMAGE SECTION (Avatar Style) --- -->
                    <div class="member-avatar-container">
                        <div class="member-avatar-circle shadow-md border-white">
                            <!-- Dynamic Profile Image Path -->
                            <img src="<?php echo $member['image']; ?>" 
                                 alt="<?php echo $member['name']; ?>" 
                                 class="img-fluid"
                                 onerror="this.src='https://via.placeholder.com/150'">
                        </div>
                        
                        <!-- Social Icon (LinkedIn) - Database se linkedin link aayega -->
                        <a href="<?php echo $member['linkedin'] ?? '#'; ?>" target="_blank" class="linkedin-badge shadow-sm">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>

                    <!-- --- TEXT CONTENT --- -->
                    <div class="mt-4 pt-2">
                        <h3 class="fw-bold text-dark h3 mb-1 member-name"><?php echo $member['name']; ?></h3>
                        <p class="text-primary fw-bold small text-uppercase tracking-widest mb-4"><?php echo $member['role']; ?></p>
                        
                        <!-- Dynamic Description Text -->
                        <p class="text-secondary leading-relaxed text-justify px-2">
                            <?php echo $member['description']; ?>
                        </p>
                    </div>
                </div>
            </div>
            <?php endforeach; else: ?>
                <!-- Fallback agar database khali ho -->
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Our management team details will be updated soon.</p>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php include('includes/footer.php'); ?>