<?php
if (file_exists(__DIR__ . '/../../functions.php')) { require_once __DIR__ . '/../../functions.php'; } else { require_once __DIR__ . '/../../../functions.php'; }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $slug = $_POST['slug'] ?? '';
    $heading = $_POST['heading'] ?? '';
    $headingDescription = $_POST['headingDescription'] ?? '';

    $chapters = [];
    if(isset($_POST['chapter_title'])) {
        foreach($_POST['chapter_title'] as $key => $title) {
            if(!empty($title)) {
                // Topic names nikalna (Dynamic key matching Admin UI)
                $nameKey = "chapter_names_" . $key;
                
                $chapters[] = [
                    'title' => $title,
                    'description' => $_POST['chapter_desc'][$key] ?? '',
                    'chapterName' => array_values(array_filter($_POST[$nameKey] ?? [])) // Key name matched to React
                ];
            }
        }
    }

    try {
        $sql = "INSERT INTO test_preparation_data (test_slug, tutoring_heading, tutoring_description, tutoring_chapters_json) 
                VALUES (?, ?, ?, ?) 
                ON DUPLICATE KEY UPDATE 
                tutoring_heading = VALUES(tutoring_heading), 
                tutoring_description = VALUES(tutoring_description), 
                tutoring_chapters_json = VALUES(tutoring_chapters_json)";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute([$slug, $heading, $headingDescription, json_encode($chapters)]);
        
        // Redirect logic (Fixed ? vs & issue)
        $referer = strtok($_SERVER['HTTP_REFERER'], '?');
        header("Location: " . $referer . "?success=1");
        exit();
    } catch(PDOException $e) { die("Error: " . $e->getMessage()); }
}