<?php
include("scripts/settings.php");
set_time_limit(0);
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_start();
$response=1;
$msg='';
if($_SESSION['username']!='sadmin'){
	$_POST['stu_id'] = $_SESSION['username'];
}
$start_time = time();
page_header_end();
page_sidebar();
?>
<script type="text/javascript" language="javascript">
function student_report() {
	window.open("student_report_print.php");
}
</script>
<body id="public">
	<div class="container col-md-12">
		<div class="card ">
			<div class="card-body ">
				<form action="student_details.php" class="wufoo leftLabel page1 no-print" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" >
					<?php echo $msg; ?>
					<div class="row d-flex my-auto">		
						<div class="col-md-12">
							<div class="card">
								<h3> Student Details </h3>
								<table width="100%" class="table table-striped table-hover rounded " >
									<tr  style="text-align:left;">
										<th width="5%"><input type="checkbox" name="stu_name" <?php echo (isset($_POST['stu_name']))?'checked':'';?>/></th>
										<th width="45%">Student Name<span class="name">*</span> </th>
										<th width="5%"><input type="checkbox" name="mother_name" <?php echo (isset($_POST['mother_name']))?'checked':'';?>/></th>
										<th width="45%">Mother Name<span class="name">*</span> </th>
										
									</tr>
									
									<tr >
										<th> Father Name<span class="name">*</span></th>
										<th><input type="checkbox" name="father_name" <?php echo (isset($_POST['father_name']))?'checked':'';?>/> </th>
										<th></th>
										<th></th>
									</tr>
									<tr>
										<th>Class<span class="name">*</span></th>
										<th><input type="checkbox" name="class" <?php echo (isset($_POST['class']))?'checked':'';?>/>
										</th><th>
										<select name="stud_class" class="form-control">
											<option value="ALL">ALL</option>
											<?php
											$sql = 'select * from class_detail order by sort_no, year';
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
										</select></th>
										<th></th>
									</tr>
									<tr >
										<th>Minority<span class="name">*</span></th>
										<th><input type="checkbox"  name="minor" <?php echo (isset($_POST['minor']))?'checked':'';?>/>
										</th><th>
										<select name="minority" class="form-control">
											<option value="ALL" <?php if(isset($_POST['minority'])){if($_POST['minority']=='ALL') {echo ' selected';}} ?>>ALL</option>
											<option value="YES" <?php if(isset($_POST['minority'])){if($_POST['minority']=='YES') {echo ' selected';}} ?>>YES</option>
											<option value="NO" <?php if(isset($_POST['minority'])){if($_POST['minority']=='NO') {echo ' selected';}} ?>>NO</option>
										</select></th>
										<th></th>
									</tr>
									<tr>
										<th>Physical Handicapped<span class="name">*</span></th>
										<th><input type="checkbox" name="physical_handicapped_switch" <?php echo (isset($_POST['physical_handicapped_switch']))?'checked':'';?>/></th><th>
										<select name="physical_handicapped" class="form-control">
											<option value="ALL" <?php if(isset($_POST['physical_handicapped'])){if($_POST['physical_handicapped']=='ALL') {echo ' selected';}} ?>>ALL</option>
											<option value="YES" <?php if(isset($_POST['physical_handicapped'])){if($_POST['physical_handicapped']=='YES') {echo ' selected';}} ?>>YES</option>
											<option value="NO" <?php if(isset($_POST['physical_handicapped'])){if($_POST['physical_handicapped']=='NO') {echo ' selected';}} ?>>NO</option>
										</select></th>
										<th></th>
									</tr>
									<tr >
										<th>Select Subject <span class="alert">*</span> </th>
										<th><input type="checkbox" name="subjects" <?php echo (isset($_POST['subjects']))?'checked':'';?>/></th><th>
										<select name="subject" id="subject" class="form-control">
											<option value="ALL" selected="selected">ALL</option>
											<?php
											$sql = 'select * from add_subject';
											$res = execute_query(connect(), $sql);
											while($row = mysqli_fetch_array($res)) {
												echo '<option value="'.$row['sno'].'" ';
												if(isset($_POST['subject'])){
													if($_POST['subject']==$row['sno']){
														echo ' selected="selected" ';
													}	
												}
												echo '>'.$row['subject'].'</option> ';
											}
											?>
										</select> </th>
										<th></th>
									</tr>
									<tr>
										<th>Minor/Elective <span class="alert">*</span> </th>
										<th><input type="checkbox" name="minor_switch" <?php echo (isset($_POST['minor_switch']))?'checked':'';?>/></th><th>
										<select name="minor_subject" class="form-control" id="minor_subject" >
											<option value="ALL" selected="selected">ALL</option>
											<?php
											$sql = 'select * from add_subject2 where subject_type=1';
											$res = execute_query(connect(), $sql);
											while($row = mysqli_fetch_array($res)) {
												echo '<option value="'.$row['sno'].'" ';
												if(isset($_POST['minor_subject'])){
													if($_POST['minor_subject']==$row['sno']){
														echo ' selected="selected" ';
													}
												}
												echo '>'.$row['subject'].'</option> ';
											}
											?>
										</select> </th>
										<th></th>
									</tr>
									<tr >
										<th>Co-curricular <span class="alert">*</span> </th>
										<th><input type="checkbox" name="cocurricular_switch" <?php echo (isset($_POST['cocurricular_switch']))?'checked':'';?>/></th><th>
										<select name="cocurricular" class="form-control" id="cocurricular" >
											<option value="ALL" selected="selected">ALL</option>
											<?php
											$sql = 'select * from add_subject2 where subject_type=2';
											$res = execute_query(connect(), $sql);
											while($row = mysqli_fetch_array($res)) {
												echo '<option value="'.$row['sno'].'" ';
												if(isset($_POST['cocurricular_switch'])){
													if($_POST['cocurricular']==$row['sno']){
														echo ' selected="selected" ';
													}
												}
												echo '>'.$row['subject'].'</option> ';
											}
											?>
										</select> </th>
										<th></th>
									</tr>
									<tr>
										<th>Vocational <span class="alert">*</span> </th>
										<th><input type="checkbox" name="vocational_switch" <?php echo (isset($_POST['vocational_switch']))?'checked':'';?>/></th><th>
										<select name="vocational" class="form-control" id="vocational" >
											<option value="ALL" selected="selected">ALL</option>
											<?php
											$sql = 'select * from add_subject2 where subject_type=3';
											$res = execute_query(connect(), $sql);
											while($row = mysqli_fetch_array($res)) {
												echo '<option value="'.$row['sno'].'" ';
												if(isset($_POST['vocational'])){
													if($_POST['vocational']==$row['sno']){
														echo ' selected="selected" ';
													}
												}
												echo '>'.$row['subject'].'</option> ';
											}
											?>
										</select> </th>
										<th></th>
									</tr>
									<tr >
										<th> Date Of Birth<span class="name">*</span></th>
										<th><input type="checkbox" name="dob" <?php echo (isset($_POST['dob']))?'checked':'';?>/> </th>
										<th></th>
										<th></th>
									</tr>
									<tr>
										<th>Address<span class="name">*</span> </th>
										<th><input type="checkbox" name="perm_address" <?php echo (isset($_POST['perm_address']))?'checked':'';?>/> </th>
										<th></th>
										<th></th>
									</tr>
									<tr  >
										<th>State<span class="name">*</span></th>
										<th><input type="checkbox" name="state_check" <?php echo (isset($_POST['state_check']))?'checked':'';?>/></th><th>
										<select name="state" class="form-control" id="state" >
											<option value="ALL" selected="selected">ALL</option>
											<?php
											$sql = 'select * from student_info where status=2 group by p_state';
											$res = execute_query(connect(), $sql);
											while($row = mysqli_fetch_array($res)) {
												echo '<option value="'.$row['p_state'].'" ';
												if(isset($_POST['state'])){
													if($_POST['state']==$row['p_state']){
														echo ' selected="selected" ';
													}
												}
												echo '>'.$row['p_state'].'</option> ';
											}
											?>
										</select></th>
										<th></th>
									</tr>
									<tr>
										<th>Mobile<span class="name">*</span></th>
										<th><input type="checkbox" name="mobile" <?php echo (isset($_POST['mobile']))?'checked':'';?>/></th>
										<th></th>
										<th></th>
									</tr>
									<tr >
										<th>Gender<span class="name">*</span></th>
										<th><input type="checkbox" name="gender1" <?php echo (isset($_POST['gender1']))?'checked':'';?>/>
										</th><th>
										<select name="gender" class="form-control">
											<option value="ALL" <?php if(isset($_POST['gender'])){if($_POST['gender']=='All') {echo ' selected';}} ?>>ALL</option>
											<option value="M" <?php if(isset($_POST['gender'])){if($_POST['gender']=='M') {echo ' selected';}} ?>>Male</option>
											<option value="F" <?php if(isset($_POST['gender'])){if($_POST['gender']=='F') {echo ' selected';}} ?>>Female</option>
										</select></th>
										<th></th>
									<tr>
									<tr>
										<th>Caste<span class="name">*</span></th>
										<th><input type="checkbox" name="caste1" <?php echo (isset($_POST['caste1']))?'checked':'';?>/>
											</th><th>
											<select name="caste" class="form-control">
												<option value="ALL" <?php if(isset($_POST['category'])){if($_POST['category']=='ALL') {echo ' selected';}} ?>>ALL</option>
												<option value="GEN" <?php if(isset($_POST['category'])){if($_POST['category']=='GEN') {echo ' selected';}} ?>>GENERAL</option>
												<option value="OBC" <?php if(isset($_POST['category'])){if($_POST['category']=='OBC') {echo ' selected';}} ?>>OBC</option>
												<option value="SC" <?php if(isset($_POST['category'])){if($_POST['category']=='SC') {echo ' selected';}} ?>>SC</option>
												<option value="ST" <?php if(isset($_POST['category'])){if($_POST['category']=='ST') {echo ' selected';}} ?>>ST</option>
											</select></th>
										<th></th>
									</tr>
									<tr >
										<th>Form No.<span class="name">*</span></th>
										<th><input type="checkbox" name="form_no" <?php echo (isset($_POST['form_no']))?'checked':'';?>/></th>
										<th></th>
										<th></th>
									</tr>
									<tr>
										<th>Email<span class="name">*</span></th>
										<th><input type="checkbox" name="email1" <?php echo (isset($_POST['email1']))?'checked':'';?>/></th>
										<th></th>
										<th></th>
									</tr>
									<tr >
										<th>Identication<span class="name">*</span></th>
										<th><input type="checkbox" name="identification" <?php echo (isset($_POST['identification']))?'checked':'';?>/></th>
										<th></th>
										<th></th>
									</tr>
									<tr>
										<th>Roll No.<span class="name">*</span></th>
										<th><input type="checkbox" name="roll_no" <?php echo (isset($_POST['roll_no']))?'checked':'';?>/></th>
										<th></th>
										<th></th>
									</tr>
									<tr >
										<th>UIN No.<span class="name">*</span></th>
										<th><input type="checkbox" name="uin" <?php echo (isset($_POST['uin']))?'checked':'';?>/></th>
										<th></th>
										<th></th>
									</tr>
									<tr>
										<th>View Scholar Details<span class="name">*</span></th>
										<th><input type="checkbox" name="view" <?php echo (isset($_POST['view']))?'checked':'';?>/></th>
										<th></th>
										<th></th>
									</tr>
									<tr >
										<th>Select Income<span class="name">*</span></th>
										<th><input type="checkbox" name="income" <?php echo (isset($_POST['income']))?'checked':'';?>/>
										</th><th>
										<select name="annual_income" id="annual_income" class="form-control">
											  <option value="ALL">ALL</option>
											  <option value="1">Below 2 Lakhs</option>
											  <option value="200000">Above 2 Lakhs</option>
										</select></th>
										<th></th>
									</tr>
									<tr>
										<th>Prev. University <span class="alert">*</span></th>
										<th><input type="checkbox" name="univ" <?php echo (isset($_POST['univ']))?'checked':'';?>/></th><th>
										<select name="other_univ" class="form-control" id="other_univ"  value="" class="form-control">
											<option value="ALL">ALL</option>
											<option value="awadh">Dr.R.M.L.Awadh University</option>
											<option value="other">Other University</option>
										</select></th>
										<th></th>
									</tr>
									<tr >
										<th>Prev. Qualification <span class="alert">*</span></th>
										<th><input type="checkbox" name="prev_qual" <?php echo (isset($_POST['prev_qual']))?'checked':'';?>/></th>
										<th></th>
										<th></th>
									</tr>
									<tr>
										<th>Remarks<span class="name">*</span></th>
										<th><input type="checkbox" name="remarks" <?php echo (isset($_POST['remarks']))?'checked':'';?>/></th>
										<th></th>
										<th></th>
									</tr>
									<tr >
										<th>Date Type<span class="name">*</span></th>
										<th><input type="checkbox" name="date1" <?php echo (isset($_POST['date1']))?'checked':'';?>/>
										</th><th>
										<select name="date_type" class="form-control">
											<option value="admit" <?php if(isset($_POST['date_type'])){if($_POST['date_type']=='admit') {echo ' selected';}} ?>>Admission Date</option>
											<option value="pending" <?php if(isset($_POST['date_type'])){if($_POST['date_type']=='pending') {echo ' selected';}} ?>>Counselling Date</option>
										</select></th>
										<th></th>
									</tr>
									<tr>
										<th>Type<span class="name">*</span></th>
										<th></th>
										<th><select name="report_type" class="form-control">
											<option value="ALL" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='All') {echo ' selected';}} ?>>ALL</option>
											<option value="sf" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='sf') {echo ' selected';}} ?>>Self Finanace</option>
											<option value="computer" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='computer') {echo ' selected';}} ?>>Computer Fees</option>
											<option value="tour" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='tour') {echo ' selected';}} ?>>Tour Fees</option>
										</select></th>
										<th></th>
									</tr>
									<tr>
										<th>Address<span class="name">*</span></th>
										<th><input type="checkbox" name="p_address" <?php echo (isset($_POST['p_address']))?'checked':'';?>/></th>
										<th></th>
										<th></th>
									</tr>
									<tr>
										<th>Thana<span class="name">*</span></th>
										<th><input type="checkbox" name="p_thana" <?php echo (isset($_POST['p_thana']))?'checked':'';?>/></th>
										<th></th>
										<th></th>
									</tr>
									<tr>
										<th>Post<span class="name">*</span></th>
										<th><input type="checkbox" name="p_post" <?php echo (isset($_POST['p_post']))?'checked':'';?>/></th>
										<th></th>
										<th></th>
									</tr>
									<tr>
										<th>Tehsil<span class="name">*</span></th>
										<th><input type="checkbox" name="p_tehsil" <?php echo (isset($_POST['p_tehsil']))?'checked':'';?>/></th>
										<th></th>
										<th></th>
									</tr>
									<tr>
										<th>District<span class="name">*</span></th>
										<th><input type="checkbox" name="p_tehsil" <?php echo (isset($_POST['p_district']))?'checked':'';?>/></th>
										<th></th>
										<th></th>
									</tr>
									<tr>
										<th>State<span class="name">*</span></th>
										<th><input type="checkbox" name="p_state" <?php echo (isset($_POST['p_state']))?'checked':'';?>/></th>
										<th></th>
										<th></th>
									</tr>
									<tr >
										<th>From Date<span class="name">*</span></th>
										<th></th><th><script  type="text/javascript" language="javascript">
										document.writeln(DateInput('from_date', 'from_date', true, 'YYYY-MM-DD', '<?php if(isset($_POST['from_date'])){echo $_POST['from_date'];}else{echo date("Y-m-d"); } ?>', 2));
											</script></th>
										<th></th>
									</tr>
									<tr>
										<th>To Date<span class="name">*</span></th>
										<th></th><th>
										<script  type="text/javascript" language="javascript">
										document.writeln(DateInput('to_date', 'to_date', true, 'YYYY-MM-DD', '<?php if(isset($_POST['to_date'])){echo $_POST['to_date'];}else{echo date("Y-m-d"); } ?>', 2));
											</script></th>
											<th></th>
									</tr>
									<tr >
										<th>Photo<span class="name">*</span></th>										
										
										<th><input type="checkbox" name="photo" <?php echo (isset($_POST['photo']))?'checked':'';?>/></th>
										<th></th>
										<th></th>
									</tr>
									<tr>
										<th>Signature<span class="name">*</span></th>
										<th>
										<input type="checkbox" name="signature" <?php echo (isset($_POST['signature']))?'checked':'';?>/></th>
										<th></th>
										<th></th>
									</tr>
								</table>
							</div>
							<input type="submit" class="btn btn-success" name="save" value="Submit" />
						</div>
					</div>
				</form>	
			</div>
		</div>
	</div>



		<?php
		if(isset($_POST['stud_class'])){
			$sql = "select student_info.sno as serial, student_info.stu_name,student_info.father_name, student_info.mother_name,student_info.class,student_info.minority, student_info.physical_handicapped, student_info.sub1,student_info.sub2,student_info.sub3, 
			 (select subject from student_info_subject left join add_subject2 on add_subject2.sno = student_info_subject.subject_id where student_id=student_info.sno and subject_type=1) as minor,
			 (select add_subject2.sno from student_info_subject left join add_subject2 on add_subject2.sno = student_info_subject.subject_id where student_id=student_info.sno and subject_type=1) as minor_sno,
			 (select subject from student_info_subject left join add_subject2 on add_subject2.sno = student_info_subject.subject_id where student_id=student_info.sno and subject_type=2) as cocurricular,
			 (select add_subject2.sno from student_info_subject left join add_subject2 on add_subject2.sno = student_info_subject.subject_id where student_id=student_info.sno and subject_type=2) as cocurricular_sno,
			 (select subject from student_info_subject left join add_subject2 on add_subject2.sno = student_info_subject.subject_id where student_id=student_info.sno and subject_type=3) as vocational,
			 (select add_subject2.sno from student_info_subject left join add_subject2 on add_subject2.sno = student_info_subject.subject_id where student_id=student_info.sno and subject_type=3) as vocational_sno,
			student_info.dob,student_info.perm_address, student_info.temp_address, student_info.post, student_info.p_post, student_info.p_pin, student_info.p_district, student_info.p_state, student_info.pin, student_info.state, student_info.district, student_info.p_mobile, student_info.mobile, student_info.date_of_admission, student_info.gender, student_info.category, student_info.form_no, student_info.e_mail1, student_info.annual_income, student_info.other_univ,student_info.roll_no, student_info.aadhar, student_info.aadhar_type, student_info.university_uin, student_info.remarks, student_info.cancel_date, student_info.photo_id, student_info.signature_id, uin_data.aadhar as uin_aadhar from student_info left join fee_invoice on student_info.sno = fee_invoice.student_id left join uin_data on uin_data.student_id = student_info.sno and student_info.university_uin = uin_data.university_uin where student_info.status=2";
			//print_r($_POST);
			//echo $sql;
			if($_POST['stud_class']!='ALL'){
				$sql .= ' and student_info.class='.$_POST['stud_class'];
			}
			if($_POST['minority']!='ALL'){
				if($_POST['minority']=='NO'){
					$sql .= ' and student_info.minority IN ("NO", "")';
				}
				if($_POST['minority']=='YES'){
					$sql .= ' and student_info.minority="YES"';
				}						
			}
			if($_POST['physical_handicapped']!='ALL'){
				$sql .= ' and student_info.physical_handicapped="'.$_POST['physical_handicapped'].'"';
			}
			if($_POST['annual_income']!='ALL'){
				$sql .= ' and student_info.annual_income="'.$_POST['annual_income'].'"';
			}
			if($_POST['gender']!='ALL'){
				$sql .= ' and student_info.gender="'.$_POST['gender'].'"';
			}
			if($_POST['caste']!='ALL'){
				$sql .= ' and student_info.category="'.$_POST['caste'].'"';
			}
			if($_POST['other_univ']!='ALL'){
				$sql .= ' and student_info.other_univ="'.$_POST['other_univ'].'"';
			}
			if($_POST['state']!='ALL'){
				$sql .= ' and (student_info.p_state like "'.$_POST['state'].'" or student_info.state like "'.$_POST['state'].'")';
			}
			if($_POST['subject']!='ALL'){
				$sql .= ' and (student_info.sub1="'.$_POST['subject'].'" or student_info.sub2="'.$_POST['subject'].'" or student_info.sub3="'.$_POST['subject'].'" )';
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
				$sql .= ' and date_of_admission>="'.$_POST['from_date'].'" and date_of_admission<="'.$_POST['to_date'].'"';
			}
			else{
				$sql .= ' and counselling_date>="'.$_POST['from_date'].'" and counselling_date<="'.$_POST['to_date'].'"';
			}
			//echo $sql;
			$sql2 = "select student_info2.student_id as serial, student_info2.stu_name,student_info2.father_name,student_info2.mother_name,student_info2.class,student_info2.minority, student_info2.physical_handicapped, student_info2.sub1 , student_info2.sub2 , student_info2.sub3 , 
			(select subject from student_info_subject left join add_subject2 on add_subject2.sno = student_info_subject.subject_id where student_id=student_info2.student_id and subject_type=1) as minor,
			 (select add_subject2.sno from student_info_subject left join add_subject2 on add_subject2.sno = student_info_subject.subject_id where student_id=student_info2.student_id and subject_type=1) as minor_sno,
			 (select subject from student_info_subject left join add_subject2 on add_subject2.sno = student_info_subject.subject_id where student_id=student_info2.student_id and subject_type=2) as cocurricular,
			 (select add_subject2.sno from student_info_subject left join add_subject2 on add_subject2.sno = student_info_subject.subject_id where student_id=student_info2.student_id and subject_type=2) as cocurricular_sno,
			 (select subject from student_info_subject left join add_subject2 on add_subject2.sno = student_info_subject.subject_id where student_id=student_info2.student_id and subject_type=3) as vocational,
			 (select add_subject2.sno from student_info_subject left join add_subject2 on add_subject2.sno = student_info_subject.subject_id where student_id=student_info2.student_id and subject_type=3) as vocational_sno,	
			 student_info2.dob , student_info2.perm_address, student_info2.temp_address , student_info2.post, student_info2.p_post, student_info2.p_pin, student_info2.p_district, student_info2.p_state, student_info2.pin, student_info2.state, student_info2.district, student_info2.p_mobile, student_info2.mobile, student_info2.date_of_admission, student_info2.gender, student_info2.category,student_info2.form_no,student_info2.e_mail1, student_info2.annual_income,student_info2.other_univ , student_info2.roll_no , student_info2.aadhar, student_info2.aadhar_type, '' as university_uin, student_info2.remarks, student_info2.cancel_date, student_info2.photo_id, student_info2.signature_id, uin_data.aadhar as uin_aadhar from student_info2 left join fee_invoice on student_info2.student_id = fee_invoice.student_id left join uin_data on uin_data.student_id = student_info2.sno where student_info2.status=2";
			if($_POST['stud_class']!='ALL'){
				$sql2 .= ' and student_info2.class='.$_POST['stud_class'];
			}
			if($_POST['minority']!='ALL'){
				if($_POST['minority']=='NO'){
					$sql2 .= ' and student_info2.minority IN ("NO", "")';
				}
				if($_POST['minority']=='YES'){
					$sql2 .= ' and student_info2.minority="YES"';
				}
			}
			if($_POST['physical_handicapped']!='ALL'){
				$sql2 .= ' and student_info2.physical_handicapped="'.$_POST['physical_handicapped'].'"';
			}
			if($_POST['annual_income']!='ALL'){
				$sql2 .= ' and student_info2.annual_income="'.$_POST['annual_income'].'"';
			}
			if($_POST['other_univ']!='ALL'){
				$sql2 .= ' and student_info2.other_univ="'.$_POST['other_univ'].'"';
			}
			if($_POST['gender']!='ALL'){
				$sql2 .= ' and student_info2.gender="'.$_POST['gender'].'"';
			}
			if($_POST['state']!='ALL'){
				$sql2 .= ' and (student_info2.p_state like "'.$_POST['state'].'" or student_info2.state like "'.$_POST['state'].'")';
			}
			if($_POST['caste']!='ALL'){
				$sql2 .= ' and student_info2.category="'.$_POST['caste'].'"';
			}
			if($_POST['subject']!='ALL'){
				$sql2 .= ' and (student_info2.sub1="'.$_POST['subject'].'" or student_info2.sub2="'.$_POST['subject'].'" or student_info2.sub3="'.$_POST['subject'].'" )';
			}
			if($_POST['report_type']=='ALL'){
				$sql2 .= ' and fee_invoice.type="fees"';
			}
			if($_POST['report_type']=='sf'){
				$sql2 .= ' and fee_invoice.type="self"';
			}
			if($_POST['report_type']=='computer'){
				$sql2 .= ' and fee_invoice.type="computer"';
			}
			if($_POST['report_type']=='tour'){
				$sql2 .= ' and fee_invoice.type="tour"';
			}
			if($_POST['date_type']=='admit'){
				$sql2 .= ' and date_of_admission>="'.$_POST['from_date'].'" and date_of_admission<="'.$_POST['to_date'].'"';
			}
			else{
				$sql2 .= ' and counselling_date>="'.$_POST['from_date'].'" and counselling_date<="'.$_POST['to_date'].'"';
			}
			if($_POST['minor_subject']!='ALL' || $_POST['vocational']!='ALL'){
				$sql .= ' having ';
				$sql2 .= ' having ';
				$count=1;
				if($_POST['minor_subject']!='ALL'){
					$sql .= ' minor_sno='.$_POST['minor_subject'];
					$sql2 .= ' minor_sno='.$_POST['minor_subject'];
					$count++;
				}
				if($_POST['cocurricular']!='ALL'){
					if($count!=1){
						$sql .= ' and ';
						$sql2 .= ' and ';
					}
					$sql .= ' cocurricular_sno='.$_POST['cocurricular'];
					$sql2 .= ' cocurricular_sno='.$_POST['cocurricular'];
				}
				if($_POST['vocational']!='ALL'){
					if($count!=1){
						$sql .= ' and ';
						$sql2 .= ' and ';
					}
					$sql .= ' vocational_sno='.$_POST['vocational'];
					$sql2 .= ' vocational_sno='.$_POST['vocational'];
				}
			}
			
			$union='('.$sql.') union all ('.$sql2.') order by roll_no';
			//echo '<br/><br/>';
			//echo $sql;
			//echo '<br/><br/>';
			//echo $sql2;
			//echo '<br/><br/>';
			//echo $union;
			//echo '<br/><br/>';
			$result = execute_query(connect(), $union);
		?>
		
		
		
	<div class="card">
		<div class="card-body ">	
			<div class="col-md-12">
				<table width="100%" class="table table-striped table-hover rounded">
					<tr class="bg-primary text-white">
						<th>S.No.</th>
						<th>Course Name</th>
						<?php 
						if(isset($_POST['stu_name'])){
							echo '<th>Student Name</th>';
						}
						if(isset($_POST['father_name'])){
							echo '<th>Father Name</th>';
						}
						if(isset($_POST['mother_name'])){
							echo '<th>Mother Name</th>';
						}
					
						if(isset($_POST['minor'])){
							echo '<th>Minority</th>';
						}
						if(isset($_POST['physical_handicapped_switch'])){
							echo '<th>Physical Handicapped</th>';
						}
						if(isset($_POST['subjects'])){
							echo '<th>Subject 1</th><th>Subject 2</th><th>Subject 3</th>';
						}
						if(isset($_POST['minor_switch'])){
							echo '<th>Minor/Elective</th>';
						}
						if(isset($_POST['cocurricular_switch'])){
							echo '<th>Co-curricular</th>';
						}
						if(isset($_POST['vocational_switch'])){
							echo '<th>Vocational</th>';
						}
						if(isset($_POST['dob'])){
							echo '<th>Date Of Birth</th>';
						}
						if(isset($_POST['perm_address'])){
							echo '<th>Address</th>';
						}
						if(isset($_POST['state_check'])){
							echo '<th>State</th>';
						}
						if(isset($_POST['mobile'])){
							echo '<th>Mobile</th>';
							echo '<th>Mobile2</th>';
						}
						if(isset($_POST['gender1'])){
							echo '<th>Gender</th>';
						}
						if(isset($_POST['caste1'])){
							echo '<th>Category</th>';
						}
						if(isset($_POST['form_no'])){
							echo '<th>Form No.</th>';
						}
						if(isset($_POST['email1'])){
							echo '<th>Email</th>';
						}
						if(isset($_POST['identification'])){
							echo '<th>ID No.</th><th>ID Type</th>';
						}
						if(isset($_POST['roll_no'])){
							echo '<th>Roll No.</th>';
						}
						if(isset($_POST['uin'])){
							echo '<th>UIN No.</th>';
						}
						if(isset($_POST['view'])){
							echo '<th>View Scholar Details.</th>';
						}
						if(isset($_POST['income'])){
							echo '<th>Annual Income</th>';
						}
						if(isset($_POST['remarks'])){
							echo '<th>Remarks</th>';
						}
						if(isset($_POST['univ'])){
							echo '<th>University</th>';
						}
						if(isset($_POST['date1'])){
							echo '<th>Date Of Admission</th>';
						}
						if(isset($_POST['prev_qual'])){
							echo '<th>Prev. Qual.</th>';	
						}
						if(isset($_POST['signature'])){
							echo '<th>Signature</th>';	
						}
						if(isset($_POST['photo'])){
							echo '<th>Photo</th>';	
						}
						?>
					</tr>
				<?php
				$i=1;
				$tot_fees='';
				$print = '';
				while($row = mysqli_fetch_array($result)){
											
					if(fileExists("PHOTO/".$row['photo_id'])){
						$photo = fileExists("PHOTO/".$row['photo_id']);
						$sign = fileExists("PHOTO/".$row['signature_id']);
						//$photo = "PHOTO/".$stu_id['photo_id'];
						//$sign = "PHOTO/".$stu_id['signature_id'];
					}
					else{
						$photo = "PHOTO/".$row['serial'].'.jpg';
						$sign = "PHOTO/".$row['serial'].'_sign.jpg';
					}
					

					if($i%2==0){
						$col = '#CCC';
					}
					else{
						$col = '#EEE';
					}
					if($row['cancel_date']!=''){
						$col="#F00";
					}
					$course_name=get_class_detail($row['class']);
					$print .= '<tr style="background:'.$col.'">
						<td>'.$i++.'</td>
						<td>'.$course_name['class_description'].'</td>';
						if(isset($_POST['stu_name'])){
							$print .= '<td>'.$row['stu_name'].'</td>';
						}
						if(isset($_POST['father_name'])){
							$print .= '<td>'.$row['father_name'].'</td>';
						}
						if(isset($_POST['mother_name'])){
							$print .= '<td>'.$row['mother_name'].'</td>';
						}
					
						if(isset($_POST['minor'])){
							$print .= '<td>'.$row['minority'].'</td>';
						}
						if(isset($_POST['physical_handicapped_switch'])){
							$print .= '<td>'.$row['physical_handicapped'].'</td>';
						}
						if(isset($_POST['subjects'])){
							$print .= '<td>'.get_subject_detail($row['sub1'])['subject'].'</td>
								  <td>'.get_subject_detail($row['sub2'])['subject'].'</td>
								  <td>'.get_subject_detail($row['sub3'])['subject'].'</td>';
						}
						if(isset($_POST['minor_switch'])){
							$print .= '<td>'.$row['minor'].'</td>';
						}
						if(isset($_POST['cocurricular_switch'])){
							$print .= '<td>'.$row['cocurricular'].'</td>';
						}
						if(isset($_POST['vocational_switch'])){
							$print .= '<td>'.$row['vocational'].'</td>';
						}
						if(isset($_POST['dob'])){
							$print .= '<td>'.$row['dob'].'</td>';
						}
						if(isset($_POST['perm_address'])){
							/*'.strtoupper($row['temp_address']).', '.strtoupper($row['post']).', '.strtoupper($row['district']).', '.strtoupper($row['pin']).', '.strtoupper($row['state']).'.<br>*/
							$sql = 'select * from uin_data where student_id="'.$row['serial'].'" order by sno desc limit 1';
							$uin_data = execute_query(connect(), $sql);
							if(mysqli_num_rows($uin_data)==1){
								$uin_data = mysqli_fetch_assoc($uin_data);
								$print .= '<td>'.strtoupper($uin_data['p_house_no']).', '.strtoupper($uin_data['p_village']).', '.strtoupper($uin_data['p_post']).', '.strtoupper($uin_data['p_district']).', '.strtoupper($uin_data['p_state']).'</td>';
							}
							else{
								$print .= '<td>'.strtoupper($row['perm_address']).', '.strtoupper($row['p_post']).', '.strtoupper($row['p_district']).', '.strtoupper($row['p_pin']).', '.strtoupper($row['p_state']).'</td>';
							}								
						}
						if(isset($_POST['state_check'])){
							$print .= '<td>'.($row['state']==''?$row['p_state']:$row['state']).'</td>';
						}
						if(isset($_POST['mobile'])){
							$print .= '<td>'.$row['p_mobile'].'</td>';
							$print .= '<td>'.$row['mobile'].'</td>';
						}
						if(isset($_POST['gender1'])){
							$print .= '<td>'.$row['gender'].'</td>';
							}
						if(isset($_POST['caste1'])){
							$print .= '<td>'.$row['category'].'</td>';
						}
						if(isset($_POST['form_no'])){
							$print .= '<td>'.$row['form_no'].'</td>';
						}
						if(isset($_POST['email1'])){
							$print .= '<td>'.$row['e_mail1'].'</td>';
						}	
						if(isset($_POST['identification'])){
							if($row['aadhar']!=''){
								$print .= '<td>'.$row['aadhar'].'</td><td>'.$row['aadhar_type'].'</td>';
							}
							elseif($row['uin_aadhar']!=''){
								$print .= '<td>'.$row['uin_aadhar'].'</td><td>AADHAR</td>';
							}
							else{
								$print .= '<td></td><td></td>';
							}
						}	
						if(isset($_POST['roll_no'])){
							$print .= '<td>'.$row['roll_no'].'</td>';
						}
						if(isset($_POST['uin'])){
							$sql = 'select * from uin_data where student_id="'.$row['serial'].'" order by sno desc limit 1';
							$result_uin = execute_query(connect(), $sql);
							if(mysqli_num_rows($result_uin)!=0){
								$row_uin = mysqli_fetch_assoc($result_uin);
								$print .= '<td>'.$row_uin['university_uin2'].'</td>';	
							}
							else{
								$print .= '<td></td>';
							}
							
						}
						if(isset($_POST['view'])){
							$print .= '<td><a href="scholar_detail.php?id='.$row['serial'].'" >View</a></td>';
						}
						if(isset($_POST['income'])){
							$print .= '<td>'.$row['annual_income'].'</td>';
						}
						if(isset($_POST['univ'])){
							$print .= '<td>'.$row['other_univ'].'</td>';
						}
						if(isset($_POST['remarks'])){
							$print .= '<td>'.$row['remarks'].'</td>';
						}
						if(isset($_POST['date1'])){
							$print .= '<td>'.date("d-m-Y",strtotime($row['date_of_admission'])).'</td>';
						}
						if(isset($_POST['prev_qual'])){
							$sql = 'select * from qual_detail where student_id="'.$row['serial'].'" order by year desc limit 1';
							//$print .= $sql.'<br>';
							$qual = execute_query(connect(), $sql);
							if(mysqli_num_rows($qual)!=0){
								$qual = mysqli_fetch_array($qual);
								$print .= '<td>'.$qual['exam_name'].' - '.$qual['year'].' ('.$qual['univ_name'].'). Roll No.:'.$qual['roll_no'].'. Marks : '.$qual['obt_marks'].'/'.$qual['tot_marks'].' Status: '.$qual['status'];
							}
							else{
								$print .= '<td>&nbsp;</td>';
							}
						}
						if(isset($_POST['signature'])){
							$print .= '<td><img src="'.$sign.'" style="height:50px;"/></td>';
						}
						if(isset($_POST['photo'])){
							$print .= '<td><img src="'.$photo.'" style="height:50px;"/></td>';
						}
						
						$print .= '</tr>';
						}
					echo $print;
					?>
				</table>
			</div>
		</div>
	</div>


	<?php } 
	// $time_spent = time()-$start_time;
	// echo $time_spent;
	?>

		  
	<?php
	page_footer_start();
	page_footer_end();
	?>
</body>