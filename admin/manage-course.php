<?php 
require_once 'includes/auth_check.php';
require_once '../functions.php';

// 1. URL se type pakdein
$type = $_GET['type'] ?? 'math-common-core';
$data = getCourseData($type);
$content = json_decode($data['content_json'] ?? '{}', true);

include('includes/header.php'); 
include('includes/sidebar.php'); 
?>

<!-- CKEditor Script -->
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>

<div class="content-area">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold m-0"><?php echo ucwords(str_replace('-', ' ', $type)); ?></h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb m-0 small">
                <li class="breadcrumb-item"><a href="dashboard.php" class="text-decoration-none text-muted">Home</a></li>
                <li class="breadcrumb-item active fw-bold text-dark">Course Management</li>
            </ol>
        </nav>
    </div>

    <div class="card border-0 shadow-sm rounded-4 col-lg-11 mx-auto mt-4">
        <div class="card-body p-4 p-lg-5">
            <form action="../api/admin/manage-course.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="category_slug" value="<?php echo $type; ?>">
                
                <!-- 🟢 COMMON: Page Main Title -->
                <div class="mb-4">
                    <label class="fw-bold small mb-2 text-muted uppercase">Page Main Title</label>
                    <input type="text" name="title" class="form-control custom-input fw-bold" 
                           value="<?php echo $data['title'] ?? ''; ?>" placeholder="Enter Title">
                </div>
                <hr class="my-5">

                <?php if($type == 'math-common-core'): ?>
                    <!-- #############################################################
                         SECTION 1: MATH COMMON CORE
                         ############################################################# -->
                    <label class="fw-bold mb-3">Course Descriptions (Paragraphs)</label>
                    <div id="desc-list">
                        <?php foreach(($content['descriptions'] ?? ['']) as $val): ?>
                            <div class="input-group mb-3">
                                <textarea name="content[descriptions][]" class="form-control custom-input" rows="3"><?php echo $val; ?></textarea>
                                <button type="button" class="btn btn-danger remove-row ms-2">×</button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" onclick="addInput('desc-list')" class="btn btn-outline-primary btn-sm">+ Add Paragraph</button>

              <!-- #############################################################
     SECTION 2: MATH ALGEBRA (Heading + Chapters Objects) - FIXED
     ############################################################# -->
