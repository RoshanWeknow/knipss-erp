<?php
set_time_limit(0);
session_cache_limiter('nocache');
session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_store();
$response=1;
$msg='';
$i=0;
if(isset($_POST['submit1'])){
	$date=$_POST['dfcdate'];
	$sql = 'select * from fees_transfer2 where month="'.date("Y-m", strtotime($date)).'" and type="aided"';
	$res = execute_query(connect(), $sql);
	if(mysqli_num_rows($res)==0){
		$sql = 'insert into fees_transfer2 (head_id, amount, timestamp, type, month) values ';
		$comma=0;
		foreach($_POST as $k => $v){
			if(strpos($k,'fees')!==false){
				if($comma==0){
					$sql .= '("'.$k.'", "'.$v.'", "'.time().'", "aided", "'.date("Y-m", strtotime($date)).'")';
					$comma=1;
				}
				else{
					$sql .= ', ("'.$k.'", "'.$v.'", "'.time().'", "aided", "'.date("Y-m", strtotime($date)).'")';
				}
			}
		}
		//echo $sql;
		execute_query(connect(), $sql);
		$msg="<h2>Collection Generated</h2>";
	}
	else{
		$msg .= '<h2>Collection Already Generated.</h2>';
	}
	
}
?>
<body id="public">
	<div id="wrapper">	
		<div id="content">    
        	<div id="container"> 
<?php
echo $msg
?>
			</div>
		</div>
<?php 
page_footer_store(); 
function editable($field){
	if($field!=''){
		echo 'readonly= "readonly"';
	}
}
?>