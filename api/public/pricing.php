<?php
header('Content-Type: application/json');
require_once '../../functions.php';

$data = getPricing();

// Loop karke fees ko wapas Array mein badalna (Frontend ke liye)
foreach ($data as &$plan) {
    $plan['fees'] = json_decode($plan['fees'], true);
}

echo json_encode(['success' => true, 'data' => $data]);
?>