<?php elseif($type == 'math-algebra'): ?>
    <label class="fw-bold small mb-2 text-muted">HEADING DESCRIPTION</label>
    <textarea name="content[main_desc]" class="form-control custom-input mb-5" rows="3"><?php echo $content['main_desc'] ?? ''; ?></textarea>

    <label class="fw-bold mb-3">ALGEBRA CHAPTERS</label>
    <div id="algebra-chapter-list">
        <?php 
        // Logic: Agar data array hai toh loop chalao, varna khali array
        $chapters = (isset($content['chapters']) && is_array($content['chapters'])) ? $content['chapters'] : [['name'=>'', 'desc'=>'']];
        
        foreach($chapters as $c): 
            // Safe access taaki error na aaye
            $chapterName = is_array($c) ? ($c['name'] ?? '') : '';
            $chapterDesc = is_array($c) ? ($c['desc'] ?? '') : '';
        ?>
        <div class="p-4 bg-light rounded-4 mb-4 border position-relative">
            <!-- Remove Button -->
            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 remove-row">×</button>
            
            <!-- Chapter Name Field -->
            <div class="mb-3">
                <label class="small fw-bold text-muted mb-1">CHAPTER NAME</label>
                <input type="text" name="content[chapters][name][]" class="form-control mb-3 fw-bold custom-input" 
                       value="<?php echo $chapterName; ?>" placeholder="e.g. Linear Equations">
            </div>

            <!-- Chapter Description Field -->
            <div>
                <label class="small fw-bold text-muted mb-1">CHAPTER DESCRIPTION</label>
                <textarea name="content[chapters][desc][]" class="form-control custom-input" rows="3" 
                          placeholder="About this chapter..."><?php echo $chapterDesc; ?></textarea>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <button type="button" onclick="addAlgebraChapter()" class="btn btn-outline-primary btn-sm rounded-3 shadow-sm">
        <i class="fas fa-plus me-1"></i> Add Chapter
    </button>
                    <!-- #############################################################
                         SECTION 3: GEOMETRY
                         ############################################################# -->
                    <label class="fw-bold small mb-1">Main Description</label>
                    <textarea name="content[main_description]" class="form-control custom-input mb-3" rows="4"><?php echo $content['main_description'] ?? ''; ?></textarea>
                    <label class="fw-bold small mb-1">Subject Description</label>
                    <textarea name="content[subject_description]" class="form-control custom-input mb-4" rows="4"><?php echo $content['subject_description'] ?? ''; ?></textarea>
                    <label class="fw-bold mb-2">Chapter Names</label>
                    <div id="geo-names"><?php foreach(($content['chapter_names'] ?? ['']) as $n): ?>
                        <div class="input-group mb-2"><input type="text" name="content[chapter_names][]" class="form-control custom-input" value="<?php echo $n; ?>"><button type="button" class="btn btn-danger remove-row">×</button></div>
                    <?php endforeach; ?></div>
                    <button type="button" onclick="addSimpleRow('geo-names', 'content[chapter_names][]')" class="btn btn-link text-decoration-none small">+ Add Chapter Name</button>

                <?php elseif($type == 'math-amc'): ?>
                    <!-- #############################################################
                         SECTION 4: MATH AMC
                         ############################################################# -->
                    <label class="fw-bold small mb-1">Participate Details</label>
                    <div id="amc-parts"><?php foreach(($content['participate'] ?? ['']) as $p): ?>
                        <div class="input-group mb-2"><input type="text" name="content[participate][]" class="form-control custom-input" value="<?php echo $p; ?>"><button type="button" class="btn btn-danger remove-row">×</button></div>
                    <?php endforeach; ?></div>
                    <button type="button" onclick="addSimpleRow('amc-parts', 'content[participate][]')" class="btn btn-link text-decoration-none small">+ Add Condition</button>

                    <h5 class="fw-bold mt-5 mb-4">Competition Cards</h5>
                    <div id="amc-cards-container">
                        <?php foreach(($content['competitions'] ?? []) as $amc): ?>
                        <div class="p-4 border rounded-4 mb-4 bg-white shadow-sm position-relative amc-card">
                            <button type="button" class="btn btn-link text-danger position-absolute top-0 end-0 m-2 remove-row">Remove</button>
                            <input type="text" name="content[competitions][name][]" class="form-control mb-3 fw-bold" placeholder="AMC Name" value="<?php echo $amc['name'] ?? ''; ?>">
                            <textarea name="content[competitions][desc_rich][]" class="amc-editor mb-3"><?php echo $amc['desc_rich'] ?? ''; ?></textarea>
                            <textarea name="content[competitions][desc_plain][]" class="form-control mb-3" rows="2" placeholder="Description"><?php echo $amc['desc_plain'] ?? ''; ?></textarea>
                            <input type="text" name="content[competitions][for][]" class="form-control mb-2" placeholder="For" value="<?php echo $amc['for'] ?? ''; ?>">
                            <input type="text" name="content[competitions][when][]" class="form-control" placeholder="When" value="<?php echo $amc['when'] ?? ''; ?>">
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" onclick="addAmcCard()" class="btn btn-outline-primary w-100 py-2 border-dashed fw-bold">+ Add Competition Card</button>

                <?php elseif($type == 'math-kangaroo'): ?>
                    <!-- #############################################################
                         SECTION 5: MATH KANGAROO
                         ############################################################# -->
                    <?php $kangDetails = getKangarooDetails(); ?>
                    <label class="fw-bold mb-2">Test Prep Description</label>
                    <textarea name="content[test_prep_desc]" class="form-control custom-input mb-4" rows="4"><?php echo $content['test_prep_desc'] ?? ''; ?></textarea>
                    <label class="fw-bold mb-2">Test Structure Points</label>
                    <div id="kan-list"><?php foreach(($content['structures'] ?? ['']) as $s): ?>
                        <div class="input-group mb-2"><input type="text" name="content[structures][]" class="form-control custom-input" value="<?php echo $s; ?>"><button type="button" class="btn btn-danger remove-row">×</button></div>
                    <?php endforeach; ?></div>
                    <button type="button" onclick="addSimpleRow('kan-list', 'content[structures][]')" class="btn btn-link text-decoration-none small">+ Add Point</button>

                    <div class="d-flex justify-content-between align-items-center mt-5 mb-3">
                        <h5 class="fw-bold m-0 text-primary">Kangaroo Detail List</h5>
                        <button type="button" class="btn btn-primary btn-sm shadow-blue" data-bs-toggle="modal" data-bs-target="#addKangarooCardModal">+ Add Detail</button>
                    </div>
                    <div class="table-responsive border rounded-4 bg-white">
                        <table class="table align-middle m-0"><thead class="table-light"><tr><th class="ps-3">Icon</th><th>Title</th><th class="text-end pe-3">Action</th></tr></thead>
                        <tbody><?php if($kangDetails): foreach($kangDetails as $kd): ?>
                            <tr><td class="ps-3"><img src="../<?php echo $kd['image']; ?>" width="40" class="rounded"></td><td class="fw-bold"><?php echo $kd['title']; ?></td><td class="text-end pe-3"><a href="../api/admin/manage-kangaroo.php?action=delete&id=<?php echo $kd['id']; ?>" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></a></td></tr>
                        <?php endforeach; endif; ?></tbody></table>
                    </div>

                <?php elseif($type == 'math-science'): ?>
                    <!-- #############################################################
                         SECTION 6: SCIENCE
                         ############################################################# -->
                    <?php $sciDetails = getScienceDetails(); ?>
                    <label class="fw-bold small mb-2 uppercase">About Science Description</label>
                    <textarea name="content[science_desc]" class="form-control custom-input mb-4" rows="4"><?php echo $content['science_desc'] ?? ''; ?></textarea>
                    <label class="fw-bold small mb-2 uppercase">Science Tutor Description</label>
                    <textarea name="content[science_tutor_desc]" class="form-control custom-input mb-4" rows="4"><?php echo $content['science_tutor_desc'] ?? ''; ?></textarea>
                    
                    <div class="d-flex justify-content-between align-items-center mt-5 mb-3">
                        <h5 class="fw-bold m-0 text-primary">Science Detail List</h5>
                        <button type="button" class="btn btn-primary btn-sm shadow-blue" data-bs-toggle="modal" data-bs-target="#addScienceDetailModal">+ Add Detail</button>
                    </div>
                    <div class="table-responsive border rounded-4 bg-white shadow-sm">
                        <table class="table align-middle m-0"><thead class="table-light"><tr><th class="ps-4">Image</th><th>Title</th><th class="text-end pe-4">Action</th></tr></thead>
                        <tbody><?php if($sciDetails): foreach($sciDetails as $sd): ?>
                            <tr><td class="ps-4"><img src="../<?php echo $sd['image']; ?>" width="50" class="rounded"></td><td class="fw-bold"><?php echo $sd['title']; ?></td><td class="text-end pe-4"><a href="../api/admin/manage-science.php?action=delete&id=<?php echo $sd['id']; ?>" class="btn btn-sm btn-outline-danger border-0"><i class="fas fa-trash-alt"></i></a></td></tr>
                        <?php endforeach; endif; ?></tbody></table>
                    </div>

                <?php elseif($type == 'k12-management'): ?>
                    <!-- #############################################################
                         SECTION 7: K-12 MANAGEMENT
                         ############################################################# -->
                    <ul class="nav nav-tabs border-0 custom-tabs mb-4">
                        <li class="nav-item"><button class="nav-link active fw-bold" data-bs-toggle="tab" data-bs-target="#service-pane" type="button">Service</button></li>
                        <li class="nav-item"><button class="nav-link fw-bold ms-4" data-bs-toggle="tab" data-bs-target="#methodology-pane" type="button">Methodology</button></li>
                    </ul>
                    <div class="tab-content border rounded-4 p-4 bg-white shadow-sm">
                        <div class="tab-pane fade show active" id="service-pane">
                            <input type="text" name="content[service_title]" class="form-control custom-input mb-3" placeholder="Service Title" value="<?php echo $content['service_title'] ?? ''; ?>">
                            <textarea name="content[service_description]" class="form-control custom-input mb-4" rows="3" placeholder="Description"><?php echo $content['service_description'] ?? ''; ?></textarea>
                            <label class="upload-box-dashed w-100 mb-4">
                                <input type="file" name="service_image" hidden onchange="previewK12(this, 'service-prev')">
                                <div class="text-center py-3">Upload Service Image</div>
                                <img id="service-prev" src="../<?php echo $content['service_image'] ?? ''; ?>" class="img-fluid rounded-3">
                            </label>
                            <!-- Subject Expertise Logic -->
                            <div id="subject-expertise-list">
                                <?php $subjects = $content['subjects'] ?? [['title'=>'', 'points'=>[''], 'image'=>'']];
                                foreach($subjects as $idx => $sub): ?>
                                    <div class="border-top pt-4 mt-4">
                                        <input type="text" name="content[subjects][<?php echo $idx; ?>][title]" class="form-control custom-input mb-3" placeholder="Subject Name" value="<?php echo $sub['title']; ?>">
                                        <div class="points-container mb-3">
                                            <?php foreach($sub['points'] as $point): ?>
                                                <div class="input-group mb-2"><input type="text" name="content[subjects][<?php echo $idx; ?>][points][]" class="form-control custom-input" value="<?php echo $point; ?>"><button type="button" class="btn btn-danger remove-row">×</button></div>
                                            <?php endforeach; ?>
                                            <button type="button" onclick="addPointRow(this, <?php echo $idx; ?>)" class="btn btn-success btn-sm">+ Add Point</button>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="methodology-pane">
                            <div id="method-list"><?php foreach(($content['methodology'] ?? ['']) as $m): ?>
                                <div class="input-group mb-2"><input type="text" name="content[methodology][]" class="form-control custom-input" value="<?php echo $m; ?>"><button type="button" class="btn btn-danger remove-row">×</button></div>
                            <?php endforeach; ?></div>
                            <button type="button" onclick="addSimpleRow('method-list', 'content[methodology][]')" class="btn btn-primary btn-sm">+ Add Point</button>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="mt-5 border-top pt-5">
                    <button type="submit" class="btn btn-primary btn-lg w-100 rounded-3 fw-bold shadow-blue py-3">Save All Page Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- --- MODALS --- -->
