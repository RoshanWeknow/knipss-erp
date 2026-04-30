<?php
//session_start();
include("scripts/settings.php");
$sql = 'SELECT class_id, other_sub_id, subject, subject_type FROM `class_detail_other_sub` left join add_subject2 on add_subject2.sno = other_sub_id where class_id='.$_GET['q'];
$result = execute_query($db, $sql);
while($row = mysqli_fetch_array($result)){
	$val .= '<option value="'.$row['other_sub_id'].'">'.$row['subject'].'</option>';
}
//echo $val.'#'.$class['category'].'#'.$class['type'].'#'.$amount['fee_amount'].'#'.$amount1['fee_amount'].'#'.$amount2['fee_amount'].'#'.$fees.'#'.$discount.'#'.$univ;
$array = array("subjects"=>$val);

echo json_encode($array);

?>