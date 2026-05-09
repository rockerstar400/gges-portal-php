<?php
require_once __DIR__ . '/../../../functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect all data
    $title = $_POST['title'];
    $description = $_POST['description'];
    
    // Arrays to JSON
    $desc1 = json_encode(array_filter($_POST['description1'] ?? []));
    $desc2 = json_encode(array_filter($_POST['description2'] ?? []));
    $desc3 = json_encode(array_filter($_POST['description3'] ?? []));

    // Handle 4 Images
    $images = [];
    $imgKeys = ['image', 'image1', 'image2', 'image3'];
    foreach($imgKeys as $k) {
        $path = null;
        if(!empty($_FILES[$k]['name'])) {
            $path = uploadFile($_FILES[$k]); // Using your functions.php helper
        }
        $images[$k] = $path;
    }

    try {
        // Simple UPSERT logic (Insert or Update if exists)
        $check = $conn->query("SELECT id FROM k12_services LIMIT 1")->fetch();
        
        if($check) {
            $sql = "UPDATE k12_services SET title=?, description=?, title1=?, description1=?, title2=?, description2=?, title3=?, description3=?";
            $params = [$title, $description, $_POST['title1'], $desc1, $_POST['title2'], $desc2, $_POST['title3'], $desc3];
            
            // Only update images if new ones uploaded
            foreach($imgKeys as $k) {
                if($images[$k]) { $sql .= ", $k='{$images[$k]}'"; }
            }
            $sql .= " WHERE id=" . $check['id'];
            $stmt = $conn->prepare($sql);
            $stmt->execute($params);
        } else {
            $stmt = $conn->prepare("INSERT INTO k12_services (title, description, image, title1, description1, image1, title2, description2, image2, title3, description3, image3) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->execute([$title, $description, $images['image'], $_POST['title1'], $desc1, $images['image1'], $_POST['title2'], $desc2, $images['image2'], $_POST['title3'], $desc3, $images['image3']]);
        }

        header("Location: ../../../admin/manage-k12.php?success=1");
    } catch(PDOException $e) { die($e->getMessage()); }
}