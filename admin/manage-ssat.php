<?php 
require_once '../functions.php';
include 'includes/header.php';
include 'includes/sidebar.php';

$slug = 'ssat'; 
$data = getTestPrepData($slug); 

// Mapping JSON Data to Variables
$hero = $data['hero'] ?? [];
$about = $data['about'] ?? [];
$levels = $data['levels'] ?? [];
$comp = $data['comparison'] ?? [];
$facts = $data['facts'] ?? [];
$scoring = $data['scoring'] ?? [];
$struct = $data['structure'] ?? [];
$footer_score = $data['footer_score'] ?? [];
?>

<div class="main-content p-4" style="background-color: #f3f4f6;">
    <div class="container-fluid bg-white p-4 p-md-5 shadow-lg rounded-4 border border-light" style="max-width: 1000px;">
        
        <h1 class="h3 fw-bold text-blue-900 border-bottom pb-4 mb-4">Edit SSAT Page</h1>

        <form action="api/admin/save-ssat.php" method="POST">
            <input type="hidden" name="slug" value="ssat">

            <!-- 1. Hero Section -->
            <div class="p-4 rounded-4 mb-4" style="background-color: #f0f7ff; border: 1px solid #c3dafe;">
                <h5 class="fw-bold text-primary mb-3">1. Hero Section</h5>
                <input type="text" name="hero[title]" value="<?= $hero['title'] ?? '' ?>" class="form-control mb-2" placeholder="Main Title">
                <textarea name="hero[description]" class="form-control mb-2" rows="3" placeholder="Intro Paragraph..."><?= $hero['description'] ?? '' ?></textarea>
                <input type="text" name="hero[cta]" value="<?= $hero['cta'] ?? '' ?>" class="form-control border-primary border-opacity-25" placeholder="Top CTA Text">
            </div>

            <!-- 2. About & 3. Levels -->
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="p-4 rounded-4 bg-light border h-100">
                        <h5 class="fw-bold mb-3">2. About Section</h5>
                        <input type="text" name="about[heading]" value="<?= $about['heading'] ?? '' ?>" class="form-control mb-2" placeholder="Heading">
                        <textarea name="about[description]" class="form-control" rows="4" placeholder="Content"><?= $about['description'] ?? '' ?></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4 rounded-4 bg-light border h-100">
                        <h5 class="fw-bold mb-3">3. Levels</h5>
                        <div id="level-container">
                            <?php foreach($levels as $lv): ?>
                            <div class="row g-2 mb-2 bg-white p-2 rounded shadow-sm border position-relative">
                                <div class="col-12"><input type="text" name="lv_title[]" value="<?= $lv['title'] ?>" class="form-control form-control-sm mb-1" placeholder="Title"></div>
                                <div class="col-11"><textarea name="lv_desc[]" class="form-control form-control-sm" rows="2"><?= $lv['desc'] ?></textarea></div>
                                <div class="col-1"><button type="button" class="btn btn-sm text-danger fw-bold" onclick="this.parentElement.parentElement.remove()">×</button></div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="btn btn-sm btn-link text-primary fw-bold p-0" onclick="addLevelBox()">+ Add Level Box</button>
                    </div>
                </div>
            </div>

            <!-- 5. Comparison -->
            <div class="p-4 rounded-4 mb-4" style="background-color: #fffaf0; border: 1px solid #feebc8;">
                <h5 class="fw-bold text-warning mb-3">5. Comparison (ISEE vs SSAT)</h5>
                <input type="text" name="comp[heading]" value="<?= $comp['heading'] ?? '' ?>" class="form-control mb-2 fw-bold" placeholder="Comparison Heading">
                <textarea name="comp[description]" class="form-control mb-3" rows="2" placeholder="Intro text..."><?= $comp['description'] ?? '' ?></textarea>
                
                <label class="small fw-bold text-muted">Bullet Points:</label>
                <div id="comp-points-container">
                    <?php foreach(($comp['points'] ?? []) as $pt): ?>
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-white">•</span>
                        <input type="text" name="comp_points[]" value="<?= $pt ?>" class="form-control">
                        <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">×</button>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="btn btn-sm btn-link text-warning fw-bold p-0" onclick="addCompPoint()">+ Add Point</button>
            </div>

            <!-- 7. Quick Facts -->
            <div class="p-4 rounded-4 mb-4" style="background-color: #f0fff4; border: 1px solid #c6f6d5;">
                <h5 class="fw-bold text-success mb-3">7. Quick Facts</h5>
                <input type="text" name="facts[heading]" value="<?= $facts['heading'] ?? '' ?>" class="form-control mb-2 fw-bold" placeholder="Heading">
                <textarea name="facts[content]" class="form-control mb-2" rows="4" placeholder="Paste content..."><?= $facts['content'] ?? '' ?></textarea>
                <input type="text" name="facts[disclaimer]" value="<?= $facts['disclaimer'] ?? '' ?>" class="form-control form-control-sm italic" placeholder="Disclaimer text...">
            </div>

            <!-- 6. Scoring Cards -->
            <div class="p-4 rounded-4 mb-4" style="background-color: #faf5ff; border: 1px solid #e9d8fd;">
                <h5 class="fw-bold text-purple mb-3" style="color: #6b46c1;">6. Scoring Cards</h5>
                <input type="text" name="scoring[heading]" value="<?= $scoring['heading'] ?? '' ?>" class="form-control mb-3" placeholder="Scoring Heading">
                <div class="row g-2" id="scoring-card-container">
                    <?php foreach(($scoring['cards'] ?? []) as $sc): ?>
                    <div class="col-md-4">
                        <div class="bg-white p-2 border rounded shadow-sm position-relative">
                            <button type="button" class="btn btn-sm text-danger position-absolute top-0 end-0" onclick="this.parentElement.parentElement.remove()">×</button>
                            <input type="text" name="score_card_title[]" value="<?= $sc['title'] ?>" class="form-control form-control-sm mb-1 fw-bold" placeholder="Title">
                            <textarea name="score_card_content[]" class="form-control form-control-sm" rows="3"><?= $sc['content'] ?></textarea>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="btn btn-sm btn-link text-purple fw-bold p-0 mt-2" onclick="addScoreCard()">+ Add Scoring Card</button>
                <input type="text" name="scoring[footer]" value="<?= $scoring['footer'] ?? '' ?>" class="form-control mt-3 small italic" placeholder="Footer Note">
            </div>

            <!-- 8. Test Structure Tables -->
            <div class="p-4 rounded-4 mb-4 bg-light border">
                <h5 class="fw-bold mb-4 text-dark border-bottom pb-2">8. Test Structure</h5>
                <input type="text" name="struct[heading]" value="<?= $struct['heading'] ?? '' ?>" class="form-control mb-4" placeholder="Structure Heading">
                
                <div class="row g-4">
                    <!-- Middle Level -->
                    <div class="col-xl-6 border-end">
                        <h6 class="fw-bold text-primary">Middle Level</h6>
                        <div id="middle-table">
                            <?php foreach(($struct['middle'] ?? []) as $m): ?>
                            <div class="d-flex gap-1 mb-1 align-items-center">
                                <input type="text" name="m_sec[]" value="<?= $m['section'] ?>" class="form-control form-control-sm" placeholder="Section">
                                <input type="text" name="m_time[]" value="<?= $m['time'] ?>" class="form-control form-control-sm w-25" placeholder="Time">
                                <input type="text" name="m_qs[]" value="<?= $m['questions'] ?>" class="form-control form-control-sm w-25" placeholder="Q's">
                                <input type="text" name="m_link[]" value="<?= $m['download'] ?>" class="form-control form-control-sm" placeholder="URL">
                                <button type="button" class="btn btn-sm text-danger" onclick="this.parentElement.remove()">×</button>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="btn btn-sm btn-link p-0 fw-bold" onclick="addTableRow('middle')">+ Add Row</button>
                    </div>
                    <!-- Upper Level -->
                    <div class="col-xl-6">
                        <h6 class="fw-bold text-success">Upper Level</h6>
                        <div id="upper-table">
                            <?php foreach(($struct['upper'] ?? []) as $u): ?>
                            <div class="d-flex gap-1 mb-1 align-items-center">
                                <input type="text" name="u_sec[]" value="<?= $u['section'] ?>" class="form-control form-control-sm" placeholder="Section">
                                <input type="text" name="u_time[]" value="<?= $u['time'] ?>" class="form-control form-control-sm w-25" placeholder="Time">
                                <input type="text" name="u_qs[]" value="<?= $u['questions'] ?>" class="form-control form-control-sm w-25" placeholder="Q's">
                                <input type="text" name="u_link[]" value="<?= $u['download'] ?>" class="form-control form-control-sm" placeholder="URL">
                                <button type="button" class="btn btn-sm text-danger" onclick="this.parentElement.remove()">×</button>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="btn btn-sm btn-link text-success p-0 fw-bold" onclick="addTableRow('upper')">+ Add Row</button>
                    </div>
                </div>
            </div>

            <!-- 9. Good Score & Footer -->
            <div class="p-4 rounded-4 mb-5 shadow-sm" style="background-color: #fff5f5; border: 1px solid #feb2b2;">
                <h5 class="fw-bold text-danger mb-4">9. Good Score & Footer</h5>
                <input type="text" name="footer_score[heading]" value="<?= $footer_score['heading'] ?? '' ?>" class="form-control mb-3 fw-bold" placeholder="Heading">
                <textarea name="footer_score[intro]" class="form-control mb-3" rows="2" placeholder="Intro Text"><?= $footer_score['intro'] ?? '' ?></textarea>
                <div class="row g-3">
                    <div class="col-md-6"><textarea name="footer_score[scaled]" class="form-control" rows="3" placeholder="Scaled Scores Details"><?= $footer_score['scaled'] ?? '' ?></textarea></div>
                    <div class="col-md-6"><textarea name="footer_score[percentile]" class="form-control" rows="3" placeholder="Percentile Ranks Details"><?= $footer_score['percentile'] ?? '' ?></textarea></div>
                </div>
                <input type="text" name="footer_score[cta]" value="<?= $footer_score['cta'] ?? '' ?>" class="form-control mt-3 border-danger border-opacity-25" placeholder="Footer CTA Text">
            </div>

            <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-3 shadow-lg">💾 Save All SSAT Changes</button>
        </form>
    </div>
