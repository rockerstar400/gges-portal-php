<?php
header('Content-Type: application/json');
require_once '../../functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $slug = $_POST['category_slug'];
    $title = $_POST['title'];
    $content = $_POST['content'] ?? []; // Raw form data

    // ======================================================================
    // 🟠 STEP 1: SPECIFIC MAPPING (Array of Inputs to Array of Objects)
    // ======================================================================

    // 1. Math Algebra
    if ($slug == 'math-algebra') {
        $chapters = [];
        $names = $_POST['content']['chapters']['name'] ?? [];
        for ($i = 0; $i < count($names); $i++) {
            $chapters[] = ['name' => $_POST['content']['chapters']['name'][$i], 'desc' => $_POST['content']['chapters']['desc'][$i]];
        }
        $content['chapters'] = $chapters;
    }

    // 2. Math AMC
    elseif ($slug == 'math-amc') {
        $competitions = [];
        $names = $_POST['content']['competitions']['name'] ?? [];
        for ($i = 0; $i < count($names); $i++) {
            $competitions[] = [
                'name'       => $_POST['content']['competitions']['name'][$i] ?? '',
                'desc_rich'  => $_POST['content']['competitions']['desc_rich'][$i] ?? '',
                'desc_plain' => $_POST['content']['competitions']['desc_plain'][$i] ?? '',
                'for'        => $_POST['content']['competitions']['for'][$i] ?? '',
                'when'       => $_POST['content']['competitions']['when'][$i] ?? ''
            ];
        }
        $content['competitions'] = $competitions;
    }

    // 3. English About ELA
    elseif ($slug == 'eng-about-ela') {
        $qTypes = [];
        $qTitles = $_POST['content']['question_types']['title'] ?? [];
        for ($i = 0; $i < count($qTitles); $i++) {
            $qTypes[] = ['title' => $_POST['content']['question_types']['title'][$i], 'desc'  => $_POST['content']['question_types']['desc'][$i]];
        }
        $content['question_types'] = $qTypes;
    }

    // 4. English About ISEE
    elseif ($slug == 'eng-about-isee') {
        $structures = [];
        $headings = $_POST['content']['test_structures']['heading'] ?? [];
        for ($i = 0; $i < count($headings); $i++) {
            $structures[] = ['heading' => $_POST['content']['test_structures']['heading'][$i], 'desc' => $_POST['content']['test_structures']['desc'][$i]];
        }
        $content['test_structures'] = $structures;
        // Keep Titles and Purposes as they are (simple arrays)
    }

    // 5. English Registration
    elseif ($slug == 'eng-registration') {
        $regItems = [];
        $richTexts = $_POST['content']['reg_items']['rich'] ?? [];
        for ($i = 0; $i < count($richTexts); $i++) {
            $regItems[] = ['rich' => $_POST['content']['reg_items']['rich'][$i], 'plain' => $_POST['content']['reg_items']['plain'][$i]];
        }
        $content['reg_items'] = $regItems;
    }

    // ======================================================================
    // 🟢 STEP 2: SAVE TO DATABASE (ONE TIME PROCESS)
    // ======================================================================
    
    // Yahan sirf ek baar encode hoga saara mapping khatam hone ke baad
    $jsonContent = json_encode($content);

    global $conn;
    try {
        $stmt = $conn->prepare("INSERT INTO course_sections (category_slug, title, content_json) 
                                VALUES (?, ?, ?) 
                                ON DUPLICATE KEY UPDATE title = VALUES(title), content_json = VALUES(content_json)");
        
        if ($stmt->execute([$slug, $title, $jsonContent])) {
            header("Location: ../../admin/manage-course.php?type=$slug&status=success");
        } else {
            header("Location: ../../admin/manage-course.php?type=$slug&status=error");
        }
    } catch (PDOException $e) {
        echo "Database Error: " . $e->getMessage();
    }
    exit();
}