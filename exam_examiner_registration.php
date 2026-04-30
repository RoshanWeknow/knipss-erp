<?php

include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
$msg='';
page_header_start();
page_header_end();
page_sidebar();

if(isset($_GET['view'])){
		$_GET['editid'] = $_GET['view'];
}

$allowedExtensions = ['jpg', 'jpeg', 'png'];

if(isset($_POST['submit']) && $_POST['submit']!=''){
	
	if(isset($_POST['edit']) && $_POST['edit']!=''){
		$edidnewid=$_POST['edit'];
		$newerrors = [];
		if($_FILES['pic']['name']!=""){
			
			$newpicName=$_FILES["pic"]["name"];
			$newpicTmpName=$_FILES["pic"]["tmp_name"];
			$newpicSize=$_FILES["pic"]['size'];

			if ($newpicSize > 5 * 1024 * 1024) {
				$newerrors[] = "File is too large. Maximum file size allowed is 5MB.";
			}
		
			// Allowed file extensions
			
			$newpicExtension = strtolower(pathinfo($newpicName, PATHINFO_EXTENSION));
		
			// Check if the file extension is allowed
			if (!in_array($newpicExtension, $allowedExtensions)) {
				$newerrors[] = "Only JPG, JPEG, PNG files are allowed.";
			}
			
			if (empty($newerrors)) {
				$newpicnewname="examiner_info/examiner_pic/" . $edidnewid . "." . $newpicExtension;
					if(move_uploaded_file($newpicTmpName,$newpicnewname)){
						if(mysqli_query($db,"UPDATE exam_examiner_info SET pic='$newpicnewname' WHERE sno='" . $_POST['edit'] . "'")){
							$msg .= '<h6 class="alert alert-success">Update image in table successfully</h6>';			
						}else{
							$msg .= '<h6 class="alert alert-alert">Could not Update in image </h6>';			
						}

						$msg .='<h6 class="alert alert-success">Picture Upload  Successfully </h6>';   
					}else{
						$msg .= '<h6 class="alert alert-danger">could not replace the Picture</h6>';			
					}
				
			}
		}

		if($_FILES['sign']['name']!=""){
			$oldsignname=$_POST['oldsign'];
			$newsignName=$_FILES["sign"]["name"];
			$newsignTmpName=$_FILES["sign"]["tmp_name"];
			$newsignSize=$_FILES["sign"]['size'];

			if ($newsignSize > 5 * 1024 * 1024) {
				$newerrors[] = "File is too large. Maximum file size allowed is 5MB.";
			}
		
			// Allowed file extensions
			
			$newsignExtension = strtolower(pathinfo($newsignName, PATHINFO_EXTENSION));
		
			// Check if the file extension is allowed
			if (!in_array($newsignExtension, $allowedExtensions)) {
				$newerrors[] = "Only JPG, JPEG, PNG files are allowed.";
			}
			
			if (empty($newerrors)) {
				$newsignnewname="examiner_info/examiner_sign/" . $edidnewid . "." . $newsignExtension;
				if(move_uploaded_file($newsignTmpName,$newsignnewname)){
					if(mysqli_query($db,"UPDATE exam_examiner_info SET sign='$newsignnewname' WHERE sno='" . $_POST['edit'] . "'")){
						$msg .= '<h6 class="alert alert-success">Update image in table successfully</h6>';			
					}else{
						$msg .= '<h6 class="alert alert-alert">Could not Update in image </h6>';			
					}
					$msg .='<h6 class="alert alert-success">Sign Upload  Successfully </h6>';   
				}else{
					$msg .= '<h6 class="alert alert-danger">could not replace the sign</h6>';			
				}
			}
		}

		if (empty($newerrors)) {
			$update_sql = "UPDATE exam_examiner_info SET 
			digital_profile_sno='" . $_POST['digital_profile_name'] . "',
			desig='" . $_POST['desig'] . "',
			name='" . $_POST['name'] . "',
			pan_num='" . $_POST['pan_num'] . "',
			acc_num='" . $_POST['acc_num'] . "',
			bank_name='" . $_POST['bank_name'] . "',
			branch_name='" . $_POST['branch_name'] . "',
			ifsc_code='" . $_POST['ifsc_code'] . "',
			mob_num='" . $_POST['mob_num'] . "',
			curr_uni_name='" . $_POST['curr_uni_name'] . "',
			examiner_uni_name='" . $_POST['examiner_uni_name'] . "',
			examiner_type='" . $_POST['examiner_type'] . "',
			teach_sub='" . $_POST['teach_sub'] . "',
			edited_by='" . $_SESSION['username'] . "',
			edition_time='" . date("Y-m-d H:i:s") . "'
				WHERE sno='" . $_POST['edit'] . "'";
				//echo $update_sql;
					
			 $update_res = mysqli_query($db, $update_sql);

			if ($update_res) {
				echo '<h6 class="alert alert-success">Data Successfully Updated</h6>';
			} else {
				echo '<h6 class="alert alert-danger">Could Not Update</h6>';
			}
		}
	}else{
		$errors = [];
		$picfileName=$_FILES["pic"]["name"];
		$picfileTmpName=$_FILES["pic"]["tmp_name"];
		$picfileSize=$_FILES["pic"]['size'];
		$picnewFileName=$picfileName;

		$signfileName=$_FILES["sign"]["name"];
		$signfileTmpName=$_FILES["sign"]["tmp_name"];
		$signfileSize=$_FILES["sign"]['size'];
		$signnewFileName=$picfileName;
		
		if ($_FILES["pic"]["size"] > 2 * 1024 * 1024) {
			$errors[] = "Picture is too large. Maximum file size allowed is 2MB.";
			$msg.="<p class='alert alert-danger'>Picture is too large. Maximum file size allowed is 2MB.</p>";
		}

		if ($_FILES["sign"]["size"] > 2 * 1024 * 1024) {
			$errors[] = "Sign is too large. Maximum file size allowed is 2MB.";
			$msg.="<p class='alert alert-danger'>Sign is too large. Maximum file size allowed is 2MB.</p>";
		}
		// Allowed file extensions
		
		$picfileExtension = strtolower(pathinfo($picfileName, PATHINFO_EXTENSION));
		$signfileExtension = strtolower(pathinfo($signfileName, PATHINFO_EXTENSION));

		// Check if the file extension is allowed
		if (!in_array($picfileExtension, $allowedExtensions)) {
			$errors[] = "Only JPG, JPEG, PNG files are allowed.";
			$msg.="<h6 class='alert alert-danger'>Only JPG, JPEG, PNG Picture is allowed.</h6>";
		}
		if (!in_array($signfileExtension, $allowedExtensions)) {
			$errors[] = "Only JPG, JPEG, PNG files are allowed.";
			$msg.="<h6 class='alert alert-danger'>Only JPG, JPEG, PNG Signature is allowed.</h6>";
		}
		

		
		
		if (empty($errors)) {
			

			$sql="INSERT INTO exam_examiner_info(digital_profile_sno,desig, name, pan_num, acc_num, bank_name, branch_name, ifsc_code, mob_num, curr_uni_name, examiner_uni_name, examiner_type, teach_sub, created_by, creation_time) VALUES ('".$_POST['digital_profile_name']."','".$_POST['desig']."','".$_POST['name']."','".$_POST['pan_num']."','".$_POST['acc_num']."','".$_POST['bank_name']."','".$_POST['branch_name']."','".$_POST['ifsc_code']."','".$_POST['mob_num']."','".$_POST['curr_uni_name']."','".$_POST['examiner_uni_name']."','".$_POST['examiner_type']."','".$_POST['teach_sub']."','".$_SESSION['username']."','".date("Y-m-d H:i:s")."')";
			//echo $sql;	
			$res=mysqli_query($db,$sql);
			
			$getsno=mysqli_insert_id($db);
			
			$picuploadPath = "examiner_info/examiner_pic/" . $getsno . "." . $picfileExtension;
			$signuploadPath = "examiner_info/examiner_sign/" . $getsno . "." . $signfileExtension;
			
			
			if(mysqli_errno($db)){
				$msg .= '<h6 class="alert alert-danger">Insertion Failed.</h6>' ;
			}
			else{
				$msg .= '<h6 class="alert  alert-success">Data Inserted.</h6>' ;
				if(move_uploaded_file($picfileTmpName,$picuploadPath) && move_uploaded_file($signfileTmpName,$signuploadPath)){
				$updateres= mysqli_query($db,"UPDATE exam_examiner_info SET pic = '$picuploadPath' , sign='$signuploadPath' where sno='$getsno'");
				if($updateres){
					$msg .='<p class="alert alert-success">File Upload  Successfully </p>';   
				}
				
				}else{
				$msg.='<p class="alert alert-danger">Files Could not upload </p>';   
				}
			}
		}
    
	}
}
if(isset($_GET['editid'])){
	$edit_data_sql='SELECT * from exam_examiner_info Where sno = "'.$_GET['editid'].'"';
	$edit_res_sql=mysqli_query($db,$edit_data_sql);
	$edit_row_sql=mysqli_fetch_assoc($edit_res_sql);
}

