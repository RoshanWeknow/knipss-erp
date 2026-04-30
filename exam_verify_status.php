<?php
include("scripts/settings.php");
$msg = '';
$tab = 1;
$response = 1;

	if (isset($_POST['submit'])){
		if($_POST['student_id']!=''){	
		$sql = 'UPDATE exam_student_info SET
				verify_status = 1 ,
				verify_by="'.$_SESSION['username'].'",
				verify_time="'.date('Y-m-d H:m:s').'"
				WHERE sno = "' . $_POST['student_id'] . '"';
			if (execute_query($db, $sql)) {
				$msg .= '<span style="color:green; font-size:18px;">successfully verified....</span>';
			} else {
				$msg .= "Error: Update failed.";
			}
		}
	}else{

		if(isset($_POST['login_button'])){
			if($_POST['exam_form_no']!=''){	
				$sql = 'select * from exam_student_info where exam_form_no="'.$_POST['exam_form_no'].'" ';
				//echo $sql;
				$result = mysqli_query($db, $sql);
				$row_exam = mysqli_fetch_array($result);
					
					$response = 2;
				
			}else{
				$msg .=  '<script>alert("Incorrect Form Number" )</script>';
				$response=1;	
				}
		}
	}


page_header_start();
page_header_end();
page_sidebar();

