<?php
require_once __DIR__ . '/../../../functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 1. Basic Fields
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    
    // 2. Dynamic Arrays (Subject Expertise)
    $title1 = $_POST['title1'] ?? '';
    $desc1  = json_encode($_POST['description1'] ?? []);
    
    $title2 = $_POST['title2'] ?? '';
    $desc2  = json_encode($_POST['description2'] ?? []);
    
    $title3 = $_POST['title3'] ?? '';
    $desc3  = json_encode($_POST['description3'] ?? []);

    // 3. Existing Data Fetch (For Image Retention)
    $existing = $conn->query("SELECT * FROM k12_services LIMIT 1")->fetch(PDO::FETCH_ASSOC);

    // 4. Image Upload Logic
    function handleK12Upload($file, $oldPath) {
        if (!empty($file['name'])) {
            // Purani image delete karna (optional)
            if ($oldPath && file_exists("../../../" . $oldPath)) {
                @unlink("../../../" . $oldPath);
            }
            return uploadFile($file); // functions.php wala function
        }
        return $oldPath;
    }

    $img  = handleK12Upload($_FILES['image'],  $existing['image'] ?? null);
    $img1 = handleK12Upload($_FILES['image1'], $existing['image1'] ?? null);
    $img2 = handleK12Upload($_FILES['image2'], $existing['image2'] ?? null);
    $img3 = handleK12Upload($_FILES['image3'], $existing['image3'] ?? null);

    try {
        if ($existing) {
            $sql = "UPDATE k12_services SET 
                    title=?, description=?, image=?, 
                    title1=?, description1=?, image1=?, 
                    title2=?, description2=?, image2=?, 
                    title3=?, description3=?, image3=? 
                    WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$title, $description, $img, $title1, $desc1, $img1, $title2, $desc2, $img2, $title3, $desc3, $img3, $existing['id']]);
        } else {
            $sql = "INSERT INTO k12_services (title, description, image, title1, description1, image1, title2, description2, image2, title3, description3, image3) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$title, $description, $img, $title1, $desc1, $img1, $title2, $desc2, $img2, $title3, $desc3, $img3]);
        }
        header("Location: ../../manage-k12.php?tab=service&success=1");
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}