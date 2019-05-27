<?php 

	// getting `exam_category_id` from `exams_criteria`
	$examCateogryId = $_GET['examcatID'];
	// getting `class_id`
	$classId = $_GET['classID'];
	//getting `examType`
	$examType = $_GET['examType'];
	// geeting all info from `exams_criteria` table and `exams_schedule` table
	$examCriteriaData = Yii::$app->db->createCommand("SELECT * FROM exams_criteria WHERE exam_category_id = '$examCateogryId' AND class_id = '$classId' AND exam_type = '$examType'
					")->queryAll();
	$classId = $examCriteriaData[0]['class_id'];
	// getting classes name `std_enroll_head_name` from `std_enrollment_head` against `std_enroll_head_id`
	$className = Yii::$app->db->createCommand("SELECT class_name FROM std_class_name WHERE class_name_id = '$classId'
					")->queryAll();
	$count = count($examCriteriaData);
	// getting exam `category_name` from `exams_cateogry`
	$examCategoryName = Yii::$app->db->createCommand("SELECT category_name FROM exams_category WHERE exam_category_id = '$examCateogryId'
					")->queryAll();

 ?>
<div class="container-fluid">
	<!-- back button start -->
	 <ol class="breadcrumb">
      <li><a class="btn btn-primary btn-xs" href="./exam-lists?id=<?php echo $examCateogryId;?>"><i class="fa fa-backward"></i> Back</a></li>
      <li style="float:right;">
      	<button onclick="printContent('datesheet')" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-print"></i> Print</button>
      </li>
    </ol>
	<!-- back button close -->
	<div class="row" id="datesheet">
		<div class="col-md-12">
			<div class="panel panel-primary" style="border:1px solid;">
				
				<div class="panel-body">
					<div class="row container-fluid">
						<div class="col-md-3">
							<center>
								<img src="uploads/abc.png" height="140px" width="130px">
							</center>
						</div>
						<div class="col-md-9 well well-sm" style="text-align: center;font-family: georgia;">
							<h2>
							<?php echo $examCategoryName[0]['category_name']; ?> (<?php echo date('Y'); ?>)
							<br>
							<br>
							<p style="font-size:20px;">Date Sheet</p>
							</h2>
						</div>
					</div><hr>
					<div class="row	">
						<div class="col-md-4" style="text-align: center;">
							<table class="table table-hover table-responsive">
									<tr>
										<b>Exam Date</b><br>
										<center>
											<?php 
											echo date('d-M-Y',strtotime($examCriteriaData[0]['exam_start_date']));
											?>
											<b>TO</b>&nbsp;<?php 
											echo date('d-M-Y',strtotime($examCriteriaData[0]['exam_end_date']));
											?>
										</center>
									</tr>
							</table>
						</div>
						<div class="col-md-4" style="border-left:1px solid; text-align: center;">
							<table class="table">
									<tr>
										<b>Exam Room</b><br>
										<center>
											<?php echo $examCriteriaData[0]['exam_room']; ?>
										</center>
									</tr>
							</table>
						</div>
						<div class="col-md-4" style="border-left:1px solid;text-align: center;">
							<table class="table">
									<tr>
										<b>Class Name</b>
										<center>
											<?php echo $className[0]['class_name']; ?>
										</center>
									</tr>
							</table>
						</div>
					</div><hr>
					<?php 	

						for ($i=0; $i <$count ; $i++) {
						$criteriaID = $examCriteriaData[$i]['exam_criteria_id'];		
						$examScheduleData = Yii::$app->db->createCommand("SELECT * FROM exams_schedule WHERE exam_criteria_id = '$criteriaID'
							")->queryAll();

						$countSubjects = count($examScheduleData);

						?>
						<div class="row">
						<div class="col-md-12">
							<table class="table table-hover">
								<thead>
									<tr style="background-color: #337AB7;color: white;">
										<th class="text-center">Date</th>
										<th class="text-center">Day</th>
										<th class="text-center">Time</th>
										<th class="text-center">Subject</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									
										for ($j=0; $j <$countSubjects ; $j++) { 
											$subjectId = $examScheduleData[$j]['subject_id'];
											$subjectName = Yii::$app->db->createCommand("SELECT subject_name FROM subjects WHERE subject_id = '$subjectId'
										")->queryAll();
										
									 ?>
									<tr align="center">
										<td>
											<?php
											echo 
											date('F d, Y',strtotime($examScheduleData[$j]['date']));
											?>	
										</td>
										<td>
											<?php 
											//Our YYYY-MM-DD date string.
											$date = $examScheduleData[$j]['date'];

											//Get the day of the week using PHP's date function.
											$dayOfWeek = date("l", strtotime($date));

											//Print out the day that our date fell on.
											echo $dayOfWeek;
											?>	
											</td>
										<td>
											<?php 
											echo date('h:m A',strtotime($examScheduleData[0]['exam_start_time']));
											?>
											<b>TO</b>&nbsp;<?php 
											echo date('h:m A',strtotime($examScheduleData[0]['exam_end_time']));
											?>
										</td>
										<td>
											<?php echo $subjectName[0]['subject_name']; ?>	
										</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div> <hr>
					 <?php }?>
					<div class="row" style="padding-bottom:20px; text-align:center;margin-top:70px;">
						<div class="col-md-6">
							<h3>Examination Controller</h3><br>
							___________________________	
						</div>
						<div class="col-md-6">
							<h3>Principal's Signature</h3><br>
							_________________________
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
function printContent(el){
	var restorepage = document.body.innerHTML;
	var printcontent = document.getElementById(el).innerHTML;
	document.body.innerHTML = printcontent;
	window.print();
	document.body.innerHTML = restorepage;
}
</script>