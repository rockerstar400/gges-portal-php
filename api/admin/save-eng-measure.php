<?php
require_once __DIR__ . '/../../../functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $slug = $_POST['slug'];
    
    // Bundle all 5 titles and descriptions into one JSON
    $measureData = [];
    for($i=1; $i<=5; $i++) {
        $measureData['title'.$i] = $_POST['title'.$i];
        $measureData['description'.$i] = $_POST['description'.$i];
    }

    try {
        $stmt = $conn->prepare("UPDATE test_preparation_data SET eng_measure_json = ? WHERE test_slug = ?");
        $stmt->execute([json_encode($measureData), $slug]);
        header("Location: ../../manage-eng-reg.php?success=1");
    } catch(PDOException $e) { die($e->getMessage()); }
}