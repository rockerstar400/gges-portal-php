<?php 

$current_page = basename($_SERVER['PHP_SELF']);

// Groups for active state logic
$mathsPages = [
    'manage-math-common.php', 
    'manage-math-algebra.php', 
    'manage-math-geometry.php', 
    'manage-math-amc.php', 
    'manage-math-kangaroo.php', 
    'manage-math-science.php'
];
// $mathsPages = ['manage-math-common.php', 'manage-math-algebra.php', 'manage-math-geometry.php', 'manage-math-amc.php', 'manage-math-kangaroo.php', 'manage-math-science.php'];
$englishPages = ['manage-eng-common.php', 'manage-eng-ela.php', 'manage-eng-about-ela.php', 'manage-eng-isee.php', 'manage-eng-reg.php'];

// 14 Modular Test Prep Files Mapping
$testPrepModules = [
    'sat' => 'manage-sat.php',
    'ssat' => 'manage-ssat.php',
    'psat' => 'manage-psat.php',
    'shsat' => 'manage-shsat.php',
    'isee' => 'manage-isee.php',
    'ela' => 'manage-ela.php',
    'scat' => 'manage-scat.php',
    'amc' => 'manage-amc.php',
    'kangaroo' => 'manage-kangaroo.php',
    'act' => 'manage-act.php',
    'cogat' => 'manage-cogat.php',
    'sbac' => 'manage-sbac.php',
    'accuplacer' => 'manage-accuplacer.php',
    'stb' => 'manage-stb.php'
];
$currentType = $_GET['type'] ?? '';
$maths = ['math-common-core', 'math-algebra', 'math-geometry', 'math-amc', 'math-kangaroo', 'math-science'];
$english = ['eng-common-lang', 'eng-core-ela', 'eng-about-ela', 'eng-about-isee', 'eng-registration'];
$testPrep = ['sat', 'ssat', 'psat', 'shsat', 'isee', 'ela', 'scat', 'amc', 'kangaroo', 'act', 'cogat', 'sbac', 'accuplacer', 'stb'];
$k12 = ['k12-management']; // Single page for K-12

?>

