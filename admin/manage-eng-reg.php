<?php 
require_once '../functions.php';
include 'includes/header.php';
include 'includes/sidebar.php';

$slug = 'eng-registration'; 
$prepData = getTestPrepData($slug); 

// Mapping Data
$regTitle = $prepData['eng_reg_title'] ?? '';
$regDesc  = $prepData['eng_reg_desc'] ?? '';
$measure  = json_decode($prepData['eng_measure_json'] ?? '[]', true);
?>

<!-- Quill Editor CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<style>
    .bg-react-gray { background-color: #f9fafb; min-height: 100vh; width: 100%; padding: 40px 20px; }
    .card-react { 
        background: white; border-radius: 1.5rem; padding: 2rem; 
        box-shadow: 0 10px 25px rgba(0,0,0,0.05); border: none;
        max-width: 1000px; margin: 0 auto 30px auto; 
    }
    .input-react { border-radius: 0.75rem; border: 1px solid #d1d5db; padding: 12px; transition: 0.3s; width: 100%; }
    .input-react:focus { border-color: #2563eb; outline: none; box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1); }
    .btn-react-save { 
        background-color: #2563eb; color: white; border: none; border-radius: 0.75rem; 
        padding: 10px; width: 100%; font-weight: 600; transition: 0.3s; 
    }
    .btn-react-save:hover { background-color: #1d4ed8; transform: translateY(-2px); }
    .quill-wrapper { background: white; border-radius: 0.75rem; border: 1px solid #d1d5db; overflow: hidden; margin-bottom: 10px; }
</style>

<div class="main-content p-0">
    <div class="bg-react-gray">
        
        <!-- 1. REGISTRATION INFO BLOCK -->
        <div class="card-react" data-aos="fade-up">
            <h3 class="text-xl font-bold mb-4 text-dark text-center">Registration Info</h3>
            <form action="api/admin/save-eng-reg.php" method="POST">
                <input type="hidden" name="slug" value="<?= $slug ?>">
                
                <input type="text" name="title" value="<?= htmlspecialchars($regTitle) ?>" 
                       placeholder="Enter title" class="input-react mb-3">

                <textarea name="description" placeholder="Enter description" 
                          class="input-react mb-3" rows="4"><?= $regDesc ?></textarea>

                <button type="submit" class="btn-react-save">Save Registration Info</button>
            </form>
        </div>

        <!-- 2. MEASURE SECTION BLOCK -->
        <div class="card-react" data-aos="fade-up" data-aos-delay="200">
            <h3 class="text-xl font-bold mb-5 text-dark text-center">Measure Section</h3>
            <form action="api/admin/save-eng-measure.php" method="POST" id="measureForm">
                <input type="hidden" name="slug" value="<?= $slug ?>">

                <?php for($i=1; $i<=5; $i++): ?>
                <div class="mb-5 border-bottom pb-4">
                    <label class="fw-bold text-secondary mb-2 small text-uppercase">Section <?= $i ?></label>
                    
                    <!-- Title with Quill -->
                    <div class="quill-wrapper">
                        <div class="title-editor" id="editor-title-<?= $i ?>" style="height: 100px;">
                            <?= $measure['title'.$i] ?? '' ?>
                        </div>
                        <input type="hidden" name="title<?= $i ?>" id="input-title-<?= $i ?>">
                    </div>

                    <!-- Description Textarea -->
                    <textarea name="description<?= $i ?>" placeholder="Enter Description <?= $i ?>" 
                              class="input-react" rows="3"><?= $measure['description'.$i] ?? '' ?></textarea>
                </div>
                <?php endfor; ?>

                <button type="submit" class="btn-react-save">Save Measure Details</button>
            </form>
        </div>

    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    // Config same as React
    const quillModules = {
        toolbar: [
            [{ 'header': [1, 2, false] }],
            ['bold', 'italic', 'underline', 'link'],
            [{ 'color': [] }, { 'background': [] }],
            ['clean']
        ]
    };

    // Initialize 5 Editors
    const editors = [];
    for(let i=1; i<=5; i++) {
        editors[i] = new Quill('#editor-title-' + i, {
            theme: 'snow',
            modules: quillModules,
            placeholder: 'Enter Title ' + i
        });
    }

    // Sync Quill to Hidden Inputs before submit
    document.getElementById('measureForm').onsubmit = function() {
        for(let i=1; i<=5; i++) {
            document.getElementById('input-title-' + i).value = editors[i].root.innerHTML;
        }
    };
</script>

<?php include 'includes/footer.php'; ?>