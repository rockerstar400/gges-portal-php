<?php 
require_once '../functions.php';
include 'includes/header.php';
include 'includes/sidebar.php';

$slug = 'eng-about-ela'; 
$prepData = getTestPrepData($slug); 

// Mapping Arrays from DB JSON
$questionTypes = json_decode($prepData['about_ela_question_json'] ?? '[]', true) ?: [['title' => '', 'description' => '']];
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
    .input-xl { border-radius: 0.75rem; border: 1px solid #d1d5db; padding: 0.75rem; transition: 0.3s; }
    .input-xl:focus { border-color: var(--blue-600); outline: none; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); }
    
    .repeater-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 1rem; padding: 1.5rem; position: relative; margin-bottom: 1.5rem; }
    .quill-container { background: white; border-radius: 0.5rem; border: 1px solid #d1d5db; margin-bottom: 10px; }
    
    .actions-bar { position: sticky; bottom: 0; background: rgba(255,255,255,0.95); backdrop-filter: blur(8px); padding: 1.5rem; border-top: 1px solid #eee; z-index: 1000; margin-top: 2rem; }
</style>

<div class="main-content">
    <div class="admin-card-wide p-4 p-md-5">
        <h2 class="text-3xl font-bold text-center mb-8 text-blue-800">About ELA Admin</h2>

        <form action="api/admin/save-eng-about-ela.php" method="POST" id="aboutElaForm">
            <input type="hidden" name="slug" value="<?= $slug ?>">

            <!-- --- 1. HERO / TOP DESCRIPTIONS --- -->
            <div class="mb-5 border-bottom pb-5">
                <h4 class="section-header"><i class="fas fa-info-circle me-2 text-primary"></i>Main Descriptions</h4>
                <div class="row g-4">
                    <div class="col-12">
                        <label class="small fw-bold text-muted">Test Prep Description</label>
                        <textarea name="prep_desc" class="form-control input-xl" rows="3" placeholder="Enter test prep description..."><?= $prepData['about_ela_prep_desc'] ?? '' ?></textarea>
                    </div>
                    <div class="col-12">
                        <label class="small fw-bold text-muted">Main Description</label>
                        <textarea name="main_desc" class="form-control input-xl" rows="3" placeholder="Enter main description..."><?= $prepData['about_ela_main_desc'] ?? '' ?></textarea>
                    </div>
                </div>
            </div>

            <!-- --- 2. HEADING & WHO TAKE --- -->
            <div class="mb-5 border-bottom pb-5">
                <h4 class="section-header"><i class="fas fa-question-circle me-2 text-primary"></i>Heading & Who Takes the Test</h4>
                <div class="mb-4">
                    <label class="small fw-bold text-muted">Heading</label>
                    <input type="text" name="heading" value="<?= $prepData['about_ela_heading'] ?? '' ?>" class="form-control input-xl" placeholder="Enter heading...">
                </div>
                
                <label class="small fw-bold text-muted">Who Take (Rich Text Editor)</label>
                <div class="quill-container">
                    <div id="whotake-editor" style="height: 180px;"><?= $prepData['about_ela_whotake_html'] ?? '' ?></div>
                    <input type="hidden" name="whotake_html" id="whotake_input">
                </div>
            </div>

            <!-- --- 3. QUESTION TYPES (Repeater) --- -->
            <div class="mb-5">
                <h4 class="section-header"><i class="fas fa-list-check me-2 text-primary"></i>Question Types</h4>
                <div id="questions-container">
                    <?php foreach($questionTypes as $idx => $q): ?>
                    <div class="repeater-box shadow-sm border-start border-primary border-4">
                        <?php if($idx > 0): ?>
                        <button type="button" class="btn btn-sm text-danger position-absolute top-0 end-0 m-3 remove-btn"><i class="fas fa-times-circle fa-lg"></i></button>
                        <?php endif; ?>
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Question Title</label>
                            <input type="text" name="q_title[]" value="<?= $q['title'] ?>" class="form-control input-xl fw-bold" placeholder="e.g. Multiple Choice" required>
                        </div>
                        <div>
                            <label class="form-label small fw-bold">Description</label>
                            <textarea name="q_desc[]" class="form-control input-xl" rows="2" placeholder="Describe the question type..." required><?= $q['description'] ?></textarea>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addQuestion()" class="btn btn-sm btn-outline-primary fw-bold mt-2">
                    <i class="fas fa-plus-circle me-1"></i> Add Question Type
                </button>
            </div>

            <!-- --- STICKY FOOTER ACTIONS --- -->
            <div class="actions-bar rounded-4 d-flex gap-3 shadow">
                <button type="submit" class="btn btn-primary flex-grow-1 py-3 fw-bold rounded-3 shadow">
                    Save About ELA Changes
                </button>
                <button type="button" class="btn btn-outline-danger px-5 rounded-3 fw-bold" onclick="return confirm('Reset form?')">
                    Reset
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
var whotakeEditor = new Quill('#whotake-editor', {
    theme: 'snow',
    modules: { toolbar: [['bold', 'italic', 'underline'], ['link'], [{list:'ordered'},{list:'bullet'}], [{color:[]},{background:[]}], ['clean']] }
});

function addQuestion() {
    const html = `
    <div class="repeater-box shadow-sm border-start border-primary border-4 animate__animated animate__fadeIn">
        <button type="button" class="btn btn-sm text-danger position-absolute top-0 end-0 m-3 remove-btn"><i class="fas fa-times-circle fa-lg"></i></button>
        <div class="mb-3">
            <label class="form-label small fw-bold">Question Title</label>
            <input type="text" name="q_title[]" class="form-control input-xl fw-bold" placeholder="Question title" required>
        </div>
        <div>
            <label class="form-label small fw-bold">Description</label>
            <textarea name="q_desc[]" class="form-control input-xl" rows="2" placeholder="Description..." required></textarea>
        </div>
    </div>`;
    document.getElementById('questions-container').insertAdjacentHTML('beforeend', html);
}

document.addEventListener('click', e => {
    if(e.target.closest('.remove-btn')) e.target.closest('.repeater-box').remove();
});

document.getElementById('aboutElaForm').onsubmit = function() {
    document.getElementById('whotake_input').value = whotakeEditor.root.innerHTML;
};
</script>

<?php include 'includes/footer.php'; ?>