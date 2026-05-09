<?php 
require_once '../functions.php';
include 'includes/header.php';
include 'includes/sidebar.php';

$slug = 'math-amc'; 
$prepData = getTestPrepData($slug); 

// Variables mapping based on React logic
$hero = $prepData['hero'] ?? [];
// Master function logic: amc_participate_json becomes amc_participate
$participationList = $prepData['amc_participate'] ?? [''];
$whyTakeList       = $prepData['amc_why'] ?? [''];
$competitions      = $prepData['amc_competitions'] ?? [['title'=>'','amc'=>'','description'=>'','for'=>'','when'=>'']];
?>

<!-- Quill Editor CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<style>
    :root { --blue-600: #2563eb; --blue-700: #1d4ed8; --gray-50: #f9fafb; }
    body { background-color: var(--gray-50); font-family: 'Inter', sans-serif; }
    
    .main-content { width: 100%; padding: 2rem; }
    .admin-card-wide { 
        background: white; border-radius: 1rem; border-top: 5px solid var(--blue-600); 
        box-shadow: 0 10px 25px rgba(0,0,0,0.05); width: 100%; margin: 0 auto; 
    }
    
    .section-header { border-bottom: 2px solid #f0f4f8; padding-bottom: 10px; margin-bottom: 20px; font-weight: 700; color: #1e293b; }
    .input-xl { border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.75rem; transition: 0.3s; }
    .input-xl:focus { border-color: var(--blue-600); outline: none; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); }
    
    .comp-card { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 1rem; padding: 1.5rem; position: relative; margin-bottom: 1.5rem; }
    .quill-container { background: white; border-radius: 0.5rem; border: 1px solid #d1d5db; margin-bottom: 10px; }
    
    .actions-bar { position: sticky; bottom: 0; background: rgba(255,255,255,0.95); backdrop-filter: blur(8px); padding: 1.5rem; border-top: 1px solid #eee; z-index: 1000; margin-top: 2rem; }
</style>

<div class="main-content">
    <div class="admin-card-wide p-4 p-md-5">
        <h2 class="text-3xl font-bold text-center mb-8 text-blue-800">AMC Competition Management</h2>

        <form action="api/admin/save-math-amc.php" method="POST" id="amcForm">
            <input type="hidden" name="slug" value="<?= $slug ?>">

            <!-- --- SECTION 1: HERO SECTION --- -->
            <div class="mb-5 border-bottom pb-5">
                <h4 class="section-header"><i class="fas fa-trophy me-2 text-primary"></i>Hero Section</h4>
                <div class="row g-4">
                    <div class="col-12">
                        <label class="form-label small fw-bold">Title *</label>
                        <input type="text" name="hero[title]" value="<?= $hero['title'] ?? '' ?>" class="form-control input-xl" placeholder="AMC TEST PREP" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold">Description *</label>
                        <textarea name="hero[description]" class="form-control input-xl" rows="3" placeholder="Hero Description..." required><?= $hero['description'] ?? '' ?></textarea>
                    </div>
                </div>
            </div>

            <!-- --- SECTION 2: PARTICIPATE --- -->
            <div class="mb-5 border-bottom pb-5">
                <h4 class="section-header"><i class="fas fa-users me-2 text-primary"></i>Participate</h4>
                <div id="participate-list">
                    <?php foreach($participationList as $idx => $p): ?>
                    <div class="d-flex gap-2 mb-2">
                        <input type="text" name="participation[]" value="<?= htmlspecialchars($p) ?>" class="form-control input-xl" placeholder="Participate condition <?= $idx+1 ?>" required>
                        <?php if($idx > 0): ?>
                            <button type="button" class="btn btn-sm btn-outline-danger px-3 remove-btn">✕</button>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addItem('participate-list', 'participation[]')" class="btn btn-link text-primary p-0 fw-bold text-decoration-none mt-2">+ Add Condition</button>
            </div>

            <!-- --- SECTION 3: WHY TAKE --- -->
            <div class="mb-5 border-bottom pb-5">
                <h4 class="section-header"><i class="fas fa-question-circle me-2 text-primary"></i>Why Take</h4>
                <div id="why-list">
                    <?php foreach($whyTakeList as $idx => $w): ?>
                    <div class="d-flex gap-2 mb-2">
                        <input type="text" name="why_take[]" value="<?= htmlspecialchars($w) ?>" class="form-control input-xl" placeholder="Reason <?= $idx+1 ?>" required>
                        <?php if($idx > 0): ?>
                            <button type="button" class="btn btn-sm btn-outline-danger remove-btn px-3">✕</button>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addItem('why-list', 'why_take[]')" class="btn btn-link text-primary p-0 fw-bold text-decoration-none mt-2">+ Add Why Take</button>
            </div>

            <!-- --- SECTION 4: COMPETITIONS (Complex Repeater) --- -->
            <div class="mb-5">
                <h4 class="section-header"><i class="fas fa-medal me-2 text-primary"></i>Competitions</h4>
                <div id="competitions-container">
                    <?php foreach($competitions as $idx => $comp): ?>
                    <div class="comp-card shadow-sm border-start border-primary border-5">
                        <button type="button" class="btn btn-sm text-danger position-absolute top-0 end-0 m-2 remove-btn" style="text-decoration:none;">✕ Remove Competition</button>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="small fw-bold text-muted">AMC Title</label>
                                <input type="text" name="comp_title[]" value="<?= $comp['title'] ?>" class="form-control fw-bold" placeholder="e.g. AMC 8" required>
                            </div>
                            <div class="col-md-3">
                                <label class="small fw-bold text-muted">For</label>
                                <input type="text" name="comp_for[]" value="<?= $comp['for'] ?>" class="form-control" placeholder="e.g. Students under 15" required>
                            </div>
                            <div class="col-md-3">
                                <label class="small fw-bold text-muted">When</label>
                                <input type="text" name="comp_when[]" value="<?= $comp['when'] ?>" class="form-control" placeholder="e.g. January annually" required>
                            </div>
                            <div class="col-12">
                                <label class="small fw-bold text-muted">AMC Detail (Quill Editor)</label>
                                <div class="quill-container">
                                    <div class="comp-editor" style="height: 120px;"><?= $comp['amc'] ?></div>
                                    <input type="hidden" name="comp_amc_html[]" class="comp-hidden-input">
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="small fw-bold text-muted">Short Description</label>
                                <textarea name="comp_desc[]" class="form-control" rows="2" placeholder="25 questions..." required><?= $comp['description'] ?></textarea>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addCompetitionBlock()" class="btn btn-sm btn-outline-primary fw-bold">+ Add Competition</button>
            </div>

            <!-- --- ACTIONS --- -->
            <div class="actions-bar d-flex gap-3 rounded-3 shadow">
                <button type="submit" class="btn btn-primary flex-grow-1 py-3 fw-bold shadow">Save AMC Changes</button>
                <button type="button" class="btn btn-outline-danger px-5 fw-bold" onclick="location.reload()">Reset</button>
            </div>
        </form>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
function initQuill(el) {
    return new Quill(el, {
        theme: 'snow',
        modules: { toolbar: [[{color:[]},{background:[]}],['bold','italic','underline'],['link'],['clean']] }
    });
}
document.querySelectorAll('.comp-editor').forEach(el => initQuill(el));

function addItem(containerId, name) {
    const html = `<div class="d-flex gap-2 mb-2 animate__animated animate__fadeIn"><input type="text" name="${name}" class="form-control input-xl" required><button type="button" class="btn btn-sm btn-outline-danger remove-btn px-3">✕</button></div>`;
    document.getElementById(containerId).insertAdjacentHTML('beforeend', html);
}

function addCompetitionBlock() {
    const html = `
    <div class="comp-card shadow-sm border-start border-primary border-5 animate__animated animate__fadeIn">
        <button type="button" class="btn btn-sm text-danger position-absolute top-0 end-0 m-2 remove-btn" style="text-decoration:none;">✕ Remove Competition</button>
        <div class="row g-3">
            <div class="col-md-6"><label class="small fw-bold text-muted">AMC Title</label><input type="text" name="comp_title[]" class="form-control fw-bold" placeholder="e.g. AMC 8" required></div>
            <div class="col-md-3"><label class="small fw-bold text-muted">For</label><input type="text" name="comp_for[]" class="form-control" placeholder="For..." required></div>
            <div class="col-md-3"><label class="small fw-bold text-muted">When</label><input type="text" name="comp_when[]" class="form-control" placeholder="When..." required></div>
            <div class="col-12">
                <label class="small fw-bold text-muted">AMC Detail</label>
                <div class="quill-container"><div class="comp-editor" style="height: 120px;"></div><input type="hidden" name="comp_amc_html[]" class="comp-hidden-input"></div>
            </div>
            <div class="col-12"><label class="small fw-bold text-muted">Short Description</label><textarea name="comp_desc[]" class="form-control" rows="2" required></textarea></div>
        </div>
    </div>`;
    const container = document.getElementById('competitions-container');
    container.insertAdjacentHTML('beforeend', html);
    initQuill(container.lastElementChild.querySelector('.comp-editor'));
}

document.addEventListener('click', e => {
    if(e.target.classList.contains('remove-btn')) e.target.closest('.d-flex, .comp-card').remove();
});

document.getElementById('amcForm').onsubmit = function() {
    document.querySelectorAll('.comp-card').forEach(card => {
        card.querySelector('.comp-hidden-input').value = card.querySelector('.ql-editor').innerHTML;
    });
};
</script>

<?php include 'includes/footer.php'; ?>