<?php

//session_cache_limiter('nocache');

//session_start();

include("scripts/settings.php");

logvalidate('admin');

page_header_start();

$msg='';

if(isset($_POST['submit'])){

	if($_POST['stu_name']=='' && $_POST['class']=='' && $_POST['amount']=='' && $_POST['fee_submission_type']==''){

		$msg='<li style="color:red"><b>Please Fill Student Details</b></li>';

	}

	elseif($_POST['student_id'] !=''){

		$sql="UPDATE `form_fee` SET 
		`stu_name`='".$_POST['stu_name']."',
		`father_name`='".$_POST['father_name']."',
		`class`='".$_POST['class']."',
		`dob`='".$_POST['dob_date']."',
		`mobile`='".$_POST['mobile']."',
		`gender`='".$_POST['gender']."',
		`batch`='".$_POST['batch']."',
		`post`='".$_POST['address']."',
		`sub1`='".$_POST['sub1']."',
		`e_mail1`='".$_POST['email_id']."',
		`form_no`='".$_POST['form_no']."',
		`blood_group`='".$_POST['blood_group']."',
		`aadhar`='".$_POST['aadhar']."' , 
		`fee_submission_type`='".$_POST['fee_submission_type']."' , 
		`amount`='".$_POST['amount']."' , 
		`amount_paid`='".$_POST['amount']."' , 
		`category`='".$_POST['category']."' , 
		`edited_by`='".$_SESSION['username']."' , 
		`edition_time`='".date('Y-m-d h:i:s')."'";
		 if($_SESSION['username']=='sadmin'){
		 	$sql .= ", `approval_date`='".$_POST['fee_submission_date']."', `fee_submission_date`='".$_POST['fee_submission_date']."' ";
		 }
		 $sql .= " where sno='".$_POST['student_id']."'";
		execute_query(connect(), $sql);
		if(mysqli_error(connect())){
			$msg .= '<li style="color:red">Failed : '.mysqli_error(connect()).' >> '.$sql.'</li>';
		}
		else{
			$pic_sno = $_POST['student_id'];
			$msg='<li style="color:red"><b> Student Details Update Succesful</b></li>';
			$msg .= '<li class="error"><a href="form_fee_print.php?id='.$pic_sno.'" target="_blank">Click Here to print.</a></li>';
			$msg .= '<script>window.open("form_fee_print.php?id='.$pic_sno.'");</script>';
			$_POST['class']='';
			$_POST['amount']='';
			$_POST['fee_submission_type']='';
			$_POST['fee_submission_date']='';
			unset($_POST);

		}



	}

	else{

		$re = 0;

		$sql_form = 'SELECT * FROM `form_fee` WHERE `form_no`="'.$_POST['form_no'].'"';

		$result_form = execute_query(connect(), $sql_form);

		if(mysqli_num_rows($result_form) != 0){

			echo '<li style="color:red"><b>Duplicate Form Number Not Allowed....</b></li>';

			$re = 1;

		}

		else{

			if(!isset($_POST['fee_submission_date'])){

				$_POST['fee_submission_date'] = date('Y-m-d');

			}

			$month = date('m' , strtotime($_POST['fee_submission_date']));

			$year = date('Y' , strtotime($_POST['fee_submission_date']));

			if($_POST['class'] == "66" || $_POST['class'] == "67" || $_POST['class'] == "68" || $_POST['class'] == "69" || $_POST['class'] == "70" || $_POST['class'] == "71" || $_POST['class'] == "72" || $_POST['class'] == "73" || $_POST['class'] == "74" || $_POST['class'] == "75"){

				if($_POST['fee_submission_type'] == "Admission Form"){

					$sql_receipt ='SELECT * FROM `form_fee` WHERE `class` IN ("66" , "67" , "68" , "69" , "70" , "71" , "72" , "73" , "74" , "75") AND `financial_year`="2020-2021" AND `fee_submission_type`="Admission Form" ORDER BY ABS(`receipt_number`) DESC LIMIT 1';

					$result_receipt = execute_query(connect(), $sql_receipt);

					$row_receipt = mysqli_fetch_array($result_receipt);

					$receipt_number = $row_receipt['receipt_number'] + 1;

				}

				else if($_POST['fee_submission_type'] == "Duplicate Form"){

					$sql_receipt ='SELECT * FROM `form_fee` WHERE `class` IN ("66" , "67" , "68" , "69" , "70" , "71" , "72" , "73" , "74" , "75") AND `financial_year`="2020-2021" AND `fee_submission_type`="Duplicate Form" ORDER BY ABS(`receipt_number`) DESC LIMIT 1';

					$result_receipt = execute_query(connect(), $sql_receipt);

					$row_receipt = mysqli_fetch_array($result_receipt);

					$receipt_number = $row_receipt['receipt_number'] + 1;

				}

				else if($_POST['fee_submission_type'] == "tc_cc"){

					$sql_receipt ='SELECT * FROM `form_fee` WHERE `class` IN ("66" , "67" , "68" , "69" , "70" , "71" , "72" , "73" , "74" , "75") AND `financial_year`="2020-2021" AND `fee_submission_type`="tc_cc" ORDER BY ABS(`receipt_number`) DESC LIMIT 1';

					$result_receipt = execute_query(connect(), $sql_receipt);

					$row_receipt = mysqli_fetch_array($result_receipt);

					$receipt_number = $row_receipt['receipt_number'] + 1;

				}

				else if($_POST['fee_submission_type'] == "miscellaneous"){

					$sql_receipt ='SELECT * FROM `form_fee` WHERE `class` IN ("66" , "67" , "68" , "69" , "70" , "71" , "72" , "73" , "74" , "75") AND `financial_year`="2020-2021" AND `fee_submission_type`="miscellaneous" ORDER BY ABS(`receipt_number`) DESC LIMIT 1';

					$result_receipt = execute_query(connect(), $sql_receipt);

					$row_receipt = mysqli_fetch_array($result_receipt);

					$receipt_number = $row_receipt['receipt_number'] + 1;

				}

			}

			else{

				if($_POST['fee_submission_type'] == "Admission Form"){

					$sql_receipt ='SELECT * FROM `form_fee` WHERE `class` NOT IN ("66" , "67" , "68" , "69" , "70" , "71" , "72" , "73" , "74" , "75") AND `financial_year`="2020-2021" AND `fee_submission_type`="Admission Form" ORDER BY ABS(`receipt_number`) DESC LIMIT 1';

					$result_receipt = execute_query(connect(), $sql_receipt);

					$row_receipt = mysqli_fetch_array($result_receipt);

					$receipt_number = $row_receipt['receipt_number'] + 1;

				}

				else if($_POST['fee_submission_type'] == "Duplicate Form"){

					$sql_receipt ='SELECT * FROM `form_fee` WHERE `class` NOT IN ("66" , "67" , "68" , "69" , "70" , "71" , "72" , "73" , "74" , "75") AND `financial_year`="2020-2021" AND `fee_submission_type`="Duplicate Form" ORDER BY ABS(`receipt_number`) DESC LIMIT 1';

					$result_receipt = execute_query(connect(), $sql_receipt);

					$row_receipt = mysqli_fetch_array($result_receipt);

					$receipt_number = $row_receipt['receipt_number'] + 1;

				}

				else if($_POST['fee_submission_type'] == "tc_cc"){

					$sql_receipt ='SELECT * FROM `form_fee` WHERE `class` NOT IN ("66" , "67" , "68" , "69" , "70" , "71" , "72" , "73" , "74" , "75") AND `financial_year`="2020-2021" AND `fee_submission_type`="tc_cc" ORDER BY ABS(`receipt_number`) DESC LIMIT 1';

					$result_receipt = execute_query(connect(), $sql_receipt);

					$row_receipt = mysqli_fetch_array($result_receipt);

					$receipt_number = $row_receipt['receipt_number'] + 1;

				}

				else if($_POST['fee_submission_type'] == "miscellaneous"){

					$sql_receipt ='SELECT * FROM `form_fee` WHERE `class` NOT IN ("66" , "67" , "68" , "69" , "70" , "71" , "72" , "73" , "74" , "75") AND `financial_year`="2020-2021" AND `fee_submission_type`="miscellaneous" ORDER BY ABS(`receipt_number`) DESC LIMIT 1';

					$result_receipt = execute_query(connect(), $sql_receipt);

					$row_receipt = mysqli_fetch_array($result_receipt);

					$receipt_number = $row_receipt['receipt_number'] + 1;

				}

			}

			$sql="INSERT INTO `form_fee`( `stu_name`, `father_name`,`class`, `dob`, `mobile`, `gender`,`post`, `sub1`, `e_mail1`,`form_no`, `blood_group`,`aadhar` , `fee_submission_type` , `fee_submission_date` , `amount` , `amount_paid`, `approval_date`, `timestamp` , `category` , `receipt_number` , `financial_year` , `created_by` , `creation_time`,`batch`) VALUES ('".$_POST['stu_name']."','".$_POST['father_name']."','".$_POST['class']."','".$_POST['dob_date']."','".$_POST['mobile']."','".$_POST['gender']."','".$_POST['address']."','".$_POST['sub1']."','".$_POST['email_id']."','".$_POST['form_no']."','".$_POST['blood_group']."','".$_POST['aadhar']."' , '".$_POST['fee_submission_type']."' , '".$_POST['fee_submission_date']."' , '".$_POST['amount']."', '".$_POST['amount']."', '".$_POST['fee_submission_date']."', '".time()."' , '".$_POST['category']."' , '".$receipt_number."' , '2020-2021' , '".$_SESSION['username']."' , '".date("Y-m-d h:i:s")."', '".$_POST['batch']."')";		 

		     if(execute_query(connect(), $sql)==true){

		     	$pic_sno = mysqli_insert_id(connect());

		     	$msg='<li style="color:red"><b> Student Details Inserted Succesful</b></li>';

				$msg .= '<li class="error"><a href="form_fee_print.php?id='.$pic_sno.'" target="_blank">Click Here to print.</a></li>';

		     	 $msg .= '<script>window.open("form_fee_print.php?id='.$pic_sno.'");</script>';



		     }

		 }

	     //echo $sql;   

	}	

}

