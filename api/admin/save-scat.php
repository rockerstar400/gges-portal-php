<?php
require_once __DIR__ . '/../../../functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $slug = 'scat';

    // Helper to bundle objects
    function bundle($titles, $descField, $descValues) {
        $data = [];
        if(isset($titles)) {
            foreach($titles as $k => $v) {
                if(!empty($v)) $data[] = ['title' => $v, $descField => $descValues[$k]];
            }
        }
        return json_encode($data);
    }

    $format_json = bundle($_POST['format_sec_title'], 'description', $_POST['format_sec_desc']);
    $scoring_json = bundle($_POST['score_lvl_title'], 'details', $_POST['score_lvl_details']);
    $versions_json = json_encode(array_filter($_POST['versions'] ?? []));
    $tips_json = json_encode(array_filter($_POST['tips'] ?? []));

    try {
        $stmt = $conn->prepare("UPDATE test_preparation_data SET 
            scat_hero_title = ?, scat_hero_desc = ?, 
            scat_about_heading = ?, scat_about_desc = ?, 
            scat_versions_heading = ?, scat_versions_json = ?, 
            scat_format_heading = ?, scat_format_desc = ?, 
            scat_format_sections_json = ?, scat_scoring_heading_html = ?, 
            scat_scoring_levels_json = ?, scat_tips_heading = ?, 
            scat_tips_json = ?, scat_register_heading = ?, 
            scat_register_subheading = ?, scat_register_contact_html = ?, 
            scat_auth_heading = ?, scat_auth_desc_html = ? 
            WHERE test_slug = ?");
        
        $stmt->execute([
            $_POST['scat_hero_title'], $_POST['scat_hero_desc'],
            $_POST['scat_about_heading'], $_POST['scat_about_desc'],
            $_POST['scat_versions_heading'], $versions_json,
            $_POST['scat_format_heading'], $_POST['scat_format_desc'],
            $format_json, $_POST['scat_scoring_heading_html'],
            $scoring_json, $_POST['scat_tips_heading'],
            $tips_json, $_POST['scat_register_heading'],
            $_POST['scat_register_subheading'], $_POST['scat_register_contact_html'],
            $_POST['scat_auth_heading'], $_POST['scat_auth_desc_html'],
            $slug
        ]);

        header("Location: ../../../admin/manage-scat.php?success=1");
    } catch(PDOException $e) { die("Error: " . $e->getMessage()); }
}