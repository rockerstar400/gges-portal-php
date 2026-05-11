<?php 
require_once 'functions.php';
include('includes/header.php'); 
include('includes/navbar.php'); 

// URL se ID pakadna
$offer_id = $_GET['id'] ?? 0;
$offer = getOfferById($offer_id); // Functions.php mein ye function pehle se hai

if(!$offer) {
    echo "<div class='container text-center py-5'><h2>Update not found!</h2><a href='offer-list.php'>Back to Updates</a></div>";
    include 'includes/footer.php';
    exit;
}
?>

<div class="bg-white py-5">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <!-- Navigation -->
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="offer-list.php">Offers</a></li>
                        <li class="breadcrumb-item active"><?php echo $offer['type']; ?></li>
                    </ol>
                </nav>

                <!-- Full Content -->
                <div class="detail-card p-4 p-md-5 rounded-5 shadow-sm border border-light">
                    <div class="mb-4">
                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill text-uppercase fw-bold mb-3" style="font-size: 12px;">
                            <?php echo $offer['type']; ?>
                        </span>
                        <h1 class="display-4 fw-bold text-dark mb-3"><?php echo $offer['title']; ?></h1>
                        <p class="text-muted fw-bold">Published on: <?php echo date('F d, Y', strtotime($offer['created_at'])); ?></p>
                    </div>

                    <hr class="my-5 border-light">

                    <div class="offer-full-description fs-5 text-secondary lh-lg" style="white-space: pre-line;">
                        <?php echo $offer['description']; ?>
                    </div>

                    <?php if($offer['expireDate']): ?>
                    <div class="mt-5 p-4 rounded-4 bg-light border-start border-primary border-4">
                        <h5 class="fw-bold text-dark"><i class="far fa-clock me-2"></i> Valid Till:</h5>
                        <p class="mb-0 text-danger fw-bold"><?php echo date('F d, Y', strtotime($offer['expireDate'])); ?></p>
                    </div>
                    <?php endif; ?>

                    <div class="mt-5 pt-4">
                        <a href="contact.php" class="btn btn-primary px-5 py-3 rounded-pill fw-bold shadow-lg">
                            Apply Now / Contact Counselor
                        </a>
                        <a href="offer-list.php" class="btn btn-link text-muted ms-3">Back to all updates</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>