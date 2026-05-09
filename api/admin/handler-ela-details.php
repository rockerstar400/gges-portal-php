<?php
require_once __DIR__ . '/../../../functions.php';

// DELETE logic
if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    // Delete image file first
    $item = $conn->query("SELECT image FROM core_ela_details WHERE id=$id")->fetch();
    if($item && file_exists("../../../".$item['image'])) @unlink("../../../".$item['image']);
    
    $conn->prepare("DELETE FROM core_ela_details WHERE id=?")->execute([$id]);
    header("Location: ../../../admin/manage-eng-ela.php?success=deleted");
    exit;
}

// POST logic (Add/Edit)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $image = !empty($_FILES['image']['name']) ? uploadFile($_FILES['image']) : null;

    if(!empty($id)) {
        // EDIT
        if($image) {
            $stmt = $conn->prepare("UPDATE core_ela_details SET title=?, image=? WHERE id=?");
            $stmt->execute([$title, $image, $id]);
        } else {
            $stmt = $conn->prepare("UPDATE core_ela_details SET title=? WHERE id=?");
            $stmt->execute([$title, $id]);
        }
    } else {
        // ADD
        $stmt = $conn->prepare("INSERT INTO core_ela_details (title, image) VALUES (?,?)");
        $stmt->execute([$title, $image]);
    }
    header("Location: ../../../admin/manage-eng-ela.php?success=1");
}