<?php
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_start();

page_header_end();
page_sidebar();
?>
<?php
if(isset($_POST['submit'])){
	if($_POST['sno'] != ''){
		$sql = 'UPDATE ex_class_exam SET class_id="'.$_POST['classdescription'].'", exam_id="'.$_POST['exam_id'].'" WHERE sno='.$_POST['sno'];
		mysqli_query($db, $sql);
		$msg .= '<li>Update successful.</li>';
	}
	else{
		$sql = 'INSERT INTO ex_class_exam (class_id, exam_id, created_by, creation_time) VALUES ("'.$_POST['classdescription'].'", "'.$_POST['exam_id'].'", "'.$_SESSION['username'].'", "'.date("Y-m-d").'")';
		mysqli_query($db, $sql);
		$msg = '<li>Class And Exam Added</li>'; 
	}
}

if(isset($_GET['id'])){
	$sql = 'SELECT * FROM ex_class_exam WHERE sno='.$_GET['id'];
	$row_details = mysqli_fetch_array(mysqli_query($db, $sql));
	$sql = 'SELECT * FROM ex_section WHERE sno='.$row_details['class_id'];
	$section = mysqli_fetch_array(mysqli_query($db, $sql));
	$sql2 = 'SELECT * FROM ex_exam_master WHERE sno='.$row_details['exam_id'];
	$row2 = mysqli_fetch_array(mysqli_query($db, $sql2));
}

if(isset($_GET['del'])){
	$sql = 'DELETE FROM ex_class_exam WHERE sno='.$_GET['del'];
	mysqli_query($db, $sql);
}
?>
<script type="text/javascript" language="javascript">

</script>
<body id="container">
	<div class="card">
		<div class="card-body ">
			<div class="row d-flex my-auto">  
            <?php //echo $msg; ?>			
				<form action="" class="wufoo leftLabel page1" name="addnewexam" enctype="multipart/form-data" method="POST" >
					<h3>Class and Exam </h3>
					<table width="100%" class="table table-striped table-hover rounded">
						<tr class="">
							<th>Class</th>
							<th><select class="select form-control" name="classdescription" id="classdescription">
								<option value=" "></option>
								<?php
									$sql = 'SELECT * FROM ex_section';
									$res = mysqli_query($db, $sql);
									while ($row = mysqli_fetch_array($res)) {
										$sql1 = 'SELECT * FROM ex_class WHERE sno="' . $row['class_desc'] . '"';
										$result = mysqli_fetch_array(mysqli_query($db, $sql1));
										echo '<option value="' . $row['sno'] . '"';
										if ($section['sno'] == $row['sno']) {
											echo 'selected="selected"';
										}
										echo '>' . $result['class_desc'] . ' ' . $row['section'] . '</option>';
									}
									echo '</select></div>';
								?>
							</th>
							<th>Exam</th>
							<th>
								<select name="exam_id" id="exam_id" class="select  form-control" onChange="hide_show('classdescription','1')">
								<option value="<?php if(isset($_GET['id'])){echo $row_details['exam_id'];}?>" selected="selected"><?php if(isset($_GET['id'])){echo $row2['exam_name'];}?></option>
								<?php
									$sql = 'SELECT * FROM ex_exam_master';
									$result = mysqli_query($db, $sql);
									
									while ($row = mysqli_fetch_array($result)) {
										echo '<option value="' . $row['sno'] . '">' . $row['exam_name'] . '</option>';
									}
								?>
								</select>
							</th>
							<th></th>
							<th></th>
						</tr>
					</table>
					<button type="submit" class="btn btn-primary" name="submit" value="submit" onClick="return confirmSubmit()">Submit</button>
					<input type="hidden" name="edit" value="<?php echo isset($_GET['edit'])? $res['sno']: '' ?>">
				</form>
			</div>
		</div>
	</div>
	<div class="card card-body ">
		<div class="row d-flex my-auto">
			<table width="100%" class="table table-striped table-hover rounded">
				<tr class="bg-primary text-white">
					<th>S.No.</th>
					<th>Class</th>
					<th>Exam Name</th>
					<th>Edit</th>
					<th>Delete</th>
				</tr>
				   <?php
					$sql = 'select * from ex_class_exam';
					$result = mysqli_query($db, $sql);
					$i = 1;

					while ($row = mysqli_fetch_array($result)) {
					  $sql = 'select * from ex_section where sno=' . $row['class_id'];
					  $class = mysqli_fetch_array(mysqli_query($db, $sql));

					  $sql = 'select class_desc from ex_class where sno=' . $class['class_desc'];
					  $row1 = mysqli_fetch_array(mysqli_query($db, $sql));

					  $sql1 = 'select * from ex_exam_master where sno=' . $row['exam_id'];
					  $row2 = mysqli_fetch_array(mysqli_query($db, $sql1));

					  if ($i % 2 == 0) {
						$col = '#CCC';
					  } else {
						$col = '#EEE';
					  }

					  echo '<tr style="background:' . $col . '">
						<td>' . $i++ . '</td>
						<td>' . $row1['class_desc'] . '&nbsp;' . $class['section'] . '</td>
						<td>' . $row2['exam_name'] . '</td>
						<td><a href="ex_class_exam.php?id=' . $row['sno'] . '">Edit</a></td>
						<td><a href="ex_class_exam.php?del=' . $row['sno'] . '" onclick="return confirm(\'Are you sure?\');" style="color:red;">Delete</a></td>
					  </tr>';
					}
					?>

			</table>
		</div>
	</div>
	<?php
	page_footer_start();
	page_footer_end();
	?>
</body>