<?php
include("scripts/settings.php");
include("exam_crosslist_marksheet_functions.php");
$msg='';
$tab=1;
$responce = 0;

page_header_start();
page_header_end();
page_sidebar();	
?>
<!----cdn lind---->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!------cdn link end-------->


<div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center"></h4></br>
						<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" id="" name="" target="_blank">
							<?php echo $msg; ?> 
							<div class="col-md-12">
								<h2 class="bg-primary text-white p-2" style="text-align:center;">Daily Examination Attendence</h2>
									<div class="row mt-1">							
										<div class="col-md-6">							
											<label>DATE OF EXAMINATION</label>
											<input type="date" name="candidate_name" id="candidate_name" class="form-control " />
										</div>
										<div class="col-md-6">							
											<label>EXAMINATION SHIFT</label>
											<select name="weightage" id="weightage" class="form-control" tabindex="<?php echo $tabindex++;?>" >
												<option value="" disabled selected>---Select---</option>
												<option value="" >Morning Shift</option>
												<option value="" >Noon Shift</option>
												<option value="" >Evening Shift</option>
											</select>
										</div>
										
									</div>
									<div class="row mt-1">	
										<div class="col-md-6">							
											<label>SHIFT WISE NO. OF STUDENT</label>
											<input type="text" name="candidate_name" id="candidate_name" class="form-control " disabled />
										</div>
										<div class="col-md-6">							
											<label>TOTAL NO OF REGISTERED STUDENTS ON CENTER</label>
											<input type="text" name="candidate_name" id="candidate_name" class="form-control " disabled />
										</div>
										
									</div>
									<div class="row mt-1">	
										<div class="col-md-6">							
											<label>NO. OF ROOM(S)</label>
											<input type="text" name="candidate_name" id="candidate_name" class="form-control " />
										</div>
										<div class="col-md-6">	
										</div>
										
									</div>
									<hr >
									<div class="row mt-1">	
										<div class="col-md-6">							
											<label>ASSIGNED ROLE</label>
											<input type="text" name="candidate_name" id="candidate_name" class="form-control m-2" placeholder="CENTER SUPERINTENDENT" disabled />
											<input type="text" name="candidate_name" id="candidate_name" class="form-control m-2"  placeholder="ASSISTANT SUPERINTENDENT" disabled />
											<input type="text" name="candidate_name" id="candidate_name" class="form-control m-2"  placeholder="ROOM INVIGILATOR"disabled />
											<input type="text" name="candidate_name" id="candidate_name" class="form-control m-2" placeholder="RELIEVER" disabled />
										</div>
										<div class="col-md-3">	
											<label>ALREADY ALOTTED</label>
											<input type="text" name="candidate_name" id="candidate_name" class="form-control m-2" />
											<input type="text" name="candidate_name" id="candidate_name" class="form-control m-2" />
											<input type="text" name="candidate_name" id="candidate_name" class="form-control m-2" />
											<input type="text" name="candidate_name" id="candidate_name" class="form-control m-2" />
										</div>
										<div class="col-md-3">	
											<label>MAX ALLOWED</label>
											<input type="text" name="candidate_name" id="candidate_name" class="form-control m-2" />
											<input type="text" name="candidate_name" id="candidate_name" class="form-control m-2" />
											<input type="text" name="candidate_name" id="candidate_name" class="form-control m-2" />
											<input type="text" name="candidate_name" id="candidate_name" class="form-control m-2" />
										</div>
									</div>
									<hr>
									<div class="row mt-1">	
										<div class="col-md-6">							
											<label>DUTY ASSIGNED</label>
											<select name="weightage" id="weightage" class="form-control" tabindex="<?php echo $tabindex++;?>" >
												<option value="" disabled selected>---Select---</option>
												<option value="" >CENTER SUPERINTENDENT</option>
												<option value="" >ASSISTANT SUPERINTENDENT</option>
												<option value="" >ROOM INVIGILATOR</option>
												<option value="" >RELIEVER</option>
											</select>
										</div>
									</div>
									<div class="row mt-1">	
										<div class="col-md-4">							
											<label>SELECT DESIGNATION</label>
											<select name="weightage" id="weightage" class="form-control" tabindex="<?php echo $tabindex++;?>" >
												<option value="" disabled selected>---Select---</option>
												<option value="" >Assistant Professor</option>
												<option value="" >Associate Professor</option>
												<option value="" > Professor</option>
												<option value="" >Other</option>
											</select>
										</div>
										<div class="col-md-4">							
											<label>SELECT FACULTY</label>
											<select name="weightage" id="weightage" class="form-control" tabindex="<?php echo $tabindex++;?>" >
												<option value="" disabled selected>---Select---</option>
											</select>
										</div>
										<div class="col-md-4">	
											<button class="btn btn-primary mt-3">Add</button>
										</div>
									</div>
									<button class="btn btn-primary">Submit</button>
								
								<div class="row pt-5">
									<div class="col-md-12">
										<h3 style="text-align:center;background-color:#0d6efd;color:white;height:4rem;line-height:4rem;">DETAILS OF DAILY EXAMINATION ATTENDANCE REPORT</h3>
										<table class="table table-striped px-auto">
											<tr class="bg-primary p-2 text-white">
												<td>S.NO.</td>
												<td>NAME</td>
												<td>DESIGNATION</td>
												<td>ASSIGNED ROLE</td>
												<td> NO. OF STUDENT</td>
												<td>SHIFT</td>
												<td>EXAM DATE</td>
												<td>EDIT</td>
												<td>DELETE</td>
											</tr>

											<tr>
												<td>1</td>
												<td>ABC</td>
												<td>ABC</td>
												<td>ABC</td>
												<td>ABC</td>
												<td>ABC</td>
												<td>ABC</td>
												<td><button class="btn btn-primary">Edit</a></button></td>
												<td><button class="btn btn-danger">Delete</a></button></td>
											</tr>	

										</table>
									</div>
								</div>
							</div>
						</form>
                    </div>
				</div>
			</div>
		</div>
