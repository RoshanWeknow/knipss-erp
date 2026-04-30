<?php
include("scripts/settings.php");
include("scripts/settings_dbase_uin.php");
$response=1;
$tabindex=1;
$verified=0;
$msg='';
if(isset($_POST)){
	foreach($_POST as $k=>$v){
		$_POST[$k] = htmlspecialchars($v);
	}
}
//include("settings.php");

///	$sup=dbconnect($_POST[$id]);
page_header_start();
page_header_end();
page_sidebar();
?>

<?php
if(isset($_GET['id'])){
	$sql = 'select * from admission_student_info where sno = '.$_GET['id'];
	//echo $sql.'<br>';
    $result_admin_info = mysqli_fetch_assoc(execute_query($db2,$sql));
	$verification_status =  $result_admin_info['status_verified'];
	if($verification_status == 0){
		$sql = 'select * from new_student_info where sno = '.$result_admin_info['student_id'];
		//echo $sql;
		$result_student_info = execute_query($db2,$sql);
		//if(mysqli_num_rows($db)){
		if(mysqli_num_rows($result_student_info)!=0){
			$data = mysqli_fetch_assoc($result_student_info);

			$sql = 'select * from mst_course where sno="'.$data['course_applying_for'].'"';
			$course = mysqli_fetch_assoc(execute_query($db2,$sql));
		}
		else{
			die("Error # 1.02.");
		}

		$sql = 'select * from register_users where sno="'.$data['reg_user_sno'].'"';
		$reg_user = mysqli_fetch_assoc(execute_query($db2,$sql));

		$stu_details = $result_admin_info;

		$sql1 = "SELECT * FROM admission_address WHERE d_student_info_sno = ".$result_admin_info['sno']." AND type_of_address = 'permanent'";
		//echo $sql1;
		$sql = execute_query($db2,$sql1);

		if($sql){
			$p_address_details = mysqli_fetch_assoc($sql);
		}
		$sql = execute_query($db2,"SELECT * FROM admission_address WHERE d_student_info_sno = ".$result_admin_info['sno']." AND type_of_address = 'correspondence'");
		if($sql){
			$c_address_details = mysqli_fetch_assoc($sql);
		}
		//print_r($stu_details);
		$sql='select * from admission_qualification where d_student_info_sno  = '.$result_admin_info['sno'];
		$sql = execute_query($db2,$sql);
		$i = 1;
		while($row = mysqli_fetch_assoc($sql)){
			if($row['name_of_examination']!= 'High School' && $row['name_of_examination']!='Intermediate' && $row['name_of_examination']!='B.Ed'){
				$examination_name = 'select * from class_detail where sno = "'.$row['name_of_examination'].'"';
				$examination_name = execute_query($db2,$examination_name);
				if($examination_name){
					$examination_name = mysqli_fetch_assoc($examination_name);
					$_POST['part_desc'.$i] = $examination_name['class_description'];
				}
			}
			if($row['name_of_examination']=='B.Ed'){
				$_POST['part_desc'.$i] = 'B.Ed';
			}
			$_POST['q_sno'.$i] = $row['sno'];
			$_POST['part_desc'.$i.'_board'] = $row['board_university_name'];
			$_POST['part_desc'.$i.'_college'] = $row['college_name'];
			$_POST['part_desc'.$i.'_year'] = $row['year'];
			$_POST['part_desc'.$i.'_rollno'] = $row['roll_no'];
			if($row['cgpa']== NULL || $row['cgpa']== ''){
				$_POST['part_desc'.$i.'_obtmarks'] = $row['obtained_marks'];
				$_POST['part_desc'.$i.'_totmarks'] = $row['total_marks'];
				$_POST['part_desc'.$i.'_percentage'] = $row['percentage'];
			}
			else{
				$_POST['part_desc'.$i.'_cgpa'] = $row['cgpa'];
			}
			$_POST['part_desc'.$i.'_division'] = $row['division'];
			$_POST['part_desc'.$i.'_status'] = $row['status'];
			$i++;
		}

		$sql1 = 'select * from student_info where roll_no="'.$_GET['rn'].'"';
		//echo $sql1;
		$stu_info = mysqli_fetch_assoc(execute_query($db,$sql1));
	}
	else{
		die('<div class="alert alert-danger">Already Verified</div>');
	}
}

