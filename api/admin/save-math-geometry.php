<?php
require_once __DIR__ . '/../../../functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $slug = $_POST['slug'] ?? 'math-geometry';
    $title = $_POST['title'] ?? '';
    $desc = $_POST['description'] ?? '';
    $subjectDesc = $_POST['subjectDescription'] ?? '';
    
    // Process Array (Filter out empty inputs)
    $chapters = array_values(array_filter($_POST['chapter_names'] ?? []));
    $chapters_json = json_encode($chapters);

    try {
        // UPSERT Logic
        $sql = "INSERT INTO test_preparation_data (test_slug, geometry_title, geometry_desc, geometry_subject_desc, geometry_chapters_json) 
                VALUES (?, ?, ?, ?, ?) 
                ON DUPLICATE KEY UPDATE 
                geometry_title = VALUES(geometry_title), 
                geometry_desc = VALUES(geometry_desc),
                geometry_subject_desc = VALUES(geometry_subject_desc),
                geometry_chapters_json = VALUES(geometry_chapters_json)";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute([$slug, $title, $desc, $subjectDesc, $chapters_json]);

        header("Location: ../../../admin/manage-math-geometry.php?success=1");
        exit();
    } catch(PDOException $e) { 
        die("Database Error: " . $e->getMessage()); 
    }
}