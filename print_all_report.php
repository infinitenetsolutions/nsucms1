<?php 
	include 'include/qr-lib/qrlib.php'; 
	    $visible = md5("visible");

	if(isset($_POST["course_id"]) && isset($_POST["academic_year"]) && isset($_POST["semester_id"])){
	   // ini_set('display_errors', 1);
    //     ini_set('display_startup_errors', 1);
    //     error_reporting(E_ALL);
		?>
		<?php
			$course_id = $_POST["course_id"];
			$academic_year = $_POST["academic_year"];
			$semester_id = $_POST["semester_id"];
			$page_no = "11";
			$page_no_inside = "11_6";
			include "include/authentication.php";
			$path = 'images/';
			//error_reporting(0);
			   
				$sql = "SELECT * FROM `tbl_allot_semester`
						INNER JOIN `tbl_admission` ON `tbl_allot_semester`.`admission_id` = `tbl_admission`.`admission_id`
						INNER JOIN `tbl_admission_details` ON `tbl_allot_semester`.`admission_id` = `tbl_admission_details`.`admission_id`
						INNER JOIN `tbl_university_details` ON `tbl_admission`.`admission_session` = `tbl_university_details`.`university_details_id`
						WHERE `tbl_allot_semester`.`status` = '$visible' && `tbl_allot_semester`.`academic_year` = '$academic_year' && `tbl_allot_semester`.`course_id` = '$course_id' && `tbl_allot_semester`.`semester_id` = '$semester_id' ORDER BY `tbl_allot_semester`.`reg_no` ASC
						
				";		
				$result = $con->query($sql);
				//$row = $result->fetch_assoc();
					/*while($row = $result->fetch_assoc()){
						echo "<pre>";
						print_r($row);
					}
					exit;*/
				?>
				<html>
				<head>
					<style>
						body {
							margin: 0;
							padding: 0;
							font: 12pt ;
							 font-family: Arial, Helvetica, sans-serif;		
							 }

						* {
							box-sizing: border-box;
							-moz-box-sizing: border-box;
						}

						.page {
							width: 21cm;
							min-height: 29.7cm;
							padding: 2cm;
							margin: 1cm auto;
							border: 1px #D3D3D3 solid;
							border-radius: 5px;
							background-image:  url(images/marksheet/nsu_print_bg.png);
							background-size: cover;
							background-position: fixed;
							background-repeat: no-repeat;           
							box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
						}

						.subpage {
							padding: 0cm;
							height: 256mm;
						}
						
        					u {
                            text-decoration: none;
                            border-bottom: 2px solid black;
                          }

						@page {
							size: A4;
							margin: 0;
						}

						@media print {
							.page {
								margin: 0;
								border: initial;
								border-radius: initial;
								width: initial;
								min-height: initial;
								box-shadow: initial;            
								page-break-after: always;
							}
						}
								.footer {
									   position: fixed;
									   left: 57px;
									   bottom: 0;
									   width: 88%;
									   color: black;
									   text-align: center;
									}

									.courseText h5 {
									font-size: 15px;
									text-align: center;
									margin-top: -24px;
									}
									table {
									  border-collapse: collapse;
									}
									table {
									  width: 706px;
									  margin-left: -28px;
									}

									table, th, td {
									  border: 1px solid black;
									  text-align: center;

									}
									
									.courseText h5 {font-size: 18px;text-align: center;margin-top: -24px;}
									.tableText {margin: 5px 0;margin-left: -28px;}
									.qr-code {position: relative;}
									.qr-code img {position: absolute; top: 0px; left: 50px;}
						
					</style>
				</head>

				<body>
					<div class="book">
						<?php 
							while($row = $result->fetch_assoc()){
							$sql_course = "SELECT * FROM `tbl_course`
										   WHERE `status` = '$visible' && `course_id` = '".$row["course_id"]."';
										   ";
							$result_course = $con->query($sql_course);
							$row_course = $result_course->fetch_assoc();
											
							$sql_semester = "SELECT * FROM `tbl_semester`
										   WHERE `status` = '$visible' && `semester_id` = '".$row["semester_id"]."';
										   ";
							$result_semester = $con->query($sql_semester);
							$row_semester = $result_semester->fetch_assoc(); 

                                $sql_count = "SELECT COUNT(subject_name) as sub,course_id FROM `tbl_subjects` 
							              WHERE `status` = '$visible' && course_id= '".$row["course_id"]."' && semester_id= '".$row["semester_id"]."'
										  ";
								$result_count = $con->query($sql_count);
								$row_count = $result_count->fetch_assoc();								
														
							$completeSessionStart = explode("-", $row["university_details_academic_start_date"]);
							$completeSessionEnd = explode("-", $row["university_details_academic_end_date"]);
							$completeSessionOnlyYear = $completeSessionStart[0]."-".$completeSessionEnd[0];
							$grandtotal = 0;
							$passmarks_total = 0;
							$sql_get = "SELECT * FROM `tbl_marks` 
								  INNER JOIN `tbl_subjects` ON `tbl_marks`.`subject_id` = `tbl_subjects`.`subject_id`
								  WHERE `tbl_marks`.`status` = '$visible' &&  `tbl_subjects`.`status`= '$visible' && `tbl_marks`.`semester_id` = '".$row["semester_id"]."' && `tbl_marks`.`course_id` = '".$row["course_id"]."' && `tbl_marks`.`fee_academic_year` = '".$row["university_details_id"]."' &&  `tbl_marks`.`reg_no` = '".$row["reg_no"]."' 
								  ORDER BY `tbl_subjects`.`subject_id` ASC";	
							$row_get = $con->query($sql_get);


							while($rows = $row_get->fetch_assoc()){ 
								$grandtotal = $grandtotal + $rows['internal_marks'] + $rows["external_marks"] ;
								$passmarks_total = $passmarks_total + $rows["pass_marks"];
							}
							
							
							
						?>
						<?php
							if ($grandtotal >= $passmarks_total)
							{
								$resultVar = "PASS";
							}else
							{
								$resultVar = "FAIL";
							}
							$data = array(
										"University"         =>  "nsuniv.ac.in",
										"Reg No"             =>  $row["reg_no"],
										"Academic Session"   =>  $completeSessionOnlyYear,
										"Course"             =>  $row_course["course_name"],
										"Student Name"       =>  $row["admission_first_name"],
										"Fathers Name"       =>  $row["admission_father_name"],
										"Result"             =>  $resultVar
									);
								
							  // Include the qrlib file 
							 
							$file = $path.uniqid().uniqid().".png"; 
							// $ecc stores error correction capability('L') (LOW)
							// $ecc stores error correction capability('H') (HIGH)
							$ecc = 'H'; 
							$pixel_Size = 10; 
							$frame_Size = 1;
							// Generates QR Code and Stores it in directory given 
							QRcode::png(json_encode($data), $file, $ecc, $pixel_Size, $frame_Size);
							$sql_check = "SELECT * FROM `tbl_barcode` WHERE `student_id` = '".$row['admission_id']."' ";
							$result_qr = $con->query($sql_check);
							if ($result_qr) {
							  if($result_qr->num_rows > 0){
								$row_qr = $result_qr->fetch_assoc();
								unlink($row_qr["barcode_image"]);
								
								$sql_update = "UPDATE `tbl_barcode` SET  `total_marks` = '$grandtotal', `barcode_image` = '$file'  WHERE `student_id` = '".$row['admission_id']."' ";
								$con->query($sql_update);
							  } else {
								$sql_insert="INSERT INTO `tbl_barcode`(`barcode_id`,`student_id`,`total_marks`,`barcode_image`,`result`)
											 VALUES('','".$row['admission_id']."','$grandtotal','$file','$resultVar')";
								$query=mysqli_query($con,$sql_insert);
							  }
							}  
						?>
						<div class="page">
							<div class="subpage">
								<img  height='100px' style='margin-left: -30px; margin-top: -35px;' width='100px' src='<?= $file ?>'>
								<p style="margin-top: -98px;margin-right: -38px; text-align: right;"><b>Sl No: <?php echo $row["serial_no"] ?></b></p>
								<center><img src="images/marksheet/nsu_image.png" style="height:278px; margin-top:-15px; margin-left: -11px;"/></center>
							
								<div class="courseText mb3">
									<h5><u><?php echo $row_semester["semester"] ?> Examination - 2020</u></h5>
								</div>
								<div class="tableText" style="width: 706px;">
								  <p style="text-align: left; line-height: 50%;"><b>NAME </b>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;: <b style="font-size: 18px;"><?php echo $row["admission_first_name"]." ".$row["admission_middle_name"]." ".$row["admission_last_name"]  ?></b>&nbsp;</p>              
								  <p style="text-align: left; line-height: 50%;"><b>FATHER'S NAME </b>&emsp;&emsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : <b style="font-size: 14px;"><?php echo $row["admission_father_name"] ?></b></p>                          
								  <p style="text-align: left; line-height: 50%;"><b>NAME OF THE SCHOOL </b>&nbsp;: <b style="font-size: 14px;"><?php echo $row_semester["name_of_school"] ?></b></p>
								  <p style="text-align: left; line-height: 50%;"><b>NAME OF THE COURSE </b>&nbsp;: <b style="font-size: 14px;">
								   <?php 
								   if (( $row_course["course_name"] )== "BBA")
								    { 
								    echo "BACHELOR OF BUSINESS ADMINISTRATION";
								    }  else if (( $row_course["course_name"] )== "MBA")
									{ 
								    echo "MASTER OF BUSINESS ADMINISTRATION";
									}  else if (( $row_course["course_name"] )== "B.COM")
									{ 
								    echo "BACHELOR OF COMMERCE";
									}  else if (( $row_course["course_name"] )== "M.COM")
									{ 
								    echo "MASTER OF COMMERCE";
									}  else if (( $row_course["course_name"] )== "BCA")
									{ 
								    echo "BACHELOR OF  COMPUTER APPLICATION";
									}  else if (( $row_course["course_name"] )== "MCA")
									{ 
								    echo "MASTER OF  COMPUTER APPLICATION";
									}  else if (( $row_course["course_name"] )== "B.SC(IT)")
									{ 
								    echo "BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY";
									}  else if (( $row_course["course_name"] )== "M.SC(IT)")
									{ 
								    echo "MASTER OF SCIENCE IN INFORMATION TECHNOLOGY";
									}  else if (( $row_course["course_name"] )== "B.PHARM")
									{ 
								    echo "BACHELOR OF PHARMACY";
									}  else if (( $row_course["course_name"] )== "D.PHARM")
									{ 
								    echo "DIPLOMA OF PHARMACY";
									}  else if (( $row_course["course_name"] )== "B.ED")
									{ 
								    echo "BACHELOR OF EDUCATION";
									}  else if (( $row_course["course_name"] )== "B.Sc in Hotel Management")
									{ 
								    echo "B.SC IN HOTEL MANAGEMENT";
									}  else if (( $row_course["course_name"] )== "B.Sc IN Travel & Tourism Management")
									{ 
								    echo "B.Sc IN Travel & Tourism Management";
									}  else if (( $row_course["course_name"] )== "LLB")
									{ 
								    echo "BACHELOR OF LEGISLATIVE LAW";
									}  else if (( $row_course["course_name"] )== "BBA LLB")
									{ 
								    echo "BACHELOR OF BUSINESS ADMINISTRATION AND BACHELOR OF LAWS";
									}  else if (( $row_course["course_name"] )== "B.Sc (BOTANY)")
									{ 
								    echo "BACHELOR OF SCIENCE - BOTANY";
									}  else if (( $row_course["course_name"] )== "B.Sc (ZOOLOGY)")
									{ 
								    echo "BACHELOR OF SCIENCE - ZOOLOGY";
									}  else if (( $row_course["course_name"] )== "B.Sc (MATHEMATICS)")
									{ 
								    echo "BACHELOR OF SCIENCE - MATHEMATICS";
									}  else if (( $row_course["course_name"] )== "B.SC (PHYSICS)")
									{ 
								    echo "BACHELOR OF SCIENCE - PHYSICS";
									}  else if (( $row_course["course_name"] )== "B.SC (CHEMISTRY)")
									{ 
								    echo "BACHELOR OF SCIENCE - CHEMISTRY";
									}  else if (( $row_course["course_name"] )== "M.Sc (BOTANY)")
									{ 
								    echo "MASTER OF SCIENCE - BOTANY";
									}  else if (( $row_course["course_name"] )== "M.Sc (ZOOLOGY)")
									{ 
								    echo "MASTER OF SCIENCE - ZOOLOGY";
									}  else if (( $row_course["course_name"] )== "M.Sc (MATHEMATICS)")
									{ 
								    echo "MASTER OF SCIENCE - MATHEMATICS";
									}  else if (( $row_course["course_name"] )== "M.SC (PHYSICS)")
									{ 
								    echo "MASTER OF SCIENCE - PHYSICS";
									}  else if (( $row_course["course_name"] )== "M.SC (CHEMISTRY)")
									{ 
								    echo "MASTER OF SCIENCE - CHEMISTRY";
									}  else if (( $row_course["course_name"] )== "B.TECH")
									{ 
								    echo "B.TECH";
									}  else if (( $row_course["course_name"] )== "POLYTECHNIC")
									{ 
								    echo "POLYTECHNIC";
									}  else if (( $row_course["course_name"] )== "B.A")
									{ 
								    echo "BACHELOR OF ARTS";
									}  else if (( $row_course["course_name"] )== "M.A")
									{ 
								    echo "MASTER OF ARTS";
									}  else if (( $row_course["course_name"] )== "Event Management")
									{ 
								    echo "Event Management";
									}  else if (( $row_course["course_name"] )== "B.A IN JOURNALISM & MASS COMM.")
									{ 
								    echo "BACHELOR OF ARTS IN JOURNALISM & MASS COMMUNICATION";
									}  else if (( $row_course["course_name"] )== "M.A IN JOURNALISM & MASS COMM.")
									{ 
								    echo "MASTER OF ARTS IN JOURNALISM & MASS COMMUNICATION";
									}  else if (( $row_course["course_name"] )== "FASHION DESIGNING")
									{ 
								    echo "FASHION DESIGNING";
									}  else if (( $row_course["course_name"] )== "INTERIOR DESIGNING")
									{ 
								    echo "INTERIOR DESIGNING";
									}  else if (( $row_course["course_name"] )== "PHD")
									{ 
								    echo "PHD";
									}  else if (( $row_course["course_name"] )== "B.A (Economics)")
									{ 
								    echo "BACHELOR OF ARTS - ECONOMIC (HONS.)";
									}  else if (( $row_course["course_name"] )== "B.A (Geography)")
									{ 
								    echo "BACHELOR OF ARTS - GEOGRAPHY (HONS.)";
									}  else if (( $row_course["course_name"] )== "B.A (Political Science)")
									{ 
								    echo "BACHELOR OF ARTS - POLITICAL SCIENCE (HONS.)";
									}  else if (( $row_course["course_name"] )== "B.A (English)")
									{ 
								    echo "BACHELOR OF ARTS - ENGLISH (HONS.)";
									}  else if(( $row_course["course_name"] )== "Diploma in Engineering")
									{ 
								    echo "DIPLOMA IN ENGINEERING";
									}
							    	?>   
								  </b></p>
								  <p style="text-align: left; line-height: 50%;"><b>UNIVERSITY REG No. </b>&nbsp;&nbsp;&nbsp;&nbsp; : <b style="font-size: 14px;"><?php echo $row["reg_no"] ?></b></p>
								  <p style="text-align: left; line-height: 50%;"><b>UNIVERSITY ROLL No. </b>&nbsp;&nbsp;&nbsp;: <b style="font-size: 14px;"><?php echo $row["roll_no"] ?></b></p>
								  <p style="text-align: left; line-height: 50%;"><b>EXAMINATION TYPE </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : <b style="font-size: 14px;"><?php echo $row["type"] ?></b></p>
								  <p style="text-align: left; line-height: 50%;"><b>Examination held in the month of <?php echo $row_semester["examination_month"] ?></b>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b style="margin-right: -27px;">Session: <?php echo $completeSessionOnlyYear ; ?></b></p>
								</div>
								
								 <table style="font-size: 14px;">
									 <tr>
										<th rowspan='2' style="background: #f7bb84d6;width:15%;">COURSE CODE</th>
										<th rowspan='2' style="background: #f7bb84d6;">SUBJECT NAME</th>
										<th rowspan='2' style="background: #f7bb84d6;">FULL<br>MARKS</th>
										<th rowspan='2' style="background: #f7bb84d6;">PASS<br>MARKS</th>
										<th colspan="2" style="background: #f7bb84d6;">MARKS SECURED</th>
										<th rowspan="2" style="background: #f7bb84d6;">TOTAL<br>MARKS<br>OBTD.</th>
									  </tr>           
									  <tr>
										<th style="background: #f7bb84d6;">INTERNAL<br/>(30)</th>
										<th style="background: #f7bb84d6;">EXTERNAL<br/>(70)</th>
									  </tr>
										  <?php 	
											$sql_get = "SELECT * FROM `tbl_marks` 
													  INNER JOIN `tbl_subjects` ON `tbl_marks`.`subject_id` = `tbl_subjects`.`subject_id`
													  WHERE `tbl_marks`.`status` = '$visible' &&  `tbl_subjects`.`status`= '$visible' && `tbl_marks`.`semester_id` = '".$row["semester_id"]."' && `tbl_marks`.`course_id` = '".$row["course_id"]."' && `tbl_marks`.`fee_academic_year` = '".$row["university_details_id"]."' &&  `tbl_marks`.`reg_no` = '".$row["reg_no"]."' 
													  ORDER BY `tbl_subjects`.`subject_id` ASC";	
											$row_get = $con->query($sql_get);
											
											 $grandtotals = 0 ;
											 $countLine = 0;
											 $iPer = 0;
											 while($rows = $row_get->fetch_assoc()){ 
											 $grandtotals = $grandtotals + $rows['internal_marks'] + $rows["external_marks"] ;
											 $passmarks_total = $passmarks_total + $rows["pass_marks"];
										        $iPer++;
										        if(strlen($rows["subject_name"]) > 35 && strlen($rows["subject_name"]) <= 70)
										            $countLine = $countLine + 1;
										        else if(strlen($rows["subject_name"]) > 70 && strlen($rows["subject_name"]) <= 105)
										                $countLine = $countLine + 2;
										        else if(strlen($rows["subject_name"]) > 105 && strlen($rows["subject_name"]) <= 140)
										                $countLine = $countLine + 3;
										        else if(strlen($rows["subject_name"]) > 140)
										                $countLine = $countLine + 4;
										 ?>
									  <tr>
										<td><?php echo $rows["subject_code"] ?></td>
										<td style="text-align: left;"><?php echo $rows["subject_name"] ?></td>
										<td><?php echo $rows["full_marks"] ?></td>
										<td><?php echo $rows["pass_marks"] ?></td>
										<td><?php echo $rows["internal_marks"] ?></td>
										<td><?php echo $rows["external_marks"] ?></td>   
										<?php $sum_total =  $rows["internal_marks"] + $rows["external_marks"] ; ?>
										<td><b><?php  echo $sum_total; ?></b></td>    
									  </tr>
										 <?php }		 
										 ?>
											   
									  <tr class="tableLastChild">
										  <td colspan="4" style="border-block-end-color: white;border-left: 2px solid #00000000;padding:0;"><br><p style="margin-block-start: -12px;margin-left: -190px;"><b>Date of Publication of Result: <?php echo date("d/m/Y", strtotime($row_semester["date_of_result"])) ?></b></p></td>
										<td colspan="2" style="text-align: right;"><b>GRAND TOTAL</b></td>
										  <td><b><?php echo $grandtotals; ?></b></td>					  
									  </tr>
										<tr class="">
										  <td colspan="7" style="border-block-end-color: white;border-left: 2px solid #00000000; border-right: 2px solid #00000000; padding:0;"><br/><br/></td>				  
									  </tr>
									 <tr class="">
										  <td colspan="4" style="border-block-end-color: white;border-left: 2px solid #00000000; border-top: 2px solid #00000000; padding:0;"></td>
										  <td colspan="2" style="border-block-end-color: white; border-left: 2px solid #00000000;padding:0; text-align:right"><b>PERCENTAGE &nbsp;</b></td>
										  <td style="border-block-end-color: white;border-left: 2px solid #00000000;  border-right: 2px solid #00000000; padding:0; text-align:left"> : &nbsp;<b><?php $divnum = ($grandtotals) / $row_count["sub"] ;
	                                       $number = $divnum;
                                           echo round($number, 2);
	                                        
	                                      
	                                       ?></b></td>					  
									  </tr>
									  <tr class="">
										  <td colspan="4" style="border-block-end-color: white;border-left: 2px solid #00000000;padding:0;"></td>
										  <td colspan="2" style="border-block-end-color: white;border-left: 2px solid #00000000;padding:0; text-align:right;"><b>RESULT &nbsp;<b></td>
										  <td style="border-block-end-color: white;border-left: 2px solid #00000000; border-right: 2px solid #00000000; padding:0; text-align:left"> : &nbsp;<b><?= $resultVar ?></b></td>					  
									  </tr>
								  </table><br/>
								 <!--<div class="tableText" style="width: 706px;">
								 <p style="text-align: right; line-height: 50%;"><b style="">PERCENTAGE &nbsp;<b style="letter-spacing: 3px;">:</b></b>&nbsp;&nbsp; <b><?php $divnum = ($grandtotals) / $row_count["sub"] ;
	                                       echo $divnum ?></b></p>
								  <p style="text-align: right; line-height: 50%;"><b>RESULT &nbsp;&nbsp;&nbsp;<b style="letter-spacing: 3px;">:</b></b>&nbsp;&nbsp; <b><?= $resultVar ?></b></p>
								</div>-->
								<?php 
								    
								    $perApply = 0;
								    $iPer = $iPer + $countLine;
								    // echo $iPer;
								    switch($iPer):
								        case 2:
								            $perApply = 35;
								            break;
								        case 3:
								            $perApply = 31.5;
								            break;
								        case 4:
								            $perApply = 25;
								            break;
								        case 5:
								            $perApply = 24.5;
								            break;
								        case 6:
								            $perApply = 21;
								            break;
								        case 7:
								            $perApply = 17.5;
								            break;
								        case 8:
								            $perApply = 14;
								            break;
								        case 9:
								            $perApply = 10.5;
								            break;
								        case 10:
								            $perApply = 7;
								            break;
								        case 11:
								            $perApply = 3.5;
								            break;
								        default:
								            $perApply = 0;
								            break;
								    endswitch;
								?>
                                <div class="sub_div">
								<!-- <p style="margin-top:<?= $perApply; ?>%; margin-left: -6%;width: 706px;">-->
								 <p style="margin-top:-5%; margin-left: -6%;width: 706px;">
									<span ><img src="images/sign/manoj.png" style="width: 18%;    margin-left: 19px;"></span>
									<span ><img src="images/sign/sneha.png" style="width: 16%;margin-left: 127px; margin-bottom: 15px;"></span>
									<span ><img src="images/sign/OPS.png" style="width: 20%; margin-bottom: 0px;margin-left: 137px;"></span>
									<span style=" margin-left: -655px;">Tabulator-I</span>
									<span >&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;&nbsp;Tabulator-II</span>
									<span style="margin-left: 34px;" >&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;Controller of Examination</span>
								</p>
								</div>
							</div>
						</div>
						<?php 
							}
						?>
						
					</div>
					<script>
						window.print();
					</script>
				
				</body>

				</html>
			<?php
							
				
	}
?>