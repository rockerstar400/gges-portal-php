<?php 
require_once '../functions.php';
include 'includes/header.php';
include 'includes/sidebar.php';

$slug = 'eng-core-ela'; 
$prepData = getTestPrepData($slug); 

// Main Section Data mapping based on Master Function
// $coreDescs = json_decode($prepData['ela_core_desc_json'] ?? '[]', true) ?: [''];
// $coverDesc = $prepData['ela_cover_desc'] ?? '';
$coreDescs = $prepData['ela_core_desc'] ?? ['']; 
$coverDesc = $prepData['ela_cover_desc'] ?? '';

// Details List (Images/Titles)
// $detailsList = $conn->query("SELECT * FROM core_ela_details ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
$detailsList = $conn->query("SELECT * FROM core_ela_details ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<style>
    /* Full Width & Premium Logic */
    .main-content {
        width: 100%;
        padding: 30px;
        background-color: #f8fafc; /* Light Slate background */
    }

    .premium-card {
        background: #ffffff;
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
        overflow: hidden;
    }

    .card-header-blue {
        background: #ffffff;
        border-bottom: 1px solid #f1f5f9;
        padding: 20px 30px;
        border-left: 5px solid #305CDE; /* Accent Border */
    }

    .card-body-content {
        padding: 30px;
    }

    .form-control-custom {
        border-radius: 10px;
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
        transition: 0.3s;
    }

    .form-control-custom:focus {
        border-color: #305CDE;
        box-shadow: 0 0 0 4px rgba(48, 92, 222, 0.1);
    }

    /* Table Improvements */
    .table-premium thead {
        background: #f1f5f9;
        color: #475569;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 1px;
    }

    .table-premium td {
        padding: 15px !important;
        vertical-align: middle;
    }

    /* Modal Styling */
    .modal-content-premium {
        border-radius: 20px;
        border: none;
    }

    .border-dashed-upload {
        border: 2px dashed #305CDE !important;
        background: #f0f7ff;
        border-radius: 15px;
        transition: 0.3s;
    }
</style>

<div class="main-content">
    <div class="container-fluid">
        
        <!-- ==========================================
             SECTION 1: ABOUT CORE ELA (Main Content)
        =========================================== -->
        <div class="premium-card">
            <div class="card-header-blue">
                <h4 class="fw-bold m-0 text-dark">About Core ELA</h4>
            </div>
            
            <div class="card-body-content">
                <form action="api/admin/save-eng-ela-main.php" method="POST">
                    <input type="hidden" name="slug" value="<?= $slug ?>">

                    <!-- Dynamic Core Descriptions -->
                    <div class="mb-5">
                        <label class="fw-bold text-secondary small mb-3">CORE DESCRIPTION (DYNAMIC LIST)</label>
                        <div id="core-desc-container">
                            <?php foreach($coreDescs as $idx => $desc): ?>
                            <div class="d-flex gap-2 mb-3 align-items-center">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="min-width: 30px; height:30px; font-size: 12px;"><?= $idx+1 ?></div>
                                <input type="text" name="core_descriptions[]" value="<?= htmlspecialchars($desc) ?>" class="form-control form-control-custom" placeholder="Enter description line...">
                                <button type="button" class="btn btn-outline-danger border-0" onclick="this.parentElement.remove()"><i class="fas fa-trash-alt"></i></button>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm mt-2 rounded-pill px-4" onclick="addCoreDesc()">
                            <i class="fas fa-plus-circle me-1"></i> Add New Line
                        </button>
                    </div>

                    <!-- Cover Description -->
                    <div class="mb-4">
                        <label class="fw-bold text-secondary small mb-3">COVER DESCRIPTION / SUMMARY</label>
                        <textarea name="cover_description" class="form-control form-control-custom" rows="4" placeholder="Enter the main cover text here..."><?= $coverDesc ?></textarea>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-5 py-2 fw-bold rounded-pill shadow-sm">Save Main Content</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ==========================================
             SECTION 2: CORE ELA DETAIL (Icons CRUD)
        =========================================== -->
        <div class="premium-card">
            <div class="card-header-blue d-flex justify-content-between align-items-center">
                <h4 class="fw-bold m-0 text-dark">Core ELA Details (Icons Grid)</h4>
                <button class="btn btn-primary rounded-pill px-4 shadow-sm" onclick="openDetailModal()">
                    <i class="fas fa-plus me-1"></i> Add New Detail
                </button>
            </div>

            <div class="card-body-content">
                <div class="table-responsive">
                    <table class="table table-premium table-hover align-middle border-0">
                        <thead>
                            <tr>
                                <th>Icon/Image</th>
                                <th>Title / Component Name</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($detailsList)): foreach($detailsList as $item): ?>
                            <tr>
                                <td>
                                    <div class="bg-light rounded-3 p-1 d-inline-block border">
                                        <img src="../<?= $item['image'] ?>" width="50" height="50" style="object-fit: cover;" class="rounded">
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark fs-5"><?= $item['title'] ?></span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-light text-primary rounded-pill me-2 px-3" onclick='editDetail(<?= json_encode($item) ?>)'>
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </button>
                                    <button class="btn btn-sm btn-light text-danger rounded-pill px-3" onclick="deleteDetail(<?= $item['id'] ?>)">
                                        <i class="fas fa-trash-alt me-1"></i> Delete
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; else: ?>
                            <tr><td colspan="3" class="text-center py-5 text-muted">No details found. Click "+ Add Detail" to start.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- ==========================================
     ADD/EDIT DETAIL MODAL (MODERN DESIGN)
