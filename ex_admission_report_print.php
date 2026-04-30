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
$_POST['dfc_date_to'] = $_SESSION['comp_date1'];
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
	$sql = "select *, student_info3.sno as student_serial, student_info3.category as student_category from fee_invoice4 join student_info3 on student_info3.sno = fee_invoice4.student_id join class_detail on student_info3.class = class_detail.sno where class_detail.sno=".$class['sno'];
	if(isset($_POST['dfc_date'])){
		$sql .= " and fee_invoice4.approval_date>='".$_POST['dfc_date']."' and fee_invoice4.approval_date<='".$_POST['dfc_date_to']."'";
	}
	if($_POST['type']=='BACK'){
		$sql .= ' and student_info3.type="BACK"';
	}
	if($_POST['type']=='EX'){
		$sql.=' and student_info3.type="EX"';
	}
	if($_POST['type']=='PRIVATE'){
		$sql.=' and student_info3.type="PRIVATE"';
	}
	
	
	//echo $sql;
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
