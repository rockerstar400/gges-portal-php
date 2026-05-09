<?php
// Fix: 2 level up (api -> root)
require_once __DIR__ . '/../../functions.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Form mein name="slug" hai
    $slug = $_POST['slug'] ?? 'sat'; 

    // --- 1. Common Sections (Dono mein hain) ---
    $hero = json_encode($_POST['hero'] ?? []);
    $about = json_encode($_POST['about'] ?? []);

    // --- 2. SAT Specific Logic ---
    $features = json_encode($_POST['features'] ?? []);
    
    $table_data = [];
    if(isset($_POST['table_name'])) {
        foreach($_POST['table_name'] as $k => $val) {
            if(!empty($val)) {
                $table_data[] = [
                    'name' => $val,
                    'time' => $_POST['table_time'][$k] ?? '',
                    'modules' => $_POST['table_modules'][$k] ?? ''
                ];
            }
        }
    }
    $sat_table_json = json_encode($table_data);
    $footer_note = $_POST['footer_note'] ?? '';

    // --- 3. SSAT Specific Logic ---
    $levels = [];
    if(isset($_POST['levels']['title'])) {
        foreach($_POST['levels']['title'] as $k => $val) {
            if(!empty($val)) {
                $levels[] = ['title' => $val, 'desc' => $_POST['levels']['desc'][$k]];
            }
        }
    }
    $lv_json = json_encode($levels);

    $scoring_cards = [];
    if(isset($_POST['scoring']['c_title'])) {
        foreach($_POST['scoring']['c_title'] as $k => $val) {
            if(!empty($val)) {
                $scoring_cards[] = ['title' => $val, 'content' => $_POST['scoring']['c_content'][$k]];
            }
        }
    }
    $score_final = json_encode([
        'heading' => $_POST['scoring']['heading'] ?? '', 
        'cards' => $scoring_cards, 
        'footer' => $_POST['scoring']['footer'] ?? ''
    ]);

    $middle_level = [];
    if(isset($_POST['m_sec'])) {
        foreach($_POST['m_sec'] as $k => $val) {
            if(!empty($val)) {
                $middle_level[] = [
                    'sec' => $val, 
                    'time' => $_POST['m_time'][$k] ?? '', 
                    'qs' => $_POST['m_qs'][$k] ?? '', 
                    'link' => $_POST['m_link'][$k] ?? ''
                ];
            }
        }
    }
    $struct_final = json_encode([
        'title' => $_POST['struct']['title'] ?? '', 
        'middle' => $middle_level, 
        'upper' => [] 
    ]);

    // --- 4. Database Upsert ---
    try {
        $stmt = $conn->prepare("INSERT INTO test_preparation_data 
            (test_slug, hero_section, about_section, levels_data, comparison_data, scoring_cards, test_structure, features_json, table_data_json, footer_note) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE 
            hero_section=VALUES(hero_section), 
            about_section=VALUES(about_section), 
            levels_data=VALUES(levels_data), 
            comparison_data=VALUES(comparison_data),
            scoring_cards=VALUES(scoring_cards), 
            test_structure=VALUES(test_structure),
            features_json=VALUES(features_json),
            table_data_json=VALUES(table_data_json),
            footer_note=VALUES(footer_note)");
        
        $stmt->execute([
            $slug, $hero, $about, $lv_json, 
            json_encode($_POST['comp'] ?? []), 
            $score_final, $struct_final, $features, $sat_table_json, $footer_note
        ]);

        // Fix: Redirect to admin folder
        header("Location: ../../admin/manage-test-prep.php?type=$slug&success=1");
        exit();

    } catch(PDOException $e) {
        die("Database Error: " . $e->getMessage());
    }


    // --- 5. PSAT Exam Period Logic ---
    $exam_period = [];
    if(isset($_POST['exam_name'])) {
        foreach($_POST['exam_name'] as $k => $val) {
            if(!empty($val)) {
                $exam_period[] = [
                    'name' => $val,
                    'time' => $_POST['exam_time'][$k] ?? '',
                    'modules' => $_POST['exam_modules'][$k] ?? ''
                ];
            }
        }
    }
    $exam_json = json_encode($exam_period);

   

    // SHSAT specific logic
if ($slug == 'shsat') {
    $items = [];
    if (isset($_POST['shsat_about_title'])) {
        foreach ($_POST['shsat_about_title'] as $k => $val) {
            if (!empty($val)) {
                $items[] = [
                    'title' => $val,
                    'content' => $_POST['shsat_about_content'][$k] ?? ''
                ];
            }
        }
    }
    // Is array ko 'about' column mein json_encode karke daal do
    $about_json = json_encode(['items' => $items]);
    
    $struct_json = json_encode([
        'title' => $_POST['struct']['title'] ?? '',
        'bullets' => $_POST['struct_bullets'] ?? []
    ]);
}

// --- 7. ELA SPECIFIC LOGIC ---
    $ela_admin_points = [];
    if(isset($_POST['ela_admin_name'])) {
        foreach($_POST['ela_admin_name'] as $k => $val) {
            if(!empty($val)) {
                $ela_admin_points[] = [
                    'name' => $val,
                    'desc' => $_POST['ela_admin_desc'][$k] ?? ''
                ];
            }
        }
    }

    // SQL UPDATE Query mein ye columns add karein:
    // ela_intro_title, ela_intro_content, ela_admin_title, ela_admin_json

    // Execute array mein ye values pass karein:
    // $_POST['ela_intro_title'] ?? '',
    // $_POST['ela_intro_content'] ?? '',
    // $_POST['ela_admin_title'] ?? '',
    // json_encode($ela_admin_points)


    // --- 8. SCAT SPECIFIC LOGIC ---
    $scat_versions = json_encode($_POST['scat_versions'] ?? []);
    $scat_tips = json_encode($_POST['scat_tips'] ?? []);

    $scat_sections = [];
    if(isset($_POST['scat_sec_title'])) {
        foreach($_POST['scat_sec_title'] as $k => $val) {
            $scat_sections[] = ['title' => $val, 'desc' => $_POST['scat_sec_desc'][$k]];
        }
    }
    $scat_sections_json = json_encode($scat_sections);

    $scat_levels = [];
    if(isset($_POST['scat_lvl_title'])) {
        foreach($_POST['scat_lvl_title'] as $k => $val) {
            $scat_levels[] = ['title' => $val, 'details' => $_POST['scat_lvl_details'][$k]];
        }
    }
    $scat_levels_json = json_encode($scat_levels);

    // --- 9. AMC SPECIFIC LOGIC ---
    $amc_points = json_encode($_POST['amc_points'] ?? []);
    
    $amc_cards = [];
    if(isset($_POST['amc_card_title'])) {
        foreach($_POST['amc_card_title'] as $k => $val) {
            if(!empty($val)) {
                $amc_cards[] = [
                    'title' => $val,
                    'desc1' => $_POST['amc_card_desc1'][$k],
                    'desc2' => $_POST['amc_card_desc2'][$k],
                    'when'  => $_POST['amc_card_when'][$k],
                    'who'   => $_POST['amc_card_who'][$k]
                ];
            }
        }
    }
    $amc_comp_json = json_encode($amc_cards);

    // SQL UPDATE Query mein ye columns add karein:
    // amc_participate_heading, amc_participate_json, amc_comp_heading, amc_comp_json, amc_why_heading, amc_why_desc

    // Ab apni INSERT/UPDATE SQL Query mein SCAT ke saare columns map kar dena.

    // --- 10. MATH KANGAROO LOGIC ---
    $kan_features = json_encode($_POST['kan_features'] ?? []);
    
    $kan_rules = [];
    if(isset($_POST['kan_rule_main'])) {
        foreach($_POST['kan_rule_main'] as $index => $mainTitle) {
            if(!empty($mainTitle)) {
                $subKey = "kan_rule_sub_" . $index;
                $kan_rules[] = [
                    'main' => $mainTitle,
                    'subs' => $_POST[$subKey] ?? []
                ];
            }
        }
    }
    $kan_rules_json = json_encode($kan_rules);

    // --- 11. ACT SPECIFIC LOGIC ---
    $act_about = [];
    if(isset($_POST['act_about_title'])) {
        foreach($_POST['act_about_title'] as $k => $val) {
            if(!empty($val)) $act_about[] = ['title' => $val, 'content' => $_POST['act_about_content'][$k]];
        }
    }
    $act_about_json = json_encode($act_about);

    $act_additional = [];
    if(isset($_POST['act_add_title'])) {
        foreach($_POST['act_add_title'] as $k => $val) {
            if(!empty($val)) $act_additional[] = ['title' => $val, 'content' => $_POST['act_add_content'][$k]];
        }
    }
    $act_add_json = json_encode($act_additional);

    $act_test_sec = [];
    if(isset($_POST['act_ts_title'])) {
        foreach($_POST['act_ts_title'] as $k => $val) {
            if(!empty($val)) $act_test_sec[] = ['title' => $val, 'desc' => $_POST['act_ts_desc'][$k]];
        }
    }
    $act_ts_json = json_encode($act_test_sec);

    // --- 12. CogAT SPECIFIC LOGIC ---
    $cogat_hero = json_encode(['sub_desc' => $_POST['cogat_hero_sub'], 'bullets' => $_POST['cogat_hero_bullets'] ?? []]);
    
    $c_struct_table = [];
    if(isset($_POST['cogat_struct_v'])) {
        foreach($_POST['cogat_struct_v'] as $k => $val) {
            $c_struct_table[] = ['v' => $val, 'q' => $_POST['cogat_struct_q'][$k], 'n' => $_POST['cogat_struct_n'][$k]];
        }
    }
    $cogat_struct = json_encode(['heading' => $_POST['cogat_struct_heading'], 'desc' => $_POST['cogat_struct_desc'], 'table' => $c_struct_table]);

    $cogat_measure = json_encode(['heading' => $_POST['cogat_measure_h'], 'content' => $_POST['cogat_measure_c']]);
    $cogat_administer = json_encode(['heading' => $_POST['cogat_administer_h'], 'content' => $_POST['cogat_administer_c']]);

    $c_lt_table = [];
    if(isset($_POST['cogat_lt_g'])) {
        foreach($_POST['cogat_lt_g'] as $k => $val) {
            $c_lt_table[] = ['g' => $val, 'l' => $_POST['cogat_lt_l'][$k], 'q' => $_POST['cogat_lt_q'][$k], 't' => $_POST['cogat_lt_t'][$k]];
        }
    }
    $cogat_levels = json_encode(['heading'=>$_POST['cogat_lt_h'], 'desc'=>$_POST['cogat_lt_d'], 'table'=>$c_lt_table, 'q_heading'=>$_POST['cogat_lt_qh'], 'q_desc'=>$_POST['cogat_lt_qd']]);

    $c_v_batt = []; foreach(($_POST['cogat_v_t'] ?? []) as $k => $v) $c_v_batt[] = ['t'=>$v, 'd'=>$_POST['cogat_v_d'][$k]];
    $c_nv_batt = []; foreach(($_POST['cogat_nv_t'] ?? []) as $k => $v) $c_nv_batt[] = ['t'=>$v, 'd'=>$_POST['cogat_nv_d'][$k]];
    $c_q_batt = []; foreach(($_POST['cogat_q_t'] ?? []) as $k => $v) $c_q_batt[] = ['t'=>$v, 'd'=>$_POST['cogat_q_d'][$k]];
    $cogat_battery = json_encode(['verbal' => $c_v_batt, 'nv' => $c_nv_batt, 'q' => $c_q_batt]);

    $cogat_score_loc = json_encode(['s_h'=>$_POST['cogat_s_h'], 's_d'=>$_POST['cogat_s_d'], 'l_h'=>$_POST['cogat_l_h'], 'l_d'=>$_POST['cogat_l_d']]);

    // SQL UPDATE execution mein ye saare naye JSON variables bind karein.

    // SQL execution mein ye columns aur values add kar dena.

    // Ab SQL query mein ye columns add karein:
 
    // kan_struct_heading, kan_struct_desc, kan_feat_heading, kan_feat_json, kan_rules_heading, kan_rules_json, kan_score_heading, kan_score_desc
    // --- 13. SBAC SPECIFIC LOGIC ---
    $sbac_points = [];
    if(isset($_POST['sbac_pt_title'])) {
        foreach($_POST['sbac_pt_title'] as $k => $val) {
            if(!empty($val)) {
                $sbac_points[] = [
                    'title' => $val,
                    'desc' => $_POST['sbac_pt_desc'][$k] ?? ''
                ];
            }
        }
    }
    $sbac_points_json = json_encode($sbac_points);

    // --- 14. ACCUPLACER SPECIFIC LOGIC ---
    $accu_test = [];
    if(isset($_POST['accu_test_title'])) {
        foreach($_POST['accu_test_title'] as $k => $val) {
            if(!empty($val)) $accu_test[] = ['title' => $val, 'desc' => $_POST['accu_test_desc'][$k]];
        }
    }
    $accu_write = [];
    if(isset($_POST['accu_write_title'])) {
        foreach($_POST['accu_write_title'] as $k => $val) {
            if(!empty($val)) $accu_write[] = ['title' => $val, 'desc' => $_POST['accu_write_desc'][$k]];
        }
    }
    $accu_esl = [];
    if(isset($_POST['accu_esl_title'])) {
        foreach($_POST['accu_esl_title'] as $k => $val) {
            if(!empty($val)) $accu_esl[] = ['title' => $val, 'desc' => $_POST['accu_esl_desc'][$k]];
        }
    }
    // --- 15. STB SPECIFIC LOGIC ---
    $stb_usage = json_encode([
        'intro'  => $_POST['stb_usage_intro'] ?? '',
        'points' => $_POST['stb_usage_points'] ?? [],
        'footer' => $_POST['stb_usage_footer'] ?? ''
    ]);

    $stb_subtests = [];
    if(isset($_POST['stb_st_title'])) {
        foreach($_POST['stb_st_title'] as $k => $val) {
            if(!empty($val)) $stb_subtests[] = ['title' => $val, 'desc' => $_POST['stb_st_desc'][$k]];
        }
    }
    $stb_subtests_json = json_encode($stb_subtests);

    $stb_timing = [];
    if(isset($_POST['stb_time_s'])) {
        foreach($_POST['stb_time_s'] as $k => $val) {
            if(!empty($val)) $stb_timing[] = ['s' => $val, 't1' => $_POST['stb_time_t1'][$k], 't2' => $_POST['stb_time_t2'][$k]];
        }
    }
    $stb_timing_json = json_encode($stb_timing);

    // Final SQL UPDATE statement mein ye columns map kar dein.

    // SQL UPDATE Query mein ye saare naye columns add karke execute mein values pass kar dena.

    // SQL UPDATE execution mein ye columns add karein:
    // sbac_assess_heading, sbac_assess_desc, sbac_assess_points_json



    // --- 7. ELA SPECIFIC LOGIC (Updated for React Compatibility) ---
    if ($slug == 'ela') {
        $admin_points = [];
        if(isset($_POST['admin_pt_title'])) {
            foreach($_POST['admin_pt_title'] as $k => $val) {
                if(!empty($val)) {
                    $admin_points[] = [
                        'title' => $val,
                        'description' => $_POST['admin_pt_desc'][$k] ?? ''
                    ];
                }
            }
        }
        
        $sql = "UPDATE test_preparation_data SET 
                ela_hero_title = ?, 
                ela_hero_desc = ?, 
                ela_intro_heading = ?, 
                ela_intro_desc = ?, 
                ela_admin_heading = ?, 
                ela_admin_points_json = ? 
                WHERE test_slug = 'ela'";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            $_POST['ela_hero_title'], 
            $_POST['ela_hero_desc'], 
            $_POST['ela_intro_heading'], 
            $_POST['ela_intro_desc'], 
            $_POST['ela_admin_heading'], 
            json_encode($admin_points)
        ]);
    }
}


?>