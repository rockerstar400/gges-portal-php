<?php
require_once __DIR__ . '/../../../functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $slug = 'amc';

    // 1. Process Competition Cards
    $cards = [];
    if (isset($_POST['card_title'])) {
        foreach ($_POST['card_title'] as $k => $title) {
            if (!empty($title)) {
                $cards[] = [
                    'title' => $title,
                    'amcDescription' => $_POST['card_amc_desc'][$k],
                    'description' => $_POST['card_desc_short'][$k],
                    'whenText' => $_POST['card_when'][$k],
                    'whoText' => $_POST['card_who'][$k]
                ];
            }
        }
    }

    try {
        $stmt = $conn->prepare("UPDATE test_preparation_data SET 
            amc_hero_title = ?, amc_hero_desc = ?, 
            amc_about_heading = ?, amc_about_desc = ?, 
            amc_participate_heading = ?, amc_participate_json = ?, 
            amc_comp_heading = ?, amc_comp_json = ?, 
            amc_why_heading = ?, amc_why_desc = ? 
            WHERE test_slug = ?");
        
        $stmt->execute([
            $_POST['amc_hero_title'], $_POST['amc_hero_desc'],
            $_POST['amc_about_heading'], $_POST['amc_about_desc'],
            $_POST['amc_participate_heading'], json_encode($_POST['participation_points'] ?? []),
            $_POST['amc_comp_heading'], json_encode($cards),
            $_POST['amc_why_heading'], $_POST['amc_why_desc'],
            $slug
        ]);

        header("Location: ../../../admin/manage-amc.php?success=1");
    } catch (PDOException $e) { die("Error: " . $e->getMessage()); }
}