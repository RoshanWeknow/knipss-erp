<?php
include("scripts/settings.php");
include("exam_crosslist_marksheet_functions.php");
$msg='';
$tab=1;
$responce = 0;

page_header_start();
page_header_end();
page_sidebar();	

	if(isset($_POST['submit'])){
		if(isset($_POST['edit']) && $_POST != ''){
			$sql = 'UPDATE exam_daily_examination_attendence SET 
			exam_date = "'.$_POST['exam_date'].'",
			exam_shift = "'.$_POST['exam_shift'].'",
			shift_wise_stud_count = "'.$_POST['shift_wise_stud_count'].'",
			total_reg_stud = "'.$_POST['total_reg_stud'].'",
			room_count = "'.$_POST['room_count'].'",
			alloted_cs = "'.$_POST['alloted_cs'].'",
			alloted_as = "'.$_POST['alloted_as'].'",
			alloted_ri = "'.$_POST['alloted_ri'].'",
			alloted_relive = "'.$_POST['alloted_relive'].'",
			max_allow_cs = "'.$_POST['max_allow_cs'].'",
			max_allow_as = "'.$_POST['max_allow_as'].'",
			max_allow_ri = "'.$_POST['max_allow_ri'].'",
			max_allow_relive = "'.$_POST['max_allow_relive'].'"
			where sno="'.$_POST['edit'].'"
			';
			$sno = $_POST['edit'];
			$result = mysqli_query($db,$sql);
			if(!isset($result)){
				echo 'Failed To Update ';
			}
			
		}else{
			$sql = 'INSERT INTO exam_daily_examination_attendence (exam_date, exam_shift, shift_wise_stud_count, total_reg_stud, room_count, alloted_cs, alloted_as, alloted_ri, alloted_relive, max_allow_cs, max_allow_as, max_allow_ri, max_allow_relive) VALUES ("'.$_POST['exam_date'].'","'.$_POST['exam_shift'].'","'.$_POST['shift_wise_stud_count'].'","'.$_POST['total_reg_stud'].'","'.$_POST['room_count'].'","'.$_POST['alloted_cs'].'","'.$_POST['alloted_as'].'","'.$_POST['alloted_ri'].'","'.$_POST['alloted_relive'].'","'.$_POST['max_allow_cs'].'","'.$_POST['max_allow_as'].'","'.$_POST['max_allow_ri'].'","'.$_POST['max_allow_relive'].'" )';
			$result = mysqli_query($db,$sql);
			if(mysqli_error($db)){
				echo 'Failed To insert ';
			}
			else{
				$sno = mysqli_insert_id($db);
			}
			echo $sql;
		}
		$sql = 'delete from exam_daily_attendence2 where exam_daily_attendence2_sno="'.$sno.'"';
		print_r($_POST);
		for($i=1; $i<=$_POST['row_insert_id']; $i++){
			if (isset($_POST['sel_designation_'.$i]) && isset($_POST['sel_faculty_'.$i])) {
				$sql2 = 'insert into exam_daily_attendence2 (exam_daily_attendence2_sno , sel_designation , sel_faculty, duty_assign) values ( "'.$sno.'","'.$_POST['sel_designation_'.$i].'" ,"'.$_POST['sel_faculty_'.$i].'","'.$_POST['duty_assign'.$i].'")';
				echo $sql2.'<br>';
				$result = mysqli_query($db,$sql2);
				if(mysqli_error($db)){
					echo 'Failed To insert ';
				}
			}
		}
			
				
	}
		
		
		
		
	
	
	// Deletion 
		if(isset($_GET['del'])){
			$sql = 'DELETE FROM exam_daily_examination_attendence where sno="'.$_GET['del'].'"';
			$delete=mysqli_query($db, $sql);
			if(!isset($delete)){
				echo "DELETION NOT SUCCESSFULL !!!";
			}
		}
		
		// Edition
		if(isset($_GET['edit'])){
			$sql = 'SELECT * FROM exam_daily_examination_attendence';
			$qry = mysqli_query($db, $sql);
			$res = mysqli_fetch_assoc($qry);
		}
	
?>
<style>
        .ui-autocomplete {
            max-height: 200px;
            overflow-y: auto;
            overflow-x: hidden;
        }
    </style>
