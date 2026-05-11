<?php
if (file_exists(__DIR__ . '/../../functions.php')) { require_once __DIR__ . '/../../functions.php'; } else { require_once __DIR__ . '/../../../functions.php'; }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $slug = $_POST['slug'] ?? 'math-science';
    $desc = $_POST['description'];
    $tutor = $_POST['tutor_description'];

    try {
        $stmt = $conn->prepare("UPDATE test_preparation_data SET sci_hero_desc = ?, sci_tutor_desc = ? WHERE test_slug = ?");
        $stmt->execute([$desc, $tutor, $slug]);
        header("Location: ../../../admin/manage-math-science.php?success=1");
    } catch(PDOException $e) { die($e->getMessage()); }
}