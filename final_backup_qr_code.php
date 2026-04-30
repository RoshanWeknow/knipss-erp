<?php 
include("scripts/settings.php");
include("exam_crosslist_marksheet_functions.php");

?>
<?php
//include('lib_card_image_upload.php');
include "lib_card_phpqrcode/qrlib.php";

$res='';
// if(isset($_POST['name'])){
  // $target_dir = 'lib_card_upload_img/';
  // if(!is_dir($target_dir)){
    // mkdir($target_dir);
  // }
// }
$conn = $db;
if(!$conn){
	echo "connection failed<br>";
	die();
}
if(isset($_POST['submit2'])){


		/* inserting qr code here */

	
		//echo $id."id is here<br>";
		$PNG_TEMP_DIR = 'exam_student_qr_image/';
		if (!file_exists($PNG_TEMP_DIR)){
			mkdir($PNG_TEMP_DIR);
		}
		$id = $_POST["mobno"];
		$filename = $id.'.png';
		//echo $filename."filename <br> ";
		
		if (isset($_POST["name"])) {
			
			$codeString = "Name  - ".$_POST["name"] . "\n";
			$codeString .= "Father's name - ".$_POST["father_name"] . "\n";
			$codeString .= "Course Enrolled - ".$_POST["course_enrolled1"] . "\n";
			$codeString .= "Exam Roll No. - ".$_POST["session"] . "\n";
			$codeString .= "UIN Number - ".$_POST["roll_no"] . "\n";
			$codeString .= "Address of the Student - ".$_POST["address"] . "\n";
			$codeString .= "Date of Birth of the Student  - ".$_POST["dob"] . "\n";
			$codeString .= "Email of the Student - ".$_POST["email"] . "\n";
			$codeString .= "Mobile no. of the Student  - ".$_POST["mobno"] . "\n";
			
			$codeString .= "Permanent Address of the Student - ".$_POST["address_perma"] . "\n";
			$codeString .= "Date of Issue this card is -".$_POST["date_of_issue"];
			
			/* $filename = $PNG_TEMP_DIR . 'test' . '.png'; */
			//echo $filename."filename <br> ";
			
			QRcode::png($codeString, $PNG_TEMP_DIR.$filename);
			
			
			//echo $PNG_TEMP_DIR . basename($filename) ."filename <br> ";

			// if($res["error"]!=0){
				//$sql = 'update lib_id_card set qr_code = "'. $filename.'" where sno = "'.$id.'"';
				//echo $sql;
				// mysqli_query($conn,$sql);
				// if(mysqli_errno($conn)){
					// echo "qr Insertion failed".mysqli_errno($conn).mysqli_error($conn)."<br>";
				// } 

			// }
		}
	
}
?> 
<form method="POST" enctype="multipart/form-data">
  <label>Name of Student:</label>
  <input type="text" name="name" required><br><br>

  <label>Course Enrolled:</label>
  <input type="text" name="course_enrolled1" required><br><br>

  <label>Session:</label>
  <input type="text" name="session" required><br><br>

  <label>Enrollment / Roll No.:</label>
  <input type="text" name="roll_no" required><br><br>

  <label>Address:</label>
  <input type="text" name="address" required><br><br>

  <label>Date of Birth:</label>
  <input type="date" name="dob" required><br><br>

  <label>Email:</label>
  <input type="email" name="email" required><br><br>

  <label>Mobile No.:</label>
  <input type="text" name="mobno" required><br><br>

  <label>Father's Name:</label>
  <input type="text" name="father_name" required><br><br>

  <label>Permanent Address:</label>
  <input type="text" name="address_perma" required><br><br>

  <label>Date of Issue:</label>
  <input type="date" name="date_of_issue" required><br><br>

  <input type="submit" name="submit2" value="Generate QR & Submit">
</form>
