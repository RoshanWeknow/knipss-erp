<?php
include("settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
$sql = "select * from general_table where sno=".$_GET['q'];
$result = execute_query(connect(), $sql);
$val = '';
while($row = mysqli_fetch_array($result)){
	echo'<div><input type="text" id="hra" value="'.$row['hra'].'">
	<div><input type="text"  id="cca" value="'.$row['cca'].'">
	<div><input type="text"  id="spl_pay" value="'.$row['spl_pay'].'">';
}

?>