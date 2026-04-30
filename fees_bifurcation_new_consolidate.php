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
if(isset($_POST['total_student'])){
	$sql = 'select * from fees_transfer where month="'.$_POST['dfc_date'].'" and type="aided"';
	$res = execute_query(connect(), $sql);
	if(mysqli_num_rows($res)==0){
		$sql = 'insert into fees_transfer (head_id, amount, timestamp, type, month) values ';
		$comma=0;
		foreach($_POST as $k => $v){
			if($comma==0){
				$sql .= '("'.$k.'", "'.$v.'", "'.time().'", "aided", "'.$_POST['dfc_date'].'")';
				$comma=1;
			}
			else{
				$sql .= ', ("'.$k.'", "'.$v.'", "'.time().'", "aided", "'.$_POST['dfc_date'].'")';
			}
		}
		//echo $sql;
		execute_query(connect(), $sql);
	}
	else{
		$msg .= '<h2>Transfer Already Generated.</h2>';
	}
	
}
page_header_end();
page_sidebar();
?>
<script type="text/javascript" language="javascript">
function consolidate_report() {
	window.open("fees_consolidate_print.php");
}
</script>
<script language="javascript" type="text/javascript">
function print_chart(){
	var dfc_date = document.getElementById('dfc_date').value;
	window.open("fees_bifurcation_new_transfer_sheet.php?type=aided&dfc_date="+dfc_date);
}
</script>
<body id="public">
	<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">    	
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" >
					<h2>Fees <span class="orange">Bifurcation (Consolidate)</span></h2>
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
									$_SESSION['class_first']=$_POST['s_class'];
									?>
								 </select>
							</div>
						</div>
						
						
					</div> 
					<input type="submit" class="submit btn btn-primary" name="save" value="Submit" />
					<input type="button" name="student_ledger" class="btn btn-danger" onClick="return consolidate_report()" style="float: right;" value="Print">					
				</form>
			</div>
		</div> 
		
		<?php
		$start_time = microtime(true);

		$sql= "select * from head_type";
		$result_head = execute_query(connect(), $sql);
		$count = mysqli_num_rows($result_head);
		?>
		<div class="card card-body">
			<table width="100%" class="table table-striped table-hover rounded">
				<tr class="table-primary ">
					<td rowspan="3">S.No.</td>
					<td rowspan="3">DATE/TIME</td>
					<td rowspan="3">STUDENT COUNT</td>
					<td colspan="<?php echo $count-2; ?>">FEES HEADS</td>
					<td colspan="4">&nbsp;</td>
					<td rowspan="3">TOTAL2</td>
					<td rowspan="3">TOTAL</td>
					<td rowspan="3">TOTAL DEPOSITED</td>
				</tr>
				<tr class="table-primary">
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
				</tr>
				<tr>
					<?php
					 $grand_tot[]=0;
					for($td=1; $td<=36; $td++){
						$grand_tot[]=0;
						$tot[]=0;
						if($td==7){
							echo '<td>7<br>(4+5+6)</td>';
						}
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
					$_SESSION['start1']=$start;
					$_SESSION['end1']=$end;
					$_SESSION['fees_date']=$_POST['dfc_date'];
					echo '<input type="hidden" value="'.date("Y-m-01",$start).'" name="month">';
					$i=1;
					while($start<$end){
						unset($tot);
						$tot[0]=0;
						for($td=1; $td<=35; $td++){
							$tot[]=0;
						}
						$tot[50]=0;
						$tot[52]=0;
						$sub_end = strtotime(date("Y-m-d",$start)."+1 day");
						$sql = "select *, fee_invoice.sno as fees_serial, student_info.sno as student_serial from fee_invoice join student_info on fee_invoice.student_id = student_info.sno where amount_paid is not null and type="."'fees'";
						if(isset($_POST['s_class'])){
							if($_POST['s_class']!=''){
								$sql .= ' and student_info.class="'.$_POST['s_class'].'"';
							}
							$_SESSION['class']=$_POST['s_class'];
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
						echo '<td>'.$tot[31].'</td>';
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
						//echo '<td>'.$grand_tot[$a].'<input type="hidden" name="fees_total_'.$a.'" value="'.$grand_tot[$a].'"></td>';
						$date= date("Y-m", strtotime($_POST['dfc_date']));
						echo '
						</table>
						<input type="hidden" name="dfc_date" value="'.$date.'" id="dfc_date" >
						</form>';
						//echo '<input type="Submit" name="submit" value="Generate Fees Transfer" class="submit">
						//<input type="button" name="print_sheet" value="Print Fees Transfer Chart" onClick="print_chart()" class="submit">';
						$end_time = microtime(true);
						//echo "Time Taken : ".($end_time-$start_time);
					}
					?>
		</div>
	</div>
	<?php 
	page_footer_start(); 
	page_footer_end(); 

	?>
</body>