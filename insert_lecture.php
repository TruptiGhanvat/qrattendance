<?php
require('conn.php');
session_start();

if ($_SESSION['usertype'] != 'ADMIN') {
    session_destroy();
    header("Location: login.php");
    exit();
}

$academic = $_POST['academic_year'];
$branch = $_POST['branch'];
$semester = $_POST['semester'];
$batch = $_POST['batch'];
$day = $_POST['day'];
$slot = $_POST['slot'];
$slotlabel = $_POST['slotlabel'];
$subject_code = $_POST['subject_code'];

$sql = "INSERT INTO timetable (academic_year, branch, semester, batch, day, slot, slotlabel, subject_code)
        VALUES ('$academic', '$branch', '$semester', '$batch', '$day', '$slot', '$slotlabel', '$subject_code')";

if (mysqli_query($conn, $sql)) {
    $_SESSION['msg'] = "<div class='alert alert-success'>Lecture added successfully.</div>";
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Failed to insert: ".mysqli_error($conn)."</div>";
}

header("Location: timetable.php");
exit();
