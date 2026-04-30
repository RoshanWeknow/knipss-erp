<?php
//session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
page_header_start();

logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);

$msg='';
// if(isset($_POST['submit'])){
		// $sql = 'insert into d_total_column(col_name, class , position)
		     // value("'.$_POST['column_name'].'","'.$_POST['classdescription'].'" , "'.$_POST['position'].'")';
		// mysql_query($sql,dbconnect());
		// $id=mysql_insert_id();
		// $sql='select * from exam_master';
		// $row_exam=mysql_query($sql,dbconnect());
		// while($row_head=mysql_fetch_array($row_exam)){
			// $sql_insert='insert into d_total_column_exam(col_id,exam_id) values(';
			// if($_POST['exam_'.$row_head['sno']]!=''){
				// $sql_insert.='"'.$id.'","'.$_POST['exam_'.$row_head['sno']].'")';
				// mysql_query($sql_insert,dbconnect());
			// }
		// }
		
		// $msg = '<li>Details Added</li>'; 
// }
// if(isset($_GET['id'])){
	// $sql='select * from d_total_column where sno='.$_GET['id'];
	// $result_edit=mysql_fetch_array(mysql_query($sql,dbconnect()));
// }
// if(isset($_GET['del'])){
	// $sql = 'delete from d_total_column_exam where col_id='.$_GET['del'];
	// mysql_query($sql,dbconnect());
	// $sql = 'delete from d_total_column where sno='.$_GET['del'];
	// mysql_query($sql,dbconnect());
	
// }
?>
<?php
if (isset($_POST['submit'])) {
    $column_name = $_POST['column_name'];
    $classdescription = $_POST['classdescription'];
    $position = $_POST['position'];

    $sql = "INSERT INTO ex_total_column (col_name, class, position) VALUES ('$column_name', '$classdescription', '$position')";
    mysqli_query($db, $sql);
    $id = mysqli_insert_id($db);

    $sql_exam = "SELECT * FROM ex_exam_master";
    $result_exam = mysqli_query($db, $sql_exam);
    while ($row_head = mysqli_fetch_array($result_exam)) {
        $exam_sno = $row_head['sno'];
        if (isset($_POST['exam_' . $exam_sno]) && $_POST['exam_' . $exam_sno] !== '') {
            $exam_id = $_POST['exam_' . $exam_sno];
            $sql_insert = "INSERT INTO ex_total_column_exam (col_id, exam_id) VALUES ('$id', '$exam_id')";
            mysqli_query($db, $sql_insert);
        }
    }

    $msg = '<li>Details Added</li>';
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM ex_total_column WHERE sno = '$id'";
    $result_edit = mysqli_fetch_array(mysqli_query($db, $sql));
}

if (isset($_GET['del'])) {
    $del_id = $_GET['del'];
    $sql_del_exam = "DELETE FROM ex_total_column_exam WHERE col_id = '$del_id'";
    mysqli_query($db, $sql_del_exam);
    $sql_del_column = "DELETE FROM ex_total_column WHERE sno = '$del_id'";
    mysqli_query($db, $sql_del_column);
}

page_header_end();
page_sidebar();
?>
<body id="container">
	<div class="card">
		<div class="card-body ">
			<div class="row d-flex my-auto">    	
				<form action="ex_add_total.php" class="wufoo leftLabel page1" name="addnewexam" enctype="multipart/form-data" method="post" onSubmit="" >
				<h3>Add Total Column</h3>
				<?php
				if(isset($_POST['submit']) && $msg!='') {
					echo $msg;
					$msg='';
				}
				?>
					<table width="100%" class="table table-striped table-hover rounded">
						<tr class="">
							<th width="15%">Column Name</th>
							<th width="20%"><input type="text" name="column_name" id="column_name" class="form-control" value="<?php if(isset($_GET['id'])){ echo $result_edit['col_name'];}?>" /></th>
							<th>Class</th>
							<th><select class="select form-control" name="classdescription" id="classdescription">
									<option value=" "></option>
									<?php echo 
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
										echo '</select>';
									?>
							</th>
							<th>Select Exams</th>
							<th>
							<?php
								$sql = 'SELECT * FROM ex_exam_master';
								$result = mysqli_query($db, $sql);
								while ($row = mysqli_fetch_array($result)) {
									echo '<input type="checkbox" value="' . $row['sno'] . '" name="exam_' . $row['sno'] . '">&nbsp;&nbsp;' . $row['exam_name'] . '<br>';
								}
							?>
							</th>
						</tr>
						<tr>
							<th>Select Position After</th>
							<th><select name="position" id="position" class="select form-control" onChange="hide_show('classdescription','1')">
									<option value="<?php if(isset($_GET['id'])){echo $row_details['position'];}?>" selected="selected"><?php if(isset($_GET['id'])){echo $row1['position'];}?></option>
									<?php 
									    $sql = 'SELECT * FROM ex_exam_master';
										$result = mysqli_query($db, $sql);

										while ($row = mysqli_fetch_array($result)) {
											echo '<option value="' . $row['sno'] . '" name="position"';
											if (isset($_GET['id'])) {
												// Assuming $result_edit is defined and contains the appropriate data
												if ($result_edit['position'] == $row['sno']) {
													echo 'selected="selected"';
												}
											}
											echo '>' . $row['exam_name'] . '</option>';
										}
									?>
								</select></th>
						</tr>
					</table>
					<input type="hidden" name="sno" value="<?php if(isset($_GET['id'])){echo $_GET['id'];}?>" />
					<input type="submit"  class="btn btn-primary submit" name="submit" value="Submit" onClick="return confirmSubmit()"/>
				</form>
			</div>
		</div>
	</div>    
	<div class="card card-body ">
		<div class="row d-flex my-auto">

			<table width="100%" class="table table-striped table-hover rounded">
				<tr class="bg-primary text-white">
					<th>S.No.</th>
					<th>Column Name</th>
                    <th>Class</th>
                    <th >Exams Included</th>
                    <th>Position After</th>
					<th>Delete</th>
				</tr>
				<?php
					$sql = 'select * from ex_total_column';
					$result = mysqli_query($db, $sql);
					$i = 1;
					while ($row = mysqli_fetch_array($result)) {
						$sql = 'select * from ex_section where sno=' . $row['class'];
						$class = mysqli_fetch_array(mysqli_query($db, $sql));
						$sql = 'select * from ex_class where sno=' . $class['class_desc'];
						$class_name = mysqli_fetch_array(mysqli_query($db, $sql));
						$sql = 'select * from ex_exam_master where sno=' . $row['position'];
						$position = mysqli_fetch_array(mysqli_query($db, $sql));
						if ($i % 2 == 0) {
							$col = '#CCC';
						} else {
							$col = '#EEE';
						}
						echo '<tr style="background:' . $col . '">
								<td>' . $i++ . '</td>
								<td>' . $row['col_name'] . '</td>
								<td>' . $class_name['class_desc'] . '&nbsp;' . $class['section'] . '</td>
								<td>';
						$sql_exam = 'select * from ex_total_column_exam where col_id=' . $row['sno'];
						$exam_master = mysqli_query($db, $sql_exam);
						while ($exam = mysqli_fetch_array($exam_master)) {
							$sql = 'select * from ex_exam_master where sno=' . $exam['exam_id'];
							$exam_name = mysqli_fetch_array(mysqli_query($db, $sql));
							echo $exam_name['exam_name'] . ',';
						}
						echo '</td><td>' . $position['exam_name'] . '</td>
								<td><a href="ex_add_total.php?del=' . $row['sno'] . '" onclick="return confirm(\'Are you sure?\');">Delete</a></td>
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