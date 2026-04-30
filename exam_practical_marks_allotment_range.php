<?php
include("scripts/settings.php");
include("scripts/settings_dbase_uin.php");
$msg='';
$tab=1;
$response = 1;
page_header_start();
page_header_end();
page_sidebar();
?>

<?php
	if(isset($_POST['submit'])){
		$ins_sql = 'INSERT INTO `exam_practical_allotment_invoice`(`paper`, `int_examiner`, `ext_examiner`, `max_marks`, `student_count`, `alloted_stu_count`, `exam_date`, `batch`, `created_by`, `creation_time`) VALUES("'.$_POST['paper'].'",
							"'.$_POST['examiner'].'",
							"'.$_POST['v_auth'].'",
							"'.$_POST['max_marks'].'",
							"'.$_POST['stu_count'].'",
							"'.$_POST['allot_stu'].'",
							"'.$_POST['pt_date'].'",
							"'.$_POST['p_batch'].'",
							"'.$_SESSION['username'].'",
							"'.date("d-m-y H:i:s").'")';
		//echo $ins_sql;					
		$ins_res = mysqli_query($db, $ins_sql);
		$pract_allot_sno = mysqli_insert_id($db);
		
		for($a=1;$a<=$_POST['allot_stu'];$a++){
			if(!isset($_POST['obt_marks'.$a])){
				continue;
			}
			$update_sql = "UPDATE exam_student_paper_info SET 
			pt_marks_max='" .$_POST['max_marks']."',
			pt_marks_obt='" .$_POST['obt_marks'.$a]."',
			teacher_internal='" .$_POST['examiner']."',
			verifier_external='" .$_POST['v_auth']."',
			practicle_allotment='$pract_allot_sno'
			WHERE sno='" .$_POST['exam_stu_id'.$a]. "'";
			//echo $update_sql;	
			$result = mysqli_query($db, $update_sql);
			if(mysqli_errno($db)){
				$msg =  "Insertion failed: ".mysqli_errno($db).mysqli_error($db);
				$msg ="<h5 class='alert alert-danger'>Error In Marks Submit!</h5>";
				
			}
			else{
				$msg = "<h5 class='alert alert-success'>Marks Succesfully Submitted</h5>";
			}	
		}
	}
