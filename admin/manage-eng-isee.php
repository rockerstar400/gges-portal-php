<?php 
require_once '../functions.php';
include 'includes/header.php';
include 'includes/sidebar.php';

$slug = 'eng-about-isee'; 
$prepData = getTestPrepData($slug); 

// Mapping Arrays from DB JSON (Using Master Function cleaned keys)
$titleList  = $prepData['about_isee_title'] ?? [''];
$purposeList = $prepData['about_isee_purpose'] ?? [''];
$structList  = $prepData['about_isee_struct'] ?? [['heading' => '', 'description' => '']];
?>

<style>
    :root { --blue-600: #2563eb; --blue-700: #1d4ed8; --gray-50: #f9fafb; }
    body { background-color: var(--gray-50); font-family: 'Inter', sans-serif; }
    
    .main-content { width: 100%; padding: 2rem; }
    .admin-card-wide { 
        background: white; border-radius: 1rem; border-top: 5px solid var(--blue-600); 
        box-shadow: 0 10px 25px rgba(0,0,0,0.05); width: 100%; margin: 0 auto; 
    }
    
    .section-header { border-bottom: 2px solid #f0f4f8; padding-bottom: 10px; margin-bottom: 20px; font-weight: 700; color: #1e293b; }
    .input-xl { border-radius: 0.75rem; border: 1px solid #d1d5db; padding: 0.75rem; transition: 0.3s; }
    .input-xl:focus { border-color: var(--blue-600); box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); outline: none; }
    
    .repeater-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 1rem; padding: 1.5rem; position: relative; margin-bottom: 1.5rem; }
    .actions-bar { position: sticky; bottom: 0; background: rgba(255,255,255,0.95); backdrop-filter: blur(8px); padding: 1.5rem; border-top: 1px solid #eee; z-index: 1000; margin-top: 2rem; }
</style>

<div class="main-content">
    <div class="admin-card-wide p-4 p-md-5">
        <h2 class="text-3xl font-bold text-center mb-8 text-blue-800">About ISEE Admin</h2>

        <form action="api/admin/save-eng-isee.php" method="POST">
            <input type="hidden" name="slug" value="<?= $slug ?>">

            <!-- --- 1. TITLE LIST --- -->
            <div class="mb-5 border-bottom pb-5">
                <h4 class="section-header"><i class="fas fa-heading me-2 text-primary"></i>Title Sections</h4>
                <div id="title-container">
                    <?php foreach($titleList as $idx => $t): ?>
                    <div class="d-flex gap-2 mb-2 align-items-center">
                        <input type="text" name="isee_titles[]" value="<?= htmlspecialchars($t) ?>" class="form-control input-xl" placeholder="Title <?= $idx+1 ?>">
                        <?php if($idx > 0): ?>
                            <button type="button" class="btn btn-sm btn-outline-danger px-3 py-2" onclick="this.parentElement.remove()">✕</button>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addSimpleItem('title-container', 'isee_titles[]')" class="btn btn-link text-primary p-0 fw-bold text-decoration-none mt-2">+ Add More Title</button>
            </div>

            <!-- --- 2. PURPOSE LIST --- -->
            <div class="mb-5 border-bottom pb-5">
                <h4 class="section-header"><i class="fas fa-bullseye me-2 text-primary"></i>Purpose Section</h4>
                <div id="purpose-container">
                    <?php foreach($purposeList as $idx => $p): ?>
                    <div class="d-flex gap-2 mb-2 align-items-center">
                        <input type="text" name="isee_purposes[]" value="<?= htmlspecialchars($p) ?>" class="form-control input-xl" placeholder="Purpose point <?= $idx+1 ?>">
                        <?php if($idx > 0): ?>
                            <button type="button" class="btn btn-sm btn-outline-danger px-3 py-2" onclick="this.parentElement.remove()">✕</button>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addSimpleItem('purpose-container', 'isee_purposes[]')" class="btn btn-link text-primary p-0 fw-bold text-decoration-none mt-2">+ Add More Purpose</button>
            </div>

            <!-- --- 3. TEST STRUCTURE (Heading + Desc) --- -->
            <div class="mb-5">
                <h4 class="section-header"><i class="fas fa-sitemap me-2 text-primary"></i>Test Structure</h4>
                <div id="struct-container">
                    <?php foreach($structList as $idx => $s): ?>
                    <div class="repeater-box shadow-sm border-start border-primary border-4">
                        <button type="button" class="btn btn-sm text-danger position-absolute top-0 end-0 m-3 remove-btn" onclick="this.parentElement.remove()">✕ Remove</button>
                        <div class="mb-3">
                            <label class="small fw-bold text-muted">Heading</label>
                            <input type="text" name="struct_heading[]" value="<?= $s['heading'] ?>" class="form-control input-xl fw-bold" placeholder="Structure Heading">
                        </div>
                        <div>
                            <label class="small fw-bold text-muted">Description</label>
                            <textarea name="struct_desc[]" class="form-control input-xl" rows="3" placeholder="Structure description..."><?= $s['description'] ?></textarea>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addStructItem()" class="btn btn-sm btn-outline-primary fw-bold mt-2">
                    <i class="fas fa-plus-circle me-1"></i> Add Test Structure
                </button>
            </div>

            <!-- --- STICKY FOOTER ACTIONS --- -->
            <div class="actions-bar rounded-4 d-flex gap-3 shadow">
                <button type="submit" class="btn btn-primary flex-grow-1 py-3 fw-bold rounded-3 shadow">
                    Save About ISEE Changes
                </button>
                <button type="button" class="btn btn-outline-danger px-5 rounded-3 fw-bold" onclick="location.reload()">
                    Reset
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function addSimpleItem(containerId, name) {
    const html = `<div class="d-flex gap-2 mb-2 align-items-center animate__animated animate__fadeIn"><input type="text" name="${name}" class="form-control input-xl" placeholder="Enter text..."><button type="button" class="btn btn-sm btn-outline-danger px-3 py-2" onclick="this.parentElement.remove()">✕</button></div>`;
    document.getElementById(containerId).insertAdjacentHTML('beforeend', html);
}

function addStructItem() {
    const html = `
    <div class="repeater-box shadow-sm border-start border-primary border-4 animate__animated animate__fadeIn">
        <button type="button" class="btn btn-sm text-danger position-absolute top-0 end-0 m-3 remove-btn" onclick="this.parentElement.remove()">✕ Remove</button>
        <div class="mb-3">
            <label class="small fw-bold text-muted">Heading</label>
            <input type="text" name="struct_heading[]" class="form-control input-xl fw-bold" placeholder="Structure Heading">
        </div>
        <div>
            <label class="small fw-bold text-muted">Description</label>
            <textarea name="struct_desc[]" class="form-control input-xl" rows="3" placeholder="Structure description..."></textarea>
        </div>
    </div>`;
    document.getElementById('struct-container').insertAdjacentHTML('beforeend', html);
}
</script>

<?php include 'includes/footer.php'; ?>