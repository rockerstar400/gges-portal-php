<?php include('includes/header.php'); ?>

<h2 class="fw-bold mb-4">Add New Why Choose Item</h2>

<div class="card p-4 col-md-8 mx-auto">
    <form action="../api/admin/manage-why-choose.php?action=add" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label fw-bold">Title</label>
            <input type="text" name="title" class="form-control" placeholder="e.g. Expert Tutors" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Description</label>
            <textarea name="description" class="form-control" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Select Icon/Image</label>
            <input type="file" name="image" class="form-control" required>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary px-5">Save Item</button>
            <a href="manage-why-choose.php" class="btn btn-light ms-2">Cancel</a>
        </div>
    </form>
</div>

<?php include('../includes/footer.php'); ?>