?>
		<div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center"></h4></br>
						<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" id="" name="">
					<?php echo $msg; ?> 
                    <div class="col-md-12">
						<h2 class="bg-primary text-white p-2">Practical Marks Feed</h2>
				        <!-- first row -->
                        <div class="row">
							 <div class=" col-md-4 ">
							
								<label>Paper</label>
								<input list="brow"  name="paper" id="paper" value="<?php echo (isset($_POST['save']))? $_POST['paper']:''; ?>" class="form-control">
								<datalist id="brow">
									<?php 
									$sql  = 'SELECT count(*) c, title_of_paper, paper_code FROM `add_subject_details` where theory_practical = "Practical" group by paper_code order by paper_code';
									$dept_list = execute_query($db,$sql);
									if($dept_list){
										while($list = mysqli_fetch_assoc($dept_list)){
											echo '<option  value = "'.$list['paper_code'].'">'.$list['paper_code'].' - '.$list['title_of_paper'].'</option>';
										}
									}
									?>
								</datalist>  
							</div>
						<div>
							<button type="submit" name = "save" value="save" class="btn btn-warning mt-2 ms-2">Search</button> 
							<!--<input type="reset"  value="Reset" class="btn btn-danger mt-2 ms-5" /> -->
						</div>
					</div>
					<?php
					if(isset($_POST['save']) || isset($_POST['search'])){
						$sql = 'select Count(*) stu_c from exam_student_paper_info where paper_code = "'.$_POST['paper'].'" AND practicle_allotment = "0"';
						//echo $sql;
						 $res = mysqli_fetch_assoc(mysqli_query($db, $sql));
						//echo $res['stu_c'];
						
						$sql_ex_scheme = 'select * from exam_examination_scheme where paper_code = "'.$_POST['paper'].'"';
						$result_ex_scheme = mysqli_fetch_assoc(mysqli_query($db, $sql_ex_scheme));
					
					?>
					 <div class="row">
						<div class=" col-md-3 ">
							<label>Practical Date<span style="color:red;">*</span></label>
							<input type ="date" name="pt_date" id="pt_date"  class="form-control" required>
						</div>
						<div class=" col-md-3 ">
							<label>Batch</label>
							<select name="p_batch" id="p_batch" class="form-control" required>
								<option selected disabled>--Select Batch--</option>
								<option value="A">A</a>
								<option value="B">B</a>
								<option value="C">C</a>
								<option value="D">D</a>
							</select>
						</div>	
						<div class=" col-md-3 ">
							<label>Internal Examiner</label>
							<!--<input name="examiner" id="examiner" class="form-control " value="<?php // echo (isset($_POST['search']))?$_POST['examiner']:''; ?>" required>-->
							<select name="examiner" id="examiner" class="form-control "  required>
								<option selected disabled>---Select Internal Examiner---</option>
								<?php
									$sql_examiner = 'select * from exam_examiner_info';
									$res_examiner = mysqli_query($db, $sql_examiner);
									while($row_examiner=mysqli_fetch_assoc($res_examiner)){
								?>
										<option value="<?php echo $row_examiner['sno']; ?>"><?php echo $row_examiner['name']; ?></option>
								<?php
									}
								?>
							</select>
						</div>
						<div class=" col-md-3 ">
							<label>External Examiner</label>
							<!--<input name="v_auth" id="v_auth" class="form-control " value="<?php //echo (isset($_POST['search']))?$_POST['v_auth']:''; ?>" required>-->
							<select name="v_auth" id="v_auth" class="form-control "  required>
								<option selected disabled>---Select External Examiner---</option>
								<?php
									$sql_examiner_ex = 'select * from exam_examiner_info';
									$res_examiner_ex = mysqli_query($db, $sql_examiner_ex);
									while($row=mysqli_fetch_assoc($res_examiner_ex)){
								?>
										<option value="<?php echo $row['sno']; ?>"><?php echo $row['name']; ?></option>
								<?php
									}
								?>
							</select>
						</div>
					</div>	
					 <div class="row">	
						<div class=" col-md-3 ">
							<label>Maximum Marks</label>
					<input name="max_marks" id="max_marks" value="<?php echo (isset($_POST['search']))?$_POST['max_marks']:''; ?>" class="form-control" required>
						</div>	
						<div class=" col-md-3 ">
							<label>No. Of Students</label>
							<input name="stu_count" id="stu_count" value="<?php echo $res['stu_c']; ?>" readonly class="form-control" required>
						</div>	
						<div class=" col-md-3 ">
							<label>No. Of Alloted Student<span style="color:red;">*</span></label>
							<input  name="allot_stu" id="allot_stu" value="<?php echo (isset($_POST['search']))?$_POST['allot_stu']:''; ?>" class="form-control" required readonly>
						</div>	
						
						
					</div>
					
					<div class="row">
				
						<div class=" col-md-6 ">
							<label><b>ADD Roll Number Range :</b></label>
							<div class="btn btn-success" onclick="addInputBox()">Add</div>
							
							<div id="inputContainer">
							</div>
						</div>
					</div>
					<input type="hidden" id="Ccount" name="ccount">
					<button type="submit" name = "search" value="search" class="btn btn-primary mt-2 ms-2">SEARCH</button> 
						<a href="exam_theory_marks_allotment_report.php" target="_blank">View Report</a>
					
					<script>
						let ccount = document.getElementById("Ccount");
						var i = 0;

						function addInputBox() {
							i++;

							// Create a new input element with form-control class
							var index = document.createElement('span');
							index.innerText = i + ".";

							var newInput = document.createElement('input');
							newInput.type = 'text';
							newInput.className = 'form-control';
							newInput.placeholder = 'Enter From Roll';
							newInput.name = 'fromroll' + i;

							var newInput2 = document.createElement('input');
							newInput2.type = 'text';
							newInput2.className = 'form-control';
							newInput2.name = 'toroll' + i;
							newInput2.placeholder = 'Enter to Roll';

							var newInput3 = document.createElement('input');
							newInput3.type = 'text';
							newInput3.className = 'form-control';
							newInput3.name = 'totalCount' + i;
							newInput3.placeholder = 'Enter Total Student Count';
							newInput3.addEventListener('input', updateAllotedStudentCount);

							// Create a new div container for the input element
							var newInputContainer = document.createElement('div');
							newInputContainer.className = 'input-container d-flex gap-3 my-2';
							newInputContainer.appendChild(index);
							newInputContainer.appendChild(newInput);
							newInputContainer.appendChild(newInput2);
							newInputContainer.appendChild(newInput3);

							// Append the new input container to the main container
							document.getElementById('inputContainer').appendChild(newInputContainer);
							ccount.value = i;

							updateAllotedStudentCount(); // Initial update
						}

						function updateAllotedStudentCount() {
							let totalAllotedStudents = 0;

							// Loop through all the totalCount input boxes and sum their values
							for (let j = 1; j <= i; j++) {
								let totalCountInput = document.querySelector('input[name="totalCount' + j + '"]');
								if (totalCountInput) {
									let totalCountValue = parseInt(totalCountInput.value) || 0;
									totalAllotedStudents += totalCountValue;
								}
							}

							// Update the No. Of Alloted Student input box
							let allotStuInput = document.getElementById('allot_stu');
							if (allotStuInput) {
								allotStuInput.value = totalAllotedStudents;
							}
						}
					</script>
			   </form>
                    </div>
					
<?php
					}
