<?php 
include("scripts/settings.php");

$msg = '';

if(isset($_POST['enrollment_no']) && $_POST['enrollment_no'] != ''){
	//print_r($_POST);
	if(isset($_POST['edit']) && $_POST['edit']!= ''){
		$sql = 'update ct_character_certificate set 
			enrollment_no="' . $_POST['enrollment_no'] . '",
			name="' . $_POST['name'] . '",
			father_name="' . $_POST['father_name'] . '",
			residency="' . $_POST['residency'] . '",
			institution_name="' . $_POST['institution_name'] . '",
			duration="' . $_POST['duration'] . '",
			issue_date="' . $_POST['issue_date'] . '",
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
	else{
		$sql = 'insert into ct_character_certificate(enrollment_no,name,father_name,residency,institution_name,duration,issue_date,description,created_by,creation_time) values(
		"'.$_POST['enrollment_no'].'","'.
		$_POST['name'].'","'.
		$_POST['father_name'].'","'.
		$_POST['residency'].'","'.
		$_POST['institution_name'].'","'.
		$_POST['duration'].'","'.
		$_POST['issue_date'].'","'.
		$_POST['description'].'","'.
		$_SESSION['username'].'","'.
		date('Y-m-d H:m:s').'")';
		execute_query($db, $sql);
		if(mysqli_errno($db)){
			$msg .= '<p class="text text-danger">Error # 1.6 : '.mysqli_error($db).'>> '.$sql.'</p>';
		}
		else{
			$msg.= '<li class="text-success"> Data Inserted </li>';
		}
	}
}

if (isset($_GET['edit'])) {
	$sql = 'select * from ct_character_certificate where sno=' . $_GET['edit'];
	$data = mysqli_fetch_assoc(execute_query($db,$sql));
}

if(isset($_GET['del']) and $_GET['del']!='') {
		$sql = 'delete from ct_character_certificate where sno=' . $_GET['del'];
		$data = execute_query($db, $sql);
		if(mysqli_errno($db)){
			$msg .= '<h6 class="alert alert-danger">Deletion Failed.</h6>';
		}
		else{
			$msg .= '<h6 class="alert alert-danger">Data deleted.</h6>';			
		}
		$_GET['del'] = '';
}




page_header_start();
page_header_end();
page_sidebar();
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
				<form action="<?php echo $_SERVER['PHP_SELF'] ?>" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" autocomplete="off" >
					<h3> Character Certificate</h3>
						<div class="col-md-12" >
							<!-- first row -->
							<div class="row">							
								<div class=" col-md-3 ">							
									<label>Enrollment Number</label>
									<input type="text" name="enrollment_no" id="enrollment_no" value="<?php  echo isset($_GET['edit'])?  $data['enrollment_no']: ""?>" class="form-control" required="required">
								</div>
								<div class="  col-md-3 ">							
									<label>Name</label><br>
									<input type="text" name="name" id="name" value="<?php  echo isset($_GET['edit'])?  $data['name']: ""?>" class="form-control" required="required" >
								</div>
								<div class="  col-md-3 ">							
									<label>Father Name</label>
									<input type="text" name="father_name" id="father_name" value="<?php  echo isset($_GET['edit'])?  $data['father_name']: ""?>" class="form-control" required="required">
								</div>
								<div class="  col-md-3 ">							
									<label>Residence </label>
									<input type="text" name="residency" id="residency" value="<?php  echo isset($_GET['edit'])?  $data['residency']: ""?>" class="form-control" required="required">
								</div>
								
							</div>
							<!-- second row -->

							<div class="row">
								<div class="  col-md-3 ">							
									<label>Institution Name</label>
									<input type="text" name="institution_name" id="institution_name" value="<?php  echo isset($_GET['edit'])?  $data['institution_name']: ""?>" class="form-control" required="required">
								</div>
								<div class="  col-md-3 ">							
									<label>Duration of Kowing the Candidate(in years)</label>
									<input type="text" name="duration" id="duration" value="<?php  echo isset($_GET['edit'])?  $data['duration']: ""?>" class="form-control" required="required">
								</div>
								<div class="col-md-3 ">
									<div class="form-group">
										<label>Issue Date</label>
										<script type="text/javascript" language="javascript">
											<?php
												$date = isset($_GET['edit'])? $data['issue_date']: date('Y-m-d');
												echo "document.writeln(DateInput('issue_date', 'user_form', true, 'YYYY-MM-DD','$date', 1));"
											?>
										</script>
									</div>
								</div>
								<div class="  col-md-3 ">
									<label>Description</label>
									<textarea id="description" name="description" rows="4" cols="50" placeholder="" class="form-control"><?php  echo isset($_GET['edit'])?  $data['description']: ""?></textarea>
								</div>
								 
							</div>
							
							</br>
							<button type="submit" class="btn btn-primary ms-4" name="save" value="">Submit </button>
							<input type = "hidden" name = "edit" value="<?php echo isset($_GET['edit'])? $_GET['edit']: ""?>">	
						</div>
				</form>	
			</div>
		</div>
	</div>



		<div class="card card-body">
			<table  class="table table-striped table-hover rounded">
				<tr class="bg-primary text-white">
					<td>S.No.</td>
					<td>Enrollment No.</td>
					<td> Name</td>
					<td>Father Name</td>
					<td>Residency</td>
					<td>Institution Name</td>
					<td>Duration</td>
					<td>Issue Date</td>
					<td>Description</td>
					<td>Edit|Delete</td>
					
				</tr>
				<?php
					$serial_no = 1;
					//echo $_SESSION['usersno'];
					$sql = 'select * from ct_character_certificate';
					
					$res = execute_query($db, $sql);
					if($res){
						while($row = mysqli_fetch_assoc($res)){

				?>
				<tr>
					<td><?php echo $serial_no++ ?></td>
					<td><?php echo $row['enrollment_no'] ?></td>
					<td><?php echo $row['name'] ?></td>
					<td><?php echo $row['father_name'] ?></td>
					<td><?php echo $row['residency'] ?></td>
					<td><?php echo $row['institution_name'] ?></td>
					<td><?php echo $row['duration'] ?></td>
					<td><?php echo $row['issue_date'] ?></td>
					<td><?php echo $row['description'] ?></td>
					<td class="text-center ">
						<a href="<?php echo $_SERVER['PHP_SELF'] . '?edit=' . $row['sno']; ?>" alt="Edit" data-toggle="tooltip" title="Edit"><span class="far fa-edit" aria-hidden="true"></span></a>&nbsp;&nbsp;&nbsp;
						<a href="<?php echo $_SERVER['PHP_SELF'] . '?del=' . $row['sno']; ?>" onclick="return confirm('Are you sure?');" style="color:#f00" alt="Delete"><span class="far fa-trash-alt" aria-hidden="true" data-toggle="tooltip" title="Delete"></span></a>
					</td>

				</tr>
				
				<?php 
					}
						
				}
				
				?>
			</table>	
		</div>
		


















<?php
page_footer_start();
?>


<!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
<script src="js/light-bootstrap-dashboard.js?v=1.4.0"></script>

<?php
page_footer_end();
?>