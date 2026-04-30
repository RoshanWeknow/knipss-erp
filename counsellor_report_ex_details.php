<?php
session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_start();
$response=1;
$msg='';
if($_SESSION['username']!='sadmin'){
	$_POST['stu_id'] = $_SESSION['username'];
}
else{
	if(!isset($_POST['stu_id'])){
		$_POST['stu_id'] = 'sadmin';
	}
}

if(isset($_GET['del'])){
	$sql = 'delete from fee_invoice4 where student_id='.$_GET['del'];
	execute_query(connect(), $sql);
	
	$sql = 'delete from student_info3 where sno='.$_GET['del'];
	execute_query(connect(), $sql);
	
	$msg .= '<h4>Deleted</h4>';
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
					<form action="counsellor_report_ex_details.php" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" >
						<div class="row">							
							<div class="col-md-4">							
								<label  class="desc" for="name">Approval date from <span class="name">*</span></label>
								
								<script  type="text/javascript" language="javascript">
									document.writeln(DateInput('apr_date_from', 'apr_date_from', true, 'YYYY-MM-DD', '<?php if(isset($_POST['apr_date_from'])){echo $_POST['apr_date_from'];}else{echo date("Y-m-d"); } ?>', 2));
								</script>
							</div>
							<div class="col-md-4">							
								<label  class="desc" for="name">Date to<span class="name">*</span></label>
								
								<script  type="text/javascript" language="javascript">
									document.writeln(DateInput('apr_date_to', 'apr_date_to', true, 'YYYY-MM-DD', '<?php if(isset($_POST['apr_date_to'])){echo $_POST['apr_date_to'];}else{echo date("Y-m-d"); } ?>', 2));
								</script>
							</div>
							<div class="col-md-4">							
								<label  class="desc" for="s_class">Select class <span class="alert">*</span></label>
								 <select name="class" class="form-control" id="class" >
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
						<div class="row">							
							<div class="col-md-4">							
								<label  class="desc" for="s_class">Select class <span class="alert">*</span></label>
								<select name="s_class" class="form-control" id="s_class" >
									<option value="">ALL</option>
									<option value="EX">Ex-Student</option>
									<option value="BACK">Back Paper</option>
									<option value="PRIVATE">Private</option>
								</select>
							</div>
						</div>								
								<input type="submit" class="btn btn-success" name="save" value="Submit" />							
								<input type="button" name="student_ledger" onClick="return view_report()"  value="Print" class="btn btn-danger">
				</div>
			</div>
		</div>
		
				
		<?php
		$sql = "select * from student_info3 where counselling_date>='".$_POST['apr_date_from']."' and counselling_date<='".date("Y-m-d", strtotime($_POST['apr_date_to'])+86400)."' ";
		if(isset($_POST['s_class'])){
			if($_POST['class']!=''){
				$sql .= ' and class="'.$_POST['class'].'"';
			}
			if($_POST['s_class']!=''){
				$sql .= ' and type="'.$_POST['s_class'].'"';
			}
		}
		//echo $sql;
		$result = execute_query(connect(), $sql);
		$_SESSION['sql1']="$sql";
		//$_SESSION['apr_date']=$_POST['apr_date'];
		?>	
		<div class="col-md-12">
			<div class="card">
				<table width="100%" class="table table-striped table-hover rounded">
					<tr class="bg-primary text-white">
						<th>S.No.</th>
						<th>Student Name</th>
						<th>Father's Name</th>
						<th>Class</th>
						<th>Type</th>
						<th>Form No</th>
						<th>Date</th>
						<th>Fees</th>
						<th>SF Fees</th>
						<th>Computer Fees</th>
						<th>Tour Fees </th>
						<th>Print</th>
						<th>&nbsp;</th>
					</tr>

				
					<?php
					$i=1;
					$tot_fees='';
					$tot_sf='';
					$tot_comp='';
					$tot_tour='';
					while($row = mysqli_fetch_array($result)){
						$class = mysqli_fetch_array(execute_query(connect(), "select * from class_detail where sno=".$row['class']));
						
						$sql = "select * from fee_invoice4 where approval_date='".$row['counselling_date']."' and student_id='".$row['sno']."' and type='fees'";
						$fees=execute_query(connect(), $sql);
						if(mysqli_num_rows($fees)!=0){
							$fees = mysqli_fetch_array($fees);
							
							$sql = "select * from fee_invoice4 where approval_date='".$row['counselling_date']."' and student_id='".$row['sno']."' and type='self'";
							$sf = execute_query(connect(), $sql);
							if(mysqli_num_rows($sf)==1){
								$sf = mysqli_fetch_array($sf);
								$sf = $sf['tot_amount'];
							}
							else{
								$sf=0;
							}

							$sql = "select * from fee_invoice4 where approval_date='".$row['counselling_date']."' and student_id='".$row['sno']."' and type='computer'";
							$computer = execute_query(connect(), $sql);
							if(mysqli_num_rows($computer)==1){
								$computer = mysqli_fetch_array($computer);
								$computer = $computer['tot_amount'];
							}
							else{
								$computer=0;
							}
							$sql = "select * from fee_invoice4 where approval_date='".$row['counselling_date']."' and student_id='".$row['sno']."' and type='tour'";
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
							<td>'.$class['class_description'].'</td>';
							if($row['type']=='EX'){
								echo '<td>Ex-Student</td>';
							}
							elseif($row['type']=='BACK'){
								echo '<td>Back Paper</td>';
							}
							else{
								echo '<td>Private</td>';
							}
							echo '
							<td>'.$row['form_no'].'</td>
							<td>'.$row['counselling_date'].'</td>
							<td>'.$fees['tot_amount'].'</td>
							<td>'.$sf.'</td>
							<td>'.$computer.'</td>
							<td>'.$tour.'</td>
							<td><a href="printing_ex.php?inv='.$fees['sno'].'" target="blank">PRINT</a></td>
							</tr>';
							$tot_fees += $fees['tot_amount'];
							$tot_sf += $sf;
							$tot_comp += $computer;
							$tot_tour += $tour;
						}

					}
					?>
					<tr><td colspan="6" style="text-align:right"><b>TOTAL</td>
						<td><b><?php echo $tot_fees?></td>
						<td><b><?php echo $tot_sf?></td>
						<td><b><?php echo $tot_comp?></td>
						<td><b><?php echo $tot_tour?></td>
					</tr>
					
					
					
				</table>

				

 			</form>
		</div>
	</div>
		

		<?php
        page_footer_start();
        page_footer_end();
        ?>