<?php
require_once __DIR__ . '/../../../functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $slug = 'cogat';

    // 1. Hero
    $cogat_hero = json_encode(['sub_desc' => $_POST['c_hero_sub'], 'bullets' => array_filter($_POST['c_hero_bullets'] ?? [])]);

    // 2. Structure Table
    $struct_table = [];
    if(isset($_POST['c_struct_v'])) {
        foreach($_POST['c_struct_v'] as $k => $val) {
            $struct_table[] = ['v' => $val, 'q' => $_POST['c_struct_q'][$k], 'n' => $_POST['c_struct_n'][$k]];
        }
    }
    $cogat_struct = json_encode(['heading' => $_POST['c_struct_h'], 'desc' => $_POST['c_struct_d'], 'table' => $struct_table]);

    // 3. Measure & Administer
    $cogat_measure = json_encode(['heading' => $_POST['c_measure_h'], 'content' => $_POST['c_measure_d']]);
    $cogat_administer = json_encode(['heading' => $_POST['c_admin_h'], 'content' => $_POST['c_admin_content']]);

    // 4. Levels & Timing
    $levels_table = [];
    if(isset($_POST['c_lt_g'])) {
        foreach($_POST['c_lt_g'] as $k => $val) {
            $levels_table[] = ['g' => $val, 'l' => $_POST['c_lt_l'][$k], 'q' => $_POST['c_lt_q'][$k], 't' => $_POST['c_lt_t'][$k]];
        }
    }
    $cogat_levels = json_encode(['heading' => $_POST['c_levels_h'], 'desc' => $_POST['c_levels_d'], 'table' => $levels_table, 'q_heading' => $_POST['c_qcount_h'], 'q_desc' => $_POST['c_qcount_d']]);

    // 5. Battery (Verbal, NV, Q)
    function bundleBat($titles, $contents) {
        $arr = [];
        if(isset($titles)) { foreach($titles as $k => $v) { if(!empty($v)) $arr[] = ['t'=>$v, 'c'=>$contents[$k]]; } }
        return $arr;
    }
    $cogat_battery = json_encode([
        'v' => bundleBat($_POST['c_bat_t_v'], $_POST['c_bat_c_v']),
        'nv' => bundleBat($_POST['c_bat_t_nv'], $_POST['c_bat_c_nv']),
        'q' => bundleBat($_POST['c_bat_t_q'], $_POST['c_bat_c_q'])
    ]);

    // 6. Score & Loc
    $cogat_score_loc = json_encode(['s_h' => $_POST['c_score_h'], 's_d' => $_POST['c_score_d'], 'l_h' => $_POST['c_loc_h'], 'l_d' => $_POST['c_loc_d']]);

    try {
        $stmt = $conn->prepare("UPDATE test_preparation_data SET 
            hero_section = ?, cogat_hero_json = ?, cogat_struct_json = ?, cogat_measure_json = ?, 
            cogat_administer_json = ?, cogat_levels_json = ?, cogat_battery_json = ?, cogat_score_loc_json = ? 
            WHERE test_slug = ?");
        
        $stmt->execute([
            json_encode($_POST['hero'] ?? []), $cogat_hero, $cogat_struct, $cogat_measure, 
            $cogat_administer, $cogat_levels, $cogat_battery, $cogat_score_loc, $slug
        ]);

        header("Location: ../../../admin/manage-cogat.php?success=1");
    } catch(PDOException $e) { die($e->getMessage()); }
}