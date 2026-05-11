<?php 
require_once '../functions.php';
include 'includes/header.php';
include 'includes/sidebar.php';

$slug = 'math-algebra'; // Algebra ke liye math-algebra, Geometry ke liye math-geometry
$prepData = getTestPrepData($slug); 

// Mapping Data
$heading = $prepData['tutoring_heading'] ?? '';
$headingDesc = $prepData['tutoring_description'] ?? '';
// $chapters = json_decode($prepData['tutoring_chapters_json'] ?? '[]', true) ?: [['title'=>'','description'=>'','names'=>['']]];
$chapters = $prepData['tutoring_chapters'] ?? [['title'=>'','description'=>'','names'=>['']]];
?>

<style>
    :root { --blue-600: #2563eb; --gray-50: #f9fafb; }
    .main-content { width: 100%; padding: 2rem; background-color: var(--gray-50); }
    .admin-card-wide { background: white; border-radius: 1.5rem; border-top: 5px solid var(--blue-600); box-shadow: 0 10px 25px rgba(0,0,0,0.05); width: 100%; margin: 0 auto; }
    .input-xl { border-radius: 0.75rem; border: 1px solid #d1d5db; padding: 0.75rem; transition: 0.3s; }
    .chapter-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 1rem; padding: 1.5rem; margin-bottom: 2rem; position: relative; }
    .sub-item-input { background: #ffffff; border-radius: 0.5rem; border: 1px solid #cbd5e1; }
    .actions-bar { position: sticky; bottom: 0; background: rgba(255,255,255,0.95); backdrop-filter: blur(8px); padding: 1.5rem; border-top: 1px solid #eee; z-index: 1000; }
</style>

<div class="main-content">
    <div class="admin-card-wide p-4 p-md-5">
        <h2 class="text-3xl font-bold text-center mb-8 text-blue-800">Tutoring Preparation — <?= strtoupper(str_replace('math-', '', $slug)) ?></h2>

        <form action="api/admin/save-math-tutoring.php" method="POST" id="tutoringForm">
            <input type="hidden" name="slug" value="<?= $slug ?>">

            <!-- 1. HEADER SECTION -->
            <div class="mb-5 border-bottom pb-5">
                <h4 class="fw-bold mb-4 text-dark">Hero & Heading</h4>
                <div class="mb-3">
                    <label class="small fw-bold text-muted">Heading</label>
                    <input type="text" name="heading" value="<?= htmlspecialchars($heading) ?>" class="form-control input-xl mb-3" placeholder="Enter heading">
                    <label class="small fw-bold text-muted">Heading Description</label>
                    <textarea name="headingDescription" class="form-control input-xl" rows="3"><?= $headingDesc ?></textarea>
                </div>
            </div>

            <!-- 2. CHAPTERS (NESTED REPEATER) -->
            <div class="mb-5">
                <h4 class="fw-bold mb-4 text-dark d-flex justify-content-between">Chapters List 
                    <button type="button" class="btn btn-sm btn-primary rounded-pill px-3" onclick="addChapter()">+ Add New Chapter</button>
                </h4>
                
                <div id="chapters-container">
                    <?php foreach($chapters as $cIdx => $ch): ?>
                    <div class="chapter-box shadow-sm" data-index="<?= $cIdx ?>">
                        <button type="button" class="btn btn-sm text-danger position-absolute top-0 end-0 m-3" onclick="this.parentElement.remove()">✕ Remove Chapter</button>
                        
                        <div class="row g-3 mb-3">
                            <div class="col-md-12">
                                <label class="text-xs fw-bold text-primary">Chapter Title</label>
                                <input type="text" name="chapter_title[]" value="<?= $ch['title'] ?>" class="form-control fw-bold shadow-sm" placeholder="Title">
                            </div>
                            <div class="col-md-12">
                                <label class="text-xs fw-bold text-primary">Chapter Description</label>
                                <textarea name="chapter_desc[]" class="form-control shadow-sm" rows="2"><?= $ch['description'] ?></textarea>
                            </div>
                        </div>

                        <!-- Nested Sub-items (Chapter Names) -->
                        <!-- <div class="ms-4 p-3 bg-white rounded-3 border">
                            <label class="small fw-bold text-muted mb-2">Chapter Names / Topics:</label>
                            <div class="names-list">
                                <?php foreach($ch['names'] as $name): ?>
                                <div class="d-flex gap-2 mb-2">
                                    <input type="text" name="chapter_names_<?= $cIdx ?>[]" value="<?= $name ?>" class="form-control form-control-sm sub-item-input" placeholder="Topic name">
                                    <button type="button" class="btn btn-sm btn-outline-danger px-2" onclick="this.parentElement.remove()">✕</button>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" class="btn btn-sm btn-link text-primary p-0 fw-bold" onclick="addName(this, <?= $cIdx ?>)">+ Add Topic</button>
                        </div> -->
                        <!-- Nested Sub-items (Chapter Names) -->
<div class="ms-4 p-3 bg-white rounded-3 border">
    <label class="small fw-bold text-muted mb-2">Chapter Names / Topics:</label>
    <div class="names-list">
        <?php 
        // FIX: Dono keys check karega (names aur chapterName) taaki error na aaye
        $topics = $ch['names'] ?? ($ch['chapterName'] ?? ['']); 
        
        // Agar topics array nahi hai toh use array mein convert karega
        if(!is_array($topics)) $topics = [$topics];

        foreach($topics as $name): 
        ?>
        <div class="d-flex gap-2 mb-2">
            <input type="text" name="chapter_names_<?= $cIdx ?>[]" value="<?= htmlspecialchars($name) ?>" class="form-control form-control-sm sub-item-input" placeholder="Topic name">
            <button type="button" class="btn btn-sm btn-outline-danger px-2" onclick="this.parentElement.remove()">✕</button>
        </div>
        <?php endforeach; ?>
    </div>
    <button type="button" class="btn btn-sm btn-link text-primary p-0 fw-bold" onclick="addName(this, <?= $cIdx ?>)">+ Add Topic</button>
</div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- STICKY SAVE BUTTON -->
            <div class="actions-bar text-center rounded-4 shadow">
                <button type="submit" class="btn btn-primary btn-lg px-5 py-2 fw-bold rounded-pill">💾 Save All Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
let chapterCounter = <?= count($chapters) ?>;

function addChapter() {
    const html = `
    <div class="chapter-box shadow-sm animate__animated animate__fadeIn" data-index="${chapterCounter}">
        <button type="button" class="btn btn-sm text-danger position-absolute top-0 end-0 m-3" onclick="this.parentElement.remove()">✕ Remove Chapter</button>
        <div class="mb-3">
            <input type="text" name="chapter_title[]" class="form-control fw-bold mb-2 shadow-sm" placeholder="Chapter Title">
            <textarea name="chapter_desc[]" class="form-control shadow-sm" rows="2" placeholder="Chapter Description"></textarea>
        </div>
        <div class="ms-4 p-3 bg-white rounded-3 border">
            <div class="names-list">
                <div class="d-flex gap-2 mb-2">
                    <input type="text" name="chapter_names_${chapterCounter}[]" class="form-control form-control-sm sub-item-input" placeholder="Topic name">
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-link text-primary p-0 fw-bold" onclick="addName(this, ${chapterCounter})">+ Add Topic</button>
        </div>
    </div>`;
    document.getElementById('chapters-container').insertAdjacentHTML('beforeend', html);
    chapterCounter++;
}

function addName(btn, idx) {
    const list = btn.previousElementSibling;
    const html = `<div class="d-flex gap-2 mb-2 animate__animated animate__fadeIn"><input type="text" name="chapter_names_${idx}[]" class="form-control form-control-sm sub-item-input" placeholder="Topic name"><button type="button" class="btn btn-sm btn-outline-danger px-2" onclick="this.parentElement.remove()">✕</button></div>`;
    list.insertAdjacentHTML('beforeend', html);
}
</script>

<?php include 'includes/footer.php'; ?>