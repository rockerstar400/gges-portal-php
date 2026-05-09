<?php
header('Content-Type: application/json');
require_once '../../functions.php';

$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'save_detail') {
    $id = $_POST['id'] ?? null;
    $title = $_POST['title'];
    $slug = $_POST['category_slug'];
    $file = $_FILES['image'];

    global $conn;
    $imagePath = null;
    if ($id) {
        $stmt = $conn->prepare("SELECT image FROM english_details WHERE id = ?");
        $stmt->execute([$id]);
        $imagePath = $stmt->fetchColumn();
    }

    if ($file && !empty($file['name'])) {
        if ($imagePath && file_exists("../../".$imagePath)) unlink("../../".$imagePath);
        $imagePath = uploadFile($file);
    }

    if ($id) {
        $sql = "UPDATE english_details SET title=?, image=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$title, $imagePath, $id]);
    } else {
        $sql = "INSERT INTO english_details (category_slug, title, image) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$slug, $title, $imagePath]);
    }
    header("Location: ../../admin/manage-course.php?type=$slug&status=success");
}

if ($action === 'delete_detail') {
    $id = $_GET['id'];
    $slug = $_GET['type'];
    global $conn;
    $stmt = $conn->prepare("SELECT image FROM english_details WHERE id = ?");
    $stmt->execute([$id]);
    $img = $stmt->fetchColumn();
    if($img && file_exists("../../".$img)) unlink("../../".$img);
    $conn->prepare("DELETE FROM english_details WHERE id = ?")->execute([$id]);
    header("Location: ../../admin/manage-course.php?type=$slug&status=deleted");
}