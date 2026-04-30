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