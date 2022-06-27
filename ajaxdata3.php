<?php
include 'include/config.php';
 $visible = md5("visible");
$id = $_POST['depart'];   // id
$academic_year = $_POST['academic_year']; //academic_year
//echo $visible;
//echo $id; echo $academic_year; 
   //var_dump($id);exit();  $sql = "SELECT * FROM users WHERE username ='".$userName."'";
$sql = "SELECT semester_id,semester,exam_fee FROM tbl_semester WHERE course_id=".$id." && fee_academic_year=".$academic_year." && status ='".$visible."'";
 //var_dump("SELECT semester_id,semester,exam_fee FROM tbl_semester WHERE course_id=".$id." && fee_academic_year=".$academic_year." && status=".$visible);exit();

$result = mysqli_query($con,$sql);
echo "<option>Select</option>";
while( $row = mysqli_fetch_array($result) ){
   
   echo '<option value="'.$row['semester_id'].'">'.$row['semester'].'   </option>';
}
?>