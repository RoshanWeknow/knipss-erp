<?php
//session_start();
include("scripts/settings.php");
$sql = 'SELECT * FROM `add_subject_details` where class_id="'.$_GET['cid'].'" and subject_id="'.$_GET['sid'].'"';
$paper_result = execute_query(connect(), $sql);
$val='';
while($row = mysqli_fetch_assoc($paper_result)){
	$val .= '<option value="'.$row['sno'].'">'.$row['title_of_paper'].'</option>';
}

//echo $val.'#'.$class['category'].'#'.$class['type'].'#'.$amount['fee_amount'].'#'.$amount1['fee_amount'].'#'.$amount2['fee_amount'].'#'.$fees.'#'.$discount.'#'.$univ;
$array = array("subjects"=>$val);

echo json_encode($array);

?>