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
function fees_report() {
	window.open("fees_report_print.php");
}
</script>
<body id="public">
	<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">    	
				<form action="fees_bifurcation_new.php" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" >
					<h2>Fees <span class="orange">Bifurcation (Aided Subjects)</span></h2>
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
						<input type="submit" class="submit btn btn-primary" name="save" value="Submit" style="margin-top:0px; margin-left:0px;"/>
						<input type="button" name="student_ledger" class="btn btn-danger" onClick="return fees_report()" style="float: right;" value="Print">					
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
					<td rowspan="3">TOTAL(Total1+Total2)</td>
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
					 <?php
					 $tot[0] = 0;
					 for($td=1; $td<=40; $td++){
						$tot[]=0;
						if($td==11){
							echo '<td>11<br>(8+9+10)</td>';
						}
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
				$sql = "select *, fee_invoice.sno as fees_serial, student_info.sno as student_serial from fee_invoice join student_info on fee_invoice.student_id = student_info.sno where amount_paid is not null and type="."'fees'";
				if(isset($_POST['user_id'])){
					if($_POST['user_id']!=''){
						$sql .= ' and fee_invoice.user_id="'.$_POST['user_id'].'"';
					}
				}
				if(isset($_POST['s_class'])){
					if($_POST['s_class']!=''){
					$sql .= ' and student_info.class="'.$_POST['s_class'].'"';
					}
				}
				if(isset($_POST['dfc_date'])){
					$start = strtotime($_POST['dfc_date']);
					$end = $start+86400;	
					$sql .= " and fee_invoice.timestamp>=".$start." and fee_invoice.timestamp<".$end;
				}
				else{
					$start = strtotime(date("Y-m-d"));
					$end = $start+86400;	
					$sql .= " and timestamp>=".$start." and timestamp<".$end;
				}
				$_SESSION['sql3']="$sql";
				if(isset($_POST['user_id'])){
					$result = execute_query(connect(), $sql);
					$i=1;
					$start_time = microtime(true);
					while($row = mysqli_fetch_array($result)){
						$final_res = fees_bifucation($row);
						$sql = 'select * from head_type';
						$re = execute_query(connect(), $sql);
						echo '<tr>
						<td>'.$i++.'</td>'.$final_res[0].'</tr>';
						while($a = mysqli_fetch_array($re)){
							$tot[$a['sno']] += $final_res[1][$a['sno']];
						}
						$tot[50] += $final_res[1][50];
						$tot[22] += $final_res[1][22];
						$tot[52] += $final_res[1][52];
						$tot[30] += $final_res[1][30];
						$tot[31] += $final_res[1][31];
					}
				}
				echo '<tr><td colspan="7">GRAND TOTAL :</td>';
				$sql = 'select * from head_type';
				$re = execute_query(connect(), $sql);
				while($a = mysqli_fetch_array($re)){
					echo '<td>'.$tot[$a['sno']].'</td>';
					if($a['sno']==3)
					{
						echo '<td>'.$tot[50].'</td>';}
					if($a['sno']==21)
					{
						echo '<td>'.$tot[22].'</td>'; }
				}

					echo '<td>'.$tot[52].'</td>';
					echo '<td>'.$tot[30].'</td>';
					echo '<td>'.$tot[31].'</td>';
				$end_time = microtime(true);
				//echo "Time Taken : ".($end_time-$start_time);
				?>
			</table>
		</div>
    </div>
	<?php 
	page_footer_start(); 
	page_footer_end(); 

	?>
</body>