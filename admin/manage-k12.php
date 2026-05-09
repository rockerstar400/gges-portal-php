<?php 
require_once '../functions.php';
include 'includes/header.php';
include 'includes/sidebar.php';

// Fetch Service Data
$service = $conn->query("SELECT * FROM k12_services LIMIT 1")->fetch(PDO::FETCH_ASSOC);
// Fetch Methodology Data
$methodologies = $conn->query("SELECT * FROM k12_methodology ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

$activeTab = $_GET['tab'] ?? 'service';
?>

<div class="main-content p-4">
    <div class="container-fluid bg-white p-4 shadow-sm rounded-4 border-top border-4 border-primary">
        <h2 class="fw-bold mb-4 text-primary">K-12 Management Panel</h2>

        <!-- TABS -->
        <ul class="nav nav-tabs mb-4 border-bottom">
            <li class="nav-item">
                <a class="nav-link fw-bold <?= $activeTab == 'service' ? 'active text-primary border-primary border-bottom-0' : 'text-muted' ?>" href="?tab=service">Service Settings</a>
            </li>
            <li class="nav-item">
                <a class="nav-link fw-bold <?= $activeTab == 'methodology' ? 'active text-primary border-primary border-bottom-0' : 'text-muted' ?>" href="?tab=methodology">Methodology Steps</a>
            </li>
        </ul>

        <?php if($activeTab == 'service'): ?>
            <!-- ==========================================
                 TAB 1: SERVICE (Subject Expertise)
            =========================================== -->
            <form action="api/admin/save-k12-service.php" method="POST" enctype="multipart/form-data" class="p-2">
                
                <!-- Main Banner Section -->
                <div class="mb-5 border-bottom pb-4">
                    <h5 class="fw-bold text-dark mb-3">1. Main K-12 Service Banner</h5>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="small fw-bold text-muted">Page Title</label>
                            <input type="text" name="title" value="<?= htmlspecialchars($service['title'] ?? '') ?>" class="form-control mb-3" placeholder="Our K-12 Services">
                        </div>
                        <div class="col-12">
                            <label class="small fw-bold text-muted">Main Description</label>
                            <textarea name="description" class="form-control mb-3" rows="3" placeholder="Enter description..."><?= htmlspecialchars($service['description'] ?? '') ?></textarea>
                        </div>
                        <div class="col-12">
                            <div class="border-2 border-dashed border-primary p-4 rounded-3 text-center mb-3 bg-light">
                                <label class="cursor-pointer">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-primary mb-2"></i><br>
                                    <span class="fw-bold">Upload Main Image</span>
                                    <input type="file" name="image" class="d-none" onchange="previewImage(this, 'main-prev')">
                                </label>
                                <div class="mt-3">
                                    <img id="main-prev" src="../<?= $service['image'] ?? 'assets/images/placeholder.png' ?>" class="rounded shadow border" width="200" onerror="this.src='https://via.placeholder.com/200x120?text=No+Image'">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Expertise Grid -->
                <div class="row">
                    <?php for($i=1; $i<=3; $i++): 
                        // JSON Decoding Logic
                        $descJson = $service["description$i"] ?? '[]';
                        $descArr = json_decode($descJson, true) ?: [''];
                    ?>
                    <div class="col-lg-4 mb-4">
                        <div class="card shadow-sm border-0 bg-light rounded-4">
                            <div class="card-body">
                                <h6 class="fw-bold text-primary mb-3">Subject Expertise Block <?= $i ?></h6>
                                
                                <label class="small fw-bold text-muted">Block Title</label>
                                <input type="text" name="title<?= $i ?>" value="<?= htmlspecialchars($service["title$i"] ?? '') ?>" class="form-control mb-3" placeholder="e.g. Mathematics">
                                
                                <label class="small fw-bold text-muted">Points / Description</label>
                                <div id="desc-wrap-<?= $i ?>">
                                    <?php foreach($descArr as $desc): ?>
                                    <div class="input-group mb-2">
                                        <input type="text" name="description<?= $i ?>[]" value="<?= htmlspecialchars($desc) ?>" class="form-control" placeholder="Enter point">
                                        <button type="button" class="btn btn-danger" onclick="this.parentElement.remove()">-</button>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary mb-4 w-100" onclick="addDescLine(<?= $i ?>)">+ Add Description Line</button>
                                
                                <label class="small fw-bold text-muted d-block">Block Icon/Image</label>
                                <input type="file" name="image<?= $i ?>" class="form-control form-control-sm mb-2" onchange="previewImage(this, 'prev-<?= $i ?>')">
                                <div class="text-center mt-2">
                                    <img id="prev-<?= $i ?>" src="../<?= $service["image$i"] ?? '' ?>" class="rounded border bg-white" width="60" height="60" style="object-fit: cover; <?= empty($service["image$i"]) ? 'display:none;' : '' ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endfor; ?>
                </div>
                
                <div class="sticky-bottom bg-white py-3 border-top mt-4 text-center">
                    <button type="submit" class="btn btn-primary btn-lg px-5 shadow rounded-pill fw-bold">💾 Save K-12 Service Changes</button>
                </div>
            </form>

        <?php else: ?>
            <!-- ==========================================
                 TAB 2: METHODOLOGY (Modal CRUD)
            =========================================== -->
            <div class="p-3">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold">Teaching Methodologies</h5>
                    <button class="btn btn-primary shadow rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#methodModal" onclick="clearMethodModal()">+ Add New Step</button>
                </div>
                
                <div class="table-responsive shadow-sm rounded-4 border overflow-hidden">
                    <table class="table table-hover align-middle mb-0 text-center">
                        <thead class="bg-light">
                            <tr>
                                <th class="py-3">#</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($methodologies as $index => $m): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><img src="../<?= $m['image'] ?>" class="rounded-circle border" width="45" height="45" style="object-fit: cover;"></td>
                                <td class="fw-bold text-dark"><?= $m['title'] ?></td>
                                <td class="text-muted small w-50"><?= $m['description'] ?></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary rounded-pill me-1" onclick='editMethod(<?= json_encode($m) ?>)'><i class="fas fa-edit"></i></button>
                                    <a href="api/admin/methodology-handler.php?delete=<?= $m['id'] ?>" class="btn btn-sm btn-outline-danger rounded-pill" onclick="return confirm('Confirm Delete?')"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- METHODOLOGY MODAL -->
<div class="modal fade" id="methodModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content border-0 shadow-lg rounded-4" action="api/admin/methodology-handler.php" method="POST" enctype="multipart/form-data">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="modalTitle">Add New Step</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <input type="hidden" name="id" id="method_id">
                
                <div class="border-2 border-dashed border-primary rounded-4 p-4 text-center mb-3 bg-light">
                    <label class="cursor-pointer w-100 mb-0">
                        <i class="fas fa-cloud-upload-alt fa-2x text-primary mb-2"></i><br>
                        <span class="small fw-bold">Click to Upload Icon</span>
                        <input type="file" name="image" class="d-none" onchange="previewImage(this, 'modal-prev')">
                    </label>
                    <div class="mt-2">
                        <img id="modal-prev" src="" class="rounded border shadow-sm" width="80" style="display:none;">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="small fw-bold">Title</label>
                    <input type="text" name="title" id="method_title" class="form-control rounded-3" placeholder="e.g. Build Foundation" required>
                </div>
                <div class="mb-3">
                    <label class="small fw-bold">Description</label>
                    <textarea name="description" id="method_desc" class="form-control rounded-3" rows="4" placeholder="How this step works..." required></textarea>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold">Save Methodology Step</button>
            </div>
        </form>
    </div>
</div>

<script>
function addDescLine(num) {
    const container = document.getElementById('desc-wrap-' + num);
    const html = `<div class="input-group mb-2"><input type="text" name="description${num}[]" class="form-control shadow-sm" placeholder="Enter description"><button type="button" class="btn btn-danger" onclick="this.parentElement.remove()">-</button></div>`;
    container.insertAdjacentHTML('beforeend', html);
}

function previewImage(input, targetId) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            const img = document.getElementById(targetId);
            img.src = e.target.result;
            img.style.display = 'inline-block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function clearMethodModal() {
    document.getElementById('modalTitle').innerText = "Add New Step";
    document.getElementById('method_id').value = "";
    document.getElementById('method_title').value = "";
    document.getElementById('method_desc').value = "";
    document.getElementById('modal-prev').style.display = "none";
}

function editMethod(data) {
    document.getElementById('modalTitle').innerText = "Edit Step";
    document.getElementById('method_id').value = data.id;
    document.getElementById('method_title').value = data.title;
    document.getElementById('method_desc').value = data.description;
    const prev = document.getElementById('modal-prev');
    prev.src = "../" + data.image;
    prev.style.display = "inline-block";
    new bootstrap.Modal(document.getElementById('methodModal')).show();
}
</script>

<style>
.border-dashed { border-style: dashed !important; border-width: 2px !important; }
.nav-tabs .nav-link.active { background: transparent; border: none; border-bottom: 3px solid #305CDE; }
.card { transition: 0.3s ease; }
.card:hover { transform: translateY(-5px); }
</style>

<?php include 'includes/footer.php'; ?>