<?php
include '../../include/config.php';
$email = $_GET['email'];
$getting_admin = "SELECT * FROM `tbl_admin` WHERE `admin_email`='$email' ";
$getting_admin_result = mysqli_query($con, $getting_admin);
$admin_getting_data = mysqli_fetch_array($getting_admin_result);
?>
<option value="<?php echo $admin_getting_data['admin_name']; ?>"><?php echo $admin_getting_data['admin_name']; ?></option>