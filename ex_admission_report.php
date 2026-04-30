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
	function class_report() {
		window.open("ex_admission_report_print.php");
	}
	</script>
<body id="public">
	<div class="card">
		<div class="card-body ">
			<div class="row d-flex my-auto">
				<div class="col-md-12">
					<h2>Fees <span class="orange">Ex/Back/Private (Day Wise)</span></h2>
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" >
						<div class="row">							
							<div class="col-md-3">							
								<label class="desc" for="name">Select Date From</label>
								
								<script  type="text/javascript" language="javascript">
									document.writeln(DateInput('dfc_date', 'dfc_date', true, 'YYYY-MM-DD', '<?php if(isset($_POST['dfc_date'])){echo $_POST['dfc_date'];}else{echo date("Y-m-d"); } ?>', 2));
								</script>
							</div>
							<div class="col-md-3">							
								<label class="desc" for="name">Date To</label>							
								
								<script  type="text/javascript" language="javascript">
									document.writeln(DateInput('dfc_date_to', 'dfc_date_to', true, 'YYYY-MM-DD', '<?php if(isset($_POST['dfc_date_to'])){echo $_POST['dfc_date_to'];}else{echo date("Y-m-d"); } ?>', 2));
								</script>
							</div>
							<div class="col-md-3">							
								<label class="desc" for="name">Enter Bank User Id</label>
								<input type="text" name="user_id" id="user_id" class="form-control">
							</div>
							<div class="col-md-3">							
								<label class="desc" for="name">Fees Type</label>
								<select class="form-control" name="type" id="type">
									<option value="all"></option>
									<option value="BACK" <?php if(isset($_POST['type'])){if($_POST['type']=='BACK'){echo ' selected';}}?>>Back Paper</option> 
									<option value="EX" <?php if(isset($_POST['type'])){if($_POST['type']=='EX'){echo ' selected';}}?>>Ex Student</option>
									<option value="PRIVATE" <?php if(isset($_POST['type'])){if($_POST['type']=='PRIVATE'){echo ' selected';}}?>>Private Student</option>
								 </select>
							</div>
						</div>					
						<input type="submit" class="btn btn-success" name="save" value="Submit" />						
						<input type="button" name="student_ledger" onClick="return class_report()" style="float: right;" value="Print" class="btn btn-primary">		
						
					</form>
				</div>
			</div>
		</div>
	</div>
			
	<div class="col-md-12">
		<div class="card">
			<table width="100%" class="table table-striped table-hover rounded">
				<tr class="table-primary">
					<th>S.No.</th>
					<th>CLASS</th>
					<th>DATE</th>
					<th>STUDENT COUNT</th>
					<th>FEES</th>
				</tr>

				<?php 
				$tot_stu_count=0;
				$i=1;
				$sql='select * from class_detail order by sort_no, class_description';
				$res=execute_query(connect(), $sql);
				$grand_fees=0;
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
					//echo $sql.'<br>';
					//$_SESSION['class_type']=$_POST['class_type'];
					$_SESSION['comp_date']=$_POST['dfc_date'];
					$_SESSION['comp_date1']=$_POST['dfc_date_to'];
					$_SESSION['type1']=$_POST['type'];
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
				echo '<tr><td colspan="3">GRAND TOTAL</td><td>'.$tot_stu_count.'</td><td>'.$grand_fees.'</td></tr>
			</table>';
			?>
		</div>
	</div>
	<?php 

	function editable($field){
		if($field!=''){
			echo 'readonly= "readonly"';
		}
	}
	?>
	<?php
	page_footer_start();
	page_footer_end();
	?>
</body>