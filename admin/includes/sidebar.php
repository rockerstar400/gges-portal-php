<?php 
$current_page = basename($_SERVER['PHP_SELF']);

// Groups for active state logic (Dropdowns open rehne ke liye)
$homePages = ['manage-banner.php', 'manage-why-choose.php', 'manage-offers.php', 'manage-success-story.php', 'manage-trust.php', 'manage-pricing.php', 'manage-footer-banner.php'];
$englishPages = ['manage-eng-common.php', 'manage-eng-ela.php', 'manage-eng-about-ela.php', 'manage-eng-isee.php', 'manage-eng-reg.php'];
$mathsPages = ['manage-math-common.php', 'manage-math-algebra.php', 'manage-math-geometry.php', 'manage-math-amc.php', 'manage-math-kangaroo.php', 'manage-math-science.php'];
$testPrepModules = ['manage-sat.php', 'manage-ssat.php', 'manage-psat.php', 'manage-shsat.php', 'manage-isee.php', 'manage-ela.php', 'manage-scat.php', 'manage-amc.php', 'manage-kangaroo.php', 'manage-act.php', 'manage-cogat.php', 'manage-sbac.php', 'manage-accuplacer.php', 'manage-stb.php'];

// Sidebar structure labels
$testPrepLabels = ['sat', 'ssat', 'psat', 'shsat', 'isee', 'ela', 'scat', 'amc', 'kangaroo', 'act', 'cogat', 'sbac', 'accuplacer', 'stb'];
?>

