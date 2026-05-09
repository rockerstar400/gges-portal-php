<?php
require_once __DIR__ . '/../../../functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $slug = $_POST['slug'];
    
    // Existing data fetch to keep old image if no new one uploaded
    $existing = $conn->query("SELECT eng_lang_image FROM test_preparation_data WHERE test_slug = '$slug'")->fetch(PDO::FETCH_ASSOC);

    // Image Handling
    $imagePath = $existing['eng_lang_image'] ?? '';
    if(!empty($_FILES['image']['name'])) {
        $imagePath = uploadFile($_FILES['image']); // Common upload function
    }

    try {
        $sql = "INSERT INTO test_preparation_data 
            (test_slug, eng_lang_heading, eng_lang_desc, eng_lang_prop1, eng_lang_prop2, eng_lang_prop3, eng_lang_prop4, eng_lang_prop5, eng_lang_image) 
            VALUES (?,?,?,?,?,?,?,?,?) 
            ON DUPLICATE KEY UPDATE 
            eng_lang_heading=VALUES(eng_lang_heading), 
            eng_lang_desc=VALUES(eng_lang_desc),
            eng_lang_prop1=VALUES(eng_lang_prop1),
            eng_lang_prop2=VALUES(eng_lang_prop2),
            eng_lang_prop3=VALUES(eng_lang_prop3),
            eng_lang_prop4=VALUES(eng_lang_prop4),
            eng_lang_prop5=VALUES(eng_lang_prop5),
            eng_lang_image=VALUES(eng_lang_image)";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            $slug,
            $_POST['heading'],
            $_POST['description'],
            $_POST['property1'],
            $_POST['property2'],
            $_POST['property3'],
            $_POST['property4'],
            $_POST['property5'],
            $imagePath
        ]);

        header("Location: ../../manage-eng-common.php?success=1");
        exit();
    } catch(PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}