<?php 

	// getting `exam_category_id` from `exams_criteria`
	$examCateogryId = $_GET['id'];
	// getting exam `category_name` from `exams_cateogry`
	$examCategoryName = Yii::$app->db->createCommand("
				SELECT category_name FROM exams_category WHERE exam_category_id = '$examCateogryId'
					")->queryAll();
	// getting class IDs `std_enroll_head_id` from `exams_criteria` against `exam_category_id`
	$classIds = Yii::$app->db->createCommand("
				SELECT DISTINCT (std_enroll_head_id) FROM exams_criteria WHERE exam_category_id = '$examCateogryId'
					")->queryAll();
	$countClassIds = count($classIds);
 ?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header" style="padding:0px;">
					<h2 style="text-align: center;font-family: georgia;font-size:30px;">
						<?php echo $examCategoryName[0]['category_name']; ?>
					</h2>
					<p style="font-weight:bold;text-align: center;"><u>Date Sheets</u></p>
				</div><hr>	
				<div class="box-body">
					<?php 
					if (empty($countClassIds)) {
					 	echo "No Schedule for classes is avaialble...!!!";
					}
					else { ?>
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Sr.#</th>
								<th>Classes</th>
								<th>View Schedules</th>
							</tr>
						</thead>
						<tbody>
							<?php
							for ($i=0; $i <$countClassIds ; $i++) { 		 
								$classID = $classIds[$i]['std_enroll_head_id'];
								// getting classes name `std_enroll_head_name` from `std_enrollment_head` against `std_enroll_head_id`
								$className = Yii::$app->db->createCommand("
											SELECT std_enroll_head_name FROM std_enrollment_head WHERE std_enroll_head_id = '$classID'
												")->queryAll();
							 ?>
							<tr  style="padding:0px;">
								<td>1</td>
								<td><?php echo $className[0]['std_enroll_head_name']; ?></td>
								<td><a href="./view-datesheet?examcatID=<?php echo $examCateogryId;?>&classID=<?php echo $classID;?>">View Datesheet</a></td>
							</tr>
							<?php }  } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>