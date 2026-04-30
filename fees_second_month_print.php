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
$start=$_SESSION['start2'];
$end=$_SESSION['end2'];
$_POST['dfc_date']=$_SESSION['fees_date2'];
?>
<style>
body{
	width: 400mm;
}
#wrapper{width:400mm; border:1px solid; margin:5mm;}
td{font-size:12px; word-wrap:break-word; word-break:break-all; width:15px}
td.min{width:10px;}
</style>           
<div id="wrapper">
<table width="100%" border="1" id="feesreport">
<?php
if(isset($_SESSION['class2'])){
	$sql = "select * from class_detail where sno=".$_SESSION['class2'];
	//echo $sql;
	$class = mysqli_fetch_array(execute_query(connect(), $sql));
	echo '<tr style="background:#CCC; color:#FFF; text-align:center; font-size:13px;"><td colspan="36">'.$class['class_description'].'</td></tr>';
	
}
?>
	<tr style="background:#CCC; color:#FFF; text-align:center;">
    	<td rowspan="3" style="width:10px;">S.No.</td>
        <td rowspan="3" nowrap="nowrap">DATE/TIME</td>
        <td rowspan="3" class="min">STUDENT COUNT</td>
       <td colspan="<?php echo $count-2;?>">FEES HEADS (SECOND INSTALLMENT) <?php echo '('.date("F-Y", strtotime($_POST['dfc_date'])).')'; ?></td>
        <td colspan="4">&nbsp;</td>
        <td rowspan="3">TOTAL2</td>
        <td rowspan="3">EXCESS</td>
        <td rowspan="3">TOTAL</td>
	</tr>
    <tr style="background:#CCC; color:#FFF; text-align:center; ">
    	<td colspan="4">MAINTENANCE</td>
    	<td colspan="20">&nbsp;</td>
    	<td colspan="6">UNIVERSITY FEES ACCOUNT</td>
     <!--   <td colspan="5"></td>
    	<td colspan="12">PRACTICAL FEES ACCOUNT</td>-->
    </tr>
    <tr style="background:#CCC; color:#FFF; text-align:center; ">
