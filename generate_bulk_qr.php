<?php
require "conn.php";
date_default_timezone_set("Asia/Kolkata");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject = $_POST['subject'];
    $batch = $_POST['batch'];
    $date = date("Ymd");
    $lecture_id = $subject . $date;

    $sql = "SELECT enrollment_no, name FROM students WHERE batch = '$batch'";
    $result = mysqli_query($conn, $sql);

    echo "<h2>QR Codes for Subject: <span style='color:blue;'>$subject</span> | Batch: $batch</h2>";
    echo "<div style='display:flex; flex-wrap:wrap;'>";

    while ($row = mysqli_fetch_assoc($result)) {
        $enrollment_no = $row['enrollment_no'];
        $name = $row['name'];
        $ts = time();
        // $qr_link = "http://localhost/qrattendance/mark_attendance.php?enrollment_no=$enrollment_no&lecture_id=$lecture_id&ts=$ts";
        $qr_link = "https://github.com/SagarBhoi404/qr-code-attendance-system";

        $qr_url = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($qr_link);

        echo "<div style='border:1px solid #ccc; margin:10px; padding:10px; text-align:center; width:220px;'>
            <strong>$name</strong><br>
            <small>$enrollment_no</small><br>
            <img src='$qr_url' alt='QR Code'><br>
            <a href='$qr_link' target='_blank'>Scan Link</a>
        </div>";
    }

    echo "</div>";
}
?>
