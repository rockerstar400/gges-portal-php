<?php 
require_once '../functions.php';
include 'includes/header.php';
include 'includes/sidebar.php';

$slug = 'sat'; 
$data = getTestPrepData($slug); 

// Mapping fields from Database JSON
$hero = $data['hero'] ?? [];
$about = $data['about'] ?? [];
$features = $data['features'] ?? [''];
$tableData = $data['table_data'] ?? [['name'=>'','time'=>'','modules'=>'']];
?>

<!-- FontAwesome for Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    :root { --blue-600: #2563eb; --blue-700: #1d4ed8; --gray-50: #f9fafb; }
    body { background-color: var(--gray-50); font-family: 'Inter', sans-serif; }
    .admin-card { background: white; border-radius: 1.5rem; border-top: 5px solid var(--blue-600); box-shadow: 0 10px 25px rgba(0,0,0,0.05); max-width: 900px; margin: 2rem auto; }
    .input-xl { border-radius: 0.75rem; border: 1px solid #d1d5db; padding: 0.75rem 1rem; transition: 0.3s; }
    .input-xl:focus { border-color: var(--blue-600); ring: 2px var(--blue-600); outline: none; }
    .btn-save { background-color: var(--blue-600); border: none; border-radius: 0.75rem; padding: 0.8rem; font-weight: 700; transition: 0.3s; }
    .btn-save:hover { background-color: var(--blue-700); transform: translateY(-2px); box-shadow: 0 5px 15px rgba(37, 99, 235, 0.3); }
    .badge-edit { background: #f3f4f6; color: #6b7280; padding: 0.4rem 1rem; border-radius: 99px; font-size: 0.85rem; }
    .remove-btn { background: #fee2e2; color: #ef4444; border: 1px solid #fecaca; border-radius: 0.75rem; padding: 0.75rem; transition: 0.2s; }
    .remove-btn:hover { background: #fecaca; }
</style>

<div class="main-content p-4">
    <div class="admin-card p-4 p-md-5">
        
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h2 class="fw-bold text-dark m-0" style="color: #1e40af !important;">SAT Page Admin</h2>
            <span class="badge-edit">Edit Mode</span>
        </div>

        <form action="api/admin/save-sat.php" method="POST" id="satForm">
            <input type="hidden" name="slug" value="sat">

            <!-- --- 1. HERO SECTION --- -->
            <div class="mb-5 border-bottom pb-4">
                <h4 class="fw-bold text-dark mb-4">Hero Section</h4>
                
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">Main Title <span class="text-danger">*</span></label>
                    <input type="text" name="hero[title]" value="<?= $hero['title'] ?? '' ?>" class="form-control input-xl" placeholder="SAT TEST PREP" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">Subtitle (Small Text) <span class="text-danger">*</span></label>
                    <input type="text" name="hero[subtitle]" value="<?= $hero['subtitle'] ?? '' ?>" class="form-control input-xl" placeholder="At GGES, we have..." required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">Description <span class="text-danger">*</span></label>
                    <textarea name="hero[description]" class="form-control input-xl" rows="4" required><?= $hero['description'] ?? '' ?></textarea>
                </div>
            </div>

            <!-- --- 2. FEATURES --- -->
            <div class="mb-5 border-bottom pb-4">
                <h4 class="fw-bold text-dark mb-4">Why Choose GGES (Features) <span class="text-danger">*</span></h4>
                <div id="features-list">
                    <?php foreach($features as $f): ?>
                    <div class="d-flex gap-2 mb-3 align-items-center">
                        <div class="text-success"><i class="fas fa-check-circle fa-lg"></i></div>
                        <input type="text" name="features[]" value="<?= $f ?>" class="form-control input-xl" placeholder="e.g. 15+ Years Experience">
                        <button type="button" class="remove-btn" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addFeature()" class="btn btn-link text-primary fw-bold p-0 text-decoration-none">+ Add Feature Point</button>
            </div>

            <!-- --- 3. ABOUT & TABLE --- -->
            <div class="mb-4">
                <h4 class="fw-bold text-dark mb-4">All About SAT & Table</h4>
                
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">Heading <span class="text-danger">*</span></label>
                    <input type="text" name="about[heading]" value="<?= $about['heading'] ?? '' ?>" class="form-control input-xl" placeholder="ALL ABOUT SAT" required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold small text-muted">About Description <span class="text-danger">*</span></label>
                    <textarea name="about[description]" class="form-control input-xl" rows="3" required><?= $about['description'] ?? '' ?></textarea>
                </div>

                <!-- Table Editor -->
                <div class="p-4 rounded-4" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                    <h6 class="fw-bold text-dark mb-3">Table Data <span class="text-danger">*</span></h6>
                    <div id="table-rows">
                        <?php foreach($tableData as $row): ?>
                        <div class="row g-2 mb-3">
                            <div class="col-md-4"><input type="text" name="table_name[]" value="<?= $row['name'] ?>" class="form-control input-xl" placeholder="Section Name"></div>
                            <div class="col-md-3"><input type="text" name="table_time[]" value="<?= $row['time'] ?>" class="form-control input-xl" placeholder="Time Allowed"></div>
                            <div class="col-md-4"><input type="text" name="table_modules[]" value="<?= $row['modules'] ?>" class="form-control input-xl" placeholder="Questions/Tasks"></div>
                            <div class="col-md-1"><button type="button" class="btn btn-danger w-100 p-3 rounded-3" onclick="this.parentElement.parentElement.remove()">✕</button></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" onclick="addTableRow()" class="btn btn-outline-secondary w-100 py-3 border-2 border-dashed mt-2" style="border-radius: 0.75rem;">+ Add Table Row</button>
                </div>

                <div class="mt-4">
                    <label class="form-label fw-bold small text-muted">Table Footer Note <span class="text-danger">*</span></label>
                    <input type="text" name="footer_note" value="<?= $data['footer_note'] ?? '' ?>" class="form-control input-xl" placeholder="The second module difficulty..." required>
                </div>
            </div>

            <!-- --- ACTIONS --- -->
            <div class="d-flex gap-3 mt-5 pt-4 border-top">
                <button type="submit" class="btn btn-save btn-primary flex-grow-1 text-white">Save All Changes</button>
                <a href="manage-sat.php?delete_all=1" onclick="return confirm('Clear everything?')" class="btn btn-outline-danger px-4 py-3 fw-bold rounded-4">Delete All</a>
            </div>

        </form>
    </div>
</div>

<script>
function addFeature() {
    const html = `<div class="d-flex gap-2 mb-3 align-items-center">
        <div class="text-success"><i class="fas fa-check-circle fa-lg"></i></div>
        <input type="text" name="features[]" class="form-control input-xl" placeholder="New Feature Point">
        <button type="button" class="remove-btn" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
    </div>`;
    document.getElementById('features-list').insertAdjacentHTML('beforeend', html);
}

function addTableRow() {
    const html = `<div class="row g-2 mb-3">
        <div class="col-md-4"><input type="text" name="table_name[]" class="form-control input-xl" placeholder="Section Name"></div>
        <div class="col-md-3"><input type="text" name="table_time[]" class="form-control input-xl" placeholder="Time"></div>
        <div class="col-md-4"><input type="text" name="table_modules[]" class="form-control input-xl" placeholder="Tasks"></div>
        <div class="col-md-1"><button type="button" class="btn btn-danger w-100 p-3 rounded-3" onclick="this.parentElement.parentElement.remove()">✕</button></div>
    </div>`;
    document.getElementById('table-rows').insertAdjacentHTML('beforeend', html);
}
</script>

<?php include 'includes/footer.php'; ?>