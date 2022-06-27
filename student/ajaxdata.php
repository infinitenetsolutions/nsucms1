<?php
include 'include/config.php';
$id = $_POST['depart1'];   // id
// var_dump($id);exit();
$sql = "SELECT exam_fee,exam_fine,fee_status FROM tbl_semester WHERE semester_id=".$id;
//var_dump("SELECT exam_fee FROM tbl_semester WHERE semester_id=".$id);exit();

$result = mysqli_query($con,$sql);
while( $row = mysqli_fetch_array($result) ){
    if($row["fee_status"]=="Active")
	{
   echo $row['exam_fee']+ $row['exam_fine'];
	}
	else
	{
  echo $row['exam_fee'];
	}
}
?>