<?php 
require_once '../functions.php';
include 'includes/header.php';
include 'includes/sidebar.php';

$slug = 'cogat'; 
$prepData = getTestPrepData($slug); 

// Mapping Variables from DB JSON
$heroData = json_decode($prepData['cogat_hero_json'] ?? '[]', true);
$structData = json_decode($prepData['cogat_struct_json'] ?? '[]', true);
$measureData = json_decode($prepData['cogat_measure_json'] ?? '[]', true);
$administerData = json_decode($prepData['cogat_administer_json'] ?? '[]', true);
$levelsData = json_decode($prepData['cogat_levels_json'] ?? '[]', true);
$batteryData = json_decode($prepData['cogat_battery_json'] ?? '[]', true);
$scoreLocData = json_decode($prepData['cogat_score_loc_json'] ?? '[]', true);
?>

<!-- Quill Editor CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<style>
    :root { --blue-600: #2563eb; --blue-700: #1d4ed8; --gray-50: #f9fafb; }
    body { background-color: var(--gray-50); font-family: 'Inter', sans-serif; }
    .main-content { width: 100%; padding: 2rem; }
    .admin-card-wide { background: white; border-radius: 1rem; border-top: 5px solid var(--blue-600); box-shadow: 0 10px 25px rgba(0,0,0,0.05); width: 100%; margin: 0 auto; }
    .input-xl { border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.7rem; transition: 0.3s; }
    .input-xl:focus { border-color: var(--blue-600); outline: none; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); }
    .section-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 1rem; padding: 1.5rem; margin-bottom: 1.5rem; }
    .quill-container { background: white; border-radius: 0.5rem; border: 1px solid #d1d5db; margin-bottom: 10px; }
    .actions-bar { position: sticky; bottom: 0; background: rgba(255,255,255,0.95); backdrop-filter: blur(8px); padding: 1.5rem; border-top: 1px solid #eee; z-index: 1000; margin-top: 2rem; }
</style>

<div class="main-content">
    <div class="admin-card-wide p-4 p-md-5">
        <h2 class="text-3xl font-bold text-center text-blue-800 mb-5">CogAT Admin Panel</h2>

        <form action="api/admin/save-cogat.php" method="POST" id="cogatForm">
            <input type="hidden" name="slug" value="cogat">

            <!-- --- 1. HERO SECTION --- -->
            <div class="section-box shadow-sm">
                <h4 class="fw-bold mb-4 text-primary border-bottom pb-2">1. Hero Section</h4>
                <div class="mb-3">
                    <label class="small fw-bold text-muted">Main Title</label>
                    <input type="text" name="hero[title]" value="<?= $prepData['hero']['title'] ?? '' ?>" class="form-control input-xl" placeholder="Hero Title">
                </div>
                <div class="mb-3">
                    <label class="small fw-bold text-muted">Main Description</label>
                    <textarea name="hero[description]" class="form-control input-xl" rows="3"><?= $prepData['hero']['description'] ?? '' ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="small fw-bold text-muted">Sub Description (List Intro)</label>
                    <input type="text" name="c_hero_sub" value="<?= $heroData['sub_desc'] ?? '' ?>" class="form-control input-xl border-info bg-light" placeholder="GGES makes the best tutoring options...">
                </div>
                
                <label class="small fw-bold text-muted mb-2">Bullet Points (Quill Enabled)</label>
                <div id="hero-bullets">
                    <?php foreach(($heroData['bullets'] ?? ['']) as $b): ?>
                    <div class="bullet-item mb-3 position-relative">
                        <div class="quill-editor" style="height: 80px;"><?= $b ?></div>
                        <input type="hidden" name="c_hero_bullets[]" class="quill-hidden-input">
                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 remove-btn">✕</button>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addHeroBullet()" class="btn btn-sm btn-link text-primary p-0">+ Add Bullet</button>
            </div>

            <!-- --- 2. TEST STRUCTURE --- -->
            <div class="section-box shadow-sm">
                <h4 class="fw-bold mb-4 text-primary border-bottom pb-2">2. Test Structure</h4>
                <input type="text" name="c_struct_h" value="<?= $structData['heading'] ?? '' ?>" class="form-control input-xl mb-3" placeholder="Heading">
                <textarea name="c_struct_d" class="form-control input-xl mb-4" rows="3" placeholder="Description"><?= $structData['desc'] ?? '' ?></textarea>
                
                <label class="fw-bold small mb-2">Structure Table (3 Columns):</label>
                <div id="struct-table">
                    <div class="row g-2 mb-2 fw-bold text-muted small">
                        <div class="col-4">Verbal Battery</div><div class="col-4">Quantitative Battery</div><div class="col-3">Non-Verbal Battery</div>
                    </div>
                    <?php foreach(($structData['table'] ?? [['v'=>'','q'=>'','n'=>'']]) as $row): ?>
                    <div class="row g-2 mb-2 align-items-center">
                        <div class="col-4"><input type="text" name="c_struct_v[]" value="<?= $row['v'] ?>" class="form-control"></div>
                        <div class="col-4"><input type="text" name="c_struct_q[]" value="<?= $row['q'] ?>" class="form-control"></div>
                        <div class="col-3"><input type="text" name="c_struct_n[]" value="<?= $row['n'] ?>" class="form-control"></div>
                        <div class="col-1"><button type="button" class="btn btn-sm text-danger remove-btn">✕</button></div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addStructRow()" class="btn btn-sm btn-outline-primary mt-2">+ Add Row</button>
            </div>

            <!-- --- 3 & 4. MEASURE & ADMINISTER --- -->
            <div class="row">
                <div class="col-md-6">
                    <div class="section-box h-100">
                        <h4 class="fw-bold mb-3 text-primary">3. What Does It Measure?</h4>
                        <input type="text" name="c_measure_h" value="<?= $measureData['heading'] ?? '' ?>" class="form-control input-xl mb-3" placeholder="Heading">
                        <textarea name="c_measure_d" class="form-control input-xl" rows="5"><?= $measureData['content'] ?? '' ?></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="section-box h-100">
                        <h4 class="fw-bold mb-3 text-primary">4. How Administered?</h4>
                        <input type="text" name="c_admin_h" value="<?= $administerData['heading'] ?? '' ?>" class="form-control input-xl mb-3" placeholder="Heading">
                        <div class="quill-container">
                            <div id="admin-editor" style="height: 150px;"><?= $administerData['content'] ?? '' ?></div>
                            <input type="hidden" name="c_admin_content" id="admin_content_input">
                        </div>
                    </div>
                </div>
            </div>

            <!-- --- 5. LEVELS & TIMING --- -->
            <div class="section-box shadow-sm mt-4">
                <h4 class="fw-bold mb-4 text-primary border-bottom pb-2">5. Levels & Timing</h4>
                <input type="text" name="c_levels_h" value="<?= $levelsData['heading'] ?? '' ?>" class="form-control input-xl mb-3">
                <textarea name="c_levels_d" class="form-control input-xl mb-4" rows="2"><?= $levelsData['desc'] ?? '' ?></textarea>
                
                <div id="levels-table" class="bg-white p-3 rounded border mb-4">
                    <div class="row g-2 mb-2 fw-bold small text-muted">
                        <div class="col-3">Grade</div><div class="col-3">Level</div><div class="col-3">Questions</div><div class="col-2">Time</div>
                    </div>
                    <?php foreach(($levelsData['table'] ?? [['g'=>'','l'=>'','q'=>'','t'=>'']]) as $row): ?>
                    <div class="row g-2 mb-2 align-items-center">
                        <div class="col-3"><input type="text" name="c_lt_g[]" value="<?= $row['g'] ?>" class="form-control"></div>
                        <div class="col-3"><input type="text" name="c_lt_l[]" value="<?= $row['l'] ?>" class="form-control"></div>
                        <div class="col-3"><input type="text" name="c_lt_q[]" value="<?= $row['q'] ?>" class="form-control"></div>
                        <div class="col-2"><input type="text" name="c_lt_t[]" value="<?= $row['t'] ?>" class="form-control"></div>
                        <div class="col-1"><button type="button" class="btn btn-sm text-danger remove-btn">✕</button></div>
                    </div>
                    <?php endforeach; ?>
                    <button type="button" onclick="addLevelsRow()" class="btn btn-sm btn-link text-primary p-0">+ Add Level Row</button>
                </div>

                <input type="text" name="c_qcount_h" value="<?= $levelsData['q_heading'] ?? '' ?>" class="form-control input-xl mb-3" placeholder="Question Count Heading">
                <textarea name="c_qcount_d" class="form-control input-xl" rows="2"><?= $levelsData['q_desc'] ?? '' ?></textarea>
            </div>

            <!-- --- 6. BATTERY DETAILS --- -->
            <div class="section-box shadow-sm">
                <h4 class="fw-bold mb-4 text-primary border-bottom pb-2">6. Battery Details</h4>
                
                <?php 
                $batteries = ['Verbal' => 'v', 'Non-Verbal' => 'nv', 'Quantitative' => 'q'];
                foreach($batteries as $label => $key): 
                ?>
                <div class="mb-5">
                    <h6 class="fw-bold mb-3"><?= strtoupper($label) ?> BATTERY</h6>
                    <div id="battery-<?= $key ?>">
                        <?php foreach(($batteryData[$key] ?? [['t'=>'','c'=>'']]) as $item): ?>
                        <div class="row g-2 mb-2 align-items-start battery-item">
                            <div class="col-4"><input type="text" name="c_bat_t_<?= $key ?>[]" value="<?= $item['t'] ?>" class="form-control fw-bold" placeholder="Title"></div>
                            <div class="col-7"><textarea name="c_bat_c_<?= $key ?>[]" class="form-control small" rows="2" placeholder="Content"><?= $item['c'] ?></textarea></div>
                            <div class="col-1"><button type="button" class="btn btn-sm text-danger remove-btn">✕</button></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" onclick="addBatteryItem('<?= $key ?>')" class="btn btn-sm btn-outline-primary">+ Add <?= $label ?> Item</button>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- --- 7. SCORING & LOCATION --- -->
            <div class="section-box shadow-sm">
                <h4 class="fw-bold mb-4 text-primary border-bottom pb-2">7. Scoring & Location</h4>
                <div class="row g-4">
                    <div class="col-md-6">
                        <input type="text" name="c_score_h" value="<?= $scoreLocData['s_h'] ?? '' ?>" class="form-control input-xl mb-2 fw-bold" placeholder="Scoring Heading">
                        <textarea name="c_score_d" class="form-control input-xl" rows="4"><?= $scoreLocData['s_d'] ?? '' ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="c_loc_h" value="<?= $scoreLocData['l_h'] ?? '' ?>" class="form-control input-xl mb-2 fw-bold" placeholder="Location Heading">
                        <textarea name="c_loc_d" class="form-control input-xl" rows="4"><?= $scoreLocData['l_d'] ?? '' ?></textarea>
                    </div>
                </div>
            </div>

            <!-- ACTIONS -->
            <div class="actions-bar rounded-4 d-flex gap-3 shadow">
                <button type="submit" class="btn btn-primary flex-grow-1 py-3 fw-bold shadow">Save CogAT Changes</button>
                <button type="button" class="btn btn-outline-danger px-5 fw-bold">Delete All</button>
            </div>
        </form>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
function initQuill(el) {
    return new Quill(el, { theme: 'snow', modules: { toolbar: [['bold', 'italic', 'underline'], [{list:'bullet'}], ['clean']] } });
}

// Initialise Quill
document.querySelectorAll('.quill-editor').forEach(el => initQuill(el));
var adminEditor = initQuill('#admin-editor');

function addHeroBullet() {
    const html = `<div class="bullet-item mb-3 position-relative animate__animated animate__fadeIn"><div class="quill-editor" style="height: 80px;"></div><input type="hidden" name="c_hero_bullets[]" class="quill-hidden-input"><button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 remove-btn">✕</button></div>`;
    document.getElementById('hero-bullets').insertAdjacentHTML('beforeend', html);
    initQuill(document.getElementById('hero-bullets').lastElementChild.querySelector('.quill-editor'));
}

function addStructRow() {
    const html = `<div class="row g-2 mb-2 align-items-center animate__animated animate__fadeIn"><div class="col-4"><input type="text" name="c_struct_v[]" class="form-control"></div><div class="col-4"><input type="text" name="c_struct_q[]" class="form-control"></div><div class="col-3"><input type="text" name="c_struct_n[]" class="form-control"></div><div class="col-1"><button type="button" class="btn btn-sm text-danger remove-btn">✕</button></div></div>`;
    document.getElementById('struct-table').insertAdjacentHTML('beforeend', html);
}

function addLevelsRow() {
    const html = `<div class="row g-2 mb-2 align-items-center animate__animated animate__fadeIn"><div class="col-3"><input type="text" name="c_lt_g[]" class="form-control"></div><div class="col-3"><input type="text" name="c_lt_l[]" class="form-control"></div><div class="col-3"><input type="text" name="c_lt_q[]" class="form-control"></div><div class="col-2"><input type="text" name="c_lt_t[]" class="form-control"></div><div class="col-1"><button type="button" class="btn btn-sm text-danger remove-btn">✕</button></div></div>`;
    document.getElementById('levels-table').insertAdjacentHTML('beforebegin', html);
}

function addBatteryItem(key) {
    const html = `<div class="row g-2 mb-2 align-items-start battery-item animate__animated animate__fadeIn"><div class="col-4"><input type="text" name="c_bat_t_${key}[]" class="form-control fw-bold"></div><div class="col-7"><textarea name="c_bat_c_${key}[]" class="form-control small" rows="2"></textarea></div><div class="col-1"><button type="button" class="btn btn-sm text-danger remove-btn">✕</button></div></div>`;
    document.getElementById(`battery-${key}`).insertAdjacentHTML('beforeend', html);
}

document.addEventListener('click', e => { if(e.target.classList.contains('remove-btn')) e.target.closest('.row, .bullet-item, .battery-item').remove(); });

document.getElementById('cogatForm').onsubmit = function() {
    document.querySelectorAll('.bullet-item').forEach(item => {
        item.querySelector('.quill-hidden-input').value = item.querySelector('.ql-editor').innerHTML;
    });
    document.getElementById('admin_content_input').value = adminEditor.root.innerHTML;
};
</script>

<?php include 'includes/footer.php'; ?>