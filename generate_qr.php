<?php
// generate_qr.php
date_default_timezone_set("Asia/Kolkata"); // Set timezone for accurate timestamp

$qr_url = '';
$qr_link = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject = $_POST['subject'];
    $enrollment_no = $_POST['enrollment_no'];
    $date = date("Ymd");
    $lecture_id = $subject . $date;

    // Generate current timestamp for expiry check
    $timestamp = time(); // current time in seconds

    // Generate the QR link with expiry timestamp
    // $qr_link = "http://localhost/qrattendance/mark_attendance.php?enrollment_no=$enrollment_no&lecture_id=$lecture_id&ts=$timestamp";
     $qr_link = "https://github.com/SagarBhoi404/qr-code-attendance-system";

    // Generate QR image URL using public API
    $qr_url = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($qr_link);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Generate QR Code</title>
    <style>
        body {
            font-family: Arial;
            padding: 20px;
        }
        form {
            margin-bottom: 30px;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input, select, button {
            padding: 6px;
            margin-top: 5px;
        }
        .qr-container {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<h2>Single Student QR Code Generator (With Expiry)</h2>

<form method="post" action="">
    <label>Select Subject:</label>
    <select name="subject" required>
        <option value="">--Select--</option>
        <option value="CN">Computer Network</option>
        <option value="ML">Machine Learning</option>
        <!-- Add more subjects as needed -->
    </select>

    <label>Enrollment No:</label>
    <input type="text" name="enrollment_no" required />

    <button type="submit">Generate QR</button>
</form>

<?php if (!empty($qr_url)): ?>
    <div class="qr-container">
        <h3>QR Code:</h3>
        <img src="<?php echo $qr_url; ?>" alt="QR Code"><br>
        <p><strong>Scan Link:</strong> <a href="<?php echo $qr_link; ?>" target="_blank"><?php echo $qr_link; ?></a></p>
        <p style="color:red;"><strong>Note:</strong> QR expires in 15 minutes from generation time.</p>
    </div>
<?php endif; ?>

</body>
</html>
