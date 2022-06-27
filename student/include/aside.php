<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="dashboard" class="brand-link">
          <img src="images/logo.png" alt="NSU Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light" style="font-size: 18px;">Netaji Subhas University</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                  <img src="images/logo.png" class="img-circle elevation-2" alt="User Image">
              </div>
              <div class="info">
                  <a href="#" class="d-block">Student</a>
              </div>
          </div>
          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                  <li class="nav-item has-treeview" <?php $flag=0; if(isset($autority)){ $allAutority = explode(",", $autority); for($i=0; $i<count($allAutority);$i++){ if($allAutority[$i] == "1"){ $flag++; break; } } if($flag == 0){ echo "style='display:none;'"; } } ?>>
                      <a href="dashboard" class="nav-link <?php if($page_no == "1"){ echo 'active'; } ?>">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Dashboard
                          </p>
                      </a>
                  </li>
                  <li class="nav-item has-treeview" <?php $flag=0; if(isset($autority)){ $allAutority = explode(",", $autority); for($i=0; $i<count($allAutority);$i++){ if($allAutority[$i] == "2"){ $flag++; break; } } if($flag == 0){ echo "style='display:none;'"; } } ?>>
                      <a href="userprofile" class="nav-link <?php if($page_no == "2"){ echo 'active'; } ?>">
                          <i class="nav-icon fas fa-user"></i>
                          <p>
                            User Profile
                          </p>
                      </a>
                  </li>
				  <?php 
				//	$sql = "SELECT * FROM `tbl_admission` WHERE `status` = '$visible' && `admission_username` = '".$_SESSION["logger_username1"]."'";
				//	$result = $con->query($sql);
				//	$row = $result->fetch_assoc();
				  ?>
                  <!-- <li class="nav-item has-treeview" <?php // $flag=0; if(isset($autority)){ $allAutority = explode(",", $autority); for($i=0; $i<count($allAutority);$i++){ if($allAutority[$i] == "3"){ $flag++; break; } } if($flag == 0){ echo "style='display:none;'"; } } ?>>
                      <a href="editprofile?id=<?php // echo base64_encode($row['admission_id']);?>" class="nav-link <?php // if($page_no == "3"){ echo 'active'; } ?>">
                          <i class="nav-icon fas fa-pencil-alt"></i>
                          <p>
                            Edit Profile
                          </p>
                      </a>
                  </li> -->
				  <li class="nav-item has-treeview" <?php $flag=0; if(isset($autority)){ $allAutority = explode(",", $autority); for($i=0; $i<count($allAutority);$i++){ if($allAutority[$i] == "5"){ $flag++; break; } } if($flag == 0){ echo "style='display:none;'"; } } ?>>
                      <a href="#" class="nav-link <?php if($page_no == "3"){ echo 'active'; } ?>">
                          <i class="nav-icon fas fa-book"></i>
                          <p>
                              Fee 
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="payfee" class="nav-link <?php if($page_no_inside == "3_1"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Pay Fee</p>
                              </a>
                          </li>
						  <!-- <li class="nav-item">
                              <a href="fee_details" class="nav-link <?php if($page_no_inside == "3_2"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Total Fee Details</p>
                              </a>
                          </li>-->
						   <li class="nav-item">
                              <a href="paid_fee_details" class="nav-link <?php if($page_no_inside == "3_3"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Paid Fee Details</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                   <li class="nav-item has-treeview" <?php $flag=0; if(isset($autority)){ $allAutority = explode(",", $autority); for($i=0; $i<count($allAutority);$i++){ if($allAutority[$i] == "5"){ $flag++; break; } } if($flag == 0){ echo "style='display:none;'"; } } ?>>
                      <a href="#" class="nav-link <?php if($page_no == "4"){ echo 'active'; } ?>">
                          <i class="nav-icon fas fa-book"></i>
                          <p>
                              Exam 
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="exam" class="nav-link <?php if($page_no_inside == "4_1"){ echo 'active'; } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Exam Form</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item has-treeview" <?php $flag=0; if(isset($autority)){ $allAutority = explode(",", $autority); for($i=0; $i<count($allAutority);$i++){ if($allAutority[$i] == "7"){ $flag++; break; } } if($flag == 0){ echo "style='display:none;'"; } } ?>>
                    <a href="#" class="nav-link <?php if($page_no == "7"){ echo 'active'; } ?>">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Admit Card Management
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="admitcard" class="nav-link <?php if($page_no_inside == "7_1"){ echo 'active'; } ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Admit Card</p>
                            </a>
                        </li>
                    </ul>
                </li>
                     <li class="nav-item has-treeview" <?php $flag=0; if(isset($autority)){ $allAutority = explode(",", $autority); for($i=0; $i<count($allAutority);$i++){ if($allAutority[$i] == "6"){ $flag++; break; } } if($flag == 0){ echo "style='display:none;'"; } } ?>>
                    <a href="#" class="nav-link <?php if($page_no == "6"){ echo 'active'; } ?>">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Complaint Management
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="complaint" class="nav-link <?php if($page_no_inside == "6_1"){ echo 'active'; } ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Complaint</p>
                            </a>
                        </li>
                    </ul>
                </li>
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