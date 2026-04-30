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
$_POST['dfc_date']=$_SESSION['comp_date4'];
$_POST['type']=$_SESSION['type4'];
$_POST['class_type']=$_SESSION['class_type4'];
?>
<style>
#wrapper{width:400mm; border:1px solid; margin:5mm;}
td{font-size:15px;}
</style> 

<table width="100%" border="1" id="feesreport">
	<tr style="background:#CCC; color:#FFF; text-align:center; font-size:13px;">
    	<td colspan="4"><?php echo date("F,Y",strtotime($_POST['dfc_date']))?>(Second Installment)</td>
    </tr>
	<tr style="background:#CCC; color:#FFF; text-align:center; font-size:13px;">
    	<td>S.No.</td>
        <td>CLASS</td>
        <td>STUDENT COUNT</td>
        <td><?php echo strtoupper($_POST['type'])?>&nbsp; FEES</td>
    </tr>
<?php 

$tot_stu_count=0;
$i=1;
$sql='select * from class_detail order by sort_no, class_description';
$res=execute_query(connect(), $sql);
while($class=mysqli_fetch_array($res)){
	$sql = "select *, student_info.sno as student_serial from fee_invoice3 join student_info on student_info.sno = fee_invoice3.student_id join class_detail on student_info.class = class_detail.sno where class_detail.sno=".$class['sno'];
	if(isset($_POST['dfc_date'])){
		$start = strtotime($_POST['dfc_date']);
		$start = date("01-m-Y",$start);
		$start = strtotime($start);
		$end = strtotime(date("Y-m-d",$start) . " +1 month");
		$sql.=' and fee_invoice3.timestamp>='.$start.' and fee_invoice3.timestamp<'.$end;
	
	}
	if($_POST['type']=='computer'){
		$sql .= ' and fee_invoice3.type="computer"';
	}
	if($_POST['type']=='self'){
		$sql.=' and fee_invoice3.type="self"';
	}
	if($_POST['class_type']=='self'){
			$sql .= ' and class_detail.type="SELF"';
	}
	if($_POST['class_type']=='aided'){
			$sql.=' and class_detail.type!="SELF"';
	}
	if($class['sno']>=60 && $class['sno']<=75){
		$class['sno']=$class['sno']+1;
		}
	$result = execute_query(connect(), $sql);
	$count = mysqli_num_rows($result);
	$tot_stu_count += $count;
	if($count!=0){
		echo '<tr>
		<td>'.$i++.'</td>
		<td>'.get_class_detail($class['sno'])['class_description'].'</td>
		<td>'.$count.'</td>';
		$tot_fees=0;
		while($row = mysqli_fetch_array($result)){
			$tot_fees+=$row['tot_amount'];
		}
		$grand_fees+=$tot_fees;
		echo '<td>'.$tot_fees.'</td></tr>';
	}
}
echo '<tr><td colspan="2">GRAND TOTAL</td><td>'.$tot_stu_count.'</td><td>'.$grand_fees.'</td></tr></table>';
?>
