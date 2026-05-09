<?php 
require_once '../functions.php';
include 'includes/header.php';
include 'includes/sidebar.php';

$slug = 'ela'; 
$prepData = getTestPrepData($slug); 

// Variables mapping
$hero = $prepData['hero'] ?? [];
$introHeading = $prepData['ela_intro_title'] ?? '';
$introContent = $prepData['ela_intro_content'] ?? ''; // Quill content
$adminHeading = $prepData['ela_admin_title'] ?? '';
$adminPoints  = json_decode($prepData['ela_admin_json'] ?? '[]', true) ?: [['title'=>'','description'=>'']];
?>

<!-- Quill Editor CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<style>
    :root { --blue-600: #2563eb; --blue-700: #1d4ed8; --gray-50: #f9fafb; }
    body { background-color: var(--gray-50); font-family: 'Inter', sans-serif; }
    .admin-card-wide { background: white; border-radius: 1rem; border-top: 5px solid var(--blue-600); box-shadow: 0 10px 25px rgba(0,0,0,0.05); width: 100%; margin: 0 auto; }
    .input-xl { border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.75rem; transition: 0.3s; }
    .input-xl:focus { border-color: var(--blue-600); outline: none; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); }
    .quill-container { background: white; border-radius: 0.5rem; border: 1px solid #d1d5db; margin-bottom: 10px; }
    .point-box { background: #fff; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1.5rem; position: relative; margin-bottom: 1rem; }
    .actions-bar { position: sticky; bottom: 0; background: rgba(255,255,255,0.9); backdrop-filter: blur(8px); padding: 1.2rem; border-top: 1px solid #eee; z-index: 1000; margin-top: 2rem; }
</style>

<div class="main-content p-4">
    <div class="admin-card-wide p-4 p-md-5">
        <h2 class="fw-bold mb-4">ELA Test Admin</h2>

        <form action="api/admin/save-ela.php" method="POST" id="elaForm">
            <input type="hidden" name="slug" value="ela">

            <!-- --- 1. HERO SECTION --- -->
            <section class="mb-5 border-bottom pb-4">
                <h4 class="fw-bold mb-3">Hero Section</h4>
                <input type="text" name="hero[title]" value="<?= $hero['title'] ?? '' ?>" placeholder="Hero Title" class="form-control input-xl mb-3">
                <textarea name="hero[description]" rows="3" placeholder="Hero Description" class="form-control input-xl"><?= $hero['description'] ?? '' ?></textarea>
            </section>

            <!-- --- 2. INTRO SECTION (Quill) --- -->
            <section class="mb-5 border-bottom pb-4">
                <h4 class="fw-bold mb-3">Intro Section</h4>
                <input type="text" name="ela_intro_title" value="<?= $introHeading ?>" placeholder="Intro Heading" class="form-control input-xl mb-3">
                
                <div class="quill-container">
                    <div id="intro-editor" style="height: 200px;"><?= $introContent ?></div>
                    <input type="hidden" name="ela_intro_content" id="intro_content_input">
                </div>
            </section>

            <!-- --- 3. ADMINISTRATION SECTION --- -->
            <section class="mb-5">
                <h4 class="fw-bold mb-3">Administration Section</h4>
                <input type="text" name="ela_admin_title" value="<?= $adminHeading ?>" placeholder="Administration Heading" class="form-control input-xl mb-4">

                <div id="admin-points-list">
                    <?php foreach($adminPoints as $item): ?>
                    <div class="point-box shadow-sm">
                        <button type="button" class="btn btn-sm text-danger position-absolute top-0 end-0 m-2 remove-btn">Remove</button>
                        <input type="text" name="admin_pt_title[]" value="<?= $item['title'] ?>" class="form-control mb-2 fw-bold border-0 bg-light" placeholder="Title">
                        <textarea name="admin_pt_desc[]" rows="2" class="form-control border-0" placeholder="Description"><?= $item['description'] ?></textarea>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <button type="button" onclick="addAdminPoint()" class="btn btn-link text-primary p-0 fw-bold text-decoration-none mt-2">+ Add Administration Point</button>
            </section>

            <!-- --- ACTIONS --- -->
            <div class="actions-bar d-flex gap-3 rounded-3">
                <button type="submit" class="btn btn-primary flex-grow-1 py-3 fw-bold shadow">Save All Changes</button>
                <button type="button" class="btn btn-outline-danger px-5 fw-bold" onclick="return confirm('Delete all data?')">Delete</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    var quill = new Quill('#intro-editor', {
        theme: 'snow',
        modules: { toolbar: [[{header:[1,2,3,false]}],['bold','italic','underline'],['link'],['clean']] }
    });

    function addAdminPoint() {
        const html = `
        <div class="point-box shadow-sm animate__animated animate__fadeIn">
            <button type="button" class="btn btn-sm text-danger position-absolute top-0 end-0 m-2 remove-btn">Remove</button>
            <input type="text" name="admin_pt_title[]" class="form-control mb-2 fw-bold border-0 bg-light" placeholder="Title">
            <textarea name="admin_pt_desc[]" rows="2" class="form-control border-0" placeholder="Description"></textarea>
        </div>`;
        document.getElementById('admin-points-list').insertAdjacentHTML('beforeend', html);
    }

    document.addEventListener('click', e => {
        if(e.target.classList.contains('remove-btn')) e.target.closest('.point-box').remove();
    });

    document.getElementById('elaForm').onsubmit = function() {
        document.getElementById('intro_content_input').value = quill.root.innerHTML;
    };
</script>

<?php include 'includes/footer.php'; ?>