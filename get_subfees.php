<?php
include("settings.php");
$q = strtoupper($_GET["q"]);
$sql = "select * from subject_fees where class_id=".$_GET['q']; 
$result = execute_query(connect(), $sql);
$val = '';
echo $sql;	
while($row = mysqli_fetch_array($result)){
	$sql_sub="select * from add_subject where sno=".$row['subject_id']."";
	$result1=mysqli_fetch_array(execute_query(connect(), $sql_sub));
	$val .= '<option value="'.$result1['sno'].'">'.$result1['subject'].'</option>';
}
echo $val;
?>