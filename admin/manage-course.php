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
    <!-- Breadcrumbs -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold m-0 text-dark"><?php echo ucwords(str_replace('-', ' ', $type)); ?></h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb m-0 small">
                <li class="breadcrumb-item"><a href="dashboard.php" class="text-decoration-none text-muted">Home</a></li>
                <li class="breadcrumb-item active fw-bold text-dark">Course Management</li>
            </ol>
        </nav>
    </div>

    <!-- Main Form Container -->
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
                         SECTION 1: MATH COMMON CORE (Description List)
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
                    <button type="button" onclick="addInput('desc-list')" class="btn btn-outline-primary btn-sm rounded-3">+ Add Paragraph</button>


                <?php elseif($type == 'math-algebra'): ?>
                    <!-- #############################################################
                         SECTION 2: MATH ALGEBRA (Heading + Chapters Objects) - FIXED
                         ############################################################# -->
                    <label class="fw-bold small mb-2 text-muted uppercase">Heading Description</label>
                    <textarea name="content[main_desc]" class="form-control custom-input mb-5" rows="3"><?php echo $content['main_desc'] ?? ''; ?></textarea>

                    <label class="fw-bold mb-3">Algebra Chapters</label>
                    <div id="algebra-chapter-list">
                        <?php 
                        $chapters = (isset($content['chapters']) && is_array($content['chapters'])) ? $content['chapters'] : [['name'=>'', 'desc'=>'']];
                        foreach($chapters as $c): 
                        ?>
                        <div class="p-4 bg-light rounded-4 mb-4 border position-relative">
                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 remove-row">×</button>
                            <div class="mb-3">
                                <label class="small fw-bold text-muted">CHAPTER NAME</label>
                                <input type="text" name="content[chapters][name][]" class="form-control mb-2 fw-bold custom-input" value="<?php echo $c['name'] ?? ''; ?>" placeholder="Chapter Name">
                            </div>
                            <div>
                                <label class="small fw-bold text-muted">CHAPTER DESCRIPTION</label>
                                <textarea name="content[chapters][desc][]" class="form-control custom-input" rows="3" placeholder="Chapter Description"><?php echo $c['desc'] ?? ''; ?></textarea>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" onclick="addAlgebraChapter()" class="btn btn-outline-primary btn-sm rounded-3 shadow-sm">+ Add Chapter</button>


                <?php elseif($type == 'math-geometry'): ?>





                    <!-- #############################################################
                         SECTION 3: GEOMETRY (Main + Subject + Chapter List)
                         ############################################################# -->
                    <label class="fw-bold small mb-1 uppercase">Main Description</label>
                    <textarea name="content[main_description]" class="form-control custom-input mb-3" rows="4"><?php echo $content['main_description'] ?? ''; ?></textarea>
                    <label class="fw-bold small mb-1 uppercase">Subject Description</label>
                    <textarea name="content[subject_description]" class="form-control custom-input mb-4" rows="4"><?php echo $content['subject_description'] ?? ''; ?></textarea>
                    <label class="fw-bold mb-2">Chapter Names List</label>
                    <div id="geo-names"><?php foreach(($content['chapter_names'] ?? ['']) as $n): ?>
                        <div class="input-group mb-2"><input type="text" name="content[chapter_names][]" class="form-control custom-input" value="<?php echo $n; ?>"><button type="button" class="btn btn-danger remove-row">×</button></div>
                    <?php endforeach; ?></div>
                    <button type="button" onclick="addSimpleRow('geo-names', 'content[chapter_names][]')" class="btn btn-link text-decoration-none small">+ Add Chapter Name</button>


                <?php elseif($type == 'math-amc'): ?>
                    <!-- #############################################################
                         SECTION 4: MATH AMC (Competition Cards + CKEditor) - FIXED
                         ############################################################# -->
                    <label class="fw-bold small mb-1 uppercase">Participate Details</label>
                    <div id="amc-parts"><?php foreach(($content['participate'] ?? ['']) as $p): ?>
                        <div class="input-group mb-2"><input type="text" name="content[participate][]" class="form-control custom-input" value="<?php echo $p; ?>"><button type="button" class="btn btn-danger remove-row">×</button></div>
                    <?php endforeach; ?></div>
                    <button type="button" onclick="addSimpleRow('amc-parts', 'content[participate][]')" class="btn btn-link text-decoration-none small mb-4">+ Add Condition</button>

                    <label class="fw-bold small mb-1 mt-3 uppercase">Why Take Details</label>
                    <div id="amc-whytake"><?php foreach(($content['why_take'] ?? ['']) as $w): ?>
                        <div class="input-group mb-2"><input type="text" name="content[why_take][]" class="form-control custom-input" value="<?php echo $w; ?>"><button type="button" class="btn btn-danger remove-row">×</button></div>
                    <?php endforeach; ?></div>
                    <button type="button" onclick="addSimpleRow('amc-whytake', 'content[why_take][]')" class="btn btn-link text-decoration-none small">+ Add Point</button>

                    <h5 class="fw-bold mt-5 mb-4 border-bottom pb-2">Competition Cards</h5>
                    <div id="amc-cards-container">
                        <?php foreach(($content['competitions'] ?? []) as $amc): ?>
                        <div class="p-4 border rounded-4 mb-4 bg-white shadow-sm position-relative">
                            <button type="button" class="btn btn-link text-danger position-absolute top-0 end-0 m-2 remove-row text-decoration-none">Remove</button>
                            <input type="text" name="content[competitions][name][]" class="form-control mb-3 fw-bold custom-input" placeholder="AMC Name" value="<?php echo $amc['name'] ?? ''; ?>">
                            <textarea name="content[competitions][desc_rich][]" class="amc-editor mb-3"><?php echo $amc['desc_rich'] ?? ''; ?></textarea>
                            <textarea name="content[competitions][desc_plain][]" class="form-control custom-input mb-3" rows="2" placeholder="Plain Description"><?php echo $amc['desc_plain'] ?? ''; ?></textarea>
                            <div class="row">
                                <div class="col-md-6"><input type="text" name="content[competitions][for][]" class="form-control custom-input" placeholder="For" value="<?php echo $amc['for'] ?? ''; ?>"></div>
                                <div class="col-md-6"><input type="text" name="content[competitions][when][]" class="form-control custom-input" placeholder="When" value="<?php echo $amc['when'] ?? ''; ?>"></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" onclick="addAmcCard()" class="btn btn-outline-primary w-100 py-2 border-dashed fw-bold mt-2">+ Add Competition Card</button>


                <?php elseif($type == 'math-kangaroo'): ?>
                    <!-- #############################################################
                         SECTION 5: MATH KANGAROO (Management + List)
                         ############################################################# -->
                    <?php $kangDetails = getKangarooDetails(); ?>
                    <div class="p-4 bg-light rounded-4 border mb-5">
                        <label class="fw-bold mb-2 uppercase small">Test Prep Description</label>
                        <textarea name="content[test_prep_desc]" class="form-control custom-input mb-4" rows="4"><?php echo $content['test_prep_desc'] ?? ''; ?></textarea>
                        <label class="fw-bold mb-2 uppercase small">Test Structure Points</label>
                        <div id="kan-list"><?php foreach(($content['structures'] ?? ['']) as $s): ?>
                            <div class="input-group mb-2"><input type="text" name="content[structures][]" class="form-control custom-input" value="<?php echo $s; ?>"><button type="button" class="btn btn-danger remove-row">×</button></div>
                        <?php endforeach; ?></div>
                        <button type="button" onclick="addSimpleRow('kan-list', 'content[structures][]')" class="btn btn-link text-decoration-none small">+ Add Point</button>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3"><h5 class="fw-bold m-0 text-primary">Kangaroo Detail Cards</h5><button type="button" class="btn btn-primary btn-sm px-3 shadow-blue" data-bs-toggle="modal" data-bs-target="#addKangarooCardModal">+ Add Detail</button></div>
                    <div class="table-responsive border rounded-4 bg-white shadow-sm">
                        <table class="table align-middle m-0"><thead class="table-light"><tr><th class="ps-3">Icon</th><th>Title</th><th class="text-end pe-3">Action</th></tr></thead>
                        <tbody><?php if($kangDetails): foreach($kangDetails as $kd): ?>
                            <tr><td class="ps-3"><img src="../<?php echo $kd['image']; ?>" width="40" class="rounded"></td><td class="fw-bold"><?php echo $kd['title']; ?></td><td class="text-end pe-3"><a href="../api/admin/manage-kangaroo.php?action=delete&id=<?php echo $kd['id']; ?>" class="btn btn-sm btn-outline-danger border-0"><i class="fas fa-trash"></i></a></td></tr>
                        <?php endforeach; endif; ?></tbody></table>
                    </div>


                <?php elseif($type == 'math-science'): ?>


                    
                    <!-- #############################################################
                         SECTION 6: SCIENCE (About + Tutor Details)
                         ############################################################# -->
                    <?php $sciDetails = getScienceDetails(); ?>
                    <label class="fw-bold small mb-2 uppercase">About Science Description</label>
                    <textarea name="content[science_desc]" class="form-control custom-input mb-4" rows="4"><?php echo $content['science_desc'] ?? ''; ?></textarea>
                    <label class="fw-bold small mb-2 uppercase">Science Tutor Description</label>
                    <textarea name="content[science_tutor_desc]" class="form-control custom-input mb-4" rows="4"><?php echo $content['science_tutor_desc'] ?? ''; ?></textarea>
                    
                    <div class="d-flex justify-content-between align-items-center mt-5 mb-3"><h5 class="fw-bold m-0 text-primary">Science Detail Cards</h5><button type="button" class="btn btn-primary btn-sm px-4 shadow-blue" data-bs-toggle="modal" data-bs-target="#addScienceDetailModal">+ Add Detail</button></div>
                    <div class="table-responsive border rounded-4 bg-white shadow-sm">
                        <table class="table align-middle m-0"><thead class="table-light"><tr><th class="ps-4">Image</th><th>Title</th><th class="text-end pe-4">Action</th></tr></thead>
                        <tbody><?php if($sciDetails): foreach($sciDetails as $sd): ?>
                            <tr><td class="ps-4"><img src="../<?php echo $sd['image']; ?>" width="50" class="rounded"></td><td class="fw-bold"><?php echo $sd['title']; ?></td><td class="text-end pe-4"><a href="../api/admin/manage-science.php?action=delete&id=<?php echo $sd['id']; ?>" class="btn btn-sm btn-outline-danger border-0"><i class="fas fa-trash-alt"></i></a></td></tr>
                        <?php endforeach; endif; ?></tbody></table>
                    </div>


                <?php elseif($type == 'k12-management'): ?>
                    <!-- ######################################################################
                     SECTION 8: ENGLISH - COMMON ENGLISH LANGUAGE 
                     (Heading + Properties List + Image)
                     ###################################################################### -->
                <?php elseif($type == 'eng-common-lang'): ?>
                    <h5 class="fw-bold text-center text-primary mb-4 uppercase">Language Details Management</h5>
                    
                    <div class="mb-4">
                        <label class="fw-bold small mb-1">MAIN HEADING</label>
                        <input type="text" name="title" class="form-control custom-input" value="<?php echo $data['title'] ?? ''; ?>" placeholder="Enter Page Title">
                    </div>

                    <div class="mb-4">
                        <label class="fw-bold small mb-1">MAIN DESCRIPTION</label>
                        <textarea name="content[main_description]" class="form-control custom-input" rows="3"><?php echo $content['main_description'] ?? ''; ?></textarea>
                    </div>

                    <!-- Properties Section (Dynamic List) -->
                    <div class="mb-4">
                        <label class="fw-bold small mb-2 text-info">PROPERTIES (Highlights Points)</label>
                        <div id="eng-props">
                            <?php foreach(($content['properties'] ?? ['']) as $prop): ?>
                                <div class="input-group mb-2">
                                    <input type="text" name="content[properties][]" class="form-control custom-input" value="<?php echo $prop; ?>">
                                    <button type="button" class="btn btn-danger remove-row">×</button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" onclick="addSimpleRow('eng-props', 'content[properties][]')" class="btn btn-outline-info btn-sm rounded-3 mt-1">+ Add Property</button>
                    </div>

                    <!-- Image Section -->
                    <div class="mb-4 mt-5">
                        <label class="fw-bold small mb-2">PAGE IMAGE</label>
                        <label for="engImg" class="upload-box-dashed w-100">
                            <input type="file" name="image" id="engImg" hidden onchange="previewMedia(this, 'eng-prev')">
                            <div class="text-center py-3 <?php echo isset($content['image']) ? 'd-none' : ''; ?>" id="eng-prev-placeholder">
                                <i class="fas fa-image fa-2x mb-2 opacity-50"></i>
                                <p class="small m-0">Click to Upload Image</p>
                            </div>
                            <img id="eng-prev" src="../<?php echo $content['image'] ?? ''; ?>" class="img-fluid rounded-3 <?php echo !empty($content['image']) ? '' : 'd-none'; ?>" style="max-height: 200px;">
                        </label>
                    </div>


                <!-- ######################################################################
                     SECTION 9: ENGLISH - COMMON CORE ELA 
                     (Top Info + Dynamic Table with Modal)
                     ###################################################################### -->
                <?php elseif($type == 'eng-core-ela'): 
                    $engDetails = getEnglishDetails('eng-core-ela'); // functions.php se cards fetch karein
                ?>
                    <div class="p-4 bg-light rounded-4 border mb-5">
                        <h5 class="fw-bold text-center mb-4">About Core ELA Settings</h5>
                        
                        <label class="fw-bold small mb-2 uppercase">Core Description Points (Array)</label>
                        <div id="ela-desc-list">
                            <?php foreach(($content['core_descriptions'] ?? ['']) as $cd): ?>
                                <div class="input-group mb-2">
                                    <input type="text" name="content[core_descriptions][]" class="form-control custom-input" value="<?php echo $cd; ?>">
                                    <button type="button" class="btn btn-danger remove-row">×</button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" onclick="addSimpleRow('ela-desc-list', 'content[core_descriptions][]')" class="btn btn-success btn-sm rounded-3 mt-2">+ Add More Description</button>

                        <div class="mt-4">
                            <label class="fw-bold small mb-2 uppercase">Cover Description (Textarea)</label>
                            <textarea name="content[cover_description]" class="form-control custom-input" rows="4"><?php echo $content['cover_description'] ?? ''; ?></textarea>
                        </div>
                    </div>

                    <!-- Core ELA Detail List (Table) -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold m-0 text-primary">Core ELA Details (Cards)</h5>
                        <button type="button" class="btn btn-primary btn-sm px-4 shadow-blue" data-bs-toggle="modal" data-bs-target="#addEngDetailModal">
                            + Add Card Detail
                        </button>
                    </div>

                    <div class="table-responsive border rounded-4 bg-white shadow-sm">
                        <table class="table align-middle m-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Image</th>
                                    <th>Title</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($engDetails): foreach($engDetails as $ed): ?>
                                <tr>
                                    <td class="ps-4"><img src="../<?php echo $ed['image']; ?>" width="40" class="rounded"></td>
                                    <td class="fw-bold text-dark"><?php echo $ed['title']; ?></td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            <button type="button" class="btn btn-sm btn-outline-warning border-0" onclick='editEngDetail(<?php echo json_encode($ed); ?>)'><i class="fas fa-edit"></i></button>
                                            <a href="../api/admin/manage-english.php?action=delete_detail&id=<?php echo $ed['id']; ?>&type=<?php echo $type; ?>" class="btn btn-sm btn-outline-danger border-0"><i class="fas fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; else: ?>
                                <tr><td colspan="3" class="text-center py-4 text-muted small">No details added yet.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    
                    <!-- #############################################################
                         SECTION 7: K-12 MANAGEMENT (Nested Tabs)
                         ############################################################# -->
                    <ul class="nav nav-tabs border-0 custom-tabs mb-4" id="k12Tab">
                        <li class="nav-item"><button class="nav-link active fw-bold" data-bs-toggle="tab" data-bs-target="#service-pane" type="button">Service</button></li>
                        <li class="nav-item"><button class="nav-link fw-bold ms-4" data-bs-toggle="tab" data-bs-target="#methodology-pane" type="button">Methodology</button></li>
                    </ul>
                    <div class="tab-content border rounded-4 p-4 bg-white shadow-sm">
                        <div class="tab-pane fade show active" id="service-pane">
                            <input type="text" name="content[service_title]" class="form-control custom-input mb-3" placeholder="Service Title" value="<?php echo $content['service_title'] ?? ''; ?>">
                            <textarea name="content[service_description]" class="form-control custom-input mb-4" rows="3" placeholder="Description"><?php echo $content['service_description'] ?? ''; ?></textarea>
                            <label class="upload-box-dashed w-100 mb-4">
                                <input type="file" name="service_image" hidden onchange="previewMedia(this, 'service-prev')">
                                <div class="text-center py-3">Upload Service Image</div>
                                <img id="service-prev" src="../<?php echo $content['service_image'] ?? ''; ?>" class="img-fluid rounded-3 <?php echo isset($content['service_image']) ? '' : 'd-none'; ?>" style="max-height:100px;">
                            </label>
                            <!-- Nested Subjects -->
                            <div id="subject-expertise-list">
                                <?php $subjects = (isset($content['subjects']) && is_array($content['subjects'])) ? $content['subjects'] : [['title'=>'', 'points'=>['']]];
                                foreach($subjects as $idx => $sub): ?>
                                    <div class="border-top pt-4 mt-4 position-relative">
                                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 remove-row">×</button>
                                        <input type="text" name="content[subjects][<?php echo $idx; ?>][title]" class="form-control custom-input mb-3 bg-light fw-bold" placeholder="Subject Name" value="<?php echo $sub['title'] ?? ''; ?>">
                                        <div class="points-container mb-3">
                                            <?php foreach(($sub['points'] ?? ['']) as $point): ?>
                                                <div class="input-group mb-2"><input type="text" name="content[subjects][<?php echo $idx; ?>][points][]" class="form-control custom-input" value="<?php echo $point; ?>"><button type="button" class="btn btn-soft-danger remove-row">×</button></div>
                                            <?php endforeach; ?>
                                            <button type="button" onclick="addPointRow(this, <?php echo $idx; ?>)" class="btn btn-success btn-sm rounded-3 mt-1">+ Add Point</button>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" onclick="addSubjectBlock()" class="btn btn-outline-primary w-100 py-2 border-dashed mt-4">+ Add Subject Block</button>
                        </div>
                        <!-- <div class="tab-pane fade" id="methodology-pane">
                            <div id="method-list"><?php foreach(($content['methodology'] ?? ['']) as $m): ?>
                                <div class="input-group mb-2"><input type="text" name="content[methodology][]" class="form-control custom-input" value="<?php echo $m; ?>"><button type="button" class="btn btn-danger remove-row">×</button></div>
                            <?php endforeach; ?></div>
                            <button type="button" onclick="addSimpleRow('method-list', 'content[methodology][]')" class="btn btn-primary btn-sm mt-2">+ Add Point</button>
                        </div> -->

                        <!-- --- TAB 2: METHODOLOGY (Updated with List & Modal) --- -->
