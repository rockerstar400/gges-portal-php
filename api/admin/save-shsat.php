<?php
require_once __DIR__ . '/../../../functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $slug = 'shsat';

    // 1. Basic Bundling
    $hero = json_encode($_POST['hero'] ?? []);
    
    // 2. About Items Bundling (Heading + Quill Content)
    $items = [];
    if(isset($_POST['about_titles'])) {
        foreach($_POST['about_titles'] as $k => $val) {
            if(!empty($val)) {
                $items[] = [
                    'title' => $val,
                    'content' => $_POST['about_contents'][$k] ?? ''
                ];
            }
        }
    }
    $about_json = json_encode(['items' => $items]);

    // 3. Test Structure Bundling
    $struct_json = json_encode([
        'title' => $_POST['struct']['title'] ?? '',
        'bullets' => array_filter($_POST['struct_bullets'] ?? [])
    ]);

    try {
        $stmt = $conn->prepare("UPDATE test_preparation_data SET 
            hero_section = ?, 
            about_section = ?, 
            test_structure = ? 
            WHERE test_slug = ?");
        
        $stmt->execute([$hero, $about_json, $struct_json, $slug]);

        header("Location: ../../../admin/manage-shsat.php?success=1");
    } catch(PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}