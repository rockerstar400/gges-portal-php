<?php 
require_once 'functions.php';
include('includes/header.php'); 
include('includes/navbar.php');  // Navbar aur Dynamic Banner yahan se aayega
?>

<div class="bg-light py-5">
    <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold display-5 text-dark">All Offers & News</h2>
            <p class="text-muted fs-5">Stay updated with everything happening at GGES</p>
            <div class="mx-auto bg-primary rounded" style="width: 70px; height: 4px;"></div>
        </div>

        <div class="row g-4">
            <?php 
            $all_offers = getOffers(); // Saare offers fetch karega
            if($all_offers): foreach($all_offers as $offer): 
            ?>
            <div class="col-md-4" data-aos="zoom-in">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4 bg-white transition-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge rounded-pill px-3 py-2 text-uppercase" style="background: #EBF8FF; color: #305CDE; font-size: 10px; font-weight: 700;">
                            <?php echo $offer['type']; ?>
                        </span>
                        <small class="text-muted"><?php echo date('M d, Y', strtotime($offer['created_at'])); ?></small>
                    </div>
                    <h4 class="fw-bold mb-3"><?php echo $offer['title']; ?></h4>
                    <p class="text-muted small mb-4">
                        <?php echo getShortText($offer['description'], 120); ?>
                    </p>
                    <a href="offer-detail.php?id=<?php echo $offer['id']; ?>" class="btn w-100 py-2 fw-bold rounded-3" style="background: #F8FAFC; color: #305CDE;">
                        View Full Details →
                    </a>
                </div>
            </div>
            <?php endforeach; else: ?>
                <div class="col-12 text-center py-5">
                    <p class="text-muted">No updates available at the moment.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>