if(isset($_GET['id'])){

	$sql="select * from form_fee where sno='".$_GET['id']."'";

	$run=execute_query(connect(), $sql);

	$row=mysqli_fetch_array($run);

}

page_header_end();
page_sidebar();

?>



<script language="javascript" type="text/javascript">

	

	$( "#sale_date" ).datepicker({ dateFormat: 'yy-mm-dd' });

	$("#sale_date").change(function(){

		$( "#sale_date" ).datepicker("option", "showAnim", "slide");

	});



</script>
<style>
form div.row:nth-child(odd) {
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

<script type="text/javascript" language="javascript" src="form_validator.js"></script>

<body id="public">
	<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">    	
				<form action="form_fee.php" class="wufoo leftLabel page1" name="editroute" enctype="multipart/form-data" method="post">
					<a href="form_fee_report.php" style="float: right;" class="btn btn-primary text-white">Report</a>
					<h2 align="center">Complete Detail of the <span class="orange">Admission</span></h2> 
					<h2 align="center">KAMLA NEHRU INSTITUTE OF PHYSICAL & SOCIAL SCIENCES</h2>
					<h3 align="center">Sultanpur (U.P.) - 228 118 Tel.: 05362-240854</h3>
					<h3 align="center">Accredited by "NAAC" with 'A' Grade</h3>
					<h3>MANUAL FORM <?php echo mysqli_fetch_array(execute_query(connect(),"SELECT * FROM `general_settings` WHERE `description`='session'"))['value']; ?></h3>
					<div class="col-md-12">
						<div class="row">							
							<div class="col-md-4">							
								<label>Fee Submission Type :</label>
								<select name="fee_submission_type" class="form-control" required>

									<option value="">-SELECT ANY ONE-</option>

									<option value="Admission Form" <?php if(isset($_GET['id'])){if($row['fee_submission_type'] == 'Admission Form'){echo 'selected';}}elseif(isset($_POST['fee_submission_type']) AND $re == 1){if($_POST['fee_submission_type'] == 'Admission Form'){echo 'selected';}}else{echo 'selected';} ?>>Admission Form</option>

									<option value="Duplicate Form" <?php if(isset($_GET['id'])){if($row['fee_submission_type'] == 'Duplicate Form'){echo 'selected';}}elseif(isset($_POST['fee_submission_type']) AND $re == 1){if($_POST['fee_submission_type'] == 'Duplicate Form'){echo 'selected';}} ?>>Duplicate Form</option>

									<option value="tc_cc" <?php if(isset($_GET['id'])){if($row['fee_submission_type'] == 'tc_cc'){echo 'selected';}}elseif(isset($_POST['fee_submission_type']) AND $re == 1){if($_POST['fee_submission_type'] == 'tc_cc'){echo 'selected';}} ?>>TC/CC</option>

									<option value="miscellaneous" <?php if(isset($_GET['id'])){if($row['fee_submission_type'] == 'Miscellaneous'){echo 'selected';}}elseif(isset($_POST['fee_submission_type'])  AND $re == 1){if($_POST['fee_submission_type'] == 'Miscellaneous'){echo 'selected';}} ?>>Miscellaneous</option>
									
									<option value="Research Inovation Fee" <?php if(isset($_GET['id'])){if($row['fee_submission_type'] == 'Research Inovation Fee'){echo 'selected';}}elseif(isset($_POST['fee_submission_type'])  AND $re == 1){if($_POST['fee_submission_type'] == 'Research Inovation Fee'){echo 'selected';}} ?>>Research Inovation Fee</option>

								</select>
							</div>
							<div class="col-md-4">							
								<label>Date :</span></label><?php			 if($_SESSION['username']=='sadmin') {			?>
								<script  type="text/javascript" language="javascript">document.writeln(DateInput('fee_submission_date', 'fee_submission_date', true, 'YYYY-MM-DD', '<?php echo date("Y-m-d"); ?>', 2));</script>
							</div>
							<div class="col-md-4">							
								<label>Class <span class="orange">*</span> :</label>
								<select name="class" class="form-control"  required>  

									<option value="">-SELECT ANY ONE-</option>

									<?php 

										$sql_class = 'SELECT * FROM `class_detail` order by `class_description` asc';

										$result_class = execute_query(connect(), $sql_class );

										while($row_class = mysqli_fetch_array($result_class)){

											?>

									<option value="<?php echo $row_class['sno']; ?>" <?php if(isset($_GET['id'])){if($row['class']==$row_class['sno']){echo 'selected';}}elseif(isset($_POST['class']) AND $re == 1){if($_POST['class']==$row_class['sno']){echo 'selected';}} ?>><?php echo $row_class['class_description']; ?></option>

											<?php

										}

									?>

									<option value="phd_commerce" <?php if(isset($_GET['id'])){if($row['class']=="phd_commerce"){echo 'selected';}}elseif(isset($_POST['class']) AND $re == 1){if($_POST['class']=='phd_commerce'){echo 'selected';}} ?>>PHD COMMERCE</option>

									<option value="phd_education" <?php if(isset($_GET['id'])){if($row['class']=="phd_education"){echo 'selected';}}elseif(isset($_POST['class']) AND $re == 1){if($_POST['class']=='phd_education'){echo 'selected';}} ?>>PHD EDUCATION</option>

									<option value="phd_english" <?php if(isset($_GET['id'])){if($row['class']=="phd_english"){echo 'selected';}}elseif(isset($_POST['class']) AND $re == 1){if($_POST['class']=='phd_english'){echo 'selected';}} ?>>PHD ENGLISH</option>

									<option value="phd_zoology" <?php if(isset($_GET['id'])){if($row['class']=="phd_zoology"){echo 'selected';}}elseif(isset($_POST['class']) AND $re == 1){if($_POST['class']=='phd_zoology'){echo 'selected';}} ?>>PHD ZOOLOGY</option>

								</select>
							</div>
						</div>
						<div class="row">							
							<div class="col-md-4">							
								<label>Form Number <span class="orange">*</span> : </label>
								<input type="text" class="form-control"  name="form_no" autocomplete="off" value="<?php if(isset($_GET['id'])){ echo $row['form_no'];}elseif(isset($_POST['form_no']) AND $re == 1){ echo $_POST['form_no'];}  ?>" required>
							</div>
							<div class="col-md-4">							
								<label>Student Name <span class="orange">*</span> :</label>
								<input type="text" class="form-control"  class="listmenu" name="stu_name" autocomplete="off" value="<?php if(isset($_GET['id'])){ echo $row['stu_name'];}elseif(isset($_POST['stu_name']) AND $re == 1){ echo $_POST['stu_name'];}  ?>" required>
							</div>
							<div class="col-md-4">							
								<label>Father Name :</label>
								<input type="text" class="form-control"  name="father_name" autocomplete="off" value="<?php if(isset($_GET['id'])){ echo $row['father_name'];}elseif(isset($_POST['father_name']) AND $re == 1){ echo $_POST['father_name'];}  ?>">
							</div>
						</div>
						<div class="row">							
							<div class="col-md-4">							
								<label>Blood Group :</label>
								<input type="text" class="form-control"  name="blood_group" autocomplete="off" value="<?php if(isset($_GET['id'])){ echo $row['blood_group'];}elseif(isset($_POST['blood_group']) AND $re == 1){ echo $_POST['blood_group'];}  ?>">
							</div>
							<div class="col-md-4">							
								<label>Subject:</label>
								<input type="text" class="form-control"  name="sub1" autocomplete="off" value="<?php if(isset($_GET['id'])){ echo $row['sub1'];}elseif(isset($_POST['sub1']) AND $re == 1){ echo $_POST['sub1'];}  ?>">
							</div>
							<div class="col-md-4">							
								<label>E-Mail :</label>
								<input type="text" class="form-control"  name="email_id" autocomplete="off" value="<?php if(isset($_GET['id'])){ echo $row['e_mail1'];}elseif(isset($_POST['email_id']) AND $re == 1){ echo $_POST['email_id'];}  ?>">
							</div>
						</div>
						<div class="row">							
							<div class="col-md-4">							
								<label>Mobile :</label>
								<input type="text" class="form-control"  name="mobile" autocomplete="off" value="<?php if(isset($_GET['id'])){ echo $row['mobile'];}elseif(isset($_POST['mobile']) AND $re == 1){ echo $_POST['mobile'];}  ?>">
							</div>
							<div class="col-md-4">							
								<label>Gender :</label>
								<select name="gender" class="form-control" >
									<option value="">-SELECT ANY ONE-</option>

									<option value="Male" <?php if(isset($_GET['id'])){if($row['gender'] == 'Male'){echo 'selected';}}elseif(isset($_POST['gender']) AND $re == 1){if($_POST['gender'] == 'Male'){echo 'selected';}} ?>>Male</option>

									<option value="Female" <?php if(isset($_GET['id'])){if($row['gender'] == 'Female'){echo 'selected';}}elseif(isset($_POST['gender']) AND $re == 1){if($_POST['gender'] == 'Female'){echo 'selected';}} ?>>Female</option>

								</select>
							</div>
							<div class="col-md-4">							
								<label>Address :</label>
								<input type="text" class="form-control"  name="address" autocomplete="off" value="<?php if(isset($_GET['id'])){ echo $row['post'];}elseif(isset($_POST['address']) AND $re == 1){ echo $_POST['address'];}  ?>">
							</div>
						</div>
						<div class="row">							
							<div class="col-md-4">							
								<label>Aadhar No. :</label>
								<input type="text" class="form-control"  name="aadhar" autocomplete="off" value="<?php if(isset($_GET['id'])){ echo $row['aadhar'];}elseif(isset($_POST['aadhar']) AND $re == 1){ echo $_POST['aadhar'];}  ?>">
							</div>
							<div class="col-md-4">							
								<label>Date of Birth : </label>
								<script  type="text/javascript" language="javascript">document.writeln(DateInput('dob_date', 'dob_date', true, 'YYYY-MM-DD', '<?php echo date("Y-m-d"); ?>', 2));</script>
								
								<!--<input type="date" class="form-control"  name="dob_date" id="dob_date" value="<?php //if(isset($_GET['id'])){echo $row['dob'];}elseif(isset($_POST['dob_date']) AND $re == 1){ echo $_POST['dob_date'];} ?>"> -->
							</div>
							<div class="col-md-4">							
								<label>Amount <span class="orange">*</span> :</label>
								<input type="text" class="form-control"  name="amount" autocomplete="off" value="<?php if(isset($_GET['id'])){ echo $row['amount'];}elseif(isset($_POST['amount']) AND $re == 1){ echo $_POST['amount'];}  ?>" required>
							</div>
						</div>
						<div class="row">							
							<div class="col-md-4">							
								<label>Category <span class="orange">*</span> :</label>
								<select name="category" class="form-control"  required>

									<option value="">-SELECT ANY ONE-</option>

									<option value="GEN" <?php if(isset($_GET['id'])){if($row['category'] == 'GEN'){echo 'selected';}}elseif(isset($_POST['category']) AND $re == 1){if($_POST['category'] == 'GEN'){echo 'selected';}} ?>>GEN</option>

									<option value="OBC" <?php if(isset($_GET['id'])){if($row['category'] == 'OBC'){echo 'selected';}}elseif(isset($_POST['category']) AND $re == 1){if($_POST['category'] == 'OBC'){echo 'selected';}} ?>>OBC</option>

									<option value="SC" <?php if(isset($_GET['id'])){if($row['category'] == 'SC'){echo 'selected';}}elseif(isset($_POST['category']) AND $re == 1){if($_POST['category'] == 'SC'){echo 'selected';}} ?>>SC</option>

									<option value="ST" <?php if(isset($_GET['id'])){if($row['category'] == 'ST'){echo 'selected';}}elseif(isset($_POST['category']) AND $re == 1){if($_POST['category'] == 'ST'){echo 'selected';}} ?>>ST</option>

								</select>
							</div>
							<div class="col-md-4">							
								<label>Batch :</label>
								<input type="text" name="batch" class="form-control" autocomplete="off" value="<?php if(isset($_GET['id'])){ echo $row['batch'];}elseif(isset($_POST['batch']) AND $re == 1){ echo $_POST['batch'];}  ?>">
							</div>
							<div class="col-md-4">							
								<label></label>
								
							</div>
						</div>
						<input  type="submit" class="submit btn btn-primary" name="submit" value="Confirm and Print" title="Continue" />
						<input type="hidden" name="student_id" value="<?php if(isset($_GET['id'])){ echo $row['sno'];}  ?>" />
					</div> 
											
				 </form>
			</div>
		</div>   
	</div>
<?php  

 page_footer_start();
 page_footer_end();
						}
?>
</body>

