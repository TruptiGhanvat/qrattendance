<?php
require "conn.php";
date_default_timezone_set("Asia/Kolkata");

if (!isset($_GET['enrollment_no']) || !isset($_GET['lecture_id']) || !isset($_GET['ts'])) {
    die("Invalid QR code.");
}

$enrollment_no = $_GET['enrollment_no'];
$lecture_id = $_GET['lecture_id'];
$timestamp = $_GET['ts'];

// QR expiry – 15 मिनिटे
if (time() - $timestamp > 900) {
    die("QR Code expired.");
}

$date = date("Y-m-d");
$time = date("H:i:s");

// attendance already marked आहे का?
$check = mysqli_query($conn, "SELECT * FROM attendance WHERE enrollment_no='$enrollment_no' AND lecture_id='$lecture_id'");
if (mysqli_num_rows($check) > 0) {
    die("Attendance already marked.");
}

// नवीन attendance insert करा
$sql = "INSERT INTO attendance (enrollment_no, lecture_id, date, time) 
        VALUES ('$enrollment_no', '$lecture_id', '$date', '$time')";

if (mysqli_query($conn, $sql)) {
    echo "Attendance marked successfully for $enrollment_no!";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
