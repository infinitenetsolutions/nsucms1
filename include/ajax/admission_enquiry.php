<?php
include '../config.php';
$data = $_GET['data'];

$admission_query = "SELECT * FROM `tbl_admission` WHERE  `admission_first_name` LIKE '%$data%' || `admission_course_name` LIKE '%$data%' ||`admission_session` LIKE '%$data%'  || `admission_username` LIKE '%$data%'  || `admission_emailid_student` LIKE '%$data%'  || `admission_mobile_student` LIKE '%$data%'  || `admission_state` LIKE '%$data%'  || `admission_city` LIKE '%$data%'  || `admission_district` LIKE '%$data%'  || `admission_gender` LIKE '%$data%'  && `stud_status`='1' ";
$admission_result = $con->query($admission_query);
$s_no = 1;
if (mysqli_num_rows($admission_result) > 0) {
    while ($row = $admission_result->fetch_assoc()) {
?>
        <tr>
            <td><?php echo $s_no; ?></td>
            <?php
            //   i heve to check prospectus course name value interger or charater

            $prospectus_course_name = $row["admission_course_name"];
            $course_no_query = "SELECT * FROM `tbl_course` WHERE `course_id`='$prospectus_course_name'";
            $course_no_result = mysqli_query($con, $course_no_query);
            $data_row1 = mysqli_fetch_array($course_no_result);
            $prospectus_course = $data_row1['course_name'];
            $course_session = $data_row1['course_duration'];
            if ($course_session == 2) {
                $course_session = date('Y') . '-' . date('Y', strtotime('+2 year'));
            } elseif ($course_session == 3) {
                $course_session = date('Y') . '-' . date('Y', strtotime('+3 year'));
            } else {
                $course_session = date('Y') . '-' . date('Y', strtotime('+4 year'));
            }

            ?>
            <td><?php echo $prospectus_course  ?></td>

            <td><?php echo $row["admission_title"];
                echo " ";
                echo $row['admission_first_name']; ?></td>
            <td><?php echo $row["admission_emailid_student"] ?></td>
            <td><?php echo $row["admission_mobile_student"] ?></td>
            <td><?php echo $course_session ?></td>
            <td><?php echo $row["admission_state"] ?></td>
            <td><?php echo $row["admission_city"] ?></td>
            <td><?php echo $row["admission_gender"] ?></td>
            <td><?php echo $row["admission_district"] ?></td>
            <td>
                <a href="admission_form_view?edit=<?php echo $row["admission_id"];  ?>" class="btn btn-secondary btn-sm">
                    <i class="fas fa-eye">
                    </i>

                </a>
            </td>
            <td>
                <a href="admission_form_update?edit=<?php echo $row["admission_id"];  ?>" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit">
                    </i>

                </a>
            </td>
            <td>
                <button class="btn btn-danger btn-sm" onclick="document.getElementById('delete_university_get_enquiry<?php echo $row['id']; ?>').style.display='block'">
                    <i class="fas fa-trash">
                    </i>

                </button>
            </td>


        </tr>
<?php
        $s_no++;
    }
} else{
    echo '
    <td colspan="15">
                                <div class="alert alert-warning alert-dismissible">
                                    <i class="icon fas fa-exclamation-triangle"></i>  No data available now!!!
                                </div>  </td>';

}
if($data==''){ ?>
<script>
    window.location.replace('../srinath/admission-enquiry')
</script>
<?php }?>