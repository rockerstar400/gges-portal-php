<?php 
require_once 'includes/auth_check.php';
require_once '../functions.php';

// Data fetch karein
$about = getAbout();

// JSON strings ko PHP arrays mein badlein
$desc = json_decode($about['description'] ?? '[]', true);
$why_us = json_decode($about['why_us'] ?? '[]', true);
$how_diff = json_decode($about['how_different'] ?? '[]', true);
$safety = json_decode($about['safety'] ?? '[]', true);

include('includes/header.php'); 
include('includes/sidebar.php'); 
?>

<div class="content-area">
    <!-- Breadcrumbs -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold m-0">About</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb m-0 small">
                <li class="breadcrumb-item"><a href="dashboard.php" class="text-decoration-none text-muted">Home</a></li>
                <li class="breadcrumb-item active fw-bold text-dark">About</li>
            </ol>
        </nav>
    </div>

    <!-- Main Form Card -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
        <div class="card-header bg-white border-bottom py-3">
            <h6 class="fw-bold m-0 text-muted">About</h6>
        </div>
        
        <div class="card-body p-4 p-lg-5">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    
                    <?php if(!$about): ?>
                        <div class="alert alert-danger rounded-3 text-center py-3 fw-bold mb-4">
                            Failed to load About data
                        </div>
                    <?php endif; ?>

                    <form action="../api/admin/manage-about.php" method="POST" enctype="multipart/form-data">
                        
                        <!-- 1. Image Upload Box -->
                        <div class="mb-4">
                            <label for="aboutImg" class="upload-box-dashed w-100">
                                <input type="file" name="image" id="aboutImg" hidden onchange="previewImg(this)">
                                <div class="text-center py-4" id="upPlaceholder">
                                    <i class="fas fa-cloud-upload-alt text-primary fa-2x mb-2"></i>
                                    <p class="small fw-bold text-dark m-0">Upload Image</p>
                                </div>
                                <img id="aboutPreview" src="../<?php echo $about['image'] ?? ''; ?>" 
                                     class="img-preview <?php echo !empty($about['image']) ? '' : 'd-none'; ?>">
                            </label>
                        </div>

                        <!-- 2. Main Description Section -->
                        <div class="mb-4">
                            <label class="fw-bold small text-muted mb-2">Description</label>
                            <div id="desc-list">
                                <?php if(!empty($desc)): foreach($desc as $p): ?>
                                    <div class="input-group mb-2">
                                        <input type="text" name="description[]" class="form-control custom-input" value="<?php echo $p; ?>">
                                        <button type="button" class="btn btn-soft-danger remove-row"><i class="fas fa-minus"></i></button>
                                    </div>
                                <?php endforeach; else: ?>
                                    <input type="text" name="description[]" class="form-control custom-input mb-2" placeholder="Enter paragraph...">
                                <?php endif; ?>
                            </div>
                            <button type="button" onclick="addNewRow('desc-list', 'description[]')" class="btn btn-primary btn-sm rounded-3 px-3 mt-1 shadow-blue">+ Add More</button>
                        </div>

                        <!-- 3. Why Us Section -->
                        <div class="mb-4 mt-5">
                            <label class="fw-bold small text-muted mb-2">Why Us Description</label>
                            <div id="whyus-list">
                                <?php if(!empty($why_us)): foreach($why_us as $w): ?>
                                    <div class="input-group mb-2">
                                        <input type="text" name="whyUsDescription[]" class="form-control custom-input" value="<?php echo $w; ?>">
                                        <button type="button" class="btn btn-soft-danger remove-row"><i class="fas fa-minus"></i></button>
                                    </div>
                                <?php endforeach; else: ?>
                                    <input type="text" name="whyUsDescription[]" class="form-control custom-input mb-2">
                                <?php endif; ?>
                            </div>
                            <button type="button" onclick="addNewRow('whyus-list', 'whyUsDescription[]')" class="btn btn-primary btn-sm rounded-3 px-3 mt-1 shadow-blue">+ Add More</button>
                        </div>

                        <!-- 4. How Different Section -->
                        <div class="mb-4 mt-5">
                            <label class="fw-bold small text-muted mb-1">How Different Description</label>
                            <p class="small text-muted mb-2">Intro Line (e.g. "Following are the highlights...")</p>
                            <input type="text" name="howDiffrentHeader" class="form-control custom-input mb-3 bg-light-blue" 
                                   placeholder="Enter the intro line here..." value="<?php echo $about['how_diff_header'] ?? ''; ?>">
                            
                            <div id="diff-list">
                                <?php if(!empty($how_diff)): foreach($how_diff as $h): ?>
                                    <div class="input-group mb-2">
                                        <input type="text" name="howDiffrentDescription[]" class="form-control custom-input" value="<?php echo $h; ?>">
                                        <button type="button" class="btn btn-soft-danger remove-row"><i class="fas fa-minus"></i></button>
                                    </div>
                                <?php endforeach; else: ?>
                                    <input type="text" name="howDiffrentDescription[]" class="form-control custom-input mb-2">
                                <?php endif; ?>
                            </div>
                            <button type="button" onclick="addNewRow('diff-list', 'howDiffrentDescription[]')" class="btn btn-primary btn-sm rounded-3 px-3 mt-1 shadow-blue">+ Add More</button>
                        </div>

                        <!-- 5. Safety Section -->
                        <div class="mb-4 mt-5">
                            <label class="fw-bold small text-muted mb-2">Safety Description</label>
                            <div id="safety-list">
                                <?php if(!empty($safety)): foreach($safety as $s): ?>
                                    <div class="input-group mb-2">
                                        <input type="text" name="safetyDescription[]" class="form-control custom-input" value="<?php echo $s; ?>">
                                        <button type="button" class="btn btn-soft-danger remove-row"><i class="fas fa-minus"></i></button>
                                    </div>
                                <?php endforeach; else: ?>
                                    <input type="text" name="safetyDescription[]" class="form-control custom-input mb-2">
                                <?php endif; ?>
                            </div>
                            <button type="button" onclick="addNewRow('safety-list', 'safetyDescription[]')" class="btn btn-primary btn-sm rounded-3 px-3 mt-1 shadow-blue">+ Add More</button>
                        </div>

                        <!-- 6. Tutor Description -->
                        <div class="mb-5 mt-5">
                            <label class="fw-bold small text-muted mb-2">Tutor Description</label>
                            <textarea name="tutorDescription" class="form-control custom-input" rows="5"><?php echo $about['tutor_desc'] ?? ''; ?></textarea>
                        </div>

                        <!-- Save Button -->
                        <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-bold fs-5 shadow-blue">
                            Save
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.upload-box-dashed { border: 2px dashed #305CDE; border-radius: 12px; background: #fcfdff; cursor: pointer; min-height: 120px; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden;}
.img-preview { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: contain; background: white; padding: 10px; }
.custom-input { border: 1px solid #e0e6ed; border-radius: 10px; padding: 12px 15px; font-size: 14px; }
.bg-light-blue { background-color: #f0f7ff !important; }
.btn-soft-danger { background: #fff1f2; color: #e11d48; border: 1px solid #fecaca; }
.shadow-blue { box-shadow: 0 10px 15px rgba(48, 92, 222, 0.2) !important; }
</style>

<script>
function previewImg(input) {
    const preview = document.getElementById('aboutPreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function addNewRow(containerId, fieldName) {
    const container = document.getElementById(containerId);
    const div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = `<input type="text" name="${fieldName}" class="form-control custom-input">
                     <button type="button" class="btn btn-soft-danger remove-row"><i class="fas fa-minus"></i></button>`;
    container.appendChild(div);
}

document.addEventListener('click', e => {
    if(e.target.closest('.remove-row')) e.target.closest('.input-group').remove();
});
</script>

<?php include('includes/footer.php'); ?>