<div class="modal fade" id="addScienceDetailModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered"><div class="modal-content border-0 rounded-4 shadow-lg"><div class="modal-header border-0"><h5 class="fw-bold">Add Detail</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><form action="../api/admin/manage-science.php?action=add_detail" method="POST" enctype="multipart/form-data"><div class="modal-body p-4"><input type="text" name="title" class="form-control custom-input mb-3" placeholder="Title" required><input type="text" name="heading" class="form-control custom-input mb-3" placeholder="Heading" required><textarea name="description" class="form-control custom-input mb-3" rows="4" placeholder="Description" required></textarea><input type="file" name="image" class="form-control custom-input mb-4" required><button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Save</button></div></form></div></div>
</div>
<div class="modal fade" id="addKangarooCardModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered"><div class="modal-content border-0 rounded-4 shadow-lg"><div class="modal-header border-0"><h5 class="fw-bold">Add Kangaroo Detail</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><form action="../api/admin/manage-kangaroo.php?action=add_card" method="POST" enctype="multipart/form-data"><div class="modal-body p-4"><input type="text" name="title" class="form-control custom-input mb-3" placeholder="Title" required><div id="modal-desc-list"><textarea name="descriptions[]" class="form-control custom-input mb-2" rows="2" placeholder="Detail Point" required></textarea></div><button type="button" onclick="addModalDesc()" class="btn btn-link text-decoration-none small p-0 mb-3">+ Add Point</button><input type="file" name="image" class="form-control custom-input mb-4" required><button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Save Card</button></div></form></div></div>
</div>

