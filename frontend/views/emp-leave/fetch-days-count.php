<?php 

	if(isset($_POST['endDate'])){

		$endDate = $_POST['endDate'];
		$startDate = $_POST['startDate'];

		//$startDate  = date('2019-05-01');
$day1  = date('d', strtotime($startDate));
$month1  = date('m', strtotime($startDate));
$year1 = date('y',  strtotime($startDate));
//$endDate  = date('2019-05-03');
$day2  = date('d', strtotime($endDate));
$month2  = date('m', strtotime($endDate));
$year2 = date('y',  strtotime($endDate));
if ($month1 == $month2) {
$totalDaysInMonth = cal_days_in_month(CAL_GREGORIAN, $month1,$year1);
	$countDate=0;
	for($i = 1; $i<= $totalDaysInMonth; $i++){
    	$var = $year1."-".$month1."-".$i;
	    	$day  = date('Y-m-d',strtotime($var));
	    	
	    	$result = date("l", strtotime($day));
	    	if($startDate <= $day && $endDate >= $day){
	    	//	echo $day."<br>";
	  		if($result == "Sunday"){
	  			continue;
	   		} else {
	   			//echo date("Y-m-d", strtotime($day)). " ".$result."<br>";
	   			$countDate++;
	   		}
	    }
	}

} else {
	//first month
	$totalDaysInMonth = cal_days_in_month(CAL_GREGORIAN, $month1,$year1);
	$countDate=0;
	for($i = 1; $i<= $totalDaysInMonth; $i++){
    	$var = $year1."-".$month1."-".$i;
	   	$day  = date('Y-m-d',strtotime($var));
	   	$result = date("l", strtotime($day));
	   	if($startDate <= $day){
	  		if($result == "Sunday"){
	  			continue;
	   		} else {
	   			//echo date("Y-m-d", strtotime($day)). " ".$result."<br>";
	   			$countDate++;
		   			
	   		}
	   }
	}

	 // secnd month
	 $totalDaysInMonth2 = cal_days_in_month(CAL_GREGORIAN, $month2,$year2);

	 for($i = 1; $i<= $totalDaysInMonth2; $i++){
    	$var = $year2."-".$month2."-".$i;
	    	$day  = date('Y-m-d',strtotime($var));
	    	$result = date("l", strtotime($day));
	    	if($endDate >= $day){
		  		if($result == "Sunday"){
		  			continue;
		   		} else {
		   					//echo date("Y-m-d", strtotime($day)). " ".$result."<br>";
		   			$countDate++;   			
	    		}
	    	}
	 }
}
	 

echo json_encode($countDate);
	} // isset close
 ?>