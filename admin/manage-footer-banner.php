<?php 
require_once 'includes/auth_check.php';
require_once '../functions.php';
$banner = getFooterBanner();
include('includes/header.php'); 
include('includes/sidebar.php'); 
?>

<div class="content-area">
    <!-- Breadcrumbs -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold m-0">Footer Banner</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb m-0 small">
                <li class="breadcrumb-item"><a href="dashboard.php" class="text-decoration-none text-muted">Home</a></li>
                <li class="breadcrumb-item active fw-bold text-dark">Footer Banner</li>
            </ol>
        </nav>
    </div>

    <!-- Main Card -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-bottom py-3">
            <h6 class="fw-bold m-0 text-muted">Footer Banner</h6>
        </div>
        
        <div class="card-body p-4 p-lg-5">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <h4 class="text-center fw-bold mb-4">Footer Banner Settings</h4>
                    
                    <form action="../api/admin/manage-footer-banner.php" method="POST" enctype="multipart/form-data">
                        
                        <!-- Title -->
                        <div class="mb-4">
                            <input type="text" name="title" class="form-control custom-input" 
                                   placeholder="Ready to Start Your Learning Journey?" 
                                   value="<?php echo $banner['title'] ?? ''; ?>" required>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <textarea name="description" class="form-control custom-input" rows="3" 
                                      placeholder="Enter description..." required><?php echo $banner['description'] ?? ''; ?></textarea>
                        </div>

                        <!-- Dashed Upload Box -->
                        <div class="mb-4">
                            <label for="footerImg" class="upload-box-dashed w-100">
                                <input type="file" name="image" id="footerImg" hidden onchange="previewImg(this)">
                                <div class="text-center py-3" id="upPlaceholder">
                                    <i class="fas fa-cloud-upload-alt text-primary fa-2x mb-2"></i>
                                    <p class="small fw-bold text-dark m-0">Click to Upload Image</p>
                                </div>
                                <img id="footerPreview" src="../<?php echo $banner['image'] ?? ''; ?>" 
                                     class="img-preview <?php echo !empty($banner['image']) ? '' : 'd-none'; ?>">
                            </label>
                        </div>

                        <!-- Save Button -->
                        <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-bold shadow-blue">
                            Save Banner
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.custom-input { border: 1px solid #e0e6ed; border-radius: 10px; padding: 12px 15px; font-size: 15px; }
.upload-box-dashed { border: 2px dashed #305CDE; border-radius: 12px; background: #fcfdff; cursor: pointer; min-height: 100px; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; }
.img-preview { position: relative; width: 100%; max-height: 300px; object-fit: cover; border-radius: 10px; }
.shadow-blue { box-shadow: 0 10px 20px rgba(48, 92, 222, 0.2) !important; }
</style>

<script>
function previewImg(input) {
    const preview = document.getElementById('footerPreview');
    const placeholder = document.getElementById('upPlaceholder');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
            placeholder.classList.add('d-none');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?php include('includes/footer.php'); ?>