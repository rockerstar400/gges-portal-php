<?php 
require_once 'includes/auth_check.php';
require_once '../functions.php';
$items = getAll('why_choose');
include('includes/header.php'); 
include('includes/sidebar.php'); 
?>

<div class="content-area">
    <!-- Header Area -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold m-0">Why Choose List</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb m-0 small">
                <li class="breadcrumb-item"><a href="dashboard.php" class="text-decoration-none text-muted">Home</a></li>
                <li class="breadcrumb-item active fw-bold text-dark" aria-current="page">Why Choose List</li>
            </ol>
        </nav>
    </div>

    <!-- Main Table Card -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
            <h6 class="fw-bold m-0 text-muted">Why Choose</h6>
        </div>
        <div class="card-body p-4">
            <!-- Add New Button -->
            <button class="btn btn-primary px-4 py-2 rounded-3 fw-bold mb-4 shadow-blue" data-bs-toggle="modal" data-bs-target="#addNewModal">
                + Add New
            </button>

            <!-- Items Table -->
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0">Icon</th>
                            <th class="border-0">Title</th>
                            <th class="border-0">Description</th>
                            <th class="border-0 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($items): foreach($items as $item): ?>
                        <tr>
                            <td><img src="../<?php echo $item['image']; ?>" width="45" class="rounded"></td>
                            <td class="fw-bold text-dark"><?php echo $item['title']; ?></td>
                            <td class="text-muted small"><?php echo substr($item['description'], 0, 80); ?>...</td>
                            <td class="text-end">
                                <a href="../api/admin/manage-why-choose.php?action=delete&id=<?php echo $item['id']; ?>" 
                                   class="btn btn-outline-danger btn-sm rounded-3 px-3" 
                                   onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <p class="text-muted m-0">No items found</p>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- --- ADD NEW MODAL (Based on your Screenshot) --- -->
<div class="modal fade" id="addNewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Add New Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../api/admin/manage-why-choose.php?action=add" method="POST" enctype="multipart/form-data">
                <div class="modal-body p-4">
                    
                    <!-- Dashed Upload Box -->
                    <div class="mb-3">
                        <label for="iconInput" class="upload-box-dashed w-100" id="dropArea">
                            <input type="file" name="image" id="iconInput" hidden onchange="previewIcon(this)" required>
                            <div class="text-center py-3" id="uploadPlaceholder">
                                <i class="fas fa-cloud-upload-alt text-primary fa-2x mb-2"></i>
                                <p class="small fw-bold text-dark m-0">Click to Upload Image</p>
                            </div>
                            <img id="iconPreview" class="d-none w-100 h-100 object-fit-contain p-2">
                        </label>
                    </div>

                    <!-- Title -->
                    <div class="mb-3">
                        <input type="text" name="title" class="form-control custom-input" placeholder="Enter title..." required>
                    </div>

                    <!-- Description -->
                    <div class="mb-1">
                        <textarea name="description" id="descInput" class="form-control custom-input" rows="4" placeholder="Enter description..." required onkeyup="countWords(this)"></textarea>
                    </div>
                    <div class="text-end mb-4">
                        <small class="text-muted small-text">Word Count: <span id="wordCount">0</span> / 250</small>
                    </div>

                    <!-- Save Button -->
                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-bold shadow-blue">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.upload-box-dashed {
    border: 2px dashed #305CDE;
    border-radius: 12px;
    background: #fcfdff;
    cursor: pointer;
    min-height: 120px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
}
.upload-box-dashed:hover { background: #f0f7ff; }
.small-text { font-size: 11px; }

/* Custom input matching modal */
.modal-content .custom-input {
    border: 1px solid #e0e6ed;
    border-radius: 8px;
    padding: 12px 15px;
}
</style>

<script>
function previewIcon(input) {
    const preview = document.getElementById('iconPreview');
    const placeholder = document.getElementById('uploadPlaceholder');
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

function countWords(obj) {
    document.getElementById('wordCount').innerText = obj.value.length;
}
</script>

<?php include('includes/footer.php'); ?>