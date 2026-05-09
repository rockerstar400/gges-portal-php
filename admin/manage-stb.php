<?php 
require_once '../functions.php';
include 'includes/header.php';
include 'includes/sidebar.php';

$slug = 'stb'; 
$prepData = getTestPrepData($slug); 

// Mapping Arrays from DB JSON
$subsetPoints = json_decode($prepData['stb_subset_points_json'] ?? '[]', true) ?: [''];
$subtests = json_decode($prepData['stb_subtests_json'] ?? '[]', true) ?: [['title' => '', 'content' => '']];
$timeTable = json_decode($prepData['stb_timing_json'] ?? '[]', true) ?: [['activity' => '', 'time5th6th' => '', 'time7thPlus' => '']];
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
    
    .repeater-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 1rem; padding: 1.5rem; position: relative; margin-bottom: 1.5rem; }
    .quill-container { background: white; border-radius: 0.5rem; border: 1px solid #d1d5db; margin-bottom: 10px; }
    
    .actions-bar { position: sticky; bottom: 0; background: rgba(255,255,255,0.95); backdrop-filter: blur(8px); padding: 1.5rem; border-top: 1px solid #eee; z-index: 1000; margin-top: 2rem; }
</style>

<div class="main-content">
    <div class="admin-card-wide p-4 p-md-5">
        <h2 class="text-3xl font-bold text-center mb-8 text-blue-800">STB Page Admin</h2>

        <form action="api/admin/save-stb.php" method="POST" id="stbForm">
            <input type="hidden" name="slug" value="stb">

            <!-- --- 1. HERO SECTION --- -->
            <div class="mb-5 border-bottom pb-5">
                <h4 class="section-header"><i class="fas fa-rocket me-2 text-primary"></i>Hero Section</h4>
                <div class="row g-4">
                    <div class="col-12">
                        <label class="form-label small fw-bold">Main Title *</label>
                        <input type="text" name="hero_title" value="<?= $prepData['hero_section']['title'] ?? '' ?>" class="form-control input-xl" placeholder="e.g. STB TEST PREP" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold">Hero Description *</label>
                        <textarea name="hero_description" class="form-control input-xl" rows="3" placeholder="Description..." required><?= $prepData['hero_section']['description'] ?? '' ?></textarea>
                    </div>
                </div>
            </div>

            <!-- --- 2. ABOUT THE STB (Quill) --- -->
            <div class="mb-5 border-bottom pb-5">
                <h4 class="section-header"><i class="fas fa-info-circle me-2 text-primary"></i>About the STB</h4>
                <div class="row g-4">
                    <div class="col-12">
                        <label class="form-label small fw-bold">Heading *</label>
                        <input type="text" name="stb_about_h" value="<?= $prepData['stb_about_h'] ?? '' ?>" class="form-control input-xl mb-3" placeholder="Heading..." required>
                        <label class="form-label small fw-bold">Description *</label>
                        <div class="quill-container">
                            <div id="about-editor" style="height: 200px;"><?= $prepData['stb_about_desc_html'] ?? '' ?></div>
                            <input type="hidden" name="stb_about_desc_html" id="about_desc_input">
                        </div>
                    </div>
                </div>
            </div>

            <!-- --- 3. STB USAGE DETAILS --- -->
            <div class="mb-5 border-bottom pb-5">
                <h4 class="section-header"><i class="fas fa-list-check me-2 text-primary"></i>STB Usage Details</h4>
                <div class="mb-4">
                    <label class="form-label small fw-bold">Intro Description</label>
                    <textarea name="stb_used_desc" class="form-control input-xl" rows="3"><?= $prepData['stb_used_desc'] ?? '' ?></textarea>
                </div>

                <h6 class="fw-bold mb-3 text-muted">STB Subset Points</h6>
                <div id="subset-points-container">
                    <?php foreach($subsetPoints as $p): ?>
                    <div class="d-flex gap-2 mb-2">
                        <input type="text" name="stb_subset_points[]" value="<?= $p ?>" class="form-control input-xl" placeholder="Enter point...">
                        <button type="button" class="btn btn-sm btn-outline-danger px-3 remove-btn">✕</button>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addPoint()" class="btn btn-sm btn-link text-blue-600 p-0 text-decoration-none">+ Add Point</button>

                <div class="mt-4">
                    <label class="form-label small fw-bold">Description after the bullet points</label>
                    <textarea name="stb_subset_desc" class="form-control input-xl" rows="3"><?= $prepData['stb_subset_desc'] ?? '' ?></textarea>
                </div>
            </div>

            <!-- --- 4. STB SUBTESTS (Repeater) --- -->
            <div class="mb-5 border-bottom pb-5">
                <h4 class="section-header"><i class="fas fa-vial me-2 text-primary"></i>STB Subtests</h4>
                <input type="text" name="stb_subtest_heading" value="<?= $prepData['stb_subtest_heading'] ?? '' ?>" class="form-control input-xl mb-4" placeholder="Heading (e.g. STB Subtests)">
                
                <div id="subtests-container">
                    <?php foreach($subtests as $item): ?>
                    <div class="repeater-box shadow-sm border-start border-primary border-4">
                        <button type="button" class="btn btn-sm text-danger position-absolute top-0 end-0 m-3 remove-btn"><i class="fas fa-times-circle fa-lg"></i></button>
                        <input type="text" name="st_title[]" value="<?= $item['title'] ?>" class="form-control fw-bold mb-3" placeholder="Subtest Title" required>
                        <textarea name="st_content[]" class="form-control" rows="3" placeholder="Description..." required><?= $item['content'] ?></textarea>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addSubtest()" class="btn btn-sm btn-outline-primary fw-bold">+ Add Subtest</button>
            </div>

            <!-- --- 5. IMPORTANT INFO & TABLE --- -->
            <div class="mb-5">
                <h4 class="section-header"><i class="fas fa-clock me-2 text-primary"></i>Important Testing Information</h4>
                <div class="row g-4 mb-4">
                    <div class="col-12">
                        <label class="form-label small fw-bold">Heading</label>
                        <input type="text" name="stb_info_h" value="<?= $prepData['stb_info_h'] ?? '' ?>" class="form-control input-xl mb-3">
                        <label class="form-label small fw-bold">Info Text</label>
                        <textarea name="stb_info_desc" class="form-control input-xl" rows="3"><?= $prepData['stb_info_desc'] ?? '' ?></textarea>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded border">
                    <h6 class="fw-bold mb-3">Timing Table Data</h6>
                    <div class="row g-2 mb-2 text-xs font-bold text-muted text-center d-none d-md-flex">
                        <div class="col-4 text-start">Subtest/Activity</div>
                        <div class="col-4">5th/6th Graders Time</div>
                        <div class="col-3">7th+ Graders Time</div>
                    </div>
                    <div id="timing-table">
                        <?php foreach($timeTable as $row): ?>
                        <div class="row g-2 mb-2 table-data-row">
                            <div class="col-4"><input type="text" name="row_activity[]" value="<?= $row['activity'] ?>" class="form-control"></div>
                            <div class="col-4"><input type="text" name="row_56[]" value="<?= $row['time5th6th'] ?>" class="form-control"></div>
                            <div class="col-3"><input type="text" name="row_7plus[]" value="<?= $row['time7thPlus'] ?>" class="form-control"></div>
                            <div class="col-1 text-center"><button type="button" class="btn btn-sm text-danger remove-btn">✕</button></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" onclick="addTableRow()" class="btn btn-sm btn-link text-blue-600">+ Add Table Row</button>
                </div>
            </div>

            <!-- --- STICKY FOOTER --- -->
            <div class="actions-bar rounded-4 d-flex gap-3 shadow">
                <button type="submit" class="btn btn-primary flex-grow-1 py-3 fw-bold rounded-3 shadow">
                    Save STB Changes
                </button>
                <button type="button" class="btn btn-outline-danger px-5 rounded-3 fw-bold" onclick="return confirm('Clear data?')">
                    Delete
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
var aboutEditor = new Quill('#about-editor', {
    theme: 'snow',
    modules: { toolbar: [[{color:[]},{background:[]}],['bold','italic','underline'],[{list:'ordered'},{list:'bullet'}],['link'],['clean']] }
});

function addPoint() {
    const html = `<div class="d-flex gap-2 mb-2 animate__animated animate__fadeIn"><input type="text" name="stb_subset_points[]" class="form-control input-xl" placeholder="Enter point..."><button type="button" class="btn btn-sm btn-outline-danger remove-btn px-3">✕</button></div>`;
    document.getElementById('subset-points-container').insertAdjacentHTML('beforeend', html);
}

function addSubtest() {
    const html = `<div class="repeater-box shadow-sm border-start border-primary border-4 animate__animated animate__fadeIn"><button type="button" class="btn btn-sm text-danger position-absolute top-0 end-0 m-3 remove-btn"><i class="fas fa-times-circle fa-lg"></i></button><input type="text" name="st_title[]" class="form-control fw-bold mb-3" placeholder="Subtest Title" required><textarea name="st_content[]" class="form-control" rows="3" placeholder="Description..." required></textarea></div>`;
    document.getElementById('subtests-container').insertAdjacentHTML('beforeend', html);
}

function addTableRow() {
    const html = `<div class="row g-2 mb-2 table-data-row animate__animated animate__fadeIn"><div class="col-4"><input type="text" name="row_activity[]" class="form-control"></div><div class="col-4"><input type="text" name="row_56[]" class="form-control"></div><div class="col-3"><input type="text" name="row_7plus[]" class="form-control"></div><div class="col-1 text-center"><button type="button" class="btn btn-sm text-danger remove-btn">✕</button></div></div>`;
    document.getElementById('timing-table').insertAdjacentHTML('beforeend', html);
}

document.addEventListener('click', e => {
    if(e.target.closest('.remove-btn')) e.target.closest('.d-flex, .repeater-box, .table-data-row').remove();
});

document.getElementById('stbForm').onsubmit = function() {
    document.getElementById('about_desc_input').value = aboutEditor.root.innerHTML;
};
</script>

<?php include 'includes/footer.php'; ?>