<?php 
require_once '../functions.php';
include 'includes/header.php';
include 'includes/sidebar.php';

$slug = 'math-science'; 
$prepData = getTestPrepData($slug); 

// Main Section Data (From functions.php Master Fetch)
$sciHeroDesc = $prepData['sci_hero_desc'] ?? '';
$sciTutorDesc = $prepData['sci_tutor_desc'] ?? '';

// Science Details List (CRUD)
$detailsList = $conn->query("SELECT * FROM science_details ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- FontAwesome for Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    :root { --blue-600: #2563eb; --blue-700: #1d4ed8; --gray-50: #f9fafb; }
    body { background-color: var(--gray-50); font-family: 'Inter', sans-serif; }
    
    .main-content { width: 100%; padding: 2rem; }
    .premium-card-wide { 
        background: white; border-radius: 1rem; border-top: 5px solid var(--blue-600); 
        box-shadow: 0 10px 25px rgba(0,0,0,0.05); width: 100%; margin: 0 auto; padding: 2rem;
    }
    
    .section-header { border-bottom: 2px solid #f0f4f8; padding-bottom: 10px; margin-bottom: 20px; font-weight: 700; color: #1e293b; }
    .form-control-custom { border-radius: 0.75rem; border: 1px solid #d1d5db; padding: 0.8rem; transition: 0.3s; }
    .form-control-custom:focus { border-color: var(--blue-600); outline: none; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); }
    
    .table-premium thead { background: #f1f5f9; color: #475569; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; }
    .actions-bar { position: sticky; bottom: 0; background: rgba(255,255,255,0.95); backdrop-filter: blur(8px); padding: 1.5rem; border-top: 1px solid #eee; z-index: 1000; margin-top: 2rem; border-radius: 1rem 1rem 0 0; }
</style>

<div class="main-content">
    <div class="premium-card-wide">
        <h2 class="text-3xl font-bold text-center text-blue-800 mb-5">Common Core Science Management</h2>

        <!-- SECTION 1: MAIN CONTENT -->
        <form action="api/admin/save-math-science.php" method="POST">
            <input type="hidden" name="slug" value="<?= $slug ?>">

            <div class="mb-5 border-bottom pb-4">
                <h4 class="section-header"><i class="fas fa-flask me-2 text-primary"></i>Main Content</h4>
                <div class="mb-4">
                    <label class="small fw-bold text-muted">Main Description</label>
                    <textarea name="description" class="form-control form-control-custom" rows="4" placeholder="Enter Science description..."><?= $sciHeroDesc ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="small fw-bold text-muted">Tutor Description</label>
                    <textarea name="tutor_description" class="form-control form-control-custom" rows="4" placeholder="Enter tutor description..."><?= $sciTutorDesc ?></textarea>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary rounded-pill px-5 shadow-sm">Update Main Content</button>
                </div>
            </div>
        </form>

        <!-- SECTION 2: SCIENCE DETAILS (CRUD) -->
        <div class="mt-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="section-header border-0 mb-0"><i class="fas fa-list-check me-2 text-primary"></i>Science Detail Items</h4>
                <button class="btn btn-primary rounded-pill px-4 shadow-sm" onclick="openDetailModal()">+ Add New Detail</button>
            </div>

            <div class="table-responsive shadow-sm rounded-4 border overflow-hidden">
                <table class="table table-hover align-middle mb-0 text-center">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-3">Image</th>
                            <th>Title</th>
                            <th>Heading</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($detailsList)): foreach($detailsList as $item): ?>
                        <tr>
                            <td><img src="../<?= $item['image'] ?>" class="rounded shadow-sm border" width="60" height="60" style="object-fit: cover;"></td>
                            <td class="fw-bold text-dark"><?= $item['title'] ?></td>
                            <td class="text-muted"><?= $item['heading'] ?></td>
                            <td class="small w-25"><?= substr($item['description'], 0, 50) ?>...</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary rounded-pill me-1" onclick='editDetail(<?= json_encode($item) ?>)'><i class="fas fa-edit"></i></button>
                                <a href="api/admin/handler-science-details.php?delete=<?= $item['id'] ?>" class="btn btn-sm btn-outline-danger rounded-pill" onclick="return confirm('Confirm Delete?')"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr><td colspan="5" class="py-5 text-muted">No details found. Click "+ Add New Detail" to start.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL FOR ADD/EDIT -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form class="modal-content border-0 shadow-lg rounded-4" action="api/admin/handler-science-details.php" method="POST" enctype="multipart/form-data">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold" id="modalLabel">Add Science Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <input type="hidden" name="id" id="detail_id">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="small fw-bold">Title</label>
                        <input type="text" name="title" id="detail_title" class="form-control form-control-custom" required>
                    </div>
                    <div class="col-md-6">
                        <label class="small fw-bold">Heading</label>
                        <input type="text" name="heading" id="detail_heading" class="form-control form-control-custom" required>
                    </div>
                    <div class="col-12">
                        <label class="small fw-bold">Description</label>
                        <textarea name="description" id="detail_desc" class="form-control form-control-custom" rows="4" required></textarea>
                    </div>
                    <div class="col-12">
                        <label class="small fw-bold">Icon/Image</label>
                        <input type="file" name="image" class="form-control form-control-custom" onchange="previewImg(this)">
                        <div class="mt-3 text-center">
                            <img id="prev-img" src="" class="rounded shadow-sm border" width="100" style="display:none;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold">Save Science Item</button>
            </div>
        </form>
    </div>
</div>

<script>
function openDetailModal() {
    document.getElementById('modalLabel').innerText = "Add Science Detail";
    document.getElementById('detail_id').value = "";
    document.getElementById('detail_title').value = "";
    document.getElementById('detail_heading').value = "";
    document.getElementById('detail_desc').value = "";
    document.getElementById('prev-img').style.display = "none";
    new bootstrap.Modal(document.getElementById('detailModal')).show();
}

function editDetail(data) {
    document.getElementById('modalLabel').innerText = "Edit Science Detail";
    document.getElementById('detail_id').value = data.id;
    document.getElementById('detail_title').value = data.title;
    document.getElementById('detail_heading').value = data.heading;
    document.getElementById('detail_desc').value = data.description;
    const prev = document.getElementById('prev-img');
    prev.src = "../" + data.image;
    prev.style.display = "inline-block";
    new bootstrap.Modal(document.getElementById('detailModal')).show();
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