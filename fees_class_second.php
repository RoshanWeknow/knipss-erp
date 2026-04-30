<?php
//set_time_limit(0);
//session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_start();
$response=1;
$msg='';
$i=0;

page_header_end();
page_sidebar();
?>
<script type="text/javascript" language="javascript">
function class_report_second() {
	window.open("fees_class_second_print.php");
}
</script>
<body id="public">
	<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">    	
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" >
					<h2>Fees <span class="orange">Bifurcation (Class Wise) Second Installment</span></h2>
					<div class="col-md-12">
						<div class="row">							
							<div class="col-md-4">							
								<label>Enter Bank User Id<span class="name">*</span></label>
								<input type="text" name="user_id" class="form-control" id="user_id" >
							</div>
							<div class="col-md-4">							
								<label>Select Date<span class="name">*</span></label>
								<script  type="text/javascript" language="javascript">
									document.writeln(DateInput('dfc_date', 'dfc_date', true, 'YYYY-MM-DD', '<?php if(isset($_POST['dfc_date'])){echo $_POST['dfc_date'];}else{echo date("Y-m-d"); } ?>', 2));
								</script>
							</div>
							<div class="col-md-4">							
								<label>Type <span class="alert">*</span></label>
								<select class="form-control" name="type" id="type">
									<option value="all">ALL</option>
									<option value="self">SELF FINANCE</option>
									<option value="aided">AIDED</option>
									<option value="ballb">BA.LLB.</option>
								 </select>
							</div>
						</div>
						
						
					</div> 
						<input type="submit" class="submit btn btn-primary" name="save" value="Submit" style="margin-top:0px; margin-left:0px;"/>
						<input type="button" name="student_ledger" class="btn btn-danger" onClick="return class_report_second()" style="float: right;" value="Print">					
				 </form>
			</div>
		</div> 


    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" >
