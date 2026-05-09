<?php
require_once __DIR__ . '/../../../functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $slug = 'kangaroo';

    // 1. Process Features
    $features = json_encode(array_filter($_POST['features'] ?? []));

    // 2. Process Nested Rules
    $rules = [];
    if (isset($_POST['rule_text'])) {
        foreach ($_POST['rule_text'] as $k => $text) {
            // Hum index nikalenge jo frontend ne 'data-index' mein bheja tha
            // Note: PHP normally values line se leta hai, toh humein manual matching karni padegi
            // Form ke inputs rule_subs_0[], rule_subs_1[] format mein hain.
            
            $subKey = "rule_subs_" . $k;
            $rules[] = [
                'text' => $text,
                'subpoints' => array_filter($_POST[$subKey] ?? [])
            ];
        }
    }
    $rules_json = json_encode($rules);

    try {
        $stmt = $conn->prepare("UPDATE test_preparation_data SET 
            hero_section = ?, 
            kan_struct_heading = ?, kan_struct_desc = ?, 
            kan_feat_heading = ?, kan_feat_json = ?, 
            kan_rules_heading = ?, kan_rules_json = ?, 
            kan_score_heading = ?, kan_score_desc = ? 
            WHERE test_slug = ?");
        
        $stmt->execute([
            json_encode($_POST['hero'] ?? []),
            $_POST['kan_struct_heading'], $_POST['kan_struct_desc'],
            $_POST['kan_feat_heading'], $features,
            $_POST['kan_rules_heading'], $rules_json,
            $_POST['kan_score_heading'], $_POST['kan_score_desc'],
            $slug
        ]);

        header("Location: ../../../admin/manage-kangaroo.php?success=1");
    } catch (PDOException $e) { die("Error: " . $e->getMessage()); }
}