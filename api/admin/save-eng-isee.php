<?php
// Path: admin/api/admin/save-eng-isee.php
require_once __DIR__ . '/../../../functions.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $slug = $_POST['slug'] ?? 'eng-about-isee';

    // 1. Simple Arrays (Title aur Purpose)
    $titles = json_encode(array_values(array_filter($_POST['isee_titles'] ?? [])));
    $purposes = json_encode(array_values(array_filter($_POST['isee_purposes'] ?? [])));

    // 2. Object Array (Structure)
    $structData = [];
    if(isset($_POST['struct_heading'])) {
        foreach($_POST['struct_heading'] as $k => $head) {
            if(!empty($head)) {
                $structData[] = [
                    'heading' => $head,
                    'description' => $_POST['struct_desc'][$k] ?? ''
                ];
            }
        }
    }
    $struct_json = json_encode($structData);

    try {
        // SQL: Hamari test_preparation_data table use hogi
        $sql = "INSERT INTO test_preparation_data (test_slug, about_isee_title_json, about_isee_purpose_json, about_isee_struct_json) 
                VALUES (?, ?, ?, ?) 
                ON DUPLICATE KEY UPDATE 
                about_isee_title_json = VALUES(about_isee_title_json), 
                about_isee_purpose_json = VALUES(about_isee_purpose_json), 
                about_isee_struct_json = VALUES(about_isee_struct_json)";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute([$slug, $titles, $purposes, $struct_json]);

        // FIX: Redirect back to your specific file name
        header("Location: ../../manage-eng-isee.php?success=1");
        exit();
    } catch(PDOException $e) { 
        die("Database Error: " . $e->getMessage()); 
    }
}