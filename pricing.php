<?php 
require_once 'functions.php'; // 1. Logic Layer include karein
$pricing_list = getPricing(); // 2. Database se real plans fetch karein

include('includes/header.php'); 
include('includes/navbar.php'); 
?>

<div class="pricing-page-wrapper py-5 position-relative" style="background-image: url('assets/images/price-bg.png'); background-size: contain; background-color: #F0F8FF;">
    
    <div class="container py-5 relative">
        <!-- Main Heading (Static UI) -->
        <h1 class="text-center fw-bold display-4 mb-5 animate-up">OUR PRICING</h1>

        <!-- Vertical Divider Line (Desktop only) -->
        <div class="vertical-divider d-none d-lg-block">
            <img src="assets/images/divider-line.png" alt="line">
        </div>

        <!-- Pricing Rows (Now Dynamic) -->
        <?php if(!empty($pricing_list)): foreach($pricing_list as $index => $plan): ?>
            <?php 
                $isEven = ($index % 2 !== 0); 
                // JSON string ko array mein badlein (Nested fees handle karne ke liye)
                $feesArray = json_decode($plan['fees'], true);
            ?>
            
            <div class="row align-items-center mb-5 pb-5 position-relative z-index-10">
                
                <!-- Image Column -->
                <div class="col-lg-6 mb-4 mb-lg-0 <?php echo $isEven ? 'order-lg-2' : 'order-lg-1'; ?>">
                    <div class="pricing-img-container text-center animate-side-<?php echo $isEven ? 'right' : 'left'; ?>">
                        <!-- Image path from DB -->
                        <img src="<?php echo $plan['image']; ?>" 
                             class="img-fluid rounded-4 shadow-lg pricing-float-img" 
                             alt="<?php echo $plan['planName']; ?>"
                             onerror="this.src='assets/images/pricing1.png'">
                    </div>
                </div>

                <!-- Table Column -->
                <div class="col-lg-6 <?php echo $isEven ? 'order-lg-1' : 'order-lg-2'; ?>">
                    <div class="pricing-table-card bg-white p-4 p-md-5 rounded-4 shadow-sm border animate-side-<?php echo $isEven ? 'left' : 'right'; ?>">
                        <div class="table-responsive">
                            <table class="table table-borderless align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="ps-0 pb-4">
                                            <span class="text-muted small fw-bold text-uppercase">Plan Name</span>
                                            <div class="mt-2">
                                                <span class="badge-rose px-3 py-2 rounded-3 fw-bold h5 mb-0">
                                                    <?php echo $plan['planName']; ?>
                                                </span>
                                            </div>
                                        </th>
                                        <th class="text-center pb-4">
                                            <span class="text-muted small fw-bold d-block mb-2">Classes</span>
                                            <span class="btn btn-primary btn-sm rounded-2 px-3 fw-bold no-pointer">
                                                <?php echo $plan['className']; ?>
                                            </span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="border-top">
                                    <!-- Nested Fees Loop (Dynamic) -->
                                    <?php if($feesArray): foreach($feesArray as $fee): ?>
                                    <tr class="border-bottom">
                                        <td class="py-3 fw-medium text-dark"><?php echo $fee['label']; ?></td>
                                        <td class="py-3 text-center text-muted"><?php echo $fee['price']; ?></td>
                                    </tr>
                                    <?php endforeach; endif; ?>
                                    
                                    <!-- Static Labels with Dynamic Values -->
                                    <tr class="border-bottom">
                                        <td class="py-3 fw-medium text-dark">Fees Per Hour</td>
                                        <td class="py-3 text-center text-muted"><?php echo $plan['feesPerHour']; ?></td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="py-3 fw-medium text-dark">Saving In Offers</td>
                                        <td class="py-3 text-center text-success fw-bold"><?php echo $plan['off']; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        <?php endforeach; else: ?>
            <div class="col-12 text-center py-5">
                <p class="text-muted">No pricing plans found. Please check back later.</p>
            </div>
        <?php endif; ?>

        <!-- Bottom Decorations -->
        <div class="text-center my-5">
            <img src="assets/images/dotted.png" class="img-fluid opacity-50" alt="dots">
        </div>

        <!-- Final CTA -->
        <div class="text-center">
            <a href="contact.php" class="btn btn-primary btn-lg px-5 py-3 rounded-3 fw-bold shadow-blue hover-up">
                Get Started <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>

    </div>
</div>

<?php include('includes/footer.php'); ?>