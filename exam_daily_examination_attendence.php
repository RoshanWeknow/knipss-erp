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
			$sql = 'INSERT INTO exam_daily_examination_attendence (exam_date, exam_shift, shift_wise_stud_count, total_reg_stud, room_count, alloted_cs, alloted_as, alloted_ri, alloted_relive, max_allow_cs, max_allow_as, max_allow_ri, max_allow_relive,created_by ,creation_time) VALUES ("'.$_POST['exam_date'].'","'.$_POST['exam_shift'].'","'.$_POST['shift_wise_stud_count'].'","'.$_POST['total_reg_stud'].'","'.$_POST['room_count'].'","'.$_POST['alloted_cs'].'","'.$_POST['alloted_as'].'","'.$_POST['alloted_ri'].'","'.$_POST['alloted_relive'].'","'.$_POST['max_allow_cs'].'","'.$_POST['max_allow_as'].'","'.$_POST['max_allow_ri'].'","'.$_POST['max_allow_relive'].'" ,"'.$_SESSION['username'].'","'.date('Y-m-d H:m:s').'")';
			$result = mysqli_query($db,$sql);
			if(mysqli_error($db)){
				echo 'Failed To insert ';
			}
			else{
				$sno = mysqli_insert_id($db);
			}
			//echo $sql;
		}
		$sql = 'delete from exam_daily_attendence2 where exam_daily_attendence2_sno="'.$sno.'"';
		//print_r($_POST);
		//echo "aaaaaa";
		if (isset($_POST['row_insert_id'])) {
			for ($i = 1; $i <= $_POST['row_insert_id']; $i++) {
				if (!empty($_POST["sel_designation_$i"]) && !empty($_POST["sel_faculty_$i"]) && !empty($_POST["duty_assign_$i"])) {
					$designation = $_POST["sel_designation_$i"];
					$faculty = $_POST["sel_faculty_$i"];
					$duty = $_POST["duty_assign_$i"];

					$sql = "INSERT INTO exam_daily_attendence2 (exam_daily_attendence2_sno, sel_designation, sel_faculty, duty_assign) 
							VALUES ('$sno', '$designation', '$faculty', '$duty')";
					$result = mysqli_query($db, $sql);

					if (!$result) {
						echo "Error: " . mysqli_error($db);
					}
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
			$sql = 'DELETE FROM exam_daily_attendence2 where exam_daily_attendence2_sno="'.$_GET['del'].'"';
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
	<div class="row col-md-11 mx-auto ">
        <div class="col-md-12">
			<div class="card shadow">
				<div class="card-header">
                    <h4 class="card-title text-center"></h4></br>
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" id="" name="" target="">
					<?php echo $msg; ?> 
						<div class="col-md-12">
							<h2 class="bg-secondary text-white p-2" style="text-align:center;">Daily Examination Attendence</h2>
							<div class="card mt-3 p-3" style="">
								<div class="row mt-1">							
									<div class="col-md-4">							
										<label>DATE OF EXAMINATION</label>
										<input type="date" name="exam_date" value="<?php echo isset($_GET['edit'])? $res['exam_date']:''; ?>" id="exam_date" class="form-control " />
									</div>
									<div class="col-md-4">							
										<label>EXAMINATION SHIFT</label>
											<select id="exam_shift" name="exam_shift" value="<?php echo isset($_GET['edit'])? $res['exam_shift']:''; ?>" class="form-control" tabindex="<?php echo $tabindex++;?>" >
											<option value="" disabled selected>---Select---</option>
											<option value="Morning Shift" >Morning Shift</option>
											<option value="Noon Shift" >Noon Shift</option>
											<option value="Evening Shift" >Evening Shift</option>
										</select>
									</div>
									
									
									<div class="col-md-4">							
										<label>SHIFT WISE NO. OF STUDENT</label>
										  <input type="text" name="shift_wise_stud_count" value="<?php echo isset($_GET['edit']) ? $res['shift_wise_stud_count'] : ''; ?>" id="shift_wise_stud_count" class="form-control" oninput="updateFields()" />

									</div>
								</div>
								<div class="row mt-1">
									<div class="col-md-4">							
										<label>TOTAL NO OF REGISTERED STUDENTS ON CENTER</label>
										<input type="text" name="total_reg_stud" value="3776" id="total_reg_stud" class="form-control " readonly />
									</div>
									<div class="col-md-4">							
										<label>NO. OF ROOM(S)</label>
										<input type="text" name="room_count" value="<?php echo isset($_GET['edit'])? $res['room_count']:''; ?>" id="room_count" class="form-control " />
									</div>
									<div class="col-md-4">	
									</div>
									
								</div>
								<hr >
								<div class="container mt-3">
									<div class="row mt-1">
										<div class="col-md-6">
											<label>ASSIGNED ROLE</label>
											<input type="text" name="assign_cs" id="assign_cs" class="form-control m-2" placeholder="CENTER SUPERINTENDENT" disabled />
											<input type="text" name="assign_as" id="assign_as" class="form-control m-2" placeholder="ASSISTANT SUPERINTENDENT" disabled />
											<input type="text" name="assign_ri" id="assign_ri" class="form-control m-2" placeholder="ROOM INVIGILATOR" disabled />
											<input type="text" name="assign_relive" id="assign_relive" class="form-control m-2" placeholder="RELIEVER" disabled />
										</div>
										<div class="col-md-3">
											<label>ALREADY ALLOTTED</label>
											<input type="text" name="alloted_cs" id="alloted_cs" class="form-control m-2" value="0" readonly />
											<input type="text" name="alloted_as" id="alloted_as" class="form-control m-2" value="0" readonly />
											<input type="text" name="alloted_ri" id="alloted_ri" class="form-control m-2" value="0" readonly />
											<input type="text" name="alloted_relive" id="alloted_relive" class="form-control m-2" value="0" readonly />
										</div>
										<div class="col-md-3">
											<label>MAX ALLOWED</label>
											<input type="text" name="max_allow_cs" id="max_allow_cs" class="form-control m-2" value="1" readonly />
											<input type="text" name="max_allow_as" id="max_allow_as" class="form-control m-2" value="12" readonly />
											<input type="text" name="max_allow_ri" id="max_allow_ri" class="form-control m-2" readonly />
											<input type="text" name="max_allow_relive" id="max_allow_relive" class="form-control m-2" readonly />
										</div>
									</div>
									<hr>
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
									<div class="row mt-1">
										<div class="col-md-6">
											<label>SELECT DESIGNATION</label>
											<select name="sel_designation_1" id="sel_designation_1" class="form-control" tabindex="2">
												<option value="" disabled selected>---Select---</option>
												<option value="Assistant Professor">Assistant Professor</option>
												<option value="Associate Professor">Associate Professor</option>
												<option value="Professor">Professor</option>
												<option value="Other">Other</option>
											</select>
										</div>

										<div class="col-md-6">
											<label>SELECT FACULTY</label>
											<input type="text" id="faculty_autocomplete" class="form-control" placeholder="Enter Name">
											<input type="hidden" name="sel_faculty_1" id="sel_faculty_1">

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
									</div>
									<div class="row mt-2">
										<div class="col-md-2">
											<input type="button" class="btn btn-success" value="Add" onclick="addRow()">
											<input type="hidden" name="row_insert_id" id="row_insert_id" value="1">
										</div>
									</div>
									<table class="table table-striped mt-3">
										<thead class="bg-secondary text-white text-center p-2">
											<tr>
												<th>ROLE</th>
												<th>DESIGNATION</th>
												<th>FACULTY NAME</th>
												<th>ACTION</th>
											</tr>
										</thead>
										<tbody id="dynamic_table">
											<!-- Dynamic rows go here -->
										</tbody>
									</table>
									<button class="btn btn-primary" name="submit">Submit</button>
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
	</script>
	<script>
		let rowId = 1;

		function addRow() {
			const duty = document.getElementById('duty_assign_1').value;
			const designation = document.getElementById('sel_designation_1').value;
			const facultyName = document.getElementById('faculty_autocomplete').value;
			const facultyId = document.getElementById('sel_faculty_1').value;

			if (!duty || !designation || !facultyName || !facultyId) {
				alert("Please fill all fields before adding.");
				return;
			}

			// Validate against MAX ALLOWED
			if (!incrementAllotted(duty)) {
				alert("Already Allotted exceeds the Max Allowed for: " + duty);
				return;
			}

			rowId++;
			document.getElementById('row_insert_id').value = rowId;

			const tbody = document.getElementById('dynamic_table');
			const tr = document.createElement('tr');
			tr.id = 'row_' + rowId;
			tr.setAttribute('data-duty', duty); // Store duty info for rollback

			tr.innerHTML = `
				<td>${duty}<input type="hidden" name="duty_assign_${rowId}" value="${duty}"></td>
				<td>${designation}<input type="hidden" name="sel_designation_${rowId}" value="${designation}"></td>
				<td>${facultyName}<input type="hidden" name="sel_faculty_${rowId}" value="${facultyId}"></td>
				<td><button type="button" class="btn btn-danger" onclick="removeRow(${rowId})">Delete</button></td>
			`;

			tbody.appendChild(tr);

			// Clear input fields
			document.getElementById('duty_assign_1').value = '';
			document.getElementById('sel_designation_1').value = '';
			document.getElementById('faculty_autocomplete').value = '';
			document.getElementById('sel_faculty_1').value = '';
		}

		function removeRow(id) {
			const row = document.getElementById('row_' + id);
			if (row) {
				const duty = row.getAttribute('data-duty');
				decrementAllotted(duty);
				row.remove();
			}
		}

		function incrementAllotted(duty) {
			const dutyMap = {
				'CENTER SUPERINTENDENT': ['alloted_cs', 'max_allow_cs'],
				'ASSISTANT SUPERINTENDENT': ['alloted_as', 'max_allow_as'],
				'ROOM INVIGILATOR': ['alloted_ri', 'max_allow_ri'],
				'RELIEVER': ['alloted_relive', 'max_allow_relive'],
			};

			const [allottedId, maxAllowedId] = dutyMap[duty];
			const allottedInput = document.getElementById(allottedId);
			const maxInput = document.getElementById(maxAllowedId);

			const current = parseInt(allottedInput.value) || 0;
			const max = parseInt(maxInput.value) || 0;

			if (current + 1 > max) {
				return false;
			}

			allottedInput.value = current + 1;
			return true;
		}

		function decrementAllotted(duty) {
			const dutyMap = {
				'CENTER SUPERINTENDENT': 'alloted_cs',
				'ASSISTANT SUPERINTENDENT': 'alloted_as',
				'ROOM INVIGILATOR': 'alloted_ri',
				'RELIEVER': 'alloted_relive',
			};

			const inputId = dutyMap[duty];
			const input = document.getElementById(inputId);
			const current = parseInt(input.value) || 0;
			if (current > 0) input.value = current - 1;
		}
	</script>		
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
			
			
	</script>
<?php	
page_footer_start();	
page_footer_end();
?>


