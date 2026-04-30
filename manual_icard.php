<?php
//session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
logvalidate('admin');
page_header_start();
$msg='';
if(isset($_POST['submit'])){
    $link = connect();
    //print_r($_POST);
	if($_POST['stu_name']=='' && $_POST['class']==''){
		$msg='<li style="color:red"><b>Please Fill Student Details</b></li>';
	}
	elseif($_POST['student_id'] !=''){
		$sql="UPDATE `student_info_mannul_icard` SET `stu_name`='".$_POST['stu_name']."',`father_name`='".$_POST['father_name']."',`class`='".$_POST['class']."',`dob`='".$_POST['dob']."',`mobile`='".$_POST['mobile']."',`gender`='".$_POST['gender']."'
		,`post`='".$_POST['address']."',`sub1`='".$_POST['sub1']."',`e_mail1`='".$_POST['email_id']."',`roll_no`='".$_POST['roll_no']."',`blood_group`='".$_POST['blood_group']."',`aadhar`='".$_POST['aadhar']."', date_of_admission='".$_POST['icard_date']."' where sno='".$_POST['student_id']."'";
		execute_query($link, $sql);
		//echo $sql;
		if(!mysqli_error($link)){
			$pic_sno = $_POST['student_id'];
			$msg='<li style="color:red"><b> Student Details Update Succesful</b></li>';
			$msg .= '<li class="error"><a href="manual_icard_print.php?id='.$pic_sno.'" target="_blank">Click Here to print.</a></li>';
			$msg .= '<script>window.open("manual_icard_print.php?id='.$pic_sno.'");</script>';
		}
		else{
		    $msg .='<li style="color:#f00">Error # 12.02 : '.mysqli_error($link).' >> '.$sql.'</li>';
		}

	}
	else{
		
		$sql="INSERT INTO `student_info_mannul_icard`( `stu_name`, `father_name`,`class`, `dob`, `mobile`,`date_of_admission`, `gender`,`post`, `sub1`, `e_mail1`,`roll_no`, `blood_group`,`aadhar`) VALUES ('".$_POST['stu_name']."','".$_POST['father_name']."','".$_POST['class']."','".$_POST['dob_date']."','".$_POST['mobile']."','".$_POST['icard_date']."','".$_POST['gender']."','".$_POST['address']."','".$_POST['sub1']."','".$_POST['email_id']."','".$_POST['roll_no']."','".$_POST['blood_group']."','".$_POST['aadhar']."')";
		 
	     if(execute_query(connect(), $sql)==true){
	     	$pic_sno = mysqli_insert_id(connect());
	     	$msg='<li style="color:red"><b> Student Details Inserted Succesful</b></li>';
			$msg .= '<li class="error"><a href="manual_icard_print.php?id='.$pic_sno.'" target="_blank">Click Here to print.</a></li>';
	     	 $msg .= '<script>window.open("manual_icard_print.php?id='.$pic_sno.'");</script>';

	     }   
	}

	if($_FILES['photo_id']['name']=='' and $_POST['stu_name']=='' and $_POST['class']==''){	
			$newfilename='';
		}
	elseif($_FILES['photo_id']['name']!=''){
		$allowed =  array('gif','png' ,'jpg', 'jpeg' , 'pdf');
		$filename = $_FILES['photo_id']['name'];
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		if(!in_array($ext,$allowed) ) {
			$msg1 .= 'Invalid Student Image..';				
		}
		else{
			$temp = explode(".", $_FILES["photo_id"]["name"]);
			$newfilename = 'student_photo_' .$pic_sno.'.' . end($temp);
			if(move_uploaded_file($_FILES["photo_id"]["tmp_name"], "student_mannual_icard/".$newfilename)){
				$sql_upload = 'UPDATE `student_info_mannul_icard` SET `photo_id` = "'.$newfilename.'" WHERE `sno`="'.$pic_sno.'"';
				execute_query(connect(), $sql_upload );
				
			}
			else{
				$msg1.='Student Image Upload Failed..';
			}
		}
	}	
}
if(isset($_GET['id'])){
	$sql="select * from student_info_mannul_icard where sno='".$_GET['id']."'";
	$run=execute_query(connect(), $sql);
	$row=mysqli_fetch_assoc($run);
	//print_r($row);
}

$sql_session = 'SELECT * FROM `general_settings` WHERE `description`="session"';
$result_session = execute_query(connect(), $sql_session);
$row_session = mysqli_fetch_array($result_session);
$current_session = $row_session['value'];


page_header_end();
page_sidebar();

?>

