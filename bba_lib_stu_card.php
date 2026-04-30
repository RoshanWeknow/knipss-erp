<?php 
//include("scripts/settings.php");
include("bba_lib_setting.php");
$msg = '';
$rdate = date("d/m/Y", strtotime("+15 days"));
// page_header_start();
// page_header_end();
// page_sidebar();
header_lib();
?>
<?php
include('lib_card_image_upload.php');
include "lib_card_phpqrcode/qrlib.php";

$res='';
if(isset($_POST['name'])){
  $target_dir = 'lib_card_upload_img/';
  if(!is_dir($target_dir)){
    mkdir($target_dir);
  }
}
$conn = $db;
if(!$conn){
	echo "connection failed<br>";
	die();
}
if(isset($_POST['submit2'])){
	if(isset($_POST['edit']) && $_POST['edit'] != ''){
		$sql = 'update bba_bba_lib_id_card set 
				name = "'.$_POST['name'].'" ,
				course_enrolled = "'.$_POST['course_enrolled'].'" ,
				session = "'.$_POST['session'].'" ,
				enrollment_no = "'.$_POST['enrollment_no'].'" ,
				date = "'.$_POST['date'].'" ,
				address = "'.$_POST['address'].'" ,
				dob = "'.$_POST['dob'].'" ,
				email = "'.$_POST['email'].'" ,
				mobno = "'.$_POST['mobno'].'" ,
				fname = "'.$_POST['fname'].'" ,
				address_perma = "'.$_POST['address_perma'].'",
				date_of_issue = "'.$_POST['date_of_issue'].'",
				lib_no = "'.$_POST['lib_no'].'",
				profile = "'.$_POST['profile'].'"
				
				 where sid = '.$_POST['edit'];
	
		mysqli_query($conn, $sql);
		if(mysqli_errno($conn)){
			echo "Updation failed".mysqli_errno($conn).mysqli_error($conn)."<br>";
		}
		else{
			 //echo "Successfully updated<br>";
		}
	}
	else{
		//inserting value to database
		$sql = 'insert into bba_lib_id_card (name, course, course_catagory, course_session, lib_card_no, valid_upto, address, dob, email, mobile, father_name, address_perma, date_of_issue,profile,lib_no) value("'.$_POST['name'].'", "'.$_POST['course_enrolled'].'", "'.$_POST['course_type'].'", "'.$_POST['session'].'", "'.$_POST['roll_no'].'", "'.$_POST['valid_up_to'].'", "'.$_POST['address'].'", "'.$_POST['dob'].'", "'.$_POST['email'].'", "'.$_POST['mobno'].'", "'.$_POST['father_name'].'", "'.$_POST['address_perma'].'", "'.$_POST['date_of_issue'].'", "'.$_POST['profile'].'", "'.$_POST['lib_no'].'")';
		// echo $sql;
	
		mysqli_query($conn, $sql);


		/* setting image name equal to its id code by saurabh sir  */
		$id = mysqli_insert_id($conn);


		if(mysqli_errno($conn)){
			echo "Insertion failed".mysqli_errno($conn).mysqli_error($conn)."<br>";
		}
		else{
			//echo "Data inserted <br>";

			/* image saving to dir command */
			
				echo'<h4 style="color: green;" >Library Card Generated</h4>';
				
		}
		

		/* inserting qr code here */

	
		//echo $id."id is here<br>";
		$PNG_TEMP_DIR = 'lib_card_qr_image/';
		if (!file_exists($PNG_TEMP_DIR)){
			mkdir($PNG_TEMP_DIR);
		}

		$filename = $id.'.png';
		//echo $filename."filename <br> ";
		
		if (isset($_POST["name"])) {
			
			$codeString = "Name of Student - ".$_POST["name"] . "\n";
			$codeString .= "Course Enrolled by Student - ".$_POST["course_enrolled1"] . "\n";
			$codeString .= "Session of the Student - ".$_POST["session"] . "\n";
			$codeString .= "Enrollment of the Student - ".$_POST["roll_no"] . "\n";
			$codeString .= "Address of the Student - ".$_POST["address"] . "\n";
			$codeString .= "Date of Birth of the Student  - ".$_POST["dob"] . "\n";
			$codeString .= "Email of the Student - ".$_POST["email"] . "\n";
			$codeString .= "Mobile no. of the Student  - ".$_POST["mobno"] . "\n";
			$codeString .= "Father's name of the Student - ".$_POST["father_name"] . "\n";
			$codeString .= "Permanent Address of the Student - ".$_POST["address_perma"] . "\n";
			$codeString .= "Date of Issue this card is -".$_POST["date_of_issue"];
			
			/* $filename = $PNG_TEMP_DIR . 'test' . '.png'; */
			//echo $filename."filename <br> ";
			
			QRcode::png($codeString, $PNG_TEMP_DIR.$filename);
			
			
			//echo $PNG_TEMP_DIR . basename($filename) ."filename <br> ";

			// if($res["error"]!=0){
				$sql = "update bba_lib_id_card set qr_code = '". $filename."' where sno = ".$id;
				//echo $sql;
				mysqli_query($conn,$sql);
				if(mysqli_errno($conn)){
					echo "qr Insertion failed".mysqli_errno($conn).mysqli_error($conn)."<br>";
				} 

			// }
		}
	}
}
?> 
<style>
.frmSearch {
    background-color: #c6f7d0;
    margin: 2px 0px;
    border-radius: 4px;
}

