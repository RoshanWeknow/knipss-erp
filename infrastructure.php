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
//print_r ($_POST);
	if(isset($_POST['submit'])){
		if(isset($_POST['edit']) && $_POST['edit'] != ''){
			$sql = 'update infrastructure set 
					building_name="'.$_POST['building_name'].'",
					year_of_establishment="'.$_POST['year_of_establishment'].'", 
					room_no="'.$_POST['room_no'].'", 
					department="'.$_POST['department'].'"
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
			$sql = 'insert into infrastructure (building_name, year_of_establishment, room_no, department) 
				values("'.$_POST['building_name'].'",
					"'.$_POST['year_of_establishment'].'",
					"'.$_POST['room_no'].'",
					"'.$_POST['department'].'")';
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
		$sql = 'delete from infrastructure where sno="'.$_GET['del'].'"';
		mysqli_query($db, $sql);
		if(mysqli_error($db)){
			$msg .= '<h3 style="color:red;">Error in deleting . '.mysqli_error($db).' >> '.$sql.'</h3>';
		}
		else{
			$msg .= '<h3 style="color:red;">Deleted</h3>';
		}
	}
	

	if(isset($_GET['edit'])){
	$sql = 'select * from infrastructure where sno = '.$_GET['edit'];
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
					<div class="bg-primary text-white p-2"><h3>Filters</h3></div>
						<div class="col-md-12" >
						
							<table width="100%" class="table table-striped  table-hover rounded">
								<tr >
									<th>Building Name</th>
									<th><input type="text" name="building_name" id="building_name" value="<?php echo isset($_GET['edit'])? $res['building_name']: '' ?>" class="form-control"></th>
									<th>Year of Establishment</th>
									<th><input type="text" name="year_of_establishment" id="year_of_establishment" value="<?php echo isset($_GET['edit'])? $res['year_of_establishment']: '' ?>" class="form-control"></th>
									<th>Room No</th>
									<th><input type ="text" id="room_no" name="room_no" value="<?php echo isset($_GET['edit'])? $res['room_no']: '' ?>" class="form-control"></th>
								</tr>
								
								<tr>
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
			<div><h3>Records</h3></div>
				<div class="col-md-12" >
					<table width="100%" class="table table-striped  table-hover rounded">
						<tr  class="bg-primary text-white">
							<th>Sno</th>
							<th>Building Name</th>
							<th>Year of Establishment</th>
							<th>Room No</th>
							<th>Department</th>
							<th>Edit </th>
							<th>Delete </th>
						</tr>
							<?php
								$sql = 'select * from infrastructure';
								$result = mysqli_query($db, $sql);
								$i=1;
								while($row = mysqli_fetch_assoc($result)){
									echo '<tr>
									<td>'.$i++.'</td>
									<td>'.$row['building_name'].'</td>
									<td>'.$row['year_of_establishment'].'</td>
									<td>'.$row['room_no'].'</td>
									<td>'.$row['department'].'</td>
									<td><a href="infrastructure.php?edit='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color: #3066ec;"> Edit</h3></a></td>
									<td><a href="infrastructure.php?del='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color:red;"></h3>Delete</a></td>
										</tr>'	;
								}
							?>
					</table>
				</div>
			</div>
		</div>
	</div>
</body>	
<?php 
page_footer_start(); 
page_footer_end(); 
?>
</html>