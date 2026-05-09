<?php 
require_once 'includes/auth_check.php';
include('includes/header.php'); 
include('includes/sidebar.php'); 
?>

<div class="content-area">
    <div class="mb-4">
        <a href="manage-management.php" class="text-decoration-none small text-muted"><i class="fas fa-arrow-left"></i> Back to List</a>
        <h2 class="fw-bold mt-2">Add Team Member</h2>
    </div>

    <div class="card border-0 shadow-sm p-4 rounded-4 col-lg-8">
        <form action="../api/admin/manage-management.php?action=add" method="POST" enctype="multipart/form-data">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Full Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Role / Designation</label>
                    <input type="text" name="role" class="form-control" placeholder="e.g. CEO" required>
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-bold">Bio / Description</label>
                    <textarea name="description" class="form-control" rows="4" required></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Profile Photo</label>
                    <input type="file" name="image" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Display Order</label>
                    <input type="number" name="order_val" class="form-control" value="0">
                    <small class="text-muted">Smaller numbers appear first</small>
                </div>
                <div class="col-md-12 mt-4">
                    <button type="submit" class="btn btn-primary px-5 btn-lg">Save Member</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include('includes/footer.php'); ?>