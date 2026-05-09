<?php
require_once __DIR__ . '/../../../functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $slug = 'isee';

    $struct = [];
    if(isset($_POST['struct_title'])) {
        foreach($_POST['struct_title'] as $k => $v) {
            if(!empty($v)) $struct[] = ['title' => $v, 'description' => $_POST['struct_desc'][$k]];
        }
    }

    $measure = [];
    if(isset($_POST['measure_title'])) {
        foreach($_POST['measure_title'] as $k => $v) {
            if(!empty($v)) $measure[] = ['title' => $v, 'description' => $_POST['measure_desc'][$k]];
        }
    }

    try {
        $stmt = $conn->prepare("UPDATE test_preparation_data SET 
            isee_hero_title = ?, isee_hero_desc = ?, 
            isee_about_heading = ?, isee_about_desc = ?, 
            isee_purpose_heading = ?, isee_purpose_json = ?, 
            isee_structure_heading = ?, isee_structure_json = ?, 
            isee_measure_heading = ?, isee_measure_json = ?, 
            isee_registration_heading = ?, isee_registration_desc = ? 
            WHERE test_slug = ?");
        
        $stmt->execute([
            $_POST['isee_hero_title'], $_POST['isee_hero_desc'],
            $_POST['isee_about_heading'], $_POST['isee_about_desc'],
            $_POST['isee_purpose_heading'], json_encode($_POST['purpose_points'] ?? []),
            $_POST['isee_structure_heading'], json_encode($struct),
            $_POST['isee_measure_heading'], json_encode($measure),
            $_POST['isee_registration_heading'], $_POST['isee_registration_desc'],
            $slug
        ]);

        header("Location: ../../../admin/manage-isee.php?success=1");
    } catch(PDOException $e) { die("Error: " . $e->getMessage()); }
}