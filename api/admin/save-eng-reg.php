<?php
require_once __DIR__ . '/../../../functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $slug = $_POST['slug'];
    $title = $_POST['title'];
    $desc = $_POST['description'];

    try {
        $stmt = $conn->prepare("UPDATE test_preparation_data SET eng_reg_title = ?, eng_reg_desc = ? WHERE test_slug = ?");
        $stmt->execute([$title, $desc, $slug]);
        header("Location: ../../manage-eng-reg.php?success=1");
    } catch(PDOException $e) { die($e->getMessage()); }
}