<?php 
require_once '../functions.php';
include 'includes/header.php';
include 'includes/sidebar.php';

$slug = 'isee'; 
$prepData = getTestPrepData($slug); 

// Variables mapping
$heroTitle = $prepData['isee_hero_title'] ?? '';
$heroDesc  = $prepData['isee_hero_desc'] ?? '';
$aboutHeading = $prepData['isee_about_heading'] ?? '';
$aboutDesc = $prepData['isee_about_desc'] ?? '';

$purposeHeading = $prepData['isee_purpose_heading'] ?? '';
$purposePoints  = json_decode($prepData['isee_purpose_json'] ?? '[]', true) ?: [''];

$structureHeading = $prepData['isee_structure_heading'] ?? '';
$structureList    = json_decode($prepData['isee_structure_json'] ?? '[]', true) ?: [['title'=>'','description'=>'']];

$measureHeading = $prepData['isee_measure_heading'] ?? '';
$measureList    = json_decode($prepData['isee_measure_json'] ?? '[]', true) ?: [['title'=>'','description'=>'']];

$regHeading = $prepData['isee_registration_heading'] ?? '';
$regDesc    = $prepData['isee_registration_desc'] ?? '';
?>

<!-- Quill Editor CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<style>
    :root { --blue-600: #2563eb; --blue-700: #1d4ed8; --gray-50: #f9fafb; }
    body { background-color: var(--gray-50); font-family: 'Inter', sans-serif; }
    .admin-card-wide { background: white; border-radius: 1rem; border-top: 5px solid var(--blue-600); box-shadow: 0 10px 25px rgba(0,0,0,0.05); width: 100%; margin: 0 auto; }
    .input-xl { border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.7rem; transition: 0.3s; }
    .input-xl:focus { border-color: var(--blue-600); outline: none; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); }
    .repeater-box { border-radius: 1rem; padding: 1.5rem; margin-bottom: 1rem; position: relative; }
    .bg-blue-subtle { background-color: #f0f7ff; border: 1px solid #dbeafe; }
    .bg-green-subtle { background-color: #f0fdf4; border: 1px solid #dcfce7; }
    .quill-container { background: white; border-radius: 0.5rem; border: 1px solid #d1d5db; margin-bottom: 10px; }
    .actions-bar { position: sticky; bottom: 0; background: rgba(255,255,255,0.9); backdrop-filter: blur(8px); padding: 1.2rem; border-top: 1px solid #eee; z-index: 1000; margin-top: 2rem; }
</style>

<div class="main-content p-4">
    <div class="admin-card-wide p-4 p-md-5">
        <h2 class="text-center fw-bold text-primary mb-5">ISEE Test Admin Panel</h2>

        <form action="api/admin/save-isee.php" method="POST" id="iseeForm">
            <input type="hidden" name="slug" value="isee">

            <!-- --- SECTION 1: HERO --- -->
            <section class="mb-5 border-bottom pb-4">
                <h4 class="fw-bold mb-4">Hero Section</h4>
                <input type="text" name="isee_hero_title" value="<?= $heroTitle ?>" placeholder="Hero Title" class="form-control input-xl mb-3">
                <textarea name="isee_hero_desc" rows="3" placeholder="Hero Description" class="form-control input-xl"><?= $heroDesc ?></textarea>
            </section>

            <!-- --- SECTION 2: ABOUT --- -->
            <section class="mb-5 border-bottom pb-4">
                <h4 class="fw-bold mb-4">About Section</h4>
                <input type="text" name="isee_about_heading" value="<?= $aboutHeading ?>" placeholder="About Heading" class="form-control input-xl mb-3">
                <textarea name="isee_about_desc" rows="3" placeholder="About Description" class="form-control input-xl"><?= $aboutDesc ?></textarea>
            </section>

            <!-- --- SECTION 3: PURPOSE (Simple List) --- -->
            <section class="mb-5 border-bottom pb-4">
                <h4 class="fw-bold mb-4">Purpose</h4>
                <input type="text" name="isee_purpose_heading" value="<?= $purposeHeading ?>" placeholder="Purpose Heading" class="form-control input-xl mb-3">
                <div id="purpose-list">
                    <?php foreach($purposePoints as $pt): ?>
                    <div class="d-flex gap-2 mb-2 align-items-center">
                        <input type="text" name="purpose_points[]" value="<?= $pt ?>" class="form-control input-xl" placeholder="Purpose point">
                        <button type="button" class="btn btn-sm btn-outline-danger remove-btn px-3">✕</button>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addPurpose()" class="btn btn-link text-primary p-0 fw-bold text-decoration-none mt-2">+ Add Purpose Point</button>
            </section>

            <!-- --- SECTION 4: STRUCTURE (Title + Desc) --- -->
            <section class="mb-5 border-bottom pb-4">
                <h4 class="fw-bold mb-4">Test Structure & Levels</h4>
                <input type="text" name="isee_structure_heading" value="<?= $structureHeading ?>" placeholder="Structure Heading" class="form-control input-xl mb-3">
                <div id="structure-list">
                    <?php foreach($structureList as $item): ?>
                    <div class="repeater-box bg-blue-subtle shadow-sm mb-3">
                        <button type="button" class="btn btn-sm text-danger position-absolute top-0 end-0 m-2 remove-btn">Remove</button>
                        <input type="text" name="struct_title[]" value="<?= $item['title'] ?>" class="form-control fw-bold mb-2" placeholder="Level / Section Title">
                        <textarea name="struct_desc[]" rows="2" class="form-control small" placeholder="Description"><?= $item['description'] ?></textarea>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addStructure()" class="btn btn-link text-primary p-0 fw-bold text-decoration-none">+ Add Structure Item</button>
            </section>

            <!-- --- SECTION 5: MEASURE (Quill Title + Desc) --- -->
            <section class="mb-5 border-bottom pb-4">
                <h4 class="fw-bold mb-4">What Sections Measure</h4>
                <input type="text" name="isee_measure_heading" value="<?= $measureHeading ?>" placeholder="Measure Heading" class="form-control input-xl mb-3">
                <div id="measure-list">
                    <?php foreach($measureList as $item): ?>
                    <div class="repeater-box bg-green-subtle shadow-sm mb-3 measure-item">
                        <button type="button" class="btn btn-sm text-danger position-absolute top-0 end-0 m-2 remove-btn">Remove</button>
                        <div class="quill-container">
                            <div class="quill-editor" style="height: 100px;"><?= $item['title'] ?></div>
                            <input type="hidden" name="measure_title[]" class="measure-hidden-title">
                        </div>
                        <textarea name="measure_desc[]" rows="2" class="form-control small" placeholder="Description"><?= $item['description'] ?></textarea>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addMeasure()" class="btn btn-link text-primary p-0 fw-bold text-decoration-none">+ Add Measure Item</button>
            </section>

            <!-- --- SECTION 6: REGISTRATION --- -->
            <section class="mb-5">
                <h4 class="fw-bold mb-4">Registration</h4>
                <input type="text" name="isee_registration_heading" value="<?= $regHeading ?>" placeholder="Registration Heading" class="form-control input-xl mb-3">
                <textarea name="isee_registration_desc" rows="4" placeholder="Registration Description" class="form-control input-xl"><?= $regDesc ?></textarea>
            </section>

            <!-- --- ACTIONS --- -->
            <div class="actions-bar d-flex gap-3 rounded-3">
                <button type="submit" class="btn btn-primary flex-grow-1 py-3 fw-bold shadow">Save All Changes</button>
                <button type="button" class="btn btn-outline-danger px-5 fw-bold">Delete All</button>
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
        modules: { toolbar: [[{header:[1,2,false]}],['bold','italic','underline'],['link'],['clean']] }
    });
}
document.querySelectorAll('.quill-editor').forEach(el => initQuill(el));

function addPurpose() {
    const html = `<div class="d-flex gap-2 mb-2 align-items-center animate__animated animate__fadeIn"><input type="text" name="purpose_points[]" class="form-control input-xl" placeholder="New point"><button type="button" class="btn btn-sm btn-outline-danger remove-btn px-3">✕</button></div>`;
    document.getElementById('purpose-list').insertAdjacentHTML('beforeend', html);
}

function addStructure() {
    const html = `<div class="repeater-box bg-blue-subtle shadow-sm mb-3 animate__animated animate__fadeIn"><button type="button" class="btn btn-sm text-danger position-absolute top-0 end-0 m-2 remove-btn">Remove</button><input type="text" name="struct_title[]" class="form-control fw-bold mb-2" placeholder="Title"><textarea name="struct_desc[]" rows="2" class="form-control small" placeholder="Description"></textarea></div>`;
    document.getElementById('structure-list').insertAdjacentHTML('beforeend', html);
}

function addMeasure() {
    const html = `<div class="repeater-box bg-green-subtle shadow-sm mb-3 measure-item"><button type="button" class="btn btn-sm text-danger position-absolute top-0 end-0 m-2 remove-btn">Remove</button><div class="quill-container"><div class="quill-editor" style="height: 100px;"></div><input type="hidden" name="measure_title[]" class="measure-hidden-title"></div><textarea name="measure_desc[]" rows="2" class="form-control small" placeholder="Description"></textarea></div>`;
    const list = document.getElementById('measure-list');
    list.insertAdjacentHTML('beforeend', html);
    initQuill(list.lastElementChild.querySelector('.quill-editor'));
}

document.addEventListener('click', e => { if(e.target.classList.contains('remove-btn')) e.target.closest('.repeater-box, .d-flex').remove(); });

document.getElementById('iseeForm').onsubmit = function() {
    document.querySelectorAll('.measure-item').forEach(box => {
        box.querySelector('.measure-hidden-title').value = box.querySelector('.ql-editor').innerHTML;
    });
};
</script>

<?php include 'includes/footer.php'; ?>