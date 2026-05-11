<?php 
require_once '../functions.php';
include 'includes/header.php';
include 'includes/sidebar.php';

// Fetch All FAQs
$faqs = $conn->query("SELECT * FROM faqs ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Quill Editor CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<style>
    :root { --blue-600: #2563eb; --blue-700: #1d4ed8; --gray-50: #f9fafb; }
    body { background-color: var(--gray-50); font-family: 'Inter', sans-serif; }
    .main-content { width: 100%; padding: 2rem; }
    .admin-card-wide { background: white; border-radius: 1rem; border-top: 5px solid var(--blue-600); box-shadow: 0 10px 25px rgba(0,0,0,0.05); width: 100%; margin: 0 auto; }
    .quill-wrapper { background: white; border-radius: 0.5rem; border: 1px solid #d1d5db; overflow: hidden; margin-bottom: 1rem; }
    .point-input-group { background: #f8fafc; border-radius: 0.75rem; padding: 10px; margin-bottom: 10px; border: 1px solid #e2e8f0; }
</style>

<div class="main-content">
    <div class="admin-card-wide p-4 p-md-5">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h2 class="fw-bold text-primary m-0">FAQ Management</h2>
            <button class="btn btn-primary rounded-pill px-4 shadow-sm" onclick="openAddModal()">+ Add New FAQ</button>
        </div>

        <!-- FAQ TABLE LIST -->
        <div class="table-responsive rounded-4 border overflow-hidden">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr class="small fw-bold text-muted text-uppercase">
                        <th class="ps-4">#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Points</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($faqs)): foreach($faqs as $idx => $f): 
                        $points = json_decode($f['points_json'], true) ?: [];
                    ?>
                    <tr>
                        <td class="ps-4"><?= $idx + 1 ?></td>
                        <td class="fw-bold text-dark"><?= $f['title'] ?></td>
                        <td>
                            <div class="small text-muted text-truncate" style="max-width: 250px;">
                                <?= strip_tags($f['description']) ?>
                            </div>
                        </td>
                        <td><span class="badge bg-info text-dark rounded-pill"><?= count($points) ?> Points</span></td>
                        <td class="text-center">
                            <button class="btn btn-sm text-primary me-2" onclick='openEditModal(<?= json_encode($f) ?>)'><i class="fas fa-edit"></i></button>
                            <a href="api/admin/save-faq.php?delete=<?= $f['id'] ?>" class="btn btn-sm text-danger" onclick="return confirm('Delete this FAQ?')"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                        <tr><td colspan="5" class="text-center py-5 text-muted">No FAQs found. Click "+ Add New FAQ" to start.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ADD/EDIT MODAL -->
<div class="modal fade" id="faqModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form class="modal-content rounded-4 border-0 shadow-lg" action="api/admin/save-faq.php" method="POST" id="faqForm">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold" id="modalTitle">Add New FAQ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <input type="hidden" name="id" id="faq_id">
                
                <div class="mb-3">
                    <label class="small fw-bold text-muted">Title *</label>
                    <input type="text" name="title" id="faq_title" class="form-control p-2" placeholder="Enter FAQ Question..." required>
                </div>

                <div class="mb-4">
                    <label class="small fw-bold text-muted">Description (Rich Text) *</label>
                    <div class="quill-wrapper">
                        <div id="editor" style="height: 180px;"></div>
                        <input type="hidden" name="description" id="faq_desc_input">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="small fw-bold text-muted d-block mb-2">Detailed Points / Sub-sections</label>
                    <div id="points-container">
                        <!-- Points input boxes will be added here -->
                    </div>
                    <button type="button" onclick="addPointField()" class="btn btn-sm btn-outline-primary mt-2">+ Add Point</button>
                </div>
            </div>
            <div class="modal-footer border-0 p-4">
                <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
var quill = new Quill('#editor', {
    theme: 'snow',
    modules: { toolbar: [[{header:[1,2,false]}],['bold','italic','underline'],['link'],[{list:'ordered'},{list:'bullet'}],['clean']] }
});

function addPointField(value = '') {
    const html = `
    <div class="point-input-group d-flex gap-2 align-items-center animate__animated animate__fadeIn">
        <input type="text" name="points[]" value="${value}" class="form-control border-0 bg-transparent" placeholder="Enter sub-point text...">
        <button type="button" class="btn btn-sm text-danger px-2" onclick="this.parentElement.remove()">✕</button>
    </div>`;
    document.getElementById('points-container').insertAdjacentHTML('beforeend', html);
}

function openAddModal() {
    document.getElementById('modalTitle').innerText = "Add New FAQ";
    document.getElementById('faq_id').value = "";
    document.getElementById('faq_title').value = "";
    quill.root.innerHTML = "";
    document.getElementById('points-container').innerHTML = "";
    addPointField(); // Start with one empty point
    new bootstrap.Modal(document.getElementById('faqModal')).show();
}

function openEditModal(data) {
    document.getElementById('modalTitle').innerText = "Edit FAQ Item";
    document.getElementById('faq_id').value = data.id;
    document.getElementById('faq_title').value = data.title;
    quill.root.innerHTML = data.description;
    
    // Points handling
    const container = document.getElementById('points-container');
    container.innerHTML = "";
    const pointsArray = JSON.parse(data.points_json) || [];
    if(pointsArray.length > 0) {
        pointsArray.forEach(p => addPointField(p));
    } else {
        addPointField();
    }
    
    new bootstrap.Modal(document.getElementById('faqModal')).show();
}

// Sync Quill content before submit
document.getElementById('faqForm').onsubmit = function() {
    document.getElementById('faq_desc_input').value = quill.root.innerHTML;
};
</script>

<?php include 'includes/footer.php'; ?>