<script language="javascript" type="text/javascript">
	
	$( "#sale_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
	$("#sale_date").change(function(){
		$( "#sale_date" ).datepicker("option", "showAnim", "slide");
	});

</script>
<script type="text/javascript" language="javascript" src="form_validator.js"></script>
<body id="public">
<div id="container">
	<div class="card">
		<div class="card-body ">
			<div class="row d-flex my-auto">
				<form action="manual_icard.php" class="wufoo leftLabel page1" name="editroute" enctype="multipart/form-data" method="post">
					<a href="manual_icard_report.php" style="float: right;" class="btn btn-danger text-white">Report</a>
					<h2 align="center">Complete Detail of the <span class="orange">Admission</span></h2>
					<h1 align="center">KAMLA NEHRU INSTITUTE OF PHYSICAL & SOCIAL SCIENCES</h1>
					<h3 align="center">Sultanpur (U.P.) - 228 118 Tel.: 05362-240854</h3>
					<h3 align="center">Accredited by "NAAC" with 'A' Grade</h3>
					<h3>MANUAL IDENTITY CARD <?php echo $current_session; ?></h3>
					<?php echo $msg;  ?>
					<div class="col-md-12">
						<div class="row">							
							<div class="col-md-4">							
								<label>Class : </label>
								<input type="text" class="form-control"  name="class" autocomplete="off" value="<?php if(isset($_GET['id'])){ echo $row['class'];}  ?>">
							</div>
							<div class="col-md-4">							
								<label>Roll Number: </label>
								<input type="text" class="form-control"  name="roll_no" autocomplete="off" value="<?php if(isset($_GET['id'])){ echo $row['roll_no'];}  ?>">
							</div>
							<div class="col-md-4">							
								<label>Student Name :</label>
								<input type="text" class="form-control"  name="stu_name" autocomplete="off" value="<?php if(isset($_GET['id'])){ echo $row['stu_name'];}  ?>">
							</div>
						</div>
						<div class="row">							
							<div class="col-md-4">							
								<label>Father Name :</label>
								<input type="text" class="form-control"  name="father_name" autocomplete="off" value="<?php if(isset($_GET['id'])){ echo $row['father_name'];}  ?>">
							</div>
							<div class="col-md-4">							
								<label>Blood Group :</label>
								<input type="text" name="blood_group" class="form-control"  autocomplete="off" value="<?php if(isset($_GET['id'])){ echo $row['blood_group'];}  ?>">
							</div>
							<div class="col-md-4">							
								<label>Subject:</label>
								<input type="text" name="sub1" class="form-control"  autocomplete="off" value="<?php if(isset($_GET['id'])){ echo $row['sub1'];}  ?>">
							</div>
						</div>
						<div class="row">							
							<div class="col-md-4">							
								<label>E-Mail :</label>
								<input type="text" class="form-control"  name="email_id" autocomplete="off" value="<?php if(isset($_GET['id'])){ echo $row['e_mail1'];}  ?>">
							</div>
							<div class="col-md-4">							
								<label>Mobile :</label>
								<input type="text" class="form-control"  name="mobile" autocomplete="off" value="<?php if(isset($_GET['id'])){ echo $row['mobile'];}  ?>">
							</div>
							<div class="col-md-4">							
								<label>Gender :</label>
								<input type="text" class="form-control"  name="gender" autocomplete="off" value="<?php if(isset($_GET['id'])){ echo $row['gender'];}  ?>">
							</div>
						</div>
						<div class="row">							
							<div class="col-md-4">							
								<label>Address :</label>
								<input type="text" class="form-control"  name="address" autocomplete="off" value="<?php if(isset($_GET['id'])){ echo $row['post'];}  ?>">
							</div>
							<div class="col-md-4">							
								<label>Photo:</label>
								<input type="file" class="form-control"  name="photo_id" autocomplete="off">
							</div>
							<div class="col-md-4">							
								<label>Date of Identity Card :</label>
								<script  type="text/javascript" language="javascript">document.writeln(DateInput('icard_date', 'icard_date', true, 'YYYY-MM-DD', '<?php echo $row['date_of_admission']; ?>', 2));</script>
							</div>
						</div>
						<div class="row">							
							<div class="col-md-4">							
								<label>Aadhar No. :</label>
								<input type="text" class="form-control"  name="aadhar" autocomplete="off" value="<?php if(isset($_GET['id'])){ echo $row['aadhar'];}  ?>">
							</div>
							<div class="col-md-4">							
								<label>Date of Birth : </label>
								<script  type="text/javascript" language="javascript">document.writeln(DateInput('dob', 'dob', true, 'YYYY-MM-DD', '<?php echo $row['dob']; ?>', 2));</script>
								
							</div>
						</div>
						<input class="submit btn btn-primary" type="submit" name="submit" value="Confirm and Print" title="Continue" />
						<input type="hidden" name="student_id" value="<?php if(isset($_GET['id'])){ echo $row['sno'];}  ?>" />
					</div>
				</form>
			</div>
		</div>
	</div>	
</div>
<?php  
 page_footer_start();
 page_footer_end();
?>
</body>  