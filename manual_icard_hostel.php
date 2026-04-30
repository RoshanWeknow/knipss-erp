<?php
//session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
logvalidate('');
page_header_start();
$msg='';
//print_r($_POST);
//die();
if(isset($_POST['submit'])){
	$link = connect();
	if($_POST['class']=='' || $_POST['stu_name']=='' || $_POST['father_name']=='' || $_POST['blood_group']=='' || $_POST['mobile']=='' || $_POST['address1']=='' || $_POST['icard_date']=='' || $_POST['aadhar']=='' || $_POST['dob_date']==''){
		$msg='<li style="color:red"><b>Please Fill Student Details</b></li>';
	}
	elseif($_POST['student_id'] !=''){
		$sql="UPDATE `student_info_mannul_icard_hostel` SET 
		`stu_name`='".$_POST['stu_name']."',
		`father_name`='".$_POST['father_name']."',
		`class`='".$_POST['class']."',
		`dob`='".$_POST['dob_date']."',
		`mobile`='".$_POST['mobile']."',
		`gender`='',
		`temp_address`='".$_POST['address1']."',
		`perm_address`='".$_POST['address2']."',
		`post`='".$_POST['address3']."',
		`parent_contact`='".$_POST['sub1']."',
		`roll_no`='',
		`blood_group`='".$_POST['blood_group']."',
		`aadhar`='".$_POST['aadhar']."' 
		where sno='".$_POST['student_id']."'";
		execute_query($link, $sql);
		if(!mysqli_error($link)){
			$pic_sno = $_POST['student_id'];
			$msg='<li style="color:red"><b> Student Details Update Succesful</b></li>';
			$msg .= '<li class="error"><a href="manual_icard_hostel_print.php?id='.$pic_sno.'" target="_blank">Click Here to print.</a></li>';
			$msg .= '<script>window.open("manual_icard_hostel_print.php?id='.$pic_sno.'");</script>';
		}
		else{
			$msg .= '<li class="error">Error # 1 : '.mysqli_error($link).' >> '.$sql.'</li>';
		}

	}
	else{
		
		$sql="INSERT INTO `student_info_mannul_icard_hostel` ( `stu_name`, `father_name`,`class`, `dob`, `mobile`,`date_of_admission`, `gender`, `temp_address`, `perm_address`, `post`, `parent_contact`, `roll_no`, `blood_group`,`aadhar`) VALUES ('".$_POST['stu_name']."', '".$_POST['father_name']."', '".$_POST['class']."', '".$_POST['dob_date']."', '".$_POST['mobile']."', '".$_POST['icard_date']."', '', '".$_POST['address1']."', '".$_POST['address2']."', '".$_POST['address3']."', '".$_POST['sub1']."', '','".$_POST['blood_group']."','".$_POST['aadhar']."')";
		 
	    execute_query($link, $sql);
		if(!mysqli_error($link)){
			$pic_sno = mysqli_insert_id(connect());
			$msg .='<li style="color:red"><b> Student Details Inserted Succesful</b></li>';
			$msg .= '<li class="error"><a href="manual_icard_hostel_print.php?id='.$pic_sno.'" target="_blank">Click Here to print.</a></li>';
			$msg .= '<script>window.open("manual_icard_hostel_print.php?id='.$pic_sno.'");</script>';
		}   
		else{
			$msg .= '<li class="error">Error # 2 : '.mysqli_error($link).' >> '.$sql.'</li>';
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
			if(move_uploaded_file($_FILES["photo_id"]["tmp_name"], "student_mannual_icard_hostel/".$newfilename)){
				$sql_upload = 'UPDATE `student_info_mannul_icard_hostel` SET `photo_id` = "'.$newfilename.'" WHERE `sno`="'.$pic_sno.'"';
				execute_query(connect(), $sql_upload );
				
			}
			else{
				$msg1.='Student Image Upload Failed..';
			}
		}
	}	
}
if(isset($_GET['id'])){
	$sql="select * from student_info_mannul_icard_hostel where sno='".$_GET['id']."'";
	$run=execute_query(connect(), $sql);
	$row=mysqli_fetch_assoc($run);
}

$sql = 'select * from general_settings where description="session"';
$session = mysqli_fetch_assoc(execute_query(connect(), $sql));


