<?php
require_once __DIR__ . '/../../../functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $slug = 'ssat';

    // 1. Common Fields
    $hero = json_encode($_POST['hero'] ?? []);
    $about = json_encode($_POST['about'] ?? []);
    $facts = json_encode($_POST['facts'] ?? []);
    $comp = json_encode([
        'heading' => $_POST['comp']['heading'] ?? '',
        'description' => $_POST['comp']['description'] ?? '',
        'points' => array_filter($_POST['comp_points'] ?? [])
    ]);

    // 2. Levels Array
    $levels = [];
    if (isset($_POST['lv_title'])) {
        foreach ($_POST['lv_title'] as $k => $val) {
            if (!empty($val)) $levels[] = ['title' => $val, 'desc' => $_POST['lv_desc'][$k]];
        }
    }

    // 3. Scoring Cards Array
    $scoring_cards = [];
    if (isset($_POST['score_card_title'])) {
        foreach ($_POST['score_card_title'] as $k => $val) {
            if (!empty($val)) $scoring_cards[] = ['title' => $val, 'content' => $_POST['score_card_content'][$k]];
        }
    }
    $scoring_final = json_encode([
        'heading' => $_POST['scoring']['heading'] ?? '',
        'cards' => $scoring_cards,
        'footer' => $_POST['scoring']['footer'] ?? ''
    ]);

    // 4. Dual Tables Logic
    function bundleTable($sec, $time, $qs, $link) {
        $rows = [];
        if (isset($sec)) {
            foreach ($sec as $k => $v) {
                if (!empty($v)) $rows[] = ['section' => $v, 'time' => $time[$k], 'questions' => $qs[$k], 'download' => $link[$k]];
            }
        }
        return $rows;
    }
    $middle = bundleTable($_POST['m_sec'], $_POST['m_time'], $_POST['m_qs'], $_POST['m_link']);
    $upper = bundleTable($_POST['u_sec'], $_POST['u_time'], $_POST['u_qs'], $_POST['u_link']);
    $struct_final = json_encode(['heading' => $_POST['struct']['heading'], 'middle' => $middle, 'upper' => $upper]);

    // 5. Good Score Logic
    $footer_score = json_encode($_POST['footer_score'] ?? []);

    try {
        $stmt = $conn->prepare("UPDATE test_preparation_data SET 
            hero_section = ?, about_section = ?, levels_data = ?, 
            comparison_data = ?, quick_facts = ?, scoring_cards = ?, 
            test_structure = ?, good_score_data = ? 
            WHERE test_slug = ?");
        
        $stmt->execute([
            $hero, $about, json_encode($levels), $comp, $facts, 
            $scoring_final, $struct_final, $footer_score, $slug
        ]);

        header("Location: ../../../admin/manage-ssat.php?success=1");
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}