<?php 
require_once 'functions.php'; // Logic include karein

// 1. Database se Website ki Contact details fetch karein
global $conn;
$stmt = $conn->query("SELECT * FROM contact_info LIMIT 1");
$contactData = $stmt->fetch();

// Fallback agar database khali ho
if (!$contactData) {
    $contactData = [
        "description" => "Have questions or need assistance? Reach out to us.",
        "mobile" => "+91-886-029-6060",
        "email" => "info@mygges.com",
        "address" => "New Delhi, India"
    ];
}

include('includes/header.php'); 
include('includes/navbar.php'); 
?>

<!-- Google reCAPTCHA Script -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<div class="contact-page-wrapper py-5 px-4" style="background-color: #F0F8FF; min-height: 90vh;">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            
            <!-- LEFT SIDE: Info (Dynamic) -->
            <div class="col-lg-6 animate-side-left">
                <h6 class="text-primary fw-bold tracking-widest mb-2 uppercase">Contact Us</h6>
                <h1 class="display-4 fw-extrabold text-navy mb-4">Get In Touch With Us</h1>
                <p class="text-secondary fs-5 mb-5 leading-relaxed">
                    <?php echo $contactData['description']; ?>
                </p>

                <div class="contact-details space-y-4">
                    <div class="d-flex align-items-center gap-4 mb-4 contact-hover-item">
                        <div class="icon-circle shadow-sm">
                            <i class="fas fa-phone-alt text-primary"></i>
                        </div>
                        <span class="fs-5 fw-medium text-dark"><?php echo $contactData['mobile']; ?></span>
                    </div>

                    <div class="d-flex align-items-center gap-4 mb-4 contact-hover-item">
                        <div class="icon-circle shadow-sm">
                            <i class="fas fa-envelope text-primary"></i>
                        </div>
                        <span class="fs-5 fw-medium text-dark"><?php echo $contactData['email']; ?></span>
                    </div>

                    <div class="d-flex align-items-start gap-4 contact-hover-item">
                        <div class="icon-circle shadow-sm">
                            <i class="fas fa-map-marker-alt text-primary"></i>
                        </div>
                        <span class="fs-5 fw-medium text-dark">
                            <?php echo $contactData['address']; ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- RIGHT SIDE: Form (AJAX Powered) -->
            <div class="col-lg-6">
                <div class="contact-form-card bg-white p-4 p-md-5 rounded-4 shadow-xl border-0 animate-side-right">
                    
                    <!-- Status Messages (Success/Error) -->
                    <div id="formResponse" class="mb-3"></div>

                    <form id="contactForm">
                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary">Your Name</label>
                            <input type="text" name="name" class="form-control custom-input" placeholder="Enter your name" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary">Email Address</label>
                            <input type="email" name="email" class="form-control custom-input" placeholder="Your email address" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary">Phone Number</label>
                            <input type="text" name="mobile" class="form-control custom-input" placeholder="Your phone number" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary">Message</label>
                            <textarea name="message" rows="4" class="form-control custom-input" placeholder="Write your message..." required></textarea>
                        </div>

                        <!-- reCAPTCHA Widget -->
                        <div class="mb-4">
                            <div class="g-recaptcha" data-sitekey="6LcmQmosAAAAANuF15kEyBUsYp020Ywy9nrbMyje"></div>
                        </div>

                        <button type="submit" id="submitBtn" class="btn btn-primary w-100 py-3 rounded-3 fw-bold shadow-blue hover-scale">
                            Send Message
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- AJAX Form Handling (Industry Standard) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#contactForm').on('submit', function(e) {
        e.preventDefault();
        
        // Button loading state
        $('#submitBtn').attr('disabled', true).text('Sending...');
        
        $.ajax({
            // url: 'api/public/contact-submit.php', // API Path
            // method: 'POST',
             url: 'https://api.mygges.com/public/contact-submit.php', // Static URL ki jagah sub-domain URL
    method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if(response.success) {
                    $('#formResponse').html(`<div class="alert alert-success border-0 shadow-sm">${response.message}</div>`);
                    $('#contactForm')[0].reset();
                    grecaptcha.reset(); // Captcha reset
                } else {
                    $('#formResponse').html(`<div class="alert alert-danger border-0 shadow-sm">${response.message}</div>`);
                }
            },
            error: function() {
                $('#formResponse').html(`<div class="alert alert-danger">Error: Something went wrong.</div>`);
            },
            complete: function() {
                $('#submitBtn').attr('disabled', false).text('Send Message');
            }
        });
    });
});
</script>

<?php include('includes/footer.php'); ?>