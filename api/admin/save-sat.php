<?php
require_once __DIR__ . '/../../functions.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $slug = 'sat'; 
    $hero = json_encode($_POST['hero'] ?? []);
    $about = json_encode($_POST['about'] ?? []);
    $features = json_encode($_POST['features'] ?? []);
    
    $table_data = [];
    if(isset($_POST['table_name'])) {
        foreach($_POST['table_name'] as $k => $val) {
            if(!empty($val)) $table_data[] = ['name' => $val, 'time' => $_POST['table_time'][$k], 'modules' => $_POST['table_modules'][$k]];
        }
    }

    try {
        $stmt = $conn->prepare("UPDATE test_preparation_data SET 
            hero_section = ?, about_section = ?, features_json = ?, table_data_json = ?, footer_note = ? 
            WHERE test_slug = ?");
        $stmt->execute([$hero, $about, $features, json_encode($table_data), $_POST['footer_note'], $slug]);
        
        header("Location: ../../admin/manage-sat.php?success=1");
    } catch(PDOException $e) { die($e->getMessage()); }
}