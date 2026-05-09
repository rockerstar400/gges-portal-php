<?php 
require_once '../functions.php';
include 'includes/header.php';
include 'includes/sidebar.php';

$slug = 'math-common-core'; 
$prepData = getTestPrepData($slug); 

// Mapping: hero_section se title aur about_section se description array nikalenge
$title = $prepData['hero']['title'] ?? '';
$descriptions = $prepData['about'] ?? ['']; // Array of strings
?>

<style>
    :root { --blue-600: #2563eb; --blue-700: #1d4ed8; --gray-50: #f9fafb; }
    body { background-color: var(--gray-50); font-family: 'Inter', sans-serif; }
    
    /* Full Width Logic */
    .main-content { width: 100%; padding: 2rem; }
    .admin-card-wide { 
        background: white; border-radius: 1.5rem; border-top: 5px solid var(--blue-600); 
        box-shadow: 0 10px 25px rgba(0,0,0,0.05); width: 100%; max-width: 900px; margin: 0 auto; 
    }
    
    .input-xl { border-radius: 0.75rem; border: 1px solid #d1d5db; padding: 0.75rem; transition: 0.3s; }
    .input-xl:focus { border-color: var(--blue-600); box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); outline: none; }
    
    .desc-box { background: #fff; border: 1px solid #e2e8f0; border-radius: 1rem; padding: 1rem; position: relative; margin-bottom: 1rem; }
</style>

<div class="main-content">
    <div class="admin-card-wide p-4 p-md-5 shadow-lg">
        <h2 class="text-3xl font-bold text-center mb-8 text-blue-600">Math Test Prep Admin</h2>

        <form action="api/admin/save-math-common.php" method="POST">
            <input type="hidden" name="slug" value="<?= $slug ?>">

            <!-- 1. TITLE SECTION -->
            <div class="mb-5 border-bottom pb-4">
                <h5 class="fw-bold mb-3">Main Page Title</h5>
                <input type="text" name="title" value="<?= htmlspecialchars($title) ?>" class="form-control input-xl" placeholder="Enter title (e.g. Common Core Math)" required>
            </div>

            <!-- 2. DYNAMIC DESCRIPTIONS (REPEATER) -->
            <div class="mb-5">
                <h5 class="fw-bold mb-3">Descriptions (Multiple Paragraphs)</h5>
                <div id="desc-container">
                    <?php foreach($descriptions as $idx => $desc): ?>
                    <div class="d-flex gap-2 mb-3 align-items-start desc-row">
                        <textarea name="descriptions[]" class="form-control input-xl" rows="3" placeholder="Description <?= $idx+1 ?>" required><?= htmlspecialchars($desc) ?></textarea>
                        <?php if($idx > 0): ?>
                            <button type="button" class="btn btn-danger rounded-3 px-3 py-2" onclick="this.parentElement.remove()">✕</button>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <button type="button" onclick="addDesc()" class="btn btn-outline-primary btn-sm w-100 py-2 border-2 border-dashed fw-bold mt-2">
                    + Add More Description Paragraph
                </button>
            </div>

            <!-- 3. ACTIONS -->
            <div class="pt-4 border-top d-flex gap-3">
                <button type="submit" class="btn btn-primary flex-grow-1 py-3 fw-bold rounded-3 shadow">💾 Save Math Prep Changes</button>
                <button type="button" class="btn btn-outline-danger px-4 rounded-3 fw-bold" onclick="location.reload()">Reset</button>
            </div>
        </form>
    </div>
</div>

<script>
function addDesc() {
    const container = document.getElementById('desc-container');
    const count = container.children.length + 1;
    const html = `
    <div class="d-flex gap-2 mb-3 align-items-start animate__animated animate__fadeIn">
        <textarea name="descriptions[]" class="form-control input-xl" rows="3" placeholder="Description ${count}" required></textarea>
        <button type="button" class="btn btn-danger rounded-3 px-3 py-2" onclick="this.parentElement.remove()">✕</button>
    </div>`;
    container.insertAdjacentHTML('beforeend', html);
}
</script>

<?php include 'includes/footer.php'; ?>