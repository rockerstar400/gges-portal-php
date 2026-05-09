<?php 
require_once 'functions.php';
include 'includes/header.php'; 
include 'includes/navbar.php';

// 1. K-12 Service Data Fetch
$serviceData = $conn->query("SELECT * FROM k12_services LIMIT 1")->fetch(PDO::FETCH_ASSOC);

// 2. K-12 Methodology Data Fetch
$methodologyData = $conn->query("SELECT * FROM k12_methodology ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);

// 3. Modular Section Include
$sectionFile = "includes/test-prep-sections/k12-section.php";
if(file_exists($sectionFile)) {
    include $sectionFile;
} else {
    echo "<div class='container text-center py-5'><h1>K-12 Section File Missing</h1></div>";
}

include 'includes/footer.php'; 
?>