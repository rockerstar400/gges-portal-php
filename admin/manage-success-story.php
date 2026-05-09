<?php 
require_once 'includes/auth_check.php';
require_once '../functions.php';
$stories = getSuccessStories();
include('includes/header.php'); 
include('includes/sidebar.php'); 
?>

<div class="content-area">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold m-0">Success Story List</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb m-0 small">
                <li class="breadcrumb-item"><a href="dashboard.php" class="text-decoration-none text-muted">Home</a></li>
                <li class="breadcrumb-item active fw-bold text-dark">Success Story List</li>
            </ol>
        </nav>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-bottom py-3">
            <h6 class="fw-bold m-0 text-muted">Success Story</h6>
        </div>
        <div class="card-body p-4">
            <button class="btn btn-primary px-4 py-2 rounded-3 fw-bold mb-4 shadow-blue" data-bs-toggle="modal" data-bs-target="#storyModal">
                + Add
            </button>

            <div class="table-responsive">
                <table class="table align-middle custom-table">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0 ps-4">#</th>
                            <th class="border-0">Image</th>
                            <th class="border-0">Name</th>
                            <th class="border-0">Designation</th>
                            <th class="border-0">Description</th>
                            <th class="border-0 text-center">Rating</th>
                            <th class="border-0 text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($stories): foreach($stories as $index => $s): ?>
                        <tr>
                            <td class="ps-4 text-muted small"><?php echo $index + 1; ?></td>
                            <td><img src="../<?php echo $s['image']; ?>" class="rounded-circle" width="40" height="40" style="object-fit: cover;"></td>
                            <td class="fw-bold text-dark"><?php echo $s['name']; ?></td>
                            <td class="text-muted small"><?php echo $s['designation']; ?></td>
                            <td class="small text-muted"><?php echo substr($s['description'], 0, 50); ?>...</td>
                            <td class="text-center">
                                <span class="text-warning">
                                    <?php for($i=0; $i<$s['rating']; $i++) echo "★"; ?>
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="#" class="btn btn-sm text-primary p-1"><i class="far fa-edit"></i></a>
                                    <a href="../api/admin/manage-story.php?action=delete&id=<?php echo $s['id']; ?>" class="btn btn-sm text-danger p-1" onclick="return confirm('Delete this story?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr><td colspan="7" class="text-center py-5 text-muted">No stories found</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- --- ADD STORY MODAL --- -->
<div class="modal fade" id="storyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header border-0 pb-0 pe-4 pt-4">
                <h5 class="modal-title fw-bold">Add Story</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../api/admin/manage-story.php?action=add" method="POST" enctype="multipart/form-data">
                <div class="modal-body p-4">
                    <input type="text" name="name" class="form-control custom-input mb-3" placeholder="Enter name..." required>
                    <input type="text" name="designation" class="form-control custom-input mb-3" placeholder="Enter designation..." required>
                    <textarea name="description" class="form-control custom-input mb-3" rows="4" placeholder="Enter description..." required></textarea>
                    <input type="number" name="rating" class="form-control custom-input mb-3" placeholder="Rating (0-5)" min="0" max="5" required>
                    
                    <label for="storyImg" class="upload-box-dashed w-100 mb-4">
                        <input type="file" name="image" id="storyImg" hidden onchange="previewImg(this)" required>
                        <div class="text-center py-3" id="upPlaceholder">
                            <i class="fas fa-cloud-upload-alt text-primary fa-2x mb-2"></i>
                            <p class="small fw-bold text-dark m-0">Click to Upload Image</p>
                        </div>
                        <img id="storyPreview" class="d-none w-100 h-100 object-fit-contain">
                    </label>

                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-bold shadow-blue">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewImg(input) {
    const preview = document.getElementById('storyPreview');
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