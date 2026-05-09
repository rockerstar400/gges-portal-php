<?php
header('Content-Type: application/json');
require_once '../../functions.php';

$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'add') {
    $name = $_POST['name'];
    $designation = $_POST['designation'];
    $description = $_POST['description'];
    $rating = $_POST['rating'];
    $file = $_FILES['image'];

    if (addStory($name, $designation, $description, $rating, $file)) {
        header("Location: ../../admin/manage-success-story.php?status=success");
    } else {
        header("Location: ../../admin/manage-success-story.php?status=error");
    }
}

if ($action === 'delete') {
    $id = $_GET['id'];
    global $conn;
    $stmt = $conn->prepare("DELETE FROM success_stories WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: ../../admin/manage-success-story.php?status=deleted");
}