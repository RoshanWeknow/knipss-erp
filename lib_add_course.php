<?php 
include("scripts/settings.php");

$msg='';

page_header_start();
page_header_end();
page_sidebar();
?>
<?php	
	if(isset($_POST['submit'])){
    if(isset($_POST['edit']) && $_POST['edit'] != ''){
        $sql = 'UPDATE lib_add_course set 
				institute_name="'.$_POST['institute_name'].'" ,
				library_name="'.$_POST['library_name'].'" , 
				department_name="'.$_POST['department_name'].'" ,  
				category="'.$_POST['category'].'" ,  
				c_name="'.$_POST['c_name'].'" ,  
				c_code="'.$_POST['c_code'].'" ,  
				duration="'.$_POST['duration'].'" ,  
				c_type="'.$_POST['c_type'].'" ,  
				edited_by="'.$_SESSION['username'].'",
				edited_date="'.date("d-m-y H:i:s").'"
				 where sno = '.$_POST['edit'];
			 //echo $sql;		 
				mysqli_query($db, $sql);
				if(mysqli_errno($db)){
					echo "Updation failed: ".mysqli_errno($db).mysqli_error($db);
				}
				else{
					echo "Successfully updated";
				}
			}
		else{
				$sql = 'INSERT INTO lib_add_course(institute_name, library_name, department_name, category, c_name, c_code, duration, c_type, created_by, created_date) 
					values("'.$_POST['institute_name'].'",
					"'.$_POST['library_name'].'",
					"'.$_POST['department_name'].'",
					"'.$_POST['category'].'",
					"'.$_POST['c_name'].'",
					"'.$_POST['c_code'].'",
					"'.$_POST['duration'].'",
					"'.$_POST['c_type'].'",
					"'.$_SESSION['username'].'",
					"'.date("d-m-y H:i:s").'")';
			//echo $sql;

				mysqli_query($db,$sql);
				if(mysqli_errno($db)){
					echo "Insertion failed: ".mysqli_errno($db).mysqli_error($db);
				}
				else{
					echo "Data inserted";
				}
			}
	}
	
	if(isset($_GET['del'])){
		$sql = 'delete from lib_add_course where sno="'.$_GET['del'].'"';
		mysqli_query($db, $sql);
		if(mysqli_error($db)){
			$msg .= '<h3 style="color:red;">Error in deleting . '.mysqli_error($db).' >> '.$sql.'</h3>';
		}
		else{
			$msg .= '<h3 style="color:red;">Deleted</h3>';
		}
	}
	

	if(isset($_GET['edit'])){
	$sql = 'select * from lib_add_course where sno = '.$_GET['edit'];
	$qry = mysqli_query($db, $sql);
	$res = mysqli_fetch_assoc($qry);
}
?>
<div id="container">
	<div class="card">
		<div class="card-body ">
			<div class="row d-flex my-auto">
				<form action="<?php echo $_SERVER['PHP_SELF']?>" class="wufoo leftLabel page1" name="feesdeposit"  enctype="multipart/form-data" method="post" onSubmit="" autocomplete="off">
				<div class="bg-primary text-white p-2"><h3>Add Course</h3></div>
					<table width="100%" class="table table-striped table-hover rounded">
						<tr class="">
							<th>Institute Name</th>
							<th><select class="form-control" name="institute_name" id="institute_name" class="form-control">
									<option value="">----Select----</option>
									<option value="KNIPSS(CENTRAL LIBRARY)">KNIPSS(CENTRAL LIBRARY)</option>
								</select></th>
							<th>Library Name</th>
							<th><input type="text" name="library_name" id="library_name" value="<?php echo isset($_GET['edit'])? $res['library_name']: '' ?>" class="form-control" required="required"></th>
							<th>Department Name</th>
							<th><input type="text" name="department_name" id="department_name" value="<?php echo isset($_GET['edit'])? $res['department_name']: '' ?>" class="form-control" required="required"></th>
							
						</tr>
						<tr>
							<th>Category</th>
							<th><select class="form-control" name="category" id="category" class="form-control">
									<option value="">----Select----</option>
									<option value="1">1</option>
									<option value="2">2</option>
								</select></th>
							<th>Course Name</th>
							<th><input type="text" name="c_name" id="c_name" value="<?php echo isset($_GET['edit'])? $res['c_name']: '' ?>" class="form-control" required="required"></th>
							<th>Course Code</th>
							<th><input type="text" name="c_code" id="c_code" value="<?php echo isset($_GET['edit'])? $res['c_code']: '' ?>" class="form-control" required="required"></th>
						</tr>
						<tr>
							<th>Duration in year</th>
							<th><input type="text" name="duration" id="duration" value="<?php echo isset($_GET['edit'])? $res['duration']: '' ?>" class="form-control" required="required"></th>
							
							<th>Course Type</th>
							<th><select class="form-control" name="c_type" id="c_type" class="form-control">
									<option value="">----Select----</option>
									<option value="1">1</option>
									<option value="2">2</option>
								</select></th>
							<th></th>
							<th></th>
						</tr>
					</table>
					<button type="submit" class="btn btn-primary " name="submit" value="">Submit </button>
					<button type="submit" class="btn btn-success " name="save" value="reset">Reset </button>
					<input type="hidden" name="edit" value="<?php echo isset($_GET['edit'])? $res['sno']: '' ?>">
				</form>
			</div>
		</div>
	</div>
</div>
<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">  
			<div ><h3>Records</h3></div>
				<div class="col-md-12" >
					<table width="80%" class="table table-striped  table-hover rounded">
						<tr class="bg-primary text-white">
							<th>Sno</th>
							<th>Institute Name</th>
							<th>Library Name</th>
							<th>Department Name</th>
							<th>Category</th>
							<th>Course Name</th>
							<th>Course Code</th>
							<th>Duration in year</th>
							<th>Course Type</th>
							<th>Edit </th>
							<th>Delete</th>
						</tr>
							<?php
								$sql = 'select * from lib_add_course';
								$result = mysqli_query($db, $sql);
								$i=1;
								while($row = mysqli_fetch_assoc($result)){
									echo '<tr>
									<td>'.$i++.'</td>
									<td>'.$row['institute_name'].'</td>
									<td>'.$row['library_name'].'</td>
									<td>'.$row['department_name'].'</td>
									<td>'.$row['category'].'</td>
									<td>'.$row['c_name'].'</td>
									<td>'.$row['c_code'].'</td>
									<td>'.$row['duration'].'</td>
									<td>'.$row['c_type'].'</td>
									<td><a href="lib_add_course.php?edit='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color: #3066ec;"> Edit</h3></a></td>
									<td><a href="lib_add_course.php?del='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color:red;"></h3>Delete</a></td>
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