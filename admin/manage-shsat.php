<?php 
require_once '../functions.php';
include 'includes/header.php';
include 'includes/sidebar.php';

$slug = 'shsat'; 
$prepData = getTestPrepData($slug); 

// Mapping Variables based on React initialState
$hero = $prepData['hero'] ?? [];
$aboutItems = $prepData['about']['items'] ?? [['title' => '', 'content' => '']];
$structure = $prepData['structure'] ?? [];
$structurePoints = $structure['bullets'] ?? [''];
?>

<!-- Quill Editor CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<style>
    :root { --blue-600: #2563eb; --blue-800: #1e40af; --gray-50: #f9fafb; }
    body { background-color: var(--gray-50); font-family: 'Inter', sans-serif; }
    .admin-card { background: white; border-radius: 1rem; border-top: 5px solid var(--blue-600); box-shadow: 0 10px 25px rgba(0,0,0,0.05); max-width: 900px; margin: 2rem auto; }
    .section-title { color: var(--blue-800); font-weight: 700; border-bottom: 2px solid #eee; padding-bottom: 10px; margin-bottom: 20px; }
    .input-xl { border-radius: 0.75rem; border: 1px solid #d1d5db; padding: 0.75rem; transition: 0.3s; }
    .input-xl:focus { border-color: var(--blue-600); box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); outline: none; }
    .about-item-box { background: #f0f7ff; border: 1px solid #dbeafe; border-radius: 1rem; padding: 1.5rem; position: relative; margin-bottom: 1.5rem; }
    .quill-wrapper { background: white; border-radius: 0.5rem; margin-top: 10px; }
    .btn-save-sticky { position: sticky; bottom: 20px; z-index: 100; background: white; padding: 15px; border-radius: 1rem; box-shadow: 0 -5px 20px rgba(0,0,0,0.05); }
</style>

<div class="main-content p-4">
    <div class="admin-card p-4 p-md-5">
        <h2 class="text-center section-title">SHSAT PreTest Section</h2>

        <form action="api/admin/save-shsat.php" method="POST" id="shsatForm">
            <input type="hidden" name="slug" value="shsat">

            <!-- --- SECTION 1: TOP SECTION (HERO) --- -->
            <div class="mb-5">
                <h4 class="fw-bold text-dark mb-4 h5">Top Section</h4>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Page Title *</label>
                    <input type="text" name="hero[title]" value="<?= $hero['title'] ?? '' ?>" class="form-control input-xl" placeholder="e.g. SHSAT Test Prep" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Description (Top Paragraphs) *</label>
                    <textarea name="hero[description]" class="form-control input-xl" rows="5" required><?= $hero['description'] ?? '' ?></textarea>
                </div>
            </div>

            <!-- --- SECTION 2: ALL ABOUT SHSAT (DYNAMIC ITEMS) --- -->
            <div class="mb-5">
                <h4 class="fw-bold text-dark mb-4 h5">All About SHSAT</h4>
                <div id="about-items-container">
                    <?php foreach($aboutItems as $idx => $item): ?>
                    <div class="about-item-box shadow-sm animate__animated animate__fadeIn">
                        <button type="button" class="btn btn-sm btn-link text-danger position-absolute top-0 end-0 m-2 remove-btn" style="text-decoration:none;">✕ Remove</button>
                        
                        <div class="mb-3">
                            <label class="text-xs fw-bold text-primary">Item Title *</label>
                            <input type="text" name="about_titles[]" value="<?= $item['title'] ?>" class="form-control fw-bold border-0 shadow-sm" placeholder="Heading (Blue Text)">
                        </div>
                        
                        <label class="text-xs fw-bold text-muted">Item Content *</label>
                        <div class="quill-wrapper">
                            <div class="editor" style="height: 150px;"><?= $item['content'] ?></div>
                            <input type="hidden" name="about_contents[]" class="content-input">
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addAboutItem()" class="btn btn-link text-primary fw-bold p-0 text-decoration-none">+ Add About Section Item</button>
            </div>

            <!-- --- SECTION 3: TEST STRUCTURE (BULLETS) --- -->
            <div class="mb-5">
                <h4 class="fw-bold text-dark mb-4 h5">Test Structure</h4>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Heading *</label>
                    <input type="text" name="struct[title]" value="<?= $structure['title'] ?? '' ?>" class="form-control input-xl" required>
                </div>

                <div class="p-4 rounded-4" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                    <label class="fw-bold small text-muted mb-3 d-block">Bullet Points *</label>
                    <div id="bullet-container">
                        <?php foreach($structurePoints as $pt): ?>
                        <div class="d-flex gap-2 mb-2 align-items-center">
                            <span class="text-muted">•</span>
                            <input type="text" name="struct_bullets[]" value="<?= $pt ?>" class="form-control input-xl" placeholder="e.g. 57 questions in each section">
                            <button type="button" class="btn btn-sm text-danger px-2 remove-btn">✕</button>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" onclick="addBullet()" class="btn btn-link text-primary fw-bold p-0 mt-2 text-decoration-none">+ Add Bullet Point</button>
                </div>
            </div>

            <!-- --- STICKY ACTIONS --- -->
            <div class="btn-save-sticky d-flex gap-3">
                <button type="submit" class="btn btn-primary flex-grow-1 py-3 fw-bold rounded-3 shadow">Save All Changes</button>
                <button type="button" class="btn btn-outline-danger px-4 rounded-3 fw-bold">Delete All</button>
            </div>

        </form>
    </div>
</div>

<!-- Quill & Script -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
function initQuill(el) {
    return new Quill(el, {
        theme: 'snow',
        modules: { toolbar: [[{header:[1,2,3,false]}],['bold','italic','underline'],['link'],['clean']] }
    });
}

// Initialize existing editors
document.querySelectorAll('.editor').forEach(el => initQuill(el));

function addAboutItem() {
    const html = `
    <div class="about-item-box shadow-sm">
        <button type="button" class="btn btn-sm btn-link text-danger position-absolute top-0 end-0 m-2 remove-btn" style="text-decoration:none;">✕ Remove</button>
        <div class="mb-3">
            <label class="text-xs fw-bold text-primary">Item Title *</label>
            <input type="text" name="about_titles[]" class="form-control fw-bold border-0 shadow-sm" placeholder="Heading (Blue Text)">
        </div>
        <label class="text-xs fw-bold text-muted">Item Content *</label>
        <div class="quill-wrapper">
            <div class="editor" style="height: 150px;"></div>
            <input type="hidden" name="about_contents[]" class="content-input">
        </div>
    </div>`;
    const container = document.getElementById('about-items-container');
    container.insertAdjacentHTML('beforeend', html);
    initQuill(container.lastElementChild.querySelector('.editor'));
}

function addBullet() {
    const html = `<div class="d-flex gap-2 mb-2 align-items-center"><span class="text-muted">•</span><input type="text" name="struct_bullets[]" class="form-control input-xl" placeholder="Bullet point text..."><button type="button" class="btn btn-sm text-danger px-2 remove-btn">✕</button></div>`;
    document.getElementById('bullet-container').insertAdjacentHTML('beforeend', html);
}

// Global Remove Logic
document.addEventListener('click', e => {
    if(e.target.classList.contains('remove-btn')) {
        e.target.closest('.about-item-box, .d-flex').remove();
    }
});

// Sync Quill before Submit
document.getElementById('shsatForm').onsubmit = function() {
    document.querySelectorAll('.about-item-box').forEach(box => {
        const quillHtml = box.querySelector('.ql-editor').innerHTML;
        box.querySelector('.content-input').value = quillHtml;
    });
};
</script>

<?php include 'includes/footer.php'; ?>