#roll-list {
    float: left;
    list-style: none;
    margin-top: -3px;
    padding: 0;
    width: 190px;
    position: absolute;
	z-index: 10;
}

#roll-list li {
    padding: 10px;
    background: #f0f0f0;
    border-bottom: #bbb9b9 1px solid;
}

#roll-list li:hover {
    background: #ece3d2;
    cursor: pointer;
}

#search-box, #accession_no {
    padding: 10px;
    border: #a8d4b1 1px solid;
    border-radius: 4px;
}

</style>
	<!--dashboard area-->
		<div class="card row" style="--bs-gutter-x: 0.1rem !important;">
			<div class="col-md-12">
				<div class="issue-wrapper">
					<form action="<?php echo $_SERVER['PHP_SELF']?>" class="wufoo leftLabel page1" name="feesdeposit"  enctype="multipart/form-data" method="post" onSubmit="" autocomplete="off">
					<div class="bg-primary text-white p-2"><h3>Library Card</h3></div>
						<table  width="100%" class="table">
							<tr>
								<td class="" width="20%">
									<div class="frmSearch">
										<input type="text" class="form-control" name="roll_no" id="search-box" placeholder="Roll No"/>
										<div id="suggesstion-box"></div>
										<script>
										function select_roll_no(val) {
											console.log(val);
											$("#search-box").val(val);
											$("#suggesstion-box").hide();
										}
										</script>
									</div>
								</td>
								<td width="10%">
									<button type="submit" class="btn btn-info" value="" placeholder="Search" name="submit1">Search</button>
								</td>
								<td width="70%"></td>
							</tr>
						</table>
						 <?php 
							if (isset($_POST["submit1"])) {
								$sql  = 'select * from student_info where roll_no = "'.$_POST['roll_no'].'"';
								$dept_list = execute_query($db, $sql);
								if($dept_list && mysqli_num_rows($dept_list)>0){
									while($row5 = mysqli_fetch_assoc($dept_list)){
									   $stu_name      = $row5['stu_name']; 
									   $dob       = $row5['dob'];
									   $batch   = $row5['batch'];
									   $course_type   = $row5['class_type'];
									   $course_enrolled   = $row5['class'];
									   $e_mail1     = $row5['e_mail1'];
									   $session     = $row5['batch'];
									   $roll_no     = $row5['roll_no'];
									   $mobile     = $row5['mobile'];
									   $address     = $row5['p_address'];
									   $father_name     = $row5['father_name'];
									   $photo_id     = $row5['photo_id'];
									   $full_path_photo = "PHOTO/";
						?>
						<table width="100%" class="table table-striped table-hover rounded">
							<tr>
								<th>Roll No.</th>
								<td>
								   <input type="text" class="form-control" name="roll_no" value="<?php echo $_POST['roll_no']; ?>"  required  readonly> 
								</td>
								<th>Student Name</th>
								<td>
								   <input type="stu_name" class="form-control" name="name" value="<?php echo $stu_name; ?>"  required > 
								</td>
								<?PHP
									$sql1 = 'select * from class_detail where sno = '.$course_enrolled;
									$course_list = execute_query($db, $sql1);
									$res_course = mysqli_fetch_assoc($course_list);
									$course_type1 = $res_course['type'];
									$course_enrolled1 = $res_course['class_description'];
								?>
								<th>Course Type</th>
								<td>
								   <input type="text" class="form-control" name="course_type" value="<?php echo $course_type1; ?>" required  > 
								</td>
							</tr>
							<tr>	
								<th>Course</th>
								<td>
								   <input type="text" class="form-control" name="course_enrolled" value="<?php echo $course_enrolled1; ?>">
								</td>
								<th>Session</th>
								<td>
								   <input type="text" class="form-control" name="session"  value="<?php echo $session; ?>" required > 
								</td>
								<th>Mobile No.</th>
								<td>
								   <input type="text" class="form-control" name="mobno"  value="<?php echo $mobile; ?>" required > 
								</td>
							</tr>
							<tr>	
								<th>Email</th>
								<td>
								   <input type="text" class="form-control" name="email"  value="<?php echo $e_mail1; ?>"> 
								</td>
							
								<th>Date Of Birth</th>
								<td>
									<input type="text" class="form-control" id="dob" name="dob"  value="<?php echo $dob; ?>" required >
								</td>
								<th>Address</th>
								<td>
									<input type="text" class="form-control" name="address" id="address" value="<?php echo $address; ?>" required />	
								</td>
							</tr>
							<tr>	
								<th>Father Name</th>
								<td>
								   <input type="text" class="form-control" name="father_name" id="father_name"  value="<?php echo $father_name; ?>" required /> 
								</td>
								<th>Date Of Issue</th>
									<td>
									   <input type="date" class="form-control" id="date_of_issue" name="date_of_issue" value="<?php echo date('Y-m-d'); ?>" required>
									</td>
									<th>Valid Up To</th>
									<td>
									   <input type="date" class="form-control" id="valid_up_to" name="valid_up_to" value="<?php echo $date; ?>" required>
									</td>

									<script>
									   document.getElementById('date_of_issue').addEventListener('change', function() {
										   var dateOfIssue = new Date(this.value);
										   var validUpTo = new Date(dateOfIssue);
										   validUpTo.setFullYear(validUpTo.getFullYear() + 1);
										   var year = validUpTo.getFullYear();
										   var month = ('0' + (validUpTo.getMonth() + 1)).slice(-2);
										   var day = ('0' + validUpTo.getDate()).slice(-2);
										   document.getElementById('valid_up_to').value = year + '-' + month + '-' + day;
									   });

									   // Trigger the change event on page load to set the initial value
									   document.getElementById('date_of_issue').dispatchEvent(new Event('change'));
									</script>

							</tr>
							<tr>
								<th>Permanent Address</th>
								<td>
								   <input type="text" class="form-control" name="address_perma"  value="<?php echo $row5['p_address'].$row5['p_district'].$row5['p_pin']; ?>"> 
								</td>
								<th>Upload Photo</th>
								<td>
								   <!-- File Input 
									<input type="file" class="form-control" name="profile" id="profile" required value="<?php echo $photo_id; ?>">-->
									<input type="hidden" class="form-control" name="profile" value="<?php echo $full_path_photo . $photo_id; ?>" id="profile" readonly>
									<!-- Image Preview -->
									<img id="profilePreview" src="<?php echo $full_path_photo . $photo_id; ?>" alt="Profile Preview" style="max-width: 200px; margin-top: 10px; display: <?php echo $photo_id ? 'block' : 'none'; ?>;">

									<script>
										// Handle file input change event to preview selected image
										document.getElementById('profile').addEventListener('change', function(event) {
											var file = event.target.files[0];
											if (file) {
												var reader = new FileReader();
												reader.onload = function(e) {
													var profilePreview = document.getElementById('profilePreview');
													profilePreview.src = e.target.result;
													profilePreview.style.display = 'block';
												};
												reader.readAsDataURL(file);
											}
										});

										// Display the preview if a photo_id is already set on page load
										window.onload = function() {
											var photoId = "<?php echo $full_path_photo . $photo_id; ?>";
											if (photoId) {
												var profilePreview = document.getElementById('profilePreview');
												profilePreview.src = photoId;
												profilePreview.style.display = 'block';
											}
										};
									</script>


								</td>
								<th>Library Card No.</th>
								<td>
								   <input type="text" class="form-control" name="lib_no"  value="" required > 
								</td>
							</tr>
							<tr>
								<td>
								   <input type="submit" name="submit2" class="btn btn-primary" value="Submit" class="ms-4 mt-4"> 
								</td>
							</tr>
						</table>
					  <?php
									}			
							}
						}
				?>
					</form>
				</div>
			</div>
		</div>
