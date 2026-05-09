<?php
require_once __DIR__ . '/../../../functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $slug = 'stb';

    // 1. Process Subtests
    $subtests_arr = [];
    if (isset($_POST['st_title'])) {
        foreach ($_POST['st_title'] as $k => $title) {
            if (!empty($title)) $subtests_arr[] = ['title' => $title, 'content' => $_POST['st_content'][$k]];
        }
    }

    // 2. Process Timing Table
    $timing_arr = [];
    if (isset($_POST['row_activity'])) {
        foreach ($_POST['row_activity'] as $k => $act) {
            if (!empty($act)) $timing_arr[] = ['activity' => $act, 'time5th6th' => $_POST['row_56'][$k], 'time7thPlus' => $_POST['row_7plus'][$k]];
        }
    }

    try {
        $stmt = $conn->prepare("UPDATE test_preparation_data SET 
            hero_section = ?, stb_about_h = ?, stb_about_desc_html = ?, 
            stb_used_desc = ?, stb_subset_points_json = ?, stb_subset_desc = ?, 
            stb_subtest_heading = ?, stb_subtests_json = ?, stb_info_h = ?, 
            stb_info_desc = ?, stb_timing_json = ? 
            WHERE test_slug = ?");
        
        $stmt->execute([
            json_encode(['title' => $_POST['hero_title'], 'description' => $_POST['hero_description']]),
            $_POST['stb_about_h'], $_POST['stb_about_desc_html'],
            $_POST['stb_used_desc'], json_encode($_POST['stb_subset_points'] ?? []),
            $_POST['stb_subset_desc'], $_POST['stb_subtest_heading'],
            json_encode($subtests_arr), $_POST['stb_info_h'],
            $_POST['stb_info_desc'], json_encode($timing_arr), $slug
        ]);

        header("Location: ../../../admin/manage-stb.php?success=1");
    } catch (PDOException $e) { die("Database Error: " . $e->getMessage()); }
}