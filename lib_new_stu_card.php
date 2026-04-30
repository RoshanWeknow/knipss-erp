<?php 
//include("scripts/settings.php");
include("lib_setting.php");
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
		$sql = 'update lib_card set 
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
		$sql = 'insert into lib_id_card (name, course, course_catagory, course_session, lib_card_no, valid_upto, address, dob, email, mobile, father_name, address_perma, date_of_issue,lib_no) value("'.$_POST['name'].'", "'.$_POST['course_enrolled1'].'", "'.$_POST['course_type'].'", "'.$_POST['session'].'", "'.$_POST['roll_no'].'", "'.$_POST['valid_up_to'].'", "'.$_POST['address'].'", "'.$_POST['dob'].'", "'.$_POST['email'].'", "'.$_POST['mobno'].'", "'.$_POST['father_name'].'", "'.$_POST['address_perma'].'", "'.$_POST['date_of_issue'].'", "'.$_POST['lib_no'].'")';
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
			$res = upload_img1($_FILES['profile'],$target_dir,$id);

			if($res["error"]!=0){
				$sql = "update lib_id_card set profile = '". $res["file_name"]."' where sno = ".$id;
				//echo $sql."<br>";
				mysqli_query($conn,$sql);
				if(mysqli_errno($conn)){
					echo "Image Insertion failed".mysqli_errno($conn).mysqli_error($conn)."<br>";
				}
				else{
				echo'<h4 style="color: green;" >Library Card Generated</h4>';
				}
			}
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

			if($res["error"]!=0){
				$sql = "update lib_id_card set qr_code = '". $filename."' where sno = ".$id;
				//echo $sql;
				mysqli_query($conn,$sql);
				if(mysqli_errno($conn)){
					echo "qr Insertion failed".mysqli_errno($conn).mysqli_error($conn)."<br>";
				} 

			}
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
						
						<table width="100%" class="table table-striped table-hover rounded">
							<tr>
								<th> Type of Card</th>
								<td>
									<select name="roll_no" id="roll_no" class="form-control" >
									  <option value="">-----Select-----</option>
									  <option value="Teacher">Teacher</option>
									  <option value="Non-Teaching">Non-Teaching</option>
									  <option value="Other">Other</option>
									</select>
								</td>
								<th>Full Name</th>
								<td>
								   <input type="stu_name" class="form-control" name="name" value=""  required > 
								</td>
								
								<th>Course Type</th>
								<td>
								   <input type="text" class="form-control" name="course_type" value="" required  > 
								</td>
							</tr>
							<tr>	
								<th>Course</th>
								<td>
								   <input type="text" class="form-control" name="course_enrolled1" value="" required  > 
								</td>
								<th>Session</th>
								<td>
								   <input type="text" class="form-control" name="session"  value="" required > 
								</td>
								<th>Mobile No.</th>
								<td>
								   <input type="text" class="form-control" name="mobno"  value="" required > 
								</td>
							</tr>
							<tr>	
								<th>Email</th>
								<td>
								   <input type="text" class="form-control" name="email"  value=""> 
								</td>
							
								<th>Date Of Birth</th>
								<td>
									<input type="date" class="form-control" id="dob" name="dob"  value="" required >
								</td>
								<th>Address</th>
								<td>
									<input type="text" class="form-control" name="address" id="address" value="" required />	
								</td>
							</tr>
							<tr>	
								<th>Father Name</th>
								<td>
								   <input type="text" class="form-control" name="father_name" id="father_name"  value="" required /> 
								</td>
								<th>Date Of Issue</th>
									<td>
									   <input type="date" class="form-control" id="date_of_issue" name="date_of_issue" value="" required>
									</td>
									<th>Valid Up To</th>
									<td>
									   <input type="date" class="form-control" id="valid_up_to" name="valid_up_to" value="" required>
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
								   <input type="text" class="form-control" name="address_perma"  value=""> 
								</td>
								<th>Upload Photo</th>
								<td>
								   <!-- File Input -->
									<input type="file" class="form-control" name="profile" id="profile" required>

									<!-- Image Preview -->
									<img id="profilePreview" " alt="Profile Preview" style="max-width: 200px; margin-top: 10px; display: none;">

									<script>
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

									// Display the preview if a photo_id is already set
									window.onload = function() {
										var photoId = "<?php echo $photo_id; ?>";
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
					
					</form>
				</div>
			</div>
		</div>

<?php
// page_footer_start();
// page_footer_end();
footer_lib();
?>