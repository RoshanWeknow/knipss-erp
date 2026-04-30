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



// if(isset($_POST['company_type']) && $_POST['company_type'] != ''){
	// $target_dir = "leave_images/".date('Y')."/".date('m')."/";
	// if(!is_dir($target_dir)){
		// mkdir($target_dir);
	// }
	// if(isset($_POST['edit']) && $_POST['edit']!= ''){
		// if(isset($_FILES['attach_file']) && $_FILES['attach_file']['name'] != ''){
			// $sql = 'update personal_memoranda set 
				// mou_date="' . $_POST['mou_date'] . '",
				// employee_id="' . $_POST['employee_id'] . '",
				// status="' . $_POST['company_address'] . '",
				// email="' . $_POST['email'] . '",
				// contact="' . $_POST['contact'] . '",
				// city="' . $_POST['city'] . '",
				// state="' . $_POST['state'] . '",
				// country="' . $_POST['country'] . '",
				// description="' . $_POST['description'] . '",
				// edited_by="' . $_SESSION['username'] . '",
				// edition_time="' . date("Y-m-d H:i:s") . '"
				// where sno=' . $_POST['edit'];
			// $file_details = upload_img($_FILES['attach_file'],$target_dir,$_POST['edit']);
			// $msg .= $file_details['msg'];
			// $sql = 'update personal_memoranda set attach_file="'. $file_details['file_name'].'" where sno = '.$_POST['edit'];
			// if(execute_query($db, $sql)){
				// echo "<li> image Updated successfully</li>";
			// }
			// else{
				// echo "<li> image updation failed</li>";
			// }
			
		// }
		// else{
			// $sql = 'update personal_memoranda set 
				// company_type="' . $_POST['company_type'] . '",
				// company_name="' . $_POST['company_name'] . '",
				// company_address="' . $_POST['company_address'] . '",
				// email="' . $_POST['email'] . '",
				// contact="' . $_POST['contact'] . '",
				// city="' . $_POST['city'] . '",
				// state="' . $_POST['state'] . '",
				// country="' . $_POST['country'] . '",
				// description="' . $_POST['description'] . '",
				// edited_by="' . $_SESSION['username'] . '",
				// edition_time="' . date("Y-m-d H:i:s") . '"
				// where sno=' . $_POST['edit'];
		// }
		// execute_query($db, $sql);
		// if(mysqli_errno($db)){
			// $msg .= '<li>Updation Failed</li>' ;
		// }
		// else{
			// $msg .= '<li>Data Updated</li>' ;
		// }
	// }
	// else{
		// $sql = 'insert into personal_memoranda(company_type,company_name,company_address,email,contact,city,state,country,description,created_by, creation_time) values("'.
		// $_POST['company_type'].'", "'.
		// $_POST['company_name'].'", "'.
		// $_POST['company_address'].'", "'.
		// $_POST['email'].'", "'.
		// $_POST['contact'].'", "'.
		// $_POST['city'].'", "'.
		// $_POST['state'].'", "'.
		// $_POST['country'].'", "'.
		// $_POST['description'].'", "'.
		// $_SESSION['username'].'", "'.
		// date("Y-m-d H:i:s").
		// '")';
		
		// execute_query($db, $sql);
		// if(mysqli_errno($db)){
			// $msg .= '<li>Insertion Failed</li>' ;
		// }
		// else{
			// $msg .= '<li>Data Inserted</li>' ;
		// }
		// $last_data_sno = mysqli_insert_id($db);
		// $file_details = upload_img($_FILES['attach_file'],$target_dir,$last_data_sno);
		// $msg .= $file_details['msg'];
		// $sql = 'update personal_memoranda set attach_file="'. $file_details['file_name'].'" where sno = '.$last_data_sno;
		// if(execute_query($db, $sql)){
			// echo "<li> image uploaded successfully</li>";
		// }
		// else{
			// echo "<li> image upload failed</li>";
		// }

	// }
// }

// if (isset($_GET['edit'])) {
	// $sql = 'select * from personal_memoranda where sno=' . $_GET['edit'];
	// $data = mysqli_fetch_assoc(execute_query($db,$sql));
// }

// if(isset($_GET['del']) and $_GET['del']!='') {
		// $sql = 'delete from personal_memoranda where sno=' . $_GET['del'];
		// $data = execute_query($db, $sql);
		// if(mysqli_errno($db)){
			// $msg .= '<h6 class="alert alert-danger">Deletion Failed.</h6>';
		// }
		// else{
			// $msg .= '<h6 class="alert alert-danger">Data deleted.</h6>';			
		// }
		// $_GET['del'] = '';
// }
 ?>



