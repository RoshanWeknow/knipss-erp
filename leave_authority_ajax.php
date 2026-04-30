<?php
include("scripts/settings.php");
 

if (isset($_GET['selected_value']) && $_GET['id'] =='test'  ){
	$sql = "select * from leave_authority_master where faculty_type = ".$_GET['selected_value'];
	$result = execute_query($db,$sql);
	$msg = '<option disabled selected>---Select Your department---</option>';
	//x`$data_to_send = array();
	if ($result){
		while($row_type = mysqli_fetch_assoc($result)){
			$msg .= '<option value="'.$row_type['department'].'" >'.mysqli_fetch_assoc(execute_query($db,'select * from dp_department where sno = '.$row_type['department']))['department_name'].'</option>';
		}
	}
	
	//$msg .= '</select>';
	echo $msg;
}
if (isset($_GET['department']) && $_GET['id'] =='test'  ){
	//echo $_GET['department'];
	$sql = "select * from leave_authority_master where department = ".$_GET['department'];
	//echo $sql;
	$result = execute_query($db,$sql);
	$msg='';
	//x`$data_to_send = array();
	if ($result){
		while($row_type = mysqli_fetch_assoc($result)){
			$msg .= '<option value="'.$row_type['authority_name'].'" >'.mysqli_fetch_assoc(execute_query($db,'select * from dp_invoice_personal_info where sno = '.$row_type['authority_name']))['full_name'].'</option>';
		}
	}
	$msg .= '<option value="25">Principal</option>';
	//$msg .= '</select>';
	echo $msg;
}

if(isset($_GET['selected_value']) && $_GET['id'] !='test'){
	//	echo $_GET['id'];
	$sql1 = execute_query($db,'select * from leave_faculty where department='.$_GET['id']);
	
	if($sql1){
		$data = mysqli_fetch_assoc($sql1);
	}
	//print_r($data);
	$sql = "select * from leave_authority_master where department = ".$_GET['selected_value'];
	$result = execute_query($db,$sql);
	//print_r($result);
	$msg = '<option disabled selected>---Select Your Course applying for---</option>';
	//x`$data_to_send = array();
	if ($result){
		while($row_type = mysqli_fetch_assoc($result)){ 
		//print_r($row_type);
			$msg .= '<option value="'.$row_type['sno'].'" '.(isset($data['authority_name']) && $data['authority_name']==$row_type['sno']? 'selected="selected"':'').'  >'.$row_type['authority_name'].'</option>';
		}
	}
	//$msg .= '</select>';
	echo $msg;
}

?>