</div>

<script>
function addLevelBox() {
    const html = `<div class="row g-2 mb-2 bg-white p-2 rounded shadow-sm border position-relative"><div class="col-12"><input type="text" name="lv_title[]" class="form-control form-control-sm mb-1" placeholder="Title"></div><div class="col-11"><textarea name="lv_desc[]" class="form-control form-control-sm" rows="2" placeholder="Description"></textarea></div><div class="col-1"><button type="button" class="btn btn-sm text-danger fw-bold" onclick="this.parentElement.parentElement.remove()">×</button></div></div>`;
    document.getElementById('level-container').insertAdjacentHTML('beforeend', html);
}
function addCompPoint() {
    const html = `<div class="input-group mb-2"><span class="input-group-text bg-white">•</span><input type="text" name="comp_points[]" class="form-control" placeholder="Point text..."><button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">×</button></div>`;
    document.getElementById('comp-points-container').insertAdjacentHTML('beforeend', html);
}
function addScoreCard() {
    const html = `<div class="col-md-4"><div class="bg-white p-2 border rounded shadow-sm position-relative"><button type="button" class="btn btn-sm text-danger position-absolute top-0 end-0" onclick="this.parentElement.parentElement.remove()">×</button><input type="text" name="score_card_title[]" class="form-control form-control-sm mb-1 fw-bold" placeholder="Card Title"><textarea name="score_card_content[]" class="form-control form-control-sm" rows="3" placeholder="Content..."></textarea></div></div>`;
    document.getElementById('scoring-card-container').insertAdjacentHTML('beforeend', html);
}
function addTableRow(type) {
    const p = (type === 'middle') ? 'm' : 'u';
    const html = `<div class="d-flex gap-1 mb-1 align-items-center"><input type="text" name="${p}_sec[]" class="form-control form-control-sm" placeholder="Section"><input type="text" name="${p}_time[]" class="form-control form-control-sm w-25" placeholder="Time"><input type="text" name="${p}_qs[]" class="form-control form-control-sm w-25" placeholder="Q's"><input type="text" name="${p}_link[]" class="form-control form-control-sm" placeholder="URL"><button type="button" class="btn btn-sm text-danger" onclick="this.parentElement.remove()">×</button></div>`;
    document.getElementById(type + '-table').insertAdjacentHTML('beforeend', html);
}
</script>

<?php include 'includes/footer.php'; ?>