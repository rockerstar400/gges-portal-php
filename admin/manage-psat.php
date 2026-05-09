<?php 
require_once '../functions.php';
include 'includes/header.php';
include 'includes/sidebar.php';

$slug = 'psat'; 
$prepData = getTestPrepData($slug); 

// Variables mapping matching React initialState
$hero = $prepData['hero'] ?? [];
$about = $prepData['about'] ?? [];
$features = $prepData['features'] ?? [''];
$tableData = $prepData['table_data'] ?? [['name'=>'','time'=>'','modules'=>'']];
$examPeriod = $prepData['exam_period'] ?? [['name'=>'','time'=>'','modules'=>'']];
$footer_note = $prepData['footer_note'] ?? '';
?>

<!-- FontAwesome for Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    :root { --blue-600: #2563eb; --blue-700: #1d4ed8; --gray-50: #f9fafb; }
    body { background-color: var(--gray-50); font-family: 'Inter', sans-serif; }
    .admin-card { background: white; border-radius: 1.5rem; border-top: 5px solid var(--blue-600); box-shadow: 0 10px 25px rgba(0,0,0,0.05); max-width: 900px; margin: 2rem auto; }
    .input-xl { border-radius: 0.75rem; border: 1px solid #d1d5db; padding: 0.75rem 1rem; transition: 0.3s; }
    .input-xl:focus { border-color: var(--blue-600); box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1); outline: none; }
    .btn-save { background-color: var(--blue-600); border: none; border-radius: 0.75rem; padding: 1rem; font-weight: 700; transition: 0.3s; }
    .btn-save:hover { background-color: var(--blue-700); transform: translateY(-2px); }
    .section-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 1rem; padding: 1.5rem; }
    .remove-btn { background: #fee2e2; color: #ef4444; border: 1px solid #fecaca; border-radius: 0.75rem; width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; }
</style>

<div class="main-content p-4">
    <div class="admin-card p-4 p-md-5">
        
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h2 class="fw-bold text-primary m-0">PSAT PreTest Section</h2>
            <span class="badge bg-light text-muted px-3 py-2 rounded-pill">Edit Mode</span>
        </div>

        <form action="api/admin/save-psat.php" method="POST">
            <input type="hidden" name="slug" value="psat">

            <!-- --- 1. HERO SECTION --- -->
            <div class="mb-5 border-bottom pb-4">
                <h4 class="fw-bold text-dark mb-4 h5">Hero Section</h4>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Main Title</label>
                    <input type="text" name="hero[title]" value="<?= $hero['title'] ?? '' ?>" class="form-control input-xl" placeholder="PSAT TEST PREP">
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Subtitle (Small Text)</label>
                    <input type="text" name="hero[subtitle]" value="<?= $hero['subtitle'] ?? '' ?>" class="form-control input-xl" placeholder="At GGES, we have...">
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Description</label>
                    <textarea name="hero[description]" class="form-control input-xl" rows="4"><?= $hero['description'] ?? '' ?></textarea>
                </div>
            </div>

            <!-- --- 2. FEATURES --- -->
            <div class="mb-5 border-bottom pb-4">
                <h4 class="fw-bold text-dark mb-4 h5">Why Choose GGES (Features)</h4>
                <div id="features-container">
                    <?php foreach($features as $f): ?>
                    <div class="d-flex gap-2 mb-3 align-items-center">
                        <div class="text-success"><i class="fas fa-check-circle fa-lg"></i></div>
                        <input type="text" name="features[]" value="<?= $f ?>" class="form-control input-xl" placeholder="e.g. 15+ Years Experience">
                        <button type="button" class="remove-btn" onclick="this.parentElement.remove()">✕</button>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addPsatFeature()" class="btn btn-link text-primary fw-bold p-0 text-decoration-none">+ Add Feature Point</button>
            </div>

            <!-- --- 3. ABOUT & STRUCTURE TABLE --- -->
            <div class="mb-5 border-bottom pb-4">
                <h4 class="fw-bold text-dark mb-4 h5">All About PSAT & Table</h4>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Heading</label>
                    <input type="text" name="about[heading]" value="<?= $about['heading'] ?? '' ?>" class="form-control input-xl">
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-bold">About Description</label>
                    <textarea name="about[description]" class="form-control input-xl" rows="3"><?= $about['description'] ?? '' ?></textarea>
                </div>

                <div class="section-box mb-4">
                    <h6 class="fw-bold text-dark mb-3">Table Data</h6>
                    <div id="table-rows">
                        <?php foreach($tableData as $row): ?>
                        <div class="row g-2 mb-2">
                            <div class="col-md-4"><input type="text" name="table_name[]" value="<?= $row['name'] ?>" class="form-control input-xl" placeholder="Section Name"></div>
                            <div class="col-md-3"><input type="text" name="table_time[]" value="<?= $row['time'] ?>" class="form-control input-xl" placeholder="Length (mins)"></div>
                            <div class="col-md-4"><input type="text" name="table_modules[]" value="<?= $row['modules'] ?>" class="form-control input-xl" placeholder="Questions/Tasks"></div>
                            <div class="col-md-1"><button type="button" class="btn btn-danger w-100 h-100" style="border-radius:0.75rem" onclick="this.parentElement.parentElement.remove()">✕</button></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" onclick="addRow('table-rows')" class="btn btn-outline-secondary w-100 py-2 border-2 border-dashed mt-2 rounded-3">+ Add Table Row</button>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Table Footer Note</label>
                    <input type="text" name="footer_note" value="<?= $footer_note ?>" class="form-control input-xl">
                </div>
            </div>

            <!-- --- 4. EXAM PERIOD --- -->
            <div class="mb-5">
                <h4 class="fw-bold text-dark mb-4 h5">Exam Period <span class="text-danger">*</span></h4>
                <div class="section-box">
                    <div id="exam-period-rows">
                        <?php foreach($examPeriod as $row): ?>
                        <div class="row g-2 mb-2">
                            <div class="col-md-4"><input type="text" name="exam_name[]" value="<?= $row['name'] ?>" class="form-control input-xl border-info" placeholder="Grade Level"></div>
                            <div class="col-md-3"><input type="text" name="exam_time[]" value="<?= $row['time'] ?>" class="form-control input-xl border-info" placeholder="Season"></div>
                            <div class="col-md-4"><input type="text" name="exam_modules[]" value="<?= $row['modules'] ?>" class="form-control input-xl border-info" placeholder="Exam Name"></div>
                            <div class="col-md-1"><button type="button" class="btn btn-danger w-100 h-100" style="border-radius:0.75rem" onclick="this.parentElement.parentElement.remove()">✕</button></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" onclick="addExamRow()" class="btn btn-outline-info w-100 py-2 border-2 border-dashed mt-2 rounded-3">+ Add Exam Period Row</button>
                </div>
            </div>

            <!-- --- ACTIONS --- -->
            <div class="d-flex gap-3 mt-5 pt-4 border-top">
                <button type="submit" class="btn btn-save btn-primary flex-grow-1 text-white">Save All Changes</button>
                <button type="button" class="btn btn-outline-danger px-4 rounded-4 fw-bold">Delete All</button>
            </div>
        </form>
    </div>
</div>

<script>
function addPsatFeature() {
    const html = `<div class="d-flex gap-2 mb-3 align-items-center"><div class="text-success"><i class="fas fa-check-circle fa-lg"></i></div><input type="text" name="features[]" class="form-control input-xl" placeholder="New Feature Point"><button type="button" class="remove-btn" onclick="this.parentElement.remove()">✕</button></div>`;
    document.getElementById('features-container').insertAdjacentHTML('beforeend', html);
}

function addRow(containerId) {
    const isExam = containerId === 'exam-period-rows';
    const borderClass = isExam ? 'border-info' : '';
    const html = `<div class="row g-2 mb-2"><div class="col-md-4"><input type="text" name="${isExam?'exam':'table'}_name[]" class="form-control input-xl ${borderClass}" placeholder="Name"></div><div class="col-md-3"><input type="text" name="${isExam?'exam':'table'}_time[]" class="form-control input-xl ${borderClass}" placeholder="Time/Season"></div><div class="col-md-4"><input type="text" name="${isExam?'exam':'table'}_modules[]" class="form-control input-xl ${borderClass}" placeholder="Q's / Exam"></div><div class="col-md-1"><button type="button" class="btn btn-danger w-100 h-100" style="border-radius:0.75rem" onclick="this.parentElement.parentElement.remove()">✕</button></div></div>`;
    document.getElementById(containerId).insertAdjacentHTML('beforeend', html);
}

function addExamRow() { addRow('exam-period-rows'); }
</script>

<?php include 'includes/footer.php'; ?>