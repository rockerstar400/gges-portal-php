<?php 
require_once 'functions.php'; // 1. Backend functions include karein
$blogs = getBlogs();          // 2. Database se real blogs fetch karein

include('includes/header.php'); 
include('includes/navbar.php'); 

// Helper function to truncate text (Same as before)
function getShortText($text, $limit = 80) {
    $cleanText = strip_tags($text); 
    if (strlen($cleanText) > $limit) {
        return substr($cleanText, 0, $limit) . "...";
    }
    return $cleanText;
}
?>

<div class="blog-page-wrapper py-5" style="background-image: url('assets/images/work-bg.png'); background-size: contain; background-color: #F0F8FF; min-height: 100vh;">
    <div class="container py-5">
        
        <!-- Animated Heading -->
        <h1 class="text-center fw-bold mb-5 animate-up">📰 Latest Blog</h1>

        <!-- Blog Grid -->
        <div class="row g-4 justify-content-center">
            <?php if($blogs): foreach($blogs as $index => $blog): ?>
            <div class="col-lg-4 col-md-6 animate-up" style="animation-delay: <?php echo ($index * 0.2); ?>s;">
                <div class="blog-card h-100 bg-white rounded-4 shadow-sm border-0 overflow-hidden transition-card d-flex flex-column">
                    
                    <!-- Media Section (Image or Video) - Real Paths from DB -->
                    <div class="blog-media-container position-relative overflow-hidden">
                        <?php if($blog['type'] == 'image'): ?>
                            <img src="<?php echo $blog['image']; ?>" class="blog-img" alt="<?php echo $blog['title']; ?>" onerror="this.src='https://via.placeholder.com/400x250'">
                        <?php elseif($blog['type'] == 'video'): ?>
                            <video src="<?php echo $blog['video']; ?>" class="blog-video" muted loop onmouseover="this.play()" onmouseout="this.pause()"></video>
                            <div class="video-overlay"><i class="fas fa-play-circle"></i></div>
                        <?php endif; ?>
                    </div>

                    <!-- Content Section -->
                    <div class="p-4 flex-grow-1 d-flex flex-column">
                        <h3 class="fw-bold h5 mb-2 blog-title"><?php echo $blog['title']; ?></h3>
                        <p class="text-muted small mb-3">
                            <!-- Database date field 'created_at' use ki gayi hai -->
                            <i class="far fa-calendar-alt me-1"></i> <?php echo date("M d, Y", strtotime($blog['created_at'])); ?>
                        </p>
                        <p class="text-secondary flex-grow-1">
                            <?php echo getShortText($blog['description'], 90); ?>
                        </p>
                        
                        <!-- Link with Dynamic ID -->
                        <a href="blog-detail.php?id=<?php echo $blog['id']; ?>" class="btn btn-primary rounded-pill fw-bold mt-3 py-2 shadow-sm">
                            Read More <i class="fas fa-arrow-right ms-1 small"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; else: ?>
                <!-- Fallback agar koi blog na ho -->
                <div class="col-12 text-center py-5">
                    <p class="text-muted">No blogs found. Please check back later.</p>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php include('includes/footer.php'); ?>