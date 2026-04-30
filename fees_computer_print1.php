<?php
set_time_limit(0);
session_cache_limiter('nocache');
session_start();
//print_r($_SESSION);
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_store();
$response=1;
$msg='';
$i=0;
$_POST['dfc_date']=$_SESSION['comp_date'];
$_POST['type']=$_SESSION['type1'];
$_POST['class_type']=$_SESSION['class_type'];
$type=$_SESSION['type1'];
if($type=='self'){
	$type='Part time';
}
?>
<style>
#wrapper{width:400mm; border:1px solid; margin:5mm;}
td{font-size:15px;}
</style> 
<h3 style="font-size:16px;">Kamla Nehru Institute Of Physical & Social Sciences, Sultanpur</h3><br>
<table width="100%" border="1" id="feesreport">
	<tr style="background:#CCC; color:#FFF; text-align:center; font-size:13px;">
    	<td>S.No.</td>
        <td>CLASS</td>
        <td>DATE</td>
        <td>STUDENT COUNT</td>
        <td><?php echo strtoupper($type)?>&nbsp; FEES</td>
    </tr>
<?php 
$tot_stu_count=0;
$i=1;
$sql='select * from class_detail order by sort_no, class_description';
$res=execute_query(connect(), $sql);
while($class=mysqli_fetch_array($res)){
	$sql = "select *, student_info.sno as student_serial, student_info.category as student_category from fee_invoice join student_info on student_info.sno = student_id join class_detail on student_info.class = class_detail.sno where class_detail.sno=".$class['sno'];
	if(isset($_POST['dfc_date'])){
		$sql .= " and fee_invoice.approval_date='".$_POST['dfc_date']."'";
	}
	if($_POST['type']=='computer'){
		$sql .= ' and fee_invoice.type="computer"';
	}
	if($_POST['type']=='self'){
		$sql.=' and fee_invoice.type="self"';
	}
	if($_POST['class_type']=='self'){
			$sql .= ' and class_detail.type="SELF"';
	}
	if($_POST['class_type']=='aided'){
			$sql.=' and class_detail.type!="SELF"';
	}
	
	$result = execute_query(connect(), $sql);
	$count = mysqli_num_rows($result);
	$tot_stu_count += $count;
	if($count!=0){
		echo '<tr>
		<td>'.$i++.'</td>
		<td>'.$class['class_description'].'</td>
		<td>'.date("d-m-Y", strtotime($_POST['dfc_date'])).'</td>
		<td>'.$count.'</td>';
		$tot_fees=0;
		while($row = mysqli_fetch_array($result)){
			$tot_fees+=$row['tot_amount'];
		}
		$grand_fees+=$tot_fees;
		echo '<td>'.$tot_fees.'</td></tr>';
	}
}
echo '<tr><td colspan="3">GRAND TOTAL</td><td>'.$tot_stu_count.'</td><td>'.$grand_fees.'</td></tr></table>';
?>
