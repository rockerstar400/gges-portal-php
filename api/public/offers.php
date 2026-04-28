<?php
header('Content-Type: application/json');
require_once '../../functions.php';

$id = $_GET['id'] ?? null;

if ($id) {
    // Single Offer Detail
    $data = getOfferById($id);
    if ($data) {
        echo json_encode(['success' => true, 'data' => $data]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Offer not found']);
    }
} else {
    // All Offers
    $data = getOffers();
    echo json_encode(['success' => true, 'data' => $data]);
}
?>