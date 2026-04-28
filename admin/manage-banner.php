<?php 
require_once 'includes/auth_check.php';
require_once '../functions.php';
$banner = getBanner(); // Purana data pre-fill karne ke liye
include('includes/header.php'); 
include('includes/sidebar.php'); 
?>

<div class="content-area">
    <!-- Breadcrumbs Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold m-0">Banner</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb m-0 small">
                <li class="breadcrumb-item"><a href="dashboard.php" class="text-decoration-none text-muted">Home</a></li>
                <li class="breadcrumb-item active fw-bold text-dark" aria-current="page">Banner</li>
            </ol>
        </nav>
    </div>

    <!-- Main Card Container -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-bottom py-3">
            <h6 class="fw-bold m-0 text-muted">Banner</h6>
        </div>
        
        <div class="card-body p-4 p-lg-5">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <form action="../api/admin/manage-banner.php" method="POST" enctype="multipart/form-data">
                        
                        <!-- Title Input -->
                        <div class="mb-4">
                            <input type="text" name="title" class="form-control custom-input" 
                                   placeholder="Enter title" value="<?php echo $banner['title'] ?? ''; ?>" required>
                        </div>

                        <!-- Description Input -->
                        <div class="mb-4">
                            <textarea name="description" class="form-control custom-input" rows="5" 
                                      placeholder="Enter description" required><?php echo $banner['description'] ?? ''; ?></textarea>
                        </div>

                        <!-- Upload Area (Dashed Box) -->
                        <div class="mb-4">
                            <label for="bannerImg" class="upload-box w-100" id="dropArea">
                                <input type="file" name="image" id="bannerImg" hidden onchange="previewImage(this)">
                                <div class="upload-content text-center py-4">
                                    <div class="icon-circle-blue mx-auto mb-3">
                                        <i class="fas fa-cloud-upload-alt text-primary fa-2x"></i>
                                    </div>
                                    <p class="m-0 fw-bold text-dark" id="fileName">Upload Image</p>
                                    <small class="text-muted">Max size: 2MB (JPG, PNG)</small>
                                </div>
                                <!-- Image Preview Area -->
                                <img id="preview" src="../<?php echo $banner['image'] ?? ''; ?>" 
                                     class="img-preview <?php echo !empty($banner['image']) ? '' : 'd-none'; ?>">
                            </label>
                        </div>

                        <!-- Save Button -->
                        <div class="mt-5">
                            <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-bold fs-5 shadow-blue">
                                Save Banner
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Preview -->
<script>
function previewImage(input) {
    const preview = document.getElementById('preview');
    const fileName = document.getElementById('fileName');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
            fileName.innerText = input.files[0].name;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?php include('includes/footer.php'); ?>