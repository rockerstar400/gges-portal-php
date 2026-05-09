<?php
header('Content-Type: application/json');
require_once '../../functions.php';

$action = $_GET['action'] ?? '';

// 1. ADD MEMBER (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'add') {
    $name = $_POST['name'] ?? '';
    $role = $_POST['role'] ?? '';
    $description = $_POST['description'] ?? '';
    $order = $_POST['order_val'] ?? 0;
    $file = $_FILES['image'] ?? null;

    if (empty($name) || empty($role) || !$file) {
        header("Location: ../../admin/manage-management.php?status=error&msg=fields_required");
        exit;
    }

    if (addMember($name, $role, $description, $order, $file)) {
        header("Location: ../../admin/manage-management.php?status=success");
    } else {
        header("Location: ../../admin/manage-management.php?status=error");
    }
}

// 2. DELETE MEMBER
if ($action === 'delete') {
    $id = $_GET['id'] ?? null;
    global $conn;
    
    $stmt = $conn->prepare("SELECT image FROM management WHERE id = ?");
    $stmt->execute([$id]);
    $m = $stmt->fetch();
    
    if ($m) {
        if (file_exists("../../" . $m['image'])) unlink("../../" . $m['image']);
        $stmt = $conn->prepare("DELETE FROM management WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: ../../admin/manage-management.php?status=deleted");
    }
}
?>