if(isset($_POST['verify'])){
	//print_r($_POST);
	$sql = 'select * from student_info WHERE roll_no = "'.$_POST['college_roll_no'].'"';
	$student_details = mysqli_fetch_assoc(execute_query($db, $sql));
	
	$photo_ext = pathinfo($_POST['photo1'], PATHINFO_EXTENSION);
	$sign_ext = pathinfo($_POST['signature1'], PATHINFO_EXTENSION);
	
	$folder_id = ceil($student_details['sno']/1000);
	$target_dir = 'PHOTO/'.$folder_id;
	if (!file_exists($target_dir)) {
		mkdir($target_dir, 0777, true);
	}
	
	$photo_new_name = $student_details['sno'].'.'.$photo_ext;
	$sign_new_name = $student_details['sno'].'_sign.'.$sign_ext;
	
	
	
	copy($_POST['photo1'], $target_dir.'/'.$photo_new_name);
	copy($_POST['signature1'], $target_dir.'/'.$sign_new_name);
	//print_r($_POST);
	$sql = 'UPDATE `student_info` SET '.
	'stu_name  = "'.$_POST['candidate_name1'].'", '.
	'father_name  = "'.$_POST['father_name1'].'", '.
	'mother_name = "'.$_POST['mother_name1'].'", '.
	'dob = "'.$_POST['dob1'].'", '.
	'aadhar = "'.$_POST['aadhar1'].'", '.
	'e_mail1 = "'.$_POST['email1'].'", '.
	'religion = "'.$_POST['religion1'].'", '.
	'whatsapp_no = "'.$_POST['whatsapp_no1'].'", '.
	'p_mobile = "'.$_POST['parent_mobile1'].'", '.
	'parent_mobile = "'.$_POST['parent_mobile1'].'", '.
	'state = "'.$_POST['domicile1'].'", '.
	'mother_tongue = "'.$_POST['mother_tongue1'].'", '.
	'waightage = "'.$_POST['weightage1'].'", '.
	'blood_group = "'.$_POST['blood_group1'].'", '.
	'domicile = "'.$_POST['domicile'].'", '.
	'p_address = "'.$_POST['p_address'].'", '.
	'perm_address = "'.$_POST['p_address'].'", '.
	'p_post = "'.$_POST['p_post'].'", '.
	'p_tehsil = "'.$_POST['p_tehsil'].'", '.
	'p_house_no = "'.$_POST['p_tehsil'].'", '.
	'p_thana = "'.$_POST['p_thana'].'", '.
	'p_district = "'.$_POST['p_district'].'", '.
	'p_state = "'.$_POST['p_state'].'", '.
	'p_pin = "'.$_POST['p_pin'].'", '.
	'c_address = "'.$_POST['c_address'].'", '.
	'temp_address = "'.$_POST['c_address'].'", '.
	'c_post = "'.$_POST['c_post'].'", '.
	'c_tehsil = "'.$_POST['c_tehsil'].'", '.
	'p_village = "'.$_POST['c_tehsil'].'", '.
	'c_thana = "'.$_POST['c_thana'].'", '.
	'c_district = "'.$_POST['c_district'].'", '.
	'district = "'.$_POST['c_district'].'", '.
	'c_state = "'.$_POST['c_state'].'", '.
	'university_uin = "'.$_POST['uin'].'", '.
	'c_pin = "'.$_POST['c_pin'].'",
	photo_id = "'.$target_dir.'/'.$photo_new_name.'", 
	signature_id = "'.$target_dir.'/'.$sign_new_name.'"
	WHERE roll_no = "'.$_POST['college_roll_no'].'"';
	//echo $sql;
	//die();
	
	execute_query($db,$sql);
	if(mysqli_error($db)){
		$rs=0;
		$msg .= '<li>'.mysqli_error($db).' >> '.$sql.'</li>';
	}
	else{
		
		$sql = 'update student_info set 
		perm_address  = "'.$_POST['p_address'].'",
		p_post  = "'.$_POST['p_post'].'",
		p_district  = "'.$_POST['p_district'].'",
		p_state  = "'.$_POST['p_state'].'",
		p_house_no  = "'.$_POST['p_tehsil'].'",
		p_pin  = "'.$_POST['p_pin'].'",
		e_mail2  = "'.$_POST['email1'].'",
		p_mobile  = "'.$_POST['whatsapp_no1'].'",
		temp_address  = "'.$_POST['c_address'].'",
		post  = "'.$_POST['c_post'].'",
		district  = "'.$_POST['c_district'].'",
		state  = "'.$_POST['c_state'].'",
		p_village  = "'.$_POST['c_tehsil'].'",
		pin  = "'.$_POST['c_pin'].'",
		e_mail1  = "'.$_POST['email1'].'",
		mobile  = "'.$_POST['mobile1'].'"
		WHERE roll_no = "'.$_POST['college_roll_no'].'"';
		execute_query($db,$sql);
		
		$sql1 = 'UPDATE `admission_student_info` SET 
		status_verified = 1 
		WHERE uin = "'.$_POST['uin'].'"';
		execute_query($db2, $sql1);
		$msg .= "<div class='alert alert-success'>Successfully Verified</div>";
		$verified = 1;


		$sql2 = 'INSERT INTO `uin_data_internal`(`application_no`, `transection_no`, `uin`, `candidate_name`, `father_name`, `mother_name`, `dob`, `aadhar`, `gender`, `mobile`, `email`, `course_type`, `course_applying_for`, `religion`, `category`, `whatsapp_no`, `college_roll_no`, `parent_no`, `domicile`, `mother_tongue`, `weightage`, `blood_group`, `status`, `photo`, `signature`, `p_address`, `p_post`, `p_tehsil`, `p_thana`, `p_district`, `p_state`, `p_pin`, `c_address`, `c_post`, `c_tehsil`, `c_thana`, `c_district`, `c_state`, `c_pin`, `created_by`, `creation_time`)  values(
		"'.$_POST['application_no'].'",
		"'.$_POST['transaction_no'].'",
		"'.$_POST['uin'].'",
		"'.$_POST['candidate_name1'].'",
		"'.$_POST['father_name1'].'",
		"'.$_POST['mother_name1'].'",
		"'.$_POST['dob1'].'",
		"'.$_POST['aadhar1'].'",
		"'.$_POST['gender1'].'",
		"'.$_POST['mobile1'].'",
		"'.$_POST['email1'].'",
		"'.$_POST['course_type12'].'",
		"'.$_POST['course_applying_for12'].'",
		"'.$_POST['religion1'].'",
		"'.$_POST['category1'].'",
		"'.$_POST['whatsapp_no1'].'",
		"'.$_POST['college_roll_no'].'",
		"'.$_POST['parent_mobile1'].'",
		"'.$_POST['domicile1'].'",
		"'.$_POST['mother_tongue1'].'",
		"'.$_POST['weightage1'].'",
		"'.$_POST['blood_group1'].'",
		"'.$_POST['stu_status'].'",
		"'.$_POST['photo1'].'",
		"'.$_POST['signature1'].'",
		"'.$_POST['p_address'].'",
		"'.$_POST['p_post'].'",
		"'.$_POST['p_tehsil'].'",
		"'.$_POST['p_thana'].'",
		"'.$_POST['p_district'].'",
		"'.$_POST['p_state'].'",
		"'.$_POST['p_pin'].'",
		"'.$_POST['c_address'].'",
		"'.$_POST['c_post'].'",
		"'.$_POST['c_tehsil'].'",
		"'.$_POST['c_thana'].'",
		"'.$_POST['c_district'].'",
		"'.$_POST['c_state'].'",
		"'.$_POST['c_pin'].'",
		"",
		"'.date('Y-m-d H:m:s').
		'")';
		execute_query($db,$sql2);
		$rs1=1;
		if(mysqli_error($db)){
			$rs1=0;
			$msg .= '<li>'.mysqli_error($db).' >> '.$sql.'</li>';
		}
		else{
			$sno = mysqli_insert_id($db);	
		}

		$college_roll_no = $_POST['college_roll_no'];
		//echo $college_roll_no;

		if($rs1==1){
			if(isset($_POST['qualification_no']) ){
				$sql = 'delete from qual_detail where student_id="'.$student_details['sno'].'"';
				execute_query($db, $sql);
				for($i=1; $i<=$_POST['qualification_no']; $i++){
					if($_POST['part_desc'.$i.'_board']!='' ){
						$_POST['part_desc'.$i.'_division'] = isset($_POST['part_desc'.$i.'_division'])?$_POST['part_desc'.$i.'_division']:'';
						$sql4 = 'insert into uin_data_internal_qualification (uin_data_internal_sno, name_of_examination, board_university_name, college_name, year, roll_no, obtained_marks, total_marks, percentage, cgpa, status, created_by, creation_time) values ("'.$sno.'", "'.$_POST['part_desc'.$i].'", "'.$_POST['part_desc'.$i.'_board'].'", "'.$_POST['part_desc'.$i.'_college'].'", "'.$_POST['part_desc'.$i.'_year'].'", "'.$_POST['part_desc'.$i.'_rollno'].'", "'.$_POST['part_desc'.$i.'_obtmarks'].'", "'.$_POST['part_desc'.$i.'_totmarks'].'", "'.$_POST['part_desc'.$i.'_percentage'].'", "'.$_POST['part_desc'.$i.'_cgpa'].'", "'.$_POST['part_desc'.$i.'_status'].'", "", "'.date('Y-m-d H:m:s').'")';
						execute_query($db, $sql4);
						if(mysqli_error($db)){
							$rs=0;
							$msg .= '<li>'.mysqli_error($db).' >> '.$sql4.'</li>';
						}
						
						
						$sql_qual = 'INSERT INTO `qual_detail` (`exam_name`, `year`, `board`, `roll_no`,`univ_name`, `student_id`, `obt_marks`, `tot_marks`, `form_no`,`percentage`, `status`, `division`) VALUES ("'.$_POST['part_desc'.$i].'", "'.$_POST['part_desc'.$i.'_year'].'", "'.$_POST['part_desc'.$i.'_board'].'", "'.$_POST['part_desc'.$i.'_rollno'].'", "'.$_POST['part_desc'.$i.'_board'].'", "'.$student_details['sno'].'", "'.$_POST['part_desc'.$i.'_obtmarks'].'", "'.$_POST['part_desc'.$i.'_totmarks'].'", "'.$student_details['form_no'].'", "'.$_POST['part_desc'.$i.'_percentage'].'", "'.$_POST['part_desc'.$i.'_status'].'", "'.$_POST['part_desc'.$i.'_cgpa'].'")';
						execute_query($db, $sql_qual);
						if(mysqli_error($db)){
							$rs=0;
							$msg .= '<li>'.mysqli_error($db).' >> '.$sql_qual.'</li>';
						}
						
					}
				}
			}
		}
	}
	$msg .= '<a href="uin_search_verification.php">Click Here to Go Back</a>';
}

