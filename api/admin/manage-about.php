<?php
header('Content-Type: application/json');
require_once '../../functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Node.js toArray() ka logic PHP automatically name[] se handle kar leta hai
    $data = [
        'description'            => $_POST['description'] ?? [],
        'whyUsDescription'       => $_POST['whyUsDescription'] ?? [],
        'howDiffrentDescription' => $_POST['howDiffrentDescription'] ?? [],
        'safetyDescription'      => $_POST['safetyDescription'] ?? [],
        'tutorDescription'       => $_POST['tutorDescription'] ?? '',
        'howDiffrentHeader'      => $_POST['howDiffrentHeader'] ?? ''
    ];

    $file = $_FILES['image'] ?? null;

    if (upsertAbout($data, $file)) {
        header("Location: ../../admin/manage-about.php?status=success");
    } else {
        header("Location: ../../admin/manage-about.php?status=error");
    }
    exit();
}