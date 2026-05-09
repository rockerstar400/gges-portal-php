<?php
header('Content-Type: application/json');
require_once '../../functions.php';

$action = $_GET['action'] ?? '';

// --- 1. ADD KANGAROO DETAIL CARD ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'add_card') {
    $title = $_POST['title'] ?? '';
    $descriptions = $_POST['descriptions'] ?? []; // Array mapping
    $file = $_FILES['image'] ?? null;

    if (empty($title) || empty($descriptions) || !$file) {
        header("Location: ../../admin/manage-course.php?type=math-kangaroo&status=error&msg=missing_fields");
        exit;
    }

    if (addKangarooDetail($title, $descriptions, $file)) {
        header("Location: ../../admin/manage-course.php?type=math-kangaroo&status=success");
    } else {
        header("Location: ../../admin/manage-course.php?type=math-kangaroo&status=error");
    }
    exit;
}

// --- 2. DELETE KANGAROO DETAIL CARD ---
if ($action === 'delete') {
    $id = $_GET['id'] ?? null;
    if ($id) {
        global $conn;
        
        // Image path nikaalo taaki folder se delete ho sake
        $stmt = $conn->prepare("SELECT image FROM kangaroo_details WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        
        if ($row && !empty($row['image'])) {
            $fullPath = "../../" . $row['image'];
            if (file_exists($fullPath)) unlink($fullPath);
        }

        // Database se delete karein
        $delStmt = $conn->prepare("DELETE FROM kangaroo_details WHERE id = ?");
        if($delStmt->execute([$id])) {
            header("Location: ../../admin/manage-course.php?type=math-kangaroo&status=deleted");
        }
    }
    exit;
}
?>