?>

<body id="public">
	<div id="wrapper">	
		<div id="content" class="card card-body ">    
        	<div id="container" class="row d-flex my-auto">    	
				<form action="<?php echo $_SERVER['PHP_SELF']?>" class="wufoo leftLabel page1" enctype="multipart/form-data" method="POST"  >
				<div class="row">
						<div class="col-md-10">
						
						</div>
						<div class="col-md-2">
							<button class="btn btn-danger "  ><a class="text-white text-end" href="exam_examiner_detail.php" target="_blank">Examiner Profile Details</a></button>
						</div>
					</div>
					<h2><img style="width:40px;" src="images/add.png" />ADD New Examiner Profile<span class="orange"></span></h2>
					<?php echo $msg;?>
					<div class="row">
                        <div class="col-md-4">							
							<label>Examiner Designation</label>
							<select name="desig" id="desig" class="form-control" <?php echo isset($_GET['view'])? 'readonly': '' ?>>
								<?php 
								$sql  = 'SELECT * from dp_designation';
								$list_d = execute_query($db, $sql);
								if($list_d){
									while($list = mysqli_fetch_assoc($list_d)){
										echo '<option value="'.$list['designation'].'" '.(isset($_GET['editid']) && $edit_row_sql['desig'] == $list['designation'] ? 'selected':'').'>'.$list['designation'].'</option>';
									}
								}
								?>
							</select>
						</div>
						<div class="col-md-4">
							<label  class="name" for="name">Examiner Name</label>
							<input type="text" name="name" id="name"class="form-control" value="<?php echo isset($_GET['editid'])? $edit_row_sql['name']: '' ?>"  required <?php echo isset($_GET['view'])? 'readonly': '' ?>/>
						</div>
						<div class="col-md-4">
							<label  class="mob_num" for="mob_num"> Mobile Number</label>
							<input type="text" name="mob_num" id="mob_num"class="form-control" value="<?php echo isset($_GET['editid'])? $edit_row_sql['mob_num']: '' ?>" required <?php echo isset($_GET['view'])? 'readonly': '' ?>/>
						</div>
						<div class="col-md-4">
							<label  class="pan_num" for="pan_num">Pan Number</label>
							<input type="text" name="pan_num" id="pan_num"class="form-control" value="<?php echo isset($_GET['editid'])? $edit_row_sql['pan_num']: '' ?>" required  <?php echo isset($_GET['view'])? 'readonly': '' ?>/>
						</div>
						<div class="col-md-4">
							<label  class="bank_name" for="bank_name">Bank Name</label>
							<input type="text" name="bank_name" id="bank_name"class="form-control" value="<?php echo isset($_GET['editid'])? $edit_row_sql['bank_name']: '' ?>" required  <?php echo isset($_GET['view'])? 'readonly': '' ?>/>
						</div>
						 
                        <div class="col-md-4">
							<label  class="branch_name" for="branch_name">Branch Name</label>
							<input type="text" name="branch_name" id="branch_name"class="form-control" value="<?php echo isset($_GET['editid'])? $edit_row_sql['branch_name']: '' ?>" required <?php echo isset($_GET['view'])? 'readonly': '' ?>/>
						</div>
						
                        <div class="col-md-4">
							<label  class="acc_num" for="acc_num">Account Number</label>
							<input type="text" name="acc_num" id="acc_num"class="form-control" value="<?php echo isset($_GET['editid'])? $edit_row_sql['acc_num']: '' ?>" required <?php echo isset($_GET['view'])? 'readonly': '' ?>/>
						</div>
                       
                        <div class="col-md-4">
							<label  class="ifsc_code" for="ifsc_code"> IFSC Code</label>
							<input type="text" name="ifsc_code" id="ifsc_code"class="form-control" value="<?php echo isset($_GET['editid'])? $edit_row_sql['ifsc_code']: '' ?>" required  <?php echo isset($_GET['view'])? 'readonly': '' ?>/>
						</div>
						<div class="col-md-4">
							<label for="digital_profile_name">Digital Profile Name</label>
							<input type="text" id="digital_profile_name" class="form-control" placeholder="Type to search...">
						</div>



                        
					</div>
                    <div class="row" style="border:1.5px solid #f2f2f2;margin-block:2rem;"></div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="curr_uni_name">Current Working University Name</label>
                            <input type="text" name="curr_uni_name" id="curr_uni_name" value="<?php echo isset($_GET['editid'])? $edit_row_sql['curr_uni_name']: '' ?>" class="form-control" required <?php echo isset($_GET['view'])? 'readonly': '' ?>>
                        </div>
                        <div class="col-md-4">
                            <label for="examiner_uni_name">Examiner Working College Name</label>
                            <input type="text" class="form-control" id="examiner_uni_name" value="<?php echo isset($_GET['editid'])? $edit_row_sql['examiner_uni_name']: '' ?>" name="examiner_uni_name" required <?php echo isset($_GET['view'])? 'readonly': '' ?>>
                        </div>
                        <div class="col-md-4">
                            <label for="examiner_type">Examiner Type</label>
                            <select name="examiner_type" id="examiner_type" class="form-control " required <?php echo isset($_GET['view'])? 'readonly': '' ?>>
								<option selected disabled>---Select Dates---</option>
                                <option value="Under Graduate" <?php echo (isset($_GET['editid']) &&  $edit_row_sql['examiner_type'] == "Under Graduate" ? 'selected':'');?>>Under Graduate</option>
                                <option value="Post Graduate" <?php echo (isset($_GET['editid']) &&  $edit_row_sql['examiner_type'] == "Post Graduate" ? 'selected':'');?>>Post Graduate</option>
							</select>
                        </div>
                        
                        <div class="col-md-4">
                            <label for="teach_sub">Teaching Subject</label>
                            <input type="text" class="form-control" id="teach_sub" value="<?php echo isset($_GET['editid'])? $edit_row_sql['teach_sub']: '' ?>" name="teach_sub" required <?php echo isset($_GET['view'])? 'readonly': '' ?>>
                        </div>
                        <div class="col-md-4">
                            <label for="pic">Upload Photo</label>
                            <input type="file" class="form-control" id="pic" name="pic" <?php echo isset($_GET['editid'])?'':'required'; ?> <?php echo isset($_GET['view'])? 'readonly': '' ?>>
							<?php echo isset($_GET['editid'])? "<img src=".$edit_row_sql['pic']." style='width:100px;'>": '' ?>
							<input type="hidden" value="<?php echo isset($_GET['editid'])?$edit_row_sql['pic']:'';  ?>" name="oldpic">

                        </div>
                        <div class="col-md-4">
                            <label for="sign">Upload Signature</label>
                            <input type="file" class="form-control" id="sign" value="" name="sign" <?php echo isset($_GET['editid'])?'': 'required'; ?> <?php echo isset($_GET['view'])? 'readonly': '' ?>>
							<?php echo isset($_GET['editid'])? "<img src=".$edit_row_sql['sign']." style='width:100px;'>": '' ?>
							<input type="hidden" value="<?php echo isset($_GET['editid'])?$edit_row_sql['sign']:'';?>" name="oldsign">
                        </div>
						<div class="col-md-2">
							<div style="height:100%; display:flex;align-items:flex-end;justify-content:flex-start;">
								
								
							</div>
						</div>
                        <div class="col-md-10">
							<div style="height:100%; display:flex;align-items:flex-end;justify-content:flex-end;">
							<?php if(isset($_GET['view'])){
								echo '<button onclick="window.print()" class="btn btn-success">Print this page</button>';
							 }
							else{
								echo '<input type="submit" value="Submit" name="submit" class="btn btn-primary btn">';
							}
							?>	
							    <input type="hidden" value="<?php echo isset($_GET['editid'])? $_GET['editid']: '' ?>" name="edit">
							</div>
						</div>

                    </div>

				</form>
			</div>
			
		</div>
	</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<script>
    $(document).ready(function () {
        // Apply jQuery UI autocomplete to the input field
        $("#digital_profile_name").autocomplete({
            source: "fetch_profiles.php", // PHP script to fetch suggestions
            minLength: 2, // Minimum number of characters before search starts
            select: function (event, ui) {
                // When a suggestion is selected, fill the input with the value
                $("#digital_profile_name").val(ui.item.value); // Displayed value
                console.log("Selected ID: " + ui.item.id); // Useful for further processing
                return false; // Prevent default behavior
            }
        });
    });
</script>



	<?php
	page_footer_start();
	page_footer_end();
	?>
</body>