page_header_end();
page_sidebar();
?>
<style>
.ui-autocomplete-loading { background: white url('images/ui-anim_basic_16x16.gif') right center no-repeat; }
input{ text-transform:uppercase}
</style>
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
				<form action="manual_icard_hostel.php" class="wufoo leftLabel page1" name="editroute" enctype="multipart/form-data" method="post">
					<a href="manual_icard_hostel_report.php" style="float: right; " class="btn btn-danger text-white">Report</a>
					<h2 align="center">Complete Detail of the <span class="orange">Admission</span></h2> 
					<h1 align="center">KAMLA NEHRU INSTITUTE OF PHYSICAL & SOCIAL SCIENCES</h1>
					<h3 align="center">Sultanpur (U.P.) - 228 118 Tel.: 05362-240854</h3>
					<h3 align="center">Accredited by "NAAC" with 'A' Grade</h3>
					<h3>HOSTEL MANUAL IDENTITY CARD <?php echo $session['value']; ?></h3>
					<?php echo $msg;  ?>
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-4">							
								<label>Photo:</label>
								<input type="file"  class="form-control"name="photo_id" autocomplete="off" required>
							</div>
							<div class="col-md-4">							
								<label>Class :</label>
								<input type="text" class="form-control" name="class" autocomplete="off" value="<?php if(isset($_GET['id'])){ echo $row['class'];}  ?>" required>
							</div>
							<div class="col-md-4">							
								<label>Student Name :</label>
								<input type="text" class="form-control" name="stu_name" autocomplete="off" value="<?php if(isset($_GET['id'])){ echo $row['stu_name'];}  ?>" required>
							</div>
						</div>
						<div class="row">							
							<div class="col-md-4">							
								<label>Father Name :</label>
								<input type="text" name="father_name" class="form-control" autocomplete="off" value="<?php if(isset($_GET['id'])){ echo $row['father_name'];}  ?>" required>
							</div>
							<div class="col-md-4">							
								<label>Date of Birth :</label>
								
								<script  type="text/javascript" language="javascript">
									document.writeln(DateInput('dob', 'dob', true, 'YYYY-MM-DD', '<?php if(isset($_POST['dob'])){echo $_POST['dob'];}else{echo date("Y-m-d"); } ?>', 2));
								</script>
							</div>
							<div class="col-md-4">							
								<label>Address : </label>
								<input type="text"class="form-control" name="address1" placeholder="address " autocomplete="off" value="<?php if(isset($_GET['id'])){ echo $row['post'];}  ?>" required>
								<input type="text"class="form-control" name="address2" placeholder="address " autocomplete="off" value="<?php if(isset($_GET['id'])){ echo $row['post'];}  ?>" required></td>
								<input type="text"class="form-control" name="address3" placeholder="address " autocomplete="off" value="<?php if(isset($_GET['id'])){ echo $row['post'];}  ?>" required>
							</div>
						</div>
						<div class="row">							
							<div class="col-md-4">							
								<label>Aadhar No. :</label>
								<input type="text" name="aadhar" class="form-control" autocomplete="off" value="<?php if(isset($_GET['id'])){ echo $row['aadhar'];}  ?>" required>
							</div>
							<div class="col-md-4">							
								<label>Student's Contact :</label>
								<input type="text" name="mobile"class="form-control" autocomplete="off" value="<?php if(isset($_GET['id'])){ echo $row['mobile'];}  ?>" required>
							</div>	
							<div class="col-md-4">							
								<label>Parent's Contact:</label>
								<input type="text" name="sub1"class="form-control" autocomplete="off" value="<?php if(isset($_GET['id'])){ echo $row['parent_contact'];}  ?>" required>
							</div>
						</div>
						<div class="row">							
							<div class="col-md-4">							
								<label>Blood Group :</label>
								<input type="text" class="form-control" name="blood_group" autocomplete="off" value="<?php if(isset($_GET['id'])){ echo $row['blood_group'];}  ?>" required>
							</div>
							<div class="col-md-4">							
								<label>Date of Identity Card :</label>
								
								<script  type="text/javascript" language="javascript">
									document.writeln(DateInput('apr_date', 'apr_date', true, 'YYYY-MM-DD', '<?php if(isset($_POST['apr_date'])){echo $_POST['apr_date'];}else{echo date("Y-m-d"); } ?>', 2));
								</script>
							</div>
						</div>
						<input class="submit btn btn-primary" type="submit" name="submit" value="Confirm and Print" title="Continue" /></td>
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