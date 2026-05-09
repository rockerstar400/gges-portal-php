<?php 
require_once '../functions.php';
include 'includes/header.php';
include 'includes/sidebar.php';

$slug = $_GET['type'] ?? 'sat'; 
$data = getTestPrepData($slug); 
?>

<div class="main-content p-4">
    <div class="container-fluid bg-white p-4 shadow-sm rounded">
        <h3 class="mb-4 text-primary border-bottom pb-2">Admin: Manage <?php echo strtoupper($slug); ?> Page</h3>

        <form action="../api/admin/save-test-prep.php" method="POST">
            <input type="hidden" name="slug" value="<?php echo $slug; ?>">

            <?php if ($slug == 'sat'): ?>
                <!-- ==========================================================================
                     PAGE: SAT (Section 1 to 3)
                =========================================================================== -->
                <div class="card mb-4 border-primary shadow-sm">
                    <div class="card-header bg-light fw-bold text-primary">1. Hero Section</div>
                    <div class="card-body">
                        <input type="text" name="hero[title]" value="<?= $data['hero']['title'] ?? '' ?>" class="form-control mb-2" placeholder="SAT TEST PREP">
                        <input type="text" name="hero[subtitle]" value="<?= $data['hero']['subtitle'] ?? '' ?>" class="form-control mb-2" placeholder="Subtitle">
                        <textarea name="hero[description]" class="form-control" rows="3"><?= $data['hero']['description'] ?? '' ?></textarea>
                    </div>
                </div>

                <div class="card mb-4 border-success shadow-sm">
                    <div class="card-header bg-light fw-bold text-success">2. Why Choose Us (Features)</div>
                    <div class="card-body">
                        <div id="sat-feature-container">
                            <?php foreach($data['features'] ?? [''] as $f): ?>
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-white text-success"><i class="fas fa-check-square"></i></span>
                                <input type="text" name="features[]" value="<?= $f ?>" class="form-control">
                                <button type="button" class="btn btn-outline-danger remove-btn">x</button>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" onclick="addFeature('sat-feature-container')" class="btn btn-sm btn-link text-decoration-none">+ Add Feature Point</button>
                    </div>
                </div>

                <div class="card mb-4 border-info shadow-sm">
                    <div class="card-header bg-light fw-bold text-info">3. All About & Table</div>
                    <div class="card-body">
                        <input type="text" name="about[heading]" value="<?= $data['about']['heading'] ?? '' ?>" class="form-control mb-2" placeholder="Heading">
                        <textarea name="about[description]" class="form-control mb-3" rows="3"><?= $data['about']['description'] ?? '' ?></textarea>
                        <div id="sat-table-container">
                            <?php foreach($data['table_data'] ?? [['name'=>'','time'=>'','modules'=>'']] as $row): ?>
                            <div class="row g-2 mb-2 table-data-row">
                                <div class="col-4"><input type="text" name="table_name[]" value="<?= $row['name'] ?>" class="form-control" placeholder="Section"></div>
                                <div class="col-3"><input type="text" name="table_time[]" value="<?= $row['time'] ?>" class="form-control" placeholder="Time"></div>
                                <div class="col-4"><input type="text" name="table_modules[]" value="<?= $row['modules'] ?>" class="form-control" placeholder="Modules"></div>
                                <div class="col-1 text-end"><button type="button" class="btn btn-danger remove-btn">x</button></div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" onclick="addSatRow('sat-table-container')" class="btn btn-sm btn-secondary w-100 mt-2">+ Add Table Row</button>
                    </div>
                </div>

            <?php elseif ($slug == 'ssat'): ?>
                <!-- ==========================================================================
                     PAGE: SSAT (Section 1 to 9)
                =========================================================================== -->
                <div class="card mb-4 border-primary shadow-sm">
                    <div class="card-header bg-primary text-white fw-bold">1. Hero Section</div>
                    <div class="card-body">
                        <input type="text" name="hero[title]" value="<?= $data['hero']['title'] ?? '' ?>" class="form-control mb-2" placeholder="Title">
                        <textarea name="hero[intro]" class="form-control mb-2" rows="3"><?= $data['hero']['intro'] ?? '' ?></textarea>
                        <input type="text" name="hero[cta]" value="<?= $data['hero']['cta'] ?? '' ?>" class="form-control" placeholder="CTA">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-4 border-secondary shadow-sm h-100">
                            <div class="card-header fw-bold">2. About Section</div>
                            <div class="card-body">
                                <input type="text" name="about[heading]" value="<?= $data['about']['heading'] ?? '' ?>" class="form-control mb-2">
                                <textarea name="about[content]" class="form-control" rows="5"><?= $data['about']['content'] ?? '' ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-4 border-info shadow-sm h-100">
                            <div class="card-header fw-bold d-flex justify-content-between">
                                3. Levels <button type="button" class="btn btn-sm btn-info text-white" onclick="addLevel()">+ Add Box</button>
                            </div>
                            <div class="card-body" id="level-container">
                                <?php foreach($data['levels'] ?? [] as $lv): ?>
                                <div class="row mb-2 border p-2 rounded">
                                    <div class="col-11">
                                        <input type="text" name="levels[title][]" value="<?= $lv['title'] ?>" class="form-control mb-1">
                                        <textarea name="levels[desc][]" class="form-control small" rows="2"><?= $lv['desc'] ?></textarea>
                                    </div>
                                    <div class="col-1"><button type="button" class="btn btn-danger btn-sm remove-btn">x</button></div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4 border-warning shadow-sm">
                    <div class="card-header fw-bold">5. Comparison</div>
                    <div class="card-body">
                        <input type="text" name="comp[title]" value="<?= $data['comparison']['title'] ?? '' ?>" class="form-control mb-2 fw-bold" placeholder="Difference Title">
                        <textarea name="comp[intro]" class="form-control mb-2" rows="2"><?= $data['comparison']['intro'] ?? '' ?></textarea>
                        <div id="comp-points">
                            <?php foreach($data['comparison']['points'] ?? [] as $pt): ?>
                            <div class="input-group mb-2"><span class="input-group-text">•</span><input type="text" name="comp[points][]" value="<?= $pt ?>" class="form-control"><button type="button" class="btn btn-outline-danger remove-btn">x</button></div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="btn btn-link btn-sm" onclick="addCompPoint()">+ Add Point</button>
                    </div>
                </div>

                <div class="card mb-4 shadow-sm" style="border-color: #A855F7;">
                    <div class="card-header text-white fw-bold d-flex justify-content-between align-items-center" style="background-color: #A855F7;">
                        6. Scoring Cards <button type="button" class="btn btn-sm btn-light" onclick="addScoreCard()">+ Add Card</button>
                    </div>
                    <div class="card-body"><div class="row g-3" id="score-card-container">
                        <?php foreach($data['scoring']['cards'] ?? [] as $sc): ?>
                        <div class="col-md-4"><div class="border p-2 rounded position-relative bg-white"><button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 remove-btn">x</button><input type="text" name="scoring[c_title][]" value="<?= $sc['title'] ?>" class="form-control fw-bold mb-1 small"><textarea name="scoring[c_content][]" class="form-control small" rows="3"><?= $sc['content'] ?></textarea></div></div>
                        <?php endforeach; ?>
                    </div></div>
                </div>

            <?php elseif ($slug == 'psat'): ?>
                <!-- ==========================================================================
                     PAGE: PSAT (Section 1 to 4)
                =========================================================================== -->
                <div class="card mb-4 border-primary shadow-sm">
                    <div class="card-header bg-light fw-bold text-primary">1. Hero Section</div>
                    <div class="card-body">
                        <input type="text" name="hero[title]" value="<?= $data['hero']['title'] ?? '' ?>" class="form-control mb-2" placeholder="PSAT TEST PREP">
                        <input type="text" name="hero[subtitle]" value="<?= $data['hero']['subtitle'] ?? '' ?>" class="form-control mb-2" placeholder="Subtitle">
                        <textarea name="hero[description]" class="form-control" rows="3"><?= $data['hero']['description'] ?? '' ?></textarea>
                    </div>
                </div>

                <div class="card mb-4 border-dark shadow-sm">
                    <div class="card-header bg-light fw-bold text-dark">4. Exam Period</div>
                    <div class="card-body">
                        <div id="exam-period-container">
                            <?php 
                            $examRows = json_decode($data['exam_period_json'] ?? '[]', true) ?: [['name'=>'','time'=>'','modules'=>'']];
                            foreach($examRows as $ex): 
                            ?>
                            <div class="row g-2 mb-2 table-data-row">
                                <div class="col-4"><input type="text" name="exam_name[]" value="<?= $ex['name'] ?>" class="form-control border-danger"></div>
                                <div class="col-3"><input type="text" name="exam_time[]" value="<?= $ex['time'] ?>" class="form-control border-danger"></div>
                                <div class="col-4"><input type="text" name="exam_modules[]" value="<?= $ex['modules'] ?>" class="form-control border-danger"></div>
                                <div class="col-1 text-end"><button type="button" class="btn btn-danger remove-btn">x</button></div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" onclick="addExamRow()" class="btn btn-sm btn-outline-dark w-100 mt-2">+ Add Exam Period Row</button>
                    </div>
                </div>

            <?php elseif ($slug == 'shsat'): ?>
                <!-- ==========================================================================
                     PAGE: SHSAT (Section 1 to 3)
                =========================================================================== -->
                <div class="card mb-4 border-primary shadow-sm">
                    <div class="card-header bg-primary text-white fw-bold">1. Top Section</div>
                    <div class="card-body">
                        <input type="text" name="hero[title]" value="<?= $data['hero']['title'] ?? '' ?>" class="form-control mb-2" placeholder="Page Title">
                        <textarea name="hero[description]" class="form-control" rows="4"><?= $data['hero']['description'] ?? '' ?></textarea>
                    </div>
                </div>

                <div class="card mb-4 border-info shadow-sm">
                    <div class="card-header bg-info text-white fw-bold d-flex justify-content-between align-items-center">
                        2. All About SHSAT <button type="button" class="btn btn-sm btn-light" onclick="addShsatAboutItem()">+ Add Block</button>
                    </div>
                    <div class="card-body bg-light" id="shsat-about-container">
                        <?php 
                        $aboutItems = $data['about']['items'] ?? []; 
                        foreach($aboutItems as $item): 
                        ?>
                        <div class="border rounded p-3 mb-3 bg-white position-relative shadow-sm border-start border-info border-4">
                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 remove-btn">x</button>
                            <input type="text" name="shsat_about_title[]" value="<?= $item['title'] ?>" class="form-control mb-2 fw-bold" placeholder="Heading">
                            <textarea name="shsat_about_content[]" class="form-control" rows="4"><?= $item['content'] ?></textarea>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="card mb-4 border-dark shadow-sm">
                    <div class="card-header bg-dark text-white fw-bold">3. Test Structure</div>
                    <div class="card-body">
                        <input type="text" name="struct[title]" value="<?= $data['structure']['title'] ?? '' ?>" class="form-control mb-3 fw-bold">
                        <div id="shsat-bullet-container">
                            <?php foreach($data['structure']['bullets'] ?? [''] as $b): ?>
                            <div class="input-group mb-2 shadow-sm">
                                <span class="input-group-text bg-white">•</span>
                                <input type="text" name="struct_bullets[]" value="<?= $b ?>" class="form-control">
                                <button type="button" class="btn btn-outline-danger remove-btn">x</button>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="btn btn-link btn-sm p-0" onclick="addShsatBullet()">+ Add Bullet Point</button>
                    </div>
                </div>
                <?php elseif ($slug == 'isee'): ?>
                <!-- ==========================================================================
                     PAGE: ISEE TEST ADMIN PANEL
                =========================================================================== -->

                <!-- === HERO SECTION === -->
                <div class="card mb-4 border-primary shadow-sm">
                    <div class="card-header bg-primary text-white fw-bold">Hero Section</div>
                    <div class="card-body">
                        <input type="text" name="hero[title]" value="<?= $data['hero']['title'] ?? '' ?>" class="form-control mb-2" placeholder="Hero Title">
                        <textarea name="hero[description]" class="form-control" rows="3" placeholder="Hero Description"><?= $data['hero']['description'] ?? '' ?></textarea>
                    </div>
                </div>

                <!-- === ABOUT SECTION === -->
                <div class="card mb-4 border-secondary shadow-sm">
                    <div class="card-header bg-light fw-bold text-secondary">About Section</div>
                    <div class="card-body">
                        <input type="text" name="about[heading]" value="<?= $data['about']['heading'] ?? '' ?>" class="form-control mb-2" placeholder="About Heading">
                        <textarea name="about[description]" class="form-control" rows="4" placeholder="About Description"><?= $data['about']['description'] ?? '' ?></textarea>
                    </div>
                </div>

                <!-- === PURPOSE SECTION (Repeater) === -->
                <div class="card mb-4 border-warning shadow-sm">
                    <div class="card-header bg-warning-subtle fw-bold d-flex justify-content-between align-items-center">
                        Purpose
                        <button type="button" class="btn btn-sm btn-warning" onclick="addIseePurpose()">+ Add Purpose Point</button>
                    </div>
                    <div class="card-body">
                        <input type="text" name="isee_purpose_title" value="<?= $data['isee_purpose_title'] ?? '' ?>" class="form-control mb-3" placeholder="Purpose Title (e.g. Purpose of the ISEE)">
                        <div id="isee-purpose-container">
                            <?php 
                            $purposes = json_decode($data['isee_purpose_json'] ?? '[]', true);
                            foreach($purposes as $p): 
                            ?>
                            <div class="input-group mb-2 shadow-sm">
                                <input type="text" name="isee_purpose[]" value="<?= $p ?>" class="form-control">
                                <button type="button" class="btn btn-outline-danger remove-btn">x</button>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- === TEST STRUCTURE & LEVELS (Repeater) === -->
                <div class="card mb-4 border-info shadow-sm">
                    <div class="card-header bg-info text-white fw-bold d-flex justify-content-between align-items-center">
                        Test Structure & Levels
                        <button type="button" class="btn btn-sm btn-light" onclick="addIseeStruct()">+ Add Structure Item</button>
                    </div>
                    <div class="card-body">
                        <input type="text" name="isee_struct_title" value="<?= $data['isee_struct_title'] ?? '' ?>" class="form-control mb-3" placeholder="Section Heading">
                        <div id="isee-struct-container">
                            <?php 
                            $structs = json_decode($data['isee_struct_json'] ?? '[]', true);
                            foreach($structs as $s): 
                            ?>
                            <div class="border rounded p-3 mb-2 bg-light position-relative">
                                <button type="button" class="btn btn-sm btn-link text-danger position-absolute top-0 end-0 m-1 remove-btn">Remove</button>
                                <input type="text" name="isee_struct_name[]" value="<?= $s['name'] ?>" class="form-control mb-2 fw-bold" placeholder="Level Name (e.g. Four levels:)">
                                <textarea name="isee_struct_desc[]" class="form-control small" rows="2"><?= $s['desc'] ?></textarea>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- === WHAT SECTIONS MEASURE (Repeater) === -->
                <div class="card mb-4 shadow-sm" style="border-color: #10B981;">
                    <div class="card-header text-white fw-bold d-flex justify-content-between align-items-center" style="background-color: #10B981;">
                        What Sections Measure
                        <button type="button" class="btn btn-sm btn-light" onclick="addIseeMeasure()">+ Add Measure Item</button>
                    </div>
                    <div class="card-body">
                        <input type="text" name="isee_measure_title" value="<?= $data['isee_measure_title'] ?? '' ?>" class="form-control mb-3" placeholder="Measure Heading">
                        <div id="isee-measure-container">
                            <?php 
                            $measures = json_decode($data['isee_measure_json'] ?? '[]', true);
                            foreach($measures as $m): 
                            ?>
                            <div class="border rounded p-3 mb-2 bg-white border-start border-success border-4 shadow-sm position-relative">
                                <button type="button" class="btn btn-sm btn-link text-danger position-absolute top-0 end-0 m-1 remove-btn">Remove</button>
                                <textarea name="isee_measure_item[]" class="form-control mb-2 fw-bold" rows="2" placeholder="Measure Item (Title/Link)"><?= $m['item'] ?></textarea>
                                <textarea name="isee_measure_desc[]" class="form-control small" rows="2" placeholder="Description"><?= $m['desc'] ?></textarea>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- === REGISTRATION SECTION === -->
                <div class="card mb-4 border-dark shadow-sm">
                    <div class="card-header bg-dark text-white fw-bold">Registration</div>
                    <div class="card-body">
                        <input type="text" name="isee_reg_title" value="<?= $data['isee_reg_title'] ?? '' ?>" class="form-control mb-2" placeholder="Registration Heading">
                        <textarea name="isee_reg_desc" class="form-control" rows="4" placeholder="Registration Description"><?= $data['isee_reg_desc'] ?? '' ?></textarea>
                    </div>
                </div>


