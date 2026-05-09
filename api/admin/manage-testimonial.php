<?php
header('Content-Type: application/json');
require_once '../../functions.php';

$action = $_GET['action'] ?? '';

// 1. POST API (Add Testimonial)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'add') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $address = $_POST['address'] ?? '';
    $file = $_FILES['image'] ?? null;

    // Validation (Exactly like Node.js code)
    if (empty($title) || empty($description) || empty($address)) {
        header("Location: ../../admin/manage-testimonial.php?status=error&message=fields_required");
        exit;
    }

    if (!$file || empty($file['name'])) {
        header("Location: ../../admin/manage-testimonial.php?status=error&message=image_required");
        exit;
    }

    if (addTestimonial($title, $description, $address, $file)) {
        header("Location: ../../admin/manage-testimonial.php?status=success");
    } else {
        header("Location: ../../admin/manage-testimonial.php?status=error");
    }
}

// 2. DELETE API
if ($action === 'delete') {
    $id = $_GET['id'] ?? null;
    if ($id && deleteTestimonial($id)) {
        header("Location: ../../admin/manage-testimonial.php?status=deleted");
    } else {
        header("Location: ../../admin/manage-testimonial.php?status=error");
    }
}
?>