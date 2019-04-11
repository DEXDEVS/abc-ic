<?php 

	// getting `exam_category_id` from `exams_criteria`
	$examCateogryId = $_GET['examcatID'];
	// getting `class_id`
	$classId = $_GET['classID'];
	// geeting all info from `exams_criteria` table and `exams_schedule` table
	$examCriteriaData = Yii::$app->db->createCommand("SELECT * FROM exams_criteria WHERE exam_category_id = '$examCateogryId' AND
		std_enroll_head_id = '$classId'
					")->queryAll();
	$criteriaId = $examCriteriaData[0]['exam_criteria_id'];

	$examScheduleData = Yii::$app->db->createCommand("SELECT * FROM exams_schedule WHERE exam_criteria_id = '$criteriaId'
					")->queryAll();
	// getting classes name `std_enroll_head_name` from `std_enrollment_head` against `std_enroll_head_id`
	$className = Yii::$app->db->createCommand("SELECT std_enroll_head_name FROM std_enrollment_head WHERE std_enroll_head_id = '$classId'
					")->queryAll();
	$count = count($examCriteriaData);
	// getting exam `category_name` from `exams_cateogry`
	$examCategoryName = Yii::$app->db->createCommand("SELECT category_name FROM exams_category WHERE exam_category_id = '$examCateogryId'
					")->queryAll();

	$subjects = Yii::$app->db->createCommand("SELECT s.section_subjects,h.section_id
			FROM std_sections as s
			INNER JOIN std_enrollment_head as h
			ON s.section_id = h.section_id
			WHERE h.std_enroll_head_id = '$classId'")->queryAll();
			$combinationId = $subjects[0]['section_subjects'];
			$combinations = Yii::$app->db->createCommand("
				SELECT std_subject_name FROM std_subjects WHERE std_subject_id = '$combinationId'
					")->queryAll();
			$subject = $combinations[0]['std_subject_name'];
			 $subjectarray = explode(',', $subject);
			$subjCount = count($subjectarray);

 ?>
 	<!DOCTYPE html>
	<html>
	<head>
		<meta charset="utf-8">
		<title>Manage Exams</title>
	</head>
	<body>
	<div class="container-fluid">
		<div class="row">
		<div class="col-md-12">
			<a href="./view?id=<?php echo $examCateogryId;?>" style="float: right;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-backward"></i> Back</a>
		</div>
	</div><br>
		<div class="box box-primary">
			<div class="box-header">
				<h3>Exams Criteria</h3>
			</div>
			<div class="box-body">
				<form method="POST" action="view?id=<?php echo $examCateogryId ?>">
					<input type="hidden" name="_csrf" class="form-control" value="<?=Yii::$app->request->getCsrfToken()?>"> 
					<div class="row">
						<div class="col-md-4">	
							<div class="form-group">
								<label>Select Exam Category</label>
								<select name="exam_category" class="form-control">
									<?php 

									 $ExamCategories = Yii::$app->db->createCommand("SELECT * FROM exams_category WHERE exam_category_id != '$examCateogryId'")->queryAll();
									 $examName = Yii::$app->db->createCommand("SELECT category_name,exam_category_id FROM exams_category WHERE exam_category_id = '$examCateogryId'")->queryAll();					 	
									 ?>
									 <option value="<?php echo $examName[0]['exam_category_id']; ?>">
									 	<?php echo $examName[0]['category_name']; ?>
									 </option>
									 <?php foreach ($ExamCategories as $key => $value) { ?>
									 <option value="<?php echo $value['exam_category_id']; ?>">
									 	<?php echo $value['category_name']; ?>
									 </option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Class Name</label>
								<input class="form-control" type="text" name="classId" value="<?php echo $className[0]['std_enroll_head_name']; ?>" readonly="">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Exam Start Date</label>
								<input type="date" name="exam_start_date" class="form-control" value="<?php echo $examCriteriaData[0]['exam_start_date'];?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">	
							<div class="form-group">
								<label>Exam End Date</label>
								<input type="date" name="exam_end_date" class="form-control" value="<?php echo $examCriteriaData[0]['exam_end_date'];?>">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Exam Start Time</label>
								<input type="time" name="exam_start_time" class="form-control" value="<?php echo $examCriteriaData[0]['exam_start_time'];?>">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Exam End Time</label>
								<input type="time" name="exam_end_time" class="form-control" value="<?php echo $examCriteriaData[0]['exam_end_time'];?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Room</label>
								<input type="text" name="room" class="form-control" value="<?php echo $examCriteriaData[0]['exam_room'];?>">
							</div>
						</div>
						<div class="col-md-4">	
							<div class="form-group">
								<label>Select Status</label>
								<select name="exam_status" class="form-control">
									 <option value="Inactive">Inactive</option>
									 <option value="announced">Announce</option>
									 <option value="conducted">Conducted</option>
								</select>
							</div>
						</div>
					</div>
					<table class="table table-stripped"> 
						<div class="box-header">
							<h3>Exams Schedule</h3>
						</div>
		<?php
			for ($i=0; $i <$subjCount ; $i++) {
				$subject = $subjectarray[$i];

				$subjectId = Yii::$app->db->createCommand("
				SELECT subject_id FROM subjects WHERE subject_name = '$subject'
					")->queryAll();
				$subarray[$i] = $subjectId[0]['subject_id'];

				?>

				<tr>
					<td>
						<div class="row" style="border-bottom:3px solid #ebd6e7; ">
							<div class="col-md-2" style="border:1px solid;color:#AA5397;border-radius: 8px;">
								<p style="line-height:2.5;text-align: center;">
								<i class="fa fa-book"></i>
								<?php echo $subject;?>
								</p>
							</div>
							<div class="col-md-10">
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
										<label>Date</label>
										<input type="date" name="date[]" class="form-control" value="<?php echo $examScheduleData[$i]['date']; ?>">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
										<label>Invagilator</label>
										<select name="Invagilator[]" class="form-control">
											<?php 
											$empId = $examScheduleData[$i]['emp_id'];
											$emp_name = Yii::$app->db->createCommand("
											SELECT emp_id,emp_name
											FROM emp_info WHERE group_by ='Faculty' AND emp_id = '$empId'
											")->queryAll();
											$teacher = Yii::$app->db->createCommand("
											SELECT emp_id,emp_name
											FROM emp_info WHERE group_by ='Faculty'
											AND emp_id != '$empId'
											")->queryAll();
											$countteacher = count($teacher);
											 ?>
											<option value="<?php echo $emp_name[0]['emp_id'];?>">
												<?php echo $emp_name[0]['emp_name'];?>
											</option>
											<?php 
											for ($j=0; $j <$countteacher ; $j++) { ?>
											<option value="<?php
													echo $teacher[$j]['emp_id'];
											?>">
											<?php
													echo $teacher[$j]['emp_name'];
											?>
											</option>
											<?php } ?>
										</select>
										</div>
									</div>
								</div>
							</div>
						</div>
					</td>
				</tr>
				</table>
				<?php
			//end of for loop
			} ?>
	<input type="hidden" name="headId" value="<?php echo $classId;?>">
	<input type="hidden" name="subjCount" value="<?php echo $subjCount;?>">
	<input type="hidden" name="criteriaId" value="<?php echo $criteriaId;?>">
	<?php 

	foreach ($subarray as $key => $value) {
		echo '<input type="hidden" name="subarray[]" value="'.$value.'">';
	}

	 ?>
	<div class="row">
	 	<div class="col-md-12">
	 		<button type="submit" name="update" class="btn btn-info" style="float: right;">Update</button>
	 	</div>
	 </div>
	

				</form>
			</div>
		</div>
	</div>
</body>
</html>
