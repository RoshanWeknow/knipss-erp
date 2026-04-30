<?php 
include("scripts/settings.php");



page_header_start();
page_header_end();
page_sidebar();
?>

<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">  
				<form action="" class="wufoo leftLabel page1" name="" enctype="multipart/form-data" method="POST" onSubmit="" >
					<h3>Leave Form</h3>
						<div class="col-md-12" >
							<div class="row">	
								<div class=" col-md-3  ms-4">							
									<label>Employee ID</label>
									<input type="text" name="employee_id" id="employee_id" value="" class="form-control">
								</div>
								<div class=" col-md-3  ms-4">							
									<label>Name of Candidate</label>
									<input type="text" name="name" id="name" value="" class="form-control">
								</div>
								<div class=" col-md-3  ms-4">							
									<label>Department</label>
									<select name="department" id="department" value="" class="form-control" required>
										<option disabled selected>---Select Your Department---</option>
										<option value="Mathematics">Department of Mathematics</option>
										<option value="English">Department of English</option>
										<option value="Physics">Department of Physics</option>
										<option value="Chemistry">Department of Chemistry</option>
										<option value="ComputerScience">Department of Computer Science</option>
										<option value="BusinessAdministration">Department of Business Administration</option>
										<option value="Sociology">Department of Sociology</option>
										<option value="PoliticalScience">Department of Political Science</option>
										<option value="CommunicationStudies">Department of Communication Studies</option>
										<option value="Engineering">Department of Engineering</option>
									</select>
								</div>		
										
							</div>
							<div class="row">							
								<div class=" col-md-3  ms-4">							
									<label>Contact No.</label>
									<input type="text" name="contect_no" id="contect_no" value="" class="form-control">
								</div>
								<div class=" col-md-3  ms-4">							
									<label>Email</label>
									<input type="email" name="email" id="email" value="" class="form-control">
								</div>
								<div class=" col-md-3  ms-4">							
									<label>Leave Days</label>
									<input type="number" name="leave_days" id="leave_days" value="" class="form-control">
								</div>
							</div>
							<div class="row">							
								<div class=" col-md-3  ms-4">							
									<label>Leave Type</label>
									<select name="department" id="department" value="" class="form-control" required>
										<option disabled selected>---Select Leave Type---</option>
										<option value="annual">Annual Leave</option>
										<option value="sick">Sick Leave</option>
										<option value="personal">Personal Leave</option>
										<option value="maternity">Maternity Leave</option>
										<option value="paternity">Paternity Leave</option>
										<option value="bereavement">Bereavement Leave</option>
										<option value="family">Family Leave</option>
										<option value="unpaid">Unpaid Leave</option>
										<option value="other">Other</option>
									</select>
								</div>	
								<div class="col-md-3 ms-4">
									<div class="form-group">
										<label>Start  Date </label>
										<script type="text/javascript" language="javascript">
											<?php
												$date = isset($_GET['edit'])? $result['date_of_retierment']: date('Y-m-d');
												echo "document.writeln(DateInput('date_of_retierment', 'user_form', true, 'YYYY-MM-DD','$date', 1));"
											?>
										</script>
									</div>
								</div>	
								<div class="col-md-3 ms-4">
									<div class="form-group">
										<label>End Date </label>
										<script type="text/javascript" language="javascript">
											<?php
												$date = isset($_GET['edit'])? $result['date_of_retierment']: date('Y-m-d');
												echo "document.writeln(DateInput('date_of_retierment', 'user_form', true, 'YYYY-MM-DD','$date', 1));"
											?>
										</script>
									</div>
								</div>		
							</div>
							<div class="row">
								<div class="col-md-3 ms-4">
									<div class="form-group">
										<label for="description">Description</label>
										<textarea type="text" id="description" name="description" class="form-control"></textarea>
									</div>
								</div>
								<div class="col-md-3 ms-4">
									<div class="form-group">
										<label for='attach_file'>Attach File</label>
										<input type ="file" id="attach_file" name="attach_files" class="form-control">
									</div>
								</div>
							</div>
							</div>
							</br><button type="submit" class="btn btn-primary ms-4" name="save" value="">Submit </button>
						</div>
				</form>	
			</div>
		</div>
	</div>