switch ($response) {
    case 1:{
        ?>
        <div id="container" class="ltr">
			<h2 class="bg-secondary text-white text-center p-2 ">BACK FORM VERIFICATION</h2>
            <form id="loginform" name="login" class="wufoo page" autocomplete="off" enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                <?php echo $msg; ?>
                <table style="width: 100%;">
					<tr>
						<td style="width: 15%; font-size:20px; font-weight:bolder;">Form Number</td>
						<td style="width: 20%;">
							<input id="exam_form_no" name="exam_form_no" type="text" class="form-control bolding" 
								spellcheck="false" maxlength="20" tabindex="1" required 
								onBlur="checkname('exam_form_no')" 
								placeholder="Enter Form Number" />
						</td>
						<td style="width: 65%;" class="ps-2"><button id="login_button" name="login_button" class="btn btn-primary" type="submit" tabindex="3" 
								value="Login to Application Section">Search</button></td>
					</tr>
				</table>

                
            </form>
        </div>
        <?php
        break;
	}
    
    case 2:{
		if($row_exam['verify_status']=="1"){
	?>
	<style>
		.no_record {
    margin: 0;
    padding: 0;
    background: linear-gradient(to right, #f7c6c7, #fce0e3);
    font-family: Arial, sans-serif;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 50vh;
}

.container {
    text-align: center;
    animation: fadeIn 1s ease-in-out;
}

.message h1 {
    font-size: 2.5rem;
    color: #333;
}

.message p {
    font-size: 1.2rem;
    color: #555;
    margin: 20px 0;
}

.icon-container {
    margin: 20px 0;
}

.icon {
    width: 100px;
    animation: bounce 1s infinite;
}

.back-button {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #ff4757;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.back-button:hover {
    background-color: #e84118;
}

/* Animations */
@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-20px);
    }
    60% {
        transform: translateY(-10px);
    }
}
</style>
			
			<div class="no_record">
					<div class="container">
						<div class="message">
							<h1>Form Already Verify</h1>
							<p>Please Enter Another Form Number</p>
							<div class="icon-container">
								<img src="https://img.icons8.com/ios-filled/100/000000/search.png" alt="No Record Found" class="icon" />
							</div>
							<a href="exam_verify_status.php" class="back-button">Go Back</a>
						</div>
					</div>
	<?php
			
		}else{
	


        $sql = 'select * from student_info where university_uin="'.$row_exam['uin_no'].'" and dob="'.$row_exam['dob'].'"';
		//echo $sql;
		$result = mysqli_query($db, $sql);
		if(mysqli_num_rows($result)!=0) {
			$row = mysqli_fetch_array($result);
			$old_sno=$row['sno'];
			$sub_data = $row;
			//echo $sql;
			$sql2 = 'SELECT * FROM student_info2 WHERE type IN ("subject_change", "admission") AND student_id = '.$row['sno'];
			//echo $sql2;
			$result2 = mysqli_query($db, $sql2);
			if(mysqli_num_rows($result2)!=0){
				$row2 = mysqli_fetch_array($result2);
				$row['class'] = $row2['class'];
				$row['sub1'] = $row2['sub1'];
				$row['sub2'] = $row2['sub2'];
				$row['sub3'] = $row2['sub3'];
				$sub_data = $row2;
				
			}
			
		}
        ?>

	<div id="container" >

		
		
<!---Student info section-------------------------------------------------------------------------------------------------------------------------------->
			
		<form action="exam_verify_status.php" id="examForm" class="wufoo leftLabel page1" name="admission_newadmission" enctype="multipart/form-data" method="post" onSubmit="" >
				<?php echo $msg; ?>	
				<div class=" card  p-4" >
				
					<div class="row mt-1">							
						<div class="col-md-6">							
							<label>Candidate Name * </label>
							<input disabled type="text" name="candidate_name" id="candidate_name" class="form-control bolding bolding" value="<?php echo $row_exam['student_name']; ?>" tabindex="<?php echo $tabindex++;?>" style="pointer-events:none ;" required>
						</div>
						<div class="col-md-6">							
							<label>Father&#39;s Name* </label>
							<input disabled type="text" name="father_name" id="father_name" class="form-control bolding bolding " value="<?php echo $row['father_name']; ?>" style="pointer-events:none ;" required>
						</div>
					</div>
					<div class="row mt-1">
						<div class="col-md-6">							
							<label>Mother&#39;s Name</label>
							<input disabled type="text" name="mother_name" id="mother_name" class="form-control bolding bolding " style="pointer-events:none ;" value="<?php echo $row['mother_name']; ?>" required>
						</div>
						<div class="col-md-6">							
							<label>Date of Birth* </label>
							<input disabled type="text" id="dob" name="dob" readonly class="form-control bolding bolding">

							<script>
								// JavaScript code to populate the Date of Birth field and make it read-only
								document.addEventListener("DOMContentLoaded", function () {
									var dobInput = document.getElementById("dob");
									var defaultDate = '<?php echo $row['dob']; ?>';
									
									// Set the default value for the Date of Birth field
									dobInput.value = defaultDate;

									// Make the Date of Birth field read-only
									dobInput.readOnly = true;
								});
							</script>
						</div>
					</div>
					<div class="row mt-1">
						<div class="col-md-6">
							<label>Aadhar</label>
							<input disabled type="text" name="aadhar" style="pointer-events:none ;" id="aadhar" class="form-control bolding bolding " value="<?php echo $row_exam['aadhar']; ?>" tabindex="<?php echo $tabindex++;?>" style="pointer-events:none ;" required>
						</div>
						<div class="col-md-6">							
							<label>E-Mail</label>
							<input disabled type="text" name="email" id="email" class="form-control bolding bolding " value="<?php echo $row['e_mail1']; ?>" style="pointer-events:none ;" tabindex="<?php echo $tabindex++;?>"  required>
						</div>
					</div>
					<div class="row mt-1">
						<div class="col-md-6">							
							<label>Mobile</label>
							<input disabled type="text" name="mobile" id="mobile" class="form-control bolding bolding " value="<?php echo $row['mobile']; ?>" style="pointer-events:none ;" tabindex="<?php echo $tabindex++;?>" required>
						</div>
						<div class="col-md-6">							
							<label>Course Type</label>
							<?php
								$sql = 'select * from class_detail where sno ='.$row_exam['course_name'];
								$course_result = mysqli_fetch_assoc(mysqli_query($db, $sql));
							?>
							<input disabled type="text" name="course_type" id="course_type" class="form-control bolding bolding " value="<?php echo $course_result['category']; ?>" style="pointer-events:none ;" tabindex="<?php echo $tabindex++;?>" required>
						</div>
					</div>
					<div class="row mt-1">							
						<div class="col-md-6"	>	
							<label>Course Applying for</label>
							<input disabled type="text" name="course_applying_for" id="course_applying_for" class="form-control bolding bolding " value="<?php echo $course_result['class_description']; ?>" style="pointer-events:none ;" tabindex="<?php echo $tabindex++;?>" required>								
						</div>
						<div class="col-md-6">							
							<label>Category</label>
							<select disabled name="category" id="category" class="form-control bolding bolding" tabindex="<?php echo $tabindex++;?>" style="pointer-events: none;" required>
							<option disabled  <?php //echo isset($_GET['id'])? "":' selected = "selected" '?>>---Select Your Category---</option>
								<option value="GEN" <?php if($row['category']=="GEN"){ echo 'selected ';}?>>General</option>
								<option value="OBC" <?php if($row['category']=="OBC"){ echo 'selected ';}?>>OBC</option>
								<option value="SC" <?php if($row['category']=="SC"){ echo 'selected ';}?>>SC</option>
								<option value="ST" <?php if($row['category']=="ST"){ echo 'selected ';}?>>ST</option>
								<option value="EWS" <?php if($row['category']=="EWS"){ echo 'selected ';}?>>EWS</option>
							</select>
						</div>
					</div>
					<div class="row mt-1">
					<div class="col-md-6">


						<label for="selectOption">Religion</label>
								<input disabled type="text" name="religion" id="religion" class="form-control bolding bolding " value="<?php echo $row_exam['religion']; ?>"  tabindex="<?php echo $tabindex++;?>" >

							
					</div>

						
						<div class="col-md-6">
							
							<label for="selectOption">Gender</label>
							<input disabled type="text" name="gender" id="gender" class="form-control bolding bolding " value="<?php
							if($row['gender'] == ("M"||"m")){
								echo "Male"; 
							}
							elseif($row['gender'] == ("F"||"f")){
								echo "Female"; 
							}
							else{
								echo $row['gender'];
							}
							?>" style="pointer-events:none ;" tabindex="<?php echo $tabindex++;?>" required>
							
						</div>
					</div>
					<div class="row mt-1">
						<div class="col-md-6">	
							<label>Whatsapp Mobile No.</label>
							<input disabled type="text" name="caste" id="caste" class="form-control bolding bolding " value="<?php echo $row_exam['whatsapp_no']; ?>" pattern=[0-9]{10} minlength="10" maxlength="10" tabindex="<?php echo $tabindex++;?>"  required />
							
						</div>
						<div class="col-md-6">							
							<label>PARENT'S Mobile No.</label>
							<input disabled type="text" name="parent_income" id="parent_income" class="form-control bolding bolding " pattern=[0-9]{10} minlength="10" maxlength="10" value="<?php echo $row_exam['p_mobile']; ?>" tabindex="<?php echo $tabindex++;?>" required>
						</div>
					</div>
					<div class="row mt-1">
						
					
						<div class="col-md-6">
							
							<label for="selectOption">DOMICILE</label>
								<input disabled type="text" name="domicile" id="domicile" class="form-control bolding bolding " value="<?php echo $row['p_state']; ?>" pattern=[0-9]{10} minlength="10" maxlength="10" tabindex="<?php echo $tabindex++;?>"  required />

							<script>
								function validateForm() {
									var selectedOption = document.getElementById('domicile').value;
									if (selectedOption === "") {
										alert("Please select Domicile");
										return false;
									}
									return true;
								}
							</script>
							
						</div>
						<div class="col-md-6">							
							<label>MOTHER TONGUE</label>
							<select disabled name="mother_tongue" id="mother_tongue" class="form-control bolding bolding" tabindex="<?php echo $tabindex++;?>" required>
								<option value="hindi" <?php if($row['mother_tongue']=="hindi"){ echo 'selected ';}?>>Hindi</option>
								<option value="english" <?php if($row['mother_tongue']=="english"){ echo 'selected ';}?>>English</option>
								
							</select>
						</div>
					</div>
					<div class="row mt-1">
						
						
						
						
						
						<div class="col-md-6">
							
							<label for="selectOption">Blood Group</label>
								<select disabled name="blood_group" id="blood_group" class="form-control bolding bolding" tabindex="<?php echo $tabindex++;?>" required>
									<option value="N/A" <?php if($row['blood_group']==''){ echo 'selected ';}?>>N/A</option>
									<option value="N/A" <?php if($row['blood_group']=="N/A"){ echo 'selected ';}?>>N/A</option>
									<option value="A+" <?php if($row['blood_group']=="A+"){ echo 'selected ';}?>>A+</option>
									<option value="A-" <?php if($row['blood_group']=="A-"){ echo 'selected ';}?>>A-</option>
									<option value="B+" <?php if($row['blood_group']=="B+"){ echo 'selected ';}?>>B+</option>
									<option value="B-" <?php if($row['blood_group']=="B-"){ echo 'selected ';}?>>B-</option>
									<option value="AB+" <?php if($row['blood_group']=="AB+"){ echo 'selected ';}?>>AB+</option>
									<option value="AB-" <?php if($row['blood_group']=="AB-"){ echo 'selected ';}?>>AB-</option>
									<option value="O+" <?php if($row['blood_group']=="O+"){ echo 'selected ';}?>>O+</option>
									<option value="O-" <?php if($row['blood_group']=="O-"){ echo 'selected ';}?>>O-</option>
								</select>

							<script>
								function validateForm() {
									var selectedOption = document.getElementById('blood_group').value;
									if (selectedOption === "") {
										alert("Please select Blood Group");
										return false;
									}
									return true;
								}
							</script>
							
						</div>
						<div class="col-md-6">	
							<label>College Roll No.</label>
							<input disabled type="text" name="college_roll_no" id="roll_no" class="form-control bolding bolding " value="<?php echo $row['roll_no']; ?>" tabindex="<?php echo $tabindex++;?>" required>
						</div>
					</div>
					<div class="row mt-1">
						
						<div class="col-md-6">	
							<label>Status</label>
							<input disabled type="text" name="student_type" id="student_type" class="form-control bolding bolding " pattern=[0-9]{10} minlength="10" maxlength="10" value="<?php echo $row_exam['student_type']; ?>" tabindex="<?php echo $tabindex++;?>" required>
						</div>
						<div class="col-md-6">	
							
						</div>
						
					</div>
					<div class="row mt-1">
						<div class="col-md-6">
						<?php
							if($course_result['semester']== "1"){
									$sql = 'select * from admission_student_info where uin ="'.$row['university_uin'].'"';
									$result_img = mysqli_fetch_assoc(mysqli_query($uin_link, $sql));
								}else{
									$sql = 'select * from admission_student_info where uin ="'.$row['university_uin'].'"';
									$result_img = mysqli_fetch_assoc(mysqli_query($db2, $sql));
								}
						?>
							<label>Photo</label>
							<img src="<?php echo $result_img['photo']; ?>" alt="person Pic" class="img-fluid " style="height: 150px;">
						</div>
						
						<div class="col-md-6">
							<label>Signature</label>
							<img src="<?php echo $result_img['signature']; ?>" alt="person Pic" class="img-fluid " style="height: 120px; width: 300px;">

						</div>
						<div class="col-md-6">
							
						</div>
					</div>
					
				</div>
				
			</div>

		<div  name="info_table" id="info_table " class="card p-2">
				<table width="100%" class="table table-striped-primary table-hover rounded ">	
					<tr class="bg-secondary text-white ">
						<th colspan="6" class="h5"><strong>Permanent Address</strong></th>
					</tr>
					<tr class="table-secondary">
						<input disabled type="hidden" name="p_sno" value="<?php echo $row['sno']; ?>">
						<th>House No./Village</th>
						<td><input disabled type="text"  class="form-control bolding bolding" id="p_address" name="p_address" value="<?php if($row['p_house_no'] != $row['p_village']){
							echo $row['p_house_no'].$row['p_village'];
							}
							else {
								echo $row['p_house_no'];
							}
						?>"  required></td>
						<th>Post</th>
						<td><input disabled type="text" class="form-control bolding bolding" id="p_post" name="p_post" value="<?php echo $row['p_post']; ?>" required></td>
						<th>Tahsil</th>
						<td><input disabled type="text" class="form-control bolding bolding" id="p_tehsil" name="p_tehsil" value="<?php echo $row['p_tehsil']; ?>" required></td>
					</tr>
					<tr>
						<th>Thana</th>
						<td><input disabled type="text" class="form-control bolding bolding" id="p_thana" name="p_thana" value="<?php echo $row['p_thana']; ?>" required></td>
						<th>District</th>
						<td><input disabled type="text" class="form-control bolding bolding" id="p_district" name="p_district" value="<?php echo $row['p_district']; ?>" required></td>
						<th>State</th>
						<td><input disabled type="text" class="form-control bolding bolding" id="p_state" name="p_state" value="<?php echo $row['p_state']; ?>" required></td>
					</tr>
					<tr>

						<th>Pin</th>
						<td><input disabled type="text" class="form-control bolding bolding"  id="p_pin" name="p_pin" value="<?php echo $row['p_pin']; ?>" required></td>
					</tr>
					<tr class="bg-secondary text-white">
						<th colspan="6" class="h5" >Correspondence Address </th>
					</tr>
					<tr class="table-secondary">
						<input disabled type="hidden" name="c_sno" value="<?php echo $row['sno']; ?>">
						<th>House No./Village</th>
						<td><input disabled type="text" class="form-control bolding bolding" id="c_address" name="c_address" value="<?php echo $row['c_address']; ?>" required></td>
						<th>Post</th>
						<td><input disabled type="text" class="form-control bolding bolding" id="c_post" name="c_post" value="<?php echo $row['c_post']; ?>" required></td>
						<th>Tahsil</th>
						<td><input disabled type="text" class="form-control bolding bolding" id="c_tehsil" name="c_tehsil" value="<?php echo $row['c_tehsil']; ?>" required></td>

					</tr>
					<tr>
						<th>Thana</th>
						<td><input disabled type="text" class="form-control bolding bolding" id="c_thana" name="c_thana" value="<?php echo $row['c_thana']; ?>" required></td>
						<th>District</th>
						<td><input disabled type="text" class="form-control bolding bolding" id="c_district" name="c_district" value="<?php echo $row['c_district']; ?>" required></td>
						<th>State</th>
						<td><input disabled type="text" class="form-control bolding bolding" id="c_state" name="c_state" value="<?php echo $row['c_state']; ?>" required></td>
					</tr>
					<tr>
						<th>Pin</th>
						<td><input disabled type="text" class="form-control bolding bolding"  id="c_pin" name="c_pin" value="<?php echo $row['c_pin']; ?>" required></td>
					</tr>

				</table>
			
					
			
			<div class="row">
				<div class="col-md-12">
					<div class="bg-secondary  p-3 my-2" ><span style="font-size:20px;color:aliceblue;margin-right:30px;" class="bolding">Subject & Paper Details</span><button class=" blinking-css btn btn-danger"><b>(Carefully Read and Submit)</b> </button></div>

					<table class="table  table-bordered table-striped " width="100%">
						<tr class="bg-secondary text-white">
							<th width="7%" class="bolding">S. No.</th>
							<th width="15%" class="bolding">TYPE</th>
							<th width="18%" class="bolding">SUBJECT</th>
							<th width="15%" class="bolding">PAPER CODE </th>
							<th width="35%" class="bolding">PAPER NAME </th>
							<th width="10%" class="bolding">CREDIT</th>
						</tr>
						<?php
								$i=1;
								$sql = 'select * from  exam_student_paper_info where exam_student_info_sno="'.$row_exam['sno'].'"';

								$result_paper=mysqli_query($db, $sql);
								//echo $sql;
								while($row_paper=mysqli_fetch_array($result_paper)){
										if ($row_paper['type_status'] == 1) {
											$exam_sub = 'SELECT * FROM `add_subject` WHERE `sno` = "' . $row_paper['subject_id'] . '" ';
										} else {
											$exam_sub = 'SELECT * FROM `add_subject2` WHERE `sno` = "' . $row_paper['subject_id'] . '" ';
										}

										$exam_subject = mysqli_query($db, $exam_sub);
										$subject_name = mysqli_fetch_assoc($exam_subject);
								?>
						<tr>
								<td style="text-align:center;">
									<?php echo $i++;?> 
								</td>
								<td style="text-align:center;">
									<?php echo $row_paper['type'];?> 
								</td>
								<td>
									<?php echo $subject_name['subject'];?> 
								</td>
								<td>
									<?php echo $row_paper['paper_code'];?> 
								</td>
								<td>
									<?php echo $row_paper['title_of_paper'];?> 
								</td>
								<td>
									<?php echo $row_paper['credit'];?> 
								</td>
								
							</tr>
							<?php
							}			
								?>
					</table>
						



					<input type="hidden" name="student_id" value="<?php echo $row_exam['sno']; ?>" />
					
					<center>
					  <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure you want to verify the form?')" name="submit" value="Submit">
						Proceed to Verify
					  </button>
					</center><br>

				</div>
			</div>

			
		</form>
</div>
	
	</div>
</div> 
<?php 
		}
		break;
	}
	}


page_footer_start();
page_footer_end();


	ob_end_flush();
?>
