<?php 
require_once '../functions.php';
include 'includes/header.php';
include 'includes/sidebar.php';

// Fetch List
$list = getAll('why_choose'); 
?>

<!-- Custom CSS for React-like UI -->
<style>
    .main-content { width: 100%; padding: 2rem; background-color: #f9fafb; }
    .admin-card-wide { background: white; border-radius: 1rem; border-top: 5px solid #2563eb; box-shadow: 0 10px 25px rgba(0,0,0,0.05); width: 100%; margin: 0 auto; padding: 2rem; }
    .upload-box { border: 2px dashed #60a5fa; background: #eff6ff; border-radius: 1rem; padding: 20px; transition: 0.3s; cursor: pointer; }
    .upload-box:hover { background: #dbeafe; }
    .word-count { font-size: 12px; font-weight: bold; margin-top: 5px; }
    .text-danger-custom { color: #ef4444; }
    .img-prev-container { width: 100px; height: 100px; border-radius: 10px; overflow: hidden; border: 1px solid #ddd; margin: 10px auto; display: none; }
</style>

<div class="main-content">
    <div class="admin-card-wide">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h4 fw-bold m-0 text-primary">Why Choose Us Management</h2>
            <button class="btn btn-primary rounded-pill px-4 shadow-sm" onclick="openAddModal()">+ Add New</button>
        </div>

        <!-- Table List -->
        <div class="table-responsive rounded-4 border overflow-hidden">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr class="small fw-bold text-muted text-uppercase">
                        <th class="ps-4">#</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($list)): foreach($list as $idx => $item): ?>
                    <tr>
                        <td class="ps-4"><?= $idx + 1 ?></td>
                        <td>
                            <img src="../<?= $item['image'] ?>" class="rounded shadow-sm" width="60" height="60" style="object-fit: cover;" onerror="this.src='https://via.placeholder.com/60'">
                        </td>
                        <td class="fw-bold text-dark"><?= $item['title'] ?></td>
                        <td class="text-muted small w-50"><?= substr($item['description'], 0, 100) ?>...</td>
                        <td class="text-center">
                            <button class="btn btn-sm text-primary me-2" onclick='openEditModal(<?= json_encode($item) ?>)'><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm text-danger" onclick="confirmDelete(<?= $item['id'] ?>)"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                        <tr><td colspan="5" class="text-center py-5">No items found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ADD/EDIT MODAL -->
<div class="modal fade" id="whyModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content rounded-4 border-0 shadow-lg" action="api/admin/save-why-choose.php" method="POST" enctype="multipart/form-data" id="whyForm">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold" id="modalTitle">Add New Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <input type="hidden" name="id" id="item_id">
                
                <!-- Upload Area -->
                <div class="upload-box text-center mb-3" onclick="document.getElementById('fileInput').click()">
                    <i class="fas fa-cloud-upload-alt fa-2x text-primary mb-2"></i>
                    <p class="small fw-bold mb-0">Click to Upload Image</p>
                    <input type="file" name="image" id="fileInput" class="d-none" accept="image/*" onchange="previewImage(this)">
                </div>

                <div class="img-prev-container" id="prevContainer">
                    <img id="imgPreview" src="" class="w-100 h-100" style="object-fit: cover;">
                </div>

                <div class="mb-3">
                    <label class="small fw-bold">Title *</label>
                    <input type="text" name="title" id="item_title" class="form-control rounded-3" placeholder="Enter title" required>
                </div>

                <div class="mb-3">
                    <label class="small fw-bold">Description *</label>
                    <textarea name="description" id="item_desc" class="form-control rounded-3" rows="4" placeholder="Enter description" onkeyup="checkWordCount(this)" required></textarea>
                    <div class="word-count text-end text-muted" id="wordCountLabel">Word Count: 0 / 250</div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="submit" id="saveBtn" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
const MAX_WORDS = 250;

function checkWordCount(textarea) {
    const text = textarea.value.trim();
    const count = text === "" ? 0 : text.split(/\s+/).length;
    const label = document.getElementById('wordCountLabel');
    const btn = document.getElementById('saveBtn');

    label.innerText = `Word Count: ${count} / ${MAX_WORDS}`;

    if (count > MAX_WORDS) {
        label.classList.add('text-danger');
        btn.disabled = true;
    } else {
        label.classList.remove('text-danger');
        btn.disabled = false;
    }
}

function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imgPreview').src = e.target.result;
            document.getElementById('prevContainer').style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function openAddModal() {
    document.getElementById('modalTitle').innerText = "Add New Item";
    document.getElementById('item_id').value = "";
    document.getElementById('item_title').value = "";
    document.getElementById('item_desc').value = "";
    document.getElementById('prevContainer').style.display = 'none';
    new bootstrap.Modal(document.getElementById('whyModal')).show();
}

function openEditModal(data) {
    document.getElementById('modalTitle').innerText = "Edit Item";
    document.getElementById('item_id').value = data.id;
    document.getElementById('item_title').value = data.title;
    document.getElementById('item_desc').value = data.description;
    
    const prev = document.getElementById('imgPreview');
    prev.src = "../" + data.image;
    document.getElementById('prevContainer').style.display = 'block';
    
    checkWordCount(document.getElementById('item_desc'));
    new bootstrap.Modal(document.getElementById('whyModal')).show();
}

function confirmDelete(id) {
    if(confirm('Are you sure you want to delete this item?')) {
        window.location.href = 'api/admin/save-why-choose.php?delete=' + id;
    }
}
</script>

<?php include 'includes/footer.php'; ?>