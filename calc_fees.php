<?php
date_default_timezone_set('Asia/Calcutta');

echo calc_fees(1);


function dbconnect(){
	$connect = mysqli_connect("localhost","cloudice_knipss", "Knip@13579", "cloudice_knipss_2014");
	if(!$connect){
		die('1.System error contact administrator');
	}
	return $connect;	
}

	
function calc_fees($id, $cur_month=0){
	$fees=0;
	$sql = 'select * from student_info where sno='.$id;
	$stud = mysqli_fetch_array(execute_query(connect(), $sql));
	$prac_sno=0;
	if($cur_month==0){
		$cur_month = date("m");
		if($cur_month>=1 && $cur_month<=6){
			$cur_month=6;
		}
		else{
			$cur_month=12;
		}
	}

	if($stud['category']=='SC' or $stud['category']=='ST'){
		$fees = 158;
		return $fees;
	}
	else{
		$sql = 'select * from fees_detail join head_type on head_type.sno = fees_detail.head_id where class_id='.$stud['class'].' and head_id!='.$prac_sno;
		$result = execute_query(connect(), $sql);
		while($row = mysqli_fetch_array($result)){
			if($cur_month%$row['rec_duration']==0){
				$fees += $row['fee_amount'];
			}
		}
	}
	return $fees;
}


?>