=========================================== -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content modal-content-premium p-3" action="api/admin/handler-ela-details.php" method="POST" enctype="multipart/form-data">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold" id="modalLabel">Add New Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="detail_id">
                
                <div class="mb-4">
                    <label class="fw-bold text-muted small mb-2">TITLE</label>
                    <input type="text" name="title" id="detail_title" class="form-control form-control-custom" placeholder="e.g. Critical Thinking" required>
                </div>

                <div class="mb-4">
                    <label class="fw-bold text-muted small mb-2">ICON / IMAGE</label>
                    <div class="border-dashed-upload p-4 text-center mb-3">
                        <label class="cursor-pointer w-100 mb-0">
                            <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i><br>
                            <span class="text-primary fw-bold">Click to Upload Icon</span>
                            <input type="file" name="image" class="d-none" onchange="previewImg(this)">
                        </label>
                    </div>
                    <div class="text-center" id="prev-container" style="display:none;">
                        <span class="d-block small text-muted mb-2">Preview:</span>
                        <img id="prev-img" src="" class="rounded-circle shadow-sm border" width="80" height="80" style="object-fit: cover;">
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
// Logic to add dynamic input rows
function addCoreDesc() {
    const container = document.getElementById('core-desc-container');
    const count = container.children.length + 1;
    const html = `
    <div class="d-flex gap-2 mb-3 align-items-center animate__animated animate__fadeIn">
        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="min-width: 30px; height:30px; font-size: 12px;">${count}</div>
        <input type="text" name="core_descriptions[]" class="form-control form-control-custom" placeholder="Enter description line...">
        <button type="button" class="btn btn-outline-danger border-0" onclick="this.parentElement.remove()"><i class="fas fa-trash-alt"></i></button>
    </div>`;
    container.insertAdjacentHTML('beforeend', html);
}

// Modal Control Functions
function openDetailModal() {
    document.getElementById('modalLabel').innerText = "Add New Detail";
    document.getElementById('detail_id').value = "";
    document.getElementById('detail_title').value = "";
    document.getElementById('prev-container').style.display = "none";
    new bootstrap.Modal(document.getElementById('detailModal')).show();
}

function editDetail(data) {
    document.getElementById('modalLabel').innerText = "Edit Detail Item";
    document.getElementById('detail_id').value = data.id;
    document.getElementById('detail_title').value = data.title;
    const prev = document.getElementById('prev-img');
    const container = document.getElementById('prev-container');
    prev.src = "../" + data.image;
    container.style.display = "block";
    new bootstrap.Modal(document.getElementById('detailModal')).show();
}

function deleteDetail(id) {
    if(confirm('Are you sure you want to permanently delete this item?')) {
        window.location.href = 'api/admin/handler-ela-details.php?delete=' + id;
    }
}

// Live Preview Image
function previewImg(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            const img = document.getElementById('prev-img');
            const container = document.getElementById('prev-container');
            img.src = e.target.result;
            container.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?php include 'includes/footer.php'; ?>