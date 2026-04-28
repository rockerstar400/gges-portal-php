<div class="sidebar bg-dark text-white shadow" style="width: 260px; min-width: 260px; background: #0e1d3e !important;">
    <div class="p-4 text-center border-bottom border-secondary mb-3">
        <h5 class="fw-bold text-uppercase tracking-wider m-0">GGES ADMIN</h5>
    </div>
    <div class="nav flex-column px-2">
        <a href="dashboard.php" class="nav-link text-white py-3 px-4 mb-1 rounded-3 <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'bg-primary active' : ''; ?>">
            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
        </a>
        <a href="manage-banner.php" class="nav-link text-white py-3 px-4 mb-1 rounded-3">
            <i class="fas fa-image me-2"></i> Hero Banner
        </a>
        <a href="manage-footer-banner.php" class="nav-link text-white py-3 px-4 mb-1 rounded-3 <?php echo (basename($_SERVER['PHP_SELF']) == 'manage-footer-banner.php') ? 'bg-primary active shadow' : ''; ?>">
    <i class="fas fa- chalkboard me-2"></i> Footer Banner
</a>
        <a href="manage-why-choose.php" class="nav-link text-white py-3 px-4 mb-1 rounded-3">
            <i class="fas fa-check-circle me-2"></i> Why Choose Us
        </a>
        <a href="manage-trust.php" class="nav-link text-white py-3 px-4 mb-1 rounded-3 <?php echo (basename($_SERVER['PHP_SELF']) == 'manage-trust.php') ? 'bg-primary active shadow' : ''; ?>">
    <i class="fas fa-shield-alt me-2"></i> Trust Credibilty
</a>
        <a href="manage-offers.php" class="nav-link text-white py-3 px-4 mb-1 rounded-3">
            <i class="fas fa-tags me-2"></i> Offers
        </a>
        <a href="manage-blogs.php" class="nav-link text-white py-3 px-4 mb-1 rounded-3">
            <i class="fas fa-newspaper me-2"></i> Manage Blogs
        </a>
        <a href="manage-about.php" class="nav-link text-white py-3 px-4 mb-1 rounded-3">
    <i class="fas fa-info-circle me-2"></i> About Us Content
</a>
<a href="manage-management.php" class="nav-link text-white py-3 px-4 mb-1 rounded-3">
    <i class="fas fa-users me-2"></i> Management Team
</a>
<a href="manage-success-story.php" class="nav-link text-white py-3 px-4 mb-1 rounded-3 <?php echo (basename($_SERVER['PHP_SELF']) == 'manage-success-story.php') ? 'bg-primary active' : ''; ?>">
    <i class="fas fa-history me-2"></i> Success Story
</a>
        <a href="manage-testimonial.php" class="nav-link text-white py-3 px-4 mb-1 rounded-3 <?php echo (basename($_SERVER['PHP_SELF']) == 'manage-testimonial.php') ? 'bg-primary active shadow' : ''; ?>">
            <i class="fas fa-star me-2"></i> Testimonials
        </a>
                <a href="manage-contact.php" class="nav-link text-white py-3 px-4 mb-1 rounded-3 <?php echo (basename($_SERVER['PHP_SELF']) == 'manage-contact.php') ? 'bg-primary active shadow' : ''; ?>">
            <i class="fas fa-address-book me-2"></i> Contact Info
        </a>
        <a href="manage-pricing.php" class="nav-link text-white py-3 px-4 mb-1 rounded-3 <?php echo (basename($_SERVER['PHP_SELF']) == 'manage-pricing.php') ? 'bg-primary active shadow' : ''; ?>">
    <i class="fas fa-tags me-2"></i> Pricing Plans
</a>
<?php 
$currentType = $_GET['type'] ?? '';
$maths = ['math-common-core', 'math-algebra', 'math-geometry', 'math-amc', 'math-kangaroo', 'math-science'];
$english = ['english-common', 'english-ela', 'english-isee'];
$k12 = ['k12-methodology', 'k12-expertise'];
?>

<div class="nav flex-column px-2 admin-nav-links">
    <!-- Home/Dashboard links... -->

    <!-- 1. MATHS -->