<div class="sidebar bg-dark text-white shadow-lg custom-sidebar">
    <div class="p-4 text-center border-bottom border-secondary mb-3">
        <h5 class="fw-bold text-uppercase tracking-wider m-0" style="color: #305CDE;">GGES ADMIN</h5>
    </div>

    <div class="nav flex-column px-2 admin-nav-links">
        
        <!-- 🏠 Dashboard -->
        <a href="dashboard.php" class="nav-link text-white py-3 px-4 mb-1 rounded-3 <?php echo ($current_page == 'dashboard.php') ? 'bg-primary active' : ''; ?>">
            <i class="fas fa-tachometer-alt me-2 text-info"></i> Dashboard
        </a>

        <!-- 🏠 Home Dropdown -->
        <div class="nav-item">
            <a class="nav-link text-white py-3 px-4 d-flex justify-content-between align-items-center <?php echo in_array($current_page, $homePages) ? '' : 'collapsed'; ?>" data-bs-toggle="collapse" href="#homeMenu">
                <span><i class="fas fa-home me-2 text-primary"></i> Home</span>
                <i class="fas fa-chevron-down small"></i>
            </a>
            <div class="collapse ps-3 <?php echo in_array($current_page, $homePages) ? 'show' : ''; ?>" id="homeMenu">
                <a href="manage-banner.php" class="nav-link py-1 small <?php echo ($current_page=='manage-banner.php')?'text-primary fw-bold':'text-white-50'; ?>">Banner</a>
                <a href="manage-why-choose.php" class="nav-link py-1 small <?php echo ($current_page=='manage-why-choose.php')?'text-primary fw-bold':'text-white-50'; ?>">Why Choose Us</a>
                <a href="manage-offers.php" class="nav-link py-1 small <?php echo ($current_page=='manage-offers.php')?'text-primary fw-bold':'text-white-50'; ?>">Offers</a>
                <a href="manage-success-story.php" class="nav-link py-1 small <?php echo ($current_page=='manage-success-story.php')?'text-primary fw-bold':'text-white-50'; ?>">Success Story</a>
                <a href="manage-trust.php" class="nav-link py-1 small <?php echo ($current_page=='manage-trust.php')?'text-primary fw-bold':'text-white-50'; ?>">Trust Credibilty</a>
                <a href="manage-pricing.php" class="nav-link py-1 small <?php echo ($current_page=='manage-pricing.php')?'text-primary fw-bold':'text-white-50'; ?>">Plan</a>
                <a href="manage-footer-banner.php" class="nav-link py-1 small <?php echo ($current_page=='manage-footer-banner.php')?'text-primary fw-bold':'text-white-50'; ?>">Footer Banner</a>
            </div>
        </div>

        <!-- 📝 Blogs & Pricing -->
        <a href="manage-blogs.php" class="nav-link text-white py-3 px-4 mb-1 rounded-3 <?php echo ($current_page == 'manage-blogs.php') ? 'bg-primary active' : ''; ?>">
            <i class="fas fa-newspaper me-2 text-info"></i> Blog
        </a>
        <a href="manage-pricing.php" class="nav-link text-white py-3 px-4 mb-1 rounded-3 <?php echo ($current_page == 'manage-pricing.php') ? 'bg-primary active' : ''; ?>">
            <i class="fas fa-tags me-2 text-success"></i> Pricing
        </a>

        <hr class="border-secondary my-2">

        <!-- 🔤 English Dropdown -->
        <div class="nav-item">
            <a class="nav-link text-white py-3 px-4 d-flex justify-content-between align-items-center <?php echo in_array($current_page, $englishPages) ? '' : 'collapsed'; ?>" data-bs-toggle="collapse" href="#engMenu">
                <span><i class="fas fa-font me-2 text-warning"></i> English</span>
                <i class="fas fa-chevron-down small"></i>
            </a>
            <div class="collapse ps-3 <?php echo in_array($current_page, $englishPages) ? 'show' : ''; ?>" id="engMenu">
                <a href="manage-eng-common.php" class="nav-link py-1 small <?php echo ($current_page=='manage-eng-common.php')?'text-primary fw-bold':'text-white-50'; ?>">Common English Lang.</a>
                <a href="manage-eng-ela.php" class="nav-link py-1 small <?php echo ($current_page=='manage-eng-ela.php')?'text-primary fw-bold':'text-white-50'; ?>">Common Core ELA</a>
                <a href="manage-eng-about-ela.php" class="nav-link py-1 small <?php echo ($current_page=='manage-eng-about-ela.php')?'text-primary fw-bold':'text-white-50'; ?>">About ELA</a>
                <a href="manage-eng-isee.php" class="nav-link py-1 small <?php echo ($current_page=='manage-eng-isee.php')?'text-primary fw-bold':'text-white-50'; ?>">About ISEE Test</a>
                <a href="manage-eng-reg.php" class="nav-link py-1 small <?php echo ($current_page=='manage-eng-reg.php')?'text-primary fw-bold':'text-white-50'; ?>">Registration</a>
            </div>
        </div>

        <!-- 🎓 K-12 -->
        <a href="manage-k12.php" class="nav-link text-white py-3 px-4 mb-1 rounded-3 <?php echo ($current_page == 'manage-k12.php') ? 'bg-primary active' : ''; ?>">
            <i class="fas fa-graduation-cap me-2 text-success"></i> K-12
        </a>

        <!-- 📐 Maths Dropdown -->
        <div class="nav-item">
            <a class="nav-link text-white py-3 px-4 d-flex justify-content-between align-items-center <?php echo in_array($current_page, $mathsPages) ? '' : 'collapsed'; ?>" data-bs-toggle="collapse" href="#mathMenu">
                <span><i class="fas fa-calculator me-2 text-info"></i> Maths</span>
                <i class="fas fa-chevron-down small"></i>
            </a>
            <div class="collapse ps-3 <?php echo in_array($current_page, $mathsPages) ? 'show' : ''; ?>" id="mathMenu">
                <a href="manage-math-common.php" class="nav-link py-1 small <?php echo ($current_page=='manage-math-common.php')?'text-primary fw-bold':'text-white-50'; ?>">Common Core Math</a>
                <a href="manage-math-algebra.php" class="nav-link py-1 small <?php echo ($current_page=='manage-math-algebra.php')?'text-primary fw-bold':'text-white-50'; ?>">Math Algebra</a>
                <a href="manage-math-geometry.php" class="nav-link py-1 small <?php echo ($current_page=='manage-math-geometry.php')?'text-primary fw-bold':'text-white-50'; ?>">Geometry</a>
                <a href="manage-math-amc.php" class="nav-link py-1 small <?php echo ($current_page=='manage-math-amc.php')?'text-primary fw-bold':'text-white-50'; ?>">Math AMC</a>
                <a href="manage-math-kangaroo.php" class="nav-link py-1 small <?php echo ($current_page=='manage-math-kangaroo.php')?'text-primary fw-bold':'text-white-50'; ?>">Math Kangaroo</a>
                <a href="manage-math-science.php" class="nav-link py-1 small <?php echo ($current_page=='manage-math-science.php')?'text-primary fw-bold':'text-white-50'; ?>">K-12 Common Core Science</a>
            </div>
        </div>

        <!-- ℹ️ General Pages -->
        <a href="manage-about.php"  class="nav-link text-white py-3 px-4 mb-1 rounded-3 <?php echo ($current_page == 'manage-about.php') ? 'bg-primary active' : ''; ?>">
            <i class="fas fa-info-circle me-2 text-info"></i> About
        </a>
        <a href="manage-testimonial.php" class="nav-link text-white py-3 px-4 mb-1 rounded-3 <?php echo ($current_page == 'manage-testimonial.php') ? 'bg-primary active' : ''; ?>">
            <i class="fas fa-star me-2 text-warning"></i> Testimonial
        </a>
        <a href="manage-faq.php" class="nav-link text-white py-3 px-4 mb-1 rounded-3 <?php echo ($current_page == 'manage-faq.php') ? 'bg-primary active' : ''; ?>">
            <i class="fas fa-question-circle me-2 text-danger"></i> Faq
        </a>

        <hr class="border-secondary my-2">

        <!-- 📞 Support & Policies -->
        <a href="manage-contact.php" class="nav-link text-white py-3 px-4 mb-1 rounded-3 <?php echo ($current_page == 'manage-contact.php') ? 'bg-primary active' : ''; ?>">
            <i class="fas fa-address-book me-2 text-success"></i> Contact
        </a>
        <a href="manage-terms.php" class="nav-link text-white py-3 px-4 mb-1 rounded-3 <?php echo ($current_page == 'manage-terms.php') ? 'bg-primary active' : ''; ?>">
            <i class="fas fa-file-contract me-2 text-muted"></i> Terms Services
        </a>
        <a href="manage-management.php" class="nav-link text-white py-3 px-4 mb-1 rounded-3 <?php echo ($current_page == 'manage-management.php') ? 'bg-primary active' : ''; ?>">
            <i class="fas fa-users-cog me-2 text-primary"></i> Our Management
        </a>

        <!-- 📝 Test Preparation Modular Dropdown -->
        <div class="nav-item mt-2">
            <a class="nav-link text-white py-3 px-4 d-flex justify-content-between align-items-center <?php echo in_array($current_page, $testPrepModules) ? '' : 'collapsed'; ?>" data-bs-toggle="collapse" href="#testPrepMenu">
                <span><i class="fas fa-file-alt me-2 text-danger"></i> Test Preparation</span>
                <i class="fas fa-chevron-down small"></i>
            </a>
            <div class="collapse ps-3 <?php echo in_array($current_page, $testPrepModules) ? 'show' : ''; ?>" id="testPrepMenu">
                <?php foreach($testPrepLabels as $tp): 
                    $file = "manage-" . $tp . ".php";
                ?>
                    <a href="<?php echo $file; ?>" class="nav-link py-1 small <?php echo ($current_page == $file) ? 'text-primary fw-bold' : 'text-white-50'; ?>">
                        <i class="fas fa-caret-right me-1" style="font-size: 10px;"></i> <?php echo strtoupper($tp); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- 🚪 Logout -->
        <div class="mt-4 mb-5 pt-3 border-top border-secondary">
            <a href="logout.php" class="nav-link text-danger py-3 px-4 fw-bold">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </a>
        </div>
    </div>
</div>

<style>
.custom-sidebar {
    width: 260px; min-width: 260px;
    background: #0e1d3e !important;
    position: sticky; top: 0; height: 100vh;
    overflow-y: auto;
}
.custom-sidebar::-webkit-scrollbar { width: 4px; }
.custom-sidebar::-webkit-scrollbar-thumb { background: #305CDE; }

.admin-nav-links .nav-link { transition: 0.2s; font-size: 13px; margin-bottom: 2px; }
.admin-nav-links .nav-link:hover { background: rgba(255,255,255,0.05); transform: translateX(3px); }
.admin-nav-links .nav-link.active { background-color: #305CDE !important; color: white !important; opacity: 1; }

.nav-link.collapsed .fas.fa-chevron-down { transform: rotate(0deg); transition: 0.3s; }
.nav-link:not(.collapsed) .fas.fa-chevron-down { transform: rotate(180deg); transition: 0.3s; }
</style>