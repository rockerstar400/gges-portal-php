<?php 
require_once 'includes/auth_check.php';
require_once '../functions.php';
$stats = getTrustStats();
include('includes/header.php'); 
include('includes/sidebar.php'); 
?>

<div class="content-area">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold m-0">Trust Credibilty List</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb m-0 small">
                <li class="breadcrumb-item"><a href="dashboard.php" class="text-decoration-none text-muted">Home</a></li>
                <li class="breadcrumb-item active fw-bold text-dark">Trust Credibilty List</li>
            </ol>
        </nav>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-bottom py-3">
            <h6 class="fw-bold m-0 text-muted">Trust Credibilty</h6>
        </div>
        <div class="card-body p-4">
            <!-- <button class="btn btn-primary px-4 py-2 rounded-3 fw-bold mb-4 shadow-blue" onclick="openModal()">
                + Add
            </button> -->
            <button class="btn btn-primary px-4 py-2 rounded-3 fw-bold mb-4 shadow-blue" data-bs-toggle="modal" data-bs-target="#trustModal">
    + Add
</button>

            <div class="table-responsive">
                <table class="table align-middle custom-table">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0 ps-4">#</th>
                            <th class="border-0">Icon</th>
                            <th class="border-0 text-center">Title</th>
                            <th class="border-0 text-center">Description</th>
                            <th class="border-0 text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($stats): foreach($stats as $index => $s): ?>
                        <tr>
                            <td class="ps-4 text-muted small"><?php echo $index + 1; ?></td>
                            <td>
                                <div class="bg-light rounded-3 p-2 d-inline-block border">
                                    <img src="../<?php echo $s['image']; ?>" width="35" height="35" style="object-fit: contain;">
                                </div>
                            </td>
                            <td class="text-center fw-bold text-dark"><?php echo $s['title']; ?></td>
                            <td class="text-center text-muted"><?php echo $s['description']; ?></td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <!-- Edit Icon -->
                                    <button class="btn btn-sm text-primary p-1" onclick='editTrust(<?php echo json_encode($s); ?>)'>
                                        <i class="far fa-edit fs-5"></i>
                                    </button>
                                    <!-- Delete Icon -->
                                    <a href="../api/admin/manage-trust.php?action=delete&id=<?php echo $s['id']; ?>" class="btn btn-sm text-danger p-1" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash-alt fs-5"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr><td colspan="5" class="text-center py-5">No items found</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- --- ADD/EDIT MODAL --- -->
<div class="modal fade" id="trustModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header border-0 pb-0 pe-4 pt-4">
                <h5 class="modal-title fw-bold" id="modalTitle">Add Trust Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="../api/admin/manage-trust.php?action=save" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" id="trustId">
                <div class="modal-body p-4">
                    <input type="text" name="title" id="trustTitle" class="form-control custom-input mb-3" placeholder="Enter title..." required>
                    <textarea name="description" id="trustDesc" class="form-control custom-input mb-3" rows="3" placeholder="Enter description..." required></textarea>
                    
                    <label for="trustImg" class="upload-box-dashed w-100 mb-4">
                        <input type="file" name="image" id="trustImg" hidden onchange="previewImg(this)">
                        <div class="text-center py-3" id="upPlaceholder">
                            <i class="fas fa-cloud-upload-alt text-primary fa-2x mb-2"></i>
                            <p class="small fw-bold text-dark m-0">Click to Upload Icon</p>
                        </div>
                        <img id="trustPreview" class="d-none w-100 h-100 object-fit-contain p-2">
                    </label>

                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-bold shadow-blue">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const myModal = new bootstrap.Modal(document.getElementById('trustModal'));

function openModal() {
    document.getElementById('modalTitle').innerText = "Add Trust Item";
    document.getElementById('trustId').value = "";
    document.getElementById('trustTitle').value = "";
    document.getElementById('trustDesc').value = "";
    document.getElementById('trustPreview').classList.add('d-none');
    document.getElementById('upPlaceholder').classList.remove('d-none');
    myModal.show();
}

function editTrust(data) {
    document.getElementById('modalTitle').innerText = "Edit Trust Item";
    document.getElementById('trustId').value = data.id;
    document.getElementById('trustTitle').value = data.title;
    document.getElementById('trustDesc').value = data.description;
    
    const preview = document.getElementById('trustPreview');
    preview.src = "../" + data.image;
    preview.classList.remove('d-none');
    document.getElementById('upPlaceholder').classList.add('d-none');
    myModal.show();
}

function previewImg(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('trustPreview').src = e.target.result;
            document.getElementById('trustPreview').classList.remove('d-none');
            document.getElementById('upPlaceholder').classList.add('d-none');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?php include('includes/footer.php'); ?>