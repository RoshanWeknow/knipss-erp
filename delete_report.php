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
page_header_end();
page_sidebar();
?>
<script type="text/javascript" language="javascript" src="form_validator.js"></script>
<div class="row">
	<div class="col-md-12 card card-body">
		<?php echo $msg; ?>   	
            <form action="delete_admission.php" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" >
                <h2>Delete <span class="orange">Admission</span> Report</h2>
				<div class="card">
					<div class="card-body">
            	
						
						<?php
							/*<li class="notranslate"><label  class="desc" for="name">Class<span class="name">*</span></label>
							<select name="stud_class">
								<option value="ALL">ALL</option>
								<?php
								$sql = 'select * from class_detail order by abs(sort_no)';
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
							</li>
							<li class="notranslate"><label  class="desc" for="name">Type<span class="name">*</span></label>
							<select name="report_type">
								<option value="ALL" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='ALL'){echo'selected';}}?>>ALL</option>
								<option value="admit" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='admit'){echo'selected';}}?>>Admitted</option>
								<option value="pending" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='pending'){echo'selected';}}?>>Fees Pending</option>
								<option value="sf" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='sf'){echo'selected';}}?>>Self Finanace</option>
								<option value="computer" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='computer'){echo'selected';}}?>>Computer Fees</option>
							</select>
							</li>
							<li class="notranslate"><label  class="desc" for="name">Date Type<span class="name">*</span></label>
							<select name="date_type">
								<option value="admit"<?php if(isset($_POST['date_type'])){if($_POST['date_type']=='admit'){echo'selected';}}?>>Admission Date</option>
								<option value="pending"<?php if(isset($_POST['date_type'])){if($_POST['date_type']=='pending'){echo'selected';}}?>>Counselling Date</option>
							</select>
							</li>
							<li class="notranslate"><label  class="desc" for="name">From Date<span class="name">*</span></label>
							<div>
							<script type="text/javascript" language="javascript">
								DateInput('from_date', false, 'YYYY-MM-DD', '<?php if(isset($_POST['from_date'])){echo $_POST['from_date'];}
								else{echo date("Y-m-d"); $_POST['from_date']=date("Y-m-d");} ?>')
							</script>
							</div>
							</li>
							<li class="notranslate"><label  class="desc" for="name">To Date<span class="name">*</span></label>
							<div>
							<script type="text/javascript" language="javascript">
								DateInput('to_date', false, 'YYYY-MM-DD', '<?php if(isset($_POST['to_date'])){echo $_POST['to_date'];}
								else{echo date("Y-m-d"); $_POST['to_date']=date("Y-m-d");} ?>')
							</script>
							</div>
							</li>
						<div><input type="submit" class="btTxt submit" name="save" value="Submit" style=" margin-top:0px; margin-left:25px;"/></div> 
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
							}*/
							$sql = 'select * from roll_no join class_detail on class_detail.sno = roll_no.class where date_of_deletion is not null';
							//echo $sql;
							$result = execute_query(connect(), $sql);
						?>
							<div class="card">
								<table width="100%" class="table table-striped table-hover rounded">
									<tr class="bg-primary text-white ">
										<th>S.No.</th>
										<th>Student Name</th>
										<th>Father's Name</th>
										<th>Class</th>
										 <th>Form No</th>
										<th>Roll No</th>
										<th>Date Of Admission</th>
										<th>Date of Deletion</th>
									</tr>
									<?php
									$i=1;
									$tot_fees='';
									while($row = mysqli_fetch_array($result)){
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
										<td>'.$row['roll_no'].'</td>
										<td>'.$row['date_of_admission'].'</td>
										<td>'.$row['date_of_deletion'].'</td>
										</tr>';
										}
									?>
								</table>
							</div>
						
					</div>
				</div>
			</form>
	</div>
</div>
<?php
page_footer_start();
page_footer_end();
?>