<!-- 1. MATHS (Updated with all 6 categories) -->
<div class="nav-item">
    <a class="nav-link text-white py-3 px-4 d-flex justify-content-between align-items-center <?php echo in_array($currentType, $maths) ? '' : 'collapsed'; ?>" data-bs-toggle="collapse" href="#mathMenu">
        <span><i class="fas fa-calculator me-2"></i> Maths</span>
        <i class="fas fa-chevron-down small"></i>
    </a>
    <div class="collapse ps-3 <?php echo in_array($currentType, $maths) ? 'show' : ''; ?>" id="mathMenu">
        
        <a href="manage-course.php?type=math-common-core" 
           class="nav-link py-2 small <?php echo ($currentType=='math-common-core') ? 'text-primary fw-bold' : 'text-white-50'; ?>">
           Common Core Math
        </a>
        
        <a href="manage-course.php?type=math-algebra" 
           class="nav-link py-2 small <?php echo ($currentType=='math-algebra') ? 'text-primary fw-bold' : 'text-white-50'; ?>">
           Math Algebra
        </a>
        
        <a href="manage-course.php?type=math-geometry" 
           class="nav-link py-2 small <?php echo ($currentType=='math-geometry') ? 'text-primary fw-bold' : 'text-white-50'; ?>">
           Geometry
        </a>
        
        <a href="manage-course.php?type=math-amc" 
           class="nav-link py-2 small <?php echo ($currentType=='math-amc') ? 'text-primary fw-bold' : 'text-white-50'; ?>">
           Math Amc
        </a>

        <!-- Naya Link: Math Kangaroo -->
        <a href="manage-course.php?type=math-kangaroo" 
           class="nav-link py-2 small <?php echo ($currentType=='math-kangaroo') ? 'text-primary fw-bold' : 'text-white-50'; ?>">
           Math Kangaroo
        </a>

        <!-- Naya Link: K-12 Common Core Science -->
        <a href="manage-course.php?type=math-science" 
           class="nav-link py-2 small <?php echo ($currentType=='math-science') ? 'text-primary fw-bold' : 'text-white-50'; ?>">
           K-12 Common Core Science
        </a>

    </div>
</div>

    <!-- 2. ENGLISH -->
    <div class="nav-item">
        <a class="nav-link text-white py-3 px-4 d-flex justify-content-between align-items-center <?php echo in_array($currentType, $english) ? '' : 'collapsed'; ?>" data-bs-toggle="collapse" href="#engMenu">
            <span><i class="fas fa-font me-2"></i> English</span>
            <i class="fas fa-chevron-down small"></i>
        </a>
        <div class="collapse ps-3 <?php echo in_array($currentType, $english) ? 'show' : ''; ?>" id="engMenu">
            <a href="manage-course.php?type=english-common" class="nav-link py-2 small <?php echo ($currentType=='english-common')?'text-primary fw-bold':'text-white-50'; ?>">Common Core English</a>
            <a href="manage-course.php?type=english-ela" class="nav-link py-2 small <?php echo ($currentType=='english-ela')?'text-primary fw-bold':'text-white-50'; ?>">ELA</a>
        </div>
    </div>

    <!-- 3. K-12 -->
    <div class="nav-item">
        <a class="nav-link text-white py-3 px-4 d-flex justify-content-between align-items-center <?php echo in_array($currentType, $k12) ? '' : 'collapsed'; ?>" data-bs-toggle="collapse" href="#k12Menu">
            <span><i class="fas fa-graduation-cap me-2"></i> K-12</span>
            <i class="fas fa-chevron-down small"></i>
        </a>
        <div class="collapse ps-3 <?php echo in_array($currentType, $k12) ? 'show' : ''; ?>" id="k12Menu">
            <a href="manage-course.php?type=k12-methodology" class="nav-link py-2 small <?php echo ($currentType=='k12-methodology')?'text-primary fw-bold':'text-white-50'; ?>">Methodology</a>
        </div>
    </div>
</div>
        
        <div class="mt-5 border-top border-secondary pt-3">
            <a href="logout.php" class="nav-link text-danger py-3 px-4">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </a>
        </div>
    </div>
</div>