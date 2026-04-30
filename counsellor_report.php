<?php
session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_start();
$response=1;
$msg='';

//print_r($_SESSION);
if($_SESSION['type']!='sadmin'){
	$_POST['stu_id'] = $_SESSION['username'];
}
else{
	if(!isset($_POST['stu_id'])){
		$_POST['stu_id'] = 'sadmin';
	}
}
page_header_end();
page_sidebar();
?>

<script type="text/javascript" language="javascript">
function view_report() {
	window.open("view_report_print.php");
}
</script>
<body id="public">

		<div class="card card-body ">
			<div class="row d-flex my-auto">
				<div class="col-md-12">
					<h2> View <span class="orange">Report</span></h2>
					<?php 
						// $result = execute_query(connect(),'SELECT DATABASE()');
						// $res = mysqli_fetch_assoc($result);
						// print_r($res);
					
					?>
					<form action="counsellor_report.php" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" >
						<div class="row">							
							<div class="col-md-4">							
								<label  class="desc" for="name">Enter Counsellor ID:<span class="name">*</span></label>
								<input type="text" name="stu_id" id="stu_id" value="<?php if(isset($_POST['stu_id'])){echo $_POST['stu_id'];}?>" class="form-control">
							</div>
							<div class="col-md-4">							
								<label  class="desc" for="name">Approval date<span class="name">*</span></label>
								<script  type="text/javascript" language="javascript">
									document.writeln(DateInput('apr_date', 'apr_date', true, 'YYYY-MM-DD', '<?php if(isset($_POST['apr_date'])){echo $_POST['apr_date'];}else{echo date("Y-m-d"); } ?>', 2));
								</script>
								
							</div>
							<div class="col-md-4">							
								<label  class="desc" for="s_class">Select class <span class="alert">*</span></label>
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
						<input type="submit" class="btn btn-success" name="save" value="Submit" />
											
						<input type="button" name="student_ledger" onClick="return view_report()"  value="Print" class="btn btn-danger">
					</form>
				</div>
			</div>
		</div>
				
				<?php
				if(isset($_POST['apr_date'])){
                $sql = "select * from student_info where counselling_date='".$_POST['apr_date']."' and user_id='".$_POST['stu_id']."'";
				if(isset($_POST['s_class'])){
					if($_POST['s_class']!=''){
						$sql .= ' and class="'.$_POST['s_class'].'"';
					}
				}
				// echo $sql;
				$result = execute_query(connect(), $sql);
					// print_r($result);
				$_SESSION['sql1']="$sql";
				$_SESSION['apr_date']=$_POST['apr_date'];
                ?>
				<div class="col-md-12">
					<div class="card">
						<table width="100%" class="table table-striped table-hover rounded">
							<tr class="bg-primary text-white">
								<th>S.No.</th>
								<th>Student Name</th>
								<th>Father's Name</th>
								<th>Class</th>
								<th>Form No</th>
								<th>Actual Fees</th>
								<th>Discount</th>
								<th>Fees</th>
								<th>Vocational Fees</th>
								<th>SF Fees</th>
								<th>Computer Fees</th>
								<th>Tour Fees </th>
								<th>Print</th>
							</tr>
							<?php
							$i=1;
							$tot_fees='';
							$tot_sf='';
							$tot_comp='';
							$tot_tour='';
							$tot_vocational='';
							$tot_fees_calc='';
							$tot_discount='';
							if($result){
								// print_r($result);
								while($row = mysqli_fetch_array($result)){
									// print_r($row);
									$class = mysqli_fetch_array(execute_query(connect(), "select * from class_detail where sno=".$row['class']));
									
									$sql = "select * from fee_invoice where approval_date='".$_POST['apr_date']."' and student_id='".$row['sno']."' and type='fees'";
									$fees=execute_query(connect(), $sql);
									if(mysqli_num_rows($fees)!=0){
										$fees = mysqli_fetch_array($fees);
										
										$sql = "select * from fee_invoice where approval_date='".$_POST['apr_date']."' and student_id='".$row['sno']."' and type='self'";
										$sf = execute_query(connect(), $sql);
										if(mysqli_num_rows($sf)==1){
											$sf = mysqli_fetch_array($sf);
											$sf = $sf['tot_amount'];
										}
										else{
											$sf=0;
										}
										
										$sql = "select * from fee_invoice where approval_date='".$_POST['apr_date']."' and student_id='".$row['sno']."' and type='vocational'";
										$vocational = execute_query(connect(), $sql);
										if(mysqli_num_rows($vocational)==1){
											$vocational = mysqli_fetch_array($vocational);
											$vocational = $vocational['tot_amount'];
										}
										else{
											$vocational=0;
										}

										$sql = "select * from fee_invoice where approval_date='".$_POST['apr_date']."' and student_id='".$row['sno']."' and type='computer'";
										$computer = execute_query(connect(), $sql);
										if(mysqli_num_rows($computer)==1){
											$computer = mysqli_fetch_array($computer);
											$computer = $computer['tot_amount'];
										}
										else{
											$computer=0;
										}
										$sql = "select * from fee_invoice where approval_date='".$_POST['apr_date']."' and student_id='".$row['sno']."' and type='tour'";
										$tour = execute_query(connect(), $sql);
										if(mysqli_num_rows($tour)==1){
											$tour = mysqli_fetch_array($tour);
											$tour = $tour['tot_amount'];
										}
										else{
											$tour=0;
										}
										if($i%2==0){
											$col = '#CCC';
										}
										else{
											$col = '#EEE';
										}

										echo '<tr style="background:'.$col.'">
										<td>'.$i++.'</td>
										<td>'.$row['stu_name'].'</td>
										<td>'.$row['father_name'].'</td>
										<td>'.$class['class_description'].'</td>
										<td>'.$row['form_no'].'</td>
										<td>'.$fees['fees_amount'].'</td>
										<td>'.$fees['discount'].'</td>
										<td>'.$fees['amount_paid'].'</td>
										<td>'.$vocational.'</td>
										<td>'.$sf.'</td>
										<td>'.$computer.'</td>
										<td>'.$tour.'</td>
										<td><a href="printing.php?inv='.$fees['sno'].'" target="blank">PRINT</a></td></tr>';
										$tot_fees_calc += $fees['fees_amount'];
										$tot_discount += $fees['discount'];
										$tot_fees += $fees['amount_paid'];
										$tot_vocational += $vocational;
										$tot_sf += $sf;
										$tot_comp += $computer;
										$tot_tour += $tour;
									}
									
								}
							}
											}
							?>
								<tfoot  class=''>
									<tr '>
										<td colspan='4'></td>
										<td style='font-weight: 700 !important;'>Total</td>
										<td style='font-weight: 700 !important;'><?php echo isset($tot_fees_calc)?$tot_fees_calc:''; ?></td>
										<td style='font-weight: 700 !important;'><?php echo isset($tot_discount)?$tot_discount:''; ?></td>
										<td style='font-weight: 700 !important;'><?php echo isset($tot_fees)?$tot_fees:''; ?></td>
										<td style='font-weight: 700 !important;'><?php echo isset($tot_vocational)?$tot_vocational:''; ?></td>
										<td style='font-weight: 700 !important;'><?php echo isset($tot_sf)?$tot_sf:''; ?></td>
										<td style='font-weight: 700 !important;'><?php echo isset($tot_comp)?$tot_comp:''; ?></td>
										<td style='font-weight: 700 !important;'><?php echo isset($tot_tour)?$tot_tour:''; ?></td>
									</tr>
								<tfoot>
						</table>
					</div>
                </div>

				
		<?php
        page_footer_start();
        page_footer_end();
        ?>
  </body>