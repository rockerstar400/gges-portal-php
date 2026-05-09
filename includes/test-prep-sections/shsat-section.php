<?php 
require_once '../functions.php';
include 'includes/header.php';
include 'includes/sidebar.php';

$slug = 'shsat'; 
$prepData = getTestPrepData($slug); 

// Variables mapping matching React initialState
$hero = $prepData['hero'] ?? [];
$aboutItems = $prepData['about']['items'] ?? [['title' => '', 'content' => '']];
$structure = $prepData['structure'] ?? [];
$structPoints = $structure['bullets'] ?? [''];
?>

<!-- Quill Editor CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<style>
    :root { --blue-600: #2563eb; --blue-800: #1e40af; --gray-50: #f9fafb; }
    body { background-color: var(--gray-50); font-family: 'Inter', sans-serif; }
    
    /* Full Width Container */
    .main-content { width: 100%; padding: 2rem; }
    .admin-card-wide { 
        background: white; 
        border-radius: 1rem; 
        border-top: 5px solid var(--blue-600); 
        box-shadow: 0 10px 25px rgba(0,0,0,0.05); 
        width: 100%; /* Pura Width */
        margin: 0 auto;
    }
    
    .section-title { color: var(--blue-800); font-weight: 700; font-size: 1.75rem; }
    .input-xl { border-radius: 0.75rem; border: 1px solid #d1d5db; padding: 0.8rem; transition: 0.3s; }
    .input-xl:focus { border-color: var(--blue-600); box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); outline: none; }
    
    /* React Style Blue Boxes */
    .about-item-box { background: #f0f7ff; border: 1px solid #dbeafe; border-radius: 1.25rem; padding: 1.5rem; position: relative; margin-bottom: 1.5rem; }
    .quill-editor-container { background: white; border-radius: 0.5rem; margin-top: 8px; border: 1px solid #d1d5db; }
    
    /* Sticky Bottom Actions */
    .actions-bar { 
        position: sticky; bottom: 0; background: rgba(255,255,255,0.9); 
        backdrop-filter: blur(10px); padding: 1.5rem; border-top: 1px solid #eee; 
        z-index: 1000; margin-top: 3rem; 
    }
</style>

<div class="main-content">
    <div class="admin-card-wide p-4 p-md-5">
        <h2 class="text-center section-title mb-5">SHSAT PreTest Section</h2>

        <form action="api/admin/save-shsat.php" method="POST" id="shsatForm">
            <input type="hidden" name="slug" value="shsat">

            <!-- --- SECTION 1: TOP SECTION (HERO) --- -->
            <div class="mb-5 border-bottom pb-5">
                <h4 class="fw-bold text-dark mb-4"><i class="fas fa-heading me-2 text-primary"></i>Top Section</h4>
                <div class="row g-4">
                    <div class="col-12">
                        <label class="form-label small fw-bold text-muted">Page Title *</label>
                        <input type="text" name="hero[title]" value="<?= $hero['title'] ?? '' ?>" class="form-control input-xl" placeholder="e.g. SHSAT Test Prep" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold text-muted">Description (Top Paragraphs) *</label>
                        <textarea name="hero[description]" class="form-control input-xl" rows="5" required><?= $hero['description'] ?? '' ?></textarea>
                    </div>
                </div>
            </div>

            <!-- --- SECTION 2: ALL ABOUT SHSAT (DYNAMIC REPEATER) --- -->
            <div class="mb-5 border-bottom pb-5">
                <h4 class="fw-bold text-dark mb-4"><i class="fas fa-list-alt me-2 text-primary"></i>All About SHSAT</h4>
                <div id="about-items-wrapper">
                    <?php foreach($aboutItems as $idx => $item): ?>
                    <div class="about-item-box shadow-sm">
                        <button type="button" class="btn btn-sm text-red-500 position-absolute top-0 end-0 m-3 remove-btn" style="color: #ef4444;"><i class="fas fa-times-circle fa-lg"></i></button>
                        
                        <div class="mb-3">
                            <label class="text-xs fw-bold text-blue-800">Item Title *</label>
                            <input type="text" name="about_titles[]" value="<?= $item['title'] ?>" class="form-control fw-bold shadow-sm" style="border-radius: 8px; color: #1e40af;" placeholder="Heading (Blue Text)">
                        </div>
                        
                        <label class="text-xs fw-bold text-muted">Item Content *</label>
                        <div class="quill-editor-container">
                            <div class="quill-instance" style="height: 200px;"><?= $item['content'] ?></div>
                            <input type="hidden" name="about_contents[]" class="quill-hidden-input">
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addAboutBlock()" class="btn btn-link text-primary fw-bold p-0 text-decoration-none mt-2">
                    <i class="fas fa-plus-circle me-1"></i> Add About Section Item
                </button>
            </div>

            <!-- --- SECTION 3: TEST STRUCTURE --- -->
            <div class="mb-5">
                <h4 class="fw-bold text-dark mb-4"><i class="fas fa-project-diagram me-2 text-primary"></i>Test Structure</h4>
                <div class="mb-4">
                    <label class="form-label small fw-bold text-muted">Heading *</label>
                    <input type="text" name="struct[title]" value="<?= $structure['title'] ?? '' ?>" class="form-control input-xl" placeholder="e.g. SHSAT Test Structure" required>
                </div>

                <div class="p-4 rounded-4" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                    <label class="fw-bold small text-muted mb-3 d-block">Bullet Points *</label>
                    <div id="bullet-points-list">
                        <?php foreach($structPoints as $pt): ?>
                        <div class="d-flex gap-2 mb-3 align-items-center">
                            <span class="text-muted fs-4">•</span>
                            <input type="text" name="struct_bullets[]" value="<?= $pt ?>" class="form-control input-xl" placeholder="e.g. 57 questions in each section">
                            <button type="button" class="btn btn-sm text-danger px-2 remove-btn"><i class="fas fa-trash"></i></button>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" onclick="addBulletPoint()" class="btn btn-link text-primary fw-bold p-0 mt-2 text-decoration-none">
                        <i class="fas fa-plus-circle me-1"></i> Add Bullet Point
                    </button>
                </div>
            </div>

            <!-- --- STICKY FOOTER ACTIONS --- -->
            <div class="actions-bar rounded-4 d-flex gap-3">
                <button type="submit" class="btn btn-primary flex-grow-1 py-3 fw-bold rounded-3 shadow" style="background-color: var(--blue-600);">
                    Save All Changes
                </button>
                <button type="button" class="btn btn-outline-danger px-5 rounded-3 fw-bold">
                    Delete All
                </button>
            </div>

        </form>
    </div>
</div>

<!-- Quill.js Library -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
// Logic to initialize Quill
function createQuill(element) {
    return new Quill(element, {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline'],
                [{ 'color': [] }],
                ['link'],
                ['clean']
            ]
        }
    });
}

// Initialize all existing instances
document.querySelectorAll('.quill-instance').forEach(el => createQuill(el));

// Add New About Block
function addAboutBlock() {
    const wrapper = document.getElementById('about-items-wrapper');
    const html = `
    <div class="about-item-box shadow-sm animate__animated animate__fadeIn">
        <button type="button" class="btn btn-sm text-red-500 position-absolute top-0 end-0 m-3 remove-btn"><i class="fas fa-times-circle fa-lg"></i></button>
        <div class="mb-3">
            <label class="text-xs fw-bold text-blue-800">Item Title *</label>
            <input type="text" name="about_titles[]" class="form-control fw-bold shadow-sm" style="border-radius: 8px; color: #1e40af;" placeholder="Heading">
        </div>
        <label class="text-xs fw-bold text-muted">Item Content *</label>
        <div class="quill-editor-container">
            <div class="quill-instance" style="height: 200px;"></div>
            <input type="hidden" name="about_contents[]" class="quill-hidden-input">
        </div>
    </div>`;
    wrapper.insertAdjacentHTML('beforeend', html);
    createQuill(wrapper.lastElementChild.querySelector('.quill-instance'));
}

// Add Bullet Point
function addBulletPoint() {
    const html = `
    <div class="d-flex gap-2 mb-3 align-items-center animate__animated animate__fadeIn">
        <span class="text-muted fs-4">•</span>
        <input type="text" name="struct_bullets[]" class="form-control input-xl" placeholder="Bullet point text...">
        <button type="button" class="btn btn-sm text-danger px-2 remove-btn"><i class="fas fa-trash"></i></button>
    </div>`;
    document.getElementById('bullet-points-list').insertAdjacentHTML('beforeend', html);
}

// Global Remove Logic
document.addEventListener('click', e => {
    if (e.target.closest('.remove-btn')) {
        e.target.closest('.about-item-box, .d-flex').remove();
    }
});

// Important: Sync Quill HTML to hidden inputs before form submit
document.getElementById('shsatForm').onsubmit = function() {
    document.querySelectorAll('.about-item-box').forEach(box => {
        const quillHtml = box.querySelector('.ql-editor').innerHTML;
        box.querySelector('.quill-hidden-input').value = quillHtml;
    });
};
</script>

<?php include 'includes/footer.php'; ?>