<div class="sidebar bg-dark text-white shadow-lg custom-sidebar">
    <div class="p-4 text-center border-bottom border-secondary mb-3">

        <h5 class="fw-bold text-uppercase tracking-wider m-0" style="color: #305CDE;">GGES ADMIN</h5>
        <!-- <h5 class="fw-bold text-uppercase tracking-wider m-0">GGES ADMIN</h5> -->

    </div>

    <div class="nav flex-column px-2 admin-nav-links">
        
        <!-- 🏠 Dashboard -->
        <a href="dashboard.php" class="nav-link text-white py-3 px-4 mb-1 rounded-3 <?php echo ($current_page == 'dashboard.php') ? 'bg-primary active' : ''; ?>">
            <i class="fas fa-tachometer-alt me-2 text-info"></i> Dashboard
        </a>

        <!-- 🖼️ Banners -->
        <div class="small text-uppercase px-4 mt-3 mb-1 text-muted fw-bold" style="font-size: 10px;">Media & Layout</div>
        <a href="manage-banner.php" class="nav-link text-white py-2 px-4 mb-1 rounded-3 <?php echo ($current_page == 'manage-banner.php') ? 'bg-primary active' : ''; ?>">
            <i class="fas fa-image me-2"></i> Hero Banner
        </a>
        <a href="manage-footer-banner.php" class="nav-link text-white py-2 px-4 mb-1 rounded-3 <?php echo ($current_page == 'manage-footer-banner.php') ? 'bg-primary active' : ''; ?>">
            <i class="fas fa-chalkboard me-2"></i> Footer Banner
        </a>

        <!-- ℹ️ General Content -->
        <div class="small text-uppercase px-4 mt-3 mb-1 text-muted fw-bold" style="font-size: 10px;">Company Info</div>
        <a href="manage-why-choose.php" class="nav-link text-white py-2 px-4 mb-1 rounded-3 <?php echo ($current_page == 'manage-why-choose.php') ? 'bg-primary active' : ''; ?>">
            <i class="fas fa-check-circle me-2"></i> Why Choose Us
        </a>
        <a href="manage-about.php" class="nav-link text-white py-2 px-4 mb-1 rounded-3 <?php echo ($current_page == 'manage-about.php') ? 'bg-primary active' : ''; ?>">
            <i class="fas fa-info-circle me-2"></i> About Us
        </a>
        <a href="manage-management.php" class="nav-link text-white py-2 px-4 mb-1 rounded-3 <?php echo ($current_page == 'manage-management.php') ? 'bg-primary active' : ''; ?>">
            <i class="fas fa-users me-2"></i> Management
        </a>

        <!-- 📝 TEST PREPARATION (The Core Modular Section) -->
        <div class="small text-uppercase px-4 mt-3 mb-1 text-danger fw-bold" style="font-size: 10px;">Test Preparation</div>
        <div class="nav-item">
            <a class="nav-link text-white py-3 px-4 d-flex justify-content-between align-items-center <?php echo in_array($current_page, $testPrepModules) ? '' : 'collapsed'; ?>" data-bs-toggle="collapse" href="#testPrepMenu">
                <span><i class="fas fa-file-alt me-2 text-danger"></i> Exams Management</span>
                <i class="fas fa-chevron-down small"></i>
            </a>
            <div class="collapse ps-3 <?php echo in_array($current_page, $testPrepModules) ? 'show' : ''; ?>" id="testPrepMenu">
                <?php foreach($testPrepModules as $label => $file): ?>
                    <a href="<?php echo $file; ?>" class="nav-link py-1 small <?php echo ($current_page == $file) ? 'text-primary fw-bold' : 'text-white-50'; ?>">
                        <i class="fas fa-caret-right me-1" style="font-size: 10px;"></i> <?php echo strtoupper($label); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <hr class="border-secondary my-3">

        <!-- 📐 MATHS -->
        <!-- <div class="nav-item">
            <a class="nav-link text-white py-3 px-4 d-flex justify-content-between align-items-center <?php echo in_array($current_page, $mathsPages) ? '' : 'collapsed'; ?>" data-bs-toggle="collapse" href="#mathMenu">
                <span><i class="fas fa-calculator me-2 text-info"></i> Maths</span>
                <i class="fas fa-chevron-down small"></i>
            </a>
            <div class="collapse ps-3 <?php echo in_array($current_page, $mathsPages) ? 'show' : ''; ?>" id="mathMenu">
                <a href="manage-math-common.php" class="nav-link py-2 small <?php echo ($current_page=='manage-math-common.php')?'text-primary fw-bold':'text-white-50'; ?>">Common Math</a>
                <a href="manage-math-algebra.php" class="nav-link py-2 small <?php echo ($current_page=='manage-math-algebra.php')?'text-primary fw-bold':'text-white-50'; ?>">Algebra</a>
                <a href="manage-math-amc.php" class="nav-link py-2 small <?php echo ($current_page=='manage-math-amc.php')?'text-primary fw-bold':'text-white-50'; ?>">Math AMC</a>
            </div>
        </div> -->

        <!-- 📐 MATHS CATEGORY -->
<div class="nav-item">
    <a class="nav-link text-white py-3 px-4 d-flex justify-content-between align-items-center <?php echo in_array($current_page, $mathsPages) ? '' : 'collapsed'; ?>" data-bs-toggle="collapse" href="#mathMenu">
        <span><i class="fas fa-calculator me-2 text-info"></i> Maths Management</span>
        <i class="fas fa-chevron-down small"></i>
    </a>
    <div class="collapse ps-3 <?php echo in_array($current_page, $mathsPages) ? 'show' : ''; ?>" id="mathMenu">
        
        <a href="manage-math-common.php" class="nav-link py-2 small <?php echo ($current_page=='manage-math-common.php')?'text-primary fw-bold':'text-white-50'; ?>">
            <i class="fas fa-caret-right me-1" style="font-size: 10px;"></i> Common Core Math
        </a>
        
        <a href="manage-math-algebra.php" class="nav-link py-2 small <?php echo ($current_page=='manage-math-algebra.php')?'text-primary fw-bold':'text-white-50'; ?>">
            <i class="fas fa-caret-right me-1" style="font-size: 10px;"></i> Math Algebra
        </a>
        
        <a href="manage-math-geometry.php" class="nav-link py-2 small <?php echo ($current_page=='manage-math-geometry.php')?'text-primary fw-bold':'text-white-50'; ?>">
            <i class="fas fa-caret-right me-1" style="font-size: 10px;"></i> Geometry
        </a>
        
        <a href="manage-math-amc.php" class="nav-link py-2 small <?php echo ($current_page=='manage-math-amc.php')?'text-primary fw-bold':'text-white-50'; ?>">
            <i class="fas fa-caret-right me-1" style="font-size: 10px;"></i> Math AMC
        </a>
        
        <a href="manage-math-kangaroo.php" class="nav-link py-2 small <?php echo ($current_page=='manage-math-kangaroo.php')?'text-primary fw-bold':'text-white-50'; ?>">
            <i class="fas fa-caret-right me-1" style="font-size: 10px;"></i> Math Kangaroo
        </a>
        
        <a href="manage-math-science.php" class="nav-link py-2 small <?php echo ($current_page=='manage-math-science.php')?'text-primary fw-bold':'text-white-50'; ?>">
            <i class="fas fa-flask me-1" style="font-size: 10px;"></i> Common Core Science
        </a>
        
    </div>
