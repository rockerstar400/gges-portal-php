<?php 
require_once '../functions.php';
include 'includes/header.php';
include 'includes/sidebar.php';

$slug = 'act'; 
$prepData = getTestPrepData($slug); 

// Variables mapping from DB JSON
$hero = $prepData['hero'] ?? [];
$aboutList = json_decode($prepData['act_about_json'] ?? '[]', true) ?: [['title' => '', 'description' => '']];
$addInfoList = json_decode($prepData['act_additional_json'] ?? '[]', true) ?: [['title' => '', 'description' => '']];
$actTestList = json_decode($prepData['act_test_sections_json'] ?? '[]', true) ?: [['title' => '', 'description' => '']];
?>

<!-- Quill Editor CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<style>
    :root { --blue-600: #2563eb; --blue-700: #1d4ed8; --gray-50: #f9fafb; }
    body { background-color: var(--gray-50); font-family: 'Inter', sans-serif; }
    
    /* Full Width Logic */
    .main-content { width: 100%; padding: 2rem; }
    .admin-card-wide { 
        background: white; border-radius: 1rem; border-top: 5px solid var(--blue-600); 
        box-shadow: 0 10px 25px rgba(0,0,0,0.05); width: 100%; margin: 0 auto; 
    }
    
    .section-title { color: var(--blue-600); font-weight: 700; font-size: 1.5rem; }
    .input-xl { border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.75rem; transition: 0.3s; }
    .input-xl:focus { border-color: var(--blue-600); outline: none; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); }
    
    .repeater-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1.5rem; position: relative; margin-bottom: 1rem; }
    .quill-container { background: white; border-radius: 0.5rem; border: 1px solid #d1d5db; margin-bottom: 10px; }
    
    .actions-bar { position: sticky; bottom: 0; background: rgba(255,255,255,0.95); backdrop-filter: blur(8px); padding: 1.5rem; border-top: 1px solid #eee; z-index: 1000; margin-top: 2rem; }
</style>

<div class="main-content">
    <div class="admin-card-wide p-4 p-md-5">
        <h2 class="text-3xl font-bold text-center mb-8 text-blue-800">ACT Test Preparation — Admin</h2>

        <form action="api/admin/save-act.php" method="POST" id="actForm">
            <input type="hidden" name="slug" value="act">

            <!-- --- SECTION 1: HERO SECTION --- -->
            <section class="mb-5 border-bottom pb-5">
                <h4 class="fw-bold text-gray-700 mb-4">Hero Section <span class="text-red-500">*</span></h4>
                <input type="text" name="hero[title]" value="<?= $hero['title'] ?? '' ?>" class="form-control input-xl mb-4" placeholder="Hero Title..." required>
                <textarea name="hero[description]" class="form-control input-xl" rows="3" placeholder="Hero Description..." required><?= $hero['description'] ?? '' ?></textarea>
            </section>

            <!-- --- SECTION 2: ABOUT ACT SECTION --- -->
            <section class="mb-5 border-bottom pb-5">
                <h4 class="fw-bold text-gray-700 mb-4">About ACT Section <span class="text-red-500">*</span></h4>
                <input type="text" name="about[heading]" value="<?= $prepData['about']['heading'] ?? '' ?>" class="form-control input-xl mb-3" placeholder="About Heading..." required>
                <textarea name="about[description]" class="form-control input-xl mb-4" rows="4" placeholder="About Description..." required><?= $prepData['about']['description'] ?? '' ?></textarea>

                <h6 class="fw-bold mb-3">About List Items:</h6>
                <div id="about-list">
                    <?php foreach($aboutList as $item): ?>
                    <div class="repeater-box shadow-sm">
                        <button type="button" class="btn btn-sm text-danger position-absolute top-0 end-0 m-2 remove-btn">✕ Remove</button>
                        <input type="text" name="about_titles[]" value="<?= $item['title'] ?>" class="form-control mb-2" placeholder="Title...">
                        <textarea name="about_descs[]" class="form-control" rows="2" placeholder="Description..."><?= $item['description'] ?></textarea>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addAboutItem()" class="btn btn-sm btn-link text-blue-600 p-0 text-decoration-none">+ Add About Item</button>
            </section>

            <!-- --- SECTION 3: ADDITIONAL INFO --- -->
            <section class="mb-5 border-bottom pb-5">
                <h4 class="fw-bold text-gray-700 mb-4">Additional Info <span class="text-red-500">*</span></h4>
                <input type="text" name="act_additional_heading" value="<?= $prepData['act_additional_heading'] ?? '' ?>" class="form-control input-xl mb-4" placeholder="Additional info heading...">

                <h6 class="fw-bold mb-3">Add List Items:</h6>
                <div id="additional-list">
                    <?php foreach($addInfoList as $item): ?>
                    <div class="repeater-box shadow-sm">
                        <button type="button" class="btn btn-sm text-danger position-absolute top-0 end-0 m-2 remove-btn">✕ Remove</button>
                        <input type="text" name="add_titles[]" value="<?= $item['title'] ?>" class="form-control mb-2" placeholder="Title...">
                        <textarea name="add_descs[]" class="form-control" rows="2" placeholder="Description..."><?= $item['description'] ?></textarea>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addAddInfoItem()" class="btn btn-sm btn-link text-blue-600 p-0 text-decoration-none">+ Add Additional Info</button>
            </section>

            <!-- --- SECTION 4: ACT TEST SECTIONS (Quill Editor) --- -->
            <section class="mb-5">
                <h4 class="fw-bold text-gray-700 mb-4">ACT Test Sections <span class="text-red-500">*</span></h4>
                <input type="text" name="act_test_sections_heading" value="<?= $prepData['act_test_sections_heading'] ?? '' ?>" class="form-control input-xl mb-4" placeholder="ACT Test Heading...">

                <div id="act-test-list">
                    <?php foreach($actTestList as $item): ?>
                    <div class="repeater-box shadow-sm act-test-item">
                        <button type="button" class="btn btn-sm text-danger position-absolute top-0 end-0 m-2 remove-btn">✕ Remove</button>
                        <input type="text" name="act_titles[]" value="<?= $item['title'] ?>" class="form-control mb-2 fw-bold" placeholder="ACT Test Section Title...">
                        
                        <div class="quill-container">
                            <div class="quill-editor" style="height: 150px;"><?= $item['description'] ?></div>
                            <input type="hidden" name="act_descs[]" class="act-desc-input">
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addActItem()" class="btn btn-sm btn-link text-blue-600 p-0 text-decoration-none">+ Add ACT Item</button>
            </section>

            <!-- --- STICKY FOOTER ACTIONS --- -->
            <div class="actions-bar rounded-4 d-flex gap-3">
                <button type="submit" class="btn btn-primary flex-grow-1 py-3 fw-bold rounded-3 shadow">Save All Changes</button>
                <button type="button" class="btn btn-outline-danger px-5 fw-bold" onclick="return confirm('Clear data?')">Delete All</button>
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
        modules: { toolbar: [['bold', 'italic', 'underline'], [{list:'ordered'},{list:'bullet'}], ['clean']] }
    });
}