<?php
	if(isset($_POST['date'])){
		if(isset($_POST['edit']) && $_POST['edit'] != ''){
			$sql = 'update establishment set 
					date="'.$_POST['date'].'",
					building_name="'.$_POST['building_name'].'",
					department="'.$_POST['department'].'", 
					room_no="'.$_POST['room_no'].'", 
					issue="'.$_POST['issue'].'", 
					assigned_to="'.$_POST['assigned_to'].'", 
					priority="'.$_POST['priority'].'", 
					status="'.$_POST['status'].'", 
					description="'.$_POST['description'].'",
					created_by="'.$_POST['created_by'].'",
					created_time="'.$_POST['created_time'].'",
					edited_by="'.$_POST['edited_by'].'",
					edited_time="'.$_POST['edited_time'].'" 
					where sno = '.$_POST['edit'];
			//echo $sql;
			mysqli_query($db, $sql);
			if(mysqli_errno($db)){
				echo "Updation failed".mysqli_errno($db).mysqli_error($db);
			}
			else{
				echo "Successfully updated";
			}
		}
		else{
			$sql = 'insert into establishment (date, building_name, department, room_no, issue, assigned_to, priority, status, description, created_by, created_time, edited_by, edited_time) 
					values("'.$_POST['date'].'",
							"'.$_POST['building_name'].'",
							"'.$_POST['department'].'",
							"'.$_POST['room_no'].'",
							"'.$_POST['issue'].'",
							"'.$_POST['assigned_to'].'",
							"'.$_POST['priority'].'",
							"'.$_POST['status'].'",
							"'.$_POST['description'].'",
							"'.$_POST['created_by'].'",
							"'.$_POST['created_time'].'",
							"'.$_POST['edited_by'].'",
							"'.$_POST['edited_time'].'")';
			//echo $sql;
			mysqli_query($db,$sql);
			if(mysqli_errno($db)){
				echo "Insertion failed".mysqli_errno($db).mysqli_error($db);
			}
			else{
				echo "Data inserted";
			}
		}
	}
	
		
	if(isset($_GET['del'])){
		$sql = 'delete from establishment where sno="'.$_GET['del'].'"';
		mysqli_query($db, $sql);
		if(mysqli_error($db)){
			$msg .= '<h3 style="color:red;">Error in deleting . '.mysqli_error($db).' >> '.$sql.'</h3>';
		}
		else{
			$msg .= '<h3 style="color:red;">Deleted</h3>';
		}
	}
	

	if(isset($_GET['edit'])){
	$sql = 'select * from establishment where sno = '.$_GET['edit'];
	$qry = mysqli_query($db, $sql);
	$res = mysqli_fetch_assoc($qry);
}
?>





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


