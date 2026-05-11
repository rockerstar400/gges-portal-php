<?php 
require_once '../functions.php';
include 'includes/header.php';
include 'includes/sidebar.php';

// Fetch all terms
$termsList = $conn->query("SELECT * FROM terms_services ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Quill Editor CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<style>
    :root { --blue-600: #2563eb; --blue-700: #1d4ed8; --gray-50: #f9fafb; }
    body { background-color: var(--gray-50); font-family: 'Inter', sans-serif; }
    .main-content { width: 100%; padding: 2rem; }
    .admin-card-wide { background: white; border-radius: 1rem; border-top: 5px solid var(--blue-600); box-shadow: 0 10px 25px rgba(0,0,0,0.05); width: 100%; margin: 0 auto; }
    .input-xl { border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.7rem; transition: 0.3s; }
    .repeater-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 1rem; padding: 1.5rem; position: relative; margin-bottom: 1.5rem; }
    .quill-container { background: white; border-radius: 0.5rem; border: 1px solid #d1d5db; margin-bottom: 10px; }
    .actions-bar { position: sticky; bottom: 0; background: rgba(255,255,255,0.95); backdrop-filter: blur(8px); padding: 1.2rem; border-top: 1px solid #eee; z-index: 1000; margin-top: 2rem; }
</style>

<div class="main-content">
    <div class="admin-card-wide p-4 p-md-5">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h2 class="fw-bold text-primary m-0">Terms & Service Management</h2>
            <button class="btn btn-primary rounded-pill px-4 shadow-sm" onclick="openAddModal()">+ Add New Section</button>
        </div>

        <!-- LIST TABLE -->
        <!-- <div class="table-responsive rounded-4 border overflow-hidden">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr class="small fw-bold text-muted text-uppercase">
                        <th class="ps-4">Title</th>
                        <th>Intro Preview</th>
                        <th>Sub-Points</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($termsList)): foreach($termsList as $item): 
                        $points = json_decode($item['points_json'], true) ?: [];
                    ?>
                    <tr>
                        <td class="ps-4 fw-bold text-dark"><?= $item['title'] ?></td>
                        <td class="text-muted small"><?= substr($item['description'], 0, 60) ?>...</td>
                        <td><span class="badge bg-blue-100 text-primary rounded-pill"><?= count($points) ?> Points</span></td>
                        <td class="text-center">
                            <button class="btn btn-sm text-success me-2" onclick='viewTerm(<?= json_encode($item) ?>)'><i class="fas fa-eye"></i></button>
                            <button class="btn btn-sm text-primary me-2" onclick='openEditModal(<?= json_encode($item) ?>)'><i class="fas fa-edit"></i></button>
                            <a href="api/admin/save-terms.php?delete=<?= $item['id'] ?>" class="btn btn-sm text-danger" onclick="return confirm('Delete this section?')"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                        <tr><td colspan="4" class="text-center py-5 text-muted">No terms added yet.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div> -->

        <div class="table-responsive rounded-4 border overflow-hidden">
    <table class="table table-hover align-middle mb-0" style="table-layout: fixed; width: 100%;">
        <thead class="bg-light">
            <tr class="small fw-bold text-muted text-uppercase">
                <th style="width: 20%;" class="ps-4">Title</th>
                <th style="width: 40%;">Intro Preview</th>
                <th style="width: 15%;">Sub-Points</th>
                <th style="width: 25%;" class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            <?php if(!empty($termsList)): foreach($termsList as $item): 
                $points = json_decode($item['points_json'], true) ?: [];
                // 🔥 IMPORTANT: JSON ko safe banana taaki HTML na tute
                $safeJson = htmlspecialchars(json_encode($item), ENT_QUOTES, 'UTF-8');
            ?>
            <tr>
                <td class="ps-4 fw-bold text-dark text-truncate"><?= htmlspecialchars($item['title']) ?></td>
                <td class="text-muted small">
                    <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        <?= strip_tags($item['description']) ?>
                    </div>
                </td>
                <td><span class="badge bg-primary bg-opacity-10 text-primary rounded-pill"><?= count($points) ?> Points</span></td>
                <td class="text-center">
                    <div class="d-flex justify-content-center gap-2">
                        <button class="btn btn-sm btn-outline-success border-0" onclick='viewTerm(<?= $safeJson ?>)' title="View"><i class="fas fa-eye"></i></button>
                        <button class="btn btn-sm btn-outline-primary border-0" onclick='openEditModal(<?= $safeJson ?>)' title="Edit"><i class="fas fa-edit"></i></button>
                        <a href="api/admin/save-terms.php?delete=<?= $item['id'] ?>" class="btn btn-sm btn-outline-danger border-0" onclick="return confirm('Delete this section?')"><i class="fas fa-trash-alt"></i></a>
                    </div>
                </td>
            </tr>
            <?php endforeach; else: ?>
                <tr><td colspan="4" class="text-center py-5 text-muted">No terms added yet.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
    </div>
</div>

<!-- ADD/EDIT MODAL -->
<div class="modal fade" id="termModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <form class="modal-content rounded-4 border-0 shadow-lg" action="api/admin/save-terms.php" method="POST" id="termForm">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold" id="modalTitle">Add Term Section</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <input type="hidden" name="id" id="term_id">
                
                <div class="mb-4">
                    <label class="small fw-bold text-muted uppercase">Section Title *</label>
                    <input type="text" name="title" id="term_title" class="form-control input-xl" placeholder="e.g. FEES AND PAYMENTS" required>
                </div>

                <div class="mb-4">
                    <label class="small fw-bold text-muted uppercase">Main Description (Intro)</label>
                    <textarea name="description" id="term_desc" class="form-control input-xl" rows="3"></textarea>
                </div>

                <div class="bg-light p-4 rounded-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <label class="fw-bold text-dark">Detailed Points / Sub-sections</label>
                        <button type="button" class="btn btn-sm btn-primary" onclick="addPointField()">+ Add Point</button>
                    </div>
                    <div id="points-container">
                        <!-- Dynamic Point Rows -->
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 p-4">
                <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<!-- VIEW PREVIEW MODAL -->
<div class="modal fade" id="viewModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 p-4 border-0 shadow">
            <div id="viewContent"></div>
            <button class="btn btn-secondary mt-4 w-100 rounded-pill" data-bs-dismiss="modal">Close Preview</button>
        </div>
    </div>
</div>

<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
function initQuill(el) {
    return new Quill(el, {
        theme: 'snow',
        modules: { toolbar: [[{color:[]},{background:[]}],['bold','italic','underline'],['link'],[{list:'ordered'},{list:'bullet'}],['clean']] }
    });
}

function addPointField(subtitle = '', desc = '') {
    const id = Date.now() + Math.floor(Math.random() * 1000);
    const html = `
    <div class="repeater-box shadow-sm point-row animate__animated animate__fadeIn">
        <button type="button" class="btn btn-sm text-danger position-absolute top-0 end-0 m-2" onclick="this.parentElement.remove()">✕</button>
        <div class="row g-3">
            <div class="col-md-4">
                <label class="text-xs fw-bold text-muted">HIGHLIGHT/SUBTITLE</label>
                <input type="text" name="point_subtitle[]" value="${subtitle}" class="form-control input-xl shadow-sm" placeholder="e.g. AGREEMENT">
            </div>
            <div class="col-md-8">
                <label class="text-xs fw-bold text-muted">POINT DESCRIPTION</label>
                <div class="quill-container">
                    <div id="editor-${id}" class="point-editor" style="height: 120px;">${desc}</div>
                    <input type="hidden" name="point_desc[]" class="point-hidden-input">
                </div>
            </div>
        </div>
    </div>`;
    document.getElementById('points-container').insertAdjacentHTML('beforeend', html);
    initQuill(`#editor-${id}`);
}

function openAddModal() {
    document.getElementById('modalTitle').innerText = "Add Term Section";
    document.getElementById('term_id').value = "";
    document.getElementById('term_title').value = "";
    document.getElementById('term_desc').value = "";
    document.getElementById('points-container').innerHTML = "";
    addPointField();
    new bootstrap.Modal(document.getElementById('termModal')).show();
}

// function openEditModal(data) {
//     document.getElementById('modalTitle').innerText = "Edit Term Section";
//     document.getElementById('term_id').value = data.id;
//     document.getElementById('term_title').value = data.title;
//     document.getElementById('term_desc').value = data.description;
    
//     const container = document.getElementById('points-container');
//     container.innerHTML = "";
//     const pts = JSON.parse(data.points_json) || [];
//     pts.forEach(p => addPointField(p.subtitle, p.desc));
    
//     new bootstrap.Modal(document.getElementById('termModal')).show();
// }


function openEditModal(data) {
    // UI clean up
    document.getElementById('modalTitle').innerText = "Edit Term Section";
    document.getElementById('term_id').value = data.id;
    document.getElementById('term_title').value = data.title;
    document.getElementById('term_desc').value = data.description;
    
    const container = document.getElementById('points-container');
    container.innerHTML = "";
    
    // JSON parse points
    let pts = [];
    try {
        pts = typeof data.points_json === 'string' ? JSON.parse(data.points_json) : data.points_json;
    } catch(e) { pts = []; }

    if(pts && pts.length > 0) {
        pts.forEach(p => addPointField(p.subtitle, p.desc));
    } else {
        addPointField();
    }
    
    new bootstrap.Modal(document.getElementById('termModal')).show();
}

// function viewTerm(data) {
//     const pts = JSON.parse(data.points_json) || [];
//     let html = `<h2 class="text-primary fw-bold text-uppercase mb-3">${data.title}</h2>`;
//     html += `<p class="text-muted mb-4">${data.description}</p>`;
//     pts.forEach(p => {
//         html += `<div class="mb-3"><strong>${p.subtitle}</strong> ${p.desc}</div>`;
//     });
//     document.getElementById('viewContent').innerHTML = html;
//     new bootstrap.Modal(document.getElementById('viewModal')).show();
// }

function viewTerm(data) {
    let pts = [];
    try {
        pts = typeof data.points_json === 'string' ? JSON.parse(data.points_json) : data.points_json;
    } catch(e) { pts = []; }

    let html = `<h2 class="text-primary fw-bold text-uppercase mb-3">${data.title}</h2>`;
    html += `<div class="text-muted mb-4 fs-5" style="white-space:pre-line">${data.description}</div>`;
    html += `<div class="space-y-4">`;
    pts.forEach(p => {
        html += `<div class="mb-3 p-3 bg-light rounded">
                    <h6 class="fw-bold text-dark">${p.subtitle}</h6>
                    <div>${p.desc}</div>
                 </div>`;
    });
    html += `</div>`;
    
    document.getElementById('viewContent').innerHTML = html;
    new bootstrap.Modal(document.getElementById('viewModal')).show();
}

document.getElementById('termForm').onsubmit = function() {
    document.querySelectorAll('.point-row').forEach(row => {
        row.querySelector('.point-hidden-input').value = row.querySelector('.ql-editor').innerHTML;
    });
};
</script>

<?php include 'includes/footer.php'; ?>