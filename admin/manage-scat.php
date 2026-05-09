<?php 
require_once '../functions.php';
include 'includes/header.php';
include 'includes/sidebar.php';

$slug = 'scat'; 
$prepData = getTestPrepData($slug); 

// Mapping Arrays
$versionsList = json_decode($prepData['scat_versions_json'] ?? '[]', true) ?: [''];
$formatSections = json_decode($prepData['scat_format_sections_json'] ?? '[]', true) ?: [['title' => '', 'description' => '']];
$scoringLevels = json_decode($prepData['scat_scoring_levels_json'] ?? '[]', true) ?: [['title' => '', 'details' => '']];
$tipsList = json_decode($prepData['scat_tips_json'] ?? '[]', true) ?: [''];
?>

<!-- Quill Editor CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<style>
    :root { --blue-600: #2563eb; --blue-700: #1d4ed8; --gray-50: #f9fafb; }
    body { background-color: var(--gray-50); font-family: 'Inter', sans-serif; }
    .admin-card-wide { background: white; border-radius: 1rem; border-top: 5px solid var(--blue-600); box-shadow: 0 10px 25px rgba(0,0,0,0.05); width: 100%; margin: 0 auto; }
    .input-xl { border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.7rem; transition: 0.3s; }
    .input-xl:focus { border-color: var(--blue-600); outline: none; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); }
    .repeater-box { border-radius: 0.75rem; padding: 1.2rem; margin-bottom: 1rem; position: relative; background: #fff; border: 1px solid #e2e8f0; }
    .quill-container { background: white; border-radius: 0.5rem; border: 1px solid #d1d5db; margin-bottom: 10px; }
    .actions-bar { position: sticky; bottom: 0; background: rgba(255,255,255,0.9); backdrop-filter: blur(8px); padding: 1.2rem; border-top: 1px solid #eee; z-index: 1000; margin-top: 2rem; }
</style>

<div class="main-content p-4">
    <div class="admin-card-wide p-4 p-md-5">
        <h2 class="text-2xl font-bold mb-4">SCAT Test Admin</h2>

        <form action="api/admin/save-scat.php" method="POST" id="scatForm">
            <input type="hidden" name="slug" value="scat">

            <!-- 1. Hero Section -->
            <section class="mb-5 border-bottom pb-4">
                <h5 class="fw-bold mb-3">Hero Section</h5>
                <input type="text" name="scat_hero_title" value="<?= $prepData['scat_hero_title'] ?? '' ?>" placeholder="Hero Title" class="form-control input-xl mb-3">
                <textarea name="scat_hero_desc" rows="3" placeholder="Hero Description" class="form-control input-xl"><?= $prepData['scat_hero_desc'] ?? '' ?></textarea>
            </section>

            <!-- 2. About Section -->
            <section class="mb-5 border-bottom pb-4">
                <h5 class="fw-bold mb-3">About Section</h5>
                <input type="text" name="scat_about_heading" value="<?= $prepData['scat_about_heading'] ?? '' ?>" placeholder="About Heading" class="form-control input-xl mb-3">
                <textarea name="scat_about_desc" rows="3" placeholder="About Description" class="form-control input-xl mb-3"><?= $prepData['scat_about_desc'] ?? '' ?></textarea>
                
                <input type="text" name="scat_versions_heading" value="<?= $prepData['scat_versions_heading'] ?? '' ?>" placeholder="Versions Heading" class="form-control input-xl mb-3">
                
                <label class="small fw-bold mb-2">Versions List</label>
                <div id="versions-list">
                    <?php foreach($versionsList as $v): ?>
                    <div class="d-flex gap-2 mb-2">
                        <input type="text" name="versions[]" value="<?= $v ?>" class="form-control input-xl" placeholder="Version">
                        <button type="button" class="btn btn-outline-danger remove-btn px-3">✕</button>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addItem('versions-list', 'versions[]')" class="btn btn-link text-primary p-0 fw-bold text-decoration-none">+ Add Version</button>
            </section>

            <!-- 3. Format Section -->
            <section class="mb-5 border-bottom pb-4">
                <h5 class="fw-bold mb-3">Format Section</h5>
                <input type="text" name="scat_format_heading" value="<?= $prepData['scat_format_heading'] ?? '' ?>" placeholder="Format Heading" class="form-control input-xl mb-3">
                <textarea name="scat_format_desc" rows="3" placeholder="Format Description" class="form-control input-xl mb-4"><?= $prepData['scat_format_desc'] ?? '' ?></textarea>
                
                <label class="small fw-bold mb-2">Sections</label>
                <div id="format-sections">
                    <?php foreach($formatSections as $sec): ?>
                    <div class="repeater-box shadow-sm">
                        <button type="button" class="btn btn-sm text-danger position-absolute top-0 end-0 m-2 remove-btn">Remove</button>
                        <input type="text" name="format_sec_title[]" value="<?= $sec['title'] ?>" class="form-control mb-2 fw-bold" placeholder="Title">
                        <textarea name="format_sec_desc[]" rows="2" class="form-control small" placeholder="Description"><?= $sec['description'] ?></textarea>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addFormatSection()" class="btn btn-link text-primary p-0 fw-bold text-decoration-none">+ Add Section</button>
            </section>

            <!-- 4. Scoring Section -->
            <section class="mb-5 border-bottom pb-4">
                <h5 class="fw-bold mb-3">Scoring Section</h5>
                <div class="quill-container">
                    <div id="scoring-heading-editor" style="height: 100px;"><?= $prepData['scat_scoring_heading_html'] ?? '' ?></div>
                    <input type="hidden" name="scat_scoring_heading_html" id="scoring_heading_input">
                </div>

                <div id="scoring-levels">
                    <?php foreach($scoringLevels as $lvl): ?>
                    <div class="repeater-box shadow-sm">
                        <button type="button" class="btn btn-sm text-danger position-absolute top-0 end-0 m-2 remove-btn">Remove</button>
                        <input type="text" name="score_lvl_title[]" value="<?= $lvl['title'] ?>" class="form-control mb-2 fw-bold" placeholder="Level Title">
                        <textarea name="score_lvl_details[]" rows="2" class="form-control small" placeholder="Details"><?= $lvl['details'] ?></textarea>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addScoringLevel()" class="btn btn-link text-primary p-0 fw-bold text-decoration-none">+ Add Level</button>
            </section>

            <!-- 5. Tips Section -->
            <section class="mb-5 border-bottom pb-4">
                <h5 class="fw-bold mb-3">Tips Section</h5>
                <input type="text" name="scat_tips_heading" value="<?= $prepData['scat_tips_heading'] ?? '' ?>" placeholder="Tips Heading" class="form-control input-xl mb-3">
                <div id="tips-list">
                    <?php foreach($tipsList as $tip): ?>
                    <div class="d-flex gap-2 mb-2">
                        <input type="text" name="tips[]" value="<?= $tip ?>" class="form-control input-xl" placeholder="Tip">
                        <button type="button" class="btn btn-outline-danger remove-btn px-3">✕</button>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addItem('tips-list', 'tips[]')" class="btn btn-link text-primary p-0 fw-bold text-decoration-none">+ Add Tip</button>
            </section>

            <!-- 6. Registration & Auth -->
            <section class="mb-5">
                <h5 class="fw-bold mb-3">Registration & Auth</h5>
                <input type="text" name="scat_register_heading" value="<?= $prepData['scat_register_heading'] ?? '' ?>" placeholder="Register Heading" class="form-control input-xl mb-3">
                <input type="text" name="scat_register_subheading" value="<?= $prepData['scat_register_subheading'] ?? '' ?>" placeholder="Register Sub Heading" class="form-control input-xl mb-3">
                
                <label class="small fw-bold">Register Contact List</label>
                <div class="quill-container">
                    <div id="register-contact-editor" style="height: 150px;"><?= $prepData['scat_register_contact_html'] ?? '' ?></div>
                    <input type="hidden" name="scat_register_contact_html" id="register_contact_input">
                </div>

                <input type="text" name="scat_auth_heading" value="<?= $prepData['scat_auth_heading'] ?? '' ?>" placeholder="Auth Heading" class="form-control input-xl mb-3 mt-3">
                
                <label class="small fw-bold">Auth Description</label>
                <div class="quill-container">
                    <div id="auth-desc-editor" style="height: 150px;"><?= $prepData['scat_auth_desc_html'] ?? '' ?></div>
                    <input type="hidden" name="scat_auth_desc_html" id="auth_desc_input">
                </div>
            </section>

            <!-- ACTIONS -->
            <div class="actions-bar d-flex gap-3 rounded-3">
                <button type="submit" class="btn btn-primary flex-grow-1 py-3 fw-bold shadow">Save All Changes</button>
                <button type="button" class="btn btn-outline-danger px-5 fw-bold" onclick="return confirm('Clear data?')">Delete</button>
            </div>
        </form>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
function createQuill(id) {
    return new Quill(id, {
        theme: 'snow',
        modules: { toolbar: [[{header:[1,2,false]}],['bold','italic','underline'],['link'],[{list:'ordered'},{list:'bullet'}],['clean']] }
    });
}

const scoringHeaderEditor = createQuill('#scoring-heading-editor');
const registerContactEditor = createQuill('#register-contact-editor');
const authDescEditor = createQuill('#auth-desc-editor');

function addItem(containerId, name) {
    const html = `<div class="d-flex gap-2 mb-2 animate__animated animate__fadeIn"><input type="text" name="${name}" class="form-control input-xl"><button type="button" class="btn btn-sm btn-outline-danger remove-btn px-3">✕</button></div>`;
    document.getElementById(containerId).insertAdjacentHTML('beforeend', html);
}

function addFormatSection() {
    const html = `<div class="repeater-box shadow-sm animate__animated animate__fadeIn"><button type="button" class="btn btn-sm text-danger position-absolute top-0 end-0 m-2 remove-btn">Remove</button><input type="text" name="format_sec_title[]" class="form-control mb-2 fw-bold" placeholder="Title"><textarea name="format_sec_desc[]" rows="2" class="form-control small" placeholder="Description"></textarea></div>`;
    document.getElementById('format-sections').insertAdjacentHTML('beforeend', html);
}

function addScoringLevel() {
    const html = `<div class="repeater-box shadow-sm animate__animated animate__fadeIn"><button type="button" class="btn btn-sm text-danger position-absolute top-0 end-0 m-2 remove-btn">Remove</button><input type="text" name="score_lvl_title[]" class="form-control mb-2 fw-bold" placeholder="Level Title"><textarea name="score_lvl_details[]" rows="2" class="form-control small" placeholder="Details"></textarea></div>`;
    document.getElementById('scoring-levels').insertAdjacentHTML('beforeend', html);
}

document.addEventListener('click', e => { if(e.target.classList.contains('remove-btn')) e.target.closest('.repeater-box, .d-flex').remove(); });

document.getElementById('scatForm').onsubmit = function() {
    document.getElementById('scoring_heading_input').value = scoringHeaderEditor.root.innerHTML;
    document.getElementById('register_contact_input').value = registerContactEditor.root.innerHTML;
    document.getElementById('auth_desc_input').value = authDescEditor.root.innerHTML;
};
</script>

<?php include 'includes/footer.php'; ?>