</div>

        <!-- 🔤 ENGLISH MANAGEMENT -->
<div class="small text-uppercase px-4 mt-3 mb-1 text-warning fw-bold" style="font-size: 10px;">English Management</div>
<div class="nav-item">
    <a class="nav-link text-white py-3 px-4 d-flex justify-content-between align-items-center <?php echo (strpos($current_page, 'manage-eng-') !== false) ? '' : 'collapsed'; ?>" data-bs-toggle="collapse" href="#engMenu">
        <span><i class="fas fa-font me-2 text-warning"></i> English Sections</span>
        <i class="fas fa-chevron-down small"></i>
    </a>
    <div class="collapse ps-3 <?php echo (strpos($current_page, 'manage-eng-') !== false) ? 'show' : ''; ?>" id="engMenu">
        <a href="manage-eng-common.php" class="nav-link py-1 small <?php echo ($current_page=='manage-eng-common.php')?'text-primary fw-bold':'text-white-50'; ?>">Common English Lang.</a>
        <a href="manage-eng-ela.php" class="nav-link py-1 small <?php echo ($current_page=='manage-eng-ela.php')?'text-primary fw-bold':'text-white-50'; ?>">Common Core ELA</a>
        <a href="manage-eng-about-ela.php" class="nav-link py-1 small <?php echo ($current_page=='manage-eng-about-ela.php')?'text-primary fw-bold':'text-white-50'; ?>">About ELA</a>
        <a href="manage-eng-isee.php" class="nav-link py-1 small <?php echo ($current_page=='manage-eng-isee.php')?'text-primary fw-bold':'text-white-50'; ?>">About ISEE Test</a>
        <a href="manage-eng-reg.php" class="nav-link py-1 small <?php echo ($current_page=='manage-eng-reg.php')?'text-primary fw-bold':'text-white-50'; ?>">Registration</a>
    </div>
</div>

        <!-- k12 -->
<a href="manage-k12.php" class="nav-link text-white py-3 px-4 mb-1 rounded-3 <?php echo ($current_page == 'manage-k12.php') ? 'bg-primary active' : ''; ?>">
    <i class="fas fa-graduation-cap me-2 text-success"></i> K-12 Management
</a>




        <!-- 🏷️ Marketing & Others -->
        <div class="small text-uppercase px-4 mt-3 mb-1 text-muted fw-bold" style="font-size: 10px;">Marketing & Site</div>
        <a href="manage-blogs.php" class="nav-link text-white py-2 px-4 mb-1 rounded-3 <?php echo ($current_page == 'manage-blogs.php') ? 'bg-primary active' : ''; ?>">
            <i class="fas fa-newspaper me-2"></i> Blogs
        </a>
        <a href="manage-pricing.php" class="nav-link text-white py-2 px-4 mb-1 rounded-3 <?php echo ($current_page == 'manage-pricing.php') ? 'bg-primary active' : ''; ?>">
            <i class="fas fa-money-check-alt me-2"></i> Pricing
        </a>
        <a href="manage-testimonial.php" class="nav-link text-white py-2 px-4 mb-1 rounded-3 <?php echo ($current_page == 'manage-testimonial.php') ? 'bg-primary active' : ''; ?>">
            <i class="fas fa-star me-2"></i> Testimonials
        </a>

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