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
$_POST['dfc_date']=$_SESSION['comp_date2'];
$_POST['type']=$_SESSION['type2'];
$_POST['class_type']=$_SESSION['class_type2'];
?>
<style>
#wrapper{width:400mm; border:1px solid; margin:5mm;}
td{font-size:15px;}
</style> 

<table width="100%" border="1" id="feesreport">
	<tr style="background:#CCC; color:#FFF; text-align:center; font-size:13px;">
    	<td>S.No.</td>
        <td>CLASS</td>
        <td>STUDENT COUNT</td>
        <td>
        	<?php
			if(!isset($_POST['type'])){
				echo 'COMPUTER/SELF FEES';
			}
			else{
				if($_POST['type']=='computer'){
					echo 'COMPUTER';
				}
				else{
					echo 'SELF';
				}
			}
			?>
        	
        </td>
        <td>VOCATIONAL FEES</td>
    </tr>
<?php 
$tot_stu_count=0;
$grand_fees=0;
$grand_vocational=0;
$i=1;
$sql='select * from class_detail order by sort_no, class_description';
$res=execute_query(connect(), $sql);
while($class=mysqli_fetch_array($res)){
	$sql = "select *, student_info.sno as student_serial, student_info.category as student_category, fee_invoice.type as fee_type from fee_invoice join student_info on student_info.sno = student_id join class_detail on student_info.class = class_detail.sno where class_detail.sno=".$class['sno'];
	if(isset($_POST['type'])){
		$start = strtotime($_POST['dfc_date']);
		$start = date("01-m-Y",$start);
		$start = strtotime($start);
		$end = strtotime(date("Y-m-d",$start) . " +1 month");
		$sql.=' and fee_invoice.timestamp>='.$start.' and fee_invoice.timestamp<'.$end;
	
		if($_POST['type']=='computer'){
			$sql .= ' and fee_invoice.type="computer"';
		}
		if($_POST['type']=='self'){
			$sql.=' and fee_invoice.type="self"';
		}
		if($_POST['type']=='all'){
			$sql .= ' and (fee_invoice.type="computer" OR fee_invoice.type="self" OR fee_invoice.type="vocational")';
		}
		if($_POST['class_type']=='self'){
				$sql .= ' and class_detail.type="SELF"';
		}
		if($_POST['class_type']=='aided'){
				$sql.=' and class_detail.type!="SELF"';
		}

		$_SESSION['class_type2']=$_POST['class_type'];
		$_SESSION['comp_date2']=$_POST['dfc_date'];
		$_SESSION['type2']=$_POST['type'];
	}
	$result = execute_query(connect(), $sql);
	$count = mysqli_num_rows($result);
	if($count!=0){
		$count=0;
		$tot_fees=0;
		$tot_vocational=0;
		
		$old_id='';
		while($row = mysqli_fetch_array($result)){
			if($old_id!=$row['student_id']){
				$count++;
				$old_id = $row['student_id'];
			}
			if($row['fee_type']=='vocational'){
				$tot_vocational+=$row['tot_amount'];
			}
			else{
				
				$tot_fees+=$row['tot_amount'];
			}
			
		}
		$grand_fees+=$tot_fees;
		$grand_vocational+=$tot_vocational;
		$tot_stu_count+=$count;
		
		echo '<tr>
		<td>'.$i++.'</td>
		<td>'.$class['class_description'].'</td>
		<td>'.$count.'</td>';
		echo '<td>'.$tot_fees.'</td>
		<td>'.$tot_vocational.'</td></tr>';
	}
}
echo '<tr><td colspan="2">GRAND TOTAL</td><td>'.$tot_stu_count.'</td><td>'.$grand_fees.'</td><td>'.$grand_vocational.'</td></tr></table>';
?>