<div class="tab-pane fade" id="methodology-pane">
    <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
        <h5 class="fw-bold m-0">Methodology List</h5>
        <!-- Button to open Modal -->
        <button type="button" class="btn btn-primary btn-sm px-4 shadow-blue" data-bs-toggle="modal" data-bs-target="#addMethodologyModal">
            + Add New Item
        </button>
    </div>

    <!-- Methodology Table -->
    <div class="table-responsive border rounded-4 bg-white shadow-sm">
        <table class="table align-middle m-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4 border-0">#</th>
                    <th class="border-0">Icon</th>
                    <th class="border-0">Title</th>
                    <th class="border-0">Description</th>
                    <th class="border-0 text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $methods = getK12Methodology();
                if($methods): foreach($methods as $index => $m): ?>
                <tr>
                    <td class="ps-4 small text-muted"><?php echo $index + 1; ?></td>
                    <td><img src="../<?php echo $m['image']; ?>" width="45" class="rounded"></td>
                    <td class="fw-bold text-dark"><?php echo $m['title']; ?></td>
                    <td class="small text-muted"><?php echo substr($m['description'], 0, 60); ?>...</td>
                    <td class="text-end pe-4">
                        <div class="d-flex justify-content-end gap-2">
                            <button class="btn btn-sm text-primary p-1"><i class="far fa-edit"></i></button>
                            <a href="../api/admin/manage-k12.php?action=delete_method&id=<?php echo $m['id']; ?>" class="btn btn-sm text-danger p-1" onclick="return confirm('Delete this item?')">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                <tr><td colspan="5" class="text-center py-4 text-muted">No methodologies found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
                    </div>
                    <!-- ######################################################################
                     SECTION 10: ENGLISH - ABOUT ELA 
                     (Heading + Rich Text + Dynamic Question Cards)
                     ###################################################################### -->
                <?php elseif($type == 'eng-about-ela'): ?>
                    <h5 class="fw-bold text-center text-primary mb-4 uppercase">About ELA Management</h5>

                    <!-- 1. Test Prep Description -->
                    <div class="mb-4">
                        <label class="fw-bold small mb-2 text-muted">TEST PREP DESCRIPTION</label>
                        <textarea name="content[test_prep_desc]" class="form-control custom-input" rows="3" placeholder="Enter test prep description"><?php echo $content['test_prep_desc'] ?? ''; ?></textarea>
                    </div>

                    <!-- 2. Description -->
                    <div class="mb-4">
                        <label class="fw-bold small mb-2 text-muted">DESCRIPTION</label>
                        <textarea name="content[description]" class="form-control custom-input" rows="3" placeholder="Enter description"><?php echo $content['description'] ?? ''; ?></textarea>
                    </div>

                    <!-- 3. Heading -->
                    <div class="mb-4">
                        <label class="fw-bold small mb-2 text-muted">HEADING</label>
                        <input type="text" name="content[heading]" class="form-control custom-input" value="<?php echo $content['heading'] ?? ''; ?>" placeholder="Enter heading">
                    </div>

                    <!-- 4. Who Take (Rich Text Editor) -->
                    <div class="mb-4">
                        <label class="fw-bold small mb-2 text-muted uppercase">Who Take (Rich Content)</label>
                        <textarea name="content[who_take]" class="amc-editor"><?php echo $content['who_take'] ?? ''; ?></textarea>
                    </div>

                    <hr class="my-5">

                    <!-- 5. Question Types (Dynamic List) -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold m-0 text-dark">Question Types</h5>
                    </div>

                    <div id="question-types-container">
                        <?php
                        // Mapping logic for existing data
                        $qTypes = [];
                        if (isset($content['question_types']['title'])) {
                            foreach ($content['question_types']['title'] as $i => $title) {
                                $qTypes[] = ['title' => $title, 'desc' => $content['question_types']['desc'][$i]];
                            }
                        } else {
                            $qTypes = [['title' => '', 'desc' => '']]; // Default row
                        }

                        foreach($qTypes as $idx => $q):
                        ?>
                        <div class="p-4 border rounded-4 mb-4 bg-white shadow-sm position-relative question-card">
                            <button type="button" class="btn btn-link text-danger position-absolute top-0 end-0 m-2 remove-row text-decoration-none">Remove</button>
                            <div class="mb-2">
                                <label class="small fw-bold text-muted">Question <?php echo $idx + 1; ?></label>
                                <input type="text" name="content[question_types][title][]" class="form-control custom-input mb-3" placeholder="Question types" value="<?php echo $q['title']; ?>">
                                <textarea name="content[question_types][desc][]" class="form-control custom-input" rows="3" placeholder="Tests feature a mix..."><?php echo $q['desc']; ?></textarea>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <button type="button" onclick="addQuestionType()" class="btn btn-link text-decoration-none fw-bold p-0 small">
                        + Add Question Type
                    </button>
                    <!-- ######################################################################
                     SECTION 11: ENGLISH - ABOUT ISEE TEST 
                     (Dynamic Titles + Dynamic Purpose + Test Structure Cards)
                     ###################################################################### -->
                <?php elseif($type == 'eng-about-isee'): ?>
                    <h5 class="fw-bold text-center text-primary mb-5 uppercase">About ISEE Management</h5>

                    <!-- 1. Dynamic Titles Section -->
                    <div class="mb-5">
                        <label class="fw-bold small mb-2 text-dark">TITLE</label>
                        <div id="isee-titles">
                            <?php foreach(($content['titles'] ?? ['']) as $t): ?>
                                <div class="input-group mb-2">
                                    <input type="text" name="content[titles][]" class="form-control custom-input" value="<?php echo $t; ?>" placeholder="Enter title...">
                                    <button type="button" class="btn btn-danger remove-row"><i class="fas fa-times"></i></button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" onclick="addSimpleRow('isee-titles', 'content[titles][]')" class="btn btn-link text-decoration-none fw-bold p-0 small">+ Add More Title</button>
                    </div>

                    <!-- 2. Dynamic Purpose Section -->
                    <div class="mb-5">
                        <label class="fw-bold small mb-2 text-dark">PURPOSE</label>
                        <div id="isee-purposes">
                            <?php foreach(($content['purposes'] ?? ['']) as $p): ?>
                                <div class="input-group mb-2">
                                    <input type="text" name="content[purposes][]" class="form-control custom-input" value="<?php echo $p; ?>" placeholder="Enter purpose...">
                                    <button type="button" class="btn btn-danger remove-row"><i class="fas fa-times"></i></button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" onclick="addSimpleRow('isee-purposes', 'content[purposes][]')" class="btn btn-link text-decoration-none fw-bold p-0 small">+ Add More Purpose</button>
                    </div>

                    <!-- 3. Test Structure Cards Section -->
                    <div class="mb-4">
                        <label class="fw-bold small mb-3 text-dark">TEST STRUCTURE</label>
                        <div id="isee-structures">
                            <?php 
                            $structures = $content['test_structures'] ?? [['heading' => '', 'desc' => '']];
                            foreach($structures as $s): ?>
                                <div class="p-4 border rounded-4 mb-4 bg-white shadow-sm position-relative isee-card">
                                    <button type="button" class="btn btn-link text-danger position-absolute top-0 end-0 m-2 remove-row text-decoration-none">×</button>
                                    <div class="mb-3">
                                        <input type="text" name="content[test_structures][heading][]" class="form-control custom-input mb-3" placeholder="Heading" value="<?php echo $s['heading'] ?? ''; ?>">
                                        <textarea name="content[test_structures][desc][]" class="form-control custom-input" rows="3" placeholder="Description"><?php echo $s['desc'] ?? ''; ?></textarea>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" onclick="addIseeStructure()" class="btn btn-link text-decoration-none fw-bold p-0 small">+ Add Test Structure</button>
                    </div>
                    <!-- ######################################################################
                     SECTION 12: ENGLISH - REGISTRATION 
                     (Top Info + Multiple Rich Text Sections)
                     ###################################################################### -->
                <?php elseif($type == 'eng-registration'): ?>
                    <h5 class="fw-bold text-center text-primary mb-5 uppercase">Registration Management</h5>

                    <!-- 1. Top Registration Info Box -->
                    <div class="p-4 bg-light rounded-4 border mb-5 shadow-sm">
                        <label class="fw-bold small mb-2 text-muted">REGISTRATION DETAILS HEADING</label>
                        <input type="text" name="title" class="form-control custom-input mb-4 fw-bold" value="<?php echo $data['title'] ?? 'REGISTRATION DETAILS'; ?>">

                        <label class="fw-bold small mb-2 text-muted">MAIN REGISTRATION DESCRIPTION</label>
                        <textarea name="content[main_description]" class="form-control custom-input mb-3" rows="5"><?php echo $content['main_description'] ?? ''; ?></textarea>
                        
                        <button type="submit" class="btn btn-primary w-100 fw-bold py-2">Save Registration Info</button>
                    </div>

                    <hr class="my-5">

                    <!-- 2. Dynamic Registration Blocks -->
                    <div id="reg-blocks-container">
                        <?php 
                        $regItems = $content['reg_items'] ?? [['rich' => '', 'plain' => '']];
                        foreach($regItems as $idx => $item): ?>
                        <div class="p-4 border rounded-4 mb-5 bg-white shadow-sm position-relative reg-item-card">
                            <button type="button" class="btn btn-link text-danger position-absolute top-0 end-0 m-2 remove-row text-decoration-none small">× Remove Section</button>
                            
                            <div class="mb-4">
                                <label class="small fw-bold text-muted mb-2">Section Content (Rich Text)</label>
                                <textarea name="content[reg_items][rich][]" class="amc-editor"><?php echo $item['rich'] ?? ''; ?></textarea>
                            </div>

                            <div class="mb-2">
                                <label class="small fw-bold text-muted mb-2">Footer Note (Plain Text)</label>
                                <textarea name="content[reg_items][plain][]" class="form-control custom-input" rows="3" placeholder="e.g. Vocabulary and verbal skills..."><?php echo $item['plain'] ?? ''; ?></textarea>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <button type="button" onclick="addRegistrationBlock()" class="btn btn-outline-primary w-100 py-3 border-dashed fw-bold">
                        <i class="fas fa-plus me-2"></i> Add New Registration Section
                    </button>
                    
                <?php endif; ?>
                

                <!-- 🔵 COMMON: FINAL SAVE BUTTON -->
                <div class="mt-5 border-top pt-5">
                    <button type="submit" class="btn btn-primary btn-lg w-100 rounded-3 fw-bold shadow-blue py-3">
                        <i class="fas fa-save me-2"></i> Save All Page Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- --- MODALS --- -->