<?php
while($row_head = mysqli_fetch_array($result_head)){
	if($row_head['sno']==4){
		echo '<td >Total1</td>';
	}
	if($row_head['sno']==23){
		echo '<td >Lab Fee Half Yearly</td>';
	}
	echo '<td>'.strtoupper($row_head['fee_type']).'</td>';
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
	for($td=1; $td<=36; $td++){
		$tot[]=0;
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
	?>
    </tr>
<?php
$start_time = microtime(true);
$test='';
$tot_stu_count=0;

$start = $_SESSION['start2'];
$end = $_SESSION['end2'];
$_POST['dfc_date'] = $_SESSION['fees_date2'];
$_POST['s_class'] = $_SESSION['class2'];
if(isset($_POST['dfc_date'])){
    if(isset($_POST['dfc_date'])){
    	$start = strtotime($_POST['dfc_date']);
    	$start = date("01-m-Y",$start);
    	$start = strtotime($start);
    	$end = strtotime(date("Y-m-d",$start) . " +1 month");
    	//$start = strtotime("2013-07-16");
    	//$end = strtotime("2013-07-17");
    }
    else{
    	$start = strtotime(date("Y-m-d"));
    	$end = $start+86400;	
    }
    
    echo '<input type="hidden" value="'.date("Y-m-01",$start).'" name="month">';
    $i=1;
    	$grand_tot[50]=0;
    	$grand_tot[52]=0;
    while($start<$end){
    	unset($tot);
    	$tot[0]=0;
    	for($td=1; $td<=35; $td++){
    		$grand_tot[]=0;
    		$tot[]=0;
    	}
    	$tot[50]=0;
    	$tot[52]=0;
    	$sub_end = strtotime(date("Y-m-d",$start)."+1 day");
    	$class='';
    	if(isset($_POST['s_class'])){
    		if($_POST['s_class']!=''){
    		$class= ' and class="'.$_POST['s_class'].'"';
    		}
    		if($_POST['s_class']>=60 && $_POST['s_class']<=81){
    			$fee_type=' and student_info2.type="admission"';
    		}
    		
    }
    
    	$timestamp= " and timestamp>=".$start." and timestamp<".$sub_end;
    	$sql = "(select student_info2.sno as sno, stu_name, father_name, mother_name, class, reservation, waightage, minority, dob, acc_no, bank_name, branch_name, temp_address, perm_address, pin, mobile, p_mobile, p_pin, date_of_admission, gender, photo_id, signature_id, subject_id, category, form_no, p_district, p_state, sub1, sub2, sub3, e_mail1, e_mail2, student_info2.status, roll_no, marks, counselling_date, cat_rank, income_certificate, annual_income, other_univ, student_info2.user_id as stu_user, icard, univ_roll, cancel_date, remarks, fee_invoice3.sno as fees_serial, student_info2.student_id as student_serial, timestamp, fee_invoice3.user_id as user_id from fee_invoice3 join student_info2 on fee_invoice3.student_id = student_info2.student_id where amount_paid is not null and fee_invoice3.type='fees' $timestamp $class $fee_type  and fee_invoice3.class_id=student_info2.class)
    union all (select student_info.sno as sno, stu_name, father_name, mother_name, class, reservation, waightage, minority, dob, acc_no, bank_name, branch_name, temp_address, perm_address, pin, mobile, p_mobile, p_pin, date_of_admission, gender, photo_id, signature_id, subject_id, category, form_no, p_district, p_state, sub1, sub2, sub3, e_mail1, e_mail2, student_info.status, roll_no, marks, counselling_date, cat_rank, income_certificate, annual_income, other_univ, student_info.user_id  as stu_user, icard, univ_roll, cancel_date, remarks, fee_invoice3.sno as fees_serial, student_info.sno as student_serial, timestamp, fee_invoice3.user_id as user_id from fee_invoice3 join student_info on fee_invoice3.student_id = student_info.sno where amount_paid is not null and type='fees' and student_info.sno not in (select student_id from student_info2) $timestamp $class and fee_invoice3.class_id=student_info.class)";
		//echo $sql.' - '.date("d-m-Y", $start).' - '.date("d-m-Y", $sub_end).'<br>';
		$result = execute_query(connect(), $sql);
		//echo "Time : ".(microtime(true)-$start_time);//."<br>".$sql."<br>";
		$count = mysqli_num_rows($result);
		$tot_stu_count += $count;
		echo '<tr>
		<td>'.$i++.'</td>
		<td>'.date("d-m-Y",$start).'</td>
		<td>'.$count.'</td>';
		while($row = mysqli_fetch_array($result)){
			$final_res = fees_bifurcation_second($row);
			$tot[50] += $final_res[1][50];
			$tot[22] += $final_res[1][22];
			$tot[52] += $final_res[1][52];
			$tot[30] += $final_res[1][30];
			$tot[31] += $final_res[1][31];
			$tot[32] += $final_res[1][32];
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
		$grand_tot[32] += $tot[32];
		$start = $sub_end;
		//echo '<tr><th colspan="2">GRAND TOTAL :</th>';
		$sql = 'select * from head_type';
		$re = execute_query(connect(), $sql);
		ob_start();
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
		echo '<td>'.$tot[31].'</td>';
		echo '<td>'.$tot[32].'</td>';
		if($tot[31]!=$tot[32]){
			echo '<td>ERROR</td>';
		}
		ob_flush();
		flush();
	}
	echo '<tr><td colspan="2">GRAND TOTAL :</td>
	<td>'.$tot_stu_count.'
	<input type="hidden" name="total_student" value="'.$tot_stu_count.'"></td>';
		$sql = 'select * from head_type';
		$re = execute_query(connect(), $sql);
		while($a = mysqli_fetch_array($re)){
			echo '<td>'.$grand_tot[$a['sno']].'<input type="hidden" name="fees_total_'.$a['sno'].'" value="'.$grand_tot[$a['sno']].'"></td>';
			if($a['sno']==3){
				echo '<td>'.$grand_tot[50].'</td>';
			}
			if($a['sno']==21){
				echo '<td>'.$grand_tot[22].'</td>';
			}
		}
		echo '<td>'.$grand_tot[52].'</td>';
		echo '<td>'.$grand_tot[30].'</td>';
		echo '<td>'.$grand_tot[31].'</td>';
		echo '<td>'.$grand_tot[32].'</td>';
		//echo '<td>'.$grand_tot[$a].'<input type="hidden" name="fees_total_'.$a.'" value="'.$grand_tot[$a].'"></td>';
		$date= date("Y-m", strtotime($_POST['dfc_date']));
		echo '
		</table>
		<input type="hidden" name="dfc_date" value="'.$date.'" id="dfc_date" >
		</form>';
		//echo '<input type="Submit" name="submit" value="Generate Fees Transfer" class="submit">
		//<input type="button" name="print_sheet" value="Print Fees Transfer Chart" onClick="print_chart()" class="submit">';
		$end_time = microtime(true);
		echo "Time Taken : ".($end_time-$start_time);
}
?>