<!DOCTYPE html>
<html>
<head>
	<title>All Branches</title>
</head>
<body>
	<?php
  // branch_id..
	$id = $_GET['id'];
  // branches query....
	$branches = Yii::$app->db->createCommand("SELECT * FROM branches WHERE branch_id = $id")->queryAll();
  // institute query....
	$institute = $branches[0]['institute_id'];
	$instituteInfo = Yii::$app->db->createCommand("SELECT * FROM institute WHERE institute_id = 2")->queryAll();
  // sessions query....
	$sessions = Yii::$app->db->createCommand("SELECT * FROM std_sessions WHERE session_branch_id = $id AND delete_status = 1")->queryAll();
	if (empty($sessions)) {
		echo "";
	}else{
		$sessionid = $sessions[0]['session_id'];
		$countSessions = count($sessions);
		$sections = Yii::$app->db->createCommand("SELECT * FROM std_sections
  INNER join std_sessions
  ON std_sections.session_id = std_sessions.session_id
  WHERE std_sessions.session_id = $sessionid AND std_sessions.delete_status = 1")->queryAll();
		if (empty($sections)) {
			echo "";
		}else{
			$sectionId = $sections[0]['section_id'];
			$countSections = count($sections);
		}
	}
	
  // sections query....

  // classes query...
	$classes = Yii::$app->db->createCommand("SELECT * FROM std_class_name WHERE branch_id = '$id' AND  delete_status = 1")->queryAll();
	$countclasses = count($classes);  
  // employee query...
	$employees = Yii::$app->db->createCommand("SELECT e.emp_id FROM emp_info as e WHERE e.emp_branch_id  = '$id' AND e.delete_status = 1 ")->queryAll();

  // Employee Designation...
  $empDesignation = Yii::$app->db->createCommand("SELECT * FROM designation")->queryAll();
 
	$employeeCount = count($employees);

	?>
 <div class="container-fluid">
  	<section class="content-header">
        	<h1 style="color: #3C8DBC;">
          	<i class="fa fa-university"></i> Branch Profile
        	</h1>
  	    <ol class="breadcrumb" style="color: #3C8DBC;">
  	        <li><a href="index.php" style="color: #3C8DBC;"><i class="fa fa-dashboard"></i> Home</a></li>
  	        <li><a href="branches" style="color: #3C8DBC;">Back</a></li>
  	    </ol>
      </section>
      <!--  -->
  	<section class="content">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box box-primary">
              <div class="box-body box-profile">
                <img class="profile-user-img img-responsive img-circle" src="<?php echo $instituteInfo[0]['institute_logo'];?>" alt="User profile picture" style="width: 150px; height: 120px">
                <h3 class="profile-username text-center"></h3>
                <p class="text-muted text-center">
                  <h4 align="center" style="color: #3C8DBC;"><?php echo $instituteInfo[0]['institute_name'];?></h4>
                </p>

                <ul class="list-group list-group-unbordered">
                  <li class="list-group-item">
                    <b>Campus Head:</b><br>
                      <a>
                        <?php echo $branches[0]['branch_head_name'];?>
                      </a>
                  </li>
                  <li class="list-group-item">
                    <b>Contact #:</b><br>
                      <a>
                        <?php echo $branches[0]['branch_head_contact_no'];?>
                      </a>
                  </li>
                  <li class="list-group-item">
                    <b>Email:</b><br>
                    <a>
                      <?php echo $branches[0]['branch_head_email'];?>
                    </a>
                  </li>
                </ul>

                <!-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> -->
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->

            <!-- About Me Box -->
            
            <!-- /.box -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs" style="color: #3C8DBC;">
                <!-- Branches -->
                <li class="active">
                  <a href="#branch" data-toggle="tab" style="color: #3C8DBC;">
                    <i class="fa fa-bold"></i> Branch
                  </a>
                </li>
                <!-- Sessions -->
                <li>
                	<a href="#sessions" data-toggle="tab" style="color: #3C8DBC;">
                    <i class="fa fa-scribd"></i> Sessions 
                    <span class="label label-success" style="border-radius: 50%;">
                      <?php 
                      if (empty($countSessions)) {
                      	echo "N/A";
                      }else{
                      	echo $countSessions;
                      }
                      ?>
                    </span>
                  </a>
                </li>
                <!-- Classes -->
                <li>
                  <a href="#classes" data-toggle="tab" style="color: #3C8DBC;">
                    <i class="fa fa-copyright"></i> Classes 
                    <span class="label label-info" style="border-radius: 50%;">
                      <?php echo $countclasses;?>
                    </span>
                  </a>
                </li>
                <!-- Sections -->
                <li>
                	<a href="#sections" data-toggle="tab" style="color: #3C8DBC;">
                    <i class="glyphicon glyphicon-link"></i> Sections 
                    <span class="label label-primary" style="border-radius: 50%;">
                      <?php 
                      if (empty($countSections)) {
                      	echo "N/A";
                      }else{
                      	echo $countSections;
                      }
                      ?>
                    </span>
                  </a>
                </li>
                <!-- Employees -->
                <li>
                  <a href="#employees" data-toggle="tab" style="color: #3C8DBC;">
                    <i class="fa fa-users"></i> Employees 
                    <span class="label label-warning" style="border-radius: 50%;">
                      <?php echo $employeeCount;?>
                    </span>
                  </a>
                </li>
              </ul>
              <!-- ************************************************************* -->
              <!-- Branch Tab start -->
              <div class="tab-content">
                <div class="active tab-pane" id="branch">
                  <div class="row">
                    <div class="col-md-5">
                      <p style="font-size: 20px; color: #3C8DBC;"><i class="fa fa-info-circle" style="font-size: 20px;"></i> Branch Information</p>
                    </div>
                  </div><hr style="margin-top: 10px;">
                  <!-- Branch info start -->
                    <div class="row">
                      <div class="col-md-6" style="border-right: 1px dashed;">
                        <table class="table table-striped table-hover table-responsive">
                          <thead>
                            <tr>
                              <th>Branch Code:</th>
                              <td><?php echo $branches[0]['branch_code'];?></td>
                            </tr>
                            <tr>
                              <th>Branch Name:</th>
                              <td><?php echo $branches[0]['branch_name'];?></td>
                            </tr>
                            <tr>
                              <th>Branch Email:</th>
                              <td><?php echo $branches[0]['branch_email'];?></td>
                            </tr>
                            <tr>
                              <th>Branch number:</th>
                              <td><?php echo $branches[0]['branch_contact_no'];?></td>
                            </tr>
                            <tr>
                              <td></td>
                            </tr>
                          </thead>
                        </table>
                      </div>
                      <div class="col-md-6">
                          <table class="table table-stripped table-hover table-responsive">
                          <thead>
                            <tr>
                              <th>Branch Status:</th>
                              <td>
                                <span class="label label-success">
                                  <?php echo $branches[0]['status'];?>
                                </span>
                              </td>
                            </tr>
                            <tr>
                              <th>Branch Type:</th>
                              <td><?php echo $branches[0]['branch_type'];?></td>
                            </tr>
                            <tr>
                              <th>Branch Location:</th>
                              <td><?php echo $branches[0]['branch_location'];?></td>
                            </tr>
                          </thead>
                        </table>
                      </div>
                    </div>
                  <!-- Branch info close -->
                </div>
                <!-- Branch Tab close -->
                <!-- ********************** -->
                <!-- Session tab start here -->
                <div class="tab-pane" id="sessions">
                 <div class="row">
                    <div class="col-md-5">
                      <p style="font-size: 20px; color: #3C8DBC;"><i class="fa fa-info-circle" style="font-size: 20px;"></i> Sessions Information</p>
                    </div>
                  </div><hr>
                  <!-- Sessions info start -->
                    <div class="row">
                      <div class="col-md-12">
                        <table class="table table-striped table-hover table-responsive table-bordered table-condensed" style="width: 100%;">
                          <thead>
                           <tr class="label-primary">
                          		<th class="text-center">Sr #:</th>
                          		<th>Session Name:</th>
                          		<th>Session Start Date</th>
                          		<th>Session End Date</th>
                          		<th>Status</th>
                          	</tr>
                          </thead>
                          <tbody>  
                          	<?php foreach ($sessions as $key => $val){  ?>
                            <tr>
                              <td class="text-center"><?php echo $key+1; ?></td>
                              <td><?php echo $val['session_name'];?></td>
                              <td><?php echo $val['session_start_date'];?></td>
                              <td><?php echo $val['session_end_date'];?></td>
                              <td>
                                <?php if ($val['status'] == "Active") { ?>
                                  <span class="label label-success">
                                    <?php echo $val['status'];?>
                                  </span>
                                <?php } else { ?>
                                  <span class="label label-danger">
                                    <?php echo $val['status'];?>
                                  </span>
                                <?php } ?>
                              </td>
                            </tr>
                        	<?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  <!-- Sessions info close -->
                </div>
                <!-- Sessions tab close here -->
                <!-- *********************** -->
                <!-- Section tab start here --->
                <div class="tab-pane" id="sections">
                 <div class="row">
                    <div class="col-md-5">
                      <p style="font-size: 20px; color: #3C8DBC;"><i class="fa fa-info-circle" style="font-size: 20px;"></i> Sections Information</p>
                    </div>
                  </div><hr>
                  <!-- Sections info start -->
                    <div class="row">
                      <div class="col-md-12">
                        <table class="table table-striped table-hover table-responsive table-condensed table-bordered">
                          <thead>
                            <tr class="label-primary">
                              <th class="text-center">Sr #:</th>
                              <th style="width: 110px">Section Name</th>
                              <th>Section Description</th>
                              <th class="text-center">Section Intake</th>
                              <th class="text-center">Enrolled Students</th>
                              <th class="text-center">Remaining</th>
                            </tr>
                          </thead>
                          <tbody>  
                            <?php 
                              $countIntake = 0;
                              $countStudent = 0;
                              $countRemainingIntake = 0;
                              if (empty($sections)) {
                              	echo "";
                              }else{
                              	
                              foreach ($sections as $key => $val){ 
                              $students = Yii::$app->db->createCommand("SELECT sed.std_enroll_detail_std_id FROM std_enrollment_detail as sed INNER JOIN std_enrollment_head as seh ON seh.std_enroll_head_id = sed.std_enroll_detail_head_id WHERE seh.section_id = $key+1")->queryAll();
                                $studentCount = count($students);
                              }
                            ?>  
                            <tr>
                              <td class="text-center"><b><?php echo $key+1; ?></b></td>
                              <td><?php echo $val['section_name'];?></td>
                              <td><?php echo $val['section_description'];?></td>
                              <td align="center">
                                <span class="label label-primary" style="border-radius: 50%; padding: 5px;"><?php echo $val['section_intake'];?></span>
                              </td>
                              <td align="center">
                                <span class="label label-warning" style="border-radius: 50%; padding: 5px 7px"><b><?php echo $studentCount; ?></b></span>
                              </td>
                              <td class="text-center">
                                <span class="label label-danger text-center" style="border-radius: 50%; padding: 5px 7px"><b><?php echo $val['section_intake']-$studentCount; ?></b></span>
                              </td>
                            </tr>
                            <?php 
                              $countIntake          += $val['section_intake'];
                              $countStudent         += $studentCount;
                              $countRemainingIntake += $val['section_intake']-$studentCount;
                          } ?>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-md-12" style="margin-left: 10px auto;">
                        <table class="table table-bordered table-hover table-condensed">
                          <tr class="label-primary">
                            <th colspan="3" class="text-center">Total</th>
                          </tr>
                          <tr class="label-info">
                            <th class="text-center">Intake</th>
                            <th class="text-center">Enrolled Students</th>
                            <th class="text-center">Remaining</th>
                          </tr>
                          <tr align="center">
                              <td width="78px">
                                <span class="label label-primary text-center" style="border-radius: 50%; padding: 5px 7px">
                                  <?php echo $countIntake; ?>
                                </span>
                              </td>
                              <td width="88px">
                                <span class="label label-warning text-center" style="border-radius: 50%; padding: 5px 7px">
                                  <?php echo $countStudent; ?>
                                </span>
                              </td>
                              <td width="105px">
                                <span class="label label-danger text-center" style="border-radius: 50%; padding: 5px 7px">
                                  <?php echo $countRemainingIntake; ?>
                                </span>
                              </td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  <!-- Sections info close -->
                </div>
                <!-- Sections tab close here -->
                <!-- ************************ -->
                <!-- Classes  tab start here -->
                <div class="tab-pane" id="classes">
                 <div class="row">
                    <div class="col-md-5">
                      <p style="font-size: 20px; color: #3C8DBC;"><i class="fa fa-info-circle" style="font-size: 20px;"></i> Classes Information</p>
                    </div>
                  </div><hr>
                  <!-- Classes info start -->
                    <div class="row">
                      <div class="col-md-12">
                        <table class="table table-striped table-hover table-responsive table-condensed table-bordered">
                          <thead>
                            <tr class="label-primary">
                              <th class="text-center">Sr #.</th>
                              <th>Class Name</th>
                              <th>Class Description</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                            <?php foreach ($classes as $key => $val){ ?>
                              <td class="text-center"><?php echo $key+1;?></td>
                              <td><?php echo $val['class_name'];?></td>
                              <td><?php echo $val['class_name_description'];?></td>
                            </tr>
                            <?php } ?>
                          </tbody>  
                        </table>
                      </div>
                    </div>
                  <!-- Classes info close -->
                </div>
                <!-- Classes tab close here -->
                <!-- Employees  tab start here -->
                <div class="tab-pane" id="employees">
                 <div class="row">
                    <div class="col-md-5">
                      <p style="font-size: 20px; color: #3C8DBC;"><i class="fa fa-info-circle" style="font-size: 20px;"></i> Employees Information</p>
                    </div>
                  </div><hr>
                  <!-- Employees info start -->
                    <div class="row">
                      <div class="col-md-12">
                        <table class="table table-striped table-hover table-responsive table-condensed table-bordered">
                          <thead>
                            <tr class="label-primary">
                              <th class="text-center">Sr #.</th>
                              <th>Employee Designation</th>
                              <th class="text-center">Designation Vice Employees</th>
                            </tr>
                          </thead>
                          <tbody>  
                            <tr>
                              <?php foreach ($empDesignation as $key => $value) {
                                $designation = $value['designation_id'];
                                $emp = Yii::$app->db->createCommand("SELECT ed.designation_id 
                                FROM ((emp_designation as ed INNER JOIN designation as d
                                ON d.designation_id = ed.designation_id ) INNER JOIN emp_info as e ON e.emp_id = ed.emp_id) WHERE e.emp_branch_id = '$id' AND d.designation_id = $designation")->queryAll();
                                $empCount = count($emp);
                              ?>
                                <?php 
                                    if ($value['designation']=='Principal') {
                                      echo '';
                                    } else{ ?>
                                <td class="text-center"><?php echo $key+1; ?></td>      
                                <td>  
                                  <?php echo $value['designation']; ?>
                                </td>
                                <td align="center">
                                  <span class="label-success" style="border-radius: 50%; padding: 3px 7px">
                                    <?php echo $empCount ?>
                                  </span>
                                </td>
                                <?php } ?>
                            </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  <!-- Employees info close -->
                </div>
                <!-- Employees tab close here -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </section>
      <!--  -->
  </div>	
</body>
</html>