?>
<style></style>
<div id="container" width="70%">
	<div class="card">
		<div class="card-body col-md-11  " style="background-color:#E5E4E2;">
			<div class="row ">
				<section class="content-header">
					<h2 style="color: #000!important;">Admission Form <span></span>(2023-24)</h3> <br>
				</section>
				<section class="content-header" style="margin-top: -25px">
					<h3 style="font-size: 20px; font-weight: 600;"></h3>
				</section>
				<form action="<?php $_SERVER['PHP_SELF']; ?>" id="examForm" class="wufoo leftLabel page1" name="admission_newadmission" enctype="multipart/form-data" method="post" onSubmit="" >
				<?php echo $msg; ?>	
					<div class=" card card-body col-md-11 my-auto mx-auto" style="border-top-color: #d2d6de; background-color:whitesmoke;" >
						<div class="row mt-1">							
							<div class="col-md-6">							
								<label>Application Number</label>
								<input type="text" name="application_no" id="application_no" class="form-control " value="<?php echo isset($_GET['id'])? $reg_user['user_name'] : '' ?>" style="pointer-events:none; " readonly  tabindex="<?php echo $tabindex++;?>" >
							</div>
							<div class="col-md-6">							
								<label>UIN Number</span></label>
								<input type="text" name="uin" id="uin" class="form-control " value="<?php echo isset($_GET['id'])? $stu_details['uin'] : '' ?>" style="pointer-events:none; " readonly  >
							</div>
						</div>
						<div class="row mt-1">							
							<div class="col-md-4">							
								<label>Transaction Number</label>
								<input type="text" name="transaction_no" id="transaction_no" class="form-control " value="<?php echo isset($_GET['id'])? $reg_user['transaction_no'] : '' ?>" style="pointer-events:none; " readonly  tabindex="<?php echo $tabindex++;?>" >
							</div>
							<div class="col-md-4">							
								<label>Payment Status</label>
								<input type="text" name="payment_status" id="payment_status" class="form-control " value="<?php echo isset($_GET['id'])? $reg_user['payment_status'] : '' ?>" style="pointer-events:none; " readonly  >
							</div>
							<div class="col-md-4">							
								<label>Form Number</label>
								<input type="text" name="form_no" id="form_no" class="form-control " value="<?php echo isset($_GET['id'])? $stu_info['form_no'] : '' ?>" style="pointer-events:none; " readonly  >
							</div>
						</div>
						<hr>
						<div class="row mt-1">							
							<div class="col-md-6">							
								<h5 align="center">UIN Data</h5>
								
							</div>
							<div class="col-md-6">							
								<h5 align="center">ERP Data</h5>
								
							</div>
						</div>
						<div class="row mt-1">
							<div class="col-md-6">	
								<label>College Roll No.*</label>
								<input type="text" name="college_roll_no1" id="roll_no" class="form-control " value="<?php echo isset($_GET['id'])? $stu_details['college_roll_no']: '' ?>" tabindex="<?php echo $tabindex++;?>" required>
							</div>
							<div class="col-md-6">	
								<label>College Roll No.*</label>
								<input type="text" name="college_roll_no" id="roll_no" class="form-control " value="<?php echo isset($_GET['id'])? $stu_info['roll_no']: '' ?>" tabindex="<?php echo $tabindex++;?>" style="pointer-events:none; " readonly>
							</div>
						</div>
						<div class="row mt-1">							
							<div class="col-md-6">							
								<label>Candidate Name *  </label>
								<input type="text" name="candidate_name1" id="candidate_name" class="form-control " value="<?php echo isset($_GET['id'])? $stu_details['candidate_name'] : '' ?>" tabindex="<?php echo $tabindex++;?>" required>
							</div>
							<div class="col-md-6">							
								<label>Candidate Name *  </label>
								<input type="text" name="candidate_name" id="candidate_name" class="form-control " value="<?php echo $stu_info['stu_name']; ?>"  tabindex="<?php echo $tabindex++;?>" style="pointer-events:none; " readonly  required>
							</div>
						</div>
						<div class="row mt-1">
							<div class="col-md-6">							
								<label>Father&#39;s Name*  </label>
								<input type="text" name="father_name1" id="father_name" class="form-control " value="<?php echo isset($_GET['id'])? $stu_details['father_name'] : '' ?>" required>
							</div>
							<div class="col-md-6">							
								<label>Father&#39;s Name*  </label>
								<input type="text" name="father_name" id="father_name" class="form-control "  value="<?php echo $stu_info['father_name']; ?>" style="pointer-events:none; " readonly  required>
							</div>
						</div>
						<div class="row mt-1">
							<div class="col-md-6">							
								<label>Mother&#39;s Name</label>
								<input type="text" name="mother_name1" id="mother_name" class="form-control " value="<?php echo isset($_GET['id'])? $stu_details['mother_name'] : '' ?>" required>
							</div>
							<div class="col-md-6">							
								<label>Mother&#39;s Name</label>
								<input type="text" name="mother_name" id="mother_name" class="form-control " value="<?php echo $stu_info['mother_name']; ?>" style="pointer-events:none; " readonly  required>
							</div>
						</div>
						<div class="row mt-1">
							<div class="col-md-6">							
								<label>Date of Birth* </label>
								<input type="text" id="dob" name="dob1" value="" class="form-control">

								<script>
									// JavaScript code to populate the Date of Birth field and make it read-only
									document.addEventListener("DOMContentLoaded", function () {
										var dobInput = document.getElementById("dob");
										var defaultDate = '<?php if(isset($_GET['id'])){echo $stu_details['dob'];}else{echo date("Y-m-d");}?>';
										
										// Set the default value for the Date of Birth field
										dobInput.value = defaultDate;

										// Make the Date of Birth field read-only
										dobInput = true;
									});
								</script>
							</div>
							<div class="col-md-6">							
								<label>Date of Birth* </label>
								<input type="text" id="dob" name="dob" value="<?php if(isset($_GET['id'])){echo $stu_info['dob'];}?>" class="form-control" style="pointer-events:none; " readonly >
							</div>
						</div>
						<div class="row mt-1">
							<div class="col-md-6">
								<label>Aadhar</label>
								<input type="text" name="aadhar1" id="aadhar1" class="form-control " value="<?php echo isset($_GET['id'])? $stu_details['aadhar'] : '' ?>" tabindex="<?php echo $tabindex++;?>" required>
							</div>
							<div class="col-md-6">
								<label>Aadhar</label>
								<input type="text" name="aadhar" id="aadhar" class="form-control " value="<?php echo $stu_info['aadhar']; ?>" tabindex="<?php echo $tabindex++;?>" style="pointer-events:none; " readonly  required>
							</div>
						</div>
						<div class="row mt-1">
							<div class="col-md-6">							
								<label>E-Mail</label>
								<input type="text" name="email1" id="email1" class="form-control "  value="<?php echo isset($_GET['id'])? $stu_details['email'] : '' ?>" tabindex="<?php echo $tabindex++;?>" required>
							</div>
							<div class="col-md-6">							
								<label>E-Mail</label>
								<input type="text" name="email" id="email" class="form-control " value="<?php echo $stu_info['e_mail1']; ?>" tabindex="<?php echo $tabindex++;?>"  style="pointer-events:none; " readonly  required>
							</div>
						</div>
						<div class="row mt-1">
							<div class="col-md-6">							
								<label>Mobile</label>
								<input type="text" name="mobile1" id="mobile" class="form-control " value="<?php echo isset($_GET['id'])? $stu_details['mobile'] : '' ?>" tabindex="<?php echo $tabindex++;?>" required>
							</div>
							<div class="col-md-6">							
								<label>Mobile</label>
								<input type="text" name="mobile" id="mobile" class="form-control " value="<?php echo $stu_info['mobile']; ?>" tabindex="<?php echo $tabindex++;?>" style="pointer-events:none; " readonly required>
							</div>
						</div>
						<div class="row mt-1">
							<div class="col-md-6">							
								<label>Course Type</label>
								<input type="hidden" name="course_type12" id="course_type12" class="form-control " value="<?php echo isset($_GET['id'])? $stu_details['course_type'] : '' ?>"/> 
								
								<select name="course_type1" id="course_type" value="<?php echo $stu_details['course_type']?>" class="form-control" tabindex="<?php echo $tabindex++;?>" required>
										<option disabled <?php echo isset($_GET['id'])? "":' selected = "selected" '?>>---Select Your Course Type---</option>
										<?php 
											$sql  = 'select * from mst_course_type';
											$dept_list = execute_query($db2, $sql);
											if($dept_list){
												while($list = mysqli_fetch_assoc($dept_list)){
													echo '<option  value = "'.$list['sno'].'" '.(isset($_GET['id']) && $stu_details['course_type'] == $list['sno'] ? ' selected = "selected" ':"").'>'.$list['course_type'].'</option>';
												}
											}
										?>
								</select>
							</div>
							<div class="col-md-6">	
								<?php if (isset($_GET['id'])) {
									$sql = 'SELECT * FROM class_detail WHERE sno ='.$stu_info['class'];
									$stu_course = mysqli_fetch_assoc(execute_query($db,$sql));
								}
								?>
								<label>Course Type</label>
								<input type="text" name="course_type" id="course_type" class="form-control " value="<?php echo $stu_course['category']; ?>" placeholder="" style="pointer-events:none ;" readonly /> 
								<!-- <select name="course_type" id="course_type" value="<?php //echo $stu_details['class']?>" class="form-control" tabindex="<?php //echo $tabindex++;?>" style="pointer-events:none; " readonly required>
										<option disabled <?php //echo isset($_GET['id'])? "":' selected = "selected" '?>>---Select Your Course Type---</option>
										<?php 
											// $sql  = 'select * from mst_course_type';
											// $dept_list = execute_query($db2, $sql);
											// if($dept_list){
												// while($list = mysqli_fetch_assoc($dept_list)){
													// echo '<option  value = "'.$list['sno'].'" '.(isset($_GET['id']) && $stu_details['course_type'] == $list['sno'] ? ' selected = "selected" ':"").'>'.$list['course_type'].'</option>';
												// }
											// }
										// ?>
								</select>-->
							</div>
						</div>
						<div class="row mt-1">							
							<div class="col-md-6">	
								<label>Course Applying for</label>
								<input type="hidden" name="course_applying_for12" id="course_applying_for" class="form-control " value="<?php echo isset($_GET['id'])? $stu_details['course_applying_for'] : '' ?>"/> 
								
								<input type="text" name="course_applying_for_display" id="course_applying_for_display" class="form-control " value="<?php echo isset($_GET['id'])? $course['course_name'] : '' ?>"/> 
								<!-- <select name="course_applying_for" id="course_applying_for" value="" class="form-control" style="pointer-events: none;" tabindex="<?php echo $tabindex++;?>" required >
									
								</select>	-->											
							</div>
							<div class="col-md-6">	
								<label>Course Applying for</label>
								<input type="text" name="course_applying_for_display" id="course_applying_for_display" class="form-control " value="<?php echo $stu_course['class_description']; ?>" style="pointer-events:none; " readonly />
								<!-- <select name="course_applying_for" id="course_applying_for" value="" class="form-control" style="pointer-events: none;" tabindex="<?php echo $tabindex++;?>" required >
									
								</select>	-->											
							</div>
						</div>
						<div class="row mt-1">
							<div class="col-md-6">							
								<label>Category</label>
								<select name="category1" id="category1" class="form-control" tabindex="<?php echo $tabindex++;?>" required>
								<option disabled <?php echo isset($_GET['id'])? "":' selected = "selected" '?>>---Select Your Category---</option>
									<option value="GEN" <?php if(isset($_GET['id']) && $stu_details['category']=="GEN"){ echo 'selected ';}?>>General</option>
									<option value="OBC" <?php if(isset($_GET['id']) && $stu_details['category']=="OBC"){ echo 'selected ';}?>>OBC</option>
									<option value="SC" <?php if(isset($_GET['id']) && $stu_details['category']=="SC"){ echo 'selected ';}?>>SC</option>
									<option value="ST" <?php if( isset($_GET['id']) && $stu_details['category']=="ST"){ echo 'selected ';}?>>ST</option>
									<option value="EWS" <?php if( isset($_GET['id']) && $stu_details['category']=="EWS"){ echo 'selected ';}?>>EWS</option>
								</select>
							</div>
							<div class="col-md-6">							
								<label>Category</label>
								<select name="category" id="category" class="form-control" tabindex="<?php echo $tabindex++;?>"style="pointer-events:none; " readonly required>
								<option disabled <?php echo isset($_GET['id'])? "":' selected = "selected" '?>>---Select Your Category---</option>
									<option value="GEN" <?php if(isset($_GET['id']) && $stu_info['category']=="GEN"){ echo 'selected ';}?>>General</option>
									<option value="OBC" <?php if(isset($_GET['id']) && $stu_info['category']=="OBC"){ echo 'selected ';}?>>OBC</option>
									<option value="SC" <?php if(isset($_GET['id']) && $stu_info['category']=="SC"){ echo 'selected ';}?>>SC</option>
									<option value="ST" <?php if( isset($_GET['id']) && $stu_info['category']=="ST"){ echo 'selected ';}?>>ST</option>
									<option value="EWS" <?php if( isset($_GET['id']) && $stu_info['category']=="EWS"){ echo 'selected ';}?>>EWS</option>
								</select>
							</div>
						</div>
						<div class="row mt-1">
							<div class="col-md-6">


								<label for="selectOption">Religion</label>
										<select id="selectOption" name="religion1" class="form-control" tabindex="<?php echo $tabindex++;?>"  required>
											<option value="" disabled selected>---Select Your Religion---</option>
											<option value="HINDU" <?php if(isset($_GET['id'])){if($stu_details['religion']=="HINDU"){ echo 'selected ';}}?>>HINDU</option>
										<option value="MUSLIM" <?php if(isset($_GET['id'])){if($stu_details['religion']=="MUSLIM"){ echo 'selected ';}}?>>MUSLIM</option>
										<option value="SIKH" <?php if(isset($_GET['id'])){if($stu_details['religion']=="SIKH"){ echo 'selected ';}}?>>SIKH</option>
										<option value="CHRISTIAN" <?php if(isset($_GET['id'])){if($stu_details['religion']=="CHRISTIAN"){ echo 'selected ';}}?>>CHRISTIAN</option>
										</select>

									<script>
										function validateForm() {
											var selectedOption = document.getElementById('selectOption').value;
											if (selectedOption === "") {
												alert("Please select religion");
												return false;
											}
											return true;
										}
									</script>
							</div>
							<div class="col-md-6">
								<label for="selectOption">Religion</label>
									<input type="text" name="religion" id="religion" class="form-control " value="<?php echo $stu_info['religion']; ?>" tabindex="<?php echo $tabindex++;?>"  style="pointer-events:none; " readonly  required>	
							</div>
						</div>
						<div class="row mt-1">
							
							<div class="col-md-6">
								
								<label for="selectOption">Gender</label>
									<select id="selectOption" name="gender1" class="form-control" tabindex="<?php echo $tabindex++;?>"  required>
										<option value="" disabled selected>---Select Your Gender---</option>
										<option value="Male" <?php if(isset($_GET['id'])){if($stu_details['gender']=="Male"){ echo 'selected ';}}?>>Male</option>
									<option value="Female" <?php if(isset($_GET['id'])){if($stu_details['gender']=="Female"){ echo 'selected ';}}?>>Female</option>
									<option value="Other" <?php if(isset($_GET['id'])){if($stu_details['gender']=="Other"){ echo 'selected ';}}?>>Transgender</option>
									</select>

								<script>
									function validateForm() {
										var selectedOption = document.getElementById('selectOption').value;
										if (selectedOption === "") {
											alert("Please select gender");
											return false;
										}
										return true;
									}
								</script>
								
							</div>
							<div class="col-md-6">
								
								<label for="selectOption">Gender</label>
									<select id="selectOption" name="gender" class="form-control" tabindex="<?php echo $tabindex++;?>"  style="pointer-events:none; " readonly required>
										<option value="" disabled selected>---Select Your Gender---</option>
										<option value="Male" <?php if(isset($_GET['id'])){if($stu_info['gender']==("M"||"male" )){ echo 'selected ';}}?>>Male</option>
									<option value="Female" <?php if(isset($_GET['id'])){if($stu_info['gender']==("F"||"female")){ echo 'selected ';}}?>>Female</option>
									<option value="Other" <?php if(isset($_GET['id'])){if($stu_info['gender']=="Other"){ echo 'selected ';}}?>>Transgender</option>
									</select>

								<script>
									function validateForm() {
										var selectedOption = document.getElementById('selectOption').value;
										if (selectedOption === "") {
											alert("Please select gender");
											return false;
										}
										return true;
									}
								</script>
								
							</div>
						</div>
						<div class="row mt-1">
							<div class="col-md-6">	
								<label>Whatsapp Mobile No.</label>
								<input type="text" name="whatsapp_no1" id="whatsapp_no1" class="form-control " value="<?php echo isset($_GET['id'])? $stu_details['caste']: '' ?>" pattern=[0-9]{10} minlength="10" maxlength="10" tabindex="<?php echo $tabindex++;?>"  required />
								
							</div>
							<div class="col-md-6">	
								<label>Whatsapp Mobile No.</label>
								<input type="text" name="whatsapp_no" id="caste" class="form-control " value="<?php echo $stu_info['whatsapp_no']; ?>"  tabindex="<?php echo $tabindex++;?>"  style="pointer-events:none; " readonly  required />
								
							</div>
						</div>
						<div class="row mt-1">
							<div class="col-md-6">							
								<label>PARENT'S Mobile No.</label>
								<input type="text" name="parent_mobile1" id="parent_mobile1" class="form-control " pattern=[0-9]{10} minlength="10" maxlength="10" value="<?php echo isset($_GET['id'])? $stu_details['parent_income']: '' ?>" tabindex="<?php echo $tabindex++;?>" required>
							</div>
							<div class="col-md-6">							
								<label>PARENT'S Mobile No.</label>
								<input type="text" name="p_mobile" id="p_mobile" class="form-control " pattern=[0-9]{10} minlength="10" maxlength="10" value="<?php echo isset($_GET['id'])? $stu_info['p_mobile']: '' ?>" tabindex="<?php echo $tabindex++;?>" style="pointer-events:none; " readonly  required>
							</div>
						</div>
						<div class="row mt-1">
							
						
							<div class="col-md-6">
								
								<label for="selectOption">DOMICILE</label>
									<select name="domicile1" id="domicile1" value="" class="form-control" tabindex="<?php echo $tabindex++;?>"  required>
										<option value="" disabled selected>---Select Your Domicile ---</option>
										<?php 
											$sql  = 'select * from mst_domicile';
											$dept_list = execute_query($db2, $sql);
											while($list = mysqli_fetch_assoc($dept_list)){
												echo '<option  value = "'.$list['sno'].'" ';
												if(isset($_GET['id'])){
													if(isset($stu_details['domicile'])){
														if($stu_details['domicile'] == $list['sno']){
															echo ' selected = "selected" ';
														}
													}
												}
												echo '>'.$list['domicile'].'</option>';
											}
										?>
									</select>

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
								
								<label for="selectOption">DOMICILE</label>
								<?php
									$sql = 'SELECT * FROM `mst_domicile` WHERE sno ="'.$stu_details['domicile'].'"';
									$domicile_state = mysqli_fetch_assoc(execute_query($db2,$sql));
								?>
								<input type="text" name="domicile" id="domicile" class="form-control "  value="<?php echo $stu_info['state']; ?>"  tabindex="<?php echo $tabindex++;?>" style="pointer-events:none; " readonly />
								
							</div>
						</div>
						<div class="row mt-1">	
							<div class="col-md-6">							
								<label>MOTHER TONGUE</label>
								<select name="mother_tongue1" id="mother_tongue" class="form-control" tabindex="<?php echo $tabindex++;?>" required>
									<option value="hindi" <?php if(isset($_GET['id'])){if($stu_details['mother_tongue']=="hindi"){ echo 'selected ';}}?>>Hindi</option>
									<option value="english" <?php if(isset($_GET['id'])){if($stu_details['mother_tongue']=="english"){ echo 'selected ';}}?>>English</option>
									
								</select>
							</div>
							<div class="col-md-6">							
								<label>MOTHER TONGUE</label>
								<input type="text" name="mother_tongue" id="mother_tongue" class="form-control " value="<?php echo $stu_info['mother_tongue']; ?>"  tabindex="<?php echo $tabindex++;?>"  style="pointer-events:none; " readonly  required />
							</div>
						</div>
						<div class="row mt-1">
							
							
							
							<div class="col-md-6">
								
								<label for="selectOption">WEIGHTAGE</label>
									<select name="weightage1" id="weightage1" class="form-control" tabindex="<?php echo $tabindex++;?>" required>
										<option value="" disabled selected>---Select Your Weightage ---</option>
										<option value="not_applicable" <?php if(isset($_GET['id'])){if($stu_details['weightage']=="not_applicable"){ echo 'selected ';}}?>>Not applicable </option>
										<option value="ncc" <?php if(isset($_GET['id'])){if($stu_details['weightage']=="ncc"){ echo 'selected ';}}?>>NCC</option>
										<option value="freedom_fighters" <?php if(isset($_GET['id'])){if($stu_details['weightage']=="freedom_fighters"){ echo 'selected ';}}?>>Freedom Fighters</option>
										<option value="sports_achievements" <?php if(isset($_GET['id'])){if($stu_details['weightage']=="sports_achievements"){ echo 'selected ';}}?>>Sports Achievements</option>
										<option value="cultural_activities" <?php if(isset($_GET['id'])){if($stu_details['weightage']=="cultural_activities"){ echo 'selected ';}}?>>Cultural Activities</option>
										<option value="social_work" <?php if(isset($_GET['id'])){if($stu_details['weightage']=="social_work"){ echo 'selected ';}}?>>Social Work</option>
										<option value="volunteering" <?php if(isset($_GET['id'])){if($stu_details['weightage']=="volunteering"){ echo 'selected ';}}?>>Volunteering</option>
									</select>

								<script>
									function validateForm() {
										var selectedOption = document.getElementById('weightage').value;
										if (selectedOption === "") {
											alert("Please select Weightage");
											return false;
										}
										return true;
									}
								</script>
								
							</div>
							<div class="col-md-6">
								
								<label for="selectOption">WEIGHTAGE</label>
									
									<input type="text" name="waightage" id="waightage" class="form-control " value="<?php echo $stu_info['waightage']; ?>"  tabindex="<?php echo $tabindex++;?>"  style="pointer-events:none; " readonly  required />
							</div>
						</div>
						<div class="row mt-1">
							
							<div class="col-md-6">
								
								<label for="selectOption">Blood Group</label>
									<select name="blood_group1" id="blood_group1" class="form-control" tabindex="<?php echo $tabindex++;?>" >
										<option value="" disabled selected>---Select Your Blood Group ---</option>
										<option value="N/A" <?php if(isset($_GET['id']) && $stu_details['blood_group']=="N/A"){ echo 'selected ';}?>>N/A</option>
										<option value="A+" <?php if(isset($_GET['id']) && $stu_details['blood_group']=="A+"){ echo 'selected ';}?>>A+</option>
										<option value="A-" <?php if(isset($_GET['id']) && $stu_details['blood_group']=="A-"){ echo 'selected ';}?>>A-</option>
										<option value="B+" <?php if(isset($_GET['id']) && $stu_details['blood_group']=="B+"){ echo 'selected ';}?>>B+</option>
										<option value="B-" <?php if(isset($_GET['id']) && $stu_details['blood_group']=="B-"){ echo 'selected ';}?>>B-</option>
										<option value="AB+" <?php if(isset($_GET['id']) && $stu_details['blood_group']=="AB+"){ echo 'selected ';}?>>AB+</option>
										<option value="AB-" <?php if(isset($_GET['id']) && $stu_details['blood_group']=="AB-"){ echo 'selected ';}?>>AB-</option>
										<option value="O+" <?php if(isset($_GET['id']) && $stu_details['blood_group']=="O+"){ echo 'selected ';}?>>O+</option>
										<option value="O-" <?php if(isset($_GET['id']) && $stu_details['blood_group']=="O-"){ echo 'selected ';}?>>O-</option>
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
								
								<label for="selectOption">Blood Group</label>
									<input type="text" name="blood_group" id="blood_group" class="form-control " value="<?php echo $stu_info['blood_group']; ?>"  tabindex="<?php echo $tabindex++;?>"  style="pointer-events:none; " readonly  />
								
							</div>
						</div>
						<div class="row mt-1">
							
							<div class="col-md-6">	
								<label>Status</label>
								<select name="status" id="status1" class="form-control"  style="pointer-events:none;" tabindex="<?php echo $tabindex++;?>" required>
									<option value="reguler" <?php echo (isset($_GET['id'])  && isset($data['status']) && $data['status']=='reguler') ? 'selected="selected"' : ''; ?>>Regular</option>
									
								</select>
							</div>
							<div class="col-md-6">	
								<label>stu_Status</label>
									<input type="text" name="stu_status" id="status" class="form-control " value="<?php echo $stu_info['stu_status']; ?>"  tabindex="<?php echo $tabindex++;?>"  style="pointer-events:none; " readonly  required />
							</div>
						</div>
					
						<div class="row mt-1">
							<div class="col-md-6">
								<div class="row">
									<div class="col-6 text-center"><img src="http://knipssexams.in/<?php echo $stu_details['photo'] ;?>" style="height: 100px;" class="img img-fluid"></div>
									<div class="col-6 text-center"><img src="http://knipssexams.in/<?php echo $stu_details['signature'] ;?>" style="height: 100px;" class="img img-fluid"></div>
								</div>
									
								<input type="hidden" name="photo1" id="photo1" class="form-control " value="http://knipssexams.in/<?php echo $stu_details['photo'] ;?>" tabindex="<?php echo $tabindex++;?>">
								<input type="hidden" name="signature1" id="signature1" class="form-control " value="http://knipssexams.in/<?php echo $stu_details['signature'];?>" tabindex="<?php echo $tabindex++;?>">
						</div>
						
					</div>
				
			</div>
	<div id="educationDetailsContainer">
			<h2 class="text-dark" >Education Details</h2>
		
                  
		<div class="container">
    <table class="table table-striped table-hover rounded ">
        <thead class="bg-secondary text-white">
            <tr>
                <th scope="col-" >S.No</th>
                <th scope="col" >Name Of<br> Examination</th>
                <th scope="col" >Board<br>University Name</th>
                <th scope="col" >College Name</th>
                <th scope="col">Year of<br> Passing</th>
                <th scope="col" >Roll No</th>
                <th scope="col">Select</th>
                <th scope="col">Obt. Marks</th>
                <th scope="col" >Total Marks</th>
                <th scope="col">Percentage</th>
                <th scope="col" >&nbsp;&nbsp;&nbsp;CGPA &nbsp;&nbsp;</th>
                <th scope="col" >Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
			if($data['course_type']=='2'){
				
				$a = 5;	
			}
			elseif ($data['course_applying_for'] == '52' || $data['course_applying_for'] == '53' || $data['course_applying_for'] == '54') {
				$a = 5;
			}
			else{
				$a = 3;
			}
			if ($data['course_applying_for'] == '52' || $data['course_applying_for'] == '53' || $data['course_applying_for'] == '54') {
				$a = 5;
			}

            for ($i = 1; $i < $a; $i++) {
                if ($i % 2 != 0) {
                    echo '<tr class="table-secondary">';
                } else {
                    echo '<tr>';
                }
                ?>
                <td><?php echo $i; ?></td>
                <?php
                if ($i == 1) {
                    echo '<td>High School<input type="hidden" name="part_desc' . $i . '"  value="High School" required ></td>';
                } elseif ($i == 2) {
                    echo '<td>Intermediate<input type="hidden" name="part_desc' . $i . '"  value="Intermediate" required ></td>';
                } elseif ($i == 3 || $i == 4) {
                    ?>
                    <td>
                        <select name="part_desc<?php echo $i; ?>" id="part_desc<?php echo $i; ?>" onBlur="tab_fill(1,8)" onFocus="getCurrent(<?php echo $i; ?>)">
                            <option value="<?php echo isset($_POST['part_desc' . $i]) ? $_POST['part_desc' . $i] : ''; ?>"
                                    selected><?php if (isset($_POST['part_desc' . $i . ''])) {
                                    echo $_POST['part_desc' . $i . ''];
                                } ?></option>

                            <option value="B.Ed">B.Ed</option>
                            <?php
                            $sql = 'select * from class_detail ';
                            $result = execute_query($db2,$sql);
                            if ($result) {
                                while ($name = mysqli_fetch_array($result)) {
                                    echo '<option value="' . $name['sno'] . '" ';
                                    echo '>' . $name['class_description'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </td>
                    <?php
                }
                ?>
                <td>
                    <input name="part_desc<?php echo $i; ?>_board" type="text"
                           value="<?php echo isset($_GET['id']) ? (isset($_POST['part_desc' . $i . '_board']) ? $_POST['part_desc' . $i . '_board'] : '') : '' ?>"
                           class="form-control" maxlength="100" id="part_desc<?php echo $i; ?>_board"  <?php if($i<=3){ echo " required ";} ?> />
                </td>

                <td><input name="part_desc<?php echo $i; ?>_college" type="text"
                           value="<?php if (isset($_POST['part_desc' . $i . '_college'])) {
                               echo $_POST['part_desc' . $i . '_college'];
                           } ?>" class="form-control" maxlength="100" id="part_desc<?php echo $i; ?>_college" <?php if($i<=3){ echo " required ";} ?>  /></td>

                <td><input name="part_desc<?php echo $i; ?>_year" type="text"
                           value="<?php if (isset($_POST['part_desc' . $i . '_year'])) {
                               echo $_POST['part_desc' . $i . '_year'];
                           } ?>" class="form-control" maxlength="6" id="part_desc<?php echo $i; ?>_year"  <?php if($i<=3){ echo " required ";} ?> /></td>

                <td><input name="part_desc<?php echo $i; ?>_rollno" type="text"
                           value="<?php if (isset($_POST['part_desc' . $i . '_rollno'])) {
                               echo $_POST['part_desc' . $i . '_rollno'];
                           } ?>" class="form-control"  id="part_desc<?php echo $i; ?>_rollno"  <?php if($i<=3){ echo " required ";} ?> />
                </td>

                <td width="10%">
                    <select name="" id="select<?php echo $i; ?>" class="form-control"
                            onchange="toggleFields(<?php echo $i; ?>)">
                        <option value="" selected>--select--</option>
                        <option value="percentage" <?php if (isset($_POST['part_desc' . $i . '_obtmarks'])) {
                            echo 'selected="selected"';
                        } ?>>percentage
                        </option>
                        <option value="cgpa" <?php if (isset($_POST['part_desc' . $i . '_cgpa'])) {
                            echo 'selected="selected"';
                        } ?>>CGPA
                        </option>
                    </select>
                </td>

                <td><input name="part_desc<?php echo $i; ?>_obtmarks" type="text"
                           value="<?php if (isset($_POST['part_desc' . $i . '_obtmarks'])) {
                               echo $_POST['part_desc' . $i . '_obtmarks'];
                           } ?>" placeholder="Obtained Marks" class="form-control" maxlength="6"
                           id="<?php echo $i ?>_obt"/></td>
                <td>
                    <input name="part_desc<?php echo $i; ?>_totmarks" type="text"
                           value="<?php if (isset($_POST['part_desc' . $i . '_totmarks'])) {
                               echo $_POST['part_desc' . $i . '_totmarks'];
                           } ?>" placeholder="Total Marks" class="form-control" maxlength="6"
                           onBlur="get_perc(<?php echo $i ?>)" id="<?php echo $i ?>_total"/></td>
                <td>
                    <input name="part_desc<?php echo $i; ?>_percentage" type="text"
                           value="<?php if (isset($_POST['part_desc' . $i . '_percentage'])) {
                               echo $_POST['part_desc' . $i . '_percentage'];
                          } ?>" placeholder="Percentage" class="form-control" maxlength="6"
                           id="<?php echo $i ?>_perc" OnBlur="get_division(<?php echo $i ?>)"/></td>
                <td>
                    <input name="part_desc<?php echo $i; ?>_cgpa" type="text"
                           value="<?php if (isset($_POST['part_desc' . $i . '_cgpa'])) {
                               echo $_POST['part_desc' . $i . '_cgpa'];
                           } ?>" class="form-control" placeholder="Enter CGPA" maxlength="10"
                           id="<?php echo $i ?>_cgpa"/></td>

                <td>
                    <select name="part_desc<?php echo $i; ?>_status"
                            value="<?php if (isset($_POST['part_desc' . $i . '_status'])) {
                                echo $_POST['part_desc' . $i . '_status'];
                            } ?>" id="part_desc" onBlur="tab_fill(1,8)" onFocus="getCurrent(<?php echo $i; ?>)">
                        <option value="Passed">Passed</option>
                        <option value="Failed">Failed</option>
                    </select>
                </td>
                <input type="hidden" name="q_sno<?php echo $i; ?>" value="<?php echo isset($_GET['id']) ? isset($_POST['q_sno' . $i]) ? $_POST['q_sno' . $i] : '' : '' ?>">
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</div>
		
		<div>
			
			<div  name="info_table" id="info_table">
				<table width="100%" class="table table-striped-primary table-hover rounded ">	
					<tr class="bg-secondary text-white ">
						<th colspan="6" class="h5"><strong>Permanent Address</strong></th>
					</tr>
					<tr class="table-secondary">
						<input type="hidden" name="p_sno" value="<?php echo isset($_GET['id'])? $p_address_details['sno']: '' ?>">
						<th>House No./Village</th>
						<td><input type="text"  class="form-control" id="p_address" name="p_address" value="<?php echo isset($_GET['id'])? $p_address_details['address'] : '' ?>"  required></td>
						<th>Post</th>
						<td><input type="text" class="form-control" id="p_post" name="p_post" value="<?php echo isset($_GET['id'])? $p_address_details['post'] : '' ?>"   required></td>
						<th>Tahsil</th>
						<td><input type="text" class="form-control" id="p_tehsil" name="p_tehsil" value="<?php echo isset($_GET['id'])? $p_address_details['tehsil'] : '' ?>" required></td>
					</tr>
					<tr>
						<th>Thana</th>
						<td><input type="text" class="form-control" id="p_thana" name="p_thana" value="<?php echo isset($_GET['id'])? $p_address_details['thana'] : '' ?>" required></td>
						<th>District</th>
						<td><input type="text" class="form-control" id="p_district" name="p_district" value="<?php echo isset($_GET['id'])? $p_address_details['district'] : '' ?>" required></td>
						<th>State</th>
						<td><input type="text" class="form-control" id="p_state" name="p_state" value="<?php echo isset($_GET['id'])? $p_address_details['state'] : '' ?>" required></td>
					</tr>
					<tr>
						
						<th>Pin</th>
						<td><input type="text" class="form-control"  id="p_pin" name="p_pin" value="<?php echo isset($_GET['id'])? $p_address_details['pin'] : '' ?>" required></td>
					</tr>
					<tr class="bg-secondary text-white">
						<th colspan="6" class="h5" >Correspondence Address <a href="javascript:copy_adr()" class="btn btn-danger" >Click Here to Copy</a></th>
					</tr>
					<tr class="table-secondary">
						<input type="hidden" name="c_sno" value="<?php echo isset($_GET['id'])? $c_address_details['sno']: '' ?>">
						<th>House No./Village</th>
						<td><input type="text" class="form-control" id="c_address" name="c_address" value="<?php echo isset($_GET['id'])? $c_address_details['address']: '' ?>" required></td>
						<th>Post</th>
						<td><input type="text" class="form-control" id="c_post" name="c_post" value="<?php echo isset($_GET['id'])? $c_address_details['post']: '' ?>" required></td>
						<th>Tahsil</th>
						<td><input type="text" class="form-control" id="c_tehsil" name="c_tehsil" value="<?php echo isset($_GET['id'])? $c_address_details['tehsil']: '' ?>" required></td>
						
					</tr>
					<tr>
						<th>Thana</th>
						<td><input type="text" class="form-control" id="c_thana" name="c_thana" value="<?php echo isset($_GET['id'])? $c_address_details['thana']: '' ?>" required></td>
						<th>District</th>
						<td><input type="text" class="form-control" id="c_district" name="c_district" value="<?php echo isset($_GET['id'])? $c_address_details['district']: '' ?>" required></td>
						<th>State</th>
						<td><input type="text" class="form-control" id="c_state" name="c_state" value="<?php echo isset($_GET['id'])? $c_address_details['state']: '' ?>" required></td>
					</tr>
					<tr>
						<th>Pin</th>
						<td><input type="text" class="form-control"  id="c_pin" name="c_pin" value="<?php echo isset($_GET['id'])? $c_address_details['pin']: '' ?>" required></td>
					</tr>
					
				</table>
			</div>
		</div>


		
		<table>
			<input type="hidden" name="qualification_no" value="<?php echo --$i; ?>" /><br/>
			<input type="hidden" name="id" id="id" value="<?php echo isset($_REQUEST['id'])? $_REQUEST['id']:"" ?>" />
			<input type="hidden" name="user_roll_no" id="user_roll_no" value="<?php echo isset($_REQUEST['rn'])? $_REQUEST['rn']:"" ?>" />
			<?php if($verified==0){?><center><button type="submit" class="btn btn-success "  name="verify" value="Submit">Verify</button></center><?php } ?>
		</form>

		<script type="text/javascript">
					function show_info() {

					
						 $("#info_table").toggle();
					
				}
				 function copy_adr(){
					 document.getElementById('c_address').value = document.getElementById('p_address').value;
					 document.getElementById('c_district').value = document.getElementById('p_district').value;
					 document.getElementById('c_state').value = document.getElementById('p_state').value;
					 document.getElementById('c_post').value = document.getElementById('p_post').value;
					 document.getElementById('c_pin').value = document.getElementById('p_pin').value;
					 document.getElementById('c_tehsil').value = document.getElementById('p_tehsil').value;
					 document.getElementById('c_thana').value = document.getElementById('p_thana').value;
				 }
				 
				 
				 
				</script>

				<script language="javascript">
				function get_perc(value) {
    var obtmarks = '';
    var totmarks = '';
    var percentage = '';

    value = value.toString();
    obtmarks = value.concat("_obt");
    obtmarks = parseFloat(document.getElementById(obtmarks).value);
    totmarks = value.concat("_total");
    totmarks = parseFloat(document.getElementById(totmarks).value);
    percentage = value.concat("_perc");

    var calculatedPercentage = (obtmarks / totmarks) * 100;
    document.getElementById(percentage).value = calculatedPercentage.toFixed(2);
}
				function get_division(value){
					var percentage='';
					value = value.toString();
					percentage = value.concat('_perc');
					//alert(percentage);
					percentage= parseFloat(document.getElementById(percentage).value);
					division= value.concat('_division');
					if(percentage>=60){
						document.getElementById(division).value ='FIRST';
					}
					else if(percentage<60 && percentage>=45){
						document.getElementById(division).value ='SECOND';
					}
					else if(percentage<45){
						document.getElementById(division).value ='THIRD';
					}
					
				}



				function printinvoice() {
					window.open("printing.php?inv=<?php echo isset($fee_print['sno'])?$fee_print['sno']:'';?>");
				}
				function get_subject(class_name){
					if(class_name==91){// class_name>=76 && class_name<=81 || class_name>=52 && class_name<=59 || class_name==45 || class_name==28){
						document.getElementById('fees').style.display='block';
					}
					else{
						document.getElementById('fees').style.display='none';
					}
					
					if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
						xmlhttp=new XMLHttpRequest();
					}
					else{// code for IE6, IE5
						xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
					}
					
					xmlhttp.onreadystatechange=function(){
						if (xmlhttp.readyState==4 && xmlhttp.status==200){
							var v = xmlhttp.responseText;
							v = JSON.parse(v);
							//console.log(v);
							//alert(v);
							//var v = v.split('#');
							//console.log(v[6]);
							if(v['class_category']=='PG' || v['class_type']=='aided' || v['class_type']=='PG'){
								document.getElementById('prev_univ_li').style.display = 'block';
							}
							else{
								document.getElementById('prev_univ_li').style.display = 'none';
							}
							if(v['computer']==''){
								document.getElementById('computer').style.display = 'none';
							}
							else{
								document.getElementById('computer').style.display = 'block';
							}
							if(v['self']==''){
								document.getElementById('self').style.display = 'none';
							}
							else{
								document.getElementById('self').style.display = 'block';
							}
							if(v['tour']==''){
								document.getElementById('tour').style.display = 'none';
							}
							else{
								document.getElementById('tour').style.display = 'block';
							}
							if(v['vocational']=='' || v['vocational']==null){
								document.getElementById('vocational').style.display = 'none';
							}
							else{
								document.getElementById('vocational').style.display = 'block';
							}
							if(v['class_type']=='SELF'){
								document.getElementById('fees_detail').style.display='block';
								document.getElementById('fees_value').innerHTML=v['fees'];
								document.getElementById('max_discount').innerHTML=v['discount'];
								v['fees'] = parseFloat(v['fees'])?parseFloat(v['fees']):0;
								v['discount'] = parseFloat(v['discount'])?parseFloat(v['discount']):0;
								v['fix_amount'] = parseFloat(v['fix_amount'])?parseFloat(v['fix_amount']):0;
								document.getElementById('fees_deposit').value=(v['fees']-v['discount'])+v['fix_amount'];
								document.getElementById('fix_amount').value=(v['fees']-v['discount']);
							}
							document.getElementById('sub1').innerHTML=v['subjects'];
							<?php 
							if(isset($_POST['sub1'])){
								echo "document.getElementById('sub1').value = '".$_POST['sub1']."';";
							}
							?>
							//alert(v[2]);
							if(v['class_category']!='PG' && v['class_type']!='self'){
								document.getElementById('sub2').innerHTML=v['subjects']+'<option value=""></option>';
								<?php 
								if(isset($_POST['sub2'])){
									echo "document.getElementById('sub2').value = '".$_POST['sub2']."';";
								}
								?>
								if(class_name == 3|| class_name == 6 || class_name == 9 || class_name == 35){
									document.getElementById('sub3').innerHTML='';
								}
								else {
									document.getElementById('sub3').innerHTML=v['subjects'];
									<?php 
									if(isset($_POST['sub3'])){
										echo "document.getElementById('sub3').value = '".$_POST['sub3']."';";
									}
									?>
								}
							}
							else{
								document.getElementById('sub2').innerHTML='';
								document.getElementById('sub3').innerHTML='';
							}
						}
					}
					xmlhttp.open("GET","get_subject.php?q="+class_name,true);
					xmlhttp.send();
					get_session(class_name);
				}
					
				function get_session(class_name){
					if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
						xmlhttp1=new XMLHttpRequest();
					}
					else{// code for IE6, IE5
						xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
					}
					xmlhttp1.onreadystatechange=function(){
						if (xmlhttp1.readyState==4 && xmlhttp.status==200){
							var v = xmlhttp1.responseText;
							//console.log("Test: "+v);
							v = JSON.parse(v);
							document.getElementById("batch").value = v['session_from']+'-'+v['session_to'];			
						}
					}
					xmlhttp1.open("GET","get_session.php?q="+class_name,true);
					xmlhttp1.send();
				}
					
				function check_discount(val){
					var fees = (!parseFloat(document.getElementById('fees_value').innerHTML))?0:parseFloat(document.getElementById('fees_value').innerHTML);
					var max_discount = (!parseFloat(document.getElementById('max_discount').innerHTML))?0:parseFloat(document.getElementById('max_discount').innerHTML);
					var fees_discount = (!parseFloat(document.getElementById('fees_discount').value))?0:parseFloat(document.getElementById('fees_discount').value);
					
					if(fees_discount>max_discount){
						alert('Discount Not Allowd.');
						document.getElementById('fees_discount').value = '';
						document.getElementById('fees_discount').focus();
					}
					else{
						var final_fees = fees-fees_discount;
					}
					document.getElementById('final_fees').innerHTML = final_fees;
					document.getElementById('fees_deposit').value = final_fees;
					document.getElementById('final_fees_value').value = final_fees;

					
				}

				function check_deposit(val){
					var fees_deposit = (!parseFloat(document.getElementById('fees_deposit').value))?0:parseFloat(document.getElementById('fees_deposit').value);
					var fix_amount = (!parseFloat(document.getElementById('fix_amount').value))?0:parseFloat(document.getElementById('fix_amount').value);
					if(fees_deposit<fix_amount){
						alert('Deposit amount is less than fix amount.');
						document.getElementById('fees_deposit').value = '';
					}
				}
					
				function isNumberKey(evt)
					  {
						 var charCode = (evt.which) ? evt.which : event.keyCode
						 if (charCode > 31 && (charCode < 48 || charCode > 57))
							return false;

						 return true;
					  }
					function fnTXTFocus(id)
					{

						var objTXT = document.getElementById(id)
						objTXT.style.borderColor = "Red";

					}

					function fnTXTLostFocus(id)
					{
						var objTXT = document.getElementById(id)
						objTXT.style.borderColor = "green";
					}
				window.onload = function(){
					<?php
					if(isset($_POST['s_class'])){
						echo "get_subject(".$_POST['s_class'].");";
					}
					?>
				};
				</script>
				<script type="text/javascript">
					function copy_address(){
						var address = document.getElementById('t_address').value;
						document.getElementById('address').value = address;
					}
				</script>
			</form>
		</div>
		
	</div>
