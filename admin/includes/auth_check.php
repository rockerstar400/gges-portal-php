<!-- 
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php"); // Agar login nahi hai toh login page par bhejo
    exit();
}
?>

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
} -->


<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php"); // Agar login nahi hai toh login page par bhejo
    exit();
}
?>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Agar session mein admin_id nahi hai, toh wapas login page par bhej do
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}
?>