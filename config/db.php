<?php
// Check karein ki site local par chal rahi hai ya server par
if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
    // LOCALHOST (XAMPP) SETTINGS
    $host = "localhost";
    $db_name = "gges_db"; // Aapka local database naam
    $username = "root";
    $password = ""; 
} else {
    // LIVE SERVER SETTINGS
    $host = "localhost";
    $db_name = "graphics2_gges_edu"; 
    $username = "graphics2_gges_admin"; 
    $password = "GGES_secure@2024#"; 
}

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>