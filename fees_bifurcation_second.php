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
function fees_report_second() {
	window.open("fees_bifurcation_second_print.php");
}
</script>
<body id="public">
	<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">    	
				<form action="fees_bifurcation_second.php" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" >
					<h2>Fees <span class="orange">Bifurcation (Second Instalment)</span></h2>
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
								<label>Select class <span class="alert">*</span></label>
								<select name="s_class" class="form-control" id="s_class" >
									<option value="">ALL</option>
										<?php
										$sql = 'select * from class_detail order by sort_no, class_description';
										$res = execute_query(connect(), $sql);
										while($row = mysqli_fetch_array($res)) {
											echo '<option value="'.$row['sno'].'" ';
											if(isset($_POST['s_class'])){
												if($_POST['s_class']==$row['sno']){
													echo " selected";
												}
											}
											echo '>'.$row['class_description'].'</option> ';
										}
										?>
									</select>
							</div>
						</div>						
					</div> 
					<input type="submit" class="submit btn btn-primary" name="save" value="Submit" />
					<input type="button" name="student_ledger" class="btn btn-danger" onClick="return fees_report_second()" style="float: right;" value="Print">					
				</form>
			</div>
		</div> 

		<?php
		$sql= "select * from head_type";
		$result_head = execute_query(connect(), $sql);
		$count = mysqli_num_rows($result_head);              
		?>
		<div class="card card-body">
			<table width="100%" class="table table-striped table-hover rounded">
				<tr class="table-primary ">
					<td rowspan="3">S.No.</td>
					<td rowspan="3">STUDENT NAME</td>
					<td rowspan="3">CLASS</td>
					<td rowspan="3">ROLL NO</td>
					<td rowspan="3">CATEGORY</td>
					<td rowspan="3">GENDER</td>
					<td rowspan="3">DATE/TIME</td>
					<td colspan="<?php echo $count-2; ?>">FEES HEADS</td>
					<td colspan="4">&nbsp;</td>
					<td rowspan="3">TOTAL2(12 to 37)
					<td rowspan="3">EXCESS</td>
					<td rowspan="3">TOTAL(Total1+Total2+Excess)</td>
					<td rowspan="3">TOTAL DEPOSITED</td>
				</tr>
				<tr class="table-primary">
					<td colspan="4">MAINTENANCE</td>
					<td colspan="14">&nbsp;</td>
					<td colspan="12">UNIVERSITY FEES ACCOUNT</td>
				<!--    <td colspan="5"></td>
					<td colspan="12">PRACTICAL FEES ACCOUNT</td> -->
				</tr>
				<tr style="background:#CCC; color:#FFF; text-align:center; font-size:13px;">
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
						<td>TOTAL PRACTICAL FEES (36 to 50)</td> -->
				</tr>
				<tr>
					<?php
					$tot[0]=0;
					for($td=1; $td<=41; $td++){
						$tot[]=0;
						if($td==11){
							echo '<td>11<br>(8+9+10)</td>';
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
					$tot[50]=0;
					$tot[52]=0;
					?>
				</tr>
					<?php
					$test='';
					$fee_type='';
					$class='';
					if(isset($_POST['dfc_date'])){
						$start = strtotime($_POST['dfc_date']);
						$end = $start+86400;	
						$timestamp = " and timestamp>=".$start." and timestamp<".$end;
					}
					else{
						$start = strtotime(date("Y-m-d"));
						$end = $start+86400;	
						$timestamp= " and timestamp>=".$start." and timestamp<".$end;
					}

					if(isset($_POST['s_class'])){
						if($_POST['s_class']!=''){
						$class= ' and class="'.$_POST['s_class'].'"';
						}
						if($_POST['s_class']>=60 && $_POST['s_class']<=81){
							$fee_type=' and student_info2.type="admission"';}
					}
					$sql = "(select student_info2.sno as sno, stu_name, father_name, mother_name, class, reservation, waightage, minority, dob, acc_no, bank_name, branch_name, temp_address, perm_address, pin, mobile, p_mobile, p_pin, date_of_admission, gender, photo_id, signature_id, subject_id, category, form_no, p_district, p_state, sub1, sub2, sub3, e_mail1, e_mail2, student_info2.status, roll_no, marks, counselling_date, cat_rank, income_certificate, annual_income, other_univ, student_info2.user_id as stu_user, icard, univ_roll, cancel_date, remarks, fee_invoice3.sno as fees_serial, student_info2.student_id as student_serial, timestamp, fee_invoice3.user_id as user_id from fee_invoice3 join student_info2 on fee_invoice3.student_id = student_info2.student_id where amount_paid is not null and fee_invoice3.type='fees' $timestamp $class $fee_type and fee_invoice3.class_id=student_info2.class)
					union all (select student_info.sno as sno, stu_name, father_name, mother_name, class, reservation, waightage, minority, dob, acc_no, bank_name, branch_name, temp_address, perm_address, pin, mobile, p_mobile, p_pin, date_of_admission, gender, photo_id, signature_id, subject_id, category, form_no, p_district, p_state, sub1, sub2, sub3, e_mail1, e_mail2, student_info.status, roll_no, marks, counselling_date, cat_rank, income_certificate, annual_income, other_univ, student_info.user_id  as stu_user, icard, univ_roll, cancel_date, remarks, fee_invoice3.sno as fees_serial, student_info.sno as student_serial, timestamp, fee_invoice3.user_id as user_id from fee_invoice3 join student_info on fee_invoice3.student_id = student_info.sno where amount_paid is not null and type='fees' and student_info.sno not in (select student_id from student_info2) $timestamp $class  and fee_invoice3.class_id=student_info.class)";
					//echo $sql;
					$_SESSION['second_print']="$sql";
					if(isset($_POST['user_id'])){
							$result = execute_query(connect(), $sql);
							$i=1;
							$start_time = microtime(true);
							while($row = mysqli_fetch_array($result)){
								$final_res = fees_bifurcation_second($row);
								$sql = 'select * from head_type';
								$re = execute_query(connect(), $sql);
								if($i%2==0){
										$col = '#CCC';
									}
									else{
										$col = '#EEE';
									}
								echo '<tr style="background:'.$col.'">
								<td>'.$i++.'</td>'.$final_res[0].'</tr>';
								while($a = mysqli_fetch_array($re)){
									$tot[$a['sno']] += $final_res[1][$a['sno']];
								}
								$tot[50] += $final_res[1][50];
								$tot[22] += $final_res[1][22];
								$tot[52] += $final_res[1][52];
								$tot[30] += $final_res[1][30];
								$tot[31] += $final_res[1][31];
								$tot[32] += $final_res[1][32];
							}
					}
					echo '<tr><td colspan="7">GRAND TOTAL :</td>';
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
					//echo '<td>-</td>';
					//for($a=41;$a<=51;$a++){
						//echo $tot[$a].'<br>';
						echo '<td>'.$tot[52].'</td>';
						echo '<td>'.$tot[30].'</td>';
						echo '<td>'.$tot[31].'</td>';
						echo '<td>'.$tot[32].'</td>';
					//}
					$end_time = microtime(true);
					//echo "Time Taken : ".($end_time-$start_time);
					?>
				</tr>
			</table>
		</div>
	</div>

	<?php 
	page_footer_start(); 
	page_footer_end(); 

	?>
</body>