<?php
if (file_exists(__DIR__ . '/../../functions.php')) { require_once __DIR__ . '/../../functions.php'; } else { require_once __DIR__ . '/../../../functions.php'; }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $slug = $_POST['slug'];
    $bannerDesc = $_POST['banner_desc'];
    $struct_json = json_encode(array_values(array_filter($_POST['struct_desc'] ?? [])));

    try {
        $stmt = $conn->prepare("UPDATE test_preparation_data SET kan_banner_desc = ?, kan_struct_json = ? WHERE test_slug = ?");
        $stmt->execute([$bannerDesc, $struct_json, $slug]);
        header("Location: ../../../admin/manage-math-kangaroo.php?tab=service&success=1");
    } catch(PDOException $e) { die($e->getMessage()); }
}