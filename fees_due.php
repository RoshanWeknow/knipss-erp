<?php
//set_time_limit(0);
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
function stu_ledger() {
	window.open("stu_ledger_print.php");
}
</script>
<body id="public">
	<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">    	
				<form action="fees_due.php" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" >
					<h2> Students Pending Fees </h2>
					<div class="col-md-12">
						<div class="row">							
							<div class="col-md-4">							
								<label>Class<span class="name">*</span></label>
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
								</select>
							</div>
							<div class="col-md-4">							
								<label>Gender<span class="name">*</span></label>
								<select name="gender" class="form-control">
									<option value="ALL" <?php if(isset($_POST['gender'])){if($_POST['gender']=='All') {echo ' selected';}} ?>>ALL</option>
									<option value="M" <?php if(isset($_POST['gender'])){if($_POST['gender']=='M') {echo ' selected';}} ?>>Male</option>
									<option value="F" <?php if(isset($_POST['gender'])){if($_POST['gender']=='F') {echo ' selected';}} ?>>Female</option>
								</select>
							</div>
							<div class="col-md-4">							
								<label>Caste<span class="name">*</span></label>
								<select name="caste" class="form-control">
									<option value="ALL" <?php if(isset($_POST['category'])){if($_POST['category']=='ALL') {echo ' selected';}} ?>>ALL</option>
									<option value="GEN" <?php if(isset($_POST['category'])){if($_POST['category']=='GEN') {echo ' selected';}} ?>>GENERAL</option>
									<option value="OBC" <?php if(isset($_POST['category'])){if($_POST['category']=='OBC') {echo ' selected';}} ?>>OBC</option>
									<option value="SC" <?php if(isset($_POST['category'])){if($_POST['category']=='SC') {echo ' selected';}} ?>>SC</option>
									<option value="ST" <?php if(isset($_POST['category'])){if($_POST['category']=='ST') {echo ' selected';}} ?>>ST</option>
								</select>
							</div>
						</div>
						<div class="row">							
							<div class="col-md-4">							
								<label>Select Subject 1<span class="alert">*</span></label>
								<select name="subject" class="form-control" id="subject" >
										<option value="" selected="selected"></option>
										<?php
										$sql = 'select * from add_subject';
										$res = execute_query(connect(), $sql);
										while($row = mysqli_fetch_array($res)) {
											echo '<option value="'.$row['sno'].'">'.$row['subject'].'</option> ';
										}
										?>
								 </select>
							</div>
							<div class="col-md-4">							
								<label>Select Subject 2<span class="alert">*</span></label>
								<select name="subject2" class="form-control" id="subject" >
										<option value="" selected="selected"></option>
										<?php
										$sql = 'select * from add_subject';
										$res = execute_query(connect(), $sql);
										while($row = mysqli_fetch_array($res)) {
											echo '<option value="'.$row['sno'].'">'.$row['subject'].'</option> ';
										}
										?>
								 </select>
							</div>
							<div class="col-md-4">							
								<label>Select Subject 3<span class="alert">*</span></label>
								<select name="subject3" class="form-control" id="subject" >
									<option value="" selected="selected"></option>
									<?php
									$sql = 'select * from add_subject';
									$res = execute_query(connect(), $sql);
									while($row = mysqli_fetch_array($res)) {
										echo '<option value="'.$row['sno'].'">'.$row['subject'].'</option> ';
									}
									?>
								</select>
							</div>
						</div>
						<div class="row">							
							<div class="col-md-4">							
								<label>Date Type<span class="name">*</span></label>
								<select name="date_type" class="form-control">
									<option value="admit" <?php if(isset($_POST['date_type'])){if($_POST['date_type']=='admit') {echo ' selected';}} ?>>Admission Date</option>
									<option value="pending" <?php if(isset($_POST['date_type'])){if($_POST['date_type']=='pending') {echo ' selected';}} ?>>Counselling Date</option>
								</select>
							</div>
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
						
					</div> 
						<input type="submit" class="btn btn-primary submit" name="save" value="Submit" />	
						<input type="button" name="student_ledger" class="btn btn-danger" onClick="return stu_ledger()" style="float: right;" value="Print">
				 </form>
			</div>
		</div> 


				<?php
				if(isset($_POST['stud_class'])){
					$sql = "(select student_info.sno as sno, stu_name, father_name,mother_name,gender,date_of_admission,student_info.category,class, sub1, sub2, sub3, form_no, roll_no, tot_amount, class_description, cancel_date, remarks, annual_income, fee_invoice.sno as fees_serial, '1' as info from student_info join fee_invoice on student_info.sno = fee_invoice.student_id join class_detail on class_detail.sno = student_info.class  where 1=1";
					if($_POST['stud_class']!='ALL'){
						$sql .= ' and class='.$_POST['stud_class'];
					}
					if($_POST['gender']!='ALL'){
						$sql .= ' and student_info.gender="'.$_POST['gender'].'"';
					}
					if($_POST['caste']!='ALL'){
						$sql .= ' and student_info.category="'.$_POST['caste'].'"';
					}
					if($_POST['subject']!=''){
						$sql .= ' and ( student_info.sub1="'.$_POST['subject'].'" or student_info.sub2="'.$_POST['subject'].'" or student_info.sub3="'.$_POST['subject'].'" )';
					}
					if($_POST['subject2']!=''){
						$sql .= ' and ( student_info.sub1="'.$_POST['subject2'].'" or student_info.sub2="'.$_POST['subject2'].'" or student_info.sub3="'.$_POST['subject2'].'" )';
					}
					if($_POST['subject3']!=''){
						$sql .= ' and ( student_info.sub1="'.$_POST['subject3'].'" or student_info.sub2="'.$_POST['subject3'].'" or student_info.sub3="'.$_POST['subject3'].'" )';
					}
					if($_POST['date_type']=='admit'){
						$sql .= ' and FROM_UNIXTIME(timestamp)>="'.$_POST['from_date'].' 00:00:00" and FROM_UNIXTIME(timestamp)<="'.$_POST['to_date'].' 23:59:59"';
					}
					else{
						$sql .= ' and counselling_date>="'.$_POST['from_date'].'" and counselling_date<="'.$_POST['to_date'].'"';
					}
					$sql .= ') union all(select student_info2.student_id as sno, stu_name, father_name,mother_name,gender,date_of_admission,student_info2.category,class,sub1, sub2, sub3, form_no, roll_no, tot_amount, class_description, cancel_date, remarks, annual_income, fee_invoice3.sno as fees_serial, "2" as info from student_info2 join fee_invoice3 on student_info2.student_id = fee_invoice3.student_id join class_detail on class_detail.sno = student_info2.class where class in (61, 63, 65, 67, 69, 71, 73, 75, 77, 79, 81)';
					if($_POST['stud_class']!='ALL'){
						$sql .= ' and class='.$_POST['stud_class'];
					}
					if($_POST['gender']!='ALL'){
						$sql .= ' and student_info2.gender="'.$_POST['gender'].'"';
					}
					if($_POST['caste']!='ALL'){
						$sql .= ' and student_info2.category="'.$_POST['caste'].'"';
					}
					if($_POST['subject']!=''){
						$sql .= ' and (student_info2.sub1="'.$_POST['subject'].'" or student_info2.sub2="'.$_POST['subject'].'" or student_info2.sub3="'.$_POST['subject'].'" )';
					}
					
					if($_POST['date_type']=='admit'){
						$sql .= ' and FROM_UNIXTIME(timestamp)>="'.$_POST['from_date'].' 00:00:00" and FROM_UNIXTIME(timestamp)<="'.$_POST['to_date'].' 23:59:59"';
					}
					else{
						$sql .= ' and counselling_date>="'.$_POST['from_date'].'" and counselling_date<="'.$_POST['to_date'].'"';
					}
					
					$sql .= ')';
					//echo $sql;
					$_SESSION['sql']="$sql";
					$result = execute_query(connect(), $sql);
                ?>
					
		<div class="card card-body">
			<table width="100%" class="table table-striped table-hover rounded">
				<tr class="table-primary ">
						<th>S.No.</th>
						<th>Roll No</th>
						<th>Student Name</th>
						<th>Father's Name</th>
						<th>Admission Date</th>
						<th>Gender</th>
						<th>Cat</th>
						<th>Sub 1</th>
						<th>Sub 2</th>
						<th>Sub 3</th>
						<th>Fees(I)</th>
						<th>Pending Fees(II)</th>
                    </tr>
					<?php
                    $i=1;
                    $tot_fees='';
					$tot_pending=0;
					$admission_date='';
                    while($row = mysqli_fetch_array($result)){
						$remarks=$row['remarks'];
						$admission_date=$row['date_of_admission'];
						$sql='select * from fee_invoice3 where student_id='.$row['sno'].' and type="fees"';
						$fees_second=execute_query(connect(), $sql);
						if(mysqli_num_rows($fees_second)==0){
							if($row['info']==1){
								$sql = "select student_info2.sno as stu_id, student_info2.student_id as sno, stu_name, father_name,mother_name,gender,date_of_admission,student_info2.category,class,sub1, sub2, sub3, form_no, roll_no, tot_amount, class_description, fee_invoice.sno as fees_serial, remarks, cancel_date, annual_income from student_info2 join fee_invoice on student_info2.student_id = fee_invoice.student_id join class_detail on class_detail.sno = student_info2.class where student_info2.student_id=".$row['sno'];
								//echo $sql.'<br>';
								if($_POST['subject']!=''){
									$sql .= ' and (student_info2.sub1="'.$_POST['subject'].'" or student_info2.sub2="'.$_POST['subject'].'" or student_info2.sub3="'.$_POST['subject'].'" )';
								}
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
								$fee2 = mysqli_fetch_array(execute_query(connect(), $sql));
								$row['tot_amount'] += $fee2['tot_amount'];

							}
							if($row['cancel_date']!=''){
								$col="#F00";
							}
							if($row['category']=='GEN' || $row['category']=='OBC'){
								$second_install=calc_second_fees_gen($row['class'],$row['sub1'],$row['sub2'],$row['sub3'],$row['gender'],$row['category']);
							}
							else{
								if($row['annual_income']>1){
									$second_install=calc_second_fees_gen($row['class'],$row['sub1'],$row['sub2'],$row['sub3'],$row['gender'],$row['category']);
								}
								else{
									$second_install=calc_second_fees_sc($row['class'],$row['sub1'],$row['sub2'],$row['sub3'],$row['gender'],$row['category']);
								}
							}

							
							//print_r($row);
							echo '<tr style="background:'.$col.'">
							<td>'.$i++.'</td>
							<td>'.$row['roll_no'].'</td>
							<td>'.$row['stu_name'].'</td>
							<td>'.$row['father_name'].'</td>
							<td>'.date("d-m-Y", strtotime($admission_date)).'</td>
							<td>'.$row['gender'].'</td>
							<td>'.$row['category'].'</td>
							<td>'.substr(get_subject_detail($row['sub1'])['subject'],0,3).'</td>
							<td>'.substr(get_subject_detail($row['sub2'])['subject'],0,3).'</td>
							<td>'.substr(get_subject_detail($row['sub3'])['subject'],0,3).'</td>
							<td>'.$row['tot_amount'].'</td>
							<td>'.$second_install.'</td>
							<td><a href="edit_admission.php?id='.$row['sno'].'">Details</a></td></tr>';
							$tot_fees+=$row['tot_amount'];
							$tot_pending+=$second_install;

						}
					}
					echo '<tr><th colspan="10"></th><th>'.$tot_fees.'</th><th>'.$tot_pending.'</th><th></th></tr>';
                    ?>
                    </table></div></div>
                    <?php } ?>
                    </ul>
                </form>
 		</div>
      </div>
<?php
page_footer_start();
page_footer_end();
?>