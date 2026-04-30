<?php
//set_time_limit(0);
//session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_start();
$response=1;
$msg='';
$i=0;

page_header_end();
page_sidebar();
?>
<?php
	if(isset($_POST['submit'])){
		if(isset($_POST['edit']) && $_POST['edit'] != ''){
			$sql = 'update administration set 
					title="'.$_POST['title'].'" ,
					name="'.$_POST['name'].'" , 
					department="'.$_POST['department'].'" , 
					date="'.$_POST['date'].'" ,  
					files="'.$filename.'" ,  
					description="'.$_POST['description'].'" , 
					remarks="'.$_POST['remarks'].'"
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
			$filename = $_FILES['attach_file']['name'];
			$targetDir = 'uploads/';
			$targetFile = $targetDir . basename($filename);

			// Move the uploaded file to the new directory
			if(move_uploaded_file($_FILES['attach_file']['tmp_name'], $targetFile)){
			$sql = 'insert into administration (title, name, department, date, files, description, remarks, created_by, created_date, edited_by, edited_date) 
					values("'.$_POST['title'].'","'.$_POST['name'].'","'.$_POST['department'].'","'.$_POST['date'].'","'.$filename.'","'.$_POST['description'].'","'.$_POST['remarks'].'","'.$_POST['created_by'].'","'.$_POST['created_date'].'","'.$_POST['edited_by'].'","'.$_POST['edited_date'].'")';
			//echo $sql;
			mysqli_query($db,$sql);
			if(mysqli_errno($db)){
				echo "Insertion failed".mysqli_errno($db).mysqli_error($db);
			}
			else{
				echo "Data inserted";
			}
		}
		else{
			echo "File upload failed";
		}
	}
	}

		
	if(isset($_GET['del'])){
		$sql = 'delete from administration where sno="'.$_GET['del'].'"';
		mysqli_query($db, $sql);
		if(mysqli_error($db)){
			$msg .= '<h3 style="color:red;">Error in deleting . '.mysqli_error($db).' >> '.$sql.'</h3>';
		}
		else{
			$msg .= '<h3 style="color:red;">Deleted</h3>';
		}
	}
	

	if(isset($_GET['edit'])){
	$sql = 'select * from administration where sno = '.$_GET['edit'];
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
				<form action="" class="wufoo leftLabel page1" name="" enctype="multipart/form-data" method="POST" onSubmit="" >
					<div class="bg-primary text-white p-2"><h3>Add Administration</h3></div>
						<div class="col-md-12" >
						
							<table width="100%" class="table table-striped  table-hover rounded">
								<tr >
									<th>Title</th>
									<th><input type="text" name="title" id="title" value="<?php echo isset($_GET['edit'])? $res['title']: '' ?>" class="form-control"></th>
									<th>Name</th>
									<th><input type="text" name="name" id="name" value="<?php echo isset($_GET['edit'])? $res['name']: '' ?>" class="form-control"></th>
									<th>Department</th>
									<th><select name="department" id="department" value="<?php echo isset($_GET['edit'])? $res['department']: '' ?>" class="form-control" required>
										<option disabled>---Select Your Department---</option>
										<option value="Mathematics" <?php echo (isset($_GET['edit']) && $res['department']=='Department of Mathematics') ?' selected="selected"':''  ?>>Department of Mathematics</option>
										<option value="English"<?php echo (isset($_GET['edit']) && $res['department']=='Department of English') ?' selected="selected"':''  ?>>Department of English</option>
										<option value="Physics"<?php echo (isset($_GET['edit']) && $res['department']=='Department of Physics') ?' selected="selected"':''  ?>>Department of Physics</option>
										<option value="Chemistry"<?php echo (isset($_GET['edit']) && $res['department']=='Department of Chemistry') ?' selected="selected"':''  ?>>Department of Chemistry</option>
										<option value="ComputerScience"<?php echo (isset($_GET['edit']) && $res['department']=='Department of Computer Science') ?' selected="selected"':''  ?>>Department of Computer Science</option>
										<option value="BusinessAdministration"<?php echo (isset($_GET['edit']) && $res['department']=='completed') ?' selected="selected"':''  ?>>Department of Business Administration</option>
										<option value="Sociology"<?php echo (isset($_GET['edit']) && $res['department']=='Department of Sociology') ?' selected="selected"':''  ?>>Department of Sociology</option>
										<option value="PoliticalScience"<?php echo (isset($_GET['edit']) && $res['department']=='Department of Political Science') ?' selected="selected"':''  ?>>Department of Political Science</option>
										<option value="CommunicationStudies"<?php echo (isset($_GET['edit']) && $res['department']=='CommunicationStudies') ?' selected="selected"':''  ?>>Department of Communication Studies</option>
										<option value="Engineering"<?php echo (isset($_GET['edit']) && $res['department']=='Engineering') ?' selected="selected"':''  ?>>Department of Engineering</option>
									</select></th>
								</tr>
								<tr >
									<th> Date</th>
									<th><script type="text/javascript" language="javascript">
											<?php
												$date = isset($_GET['edit'])? $res['date']: date('Y-m-d');
												echo "document.writeln(DateInput('date', 'date', true, 'YYYY-MM-DD','$date', 1));"
											?>
										</script></th>
									<th>Attach File</th>
									<th><input type ="file" id="attach_file" name="attach_file" class="form-control"></th>
									<th>Description</th>
									<th><textarea type="text" id="description" name="description" class="form-control"><?php echo isset($_GET['edit'])? $res['description']: '' ?></textarea></th>
								</tr>
								<tr>
									<th>Remarks</th>
									<th><textarea type="text" id="remarks" name="remarks" class="form-control"><?php echo isset($_GET['edit'])? $res['remarks']: '' ?></textarea></th>
								</tr>
							</table>
							<button type="submit" class="btn btn-primary " name="submit" value="">Submit </button>
							<input type="hidden" name="edit" value="<?php echo isset($_GET['edit'])? $res['sno']: '' ?>">	
								
						</div>
				</form>	
			</div>
		</div>
	</div>
		<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">  
			<div ><h3>Records</h3></div>
				<div class="col-md-12" >
					<table width="100%" class="table table-striped  table-hover rounded">
						<tr class="bg-primary text-white" >
							<th>Sno</th>
							<th>Title</th>
							<th>Name</th>
							<th>Department</th>
							<th>Date</th>
							<th>Attached File</th>
							<th>Description</th>
							<th>Remarks</th>
							<th>Edit </th>
							<th>Delete</th>
						</tr>
							<?php
								$sql = 'select * from administration';
								$result = mysqli_query($db, $sql);
								$i=1;
								while($row = mysqli_fetch_assoc($result)){
									echo '<tr>
									<td>'.$i++.'</td>
									<td>'.$row['title'].'</td>
									<td>'.$row['name'].'</td>
									<td>'.$row['department'].'</td>
									<td>'.$row['date'].'</td>
									<td>'.$row['files'].'</td>
									<td>'.$row['description'].'</td>
									<td>'.$row['remarks'].'</td>
									<td><a href="administration.php?edit='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color: #3066ec;"> Edit</h3></a></td>
									<td><a href="administration.php?del='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color:red;"></h3>Delete</a></td>
										</tr>'	;
								}
							?>
					</table>
				</div>
			</div>
		</div>
	</div>
<?php 
page_footer_start(); 
page_footer_end(); 

?>