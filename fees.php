<?php
error_reporting(E_ALL);
date_default_timezone_set('Asia/Calcutta');
//error_reporting(0);
include("scripts/settings.php");

$class = $_GET['a'];
$sub1 = $_GET['b'];
$sub2 = $_GET['c'];
$sub3 = $_GET['d'];
$gender = $_GET['e'];

calc_fees_new($class,$sub1,$sub2,$sub3,$gender);
function calc_fees_new1($class,$sub1,$sub2,$sub3,$gender){
	$r = calc_sub_fees_new1($class, $sub1, $sub2, $sub3);
	echo '<table border=1>';
	$link = connect();
	$sql = "select * from class_detail where sno=".$class;
	$class_detail = mysqli_fetch_array(execute_query(connect(), $sql,$link));
	$sql = "select * from fees_detail where class_id=".$class;
	$result_heads = execute_query(connect(), $sql,$link);
	$i=1;
	$head_tot = 0;
	$sci=0;
	$fem=0;
	while($row_heads = mysqli_fetch_array($result_heads)){
		$sql = "select * from head_type where sno = ".$row_heads['head_id'];
		$head = mysqli_fetch_array(execute_query(connect(), $sql,$link));
		if($head['sno']==14){
			$row_heads['fee_amount'] = $row_heads['fee_amount']*$r['c'];
		}
		echo "<tr><td>$i</td>
		<td>".$head['fee_type']."</td>
		<td>".$row_heads['fee_amount']."</td>
		</tr>";
		$head_tot += $row_heads['fee_amount'];
		$i++;
	}
	echo '<tr><th></th><th>Total</th><th>'.$head_tot.'</th></tr></table>';
	if($gender=='F'){
		$sql = 'select * from fees_detail where class_id='.$class.' and head_id=1';
		$female = mysqli_fetch_array(execute_query(connect(), $sql));
	}
	else{
		$female['fee_amount']=0;
	}
	
	echo '
	<table>
		<tr>
			<th>Head Fees:'.$head_tot.'</th>
		</tr>
		<tr>
			<th>Subject Fees:'.$r['fees'].'</th>
		</tr>
		<tr>
			<th>Self:'.$self.'</th>
		</tr>
		<tr>
			<th>Female Disount: '.$female['fee_amount'].'</th>
		</tr>';
	echo '
	<tr><th>Grand Total:'.(($head_tot+$r['fees']+$self)-$female['fee_amount']).'</th>
	</tr></table>';
	
}

function calc_sub_fees_new1($class,$sub1, $sub2, $sub3){
	$link = connect();
	$sql = 'select sum(fees) as fees, count(*) c from subject_fees where class_id='.$class.' and subject_id in ('.$sub1.', '.$sub2.', '.$sub3.') and fees!=""';
	$row = mysqli_fetch_array(execute_query(connect(), $sql,$link));
	return $row;
}
?>