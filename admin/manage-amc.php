<?php 
require_once '../functions.php';
include 'includes/header.php';
include 'includes/sidebar.php';

$slug = 'amc'; 
$prepData = getTestPrepData($slug); 

// Mapping Arrays from Database JSON
$participationPoints = json_decode($prepData['amc_participate_json'] ?? '[]', true) ?: [''];
$competitionCards = json_decode($prepData['amc_comp_json'] ?? '[]', true) ?: [
    ['title' => '', 'amcDescription' => '', 'description' => '', 'whenText' => '', 'whoText' => '']
];
?>

<!-- Quill Editor CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<style>
    :root { --blue-600: #2563eb; --blue-700: #1d4ed8; --gray-50: #f9fafb; }
    body { background-color: var(--gray-50); font-family: 'Inter', sans-serif; }
    
    /* Full Width Container Logic */
    .main-content { width: 100%; padding: 2rem; }
    .admin-card-wide { 
        background: white; 
        border-radius: 1rem; 
        border-top: 5px solid var(--blue-600); 
        box-shadow: 0 10px 25px rgba(0,0,0,0.05); 
        width: 100%; 
        margin: 0 auto;
    }
    
    .section-title { color: var(--blue-600); font-weight: 700; font-size: 1.75rem; }
    .input-xl { border-radius: 0.75rem; border: 1px solid #d1d5db; padding: 0.8rem; transition: 0.3s; }
    .input-xl:focus { border-color: var(--blue-600); box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); outline: none; }
    
    .card-repeater { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 1.25rem; padding: 1.5rem; position: relative; height: 100%; }
    .quill-container { background: white; border-radius: 0.5rem; border: 1px solid #d1d5db; margin-bottom: 10px; }
    
    .remove-btn { color: #ef4444; cursor: pointer; transition: 0.2s; }
    .remove-btn:hover { color: #b91c1c; transform: scale(1.1); }

    /* Sticky Actions */
    .actions-bar { 
        position: sticky; bottom: 0; background: rgba(255,255,255,0.95); 
        backdrop-filter: blur(10px); padding: 1.5rem; border-top: 1px solid #eee; 
        z-index: 1000; margin-top: 3rem; 
    }
</style>

<div class="main-content">
    <div class="admin-card-wide p-4 p-md-5">
        <h2 class="section-title text-center mb-5">AMC PreTest Section</h2>

        <form action="api/admin/save-amc.php" method="POST" id="amcForm">
            <input type="hidden" name="slug" value="amc">

            <!-- --- 1. HERO SECTION --- -->
            <div class="mb-5 border-bottom pb-5">
                <h4 class="fw-bold text-dark mb-4"><i class="fas fa-rocket me-2 text-primary"></i>Hero Section</h4>
                <div class="row g-4">
                    <div class="col-12">
                        <label class="form-label small fw-bold text-muted">Hero Title *</label>
                        <input type="text" name="amc_hero_title" value="<?= $prepData['amc_hero_title'] ?? '' ?>" class="form-control input-xl" placeholder="Main Title (e.g. AMC TEST PREP)" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold text-muted">Hero Description *</label>
                        <textarea name="amc_hero_desc" class="form-control input-xl" rows="4" placeholder="Hero Description (At GGES...)" required><?= $prepData['amc_hero_desc'] ?? '' ?></textarea>
                    </div>
                </div>
            </div>

            <!-- --- 2. ABOUT AMC TEST --- -->
            <div class="mb-5 border-bottom pb-5">
                <h4 class="fw-bold text-dark mb-4"><i class="fas fa-info-circle me-2 text-primary"></i>About AMC Test</h4>
                <div class="row g-4">
                    <div class="col-12">
                        <label class="form-label small fw-bold text-muted">Heading *</label>
                        <input type="text" name="amc_about_heading" value="<?= $prepData['amc_about_heading'] ?? '' ?>" class="form-control input-xl" placeholder="About Heading" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold text-muted">Description *</label>
                        <textarea name="amc_about_desc" class="form-control input-xl" rows="4" placeholder="About Description..." required><?= $prepData['amc_about_desc'] ?? '' ?></textarea>
                    </div>
                </div>
            </div>

            <!-- --- 3. WHO CAN PARTICIPATE --- -->
            <div class="mb-5 border-bottom pb-5">
                <h4 class="fw-bold text-dark mb-4"><i class="fas fa-users me-2 text-primary"></i>Who Can Participate?</h4>
                <div class="mb-4">
                    <label class="form-label small fw-bold text-muted">Heading *</label>
                    <input type="text" name="amc_participate_heading" value="<?= $prepData['amc_participate_heading'] ?? '' ?>" class="form-control input-xl" placeholder="Heading" required>
                </div>
                
                <label class="small fw-bold text-muted mb-2">Bullet Points *</label>
                <div id="participation-list">
                    <?php foreach($participationPoints as $pt): ?>
                    <div class="d-flex gap-2 mb-2 align-items-center">
                        <span class="text-muted fs-4">•</span>
                        <input type="text" name="participation_points[]" value="<?= $pt ?>" class="form-control input-xl" placeholder="e.g. Students: Middle and high school..." required>
                        <i class="fas fa-times-circle fs-4 remove-btn" onclick="this.parentElement.remove()"></i>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addPoint()" class="btn btn-link text-primary fw-bold p-0 text-decoration-none mt-2">
                    <i class="fas fa-plus-circle me-1"></i> Add Point
                </button>
            </div>

            <!-- --- 4. DIFFERENT AMC COMPETITIONS (Wide Grid) --- -->
            <div class="mb-5 border-bottom pb-5">
                <h4 class="fw-bold text-dark mb-4"><i class="fas fa-trophy me-2 text-primary"></i>Different AMC Competitions</h4>
                <div class="mb-4">
                    <label class="form-label small fw-bold text-muted">Section Heading *</label>
                    <input type="text" name="amc_comp_heading" value="<?= $prepData['amc_comp_heading'] ?? '' ?>" class="form-control input-xl" placeholder="Heading" required>
                </div>

                <div class="row g-4" id="competition-cards-wrapper">
                    <?php foreach($competitionCards as $idx => $card): ?>
                    <div class="col-lg-4 col-md-6 comp-card-item">
                        <div class="card-repeater shadow-sm border-top border-primary border-4">
                            <i class="fas fa-times-circle position-absolute top-0 end-0 m-3 remove-btn fa-lg" onclick="this.closest('.comp-card-item').remove()"></i>
                            
                            <div class="mb-3">
                                <label class="text-xs fw-bold text-muted">Title *</label>
                                <input type="text" name="card_title[]" value="<?= $card['title'] ?>" class="form-control fw-bold border-0 shadow-sm" placeholder="e.g. AMC 8" required>
                            </div>
                            
                            <label class="text-xs fw-bold text-muted">amcDescription *</label>
                            <div class="quill-container">
                                <div class="quill-instance" style="height: 120px;"><?= $card['amcDescription'] ?></div>
                                <input type="hidden" name="card_amc_desc[]" class="quill-hidden-input">
                            </div>

                            <div class="mb-2">
                                <label class="text-xs fw-bold text-muted">Description *</label>
                                <textarea name="card_description[]" class="form-control small" rows="2" placeholder="25 questions..."><?= $card['description'] ?></textarea>
                            </div>

                            <div class="row g-2">
                                <div class="col-6">
                                    <label class="text-xs fw-bold text-muted">When *</label>
                                    <input type="text" name="card_when[]" value="<?= $card['whenText'] ?>" class="form-control small" placeholder="January" required>
                                </div>
                                <div class="col-6">
                                    <label class="text-xs fw-bold text-muted">Who *</label>
                                    <input type="text" name="card_who[]" value="<?= $card['whoText'] ?>" class="form-control small" placeholder="Under 15" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addCompCard()" class="btn btn-sm btn-outline-primary mt-4 fw-bold">
                    <i class="fas fa-plus-circle me-1"></i> Add Competition Card
                </button>
            </div>

            <!-- --- 5. WHY TAKE AMC --- -->
            <div class="mb-5">
                <h4 class="fw-bold text-dark mb-4"><i class="fas fa-question-circle me-2 text-primary"></i>Why Take AMC?</h4>
                <div class="row g-4">
                    <div class="col-12">
                        <label class="form-label small fw-bold text-muted">Heading *</label>
                        <input type="text" name="amc_why_heading" value="<?= $prepData['amc_why_heading'] ?? '' ?>" class="form-control input-xl" placeholder="Heading" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold text-muted">Description *</label>
                        <textarea name="amc_why_desc" class="form-control input-xl" rows="4" placeholder="Description (AMC 10/12 aims to...)" required><?= $prepData['amc_why_desc'] ?? '' ?></textarea>
                    </div>
                </div>
            </div>

            <!-- --- STICKY FOOTER ACTIONS --- -->
            <div class="actions-bar rounded-4 d-flex gap-3">
                <button type="submit" class="btn btn-primary flex-grow-1 py-3 fw-bold rounded-3 shadow">
                    Save All Changes
                </button>
                <button type="button" class="btn btn-outline-danger px-5 rounded-3 fw-bold" onclick="return confirm('Delete all AMC data?')">
                    Delete All
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Quill Scripts -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
// Logic to initialize Quill
function createQuill(element) {
    return new Quill(element, {
        theme: 'snow',
        modules: { toolbar: [['bold', 'italic', 'underline'], ['link'], [{list:'ordered'},{list:'bullet'}], ['clean']] }
    });
}

// Init existing
document.querySelectorAll('.quill-instance').forEach(el => createQuill(el));

function addPoint() {
    const html = `<div class="d-flex gap-2 mb-2 align-items-center animate__animated animate__fadeIn"><span class="text-muted fs-4">•</span><input type="text" name="participation_points[]" class="form-control input-xl" placeholder="New Point" required><i class="fas fa-times-circle fs-4 remove-btn" onclick="this.parentElement.remove()"></i></div>`;
    document.getElementById('participation-list').insertAdjacentHTML('beforeend', html);
}

function addCompCard() {
    const wrapper = document.getElementById('competition-cards-wrapper');
    const html = `
    <div class="col-lg-4 col-md-6 comp-card-item animate__animated animate__fadeIn">
        <div class="card-repeater shadow-sm border-top border-primary border-4">
            <i class="fas fa-times-circle position-absolute top-0 end-0 m-3 remove-btn fa-lg" onclick="this.closest('.comp-card-item').remove()"></i>
            <div class="mb-3">
                <label class="text-xs fw-bold text-muted">Title *</label>
                <input type="text" name="card_title[]" class="form-control fw-bold shadow-sm" placeholder="AMC 8" required>
            </div>
            <label class="text-xs fw-bold text-muted">amcDescription *</label>
            <div class="quill-container"><div class="quill-instance" style="height: 120px;"></div><input type="hidden" name="card_amc_desc[]" class="quill-hidden-input"></div>
            <div class="mb-2"><label class="text-xs fw-bold text-muted">Description *</label><textarea name="card_description[]" class="form-control small" rows="2" placeholder="25 questions..."></textarea></div>
            <div class="row g-2">
                <div class="col-6"><label class="text-xs fw-bold text-muted">When *</label><input type="text" name="card_when[]" class="form-control small" placeholder="January" required></div>
                <div class="col-6"><label class="text-xs fw-bold text-muted">Who *</label><input type="text" name="card_who[]" class="form-control small" placeholder="Under 15" required></div>
            </div>
        </div>
    </div>`;
    wrapper.insertAdjacentHTML('beforeend', html);
    createQuill(wrapper.lastElementChild.querySelector('.quill-instance'));
}

// Sync Quill before Submit
document.getElementById('amcForm').onsubmit = function() {
    document.querySelectorAll('.comp-card-item').forEach(card => {
        const quillHtml = card.querySelector('.ql-editor').innerHTML;
        card.querySelector('.quill-hidden-input').value = quillHtml;
    });
};
</script>

<?php include 'includes/footer.php'; ?>