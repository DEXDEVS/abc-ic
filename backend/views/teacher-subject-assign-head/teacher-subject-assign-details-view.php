<!DOCTYPE html>
<html>
<head>
	<title>All Branches</title>
</head>
<body>
<?php 
  $id = $_GET['id'];
  
   $teacherName = Yii::$app->db->createCommand("SELECT teacher_subject_assign_head_name FROM teacher_subject_assign_head WHERE teacher_subject_assign_head_id = '$id'")->queryAll();

  $teacherClassID = Yii::$app->db->createCommand("SELECT DISTINCT class_id FROM teacher_subject_assign_detail WHERE teacher_subject_assign_detail_head_id = '$id'")->queryAll();
?>
<div class="container-fluid">
	<section class="content-header">
      	<h1 style="color: #3C8DBC;">
        	<i class="fa fa-user-circle-o"></i>
          <?php echo $teacherName[0]['teacher_subject_assign_head_name']." - Information" ; ?>
      	</h1>
	    <ol class="breadcrumb" style="color: #3C8DBC;">
	        <li><a href="./home" style="color: #3C8DBC;"><i class="fa fa-dashboard"></i> Home</a></li>
	        <li><a href="./teacher-subject-assign-head" style="color: #3C8DBC;">Back</a></li>
	    </ol>
    </section>
    <!--  -->
	  <section class="content">
      <div class="row">
        <!-- /.col -->
        <div class="col-md-6">
          <table class="table table-bordered table-hover table-condensed table-striped">
            <tbody>
              <?php 
                foreach ($teacherClassID as $k => $val) {
                  $teacherClassId = $val['class_id'];              
                  $teacherClassName = Yii::$app->db->createCommand("SELECT std_enroll_head_name FROM std_enrollment_head WHERE std_enroll_head_id = '$teacherClassId'")->queryAll(); 
                  $teacherAssignDetail = Yii::$app->db->createCommand("SELECT tsah.teacher_subject_assign_head_name,tsad.class_id,tsad.subject_id,tsad.no_of_lecture,tsad.incharge
                  FROM teacher_subject_assign_detail as tsad
                  INNER JOIN teacher_subject_assign_head as tsah
                  ON tsah.teacher_subject_assign_head_id = tsad.teacher_subject_assign_detail_head_id
                  WHERE tsad.teacher_subject_assign_detail_head_id = '$id' ANd tsad.class_id = '$teacherClassId'")->queryAll();
              ?>
                <thead>
                  <tr>
                  <th colspan="6" class="label-primary text-center">
                    <?php echo $teacherClassName[0]['std_enroll_head_name']; ?>
                    
                      <?php 
                        if ($teacherAssignDetail[0]['incharge'] == 1) { ?>
                          <span class="label label-success" style="float: right;padding: 5px;">
                         <?php echo "Incharge"; ?>
                          </span>
                     <?php   }
                       ?>  
                    
                  </th>
                </tr>  
                <tr class="label-aqua">
                  <th style="width: 60px; text-align: center;">Sr #</th>
                  <th style="width: 200px">Subject</th>
                  <th>Lectures</th>
                  <th colspan="2" style="text-align: center;">Attendance</th>
                </tr>
                </thead>
                <?php
                  foreach ($teacherAssignDetail as $key => $value) {
                    $teacherSubjectId  = $value['subject_id'];
                    $teacherSubjectName = Yii::$app->db->createCommand("SELECT subject_name FROM subjects WHERE subject_id = '$teacherSubjectId'")->queryAll();
                ?>
                <tr>
                  <td align="center"><b><?php  echo $key+1; ?></b></td>
                  <td><?php echo $teacherSubjectName[0]['subject_name']; ?></td>
                  <td><?php echo $value['no_of_lecture'];?></td>
                  <td>
                    <a href="take-attendance?sub_id=<?php echo $teacherSubjectId;?>&class_id=<?php echo $teacherClassId;?>&teacherHeadId=<?php echo $id;?>" class="btn btn-success btn-xs">
                      Take
                    </a>
                  </td>
                  <td>
                    <a href="view-attendance?sub_id=<?php echo $teacherSubjectId;?>&class_id=<?php echo $teacherClassId;?>&teacherHeadId=<?php echo $id;?>" class="btn btn-warning btn-xs">
                      View
                    </a>
                  </td>
                  <td>
                    <a href="update-attendance?sub_id=<?php echo $teacherSubjectId;?>&class_id=<?php echo $teacherClassId;?>&teacherHeadId=<?php echo $id;?>" class="btn btn-info btn-xs">
                      Update
                    </a>
                  </td>
                </tr>
              <?php } } ?>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!--  -->
</div>	
</body>
</html>