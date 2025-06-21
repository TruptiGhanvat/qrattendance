<?php
require('header.php');
require('conn.php');

if ($_SESSION['usertype'] != 'ADMIN') {
    session_destroy();
    header("location: login.php");
    exit();
}
?>
<div class="container pt-3 px-4 m-0">
    <nav style="--bs-breadcrumb-divider: url(...) ;" aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 p-1 rounded-4" style="background: #eee;">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item">Time Table</li>
            <li class="breadcrumb-item active" aria-current="page">Details</li>
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
        <button type="button" class="btn btn-outline-primary m-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <i class="fas fa-plus me-2"></i>Set New Time Table
        </button>
    </div>

    <div class="row bg-light rounded mx-0">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Time Table</h6>
                <form class="row gy-2 gx-3 align-items-center border p-2" action="timetable.php" method="get">
                    <div class="col-auto">
                        <select class="form-select" name="branch" required>
                            <option value="">Select Branch</option>
                            <option value="Computer Science And Engineering">Computer Science And Engineering</option>
                        </select>
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
                if (isset($_GET['batch']) && isset($_GET['semester']) && isset($_GET['academic']) && isset($_GET['branch'])) {
                    $semester = mysqli_escape_string($conn, $_GET['semester']);
                    $batch = mysqli_escape_string($conn, $_GET['batch']);
                    $academic = mysqli_escape_string($conn, $_GET['academic']);
                    $branch = mysqli_escape_string($conn, $_GET['branch']);

                    $sql = "SELECT * FROM `timetable` WHERE `academic_year`='$academic' AND  `branch`='$branch' AND `semester`='$semester' AND `batch`='$batch'";
                    $sqlslot = "SELECT DISTINCT `slotlabel` FROM `timetable` WHERE `academic_year`='$academic' AND  `branch`='$branch' AND `semester`='$semester' AND `batch`='$batch'";
                    $result1 = mysqli_query($conn, $sqlslot);
                    $result2 = mysqli_query($conn, $sql);

                    $slots = [];
                    while ($row = mysqli_fetch_assoc($result1)) {
                        $slots[] = $row['slotlabel'];
                    }

                    $timetable = [];
                    while ($row = mysqli_fetch_assoc($result2)) {
                        $timetable[$row['day']][] = $row['subject_code'];
                    }

                    echo '<h6 class="mb-3 text-center mt-3 text-danger">Time Table Details : Academic Year-['.$academic.'], Branch-['.$branch.'] , Batch-['.$batch.'], Semester-['.$semester.']</h6>';

                    echo '<div class="table-responsive">';
                    echo '<table class="table table-bordered">';
                    echo '<thead><tr><th scope="col">Day</th>';
                    foreach ($slots as $slot) {
                        echo '<th scope="col">'.$slot.'</th>';
                    }
                    echo '</tr></thead><tbody>';

                    $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                    $slotCount = count($slots);
                    foreach ($daysOfWeek as $day) {
                        $dayData = isset($timetable[$day]) ? $timetable[$day] : array_fill(0, $slotCount, '');
                        echo '<tr><td>'.$day.'</td>';
                        for ($i = 0; $i < $slotCount; $i++) {
                            $subjectCode = isset($dayData[$i]) ? $dayData[$i] : '';
                            $subjectSQL = "SELECT * FROM `subjects` WHERE `subject_code`='$subjectCode'";
                            $subjectRes = mysqli_query($conn, $subjectSQL);
                            $subjectRow = mysqli_fetch_assoc($subjectRes);
                            $subjectName = $subjectRow ? $subjectRow['name'] : '';

                            // QR Code
                            $lecture_id = $subjectCode . date("Ymd") . $i;
                            $timestamp = time();
                            $qr_link = "http://localhost/qrattendance/mark_attendance.php?lecture_id=$lecture_id&ts=$timestamp";
                            $qr_url = "https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=".urlencode($qr_link);

                            echo '<td>'.$subjectName;
                            if ($subjectCode != '') {
                                echo '<br><img src="'.$qr_url.'" title="QR Code" alt="QR Code" width="100" />';
                            }
                            echo '</td>';
                        }
                        echo '</tr>';
                    }
                    echo '</tbody></table></div>';
                }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- ✅ Modal for Setting New Lecture -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="insert_lecture.php" method="POST" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Set New Lecture</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <div class="mb-2">
            <label>Academic Year</label>
            <input type="text" class="form-control" name="academic_year" value="2024-25" required>
        </div>

        <div class="mb-2">
            <label>Branch</label>
            <input type="text" class="form-control" name="branch" value="Computer Science And Engineering" required>
        </div>

        <div class="mb-2">
            <label>Semester</label>
            <select name="semester" class="form-control" required>
                <option value="6">6</option>
            </select>
        </div>

        <div class="mb-2">
            <label>Batch</label>
            <select name="batch" class="form-control" required>
                <option value="T1">T1</option>
                <option value="T2">T2</option>
                <option value="T3">T3</option>
            </select>
        </div>

        <div class="mb-2">
            <label>Day</label>
            <select name="day" class="form-control" required>
                <option>Monday</option>
                <option>Tuesday</option>
                <option>Wednesday</option>
                <option>Thursday</option>
                <option>Friday</option>
                <option>Saturday</option>
            </select>
        </div>

        <div class="mb-2">
            <label>Slot Number</label>
            <input type="number" class="form-control" name="slot" placeholder="E.g., 1" required>
        </div>

        <div class="mb-2">
            <label>Slot Label</label>
            <input type="text" class="form-control" name="slotlabel" placeholder="E.g., 9:00-10:00" required>
        </div>

        <div class="mb-2">
            <label>Subject Code</label>
            <input type="text" class="form-control" name="subject_code" placeholder="e.g. CSE601" required>
        </div>

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save Lecture</button>
      </div>
    </form>
  </div>
</div>

<?php require('footer.php'); ?>
