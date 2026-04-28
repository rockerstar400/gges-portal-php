<?php
header('Content-Type: application/json');
require_once '../../functions.php';

// Action check: messages lane hain ya contact info text
$type = $_GET['type'] ?? 'messages';

if ($type === 'messages') {
    // Node.js: ContactModel.find().sort({ createdAt: -1 })
    $data = getAll('contact_queries');
    echo json_encode(['success' => true, 'data' => $data]);
} else {
    // Node.js: ContactTextModel.findOne()
    global $conn;
    $stmt = $conn->query("SELECT * FROM contact_info LIMIT 1");
    $data = $stmt->fetch();
    echo json_encode(['success' => true, 'data' => $data]);
}
?>