<?php
set_time_limit(0);
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
	page_header_end();
	page_sidebar();
?>

<script type="text/javascript" language="javascript">
function admission_report() {
	window.open("admission_report_print.php");
}
</script>
<body id="public">
	<div class="card">
		<div class="card-body ">
			<div class="row d-flex my-auto">					
				<h2> Student Report </h2>
				<form action="admissionreports.php" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" >
					<div class="col-md-12">
						<div class="row">							
							<div class="col-md-4">							
								<label  class="desc" for="name">Class<span class="name">*</span></label>
								<select name="stud_class" class="form-control">
									<option value="ALL">ALL</option>
									<?php
									$sql = 'select * from class_detail order by sort_no, abs(year), sno';
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
								<label  class="desc" for="name">Gender<span class="name">*</span></label>
								<select name="gender" class="form-control">
									<option value="ALL" <?php if(isset($_POST['gender'])){if($_POST['gender']=='All') {echo ' selected';}} ?>>ALL</option>
									<option value="M" <?php if(isset($_POST['gender'])){if($_POST['gender']=='M') {echo ' selected';}} ?>>Male</option>
									<option value="F" <?php if(isset($_POST['gender'])){if($_POST['gender']=='F') {echo ' selected';}} ?>>Female</option>
								</select>
								
							</div>
							<div class="col-md-4">							
								<label  class="desc" for="name">Caste<span class="name">*</span></label>
								<select name="caste" class="form-control">
								<option value="ALL" <?php if(isset($_POST['caste'])){if($_POST['caste']=='ALL') {echo ' selected';}} ?>>ALL</option>
									<option value="GEN" <?php if(isset($_POST['caste'])){if($_POST['caste']=='GEN') {echo ' selected';}} ?>>GENERAL</option>
									<option value="OBC" <?php if(isset($_POST['caste'])){if($_POST['caste']=='OBC') {echo ' selected';}} ?>>OBC</option>
									<option value="SC" <?php if(isset($_POST['caste'])){if($_POST['caste']=='SC') {echo ' selected';}} ?>>SC</option>
									<option value="ST" <?php if(isset($_POST['caste'])){if($_POST['caste']=='ST') {echo ' selected';}} ?>>ST</option>
								</select>
							</div>
						</div>
						<div class="row">							
							<div class="col-md-4">							
								<label  class="desc" for="name">Minority<span class="name">*</span></label>
								<select name="minority" class="form-control">
									 <option value="ALL" <?php if(isset($_POST['minority'])){if($_POST['minority']=='ALL') {echo ' selected';}} ?>>ALL</option>
									<option value="YES" <?php if(isset($_POST['minority'])){if($_POST['minority']=='YES') {echo ' selected';}} ?>>YES</option>
									<option value="NO" <?php if(isset($_POST['minority'])){if($_POST['minority']=='NO') {echo ' selected';}} ?>>NO</option>
								</select>
							</div>
							<div class="col-md-4">							
								<label  class="desc" for="subject">Select Subject <span class="alert">*</span></label>
								<select name="subject" class="form-control" id="subject" >
										<option value="" selected="selected"></option>
										<?php
										$sql = 'select * from add_subject';
										$res = execute_query(connect(), $sql);
										$tot_sub_count = array();
										while($row = mysqli_fetch_array($res)) {
											echo '<option value="'.$row['sno'].'" ';
											if($_POST['subject']==$row['sno']){
												echo ' selected="selected" ';
											}
											$tot_sub_count[$row['sno']] = 0;
											echo '>'.$row['subject'].'</option> ';
										}
										?>
								 </select>
							</div>
							<div class="col-md-4">							
								<label  class="desc" for="name">Type<span class="name">*</span></label>
								<select name="report_type" class="form-control">
									<option value="ALL" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='All') {echo ' selected';}} ?>>ALL</option>
									<option value="admit" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='admit') {echo ' selected';}} ?>>Admitted</option>
									<option value="pending" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='pending') {echo ' selected';}} ?>>Fees Pending</option>
									<option value="sf" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='sf') {echo ' selected';}} ?>>Self Finanace</option>
									<option value="computer" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='computer') {echo ' selected';}} ?>>Computer Fees</option>
									<option value="tour" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='tour') {echo ' selected';}} ?>>Tour Fees</option>
								</select>
							</div>
						</div>
						<div class="row">							
							<div class="col-md-4">							
								<label  class="desc" for="name">Date Type<span class="name">*</span></label>
								<select name="date_type" class="form-control">
									<option value="admit" <?php if(isset($_POST['date_type'])){if($_POST['date_type']=='admit') {echo ' selected';}} ?>>Admission Date</option>
									<option value="pending" <?php if(isset($_POST['date_type'])){if($_POST['date_type']=='pending') {echo ' selected';}} ?>>Counselling Date</option>
								</select>
							</div>
							<div class="col-md-4">							
								<label  class="desc" for="name">From Date<span class="name">*</span></label>							
								<script  type="text/javascript" language="javascript">
									document.writeln(DateInput('from_date', 'from_date', true, 'YYYY-MM-DD', '<?php if(isset($_POST['from_date'])){echo $_POST['from_date'];}else{echo date("Y-m-d"); } ?>', 2));
								</script>
								
							</div>
							<div class="col-md-4">							
								<label  class="desc" for="name">To Date<span class="name">*</span></label>
								<script  type="text/javascript" language="javascript">
									document.writeln(DateInput('to_date', 'to_date', true, 'YYYY-MM-DD', '<?php if(isset($_POST['to_date'])){echo $_POST['to_date'];}else{echo date("Y-m-d"); } ?>', 2));
								</script>
									
							</div>
						</div>
						<input type="submit" class="btn btn-primary" name="save" value="Submit" />
					</div>
					<?php
					if(isset($_POST['stud_class'])){
						$sql = "(select student_info.sno as sno, stu_name, father_name,mother_name,gender,date_of_admission,student_info.category,class, sub1, sub2, sub3, form_no, roll_no, tot_amount, amount_paid , class_description,cancel_date, fee_invoice.sno as fees_serial, '1' as info from student_info join fee_invoice on student_info.sno = fee_invoice.student_id join class_detail on class_detail.sno = student_info.class  where 1=1 ";
						if($_POST['stud_class']!='ALL'){
							$sql .= ' and class='.$_POST['stud_class'];
						}
						if($_POST['gender']!='ALL'){
							$sql .= ' and student_info.gender="'.$_POST['gender'].'"';
						}
						if($_POST['caste']!='ALL'){
							$sql .= ' and student_info.category="'.$_POST['caste'].'"';
						}
						if($_POST['minority']!=='ALL'){
							$sql .= ' and student_info.minority="'.$_POST['minority'].'"';
						}
						if($_POST['subject']!=''){
							$sql .= ' and (student_info.sub1="'.$_POST['subject'].'" or student_info.sub2="'.$_POST['subject'].'" or student_info.sub3="'.$_POST['subject'].'" )';
						}
						if($_POST['report_type']=='admit'){
							$sql .= ' and student_info.status=2';
						}
						if($_POST['report_type']=='pending'){
							$sql .= ' and student_info.status=1';
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
						if($_POST['report_type']=='tour'){
							$sql .= ' and fee_invoice.type="tour"';
						}
						
						if($_POST['date_type']=='admit'){
							$sql .= ' and approval_date>="'.$_POST['from_date'].'" and approval_date<"'.date("Y-m-d", strtotime($_POST['to_date']."+1 day")).'"';
						}
						else{
							$sql .= ' and counselling_date>="'.$_POST['from_date'].'" and counselling_date<"'.date("Y-m-d", strtotime($_POST['to_date']. "+1 day")).'"';
						}
						//echo $sql;
						$sql .= ') union all(select student_info2.student_id as sno, stu_name, father_name,mother_name,gender,date_of_admission,student_info2.category,class,sub1, sub2, sub3, form_no, roll_no, tot_amount,amount_paid , class_description, cancel_date,  fee_invoice3.sno as fees_serial, "2" as info from student_info2 join fee_invoice3 on student_info2.student_id = fee_invoice3.student_id join class_detail on class_detail.sno = student_info2.class where class in (61, 63, 65, 67, 69, 71, 73, 75, 77, 79, 81)';
						if($_POST['stud_class']!='ALL'){
							$sql .= ' and class='.$_POST['stud_class'];
						}
						if($_POST['gender']!='ALL'){
							$sql .= ' and student_info2.gender="'.$_POST['gender'].'"';
						}
						if($_POST['caste']!='ALL'){
							$sql .= ' and student_info2.category="'.$_POST['caste'].'"';
						}
						if($_POST['minority']!=='ALL'){
							$sql .= ' and student_info2.minority="'.$_POST['minority'].'"';
						}
						if($_POST['subject']!=''){
							$sql .= ' and (student_info2.sub1="'.$_POST['subject'].'" or student_info2.sub2="'.$_POST['subject'].'" or student_info2.sub3="'.$_POST['subject'].'" )';
						}
						if($_POST['report_type']=='admit'){
							$sql .= ' and student_info2.status=2';
						}
						if($_POST['report_type']=='pending'){
							$sql .= ' and student_info2.status=1';
						}
						if($_POST['report_type']=='ALL'){
							$sql .= ' and fee_invoice3.type="fees"';
						}
						if($_POST['report_type']=='sf'){
							$sql .= ' and fee_invoice3.type="self"';
						}
						if($_POST['report_type']=='computer'){
							$sql .= ' and fee_invoice3.type="computer"';
						}
						if($_POST['report_type']=='tour'){
							$sql .= ' and fee_invoice3.type="tour"';
						}
						
						if($_POST['date_type']=='admit'){
							$sql .= ' and approval_date>="'.$_POST['from_date'].' 00:00:00" and approval_date<"'.date("Y-m-d", strtotime($_POST['to_date']."+1 day")).'"';
						}
						else{
							$sql .= ' and counselling_date>="'.$_POST['from_date'].'" and counselling_date<"'.date("Y-m-d", strtotime($_POST['to_date']. "+1 day")).'"';
						}
						
						$sql .= ')';
						$_SESSION['sql2']="$sql";
						//echo $sql;
						$result = execute_query(connect(), $sql);
					?>
					
                </form>
				<div class="row d-flex my-auto">		
					<div class="col-md-12">
						<div class="card">
						<div class="col-md-12"><input type="button" class="btn btn-danger" name="student_ledger" onClick="return admission_report()" style="float: right;" value="Print"></div>
							<table width="100%" class="table table-striped table-hover rounded">
								<tr class="bg-primary text-white">
									<th>S.No.</th>
									<th>Roll No</th>
									<th>Form No</th>
									<th>Student Name</th>
									<th>Father's Name</th>
									<th>Mother's Name</th>
									<th>Admission Date</th>
									<th>Class</th>
									<th>Gender</th>
									<th>Category</th>
									<th>Subject 1</th>
									<th>Subject 2</th>
									<th>Subject 3</th>
									<th>Minor/Elective</th>
									<th>Co-curricular</th>
									<th>Vocational</th>
									<th>Fees</th>
									<th>Self Fees</th>
									<th>Vocational Fees</th>
									<th>Comp. Fees</th>
									<th>Tour Fees</th>
									<th>Status</th>
									<th>View Scholar Details</th>
								</tr>

								<?php
								$i=1;
								$tot_fees='';
								$tot_sf='';
								$tot_comp='';
								$tot_tour='';
								$tot_vocational='';
								while($row = mysqli_fetch_array($result)){
									$roll=$row['sno'];
									if($row['info']==1){
										$sql = "select student_info2.sno as stu_id, student_info2.student_id as sno, stu_name, father_name,mother_name,gender,date_of_admission,student_info2.category,class,sub1, sub2, sub3, form_no, roll_no, tot_amount, amount_paid , class_description, fee_invoice.sno as fees_serial from student_info2 join fee_invoice on student_info2.student_id = fee_invoice.student_id join class_detail on class_detail.sno = student_info2.class where student_info2.student_id=".$row['sno']." and student_info2.type='subject_change'";
										//echo $sql.'<br>';
										if($_POST['report_type']=='ALL'){
											$sql .= ' and fee_invoice.type="fees"';
										}
										if($_POST['report_type']=='sf'){
											$sql .= ' and fee_invoice.type="self"';
										}
										if($_POST['report_type']=='computer'){
											$sql .= ' and fee_invoice.type="computer"';
										}
										if($_POST['subject']!=''){
										$sql .= ' and (student_info2.sub1="'.$_POST['subject'].'" or student_info2.sub2="'.$_POST['subject'].'" or student_info2.sub3="'.$_POST['subject'].'" )';
										}
										//echo $sql;
										$r_chk = execute_query(connect(), $sql);
										$row_chk = mysqli_num_rows($r_chk);
									}
									else{
										$row_chk=0;
									}
									if($i%2==0){
										$col = '#CCC';
									}
									else{
										$col = '#EEE';
									}
									if($row_chk!=0){
										//echo $sql;
										$col = "Yellow";
										$row = mysqli_fetch_array($r_chk);
										$sql = 'select * from fee_invoice2 where student_id='.$row['stu_id'];
										if($_POST['report_type']=='ALL'){
											$sql .= ' and fee_invoice2.type="fees"';
										}
										if($_POST['report_type']=='sf'){
											$sql .= ' and fee_invoice2.type="self"';
										}
										if($_POST['report_type']=='computer'){
											$sql .= ' and fee_invoice2.type="computer"';
										}
										$fee2 = mysqli_fetch_array(execute_query(connect(), $sql));
										$row['tot_amount'] += $fee2['amount_paid'];
										
									}
									if($row['cancel_date']!=''){ $col="#F00"; }
									echo '<tr style="background:'.$col.'">
									<td>'.$i++.'</td>
									<td>'.$row['roll_no'].'</td>
									<td>'.$row['form_no'].'</td>
									<td>'.$row['stu_name'].'</td>
									<td>'.$row['father_name'].'</td>
									<td>'.$row['mother_name'].'</td>
									<td>'.$row['date_of_admission'].'</td>
									<td>'.$row['class_description'].'</td>
									<td>'.$row['gender'].'</td>
									<td>'.$row['category'].'</td>
									<td>'.get_subject_detail($row['sub1'])['subject'].'</td>
									<td>'.get_subject_detail($row['sub2'])['subject'].'</td>
									<td>'.get_subject_detail($row['sub3'])['subject'].'</td>';
									$sql = "SELECT subject, 
											CASE subject_type 
												  WHEN 1 THEN 'Minor/Elective Subject'
												  WHEN 2 THEN 'Co-curricular Subject'
												  WHEN 3 THEN 'Vocational Subject'
												  ELSE NULL
											  END as 'subject_type'
											FROM `student_info_subject` left join add_subject2 on add_subject2.sno = subject_id where student_id=".$row['sno'];
									//echo $sql;
									$result_other_sub = execute_query(connect(), $sql);
									if ( mysqli_num_rows( $result_other_sub ) != 0 ) {
										while ( $row_other_sub = mysqli_fetch_assoc( $result_other_sub ) ) {
											echo ($row_other_sub[ 'subject' ]!='')?'<td>' . $row_other_sub[ 'subject' ] . '</td>':'<td></td>';
										}
									}
									else{
										echo '<td></td>';
										echo '<td></td>';
										echo '<td></td>';
									}

									echo '<td>'.$row['amount_paid'].'</td>
									<td>'.get_self_fees($roll)['tot_amount'].'</td>
									<td>'.get_vocational_fees($roll)['tot_amount'].'</td>
									<td>'.get_comp_fees($roll)['tot_amount'].'</td>
									<td>'.get_tour_fees($roll)['tot_amount'].'</td>
									<td><a href="edit_admission.php?id='.$row['sno'].'" >Details</a></td>
									<td><a href="scholar_detail.php?id='.$row['sno'].'" >View</a></td></tr>';
									$tot_fees+=$row['amount_paid'];
									$tot_sf+=get_self_fees($roll)['tot_amount'];
									$tot_vocational+=get_vocational_fees($roll)['tot_amount'];
									$tot_comp+=get_comp_fees($roll)['tot_amount'];
									$tot_tour+=get_tour_fees($roll)['tot_amount'];
									$tot_sub_count[$row['sub1']]++;
									$tot_sub_count[$row['sub2']]++;
									$tot_sub_count[$row['sub3']]++;
									
									
								}
								?>
								<tr><td colspan="16" style="text-align:right"><b>TOTAL</td>
								<td><b><?php echo $tot_fees?></td>
								<td><b><?php echo $tot_sf?></td>
								<td><b><?php echo $tot_vocational; ?></td>
								<td><b><?php echo $tot_comp?></td>
								<td><b><?php echo $tot_tour?></td>
								<td></td>
								<td></td>
								</tr>
							</table>
						</div>
					</div>
				</div>

				<div class="row d-flex my-auto">		
					<div class="col-md-12">
						<div class="card">
							<table width="100%" class="table table-striped table-hover rounded">
								<tr class="bg-primary text-white">
									<th>S.No.</th>
									<th>Subject Name</th>
									<th>Count</th>
								</tr>

								<?php
								$i=1;
								$sql = 'select * from add_subject';
								$result_subject = execute_query(connect(), $sql);
								while($row_subject = mysqli_fetch_assoc($result_subject)){
									echo '<tr>
									<td>'.$i++.'</td>
									<td>'.$row_subject['subject'].'</td>
									<td>'.$tot_sub_count[$row_subject['sno']].'</td>
									</tr>';
								}
								?>
							</table>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php
	page_footer_start();
	page_footer_end();
	?>
</body>