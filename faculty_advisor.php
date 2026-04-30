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
						<h3>Faculty Advisor Form</h3>
						<div class="row">							
							<div class=" col-md-3  ms-4">							
								<label for="name">Name</label>
								<input type="text" id="name" name="name" class="form-control">
							</div>							
							<div class=" col-md-3  ms-4">							
								<label for="date">Date</label>
								<input type="date" id="date" name="date" class="form-control">
							</div>
							<div class=" col-md-3  ms-4">							
								 <label for="student-id">Student ID</label>
								<input type="text" id="student-id" name="student-id" class="form-control">
							</div>
						</div>
						<div class="row">
							<div class=" col-md-3  ms-4">							
								 <label for="phone">Phone Number</label>
								<input type="text" id="phone" name="phone" class="form-control">
							</div>	
							<div class=" col-md-3  ms-4">	
							  <label for="department">Department</label>
								<input type="text" id="department" name="department" class="form-control">
							</div>
							<div class=" col-md-3  ms-4">	
							 <label for="current-major">Current Major</label>
							<input type="text" id="current-major" name="current-major" class="form-control">
							</div>
						</div>
						<div class="row">
							<div class=" col-md-3  ms-4">							
								  <label for="current-faculty">Current Faculty Advisor</label>
								<input type="text" id="current-faculty" name="current-faculty" class="form-control">
							</div>	
							<div class=" col-md-3  ms-4">	
							  <label for="new-faculty">New Faculty Advisor</label>
								<input type="text" id="new-faculty" name="new-faculty" class="form-control">
							</div>
							<div class=" col-md-3  ms-4">	
							  <label for="reason">Reason for Request</label>
							<textarea id="reason" name="reason" rows="5" class="form-control"></textarea>
							</div>
						</div>
					</div>
					<button type="submit" class="btn btn-primary ms-5 mt-" name="save" value="">Submit </button>
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