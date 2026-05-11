<?php
// Path: admin/api/admin/save-math-amc.php
require_once __DIR__ . '/../../../functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $slug = $_POST['slug'] ?? 'math-amc';

    // 1. Hero Section (Title & Description)
    $hero = json_encode($_POST['hero'] ?? []);

    // 2. Participate List (Keys reset karke pure array banana)
    $participate_json = json_encode(array_values(array_filter($_POST['participation'] ?? [])));

    // 3. Why Take List (Keys reset karke pure array banana)
    $why_json = json_encode(array_values(array_filter($_POST['why_take'] ?? [])));

    // 4. Competitions Cards Logic
    $comps = [];
    if(isset($_POST['comp_title'])) {
        foreach($_POST['comp_title'] as $k => $title) {
            // Sirf wahi cards save karenge jinka Title bhara hua ho
            if(!empty($title)) {
                $comps[] = [
                    'title'       => $title,
                    'amc'         => $_POST['comp_amc_html'][$k] ?? '', // Quill Editor Content
                    'description' => $_POST['comp_desc'][$k] ?? '',     // Short Description
                    'for'         => $_POST['comp_for'][$k] ?? '',
                    'when'        => $_POST['comp_when'][$k] ?? ''
                ];
            }
        }
    }
    $comps_json = json_encode($comps);
    

    try {
        // UPSERT LOGIC: Insert karega agar slug naya hai, Update karega agar slug pehle se hai.
        $sql = "INSERT INTO test_preparation_data 
                (test_slug, hero_section, amc_participate_json, amc_why_json, amc_comp_json) 
                VALUES (?, ?, ?, ?, ?) 
                ON DUPLICATE KEY UPDATE 
                hero_section         = VALUES(hero_section), 
                amc_participate_json = VALUES(amc_participate_json), 
                amc_why_json         = VALUES(amc_why_json), 
                amc_comp_json        = VALUES(amc_comp_json)";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            $slug,
            $hero,
            $participate_json,
            $why_json,
            $comps_json
        ]);

        // Redirect back with success flag
        header("Location: ../../manage-math-amc.php?success=1");
        exit();

    } catch(PDOException $e) { 
        // Error handling for debugging
        die("Database Error: " . $e->getMessage()); 
    }
}