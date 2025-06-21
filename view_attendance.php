<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
echo "<h2>Welcome to Attendance Viewer</h2>";
echo "<a href='logout.php'>Logout</a>";
?>