<?php
$sql= "select * from head_type";
$result_head = execute_query(connect(), $sql);
$count = mysqli_num_rows($result_head);
?>
		<div class="card card-body">
			<table width="100%" class="table table-striped table-hover rounded">
				<tr class="table-primary ">
					<td rowspan="3">S.No.</td>
					<td rowspan="3">CLASS</td>
					<td rowspan="3">DATE</td>
					<td rowspan="3">STUDENT COUNT</td>
					<td colspan="<?php echo $count-2; ?>">FEES HEADS</td>
					<td colspan="4">&nbsp;</td>
					<td rowspan="3">TOTAL2</td>
					<td rowspan="3">EXCESS</td>
					<td rowspan="3">TOTAL(Total1+Total2+Excess)</td>
					<td rowspan="3">TOTAL DEPOSITED</td>
				</tr>
				<tr class="table-primary ">
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
				for($td=1; $td<=38; $td++){
					$tot[]=0;
					$grand_tot[]=0;
					if($td==8){
						echo '<td>8<br>(5+6+7)</td>';
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
			$start_time = microtime(true);
			$tot_stu_count=0;

			$i=1;
			$sql='select * from class_detail order by sort_no, class_description';
			$res=execute_query(connect(), $sql);
			while($class=mysqli_fetch_array($res)){
				unset($tot);
				$tot[0]=0;
				for($td=1; $td<=36; $td++){
					$tot[]=0;
				}
				$tot[50]=0;
				$tot[52]=0;
				$self = '';
				$type = '';
				$ballb = '';
				$fee_type='';
				if(isset($_POST['dfc_date'])){
					$start = strtotime($_POST['dfc_date']);
					$end = $start+86400;	
					$timestamp = " and timestamp>=".$start." and timestamp<".$end;
				}
				else{
					$start = strtotime(date("Y-m-d"));
					$end = $start+86400;	
					$timestamp = " and timestamp>=".$start." and timestamp<".$end;
				}
				if(isset($_POST['type'])){
					if($_POST['type']=='self'){
						$self = ' and class_detail.type="SELF" and class_detail.sno not in(66,67,68,69,70,71,72,73,74,75)';
					}
					if($_POST['type']=='aided'){
						$type =' and class_detail.type!="SELF"';
					}
					if($_POST['type']=='ballb'){
						$ballb =' and class_detail.sno>=66 and class_detail.sno<=75';
					}
					
					$_SESSION['class_type3']=$_POST['type'];
				}
					if($class['sno']>=60 && $class['sno']<=81){
						$fee_type=' and student_info2.type="admission"';
					}
					
				$_SESSION['class_date3']=$_POST['dfc_date'];
				$sql = "(select student_info2.sno as sno, stu_name, class, minority,  date_of_admission, gender, subject_id, student_info2.category, form_no, sub1, sub2, sub3, student_info2.status, roll_no, counselling_date, annual_income, other_univ, student_info2.user_id as stu_user, cancel_date, class_detail.type as type, class_detail.sno as class_serial, fee_invoice3.sno as fees_serial, student_info2.student_id as student_serial, timestamp, fee_invoice3.user_id as user_id from fee_invoice3 join student_info2 on fee_invoice3.student_id = student_info2.student_id join class_detail on student_info2.class = class_detail.sno where amount_paid is not null and fee_invoice3.type='fees' and class_detail.sno=".$class['sno']." $timestamp $self $type $ballb $fee_type and fee_invoice3.class_id=student_info2.class)
				union all (select student_info.sno as sno, stu_name, class, minority, date_of_admission, gender, subject_id, student_info.category, form_no, sub1, sub2, sub3, student_info.status, roll_no, counselling_date, annual_income, other_univ, student_info.user_id  as stu_user, cancel_date, class_detail.type as type, class_detail.sno as class_serial, fee_invoice3.sno as fees_serial, student_info.sno as student_serial, timestamp, fee_invoice3.user_id as user_id from fee_invoice3 join student_info on fee_invoice3.student_id = student_info.sno join class_detail on student_info.class = class_detail.sno where amount_paid is not null and fee_invoice3.type='fees' and class_detail.sno=".$class['sno']." and student_info.sno not in (select student_id from student_info2) $timestamp $self $type $ballb and fee_invoice3.class_id=student_info.class)";
				if(isset($_POST['user_id'])){
					$result = execute_query(connect(), $sql);
					//echo "Time Taken : ".(microtime(true)-$start_time).'<br>'.$sql.'<br>';
					$count = mysqli_num_rows($result);
					$tot_stu_count += $count;
					if($count!=0){
					echo '<tr>
					<td>'.$i++.'</td>
					<td>'.$class['class_description'].'</td>
					<td>'.date("d-m-Y", strtotime($_POST['dfc_date'])).'</td>
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
				//$start = $sub_end;
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
				echo '<td>'.$tot[31].'</td>';
				echo '<td>'.$tot[32].'</td>';
				if($tot[31]!=$tot[32]){
					echo '<td>ERROR</td>';
				}
					}
			}
			}
			echo '<tr><td colspan="3">GRAND TOTAL :</td>
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
				$end_time = microtime(true);
				echo "Time Taken : ".($end_time-$start_time);
				//echo '<td>'.$grand_tot[$a].'<input type="hidden" name="fees_total_'.$a.'" value="'.$grand_tot[$a].'"></td>';
				$date= date("Y-m", strtotime($_POST['dfc_date']));
				echo '
				</table></div>
				<input type="hidden" name="dfc_date" value="'.$date.'" id="dfc_date" >
				</form>';
				//echo '<input type="Submit" name="submit" value="Generate Fees Transfer" class="submit">
				//<input type="button" name="print_sheet" value="Print Fees Transfer Chart" onClick="print_chart()" class="submit">';
			?></div>
<?php 
page_footer_start(); 
page_footer_end(); 
function editable($field){
	if($field!=''){
		echo 'readonly= "readonly"';
	}
}
?>