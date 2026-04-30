<?php
//session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_start();
$response=1;
$msg='';
if($_SESSION['username']!='sadmin'){
	$_POST['stu_id'] = $_SESSION['username'];
}
if(isset($_GET['del'])){
	$sql = 'select * from student_info2 where student_id='.$_GET['del'];
	$res = execute_query(connect(), $sql);
	if(mysqli_num_rows($res)!=0){
		$row2 = mysqli_fetch_array($res);
	}
	$sql= 'delete from fee_invoice2 where student_id='.$row2['sno'];
	execute_query(connect(), $sql);
	
	$sql = 'delete from student_info2 where student_id='.$_GET['del'];
	execute_query(connect(), $sql);
	
	$sql= 'delete from fee_invoice where student_id='.$_GET['del'];
	execute_query(connect(), $sql);
	
	$sql = 'delete from student_info where sno='.$_GET['del'];
	execute_query(connect(), $sql);
	
	$sql = 'update roll_no set date_of_deletion="'.date("Y-m-d").'" where stu_id="'.$_GET['del'].'"';
	execute_query(connect(), $sql);
	if(!mysqli_error()){
		$msg .= '<li class="error">Delete Sucessful</li>';
	}
	else{
		$msg .= '<li>Something is Wrong. '.mysqli_error().'</li>';
	}
	
}
page_header_end();
page_sidebar();
?>
<script type="text/javascript" language="javascript" src="form_validator.js"></script>
<body id="public">
	<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto"> 
            	<?php echo $msg; ?>   	
                <form action="delete_admission.php" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" >
                <h2>Delete <span class="orange">Admision</span></h2>
				<div class="col-md-12">
					<div class="row">							
						<div class="col-md-4">							
							<label>Class<span class="name">*</span></label>
							<select name="stud_class" class="form-control">
								<option value="ALL">ALL</option>
								<?php
								$sql = 'select * from class_detail order by sort_no, class_description';
								$result = execute_query(connect(), $sql);
								while($row = mysqli_fetch_array($result)){
									echo '<option value="'.$row['sno'].'" ';
									if(isset($_POST['stud_class'])){
										if($_POST['stud_class']==$row['sno']){
											echo ' selected';
										}
									}
									echo '>'.$row['class_description'].'</option>';
								}
								?>
							</select>
						</div>
						<div class="col-md-4">							
							<label>Type<span class="name">*</span></label>
							<select name="report_type" class="form-control">
								<option value="ALL" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='ALL'){echo'selected';}}?>>ALL</option>
								<option value="admit" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='admit'){echo'selected';}}?>>Admitted</option>
								<option value="pending" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='pending'){echo'selected';}}?>>Fees Pending</option>
								<option value="sf" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='sf'){echo'selected';}}?>>Self Finanace</option>
								<option value="computer" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='computer'){echo'selected';}}?>>Computer Fees</option>
							</select>
						</div>
						<div class="col-md-4">							
							<label>Date Type<span class="name">*</span></label>
							<select name="date_type" class="form-control">
								<option value="admit"<?php if(isset($_POST['date_type'])){if($_POST['date_type']=='admit'){echo'selected';}}?>>Admission Date</option>
								<option value="pending"<?php if(isset($_POST['date_type'])){if($_POST['date_type']=='pending'){echo'selected';}}?>>Counselling Date</option>
							</select>
						</div>
					</div>
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
					</div>
					<input type="submit" class="btn btn-primary submit" name="save" value="Submit" />
				</div>
			</div>
		</div>

				<?php
				if(isset($_POST['stud_class'])){
					$sql = "select student_info.sno as sno, stu_name, father_name, class, sub1, sub2, sub3, form_no, roll_no, tot_amount, class_description, fee_invoice.sno as fees_serial from student_info join fee_invoice on student_info.sno = fee_invoice.student_id join class_detail on class_detail.sno = student_info.class where 1=1";
					if($_POST['stud_class']!='ALL'){
						$sql .= ' and class='.$_POST['stud_class'];
					}
					if($_POST['report_type']=='admit'){
						$sql .= ' and status=2';
					}
					if($_POST['report_type']=='pending'){
						$sql .= ' and status=1';
					}
					if($_POST['report_type']=='ALL'){
						$sql .= ' and fee_invoice.type="fees"';
					}
					if($_POST['report_type']=='sf'){
						$sql .= ' and fee_invoice.type="self"';
					}
					if($_POST['report_type']=='computer'){
						$sql .= ' and fee_invoice.type="computer"';
					}
					if($_POST['date_type']=='admit'){
						$sql .= ' and timestamp>="'.strtotime($_POST['from_date']).'" and timestamp<="'.strtotime($_POST['to_date']).'"';
					}
					else{
						$sql .= ' and counselling_date>="'.$_POST['from_date'].'" and counselling_date<="'.$_POST['to_date'].'"';
					}
					$result = execute_query(connect(), $sql);
                ?>
		<div class="card card-body">
			<table width="100%" class="table table-striped table-hover rounded">
				<tr class="bg-primary text-white ">
					<th>S.No.</th>
					<th>Student Name</th>
					<th>Father's Name</th>
					<th>Class</th>
					 <th>Form No</th>
					<th>Subject 1</th>
					<th>Subject 2</th>
					<th>Subject 3</th>
					<th>Roll No</th>
					<th>Fees</th>
					<th>Delete</th>
				</tr>
				<?php
				$i=1;
				$tot_fees='';
				while($row = mysqli_fetch_array($result)){
					$sql = "select student_info2.student_id as sno, stu_name, father_name, class, sub1, sub2, sub3, form_no, roll_no, tot_amount, class_description, fee_invoice2.sno as fees_serial from student_info2 join fee_invoice2 on student_info2.student_id = fee_invoice2.student_id join class_detail on class_detail.sno = student_info2.class where student_info2.student_id=".$row['sno'];
					$r_chk = execute_query(connect(), $sql);
					$row_chk = mysqli_num_rows($r_chk);
					if($row_chk!=0){
						$row = mysqli_fetch_array($r_chk);
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
					<td>'.$row['class_description'].'</td>
					<td>'.$row['form_no'].'</td>
					<td>'.get_subject_detail($row['sub1'])['subject'].'</td>
					<td>'.get_subject_detail($row['sub2'])['subject'].'</td>
					<td>'.get_subject_detail($row['sub3'])['subject'].'</td>
					<td>'.$row['roll_no'].'</td>
					<td>'.$row['tot_amount'].'</td>
					<td><a href="delete_admission.php?del='.$row['sno'].'" onclick="return confirm(\'Are You sure?\')">DELETE</a></td>';
					echo '
					</tr>';
					}
				?>
			</table>
		</div>
                    <?php } ?>
                   
                </form>
 		</div>
     
<?php
page_footer_start();
page_footer_end();
?>