<div class="modal fade" id="addScienceDetailModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered"><div class="modal-content border-0 rounded-4 shadow-lg"><div class="modal-header border-0 pe-4 pt-4"><h5 class="fw-bold">Add Detail</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><form action="../api/admin/manage-science.php?action=add_detail" method="POST" enctype="multipart/form-data"><div class="modal-body p-4"><input type="text" name="title" class="form-control custom-input mb-3" placeholder="Title" required><input type="text" name="heading" class="form-control custom-input mb-3" placeholder="Heading" required><textarea name="description" class="form-control custom-input mb-3" rows="4" placeholder="Description" required></textarea><input type="file" name="image" class="form-control custom-input mb-4" required><button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-bold shadow-blue">Save</button></div></form></div></div>
</div>
<div class="modal fade" id="addKangarooCardModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered"><div class="modal-content border-0 rounded-4 shadow-lg"><div class="modal-header border-0 pe-4 pt-4"><h5 class="fw-bold">Add Detail</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><form action="../api/admin/manage-kangaroo.php?action=add_card" method="POST" enctype="multipart/form-data"><div class="modal-body p-4"><input type="text" name="title" class="form-control custom-input mb-3" placeholder="Title" required><div id="modal-desc-list"><textarea name="descriptions[]" class="form-control custom-input mb-2" rows="2" placeholder="Detail Point" required></textarea></div><button type="button" onclick="addModalDesc()" class="btn btn-link text-decoration-none small p-0 mb-3">+ Add Point</button><input type="file" name="image" class="form-control custom-input mb-4" required><button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-bold shadow-blue">Save Card</button></div></form></div></div>
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
    const div = document.createElement('div'); div.className = 'input-group mb-3';
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
    div.innerHTML = `<button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 remove-row">×</button><div class="mb-3"><label class="small fw-bold">NAME</label><input type="text" name="content[chapters][name][]" class="form-control mb-2 custom-input"></div><div><label class="small fw-bold">DESC</label><textarea name="content[chapters][desc][]" class="form-control custom-input" rows="3"></textarea></div>`;
    container.appendChild(div);
}
function addAmcCard() {
    const container = document.getElementById('amc-cards-container');
    const div = document.createElement('div'); div.className = 'p-4 border rounded-4 mb-4 bg-white shadow-sm position-relative';
    div.innerHTML = `<button type="button" class="btn btn-sm btn-link text-danger position-absolute top-0 end-0 m-2 remove-row text-decoration-none">Remove</button><input type="text" name="content[competitions][name][]" class="form-control mb-3 fw-bold custom-input" placeholder="AMC Name"><textarea name="content[competitions][desc_rich][]" class="amc-editor mb-3"></textarea><textarea name="content[competitions][desc_plain][]" class="form-control custom-input mb-3" rows="2" placeholder="Description"></textarea><div class="row"><div class="col-md-6"><input type="text" name="content[competitions][for][]" class="form-control custom-input" placeholder="For"></div><div class="col-md-6"><input type="text" name="content[competitions][when][]" class="form-control custom-input" placeholder="When"></div></div>`;
    container.appendChild(div); initEditors();
}
let subjectCounter = <?php echo isset($subjects) ? count($subjects) : 1; ?>;
function addSubjectBlock() {
    const container = document.getElementById('subject-expertise-list');
    const div = document.createElement('div'); div.className = 'border-top pt-4 mt-4 position-relative';
    div.innerHTML = `<button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 remove-row">×</button><input type="text" name="content[subjects][${subjectCounter}][title]" class="form-control custom-input mb-3 bg-light fw-bold" placeholder="Subject Name"><div class="points-container mb-3"><button type="button" onclick="addPointRow(this, ${subjectCounter})" class="btn btn-success btn-sm mt-1">+ Add Point</button></div><label class="upload-box-dashed w-100 bg-white"><input type="file" name="subject_image_${subjectCounter}" hidden><div class="text-center py-2"><p class="small m-0">Upload Subject Image</p></div></label>`;
    container.appendChild(div); subjectCounter++;
}
function addPointRow(btn, subjectIdx) {
    const div = document.createElement('div'); div.className = 'input-group mb-2';
    div.innerHTML = `<input type="text" name="content[subjects][${subjectIdx}][points][]" class="form-control custom-input"><button type="button" class="btn btn-soft-danger remove-row">×</button>`;
    btn.parentNode.insertBefore(div, btn);
}
function addModalDesc() {
    const div = document.createElement('div'); div.innerHTML = `<textarea name="descriptions[]" class="form-control custom-input mb-2" rows="2" placeholder="Detail Point"></textarea>`;
    document.getElementById('modal-desc-list').appendChild(div);
}
function previewMedia(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader(); reader.onload = e => { preview.src = e.target.result; preview.classList.remove('d-none'); }
        reader.readAsDataURL(input.files[0]);
    }
}
document.addEventListener('click', e => { if(e.target.classList.contains('remove-row')) e.target.closest('.input-group, .border, .p-4, .subject-item, .subject-card-item, .subject-item').remove(); });
document.addEventListener('DOMContentLoaded', initEditors);
</script>

