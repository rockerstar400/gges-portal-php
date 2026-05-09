<?php 
require_once '../functions.php';
include 'includes/header.php';
include 'includes/sidebar.php';

$slug = 'accuplacer'; 
$prepData = getTestPrepData($slug); 

// Mapping Arrays from DB JSON
$testList = json_decode($prepData['accu_test_list_json'] ?? '[]', true) ?: [['title' => '', 'description' => '']];
$writeList = json_decode($prepData['accu_write_list_json'] ?? '[]', true) ?: [['title' => '', 'description' => '']];
$eslList = json_decode($prepData['accu_esl_list_json'] ?? '[]', true) ?: [['title' => '', 'description' => '']];
?>

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
    
    .repeater-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 1rem; padding: 1.5rem; position: relative; margin-bottom: 1.5rem; transition: 0.3s; }
    .repeater-box:hover { border-color: var(--blue-600); box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
    
    .actions-bar { position: sticky; bottom: 0; background: rgba(255,255,255,0.95); backdrop-filter: blur(8px); padding: 1.5rem; border-top: 1px solid #eee; z-index: 1000; margin-top: 2rem; }
</style>

<div class="main-content">
    <div class="admin-card-wide p-4 p-md-5">
        <h2 class="text-3xl font-bold text-center mb-8 text-blue-800">Accuplacer Page Admin</h2>

        <form action="api/admin/save-accuplacer.php" method="POST" id="accuplacerForm">
            <input type="hidden" name="slug" value="accuplacer">

            <!-- --- 1. HERO SECTION --- -->
            <div class="mb-5 border-bottom pb-5">
                <h4 class="section-header"><i class="fas fa-rocket me-2 text-primary"></i>Hero Section</h4>
                <div class="mb-3">
                    <label class="small fw-bold text-muted">Title *</label>
                    <input type="text" name="accu_hero_title" value="<?= $prepData['accu_hero_title'] ?? '' ?>" class="form-control input-xl" placeholder="ACCUPLACER TEST PREP" required>
                </div>
                <div class="mb-3">
                    <label class="small fw-bold text-muted">Description *</label>
                    <textarea name="accu_hero_desc" class="form-control input-xl" rows="4" required><?= $prepData['accu_hero_desc'] ?? '' ?></textarea>
                </div>
            </div>

            <!-- --- 2. ABOUT ACCUPLACER --- -->
            <div class="mb-5 border-bottom pb-5">
                <h4 class="section-header"><i class="fas fa-info-circle me-2 text-primary"></i>About Accuplacer</h4>
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="small fw-bold text-muted">Heading *</label>
                        <input type="text" name="accu_about_heading" value="<?= $prepData['accu_about_heading'] ?? '' ?>" class="form-control input-xl mb-3" placeholder="ABOUT ACCUPLACER" required>
                        <label class="small fw-bold text-muted">Description *</label>
                        <textarea name="accu_about_desc" class="form-control input-xl" rows="4" required><?= $prepData['accu_about_desc'] ?? '' ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="small fw-bold text-muted">What's Heading *</label>
                        <input type="text" name="accu_whats_heading" value="<?= $prepData['accu_whats_heading'] ?? '' ?>" class="form-control input-xl mb-3" placeholder="What's on the Tests" required>
                        <label class="small fw-bold text-muted">What's Description *</label>
                        <textarea name="accu_whats_desc" class="form-control input-xl" rows="4" required><?= $prepData['accu_whats_desc'] ?? '' ?></textarea>
                    </div>
                </div>
            </div>

            <!-- --- 3. TEST LIST (Repeater) --- -->
            <div class="mb-5 border-bottom pb-5">
                <h4 class="section-header"><i class="fas fa-list-ul me-2 text-primary"></i>What's on the Tests (List)</h4>
                <div id="test-list-container">
                    <?php foreach($testList as $idx => $item): ?>
                    <div class="repeater-box shadow-sm">
                        <button type="button" class="btn btn-sm text-danger position-absolute top-0 end-0 m-3 remove-btn"><i class="fas fa-times-circle fa-lg"></i></button>
                        <input type="text" name="test_title[]" value="<?= $item['title'] ?>" class="form-control fw-bold mb-3 border-0 bg-white shadow-sm" placeholder="Test Name (e.g. Reading Test)" required>
                        <textarea name="test_description[]" class="form-control border-0 bg-white shadow-sm" rows="3" placeholder="Description..." required><?= $item['description'] ?></textarea>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addItem('test-list-container', 'test')" class="btn btn-sm btn-outline-primary fw-bold">+ Add Test Item</button>
            </div>

            <!-- --- 4. WRITE PLACER SECTION --- -->
            <div class="mb-5 border-bottom pb-5">
                <h4 class="section-header"><i class="fas fa-pen-nib me-2 text-primary"></i>Write Placer Section</h4>
                <div class="mb-4">
                    <label class="small fw-bold text-muted">Introduction Description *</label>
                    <textarea name="accu_write_desc_html" class="form-control input-xl" rows="3" required><?= $prepData['accu_write_desc_html'] ?? '' ?></textarea>
                </div>
                
                <div id="write-list-container">
                    <?php foreach($writeList as $idx => $item): ?>
                    <div class="repeater-box shadow-sm border-start border-warning border-4">
                        <button type="button" class="btn btn-sm text-danger position-absolute top-0 end-0 m-3 remove-btn"><i class="fas fa-times-circle fa-lg"></i></button>
                        <input type="text" name="write_title[]" value="<?= $item['title'] ?>" class="form-control fw-bold mb-3" placeholder="Title" required>
                        <textarea name="write_description[]" class="form-control" rows="2" placeholder="Description..." required><?= $item['description'] ?></textarea>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addItem('write-list-container', 'write')" class="btn btn-sm btn-outline-warning fw-bold">+ Add Write Placer Point</button>
            </div>

            <!-- --- 5. ACCUPLACER ESL SECTION --- -->
            <div class="mb-5">
                <h4 class="section-header"><i class="fas fa-language me-2 text-primary"></i>Accuplacer ESL Section</h4>
                <div class="mb-4">
                    <label class="small fw-bold text-muted">ESL Intro Description *</label>
                    <textarea name="accu_esl_desc_html" class="form-control input-xl" rows="3" required><?= $prepData['accu_esl_desc_html'] ?? '' ?></textarea>
                </div>
                
                <div id="esl-list-container">
                    <?php foreach($eslList as $idx => $item): ?>
                    <div class="repeater-box shadow-sm border-start border-success border-4">
                        <button type="button" class="btn btn-sm text-danger position-absolute top-0 end-0 m-3 remove-btn"><i class="fas fa-times-circle fa-lg"></i></button>
                        <input type="text" name="esl_title[]" value="<?= $item['title'] ?>" class="form-control fw-bold mb-3" placeholder="Title" required>
                        <textarea name="esl_description[]" class="form-control" rows="2" placeholder="Description..." required><?= $item['description'] ?></textarea>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addItem('esl-list-container', 'esl')" class="btn btn-sm btn-outline-success fw-bold">+ Add ESL Point</button>
            </div>

            <!-- --- STICKY FOOTER --- -->
            <div class="actions-bar rounded-4 d-flex gap-3">
                <button type="submit" class="btn btn-primary flex-grow-1 py-3 fw-bold rounded-3 shadow">
                    Save Accuplacer Changes
                </button>
                <button type="button" class="btn btn-outline-danger px-5 rounded-3 fw-bold" onclick="return confirm('Reset all data?')">
                    Delete All
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function addItem(containerId, type) {
    const html = `
    <div class="repeater-box shadow-sm animate__animated animate__fadeIn">
        <button type="button" class="btn btn-sm text-danger position-absolute top-0 end-0 m-3 remove-btn"><i class="fas fa-times-circle fa-lg"></i></button>
        <input type="text" name="${type}_title[]" class="form-control fw-bold mb-3" placeholder="Title" required>
        <textarea name="${type}_description[]" class="form-control" rows="2" placeholder="Description..." required></textarea>
    </div>`;
    document.getElementById(containerId).insertAdjacentHTML('beforeend', html);
}

document.addEventListener('click', e => {
    if(e.target.closest('.remove-btn')) e.target.closest('.repeater-box').remove();
});
</script>

<?php include 'includes/footer.php'; ?>