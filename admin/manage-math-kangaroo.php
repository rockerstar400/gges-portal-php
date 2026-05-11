<?php 
require_once '../functions.php';
include 'includes/header.php';
include 'includes/sidebar.php';

$slug = 'math-kangaroo'; 
$prepData = getTestPrepData($slug); 

// Banner Data
$bannerDesc = $prepData['kan_banner_desc'] ?? '';
$structList = json_decode($prepData['kan_struct_json'] ?? '[]', true) ?: [''];

// Details List (Images/Titles)
$detailsList = $conn->query("SELECT * FROM kangaroo_details ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<style>
    .main-content { width: 100%; padding: 30px; background-color: #f8fafc; }
    .premium-card { background: white; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); margin-bottom: 30px; border-top: 5px solid #305CDE; }
    .form-control-custom { border-radius: 10px; padding: 12px; border: 1px solid #e2e8f0; }
    .modal-xl-custom { max-width: 900px; }
</style>

<div class="main-content">
    <div class="container-fluid">
        
        <!-- SECTION 1: KANGAROO BANNER & STRUCTURE -->
        <div class="premium-card p-4 p-md-5">
            <h2 class="text-2xl font-bold mb-4 text-primary">Kangaroo Test Management</h2>
            <form action="api/admin/save-kangaroo-banner.php" method="POST">
                <input type="hidden" name="slug" value="<?= $slug ?>">

                <div class="mb-4">
                    <label class="fw-bold text-secondary mb-2">Test Prep Description</label>
                    <textarea name="banner_desc" class="form-control form-control-custom" rows="3"><?= $bannerDesc ?></textarea>
                </div>

                <div class="mb-4">
                    <label class="fw-bold text-secondary mb-2">Test Structure Description (Array)</label>
                    <div id="struct-container">
                        <?php foreach($structList as $idx => $desc): ?>
                        <div class="d-flex gap-2 mb-2">
                            <input type="text" name="struct_desc[]" value="<?= htmlspecialchars($desc) ?>" class="form-control form-control-custom" placeholder="Structure point <?= $idx+1 ?>">
                            <button type="button" class="btn btn-danger" onclick="this.parentElement.remove()">✕</button>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="addStructField()">+ Add Structure</button>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-pill">Save Banner & Structure</button>
            </form>
        </div>

        <!-- SECTION 2: KANGAROO DETAILS (CRUD) -->
        <div class="premium-card p-4 p-md-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-2xl font-bold text-primary">Kangaroo Details (Items)</h2>
                <button class="btn btn-primary rounded-pill px-4" onclick="openDetailModal()">+ Add New Detail</button>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle border-0">
                    <thead class="bg-light">
                        <tr class="small text-muted text-uppercase">
                            <th>Image</th><th>Title</th><th>Description</th><th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($detailsList as $item): 
                            $itemDescs = json_decode($item['description'], true) ?: [];
                        ?>
                        <tr>
                            <td><img src="../<?= $item['image'] ?>" class="rounded shadow-sm border" width="80" height="80" style="object-fit: cover;"></td>
                            <td class="fw-bold"><?= $item['title'] ?></td>
                            <td>
                                <button class="btn btn-sm btn-outline-info rounded-pill" onclick='showViewModal(<?= json_encode($itemDescs) ?>)'>View Descriptions (<?= count($itemDescs) ?>)</button>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm text-primary me-2" onclick='editDetail(<?= json_encode($item) ?>)'><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm text-danger" onclick="deleteDetail(<?= $item['id'] ?>)"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- ADD/EDIT DETAIL MODAL -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-xl-custom modal-dialog-centered">
        <form class="modal-content rounded-4 border-0 shadow-lg" action="api/admin/handler-kangaroo-details.php" method="POST" enctype="multipart/form-data">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold" id="modalLabel">Add Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <input type="hidden" name="id" id="detail_id">
                
                <div class="mb-3">
                    <label class="fw-bold mb-2">Title</label>
                    <input type="text" name="title" id="detail_title" class="form-control form-control-custom" required>
                </div>

                <div class="mb-3">
                    <label class="fw-bold mb-2">Descriptions List</label>
                    <div id="detail-desc-container">
                        <!-- Dynamic Textareas -->
                    </div>
                    <button type="button" class="btn btn-sm btn-link text-primary p-0 fw-bold" onclick="addDetailDesc()">+ Add Description</button>
                </div>

                <div class="mb-3">
                    <label class="fw-bold mb-2">Image</label>
                    <input type="file" name="image" class="form-control form-control-custom" onchange="previewImg(this)">
                    <div class="mt-3">
                        <img id="prev-img" src="" class="rounded shadow-sm" width="100" style="display:none;">
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold">Save Item</button>
            </div>
        </form>
    </div>
</div>

<!-- VIEW DESCRIPTIONS MODAL -->
<div class="modal fade" id="viewModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 p-4">
            <h5 class="fw-bold mb-3 border-bottom pb-2">Full Descriptions</h5>
            <ul id="view-list" class="list-group list-group-flush fs-6"></ul>
            <button class="btn btn-secondary mt-4 rounded-pill" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
</div>

<script>
function addStructField() {
    const html = `<div class="d-flex gap-2 mb-2 animate__animated animate__fadeIn"><input type="text" name="struct_desc[]" class="form-control form-control-custom"><button type="button" class="btn btn-danger" onclick="this.parentElement.remove()">✕</button></div>`;
    document.getElementById('struct-container').insertAdjacentHTML('beforeend', html);
}

function addDetailDesc(val = '') {
    const html = `<div class="d-flex gap-2 mb-2 animate__animated animate__fadeIn"><textarea name="description[]" class="form-control form-control-custom" rows="2">${val}</textarea><button type="button" class="btn btn-danger btn-sm px-2" onclick="this.parentElement.remove()">✕</button></div>`;
    document.getElementById('detail-desc-container').insertAdjacentHTML('beforeend', html);
}

function openDetailModal() {
    document.getElementById('modalLabel').innerText = "Add New Detail";
    document.getElementById('detail_id').value = "";
    document.getElementById('detail_title').value = "";
    document.getElementById('detail-desc-container').innerHTML = "";
    addDetailDesc();
    document.getElementById('prev-img').style.display = "none";
    new bootstrap.Modal(document.getElementById('detailModal')).show();
}

function editDetail(data) {
    document.getElementById('modalLabel').innerText = "Edit Detail Item";
    document.getElementById('detail_id').value = data.id;
    document.getElementById('detail_title').value = data.title;
    
    const container = document.getElementById('detail-desc-container');
    container.innerHTML = "";
    const descs = JSON.parse(data.description);
    descs.forEach(d => addDetailDesc(d));

    const prev = document.getElementById('prev-img');
    prev.src = "../" + data.image;
    prev.style.display = "inline-block";
    new bootstrap.Modal(document.getElementById('detailModal')).show();
}

function showViewModal(descs) {
    const list = document.getElementById('view-list');
    list.innerHTML = descs.map((d, i) => `<li class="list-group-item border-0 p-1 mb-2">${i+1}. ${d}</li>`).join("");
    new bootstrap.Modal(document.getElementById('viewModal')).show();
}

function deleteDetail(id) {
    if(confirm('Permanently delete this item?')) {
        window.location.href = 'api/admin/handler-kangaroo-details.php?delete=' + id;
    }
}

function previewImg(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('prev-img').src = e.target.result;
            document.getElementById('prev-img').style.display = 'inline-block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?php include 'includes/footer.php'; ?>