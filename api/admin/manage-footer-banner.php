<?php
header('Content-Type: application/json');
require_once '../../functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $file = $_FILES['image'] ?? null;

    if (empty($title) || empty($description)) {
        header("Location: ../../admin/manage-footer-banner.php?status=error&msg=missing_fields");
        exit;
    }

    if (upsertFooterBanner($title, $description, $file)) {
        header("Location: ../../admin/manage-footer-banner.php?status=success");
    } else {
        header("Location: ../../admin/manage-footer-banner.php?status=error");
    }
}