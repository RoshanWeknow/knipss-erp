<?php
include("scripts/settings.php");
 

if (isset($_GET['selected_value']) && $_GET['id'] =='test'  ){
	$sql = "select * from infr_add_faculty_type where campus_name = ".$_GET['selected_value'];
	$result = execute_query($db,$sql);
	$msg = '<option disabled selected>---Select Your faculty type---</option>';
	//x`$data_to_send = array();
	if ($result){
		while($row_type = mysqli_fetch_assoc($result)){
			$msg .= '<option value="'.$row_type['sno'].'" >'.mysqli_fetch_assoc(execute_query($db,'select * from infr_add_faculty_type where sno = '.$row_type['sno']))['faculty_type'].'</option>';
		}
	}
	//$msg .= '</select>';
	echo $msg;
}
if (isset($_GET['faculty_type']) && $_GET['id'] =='test'  ){
	$sql = "select * from infr_add_floor where faculty_type = ".$_GET['faculty_type'];
	$result = execute_query($db,$sql);
	$msg = '<option disabled selected>---Select Your floor name---</option>';
	//x`$data_to_send = array();
	if ($result){
		while($row_type = mysqli_fetch_assoc($result)){
			$msg .= '<option value="'.$row_type['sno'].'" >'.mysqli_fetch_assoc(execute_query($db,'select * from infr_add_floor where sno = '.$row_type['sno']))['floor_name'].'</option>';
		}
	}
	//$msg .= '</select>';
	echo $msg;
}

if(isset($_GET['selected_value']) && $_GET['id'] !='test'){
	//	echo $_GET['id'];
	$sql1 = execute_query($db,'select * from infr_add_faculty_type where campus_name='.$_GET['id']);
	
	if($sql1){
		$data = mysqli_fetch_assoc($sql1);
	}
	//print_r($data);
	$sql = "select * from add_floor where building_name = ".$_GET['selected_value'];
	$result = execute_query($db,$sql);
	//print_r($result);
	$msg = '<option disabled selected>---Select Your Course applying for---</option>';
	//x`$data_to_send = array();
	if ($result){
		while($row_type = mysqli_fetch_assoc($result)){ 
		//print_r($row_type);
			$msg .= '<option value="'.$row_type['sno'].'" '.(isset($data['floor_name']) && $data['floor_name']==$row_type['sno']? 'selected="selected"':'').'  >'.$row_type['floor_name'].'</option>';
		}
	}
	//$msg .= '</select>';
	echo $msg;
}

?>