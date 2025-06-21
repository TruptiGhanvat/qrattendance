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
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 p-1 rounded-4" style="background: #eee;">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item">Students</li>
            <li class="breadcrumb-item">Details</li>
            <li class="breadcrumb-item active" aria-current="page">Update</li>
        </ol>
    </nav>
</div>


<!-- Blank Start -->
<div class="container-fluid pt-4 px-4">
    <?php
    if (isset($_GET['enroll'])) {
        $enroll = mysqli_escape_string($conn, $_GET['enroll']);
        $sql = "SELECT * FROM students WHERE enrollment_no='$enroll'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
    }
    ?>


    <div class="row bg-light rounded mx-0">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <form action="api_stud.php?type=update" method="post">
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-3 col-form-label">Enrollment No</label>
                        <div class="col-sm-9">
                            <input type="text" name="enrollmentno" class="form-control" value="<?php echo $enroll; ?>" id="inputEmail3" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputPassword3" class="col-sm-3 col-form-label">Student Name</label>
                        <div class="col-sm-9">
                            <input type="text" name="studentname" value="<?php echo $row['name']; ?>" class="form-control" id="inputPassword3">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputPassword3" class="col-sm-3 col-form-label">Select Semeter</label>
                        <div class="col-sm-9">
                            <select class="form-select" name="semester" value="<?php echo $row['semester']; ?>" required>
                                <option selected="">Open this select menu</option>
                                <option value="1" <?php if ($row['semester'] == '1') echo ' selected="selected"'; ?>>First</option>
                                <option value="2" <?php if ($row['semester'] == '2') echo ' selected="selected"'; ?>>Second</option>
                                <option value="3" <?php if ($row['semester'] == '3') echo ' selected="selected"'; ?>>Third</option>
                                <option value="4" <?php if ($row['semester'] == '4') echo ' selected="selected"'; ?>>Fourth</option>
                                <option value="5" <?php if ($row['semester'] == '5') echo ' selected="selected"'; ?>>Fifth</option>
                                <option value="6" <?php if ($row['semester'] == '6') echo ' selected="selected"'; ?>>Sixth</option>
                                <option value="7" <?php if ($row['semester'] == '7') echo ' selected="selected"'; ?>>Seven</option>
                                <option value="8" <?php if ($row['semester'] == '8') echo ' selected="selected"'; ?>>Eight</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputPassword3" class="col-sm-3 col-form-label">Branch</label>
                        <div class="col-sm-9">
                            <select class="form-select" name="branch" value="<?php echo $row['branch']; ?>" required>
                                <option selected="">Open this select menu</option>
                                <option value="Computer Science And Engineering" <?php if ($row['branch'] == 'Computer Science And Engineering') echo ' selected="selected"'; ?>>Computer Science And Engineering</option>
                                <option value="Mechanical Engineering" <?php if ($row['branch'] == 'Mechanical Engineering') echo ' selected="selected"'; ?>>Mechanical Engineering</option>
                                <option value="Electrical Engineering" <?php if ($row['branch'] == 'Electrical Engineering') echo ' selected="selected"'; ?>>Electrical Engineering</option>
                                <option value="Civil Engineering" <?php if ($row['branch'] == 'Civil Engineering') echo ' selected="selected"'; ?>>Civil Engineering</option>
                                <option value="Electronics And Telecommunication Engineering" <?php if ($row['branch'] == 'Electronics And Telecommunication Engineering') echo ' selected="selected"'; ?>>Electronics And Telecommunication Engineering</option>
                                <option value="Artificial Intelligence And Data Science Engineering" <?php if ($row['branch'] == 'Artificial Intelligence And Data Science Engineering') echo ' selected="selected"'; ?>>Artificial Intelligence And Data Science Engineering</option>
                                <option value="Computer Science And (Cyber Security) Engineering" <?php if ($row['branch'] == 'Computer Science And (Cyber Security) Engineering') echo ' selected="selected"'; ?>>Computer Science And (Cyber Security)  Engineering</option>
                                <option value="Robotics And Artificial Intelligence Engineering" <?php if ($row['branch'] == 'Robotics And Artificial Intelligence Engineering') echo ' selected="selected"'; ?>>Robotics And Artificial Intelligence Engineering</option>
                                <option value="Mechatronics Engineering" <?php if ($row['branch'] == 'Mechatronics Engineering') echo ' selected="selected"'; ?>>Mechatronics Engineering</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputPassword3" class="col-sm-3 col-form-label">Shift</label>
                        <div class="col-sm-9">
                            <select class="form-select" name="shift" value="<?php echo $row['shift']; ?>" required>
                                <option selected="">Open this select menu</option>
                                <option value="1" <?php if ($row['shift'] == '1') echo ' selected="selected"'; ?>>First</option>
                                <option value="2" <?php if ($row['shift'] == '2') echo ' selected="selected"'; ?>>Second</option>
                                <option value="3" <?php if ($row['shift'] == '3') echo ' selected="selected"'; ?>>Third</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputPassword3" class="col-sm-3 col-form-label">Assign Roll No</label>
                        <div class="col-sm-9">
                            <input type="text" name="rollno" class="form-control" value="<?php echo $row['roll_no']; ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputPassword3" class="col-sm-3 col-form-label">Select Batch</label>
                        <div class="col-sm-9">
                            <select class="form-select" name="batch" value="<?php echo $row['batch']; ?>" required>
                                <option selected="">Open this select menu</option>
                                <option value="A1" <?php if ($row['batch'] == 'T1') echo ' selected="selected"'; ?>>T1</option>
                                <option value="A2" <?php if ($row['batch'] == 'T2') echo ' selected="selected"'; ?>>T2</option>
                                <option value="A3" <?php if ($row['batch'] == 'T3') echo ' selected="selected"'; ?>>T3</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputPassword3" class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-9">
                            <input type="text" name="password" class="form-control" value="<?php echo $row['password']; ?>">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Blank End -->


<?php
require('footer.php');
?>