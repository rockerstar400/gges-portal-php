<?php 
require_once 'functions.php';

// 1. URL se ID fetch karein (?id=XX)
$blog_id = $_GET['id'] ?? null;

if (!$blog_id) {
    header("Location: blog.php");
    exit();
}

// 2. Database se specific blog data layein
$blog = getBlogById($blog_id);

include('includes/header.php'); 
include('includes/navbar.php'); 
?>

<div class="blog-detail-wrapper py-5 px-4" style="background-image: url('assets/images/work-bg.png'); background-size: contain; background-position: center; background-color: #F0F8FF; min-height: 100vh;">
    
    <div class="container max-w-1000">
        
        <?php if($blog): ?>
        <!-- 3D Animated Card Container -->
        <div class="detail-card bg-white-glass shadow-2xl rounded-5 p-4 p-md-5 animate-fade-up">
            
            <!-- Back Button (React navigate(-1) jaisa) -->
            <a href="javascript:history.back()" class="btn-back d-inline-flex align-items-center gap-2 mb-4 text-decoration-none fw-bold">
                <i class="fas fa-chevron-left"></i> Back
            </a>

            <!-- Media Section (Image or Video) -->
            <div class="media-container rounded-4 shadow-lg mb-5 overflow-hidden">
                <?php if($blog['type'] == 'image'): ?>
                    <img src="<?php echo $blog['image']; ?>" class="w-100 detail-img" alt="Blog Media">
                <?php elseif($blog['type'] == 'video'): ?>
                    <video src="<?php echo $blog['video']; ?>" controls class="w-100 detail-video"></video>
                <?php endif; ?>
            </div>

            <!-- Content Section -->
            <div class="content-section">
                <!-- Title -->
                <h1 class="display-4 fw-extrabold text-dark mb-4 leading-tight">
                    <?php echo $blog['title']; ?>
                </h1>

                <!-- Body (CKEditor HTML content) -->
                <div class="blog-rich-text fs-5 text-secondary mb-5">
                    <?php echo $blog['description']; ?>
                </div>

                <!-- Date & Meta -->
                <div class="meta-footer border-top pt-4 mt-5">
                    <p class="text-muted fw-medium m-0">
                        <i class="far fa-calendar-check me-2 text-primary"></i>
                        <?php 
                            // Professional Indian Date Formatting
                            echo date("l, d F Y, h:i A", strtotime($blog['created_at'])); 
                        ?>
                    </p>
                </div>
            </div>

        </div>
        <?php else: ?>
            <div class="alert alert-danger text-center py-5 rounded-4 shadow">
                <h3 class="fw-bold">Blog Not Found</h3>
                <p>The post you are looking for might have been removed.</p>
                <a href="blog.php" class="btn btn-primary px-4">Browse Blogs</a>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php include('includes/footer.php'); ?>