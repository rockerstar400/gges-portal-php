<?php
require_once __DIR__ . '/../../../functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $slug = $_POST['slug'] ?? 'eng-about-ela';

    // 1. Process Question Types Repeater
    $questions = [];
    if (isset($_POST['q_title'])) {
        foreach ($_POST['q_title'] as $k => $title) {
            if (!empty($title)) {
                $questions[] = [
                    'title' => $title,
                    'description' => $_POST['q_desc'][$k] ?? ''
                ];
            }
        }
    }
    $question_json = json_encode($questions);

    try {
        $stmt = $conn->prepare("UPDATE test_preparation_data SET 
            about_ela_prep_desc = ?, 
            about_ela_main_desc = ?, 
            about_ela_heading = ?, 
            about_ela_whotake_html = ?, 
            about_ela_question_json = ? 
            WHERE test_slug = ?");
        
        $stmt->execute([
            $_POST['prep_desc'],
            $_POST['main_desc'],
            $_POST['heading'],
            $_POST['whotake_html'],
            $question_json,
            $slug
        ]);

        header("Location: ../../../admin/manage-eng-about-ela.php?success=1");
    } catch (PDOException $e) { die("Database Error: " . $e->getMessage()); }
}