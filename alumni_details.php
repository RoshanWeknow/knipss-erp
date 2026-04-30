<?php 
include("scripts/settings.php");
include("scripts/image_upload.php");

page_header_start();
$response=1;
$msg='';


page_header_end();
page_sidebar();
?>
<?php 



if(isset($_POST['full_name']) && $_POST['full_name'] != ''){
	//print_r($_POST);
	$target_dir = "alumni_images/".date('Y')."/".date('m')."/";
	if(!is_dir($target_dir)){
		mkdir($target_dir);
	}
	if(isset($_POST['edit']) && $_POST['edit']!= ''){
		if(isset($_FILES['attach_file']) && $_FILES['attach_file']['name'] != ''){
			$sql = 'update alumni_details set 
				full_name="' . $_POST['full_name'] . '",
				father_name="' . $_POST['father_name'] . '",
				mother_name="' . $_POST['mother_name'] . '",
				dob="' . $_POST['dob'] . '",
				contact_no="' . $_POST['contact_no'] . '",
				email="' . $_POST['email'] . '",
				present_address="' . $_POST['present_address'] . '",
				p_address="' . $_POST['p_address'] . '",
				course_completed="' . $_POST['course_completed'] . '",
				subject="' . $_POST['subject'] . '",
				year_of_admission="' . $_POST['year_of_admission'] . '",
				year_of_completed="' . $_POST['year_of_completed'] . '",
				leaving="' . $_POST['leaving'] . '",
				job_profile="' . $_POST['job_profile'] . '",
				company_name="' . $_POST['company_name'] . '",
				c_own_institute="' . $_POST['c_own_institute'] . '",
				description="' . $_POST['description'] . '",
				edited_by="' . $_SESSION['username'] . '",
				edition_time="' . date("Y-m-d H:i:s") . '"
				where sno=' . $_POST['edit'];
			execute_query($db, $sql);
			if(mysqli_errno($db)){
				$msg .= '<li>Updation Failed</li>' ;
			}
			
			$file_details = upload_img($_FILES['attach_file'],$target_dir,$_POST['edit']);
			$msg .= $file_details['msg'];
			$sql = 'update alumni_details set attach_file="'. $file_details['file_name'].'" where sno = '.$_POST['edit'];
			if(execute_query($db, $sql)){
				$msg.= "<li> image Updated successfully</li>";
			}
			else{
				$msg.= "<li> image updation failed</li>";
			}
			
		}
		else{
			$sql = 'update alumni_details set 
				full_name="' . $_POST['full_name'] . '",
				father_name="' . $_POST['father_name'] . '",
				mother_name="' . $_POST['mother_name'] . '",
				dob="' . $_POST['dob'] . '",
				contact_no="' . $_POST['contact_no'] . '",
				email="' . $_POST['email'] . '",
				present_address="' . $_POST['present_address'] . '",
				p_address="' . $_POST['p_address'] . '",
				course_completed="' . $_POST['course_completed'] . '",
				subject="' . $_POST['subject'] . '",
				year_of_admission="' . $_POST['year_of_admission'] . '",
				year_of_completed="' . $_POST['year_of_completed'] . '",
				leaving="' . $_POST['leaving'] . '",
				job_profile="' . $_POST['job_profile'] . '",
				company_name="' . $_POST['company_name'] . '",
				c_own_institute="' . $_POST['c_own_institute'] . '",
				description="' . $_POST['description'] . '",
				edited_by="' . $_SESSION['username'] . '",
				edition_time="' . date("Y-m-d H:i:s") . '"
				where sno=' . $_POST['edit'];
			execute_query($db, $sql);
			if(mysqli_errno($db)){
				$msg .= '<li>Updation Failed</li>' ;
			}
			else{
				$msg .= '<li>Data Updated</li>' ;
			}
		}
		
	}
	else{
		$sql = 'insert into alumni_details (full_name,father_name,mother_name,dob,contact_no,email,present_address,p_address,course_completed,subject,year_of_admission,year_of_completed,leaving,job_profile,company_name,c_own_institute,description,created_by, creation_time) values("'.
		$_POST['full_name'].'", "'.
		$_POST['father_name'].'", "'.
		$_POST['mother_name'].'", "'.
		$_POST['dob'].'", "'.
		$_POST['contact_no'].'", "'.
		$_POST['email'].'", "'.
		$_POST['present_address'].'", "'.
		$_POST['p_address'].'", "'.
		$_POST['course_completed'].'", "'.
		$_POST['subject'].'", "'.
		$_POST['year_of_admission'].'", "'.
		$_POST['year_of_completed'].'", "'.
		$_POST['leaving'].'", "'.
		$_POST['job_profile'].'", "'.
		$_POST['company_name'].'", "'.
		$_POST['c_own_institute'].'", "'.
		$_POST['description'].'", "'.
		$_SESSION['username'].'", "'.
		date("Y-m-d H:i:s").
		'")';
		echo $sql;
		execute_query($db, $sql);
		if(mysqli_errno($db)){
			$msg .= '<li>Insertion Failed</li>' ;
		}
		
		$last_data_sno = mysqli_insert_id($db);
		$file_details = upload_img($_FILES['attach_file'],$target_dir,$last_data_sno);
		$msg .= $file_details['msg'];
		$sql = 'update alumni_details set attach_file="'. $file_details['file_name'].'" where sno = '.$last_data_sno;
		if(execute_query($db, $sql)){
			$msg.= "<li> image uploaded successfully</li>";
		}
		else{
			$msg.= "<li> image upload failed</li>";
		}

	}
}