<!-- --- JAVASCRIPT --- -->
<script>
function initEditors() {
    document.querySelectorAll('.amc-editor').forEach(el => {
        if (!el.classList.contains('ck-initialized')) {
            ClassicEditor.create(el).catch(err => console.error(err)); el.classList.add('ck-initialized');
        }
    });
}
function addInput(id) {
    const container = document.getElementById(id);
    const div = document.createElement('div'); div.className = 'input-group mb-3 align-items-start';
    div.innerHTML = `<textarea name="content[descriptions][]" class="form-control custom-input" rows="3"></textarea><button type="button" class="btn btn-danger remove-row ms-2">×</button>`;
    container.appendChild(div);
}
function addSimpleRow(id, name) {
    const container = document.getElementById(id);
    const div = document.createElement('div'); div.className = 'input-group mb-2';
    div.innerHTML = `<input type="text" name="${name}" class="form-control custom-input"><button type="button" class="btn btn-danger remove-row">×</button>`;
    container.appendChild(div);
}
function addAlgebraChapter() {
    const container = document.getElementById('algebra-chapter-list');
    const div = document.createElement('div'); div.className = 'p-4 bg-light rounded-4 mb-4 border position-relative';
    div.innerHTML = `<input type="text" name="content[chapters][name][]" class="form-control mb-3 fw-bold" placeholder="Chapter Name"><textarea name="content[chapters][desc][]" class="form-control custom-input" rows="3" placeholder="Chapter Description"></textarea><button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 remove-row">×</button>`;
    container.appendChild(div);
}
function addAmcCard() {
    const container = document.getElementById('amc-cards-container');
    const div = document.createElement('div'); div.className = 'p-4 border rounded-4 mb-4 bg-white shadow-sm position-relative';
    div.innerHTML = `<button type="button" class="btn btn-sm btn-link text-danger position-absolute top-0 end-0 m-2 remove-row text-decoration-none">Remove</button><input type="text" name="content[competitions][name][]" class="form-control mb-3 fw-bold" placeholder="AMC Name"><textarea name="content[competitions][desc_rich][]" class="amc-editor mb-3"></textarea><textarea name="content[competitions][desc_plain][]" class="form-control mb-3" rows="2" placeholder="Description"></textarea><input type="text" name="content[competitions][for][]" class="form-control mb-2" placeholder="For"><input type="text" name="content[competitions][when][]" class="form-control" placeholder="When">`;
    container.appendChild(div); initEditors();
}
function addPointRow(btn, subjectIdx) {
    const div = document.createElement('div'); div.className = 'input-group mb-2';
    div.innerHTML = `<input type="text" name="content[subjects][${subjectIdx}][points][]" class="form-control custom-input"><button type="button" class="btn btn-danger remove-row">×</button>`;
    btn.previousElementSibling.appendChild(div);
}
function addModalDesc() {
    const div = document.createElement('div'); div.innerHTML = `<textarea name="descriptions[]" class="form-control custom-input mb-2" rows="2" placeholder="Detail Point"></textarea>`;
    document.getElementById('modal-desc-list').appendChild(div);
}
function previewK12(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader(); reader.onload = e => { preview.src = e.target.result; preview.classList.remove('d-none'); }
        reader.readAsDataURL(input.files[0]);
    }
}
document.addEventListener('click', e => { if(e.target.classList.contains('remove-row')) e.target.closest('.input-group, .border, .p-4').remove(); });
document.addEventListener('DOMContentLoaded', initEditors);
</script>

<style>
.custom-input { border: 1px solid #e0e6ed; border-radius: 12px; padding: 12px 15px; }
.border-dashed { border: 2px dashed #305CDE; border-radius: 10px; background: #fcfdff; cursor: pointer; }
.shadow-blue { box-shadow: 0 10px 20px rgba(48, 92, 222, 0.15) !important; }
.uppercase { text-transform: uppercase; letter-spacing: 1px; }
</style>

<?php include('includes/footer.php'); ?>