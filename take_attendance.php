<?php
require('header.php');
require('conn.php');

if ($_SESSION['usertype'] != 'TEACHER') {
    session_destroy();
    header("location: login.php");
    exit();
}

$teacher_id = $_SESSION['teacher_id'];
$teacher_sql = "SELECT * FROM teachers WHERE `id`=$teacher_id";
$teacher_res = mysqli_query($conn, $teacher_sql);
$teacher_row = mysqli_fetch_assoc($teacher_res);
?>

<div class="container pt-3 px-4 m-0">
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 p-1 rounded-4" style="background: #eee;">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item">Attendance</li>
            <li class="breadcrumb-item active" aria-current="page">Take Attendance</li>
        </ol>
    </nav>
</div>

<div class="container-fluid pt-4 px-4">
    <div class="text-center w-100">
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
    </div>

    <div class="row bg-light rounded mx-0">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Take Attendance</h6>
                <form class="row gy-2 gx-3 align-items-center border p-2" action="take_attendance.php" method="get">
                    <div class="col-auto">
                        <p>View Time Table</p>
                    </div>
                    <div class="col-auto">
                        <select class="form-select" name="semester" required>
                            <option value="">Select Semester</option>
                            <option value="6">Sixth</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <select class="form-select" name="batch" required>
                            <option value="">Select Batch</option>
                            <option value="T1">T1</option>
                            <option value="T2">T2</option>
                            <option value="T3">T3</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <select class="form-select" name="academic" required>
                            <option value="">Select Academic Year</option>
                            <option value="2024-25">2024-25</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-outline-success">Search Time Table</button>
                    </div>
                </form>

                <?php
                if (isset($_GET['batch']) && isset($_GET['semester']) && isset($_GET['academic'])):
                    $semester = mysqli_escape_string($conn, $_GET['semester']);
                    $batch = mysqli_escape_string($conn, $_GET['batch']);
                    $academic = mysqli_escape_string($conn, $_GET['academic']);

                    echo "<h6 class='mb-3 text-center mt-3 text-danger'>Time Table Details : Academic Year-[$academic], Batch-[$batch], Semester-[$semester]</h6>";

                    $sql = "SELECT * FROM `timetable` WHERE `academic_year`='$academic' AND `branch`='{$teacher_row['branch']}' AND `semester`='$semester' AND `batch`='$batch'";
                    $sqlslot = "SELECT DISTINCT `slot`,`slotlabel` FROM `timetable` WHERE `academic_year`='$academic' AND `branch`='{$teacher_row['branch']}' AND `semester`='$semester' AND `batch`='$batch'";

                    $result1 = mysqli_query($conn, $sqlslot);
                    $result2 = mysqli_query($conn, $sql);

                    $slots = [];
                    while ($row = mysqli_fetch_assoc($result1)) {
                        $slots[$row['slot']] = $row['slotlabel'];
                    }

                    $timetable = [];
                    while ($row = mysqli_fetch_assoc($result2)) {
                        $day = $row['day'];
                        $slot = $row['slot'];
                        $timetable[$day][$slot] = $row['subject_code'];
                    }

                    $currentDay = date('l');
                ?>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Day</th>
                                    <?php foreach ($slots as $slotLabel): ?>
                                        <th scope="col"><?php echo $slotLabel; ?></th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday','Saturday'];
                                foreach ($daysOfWeek as $day):
                                ?>
                                    <tr>
                                        <td><?php echo $day; ?></td>
                                        <?php foreach ($slots as $slot => $slotLabel): ?>
                                            <td>
                                                <?php
                                                $subjectCode = $timetable[$day][$slot] ?? '';
                                                if ($subjectCode) {
                                                    $subjectQuery = "SELECT * FROM `subjects` WHERE `subject_code`='$subjectCode'";
                                                    $subjectRes = mysqli_query($conn, $subjectQuery);
                                                    $subjectRow = mysqli_fetch_assoc($subjectRes);

                                                    if ($subjectRow) {
                                                        echo "<strong>{$subjectRow['name']}</strong>";

                                                        if ($subjectRow['teacher_id'] == $teacher_id && $day == $currentDay) {
                                                            $lecture_id = $subjectCode . date('Ymd') . $slot;
                                                            $ts = time();
                                                            $qr_link = "http://localhost/qrattendance/mark_attendance.php?lecture_id=$lecture_id&ts=$ts";
                                                            $qr_url = "https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=" . urlencode($qr_link);

                                                            echo "<br><img src='$qr_url' class='mt-2' alt='QR Code' width='150' />";
                                                        }
                                                    }
                                                }
                                                ?>
                                            </td>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require('footer.php'); ?>
