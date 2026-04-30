<?php
include("scripts/settings.php");
include("scripts/settings_dbase_uin.php");
$msg='';
$tab=1;
$response = 1;
page_header_start();
page_header_end();
page_sidebar();
	if(isset($_POST['submit'])){
		$ins_sql = 'INSERT INTO `theory_marks_allotment`(`paper`, `examiner`, `v_auth`, `max_marks`, `stu_count`, `allot_stu`, `created_by`, `creation_time`, `checking_date`) VALUES("'.$_POST['paper'].'", "'.$_POST['examiner'].'", "'.$_POST['v_auth'].'", "'.$_POST['max_marks'].'", "'.$_POST['stu_count'].'", "'.$_POST['allot_stu'].'", "'.$_SESSION['username'].'", "'.date("Y-m-d H:i:s").'", "'.$_POST['checking_date'].'")';
		//echo $ins_sql;					
		$ins_res = mysqli_query($db, $ins_sql);
		$pract_allot_sno = mysqli_insert_id($db);
			for($a=1;$a<=$_POST['allot_stu'];$a++){
			if(!isset($_POST['obt_marks'.$a])){
				continue;
			}
			if($_POST['exam_stu_type'.$a]=='Regular'){
			    $update_sql = "UPDATE exam_student_paper_info SET 
					pt_marks_max='" .$_POST['max_marks']."',
					pt_marks_obt='" .$_POST['obt_marks'.$a]."',
					teacher_internal='" .$_POST['examiner']."',
					verifier_external='" .$_POST['v_auth']."',
					practicle_allotment='$pract_allot_sno'
					WHERE sno='" .$_POST['exam_stu_id'.$a]. "'";
			    
			}
			elseif($_POST['exam_stu_type'.$a]=='Supplementary' || $_POST['exam_stu_type'.$a]=='Back-Paper' || $_POST['exam_stu_type'.$a]=='Ex-Student'){
			   $update_sql = "UPDATE back_exam_student_paper_info SET 
					pt_marks_max='" .$_POST['max_marks']."',
					pt_marks_obt='" .$_POST['obt_marks'.$a]."',
					teacher_internal='" .$_POST['examiner']."',
					verifier_external='" .$_POST['v_auth']."',
					practicle_allotment='$pract_allot_sno'
					WHERE sno='" .$_POST['exam_stu_id'.$a]. "'";
			}
			//echo $update_sql.'<br>';	
			$result = mysqli_query($db, $update_sql);
			if(mysqli_error($db)){
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
						<h2 class="bg-primary text-white p-2">Theory Marks Feed</h2>
				        <!-- first row -->
                        <div class="row">
							 <div class=" col-md-4 ">
							
								<label>Paper</label>
								<input list="brow"  name="paper" id="paper" value="<?php echo (isset($_POST['save']))? $_POST['paper']:''; ?>" class="form-control">
								<datalist id="brow">
									<?php 
									$sql  = 'SELECT count(*) c, title_of_paper, paper_code FROM `add_subject_details` where theory_practical = "Theory" group by paper_code order by paper_code';
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
					// if(isset($_POST['save']) || isset($_POST['search'])){
						// $sql = 'select Count(*) stu_c from exam_student_paper_info where paper_code = "'.$_POST['paper'].'" AND practicle_allotment = "0"';
						//echo $sql;
						 // $res = mysqli_fetch_assoc(mysqli_query($db, $sql));
						//echo $res['stu_c'];
						
						// $sql_ex_scheme = 'select * from exam_examination_scheme where paper_code = "'.$_POST['paper'].'"';
						// $result_ex_scheme = mysqli_fetch_assoc(mysqli_query($db, $sql_ex_scheme));
					
					?>
					<?php
					if(isset($_POST['save']) || isset($_POST['search'])){
						$sql = 'select Count(*) stu_c from exam_student_paper_info where paper_code = "'.$_POST['paper'].'" AND mid_sem_allotment = "0"';
						
						$sql = 'SELECT 
								COUNT(*) AS stu_c,
								t2.sno AS id,
								t2.exam_roll_no,
								t2.student_type,
								t2.student_name,
								t2.practicle_allotment,
								t2.paper_code,
								t2.title_of_paper
							FROM (
								SELECT 
									back_exam_student_paper_info.sno,
									back_exam_student_info.exam_roll_no,
									back_exam_student_info.student_type,
									back_exam_student_info.student_name,
									back_exam_student_paper_info.practicle_allotment,
									back_exam_student_paper_info.paper_code,
									back_exam_student_paper_info.title_of_paper
								FROM 
									back_exam_student_paper_info
								LEFT JOIN 
									back_exam_student_info
								ON 
									back_exam_student_info.sno = back_exam_student_paper_info.exam_student_info_sno
								WHERE 
									paper_code = "'.$_POST['paper'].'" 
									AND practicle_allotment = "0"

								UNION ALL

								SELECT 
									exam_student_paper_info.sno,
									exam_student_info.exam_roll_no,
									exam_student_info.student_type,
									exam_student_info.student_name,
									exam_student_paper_info.practicle_allotment,
									exam_student_paper_info.paper_code,
									exam_student_paper_info.title_of_paper
								FROM 
									exam_student_paper_info
								LEFT JOIN 
									exam_student_info
								ON 
									exam_student_info.sno = exam_student_paper_info.exam_student_info_sno
								WHERE 
									paper_code = "'.$_POST['paper'].'" 
									AND practicle_allotment = "0"
							) AS t2
							ORDER BY 
								t2.exam_roll_no';

						//echo $sql;
						 $res = mysqli_fetch_assoc(mysqli_query($db, $sql));
						//echo $res['stu_c'];
						
						$sql_ex_scheme = 'select * from exam_examination_scheme where paper_code = "'.$_POST['paper'].'"';
						$result_ex_scheme = mysqli_fetch_assoc(mysqli_query($db, $sql_ex_scheme));
					
					?>
					 <div class="row">			
						<div class=" col-md-3 ">
							<label>Copy Checking Date</label>
							<input type="date" name="checking_date" id="checking_date" class="form-control " value="<?php echo (isset($_POST['search']))?$_POST['checking_date']:''; ?>" required>
						</div>
						<div class=" col-md-3 ">
							<label>Examiner</label>
							<input name="examiner" id="examiner" class="form-control " value="<?php echo (isset($_POST['search']))?$_POST['examiner']:''; ?>" required>
						</div>
						<div class=" col-md-3 ">
							<label>Verifier Authority</label>
							<input name="v_auth" id="v_auth" class="form-control " value="<?php echo (isset($_POST['search']))?$_POST['v_auth']:''; ?>" required>
						</div>
						<div class=" col-md-3 ">
							<label>Maximum Marks</label>
					<input name="max_marks" id="max_marks" value="<?php echo (isset($_POST['search']))?$_POST['max_marks']:''; ?>" class="form-control" required>
						</div>
					</div>
					<div class="row">	
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
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" id="" onsubmit="return confirm('Are you sure?');">	
					<input type="hidden" name="paper" value="<?php echo $_POST['paper']; ?>">			
					<input type="hidden" name="examiner" value="<?php echo $_POST['examiner']; ?>">			
					<input type="hidden" name="v_auth" value="<?php echo $_POST['v_auth']; ?>">			
					<input type="hidden" name="max_marks" value="<?php echo $_POST['max_marks']; ?>">			
					<input type="hidden" name="stu_count" value="<?php echo $_POST['stu_count']; ?>">			
					<input type="hidden" name="allot_stu" value="<?php echo $_POST['allot_stu']; ?>">			
					<input type="hidden" name="checking_date" value="<?php echo $_POST['checking_date']; ?>">			
					<table class='table table-hover table-stripped'><tr class='bg-primary text-white'>
					<td>Select Student</td>
					<td>Sno</td>
					<td>Student Type</td>
					<td>Student NAME</td>
					<td>Roll No.</td>
					<td>Paper</td>
					<td>Maximum Marks</td>
					<td>Obtained Marks</td>
					</tr> 
				<?php
					$c = 1;
					$i = 1;
					for($i=1;$i<=$_POST['ccount'];$i++){
						$stu_allot = 'SELECT *,exam_student_paper_info.sno as id FROM `exam_student_paper_info` LEFT JOIN exam_student_info on exam_student_info_sno=exam_student_info.sno WHERE paper_code="'.$_POST['paper'].'" AND exam_roll_no BETWEEN "'.$_POST['fromroll'.$i].'" AND "'.$_POST['toroll'.$i].'" AND practicle_allotment="0"  ORDER BY exam_roll_no'; 
						
						$stu_allot = 'SELECT 
										exam_student_paper_info.sno as id, 
										exam_student_info.exam_roll_no, 
										exam_student_info.student_type, 
										exam_student_info.student_name, 
										exam_student_paper_info.practicle_allotment, 
										exam_student_paper_info.paper_code ,
										exam_student_paper_info.title_of_paper 
									FROM 
										`exam_student_paper_info` 
									LEFT JOIN 
										exam_student_info 
									ON 
										exam_student_info_sno = exam_student_info.sno  
									WHERE 
										paper_code="'.$_POST['paper'].'" 
										AND exam_roll_no BETWEEN "'.$_POST['fromroll'.$i].'" AND "'.$_POST['toroll'.$i].'" AND practicle_allotment="0"

									UNION 

									SELECT 
										back_exam_student_paper_info.sno as id, 
										back_exam_student_info.exam_roll_no, 
										back_exam_student_info.student_type, 
										back_exam_student_info.student_name, 
										back_exam_student_paper_info.practicle_allotment, 
										back_exam_student_paper_info.paper_code ,
										back_exam_student_paper_info.title_of_paper 
									FROM 
										`back_exam_student_paper_info` 
									LEFT JOIN 
										back_exam_student_info 
									ON 
										exam_student_info_sno = back_exam_student_info.sno  
									WHERE 
										paper_code="'.$_POST['paper'].'"  
										AND exam_roll_no BETWEEN "'.$_POST['fromroll'.$i].'" AND "'.$_POST['toroll'.$i].'" AND practicle_allotment="0"

									ORDER BY 
										exam_roll_no';
						//echo $stu_allot;
						$result =execute_query($db,$stu_allot);
						$j=1;
						while($row=mysqli_fetch_assoc($result)){
				?>
					<tr>
						<td><input type="checkbox" id="stu_check<?php echo $c; ?>" name="stu_check<?php echo $c; ?>"  checked></td>
						<td><?php echo $i++;?></td>
						<td><?php echo $row['student_type'];?></td>
						<td><?php echo $row['student_name'];?></td>
						<td><?php echo $row['exam_roll_no'] ;?></td>
						<td><?php echo $row['paper_code'] ;?></td>
						<td><input type="text" name="max_marks" value="<?php echo $_POST['max_marks']; ?>" class="form-control" id="max_marks<?php echo $c; ?>" readonly></td>
						<td><input type="text" name="obt_marks<?php echo $c; ?>" id="obt_marks<?php echo $c; ?>"  tabindex="1" value="" class="form-control" oninput="validateMarks('<?php echo $c; ?>')"></td>
						<script>
						  function validateMarks(c) {
							// Get the maximum marks and obtained marks input elements
							const maxMarks = document.getElementById('max_marks' + c);
							const obtMarks = document.getElementById('obt_marks' + c);
							
							// Parse the values as numbers
							const max = parseFloat(maxMarks.value) || 0;
							const obt = parseFloat(obtMarks.value) || 0;

							// Check if obtained marks exceed maximum marks
							if (obt > max) {
							  alert("Obtained marks cannot be greater than maximum marks.");
							  obtMarks.value = ""; // Clear the invalid input
							}
						  }
						</script>
						<input type="hidden" name="exam_stu_id<?php echo $c; ?>" value="<?php echo $row['id']; ?>" class="form-control" readonly>
						<input type="hidden" name="exam_stu_type<?php echo $c++; ?>" value="<?php echo $row['student_type']; ?>" class="form-control" readonly>
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
<script>
function get_stu_count(rf, rt, id){
	var pc = $("#paper").val();
	$.ajax({
		url: "scripts/ajax.php?id=student_count&term=a&rf="+rf+"&rt="+rt+"&pc="+pc,
		dataType:"json"
	})
	.done(function( data ) {
		console.log(data);
		$("#totalCount"+id).val(data.count);
		updateAllotedStudentCount();
	});
}	
</script>
    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="js/light-bootstrap-dashboard.js?v=1.4.0"></script>
<?php		
page_footer_end();
?>