<!-- Add your existing HTML and PHP code for the select dropdown and submit button here -->
<!-- Make sure you include the necessary JavaScript libraries like jQuery for AJAX -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet">
<script src='https://cdn.rawgit.com/pguso/jquery-plugin-circliful/master/js/jquery.circliful.min.js'></script>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
<script>
    $(document).ready(function() {
		//-----------------------------------------
		
		$("#search-box").keyup(function() {
			$.ajax({
				type: "POST",
				url: "testing_autocomplete.php",
				data: 'keyword=' + $(this).val(),
				beforeSend: function() {
					$("#search-box").css("background", "#FFF url(LoaderIcon.gif) no-repeat 165px");
				},
				success: function(data) {
					$("#suggesstion-box").show();
					$("#suggesstion-box").html(data);
					$("#search-box").css("background", "#FFF");
				}
			});
		});
		$("#accession_no").keyup(function() {
			$.ajax({
				type: "POST",
				url: "testing_autocomplete.php",
				data: 'accession_keyword=' + $(this).val(),
				beforeSend: function() {
					$("#accession_no").css("background", "#FFF url(LoaderIcon.gif) no-repeat 165px");
				},
				success: function(data) {
					$("#a_suggesstion-box").show();
					$("#a_suggesstion-box").html(data);
					$("#accession_no").css("background", "#FFF");
				}
			});
		});
		
		//-----------------------------------------
        // Attach a change event listener to the select element
        $('#roll_no').change(function() {
            var selectedRollNo = $(this).val(); // Get the selected roll number
            
            // Make an AJAX request to fetch data based on the selected roll number
            $.ajax({
                url: 'get_student_details.php', // PHP script to handle the AJAX request
                type: 'GET', // or 'POST' depending on your setup
                data: { roll_no: selectedRollNo }, // Send the selected roll number as a parameter
                success: function(response) {
                    // Handle the response data and update the UI as needed
                    // You can update the details in the third column of the table here
                    $('#student_details').html(response);
                }
            });
        });
    });
</script>
<?php
// page_footer_start();
// page_footer_end();
footer_lib();
?>