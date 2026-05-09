<?php 
require_once '../functions.php';
include 'includes/header.php';
include 'includes/sidebar.php';

$slug = 'sbac'; 
$prepData = getTestPrepData($slug); 

// Mapping Arrays from Database JSON
$assessmentPoints = json_decode($prepData['sbac_assess_points_json'] ?? '[]', true) ?: [['title' => '', 'description' => '']];
?>

<!-- Quill Editor CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<style>
    :root { --blue-600: #2563eb; --blue-700: #1d4ed8; --gray-50: #f9fafb; }
    body { background-color: var(--gray-50); font-family: 'Inter', sans-serif; }
    
    /* Full Width Container Logic */
    .main-content { width: 100%; padding: 2rem; }
    .admin-card-wide { 
        background: white; border-radius: 1rem; border-top: 5px solid var(--blue-600); 
        box-shadow: 0 10px 25px rgba(0,0,0,0.05); width: 100%; margin: 0 auto; 
    }
    
    .section-header { border-bottom: 2px solid #f0f4f8; padding-bottom: 10px; margin-bottom: 20px; font-weight: 700; color: #1e293b; }
    .input-xl { border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.75rem; transition: 0.3s; }
    .input-xl:focus { border-color: var(--blue-600); outline: none; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); }
    
    .point-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 1rem; padding: 1.5rem; position: relative; margin-bottom: 1.5rem; }
    .quill-container { background: white; border-radius: 0.5rem; border: 1px solid #d1d5db; margin-bottom: 10px; }
    
    .actions-bar { position: sticky; bottom: 0; background: rgba(255,255,255,0.95); backdrop-filter: blur(8px); padding: 1.5rem; border-top: 1px solid #eee; z-index: 1000; margin-top: 2rem; }
</style>

<div class="main-content">
    <div class="admin-card-wide p-4 p-md-5">
        <h2 class="text-3xl font-bold text-center mb-8 text-blue-800">SBAC Page Admin</h2>

        <form action="api/admin/save-sbac.php" method="POST" id="sbacForm">
            <input type="hidden" name="slug" value="sbac">

            <!-- --- 1. HERO SECTION --- -->
            <div class="mb-5 border-bottom pb-5">
                <h4 class="section-header"><i class="fas fa-rocket me-2 text-primary"></i>Hero Section</h4>
                <div class="row g-4">
                    <div class="col-12">
                        <label class="form-label small fw-bold">Title *</label>
                        <input type="text" name="sbac_hero_title" value="<?= $prepData['sbac_hero_title'] ?? '' ?>" class="form-control input-xl" placeholder="SBAC TEST PREP" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold">Description *</label>
                        <div class="quill-container">
                            <div id="hero-editor" style="height: 150px;"><?= $prepData['sbac_hero_desc_html'] ?? '' ?></div>
                            <input type="hidden" name="sbac_hero_desc_html" id="hero_desc_input">
                        </div>
                    </div>
                </div>
            </div>

            <!-- --- 2. ABOUT SBAC --- -->
            <div class="mb-5 border-bottom pb-5">
                <h4 class="section-header"><i class="fas fa-info-circle me-2 text-primary"></i>About SBAC</h4>
                <div class="row g-4">
                    <div class="col-12">
                        <label class="form-label small fw-bold">Heading *</label>
                        <input type="text" name="sbac_about_heading" value="<?= $prepData['sbac_about_heading'] ?? '' ?>" class="form-control input-xl" placeholder="About Heading" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold">Description *</label>
                        <textarea name="sbac_about_desc" class="form-control input-xl" rows="5" placeholder="About Description..." required><?= $prepData['sbac_about_desc'] ?? '' ?></textarea>
                    </div>
                </div>
            </div>

            <!-- --- 3. ASSESSMENT DETAILS --- -->
            <div class="mb-5">
                <h4 class="section-header"><i class="fas fa-tasks me-2 text-primary"></i>Assessment Details</h4>
                <div class="row g-4 mb-4">
                    <div class="col-12">
                        <label class="form-label small fw-bold">Heading *</label>
                        <input type="text" name="sbac_assess_heading" value="<?= $prepData['sbac_assess_heading'] ?? '' ?>" class="form-control input-xl" placeholder="Assessment Heading" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold">Description *</label>
                        <textarea name="sbac_assess_desc" class="form-control input-xl" rows="4" placeholder="Assessment Description..." required><?= $prepData['sbac_assess_desc'] ?? '' ?></textarea>
                    </div>
                </div>

                <h5 class="fw-bold mb-3 text-muted">Assessment Points (Title + Description)</h5>
                <div id="assessment-points-list">
                    <?php foreach($assessmentPoints as $idx => $point): ?>
                    <div class="point-box shadow-sm">
                        <?php if($idx > 0): ?>
                        <button type="button" class="btn btn-sm text-danger position-absolute top-0 end-0 m-3 remove-btn"><i class="fas fa-times-circle fa-lg"></i></button>
                        <?php endif; ?>
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Point Title</label>
                            <input type="text" name="point_title[]" value="<?= $point['title'] ?>" class="form-control input-xl fw-bold" placeholder="e.g. Mathematics Assessment" required>
                        </div>
                        <div>
                            <label class="form-label small fw-bold">Description</label>
                            <textarea name="point_description[]" class="form-control input-xl" rows="3" placeholder="Point description..." required><?= $point['description'] ?></textarea>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addPoint()" class="btn btn-sm btn-outline-primary fw-bold mt-2">
                    <i class="fas fa-plus-circle me-1"></i> Add More Assessment Point
                </button>
            </div>

            <!-- --- STICKY FOOTER ACTIONS --- -->
            <div class="actions-bar rounded-4 d-flex gap-3">
                <button type="submit" class="btn btn-primary flex-grow-1 py-3 fw-bold rounded-3 shadow">
                    Save SBAC Changes
                </button>
                <button type="button" class="btn btn-outline-danger px-5 rounded-3 fw-bold" onclick="return confirm('Clear all SBAC data?')">
                    Delete All
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
var heroEditor = new Quill('#hero-editor', {
    theme: 'snow',
    modules: { toolbar: [[{header:[1,2,false]}],['bold','italic','underline'],['link'],[{list:'ordered'},{list:'bullet'}],['clean']] }
});

function addPoint() {
    const html = `
    <div class="point-box shadow-sm animate__animated animate__fadeIn">
        <button type="button" class="btn btn-sm text-danger position-absolute top-0 end-0 m-3 remove-btn"><i class="fas fa-times-circle fa-lg"></i></button>
        <div class="mb-3">
            <label class="form-label small fw-bold">Point Title</label>
            <input type="text" name="point_title[]" class="form-control input-xl fw-bold" placeholder="Point Title" required>
        </div>
        <div>
            <label class="form-label small fw-bold">Description</label>
            <textarea name="point_description[]" class="form-control input-xl" rows="3" placeholder="Point description..." required></textarea>
        </div>
    </div>`;
    document.getElementById('assessment-points-list').insertAdjacentHTML('beforeend', html);
}

document.addEventListener('click', e => {
    if(e.target.closest('.remove-btn')) e.target.closest('.point-box').remove();
});

document.getElementById('sbacForm').onsubmit = function() {
    document.getElementById('hero_desc_input').value = heroEditor.root.innerHTML;
};
</script>

<?php include 'includes/footer.php'; ?>