<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">  
				<form action="" class="wufoo leftLabel page1" value="<?php echo isset($_GET['edit'])?$data['leave_days']:""?>" enctype="multipart/form-data" method="POST" onSubmit="" >
					<div class="bg-primary text-white p-2"><h3>Establishment</h3></div>
						<div class="col-md-12" >
						
							<table width="100%" class="table table-striped  table-hover rounded">
								<tr >
									<th>Date</th>
									<th><script type="text/javascript" language="javascript">
											<?php
												$date = isset($_GET['edit'])? $res['date']: date('Y-m-d');
												echo "document.writeln(DateInput('date', 'date', true, 'YYYY-MM-DD','$date', 1));"
											?>
										</script></th>
									<th>Building Name</th>
									<th><input type="text" name="building_name" id="building_name" value="<?php echo isset($_GET['edit'])? $res['building_name']: '' ?>" class="form-control"></th>
									
									<th>Department</th>
									<th><select name="department" id="department" value="" class="form-control" required>
										<option disabled selected>---Select Your Department---</option>
										<option value="Mathematics" <?php echo (isset($_GET['edit']) && $res['department']=='Mathematics') ?' selected="selected"':''  ?>>Department of Mathematics</option>
										<option value="English" <?php echo (isset($_GET['edit']) && $res['department']=='English') ?' selected="selected"':''  ?> >Department of English</option>
										<option value="Physics" <?php echo (isset($_GET['edit']) && $res['department']=='Physics') ?' selected="selected"':''  ?>>Department of Physics</option>
										<option value="Chemistry" <?php echo (isset($_GET['edit']) && $res['department']=='Chemistry') ?' selected="selected"':''  ?>>Department of Chemistry</option>
										<option value="ComputerScience" <?php echo (isset($_GET['edit']) && $res['department']=='ComputerScience') ?' selected="selected"':''  ?>>Department of Computer Science</option>
										<option value="BusinessAdministration" <?php echo (isset($_GET['edit']) && $res['department']=='BusinessAdministration') ?' selected="selected"':''  ?>>Department of Business Administration</option>
										<option value="Sociology" <?php echo (isset($_GET['edit']) && $res['department']=='Sociology') ?' selected="selected"':''  ?>>Department of Sociology</option>
										<option value="PoliticalScience" <?php echo (isset($_GET['edit']) && $res['department']=='PoliticalScience') ?' selected="selected"':''  ?>>Department of Political Science</option>
										<option value="CommunicationStudies" <?php echo (isset($_GET['edit']) && $res['department']=='CommunicationStudies') ?' selected="selected"':''  ?>>Department of Communication Studies</option>
										<option value="Engineering" <?php echo (isset($_GET['edit']) && $res['department']=='Engineering') ?' selected="selected"':''  ?>>Department of Engineering</option>
									</select></th>
									
									
								</tr>
								<tr >
									<th>Room No</th>
									<th><input type="text" name="room_no" id="room_no" value="<?php echo isset($_GET['edit'])? $res['room_no']: '' ?>" class="form-control"></th>
									
									<th>Issue</th>
									<th><textarea type="text" id="issue" name="issue"  class="form-control"><?php echo isset($_GET['edit'])? $res['issue']: '' ?></textarea></th>
									
									<th>Assigned To</th>
									<th><input type="text" name="assigned_to" id="assigned_to" value="<?php echo isset($_GET['edit'])? $res['assigned_to']: '' ?>" class="form-control"></th>
								</tr>
								<tr>
									<th>Priority</th>
									<th><select name="priority"  id="priority" value="<?php echo isset($_GET['edit'])? $res['priority']: '' ?>"class="form-control" required>
										  <option value="High" <?php echo (isset($_GET['edit']) && $res['priority']=='High') ?' selected="selected"':''  ?>>High</option>
										  <option value="Medium" <?php echo (isset($_GET['edit']) && $res['priority']=='Medium') ?' selected="selected"':''  ?>>Medium</option>
										  <option value="Low" <?php echo (isset($_GET['edit']) && $res['priority']=='Low') ?' selected="selected"':''  ?>>Low</option>
										</select></th>
									<th>Status</th>
									<th><select name="status" id="status" value="<?php echo isset($_GET['edit'])? $res['status']: '' ?>" class="form-control" required>
										  <option value="completed" <?php echo (isset($_GET['edit']) && $res['status']=='completed') ?' selected="selected"':''  ?>>Completed</option>
										  <option value="pending" <?php echo (isset($_GET['edit']) && $res['status']=='pending') ?' selected="selected"':''  ?>>Pending</option>
										</select></th>
									<th>Description</th>
									<th><textarea type="text" id="description" name="description" class="form-control"  ><?php echo isset($_GET['edit'])? $res['description']: '' ?></textarea></th>
									
								</tr>
								<!--<tr>
									<th>Remarks</th>
									<th><textarea type="text" id="description" name="description" class="form-control"> </textarea></th>
								</tr>--->
							</table>
							<button type="submit" class="btn btn-primary " name="save" value="">Submit </button>
							<input type="hidden" name="edit" value="<?php echo isset($_GET['edit'])? $res['sno']: '' ?>">
								
						</div>
				</form>	
			</div>
		</div>
	</div>


	<div class="card">
			<h3 class="ps-2">Reports</h3>
			<table width="100%" class="table table-striped table-hover rounded">
				<tr class="text-white bg-primary">
					<th>Sno.</th>
					<th>Date</th>
					<th>Building Name</th>
					<th>Department</th>
					<th>Room No.</th>
					<th>Issue</th>
					<th>Assigned to</th>
					<th>Priority</th>
					<th>Status:</th>
					<th>Description</th>
					<th>Edit</th>					
					<th>Delete</th>
				</tr>
				<?php
					$sql = 'select * from establishment';
					$result = mysqli_query($db, $sql);
					$i=1;
					while($row = mysqli_fetch_assoc($result)){
						echo '<tr>
						<td>'.$i++.'</td>
						<td>'.$row['date'].'</td>
						<td>'.$row['building_name'].'</td>
						<td>'.$row['department'].'</td>
						<td>'.$row['room_no'].'</td>
						<td>'.$row['issue'].'</td>
						<td>'.$row['assigned_to'].'</td>
						<td>'.$row['priority'].'</td>
						<td>'.$row['status'].'</td>
						<td>'.$row['description'].'</td>
						<td><a href="establishment.php?edit='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color: #3066ec;"> Edit</h3></a></td>
						
						<td><a href="establishment.php?del='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color:red;"></h3>Delete</a></td>
							</tr>'	;
					}
								?>
			</table>
		</div>
    </div>


<?php 
page_footer_start(); 
page_footer_end(); 

?>