if (isset($_GET['edit'])) {
	$sql = 'select * from alumni_details where sno=' . $_GET['edit'];
	$data = mysqli_fetch_assoc(execute_query($db,$sql));
}

if(isset($_GET['del']) and $_GET['del']!='') {
		$sql = 'delete from alumni_details where sno=' . $_GET['del'];
		$data = execute_query($db, $sql);
		if(mysqli_errno($db)){
			$msg .= '<h6 class="alert alert-danger">Deletion Failed.</h6>';
		}
		else{
			$msg .= '<h6 class="alert alert-danger">Data deleted.</h6>';			
		}
		$_GET['del'] = '';
}


?>

<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">  
				<form action="" class="wufoo leftLabel page1" name="" enctype="multipart/form-data" method="POST" onSubmit="" >
					<div class="bg-primary text-white p-2"><h3>Add Alumni</h3></div>
						<div class="col-md-12" >
						
							<table width="100%" class="table table-striped  table-hover rounded">
								<tr >
									
									<th>Full Name</th>
									<th><input type="text" name="full_name" id="full_name" value="<?php echo isset($_GET['edit'])?$data['full_name']:""?>" class="form-control"></th>
									<th>Father's Name</th>
									<th><input type="text" name="father_name" id="father_name" value="<?php echo isset($_GET['edit'])?$data['father_name']:""?>" class="form-control"></th>
									<th>Mother's Name</th>
									<th><input type="text" name="mother_name" id="mother_name" value="<?php echo isset($_GET['edit'])?$data['mother_name']:""?>" class="form-control"></th>
								</tr>
								<tr >
									<th>Date Of Birth</th>
									<th><script  type="text/javascript" language="javascript">
									document.writeln(DateInput('dob', 'dob', true, 'YYYY-MM-DD', '<?php if(isset($_POST['dob'])){echo $_POST['dob'];}else{echo date("Y-m-d"); } ?>', 2));
									</script></th>
									<th>Contact Number</th>
									<th><input type="text" name="contact_no" id="contact_no" value="<?php echo isset($_GET['edit'])?$data['contact_no']:""?>" class="form-control"></th>
									<th>Email</th>
									<th><input type="email" name="email" id="email" value="<?php echo isset($_GET['edit'])?$data['email']:""?>" class="form-control"></th>
								</tr>
								<tr >
									<th>Present Address</th>
									<th><textarea type="text" id="present_address" name="present_address" class="form-control"><?php echo isset($_GET['edit'])?$data['present_address']:""?> </textarea></th>
									<th>Permanent Address</th>
									<th><textarea type="text" id="p_address" name="p_address" class="form-control"><?php echo isset($_GET['edit'])?$data['p_address']:""?></textarea></th>
									<th>Course Completed</th>
									<th><select name="course_completed" id="course_completed" value="<?php echo isset($_GET['edit'])?$data['course_completed']:""?>" class="form-control" required>
										<option disabled <?php isset($_GET['edit'])?"": 'selected="selected"' ?>>---Select Your Department---</option>
										<?php 
											$sql  = 'select * from staff_department';
											$dept_list = execute_query($db, $sql);
											if($dept_list){
												while($list = mysqli_fetch_assoc($dept_list)){
													echo '<option value = "'.$list['sno'].'" '.(isset($_GET['edit']) and $data['department'] == $list['sno'] ? ' selected = "selected" ':"").'>'.$list['department'].'</option>';
												}
											}
										?>
									</select></th>
								</tr>
								<tr >
									<th>Subject</th>
									<th><input type="text" name="subject" id="subject" value="<?php echo isset($_GET['edit'])?$data['subject']:""?>" class="form-control"></th>
									<th>Year of Admission in Course</th>
									<th><input type="text" name="year_of_admission" id="year_of_admission" value="<?php echo isset($_GET['edit'])?$data['year_of_admission']:""?>" class="form-control"></th>
									<th>Year of Course Completion</th>
									<th><input type="text" name="year_of_completed" id="year_of_completed" value="<?php echo isset($_GET['edit'])?$data['year_of_completed']:""?>" class="form-control"></th>
								</tr>
								<tr >
									<th>Reason for Leaving </th>
									<th><select name="leaving" id="leaving" value="<?php echo isset($_GET['edit'])?$data['leaving']:""?>" class="form-control" required>
										<option disabled <?php isset($_GET['edit'])?"": 'selected="selected"' ?>>---Select Your Department---</option>
										<option value="Higher Studies" <?php (isset($_GET['edit']) && $data['leaving']=="Higher Studies")?' selected = "selected"':"" ?>>Higher Studies</option>
										<option value="Placement" <?php (isset($_GET['edit']) && $data['leaving']=="Placement")?' selected = "selected"':"" ?>>Placement</option>
									
									</select></th>
									<th>Job profile</th>
									<th><input type="text" name="job_profile" id="job_profile" value="<?php echo isset($_GET['edit'])?$data['job_profile']:""?>" class="form-control"></th>
									<th>Company Name</th>
									<th><input type="text" name="company_name" id="company_name" value="<?php echo isset($_GET['edit'])?$data['company_name']:""?>" class="form-control"></th>
									
								</tr>
								<tr >
									<th >How you Want to Contribute to Your Own Institute</th>
									<th ><textarea type="text" id="c_own_institute" name="c_own_institute" class="form-control"><?php echo isset($_GET['edit'])?$data['c_own_institute']:""?> </textarea></th>
									<th>Attach File</th>
									<th><input type ="file" id="attach_file" value="<?php echo isset($_GET['edit'])?$data['attach_file']:""?>" name="attach_file" class="form-control"></th>
									
									<th>Description</th>
									<th><textarea type="text" id="description" value="" name="description" class="form-control"><?php echo isset($_GET['edit'])?$data['description']:""?> </textarea></th>
								</tr>
							</table>
							<button type="submit" class="btn btn-primary " name="save" value="">Submit </button>
							<input type = "hidden" name = "edit" value="<?php echo isset($_GET['edit'])? $_GET['edit']: ""?>">		
								
						</div>
				</form>	
			</div>
		</div>
		<div class="card card-body">
			<table  class="table table-striped table-hover rounded">
				<tr class="bg-primary text-white ">
					<td>S.No.</td>
					<td>Full Name</td>
					<td>Bate Of Birth</td>
					<td>Course</td>
					<td>Passing Year</td>
					<td>Reason For Leaving</td>
					<td>Attach File</td>
					<td>Description</td>
					<td>Edit</td>
					<td>Delete</td>
					
				</tr>
				<?php
					$serial_no = 1;
					$sql = 'select * from alumni_details';
					$res = execute_query($db, $sql);
					if($res){
						while($row = mysqli_fetch_assoc($res)){

				?>
				<tr>
					<td><?php echo $serial_no++ ?></td>
					<td><?php echo $row['full_name'] ?></td>
					<td><?php echo $row['dob'] ?></td>
					<td><?php echo $row['course_completed'] ?></td>
					<td><?php echo $row['year_of_completed'] ?></td>
					<td><?php echo $row['leaving'] ?></td>
					<td><a href= "<?php echo "alumni_images/".date('Y')."/".date('m')."/".$row['attach_file'] ?>" target = "_blank"><?php echo $row['attach_file'] ?></a></td>
					<td><?php echo $row['description'] ?></td>
					<td class="text-center ">
						<a href="<?php echo $_SERVER['PHP_SELF'] . '?edit=' . $row['sno']; ?>" alt="Edit" data-toggle="tooltip" title="Edit"><span class="far fa-edit" aria-hidden="true"></span></a></td>
					<td>
						<a href="<?php echo $_SERVER['PHP_SELF'] . '?del=' . $row['sno']; ?>" onclick="return confirm('Are you sure?');" style="color:#f00" alt="Delete"><span class="far fa-trash-alt" aria-hidden="true" data-toggle="tooltip" title="Delete"></span></a>
					</td>

				</tr>
				
				<?php 
					}
						
				}
				
				?>
			</table>	
		</div>
	</div>


<?php 
page_footer_start(); 
page_footer_end(); 

?>