<?php elseif ($slug == 'ela'): ?>
<!-- ==========================================================================
     PAGE: ELA TEST ADMIN (REPLICATING REACT DESIGN)
=========================================================================== -->

<!-- Quill Editor CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<div class="card mb-4 border-0 shadow-sm">
    <div class="card-body p-4">
        <h1 class="h3 fw-bold mb-4">ELA Test Admin</h1>

        <!-- 1. Hero Section -->
        <div class="mb-5">
            <h5 class="fw-semibold mb-3">Hero Section</h5>
            <input type="text" name="ela_hero_title" value="<?= $data['ela_hero_title'] ?? '' ?>" placeholder="Hero Title" class="form-control mb-3 shadow-sm">
            <textarea name="ela_hero_desc" placeholder="Hero Description" rows="3" class="form-control shadow-sm"><?= $data['ela_hero_desc'] ?? '' ?></textarea>
        </div>

        <!-- 2. Intro Section -->
        <div class="mb-5">
            <h5 class="fw-semibold mb-3">Intro Section</h5>
            <input type="text" name="ela_intro_heading" value="<?= $data['ela_intro_heading'] ?? '' ?>" placeholder="Intro Heading" class="form-control mb-3 shadow-sm">
            
            <!-- React Quill Replacement -->
            <div id="quill-editor" style="height: 200px;" class="bg-white rounded shadow-sm"><?= $data['ela_intro_desc'] ?? '' ?></div>
            <input type="hidden" name="ela_intro_desc" id="ela_intro_desc_input">
        </div>

        <!-- 3. Administration Section -->
        <div class="mb-5">
            <h5 class="fw-semibold mb-3">Administration Section</h5>
            <input type="text" name="ela_admin_heading" value="<?= $data['ela_admin_heading'] ?? '' ?>" placeholder="Administration Heading" class="form-control mb-4 shadow-sm">

            <div id="ela-admin-points-container">
                <?php 
                $adminPoints = json_decode($data['ela_admin_points_json'] ?? '[]', true);
                foreach($adminPoints as $idx => $item): 
                ?>
                <div class="admin-point-block border rounded p-4 mb-3 bg-light position-relative shadow-sm">
                    <button type="button" class="btn btn-sm btn-link text-danger position-absolute top-0 end-0 m-2 remove-btn" style="text-decoration:none;">Remove</button>
                    <input type="text" name="admin_pt_title[]" value="<?= $item['title'] ?>" placeholder="Title" class="form-control mb-3 fw-bold border-0">
                    <textarea name="admin_pt_desc[]" placeholder="Description" rows="2" class="form-control border-0"><?= $item['description'] ?></textarea>
                </div>
                <?php endforeach; ?>
            </div>

            <button type="button" onclick="addElaAdminPoint()" class="btn btn-sm btn-link text-primary p-0 fw-bold">
                + Add Administration Point
            </button>
        </div>
    </div>
</div>


                <?php elseif ($slug == 'ela'): ?>
                <!-- ==========================================================================
                     PAGE: ELA TEST ADMIN
                =========================================================================== -->

                <!-- === SECTION 1: HERO SECTION === -->
                <div class="card mb-4 border-primary shadow-sm">
                    <div class="card-header bg-primary text-white fw-bold">Hero Section</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="small fw-bold">Hero Title</label>
                            <input type="text" name="hero[title]" value="<?= $data['hero']['title'] ?? '' ?>" class="form-control" placeholder="Hero Title">
                        </div>
                        <div class="mb-3">
                            <label class="small fw-bold">Hero Description</label>
                            <textarea name="hero[description]" class="form-control" rows="3" placeholder="Hero Description"><?= $data['hero']['description'] ?? '' ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- === SECTION 2: INTRO SECTION === -->
                <div class="card mb-4 border-info shadow-sm">
                    <div class="card-header bg-info text-white fw-bold">Intro Section</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="small fw-bold">Section Title (e.g. Who takes this test?)</label>
                            <input type="text" name="ela_intro_title" value="<?= $data['ela_intro_title'] ?? '' ?>" class="form-control" placeholder="Intro Title">
                        </div>
                        <div class="mb-3">
                            <label class="small fw-bold">Intro Content (Paragraphs)</label>
                            <textarea name="ela_intro_content" class="form-control" rows="6" placeholder="Paste the content here..."><?= $data['ela_intro_content'] ?? '' ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- === SECTION 3: ADMINISTRATION SECTION (Repeater) === -->
                <div class="card mb-4 border-secondary shadow-sm">
                    <div class="card-header bg-light fw-bold d-flex justify-content-between align-items-center">
                        Administration Section
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="addElaAdminPoint()">+ Add Administration Point</button>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="small fw-bold">Administration Heading</label>
                            <input type="text" name="ela_admin_title" value="<?= $data['ela_admin_title'] ?? '' ?>" class="form-control" placeholder="Administration Heading">
                        </div>
                        <div id="ela-admin-container">
                            <?php 
                            $adminPoints = json_decode($data['ela_admin_json'] ?? '[]', true);
                            foreach($adminPoints as $point): 
                            ?>
                            <div class="border rounded p-3 mb-2 bg-light position-relative shadow-sm">
                                <button type="button" class="btn btn-sm btn-link text-danger position-absolute top-0 end-0 m-1 remove-btn">Remove</button>
                                <div class="mb-2">
                                    <input type="text" name="ela_admin_name[]" value="<?= $point['name'] ?>" class="form-control fw-bold" placeholder="Title">
                                </div>
                                <textarea name="ela_admin_desc[]" class="form-control small" rows="2" placeholder="Description"><?= $point['desc'] ?></textarea>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
