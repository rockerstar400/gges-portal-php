<?php 
require_once 'includes/auth_check.php';
require_once '../functions.php';
$testimonials = getAll('testimonials'); // functions.php se data laya
include('includes/header.php'); 
include('includes/sidebar.php'); 
?>

<div class="content-area">
    <!-- Breadcrumbs -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold m-0">Testimonial</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb m-0 small">
                <li class="breadcrumb-item"><a href="dashboard.php" class="text-decoration-none text-muted">Home</a></li>
                <li class="breadcrumb-item active fw-bold text-dark" aria-current="page">Testimonial</li>
            </ol>
        </nav>
    </div>

    <!-- Main Card -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-bottom py-3">
            <h6 class="fw-bold m-0 text-muted">Testimonial</h6>
        </div>
        <div class="card-body p-4">
            <!-- Add Button -->
            <button class="btn btn-primary px-4 py-2 rounded-3 fw-bold mb-4 shadow-blue" data-bs-toggle="modal" data-bs-target="#testimonialModal">
                + Add About
            </button>

            <!-- Table -->
            <!-- <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0">Photo</th>
                            <th class="border-0">Name</th>
                            <th class="border-0">Address</th>
                            <th class="border-0 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($testimonials): foreach($testimonials as $t): ?>
                        <tr>
                            <td>
                                <img src="../<?php echo $t['image']; ?>" class="rounded-circle shadow-sm" width="50" height="50" style="object-fit: cover;">
                            </td>
                            <td class="fw-bold text-dark"><?php echo $t['title']; ?></td>
                            <td class="text-muted small"><?php echo $t['address']; ?></td>
                            <td class="text-end">
                                <a href="../api/admin/manage-testimonial.php?action=delete&id=<?php echo $t['id']; ?>" 
                                   class="btn btn-outline-danger btn-sm rounded-3 px-3" 
                                   onclick="return confirm('Delete this testimonial?')">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">No testimonials found</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div> -->
            <!-- Table -->
<div class="table-responsive">
    <table class="table align-middle">
        <thead class="table-light">
            <tr>
                <th class="border-0 ps-4">Photo</th>
                <th class="border-0">Name</th>
                <th class="border-0">Description</th> <!-- Naya Column -->
                <th class="border-0">Address</th>
                <th class="border-0 text-end pe-4">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if($testimonials): foreach($testimonials as $t): ?>
            <tr>
                <td class="ps-4">
                    <img src="../<?php echo $t['image']; ?>" class="rounded-circle shadow-sm" width="50" height="50" style="object-fit: cover;">
                </td>
                <td class="fw-bold text-dark"><?php echo $t['title']; ?></td>
                
                <!-- Description Logic: Sirf pehle 50 words dikhayenge -->
                <td class="text-muted small">
                    <div style="max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        <?php echo strip_tags($t['description']); ?>
                    </div>
                </td>

                <td class="text-muted small"><?php echo $t['address']; ?></td>
                <td class="text-end pe-4">
                    <a href="../api/admin/manage-testimonial.php?action=delete&id=<?php echo $t['id']; ?>" 
                       class="btn btn-outline-danger btn-sm rounded-3 px-3" 
                       onclick="return confirm('Delete this testimonial?')">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; else: ?>
            <tr>
                <td colspan="5" class="text-center py-5 text-muted">No testimonials found</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
        </div>
    </div>
</div>

<!-- --- ADD NEW MODAL (As per Screenshot) --- -->
<div class="modal fade" id="testimonialModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Add About</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../api/admin/manage-testimonial.php?action=add" method="POST" enctype="multipart/form-data">
                <div class="modal-body p-4">
                    
                    
                    <div class="mb-3">
                        <label for="testImg" class="upload-box-dashed w-100">
                            <input type="file" name="image" id="testImg" hidden onchange="previewImg(this)" required>
                            <div class="text-center py-3" id="upPlaceholder">
                                <i class="fas fa-cloud-upload-alt text-primary fa-2x mb-2"></i>
                                <p class="small fw-bold text-dark m-0">Click to Upload Image</p>
                            </div>
                            <img id="testPreview" class="d-none w-100 h-100 object-fit-contain rounded-3">
                        </label>
                    </div>

                    <div class="mb-3">
                        <input type="text" name="title" class="form-control custom-input" placeholder="Enter Name" required>
                    </div>

                  
                    <div class="mb-3">
                        <textarea name="description" class="form-control custom-input" rows="4" placeholder="Enter description" required></textarea>
                    </div>

                   
                    <div class="mb-4">
                        <input type="text" name="address" class="form-control custom-input" placeholder="Enter address" required>
                    </div>

                  
                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-bold shadow-blue">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Exact UI match with screenshot */
.upload-box-dashed {
    border: 2px dashed #305CDE;
    border-radius: 12px;
    background: #fcfdff;
    cursor: pointer;
    min-height: 110px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
}
.custom-input {
    border: 1px solid #e0e6ed;
    border-radius: 10px;
    padding: 12px 15px;
    font-size: 15px;
}
.custom-input:focus { border-color: #305CDE; box-shadow: none; }
.shadow-blue { box-shadow: 0 10px 20px rgba(48, 92, 222, 0.2) !important; }
</style>

<script>
    function previewImg(input) {
        const preview = document.getElementById('testPreview');
        const placeholder = document.getElementById('upPlaceholder');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                placeholder.classList.add('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<?php include('includes/footer.php'); ?>