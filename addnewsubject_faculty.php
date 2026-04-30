<?php
//session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_start();
$response=1;
$msg='';
if(isset($_POST['submit'])) {
	if($_POST['faculty']==''){
		$msg .= '<li>Please enter full information</li>';
	}
	if($_POST['edit_sno']=='') {
		$sql='insert into add_subject_faculty (faculty) values("'.$_POST['faculty'].'")';
		execute_query(connect(), $sql);
		$msg .= '<li>New Faculty Added</li>'; 
		$_POST['faculty'] = '';
		$_POST['edit_sno'] = '';
	}
	else{
		$sql = 'update add_subject_faculty set faculty="'.$_POST['faculty'].'" where sno="'.$_POST['edit_sno'].'"';
		execute_query(connect(), $sql);
		$msg .= '<li>Faculty Update</li>'; 
		$_POST['faculty'] = '';
		$_POST['edit_sno'] = '';
	}
}
else{
	$_POST['faculty'] = '';
	$_POST['edit_sno'] = '';
}

if(isset($_GET['ed'])){
	$sql = 'select * from add_subject_faculty where sno="'.$_GET['ed'].'"';
	$data = mysqli_fetch_assoc(execute_query(dbconnect(), $sql));
	$_POST['faculty'] = $data['faculty'];
	$_POST['edit_sno'] = $data['sno'];
}

if(isset($_GET['del'])){
	$sql = 'delete from add_subject_faculty where sno="'.$_GET['del'].'"';
	execute_query(dbconnect(), $sql);
}
page_header_end();
page_sidebar();
?>
<script type="text/javascript" language="javascript" src="form_validator.js"></script>
<body id="public">
	<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">    	
				<form action="addnewsubject_faculty.php" class="wufoo leftLabel page1" name="addnewsubject" enctype="multipart/form-data" method="post" onSubmit="" >
				<h2><img style="width:40px;" src="images/add.png" />Add New <span class="orange">Faculty</span></h2>
				<?php echo $msg;?>
				<div class="col-md-12">
					<div class="row">							
						<div class="col-md-4">							
							<label>Faculty Name <span class="sub_name">*</span></label>
							<input type="text" name="faculty" id="faculty" class="form-control" value="<?php echo $_POST['faculty']; ?>"/>
						</div>
					</div>
					<input type="submit" class="btn btn-success submit" name="submit" value="Submit"/>
					<input type="hidden" name="edit_sno" value="<?php echo $_POST['edit_sno']; ?>">
				</div>
			</div>
		</div>
		<div class="card card-body">
			<table width="100%" class="table table-striped table-hover rounded">
				<tr class="table-success ">
					<th>S.No</th>
					<th>Faculty Name</th>
					<th>&nbsp;</th>
					<th>&nbsp;</th>
				</tr>
				<?php
				$i=1;
				$sql = "select * from add_subject_faculty";
				$result_sub = execute_query(connect(), $sql);
				while($row_sub = mysqli_fetch_array($result_sub)){
					echo '<tr>
					<td>'.$i++.'</td>
					<td>'.$row_sub['faculty'].'</td>
					<td><a href="addnewsubject_faculty.php?ed='.$row_sub['sno'].'">Edit</a></td>
					<td><a href="addnewsubject_faculty.php?del='.$row_sub['sno'].'" style="color:#f00" onClick="return confirm(\'Are you sure?\');">Delete</a></td>
					</tr>';		
				}
				?>
			</table>
		</div>
	</form>
</div>
<?php
page_footer_start();
page_footer_end();
?>