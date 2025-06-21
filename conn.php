<?php
$host = "localhost";
$user = "root";
$pass = ""; // जर XAMPP वापरत असाल तर पासवर्ड रिकामा ठेवा
$db = "qrattendance";

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
