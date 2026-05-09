<?php 
require_once '../functions.php';
include 'includes/header.php';
include 'includes/sidebar.php';

$slug = 'math-geometry'; 
$prepData = getTestPrepData($slug); 

// Mapping Variables based on React logic
$title = $prepData['geometry_title'] ?? '';
$desc  = $prepData['geometry_desc'] ?? '';
$subjectDesc = $prepData['geometry_subject_desc'] ?? '';
// Master function cleanKey logic: geometry_chapters_json becomes geometry_chapters
$chapters = $prepData['geometry_chapters'] ?? ['']; 
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
    .input-xl { border-radius: 0.75rem; border: 1px solid #d1d5db; padding: 0.8rem; transition: 0.3s; }
    .input-xl:focus { border-color: var(--blue-600); outline: none; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); }
    
    .actions-bar { position: sticky; bottom: 0; background: rgba(255,255,255,0.95); backdrop-filter: blur(8px); padding: 1.5rem; border-top: 1px solid #eee; z-index: 1000; margin-top: 2rem; }
</style>

<div class="main-content">
    <div class="admin-card-wide p-4 p-md-5">
        <h2 class="text-3xl font-bold text-center mb-8 text-blue-800">Geometry Management Admin</h2>

        <form action="api/admin/save-math-geometry.php" method="POST" id="geometryForm">
            <input type="hidden" name="slug" value="<?= $slug ?>">

            <!-- --- SECTION 1: HEADER INFO --- -->
            <div class="mb-5 border-bottom pb-5">
                <h4 class="section-header"><i class="fas fa-shapes me-2 text-primary"></i>Main Content</h4>
                <div class="row g-4">
                    <div class="col-12">
                        <label class="small fw-bold text-muted">Title *</label>
                        <input type="text" name="title" value="<?= htmlspecialchars($title) ?>" class="form-control input-xl" placeholder="Enter title" required>
                    </div>
                    <div class="col-md-6">
                        <label class="small fw-bold text-muted">Description *</label>
                        <textarea name="description" class="form-control input-xl" rows="4" placeholder="Enter description" required><?= $desc ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="small fw-bold text-muted">Subject Description *</label>
                        <textarea name="subjectDescription" class="form-control input-xl" rows="4" placeholder="Enter subject description" required><?= $subjectDesc ?></textarea>
                    </div>
                </div>
            </div>

            <!-- --- SECTION 2: CHAPTER NAMES (REPEATER) --- -->
            <div class="mb-5">
                <h4 class="section-header"><i class="fas fa-list-ul me-2 text-primary"></i>Chapter Names</h4>
                <div id="chapter-list">
                    <?php foreach($chapters as $idx => $chapter): ?>
                    <div class="d-flex gap-2 mb-3 align-items-center">
                        <span class="text-muted fw-bold"><?= $idx + 1 ?>.</span>
                        <input type="text" name="chapter_names[]" value="<?= htmlspecialchars($chapter) ?>" class="form-control input-xl" placeholder="Enter chapter name" required>
                        <?php if($idx > 0): ?>
                            <button type="button" class="btn btn-sm btn-outline-danger px-3 py-2" onclick="this.parentElement.remove()">✕</button>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addChapter()" class="btn btn-link text-primary p-0 fw-bold text-decoration-none mt-2">
                    <i class="fas fa-plus-circle me-1"></i> Add Chapter Name
                </button>
            </div>

            <!-- --- STICKY FOOTER ACTIONS --- -->
            <div class="actions-bar rounded-4 d-flex gap-3 shadow">
                <button type="submit" class="btn btn-primary flex-grow-1 py-3 fw-bold rounded-3 shadow">
                    Save Geometry Changes
                </button>
                <button type="button" class="btn btn-outline-danger px-5 rounded-3 fw-bold" onclick="location.reload()">
                    Reset
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function addChapter() {
    const container = document.getElementById('chapter-list');
    const count = container.children.length + 1;
    const html = `
    <div class="d-flex gap-2 mb-3 align-items-center animate__animated animate__fadeIn">
        <span class="text-muted fw-bold">${count}.</span>
        <input type="text" name="chapter_names[]" class="form-control input-xl" placeholder="Enter chapter name" required>
        <button type="button" class="btn btn-sm btn-outline-danger px-3 py-2" onclick="this.parentElement.remove()">✕</button>
    </div>`;
    container.insertAdjacentHTML('beforeend', html);
}
</script>

<?php include 'includes/footer.php'; ?>