<!----cdn lind---->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!------cdn link end-------->


		<div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center"></h4></br>
						<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" id="" name="" target="">
							<?php echo $msg; ?> 
							<?php
								
							?>
							<div class="col-md-12">
								<h2 class="bg-primary text-white p-2" style="text-align:center;">Daily Examination Attendence</h2>
									<div class="row mt-1">							
										<div class="col-md-6">							
											<label>DATE OF EXAMINATION</label>
											<input type="date" name="exam_date" value="<?php echo isset($_GET['edit'])? $res['exam_date']:''; ?>" id="exam_date" class="form-control " />
										</div>
										<div class="col-md-6">							
											<label>EXAMINATION SHIFT</label>
											<select id="exam_shift" name="exam_shift" value="<?php echo isset($_GET['edit'])? $res['exam_shift']:''; ?>" class="form-control" tabindex="<?php echo $tabindex++;?>" >
												<option value="" disabled selected>---Select---</option>
												<option value="Morning Shift" >Morning Shift</option>
												<option value="Noon Shift" >Noon Shift</option>
												<option value="Evening Shift" >Evening Shift</option>
											</select>
										</div>
										
									</div>
									<div class="row mt-1">	
										<div class="col-md-6">							
											<label>SHIFT WISE NO. OF STUDENT</label>
											  <input type="text" name="shift_wise_stud_count" value="<?php echo isset($_GET['edit']) ? $res['shift_wise_stud_count'] : ''; ?>" id="shift_wise_stud_count" class="form-control" oninput="updateFields()" />

										</div>
										<div class="col-md-6">							
											<label>TOTAL NO OF REGISTERED STUDENTS ON CENTER</label>
											<input type="text" name="total_reg_stud" value="3776" id="total_reg_stud" class="form-control " readonly />
										</div>
										
									</div>
									<div class="row mt-1">	
										<div class="col-md-6">							
											<label>NO. OF ROOM(S)</label>
											<input type="text" name="room_count" value="<?php echo isset($_GET['edit'])? $res['room_count']:''; ?>" id="room_count" class="form-control " />
										</div>
										<div class="col-md-6">	
										</div>
										
									</div>
									<hr >
									<div class="row mt-1">	
										<div class="col-md-6">							
											<label>ASSIGNED ROLE</label>
											<input type="text" name="assign_cs" id="assign_cs" class="form-control m-2" placeholder="CENTER SUPERINTENDENT" disabled />
											<input type="text" name="assign_as" id="assign_as" class="form-control m-2"  placeholder="ASSISTANT SUPERINTENDENT" disabled />
											<input type="text" name="assign_ri" id="assign_rm" class="form-control m-2"  placeholder="ROOM INVIGILATOR"disabled />
											<input type="text" name="assign_relive" id="assign_relive" class="form-control m-2" placeholder="RELIEVER" disabled />
										</div>
										<div class="col-md-3">
											<label>ALREADY ALLOTTED</label>
											<input type="text" name="alloted_cs" value="<?php echo isset($_GET['edit'])? $res['alloted_cs']:''; ?>" id="alloted_cs" class="form-control m-2" />
											<input type="text" name="alloted_as" value="<?php echo isset($_GET['edit'])? $res['alloted_as']:''; ?>" id="alloted_as" class="form-control m-2" />
											<input type="text" name="alloted_ri" value="<?php echo isset($_GET['edit'])? $res['alloted_ri']:''; ?>" id="alloted_ri" class="form-control m-2" />
											<input type="text" name="alloted_relive" value="<?php echo isset($_GET['edit'])? $res['alloted_relive']:''; ?>" id="alloted_relive" class="form-control m-2" />
										</div>
										<div class="col-md-3">
											<label>MAX ALLOWED</label>
											<input type="text" name="max_allow_cs" value="1" id="max_allow_cs" class="form-control m-2" readonly />
											<input type="text" name="max_allow_as" value="12" id="max_allow_as" class="form-control m-2" readonly />
											<input type="text" name="max_allow_ri" value="<?php echo isset($_GET['edit'])? $res['max_allow_ri']:''; ?>" id="max_allow_ri" class="form-control m-2" readonly />
											<input type="text" name="max_allow_relive" value="<?php echo isset($_GET['edit']) ? $res['max_allow_relive'] : ''; ?>" id="max_allow_relive" class="form-control m-2" readonly />
										</div>
									</div>
															<hr>
									<div class="container mt-3">
										<div class="row mt-1">	
											<div class="col-md-6">							
												<label>DUTY ASSIGNED</label>
												<select name="duty_assign_1" id="duty_assign_1" class="form-control" tabindex="1">
													<option value="" disabled selected>---Select---</option>
													<option value="CENTER SUPERINTENDENT">CENTER SUPERINTENDENT</option>
													<option value="ASSISTANT SUPERINTENDENT">ASSISTANT SUPERINTENDENT</option>
													<option value="ROOM INVIGILATOR">ROOM INVIGILATOR</option>
													<option value="RELIEVER">RELIEVER</option>
												</select>
											</div>
										</div>
										
										<div class="row mt-1" id="amenitiestable">
											<div class="col-md-4" id="sel_designa">
												<label>SELECT DESIGNATION</label>
												<select name="sel_designation_1" id="sel_designation_1" class="form-control" tabindex="2">
													<option value="" disabled selected>---Select---</option>
													<option value="Assistant Professor">Assistant Professor</option>
													<option value="Associate Professor">Associate Professor</option>
													<option value="Professor">Professor</option>
													<option value="Other">Other</option>
												</select>
											</div>
											<div class="col-md-4" id="sel_faculty">
												<label>SELECT FACULTY</label>
												
												
												
												<input type="text" id="faculty_autocomplete" class="form-control" placeholder="Enter Name" value="<?php echo isset($_GET['edit']) ? $res['sel_faculty_1_name'] : ''; ?>">
											<input type="hidden" name="sel_faculty_1" id="sel_faculty_1" value="<?php echo isset($_GET['edit']) ? $res['sel_faculty_1'] : ''; ?>">

											<?php 
												$sql  = 'SELECT * FROM exam_faculty_master_info';
												$dept_list = execute_query($db, $sql);
												$faculty_data = [];
												if ($dept_list) {
													while ($list = mysqli_fetch_assoc($dept_list)) {
														$faculty_data[] = ['id' => $list['sno'], 'name' => $list['name']];
													}
												}
											?>
											</div>
											<div class="col-md-2">
												<input type="button" class="btn btn-primary" value="Add" onclick="addRow()">
												<input type="hidden" name="row_insert_id" id="row_insert_id" value="1">
											</div>
										</div>
										
										<table class="table table-striped mt-3">
											<thead class="bg-secondary text-white text-center p-2">
												<tr>
													<th width="20%">ROLE</th>
													<th width="30%">DESIGNATION</th>
													<th width="30%">FACULTY NAME</th>
													<th width="20%">ACTION</th>
												</tr>
											</thead>
											<tbody id="dynamic_table">
												<!-- Dynamic rows will be added here -->
											</tbody>
										</table>
									</div>

									<script>
										function addRow() {
											// Get selected values
											const dutyAssign = document.getElementById('duty_assign_1').value;
											const designation = document.getElementById('sel_designation_1').value;
											const facultyName = document.getElementById('faculty_autocomplete').value;

											// Check if any field is empty
											if (!dutyAssign || !designation || !facultyName) {
												alert('Please fill out all fields');
												return;
											}

											// Create a new row
											const table = document.getElementById('dynamic_table');
											const newRow = document.createElement('tr');

											// Create cells
											const roleCell = document.createElement('td');
											roleCell.innerText = dutyAssign;

											const designationCell = document.createElement('td');
											designationCell.innerText = designation;

											const facultyCell = document.createElement('td');
											facultyCell.innerText = facultyName;

											const actionCell = document.createElement('td');
											const deleteButton = document.createElement('input');
											deleteButton.type = 'button';
											deleteButton.className = 'btn btn-danger';
											deleteButton.value = 'Delete';
											deleteButton.onclick = function() {
												deleteRow(this);
											};
											actionCell.appendChild(deleteButton);

											// Append cells to the row
											newRow.appendChild(roleCell);
											newRow.appendChild(designationCell);
											newRow.appendChild(facultyCell);
											newRow.appendChild(actionCell);

											// Append row to the table
											table.appendChild(newRow);

											// Clear the input fields
											document.getElementById('duty_assign_1').value = '';
											document.getElementById('sel_designation_1').value = '';
											document.getElementById('faculty_autocomplete').value = '';
										}

										function deleteRow(button) {
											// Get the row to delete
											const row = button.parentNode.parentNode;
											// Remove the row from the table
											row.parentNode.removeChild(row);
										}
									</script>
									<button class="btn btn-primary" name="submit">Submit</button>
								
								<div class="row pt-5">
									<div class="col-md-12">
										<h3 style="text-align:center;background-color:#0d6efd;color:white;height:4rem;line-height:4rem;">DETAILS OF DAILY EXAMINATION ATTENDANCE REPORT</h3>
										<table class="table table-striped px-auto">
											<tr class="bg-primary p-2 text-white">
												<td>S.NO.</td>
												<td>Exam Date</td>
												<td>Exam Shift</td>
												<td>Shift Wise Student Count</td>
												<td>Total Student Reg</td>
												<td>Number Of Rooms</td>
												<td>EDIT</td>
												<td>DELETE</td>
											</tr>
												<?php
													$sql = 'SELECT * FROM exam_daily_examination_attendence';
													$result = mysqli_query($db,$sql);
													$i=1;
													while($row = mysqli_fetch_assoc($result)){
												?>
											<tr>
												<td><?php echo $i++; ?></td>
												<td><?php echo $row['exam_date']; ?></td>
												<td><?php echo $row['exam_shift']; ?></td>
												<td><?php echo $row['shift_wise_stud_count']; ?></td>
												<td><?php echo $row['total_reg_stud']; ?></td>
												<td><?php echo $row['room_count']; ?></td>
												<td><a href="exam_daily_examination_attendence.php?edit=<?php echo $row['sno'];?> " class="btn btn-primary">Edit</a></td>
												<td><a href="exam_daily_examination_attendence.php?del=<?php echo $row['sno']?>" class="btn btn-danger">Delete</a></td>
											</tr>	
											<?php		
												}
											?>
										</table>
									</div>
								</div>
							</div>
						</form>
                    </div>
				</div>
			</div>
		</div>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
		<script>
			$(function() {
				var facultyData = <?php echo json_encode($faculty_data); ?>;
				$("#faculty_autocomplete").autocomplete({
					source: facultyData.map(function(faculty) {
						return {
							label: faculty.name,
							value: faculty.name,
							id: faculty.id
						};
					}),
					select: function(event, ui) {
						$("#sel_faculty_1").val(ui.item.id);
					}
				});
			});
			
			
			

			function deleteRows() {
				$('#amenitiestable input[type="checkbox"]:checked').each(function() {
					$(this).closest('.row').remove();
				});
			}


			function updateFields() {
				var shiftWiseStudCount = document.getElementById('shift_wise_stud_count').value;
				var maxAllowRi = document.getElementById('max_allow_ri');
				var maxAllowRelive = document.getElementById('max_allow_relive');

				// Convert the input value to a number
				var shiftWiseStudCountNumber = parseFloat(shiftWiseStudCount);

				// Check if the value is a valid number
				if (!isNaN(shiftWiseStudCountNumber)) {
					// Update max_allow_ri
					maxAllowRi.value = Math.ceil(shiftWiseStudCountNumber / 20);

					// Update max_allow_relive
					var reliveValue = Math.ceil(shiftWiseStudCountNumber / 100);
					if (reliveValue > 4) {
						reliveValue = 4;
					}
					maxAllowRelive.value = reliveValue; // Ensure it's an integer and respects the maximum value
				} else {
					maxAllowRi.value = '';
					maxAllowRelive.value = '';
				}
			}
			
			
			document.addEventListener('DOMContentLoaded', (event) => {
		const maxAllowCs = parseInt(document.getElementById('max_allow_cs').value);
		const maxAllowAs = parseInt(document.getElementById('max_allow_as').value);
		const maxAllowRi = parseInt(document.getElementById('max_allow_ri').value);
		const maxAllowRelive = parseInt(document.getElementById('max_allow_relive').value);

		const allotedCs = document.getElementById('alloted_cs');
		const allotedAs = document.getElementById('alloted_as');
		const allotedRi = document.getElementById('alloted_ri');
		const allotedRelive = document.getElementById('alloted_relive');

		function validateAllotedValues() {
			if (parseInt(allotedCs.value) > maxAllowCs) {
				alert('ALREADY ALLOTTED CS value cannot be more than MAX ALLOWED CS value');
				allotedCs.value = maxAllowCs;
			}
			if (parseInt(allotedAs.value) > maxAllowAs) {
				alert('ALREADY ALLOTTED AS value cannot be more than MAX ALLOWED AS value');
				allotedAs.value = maxAllowAs;
			}
			if (parseInt(allotedRi.value) > maxAllowRi) {
				alert('ALREADY ALLOTTED RI value cannot be more than MAX ALLOWED RI value');
				allotedRi.value = maxAllowRi;
			}
			if (parseInt(allotedRelive.value) > maxAllowRelive) {
				alert('ALREADY ALLOTTED RELIVE value cannot be more than MAX ALLOWED RELIVE value');
				allotedRelive.value = maxAllowRelive;
			}
		}

		allotedCs.addEventListener('change', validateAllotedValues);
		allotedAs.addEventListener('change', validateAllotedValues);
		allotedRi.addEventListener('change', validateAllotedValues);
		allotedRelive.addEventListener('change', validateAllotedValues);
	});
</script>
<?php	
page_footer_start();	
page_footer_end();
?>


