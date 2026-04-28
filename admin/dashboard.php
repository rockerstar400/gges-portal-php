<?php 
require_once 'includes/auth_check.php'; 
require_once '../functions.php';

// Stats logic (Same as before)
global $conn;
$banner_count = $conn->query("SELECT COUNT(*) FROM banners")->fetchColumn();
$blog_count = $conn->query("SELECT COUNT(*) FROM blogs")->fetchColumn();
$query_count = $conn->query("SELECT COUNT(*) FROM contact_queries")->fetchColumn();
$pricing_count = $conn->query("SELECT COUNT(*) FROM pricing")->fetchColumn();

include('includes/header.php'); // Wrapper Start 
include('includes/sidebar.php'); // Sidebar on the left
?>

<!-- Main Content Area -->
<div class="content-area">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Welcome, <?php echo $_SESSION['admin_user']; ?>! 👋</h2>
        <span class="text-muted"><?php echo date('D, d M Y'); ?></span>
    </div>

    <!-- Stats Cards (Banner, Blog, etc.) -->
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card p-3 bg-primary text-white">
                <div class="d-flex align-items-center">
                    <i class="fas fa-image fa-2x opacity-50 me-3"></i>
                    <div><h6 class="mb-0 small">Banners</h6><h3 class="fw-bold mb-0"><?php echo $banner_count; ?></h3></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 bg-success text-white">
                <div class="d-flex align-items-center">
                    <i class="fas fa-blog fa-2x opacity-50 me-3"></i>
                    <div><h6 class="mb-0 small">Blogs</h6><h3 class="fw-bold mb-0"><?php echo $blog_count; ?></h3></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 bg-warning text-white">
                <div class="d-flex align-items-center">
                    <i class="fas fa-envelope fa-2x opacity-50 me-3"></i>
                    <div><h6 class="mb-0 small">Queries</h6><h3 class="fw-bold mb-0"><?php echo $query_count; ?></h3></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 bg-info text-white">
                <div class="d-flex align-items-center">
                    <i class="fas fa-tags fa-2x opacity-50 me-3"></i>
                    <div><h6 class="mb-0 small">Price Plans</h6><h3 class="fw-bold mb-0"><?php echo $pricing_count; ?></h3></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Inquiries Table -->
    <div class="mt-5">
        <h4 class="fw-bold mb-4">Recent Inquiries</h4>
        <div class="card p-4">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr><th>Name</th><th>Email</th><th>Mobile</th><th>Date</th></tr>
                </thead>
                <tbody>
                    <?php 
                    $queries = getLatest('contact_queries', 5);
                    if($queries): foreach($queries as $q): ?>
                    <tr>
                        <td><?php echo $q['name']; ?></td>
                        <td><?php echo $q['email']; ?></td>
                        <td><?php echo $q['mobile']; ?></td>
                        <td><?php echo date('d M', strtotime($q['created_at'])); ?></td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr><td colspan="4" class="text-center">No inquiries yet.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>