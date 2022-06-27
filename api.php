<?php
include 'include/config.php';
$visible = md5("visible");
$id = $_GET['id'];
 $sql = "SELECT `tbl_admission`.`admission_emailid_student`, `tbl_admission`.`admission_first_name`,`tbl_admission`.`admission_middle_name`,`tbl_admission`.`admission_last_name`, `tbl_university_details`.`academic_session`,`tbl_course`.`course_name` FROM `tbl_admission` join `tbl_university_details` on `tbl_admission`.`admission_session`= `tbl_university_details`.university_details_id join `tbl_course` ON `tbl_admission`.`admission_course_name`= `tbl_course`.`course_id` WHERE `tbl_admission`.`status`='$visible' && `admission_id`=$id";

$result = mysqli_query($con, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    echo json_encode($row);
}
