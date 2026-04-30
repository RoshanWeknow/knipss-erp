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
if(!isset($_POST['from_date'])){
	$_SESSION['re_from_date'] = date('Y-m-d');
	$_SESSION['re_to_date'] = date('Y-m-d');
}
else {
	$_SESSION['re_from_date'] = $_POST['from_date'];
	$_SESSION['re_to_date'] = $_POST['to_date'];
	$_SESSION['re_class_type'] = $_POST['class_type'];
}
page_header_end();
page_sidebar();
?>
<script type="text/javascript" language="javascript">
function class_report() {
	window.open("fee_receipt_generation_second_installment_print.php");
}
</script>
<body id="public">
	<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">    	
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" >
					<h2>Fees <span class="orange">Fee Receipt Generation(Second Installment)</span></h2>
					<div class="col-md-12">
						<div class="row">							
							<div class="col-md-4">							
								<label>From Date<span class="name">*</span></label>
								<script  type="text/javascript" language="javascript">
									document.writeln(DateInput('from_date', 'from_date', true, 'YYYY-MM-DD', '<?php if(isset($_POST['from_date'])){echo $_POST['from_date'];}else{echo date("Y-m-d"); } ?>', 2));
								</script>
							</div>
							<div class="col-md-4">							
								<label>To Date<span class="name">*</span></label>
								<script  type="text/javascript" language="javascript">
									document.writeln(DateInput('to_date', 'to_date', true, 'YYYY-MM-DD', '<?php if(isset($_POST['to_date'])){echo $_POST['to_date'];}else{echo date("Y-m-d"); } ?>', 2));
								</script>
							</div>
							<div class="col-md-4">							
								<label>Enter Start Recipt Number<span class="name">*</span></label>
								<input type="text" name="start_receipt_number" class="form-control" id="start_receipt_number"  value="<?php if(isset($_POST['start_receipt_number'])){echo $_POST['start_receipt_number'];} ?>"
							</div>
						</div>
						<div class="row">							
							<div class="col-md-4">							
								<label>Type<span class="alert">*</span></label>
								<select class="form-control" name="class_type" id="class_type" class="form-control">
									<option value="SELF">SELF FINANCE</option>
									<option value="AIDED">AIDED</option>
									<option value="ballb">BALLB</option>
								</select>
							</div>
							
						</div>
						
					</div> 
						<input type="submit" class="submit btn btn-success" name="show" value="Show" />
					   <input type="submit" class="submit btn btn-primary" name="generate" value="Genarate" />
					   <input type="button" name="student_ledger" class="btn btn-danger" onClick="return class_report()" style="float: right;" value="Print">					
				</form>
			</div>
		</div>
    
		<div class="card card-body">
			<table width="100%" class="table table-striped table-hover rounded">
				<tr class="table-primary ">
					<td>S.No.</td>
					<td>Receipt Number</td>
					<td>Date</td>
					<td>Name Of Student</td>
					<td>Father's Name</td>
					<td>Class/Course Name/Year</td>
					<td>Session(Old)</td>
					<td>Session(Current)</td>
					<td>Gender</td>
					<td>Category</td>
					<td>Fee Amount</td>
					<td>Mode Of Receipt</td>
				</tr>
				<?php 
				$tot_stu_count=0;
				$grand_fees=0;
				$receipt_number=0;
				$n=1;
				if(isset($_POST['generate'])){
					if($_POST['start_receipt_number'] != ''){
						$sql_fee_type = 'SELECT * FROM `fee_invoice3` group by `type`';
						$result_fee_type = execute_query(connect(), $sql_fee_type);
						while($row_fee_type = mysqli_fetch_array($result_fee_type)){
							$receipt_number = $_POST['start_receipt_number'];
							switch($_POST['class_type']){
								case 'ballb': {
									$sql = 'select fee_invoice3.sno from fee_invoice3 left join class_detail on class_detail.sno = fee_invoice3.class_id where  `approval_date` >= "'.$_POST['from_date'].'" AND `approval_date` <= "'.$_POST['to_date'].'" AND `fee_invoice3`.`type`="'.$row_fee_type['type'].'" and class_detail.sort_no="BA_LLB" order by fee_invoice3.sno';
									
									break;
								}
								case 'AIDED' : {
									$sql = 'select fee_invoice3.sno from fee_invoice3 left join class_detail on class_detail.sno = fee_invoice3.class_id where  `approval_date` >= "'.$_POST['from_date'].'" AND `approval_date` <= "'.$_POST['to_date'].'" AND `fee_invoice3`.`type`="'.$row_fee_type['type'].'" and class_detail.type!="SELF" and class_detail.sort_no!="BA_LLB" order by fee_invoice3.sno';
									break;
								}
								case 'SELF' : {
									$sql = 'select fee_invoice3.sno from fee_invoice3 left join class_detail on class_detail.sno = fee_invoice3.class_id where  `approval_date` >= "'.$_POST['from_date'].'" AND `approval_date` <= "'.$_POST['to_date'].'" AND `fee_invoice3`.`type`="'.$row_fee_type['type'].'" and class_detail.type="SELF" and class_detail.sort_no!="BA_LLB" order by fee_invoice3.sno';
									break;
								}
							}
							
							$result_data = execute_query(connect(), $sql);
							while($row_data = mysqli_fetch_assoc($result_data)){
									$sql_update = 'UPDATE `fee_invoice3` SET `receipt_number`="'.$receipt_number.'" WHERE `sno`="'.$row_data['sno'].'"';
									$res_update = execute_query(connect(), $sql_update);
									$receipt_number++;
							}
							//echo $sql.'</br>';

						}

						/*
						$sql_fee_type = 'SELECT * FROM `fee_invoice3` group by `type`';
						$result_fee_type = execute_query(connect(), $sql_fee_type);
						while($row_fee_type = mysqli_fetch_array($result_fee_type)){
							$receipt_number = $_POST['start_receipt_number'];
							$sql = 'SELECT * FROM `fee_invoice3` WHERE `approval_date` >= "'.$_POST['from_date'].'" AND `approval_date` <= "'.$_POST['to_date'].'" AND `type`="'.$row_fee_type['type'].'"';
							$res=execute_query(connect(), $sql);
							while($row=mysqli_fetch_array($res)){
								$sql_class_type = 'SELECT * FROM `class_detail` WHERE `sno`="'.$row['class_id'].'"';
								$result_self = execute_query(connect(), $sql_class_type);
								$row_self = mysqli_fetch_array($result_self);
								if($_POST['class_type'] == 'self' and $row_self['type'] == 'SELF' and $row_self['sort_no'] != 'BA_LLB'){
									$sql_update = 'UPDATE `fee_invoice3` SET `receipt_number`="'.$receipt_number.'" WHERE `sno`="'.$row['sno'].'"';
									$res_update = execute_query(connect(), $sql_update);
									$receipt_number++;
								}
								if($_POST['class_type'] == 'aided' and $row_self['type'] != 'SELF' and $row_self['sort_no'] != 'BA_LLB'){
									$sql_update = 'UPDATE `fee_invoice3` SET `receipt_number`="'.$receipt_number.'" WHERE `sno`="'.$row['sno'].'"';
									$res_update = execute_query(connect(), $sql_update);
									$receipt_number++;
									
								}
								if($_POST['class_type'] == 'ballb' and $row_self['sort_no'] == 'BA_LLB'){
									$sql_update = 'UPDATE `fee_invoice3` SET `receipt_number`="'.$receipt_number.'" WHERE `sno`="'.$row['sno'].'"';
									$res_update = execute_query(connect(), $sql_update);
									$receipt_number++;

								}
							}
						}*/
					}

						switch($_POST['class_type']){
							case 'ballb': {
								$sql = 'select fee_invoice3.sno from fee_invoice3 left join class_detail on class_detail.sno = fee_invoice3.class_id where  `approval_date` >= "'.$_POST['from_date'].'" AND `approval_date` <= "'.$_POST['to_date'].'" and class_detail.sort_no="BA_LLB" order by fee_invoice3.sno';
								
								break;
							}
							case 'AIDED' : {
								$sql = 'select fee_invoice3.sno from fee_invoice3 left join class_detail on class_detail.sno = fee_invoice3.class_id where  `approval_date` >= "'.$_POST['from_date'].'" AND `approval_date` <= "'.$_POST['to_date'].'" and class_detail.type!="SELF" and class_detail.sort_no!="BA_LLB" order by fee_invoice3.sno';
								break;
							}
							case 'SELF' : {
								$sql = 'select fee_invoice3.sno from fee_invoice3 left join class_detail on class_detail.sno = fee_invoice3.class_id where  `approval_date` >= "'.$_POST['from_date'].'" AND `approval_date` <= "'.$_POST['to_date'].'" AND class_detail.type="SELF" and class_detail.sort_no!="BA_LLB" order by fee_invoice3.sno';
								break;
							}
						}
						//echo $sql.'</br>' ;
						$result_data = execute_query(connect(), $sql);
						while($row_data = mysqli_fetch_assoc($result_data)){
							$sql = 'select * from `fee_invoice3` where `sno`="'.$row_data['sno'].'"';
							$row = mysqli_fetch_assoc(execute_query(connect(), $sql));
						$sql_student = 'select * from student_info where sno="'.$row['student_id'].'"';
						$student = mysqli_fetch_array(execute_query(connect(), $sql_student));
						$sql_class = 'select * from class_detail where sno="'.$row['class_id'].'"';
						$class = mysqli_fetch_array(execute_query(connect(), $sql_class));

							echo '<tr><td>'.$n++.'</td><td>';
							if($_POST['class_type']=="ballb"){
								echo 'knss';
							}
							else{
								echo 'knipss';
							}
							echo '/'.$_POST['class_type'].'/2019/'.$row['receipt_number'].'</td><td>'.$row['approval_date'].'</td><td>'.$student['stu_name'].'</td><td>'.$student['father_name'].'</td><td>'.$class['class_description'].'</td><td></td><td></td><td>'.$student['gender'].'</td><td>'.$student['category'].'</td><td>'.$row['amount_paid'].'</td><td>'.$row['type'].'</td></tr>';
							$grand_fees += $row['amount_paid'];

					}
					echo '<tr><td colspan="10" style="text-align:right;">GRAND TOTAL</td><td>'.$grand_fees.'</td><td></td></tr></table>';
				}
				?>
		</div>
	</div>
	<?php 
	page_footer_start(); 
	page_footer_end(); 

	?>
</body>
