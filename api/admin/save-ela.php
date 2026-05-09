<?php
require_once __DIR__ . '/../../../functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $slug = 'ela';

    $admin_points = [];
    if(isset($_POST['admin_pt_title'])) {
        foreach($_POST['admin_pt_title'] as $k => $title) {
            if(!empty($title)) {
                $admin_points[] = [
                    'title' => $title,
                    'description' => $_POST['admin_pt_desc'][$k] ?? ''
                ];
            }
        }
    }

    try {
        $stmt = $conn->prepare("UPDATE test_preparation_data SET 
            hero_section = ?, 
            ela_intro_title = ?, 
            ela_intro_content = ?, 
            ela_admin_title = ?, 
            ela_admin_json = ? 
            WHERE test_slug = ?");
        
        $stmt->execute([
            json_encode($_POST['hero'] ?? []),
            $_POST['ela_intro_title'],
            $_POST['ela_intro_content'],
            $_POST['ela_admin_title'],
            json_encode($admin_points),
            $slug
        ]);

        header("Location: ../../../admin/manage-ela.php?success=1");
    } catch(PDOException $e) { die("Error: " . $e->getMessage()); }
}