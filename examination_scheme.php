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
			$sql = 'update examination_scheme set 
					course_name="'.$_POST['course_name'].'",
					exam_date="'.$_POST['exam_date'].'", 
					exam_time="'.$_POST['exam_time'].'", 
					exam_venue="'.$_POST['exam_venue'].'", 
					exam_instructions="'.$_POST['exam_instructions'].'", 
					brochure="'.$_POST['brochure'].'" 
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
			$sql = 'insert into examination_scheme (course_name, exam_date, exam_time, exam_venue, exam_instructions, files, created_by, created_date, edited_by, edited_date) 
				values("'.$_POST['course_name'].'",
					"'.$_POST['exam_date'].'",
					"'.$_POST['exam_time'].'",
					"'.$_POST['exam_venue'].'",
					"'.$_POST['exam_instructions'].'",
					"'.$filename.'",
					"'.$_POST['created_by'].'",
					"'.$_POST['created_date'].'",
					"'.$_POST['edited_by'].'",
					"'.$_POST['edited_date'].'")';
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
		$sql = 'delete from examination_scheme where sno="'.$_GET['del'].'"';
		mysqli_query($db, $sql);
		if(mysqli_error($db)){
			$msg .= '<h3 style="color:red;">Error in deleting . '.mysqli_error($db).' >> '.$sql.'</h3>';
		}
		else{
			$msg .= '<h3 style="color:red;">Deleted</h3>';
		}
	}
	

	if(isset($_GET['edit'])){
	$sql = 'select * from examination_scheme where sno = '.$_GET['edit'];
	$qry = mysqli_query($db, $sql);
	$res = mysqli_fetch_assoc($qry);
}
?>
<html>
<head>
	<style>
	.form div.row:nth-child(odd) {
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
</head>
<body id="public">
	<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">  
				<form action="" class="wufoo leftLabel page1" name="" enctype="multipart/form-data" method="POST" onSubmit="" >
					<div class="bg-primary text-white p-2"><h3>Examination Scheme</h3></div>
					<div class="col-md-12" >
						<div class="row" style="background: #eeeeee;">							
							<div class=" col-md-3  ms-4" >							
								<label for="course">Course Name</label>
								<input type="text" id="course_name" name="course_name" value="<?php echo isset($_GET['edit'])? $res['course_name']: '' ?>" class="form-control">
							</div>							
							<div class=" col-md-3  ms-4">							
								<label for="date">Exam Date</label>
								<script type="text/javascript" language="javascript">
									<?php
										$date = isset($_GET['edit'])? $res['exam_date']: date('Y-m-d');
										echo "document.writeln(DateInput('exam_date', 'exam_date', true, 'YYYY-MM-DD','$date', 1));"
									?>
								</script>
							</div>							
							<div class=" col-md-3  ms-4">							
								<label for="time">Exam Time</label>
								<input type="time" id="exam_time" name="exam_time" value="<?php echo isset($_GET['edit'])? $res['exam_time']: '' ?>" class="form-control">
							</div>
						</div>
						<div class="row">
							<div class=" col-md-3  ms-4">							
								<label for="venue">Exam Venue</label>
								<input type="text" id="exam_venue" name="exam_venue" value="<?php echo isset($_GET['edit'])? $res['exam_venue']: '' ?>" class="form-control">
							</div>
							<div class=" col-md-3  ms-4">							
								<label for="instructions">Exam Instructions</label>
								<textarea id="exam_instructions" name="exam_instructions" rows="5" value="" class="form-control"><?php echo isset($_GET['edit'])? $res['exam_instructions']: '' ?></textarea>
							</div>	
							<div class=" col-md-3  ms-4">	
								<label for="brochure">Brochure</label><br>
								<input type="file" id="attach_file" name="attach_file" value="<?php echo isset($_GET['edit'])? $res['brochure']: '' ?>" class="form-control">
							</div>
						</div>
					</div>
					<button type="submit" class="btn btn-primary ms-5 mt-" name="submit" value="">Submit </button>
					<input type="hidden" name="edit" value="<?php echo isset($_GET['edit'])? $res['sno']: '' ?>">
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
						<tr class="bg-primary text-white">
							<th>Sno</th>
							<th>Course Name</th>
							<th>Exam Date</th>
							<th>Exam Time</th>
							<th>Exam Venue</th>
							<th>Exam Instructions </th>
							<th>Brochure</th>
							<th>Edit </th>
							<th>Delete </th>
						</tr>
							<?php
								$sql = 'select * from examination_scheme';
								$result = mysqli_query($db, $sql);
								$i=1;
								while($row = mysqli_fetch_assoc($result)){
									echo '<tr>
									<td>'.$i++.'</td>
									<td>'.$row['course_name'].'</td>
									<td>'.$row['exam_date'].'</td>
									<td>'.$row['exam_time'].'</td>
									<td>'.$row['exam_venue'].'</td>
									<td>'.$row['exam_instructions'].'</td>
									<td>'.$row['files'].'</td>
									<td><a href="examination_scheme.php?edit='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color: #3066ec;"> Edit</h3></a></td>
									<td><a href="examination_scheme.php?del='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color:red;"></h3>Delete</a></td>
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