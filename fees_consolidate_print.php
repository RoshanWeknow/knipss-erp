<?php
set_time_limit(0);
session_cache_limiter('nocache');
session_start();
include("scripts/settings.php");
$response=1;
$msg='';
$i=0;
$sql= "select * from head_type";
$result_head = execute_query(connect(), $sql);
$count = mysqli_num_rows($result_head);
$start=$_SESSION['start1'];
$end=$_SESSION['end1'];
$_POST['dfc_date']=$_SESSION['fees_date'];
?>
<style>
body{
	width: 400mm;
}
#wrapper{width:400mm; border:1px solid; margin:5mm;}
td{font-size:12px; word-wrap:break-word; word-break:break-all; width:45px}
td.min{width:35px;}
</style>           
<div id="wrapper">

<table width="100%" border="1" id="feesreport">
<?php
if(isset($_SESSION['class_first'])){
	$sql = "select * from class_detail where sno=".$_SESSION['class_first'];
	//echo $sql;
	$class = mysqli_fetch_array(execute_query(connect(), $sql));
	echo '<tr style="background:#CCC; color:#FFF; text-align:center; font-size:13px;"><td colspan="36">'.$class['class_description'].'</td></tr>';
	
}
?>
	<tr style="background:#CCC; color:#FFF; text-align:center; " >
    	<td rowspan="3">S.No.</td>
        <td rowspan="3" nowrap="nowrap">DATE/TIME</td>
        <td rowspan="3" class="min">STUDENT COUNT</td>
        <td colspan="<?php echo $count-2;?>">FEES HEADS<?php echo '('.date("F-Y", strtotime($_POST['dfc_date'])).')'; ?></td>
        <td colspan="4">&nbsp;</td>
        <td rowspan="3">TOTAL2</td>
        <td rowspan="3">TOTAL</td>
	</tr>
    <tr style="background:#CCC; color:#FFF; text-align:center; ">
    	<td colspan="4">MAINTENANCE</td>
    	<td colspan="16">&nbsp;</td>
    	<td colspan="12">UNIVERSITY FEES ACCOUNT</td>
     <!--   <td colspan="5"></td>
    	<td colspan="12">PRACTICAL FEES ACCOUNT</td>-->
    </tr>
    <tr style="background:#CCC; color:#FFF; text-align:center; ">
<?php
while($row_head = mysqli_fetch_array($result_head)){
	if($row_head['sno']==4){
		echo '<td nowrap="nowrap">Total1</td>';
	}
	if($row_head['sno']==23){
		echo '<td class="min" >Lab Fee Half Yearly</td>';
	}
	echo '<td class="min">'.strtoupper($row_head['fee_type']).'</td>';
	$fees_division[$row_head['sno']]=0;
}
?>
<!--	<td>TOTAL FEES</td>
    <td>ZOOLOGY PRACTICAL FEES</td>
    <td>BOTANY PRACTICAL FEES</td>
    <td>CHEMISTRY PRACTICAL FEES</td>
    <td>PHYSICS PRACTICAL FEES</td>
    <td>MILITARY SCIENCE PRACTICAL FEES</td>
    <td>GEOGRAPHY PRACTICAL FEES</td>
    <td>HOME SCIENCE PRACTICAL FEES</td>
    <td>PHYSICAL EDUCATION PRACTICAL FEES</td>
    <tr>TOTAL PRACTICAL FEES (36 to 50)</tr>-->
    </tr>
     <?php
	$grand_tot[]=0;
	for($td=1; $td<=35; $td++){
		$tot[]=0;
		$grand_tot[]=0;
		if($td==7){
			echo '<td>7<br>(4+5+6)</td>';
		}
		//elseif($td==17){
			//echo '<td>17<br>(15+16)</td>';
		//}
		//elseif($td==30) {
			//echo '<td>30<br>(26+27+28+29)</td>';
		//}
		else{
			echo '<td>'.$td.'</td>';
		}
	}
	$grand_tot[50] = 0;
	$grand_tot[52] = 0;
	?>
    </tr>
