<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
	@media print{
	    .table th{
	        background-color: #001F3F !important;
	        color: #fff !important;
	    }
	    .table .tdcolor{
	    	background-color: #ccc !important;
	    }
	    .table .a{
	    	background-color: gray !important;
	    	 color: #FFF;
	    }
	}
</style>
</head>
<body>
<div class="row container-fluid">
<!-- class fee account report start-->
<div class="container-fluid" style="margin-top: -30px;">
	<h1 class="well well-sm bg-navy" align="center" style="color: #3C8DBC;">Class Account Fee Report</h1>
	<form method="POST" action="./monthly-fee-report" >
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="hidden" name="_csrf" class="form-control" value="<?=Yii::$app->request->getCsrfToken()?>">          
                </div>    
            </div>    
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <select class="form-control" name="sessionid" id="sessionId" required="">
                            <option value="">Select Session</option>
                            <?php 
                            $branch_id = Yii::$app->user->identity->branch_id;
                                $sessionName = Yii::$app->db->createCommand("SELECT * FROM std_sessions where delete_status=1 AND status ='Active' AND session_branch_id = '$branch_id'")->queryAll();
                                    foreach ($sessionName as  $value) { ?>  
                                    <option value="<?php echo $value["session_id"]; ?>">
                                        <?php echo $value["session_name"]; ?>   
                                    </option>
                            <?php } ?>
                    </select>      
                </div>    
            </div> 
            <div class="col-md-4">
                <div class="form-group">
                    <select class="form-control" name="classid" id="classId" required="">
                    	<option>Select Class</option>
                            <?php 
                                
                                $className = Yii::$app->db->createCommand("SELECT * FROM std_class_name where branch_id = '$branch_id' AND delete_status=1")->queryAll();
                                
                                    foreach ($className as  $value) { ?>    
                                    <option value="<?php echo $value["class_name_id"]; ?>">
                                        <?php echo $value["class_name"]; ?> 
                                    </option>
                            <?php } ?>
                    </select>      
                </div>    
            </div>  
             
            <div class="col-md-4">
                <div class="form-group">
                    <select class="form-control" name="sectionid" id="section" required="">
                            <option value="">Select Section</option>
                    </select>      
                </div>    
            </div>    
        </div>
        <div class="row">
            <div class="col-md-4">
                <label>Select Month</label>
                <div class="form-group">
                    <input type="month" name="month" required="" id="month">   
                </div>    
            </div>   
            <div class="col-md-3">
                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-success btn-flat" id="sub" value='Yes'><i class="fa fa-check-square-o" aria-hidden="true"></i><b> Get Class</b></button>
                </div>    
            </div>
        </div>
    </form>
    <!-- Header Form Close--> 
</div>
<!-- class fee account report end-->
</body>
</html>

<?php
$url = \yii\helpers\Url::to("fee-transaction-detail/fetch-students");

$script = <<< JS
$('#month').on('change',function(){
   var class_Id = $('#classId').val();
   var session_Id = $('#sessionId').val();
   var section_Id = $('#section').val();
   var month = $('#month').val();
  
   $.ajax({
        type:'post',
        data:{classid:class_Id,sessionid:session_Id,sectionid:section_Id,month:month},
        url: "$url",

        success: function(result){
            var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));
            if(jsonResult == 0){
                alert('Sorry! The account of this month not maintained yet.');
                $('#month').val('');
            }
        }         
    });       
});

$('#classId').on('change',function(){
    var classId = $('#classId').val();
    var session_Id = $('#sessionId').val();
  
   $.ajax({
        type:'post',
        data:{session_Id:session_Id,classId:classId},
        url: "$url",

        success: function(result){
            console.log(result);
            var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));
            var options = '';
            $('#section').empty();
            $('#section').append("<option>"+"Select Section"+"</option>");
            for(var i=0; i<jsonResult.length; i++) { 
                options += '<option value="'+jsonResult[i].section_id+'">'+jsonResult[i].section_name+'</option>';
            }
            // Append to the html
            $('#section').append(options);
        }         
    });       
});
JS;
$this->registerJs($script);
?>
</script>