document.querySelectorAll('.quill-editor').forEach(el => initQuill(el));

function addAboutItem() {
    const html = `<div class="repeater-box shadow-sm"><button type="button" class="btn btn-sm text-danger position-absolute top-0 end-0 m-2 remove-btn">✕ Remove</button><input type="text" name="about_titles[]" class="form-control mb-2" placeholder="Title..."><textarea name="about_descs[]" class="form-control" rows="2" placeholder="Description..."></textarea></div>`;
    document.getElementById('about-list').insertAdjacentHTML('beforeend', html);
}

function addAddInfoItem() {
    const html = `<div class="repeater-box shadow-sm"><button type="button" class="btn btn-sm text-danger position-absolute top-0 end-0 m-2 remove-btn">✕ Remove</button><input type="text" name="add_titles[]" class="form-control mb-2" placeholder="Title..."><textarea name="add_descs[]" class="form-control" rows="2" placeholder="Description..."></textarea></div>`;
    document.getElementById('additional-list').insertAdjacentHTML('beforeend', html);
}

function addActItem() {
    const html = `
    <div class="repeater-box shadow-sm act-test-item">
        <button type="button" class="btn btn-sm text-danger position-absolute top-0 end-0 m-2 remove-btn">✕ Remove</button>
        <input type="text" name="act_titles[]" class="form-control mb-2 fw-bold" placeholder="ACT Test Section Title...">
        <div class="quill-container"><div class="quill-editor" style="height: 150px;"></div><input type="hidden" name="act_descs[]" class="act-desc-input"></div>
    </div>`;
    const container = document.getElementById('act-test-list');
    container.insertAdjacentHTML('beforeend', html);
    initQuill(container.lastElementChild.querySelector('.quill-editor'));
}

document.addEventListener('click', e => { if(e.target.classList.contains('remove-btn')) e.target.closest('.repeater-box').remove(); });

document.getElementById('actForm').onsubmit = function() {
    document.querySelectorAll('.act-test-item').forEach(item => {
        item.querySelector('.act-desc-input').value = item.querySelector('.ql-editor').innerHTML;
    });
};
</script>

<?php include 'includes/footer.php'; ?>