<?php
header('Content-Type: application/json');
require_once '../../functions.php';

// Note: Industry level par yahan Session validation (authentication) honi chahiye
// Abhi hum logic par focus kar rahe hain

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $image = $_FILES['image'] ?? null;

    if (empty($title) || empty($description)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        exit;
    }

    $result = saveBanner($title, $description, $image);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Banner updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
}
?>