>>>>>>> 3b8e8e8565be720095338ba4c36ee3cc8408dc26
                <?php elseif ($slug == 'scat'): ?>
                <!-- ==========================================================================
                     PAGE: SCAT TEST ADMIN
                =========================================================================== -->

                <!-- 1. Hero Section -->
                <div class="card mb-4 border-primary shadow-sm">
                    <div class="card-header bg-primary text-white fw-bold">Hero Section</div>
                    <div class="card-body">
                        <input type="text" name="hero[title]" value="<?= $data['hero']['title'] ?? '' ?>" class="form-control mb-2" placeholder="Hero Title">
                        <textarea name="hero[description]" class="form-control" rows="3" placeholder="Hero Description"><?= $data['hero']['description'] ?? '' ?></textarea>
                    </div>
                </div>

                <!-- 2. About Section -->
                <div class="card mb-4 border-secondary shadow-sm">
                    <div class="card-header bg-light fw-bold">About Section</div>
                    <div class="card-body">
                        <input type="text" name="about[heading]" value="<?= $data['about']['heading'] ?? '' ?>" class="form-control mb-2" placeholder="About Heading">
                        <textarea name="about[description]" class="form-control mb-3" rows="3" placeholder="About Description"><?= $data['about']['description'] ?? '' ?></textarea>
                        
                        <input type="text" name="scat_versions_title" value="<?= $data['scat_versions_title'] ?? '' ?>" class="form-control mb-2" placeholder="Versions Heading">
                        <label class="small fw-bold">Versions List:</label>
                        <div id="scat-versions-container">
                            <?php 
                            $versions = json_decode($data['scat_versions_json'] ?? '[]', true);
                            foreach($versions as $v): ?>
                            <div class="input-group mb-2">
                                <input type="text" name="scat_versions[]" value="<?= $v ?>" class="form-control" placeholder="Version">
                                <button type="button" class="btn btn-outline-danger remove-btn text-danger">Remove</button>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="btn btn-sm btn-link text-decoration-none p-0" onclick="addScatVersion()">+ Add Version</button>
                    </div>
                </div>

                <!-- 3. Format Section & Sections Repeater -->
                <div class="card mb-4 border-info shadow-sm">
                    <div class="card-header bg-info text-white fw-bold">Format & Sections</div>
                    <div class="card-body">
                        <input type="text" name="scat_format_title" value="<?= $data['scat_format_title'] ?? '' ?>" class="form-control mb-2" placeholder="Format Heading">
                        <textarea name="scat_format_desc" class="form-control mb-4" rows="3" placeholder="Format Description"><?= $data['scat_format_desc'] ?? '' ?></textarea>
                        
                        <label class="fw-bold d-flex justify-content-between">Sections: <button type="button" class="btn btn-sm btn-outline-info" onclick="addScatSection()">+ Add Section</button></label>
                        <div id="scat-sections-container">
                            <?php 
                            $scat_sections = json_decode($data['scat_sections_json'] ?? '[]', true);
                            foreach($scat_sections as $sec): ?>
                            <div class="border rounded p-3 mb-2 bg-light position-relative">
                                <button type="button" class="btn btn-sm btn-link text-danger position-absolute top-0 end-0 m-1 remove-btn">Remove</button>
                                <input type="text" name="scat_sec_title[]" value="<?= $sec['title'] ?>" class="form-control mb-2 fw-bold" placeholder="Title">
                                <textarea name="scat_sec_desc[]" class="form-control small" rows="2" placeholder="Description"><?= $sec['desc'] ?></textarea>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- 4. Scoring Section -->
                <div class="card mb-4 shadow-sm" style="border-color: #A855F7;">
                    <div class="card-header text-white fw-bold d-flex justify-content-between align-items-center" style="background-color: #A855F7;">
                        Scoring Section
                        <button type="button" class="btn btn-sm btn-light" onclick="addScatLevel()">+ Add Level</button>
                    </div>
                    <div class="card-body">
                        <input type="text" name="scat_scoring_title" value="<?= $data['scat_scoring_title'] ?? '' ?>" class="form-control mb-3" placeholder="Scoring Heading">
                        <div id="scat-scoring-container">
                            <?php 
                            $levels = json_decode($data['scat_scoring_json'] ?? '[]', true);
                            foreach($levels as $lvl): ?>
                            <div class="border rounded p-3 mb-2 bg-white shadow-sm position-relative">
                                <button type="button" class="btn btn-sm btn-link text-danger position-absolute top-0 end-0 m-1 remove-btn">Remove</button>
                                <input type="text" name="scat_lvl_title[]" value="<?= $lvl['title'] ?>" class="form-control mb-2 fw-bold" placeholder="Level Title">
                                <textarea name="scat_lvl_details[]" class="form-control small" rows="2" placeholder="Details"><?= $lvl['details'] ?></textarea>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- 5. Tips Section -->
                <div class="card mb-4 border-success shadow-sm">
                    <div class="card-header bg-success text-white fw-bold d-flex justify-content-between">
                        Tips Section
                        <button type="button" class="btn btn-sm btn-light" onclick="addScatTip()">+ Add Tip</button>
                    </div>
                    <div class="card-body">
                        <input type="text" name="scat_tips_title" value="<?= $data['scat_tips_title'] ?? '' ?>" class="form-control mb-3" placeholder="Tips Heading">
                        <div id="scat-tips-container">
                            <?php 
                            $tips = json_decode($data['scat_tips_json'] ?? '[]', true);
                            foreach($tips as $tip): ?>
                            <div class="input-group mb-2">
                                <input type="text" name="scat_tips[]" value="<?= $tip ?>" class="form-control" placeholder="Tip">
                                <button type="button" class="btn btn-outline-danger remove-btn text-danger">Remove</button>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- 6. Registration & Auth -->
                <div class="card mb-4 border-dark shadow-sm">
                    <div class="card-header bg-dark text-white fw-bold">Registration & Auth</div>
                    <div class="card-body">
                        <input type="text" name="scat_reg_heading" value="<?= $data['scat_reg_heading'] ?? '' ?>" class="form-control mb-2" placeholder="Register Heading">
                        <input type="text" name="scat_reg_subheading" value="<?= $data['scat_reg_subheading'] ?? '' ?>" class="form-control mb-2" placeholder="Register Sub Heading">
                        <textarea name="scat_reg_contact" class="form-control mb-4" rows="3" placeholder="Register Contact List"><?= $data['scat_reg_contact'] ?? '' ?></textarea>
                        
                        <input type="text" name="scat_auth_heading" value="<?= $data['scat_auth_heading'] ?? '' ?>" class="form-control mb-2" placeholder="Auth Heading">
                        <textarea name="scat_auth_desc" class="form-control" rows="5" placeholder="Auth Description"><?= $data['scat_auth_desc'] ?? '' ?></textarea>
                    </div>
                </div>
      
           <?php elseif ($slug == 'amc'): ?>
                <!-- ==========================================================================
                     PAGE: AMC TEST ADMIN
                =========================================================================== -->

                <!-- 1. Hero Section -->
                <div class="card mb-4 border-primary shadow-sm">
                    <div class="card-header bg-primary text-white fw-bold">Hero Section</div>
                    <div class="card-body">
                        <input type="text" name="hero[title]" value="<?= $data['hero']['title'] ?? '' ?>" class="form-control mb-2" placeholder="Main Title (e.g. AMC TEST PREP)">
                        <textarea name="hero[description]" class="form-control" rows="3" placeholder="Hero Description (At GGES...)"><?= $data['hero']['description'] ?? '' ?></textarea>
                    </div>
                </div>

                <!-- 2. About AMC Test -->
                <div class="card mb-4 border-secondary shadow-sm">
                    <div class="card-header bg-light fw-bold">About AMC Test</div>
                    <div class="card-body">
                        <input type="text" name="about[heading]" value="<?= $data['about']['heading'] ?? '' ?>" class="form-control mb-2" placeholder="About Heading">
                        <textarea name="about[description]" class="form-control" rows="4" placeholder="About Description..."><?= $data['about']['description'] ?? '' ?></textarea>
                    </div>
                </div>

                <!-- 3. Who Can Participate? (Simple Repeater) -->
                <div class="card mb-4 border-warning shadow-sm">
                    <div class="card-header bg-warning text-dark fw-bold d-flex justify-content-between align-items-center">
                        Who Can Participate?
                        <button type="button" class="btn btn-sm btn-light" onclick="addAmcPoint()">+ Add Point</button>
                    </div>
                    <div class="card-body">
                        <input type="text" name="amc_participate_heading" value="<?= $data['amc_participate_heading'] ?? '' ?>" class="form-control mb-3" placeholder="Heading">
                        <div id="amc-participate-container">
                            <?php 
                            $points = json_decode($data['amc_participate_json'] ?? '[]', true);
                            foreach($points as $p): ?>
                            <div class="input-group mb-2">
                                <span class="input-group-text">•</span>
                                <input type="text" name="amc_points[]" value="<?= $p ?>" class="form-control" placeholder="e.g. Students: Middle and high school...">
                                <button type="button" class="btn btn-outline-danger remove-btn">x</button>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- 4. Different AMC Competitions (Complex Card Repeater) -->
                <div class="card mb-4 border-info shadow-sm">
                    <div class="card-header bg-info text-white fw-bold d-flex justify-content-between align-items-center">
                        Different AMC Competitions
                        <button type="button" class="btn btn-sm btn-light" onclick="addAmcCard()">+ Add Competition Card</button>
                    </div>
                    <div class="card-body">
                        <input type="text" name="amc_comp_heading" value="<?= $data['amc_comp_heading'] ?? '' ?>" class="form-control mb-4" placeholder="Section Heading">
                        <div class="row g-3" id="amc-cards-container">
                            <?php 
                            $cards = json_decode($data['amc_comp_json'] ?? '[]', true);
                            foreach($cards as $c): ?>
                            <div class="col-md-4 amc-card-item">
                                <div class="border rounded p-3 bg-white shadow-sm position-relative">
                                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 remove-btn" style="padding: 2px 8px;">×</button>
                                    <label class="small fw-bold">Title</label>
                                    <input type="text" name="amc_card_title[]" value="<?= $c['title'] ?>" class="form-control mb-2" placeholder="e.g. AMC 8">
                                    
                                    <label class="small fw-bold">amcDescription</label>
                                    <textarea name="amc_card_desc1[]" class="form-control mb-2 small" rows="3" placeholder="AMC Description (Rich Text)"><?= $c['desc1'] ?></textarea>
                                    
                                    <label class="small fw-bold">Description</label>
                                    <input type="text" name="amc_card_desc2[]" value="<?= $c['desc2'] ?>" class="form-control mb-2" placeholder="25 questions...">
                                    
                                    <label class="small fw-bold">When</label>
                                    <input type="text" name="amc_card_when[]" value="<?= $c['when'] ?>" class="form-control mb-2" placeholder="e.g. January annually">
                                    
                                    <label class="small fw-bold">Who</label>
                                    <input type="text" name="amc_card_who[]" value="<?= $c['who'] ?>" class="form-control" placeholder="e.g. Students under 15">
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- 5. Why Take AMC? -->
                <div class="card mb-4 border-dark shadow-sm">
                    <div class="card-header bg-dark text-white fw-bold">Why Take AMC?</div>
                    <div class="card-body">
                        <input type="text" name="amc_why_heading" value="<?= $data['amc_why_heading'] ?? '' ?>" class="form-control mb-2" placeholder="Heading">
                        <textarea name="amc_why_desc" class="form-control" rows="4" placeholder="Description (AMC 10/12 aims to...)"><?= $data['amc_why_desc'] ?? '' ?></textarea>
                    </div>
                </div>

           <?php elseif ($slug == 'kangaroo'): ?>
                <!-- ==========================================================================
                     PAGE: MATH KANGAROO TEST PREP ADMIN
                =========================================================================== -->

                <!-- 1. Hero Section -->
                <div class="card mb-4 border-primary shadow-sm">
                    <div class="card-header bg-primary text-white fw-bold">Hero Section</div>
                    <div class="card-body">
                        <label class="small fw-bold">Title *</label>
                        <input type="text" name="hero[title]" value="<?= $data['hero']['title'] ?? '' ?>" class="form-control mb-3" placeholder="MATH KANGAROO TEST PREP">
                        <label class="small fw-bold">Description *</label>
                        <textarea name="hero[description]" class="form-control" rows="4"><?= $data['hero']['description'] ?? '' ?></textarea>
                    </div>
                </div>

                <!-- 2. Test Structure -->
                <div class="card mb-4 border-secondary shadow-sm">
                    <div class="card-header bg-light fw-bold">Test Structure</div>
                    <div class="card-body">
                        <label class="small fw-bold">Heading *</label>
                        <input type="text" name="kan_struct_heading" value="<?= $data['kan_struct_heading'] ?? '' ?>" class="form-control mb-3" placeholder="TEST STRUCTURE">
                        <label class="small fw-bold">Description *</label>
                        <textarea name="kan_struct_desc" class="form-control" rows="4"><?= $data['kan_struct_desc'] ?? '' ?></textarea>
                    </div>
                </div>

                <!-- 3. Features (Simple Repeater) -->
                <div class="card mb-4 border-success shadow-sm">
                    <div class="card-header bg-success text-white fw-bold d-flex justify-content-between align-items-center">
                        Features
                        <button type="button" class="btn btn-sm btn-light" onclick="addKanFeature()">+ Add Feature</button>
                    </div>
                    <div class="card-body">
                        <input type="text" name="kan_feat_heading" value="<?= $data['kan_feat_heading'] ?? '' ?>" class="form-control mb-3" placeholder="Features Heading">
                        <div id="kan-features-container">
                            <?php 
                            $features = json_decode($data['kan_feat_json'] ?? '[]', true);
                            foreach($features as $f): ?>
                            <div class="input-group mb-2">
                                <input type="text" name="kan_features[]" value="<?= $f ?>" class="form-control" placeholder="Feature text...">
                                <button type="button" class="btn btn-outline-danger remove-btn">×</button>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- 4. General Rules (Nested Repeater: Rule + Subpoints) -->
                <div class="card mb-4 border-warning shadow-sm">
                    <div class="card-header bg-warning text-dark fw-bold d-flex justify-content-between align-items-center">
                        General Rules
                        <button type="button" class="btn btn-sm btn-dark" onclick="addKanRule()">+ Add Rule</button>
                    </div>
                    <div class="card-body bg-light">
                        <input type="text" name="kan_rules_heading" value="<?= $data['kan_rules_heading'] ?? '' ?>" class="form-control mb-3" placeholder="General Rules Heading">
                        
                        <div id="kan-rules-container">
                            <?php 
                            $rules = json_decode($data['kan_rules_json'] ?? '[]', true);
                            foreach($rules as $index => $rule): ?>
                            <div class="rule-block border rounded p-3 mb-3 bg-white shadow-sm position-relative">
                                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 remove-btn">×</button>
                                <input type="text" name="kan_rule_main[]" value="<?= $rule['main'] ?>" class="form-control mb-2 fw-bold" placeholder="Rule text...">
                                
                                <div class="ms-4">
                                    <label class="small fw-bold text-muted">Subpoints:</label>
                                    <div class="subpoints-container">
                                        <?php foreach($rule['subs'] as $sub): ?>
                                            <div class="input-group input-group-sm mb-1">
                                                <input type="text" name="kan_rule_sub_<?= $index ?>[]" value="<?= $sub ?>" class="form-control" placeholder="Subpoint...">
                                                <button type="button" class="btn btn-outline-danger remove-btn">×</button>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-link p-0 text-decoration-none" onclick="addKanSubpoint(this, <?= $index ?>)">+ Add Subpoint</button>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- 5. Scoring -->
                <div class="card mb-4 border-dark shadow-sm">
                    <div class="card-header bg-dark text-white fw-bold">Scoring</div>
                    <div class="card-body">
                        <label class="small fw-bold">Heading *</label>
                        <input type="text" name="kan_score_heading" value="<?= $data['kan_score_heading'] ?? '' ?>" class="form-control mb-3">
                        <label class="small fw-bold">Description *</label>
                        <textarea name="kan_score_desc" class="form-control" rows="4"><?= $data['kan_score_desc'] ?? '' ?></textarea>
                    </div>
                </div>
