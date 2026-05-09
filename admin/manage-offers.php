<?php 
require_once 'includes/auth_check.php';
require_once '../functions.php';
$offers = getAll('offers'); // functions.php se data laya
include('includes/header.php'); 
include('includes/sidebar.php'); 
?>

<!-- CKEditor for Professional Text Editing -->
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>

<div class="content-area">
    <!-- Breadcrumbs -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold m-0">Offer List</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb m-0 small">
                <li class="breadcrumb-item"><a href="dashboard.php" class="text-decoration-none text-muted">Home</a></li>
                <li class="breadcrumb-item active fw-bold text-dark" aria-current="page">Offer List</li>
            </ol>
        </nav>
    </div>

    <!-- Main Card -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-bottom py-3">
            <h6 class="fw-bold m-0 text-muted">Offer</h6>
        </div>
        <div class="card-body p-4">
            <!-- Add Button -->
            <button class="btn btn-primary px-4 py-2 rounded-3 fw-bold mb-4 shadow-blue" data-bs-toggle="modal" data-bs-target="#offerModal">
                + Add
            </button>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0">Type</th>
                            <th class="border-0">Title</th>
                            <th class="border-0">Expire Date</th>
                            <th class="border-0 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($offers): foreach($offers as $o): ?>
                        <tr>
                            <td><span class="badge bg-soft-blue text-primary px-3"><?php echo $o['type']; ?></span></td>
                            <td class="fw-bold"><?php echo $o['title']; ?></td>
                            <td class="text-muted"><?php echo $o['expireDate'] ? date('d/m/Y', strtotime($o['expireDate'])) : 'No Expiry'; ?></td>
                            <td class="text-end">
                                <a href="../api/admin/manage-offers.php?action=delete&id=<?php echo $o['id']; ?>" 
                                   class="btn btn-outline-danger btn-sm rounded-3 px-3" 
                                   onclick="return confirm('Delete this offer?')">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">No offers found</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- --- ADD NEW OFFER MODAL --- -->
<div class="modal fade" id="offerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Add New Offer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../api/admin/manage-offers.php?action=add" method="POST">
                <div class="modal-body p-4">
                    
                    <!-- Select Type -->
                    <div class="mb-3">
                        <select name="type" class="form-select custom-input" required>
                            <option value="">Select Type</option>
                            <option value="New">New</option>
                            <option value="Hot Deal">Hot Deal</option>
                            <option value="Referral">Referral</option>
                        </select>
                    </div>

                    <!-- Title -->
                    <div class="mb-3">
                        <input type="text" name="title" class="form-control custom-input" placeholder="Enter title..." required>
                    </div>

                    <!-- Description (CKEditor) -->
                    <div class="mb-3">
                        <textarea name="description" id="editor" placeholder="Enter description..."></textarea>
                    </div>

                    <!-- Date Picker -->
                    <div class="mb-4">
                        <input type="date" name="expireDate" class="form-control custom-input">
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
/* Screenshot matching styles */
.custom-input {
    border: 1px solid #e0e6ed;
    border-radius: 10px;
    padding: 12px 15px;
    font-size: 15px;
}
.ck-editor__editable {
    min-height: 150px;
    border-radius: 0 0 10px 10px !important;
}
.bg-soft-blue { background-color: #ebf2ff; }
</style>

<script>
    // CKEditor initialization
    ClassicEditor
        .create(document.querySelector('#editor'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo']
        })
        .catch(error => {
            console.error(error);
        });
</script>

<?php include('includes/footer.php'); ?>