<style>
.custom-input { border: 1px solid #e0e6ed; border-radius: 12px; padding: 12px 15px; }
.border-dashed { border: 2px dashed #305CDE; border-radius: 10px; background: #fcfdff; cursor: pointer; transition: 0.3s; }
.shadow-blue { box-shadow: 0 10px 20px rgba(48, 92, 222, 0.15) !important; }
.uppercase { text-transform: uppercase; letter-spacing: 1px; }
.btn-soft-danger { background: #fff1f2; color: #e11d48; border: none; font-size: 18px; padding: 5px; }
</style>


<!-- --- MODAL FOR K-12 METHODOLOGY (Screenshot Exact Match) --- -->
<div class="modal fade" id="addMethodologyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header border-0 pb-0 pe-4 pt-4">
                <h5 class="modal-title fw-bold">Add New Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="../api/admin/manage-k12.php?action=add_method" method="POST" enctype="multipart/form-data">
                <div class="modal-body p-4">
                    
                    <!-- Dashed Upload Box -->
                    <div class="mb-3">
                        <label for="methImg" class="upload-box-dashed w-100">
                            <input type="file" name="image" id="methImg" hidden onchange="previewMethodImg(this)" required>
                            <div class="text-center py-3" id="methPlaceholder">
                                <i class="fas fa-cloud-upload-alt text-primary fa-2x mb-2"></i>
                                <p class="small fw-bold text-dark m-0">Click to Upload Image</p>
                            </div>
                            <img id="methPreview" class="d-none w-100 h-100 object-fit-contain p-2">
                        </label>
                    </div>

                    <input type="text" name="title" class="form-control custom-input mb-3" placeholder="Enter title..." required>
                    
                    <textarea name="description" class="form-control custom-input mb-1" rows="4" placeholder="Enter description..." onkeyup="countMethWords(this)" required></textarea>
                    <div class="text-end mb-4">
                        <small class="text-muted" style="font-size: 11px;">Word Count: <span id="methWordCount">0</span> / 250</small>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-bold shadow-blue">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewMethodImg(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('methPreview').src = e.target.result;
            document.getElementById('methPreview').classList.remove('d-none');
            document.getElementById('methPlaceholder').classList.add('d-none');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
function countMethWords(obj) {
    document.getElementById('methWordCount').innerText = obj.value.length;
}
</script>
<!-- Modal for English Details -->
<div class="modal fade" id="addEngDetailModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header border-0 pe-4 pt-4"><h5 class="fw-bold" id="engModalTitle">Add Detail</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form action="../api/admin/manage-english.php?action=save_detail" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" id="engDetailId">
                <input type="hidden" name="category_slug" value="<?php echo $type; ?>">
                <div class="modal-body p-4">
                    <label class="small fw-bold">Title</label>
                    <input type="text" name="title" id="engDetailTitle" class="form-control custom-input mb-3" required>
                    <label class="small fw-bold">Image</label>
                    <input type="file" name="image" id="engDetailImg" class="form-control custom-input mb-4">
                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-bold shadow-blue">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editEngDetail(data) {
    document.getElementById('engModalTitle').innerText = "Edit Detail";
    document.getElementById('engDetailId').value = data.id;
    document.getElementById('engDetailTitle').value = data.title;
    document.getElementById('engDetailImg').required = false;
    new bootstrap.Modal(document.getElementById('addEngDetailModal')).show();
}
function addQuestionType() {
    const container = document.getElementById('question-types-container');
    const count = container.children.length + 1;
    const div = document.createElement('div');
    div.className = 'p-4 border rounded-4 mb-4 bg-white shadow-sm position-relative question-card';
    div.innerHTML = `
        <button type="button" class="btn btn-link text-danger position-absolute top-0 end-0 m-2 remove-row text-decoration-none">Remove</button>
        <div class="mb-2">
            <label class="small fw-bold text-muted">Question ${count}</label>
            <input type="text" name="content[question_types][title][]" class="form-control custom-input mb-3" placeholder="Question types">
            <textarea name="content[question_types][desc][]" class="form-control custom-input" rows="3" placeholder="Tests feature a mix..."></textarea>
        </div>
    `;
    container.appendChild(div);
}

function addIseeStructure() {
    const container = document.getElementById('isee-structures');
    const div = document.createElement('div');
    div.className = 'p-4 border rounded-4 mb-4 bg-white shadow-sm position-relative isee-card';
    div.innerHTML = `
        <button type="button" class="btn btn-link text-danger position-absolute top-0 end-0 m-2 remove-row text-decoration-none">×</button>
        <div class="mb-3">
            <input type="text" name="content[test_structures][heading][]" class="form-control custom-input mb-3" placeholder="Heading">
            <textarea name="content[test_structures][desc][]" class="form-control custom-input" rows="3" placeholder="Description"></textarea>
        </div>
    `;
    container.appendChild(div);
}

function addRegistrationBlock() {
    const container = document.getElementById('reg-blocks-container');
    const div = document.createElement('div');
    div.className = 'p-4 border rounded-4 mb-5 bg-white shadow-sm position-relative reg-item-card';
    div.innerHTML = `
        <button type="button" class="btn btn-link text-danger position-absolute top-0 end-0 m-2 remove-row text-decoration-none small">× Remove Section</button>
        <div class="mb-4">
            <label class="small fw-bold text-muted mb-2">Section Content (Rich Text)</label>
            <textarea name="content[reg_items][rich][]" class="amc-editor"></textarea>
        </div>
        <div class="mb-2">
            <label class="small fw-bold text-muted mb-2">Footer Note (Plain Text)</label>
            <textarea name="content[reg_items][plain][]" class="form-control custom-input" rows="3" placeholder="Footer text..."></textarea>
        </div>
    `;
    container.appendChild(div);
    initEditors(); // Re-initialize CKEditor for the new textarea
}
</script>


<?php include('includes/footer.php'); ?>