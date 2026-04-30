<?php
//set_time_limit(0);
//session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_start();
$response=1;
$msg='';
$i=0;

page_header_end();
page_sidebar();
?>
<html>
<head>
	<style>
	.form div.row:nth-child(odd) {
	  background: #eeeeee;
	  border-radius: 5px;
	  margin-bottom:5px;
	  margin-top:5px;
	  padding:5px;
	}
	form div.row label{
		color:#000000;
	}
	</style>
</head>
<body id="public">
	<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">  
				<form action="" class="wufoo leftLabel page1" name="" enctype="multipart/form-data" method="POST" onSubmit="" >
						<div class="col-md-12" >
							<h3>Branch Change Appplication Form</h3>
							<div>
								<h4>Personal Information</h4>
								<div class="row">							
									<div class=" col-md-3  ms-4">							
										<label>ENROLLMENT NUMBER</label>
										<input type="text" name="e_number" id="e_number" value="" class="form-control">
									</div>	
								</div>
								<div class="row">							
									<div class=" col-md-3  ms-4">							
										<label>Full Name</label>
										<input type="text" name="name" id="name" value="" class="form-control">
									</div>							
									<div class=" col-md-3  ms-4">							
										<label>Contact No.</label>
										<input type="text" name="contect_no" id="contect_no" value="" class="form-control">
									</div>
									<div class=" col-md-3  ms-4">							
										<label>Email</label>
										<input type="email" name="email" id="email" value="" class="form-control">
									</div>
								</div>
								<div class="row">
									<div class=" col-md-3  ms-4">							
										<label>Date of Birth</label>
										<input type="date" name="dob" id="dob" value="" class="form-control">
									</div>	
									<div class=" col-md-3  ms-4">	
									<label for="gender">Gender:</label><br>
										<select name="gender" id="gender" value="" class="form-control" required>
											<option disabled selected>---Select Gender---</option>
											<option>Male</option>
											<option>Female</option>
											<option>Other</option>
										</select>	
									</div>
									<div class=" col-md-3  ms-4">	
									<label for="gender">Category</label><br>
										<select name="gender" id="gender" value="" class="form-control" required>
											<option disabled selected>---Select Category---</option>
											<option>General</option>
											<option>OBC</option>
											<option>SC/ST</option>
										</select>
									</div>
								</div>
							</div>
							<div>
								<h4>Academic Details</h4>
								<div class="row">							
									<div class=" col-md-3  ms-4">							
										<label for="course">Course</label><br>
										<select name="course" id="course" value="" class="form-control" required>
											<option disabled selected>---Select course---</option>
											<option value="">B.Tech</option>
											<option value="">M.Tech</option>
											<option value="">BCA</option>
											<option value="">MCA</option>
											<option value="">BSc</option>
											<option value="">MSc</option>
										</select>
									</div>						
									<div class=" col-md-3  ms-4">							
										<label for="c_branch"> Current Branch</label><br>
										<select name="c_branch" id="c_branch" value="" class="form-control" required>
											<option disabled selected>---Select Current Branch---</option>
											<option value="">CSE</option>
											<option value="">IT</option>
											<option value="">ECE</option>
											<option value="">EE</option>
											<option value="">Civil</option>
											<option value="">ME</option>
										</select>
									</div>
										<div class=" col-md-3  ms-4">							
											<label>Current GPA/CGPA/Percentage </label>
											<input type="text" name="marks" id="marks" value="" class="form-control">
										</div>
									</div>
								</div>
								<div class="row">
									<div class=" col-md-3  ms-4">							
										<label>Completed Credits</label>
										<input type="text" name="credits_completed" id="credits_completed" value="" class="form-control">
									</div>	
									<div class="col-md-3 ms-4">
										<label for="d_branch"> Desired Branch </label><br>
										<select name="d_Branch" id="d_branch" value="d_branch" class="form-control" required>
											<option disabled selected>---Select Desired Branch---</option>
											<option value="">CSE</option>
											<option value="">IT</option>
											<option value="">ECE</option>
											<option value="">EE</option>
											<option value="">Civil</option>
											<option value="">ME</option>
										</select>
									</div>	
									<div class=" col-md-3  ms-4">	
										<label for="gender">Reason for Branch Change</label><br>
										<textarea id="reason" name="reason" rows="5" cols="40" class="form-control"></textarea>	
									</div>
								</div>
									<div class="row">
										<div class=" col-md-3  ms-4">	
											<label for="gender">Letter Of Recommendation</label><br>
											<input type="file" id="recommendations" name="recommendations" class="form-control">
										</div>
									</div>
								</div>
							</br><button type="submit" class="btn btn-primary ms-4" name="save" value="">Submit </button>
						</div>
				</form>	
			</div>
		</div>
	</div>
</body>	
<?php 
page_footer_start(); 
page_footer_end(); 

?>
</html>