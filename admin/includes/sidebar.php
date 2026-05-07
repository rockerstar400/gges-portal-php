<?php 
$currentType = $_GET['type'] ?? '';
$maths = ['math-common-core', 'math-algebra', 'math-geometry', 'math-amc', 'math-kangaroo', 'math-science'];
$english = ['eng-common-lang', 'eng-core-ela', 'eng-about-ela', 'eng-about-isee', 'eng-registration'];
$testPrep = ['sat', 'ssat', 'psat', 'shsat', 'isee', 'ela', 'scat', 'amc', 'kangaroo', 'act', 'cogat', 'sbac', 'accuplacer', 'stb'];
$k12 = ['k12-management']; // Single page for K-12
?>

<div class="sidebar bg-dark text-white shadow-lg custom-sidebar">
    <div class="p-4 text-center border-bottom border-secondary mb-3">
        <h5 class="fw-bold text-uppercase tracking-wider m-0">GGES ADMIN</h5>
    </div>

    <div class="nav flex-column px-2 admin-nav-links">
        
        <!-- 🏠 Dashboard -->
        <a href="dashboard.php" class="nav-link text-white py-3 px-4 mb-1 rounded-3 <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'bg-primary active' : ''; ?>">
            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
        </a>

        <!-- 🖼️ Banners -->
        <a href="manage-banner.php" class="nav-link text-white py-2 px-4 mb-1 rounded-3 <?php echo (basename($_SERVER['PHP_SELF']) == 'manage-banner.php') ? 'bg-primary active' : ''; ?>">
            <i class="fas fa-image me-2"></i> Hero Banner
        </a>
        <a href="manage-footer-banner.php" class="nav-link text-white py-2 px-4 mb-1 rounded-3 <?php echo (basename($_SERVER['PHP_SELF']) == 'manage-footer-banner.php') ? 'bg-primary active' : ''; ?>">
            <i class="fas fa-chalkboard me-2"></i> Footer Banner
        </a>

        <!-- ℹ️ General Content -->
        <a href="manage-why-choose.php" class="nav-link text-white py-2 px-4 mb-1 rounded-3 <?php echo (basename($_SERVER['PHP_SELF']) == 'manage-why-choose.php') ? 'bg-primary active' : ''; ?>">
            <i class="fas fa-check-circle me-2"></i> Why Choose Us
        </a>
        <a href="manage-trust.php" class="nav-link text-white py-2 px-4 mb-1 rounded-3 <?php echo (basename($_SERVER['PHP_SELF']) == 'manage-trust.php') ? 'bg-primary active' : ''; ?>">
            <i class="fas fa-shield-alt me-2"></i> Trust Credibilty
        </a>
        <a href="manage-about.php" class="nav-link text-white py-2 px-4 mb-1 rounded-3 <?php echo (basename($_SERVER['PHP_SELF']) == 'manage-about.php') ? 'bg-primary active' : ''; ?>">
            <i class="fas fa-info-circle me-2"></i> About Us
        </a>
        <a href="manage-management.php" class="nav-link text-white py-2 px-4 mb-1 rounded-3 <?php echo (basename($_SERVER['PHP_SELF']) == 'manage-management.php') ? 'bg-primary active' : ''; ?>">
            <i class="fas fa-users me-2"></i> Management Team
        </a>

        <!-- 🏷️ Marketing -->
        <a href="manage-offers.php" class="nav-link text-white py-2 px-4 mb-1 rounded-3 <?php echo (basename($_SERVER['PHP_SELF']) == 'manage-offers.php') ? 'bg-primary active' : ''; ?>">
            <i class="fas fa-tags me-2"></i> Offers
        </a>
        <a href="manage-success-story.php" class="nav-link text-white py-2 px-4 mb-1 rounded-3 <?php echo (basename($_SERVER['PHP_SELF']) == 'manage-success-story.php') ? 'bg-primary active' : ''; ?>">
            <i class="fas fa-history me-2"></i> Success Story
        </a>
        <a href="manage-testimonial.php" class="nav-link text-white py-2 px-4 mb-1 rounded-3 <?php echo (basename($_SERVER['PHP_SELF']) == 'manage-testimonial.php') ? 'bg-primary active' : ''; ?>">
            <i class="fas fa-star me-2"></i> Testimonials
        </a>

        <hr class="border-secondary my-3">

        <!-- 📐 MATHS CATEGORY -->
        <div class="nav-item">
            <a class="nav-link text-white py-3 px-4 d-flex justify-content-between align-items-center <?php echo in_array($currentType, $maths) ? '' : 'collapsed'; ?>" data-bs-toggle="collapse" href="#mathMenu">
                <span><i class="fas fa-calculator me-2 text-info"></i> Maths</span>
                <i class="fas fa-chevron-down small"></i>
            </a>
            <div class="collapse ps-3 <?php echo in_array($currentType, $maths) ? 'show' : ''; ?>" id="mathMenu">
                <a href="manage-course.php?type=math-common-core" class="nav-link py-2 small <?php echo ($currentType=='math-common-core')?'text-primary fw-bold':'text-white-50'; ?>">Common Core Math</a>
                <a href="manage-course.php?type=math-algebra" class="nav-link py-2 small <?php echo ($currentType=='math-algebra')?'text-primary fw-bold':'text-white-50'; ?>">Math Algebra</a>
                <a href="manage-course.php?type=math-geometry" class="nav-link py-2 small <?php echo ($currentType=='math-geometry')?'text-primary fw-bold':'text-white-50'; ?>">Geometry</a>
                <a href="manage-course.php?type=math-amc" class="nav-link py-2 small <?php echo ($currentType=='math-amc')?'text-primary fw-bold':'text-white-50'; ?>">Math Amc</a>
                <a href="manage-course.php?type=math-kangaroo" class="nav-link py-2 small <?php echo ($currentType=='math-kangaroo')?'text-primary fw-bold':'text-white-50'; ?>">Math Kangaroo</a>
                
                <a href="manage-course.php?type=math-science" class="nav-link py-2 small <?php echo ($currentType=='math-science')?'text-primary fw-bold':'text-white-50'; ?>">Common Core Science</a>
                
            </div>
        </div>

        <!-- 🔤 ENGLISH CATEGORY -->
        <div class="nav-item">
            <a class="nav-link text-white py-3 px-4 d-flex justify-content-between align-items-center <?php echo in_array($currentType, $english) ? '' : 'collapsed'; ?>" data-bs-toggle="collapse" href="#engMenu">
                <span><i class="fas fa-font me-2 text-warning"></i> English</span>
                <i class="fas fa-chevron-down small"></i>
            </a>
            <div class="collapse ps-3 <?php echo in_array($currentType, $english) ? 'show' : ''; ?>" id="engMenu">
                <a href="manage-course.php?type=eng-common-lang" class="nav-link py-2 small <?php echo ($currentType=='eng-common-lang')?'text-primary fw-bold':'text-white-50'; ?>">Common English Lang.</a>
                <a href="manage-course.php?type=eng-core-ela" class="nav-link py-2 small <?php echo ($currentType=='eng-core-ela')?'text-primary fw-bold':'text-white-50'; ?>">Common Core ELA</a>
                <a href="manage-course.php?type=eng-about-ela" class="nav-link py-2 small <?php echo ($currentType=='eng-about-ela')?'text-primary fw-bold':'text-white-50'; ?>">About ELA</a>
                <a href="manage-course.php?type=eng-about-isee" class="nav-link py-2 small <?php echo ($currentType=='eng-about-isee')?'text-primary fw-bold':'text-white-50'; ?>">About ISEE Test</a>
                <a href="manage-course.php?type=eng-registration" class="nav-link py-2 small <?php echo ($currentType=='eng-registration')?'text-primary fw-bold':'text-white-50'; ?>">Registration</a>
            </div>
        </div>

        <!-- 🎓 K-12 (Direct Link) -->
        <a href="manage-course.php?type=k12-management" class="nav-link text-white py-3 px-4 mb-1 rounded-3 <?php echo ($currentType == 'k12-management') ? 'bg-primary active' : ''; ?>">
            <i class="fas fa-graduation-cap me-2 text-success"></i> K-12 Management
        </a>

        <hr class="border-secondary my-3">

        <a href="manage-blogs.php" class="nav-link text-white py-2 px-4 mb-1 rounded-3 <?php echo (basename($_SERVER['PHP_SELF']) == 'manage-blogs.php') ? 'bg-primary active' : ''; ?>">
            <i class="fas fa-newspaper me-2"></i> Manage Blogs
        </a>
        <a href="manage-pricing.php" class="nav-link text-white py-2 px-4 mb-1 rounded-3 <?php echo (basename($_SERVER['PHP_SELF']) == 'manage-pricing.php') ? 'bg-primary active' : ''; ?>">
            <i class="fas fa-money-check-alt me-2"></i> Pricing Plans
        </a>
        <a href="manage-contact.php" class="nav-link text-white py-2 px-4 mb-1 rounded-3 <?php echo (basename($_SERVER['PHP_SELF']) == 'manage-contact.php') ? 'bg-primary active' : ''; ?>">
            <i class="fas fa-address-book me-2"></i> Contact Info
        </a>

        <div class="nav-item">
    <a class="nav-link text-white py-3 px-4 d-flex justify-content-between align-items-center <?php echo in_array($currentType, $testPrep) ? '' : 'collapsed'; ?>" data-bs-toggle="collapse" href="#testPrepMenu">
        <span><i class="fas fa-file-alt me-2 text-danger"></i> Test Prep</span>
        <i class="fas fa-chevron-down small"></i>
    </a>
    <div class="collapse ps-3 <?php echo in_array($currentType, $testPrep) ? 'show' : ''; ?>" id="testPrepMenu">
        <?php foreach($testPrep as $tp): ?>
            <a href="manage-test-prep.php?type=<?php echo $tp; ?>" class="nav-link py-1 small <?php echo ($currentType == $tp) ? 'text-primary fw-bold' : 'text-white-50'; ?>">
                <?php echo strtoupper($tp); ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>

        <div class="mt-5 mb-5 pt-3 border-top border-secondary">
            <a href="logout.php" class="nav-link text-danger py-3 px-4 fw-bold">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </a>
        </div>
    </div>
</div>

<style>
/* Sidebar Fixing Logic */
.custom-sidebar {
    width: 260px;
    min-width: 260px;
    background: #0e1d3e !important;
    position: sticky;
    top: 0;
    height: 100vh;
    overflow-y: auto; /* Internal scrolling if links are more */
}

/* Scrollbar Hide for Clean UI */
.custom-sidebar::-webkit-scrollbar { width: 5px; }
.custom-sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }

.admin-nav-links .nav-link { transition: 0.3s; font-size: 13px; opacity: 0.8; }
.admin-nav-links .nav-link:hover { opacity: 1; background: rgba(255,255,255,0.1); transform: translateX(5px); }
.admin-nav-links .nav-link.active { opacity: 1; background-color: #305CDE !important; }

/* Dropdown Arrow Animation */
.nav-link.collapsed .fas.fa-chevron-down { transform: rotate(0deg); transition: 0.3s; }
.nav-link:not(.collapsed) .fas.fa-chevron-down { transform: rotate(180deg); transition: 0.3s; }
</style>