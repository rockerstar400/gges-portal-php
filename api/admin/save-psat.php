<?php
require_once __DIR__ . '/../../../functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $slug = 'psat';

    // 1. Basic bundling
    $hero = json_encode($_POST['hero'] ?? []);
    $about = json_encode($_POST['about'] ?? []);
    $features = json_encode(array_filter($_POST['features'] ?? []));
    
    // 2. Structure Table bundling
    $tableData = [];
    if(isset($_POST['table_name'])) {
        foreach($_POST['table_name'] as $k => $val) {
            if(!empty($val)) {
                $tableData[] = [
                    'name' => $val,
                    'time' => $_POST['table_time'][$k] ?? '',
                    'modules' => $_POST['table_modules'][$k] ?? ''
                ];
            }
        }
    }

    // 3. Exam Period Table bundling
    $examPeriod = [];
    if(isset($_POST['exam_name'])) {
        foreach($_POST['exam_name'] as $k => $val) {
            if(!empty($val)) {
                $examPeriod[] = [
                    'name' => $val,
                    'time' => $_POST['exam_time'][$k] ?? '',
                    'modules' => $_POST['exam_modules'][$k] ?? ''
                ];
            }
        }
    }

    try {
        $stmt = $conn->prepare("UPDATE test_preparation_data SET 
            hero_section = ?, 
            about_section = ?, 
            features_json = ?, 
            table_data_json = ?, 
            exam_period_json = ?, 
            footer_note = ? 
            WHERE test_slug = ?");
        
        $stmt->execute([
            $hero, 
            $about, 
            $features, 
            json_encode($tableData), 
            json_encode($examPeriod),
            $_POST['footer_note'], 
            $slug
        ]);

        header("Location: ../../../admin/manage-psat.php?success=1");
    } catch(PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}