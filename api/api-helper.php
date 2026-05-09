<?php
// api/api-helper.php
header('Content-Type: application/json'); // Hamesha JSON bhejne ke liye
header('Access-Control-Allow-Origin: *'); // CORS handling


/** 
 * SMART PATH LOGIC (Universal Fix)
 * Live server par path: api/api-helper.php (1 level up)
 * Local Windows par path: admin/api/api-helper.php (2 level up)
 */
if (file_exists(dirname(__DIR__, 1) . '/functions.php')) {
    // Ye Live Server par sahi rasta pakdega
    require_once dirname(__DIR__, 1) . '/functions.php';
} else if (file_exists(dirname(__DIR__, 2) . '/functions.php')) {
    // Ye Local Windows (Admin/api folder) par sahi rasta pakdega
    require_once dirname(__DIR__, 2) . '/functions.php';
}
// require_once '../functions.php'; // DB connection aur logic include karein
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions.php';


function sendResponse($success, $message, $data = null) {
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ]);
    exit;
}
?>