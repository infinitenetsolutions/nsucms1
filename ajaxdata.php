<?php
include 'include/config.php';
$id = $_POST['depart'];   // id
$visible = md5("visible");

// var_dump($id);exit();
$sql = "SELECT semester_id,semester FROM tbl_semester WHERE course_id=".$id." && status='".$visible."'";
// var_dump("SELECT semester_id,semester FROM tbl_semester WHERE course_id=".$id." && status= ".$visible);exit();

$result = mysqli_query($con,$sql);
while( $row = mysqli_fetch_array($result) ){
    
   echo '<option value="'.$row['semester_id'].'">'.$row['semester'].'   </option>';
}
?>