<?php elseif ($slug == 'act'): ?>
                <!-- ==========================================================================
                     PAGE: ACT TEST PREPARATION - ADMIN (Full Width UI)
                =========================================================================== -->

                <!-- 1. Hero Section -->
                <div class="card mb-4 border-primary shadow-sm w-100">
                    <div class="card-header bg-primary text-white fw-bold">1. Hero Section *</div>
                    <div class="card-body">
                        <input type="text" name="hero[title]" value="<?= $data['hero']['title'] ?? '' ?>" class="form-control mb-3" placeholder="ACT TEST PREP">
                        <textarea name="hero[description]" class="form-control" rows="4" placeholder="At GGES, We have the best tutors..."><?= $data['hero']['description'] ?? '' ?></textarea>
                    </div>
                </div>

                <!-- 2. About ACT Section -->
                <div class="card mb-4 border-secondary shadow-sm w-100">
                    <div class="card-header bg-light fw-bold">2. About ACT Section *</div>
                    <div class="card-body">
                        <input type="text" name="about[heading]" value="<?= $data['about']['heading'] ?? '' ?>" class="form-control mb-3" placeholder="All About ACT">
                        <textarea name="about[description]" class="form-control mb-4" rows="4" placeholder="The ACT (American College Testing) is..."><?= $data['about']['description'] ?? '' ?></textarea>
                        
                        <label class="fw-bold text-dark border-bottom pb-2 mb-3 d-block">About List Items:</label>
                        <div id="act-about-list-container">
                            <?php 
                            $aboutList = json_decode($data['act_about_json'] ?? '[]', true);
                            foreach($aboutList as $item): ?>
                            <div class="border rounded p-3 mb-3 bg-white position-relative shadow-sm">
                                <button type="button" class="btn btn-sm btn-link text-danger position-absolute top-0 end-0 m-2 remove-btn" style="text-decoration:none;">✕ Remove</button>
                                <input type="text" name="act_about_title[]" value="<?= $item['title'] ?>" class="form-control mb-2 fw-bold" placeholder="Item Title (e.g. Core sections:)">
                                <textarea name="act_about_content[]" class="form-control small" rows="2" placeholder="Item Content..."><?= $item['content'] ?></textarea>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="btn btn-sm btn-link text-decoration-none p-0" onclick="addActAboutItem()">+ Add About Item</button>
                    </div>
                </div>

                <!-- 3. Additional Info -->
                <div class="card mb-4 border-warning shadow-sm w-100">
                    <div class="card-header bg-warning text-dark fw-bold">3. Additional Info *</div>
                    <div class="card-body">
                        <input type="text" name="act_additional_heading" value="<?= $data['act_additional_heading'] ?? '' ?>" class="form-control mb-4" placeholder="Additional info Heading">
                        
                        <label class="fw-bold d-block mb-3">Add List Items:</label>
                        <div id="act-additional-container">
                            <?php 
                            $addInfo = json_decode($data['act_additional_json'] ?? '[]', true);
                            foreach($addInfo as $info): ?>
                            <div class="border rounded p-3 mb-3 bg-light position-relative">
                                <button type="button" class="btn btn-sm btn-link text-danger position-absolute top-0 end-0 m-2 remove-btn" style="text-decoration:none;">✕ Remove</button>
                                <input type="text" name="act_add_title[]" value="<?= $info['title'] ?>" class="form-control mb-2 fw-bold" placeholder="Title (e.g. Cost:)">
                                <textarea name="act_add_content[]" class="form-control small" rows="2" placeholder="Content..."><?= $info['content'] ?></textarea>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="btn btn-sm btn-link text-decoration-none p-0" onclick="addActAdditionalInfo()">+ Add Additional Info</button>
                    </div>
                </div>

                <!-- 4. ACT Test Sections -->
                <div class="card mb-4 border-info shadow-sm w-100">
                    <div class="card-header bg-info text-white fw-bold">4. ACT Test Sections *</div>
                    <div class="card-body">
                        <input type="text" name="act_test_sections_heading" value="<?= $data['act_test_sections_heading'] ?? '' ?>" class="form-control mb-4" placeholder="New ACT in 2025 Heading">
                        
                        <div id="act-test-sections-container">
                            <?php 
                            $testSections = json_decode($data['act_test_sections_json'] ?? '[]', true);
                            foreach($testSections as $ts): ?>
                            <div class="border rounded p-4 mb-3 bg-white position-relative border-start border-info border-4 shadow-sm">
                                <button type="button" class="btn btn-sm btn-link text-danger position-absolute top-0 end-0 m-2 remove-btn" style="text-decoration:none;">✕ Remove</button>
                                <input type="text" name="act_ts_title[]" value="<?= $ts['title'] ?>" class="form-control mb-3 fw-bold bg-light" placeholder="Section Title (e.g. 1. Optional Science section)">
                                <textarea name="act_ts_desc[]" class="form-control" rows="5" placeholder="Detailed content..."><?= $ts['desc'] ?></textarea>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="btn btn-sm btn-link text-decoration-none p-0 mt-2" onclick="addActTestSection()">+ Add ACT Item</button>
                    </div>
                </div>

            <?php elseif ($slug == 'cogat'): ?>
                <!-- ==========================================================================
                     PAGE: CogAT ADMIN PANEL (Full Width UI)
                =========================================================================== -->

                <!-- 1. HERO SECTION -->
                <div class="card mb-4 border-primary shadow-sm">
                    <div class="card-header bg-primary text-white fw-bold">1. Hero Section</div>
                    <div class="card-body">
                        <label class="small fw-bold">Main Title</label>
                        <input type="text" name="hero[title]" value="<?= $data['hero']['title'] ?? '' ?>" class="form-control mb-3" placeholder="Hero Title">
                        
                        <label class="small fw-bold">Main Description</label>
                        <textarea name="hero[description]" class="form-control mb-3" rows="4" placeholder="Introduction Paragraph..."><?= $data['hero']['description'] ?? '' ?></textarea>
                        
                        <?php $hero_extra = json_decode($data['cogat_hero_json'] ?? '[]', true); ?>
                        <label class="small fw-bold">Sub Description (List Intro)</label>
                        <input type="text" name="cogat_hero_sub" value="<?= $hero_extra['sub_desc'] ?? '' ?>" class="form-control mb-3" placeholder="e.g. GGES makes the best tutoring options...">
                        
                        <label class="small fw-bold">Bullet Points (Why Choose GGES?):</label>
                        <div id="cogat-hero-bullets">
                            <?php foreach(($hero_extra['bullets'] ?? ['']) as $b): ?>
                            <div class="input-group mb-2">
                                <input type="text" name="cogat_hero_bullets[]" value="<?= $b ?>" class="form-control" placeholder="Bullet point...">
                                <button type="button" class="btn btn-outline-danger remove-btn">×</button>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="btn btn-sm btn-link p-0 text-decoration-none" onclick="addCogatHeroBullet()">+ Add Bullet</button>
                    </div>
                </div>

                <!-- 2. TEST STRUCTURE -->
                <div class="card mb-4 border-secondary shadow-sm">
                    <div class="card-header bg-light fw-bold">2. Test Structure</div>
                    <div class="card-body">
                        <?php $struct = json_decode($data['cogat_struct_json'] ?? '[]', true); ?>
                        <input type="text" name="cogat_struct_heading" value="<?= $struct['heading'] ?? '' ?>" class="form-control mb-2" placeholder="Heading (What is on the test?)">
                        <textarea name="cogat_struct_desc" class="form-control mb-4" rows="3" placeholder="Description..."><?= $struct['desc'] ?? '' ?></textarea>
                        
                        <label class="small fw-bold">Structure Table (3 Columns):</label>
                        <div id="cogat-struct-table">
                            <div class="row g-2 mb-2 d-none d-md-flex">
                                <div class="col-4 small fw-bold">Verbal Battery</div>
                                <div class="col-4 small fw-bold">Quantitative Battery</div>
                                <div class="col-3 small fw-bold">Non-Verbal Battery</div>
                            </div>
                            <?php foreach(($struct['table'] ?? [['v'=>'','q'=>'','n'=>'']]) as $row): ?>
                            <div class="row g-2 mb-2 align-items-center table-data-row">
                                <div class="col-4"><input type="text" name="cogat_struct_v[]" value="<?= $row['v'] ?>" class="form-control" placeholder="Verbal item"></div>
                                <div class="col-4"><input type="text" name="cogat_struct_q[]" value="<?= $row['q'] ?>" class="form-control" placeholder="Quant item"></div>
                                <div class="col-3"><input type="text" name="cogat_struct_n[]" value="<?= $row['n'] ?>" class="form-control" placeholder="Non-Verbal item"></div>
                                <div class="col-1 text-end"><button type="button" class="btn btn-danger remove-btn">×</button></div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="btn btn-sm btn-secondary" onclick="addCogatStructRow()">+ Add Row</button>
                    </div>
                </div>

                <!-- 3 & 4. MEASURE & ADMINISTERED -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-4 border-info shadow-sm h-100">
                            <div class="card-header bg-info text-white fw-bold">3. What Does It Measure?</div>
                            <div class="card-body">
                                <?php $measure = json_decode($data['cogat_measure_json'] ?? '[]', true); ?>
                                <input type="text" name="cogat_measure_h" value="<?= $measure['heading'] ?? '' ?>" class="form-control mb-2" placeholder="Heading">
                                <textarea name="cogat_measure_c" class="form-control" rows="5" placeholder="Content..."><?= $measure['content'] ?? '' ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-4 border-info shadow-sm h-100">
                            <div class="card-header bg-info text-white fw-bold">4. How Administered?</div>
                            <div class="card-body">
                                <?php $administer = json_decode($data['cogat_administer_json'] ?? '[]', true); ?>
                                <input type="text" name="cogat_administer_h" value="<?= $administer['heading'] ?? '' ?>" class="form-control mb-2" placeholder="Heading">
                                <textarea name="cogat_administer_c" class="form-control" rows="5" placeholder="Intro text..."><?= $administer['content'] ?? '' ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 5. LEVELS & TIMING -->
                <div class="card mb-4 border-warning shadow-sm">
                    <div class="card-header bg-warning text-dark fw-bold">5. Levels & Timing</div>
                    <div class="card-body">
                        <?php $lt = json_decode($data['cogat_levels_json'] ?? '[]', true); ?>
                        <input type="text" name="cogat_lt_h" value="<?= $lt['heading'] ?? '' ?>" class="form-control mb-2" placeholder="Heading (Which CogAT Level...)">
                        <textarea name="cogat_lt_d" class="form-control mb-4" rows="3" placeholder="Description..."><?= $lt['desc'] ?? '' ?></textarea>
                        
                        <div id="cogat-lt-table">
                            <div class="row g-2 mb-2 fw-bold small">
                                <div class="col-3">Grade</div><div class="col-3">Level</div><div class="col-3">Questions</div><div class="col-2">Time</div>
                            </div>
                            <?php foreach(($lt['table'] ?? [['g'=>'','l'=>'','q'=>'','t'=>'']]) as $row): ?>
                            <div class="row g-2 mb-2 table-data-row">
                                <div class="col-3"><input type="text" name="cogat_lt_g[]" value="<?= $row['g'] ?>" class="form-control" placeholder="Grade"></div>
                                <div class="col-3"><input type="text" name="cogat_lt_l[]" value="<?= $row['l'] ?>" class="form-control" placeholder="Level"></div>
                                <div class="col-3"><input type="text" name="cogat_lt_q[]" value="<?= $row['q'] ?>" class="form-control" placeholder="Ques"></div>
                                <div class="col-2"><input type="text" name="cogat_lt_t[]" value="<?= $row['t'] ?>" class="form-control" placeholder="Time"></div>
                                <div class="col-1 text-end"><button type="button" class="btn btn-danger remove-btn">×</button></div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-warning mb-4" onclick="addCogatLtRow()">+ Add Level Row</button>
                        
                        <input type="text" name="cogat_lt_qh" value="<?= $lt['q_heading'] ?? '' ?>" class="form-control mb-2" placeholder="Question Count Heading">
                        <textarea name="cogat_lt_qd" class="form-control" rows="2" placeholder="Question Count Description..."><?= $lt['q_desc'] ?? '' ?></textarea>
                    </div>
                </div>

                <!-- 6. BATTERY DETAILS -->
                <div class="card mb-4 border-success shadow-sm">
                    <div class="card-header bg-success text-white fw-bold">6. Battery Details</div>
                    <div class="card-body">
                        <?php $battery = json_decode($data['cogat_battery_json'] ?? '[]', true); ?>
                        
                        <!-- Verbal -->
                        <h6 class="fw-bold text-primary border-bottom pb-2">VERBAL BATTERY</h6>
                        <div id="cogat-v-battery">
                            <?php foreach(($battery['verbal'] ?? [['t'=>'','d'=>'']]) as $item): ?>
                            <div class="row g-2 mb-3 table-data-row border-bottom pb-2">
                                <div class="col-4"><input type="text" name="cogat_v_t[]" value="<?= $item['t'] ?>" class="form-control fw-bold" placeholder="Title (e.g. Picture Analogies)"></div>
                                <div class="col-7"><textarea name="cogat_v_d[]" class="form-control small" rows="2"><?= $item['d'] ?></textarea></div>
                                <div class="col-1"><button type="button" class="btn btn-outline-danger remove-btn">×</button></div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="btn btn-sm btn-link p-0 mb-4" onclick="addCogatBattery('v')">+ Add Verbal Item</button>

                        <!-- Non-Verbal -->
                        <h6 class="fw-bold text-success border-bottom pb-2">NON-VERBAL BATTERY</h6>
                        <div id="cogat-nv-battery">
                            <?php foreach(($battery['nv'] ?? [['t'=>'','d'=>'']]) as $item): ?>
                            <div class="row g-2 mb-3 table-data-row border-bottom pb-2">
                                <div class="col-4"><input type="text" name="cogat_nv_t[]" value="<?= $item['t'] ?>" class="form-control fw-bold" placeholder="Title"></div>
                                <div class="col-7"><textarea name="cogat_nv_d[]" class="form-control small" rows="2"><?= $item['d'] ?></textarea></div>
                                <div class="col-1"><button type="button" class="btn btn-outline-danger remove-btn">×</button></div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="btn btn-sm btn-link p-0 mb-4 text-success" onclick="addCogatBattery('nv')">+ Add Non-Verbal Item</button>

                        <!-- Quantitative -->
                        <h6 class="fw-bold text-warning border-bottom pb-2">QUANTITATIVE BATTERY</h6>
                        <div id="cogat-q-battery">
                            <?php foreach(($battery['q'] ?? [['t'=>'','d'=>'']]) as $item): ?>
                            <div class="row g-2 mb-3 table-data-row border-bottom pb-2">
                                <div class="col-4"><input type="text" name="cogat_q_t[]" value="<?= $item['t'] ?>" class="form-control fw-bold" placeholder="Title"></div>
                                <div class="col-7"><textarea name="cogat_q_d[]" class="form-control small" rows="2"><?= $item['d'] ?></textarea></div>
                                <div class="col-1"><button type="button" class="btn btn-outline-danger remove-btn">×</button></div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="btn btn-sm btn-link p-0 text-warning" onclick="addCogatBattery('q')">+ Add Quant Item</button>
                    </div>
                </div>

                <!-- 7. SCORING & LOCATION -->
                <div class="card mb-4 border-dark shadow-sm">
                    <div class="card-header bg-dark text-white fw-bold">7. Scoring & Location</div>
                    <div class="card-body">
                        <?php $sl = json_decode($data['cogat_score_loc_json'] ?? '[]', true); ?>
                        <input type="text" name="cogat_s_h" value="<?= $sl['s_h'] ?? '' ?>" class="form-control mb-2 fw-bold" placeholder="How is the CogAT scored?">
                        <textarea name="cogat_s_d" class="form-control mb-4" rows="4"><?= $sl['s_d'] ?? '' ?></textarea>
                        
                        <input type="text" name="cogat_l_h" value="<?= $sl['l_h'] ?? '' ?>" class="form-control mb-2 fw-bold" placeholder="Where is the CogAT given?">
                        <textarea name="cogat_l_d" class="form-control" rows="4"><?= $sl['l_d'] ?? '' ?></textarea>
                    </div>
                </div>

            <?php elseif ($slug == 'sbac'): ?>
                <!-- ==========================================================================
                     PAGE: SBAC PAGE ADMIN (Full Width UI)
                =========================================================================== -->

                <!-- 1. Hero Section -->
                <div class="card mb-4 border-primary shadow-sm w-100">
                    <div class="card-header bg-primary text-white fw-bold">1. Hero Section</div>
                    <div class="card-body">
                        <label class="small fw-bold">Title *</label>
                        <input type="text" name="hero[title]" value="<?= $data['hero']['title'] ?? '' ?>" class="form-control mb-3" placeholder="SBAC TEST PREP">
                        
                        <label class="small fw-bold">Description *</label>
                        <textarea name="hero[description]" class="form-control" rows="4" placeholder="Hero Description (Rich Text)"><?= $data['hero']['description'] ?? '' ?></textarea>
                    </div>
                </div>

                <!-- 2. About SBAC -->
                <div class="card mb-4 border-secondary shadow-sm w-100">
                    <div class="card-header bg-light fw-bold">2. About SBAC</div>
                    <div class="card-body">
                        <input type="text" name="about[heading]" value="<?= $data['about']['heading'] ?? '' ?>" class="form-control mb-2" placeholder="About Heading">
                        <textarea name="about[description]" class="form-control" rows="5" placeholder="About Description..."><?= $data['about']['description'] ?? '' ?></textarea>
                    </div>
                </div>

                <!-- 3. Assessment Details -->
                <div class="card mb-4 border-info shadow-sm w-100">
                    <div class="card-header bg-info text-white fw-bold">3. Assessment Details</div>
                    <div class="card-body">
                        <input type="text" name="sbac_assess_heading" value="<?= $data['sbac_assess_heading'] ?? '' ?>" class="form-control mb-2" placeholder="Assessment Heading">
                        <textarea name="sbac_assess_desc" class="form-control mb-4" rows="4" placeholder="Assessment Description..."><?= $data['sbac_assess_desc'] ?? '' ?></textarea>
                        
                        <label class="fw-bold border-bottom pb-2 d-block mb-3">Assessment Points (Title + Description):</label>
                        <div id="sbac-points-container">
                            <?php 
                            $points = json_decode($data['sbac_assess_points_json'] ?? '[]', true);
                            foreach($points as $p): ?>
                            <div class="border rounded p-3 mb-3 bg-white position-relative shadow-sm border-start border-info border-4">
                                <button type="button" class="btn btn-sm btn-link text-danger position-absolute top-0 end-0 m-2 remove-btn" style="text-decoration:none;">✕ Remove</button>
                                <div class="mb-2">
                                    <label class="small fw-bold">Point Title</label>
                                    <input type="text" name="sbac_pt_title[]" value="<?= $p['title'] ?>" class="form-control" placeholder="e.g. Mathematics Assessment">
                                </div>
                                <div>
                                    <label class="small fw-bold">Description</label>
                                    <textarea name="sbac_pt_desc[]" class="form-control small" rows="3"><?= $p['desc'] ?></textarea>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="btn btn-sm btn-link text-decoration-none p-0" onclick="addSbacPoint()">+ Add More Assessment Point</button>
                    </div>
                </div>

            
            <?php elseif ($slug == 'accuplacer'): ?>
                <!-- ==========================================================================
                     PAGE: ACCUPLACER PAGE ADMIN (Full Width UI)
                =========================================================================== -->

                <!-- 1. Hero Section -->
                <div class="card mb-4 border-primary shadow-sm w-100">
                    <div class="card-header bg-primary text-white fw-bold">1. Hero Section</div>
                    <div class="card-body">
                        <label class="small fw-bold">Title *</label>
                        <input type="text" name="hero[title]" value="<?= $data['hero']['title'] ?? '' ?>" class="form-control mb-3" placeholder="ACCUPLACER TEST PREP">
                        <label class="small fw-bold">Description *</label>
                        <textarea name="hero[description]" class="form-control" rows="4" placeholder="Hero Description"><?= $data['hero']['description'] ?? '' ?></textarea>
                    </div>
                </div>

                <!-- 2. About Accuplacer -->
                <div class="card mb-4 border-secondary shadow-sm w-100">
                    <div class="card-header bg-light fw-bold">2. About Accuplacer</div>
                    <div class="card-body">
                        <input type="text" name="about[heading]" value="<?= $data['about']['heading'] ?? '' ?>" class="form-control mb-2" placeholder="ABOUT ACCUPLACER">
                        <textarea name="about[description]" class="form-control mb-3" rows="4" placeholder="Main description..."><?= $data['about']['description'] ?? '' ?></textarea>
                        
                        <div class="bg-light p-3 rounded border">
                            <label class="small fw-bold">Sub Heading (What's on the Tests)</label>
                            <input type="text" name="accu_about_subheading" value="<?= $data['accu_about_subheading'] ?? '' ?>" class="form-control mb-2">
                            <label class="small fw-bold">Sub Description</label>
                            <textarea name="accu_about_subdesc" class="form-control" rows="3"><?= $data['accu_about_subdesc'] ?? '' ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- 3. What's on the Tests (Repeater) -->
                <div class="card mb-4 border-info shadow-sm w-100">
                    <div class="card-header bg-info text-white fw-bold d-flex justify-content-between align-items-center">
                        3. What's on the Tests
                        <button type="button" class="btn btn-sm btn-light" onclick="addAccuTestItem()">+ Add Item</button>
                    </div>
                    <div class="card-body">
                        <div id="accu-test-items-container">
                            <?php 
                            $testItems = json_decode($data['accu_test_items_json'] ?? '[]', true);
                            foreach($testItems as $item): ?>
                            <div class="border rounded p-3 mb-3 bg-white position-relative shadow-sm border-start border-info border-4">
                                <button type="button" class="btn btn-sm btn-link text-danger position-absolute top-0 end-0 m-2 remove-btn" style="text-decoration:none;">✕</button>
                                <input type="text" name="accu_test_title[]" value="<?= $item['title'] ?>" class="form-control mb-2 fw-bold" placeholder="Reading Test">
                                <textarea name="accu_test_desc[]" class="form-control small" rows="3"><?= $item['desc'] ?></textarea>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- 4. WritePlacer Section (Repeater) -->
                <div class="card mb-4 shadow-sm w-100" style="border-color: #A855F7;">
                    <div class="card-header text-white fw-bold d-flex justify-content-between align-items-center" style="background-color: #A855F7;">
                        4. WritePlacer Section
                        <button type="button" class="btn btn-sm btn-light" onclick="addAccuWriteItem()">+ Add Item</button>
                    </div>
                    <div class="card-body">
                        <label class="small fw-bold">Write Placer Intro Section</label>
                        <textarea name="accu_write_intro" class="form-control mb-4" rows="3"><?= $data['accu_write_intro'] ?? '' ?></textarea>
                        
                        <label class="fw-bold small mb-2 d-block">Write Placer List:</label>
                        <div id="accu-write-items-container">
                            <?php 
                            $writeItems = json_decode($data['accu_write_items_json'] ?? '[]', true);
                            foreach($writeItems as $item): ?>
                            <div class="border rounded p-3 mb-3 bg-light position-relative">
                                <button type="button" class="btn btn-sm btn-link text-danger position-absolute top-0 end-0 m-2 remove-btn" style="text-decoration:none;">✕</button>
                                <input type="text" name="accu_write_title[]" value="<?= $item['title'] ?>" class="form-control mb-2 fw-bold" placeholder="Purpose and Focus">
                                <textarea name="accu_write_desc[]" class="form-control small" rows="2"><?= $item['desc'] ?></textarea>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- 5. ESL Accuplacer Section (Repeater) -->
                <div class="card mb-4 border-dark shadow-sm w-100">
                    <div class="card-header bg-dark text-white fw-bold d-flex justify-content-between align-items-center">
                        5. Accuplacer Section (ESL)
                        <button type="button" class="btn btn-sm btn-outline-light" onclick="addAccuEslItem()">+ Add Item</button>
                    </div>
                    <div class="card-body">
                        <label class="small fw-bold">Accuplacer Section Desc</label>
                        <textarea name="accu_esl_intro" class="form-control mb-4" rows="3"><?= $data['accu_esl_intro'] ?? '' ?></textarea>
                        
                        <label class="fw-bold small mb-2 d-block">Accuplacer List:</label>
                        <div id="accu-esl-items-container">
                            <?php 
                            $eslItems = json_decode($data['accu_esl_items_json'] ?? '[]', true);
                            foreach($eslItems as $item): ?>
                            <div class="border rounded p-3 mb-3 bg-white position-relative shadow-sm">
                                <button type="button" class="btn btn-sm btn-link text-danger position-absolute top-0 end-0 m-2 remove-btn" style="text-decoration:none;">✕</button>
                                <input type="text" name="accu_esl_title[]" value="<?= $item['title'] ?>" class="form-control mb-2 fw-bold" placeholder="The ESL Language Use test">
                                <textarea name="accu_esl_desc[]" class="form-control small" rows="2"><?= $item['desc'] ?></textarea>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

         <?php elseif ($slug == 'stb'): ?>
                <!-- ==========================================================================
                     PAGE: STB PAGE ADMIN (Full Width UI)
                =========================================================================== -->

                <!-- 1. Hero Section -->
                <div class="card mb-4 border-primary shadow-sm w-100">
                    <div class="card-header bg-primary text-white fw-bold">1. Hero Section</div>
                    <div class="card-body">
                        <label class="small fw-bold">Main Title *</label>
                        <input type="text" name="hero[title]" value="<?= $data['hero']['title'] ?? '' ?>" class="form-control mb-3" placeholder="e.g. STB TEST PREP">
                        <label class="small fw-bold">Hero Description</label>
                        <textarea name="hero[description]" class="form-control" rows="3"><?= $data['hero']['description'] ?? '' ?></textarea>
                    </div>
                </div>

                <!-- 2. About the STB -->
                <div class="card mb-4 border-secondary shadow-sm w-100">
                    <div class="card-header bg-light fw-bold">2. About the STB</div>
                    <div class="card-body">
                        <input type="text" name="about[heading]" value="<?= $data['about']['heading'] ?? '' ?>" class="form-control mb-2" placeholder="Heading (e.g. About the STB)">
                        <textarea name="about[description]" class="form-control" rows="5" placeholder="Rich text description..."><?= $data['about']['description'] ?? '' ?></textarea>
                    </div>
                </div>

                <!-- 3. STB Usage Details -->
                <div class="card mb-4 border-info shadow-sm w-100">
                    <div class="card-header bg-info text-white fw-bold">3. STB Usage Details</div>
                    <div class="card-body">
                        <?php $usage = json_decode($data['stb_usage_json'] ?? '[]', true); ?>
                        <label class="small fw-bold">Usage Intro Description</label>
                        <textarea name="stb_usage_intro" class="form-control mb-3" rows="2"><?= $usage['intro'] ?? '' ?></textarea>
                        
                        <label class="small fw-bold">STB Subset Points:</label>
                        <div id="stb-usage-points-container">
                            <?php foreach(($usage['points'] ?? ['']) as $p): ?>
                            <div class="input-group mb-2">
                                <input type="text" name="stb_usage_points[]" value="<?= $p ?>" class="form-control" placeholder="Enter point...">
                                <button type="button" class="btn btn-outline-danger remove-btn">✕</button>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="btn btn-sm btn-link p-0 mb-3" onclick="addStbUsagePoint()">+ Add Point</button>

                        <label class="small fw-bold d-block">Description after the bullet points...</label>
                        <textarea name="stb_usage_footer" class="form-control" rows="2"><?= $usage['footer'] ?? '' ?></textarea>
                    </div>
                </div>

                <!-- 4. STB Subtests -->
                <div class="card mb-4 shadow-sm w-100" style="border-color: #A855F7;">
                    <div class="card-header text-white fw-bold d-flex justify-content-between align-items-center" style="background-color: #A855F7;">
                        4. STB Subtests
                        <button type="button" class="btn btn-sm btn-light" onclick="addStbSubtest()">+ Add Subtest</button>
                    </div>
                    <div class="card-body">
                        <input type="text" name="stb_subtests_heading" value="<?= $data['stb_subtests_heading'] ?? '' ?>" class="form-control mb-4" placeholder="Heading (e.g. STB Subtests)">
                        <div id="stb-subtests-container">
                            <?php 
                            $subtests = json_decode($data['stb_subtests_json'] ?? '[]', true);
                            foreach($subtests as $st): ?>
                            <div class="border rounded p-3 mb-3 bg-light position-relative shadow-sm">
                                <button type="button" class="btn btn-sm btn-link text-danger position-absolute top-0 end-0 m-1 remove-btn" style="text-decoration:none;">✕</button>
                                <input type="text" name="stb_st_title[]" value="<?= $st['title'] ?>" class="form-control mb-2 fw-bold" placeholder="Subtest Title (e.g. Visual Memory)">
                                <textarea name="stb_st_desc[]" class="form-control small" rows="3" placeholder="Description..."><?= $st['desc'] ?></textarea>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- 5. Important Testing Info & Timing Table -->
                <div class="card mb-4 border-dark shadow-sm w-100">
                    <div class="card-header bg-dark text-white fw-bold">5. Important Testing Information</div>
                    <div class="card-body">
                        <input type="text" name="stb_info_heading" value="<?= $data['stb_info_heading'] ?? '' ?>" class="form-control mb-2" placeholder="Heading">
                        <textarea name="stb_info_text" class="form-control mb-4" rows="3" placeholder="Info Text..."><?= $data['stb_info_text'] ?? '' ?></textarea>

                        <div class="p-3 border rounded bg-light">
                            <label class="fw-bold mb-3 d-flex justify-content-between">Timing Table Data: <button type="button" class="btn btn-sm btn-outline-dark" onclick="addStbTimingRow()">+ Add Table Row</button></label>
                            <div id="stb-timing-table">
                                <div class="row g-2 mb-2 fw-bold small text-center d-none d-md-flex">
                                    <div class="col-4 text-start">Subtest/Activity</div>
                                    <div class="col-4">5th/6th Graders Time</div>
                                    <div class="col-3">7th+ Graders Time</div>
                                </div>
                                <?php 
                                $timing = json_decode($data['stb_timing_json'] ?? '[]', true);
                                foreach(($timing ?: [['s'=>'','t1'=>'','t2'=>'']]) as $row): ?>
                                <div class="row g-2 mb-2 table-data-row align-items-center">
                                    <div class="col-4"><input type="text" name="stb_time_s[]" value="<?= $row['s'] ?>" class="form-control" placeholder="Subtest/Activity"></div>
                                    <div class="col-4"><input type="text" name="stb_time_t1[]" value="<?= $row['t1'] ?>" class="form-control" placeholder="Time"></div>
                                    <div class="col-3"><input type="text" name="stb_time_t2[]" value="<?= $row['t2'] ?>" class="form-control" placeholder="Time"></div>
                                    <div class="col-1 text-end"><button type="button" class="btn btn-sm btn-danger remove-btn">✕</button></div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>

       

            <?php endif; ?>


            <!-- COMMON SAVE BUTTON -->
            <div class="sticky-bottom bg-white py-3 border-top text-center mt-5">
                <button type="submit" class="btn btn-primary btn-lg px-5 shadow rounded-pill">💾 Save All Changes for <?php echo strtoupper($slug); ?></button>
            </div>

        </form>
    </div>
</div>

<!-- ==========================================================================
     UNIFIED JAVASCRIPT REPEATERS
=========================================================================== -->
<script>
// SAT & PSAT Functions
function addFeature(containerId) {
    const html = `<div class="input-group mb-2 shadow-sm"><span class="input-group-text bg-white text-success"><i class="fas fa-check-square"></i></span><input type="text" name="features[]" class="form-control"><button type="button" class="btn btn-outline-danger remove-btn">x</button></div>`;
    document.getElementById(containerId || 'feature-container').insertAdjacentHTML('beforeend', html);
}
function addSatRow(containerId) {
    const html = `<div class="row g-2 mb-2 table-data-row"><div class="col-4"><input type="text" name="table_name[]" class="form-control"></div><div class="col-3"><input type="text" name="table_time[]" class="form-control"></div><div class="col-4"><input type="text" name="table_modules[]" class="form-control"></div><div class="col-1 text-end"><button type="button" class="btn btn-danger remove-btn">x</button></div></div>`;
    document.getElementById(containerId || 'sat-table-container').insertAdjacentHTML('beforeend', html);
}
function addPsatTableRow() { addSatRow('psat-table-container'); }
function addPsatFeature() { addFeature('psat-feature-container'); }

// SSAT Functions
function addLevel() {
    const html = `<div class="row mb-3 border p-2 rounded bg-white shadow-sm"><div class="col-11"><input type="text" name="levels[title][]" class="form-control mb-1 fw-bold"><textarea name="levels[desc][]" class="form-control small" rows="2"></textarea></div><div class="col-1 text-end"><button type="button" class="btn btn-danger btn-sm remove-btn">x</button></div></div>`;
    document.getElementById('level-container').insertAdjacentHTML('beforeend', html);
}
function addCompPoint() {
    const html = `<div class="input-group mb-2"><span class="input-group-text">•</span><input type="text" name="comp[points][]" class="form-control"><button type="button" class="btn btn-outline-danger remove-btn">x</button></div>`;
    document.getElementById('comp-points').insertAdjacentHTML('beforeend', html);
}
function addScoreCard() {
    const html = `<div class="col-md-4"><div class="border p-2 rounded position-relative bg-white shadow-sm"><button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 remove-btn">x</button><input type="text" name="scoring[c_title][]" class="form-control fw-bold mb-1 small"><textarea name="scoring[c_content][]" class="form-control small" rows="3"></textarea></div></div>`;
    document.getElementById('score-card-container').insertAdjacentHTML('beforeend', html);
}
function addRow(type) {
    const container = document.getElementById(type + '-rows');
    const p = (type === 'middle') ? 'm' : 'u';
    const html = `<div class="row g-1 mb-2 align-items-center border-bottom pb-1"><div class="col-3"><input type="text" name="${p}_sec[]" class="form-control form-control-sm"></div><div class="col-2"><input type="text" name="${p}_time[]" class="form-control form-control-sm"></div><div class="col-2"><input type="text" name="${p}_qs[]" class="form-control form-control-sm"></div><div class="col-4"><input type="text" name="${p}_link[]" class="form-control form-control-sm"></div><div class="col-1 text-center"><button type="button" class="btn btn-sm btn-link text-danger remove-btn">x</button></div></div>`;
    container.insertAdjacentHTML('beforeend', html);
}

// PSAT & SHSAT Specific
function addExamRow() {
    const html = `<div class="row g-2 mb-2 table-data-row"><div class="col-4"><input type="text" name="exam_name[]" class="form-control border-danger"></div><div class="col-3"><input type="text" name="exam_time[]" class="form-control border-danger"></div><div class="col-4"><input type="text" name="exam_modules[]" class="form-control border-danger"></div><div class="col-1 text-end"><button type="button" class="btn btn-danger remove-btn">x</button></div></div>`;
    document.getElementById('exam-period-container').insertAdjacentHTML('beforeend', html);
}
function addShsatAboutItem() {
    const html = `<div class="border rounded p-3 mb-3 bg-white position-relative shadow-sm border-start border-info border-4"><button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 remove-btn">x</button><input type="text" name="shsat_about_title[]" class="form-control mb-2 fw-bold" placeholder="Heading"><textarea name="shsat_about_content[]" class="form-control" rows="4"></textarea></div>`;
    document.getElementById('shsat-about-container').insertAdjacentHTML('beforeend', html);
}
function addShsatBullet() {
    const html = `<div class="input-group mb-2 shadow-sm"><span class="input-group-text bg-white">•</span><input type="text" name="struct_bullets[]" class="form-control"><button type="button" class="btn btn-outline-danger remove-btn">x</button></div>`;
    document.getElementById('shsat-bullet-container').insertAdjacentHTML('beforeend', html);
}

// Global Remove Logic
document.addEventListener('click', function(e){
    if(e.target.closest('.remove-btn')){
        const target = e.target.closest('.row, .input-group, .table-data-row, .border, .col-md-4');
        if(target) target.remove();
    }
});


// --- ISEE Purpose Repeater ---
function addIseePurpose() {
    const html = `<div class="input-group mb-2 shadow-sm animate__animated animate__fadeIn">
        <input type="text" name="isee_purpose[]" class="form-control" placeholder="New purpose point...">
        <button type="button" class="btn btn-outline-danger remove-btn">x</button>
    </div>`;
    document.getElementById('isee-purpose-container').insertAdjacentHTML('beforeend', html);
}

// --- ISEE Structure Repeater ---
function addIseeStruct() {
    const html = `<div class="border rounded p-3 mb-2 bg-light position-relative animate__animated animate__fadeIn">
        <button type="button" class="btn btn-sm btn-link text-danger position-absolute top-0 end-0 m-1 remove-btn">Remove</button>
        <input type="text" name="isee_struct_name[]" class="form-control mb-2 fw-bold" placeholder="Level Name">
        <textarea name="isee_struct_desc[]" class="form-control small" rows="2" placeholder="Description"></textarea>
    </div>`;
    document.getElementById('isee-struct-container').insertAdjacentHTML('beforeend', html);
}

// --- ISEE Measure Repeater ---
function addIseeMeasure() {
    const html = `<div class="border rounded p-3 mb-2 bg-white border-start border-success border-4 shadow-sm position-relative animate__animated animate__fadeIn">
        <button type="button" class="btn btn-sm btn-link text-danger position-absolute top-0 end-0 m-1 remove-btn">Remove</button>
        <textarea name="isee_measure_item[]" class="form-control mb-2 fw-bold" rows="2" placeholder="Measure Item (Title/Link)"></textarea>
        <textarea name="isee_measure_desc[]" class="form-control small" rows="2" placeholder="Description"></textarea>
    </div>`;
    document.getElementById('isee-measure-container').insertAdjacentHTML('beforeend', html);
}

// --- ELA Administration Repeater ---
function addElaAdminPoint() {
    const html = `
    <div class="border rounded p-3 mb-2 bg-light position-relative animate__animated animate__fadeIn">
        <button type="button" class="btn btn-sm btn-link text-danger position-absolute top-0 end-0 m-1 remove-btn">Remove</button>
        <div class="mb-2">
            <input type="text" name="ela_admin_name[]" class="form-control fw-bold" placeholder="Title">
        </div>
        <textarea name="ela_admin_desc[]" class="form-control small" rows="2" placeholder="Description"></textarea>
    </div>`;
    document.getElementById('ela-admin-container').insertAdjacentHTML('beforeend', html);
}
function addScatVersion() {
    const html = `<div class="input-group mb-2 animate__animated animate__fadeIn">
        <input type="text" name="scat_versions[]" class="form-control" placeholder="Version">
        <button type="button" class="btn btn-outline-danger remove-btn text-danger">Remove</button>
    </div>`;
    document.getElementById('scat-versions-container').insertAdjacentHTML('beforeend', html);
}

function addScatSection() {
    const html = `<div class="border rounded p-3 mb-2 bg-light position-relative animate__animated animate__fadeIn">
        <button type="button" class="btn btn-sm btn-link text-danger position-absolute top-0 end-0 m-1 remove-btn">Remove</button>
        <input type="text" name="scat_sec_title[]" class="form-control mb-2 fw-bold" placeholder="Title">
        <textarea name="scat_sec_desc[]" class="form-control small" rows="2" placeholder="Description"></textarea>
    </div>`;
    document.getElementById('scat-sections-container').insertAdjacentHTML('beforeend', html);
}

function addScatLevel() {
    const html = `<div class="border rounded p-3 mb-2 bg-white shadow-sm position-relative animate__animated animate__fadeIn">
        <button type="button" class="btn btn-sm btn-link text-danger position-absolute top-0 end-0 m-1 remove-btn">Remove</button>
        <input type="text" name="scat_lvl_title[]" class="form-control mb-2 fw-bold" placeholder="Level Title">
        <textarea name="scat_lvl_details[]" class="form-control small" rows="2" placeholder="Details"></textarea>
    </div>`;
    document.getElementById('scat-scoring-container').insertAdjacentHTML('beforeend', html);
}

function addScatTip() {
    const html = `<div class="input-group mb-2 animate__animated animate__fadeIn">
        <input type="text" name="scat_tips[]" class="form-control" placeholder="Tip">
        <button type="button" class="btn btn-outline-danger remove-btn text-danger">Remove</button>
    </div>`;
    document.getElementById('scat-tips-container').insertAdjacentHTML('beforeend', html);
}

// AMC Participate Bullet Points
function addAmcPoint() {
    const html = `<div class="input-group mb-2 animate__animated animate__fadeIn">
        <span class="input-group-text">•</span>
        <input type="text" name="amc_points[]" class="form-control" placeholder="Bullet Point">
        <button type="button" class="btn btn-outline-danger remove-btn">x</button>
    </div>`;
    document.getElementById('amc-participate-container').insertAdjacentHTML('beforeend', html);
}

// AMC Competition Cards
function addAmcCard() {
    const html = `
    <div class="col-md-4 amc-card-item animate__animated animate__fadeIn">
        <div class="border rounded p-3 bg-white shadow-sm position-relative">
            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 remove-btn" style="padding: 2px 8px;">×</button>
            <label class="small fw-bold">Title</label>
            <input type="text" name="amc_card_title[]" class="form-control mb-2" placeholder="e.g. AMC 8">
            <label class="small fw-bold">amcDescription</label>
            <textarea name="amc_card_desc1[]" class="form-control mb-2 small" rows="3" placeholder="AMC Description"></textarea>
            <label class="small fw-bold">Description</label>
            <input type="text" name="amc_card_desc2[]" class="form-control mb-2" placeholder="25 questions...">
            <label class="small fw-bold">When</label>
            <input type="text" name="amc_card_when[]" class="form-control mb-2" placeholder="e.g. January annually">
            <label class="small fw-bold">Who</label>
            <input type="text" name="amc_card_who[]" class="form-control" placeholder="e.g. Students under 15">
        </div>
    </div>`;
    document.getElementById('amc-cards-container').insertAdjacentHTML('beforeend', html);
}


let ruleCounter = <?= isset($rules) ? count($rules) : 0 ?>;

function addKanFeature() {
    const html = `<div class="input-group mb-2 animate__animated animate__fadeIn">
        <input type="text" name="kan_features[]" class="form-control" placeholder="Feature text...">
        <button type="button" class="btn btn-outline-danger remove-btn">×</button>
    </div>`;
    document.getElementById('kan-features-container').insertAdjacentHTML('beforeend', html);
}

function addKanRule() {
    const html = `
    <div class="rule-block border rounded p-3 mb-3 bg-white shadow-sm position-relative animate__animated animate__fadeIn">
        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 remove-btn">×</button>
        <input type="text" name="kan_rule_main[]" class="form-control mb-2 fw-bold" placeholder="Rule Title (e.g. Levels correspond with...)">
        <div class="ms-4">
            <label class="small fw-bold text-muted">Subpoints:</label>
            <div class="subpoints-container"></div>
            <button type="button" class="btn btn-sm btn-link p-0 text-decoration-none" onclick="addKanSubpoint(this, ${ruleCounter})">+ Add Subpoint</button>
        </div>
    </div>`;
    document.getElementById('kan-rules-container').insertAdjacentHTML('beforeend', html);
    ruleCounter++;
}

function addKanSubpoint(btn, index) {
    const container = btn.previousElementSibling;
    const html = `<div class="input-group input-group-sm mb-1 animate__animated animate__fadeIn">
        <input type="text" name="kan_rule_sub_${index}[]" class="form-control" placeholder="Subpoint...">
        <button type="button" class="btn btn-outline-danger remove-btn">×</button>
    </div>`;
    container.insertAdjacentHTML('beforeend', html);
}

// ACT Section 2: About Items
function addActAboutItem() {
    const html = `
    <div class="border rounded p-3 mb-3 bg-white position-relative shadow-sm animate__animated animate__fadeIn">
        <button type="button" class="btn btn-sm btn-link text-danger position-absolute top-0 end-0 m-2 remove-btn" style="text-decoration:none;">✕ Remove</button>
        <input type="text" name="act_about_title[]" class="form-control mb-2 fw-bold" placeholder="Item Title">
        <textarea name="act_about_content[]" class="form-control small" rows="2" placeholder="Item Content..."></textarea>
    </div>`;
    document.getElementById('act-about-list-container').insertAdjacentHTML('beforeend', html);
}

// ACT Section 3: Additional Info
function addActAdditionalInfo() {
    const html = `
    <div class="border rounded p-3 mb-3 bg-light position-relative animate__animated animate__fadeIn">
        <button type="button" class="btn btn-sm btn-link text-danger position-absolute top-0 end-0 m-2 remove-btn" style="text-decoration:none;">✕ Remove</button>
        <input type="text" name="act_add_title[]" class="form-control mb-2 fw-bold" placeholder="Title">
        <textarea name="act_add_content[]" class="form-control small" rows="2" placeholder="Content..."></textarea>
    </div>`;
    document.getElementById('act-additional-container').insertAdjacentHTML('beforeend', html);
}

// ACT Section 4: Test Sections
function addActTestSection() {
    const html = `
    <div class="border rounded p-4 mb-3 bg-white position-relative border-start border-info border-4 shadow-sm animate__animated animate__fadeIn">
        <button type="button" class="btn btn-sm btn-link text-danger position-absolute top-0 end-0 m-2 remove-btn" style="text-decoration:none;">✕ Remove</button>
        <input type="text" name="act_ts_title[]" class="form-control mb-3 fw-bold bg-light" placeholder="Section Title">
        <textarea name="act_ts_desc[]" class="form-control" rows="5" placeholder="Detailed content..."></textarea>
    </div>`;
    document.getElementById('act-test-sections-container').insertAdjacentHTML('beforeend', html);
}

// CogAT Hero Bullets
function addCogatHeroBullet() {
    const html = `<div class="input-group mb-2"><input type="text" name="cogat_hero_bullets[]" class="form-control"><button type="button" class="btn btn-outline-danger remove-btn">×</button></div>`;
    document.getElementById('cogat-hero-bullets').insertAdjacentHTML('beforeend', html);
}

// CogAT Structure Table
function addCogatStructRow() {
    const html = `<div class="row g-2 mb-2 table-data-row"><div class="col-4"><input type="text" name="cogat_struct_v[]" class="form-control"></div><div class="col-4"><input type="text" name="cogat_struct_q[]" class="form-control"></div><div class="col-3"><input type="text" name="cogat_struct_n[]" class="form-control"></div><div class="col-1 text-end"><button type="button" class="btn btn-danger remove-btn">×</button></div></div>`;
    document.getElementById('cogat-struct-table').insertAdjacentHTML('beforeend', html);
}

// CogAT Levels Table
function addCogatLtRow() {
    const html = `<div class="row g-2 mb-2 table-data-row"><div class="col-3"><input type="text" name="cogat_lt_g[]" class="form-control"></div><div class="col-3"><input type="text" name="cogat_lt_l[]" class="form-control"></div><div class="col-3"><input type="text" name="cogat_lt_q[]" class="form-control"></div><div class="col-2"><input type="text" name="cogat_lt_t[]" class="form-control"></div><div class="col-1 text-end"><button type="button" class="btn btn-danger remove-btn">×</button></div></div>`;
    document.getElementById('cogat-lt-table').insertAdjacentHTML('beforeend', html);
}

// CogAT Batteries (v, nv, q)
function addCogatBattery(type) {
    const container = document.getElementById(`cogat-${type}-battery`);
    const html = `<div class="row g-2 mb-3 table-data-row border-bottom pb-2"><div class="col-4"><input type="text" name="cogat_${type}_t[]" class="form-control fw-bold"></div><div class="col-7"><textarea name="cogat_${type}_d[]" class="form-control small" rows="2"></textarea></div><div class="col-1"><button type="button" class="btn btn-outline-danger remove-btn">×</button></div></div>`;
    container.insertAdjacentHTML('beforeend', html);
}

// SBAC Assessment Points Repeater
function addSbacPoint() {
    const html = `
    <div class="border rounded p-3 mb-3 bg-white position-relative shadow-sm border-start border-info border-4 animate__animated animate__fadeIn">
        <button type="button" class="btn btn-sm btn-link text-danger position-absolute top-0 end-0 m-2 remove-btn" style="text-decoration:none;">✕ Remove</button>
        <div class="mb-2">
            <label class="small fw-bold">Point Title</label>
            <input type="text" name="sbac_pt_title[]" class="form-control" placeholder="Point Title">
        </div>
        <div>
            <label class="small fw-bold">Description</label>
            <textarea name="sbac_pt_desc[]" class="form-control small" rows="3"></textarea>
        </div>
    </div>`;
    document.getElementById('sbac-points-container').insertAdjacentHTML('beforeend', html);
}
// Accuplacer List 1: What's on Tests
function addAccuTestItem() {
    const html = `
    <div class="border rounded p-3 mb-3 bg-white position-relative shadow-sm border-start border-info border-4 animate__animated animate__fadeIn">
        <button type="button" class="btn btn-sm btn-link text-danger position-absolute top-0 end-0 m-2 remove-btn" style="text-decoration:none;">✕</button>
        <input type="text" name="accu_test_title[]" class="form-control mb-2 fw-bold" placeholder="Item Title">
        <textarea name="accu_test_desc[]" class="form-control small" rows="3" placeholder="Item Description"></textarea>
    </div>`;
    document.getElementById('accu-test-items-container').insertAdjacentHTML('beforeend', html);
}

// Accuplacer List 2: WritePlacer
function addAccuWriteItem() {
    const html = `
    <div class="border rounded p-3 mb-3 bg-light position-relative animate__animated animate__fadeIn">
        <button type="button" class="btn btn-sm btn-link text-danger position-absolute top-0 end-0 m-2 remove-btn" style="text-decoration:none;">✕</button>
        <input type="text" name="accu_write_title[]" class="form-control mb-2 fw-bold" placeholder="Item Title">
        <textarea name="accu_write_desc[]" class="form-control small" rows="2" placeholder="Item Description"></textarea>
    </div>`;
    document.getElementById('accu-write-items-container').insertAdjacentHTML('beforeend', html);
}

// Accuplacer List 3: ESL
function addAccuEslItem() {
    const html = `
    <div class="border rounded p-3 mb-3 bg-white position-relative shadow-sm animate__animated animate__fadeIn">
        <button type="button" class="btn btn-sm btn-link text-danger position-absolute top-0 end-0 m-2 remove-btn" style="text-decoration:none;">✕</button>
        <input type="text" name="accu_esl_title[]" class="form-control mb-2 fw-bold" placeholder="Item Title">
        <textarea name="accu_esl_desc[]" class="form-control small" rows="2" placeholder="Item Description"></textarea>
    </div>`;
    document.getElementById('accu-esl-items-container').insertAdjacentHTML('beforeend', html);
}
// STB Usage Points
function addStbUsagePoint() {
    const html = `<div class="input-group mb-2 animate__animated animate__fadeIn"><input type="text" name="stb_usage_points[]" class="form-control" placeholder="Enter point..."><button type="button" class="btn btn-outline-danger remove-btn">✕</button></div>`;
    document.getElementById('stb-usage-points-container').insertAdjacentHTML('beforeend', html);
}

// STB Subtest Cards
function addStbSubtest() {
    const html = `
    <div class="border rounded p-3 mb-3 bg-light position-relative shadow-sm animate__animated animate__fadeIn">
        <button type="button" class="btn btn-sm btn-link text-danger position-absolute top-0 end-0 m-1 remove-btn" style="text-decoration:none;">✕</button>
        <input type="text" name="stb_st_title[]" class="form-control mb-2 fw-bold" placeholder="Subtest Title">
        <textarea name="stb_st_desc[]" class="form-control small" rows="3" placeholder="Description..."></textarea>
    </div>`;
    document.getElementById('stb-subtests-container').insertAdjacentHTML('beforeend', html);
}

// STB Timing Table Row
function addStbTimingRow() {
    const html = `
    <div class="row g-2 mb-2 table-data-row align-items-center animate__animated animate__fadeIn">
        <div class="col-4"><input type="text" name="stb_time_s[]" class="form-control" placeholder="Subtest/Activity"></div>
        <div class="col-4"><input type="text" name="stb_time_t1[]" class="form-control" placeholder="Time"></div>
        <div class="col-3"><input type="text" name="stb_time_t2[]" class="form-control" placeholder="Time"></div>
        <div class="col-1 text-end"><button type="button" class="btn btn-sm btn-danger remove-btn">✕</button></div>
    </div>`;
    document.getElementById('stb-timing-table').insertAdjacentHTML('beforeend', html);
}


<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    var quill = new Quill('#quill-editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline'],
                [{ 'color': [] }],
                ['link'],
                ['clean']
            ]
        }
    });

    // Form submit hone se pehle Quill ka data hidden input mein daalna
    document.querySelector('form').onsubmit = function() {
        document.getElementById('ela_intro_desc_input').value = quill.root.innerHTML;
    };

    function addElaAdminPoint() {
        const html = `
        <div class="admin-point-block border rounded p-4 mb-3 bg-light position-relative shadow-sm animate__animated animate__fadeIn">
            <button type="button" class="btn btn-sm btn-link text-danger position-absolute top-0 end-0 m-2 remove-btn" style="text-decoration:none;">Remove</button>
            <input type="text" name="admin_pt_title[]" placeholder="Title" class="form-control mb-3 fw-bold border-0">
            <textarea name="admin_pt_desc[]" placeholder="Description" rows="2" class="form-control border-0"></textarea>
        </div>`;
        document.getElementById('ela-admin-points-container').insertAdjacentHTML('beforeend', html);
    }
</script>

</script>

<?php include 'includes/footer.php'; ?>