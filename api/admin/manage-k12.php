<?php
header('Content-Type: application/json');
require_once '../../functions.php';

$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'add_method') {
    if (addK12Methodology($_POST['title'], $_POST['description'], $_FILES['image'])) {
        header("Location: ../../admin/manage-course.php?type=k12-management&status=success");
    } else {
        header("Location: ../../admin/manage-course.php?type=k12-management&status=error");
    }
}

if ($action === 'delete_method') {
    $id = $_GET['id'];
    global $conn;
    $stmt = $conn->prepare("SELECT image FROM k12_methodology WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    if($row && file_exists("../../".$row['image'])) unlink("../../".$row['image']);

    $stmt = $conn->prepare("DELETE FROM k12_methodology WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: ../../admin/manage-course.php?type=k12-management&status=deleted");
}