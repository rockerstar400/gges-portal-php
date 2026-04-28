<?php
// api/api-helper.php
header('Content-Type: application/json'); // Hamesha JSON bhejne ke liye
header('Access-Control-Allow-Origin: *'); // CORS handling

require_once '../functions.php'; // DB connection aur logic include karein

function sendResponse($success, $message, $data = null) {
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ]);
    exit;
}
?>