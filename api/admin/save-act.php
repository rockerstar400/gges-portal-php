<?php
require_once __DIR__ . '/../../../functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $slug = 'act';

    // Helper to bundle list items
    function bundleList($titles, $descs) {
        $data = [];
        if (isset($titles)) {
            foreach ($titles as $k => $v) {
                if (!empty($v) || !empty($descs[$k])) {
                    $data[] = ['title' => $v, 'description' => $descs[$k]];
                }
            }
        }
        return json_encode($data);
    }

    $about_json = bundleList($_POST['about_titles'], $_POST['about_descs']);
    $add_json = bundleList($_POST['add_titles'], $_POST['add_descs']);
    $act_json = bundleList($_POST['act_titles'], $_POST['act_descs']);

    try {
        $stmt = $conn->prepare("UPDATE test_preparation_data SET 
            hero_section = ?, 
            about_section = ?, 
            act_about_json = ?, 
            act_additional_heading = ?, 
            act_additional_json = ?, 
            act_test_sections_heading = ?, 
            act_test_sections_json = ? 
            WHERE test_slug = ?");
        
        $stmt->execute([
            json_encode($_POST['hero'] ?? []),
            json_encode($_POST['about'] ?? []),
            $about_json,
            $_POST['act_additional_heading'],
            $add_json,
            $_POST['act_test_sections_heading'],
            $act_json,
            $slug
        ]);

        header("Location: ../../../admin/manage-act.php?success=1");
    } catch (PDOException $e) { die("Error: " . $e->getMessage()); }
}