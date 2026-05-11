<?php
if (file_exists(__DIR__ . '/../../functions.php')) { require_once __DIR__ . '/../../functions.php'; } else { require_once __DIR__ . '/../../../functions.php'; }

// 1. Handle Delete
if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    try {
        $stmt = $conn->prepare("SELECT image FROM why_choose WHERE id = ?");
        $stmt->execute([$id]);
        $res = $stmt->fetch();
        if($res && file_exists("../../../".$res['image'])) @unlink("../../../".$res['image']);

        $conn->prepare("DELETE FROM why_choose WHERE id = ?")->execute([$id]);
        header("Location: ../../manage-why-choose.php?success=deleted");
    } catch(PDOException $e) { die($e->getMessage()); }
    exit;
}

// 2. Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? '';
    $title = $_POST['title'];
    $description = $_POST['description'];
    
    // Image Upload Logic
    $imagePath = null;
    if(!empty($_FILES['image']['name'])) {
        $imagePath = uploadFile($_FILES['image']);
    }

    try {
        if(!empty($id)) {
            // Edit
            if($imagePath) {
                $sql = "UPDATE why_choose SET title=?, description=?, image=? WHERE id=?";
                $params = [$title, $description, $imagePath, $id];
            } else {
                $sql = "UPDATE why_choose SET title=?, description=? WHERE id=?";
                $params = [$title, $description, $id];
            }
        } else {
            // Add
            $sql = "INSERT INTO why_choose (title, description, image) VALUES (?,?,?)";
            $params = [$title, $description, $imagePath];
        }

        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        header("Location: ../../manage-why-choose.php?success=1");
    } catch(PDOException $e) { die($e->getMessage()); }
}