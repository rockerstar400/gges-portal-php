<?php
if (file_exists(__DIR__ . '/../../functions.php')) { require_once __DIR__ . '/../../functions.php'; } else { require_once __DIR__ . '/../../../functions.php'; }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $slug = $_POST['slug'] ?? 'math-common-core';
    
    // 1. Title handle karna
    $hero = json_encode(['title' => $_POST['title']]);
    
    // 2. Multiple descriptions ko array filter karke JSON banana
    $descriptions = array_filter($_POST['descriptions'] ?? []);
    $about_json = json_encode(array_values($descriptions)); 

    try {
        // UPSERT LOGIC
        $sql = "INSERT INTO test_preparation_data (test_slug, hero_section, about_section) 
                VALUES (?, ?, ?) 
                ON DUPLICATE KEY UPDATE 
                hero_section = VALUES(hero_section), 
                about_section = VALUES(about_section)";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute([$slug, $hero, $about_json]);

        header("Location: ../../../admin/manage-math-common.php?success=1");
        exit();
    } catch(PDOException $e) { 
        die("Database Error: " . $e->getMessage()); 
    }
}