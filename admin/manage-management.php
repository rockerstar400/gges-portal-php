<?php 
require_once 'includes/auth_check.php';
require_once '../functions.php';
$members = getMembers(); // functions.php se members fetch karein
include('includes/header.php'); 
include('includes/sidebar.php'); 
?>

<div class="content-area">
    <!-- Breadcrumbs -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold m-0">Our-Management</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb m-0 small">
                <li class="breadcrumb-item"><a href="dashboard.php" class="text-decoration-none text-muted">Home</a></li>
                <li class="breadcrumb-item active fw-bold text-dark">Management</li>
            </ol>
        </nav>
    </div>

    <!-- Main List Card -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
            <h4 class="fw-bold m-0 text-dark">Management Team</h4>
            <button class="btn btn-primary px-4 py-2 rounded-3 fw-bold shadow-blue" data-bs-toggle="modal" data-bs-target="#addMemberModal">
                + Add Member
            </button>
        </div>
        
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table align-middle custom-table">
                    <thead>
                        <tr class="bg-light">
                            <th class="border-0 rounded-start ps-4">Image</th>
                            <th class="border-0">Name & Role</th>
                            <th class="border-0">Description Preview</th>
                            <th class="border-0 rounded-end text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($members): foreach($members as $m): ?>
                        <tr>
                            <td class="ps-4">
                                <img src="../<?php echo $m['image']; ?>" class="rounded-circle shadow-sm" width="50" height="50" style="object-fit: cover;">
                            </td>
                            <td>
                                <div class="fw-bold text-dark"><?php echo $m['name']; ?></div>
                                <div class="small text-primary fw-bold text-uppercase" style="font-size: 11px;"><?php echo $m['role']; ?></div>
                            </td>
                            <td class="text-muted small">
                                <?php echo substr($m['description'], 0, 100); ?>...
                            </td>
                            <td class="text-end pe-4">
                                <a href="../api/admin/manage-management.php?action=delete&id=<?php echo $m['id']; ?>" 
                                   class="btn btn-sm btn-outline-danger border-0 rounded-circle" 
                                   onclick="return confirm('Remove this member?')">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr><td colspan="4" class="text-center py-5 text-muted">No management members found</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- --- ADD MEMBER MODAL (Exactly as Screenshot) --- -->
<div class="modal fade" id="addMemberModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header border-0 pb-0 pe-4 pt-4">
                <h5 class="modal-title fw-bold">Add Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../api/admin/manage-management.php?action=add" method="POST" enctype="multipart/form-data">
                <div class="modal-body p-4">
                    
                    <!-- Name -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Name</label>
                        <input type="text" name="name" class="form-control custom-input" placeholder="e.g. Raj Gaurav Sharma" required>
                    </div>

                    <!-- Role -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Role / Designation</label>
                        <input type="text" name="role" class="form-control custom-input" placeholder="e.g. Executive Director" required>
                    </div>

                    <!-- Profile Image Dashed Box -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Profile Image</label>
                        <label for="memberImg" class="upload-box-dashed w-100">
                            <input type="file" name="image" id="memberImg" hidden onchange="previewMember(this)" required>
                            <div class="text-center py-3" id="upPlaceholder">
                                <i class="fas fa-cloud-upload-alt text-muted fa-2x mb-2"></i>
                                <p class="small text-muted m-0">Click to upload photo</p>
                            </div>
                            <img id="memberPreview" class="d-none w-100 h-100 object-fit-contain p-2">
                        </label>
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-dark">Description</label>
                        <textarea name="description" class="form-control custom-input" rows="4" placeholder="About the person..." required></textarea>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-light px-4 fw-bold" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4 fw-bold shadow-blue">Save Member</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.custom-table thead tr { height: 60px; }
.custom-input { border: 1px solid #e0e6ed; border-radius: 8px; padding: 10px 15px; font-size: 14px; }
.upload-box-dashed { border: 2px dashed #ced4da; border-radius: 12px; background: #fff; cursor: pointer; min-height: 100px; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; }
.upload-box-dashed:hover { border-color: #305CDE; }
.shadow-blue { box-shadow: 0 8px 15px rgba(48, 92, 222, 0.2) !important; }
</style>

<script>
function previewMember(input) {
    const preview = document.getElementById('memberPreview');
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