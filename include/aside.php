<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-olive elevation-4" style="background-color: #8a0410 !important;">
      <!-- Brand Logo -->
      <!--<a href="dashboard" class="brand-link">-->
      <!--    <img src="images/logo.png" alt="NSU Logo" class="brand-image img-circle elevation-3" style="opacity: .8">-->
      <!--    <span class="brand-text font-weight-light" style="font-size: 18px;">Netaji Subhas University</span>-->
      <!--</a>-->

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                  <img src="images/logo.png" class="" alt="User Image" style="width: 6.1rem !important;">
              </div>
              <div class="info">
                  <a href="#" class="d-block" style="margin-top: 4px;font-weight: 900;">NETAJI<br/>SUBHAS <br/>UNIVERSITY</a>
              </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent text-sm" data-widget="treeview" role="menu" data-accordion="false">
                  <li class="nav-item has-treeview" id="menu1">
                      <a href="dashboard" class="nav-link <?php if($page_no == "1"){ echo 'active'; } ?>">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Dashboard
                          </p>
                      </a>
                  </li>
                  <li class="nav-item has-treeview <?php if($page_no == "2"){ echo 'menu-open'; } ?>" <?php if(isset($autority)){ $page_no_temp = 2; if(isset($allAutority->$page_no_temp)){ if($allAutority->$page_no_temp == ""){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                      <a href="#" class="nav-link <?php if($page_no == "2"){ echo 'active'; } ?>">
                          <i class="nav-icon fas fa-book"></i>
                          <p>
                              Administration
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item" <?php if(isset($autority)){ $page_no_temp = 2; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "2_1"){ $flag++; break; } } if($flag == 0){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                              <a href="admin_view" class="nav-link <?php if($page_no_inside == "2_1"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Admin List</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item has-treeview <?php if($page_no == "3"){ echo 'menu-open'; } ?>" <?php if(isset($autority)){ $page_no_temp = 3; if(isset($allAutority->$page_no_temp)){ if($allAutority->$page_no_temp == ""){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                      <a href="#" class="nav-link <?php if($page_no == "3"){ echo 'active'; } ?>">
                          <i class="nav-icon fas fa-tree"></i>
                          <p>
                              Setup
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item" <?php if(isset($autority)){ $page_no_temp = 3; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "3_1"){ $flag++; break; } } if($flag == 0){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                              <a href="add_university_details" class="nav-link <?php if($page_no_inside == "3_1"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>University Details</p>
                              </a>
                          </li>
                          <li class="nav-item" <?php if(isset($autority)){ $page_no_temp = 3; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "3_2"){ $flag++; break; } } if($flag == 0){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                              <a href="course_view" class="nav-link <?php if($page_no_inside == "3_2"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Courses</p>
                              </a>
                          </li>
                          <!--<li class="nav-item">
                              <a href="subject_view" class="nav-link <?php if($page_no_inside == "3_3"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Subjects</p>
                              </a>
                          </li>-->
                      </ul>
                  </li>
                <li class="nav-item has-treeview <?php if($page_no == "4"){ echo 'menu-open'; } ?>" <?php if(isset($autority)){ $page_no_temp = 4; if(isset($allAutority->$page_no_temp)){ if($allAutority->$page_no_temp == ""){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>

                      <a href="#" class="nav-link <?php if($page_no == 4){ echo 'active'; } ?>">
                          <i class="nav-icon fas fa-calendar-alt"></i>
                          <p>
                              Front Office
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item" <?php if(isset($autority)){ $page_no_temp = 4; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "4_1"){ $flag++; break; } } if($flag == 0){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                              <a href="prospectus_view" class="nav-link <?php if($page_no_inside == "4_1"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Prospectus</p>
                              </a>
                          </li>
                          
                      </ul>
                  </li>
                  <li class="nav-item has-treeview <?php if($page_no == "5"){ echo 'menu-open'; } ?>" <?php if(isset($autority)){ $page_no_temp = 5; if(isset($allAutority->$page_no_temp)){ if($allAutority->$page_no_temp == ""){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                      <a href="#" class="nav-link <?php if($page_no == "5"){ echo 'active'; } ?>">
                          <i class="nav-icon fas fa-book"></i>
                          <p>
                              Admission
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item" <?php if(isset($autority)){ $page_no_temp = 5; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "5_1"){ $flag++; break; } } if($flag == 0){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                              <a href="admission_form" class="nav-link <?php if($page_no_inside == "5_1"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Admission Form</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item has-treeview <?php if($page_no == "6"){ echo 'menu-open'; } ?>" <?php if(isset($autority)){ $page_no_temp = 6; if(isset($allAutority->$page_no_temp)){ if($allAutority->$page_no_temp == ""){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                      <a href="#" class="nav-link <?php if($page_no == "6"){ echo 'active'; } ?>">
                          <i class="nav-icon fas fa-edit"></i>
                          <p>
                              Student
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                         <!-- <li class="nav-item">
                              <a href="add_section_roll" class="nav-link <?php if($page_no_inside == "6_1"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Section/Roll No</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="search_student_record" class="nav-link <?php if($page_no_inside == "6_2"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Search Student Record</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="update_course_record" class="nav-link <?php if($page_no_inside == "6_3"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Update Course Record</p>
                              </a>
                          </li>-->
                          <li class="nav-item" <?php if(isset($autority)){ $page_no_temp = 6; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "6_4"){ $flag++; break; } } if($flag == 0){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                              <a href="student_list" class="nav-link <?php if($page_no_inside == "6_4"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Student List</p>
                              </a>
                          </li>
                          <li style="display:none;" class="nav-item" <?php if(isset($autority)){ $page_no_temp = 6; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "6_5"){ $flag++; break; } } if($flag == 0){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                              <a href="edit_student" class="nav-link <?php if($page_no_inside == "6_5"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Student Edit</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                   <li class="nav-item has-treeview <?php if($page_no == "7"){ echo 'menu-open'; } ?>" <?php if(isset($autority)){ $page_no_temp = 7; if(isset($allAutority->$page_no_temp)){ if($allAutority->$page_no_temp == ""){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                      <a href="#" class="nav-link <?php if($page_no == "7"){ echo 'active'; } ?>">
                          <i class="nav-icon fas fa-book"></i>
                          <p>
                              Fee Payment
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item" <?php if(isset($autority)){ $page_no_temp = 7; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "7_1"){ $flag++; break; } } if($flag == 0){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                              <a href="add_fees" class="nav-link <?php if($page_no_inside == "7_1"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Add Fees</p>
                              </a>
                          </li>
                        
                          <!--<li class="nav-item">
                              <a href="add_latefeefine" class="nav-link <?php if($page_no_inside == "7_2"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Late Fee Fine</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="add_duedate" class="nav-link <?php if($page_no_inside == "7_3"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Fee Due Date</p>
                              </a>
                          </li>-->
                          <li class="nav-item" <?php if(isset($autority)){ $page_no_temp = 7; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "7_4"){ $flag++; break; } } if($flag == 0){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                              <a href="fee_details" class="nav-link <?php if($page_no_inside == "7_4"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Fee Details</p>
                              </a>
                          </li>
                          <!--<li class="nav-item">
                              <a href="add_examfee" class="nav-link <?php if($page_no_inside == "7_5"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Add Exam Fee</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="#" class="nav-link <?php if($page_no_inside == "7_6"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Exam Fee Collection</p>
                              </a>
                          </li>-->
                          <li class="nav-item" <?php if(isset($autority)){ $page_no_temp = 7; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "7_7"){ $flag++; break; } } if($flag == 0){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                              <a href="payfee" class="nav-link <?php if($page_no_inside == "7_7"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Pay Fee</p>
                              </a>
                          </li>
                          <li class="nav-item" <?php if(isset($autority)){ $page_no_temp = 7; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "7_5"){ $flag++; break; } } if($flag == 0){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                              <a href="hostel_fee" class="nav-link <?php if($page_no_inside == "7_5"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Hostel Fee List </p>
                              </a>
                          </li>
                          <li class="nav-item" <?php if(isset($autority)){ $page_no_temp = 7; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "7_8"){ $flag++; break; } } if($flag == 0){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                              <a href="print_receipt" class="nav-link <?php if($page_no_inside == "7_8"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Print Receipt</p>
                              </a>
                          </li>
                           <li class="nav-item" <?php if(isset($autority)){ $page_no_temp = 7; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "7_6"){ $flag++; break; } } if($flag == 0){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                              <a href="student_fee_card" class="nav-link <?php if($page_no_inside == "7_6"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Student Fee Card</p>
                              </a>
                          </li>
                           <li class="nav-item" <?php if(isset($autority)){ $page_no_temp = 7; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "7_9"){ $flag++; break; } } if($flag == 0){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                              <a href="course_yearwise" class="nav-link <?php if($page_no_inside == "7_9"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Course & Year Wise Fee Report</p>
                              </a>
                          </li>
                          <li class="nav-item" <?php if(isset($autority)){ $page_no_temp = 7; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "7_10"){ $flag++; break; } } if($flag == 0){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                              <a href="datewise_fee_report" class="nav-link <?php if($page_no_inside == "7_10"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Datewise Fee Report</p>
                              </a>
                          </li>
                         
<!--
                          <li class="nav-item">
                              <a href="#" class="nav-link <?php if($page_no_inside == "7_9"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Student Fee Card</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="#" class="nav-link <?php if($page_no_inside == "7_10"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Course Wise Fee Status</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="#" class="nav-link <?php if($page_no_inside == "7_11"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Paid Fee List</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="#" class="nav-link <?php if($page_no_inside == "7_12"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Category Wise Paid Fee</p>
                              </a>
                          </li>
-->
                      </ul>
                  </li>
				   <li class="nav-item has-treeview <?php if($page_no == "8"){ echo 'menu-open'; } ?>" <?php if(isset($autority)){ $page_no_temp = 8; if(isset($allAutority->$page_no_temp)){ if($allAutority->$page_no_temp == ""){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                      <a href="#" class="nav-link <?php if($page_no == "8"){ echo 'active'; } ?>">
                          <i class="nav-icon fas fa-calendar-alt"></i>
                          <p>
                              Income/Expenses
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item" <?php if(isset($autority)){ $page_no_temp = 8; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "8_1"){ $flag++; break; } } if($flag == 0){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                              <a href="extra_income" class="nav-link <?php if($page_no_inside == "8_1"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Extra Income</p>
                              </a>
                          </li>
                           <li class="nav-item" <?php if(isset($autority)){ $page_no_temp = 8; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "8_2"){ $flag++; break; } } if($flag == 0){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                              <a href="income" class="nav-link <?php if($page_no_inside == "8_2"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Income</p>
                              </a>
                          </li>
                          <li class="nav-item" <?php if(isset($autority)){ $page_no_temp = 8; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "8_3"){ $flag++; break; } } if($flag == 0){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                              <a href="expenses" class="nav-link <?php if($page_no_inside == "8_3"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Expenses</p>
                              </a>
                          </li>
                            <li class="nav-item" <?php if(isset($autority)){ $page_no_temp = 8; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "8_4"){ $flag++; break; } } if($flag == 0){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                              <a href="balance_sheet" class="nav-link <?php if($page_no_inside == "8_4"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Balance Sheet</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  
                <!--  NSUNIV (Main Website Navbar) Start -->
                    <li class="nav-item has-treeview <?php if($page_no == "9"){ echo 'menu-open'; } ?>" <?php if(isset($autority)){ $page_no_temp = 9; if(isset($allAutority->$page_no_temp)){ if($allAutority->$page_no_temp == ""){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                      <a href="#" class="nav-link <?php if($page_no == "9"){ echo 'active'; } ?>">
                          <i class="nav-icon fas fa-university"></i>
                          <p>
                              Nsuniv Informations 
                              <!--<span id="allNsunivNotifications"></span> -->
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
<!--
                          <li class="nav-item">
                              <a href="nsuniv-home-enquiry" class="nav-link <?php if($page_no_inside == "9_1"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Home Enquiry</p>
                              </a>
                          </li>
-->
                         <li class="nav-item" <?php if(isset($autority)){ $page_no_temp = 9; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "9_4"){ $flag++; break; } } if($flag == 0){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                              <a href="nsuniv-get-enquiry" class="nav-link <?php if($page_no_inside == "9_4"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Get Started Enquiry <span id="allNsunivGetStartedEnquiry"></span></p>
                              </a>
                          </li>
                          <li class="nav-item" <?php if(isset($autority)){ $page_no_temp = 9; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "9_2"){ $flag++; break; } } if($flag == 0){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                              <a href="nsuniv-prospectus-enquiry" class="nav-link <?php if($page_no_inside == "9_2"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Prospectus Enquiry <span id="allNsunivProspectusEnquiry"></span></p>
                              </a>
                          </li>
                          <li class="nav-item" <?php if(isset($autority)){ $page_no_temp = 9; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "9_3"){ $flag++; break; } } if($flag == 0){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                              <a href="nsuniv-admission-enquiry" class="nav-link <?php if($page_no_inside == "9_3"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Admission Enquiry <span id="allNsunivAdmissionEnquiry"></span></p>
                              </a>
                          </li>
                          <li class="nav-item" <?php if(isset($autority)){ $page_no_temp = 9; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "9_5"){ $flag++; break; } } if($flag == 0){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                              <a href="notification-nsuniv" class="nav-link <?php if($page_no_inside == "9_5"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Notifications</p>
                              </a>
                          </li>
                          <li class="nav-item" <?php if(isset($autority)){ $page_no_temp = 9; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "9_6"){ $flag++; break; } } if($flag == 0){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                              <a href="nsuniv-files" class="nav-link <?php if($page_no_inside == "9_6"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Files</p>
                              </a>
                          </li>
<!--
                          <li class="nav-item">
                              <a href="#" class="nav-link <?php if($page_no_inside == "9_4"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Career Enquiry</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="#" class="nav-link <?php if($page_no_inside == "9_5"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Contact Enquiry</p>
                              </a>
                          </li>
-->
                      </ul>
                  </li>
                  <!--  NSUNIV (Main Website Navbar) End -->
<!--
                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-plus-square"></i>
                          <p>
                              Staff
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p></p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-edit"></i>
                          <p>
                              Library
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p></p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-calendar-alt"></i>
                          <p>
                              Hostel
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p></p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-plus"></i>
                          <p>
                              Examination
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p></p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-edit"></i>
                          <p>
                              Accounting
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p></p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-home"></i>
                          <p>
                              Certificates
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Admit Card</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Mark Sheet</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-edit"></i>
                          <p>
                              Send Notice
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p></p>
                              </a>
                          </li>
                      </ul>
                  </li>
                 
                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-edit"></i>
                          <p>
                              Forms
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="pages/forms/general" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>General Elements</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="pages/forms/advanced" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Advanced Elements</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-table"></i>
                          <p>
                              Tables
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="pages/tables/data" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>DataTables</p>
                              </a>
                          </li>
                      </ul>
                  </li>

                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-book"></i>
                          <p>
                              Pages
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="invoice" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Invoice</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="pages/examples/projects" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Projects</p>
                              </a>
                          </li>

                      </ul>
                  </li>
                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="nav-icon far fa-plus-square"></i>
                          <p>
                              Extras
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="pages/examples/login" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Login</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="pages/examples/register" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Register</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="pages/examples/forgot-password" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Forgot Password</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="pages/examples/recover-password" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Recover Password</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="pages/examples/lockscreen" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Lockscreen</p>
                              </a>
                          </li>

                          <li class="nav-item">
                              <a href="pages/examples/404" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Error 404</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="pages/examples/500" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Error 500</p>
                              </a>
                          </li>
                      </ul>
                  </li>
-->
                    <li class="nav-item has-treeview <?php if($page_no == "11"){ echo 'menu-open'; } ?>" <?php if(isset($autority)){ $page_no_temp = 11; if(isset($allAutority->$page_no_temp)){ if($allAutority->$page_no_temp == ""){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                      <a href="#" class="nav-link <?php if($page_no == 11){ echo 'active'; } ?>">
                          <i class="nav-icon fas fa-calendar-alt"></i>
                          <p>
                              Student & Examination
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                           <li class="nav-item" <?php if(isset($autority)){ $page_no_temp = 11; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "11_1"){ $flag++; break; } } if($flag == 0){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                              <a href="add_semester" class="nav-link <?php if($page_no_inside == "11_1"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Add Semester</p>
                              </a>
                          </li>
                           <li class="nav-item" <?php if(isset($autority)){ $page_no_temp = 11; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "11_2"){ $flag++; break; } } if($flag == 0){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                              <a href="student_details" class="nav-link <?php if($page_no_inside == "11_2"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Export Student</p>
                              </a>
                          </li>
						   <li class="nav-item" <?php if(isset($autority)){ $page_no_temp = 11; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "11_8"){ $flag++; break; } } if($flag == 0){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                              <a href="student_view" class="nav-link <?php if($page_no_inside == "11_8"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Import Student</p>
                              </a>
                          </li>
                          <li class="nav-item" <?php if(isset($autority)){ $page_no_temp = 11; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "11_3"){ $flag++; break; } } if($flag == 0){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                              <a href="student_semester" class="nav-link <?php if($page_no_inside == "11_3"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Allocate Semester to Student</p>
                              </a>
                          </li>
                          <li class="nav-item" <?php if(isset($autority)){ $page_no_temp = 11; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "11_4"){ $flag++; break; } } if($flag == 0){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                              <a href="add_subject" class="nav-link <?php if($page_no_inside == "11_4"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Add Subject</p>
                              </a>
                          </li>
						  <li class="nav-item" <?php if(isset($autority)){ $page_no_temp = 11; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "11_5"){ $flag++; break; } } if($flag == 0){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                              <a href="add_marks" class="nav-link <?php if($page_no_inside == "11_5"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Add Marks</p>
                              </a>
                          </li>	
							<li class="nav-item" <?php if(isset($autority)){ $page_no_temp = 11; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "11_6"){ $flag++; break; } } if($flag == 0){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                              <a href="create_report" class="nav-link <?php if($page_no_inside == "11_6"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Create Report</p>
                              </a>
							</li>
							<li class="nav-item" <?php if(isset($autority)){ $page_no_temp = 11; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "11_7"){ $flag++; break; } } if($flag == 0){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                              <a href="create_all_report" class="nav-link <?php if($page_no_inside == "11_7"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Create Full Report</p>
                              </a>
							</li>
                      </ul>
                  </li>
                  <li class="nav-item has-treeview <?php if($page_no == "12"){ echo 'menu-open'; } ?>" <?php if(isset($autority)){ $page_no_temp = 12; if(isset($allAutority->$page_no_temp)){ if($allAutority->$page_no_temp == ""){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                      <a href="#" class="nav-link <?php if($page_no == "12"){ echo 'active'; } ?>">
                          <i class="nav-icon fas fa-edit"></i>
                          <p>
                              Examination
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item" <?php if(isset($autority)){ $page_no_temp = 12; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "12_1"){ $flag++; break; } } if($flag == 0){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                              <a href="exam_form_list" class="nav-link <?php if($page_no_inside == "12_1"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Exam Form</p>
                              </a>
                          </li>
                        
                           <li class="nav-item">
                              <a href="exam_fee_details" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Exam Fee Details</p>
                              </a>
                          </li>
                        
                        
                         <li class="nav-item">
                              <a href="exam_payfee" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Exam Pay Fee</p>
                              </a>
                          </li>
                          
                          
                            <li class="nav-item">
                              <a href="course_yearwise_exam_fee_report" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Course & Year Wise Exam Fee Report</p>
                              </a>
                          </li>


						   <li class="nav-item" <?php if(isset($autority)){ $page_no_temp = 12; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "12_2"){ $flag++; break; } } if($flag == 0){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                              <a href="student_nodues_list" class="nav-link <?php if($page_no_inside == "12_2"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Student List (No Dues)</p>
                              </a>
                          </li>
                      </ul>
                  </li>
				  <li class="nav-item has-treeview <?php if($page_no == "14"){ echo 'menu-open'; } ?>" <?php if(isset($autority)){ $page_no_temp = 14; if(isset($allAutority->$page_no_temp)){ if($allAutority->$page_no_temp == ""){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                      <a href="#" class="nav-link <?php if($page_no == "14"){ echo 'active'; } ?>">
                          <i class="nav-icon fas fa-edit"></i>
                          <p>
                              Admit Card
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item" <?php if(isset($autority)){ $page_no_temp = 14; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "14_1"){ $flag++; break; } } if($flag == 0){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                              <a href="students_view" class="nav-link <?php if($page_no_inside == "14_1"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Admit Card Approval</p>
                              </a>
                          </li>						  
                      </ul>
                  </li>
                  <li class="nav-item has-treeview <?php if($page_no == "13"){ echo 'menu-open'; } ?>" <?php if(isset($autority)){ $page_no_temp = 13; if(isset($allAutority->$page_no_temp)){ if($allAutority->$page_no_temp == ""){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                      <a href="#" class="nav-link <?php if($page_no == "13"){ echo 'active'; } ?>">
                          <i class="nav-icon fas fa-edit"></i>
                          <p>
                              Complaint From Students
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item" <?php if(isset($autority)){ $page_no_temp = 13; $flag = 0; if(isset($allAutority->$page_no_temp)) { $subMenus = explode("||", $allAutority->$page_no_temp); for($i=0; $i<count($subMenus);$i++){ if($subMenus[$i] == "13_1"){ $flag++; break; } } if($flag == 0){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                              <a href="complaint" class="nav-link <?php if($page_no_inside == "13_1"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>View Complaint</p>
                              </a>
                          </li>						  
                      </ul>
                  </li>
                 <li class="nav-item has-treeview" <?php if(isset($autority)){ $page_no_temp = 10; if(isset($allAutority->$page_no_temp)){ if($allAutority->$page_no_temp == ""){ echo "style='display:none;';"; } } else { echo "style='display:none;';"; } } ?>>
                      <a href="trash" class="nav-link <?php if($page_no == "10"){ echo 'active'; } ?>">
                          <i class="nav-icon fas fa-trash"></i>
                          <p>
                              Trash
                          </p>
                      </a>
                  </li>
                  
                  
                   <a href="edit_student" class=" <?php if($page_no == "edit_student"){ echo 'active'; } ?>"></a>
                      
                  <li class="nav-item has-treeview">
                      <a href="javascript:void(0)" class="nav-link" onclick="document.getElementById('logout').style.display='block'">
                          <i class="nav-icon fa fa-power-off"></i>
                          <p>
                              Log Out
                          </p>
                      </a>
                  </li>
              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>
<script>
function removeThis(commingId){
    $("#"+commingId).remove();
}
//    $(document).ready(function() {
//        setInterval(function(){
//            $.ajax({
//                url: 'include/view.php?action=get_all_nsuniv_notifications',
//                type: 'GET',
//                success: function(result) {
//                    if(parseInt(result) > 0)
//                        $("#allNsunivNotifications").html('<sup class="btn btn-success btn-xs">'+result+'</sup>');
//                    else
//                        $("#allNsunivNotifications").html('');
//                }
//            });
//            $.ajax({
//                url: 'include/view.php?action=get_all_nsuniv_prospectus_notifications',
//                type: 'GET',
//                success: function(result) {
//                    if(parseInt(result) > 0)
//                        $("#allNsunivProspectusEnquiry").html('<sup class="btn btn-success btn-xs">'+result+'</sup>');
//                    else
//                        $("#allNsunivProspectusEnquiry").html('');
//                }
//            });
//            $.ajax({
//                url: 'include/view.php?action=get_all_nsuniv_admission_notifications',
//                type: 'GET',
//                success: function(result) {
//                    if(parseInt(result) > 0)
//                        $("#allNsunivAdmissionEnquiry").html('<sup class="btn btn-success btn-xs">'+result+'</sup>');
//                    else
//                        $("#allNsunivAdmissionEnquiry").html('');
//                }
//            });
//            $.ajax({
//                url: 'include/view.php?action=get_all_nsuniv_get_started_notifications',
//                type: 'GET',
//                success: function(result) {
//                    if(parseInt(result) > 0)
//                        $("#allNsunivGetStartedEnquiry").html('<sup class="btn btn-success btn-xs">'+result+'</sup>');
//                    else
//                        $("#allNsunivGetStartedEnquiry").html('');
//                }
//            });
//            
//        }, 10000);
//    });
</script>
  <!-- Logout Section Start -->
  <div id="logout" class="w3-modal" style="z-index:2020;">
      <div class="w3-modal-content w3-animate-top w3-card-4" style="width:40%">
          <header class="w3-container" style="background:#343a40; color:white;">
              <span onclick="document.getElementById('logout').style.display='none'" class="w3-button w3-display-topright">&times;</span>
              <h2 align="center">Are you sure???</h2>
          </header>
          <div class="card-body">
              <div class="col-md-12" align="center">
                  <a href="logout" class="btn btn-danger"><i class="nav-icon fa fa-power-off"></i> Log Out</a>
                  <button type="button" onclick="document.getElementById('logout').style.display='none'" class="btn btn-primary">Cancel</button>
              </div>
          </div>
      </div>
  </div>
  <!-- Logout Section End -->