?>
			<?php 
			if(isset($_POST['search'])){
				if($_POST['stu_count'] >= $_POST['allot_stu']){
			?>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" id="" onsubmit="return showAlert()">	
					<input type="hidden" name="paper" value="<?php echo $_POST['paper']; ?>">			
					<input type="hidden" name="examiner" value="<?php echo $_POST['examiner']; ?>">			
					<input type="hidden" name="v_auth" value="<?php echo $_POST['v_auth']; ?>">			
					<input type="hidden" name="max_marks" value="<?php echo $_POST['max_marks']; ?>">			
					<input type="hidden" name="stu_count" value="<?php echo $_POST['stu_count']; ?>">			
					<input type="hidden" name="allot_stu" value="<?php echo $_POST['allot_stu']; ?>">			
					<input type="hidden" name="pt_date" value="<?php echo $_POST['pt_date']; ?>">			
					<input type="hidden" name="p_batch" value="<?php echo $_POST['p_batch']; ?>">			
					<table class='table table-hover table-stripped'><tr class='bg-primary text-white'>
					<td>Select Student</td>
					<td>Sno</td>
					<td>Student NAME</td>
					<td>Roll No.</td> 
					<td>Paper</td>
					<td>Maximum Marks</td>
					<td>Obtained Marks</td>
					</tr>
				<?php
					$c = 1;
					for($i=1;$i<=$_POST['ccount'];$i++){
						$stu_allot = 'SELECT *,exam_student_paper_info.sno as id FROM `exam_student_paper_info` LEFT JOIN exam_student_info on exam_student_info_sno=exam_student_info.sno WHERE paper_code="'.$_POST['paper'].'" AND exam_roll_no BETWEEN "'.$_POST['fromroll'.$i].'" AND "'.$_POST['toroll'.$i].'" AND practicle_allotment="0" ORDER BY exam_roll_no'; 
						//echo $stu_allot;
						$result =execute_query($db,$stu_allot);
						$j=1;
						while($row=mysqli_fetch_assoc($result)){
				?>
					<tr>
						<td><input type="checkbox" id="stu_check<?php echo $c; ?>" name="stu_check<?php echo $c; ?>"  checked></td>
						<td><?php echo $c;?></td>
						<td><?php echo $row['student_name'];?></td>
						<td><?php echo $row['exam_roll_no'] ;?></td>
						<td><?php echo $row['paper_code'] ;?></td>
						<td><input type="text" name="max_marks" value="<?php echo $_POST['max_marks']; ?>" class="form-control" readonly></td>
						<td><input type="text" name="obt_marks<?php echo $c; ?>" id="obt_marks<?php echo $c; ?>" value="" tabindex="1" class="form-control" ></td>
						<input type="hidden" name="exam_stu_id<?php echo $c++; ?>" value="<?php echo $row['id']; ?>" class="form-control" readonly>
					</tr>
				<?php
						}
					}
				echo "</table>";
				?>
				<script>
					
					let totalLoop = <?php echo --$c ?>;
					//console.log(totalLoop);

					for (let i = 1; i <= totalLoop; i++) {
					let checkbox = document.getElementById('stu_check' + i);
					let inputBox = document.getElementById('obt_marks' + i);

					checkbox.addEventListener('change', function () {
					// When the checkbox is clicked
					if (checkbox.checked) {
						// If the checkbox is checked, enable the respective input box
						inputBox.disabled = false;
					} else {
						// If the checkbox is unchecked, disable and clear the respective input box
						inputBox.disabled = true;
						inputBox.value = '';
					}
					});
					}
				</script>
				 <div style="display:flex;justify-content:flex-end;">
					  <button class="btn btn-primary" value="submit" name="submit" type="submit">submit</button></td>
					  <script>
						function showAlert() {
							// Display an alert
							alert("Are you sure you want to submit?");

							// Return false to prevent the form from being submitted
							return true;
						}
					 </script>
				 </div>
			</form>		 
<?php				
}
else{
	echo "<h5 class='alert alert-danger'>Alloted Students is more then remaining students</h5>";
}
	}
page_footer_start();
?>

    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="js/light-bootstrap-dashboard.js?v=1.4.0"></script>
<?php		
page_footer_end();
?>