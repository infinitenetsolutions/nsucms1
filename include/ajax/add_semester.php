<?php
$visible = md5('visible');
include '../../include/config.php';
$course_id = $_POST['data'];

// getting the course duration of the course
$course_duration_get = "SELECT * FROM `tbl_course` WHERE `course_id`='$course_id'";
$course_duration_get = $con->query($course_duration_get);
$course_duration = mysqli_fetch_array($course_duration_get)['duration'];



$sql_ac_year = "SELECT * FROM `tbl_university_details`
                                       WHERE `status` = '$visible';
                                       ";
$result_ac_year = $con->query($sql_ac_year);
if (mysqli_num_rows($course_duration_get) > 0) {
    while ($row_ac_year = $result_ac_year->fetch_assoc()) {
?>
        <?php
        $completeSessionStart = explode("-", $row_ac_year["university_details_academic_start_date"]);
        $completeSessionEnd = explode("-", $row_ac_year["university_details_academic_end_date"]);
        $get_course_duration = $completeSessionEnd[0] - $completeSessionStart[0];
        if ($get_course_duration == $course_duration) {
            $completeSessionOnlyYear = $completeSessionStart[0] . "-" . $completeSessionEnd[0];
        ?>
            <option value="<?php echo $row_ac_year["university_details_id"]; ?>"><?php echo $completeSessionOnlyYear; ?></option>
    <?php }
    }
} else { ?>
    <option value="all">All</option>

<?php
} ?>