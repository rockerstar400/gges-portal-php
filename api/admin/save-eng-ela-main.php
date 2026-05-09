<?php
require_once __DIR__ . '/../../../functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $slug = $_POST['slug'] ?? 'eng-core-ela';
    
    // Array processing
    $descriptions = array_filter($_POST['core_descriptions'] ?? []);
    $core_json = json_encode(array_values($descriptions)); 
    $cover = $_POST['cover_description'] ?? '';

    try {
        // UPSERT LOGIC: Agar slug hai toh update, warna insert
        $sql = "INSERT INTO test_preparation_data (test_slug, ela_core_desc_json, ela_cover_desc) 
                VALUES (?, ?, ?) 
                ON DUPLICATE KEY UPDATE 
                ela_core_desc_json = VALUES(ela_core_desc_json), 
                ela_cover_desc = VALUES(ela_cover_desc)";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute([$slug, $core_json, $cover]);

        header("Location: ../../../admin/manage-eng-ela.php?success=1");
        exit();
    } catch(PDOException $e) { 
        die("Database Error: " . $e->getMessage()); 
    }
}