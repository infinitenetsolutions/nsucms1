<?php
include "../config.php";
include '../../framwork/main.php';
$search_data = $_GET['search'];
if ($search_data != '') {
    $query = "SELECT * FROM `tbl_income` WHERE `reg_no` LIKE '%$search_data%' || `course` LIKE '%$search_data%' || `academic_year` LIKE '%$search_data%' || `received_date` LIKE '%$search_data%' || `particulars` LIKE '%$search_data%' || `amount` LIKE '%$search_data%' || `payment_mode` LIKE '%$search_data%' || `check_no` LIKE '%$search_data%' || `bank_name` LIKE '%$search_data%' || `income_from` LIKE '%$search_data%' || `post_at` LIKE '%$search_data%'  &&  `amount`!='' ORDER BY id DESC LIMIT 100 ";
    $results = mysqli_query($con, $query) or die("database error:" . mysqli_error($con));
?>


    <table id="dtHorizontalExample" class="table table-bordered table-striped table-responsive">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Date</th>
                <th>Reg No/Form No</th>
                <th>Name</th>
                <th>Course</th>
                <th>Session</th>
                <th>Particulars</th>
                <th>Amount</th>
                <th>Payment Mode</th>
                <th>Cheque/DD/Online No</th>
                <th>Payment Date</th>
                <th>Bank Name</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $s_no = 1;
            while ($order = mysqli_fetch_array($results)) {
                if ($order["amount"] != "") {
            ?>
                    <tr>
                        <td><?php echo $s_no; ?></td>
                        <td><?php echo date("d-m-Y", strtotime($order["post_at"])); ?></td>
                        <td>
                            <?php
                            if (strpos($order["reg_no"], "Extra Income") === false)
                                echo $order["reg_no"];
                            else
                                echo "Extra Income";
                            ?>

                        </td>
                        <?php
                        if (strpos($order["reg_no"], "Extra Income") === false) {
                            $remove_admission = str_replace("(Reg No)", "", $order["reg_no"]);
                            $sql_name = "SELECT * FROM `tbl_admission` WHERE `admission_id` = '" . $remove_admission . "' ";
                            $result_name = $con->query($sql_name);
                            if ($result_name->num_rows > 0) {
                                $row_name = $result_name->fetch_assoc();
                        ?>
                                <td><?php echo strtoupper($row_name["admission_first_name"]) . " " . strtoupper($row_name["admission_middle_name"]) . " " . strtoupper($row_name["admission_last_name"]); ?></td>
                            <?php

                            } else {
                                $remove_prospectus = str_replace("(Form No)", "", $order["reg_no"]);
                                $sql_name1 = "SELECT * FROM `tbl_prospectus` WHERE `prospectus_no` = '" . $remove_prospectus . "' ";
                                $result_name1 = $con->query($sql_name1);
                                $row_name1 = $result_name1->fetch_assoc();
                            ?>
                                <td><?php echo strtoupper($row_name1["prospectus_applicant_name"]); ?></td>
                        <?php
                            }
                        } else {
                            echo "<td> " . strtoupper("From " . str_replace("Extra Income", "", str_replace(")", "", str_replace("(", "", $order["reg_no"])))) . " </td>";
                        }
                        ?>

                        <?php
                        $sql_course = "SELECT * FROM `tbl_course` WHERE `course_id` = '" . $order["course"] . "' ";
                        $result_course = $con->query($sql_course);
                        $row_course = $result_course->fetch_assoc();
                        ?>
                        <td><?php echo $row_course["course_name"]; ?></td>
                        <?php
                        $sql_session = "SELECT * FROM `tbl_university_details` WHERE `university_details_id` = '" . $order["academic_year"] . "' ";
                        $result_session = $con->query($sql_session);
                        $row_session = $result_session->fetch_assoc();
                        ?>
                        <td><?php echo intval($row_session["university_details_academic_start_date"]) . " - " . intval($row_session["university_details_academic_end_date"]); ?></td>
                        <td><?php
                            if (strpos($order["reg_no"], "Extra Income") === false)
                                echo strtoupper($order["particulars"]);
                            else
                                echo " " . $order["particulars"] . " From " . str_replace("Extra Income", "", str_replace(")", "", str_replace("(", "", $order["reg_no"])));
                            ?>

                        </td>
                        <td><?php echo $order["amount"]; ?></td>
                        <td><?php echo $order["payment_mode"]; ?></td>
                        <td><?php echo  $order["check_no"]; ?></td>
                        <td><?= date('d-m-Y', strtotime(fetchRow('tbl_fee_paid', 'student_id=' . str_replace('(Reg No)', '', $order["reg_no"]))['transaction_date'] == '' ? fetchRow('tbl_prospectus', ' prospectus_no=' . str_replace('(Form No)', '', $order["reg_no"]))['transaction_date'] : fetchRow('tbl_fee_paid', 'student_id=' . str_replace('(Reg No)', '', $order["reg_no"]))['transaction_date']))
                            ?></td>
                        <td><?php echo $order["bank_name"]; ?></td>

                        <td><?= fetchRow('tbl_fee_paid', 'student_id=' . str_replace('(Reg No)', '', $order["reg_no"]))['print_generated_by'] == '' ? fetchRow('tbl_prospectus', ' prospectus_no=' . str_replace('(Form No)', '', $order["reg_no"]))['user_name'] : fetchRow('tbl_fee_paid', 'student_id=' . str_replace('(Reg No)', '', $order["reg_no"]))['print_generated_by']
                            ?></td>


                    </tr>
            <?php
                    $s_no++;
                }
            }

            ?>
        </tbody>
    </table>
<?php } else { ?>

    <script>
        window.location.reload;
    </script>

<?php } ?>