</div>  
<script>

	$(document).ready(function(){
		let selected_value = $("#course_type").val();
			//console.log(selected_value);

			$.ajax({
    			url: 'ajax_course_applied_for.php',
    			method: 'GET',
				data : {selected_value: selected_value, id: <?php echo $_GET['id']?>},
    			success: function(data){
					$("#course_applying_for").html(data);
    			}
    		});
	})
    // Initialize the display state of fields when the page loads
    document.addEventListener("DOMContentLoaded", function () {
        for (var i = 1; i < 5; i++) {
            toggleFields(i);
        }
    });

    function toggleFields(row) {
        var selectedOption = document.getElementById('select' + row).value;
        var obtMarks = document.getElementById(row + '_obt');
        var totMarks = document.getElementById(row + '_total');
        var perc = document.getElementById(row + '_perc');
        //var division = document.getElementById(row + '_division');
        var cgpa = document.getElementById(row + '_cgpa');

        if (selectedOption === 'percentage') {
            obtMarks.style.display = 'block';
            totMarks.style.display = 'block';
            perc.style.display = 'block';
            //division.style.display = 'block';
            cgpa.style.display = 'none';
        } else if (selectedOption === 'cgpa') {
            obtMarks.style.display = 'none';
            totMarks.style.display = 'none';
            perc.style.display = 'none';
            //division.style.display = 'none';
            cgpa.style.display = 'block';
        } else {
            obtMarks.style.display = 'none';
            totMarks.style.display = 'none';
            perc.style.display = 'none';
            //division.style.display = 'none';
            cgpa.style.display = 'none';
        }
    }
    // Get references to the course type dropdown and education details container
    const courseTypeDropdown = document.getElementById('course_type');
    const educationDetailsContainer = document.getElementById('educationDetailsContainer');

    // Function to show or hide education details rows based on the selected course type
    function toggleEducationDetails() {
        const selectedCourseType = courseTypeDropdown.value;

        // Check the selected course type and toggle visibility accordingly
        if (selectedCourseType === 'UG') {
            // Show only "High School" and "Intermediate" rows
            showOnlyHighSchoolAndIntermediateRows();
        } else if (selectedCourseType === 'PG') {
            // Show all rows
            showAllRows();
        } else {
            // Hide all rows if no course type is selected
            hideAllRows();
        }
    }

    // Function to show only "High School" and "Intermediate" rows
    function showOnlyHighSchoolAndIntermediateRows() {
        // Your logic to show only relevant rows here
        // For example, you can set the display property of rows accordingly
    }

    // Function to show all rows
    function showAllRows() {
        // Your logic to show all rows here
        // For example, you can set the display property of rows accordingly
    }

    // Function to hide all rows
    function hideAllRows() {
        // Your logic to hide all rows here
        // For example, you can set the display property of rows to 'none'
    }

    // Add an event listener to the course type dropdown to trigger the toggle function
    courseTypeDropdown.addEventListener('change', toggleEducationDetails);

    // Initially, call the toggle function to set the initial visibility based on the default selection
    toggleEducationDetails();
</script>
</div>
<?php
page_footer_start();
?>