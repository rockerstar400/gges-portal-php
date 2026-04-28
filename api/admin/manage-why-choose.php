<?php
header('Content-Type: application/json');
require_once '../../functions.php';

// Action check karein: add, update, ya delete
$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'add') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $file = $_FILES['image'] ?? null;

    if (!$title || !$description || !$file) {
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        exit;
    }

    if (addWhyChoose($title, $description, $file)) {
        echo json_encode(['success' => true, 'message' => 'Item added successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add item']);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'update') {
    $id = $_POST['id'] ?? '';
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $file = $_FILES['image'] ?? null;

    if (updateWhyChoose($id, $title, $description, $file)) {
        echo json_encode(['success' => true, 'message' => 'Item updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Update failed']);
    }
}

if ($action === 'delete') {
    $id = $_GET['id'] ?? '';
    if (deleteWhyChoose($id)) {
        echo json_encode(['success' => true, 'message' => 'Deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Delete failed']);
    }
}
<?php
header('Content-Type: application/json');
require_once '../../functions.php';

$action = $_GET['action'] ?? '';

// ADD ACTION
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'add') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $file = $_FILES['image'];

    if (addWhyChoose($title, $description, $file)) {
        header("Location: ../../admin/manage-why-choose.php?status=success");
    } else {
        header("Location: ../../admin/manage-why-choose.php?status=error");
    }
}

// DELETE ACTION
if ($action === 'delete') {
    $id = $_GET['id'];
    global $conn;
    
    // Purani image delete karein
    $stmt = $conn->prepare("SELECT image FROM why_choose WHERE id = ?");
    $stmt->execute([$id]);
    $item = $stmt->fetch();
    if($item && file_exists("../../".$item['image'])) unlink("../../".$item['image']);

    // Record delete karein
    $stmt = $conn->prepare("DELETE FROM why_choose WHERE id = ?");
    if($stmt->execute([$id])) {
        header("Location: ../../admin/manage-why-choose.php?status=deleted");
    }
}
?>
