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
$vocational='';
$i=1;
$sql='select * from class_detail order by sort_no, class_description';
$res=execute_query(connect(), $sql);
while($class=mysqli_fetch_array($res)){
	$sql = "select *, student_info.sno as student_serial, student_info.category as student_category, fee_invoice.type as fee_type from fee_invoice join student_info on student_info.sno = student_id join class_detail on student_info.class = class_detail.sno where class_detail.sno=".$class['sno'];
	if(isset($_POST['type'])){
		if(isset($_POST['dfc_date'])){
			$sql .= " and fee_invoice.approval_date='".$_POST['dfc_date']."'";
		}
	
		if($_POST['type']=='computer'){
			$sql .= ' and fee_invoice.type="computer"';
		}
		if($_POST['type']=='all'){
			$sql .= ' and (fee_invoice.type="computer" OR fee_invoice.type="self" OR fee_invoice.type="vocational")';
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
	}

	//echo $sql.'<br>';
	//echo $sql.'<br>';
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
		<td>'.date("d-m-Y", strtotime($_POST['dfc_date'])).'</td>
		<td>'.$count.'</td>';
		echo '<td>'.$tot_fees.'</td>
		<td>'.$tot_vocational.'</td>
		</tr>';
	}
}
echo '<tr><td colspan="3">GRAND TOTAL</td><td>'.$tot_stu_count.'</td><td>'.$grand_fees.'</td><td>'.$grand_vocational.'</td></tr></table>';
?>
