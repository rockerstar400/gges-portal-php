<?php
require_once __DIR__ . '/../../../functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $slug = 'sbac';

    // 1. Process Assessment Points Repeater
    $points = [];
    if (isset($_POST['point_title'])) {
        foreach ($_POST['point_title'] as $k => $title) {
            if (!empty($title)) {
                $points[] = [
                    'title' => $title,
                    'description' => $_POST['point_description'][$k] ?? ''
                ];
            }
        }
    }
    $points_json = json_encode($points);

    try {
        $stmt = $conn->prepare("UPDATE test_preparation_data SET 
            sbac_hero_title = ?, 
            sbac_hero_desc_html = ?, 
            sbac_about_heading = ?, 
            sbac_about_desc = ?, 
            sbac_assess_heading = ?, 
            sbac_assess_desc = ?, 
            sbac_assess_points_json = ? 
            WHERE test_slug = ?");
        
        $stmt->execute([
            $_POST['sbac_hero_title'],
            $_POST['sbac_hero_desc_html'],
            $_POST['sbac_about_heading'],
            $_POST['sbac_about_desc'],
            $_POST['sbac_assess_heading'],
            $_POST['sbac_assess_desc'],
            $points_json,
            $slug
        ]);

        header("Location: ../../../admin/manage-sbac.php?success=1");
    } catch (PDOException $e) { die("Database Error: " . $e->getMessage()); }
}