<?php
$test='';
$tot_stu_count=0;
$i=1;
$start=$_SESSION['start1'];
$end=$_SESSION['end1'];
while($start<$end){
	unset($tot);
	$tot[0]=0;
	for($td=1; $td<=35; $td++){
		$tot[]=0;
	}
	$tot[50]=0;
	$tot[52]=0;
	$sub_end = strtotime(date("Y-m-d",$start)."+1 day");
	$_POST['s_class']=$_SESSION['class'];
	$sql = "select *, fee_invoice.sno as fees_serial, student_info.sno as student_serial from fee_invoice join student_info on fee_invoice.student_id = student_info.sno where amount_paid is not null and type="."'fees'";
	if(isset($_POST['s_class'])){
		if($_POST['s_class']!=''){
			$sql .= ' and student_info.class="'.$_POST['s_class'].'"';
		}
	}
	$sql .= " and timestamp>=".$start." and timestamp<".$sub_end." order by fee_invoice.sno";
	//echo $sql.' - '.date("d-m-Y", $start).' - '.date("d-m-Y", $sub_end).'<br>';
	
	$result = execute_query(connect(), $sql);
	$count = mysqli_num_rows($result);
	$tot_stu_count += $count;
	
	$sql = 'select sum(amount_paid) as amount_paid from fee_invoice where amount_paid is not NULL and type="fees" and timestamp>=".$start." and timestamp<".$sub_end."';
	$amount_paid = mysqli_fetch_array(execute_query(connect(), $sql));
	$amount_paid = $amount_paid['amount_paid'];
	//$tot[31]+=$amount_paid;		
	//$tot[30]+=$tot_fees;
	//$grand_tot[31]+=$amount_paid;
	//$grand_tot[30]+=$tot_fees;
	echo '<tr>
	<td>'.$i++.'</td>
	<td>'.date("d-m-Y",$start).'</td>
	<td>'.$count.'</td>';
	while($row = mysqli_fetch_array($result)){
		$final_res = fees_bifucation($row);
		$tot[50] += $final_res[1][50];
		$tot[22] += $final_res[1][22];
		$tot[52] += $final_res[1][52];
		$tot[30] += $final_res[1][30];
		$tot[31] += $final_res[1][31];
		$sql = 'select * from head_type';
		$re = execute_query(connect(), $sql);
		while($a = mysqli_fetch_array($re)){
			$tot[$a['sno']] += $final_res[1][$a['sno']];
			$grand_tot[$a['sno']] += $final_res[1][$a['sno']];
		}
	}
	$grand_tot[50] += $tot[50];
	$grand_tot[22] += $tot[22];
	$grand_tot[52] += $tot[52];
	$grand_tot[30] += $tot[30];
	$grand_tot[31] += $tot[31];
	$start = $sub_end;
	//echo '<tr><th colspan="2">GRAND TOTAL :</th>';
	$sql = 'select * from head_type';
	$re = execute_query(connect(), $sql);
	while($a = mysqli_fetch_array($re)){
		echo '<td>'.$tot[$a['sno']].'</td>';
		if($a['sno']==3){
			echo '<td>'.$tot[50].'</td>';
		}
		if($a['sno']==21){
			echo '<td>'.$tot[22].'</td>';
	 	}
	}
	echo '<td>'.$tot[52].'</td>';
	echo '<td>'.$tot[30].'</td>';
	//echo '<td>'.$tot[31].'</td>';
	if($tot[30]!=$tot[31]){
		echo '<td>ERROR</td>';
	}
}
echo '<tr><td colspan="2">GRAND TOTAL :</td>
<td>'.$tot_stu_count.'
<input type="hidden" name="total_student" value="'.$tot_stu_count.'"></td>';
	$sql = 'select * from head_type';
	$re = execute_query(connect(), $sql);
	while($a = mysqli_fetch_array($re)){
		if($a['sno']==1){
			echo '<td style="width:100px;">'.$grand_tot[$a['sno']].'<input type="hidden" name="fees_total_'.$a['sno'].'" value="'.$grand_tot[$a['sno']].'"></td>';
		}
		else{
			echo '<td style="width:90px;">'.$grand_tot[$a['sno']].'<input type="hidden" name="fees_total_'.$a['sno'].'" value="'.$grand_tot[$a['sno']].'"></td>';
		}
		if($a['sno']==3){
			echo '<td style="width:100px;">'.$grand_tot[50].'</td>';
		}
		if($a['sno']==21){
			echo '<td style="width:100px;">'.$grand_tot[22].'</td>';
		}
	}
	echo '<td style="width:100px;">'.$grand_tot[52].'</td>';
	echo '<td style="width:100px;">'.$grand_tot[30].'</td>';
	//echo '<td style="width:100px;">'.$grand_tot[31].'</td>';
	//echo '<td>'.$grand_tot[$a].'<input type="hidden" name="fees_total_'.$a.'" value="'.$grand_tot[$a].'"></td>';
	$date= date("Y-m", strtotime($_POST['dfc_date']));
	echo '
	</table>
	<input type="hidden" name="dfc_date" value="'.$date.'" id="dfc_date" >
	</form></div>';
	//echo '<input type="Submit" name="submit" value="Generate Fees Transfer" class="submit">
	//<input type="button" name="print_sheet" value="Print Fees Transfer Chart" onClick="print_chart()" class="submit">';
?>
