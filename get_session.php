<?php
//session_start();
include("scripts/settings.php");

$sql = 'select * from general_settings where description="session"';
$session = mysqli_fetch_array(execute_query(connect(), $sql));

$sql = 'select * from class_detail where sno='.$_GET['q'];
$class = mysqli_fetch_array(execute_query(connect(), $sql));

$sql = 'select * from class_detail where sort_no="'.$class['sort_no'].'" order by abs(year) desc limit 1';
$class_to = mysqli_fetch_array(execute_query(connect(), $sql));

$year = $class_to['course_year']-1;

$session_from = explode("-", $session['value']);
$session_to = ($session_from[0]+$year).'-'.($session_from[1]+$year);

$array = array("session_from"=>$session_from[0], 'session_to'=>$session_from[1]+$year);

echo json_encode($array);

?>