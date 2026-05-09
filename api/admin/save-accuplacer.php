<?php
require_once __DIR__ . '/../../../functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $slug = 'accuplacer';

    // Helper function to bundle repeaters
    function bundle($titles, $descs) {
        $data = [];
        if(isset($titles)) {
            foreach($titles as $k => $v) {
                if(!empty($v)) $data[] = ['title' => $v, 'description' => $descs[$k]];
            }
        }
        return json_encode($data);
    }

    $test_json  = bundle($_POST['test_title'], $_POST['test_description']);
    $write_json = bundle($_POST['write_title'], $_POST['write_description']);
    $esl_json   = bundle($_POST['esl_title'], $_POST['esl_description']);

    try {
        $stmt = $conn->prepare("UPDATE test_preparation_data SET 
            accu_hero_title = ?, accu_hero_desc = ?, 
            accu_about_heading = ?, accu_about_desc = ?, 
            accu_whats_heading = ?, accu_whats_desc = ?, 
            accu_test_list_json = ?, accu_write_desc_html = ?, 
            accu_write_list_json = ?, accu_esl_desc_html = ?, 
            accu_esl_list_json = ? 
            WHERE test_slug = ?");
        
        $stmt->execute([
            $_POST['accu_hero_title'], $_POST['accu_hero_desc'],
            $_POST['accu_about_heading'], $_POST['accu_about_desc'],
            $_POST['accu_whats_heading'], $_POST['accu_whats_desc'],
            $test_json, $_POST['accu_write_desc_html'],
            $write_json, $_POST['accu_esl_desc_html'],
            $esl_json, $slug
        ]);

        header("Location: ../../../admin/manage-accuplacer.php?success=1");
    } catch (PDOException $e) { die("Database Error: " . $e->getMessage()); }
}