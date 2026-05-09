<?php 
require_once '../functions.php';
include 'includes/header.php';
include 'includes/sidebar.php';

$slug = 'kangaroo'; 
$prepData = getTestPrepData($slug); 

// Data Mapping
$hero = $prepData['hero'] ?? [];
$featuresList = json_decode($prepData['kan_feat_json'] ?? '[]', true) ?: [''];
$rulesList = json_decode($prepData['kan_rules_json'] ?? '[]', true) ?: [['text' => '', 'subpoints' => ['']]];
?>

<style>
    :root { --blue-600: #2563eb; --blue-700: #1d4ed8; --gray-50: #f9fafb; }
    body { background-color: var(--gray-50); font-family: 'Inter', sans-serif; }
    
    /* Full Width Logic */
    .main-content { width: 100%; padding: 2rem; }
    .admin-card-wide { 
        background: white; border-radius: 1rem; border-top: 5px solid var(--blue-600); 
        box-shadow: 0 10px 25px rgba(0,0,0,0.05); width: 100%; margin: 0 auto; 
    }
    
    .section-header { border-bottom: 2px solid #f0f4f8; padding-bottom: 10px; margin-bottom: 20px; font-weight: 700; color: #1e293b; }
    .input-xl { border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.75rem; transition: 0.3s; }
    .input-xl:focus { border-color: var(--blue-600); outline: none; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); }
    
    /* Rules & Subpoints Style */
    .rule-block { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 1rem; padding: 1.5rem; position: relative; margin-bottom: 1.5rem; }
    .subpoint-item { background: #ffffff; border-left: 3px solid var(--blue-600); padding-left: 10px; margin-left: 1.5rem; border-radius: 0.25rem; }
    
    .actions-bar { position: sticky; bottom: 0; background: rgba(255,255,255,0.95); backdrop-filter: blur(8px); padding: 1.5rem; border-top: 1px solid #eee; z-index: 1000; margin-top: 2rem; }
</style>

<div class="main-content">
    <div class="admin-card-wide p-4 p-md-5">
        <h2 class="text-3xl font-bold text-center mb-5 text-blue-800">Math Kangaroo Test Prep Admin</h2>

        <form action="api/admin/save-kangaroo.php" method="POST" id="kangarooForm">
            <input type="hidden" name="slug" value="kangaroo">

            <!-- --- SECTION 1: HERO SECTION --- -->
            <div class="mb-5 border-bottom pb-5">
                <h4 class="section-header"><i class="fas fa-rocket me-2 text-primary"></i>Hero Section</h4>
                <div class="row g-4">
                    <div class="col-12">
                        <label class="form-label small fw-bold">Title *</label>
                        <input type="text" name="hero[title]" value="<?= $hero['title'] ?? '' ?>" class="form-control input-xl" placeholder="MATH KANGAROO TEST PREP" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold">Description *</label>
                        <textarea name="hero[description]" class="form-control input-xl" rows="4" required><?= $hero['description'] ?? '' ?></textarea>
                    </div>
                </div>
            </div>

            <!-- --- SECTION 2: TEST STRUCTURE --- -->
            <div class="mb-5 border-bottom pb-5">
                <h4 class="section-header"><i class="fas fa-sitemap me-2 text-primary"></i>Test Structure</h4>
                <div class="mb-4">
                    <label class="form-label small fw-bold">Heading *</label>
                    <input type="text" name="kan_struct_heading" value="<?= $prepData['kan_struct_heading'] ?? '' ?>" class="form-control input-xl" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Description *</label>
                    <textarea name="kan_struct_desc" class="form-control input-xl" rows="4" required><?= $prepData['kan_struct_desc'] ?? '' ?></textarea>
                </div>
            </div>

            <!-- --- SECTION 3: FEATURES --- -->
            <div class="mb-5 border-bottom pb-5">
                <h4 class="section-header"><i class="fas fa-check-circle me-2 text-primary"></i>Features</h4>
                <div class="mb-4">
                    <label class="form-label small fw-bold">Heading *</label>
                    <input type="text" name="kan_feat_heading" value="<?= $prepData['kan_feat_heading'] ?? '' ?>" class="form-control input-xl" required>
                </div>
                <div id="features-container">
                    <?php foreach($featuresList as $f): ?>
                    <div class="d-flex gap-2 mb-2 align-items-center">
                        <span class="text-success"><i class="fas fa-check"></i></span>
                        <input type="text" name="features[]" value="<?= $f ?>" class="form-control input-xl" required>
                        <button type="button" class="btn btn-sm btn-outline-danger remove-btn px-3">✕</button>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addFeature()" class="btn btn-link text-primary fw-bold p-0 text-decoration-none mt-2">+ Add Feature</button>
            </div>

            <!-- --- SECTION 4: GENERAL RULES (Nested Repeater) --- -->
            <div class="mb-5 border-bottom pb-5">
                <h4 class="section-header"><i class="fas fa-list-ol me-2 text-primary"></i>General Rules</h4>
                <div class="mb-4">
                    <label class="form-label small fw-bold">Heading *</label>
                    <input type="text" name="kan_rules_heading" value="<?= $prepData['kan_rules_heading'] ?? '' ?>" class="form-control input-xl" required>
                </div>

                <div id="rules-list">
                    <?php foreach($rulesList as $idx => $rule): ?>
                    <div class="rule-block shadow-sm" data-index="<?= $idx ?>">
                        <button type="button" class="btn btn-sm text-danger position-absolute top-0 end-0 m-3 remove-rule">✕ Remove Rule</button>
                        
                        <label class="small fw-bold text-muted">Main Rule Text *</label>
                        <input type="text" name="rules[<?= $idx ?>][text]" value="<?= $rule['text'] ?>" class="form-control fw-bold mb-3 shadow-sm border-0" style="background:#fff;" required>
                        
                        <div class="subpoints-container ms-4">
                            <label class="text-xs fw-bold text-muted">Subpoints:</label>
                            <div class="sub-list">
                                <?php foreach($rule['subpoints'] as $sp): ?>
                                <div class="d-flex gap-2 mb-2 subpoint-item">
                                    <input type="text" name="rules[<?= $idx ?>][subpoints][]" value="<?= $sp ?>" class="form-control form-control-sm border-0 bg-transparent">
                                    <button type="button" class="btn btn-sm text-danger remove-sub">✕</button>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" onclick="addSubpoint(<?= $idx ?>, this)" class="btn btn-sm btn-link text-primary p-0 text-decoration-none">+ Add Subpoint</button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addRule()" class="btn btn-sm btn-outline-primary fw-bold">+ Add New Rule Block</button>
            </div>

            <!-- --- SECTION 5: SCORING --- -->
            <div class="mb-5">
                <h4 class="section-header"><i class="fas fa-chart-line me-2 text-primary"></i>Scoring</h4>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Heading *</label>
                    <input type="text" name="kan_score_heading" value="<?= $prepData['kan_score_heading'] ?? '' ?>" class="form-control input-xl" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Description *</label>
                    <textarea name="kan_score_desc" class="form-control input-xl" rows="4" required><?= $prepData['kan_score_desc'] ?? '' ?></textarea>
                </div>
            </div>

            <!-- --- STICKY FOOTER --- -->
            <div class="actions-bar rounded-4 d-flex gap-3">
                <button type="submit" class="btn btn-primary flex-grow-1 py-3 fw-bold rounded-3 shadow">
                    Save Math Kangaroo Changes
                </button>
                <button type="button" class="btn btn-outline-danger px-5 rounded-3 fw-bold" onclick="return confirm('Delete all data?')">
                    Delete All
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let ruleCounter = <?= count($rulesList) ?>;

function addFeature() {
    const html = `<div class="d-flex gap-2 mb-2 align-items-center animate__animated animate__fadeIn"><span class="text-success"><i class="fas fa-check"></i></span><input type="text" name="features[]" class="form-control input-xl" required><button type="button" class="btn btn-sm btn-outline-danger remove-btn px-3">✕</button></div>`;
    document.getElementById('features-container').insertAdjacentHTML('beforeend', html);
}

function addRule() {
    const html = `
    <div class="rule-block shadow-sm animate__animated animate__fadeIn" data-index="${ruleCounter}">
        <button type="button" class="btn btn-sm text-danger position-absolute top-0 end-0 m-3 remove-rule">✕ Remove Rule</button>
        <label class="small fw-bold text-muted">Main Rule Text *</label>
        <input type="text" name="rules[${ruleCounter}][text]" class="form-control fw-bold mb-3 shadow-sm border-0" style="background:#fff;" required>
        <div class="subpoints-container ms-4">
            <label class="text-xs fw-bold text-muted">Subpoints:</label>
            <div class="sub-list"></div>
            <button type="button" onclick="addSubpoint(${ruleCounter}, this)" class="btn btn-sm btn-link text-primary p-0 text-decoration-none">+ Add Subpoint</button>
        </div>
    </div>`;
    document.getElementById('rules-list').insertAdjacentHTML('beforeend', html);
    ruleCounter++;
}

function addSubpoint(idx, btn) {
    const list = btn.previousElementSibling;
    const html = `<div class="d-flex gap-2 mb-2 subpoint-item animate__animated animate__fadeIn"><input type="text" name="rules[${idx}][subpoints][]" class="form-control form-control-sm border-0 bg-transparent" placeholder="Enter subpoint..."><button type="button" class="btn btn-sm text-danger remove-sub">✕</button></div>`;
    list.insertAdjacentHTML('beforeend', html);
}

document.addEventListener('click', e => {
    if(e.target.closest('.remove-btn')) e.target.closest('.d-flex').remove();
    if(e.target.closest('.remove-rule')) e.target.closest('.rule-block').remove();
    if(e.target.closest('.remove-sub')) e.target.closest('.subpoint-item').remove();
});
</script>

<?php include 'includes/footer.php'; ?>