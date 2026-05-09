
<?php
header('Content-Type: application/json');
require_once '../../functions.php';

$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'save') {
    $id = $_POST['id'] ?: null; // Agar ID hai toh update, nahi toh add
    $title = $_POST['title'];
    $description = $_POST['description'];
    $file = $_FILES['image'];

    if (saveTrust($title, $description, $file, $id)) {
        header("Location: ../../admin/manage-trust.php?status=success");
    } else {
        header("Location: ../../admin/manage-trust.php?status=error");
    }
}

if ($action === 'delete') {
    $id = $_GET['id'];
    global $conn;
    $stmt = $conn->prepare("SELECT image FROM trust_stats WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    if($row && file_exists("../../".$row['image'])) unlink("../../".$row['image']);

    $stmt = $conn->prepare("DELETE FROM trust_stats WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: ../../admin/manage-trust.php?status=deleted");
}