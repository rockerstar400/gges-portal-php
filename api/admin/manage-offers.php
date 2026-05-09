<?php
header('Content-Type: application/json');
require_once '../../functions.php';

$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'add') {
    $data = [
        'type' => $_POST['type'],
        'title' => $_POST['title'],
        'description' => $_POST['description'], // CKEditor se HTML data aayega
        'expireDate' => !empty($_POST['expireDate']) ? $_POST['expireDate'] : null
    ];

    if (addOffer($data)) {
        header("Location: ../../admin/manage-offers.php?status=success");
    } else {
        header("Location: ../../admin/manage-offers.php?status=error");
    }
}

if ($action === 'delete') {
    $id = $_GET['id'];
    if (deleteOffer($id)) {
        header("Location: ../../admin/manage-offers.php?status=deleted");
    }
}